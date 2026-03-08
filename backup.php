<?php
/**
 * Sistema de Backup Criptografado
 * Execute via cron: php /path/to/backup.php
 * 
 * Configurações no .env:
 * BACKUP_ENABLED=true
 * BACKUP_ENCRYPTION_KEY=sua_chave_aqui_32_caracteres
 * BACKUP_RETENTION_DAYS=30
 * BACKUP_PATH=/backups
 */

require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/security.php';

class EncryptedBackup {
    private $backupPath;
    private $encryptionKey;
    private $retentionDays;
    
    public function __construct() {
        $this->backupPath = $_ENV['BACKUP_PATH'] ?? __DIR__ . '/../backups';
        $this->encryptionKey = $_ENV['BACKUP_ENCRYPTION_KEY'] ?? null;
        $this->retentionDays = (int)($_ENV['BACKUP_RETENTION_DAYS'] ?? 30);
        
        if (empty($this->encryptionKey) || strlen($this->encryptionKey) < 32) {
            die("ERRO: BACKUP_ENCRYPTION_KEY deve ter pelo menos 32 caracteres no .env\n");
        }
        
        if (!is_dir($this->backupPath)) {
            mkdir($this->backupPath, 0755, true);
        }
    }
    
    public function run() {
        echo "Iniciando backup criptografado...\n";
        
        $timestamp = date('Y-m-d_His');
        $filename = "backup_{$timestamp}";
        $sqlFile = "{$this->backupPath}/{$filename}.sql";
        $encryptedFile = "{$this->backupPath}/{$filename}.enc";
        
        // Gerar backup SQL
        if ($this->generateSQLBackup($sqlFile)) {
            echo "Backup SQL gerado: {$sqlFile}\n";
            
            // Criptografar arquivo
            if ($this->encryptFile($sqlFile, $encryptedFile)) {
                echo "Arquivo criptografado: {$encryptedFile}\n";
                
                // Remover arquivo SQL original (manter apenas criptografado)
                unlink($sqlFile);
                echo "Arquivo SQL temporário removido.\n";
                
                // Limpar backups antigos
                $this->cleanupOldBackups();
                
                echo "Backup concluído com sucesso!\n";
                return true;
            }
        }
        
        echo "ERRO: Falha no processo de backup\n";
        return false;
    }
    
    private function generateSQLBackup($filename) {
        $host = $_ENV['DB_HOST'] ?? '127.0.0.1';
        $db = $_ENV['DB_NAME'] ?? 'theological_courses';
        $user = $_ENV['DB_USER'] ?? 'root';
        $pass = $_ENV['DB_PASS'] ?? '';
        
        $command = sprintf(
            'mysqldump --host=%s --user=%s --password=%s --single-transaction --routines --triggers %s > %s',
            escapeshellarg($host),
            escapeshellarg($user),
            escapeshellarg($pass),
            escapeshellarg($db),
            escapeshellarg($filename)
        );
        
        exec($command, $output, $return);
        
        return $return === 0 && file_exists($filename);
    }
    
    private function encryptFile($source, $destination) {
        $iv = openssl_random_pseudo_bytes(16);
        $encrypted = openssl_encrypt(
            file_get_contents($source),
            'aes-256-cbc',
            $this->encryptionKey,
            OPENSSL_RAW_DATA,
            $iv
        );
        
        if ($encrypted === false) {
            return false;
        }
        
        // Salvar IV + dados criptografados
        $result = file_put_contents($destination, $iv . $encrypted);
        
        return $result !== false;
    }
    
    private function cleanupOldBackups() {
        $files = glob("{$this->backupPath}/*.enc");
        $cutoff = time() - ($this->retentionDays * 86400);
        
        foreach ($files as $file) {
            if (filemtime($file) < $cutoff) {
                unlink($file);
                echo "Backup antigo removido: " . basename($file) . "\n";
            }
        }
    }
}

// Executar se chamado diretamente
if (php_sapi_name() === 'cli' && isset($argv[0]) && realpath($argv[0]) === __FILE__) {
    $backup = new EncryptedBackup();
    $backup->run();
}

if ($_ENV['BACKUP_ENABLED'] ?? false) {
    $backup = new EncryptedBackup();
    $backup->run();
}

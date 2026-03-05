<?php
// admin/configuracoes.php
require_once __DIR__ . '/includes/admin_header.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validate_csrf_token($_POST['csrf_token'] ?? '')) {
        $error = "Token CSRF inválido.";
    }
    else {
        $asaas_key = filter_input(INPUT_POST, 'asaas_api_key', FILTER_SANITIZE_STRING);
        $whatsapp = filter_input(INPUT_POST, 'whatsapp_number', FILTER_SANITIZE_STRING);

        $stmt = $pdo->prepare("UPDATE settings SET asaas_api_key = ?, whatsapp_number = ? WHERE id = 1");
        if ($stmt->execute([$asaas_key, $whatsapp])) {
            $success = "Configurações atualizadas com sucesso.";
        }
        else {
            $error = "Erro ao atualizar configurações.";
        }
    }
}

// Fetch current settings
$stmt = $pdo->query("SELECT * FROM settings WHERE id = 1");
$settings = $stmt->fetch();
?>

<div class="mb-8 flex justify-between items-center">
    <div>
        <h2 class="text-3xl font-bold tracking-tighter">Integrações & Configuração</h2>
        <p class="text-gray-400 font-mono text-sm mt-1">Gerencie a chave da API Asaas e o WhatsApp de destino.</p>
    </div>
</div>

<?php if ($error): ?>
    <div class="bg-red-900/50 border border-red-500 text-red-200 px-4 py-3 rounded-lg mb-6 max-w-2xl font-mono text-sm">
        <?php echo $error; ?>
    </div>
<?php
endif; ?>

<?php if ($success): ?>
    <div class="bg-green-900/50 border border-green-500 text-green-200 px-4 py-3 rounded-lg mb-6 max-w-2xl font-mono text-sm">
        <?php echo $success; ?>
    </div>
<?php
endif; ?>

<div class="bg-[#0a0a0c] border border-white/10 p-8 rounded-3xl max-w-2xl">
    <form method="POST" action="">
        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
        
        <div class="mb-6">
            <label class="block text-xs font-mono text-gray-400 mb-2 uppercase tracking-wide">Asaas API Key (Token)</label>
            <input type="password" name="asaas_api_key" value="<?php echo sanitize_output($settings['asaas_api_key'] ?? ''); ?>" placeholder="$aact_..." class="w-full bg-black border border-white/10 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-[#00ffcc] transition-colors font-mono text-sm">
            <p class="mt-2 text-xs text-gray-500 font-mono">Usado para gerar cobranças Pix via API oficial.</p>
        </div>
        
        <div class="mb-8">
            <label class="block text-xs font-mono text-gray-400 mb-2 uppercase tracking-wide">WhatsApp Redirecionamento</label>
            <input type="text" name="whatsapp_number" value="<?php echo sanitize_output($settings['whatsapp_number'] ?? ''); ?>" placeholder="5511999999999" class="w-full bg-black border border-white/10 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-[#00ffcc] transition-colors font-mono text-sm">
            <p class="mt-2 text-xs text-gray-500 font-mono">Apenas números (Código país + DDD + Número). Ex: 5511999999999.</p>
        </div>

        <button type="submit" class="py-3 px-6 bg-[#00ffcc] text-black font-bold rounded-xl hover:bg-white transition-colors flex items-center gap-2">
            Salvar Configurações
        </button>
    </form>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>

<?php
// admin/alterar_senha.php
require_once __DIR__ . '/includes/admin_header.php';

$success = '';
$error = '';

// Handle Password Change
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validate_csrf_token($_POST['csrf_token'] ?? '')) {
        $error = "Token de segurança inválido. Tente novamente.";
    }
    else {
        $current_password = $_POST['current_password'] ?? '';
        $new_password = $_POST['new_password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        
        // Get current user data
        $stmt = $pdo->prepare("SELECT email, password_hash FROM admin_users WHERE id = ?");
        $stmt->execute([$_SESSION['admin_id']]);
        $admin = $stmt->fetch();
        
        if (!$admin) {
            $error = "Usuário não encontrado.";
        }
        elseif (!password_verify($current_password, $admin['password_hash'])) {
            $error = "Senha atual incorreta.";
        }
        elseif (strlen($new_password) < 6) {
            $error = "A nova senha deve ter pelo menos 6 caracteres.";
        }
        elseif ($new_password !== $confirm_password) {
            $error = "A confirmação de senha não coincide.";
        }
        else {
            // Update password
            $new_hash = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE admin_users SET password_hash = ? WHERE id = ?");
            $result = $stmt->execute([$new_hash, $_SESSION['admin_id']]);
            
            if ($result) {
                $success = "Senha alterada com sucesso!";
            }
            else {
                $error = "Erro ao alterar senha. Tente novamente.";
            }
        }
    }
}
?>

<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <h2 class="text-3xl font-bold tracking-tighter">🔐 Alterar Senha</h2>
        <p class="text-gray-400 font-mono text-sm mt-1">Altere sua senha de acesso ao painel administrativo.</p>
    </div>

    <?php if ($error): ?>
        <div class="bg-red-900/50 border border-red-500 text-red-200 px-4 py-3 rounded-lg mb-6 font-mono text-sm">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="bg-green-900/50 border border-green-500 text-green-200 px-4 py-3 rounded-lg mb-6 font-mono text-sm">
            <?php echo $success; ?>
        </div>
    <?php endif; ?>

    <div class="bg-[#0a0a0c] border border-white/10 p-8 rounded-2xl">
        <form method="POST" action="" class="space-y-6">
            <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
            
            <div>
                <label class="block text-xs font-mono text-gray-400 mb-2 uppercase tracking-widest">Senha Atual</label>
                <input type="password" name="current_password" required 
                       class="w-full bg-black border border-white/10 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-[#00ffcc] transition-colors">
            </div>
            
            <div>
                <label class="block text-xs font-mono text-gray-400 mb-2 uppercase tracking-widest">Nova Senha</label>
                <input type="password" name="new_password" required 
                       class="w-full bg-black border border-white/10 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-[#00ffcc] transition-colors">
                <p class="text-gray-500 text-xs mt-2">Mínimo 6 caracteres</p>
            </div>
            
            <div>
                <label class="block text-xs font-mono text-gray-400 mb-2 uppercase tracking-widest">Confirmar Nova Senha</label>
                <input type="password" name="confirm_password" required 
                       class="w-full bg-black border border-white/10 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-[#00ffcc] transition-colors">
            </div>

            <div class="flex gap-4">
                <button type="submit" class="px-6 py-3 bg-[#00ffcc] text-black font-bold rounded-lg hover:bg-white transition-colors">
                    Alterar Senha
                </button>
                <a href="index.php" class="px-6 py-3 border border-white/20 text-gray-400 rounded-lg hover:text-white transition-colors">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>

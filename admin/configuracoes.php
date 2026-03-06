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
        $fb = filter_input(INPUT_POST, 'social_facebook', FILTER_SANITIZE_URL);
        $ig = filter_input(INPUT_POST, 'social_instagram', FILTER_SANITIZE_URL);
        $tw = filter_input(INPUT_POST, 'social_twitter', FILTER_SANITIZE_URL);
        $th = filter_input(INPUT_POST, 'social_threads', FILTER_SANITIZE_URL);
        $li = filter_input(INPUT_POST, 'social_linkedin', FILTER_SANITIZE_URL);
        $tt = filter_input(INPUT_POST, 'social_tiktok', FILTER_SANITIZE_URL);

        $stmt = $pdo->prepare("UPDATE settings SET asaas_api_key = ?, whatsapp_number = ?, social_facebook = ?, social_instagram = ?, social_twitter = ?, social_threads = ?, social_linkedin = ?, social_tiktok = ? WHERE id = 1");
        if ($stmt->execute([$asaas_key, $whatsapp, $fb, $ig, $tw, $th, $li, $tt])) {
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
        
        <div class="mb-6 border-t border-white/5 pt-6">
            <h3 class="text-white font-bold mb-4 font-mono text-sm tracking-widest uppercase">Redes Sociais</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-mono text-gray-400 mb-2 uppercase">Facebook</label>
                    <input type="url" name="social_facebook" value="<?php echo sanitize_output($settings['social_facebook'] ?? ''); ?>" placeholder="https://..." class="w-full bg-black border border-white/10 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-[#00ffcc] text-sm">
                </div>
                <div>
                    <label class="block text-[10px] font-mono text-gray-400 mb-2 uppercase">Instagram</label>
                    <input type="url" name="social_instagram" value="<?php echo sanitize_output($settings['social_instagram'] ?? ''); ?>" placeholder="https://..." class="w-full bg-black border border-white/10 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-[#00ffcc] text-sm">
                </div>
                <div>
                    <label class="block text-[10px] font-mono text-gray-400 mb-2 uppercase">X (Twitter)</label>
                    <input type="url" name="social_twitter" value="<?php echo sanitize_output($settings['social_twitter'] ?? ''); ?>" placeholder="https://..." class="w-full bg-black border border-white/10 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-[#00ffcc] text-sm">
                </div>
                <div>
                    <label class="block text-[10px] font-mono text-gray-400 mb-2 uppercase">Threads</label>
                    <input type="url" name="social_threads" value="<?php echo sanitize_output($settings['social_threads'] ?? ''); ?>" placeholder="https://..." class="w-full bg-black border border-white/10 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-[#00ffcc] text-sm">
                </div>
                <div>
                    <label class="block text-[10px] font-mono text-gray-400 mb-2 uppercase">LinkedIn</label>
                    <input type="url" name="social_linkedin" value="<?php echo sanitize_output($settings['social_linkedin'] ?? ''); ?>" placeholder="https://..." class="w-full bg-black border border-white/10 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-[#00ffcc] text-sm">
                </div>
                <div>
                    <label class="block text-[10px] font-mono text-gray-400 mb-2 uppercase">TikTok</label>
                    <input type="url" name="social_tiktok" value="<?php echo sanitize_output($settings['social_tiktok'] ?? ''); ?>" placeholder="https://..." class="w-full bg-black border border-white/10 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-[#00ffcc] text-sm">
                </div>
            </div>
        </div>

        <button type="submit" class="py-3 px-6 bg-[#00ffcc] text-black font-bold rounded-xl hover:bg-white transition-colors flex items-center gap-2">
            Salvar Configurações
        </button>
    </form>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>

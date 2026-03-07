<?php
// checkout.php
require_once __DIR__ . '/includes/security.php';
require_once __DIR__ . '/includes/db.php';

$curso_id = filter_input(INPUT_GET, 'curso', FILTER_VALIDATE_INT);

// Require Login before generating any HTML output
if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php?redirect=' . urlencode('/checkout.php?curso=' . $curso_id));
    exit;
}

require_once __DIR__ . '/includes/asaas.php';

$error = '';
$success_url = '';

if (!$curso_id) {
    die("<div class='text-center py-32 text-white font-mono'>[ ERRO FATAL: NENHUM CURSO SELECIONADO ]</div>");
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'] ?? '';
$user_email = $_SESSION['user_email'] ?? '';

// Fetch Course
$stmt = $pdo->prepare("SELECT * FROM courses WHERE id = ? AND status = 'active'");
$stmt->execute([$curso_id]);
$course = $stmt->fetch();

if (!$course) {
    die("<div class='text-center py-32 text-white font-mono'>[ ERRO FATAL: CURSO NÃO ENCONTRADO ]</div>");
}

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validate_csrf_token($_POST['csrf_token'] ?? '')) {
        $error = "Token de segurança inválido. Tente novamente.";
    }
    else {
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $cpf = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_STRING);
        $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);

        // 1. Fetch Admin WhatsApp Number
        $stmt = $pdo->query("SELECT whatsapp_number FROM settings WHERE id = 1");
        $settings = $stmt->fetch();
        $admin_phone = preg_replace('/[^0-9]/', '', $settings['whatsapp_number'] ?? '5511999999999');

        // 2. Prepare WhatsApp Message
        $message = "Olá! Gostaria de comprar o curso: *" . $course['title'] . "*.\n\n";
        $message .= "*Dados do Cliente:*\n";
        $message .= "Nome: " . $name . "\n";
        $message .= "E-mail: " . $email . "\n";
        $message .= "WhatsApp: " . $phone . "\n\n";
        if (!empty($cpf)) {
            $message .= "CPF: " . $cpf . "\n";
        }
        $message .= "Por favor, me envie os dados para pagamento via PIX.";

        $whatsapp_url = "https://api.whatsapp.com/send?phone=" . $admin_phone . "&text=" . urlencode($message);

        // 3. Save Order (Pending) for tracking
        $stmt = $pdo->prepare("INSERT INTO orders (course_id, user_id, customer_name, customer_email, customer_cpf, status, payment_url) VALUES (?, ?, ?, ?, ?, 'PENDING_MANUAL', ?)");
        $stmt->execute([$curso_id, $user_id, $name, $email, $cpf, $whatsapp_url]);

        // 4. Redirect directly to WhatsApp
        header("Location: " . $whatsapp_url);
        exit;
    }
}
?>

<?php require_once __DIR__ . '/includes/header.php'; ?>

<section class="min-h-[90dvh] pt-32 pb-20 flex items-center justify-center px-6 relative z-10">
    <div class="max-w-4xl w-full grid grid-cols-1 lg:grid-cols-2 gap-12 bg-deep-surface/50 backdrop-blur-xl border border-deep-border/50 rounded-3xl p-8 md:p-12 shadow-2xl gsap-reveal">
        
        <!-- Course Summary -->
        <div>
            <span class="font-mono text-xs text-neon-accent tracking-widest uppercase mb-4 block">Resumo do Pedido</span>
            <h1 class="text-3xl font-bold mb-4"><?php echo sanitize_output($course['title']); ?></h1>
            <p class="text-gray-400 text-sm mb-8"><?php echo sanitize_output($course['description']); ?></p>
            
            <div class="border-t border-deep-border/50 pt-8 mt-8">
                <div class="flex justify-between items-center mb-4 text-sm text-gray-400">
                    <span>Taxa de Matrícula</span>
                    <span>Isento</span>
                </div>
                <div class="flex justify-between items-center text-xl font-bold text-white">
                    <span>Total a Pagar</span>
                    <span>R$ <?php echo number_format($course['price'], 2, ',', '.'); ?></span>
                </div>
            </div>
            
            <div class="mt-8 flex items-center gap-3 text-xs font-mono text-gray-500">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" class="text-neon-accent"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                CHECKOUT SEGURO VIA ASAAS
            </div>
        </div>

        <!-- Checkout Form -->
        <div class="bg-black/40 rounded-2xl p-6 border border-white/5">
            <h2 class="text-xl font-bold mb-6 font-mono text-gray-200">Dados do Estudante</h2>
            
            <?php if ($error): ?>
                <div class="bg-red-900/50 border border-red-500 text-red-200 px-4 py-3 rounded-lg mb-6 text-sm">
                    <?php echo $error; ?>
                </div>
            <?php
endif; ?>

            <form method="POST" action="" class="space-y-5">
                <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                
                <div>
                    <label class="block text-xs font-mono text-gray-400 mb-2 uppercase tracking-wide">Nome Completo</label>
                    <input type="text" name="name" required class="w-full bg-deep-surface border border-deep-border/50 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-neon-accent transition-colors" value="<?php echo sanitize_output($user_name); ?>" readonly>
                </div>
                
                <div>
                    <label class="block text-xs font-mono text-gray-400 mb-2 uppercase tracking-wide">E-mail</label>
                    <input type="email" name="email" required class="w-full bg-deep-surface border border-deep-border/50 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-neon-accent transition-colors text-gray-400" value="<?php echo sanitize_output($user_email); ?>" readonly>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-mono text-gray-400 mb-2 uppercase tracking-wide">CPF (Opcional)</label>
                        <input type="text" name="cpf" class="w-full bg-deep-surface border border-deep-border/50 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-neon-accent transition-colors" placeholder="Somente números (opcional)">
                    </div>
                    <div>
                        <label class="block text-xs font-mono text-gray-400 mb-2 uppercase tracking-wide">WhatsApp</label>
                        <input type="text" name="phone" required class="w-full bg-deep-surface border border-deep-border/50 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-neon-accent transition-colors">
                    </div>
                </div>

                <button type="submit" class="w-full mt-6 py-4 bg-neon-accent text-black font-bold rounded-xl hover:bg-white transition-colors flex justify-center items-center gap-2">
                    Gerar Pagamento PIX
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M5 12h14M12 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
            </form>
        </div>

    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

<?php
// login.php
require_once __DIR__ . '/includes/security.php';
require_once __DIR__ . '/includes/db.php';

// Initialize login attempts
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}

// If already logged in, redirect to portal
if (isset($_SESSION['user_id'])) {
    header('Location: /portal/index.php');
    exit;
}

$error = '';
$redirect_to = isset($_GET['redirect']) ? filter_var($_GET['redirect'], FILTER_SANITIZE_URL) : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validate_csrf_token($_POST['csrf_token'] ?? '')) {
        $error = "Sessão expirada. Tente novamente.";
    }
    else {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'] ?? '';
        $redirect_to_post = $_POST['redirect'] ?? '';

        if (!$email || !$password) {
            $error = "Preencha todos os campos.";
        }
        else {
            // Check Captcha if attempts >= 3
            if ($_SESSION['login_attempts'] >= 3) {
                $captcha_answer = filter_input(INPUT_POST, 'captcha_answer', FILTER_VALIDATE_INT);
                $expected_answer = $_SESSION['captcha_answer'] ?? null;

                if ($captcha_answer !== $expected_answer) {
                    $error = "Enigma incorreto. Resolva o cálculo para prosseguir.";
                }
            }

            if (empty($error)) {
                $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
                $stmt->execute([$email]);
                $user = $stmt->fetch();

                if ($user && password_verify($password, $user['password_hash'])) {
                    // Login successful
                    $_SESSION['login_attempts'] = 0; // Reset
                    unset($_SESSION['captcha_answer']);

                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['name'];
                    $_SESSION['user_email'] = $user['email'];

                    if (!empty($redirect_to_post)) {
                        header('Location: ' . $redirect_to_post);
                    }
                    else {
                        header('Location: /portal/index.php');
                    }
                    exit;
                }
                else {
                    $_SESSION['login_attempts']++;
                    $error = "E-mail ou senha incorretos.";
                }
            }
        }
    }
}

// Generate new Captcha if needed
$show_captcha = ($_SESSION['login_attempts'] >= 3);
if ($show_captcha) {
    $num1 = rand(1, 10);
    $num2 = rand(1, 10);
    $_SESSION['captcha_answer'] = $num1 + $num2;
    $captcha_question = "Quanto é $num1 + $num2?";
}

// Includes layout header safely
require_once __DIR__ . '/includes/header.php';
?>

<section class="min-h-screen py-32 bg-black relative overflow-hidden flex items-center justify-center">
    <div class="absolute inset-0 bg-hero-gradient opacity-80 z-0"></div>
    
    <div class="w-full max-w-md px-6 relative z-10 gsap-reveal">
        <div class="text-center mb-10">
            <a href="/" class="inline-block mb-8">
                <img src="/assets/images/logotipo.jpeg" alt="Logotipo" class="h-16 w-auto rounded-xl object-contain shadow-[0_0_30px_rgba(255,255,255,0.1)]">
            </a>
            <h1 class="text-3xl font-bold tracking-tight text-white mb-2">Acesso ao Portal</h1>
            <p class="text-gray-400 text-sm font-mono">Área do Aluno CGADRB</p>
        </div>

        <div class="bg-black border border-white/10 p-8 rounded-3xl shadow-2xl backdrop-blur-xl">
            
            <?php if ($error): ?>
                <div class="bg-red-900/50 border border-red-500 text-red-200 px-4 py-3 rounded-xl mb-6 font-mono text-xs">
                    <?php echo $error; ?>
                </div>
            <?php
endif; ?>

            <form method="POST" action="login.php" class="space-y-5">
                <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                <?php if ($redirect_to): ?>
                    <input type="hidden" name="redirect" value="<?php echo sanitize_output($redirect_to); ?>">
                <?php
endif; ?>

                <div>
                    <label class="block text-xs font-mono text-gray-500 mb-2 uppercase tracking-widest">E-mail</label>
                    <input type="email" name="email" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#00ffcc] focus:bg-white/10 transition-colors text-sm" placeholder="seu@email.com" value="<?php echo sanitize_output($_POST['email'] ?? ''); ?>">
                </div>

                <div>
                    <label class="block text-xs font-mono text-gray-500 mb-2 uppercase tracking-widest">Senha</label>
                    <input type="password" name="password" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#00ffcc] focus:bg-white/10 transition-colors text-sm" placeholder="Sua senha">
                </div>

                <?php if ($show_captcha): ?>
                    <div class="bg-red-900/20 border border-red-500/50 p-4 rounded-xl">
                        <label class="block text-xs font-mono text-red-400 mb-2 uppercase tracking-widest">Verificação de Segurança</label>
                        <p class="text-sm text-gray-300 mb-3">Muitas tentativas falhas. <?php echo $captcha_question; ?></p>
                        <input type="number" name="captcha_answer" required class="w-full bg-white/5 border border-red-500/50 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-red-500 transition-colors text-sm" placeholder="Sua resposta">
                    </div>
                <?php
endif; ?>

                <div class="pt-4">
                    <button type="submit" class="w-full py-4 bg-white text-black font-bold rounded-xl hover:bg-[#00ffcc] transition-colors flex justify-center items-center gap-2 group shadow-[0_0_20px_rgba(255,255,255,0.1)] hover:shadow-[0_0_20px_rgba(0,255,204,0.3)]">
                        Entrar
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" class="group-hover:translate-x-1 transition-transform"><path d="M5 12h14M12 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                </div>
            </form>
            
            <div class="mt-8 pt-6 border-t border-white/5 text-center text-sm text-gray-400 flex flex-col gap-4">
                <a href="/forgot-password.php" class="text-gray-500 hover:text-white transition-colors underline underline-offset-4 decoration-white/20 hover:decoration-white">Esqueci minha senha</a>
                
                <div>
                    Ainda não tem conta? 
                    <a href="/register.php<?php echo $redirect_to ? '?redirect=' . urlencode($redirect_to) : ''; ?>" class="text-[#00ffcc] hover:text-white transition-colors font-semibold">Cadastre-se</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

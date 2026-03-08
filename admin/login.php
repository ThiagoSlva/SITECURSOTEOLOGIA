<?php
// admin/login.php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/security.php';

// Initialize login attempts
if (!isset($_SESSION['admin_login_attempts'])) {
    $_SESSION['admin_login_attempts'] = 0;
}

// If already logged in, redirect to index
if (isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validate_csrf_token($_POST['csrf_token'] ?? '')) {
        $error = "Token de segurança inválido.";
    }
    else {
        // Check Captcha if attempts >= 3
        if ($_SESSION['admin_login_attempts'] >= 3) {
            $captcha_answer = filter_input(INPUT_POST, 'captcha_answer', FILTER_VALIDATE_INT);
            $expected_answer = $_SESSION['admin_captcha_answer'] ?? null;

            if ($captcha_answer !== $expected_answer) {
                $error = "Enigma incorreto. Resolva o cálculo para prosseguir.";
            }
        }

        if (empty($error)) {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';

            $stmt = $pdo->prepare("SELECT id, name, password_hash FROM admin_users WHERE email = ? LIMIT 1");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            // Secure password verification
            if ($user && password_verify($password, $user['password_hash'])) {
                // Password is correct, regenerate session ID to prevent session fixation attacks
                session_regenerate_id(true);

                $_SESSION['admin_login_attempts'] = 0;
                unset($_SESSION['admin_captcha_answer']);
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['admin_name'] = $user['name'];

                header("Location: index.php");
                exit();
            }
            else {
                $_SESSION['admin_login_attempts']++;
                $error = "E-mail ou senha incorretos.";
            }
        }
    }
}

// Generate new Captcha if needed
$show_captcha = ($_SESSION['admin_login_attempts'] >= 3);
if ($show_captcha) {
    $num1 = rand(1, 10);
    $num2 = rand(1, 10);
    $_SESSION['admin_captcha_answer'] = $num1 + $num2;
    $captcha_question = "Quanto é $num1 + $num2?";
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Administração CGADRB</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #050505; color: white;}
    </style>
</head>
<body class="min-h-screen flex items-center justify-center relative overflow-hidden">
    
    <!-- Background Noise/Glow -->
    <div class="absolute inset-0 z-0">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-[#00ffcc] opacity-[0.05] blur-[100px] rounded-full"></div>
    </div>

    <div class="relative z-10 w-full max-w-md p-8 bg-[#0a0a0c] border border-white/10 rounded-3xl shadow-2xl">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold tracking-tighter">CGADRB<span class="text-[#00ffcc]">.</span>Admin</h1>
            <p class="text-gray-500 font-mono text-xs mt-2 uppercase tracking-widest">Acesso Restrito</p>
        </div>

        <?php if ($error): ?>
            <div class="bg-red-900/50 border border-red-500 text-red-200 px-4 py-3 rounded-lg mb-6 text-sm text-center">
                <?php echo $error; ?>
            </div>
        <?php
endif; ?>

        <form method="POST" action="" class="space-y-6">
            <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
            
            <div>
                <label class="block text-xs font-mono text-gray-400 mb-2 uppercase">E-mail</label>
                <input type="email" name="email" required class="w-full bg-black border border-white/10 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-[#00ffcc] transition-colors">
            </div>
            
            <div>
                <label class="block text-xs font-mono text-gray-400 mb-2 uppercase">Senha</label>
                <input type="password" name="password" required class="w-full bg-black border border-white/10 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-[#00ffcc] transition-colors">
            </div>

            <?php if ($show_captcha): ?>
            <div class="bg-red-900/20 border border-red-500/50 p-4 rounded-xl">
                <label class="block text-xs font-mono text-red-400 mb-2 uppercase tracking-widest">Verificação de Segurança</label>
                <p class="text-sm text-gray-300 mb-3">Muitas tentativas falhas. <?php echo $captcha_question; ?></p>
                <input type="number" name="captcha_answer" required class="w-full bg-black border border-red-500/50 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-red-500 transition-colors" placeholder="Sua resposta">
            </div>
            <?php endif; ?>

            <button type="submit" class="w-full py-4 text-black bg-[#00ffcc] hover:bg-white font-bold rounded-xl transition-colors flex items-center justify-center gap-2">
                Acessar Portal
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M5 12h14M12 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
        </form>
    </div>

</body>
</html>

<?php
// forgot-password.php
session_start();
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/security.php';
require_once __DIR__ . '/includes/mailer.php';

// If already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: /portal/index.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validate_csrf_token($_POST['csrf_token'] ?? '')) {
        $error = "Token inválido ou expirado. Tente novamente.";
    }
    else {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

        if (!$email) {
            $error = "Por favor, insira um e-mail válido.";
        }
        else {
            // Check if user exists
            $stmt = $pdo->prepare("SELECT id, name FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user) {
                // Generate secure token (64 hex characters)
                $token = bin2hex(random_bytes(32));
                // Set expiration (1 hour from now)
                $expires_at = date('Y-m-d H:i:s', strtotime('+1 hour'));

                // Save to password_resets
                $stmt = $pdo->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)");
                if ($stmt->execute([$email, $token, $expires_at])) {

                    // Create Reset Link
                    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
                    $host = $_SERVER['HTTP_HOST'];
                    $reset_link = $protocol . "://" . $host . "/reset-password.php?token=" . $token;

                    // Send Email
                    send_system_email($pdo, $email, 'password_reset', [
                        'reset_link' => $reset_link
                    ]);

                    $success = "Um link para recuperar sua senha foi enviado para seu e-mail.";
                }
                else {
                    $error = "Ocorreu um erro interno. Tente mais tarde.";
                }
            }
            else {
                // For security, don't reveal if email exists or not, just pretend we sent it
                $success = "Se o e-mail estiver cadastrado, um link de recuperação foi enviado.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esqueci minha senha - CGADRB</title>
    <link rel="icon" href="/assets/images/brasao.jpeg" type="image/jpeg">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,700;1,400;1,700&family=JetBrains+Mono&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS (Compiled Locally) -->
    <link rel="stylesheet" href="/assets/css/tailwind.css">
</head>
<body class="bg-deep-space text-white font-sans antialiased min-h-screen flex items-center justify-center relative overflow-hidden selection:bg-neon-accent selection:text-black p-6">

<!-- Global Noise Overlay -->
<div class="pointer-events-none fixed inset-0 z-50 h-full w-full opacity-[0.04]">
    <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
        <filter id="noise">
            <feTurbulence type="fractalNoise" baseFrequency="0.75" numOctaves="3" stitchTiles="stitch" />
        </filter>
        <rect width="100%" height="100%" filter="url(#noise)" />
    </svg>
</div>

<!-- Background Glow -->
<div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-neon-accent/5 rounded-full blur-[120px] pointer-events-none -z-10"></div>

<div class="max-w-md w-full relative z-10">
    
    <div class="text-center mb-10">
        <a href="/" class="inline-block mb-8">
            <img src="/assets/images/logotipo.jpeg" alt="CGADRB" class="h-14 w-auto rounded-xl mx-auto ring-1 ring-white/10 shadow-2xl">
        </a>
        <h1 class="text-3xl font-bold tracking-tight mb-3">Recuperar Senha</h1>
        <p class="text-gray-400 font-mono text-sm leading-relaxed">Digite o e-mail cadastrado na sua conta. Enviaremos um link seguro para você redefinir sua senha.</p>
    </div>

    <div class="bg-deep-surface/80 backdrop-blur-xl border border-deep-border/50 p-8 rounded-3xl shadow-2xl">
        
        <?php if ($error): ?>
            <div class="bg-red-900/30 border border-red-500/50 text-red-200 px-4 py-3 rounded-xl mb-6 font-mono text-sm flex items-start gap-3">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" class="shrink-0 mt-0.5"><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm-1-7v2h2v-2h-2zm0-8v6h2V7h-2z" fill="currentColor"/></svg>
                <span><?php echo $error; ?></span>
            </div>
        <?php
endif; ?>

        <?php if ($success): ?>
            <div class="bg-green-900/30 border border-green-500/50 text-green-200 px-4 py-3 rounded-xl mb-6 font-mono text-sm flex items-start gap-3 text-center">
                <span><?php echo $success; ?></span>
            </div>
            <a href="/login.php" class="block text-center w-full py-4 text-neon-accent font-bold hover:text-white transition-colors">Voltar ao Login</a>
        <?php
else: ?>

            <form method="POST" action="forgot-password.php" class="space-y-6">
                <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">

                <div>
                    <label class="block text-xs font-mono text-gray-400 mb-2 uppercase tracking-wide">E-mail Cadastrado</label>
                    <input type="email" name="email" required autofocus class="w-full bg-black/60 border border-deep-border/50 rounded-xl px-4 py-4 text-white focus:outline-none focus:border-neon-accent transition-colors font-mono text-sm placeholder:text-gray-600 shadow-inner" placeholder="aluno@exemplo.com">
                </div>

                <button type="submit" class="w-full py-4 bg-neon-accent text-black font-bold rounded-xl hover:bg-white transition-all transform hover:-translate-y-1 hover:shadow-[0_10px_40px_-10px_rgba(0,255,204,0.5)] flex justify-center items-center gap-2">
                    Enviar Link de Recuperação
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-white/5 text-center">
                <p class="text-xs font-mono text-gray-500 mb-4 uppercase tracking-widest">Lembrou a senha?</p>
                <a href="/login.php" class="text-sm font-bold text-white hover:text-neon-accent transition-colors block py-3 border border-white/10 rounded-xl hover:border-white/30 bg-white/5">
                    Voltar para o Login
                </a>
            </div>
            
        <?php
endif; ?>
    </div>
</div>

</body>
</html>

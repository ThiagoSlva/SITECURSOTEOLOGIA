<?php
// reset-password.php
session_start();
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/security.php';

$token = filter_input(INPUT_GET, 'token', FILTER_SANITIZE_STRING) ?? filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);

if (!$token) {
    die("Token não fornecido. Acesse o link enviado para o seu e-mail.");
}

$error = '';
$success = '';
$valid_token = false;
$user_email = '';

// Check Token Validity
$stmt = $pdo->prepare("SELECT email FROM password_resets WHERE token = ? AND expires_at > NOW() ORDER BY id DESC LIMIT 1");
$stmt->execute([$token]);
$reset_req = $stmt->fetch();

if ($reset_req) {
    $valid_token = true;
    $user_email = $reset_req['email'];
}
else {
    $error = "O link de recuperação é inválido ou expirou. Por favor, solicite um novo na tela de login.";
}

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $valid_token) {
    if (!validate_csrf_token($_POST['csrf_token'] ?? '')) {
        $error = "Token de formulário inválido.";
    }
    else {
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        if (strlen($password) < 8 || !preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/[\W_]/', $password)) {
            $error = "A senha deve ter no mínimo 8 caracteres, e conter letras, números e pelo menos um símbolo.";
        }
        elseif ($password !== $confirm_password) {
            $error = "As senhas não coincidem.";
        }
        else {
            // Update Password
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET password_hash = ? WHERE email = ?");

            if ($stmt->execute([$password_hash, $user_email])) {
                // Invalidate the used token by setting expiration to past
                $stmt_inv = $pdo->prepare("UPDATE password_resets SET expires_at = NOW() WHERE token = ?");
                $stmt_inv->execute([$token]);

                $success = "Sua senha foi redefinida com sucesso! Você pode fazer login agora.";
                $valid_token = false; // Prevent showing the form again
            }
            else {
                $error = "Erro ao atualizar a senha. Tente novamente.";
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
    <title>Redefinir Senha - CGADRB</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,700;1,400;1,700&family=JetBrains+Mono&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/tailwind.css">
</head>
<body class="bg-deep-space text-white font-sans antialiased min-h-screen flex items-center justify-center relative overflow-hidden p-6">

<div class="pointer-events-none fixed inset-0 z-50 h-full w-full opacity-[0.04]">
    <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%"><filter id="noise"><feTurbulence type="fractalNoise" baseFrequency="0.75" numOctaves="3" stitchTiles="stitch" /></filter><rect width="100%" height="100%" filter="url(#noise)" /></svg>
</div>

<div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-[#00ffcc]/5 rounded-full blur-[100px] pointer-events-none -z-10"></div>

<div class="max-w-md w-full relative z-10">
    <div class="text-center mb-10">
        <a href="/" class="inline-block mb-6">
            <img src="/assets/images/logotipo.jpeg" alt="CGADRB" class="h-12 w-auto rounded-xl mx-auto ring-1 ring-white/10 shadow-2xl">
        </a>
        <h1 class="text-3xl font-bold tracking-tight mb-3">Nova Senha</h1>
        <p class="text-gray-400 font-mono text-sm leading-relaxed">Crie uma nova senha forte para acessar sua conta.</p>
    </div>

    <div class="bg-deep-surface/80 backdrop-blur-xl border border-deep-border/50 p-8 rounded-3xl shadow-2xl">
        
        <?php if ($error): ?>
            <div class="bg-red-900/30 border border-red-500/50 text-red-200 px-4 py-3 rounded-xl mb-6 font-mono text-sm">
                <?php echo $error; ?>
            </div>
        <?php
endif; ?>

        <?php if ($success): ?>
            <div class="bg-green-900/30 border border-green-500/50 text-green-200 px-4 py-3 rounded-xl mb-6 font-mono text-sm text-center">
                <?php echo $success; ?>
            </div>
            <a href="/login.php" class="block text-center w-full py-4 bg-white text-black font-bold rounded-xl hover:bg-neon-accent transition-colors">Acessar o Portal</a>
        <?php
elseif ($valid_token): ?>

            <form method="POST" action="reset-password.php" class="space-y-6">
                <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                <input type="hidden" name="token" value="<?php echo sanitize_output($token); ?>">

                <div>
                    <label class="block text-xs font-mono text-gray-400 mb-2 uppercase tracking-wide">Nova Senha</label>
                    <input type="password" name="password" required autofocus class="w-full bg-black/60 border border-deep-border/50 rounded-xl px-4 py-4 text-white focus:outline-none focus:border-neon-accent transition-colors font-mono text-sm shadow-inner" placeholder="Mínimo 8 caracteres, letras, números e símbolos">
                </div>

                <div>
                    <label class="block text-xs font-mono text-gray-400 mb-2 uppercase tracking-wide">Confirme a Nova Senha</label>
                    <input type="password" name="confirm_password" required class="w-full bg-black/60 border border-deep-border/50 rounded-xl px-4 py-4 text-white focus:outline-none focus:border-neon-accent transition-colors font-mono text-sm shadow-inner" placeholder="Repita a senha">
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-4 bg-neon-accent text-black font-bold rounded-xl hover:bg-white transition-colors">
                        Atualizar Senha
                    </button>
                </div>
            </form>
            
        <?php
endif; ?>
    </div>
</div>
</body>
</html>

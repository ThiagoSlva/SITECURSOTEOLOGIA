<?php
// register.php
require_once __DIR__ . '/includes/security.php';
require_once __DIR__ . '/includes/db.php';

if (isset($_SESSION['user_id'])) {
    header('Location: /portal/index.php');
    exit;
}

$error = '';
$success = '';
$redirect_to = isset($_GET['redirect']) ? filter_var($_GET['redirect'], FILTER_SANITIZE_URL) : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validate_csrf_token($_POST['csrf_token'] ?? '')) {
        $error = "Sessão expirada. Tente novamente.";
    }
    else {
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
        $password = $_POST['password'] ?? '';
        $redirect_to_post = $_POST['redirect'] ?? '';
        $accept_terms = isset($_POST['accept_terms']) && $_POST['accept_terms'] === '1';

        if (!$name || !$email || !$password) {
            $error = "Preencha todos os campos obrigatórios.";
        }
        elseif (!$accept_terms) {
            $error = "Você precisa aceitar os Termos de Uso e Política de Privacidade para criar uma conta.";
        }
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "E-mail inválido.";
        }
        elseif (strlen($password) < 8 || !preg_match("#[0-9]+#", $password) || !preg_match("#[a-zA-Z]+#", $password) || !preg_match("/[\W_]/", $password)) {
            $error = "A senha deve ter pelo menos 8 caracteres, contendo letras, números e símbolos especiais.";
        }
        else {
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                $error = "Este e-mail já está cadastrado. Faça login.";
            }
            else {
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                require_once __DIR__ . '/includes/mailer.php';

                $stmt = $pdo->prepare("INSERT INTO users (name, email, password_hash, phone) VALUES (?, ?, ?, ?)");
                if ($stmt->execute([$name, $email, $password_hash, $phone])) {
                    $user_id = $pdo->lastInsertId();

                    send_system_email($pdo, $email, 'welcome', [
                        'nome' => $name,
                        'email' => $email
                    ]);

                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['user_name'] = $name;
                    $_SESSION['user_email'] = $email;

                    if (!empty($redirect_to_post)) {
                        header('Location: ' . $redirect_to_post);
                    }
                    else {
                        header('Location: /portal/index.php');
                    }
                    exit;
                }
                else {
                    $error = "Erro ao criar conta. Tente novamente mais tarde.";
                }
            }
        }
    }
}

require_once __DIR__ . '/includes/header.php';
?>

<section class="min-h-screen py-32 bg-black relative overflow-hidden flex items-center justify-center">
    <div class="absolute inset-0 bg-hero-gradient opacity-80 z-0"></div>
    
    <div class="w-full max-w-md px-6 relative z-10 gsap-reveal">
        <div class="text-center mb-10">
            <a href="/" class="inline-block mb-8">
                <img src="/assets/images/logotipo.jpeg" alt="Logotipo" class="h-16 w-auto rounded-xl object-contain shadow-[0_0_30px_rgba(255,255,255,0.1)]">
            </a>
            <h1 class="text-3xl font-bold tracking-tight text-white mb-2">Criar Conta</h1>
            <p class="text-gray-400 text-sm font-mono">Portal do Aluno CGADRB</p>
        </div>

        <div class="bg-black border border-white/10 p-8 rounded-3xl shadow-2xl backdrop-blur-xl">
            
            <?php if ($error): ?>
                <div class="bg-red-900/50 border border-red-500 text-red-200 px-4 py-3 rounded-xl mb-6 font-mono text-xs">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="register.php" class="space-y-5">
                <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                <?php if ($redirect_to): ?>
                    <input type="hidden" name="redirect" value="<?php echo sanitize_output($redirect_to); ?>">
                <?php endif; ?>

                <div>
                    <label class="block text-xs font-mono text-gray-500 mb-2 uppercase tracking-widest">Nome Completo</label>
                    <input type="text" name="name" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#00ffcc] focus:bg-white/10 transition-colors text-sm" placeholder="Seu nome completo" value="<?php echo sanitize_output($_POST['name'] ?? ''); ?>">
                </div>

                <div>
                    <label class="block text-xs font-mono text-gray-500 mb-2 uppercase tracking-widest">E-mail</label>
                    <input type="email" name="email" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#00ffcc] focus:bg-white/10 transition-colors text-sm" placeholder="seu@email.com" value="<?php echo sanitize_output($_POST['email'] ?? ''); ?>">
                </div>

                <div>
                    <label class="block text-xs font-mono text-gray-500 mb-2 uppercase tracking-widest">Telefone / WhatsApp</label>
                    <input type="text" name="phone" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#00ffcc] focus:bg-white/10 transition-colors text-sm" placeholder="(11) 99999-9999" value="<?php echo sanitize_output($_POST['phone'] ?? ''); ?>">
                </div>

                <div>
                    <label class="block text-xs font-mono text-gray-500 mb-2 uppercase tracking-widest">Senha Forte</label>
                    <input type="password" name="password" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#00ffcc] focus:bg-white/10 transition-colors text-sm" placeholder="Mínimo 8 caracteres (Letras, Números e Símbolos)">
                </div>

                <div class="pt-2">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" name="accept_terms" required value="1" class="mt-1 w-4 h-4 rounded border-gray-600 text-[#00ffcc] focus:ring-[#00ffcc] bg-white/5">
                        <span class="text-xs text-gray-400">
                            Ao criar uma conta, você concorda com nossos 
                            <a href="/termos-de-uso.php" target="_blank" class="text-[#00ffcc] hover:underline">Termos de Uso</a> e 
                            <a href="/politica-privacidade.php" target="_blank" class="text-[#00ffcc] hover:underline">Política de Privacidade</a>.
                        </span>
                    </label>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-4 bg-[#00ffcc] text-black font-bold rounded-xl hover:bg-white transition-colors flex justify-center items-center gap-2 group shadow-[0_0_20px_rgba(0,255,204,0.3)]">
                        Criar e Continuar
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" class="group-hover:translate-x-1 transition-transform"><path d="M5 12h14M12 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                </div>
            </form>
            
            <div class="mt-8 text-center text-sm text-gray-400">
                Já tem uma conta? 
                <a href="/login.php<?php echo $redirect_to ? '?redirect=' . urlencode($redirect_to) : ''; ?>" class="text-[#00ffcc] hover:text-white transition-colors font-semibold">Fazer Login</a>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

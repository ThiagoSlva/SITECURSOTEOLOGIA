<?php
// portal/index.php
session_start();
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/security.php';

// Auth Check
if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$user_email = $_SESSION['user_email'] ?? '';

// Fetch WhatsApp Number
$stmt = $pdo->query("SELECT whatsapp_number FROM settings WHERE id = 1");
$settings = $stmt->fetch();
$whatsapp_number = preg_replace('/[^0-9]/', '', $settings['whatsapp_number'] ?? '553192157857');

// Fetch User's Purchased Courses
// Status: PAID (pago) ou DELIVERED (entregue)
$stmt = $pdo->prepare("
    SELECT c.*, o.status as order_status, o.created_at as purchase_date 
    FROM courses c 
    INNER JOIN orders o ON c.id = o.course_id 
    WHERE o.user_id = ? AND o.status IN ('PAID', 'DELIVERED')
    ORDER BY o.created_at DESC
");
$stmt->execute([$user_id]);
$purchased_courses = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal do Aluno - CGADRB</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,700;1,400;1,700&family=JetBrains+Mono&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS (CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    },
                    colors: {
                        'deep-space': '#000000',
                        'deep-surface': '#0a0a0c',
                        'deep-border': 'rgba(255, 255, 255, 0.1)',
                        'neon-accent': '#00ffcc',
                        'neon-hover': '#00e6b8',
                    },
                    backgroundImage: {
                        'hero-gradient': 'linear-gradient(to bottom, rgba(0,0,0,0) 0%, rgba(0,0,0,0.8) 70%, rgba(0,0,0,1) 100%)',
                    }
                }
            }
        }
    </script>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body class="bg-deep-space text-white antialiased font-sans selection:bg-neon-accent selection:text-black min-h-screen flex flex-col relative overflow-x-hidden">

<!-- Global Noise Overlay -->
<div class="pointer-events-none fixed inset-0 z-50 h-full w-full opacity-[0.04]">
    <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
        <filter id="noise">
            <feTurbulence type="fractalNoise" baseFrequency="0.75" numOctaves="3" stitchTiles="stitch" />
        </filter>
        <rect width="100%" height="100%" filter="url(#noise)" />
    </svg>
</div>

<!-- Navbar Portal -->
<nav class="fixed w-full z-50 bg-black/80 backdrop-blur-xl border-b border-white/10 top-0">
    <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
        <a href="/portal/index.php" class="flex items-center gap-4">
            <img src="/assets/images/logotipo.jpeg" alt="CGADRB" class="h-10 w-auto rounded-lg">
            <span class="font-mono pt-1 text-sm tracking-widest text-[#00ffcc] hidden sm:block">PORTAL DO ALUNO</span>
        </a>
        <div class="flex items-center gap-6">
            <span class="text-xs font-mono text-gray-400 hidden sm:block">Olá, <?php echo sanitize_output(explode(' ', $user_name)[0]); ?></span>
            <a href="logout.php" class="text-xs font-mono text-red-400 hover:text-white transition-colors border border-red-900/50 hover:border-red-500 px-4 py-2 rounded-lg bg-red-900/20">Sair</a>
        </div>
    </div>
</nav>

<!-- Main Dashboard -->
<main class="pt-32 pb-24 min-h-screen relative overflow-hidden">
    <div class="absolute top-0 right-0 w-[800px] h-[800px] bg-[#00ffcc]/5 rounded-full blur-[120px] -z-10 pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-6 relative z-10">
        
        <header class="mb-16">
            <h1 class="text-4xl md:text-5xl font-bold tracking-tight mb-4">Meus Cursos</h1>
            <p class="text-gray-400 font-mono text-sm">Acesse todo o seu material didático e treinamentos abaixo.</p>
        </header>

        <?php if (empty($purchased_courses)): ?>
            <div class="bg-black border border-white/10 rounded-3xl p-12 text-center max-w-2xl mx-auto">
                <div class="w-20 h-20 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-500">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 016.5 17H20M4 19.5A2.5 2.5 0 006.5 22H20V2H6.5A2.5 2.5 0 004 4.5v15z"/></svg>
                </div>
                <h3 class="text-2xl font-bold mb-4">Nenhum curso ainda</h3>
                <p class="text-gray-400 mb-8 leading-relaxed">Você ainda não possui matrículas ativas ou seus pagamentos estão aguardando confirmação (PIX/Boleto).</p>
                <a href="/cursos.php" class="inline-flex items-center gap-2 px-8 py-4 bg-[#00ffcc] text-black font-bold rounded-xl hover:bg-white transition-colors">
                    Explorar Catálogo
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M5 12h14M12 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </a>
            </div>
        <?php
else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($purchased_courses as $course): ?>
                    <div class="bg-black border border-white/10 rounded-3xl overflow-hidden hover:border-[#00ffcc]/50 transition-colors group flex flex-col h-full">
                        
                        <?php if (!empty($course['image_url'])): ?>
                            <div class="h-48 overflow-hidden relative border-b border-white/10">
                                <div class="absolute inset-0 bg-black/40 group-hover:bg-transparent transition-colors z-10"></div>
                                <img src="<?php echo sanitize_output($course['image_url']); ?>" alt="Capa do Curso" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700">
                            </div>
                        <?php
        else: ?>
                            <div class="h-48 bg-white/5 flex items-center justify-center border-b border-white/10">
                                <span class="font-mono text-xs text-gray-600 tracking-widest uppercase">CGADRB Acadêmico</span>
                            </div>
                        <?php
        endif; ?>

                        <div class="p-8 flex flex-col flex-grow">
                            <h3 class="text-xl font-bold mb-3"><?php echo sanitize_output($course['title']); ?></h3>
                            <p class="text-gray-400 text-sm mb-8 line-clamp-2"><?php echo sanitize_output($course['description']); ?></p>
                            
                            <div class="mt-auto">
                                <div class="flex items-center gap-2 mb-6">
                                    <span class="w-2 h-2 rounded-full bg-green-500 shadow-[0_0_10px_rgba(34,197,94,0.5)]"></span>
                                    <span class="text-xs font-mono text-gray-400 uppercase tracking-widest">Matriculado</span>
                                </div>
                                <?php
                                $zap_message = "Olá! Gostaria de acessar o conteúdo do curso: " . $course['title'];
                                $zap_url = "https://api.whatsapp.com/send?phone=" . $whatsapp_number . "&text=" . urlencode($zap_message);
                                ?>
                                <a href="<?php echo $zap_url; ?>" target="_blank" class="w-full py-4 text-center rounded-xl bg-white/10 text-white font-semibold hover:bg-white hover:text-black transition-colors block border border-white/5 hover:border-white">
                                    Acessar Aulas
                                </a>
                            </div>
                        </div>
                    </div>
                <?php
    endforeach; ?>
            </div>
        <?php
endif; ?>

    </div>
</main>

<!-- Footer Simples -->
<footer class="border-t border-white/5 bg-black py-8">
    <div class="max-w-7xl mx-auto px-6 text-center text-xs font-mono text-gray-600">
        &copy; <?php echo date('Y'); ?> CGADRB. Ambiente Seguro.
    </div>
</footer>

</body>
</html>

<?php
// includes/header.php
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/db.php';

$site_name = 'Instituto Teológico CGADRB';
$site_url = 'https://cgadrb.shopdix.com.br'; // Altere para seu domínio real
$site_description = 'Cursos de extensão Instituto CAT em teologia com certificação reconhecida. Formação teológica de excelência combinando tradição cristã e rigor acadêmico contemporâneo.';
$site_image = '/assets/images/logotipo.jpeg';
$twitter_site = '@cgadrb';

$page_title = $page_title ?? 'CGADRB - Cursos de Extensão Instituto CAT';
$page_description = $page_description ?? $site_description;
$page_image = $page_image ?? $site_image;
$page_url = $page_url ?? $site_url;
$page_type = $page_type ?? 'website';

$is_logged_in = isset($_SESSION['user_id']);
$user_name = $_SESSION['user_name'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <link rel="icon" href="/assets/images/brasao.jpeg" type="image/jpeg">
    
    <!-- Meta Tags SEO -->
    <meta name="description" content="<?php echo htmlspecialchars($page_description); ?>">
    <meta name="keywords" content="teologia, curso de teologia, extensão universitária, certificação MEC, formação cristã, cursos online, seminário teológico, bachelor theology, master theology">
    <meta name="author" content="Instituto Teológico CGADRB">
    <meta name="robots" content="index, follow">
    <meta name="language" content="Portuguese">
    <meta name="revisit-after" content="7 days">
    <meta name="theme-color" content="#000000">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="<?php echo htmlspecialchars($page_url); ?>">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="<?php echo htmlspecialchars($page_type); ?>">
    <meta property="og:url" content="<?php echo htmlspecialchars($page_url); ?>">
    <meta property="og:title" content="<?php echo htmlspecialchars($page_title); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($page_description); ?>">
    <meta property="og:image" content="<?php echo htmlspecialchars($site_url . $page_image); ?>">
    <meta property="og:site_name" content="<?php echo htmlspecialchars($site_name); ?>">
    <meta property="og:locale" content="pt_BR">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="<?php echo htmlspecialchars($page_url); ?>">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($page_title); ?>">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($page_description); ?>">
    <meta name="twitter:image" content="<?php echo htmlspecialchars($site_url . $page_image); ?>">
    <meta name="twitter:site" content="<?php echo htmlspecialchars($twitter_site); ?>">
    
    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="/assets/images/logotipo.jpeg">
    <link rel="apple-touch-icon" href="/assets/images/logotipo.jpeg">
    
    <!-- Preconnect para Performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://unpkg.com">
    
    <!-- Tailwind CSS (Compiled Locally) -->
    <link rel="stylesheet" href="/assets/css/tailwind.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/css/styles.css">
    
    <!-- Lenis Smooth Scroll -->
    <link rel="stylesheet" href="https://unpkg.com/lenis@1.1.9/dist/lenis.css">
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

    <!-- The Floating Island Navbar (Slimmed) -->
    <nav id="navbar" class="fixed top-0 left-1/2 -translate-x-1/2 z-40 w-full max-w-5xl rounded-b-3xl border-x border-b border-deep-border bg-deep-surface/40 backdrop-blur-xl transition-all duration-500">
        <div class="px-8 py-3 flex items-center justify-between">
            <a href="/" class="flex items-center">
                <img src="assets/images/logotipo.jpeg" alt="CGADRB" class="h-9 w-auto rounded-lg object-contain shadow-lg border border-white/10">
            </a>
            
            <div class="hidden md:flex items-center gap-8">
                <a href="/cursos.php" class="text-xs font-mono uppercase tracking-widest text-gray-400 hover:text-white transition-colors">Cursos</a>
                <a href="/blog.php" class="text-xs font-mono uppercase tracking-widest text-gray-400 hover:text-white transition-colors">Blog</a>
                
                <?php if ($is_logged_in): ?>
                    <a href="/portal/index.php" class="text-xs font-mono uppercase tracking-widest text-neon-accent hover:text-white transition-colors">Portal do Aluno</a>
                <?php
else: ?>
                    <a href="/login.php" class="text-xs font-mono uppercase tracking-widest text-gray-400 hover:text-white transition-colors">Login</a>
                <?php
endif; ?>
            </div>
            
            <!-- Mobile Menu Button -->
            <button id="mobile-menu-btn" class="md:hidden text-gray-300 hover:text-white">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 12h18M3 6h18M3 18h18"/>
                </svg>
            </button>
            
            <a href="#planos" class="hidden md:block px-6 py-2 rounded-full bg-neon-accent text-black text-[10px] font-bold uppercase tracking-widest hover:bg-neon-hover transition-colors whitespace-nowrap">Comprar Curso</a>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden absolute top-full left-0 right-0 bg-deep-surface/95 backdrop-blur-xl border-t border-deep-border">
            <div class="px-6 py-4 space-y-4">
                <a href="/cursos.php" class="block text-sm font-medium text-gray-300 hover:text-white transition-colors">Cursos</a>
                <a href="/blog.php" class="block text-sm font-medium text-gray-300 hover:text-white transition-colors">Blog</a>
                <?php if ($is_logged_in): ?>
                    <a href="/portal/index.php" class="block text-sm font-medium text-neon-accent hover:text-white transition-colors">Portal do Aluno</a>
                <?php
else: ?>
                    <a href="/login.php" class="block text-sm font-medium text-gray-300 hover:text-white transition-colors">Login</a>
                <?php
endif; ?>
                <a href="#planos" class="block w-full py-2 rounded-full bg-neon-accent text-black text-sm font-semibold hover:bg-neon-hover transition-colors text-center">Comprar Curso</a>
            </div>
        </div>
    </nav>
    
    <main class="flex-grow">

    <!-- Mobile Menu Script -->
    <script>
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('mobile-menu');
            const btn = document.getElementById('mobile-menu-btn');
            if (!menu.contains(event.target) && !btn.contains(event.target)) {
                menu.classList.add('hidden');
            }
        });
    </script>

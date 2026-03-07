<?php
// includes/header.php
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/seo.php';

// Detectar página atual e gerar SEO
$current_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$page_data = [];

// SEO por página
switch ($current_path) {
    case '/':
    case '':
        $page_data = [
            'title' => 'CGADRB - Cursos Teológicos Online com Certificado',
            'description' => 'Cursos teológicos online com certificação reconhecida pelo MEC. Formação em teologia sistemática, pastoral e ministerial. Matricule-se agora!',
            'keywords' => 'cursos teológicos online, teologia a distancia, curso de teologia, formação teológica, seminário teológico, certificado teológico, CGADRB',
            'type' => 'website',
            'image' => 'https://' . $_SERVER['HTTP_HOST'] . '/assets/images/brasao.jpeg'
        ];
        break;
        
    case '/cursos.php':
        $page_data = [
            'title' => 'Catálogo de Cursos Teológicos - CGADRB',
            'description' => 'Conheça todos os cursos teológicos do CGADRB. Cursos online em teologia sistemática, pastoral, homilética e mais. Matrículas abertas!',
            'keywords' => 'cursos teológicos, catálogo de cursos, teologia online, cursos de teologia, formação pastoral, CGADRB',
            'type' => 'website'
        ];
        break;
        
    case (strpos($current_path, '/curso-single.php') !== false):
        $slug = $_GET['slug'] ?? '';
        if ($slug) {
            $stmt = $pdo->prepare("SELECT * FROM courses WHERE slug = ? AND status = 'active'");
            $stmt->execute([$slug]);
            $course = $stmt->fetch();
            
            if ($course) {
                $page_data = [
                    'title' => $course['title'] . ' - Curso Teológico Online - CGADRB',
                    'description' => strip_tags(substr($course['description'], 0, 160)) . '...',
                    'keywords' => $course['title'] . ', curso teológico, ' . $course['title'] . ' online, CGADRB',
                    'type' => 'course',
                    'image' => $course['image_url'] ?? 'https://' . $_SERVER['HTTP_HOST'] . '/assets/images/logotipo.jpeg'
                ];
            }
        }
        break;
        
    case '/blog.php':
        $page_data = [
            'title' => 'Blog Teológico - Artigos e Reflexões - CGADRB',
            'description' => 'Leia artigos teológicos profundos sobre teologia sistemática, pastoral, homilética e vida cristã. Conteúdo exclusivo CGADRB.',
            'keywords' => 'blog teológico, artigos teológicos, teologia sistemática, pastoral, homilética, CGADRB',
            'type' => 'website'
        ];
        break;
        
    default:
        $page_data = [
            'title' => 'CGADRB - Instituto de Formação Teológica',
            'description' => 'CGADRB - Instituto de formação teológica com cursos online e certificação reconhecida. Matricule-se em nossos cursos teológicos.',
            'keywords' => 'CGADRB, instituto teológico, formação teológica, cursos online, certificado teológico',
            'type' => 'website'
        ];
        break;
}

// Gerar meta tags
$seo_meta = generate_seo_meta($page_data);
echo $seo_meta;
?>
<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <!-- Tailwind CSS (CDN for rapid prototyping as requested) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,700;1,400;1,700&family=JetBrains+Mono&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/css/styles.css">
    
    <!-- Lenis Smooth Scroll -->
    <link rel="stylesheet" href="https://unpkg.com/lenis@1.1.9/dist/lenis.css">
    
    <!-- Structured Data Avançado -->
    <?php
    // Adicionar schema específico por página
    if (isset($course) && $course) {
        echo '<script type="application/ld+json">' . generate_course_schema($course) . '</script>';
    }
    // Adicionar breadcrumbs se aplicável
    if (isset($page_data['breadcrumbs'])) {
        echo '<script type="application/ld+json">' . generate_breadcrumb_schema($page_data['breadcrumbs']) . '</script>';
    }
    ?>
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

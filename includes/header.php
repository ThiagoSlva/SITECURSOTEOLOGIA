<?php
// includes/header.php
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/db.php';
?>
<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CGADRB - Cursos de Extensão Universitária</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,700;1,400;1,700&family=JetBrains+Mono&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS (CDN for rapid prototyping as requested) -->
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

    <!-- The Floating Island Navbar -->
    <nav id="navbar" class="fixed top-6 left-1/2 -translate-x-1/2 z-40 w-[90%] max-w-4xl rounded-full border border-deep-border bg-deep-surface/40 backdrop-blur-xl transition-all duration-500">
        <div class="px-6 py-4 flex items-center justify-between">
            <a href="/" class="flex items-center">
                <img src="assets/images/logotipo.jpeg" alt="CGADRB" class="h-12 w-auto rounded-xl object-contain shadow-lg border border-white/10">
            </a>
            
            <div class="hidden md:flex items-center gap-8">
                <a href="/cursos.php" class="text-sm font-medium text-gray-300 hover:text-white transition-colors">Cursos</a>
                <a href="/blog.php" class="text-sm font-medium text-gray-300 hover:text-white transition-colors">Blog</a>
            </div>
            
            <!-- Mobile Menu Button -->
            <button id="mobile-menu-btn" class="md:hidden text-gray-300 hover:text-white">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 12h18M3 6h18M3 18h18"/>
                </svg>
            </button>
            
            <a href="#planos" class="hidden md:block px-4 py-2 sm:px-5 rounded-full bg-neon-accent text-black text-xs sm:text-sm font-semibold hover:bg-neon-hover transition-colors whitespace-nowrap">Comprar Curso</a>
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

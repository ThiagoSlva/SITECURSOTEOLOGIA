<?php
// admin/includes/admin_header.php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/security.php';

// Force authentication
require_login();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo - CGADRB</title>
    <link rel="stylesheet" href="/assets/css/tailwind.css">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #050505; color: white;}
    </style>
</head>
<body class="min-h-screen bg-[#050505]">

    <!-- Mobile Top Bar -->
    <header class="lg:hidden h-16 bg-[#0a0a0c] border-b border-white/10 flex items-center justify-between px-6 sticky top-0 z-50">
        <div class="flex items-center gap-3">
            <img src="/assets/images/logotipo.jpeg" alt="Logotipo" class="h-6 w-auto rounded border border-white/10">
            <span class="text-xs font-mono font-bold uppercase tracking-widest text-gray-400">Admin</span>
        </div>
        <button id="mobile-menu-toggle" class="p-2 text-gray-400 hover:text-white transition-colors">
            <svg id="toggle-icon-open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
            <svg id="toggle-icon-close" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </header>

    <!-- Sidebar Wrapper for Flex on Desktop -->
    <div class="flex min-h-screen relative">
        <!-- Sidebar Backdrop (Mobile Only) -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-40 hidden lg:hidden opacity-0 transition-opacity duration-300"></div>

        <!-- Sidebar -->
        <aside id="admin-sidebar" class="fixed inset-y-0 left-0 w-64 bg-[#0a0a0c] border-r border-white/10 flex flex-col z-50 -translate-x-full lg:translate-x-0 lg:sticky lg:top-0 h-screen transition-transform duration-300 ease-in-out">
            <div class="p-5 border-b border-white/10 hidden lg:block">
                <a href="index.php" class="block mb-1">
                    <img src="/assets/images/logotipo.jpeg" alt="CGADRB Admin" class="h-8 w-auto rounded-lg object-contain shadow-md border border-white/10">
                </a>
                <p class="text-gray-500 font-mono text-[9px] mt-1 uppercase tracking-widest leading-none">Painel de Controle</p>
            </div>
            
            <nav class="flex-grow p-4 space-y-2 font-mono text-sm overflow-y-auto">
                <a href="index.php" class="flex items-center gap-3 py-2 px-4 rounded hover:bg-white/5 transition-colors <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'bg-white/10 text-[#00ffcc]' : 'text-gray-400'; ?>">📄 Dashboard</a>
                <a href="cursos.php" class="flex items-center gap-3 py-2 px-4 rounded hover:bg-white/5 transition-colors <?php echo basename($_SERVER['PHP_SELF']) == 'cursos.php' ? 'bg-white/10 text-[#00ffcc]' : 'text-gray-400'; ?>">🎓 Cursos</a>
                <a href="blog.php" class="flex items-center gap-3 py-2 px-4 rounded hover:bg-white/5 transition-colors <?php echo basename($_SERVER['PHP_SELF']) == 'blog.php' ? 'bg-white/10 text-[#00ffcc]' : 'text-gray-400'; ?>">✍️ Blog</a>
                <a href="emails.php" class="flex items-center gap-3 py-2 px-4 rounded hover:bg-white/5 transition-colors <?php echo basename($_SERVER['PHP_SELF']) == 'emails.php' ? 'bg-white/10 text-[#00ffcc]' : 'text-gray-400'; ?>">✉️ E-mails</a>
                <a href="clientes.php" class="flex items-center gap-3 py-2 px-4 rounded hover:bg-white/5 transition-colors <?php echo basename($_SERVER['PHP_SELF']) == 'clientes.php' ? 'bg-white/10 text-[#00ffcc]' : 'text-gray-400'; ?>">👥 Clientes</a>
                <hr class="border-white/5 my-4">
                <a href="configuracoes.php" class="flex items-center gap-3 py-2 px-4 rounded hover:bg-white/5 transition-colors <?php echo basename($_SERVER['PHP_SELF']) == 'configuracoes.php' ? 'bg-white/10 text-[#00ffcc]' : 'text-gray-400'; ?>">⚙️ Configs</a>
                <a href="alterar_senha.php" class="flex items-center gap-3 py-2 px-4 rounded hover:bg-white/5 transition-colors <?php echo basename($_SERVER['PHP_SELF']) == 'alterar_senha.php' ? 'bg-white/10 text-[#00ffcc]' : 'text-gray-400'; ?>">🔐 Senha</a>
                <a href="logout.php" class="flex items-center gap-3 py-2 px-4 rounded hover:bg-red-500/10 text-red-400/80 hover:text-red-400 transition-colors mt-4">🚪 Sair</a>
            </nav>

            <div class="p-4 border-t border-white/10">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-[#00ffcc] text-black flex items-center justify-center font-bold text-xs">A</div>
                    <div class="flex-grow min-w-0">
                        <p class="text-xs font-bold truncate"><?php echo sanitize_output($_SESSION['admin_name']); ?></p>
                        <a href="logout.php" class="text-[10px] text-gray-400 hover:text-red-400 uppercase tracking-tighter">Sair do Sistema</a>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-grow p-4 md:p-8 min-w-0 w-full">

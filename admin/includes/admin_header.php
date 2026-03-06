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
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #050505; color: white;}
    </style>
</head>
<body class="min-h-screen flex">

    <!-- Sidebar (Slimmed) -->
    <aside class="w-56 bg-[#0a0a0c] border-r border-white/10 flex flex-col h-screen sticky top-0">
        <div class="p-5 border-b border-white/10">
            <a href="index.php" class="block mb-1">
                <img src="/assets/images/logotipo.jpeg" alt="CGADRB Admin" class="h-8 w-auto rounded-lg object-contain shadow-md border border-white/10">
            </a>
            <p class="text-gray-500 font-mono text-[9px] mt-1 uppercase tracking-widest leading-none">Painel de Controle</p>
        </div>
        
        <nav class="flex-grow p-4 space-y-2 font-mono text-sm">
            <a href="index.php" class="block py-2 px-4 rounded hover:bg-white/5 transition-colors">📄 Dashboard</a>
            <a href="cursos.php" class="block py-2 px-4 rounded hover:bg-white/5 transition-colors">🎓 Cursos</a>
            <a href="blog.php" class="block py-2 px-4 rounded hover:bg-white/5 transition-colors">✍️ Artigos (Blog)</a>
            <a href="configuracoes.php" class="block py-2 px-4 rounded hover:bg-white/5 transition-colors">⚙️ Integrações (Asaas)</a>
        </nav>

        <div class="p-4 border-t border-white/10">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-8 h-8 rounded-full bg-[#00ffcc] text-black flex items-center justify-center font-bold">A</div>
                <div>
                    <p class="text-xs font-bold"><?php echo sanitize_output($_SESSION['admin_name']); ?></p>
                    <a href="logout.php" class="text-[10px] text-gray-500 hover:text-red-400 uppercase">Sair do Sistema</a>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-grow p-8 overflow-y-auto">

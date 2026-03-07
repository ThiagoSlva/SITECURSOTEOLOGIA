<?php
// admin/blog.php
require_once __DIR__ . '/includes/admin_header.php';

$success = '';
$error = '';

// Handle Post Creation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
    if (!validate_csrf_token($_POST['csrf_token'] ?? '')) {
        $error = "Token CSRF inválido.";
    }
    else {
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));

        // Em um sistema real poderíamos usar um editor rích text com purificador HTML. Aqui usamos textarea basic + nl2br no front
        $content = $_POST['content'] ?? ''; // Sanitaremos na exibição no frontend

        if (empty($title) || empty($content)) {
            $error = "Título e conteúdo são obrigatórios.";
        }
        else {
            try {
                $stmt = $pdo->prepare("INSERT INTO blog_posts (title, slug, content, author_id) VALUES (?, ?, ?, ?)");
                $stmt->execute([$title, $slug, $content, $_SESSION['admin_id']]);
                $success = "Artigo publicado com sucesso!";
            }
            catch (PDOException $e) {
                $error = "Erro ao publicar. Verifique duplicidade de título.";
            }
        }
    }
}

// Handle Post Deletion
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id_to_delete = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM blog_posts WHERE id = ?");
    $stmt->execute([$id_to_delete]);
    $success = "Artigo removido permanentemente.";
}

// Fetch Posts
$stmt = $pdo->query("SELECT b.*, a.name as author_name FROM blog_posts b LEFT JOIN admin_users a ON b.author_id = a.id ORDER BY b.created_at DESC");
$posts = $stmt->fetchAll();
?>

<div class="mb-8 flex justify-between items-end">
    <div>
        <h2 class="text-3xl font-bold tracking-tighter">Artigos (Blog)</h2>
        <p class="text-gray-400 font-mono text-sm mt-1">Gerencie as postagens do seu blog acadêmico/teológico.</p>
    </div>
</div>

<?php if ($error): ?>
    <div class="bg-red-900/50 border border-red-500 text-red-200 px-4 py-3 rounded-lg mb-6 font-mono text-sm">
        <?php echo $error; ?>
    </div>
<?php
endif; ?>

<?php if ($success): ?>
    <div class="bg-green-900/50 border border-green-500 text-green-200 px-4 py-3 rounded-lg mb-6 font-mono text-sm">
        <?php echo $success; ?>
    </div>
<?php
endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Novo Post Form -->
    <div class="lg:col-span-1">
        <div class="bg-[#0a0a0c] border border-white/10 p-6 rounded-2xl sticky top-24">
            <h3 class="font-bold mb-6 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span> Redigir Artigo
            </h3>
            
            <form method="POST" action="">
                <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                <input type="hidden" name="action" value="create">
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-mono text-gray-400 mb-2 uppercase">Título</label>
                        <input type="text" name="title" required class="w-full bg-black border border-white/10 rounded-lg px-3 py-2 text-white focus:outline-none focus:border-blue-500 text-sm">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-mono text-gray-400 mb-2 uppercase">Conteúdo do Artigo</label>
                        <textarea name="content" rows="10" required class="w-full bg-black border border-white/10 rounded-lg px-3 py-2 text-white focus:outline-none focus:border-blue-500 text-sm placeholder-gray-600 border-none resize-y"></textarea>
                        <p class="mt-2 text-[10px] text-gray-500 font-mono">Quebras de linha (Enter) criarão parágrafos automaticamente no portal.</p>
                    </div>
                </div>

                <button type="submit" class="w-full mt-6 py-3 bg-blue-600 text-white hover:bg-white hover:text-black font-bold rounded-lg transition-colors text-sm border border-transparent">
                    Publicar
                </button>
            </form>
        </div>
    </div>

    <!-- Lista de Posts -->
    <div class="lg:col-span-2">
        <div class="bg-[#0a0a0c] border border-white/10 rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-400">
                <thead class="text-xs uppercase bg-white/5 font-mono">
                    <tr>
                        <th class="px-6 py-4">Artigo</th>
                        <th class="px-6 py-4">Autor</th>
                        <th class="px-6 py-4">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($posts)): ?>
                        <tr><td colspan="3" class="px-6 py-8 text-center text-gray-500 font-mono">Nenhum artigo publicado.</td></tr>
                    <?php
else: ?>
                        <?php foreach ($posts as $p): ?>
                            <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
                                <td class="px-6 py-4">
                                    <p class="text-white font-medium mb-1"><?php echo sanitize_output($p['title']); ?></p>
                                    <p class="text-xs text-gray-500 font-mono"><?php echo date('d/m/Y H:i', strtotime($p['created_at'])); ?></p>
                                </td>
                                <td class="px-6 py-4 text-gray-500 font-mono text-xs"><?php echo sanitize_output($p['author_name'] ?? 'Admin'); ?></td>
                                <td class="px-6 py-4">
                                    <a href="blog.php?delete=<?php echo $p['id']; ?>" class="text-red-400 hover:text-white transition-colors text-xs font-mono" onclick="return confirm('Excluir este artigo para sempre?');">[ DELETAR ]</a>
                                </td>
                            </tr>
                        <?php
    endforeach; ?>
                    <?php
endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>

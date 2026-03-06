<?php
// admin/cursos.php
require_once __DIR__ . '/includes/admin_header.php';

$success = '';
$error = '';

// Handle Course Creation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
    if (!validate_csrf_token($_POST['csrf_token'] ?? '')) {
        $error = "Token CSRF inválido.";
    }
    else {
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
        $desc = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);

        // Parse features
        $features_raw = explode("\n", $_POST['features'] ?? '');
        $features = [];
        foreach ($features_raw as $f) {
            $f = trim($f);
            if (!empty($f))
                $features[] = $f;
        }
        $features_json = json_encode($features);

        if ($price === false) {
            $error = "Preço inválido.";
        }
        else {
            // Handle Image Upload
            $image_url = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $upload_dir = __DIR__ . '/../assets/images/cursos/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }

                $file_extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                $allowed_exts = ['jpg', 'jpeg', 'png', 'webp'];

                if (in_array($file_extension, $allowed_exts)) {
                    $new_filename = uniqid('curso_') . '.' . $file_extension;
                    $upload_path = $upload_dir . $new_filename;

                    if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                        $image_url = '/assets/images/cursos/' . $new_filename;
                    }
                    else {
                        $error = "Erro ao salvar a imagem do curso.";
                    }
                }
                else {
                    $error = "Formato de imagem inválido. Use JPG, PNG ou WEBP.";
                }
            }

            if (empty($error)) {
                try {
                    $stmt = $pdo->prepare("INSERT INTO courses (title, slug, description, price, features_json, status, image_url) VALUES (?, ?, ?, ?, ?, 'active', ?)");
                    $stmt->execute([$title, $slug, $desc, $price, $features_json, $image_url]);
                    $success = "Curso criado com sucesso e ativo na plataforma.";
                }
                catch (PDOException $e) {
                    $error = "Erro ao criar curso. Verifique se o nome já existe.";
                }
            }
        }
    }
}

// Handle Course Deletion
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id_to_delete = (int)$_GET['delete'];
    // In a real app we might soft-delete. Here we just hard delete or set inactive.
    $stmt = $pdo->prepare("UPDATE courses SET status = 'inactive' WHERE id = ?");
    $stmt->execute([$id_to_delete]);
    $success = "Curso inativado com sucesso.";
}

// Fetch Courses
$stmt = $pdo->query("SELECT * FROM courses ORDER BY id DESC");
$courses = $stmt->fetchAll();
?>

<div class="mb-8 flex justify-between items-end">
    <div>
        <h2 class="text-3xl font-bold tracking-tighter">Cursos</h2>
        <p class="text-gray-400 font-mono text-sm mt-1">Gerencie os cursos oferecidos na plataforma.</p>
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
    
    <!-- Novo Curso Form -->
    <div class="lg:col-span-1">
        <div class="bg-[#0a0a0c] border border-white/10 p-6 rounded-2xl sticky top-24">
            <h3 class="font-bold mb-6 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-[#00ffcc]"></span> Adicionar Curso
            </h3>
            
            <form method="POST" action="" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                <input type="hidden" name="action" value="create">
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-mono text-gray-400 mb-2 uppercase">Imagem (Capa)</label>
                        <input type="file" name="image" accept="image/jpeg, image/png, image/webp" class="w-full bg-black border border-white/10 rounded-lg px-3 py-2 text-white focus:outline-none focus:border-[#00ffcc] text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-[#00ffcc] file:text-black hover:file:bg-white cursor-pointer">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-mono text-gray-400 mb-2 uppercase">Título</label>
                        <input type="text" name="title" required class="w-full bg-black border border-white/10 rounded-lg px-3 py-2 text-white focus:outline-none focus:border-[#00ffcc] text-sm">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-mono text-gray-400 mb-2 uppercase">Preço (Ex: 197.50)</label>
                        <input type="number" step="0.01" name="price" required class="w-full bg-black border border-white/10 rounded-lg px-3 py-2 text-white focus:outline-none focus:border-[#00ffcc] text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-mono text-gray-400 mb-2 uppercase">Descrição Curta</label>
                        <textarea name="description" rows="3" required class="w-full bg-black border border-white/10 rounded-lg px-3 py-2 text-white focus:outline-none focus:border-[#00ffcc] text-sm"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-mono text-gray-400 mb-2 uppercase">Tópicos (1 por linha)</label>
                        <textarea name="features" rows="4" placeholder="Certificado Reconhecido&#10;Mentoria VIP&#10;Acesso Vitalício" class="w-full bg-black border border-white/10 rounded-lg px-3 py-2 text-white focus:outline-none focus:border-[#00ffcc] text-sm placeholder-gray-600 font-mono"></textarea>
                    </div>
                </div>

                <button type="submit" class="w-full mt-6 py-3 bg-[#00ffcc] text-black font-bold rounded-lg hover:bg-white transition-colors text-sm">
                    Adicionar Curso
                </button>
            </form>
        </div>
    </div>

    <!-- Lista de Cursos -->
    <div class="lg:col-span-2">
        <div class="bg-[#0a0a0c] border border-white/10 rounded-2xl overflow-hidden">
            <table class="w-full text-left text-sm text-gray-400">
                <thead class="text-xs uppercase bg-white/5 font-mono">
                    <tr>
                        <th class="px-6 py-4">Curso</th>
                        <th class="px-6 py-4">Preço</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($courses)): ?>
                        <tr><td colspan="4" class="px-6 py-8 text-center">Nenhum curso cadastrado.</td></tr>
                    <?php
else: ?>
                        <?php foreach ($courses as $c): ?>
                            <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
                                <td class="px-6 py-4 flex items-center gap-4">
                                    <?php if (!empty($c['image_url'])): ?>
                                        <img src="<?php echo sanitize_output($c['image_url']); ?>" alt="Capa" class="w-12 h-12 object-cover rounded-lg border border-white/10">
                                    <?php
        else: ?>
                                        <div class="w-12 h-12 bg-white/5 rounded-lg border border-white/10 flex items-center justify-center text-gray-500 font-mono text-[10px]">SEM IMAGEM</div>
                                    <?php
        endif; ?>
                                    
                                    <div>
                                        <p class="text-white font-medium mb-1"><?php echo sanitize_output($c['title']); ?></p>
                                        <p class="text-xs line-clamp-1 max-w-sm"><?php echo sanitize_output($c['description']); ?></p>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-[#00ffcc] font-mono">R$ <?php echo number_format($c['price'], 2, ',', '.'); ?></td>
                                <td class="px-6 py-4">
                                    <?php if ($c['status'] == 'active'): ?>
                                        <span class="px-2 py-1 rounded bg-green-900/50 text-green-400 text-xs font-mono">Ativo</span>
                                    <?php
        else: ?>
                                        <span class="px-2 py-1 rounded bg-red-900/50 text-red-400 text-xs font-mono">Inativo</span>
                                    <?php
        endif; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php if ($c['status'] == 'active'): ?>
                                    <a href="cursos.php?delete=<?php echo $c['id']; ?>" class="text-red-400 hover:text-white transition-colors text-xs font-mono" onclick="return confirm('Deseja realmente inativar este curso? Ele sumirá da página inicial.');">[ INATIVAR ]</a>
                                    <?php
        endif; ?>
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

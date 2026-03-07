<?php
// admin/cursos.php
require_once __DIR__ . '/includes/admin_header.php';

$success = '';
$error = '';

// Handle Course Creation/Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if (!validate_csrf_token($_POST['csrf_token'] ?? '')) {
        $error = "Token CSRF inválido.";
    }
    else {
        $action = $_POST['action'];
        $course_id = filter_input(INPUT_POST, 'course_id', FILTER_VALIDATE_INT);
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
            $category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);

            // Handle Image Upload
            $image_url = $_POST['existing_image'] ?? null;
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
                    if ($action === 'create') {
                        $stmt = $pdo->prepare("INSERT INTO courses (title, slug, description, price, features_json, status, image_url, category_id) VALUES (?, ?, ?, ?, ?, 'active', ?, ?)");
                        $stmt->execute([$title, $slug, $desc, $price, $features_json, $image_url, $category_id ?: null]);
                        $success = "Curso criado com sucesso.";
                    }
                    elseif ($action === 'update' && $course_id) {
                        $stmt = $pdo->prepare("UPDATE courses SET title = ?, slug = ?, description = ?, price = ?, features_json = ?, image_url = ?, category_id = ? WHERE id = ?");
                        $stmt->execute([$title, $slug, $desc, $price, $features_json, $image_url, $category_id ?: null, $course_id]);
                        $success = "Curso atualizado com sucesso.";
                    }
                }
                catch (PDOException $e) {
                    $error = "Erro ao processar curso. Verifique se o nome já existe.";
                }
            }
        }
    }
}

// Handle Category Creation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cat_action']) && $_POST['cat_action'] === 'create_cat') {
    if (!validate_csrf_token($_POST['csrf_token'] ?? '')) {
        $error = "Token CSRF inválido.";
    }
    else {
        $cat_name = filter_input(INPUT_POST, 'cat_name', FILTER_SANITIZE_STRING);
        $cat_slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $cat_name)));

        if ($cat_name) {
            try {
                $stmt = $pdo->prepare("INSERT INTO categories (name, slug) VALUES (?, ?)");
                $stmt->execute([$cat_name, $cat_slug]);
                $success = "Categoria criada com sucesso.";
            }
            catch (PDOException $e) {
                $error = "Erro ao criar categoria. Talvez o nome já exista.";
            }
        }
    }
}

// Handle Category Deletion
if (isset($_GET['delete_cat']) && is_numeric($_GET['delete_cat'])) {
    $cat_id = (int)$_GET['delete_cat'];
    try {
        $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->execute([$cat_id]);
        $success = "Categoria excluída com sucesso.";
    }
    catch (PDOException $e) {
        $error = "Não é possível excluir a categoria pois existem cursos vinculados a ela.";
    }
}

// Handle Course Deactivation (Inativar)
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id_to_delete = (int)$_GET['delete'];
    $stmt = $pdo->prepare("UPDATE courses SET status = 'inactive' WHERE id = ?");
    $stmt->execute([$id_to_delete]);
    $success = "Curso inativado com sucesso.";
}

// Handle Course Hard Deletion (Excluir)
if (isset($_GET['hard_delete']) && is_numeric($_GET['hard_delete'])) {
    $id_to_delete = (int)$_GET['hard_delete'];
    try {
        $stmt = $pdo->prepare("DELETE FROM courses WHERE id = ?");
        $stmt->execute([$id_to_delete]);
        $success = "Curso excluído permanentemente com sucesso.";
    }
    catch (PDOException $e) {
        // Código 23000 indica violação de chave estrangeira (já existem compras atreladas)
        if ($e->getCode() == 23000) {
            $error = "Não é possível excluir o curso pois existem matrículas vinculadas a ele. Utilize a opção [ INATIVAR ].";
        }
        else {
            $error = "Erro ao excluir curso: " . $e->getMessage();
        }
    }
}

// Fetch Course for Editing
$edit_course = null;
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM courses WHERE id = ?");
    $stmt->execute([(int)$_GET['edit']]);
    $edit_course = $stmt->fetch();
}

// Fetch Categories
$stmt = $pdo->query("SELECT * FROM categories ORDER BY name ASC");
$categories = $stmt->fetchAll();

// Fetch Courses with Category Name
$stmt = $pdo->query("
    SELECT c.*, cat.name as category_name 
    FROM courses c 
    LEFT JOIN categories cat ON c.category_id = cat.id 
    ORDER BY c.id DESC
");
$courses = $stmt->fetchAll();
?>

<div class="mb-8 flex justify-between items-end gap-4">
    <div>
        <h2 class="text-3xl font-bold tracking-tighter">Cursos</h2>
        <p class="text-gray-400 font-mono text-sm mt-1">Gerencie os cursos oferecidos na plataforma.</p>
    </div>
    <div class="flex gap-2">
        <a href="#categorias" class="px-4 py-2 border border-blue-500 text-blue-400 text-[10px] font-bold rounded-lg hover:bg-blue-600 hover:text-white transition-all uppercase tracking-widest flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
            Categorias
        </a>
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
    
    <!-- Formulário De Curso (Criação/Edição) -->
    <div class="lg:col-span-1">
        <div class="bg-[#0a0a0c] border border-white/10 p-6 rounded-2xl sticky top-24 shadow-2xl">
            <h3 class="font-bold mb-6 flex items-center justify-between gap-2">
                <span class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-[#00ffcc] <?php echo $edit_course ? 'animate-pulse' : ''; ?>"></span> 
                    <?php echo $edit_course ? 'Editar Curso' : 'Adicionar Curso'; ?>
                </span>
                <?php if ($edit_course): ?>
                    <a href="cursos.php" class="text-[10px] text-gray-500 hover:text-white font-mono uppercase tracking-widest transition-colors">[ Cancelar ]</a>
                <?php
endif; ?>
            </h3>
            
            <form method="POST" action="cursos.php" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                <input type="hidden" name="action" value="<?php echo $edit_course ? 'update' : 'create'; ?>">
                <?php if ($edit_course): ?>
                    <input type="hidden" name="course_id" value="<?php echo $edit_course['id']; ?>">
                    <input type="hidden" name="existing_image" value="<?php echo $edit_course['image_url']; ?>">
                <?php
endif; ?>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-mono text-gray-400 mb-2 uppercase tracking-widest">Imagem (Capa)</label>
                        <?php if ($edit_course && $edit_course['image_url']): ?>
                            <div class="mb-3 relative group overflow-hidden rounded-lg">
                                <img src="<?php echo $edit_course['image_url']; ?>" class="w-full h-32 object-contain border border-white/10 bg-black">
                                <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-[10px] text-gray-400 font-mono text-center px-4">ENVIAR NOVA PARA SUBSTITUIR</div>
                            </div>
                        <?php
endif; ?>
                        <input type="file" name="image" accept="image/jpeg, image/png, image/webp" class="w-full bg-black border border-white/10 rounded-lg px-3 py-2 text-white focus:outline-none focus:border-[#00ffcc] text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-[#00ffcc] file:text-black hover:file:bg-white cursor-pointer">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-mono text-gray-400 mb-2 uppercase tracking-widest">Título</label>
                        <input type="text" name="title" required value="<?php echo $edit_course ? sanitize_output($edit_course['title']) : ''; ?>" class="w-full bg-black border border-white/10 rounded-lg px-3 py-2 text-white focus:outline-none focus:border-[#00ffcc] text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-mono text-gray-400 mb-2 uppercase tracking-widest">Categoria</label>
                        <select name="category_id" class="w-full bg-black border border-white/10 rounded-lg px-3 py-2 text-white focus:outline-none focus:border-[#00ffcc] text-sm cursor-pointer">
                            <option value="">Sem Categoria</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo $cat['id']; ?>" <?php echo($edit_course && $edit_course['category_id'] == $cat['id']) ? 'selected' : ''; ?>>
                                    <?php echo sanitize_output($cat['name']); ?>
                                </option>
                            <?php
endforeach; ?>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-mono text-gray-400 mb-2 uppercase tracking-widest">Preço (Ex: 197.50)</label>
                        <input type="number" step="0.01" name="price" required value="<?php echo $edit_course ? $edit_course['price'] : ''; ?>" class="w-full bg-black border border-white/10 rounded-lg px-3 py-2 text-white focus:outline-none focus:border-[#00ffcc] text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-mono text-gray-400 mb-2 uppercase tracking-widest">Descrição Curta</label>
                        <textarea name="description" rows="3" required class="w-full bg-black border border-white/10 rounded-lg px-3 py-2 text-white focus:outline-none focus:border-[#00ffcc] text-sm"><?php echo $edit_course ? sanitize_output($edit_course['description']) : ''; ?></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-mono text-gray-400 mb-2 uppercase tracking-widest">Tópicos (1 por linha)</label>
                        <?php
$features_text = "";
if ($edit_course) {
    $feat_arr = json_decode($edit_course['features_json'], true);
    if (is_array($feat_arr))
        $features_text = implode("\n", $feat_arr);
}
?>
                        <textarea name="features" rows="4" placeholder="Certificado Reconhecido&#10;Mentoria VIP&#10;Acesso Vitalício" class="w-full bg-black border border-white/10 rounded-lg px-3 py-2 text-white focus:outline-none focus:border-[#00ffcc] text-sm placeholder-gray-600 font-mono"><?php echo $features_text; ?></textarea>
                    </div>
                </div>

                <button type="submit" class="w-full mt-6 py-4 bg-[#00ffcc] text-black font-bold rounded-lg hover:bg-white transition-all transform hover:-translate-y-1 shadow-lg text-sm">
                    <?php echo $edit_course ? 'Salvar Alterações' : 'Adicionar Curso'; ?>
                </button>
            </form>
        </div>
    </div>

    <!-- Lista de Cursos -->
    <div class="lg:col-span-2">
        <div class="bg-[#0a0a0c] border border-white/10 rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-400">
                <thead class="text-xs uppercase bg-white/5 font-mono">
                    <tr>
                        <th class="px-6 py-4">Curso</th>
                        <th class="px-6 py-4">Categoria</th>
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
                                        <img src="<?php echo sanitize_output($c['image_url']); ?>" alt="Capa" class="w-12 h-12 object-contain rounded-lg border border-white/10 bg-black">
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
                                <td class="px-6 py-4">
                                    <span class="text-xs font-mono <?php echo $c['category_name'] ? 'text-gray-300' : 'text-gray-600 italic'; ?>">
                                        <?php echo $c['category_name'] ? sanitize_output($c['category_name']) : 'Nenhum'; ?>
                                    </span>
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
                                <td class="px-6 py-4 flex flex-col gap-2">
                                    <div class="flex gap-2">
                                        <a href="cursos.php?edit=<?php echo $c['id']; ?>" class="text-blue-400 hover:text-white transition-colors text-[10px] font-mono uppercase tracking-widest">[ EDITAR ]</a>
                                        
                                        <?php if ($c['status'] == 'active'): ?>
                                            <a href="cursos.php?delete=<?php echo $c['id']; ?>" class="text-yellow-500 hover:text-white transition-colors text-[10px] font-mono uppercase tracking-widest" onclick="return confirm('Deseja inativar este curso? Ele será ocultado da loja inicial.');">[ INATIVAR ]</a>
                                        <?php
        endif; ?>
                                    </div>
                                    
                                    <a href="cursos.php?hard_delete=<?php echo $c['id']; ?>" class="text-red-500 hover:text-white transition-colors text-[10px] font-mono uppercase tracking-widest" onclick="return confirm('ATENÇÃO: Deseja EXCLUIR permanentemente este curso? Isso não pode ser desfeito.');">[ EXCLUIR ]</a>
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

    <!-- Gestão de Categorias -->
    <div id="categorias" class="lg:col-span-3 mt-12 border-t border-white/10 pt-12">
        <h3 class="text-xl font-bold mb-6 flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-blue-500"></span>
            Gestão de Categorias
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Adicionar Categoria -->
            <div class="bg-[#0a0a0c] border border-white/10 p-6 rounded-2xl">
                <form method="POST" action="cursos.php">
                    <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                    <input type="hidden" name="cat_action" value="create_cat">
                    <div class="flex gap-4">
                        <div class="flex-grow">
                            <label class="block text-xs font-mono text-gray-400 mb-2 uppercase tracking-widest">Novo Nome de Categoria</label>
                            <input type="text" name="cat_name" required placeholder="Ex: Cursos Rápidos" class="w-full bg-black border border-white/10 rounded-lg px-3 py-2 text-white focus:outline-none focus:border-blue-500 text-sm">
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="h-[38px] px-6 bg-blue-600 text-white font-bold rounded-lg hover:bg-white hover:text-black transition-all text-xs uppercase tracking-widest">Criar</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Listagem de Categorias -->
            <div class="bg-[#0a0a0c] border border-white/10 rounded-2xl overflow-hidden text-sm">
                <table class="w-full text-left">
                    <thead class="bg-white/5 font-mono text-xs uppercase">
                        <tr>
                            <th class="px-6 py-3">Categoria</th>
                            <th class="px-6 py-3 text-right">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($categories)): ?>
                            <tr><td colspan="2" class="px-6 py-4 text-gray-500">Nenhuma categoria criada.</td></tr>
                        <?php
else: ?>
                            <?php foreach ($categories as $cat): ?>
                                <tr class="border-b border-white/5">
                                    <td class="px-6 py-3 font-medium"><?php echo sanitize_output($cat['name']); ?></td>
                                    <td class="px-6 py-3 text-right">
                                        <a href="cursos.php?delete_cat=<?php echo $cat['id']; ?>" class="text-red-500 hover:text-white transition-colors font-mono text-[10px]" onclick="return confirm('Deseja excluir esta categoria?');">[ EXCLUIR ]</a>
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

</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>

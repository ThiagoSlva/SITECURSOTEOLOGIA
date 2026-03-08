<?php
// admin/emails.php
require_once __DIR__ . '/includes/admin_header.php';

$success = '';
$error = '';

/**
 * Handle form submission
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validate_csrf_token($_POST['csrf_token'] ?? '')) {
        $error = "Token de segurança inválido.";
    }
    else {
        $action = $_POST['action'] ?? 'edit';

        if ($action === 'create') {
            // Criar novo template
            $type = filter_input(INPUT_POST, 'new_type', FILTER_SANITIZE_STRING);
            $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING);
            $body_html = $_POST['body_html'] ?? '';

            if (!$type || !$subject || !$body_html) {
                $error = "Todos os campos são obrigatórios.";
            }
            else {
                // Verificar se tipo já existe
                $stmt = $pdo->prepare("SELECT id FROM email_templates WHERE type = ?");
                $stmt->execute([$type]);
                if ($stmt->fetch()) {
                    $error = "Este tipo de template já existe.";
                }
                else {
                    $stmt = $pdo->prepare("INSERT INTO email_templates (type, subject, body_html) VALUES (?, ?, ?)");
                    if ($stmt->execute([$type, $subject, $body_html])) {
                        $success = "Template criado com sucesso!";
                    }
                    else {
                        $error = "Erro ao criar o template.";
                    }
                }
            }
        }
        else {
            // Editar template existente
            $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING);
            $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING);
            $body_html = $_POST['body_html'] ?? '';

            if (!$type || !$subject || !$body_html) {
                $error = "Todos os campos são obrigatórios.";
            }
            else {
                $stmt = $pdo->prepare("UPDATE email_templates SET subject = ?, body_html = ? WHERE type = ?");
                if ($stmt->execute([$subject, $body_html, $type])) {
                    $success = "Template atualizado com sucesso!";
                }
                else {
                    $error = "Erro ao atualizar o template.";
                }
            }
        }
    }
}

// Fetch Templates
$stmt = $pdo->query("SELECT * FROM email_templates ORDER BY type ASC");
$templates = $stmt->fetchAll();
?>

<div class="space-y-8">
    
    <div class="flex justify-between items-start">
        <div>
            <h1 class="text-3xl font-bold tracking-tight mb-2">Editor de E-mails</h1>
            <p class="text-gray-400 font-mono text-sm max-w-2xl">Personalize os e-mails automáticos do sistema. Utilize as variáveis disponíveis (ex: <code class="text-neon-accent">{{nome}}</code>) em cada template.</p>
        </div>
        <button type="button" onclick="document.getElementById('newTemplateModal').classList.remove('hidden')" class="px-4 py-2 bg-neon-accent text-black font-bold rounded-lg hover:bg-white transition-colors text-sm">
            + Novo Template
        </button>
    </div>

    <!-- Modal Novo Template -->
    <div id="newTemplateModal" class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-deep-surface border border-deep-border rounded-2xl p-6 w-full max-w-lg shadow-2xl">
            <h3 class="text-xl font-bold text-white mb-4">Criar Novo Template</h3>
            <form action="" method="POST" class="space-y-4">
                <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                <input type="hidden" name="action" value="create">
                
                <div>
                    <label class="block text-xs font-mono text-gray-400 mb-2 uppercase tracking-wide">Tipo (identificador)</label>
                    <input type="text" name="new_type" required placeholder="ex: guest_welcome" class="w-full bg-black/40 border border-deep-border/50 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-neon-accent transition-colors font-mono text-sm">
                    <p class="text-xs text-gray-500 mt-1">Use snake_case: guest_welcome, purchase_confirmation, etc.</p>
                </div>
                
                <div>
                    <label class="block text-xs font-mono text-gray-400 mb-2 uppercase tracking-wide">Assunto do E-mail</label>
                    <input type="text" name="subject" required class="w-full bg-black/40 border border-deep-border/50 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-neon-accent transition-colors font-mono text-sm">
                </div>
                
                <div>
                    <label class="block text-xs font-mono text-gray-400 mb-2 uppercase tracking-wide">Corpo (HTML permitido)</label>
                    <textarea name="body_html" required rows="6" class="w-full bg-black/40 border border-deep-border/50 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-neon-accent transition-colors font-mono text-sm"></textarea>
                </div>
                
                <div class="flex gap-3">
                    <button type="submit" class="flex-1 py-2 bg-neon-accent text-black font-bold rounded-lg hover:bg-white transition-colors">
                        Criar Template
                    </button>
                    <button type="button" onclick="document.getElementById('newTemplateModal').classList.add('hidden')" class="px-4 py-2 bg-white/10 text-white rounded-lg hover:bg-white/20 transition-colors">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <?php if ($success): ?>
        <div class="bg-green-900/40 border border-green-500/50 text-green-300 px-4 py-3 rounded-xl font-mono text-sm">
            <?php echo $success; ?>
        </div>
    <?php
endif; ?>

    <?php if ($error): ?>
        <div class="bg-red-900/40 border border-red-500/50 text-red-300 px-4 py-3 rounded-xl font-mono text-sm">
            <?php echo $error; ?>
        </div>
    <?php
endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <?php foreach ($templates as $template): ?>
            <div class="bg-deep-surface border border-deep-border/50 rounded-2xl overflow-hidden shadow-2xl">
                
                <div class="bg-black/50 px-6 py-4 border-b border-deep-border/50 flex justify-between items-center">
                    <h3 class="font-bold text-lg font-mono text-gray-200 uppercase tracking-widest">
                        <?php echo $template['type'] === 'welcome' ? 'Boas-Vindas' : 'Redefinição de Senha'; ?>
                    </h3>
                    <span class="text-[10px] uppercase font-bold tracking-widest bg-white/10 text-white px-2 py-1 rounded">Template</span>
                </div>

                <div class="p-6">
                    <form action="" method="POST" class="space-y-5">
                        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                        <input type="hidden" name="type" value="<?php echo sanitize_output($template['type']); ?>">

                        <div>
                            <label class="block text-xs font-mono text-gray-400 mb-2 uppercase tracking-wide">Assunto do E-mail</label>
                            <input type="text" name="subject" value="<?php echo sanitize_output($template['subject']); ?>" required class="w-full bg-black/40 border border-deep-border/50 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-neon-accent transition-colors font-mono text-sm">
                        </div>

                        <div>
                            <div class="flex justify-between items-end mb-2">
                                <label class="block text-xs font-mono text-gray-400 uppercase tracking-wide">Corpo (HTML permitido)</label>
                                <span class="text-xs font-mono text-neon-accent opacity-70">
                                    <?php if ($template['type'] === 'welcome'): ?>
                                        Variáveis: {{nome}}, {{email}}
                                    <?php elseif ($template['type'] === 'guest_welcome'): ?>
                                        Variáveis: {{nome}}, {{email}}, {{senha}}, {{curso}}
                                    <?php elseif ($template['type'] === 'purchase_confirmation'): ?>
                                        Variáveis: {{nome}}, {{curso}}
                                    <?php
    else: ?>
                                        Variáveis: {{reset_link}}
                                    <?php
    endif; ?>
                                </span>
                            </div>
                            <textarea name="body_html" required rows="8" class="w-full bg-black/40 border border-deep-border/50 rounded-lg px-4 py-4 text-white focus:outline-none focus:border-neon-accent transition-colors font-mono text-sm leading-relaxed"><?php echo htmlspecialchars($template['body_html']); ?></textarea>
                        </div>

                        <button type="submit" class="w-full py-3 bg-white/5 border border-white/10 hover:border-white/30 text-white hover:text-white transition-colors rounded-xl font-bold text-sm tracking-wide">
                            Salvar Alterações
                        </button>
                    </form>
                </div>
            </div>
        <?php
endforeach; ?>
    </div>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>

<?php
// blog-single.php
require_once __DIR__ . '/includes/header.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    die("<div class='text-center py-32 text-white font-mono'>[ ERRO FATAL: MANUSCRITO NÃO ESPECIFICADO ]</div>");
}

$stmt = $pdo->prepare("SELECT b.*, a.name as author_name FROM blog_posts b LEFT JOIN admin_users a ON b.author_id = a.id WHERE b.id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch();

if (!$post) {
    die("<div class='text-center py-32 text-white font-mono'>[ ERRO FATAL: MANUSCRITO NÃO LOCALIZADO NO ARQUIVO ]</div>");
}

// Convert line breaks to paragraphs for basic rich text
$content_lines = explode("\n", strip_tags($post['content']));
$formatted_content = '';
foreach ($content_lines as $line) {
    $line = trim($line);
    if (!empty($line)) {
        $formatted_content .= "<p class='mb-6 font-serif italic text-xl md:text-2xl text-gray-300 leading-relaxed'>" . sanitize_output($line) . "</p>";
    }
}
?>

<article class="pt-40 pb-32">
    <!-- Post Header -->
    <header class="max-w-4xl mx-auto px-6 mb-16 text-center">
        <div class="mb-8 flex items-center justify-center gap-4 text-[10px] font-mono tracking-widest uppercase text-neon-accent">
            <span>ID: <?php echo str_pad($post['id'], 4, '0', STR_PAD_LEFT); ?></span>
            <span class="w-1 h-1 rounded-full bg-white/20"></span>
            <span><?php echo date('d M, Y', strtotime($post['created_at'])); ?></span>
            <span class="w-1 h-1 rounded-full bg-white/20"></span>
            <span>AUTOR: <?php echo sanitize_output($post['author_name'] ?? 'Coordenação'); ?></span>
        </div>
        
        <h1 class="text-[clamp(2.5rem,5vw,4.5rem)] leading-tight font-bold tracking-tighter mb-8 gsap-reveal">
            <?php echo sanitize_output($post['title']); ?>
        </h1>
        
        <div class="w-full h-px bg-gradient-to-r from-transparent via-white/20 to-transparent my-12"></div>
    </header>

    <!-- Post Content -->
    <div class="max-w-3xl mx-auto px-6 prose prose-invert prose-lg prose-p:leading-relaxed prose-p:font-serif prose-p:italic prose-a:text-[#00ffcc] gsap-reveal">
        <?php echo $formatted_content; ?>
    </div>
    
    <!-- Footer Link -->
    <div class="max-w-3xl mx-auto px-6 mt-20 pt-12 border-t border-white/10 text-center gsap-reveal">
        <a href="blog.php" class="inline-flex items-center gap-2 text-xs font-mono text-gray-400 hover:text-white transition-colors">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" class="transform rotate-180"><path d="M5 12h14M12 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            VOLTAR AO ARQUIVO
        </a>
    </div>
</article>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

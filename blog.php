<?php
// blog.php
require_once __DIR__ . '/includes/header.php';

// Fetch public posts
$stmt = $pdo->query("SELECT b.*, a.name as author_name FROM blog_posts b LEFT JOIN admin_users a ON b.author_id = a.id ORDER BY b.created_at DESC");
$posts = $stmt->fetchAll();
?>

<!-- HEADER BLOG -->
<section class="relative pt-40 pb-20 overflow-hidden bg-black">
    <div class="absolute inset-0 z-0 bg-hero-gradient opacity-80"></div>
    <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
        <span class="font-mono text-xs text-neon-accent tracking-widest uppercase mb-4 block">Knowledge Base</span>
        <h1 class="text-[clamp(3rem,6vw,5rem)] leading-none font-bold tracking-tighter mb-6 gsap-reveal">
            Arquivo <br><span class="text-transparent bg-clip-text bg-gradient-to-r from-neon-accent to-cobalt-accent font-serif italic">Teológico</span>
        </h1>
        <p class="text-gray-400 max-w-2xl mx-auto text-lg gsap-reveal">
            Artigos, reflexões e conteúdos profundos curados pela coordenação da CGADRB.
        </p>
    </div>
</section>

<!-- LISTA DE ARTIGOS -->
<section class="py-20 bg-deep-surface relative z-10 min-h-[50vh]">
    <div class="max-w-5xl mx-auto px-6 space-y-12">
        
        <?php if (empty($posts)): ?>
            <div class="text-center text-gray-500 py-20 font-mono text-sm border border-white/5 rounded-3xl bg-black">
                [ NENHUM ARTIGO PUBLICADO NO MOMENTO ]
            </div>
        <?php
else: ?>
            <?php foreach ($posts as $post): ?>
                <article class="group relative bg-[#0a0a0c] border border-white/5 p-8 md:p-12 rounded-[2rem] hover:border-white/20 transition-all duration-700 gsap-reveal">
                    
                    <div class="flex flex-col md:flex-row gap-8 items-start">
                        <!-- Metadados Esquerda -->
                        <div class="w-full md:w-1/4 flex-shrink-0 pt-2 border-t md:border-t-0 md:border-l border-neon-accent/30 md:pl-6">
                            <p class="font-mono text-xs text-gray-500 mb-2 uppercase"><?php echo date('d M, Y', strtotime($post['created_at'])); ?></p>
                            <p class="font-mono text-[10px] text-neon-accent tracking-widest uppercase mb-1">Por: <?php echo sanitize_output($post['author_name'] ?? 'Coordenação'); ?></p>
                            <p class="font-mono text-[10px] text-white/30 tracking-widest uppercase mt-4">ID: <?php echo str_pad($post['id'], 4, '0', STR_PAD_LEFT); ?></p>
                        </div>
                        
                        <!-- Conteúdo Direita -->
                        <div class="w-full md:w-3/4">
                            <h2 class="text-2xl md:text-3xl font-bold mb-6 font-serif italic tracking-wide group-hover:text-neon-accent transition-colors">
                                <a href="blog-single.php?id=<?php echo $post['id']; ?>" class="focus:outline-none">
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                    <?php echo sanitize_output($post['title']); ?>
                                </a>
                            </h2>
                            <p class="text-gray-400 leading-relaxed max-w-2xl line-clamp-3">
                                <?php echo sanitize_output(strip_tags($post['content'])); ?>
                            </p>
                            
                            <div class="mt-8 flex items-center text-xs font-mono text-white/50 group-hover:text-white transition-colors">
                                LER MANUSCRITO COMPLETO 
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" class="ml-2 transform group-hover:translate-x-2 transition-transform"><path d="M5 12h14M12 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                        </div>
                    </div>
                </article>
            <?php
    endforeach; ?>
        <?php
endif; ?>
        
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

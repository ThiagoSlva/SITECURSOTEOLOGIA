<?php
// cursos.php
require_once __DIR__ . '/includes/header.php';

// Fetch all active courses
$stmt = $pdo->query("SELECT * FROM courses WHERE status = 'active' ORDER BY id DESC");
$courses = $stmt->fetchAll();
?>

<!-- HEADER CURSOS -->
<section class="relative pt-40 pb-20 overflow-hidden bg-black">
    <div class="absolute inset-0 z-0 bg-hero-gradient opacity-80"></div>
    <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
        <span class="font-mono text-xs text-neon-accent tracking-widest uppercase mb-4 block">Store</span>
        <h1 class="text-[clamp(3rem,6vw,5rem)] leading-none font-bold tracking-tighter mb-6 gsap-reveal">
            Catálogo de <br><span class="text-transparent bg-clip-text bg-gradient-to-r from-neon-accent to-cobalt-accent font-serif italic">Cursos</span>
        </h1>
        <p class="text-gray-400 max-w-2xl mx-auto text-lg gsap-reveal">
            Formação teológica avançada. Selecione sua área de especialização e inicie sua jornada acadêmica com certificação CGADRB.
        </p>
    </div>
</section>

<!-- GRID DE CURSOS -->
<section class="py-20 bg-deep-surface relative z-10 min-h-[50vh]">
    <div class="max-w-7xl mx-auto px-6">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-stretch">
            
            <?php if (empty($courses)): ?>
               <div class="col-span-full text-center text-gray-500 py-20 font-mono text-sm border border-white/5 rounded-3xl bg-black">
                   [ NENHUM CURSO DISPONÍVEL NO MOMENTO ]
               </div>
            <?php
else: ?>
                <?php foreach ($courses as $index => $course): ?>
                    <div class="rounded-3xl border border-deep-border/50 bg-black/40 backdrop-blur-md p-8 hover:border-neon-accent/50 hover:bg-black transition-all duration-500 group flex flex-col h-full gsap-reveal">
                        
                        <?php if (!empty($course['image_url'])): ?>
                            <div class="h-48 -mx-8 -mt-8 mb-6 overflow-hidden rounded-t-3xl border-b border-white/10 relative">
                                <div class="absolute inset-0 bg-black/20 z-10 group-hover:bg-transparent transition-colors"></div>
                                <img src="<?php echo sanitize_output($course['image_url']); ?>" alt="Capa" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700">
                            </div>
                        <?php
        else: ?>
                            <div class="mb-4">
                                <span class="inline-block px-3 py-1 bg-white/5 text-gray-400 text-[10px] font-mono rounded-full tracking-widest uppercase">ID: <?php echo str_pad($course['id'], 3, '0', STR_PAD_LEFT); ?></span>
                            </div>
                        <?php
        endif; ?>

                        <h3 class="text-2xl font-bold mb-3 group-hover:text-[#00ffcc] transition-colors"><?php echo sanitize_output($course['title']); ?></h3>
                        <p class="text-gray-400 text-sm mb-6 leading-relaxed line-clamp-3"><?php echo sanitize_output($course['description']); ?></p>
                        
                        <div class="mb-8">
                            <span class="text-4xl font-light tracking-tighter">R$ <?php echo number_format($course['price'], 2, ',', '.'); ?></span>
                        </div>

                        <?php
        $features = json_decode($course['features_json'], true);
        if (is_array($features) && count($features) > 0):
?>
                        <div class="mb-10 flex-grow border-t border-white/5 pt-6">
                            <h4 class="text-xs font-mono text-gray-500 uppercase tracking-widest mb-4">Núcleo Curricular</h4>
                            <ul class="space-y-4 font-mono text-xs text-gray-300">
                                <?php foreach ($features as $feature): ?>
                                <li class="flex items-start gap-3">
                                    <span class="text-neon-accent mt-0.5">●</span>
                                    <span><?php echo sanitize_output($feature); ?></span>
                                </li>
                                <?php
            endforeach; ?>
                            </ul>
                        </div>
                        <?php
        else: ?>
                            <div class="flex-grow"></div>
                        <?php
        endif; ?>

                        <div class="pt-6 border-t border-white/5 mt-auto">
                            <a href="curso-single.php?slug=<?php echo sanitize_output($course['slug']); ?>" class="w-full py-4 flex items-center justify-between px-6 rounded-xl border border-white/20 text-sm font-semibold hover:bg-[#00ffcc] hover:text-black hover:border-[#00ffcc] transition-colors group/btn">
                                <span>Ver Detalhes do Curso</span>
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" class="group-hover/btn:translate-x-1 transition-transform"><path d="M5 12h14M12 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </a>
                        </div>
                    </div>
                <?php
    endforeach; ?>
            <?php
endif; ?>
            
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

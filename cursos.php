<?php
// cursos.php
require_once __DIR__ . '/includes/header.php';

// Fetch Categories that have at least one active course
$stmt = $pdo->query("
    SELECT DISTINCT cat.* 
    FROM categories cat
    INNER JOIN courses c ON c.category_id = cat.id
    WHERE c.status = 'active'
    ORDER BY cat.name ASC
");
$categories_list = $stmt->fetchAll();

// Fetch courses without categories
$stmt = $pdo->query("SELECT * FROM courses WHERE status = 'active' AND (category_id IS NULL OR category_id NOT IN (SELECT id FROM categories)) ORDER BY id DESC");
$uncategorized_courses = $stmt->fetchAll();

function render_course_card($course)
{
    ob_start();
?>
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
    return ob_get_clean();
}
?>

<!-- GRID DE CURSOS POR CATEGORIA -->
<section class="py-20 bg-deep-surface relative z-10 min-h-[50vh]">
    <div class="max-w-7xl mx-auto px-6">
        
        <?php if (empty($categories_list) && empty($uncategorized_courses)): ?>
            <div class="text-center text-gray-500 py-20 font-mono text-sm border border-white/5 rounded-3xl bg-black">
                [ NENHUM SINAL DE CURSO CARREGADO ]
            </div>
        <?php
else: ?>

            <?php foreach ($categories_list as $cat):
        $stmt = $pdo->prepare("SELECT * FROM courses WHERE category_id = ? AND status = 'active' ORDER BY id DESC");
        $stmt->execute([$cat['id']]);
        $cat_courses = $stmt->fetchAll();
        if (empty($cat_courses))
            continue;
?>
                <div class="mb-20">
                    <div class="flex items-center gap-4 mb-10">
                        <h2 class="text-3xl font-bold tracking-tighter"><?php echo sanitize_output($cat['name']); ?></h2>
                        <div class="h-[1px] flex-grow bg-white/5"></div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-stretch">
                        <?php foreach ($cat_courses as $course)
            echo render_course_card($course); ?>
                    </div>
                </div>
            <?php
    endforeach; ?>

            <?php if (!empty($uncategorized_courses)): ?>
                <div class="mb-20">
                    <div class="flex items-center gap-4 mb-10">
                        <h2 class="text-3xl font-bold tracking-tighter">Geral / Outros</h2>
                        <div class="h-[1px] flex-grow bg-white/5"></div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-stretch">
                        <?php foreach ($uncategorized_courses as $course)
            echo render_course_card($course); ?>
                    </div>
                </div>
            <?php
    endif; ?>

        <?php
endif; ?>
            
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

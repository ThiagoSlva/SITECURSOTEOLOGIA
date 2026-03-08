<?php
// curso-single.php
require_once __DIR__ . '/includes/header.php';

$slug = filter_input(INPUT_GET, 'slug', FILTER_SANITIZE_STRING);

if (!$slug) {
    header('Location: /cursos.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM courses WHERE slug = ? AND status = 'active'");
$stmt->execute([$slug]);
$course = $stmt->fetch();

if (!$course) {
    // Course not found
    echo '<div class="min-h-screen flex items-center justify-center bg-black text-white font-mono"><p>[ ERRO 404: CURSO NÃO ENCONTRADO ]</p></div>';
    require_once __DIR__ . '/includes/footer.php';
    exit;
}

$features = json_decode($course['features_json'], true) ?: [];
$hasImage = !empty($course['image_url']);

// Meta tags dinâmicas para SEO
$page_title = $course['title'] . ' - Instituto Teológico CGADRB';
$page_description = substr(strip_tags($course['description']), 0, 160);
$page_image = $course['image_url'] ?? '/assets/images/logotipo.jpeg';
$page_url = 'https://cgadrb.shopdix.com.br/curso-single.php?slug=' . $slug;
$page_type = 'course';
?>

<!-- Schema.org Course -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Course",
    "name": "<?php echo addslashes($course['title']); ?>",
    "description": "<?php echo addslashes(substr(strip_tags($course['description']), 0, 160)); ?>",
    "image": "<?php echo $course['image_url'] ?? ''; ?>",
    "provider": {
        "@type": "Organization",
        "name": "Instituto Teológico CGADRB",
        "url": "https://cgadrb.shopdix.com.br"
    },
    "offers": {
        "@type": "Offer",
        "price": "<?php echo $course['price']; ?>",
        "priceCurrency": "BRL",
        "availability": "https://schema.org/InStock"
    },
    "coursePrerequisites": "Ensino médio completo",
    "educationalLevel": "Extensão Universitária",
    "inLanguage": "pt-BR"
}
</script>

<!-- Course Header Hero -->
<section class="relative pt-40 pb-20 overflow-hidden bg-black border-b border-deep-border">
    <?php if ($hasImage): ?>
        <div class="absolute inset-0 z-0 opacity-30 bg-cover bg-center blend-luminosity gsap-parallax" style="background-image: url('<?php echo sanitize_output($course['image_url']); ?>');"></div>
    <?php
endif; ?>
    <div class="absolute inset-0 z-0 bg-hero-gradient <?php echo $hasImage ? 'opacity-90' : 'opacity-80'; ?>"></div>
    
    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="max-w-3xl">
            <a href="/cursos.php" class="inline-flex items-center gap-2 text-xs font-mono text-gray-500 hover:text-neon-accent transition-colors mb-8 group uppercase tracking-widest">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" class="group-hover:-translate-x-1 transition-transform"><path d="M19 12H5M5 12L12 19M5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Voltar para Cursos
            </a>

            <div class="mb-6 flex flex-wrap items-center gap-4">
                <span class="inline-block px-3 py-1 bg-white/10 text-white text-[10px] font-mono rounded-full tracking-widest uppercase border border-white/20">ID: <?php echo str_pad($course['id'], 3, '0', STR_PAD_LEFT); ?></span>
                <span class="inline-block px-3 py-1 text-neon-accent bg-neon-accent/10 border border-neon-accent/20 text-[10px] font-mono rounded-full tracking-widest uppercase flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-neon-accent animate-pulse"></span>
                    Matrículas Abertas
                </span>
            </div>

            <h1 class="text-[clamp(2.5rem,5vw,4.5rem)] leading-[1.1] font-bold tracking-tighter text-white mb-6 gsap-reveal">
                <?php echo sanitize_output($course['title']); ?>
            </h1>
            
            <p class="text-xl md:text-2xl text-gray-400 font-light leading-relaxed mb-10 gsap-reveal">
                Formação teológica avançada com certificação reconhecida.
            </p>

            <div class="flex flex-col sm:flex-row gap-6 items-start sm:items-center gsap-reveal">
                <div class="text-5xl font-light tracking-tighter text-white">
                    R$ <?php echo number_format($course['price'], 2, ',', '.'); ?>
                </div>
                <div class="hidden sm:block w-px h-12 bg-white/20"></div>
                <a href="checkout.php?curso=<?php echo $course['id']; ?>" class="px-8 py-4 bg-[#00ffcc] text-black font-semibold rounded-xl hover:bg-white transition-colors flex items-center justify-center gap-2 group w-full sm:w-auto">
                    Iniciar Admissão
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" class="group-hover:translate-x-1 transition-transform"><path d="M5 12h14M12 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Course Details & Content -->
<section class="py-24 bg-deep-surface relative z-10">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
            
            <!-- Main Content Area -->
            <div class="lg:col-span-8">
                <?php if ($hasImage): ?>
                    <div class="aspect-video w-full rounded-3xl overflow-hidden border border-white/10 shadow-2xl mb-16 relative group gsap-reveal bg-black">
                        <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition-colors z-10"></div>
                        <img src="<?php echo sanitize_output($course['image_url']); ?>" alt="<?php echo sanitize_output($course['title']); ?>" class="w-full h-full object-contain">
                    </div>
                <?php
endif; ?>

                <div class="prose prose-invert prose-lg prose-p:text-gray-400 prose-headings:text-white max-w-none gsap-reveal font-sans">
                    <h2 class="text-3xl font-bold tracking-tight mb-6">Sobre o Curso</h2>
                    <div class="bg-black/40 p-8 rounded-2xl border border-white/5 mb-12">
                        <p class="whitespace-pre-line leading-relaxed"><?php echo sanitize_output($course['description']); ?></p>
                    </div>

                    <?php if (!empty($features)): ?>
                        <h2 class="text-3xl font-bold tracking-tight mb-8">Núcleo Curricular</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <?php foreach ($features as $feature): ?>
                                <div class="bg-black border border-white/5 p-6 rounded-2xl flex items-start gap-4 hover:border-white/10 transition-colors">
                                    <div class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center flex-shrink-0 text-[#00ffcc]">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
                                    </div>
                                    <p class="font-mono text-sm text-gray-300 mt-1"><?php echo sanitize_output($feature); ?></p>
                                </div>
                            <?php
    endforeach; ?>
                        </div>
                    <?php
endif; ?>
                </div>
            </div>

            <!-- Sticky Sidebar -->
            <div class="lg:col-span-4">
                <div class="sticky top-32 bg-black border border-white/10 p-8 rounded-3xl shadow-xl gsap-reveal">
                    <h3 class="font-bold text-xl mb-6 flex items-center gap-3">
                        <span class="w-3 h-3 rounded-full bg-[#00ffcc]"></span> Resumo da Admissão
                    </h3>

                    <div class="space-y-6 mb-8">
                        <div class="flex items-center justify-between pb-4 border-b border-white/5">
                            <span class="text-gray-500 font-mono text-xs uppercase tracking-widest">Acesso</span>
                            <span class="text-gray-300 font-medium text-sm">Vitalício</span>
                        </div>
                        <div class="flex items-center justify-between pb-4 border-b border-white/5">
                            <span class="text-gray-500 font-mono text-xs uppercase tracking-widest">Certificado</span>
                            <span class="text-gray-300 font-medium text-sm">Incluso (MEC)</span>
                        </div>
                        <div class="flex items-center justify-between pb-4 border-b border-white/5">
                            <span class="text-gray-500 font-mono text-xs uppercase tracking-widest">Formato</span>
                            <span class="text-gray-300 font-medium text-sm">100% Online</span>
                        </div>
                        <div class="flex items-center justify-between pb-4 border-b border-white/5">
                            <span class="text-gray-500 font-mono text-xs uppercase tracking-widest">Investimento</span>
                            <span class="text-[#00ffcc] font-mono font-bold">R$ <?php echo number_format($course['price'], 2, ',', '.'); ?></span>
                        </div>
                    </div>

                    <a href="checkout.php?curso=<?php echo $course['id']; ?>" class="w-full py-4 text-center rounded-xl bg-white text-black font-bold hover:bg-gray-200 transition-colors block shadow-[0_0_30px_rgba(255,255,255,0.1)]">
                        Confirmar e Prosseguir
                    </a>
                    
                    <div class="mt-6 flex items-center justify-center gap-2 text-xs font-mono text-gray-500">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        Ambiente Seguro Criptografado
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

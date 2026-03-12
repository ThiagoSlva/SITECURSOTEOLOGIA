<?php
// index.php
$page_title = 'Instituto Teológico CGADRB - Cursos de Extensão Instituto CAT em Teologia';
$page_description = 'Cursos de extensão Instituto CAT em teologia com certificação reconhecida pelo MEC. Formação teológica de excelência combinando tradição cristã e rigor acadêmico contemporâneo.';
$page_type = 'website';

require_once __DIR__ . '/includes/header.php';
?>

<!-- Schema.org JSON-LD -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "Instituto Teológico CGADRB",
    "url": "https://cgadrb.shopdix.com.br",
    "logo": "https://cgadrb.shopdix.com.br/assets/images/logotipo.jpeg",
    "description": "Cursos de extensão Instituto CAT em teologia com certificação reconhecida. Formação teológica de excelência combinando tradição cristã e rigor acadêmico contemporâneo.",
    "sameAs": [
        "https://facebook.com/cgadrb",
        "https://instagram.com/cgadrb",
        "https://youtube.com/cgadrb"
    ],
    "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "+55-SEU-TELEFONE",
        "contactType": "customer service",
        "availableLanguage": "Portuguese"
    },
    "address": {
        "@type": "PostalAddress",
        "addressCountry": "BR",
        "addressRegion": "SP"
    }
}
</script>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "WebSite",
    "name": "Instituto Teológico CGADRB",
    "url": "https://cgadrb.shopdix.com.br",
    "potentialAction": {
        "@type": "SearchAction",
        "target": "https://cgadrb.shopdix.com.br/cursos.php?search={search_term_string}",
        "query-input": "required name=search_term_string"
    }
}
</script>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "EducationalOccupationalProgram",
    "name": "Cursos de Teologia",
    "description": "Cursos de extensão Instituto CAT em teologia com certificação reconhecida pelo MEC.",
    "provider": {
        "@type": "Organization",
        "name": "Instituto Teológico CGADRB",
        "url": "https://cgadrb.shopdix.com.br"
    }
}
</script>

<!-- SECTION B: O PLANO DE ABERTURA (HERO) -->
<section class="relative h-[100dvh] w-full flex items-end justify-start pb-20 overflow-hidden">
    <!-- Fundo Imagem Parallax -->
    <div class="absolute inset-0 z-0 bg-gradient-to-br from-black via-gray-900 to-black">
        <div class="absolute inset-0 bg-black/40"></div>
        <div class="absolute inset-0 bg-hero-gradient"></div>
    </div>

    <!-- Conteúdo Hero -->
    <div class="relative z-10 px-6 max-w-7xl mx-auto w-full">
        <div class="max-w-4xl pt-32">
            <img src="assets/images/brasao.jpeg" alt="Brasão CGADRB" class="w-24 md:w-32 h-auto mb-6 rounded-lg border border-white/5 shadow-2xl gsap-reveal">
            
            <p class="font-mono text-neon-accent text-sm tracking-[0.2em] mb-4 uppercase gsap-reveal">Instituto CAT</p>
            
            <h1 class="text-[clamp(2.5rem,7vw,6rem)] leading-[0.9] tracking-tighter text-white font-sans font-bold gsap-reveal">
                TEOLOGIA DE<br>
                <span class="font-serif italic font-normal text-[clamp(3.5rem,10vw,8rem)] text-gray-300">EXCELÊNCIA</span>
            </h1>
            
            <p class="mt-8 text-xl md:text-2xl text-gray-400 font-light max-w-2xl leading-relaxed gsap-reveal">
                Cursos de extensão Instituto CAT que combinam a tradição cristã com o rigor do design acadêmico contemporâneo.
            </p>

            <div class="mt-12 flex flex-col sm:flex-row items-start sm:items-center gap-6 gsap-reveal">
                <a href="#planos" class="px-8 py-4 bg-white text-black font-semibold rounded-full hover:bg-gray-200 transition-colors flex items-center gap-2">
                    Ver Cursos
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" class="animate-pulse">
                        <path d="M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <path d="M12 5L19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
                <span class="font-mono text-xs text-gray-500 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-neon-accent animate-pulse"></span>
                    MATRÍCULAS ABERTAS
                </span>
            </div>
        </div>
    </div>
</section>

<!-- SECTION C: ARTEFATOS FUNCIONAIS (FEATURES) -->
<section class="py-32 bg-deep-surface relative z-10 border-t border-deep-border">
    <div class="max-w-7xl mx-auto px-6">
        <div class="mb-20">
            <h2 class="text-[clamp(2rem,4vw,3.5rem)] font-bold tracking-tighter leading-tight gsap-reveal">
                Ferramentas de <span class="text-neon-accent">Capacitação</span>
            </h2>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- 1. Diagnostic Shuffler (Micro-UI) -->
            <div class="bg-deep-space p-8 rounded-3xl border border-deep-border/50 relative overflow-hidden group hover:border-neon-accent/30 transition-colors h-96 flex flex-col justify-end gsap-reveal">
                <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent z-10"></div>
                <!-- Shuffler Mock -->
                <div class="absolute top-8 left-8 right-8 z-0">
                    <div class="bg-gray-900/50 backdrop-blur-md p-4 rounded-xl border border-white/5 shadow-2xl transform translate-y-4 group-hover:-translate-y-2 transition-transform duration-500 select-none">
                        <p class="font-mono text-xs text-neon-accent">MÓDULO: HISTÓRIA CRISTÃ</p>
                        <div class="h-2 w-3/4 bg-gray-800 rounded mt-3"></div>
                        <div class="h-2 w-1/2 bg-gray-800 rounded mt-2"></div>
                    </div>
                     <div class="bg-gray-800/80 backdrop-blur-md p-4 rounded-xl border border-white/10 shadow-2xl transform -translate-y-4 group-hover:-translate-y-12 transition-transform duration-700 select-none">
                        <p class="font-mono text-xs text-white">RECONHECIMENTO MEC</p>
                        <div class="h-2 w-full bg-neon-accent/20 rounded mt-3"></div>
                        <div class="h-2 w-2/3 bg-gray-700 rounded mt-2"></div>
                    </div>
                </div>
                <div class="relative z-20">
                    <h3 class="text-2xl font-bold mb-2">Curadoria Acadêmica</h3>
                    <p class="text-gray-400 font-light">Módulos empilhados com precisão dogmática e histórica.</p>
                </div>
            </div>

            <!-- 2. Telemetry Typewriter -->
            <div class="bg-deep-space p-8 rounded-3xl border border-deep-border/50 relative overflow-hidden hover:border-cobalt-accent/30 transition-colors h-96 flex flex-col justify-end gsap-reveal">
                <div class="absolute inset-0 bg-black/60 z-10"></div>
                <div class="absolute top-8 left-8 right-8 z-0 font-mono text-[10px] text-cobalt-accent/60 leading-relaxed overflow-hidden">
                    <p class="animate-pulse">> INICIANDO COMUNICAÇÃO...</p>
                    <p>> CARREGANDO CERTIFICADO CGADRB [OK]</p>
                    <p>> ESTABELECENDO CONEXÃO SEGURA PARA CHECKOUT</p>
                    <p>> AGUARDANDO AÇÃO DO ESTUDANTE_</p>
                </div>
                <div class="relative z-20">
                    <h3 class="text-2xl font-bold mb-2">Processo Transparente</h3>
                    <p class="text-gray-400 font-light">Matrícula direta e automatizada com certificação validada.</p>
                </div>
            </div>

            <!-- 3. Protocol Scheduler -->
            <div class="bg-deep-space p-8 rounded-3xl border border-deep-border/50 relative overflow-hidden hover:border-white/20 transition-colors h-96 flex flex-col justify-end gsap-reveal">
                <div class="absolute top-8 left-8 right-8 z-0 grid grid-cols-4 gap-2 opacity-30 group-hover:opacity-60 transition-opacity">
                    <div class="h-8 bg-gray-800 rounded-md"></div>
                    <div class="h-8 bg-neon-accent/20 rounded-md border border-neon-accent/50"></div>
                    <div class="h-8 bg-gray-800 rounded-md"></div>
                    <div class="h-8 bg-gray-800 rounded-md"></div>
                    
                    <div class="h-8 bg-gray-800 rounded-md"></div>
                    <div class="h-8 bg-gray-800 rounded-md"></div>
                    <div class="h-8 bg-gray-800 rounded-md"></div>
                    <div class="h-8 bg-gray-800 rounded-md"></div>
                </div>
                <div class="relative z-20">
                    <h3 class="text-2xl font-bold mb-2">Flexibilidade Total</h3>
                    <p class="text-gray-400 font-light">Estude no seu ritmo, de qualquer lugar, com suporte integral.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SECTION D: PHILOSOPHY -->
<section class="py-32 bg-black relative border-y border-deep-border overflow-hidden flex items-center min-h-[70vh]">
    <div class="absolute inset-0 opacity-20 bg-[url('https://images.unsplash.com/photo-1601569482813-f66f91880f08?auto=format&fit=crop&q=80')] bg-cover bg-center blend-luminosity gsap-parallax"></div>
    <div class="max-w-5xl mx-auto px-6 relative z-10 text-center">
        <p class="text-xl md:text-3xl text-gray-500 font-light tracking-wide mb-8 gsap-reveal">A maioria foca em certificados vazios.</p>
        <p class="text-[clamp(2.5rem,6vw,5rem)] leading-tight text-white font-serif italic gsap-reveal">
            Nós focamos em <span class="text-transparent bg-clip-text bg-gradient-to-r from-neon-accent to-cobalt-accent">Transformação Ministerial Profunda</span>.
        </p>
    </div>
</section>

<!-- SECTION F: MEMBERSHIP PLANOS (MARKETPLACE) -->
<section id="planos" class="py-32 bg-deep-surface relative z-10">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-end mb-20 gap-8">
            <div>
                <span class="font-mono text-xs text-neon-accent tracking-widest uppercase mb-4 block">Store / Cursos</span>
                <h2 class="text-[clamp(3rem,5vw,4.5rem)] font-bold tracking-tighter leading-none gsap-reveal">
                    Cursos de<br>Formação
                </h2>
            </div>
            <a href="/cursos.php" class="text-sm font-mono hover:text-neon-accent transition-colors flex items-center gap-2 border-b border-white/20 pb-1">
                VER CATÁLOGO COMPLETO
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </a>
        </div>

        <?php
// Fetch 3 limited courses to display on the home screen
require_once __DIR__ . '/includes/db.php';
$stmt = $pdo->query("SELECT * FROM courses WHERE status = 'active' ORDER BY id DESC LIMIT 3");
$courses = $stmt->fetchAll();
?>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-center">
            
            <?php if (empty($courses)): ?>
               <div class="col-span-full text-center text-gray-500 py-20 font-mono">
                   [ NENHUM SINAL CARREGADO NO BANCO DE DADOS ]
               </div>
            <?php
else: ?>
                <?php foreach ($courses as $index => $course): ?>
                    <!-- Highlight the middle column (index 1) differently to 'pop' -->
                    <div class="rounded-3xl border <?php echo($index == 1) ? 'border-neon-accent/50 bg-black shadow-[0_0_50px_rgba(0,255,204,0.1)] scale-105 z-10' : 'border-deep-border/50 bg-deep-space bg-opacity-50 backdrop-blur-md'; ?> p-8 hover:border-white/20 transition-all duration-500 group flex flex-col h-full gsap-reveal">
                        
                        <?php if ($index == 1): ?>
                            <div class="inline-block px-3 py-1 bg-neon-accent text-black text-[10px] font-mono rounded-full mb-6 w-max">RECOMENDADO</div>
                        <?php
        endif; ?>

                        <?php if (!empty($course['image_url'])): ?>
                            <div class="h-48 -mx-8 -mt-8 mb-6 overflow-hidden rounded-t-3xl border-b border-white/10 relative bg-black">
                                <div class="absolute inset-0 bg-black/20 z-10 group-hover:bg-transparent transition-colors"></div>
                                <img src="<?php echo sanitize_output($course['image_url']); ?>" alt="Capa" class="w-full h-full object-contain transform group-hover:scale-105 transition-transform duration-700">
                            </div>
                        <?php
        endif; ?>

                        <h3 class="text-2xl font-bold mb-2"><?php echo sanitize_output($course['title']); ?></h3>
                        <p class="text-gray-400 text-sm mb-6 leading-relaxed line-clamp-2"><?php echo sanitize_output($course['description']); ?></p>
                        
                        <div class="mb-8">
                            <span class="text-4xl font-light tracking-tighter">R$ <?php echo number_format($course['price'], 2, ',', '.'); ?></span>
                        </div>

                        <?php
        $features = json_decode($course['features_json'], true);
        if (is_array($features) && count($features) > 0):
?>
                        <ul class="space-y-4 mb-10 flex-grow font-mono text-xs text-gray-300">
                            <?php foreach ($features as $feature): ?>
                            <li class="flex items-start gap-3">
                                <span class="text-neon-accent mt-0.5">●</span>
                                <?php echo sanitize_output($feature); ?>
                            </li>
                            <?php
            endforeach; ?>
                        </ul>
                        <?php
        else: ?>
                            <div class="flex-grow"></div>
                        <?php
        endif; ?>

                        <a href="curso-single.php?slug=<?php echo sanitize_output($course['slug']); ?>" class="w-full py-4 text-center rounded-xl text-sm font-semibold transition-colors <?php echo($index == 1) ? 'bg-neon-accent text-black hover:bg-white' : 'bg-white text-black hover:bg-gray-200'; ?>">
                            Ver Detalhes
                        </a>
                    </div>
                <?php
    endforeach; ?>
            <?php
endif; ?>
            
        </div>
    </div>
</section>

<!-- SECTION G: AMPARO LEGAL -->
<section class="py-16 bg-black border-t border-white/5 relative z-10">
    <div class="max-w-4xl mx-auto px-6 text-center">
        <div class="w-12 h-12 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-500">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M12 8v4M12 16h.01"/></svg>
        </div>
        <h3 class="text-lg font-bold text-white mb-4 uppercase tracking-widest font-mono">Amparo Legal & Credenciamento</h3>
        <p class="text-gray-400 text-sm leading-relaxed font-light">
            Os cursos oferecidos por nossa instituição são classificados como "Cursos Livres de Formação e Qualificação Profissional/Eclesiástica". 
            Eles são válidos em todo o território nacional e estão amparados pela <strong class="text-white">Lei nº 9.394/96 (Lei de Diretrizes e Bases da Educação Nacional)</strong>, 
            pelo <strong class="text-white">Decreto Presidencial nº 5.154/04</strong> e deliberações do <strong class="text-white">CEE 14/97 (Indicação CEE 14/97)</strong>.
        </p>
        <p class="text-gray-500 text-xs leading-relaxed font-mono mt-4">
            Em conformidade com a legislação educacional brasileira, cursos livres de atualização e qualificação profissional não dependem de autorização, reconhecimento ou aprovação do Ministério da Educação (MEC) ou do Conselho Estadual de Educação (CEE). O objetivo primordial é proporcionar o desenvolvimento de novas competências, capacitação teológica e aprimoramento contínuo.
        </p>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

<?php
// index.php
require_once __DIR__ . '/includes/header.php';
?>

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
            <p class="font-mono text-neon-accent text-sm tracking-[0.2em] mb-4 uppercase gsap-reveal">Sistema de Formação Acadêmica v1.0</p>
            
            <h1 class="text-[clamp(2.5rem,7vw,6rem)] leading-[0.9] tracking-tighter text-white font-sans font-bold gsap-reveal">
                TEOLOGIA DE<br>
                <span class="font-serif italic font-normal text-[clamp(3.5rem,10vw,8rem)] text-gray-300">EXCELÊNCIA</span>
            </h1>
            
            <p class="mt-8 text-xl md:text-2xl text-gray-400 font-light max-w-2xl leading-relaxed gsap-reveal">
                Cursos de extensão universitária que combinam a tradição cristã com o rigor do design acadêmico contemporâneo.
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

                        <h3 class="text-2xl font-bold mb-2"><?php echo sanitize_output($course['title']); ?></h3>
                        <p class="text-gray-400 text-sm mb-8 leading-relaxed line-clamp-2"><?php echo sanitize_output($course['description']); ?></p>
                        
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

                        <a href="checkout.php?curso=<?php echo $course['id']; ?>" class="w-full py-4 text-center rounded-xl text-sm font-semibold transition-colors <?php echo($index == 1) ? 'bg-neon-accent text-black hover:bg-white' : 'bg-white text-black hover:bg-gray-200'; ?>">
                            Iniciar Check-out Externo
                        </a>
                    </div>
                <?php
    endforeach; ?>
            <?php
endif; ?>
            
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

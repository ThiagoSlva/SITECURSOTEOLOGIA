    </main>
    
    <footer class="bg-[#050505] pt-24 pb-12 rounded-t-[4rem] border-t border-deep-border mt-32 relative z-10 overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-12">
            <div>
                <a href="/" class="block mb-6">
                    <img src="/assets/images/logotipo.jpeg" alt="CGADRB" class="h-14 w-auto rounded-2xl object-contain shadow-lg border border-white/10">
                </a>
                <p class="text-gray-400 text-sm max-w-sm mb-6 font-mono">
                    Formação teológica de excelência com certificação reconhecida. Combinando tradição cristã e rigor acadêmico.
                </p>
                <!-- Status do Sistema -->
                <div class="flex items-center gap-3">
                    <span class="relative flex h-3 w-3">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-neon-accent opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-3 w-3 bg-neon-accent"></span>
                    </span>
                    <span class="text-xs font-mono text-gray-500 uppercase tracking-widest">SISTEMA ONLINE V1.0</span>
                </div>
            </div>
            
            <div class="md:col-start-3">
                <h4 class="text-white font-bold mb-6 font-mono text-sm tracking-widest uppercase">Links Rápidos</h4>
                <ul class="space-y-4">
                    <li><a href="/cursos.php" class="text-gray-400 hover:text-neon-accent transition-colors text-sm font-medium">Todos os Cursos</a></li>
                    <li><a href="/blog.php" class="text-gray-400 hover:text-neon-accent transition-colors text-sm font-medium">Artigos Teológicos</a></li>
                    <li><a href="/admin/login.php" class="text-gray-400 hover:text-neon-accent transition-colors text-sm font-medium">Acesso Restrito</a></li>
                </ul>
            </div>
        </div>
        
        <div class="max-w-7xl mx-auto px-6 mt-24 pt-8 border-t border-deep-border/50 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-gray-600 font-mono text-xs">© <?php echo date('Y'); ?> Instituto Teológico CGADRB. Todos os direitos reservados.</p>
        </div>
    </footer>

    <!-- GSAP / ScrollTrigger / Lenis Smooth Scroll -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script src="https://unpkg.com/lenis@1.1.9/dist/lenis.min.js"></script>

    <!-- Custom Animation Logic -->
    <script src="/assets/js/animations.js"></script>

</body>
</html>

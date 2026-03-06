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
    
    <?php
// Fetch settings for WhatsApp number
$stmt_ws = $pdo->query("SELECT whatsapp_number FROM settings WHERE id = 1");
$settings_ws = $stmt_ws->fetch();
$ws_number = $settings_ws['whatsapp_number'] ?? '';
if (!empty($ws_number)):
?>
    <!-- Floating WhatsApp Button -->
    <a href="https://api.whatsapp.com/send?phone=<?php echo sanitize_output($ws_number); ?>" 
       target="_blank" 
       id="whatsapp-btn"
       class="fixed bottom-8 right-8 z-50 flex items-center justify-center w-16 h-16 bg-[#25D366] rounded-full shadow-[0_0_30px_rgba(37,211,102,0.3)] hover:scale-110 transition-transform duration-300 group opacity-0 translate-y-10"
       title="Fale conosco no WhatsApp">
        <svg width="32" height="32" viewBox="0 0 24 24" fill="white">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.937 3.659 1.432 5.631 1.433h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
        </svg>
    </a>
    <?php
endif; ?>

    <!-- GSAP / ScrollTrigger / Lenis Smooth Scroll -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script src="https://unpkg.com/lenis@1.1.9/dist/lenis.min.js"></script>

    <!-- Custom Animation Logic -->
    <script src="/assets/js/animations.js"></script>

</body>
</html>

    </main>
    
    <footer class="bg-[#050505] pt-24 pb-12 rounded-t-[4rem] border-t border-deep-border mt-32 relative z-10 overflow-hidden">
        <?php
// Fetch all settings safely
$stmt_settings = $pdo->query("SELECT * FROM settings WHERE id = 1");
$site_settings = $stmt_settings->fetch();
?>
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-12">
            <div class="md:col-span-2">
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
                    <a href="https://clouddix.com.br" target="_blank" rel="noopener noreferrer" class="text-xs font-mono text-gray-500 uppercase tracking-widest hover:text-neon-accent transition-colors">Sistema desenvolvido por clouddix.com.br</a>
                </div>
            </div>
            
            <div>
                <h4 class="text-white font-bold mb-6 font-mono text-sm tracking-widest uppercase">Links Rápidos</h4>
                <ul class="space-y-4">
                    <li><a href="/cursos.php" class="text-gray-400 hover:text-neon-accent transition-colors text-sm font-medium">Todos os Cursos</a></li>
                    <li><a href="/blog.php" class="text-gray-400 hover:text-neon-accent transition-colors text-sm font-medium">Artigos Teológicos</a></li>
                    <li><a href="/admin/login.php" class="text-gray-400 hover:text-neon-accent transition-colors text-sm font-medium">Acesso Restrito</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-bold mb-6 font-mono text-sm tracking-widest uppercase">Redes Sociais</h4>
                <div class="flex flex-wrap gap-3">
                    <?php if (!empty($site_settings['social_facebook'])): ?>
                        <a href="<?php echo sanitize_output($site_settings['social_facebook']); ?>" target="_blank" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center hover:bg-neon-accent hover:text-black transition-colors text-white" title="Facebook">
                            <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                    <?php
endif; ?>
                    <?php if (!empty($site_settings['social_instagram'])): ?>
                        <a href="<?php echo sanitize_output($site_settings['social_instagram']); ?>" target="_blank" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center hover:bg-neon-accent hover:text-black transition-colors text-white" title="Instagram">
                            <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        </a>
                    <?php
endif; ?>
                    <?php if (!empty($site_settings['social_twitter'])): ?>
                        <a href="<?php echo sanitize_output($site_settings['social_twitter']); ?>" target="_blank" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center hover:bg-neon-accent hover:text-black transition-colors text-white" title="X (Twitter)">
                            <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                    <?php
endif; ?>
                    <?php if (!empty($site_settings['social_threads'])): ?>
                        <a href="<?php echo sanitize_output($site_settings['social_threads']); ?>" target="_blank" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center hover:bg-neon-accent hover:text-black transition-colors text-white" title="Threads">
                            <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M14.6 10.55c-.24-.76-.78-1.57-1.58-2.02a4.4 4.4 0 00-3.05-.28 4.63 4.63 0 00-2.82 2.3A5.4 5.4 0 006.5 13.9a5.13 5.13 0 001.35 3.32c.98.99 2.18 1.4 3.73 1.25a4.7 4.7 0 003.58-1.93l1.1 1.04a5.83 5.83 0 01-4.75 2.47c-2.43 0-4.14-1-5.2-2.3-1.07-1.3-1.46-3.2-1.46-5.4 0-2.18.52-4.04 1.55-5.32C7.43 5.75 9.1 5 11.66 5c1.86 0 3.37.56 4.38 1.63 1 .98 1.56 2.5 1.6 4.41h-6.81a3.03 3.03 0 001.2 2.53 3.37 3.37 0 002.37.7 3.1 3.1 0 002.33-.94l.87.89a4.2 4.2 0 01-3.25 1.41 4.26 4.26 0 01-3.21-1.12c-.52-.51-.83-1.17-1.03-1.92l5.5.02c.03-1.04 0-1.87-.22-2.38l-.79.33zM10.8 7.37c-.7 0-1.28.31-1.68.82-.44.57-.68 1.44-.71 2.4l4.58.01a3.67 3.67 0 00-.73-2.22c-.37-.53-.89-.9-1.46-1.01z"/><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18.5c-4.69 0-8.5-3.81-8.5-8.5S7.31 3.5 12 3.5 20.5 7.31 20.5 12s-3.81 8.5-8.5 8.5z"/></svg>
                        </a>
                    <?php
endif; ?>
                    <?php if (!empty($site_settings['social_linkedin'])): ?>
                        <a href="<?php echo sanitize_output($site_settings['social_linkedin']); ?>" target="_blank" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center hover:bg-neon-accent hover:text-black transition-colors text-white" title="LinkedIn">
                            <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        </a>
                    <?php
endif; ?>
                    <?php if (!empty($site_settings['social_tiktok'])): ?>
                        <a href="<?php echo sanitize_output($site_settings['social_tiktok']); ?>" target="_blank" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center hover:bg-neon-accent hover:text-black transition-colors text-white" title="TikTok">
                            <svg width="18" height="18" fill="currentColor" viewBox="0 0 448 512"><path d="M448 209.9a210.1 210.1 0 01-122.8-39.3V349.4A162.6 162.6 0 11150.8 219.1v89.4a73.3 73.3 0 1060.2 72.1V0h88c0 47.9 33.1 87.2 81 101.4v108.5z"/></svg>
                        </a>
                    <?php
endif; ?>
                </div>
            </div>
        </div>
        
        <div class="max-w-7xl mx-auto px-6 mt-24 pt-8 border-t border-deep-border/50 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-gray-600 font-mono text-xs">© <?php echo date('Y'); ?> Instituto Teológico CGADRB. Todos os direitos reservados.</p>
        </div>
    </footer>
    
    <?php
$ws_number = $site_settings['whatsapp_number'] ?? '';
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

<?php
// politica-privacidade.php
require_once __DIR__ . '/includes/db.php';

$page_title = 'Política de Privacidade - Instituto Teológico CGADRB';
$page_description = 'Política de Privacidade do Instituto Teológico CGADRB.Saiba como protegemos seus dados pessoais em conformidade com a LGPD.';
$page_type = 'article';

$stmt_settings = $pdo->query("SELECT whatsapp_number FROM settings WHERE id = 1");
$site_settings = $stmt_settings->fetch();

require_once __DIR__ . '/includes/header.php';
?>

<!-- Schema.org JSON-LD -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "WebPage",
    "name": "Política de Privacidade",
    "description": "Política de Privacidade do Instituto Teológico CGADRB",
    "publisher": {
        "@type": "Organization",
        "name": "Instituto Teológico CGADRB"
    }
}
</script>

<!-- Page Header -->
<section class="relative pt-32 pb-16 bg-black">
    <div class="absolute inset-0 bg-gradient-to-b from-deep-bg/50 to-black"></div>
    <div class="relative z-10 max-w-4xl mx-auto px-6 text-center">
        <p class="font-mono text-neon-accent text-sm tracking-[0.2em] mb-4 uppercase">LGPD</p>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white tracking-tight gsap-reveal">
            Política de <span class="text-neon-accent">Privacidade</span>
        </h1>
        <p class="text-gray-400 mt-6 text-lg max-w-2xl mx-auto gsap-reveal">
            Know how we protect and process your personal data in accordance with LGPD.
        </p>
    </div>
</section>

<!-- Content -->
<section class="relative py-20 bg-black">
    <div class="max-w-4xl mx-auto px-6">
        
        <!-- Introduction Card -->
        <div class="bg-white/5 border border-white/10 rounded-3xl p-8 md:p-12 mb-12 gsap-reveal">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-2xl bg-neon-accent/20 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-neon-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-white mb-4">Nossa Compromisso com sua Privacidade</h2>
                    <p class="text-gray-300 leading-relaxed">
                        O <strong>Instituto Teológico CGADRB</strong> está comprometido em proteger a privacidade e os dados pessoais de nossos alunos, visitantes e parceiros. Esta Política de Privacidade descreve como coletamos, usamos, armazenamos e protegemos suas informações pessoais em conformidade com a <strong>Lei Geral de Proteção de Dados (LGPD - Lei nº 13.709/2018)</strong>.
                    </p>
                </div>
            </div>
        </div>

        <!-- Table of Contents -->
        <div class="bg-white/5 border border-white/10 rounded-3xl p-8 mb-12 gsap-reveal">
            <h3 class="text-xl font-bold text-white mb-6">Índice</h3>
            <nav class="space-y-3">
                <a href="#section-1" class="flex items-center gap-3 text-gray-400 hover:text-neon-accent transition-colors">
                    <span class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-sm font-mono">01</span>
                    <span>Dados que Coletamos</span>
                </a>
                <a href="#section-2" class="flex items-center gap-3 text-gray-400 hover:text-neon-accent transition-colors">
                    <span class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-sm font-mono">02</span>
                    <span>Como Utilizamos seus Dados</span>
                </a>
                <a href="#section-3" class="flex items-center gap-3 text-gray-400 hover:text-neon-accent transition-colors">
                    <span class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-sm font-mono">03</span>
                    <span>Compartilhamento de Dados</span>
                </a>
                <a href="#section-4" class="flex items-center gap-3 text-gray-400 hover:text-neon-accent transition-colors">
                    <span class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-sm font-mono">04</span>
                    <span>Cookies e Tecnologias de Rastreamento</span>
                </a>
                <a href="#section-5" class="flex items-center gap-3 text-gray-400 hover:text-neon-accent transition-colors">
                    <span class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-sm font-mono">05</span>
                    <span>Segurança dos Dados</span>
                </a>
                <a href="#section-6" class="flex items-center gap-3 text-gray-400 hover:text-neon-accent transition-colors">
                    <span class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-sm font-mono">06</span>
                    <span>Seus Direitos (LGPD)</span>
                </a>
                <a href="#section-7" class="flex items-center gap-3 text-gray-400 hover:text-neon-accent transition-colors">
                    <span class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-sm font-mono">07</span>
                    <span>Retenção de Dados</span>
                </a>
                <a href="#section-8" class="flex items-center gap-3 text-gray-400 hover:text-neon-accent transition-colors">
                    <span class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-sm font-mono">08</span>
                    <span>Alterações nesta Política</span>
                </a>
            </nav>
        </div>

        <!-- Section 1: Dados que Coletamos -->
        <div id="section-1" class="scroll-mt-32 mb-16 gsap-reveal">
            <div class="flex items-center gap-4 mb-8">
                <span class="w-12 h-12 rounded-2xl bg-neon-accent/20 flex items-center justify-center font-mono text-neon-accent font-bold">01</span>
                <h2 class="text-3xl font-bold text-white">Dados que Coletamos</h2>
            </div>
            
            <div class="space-y-6">
                <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
                    <h3 class="text-xl font-semibold text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-neon-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Dados de Identificação Pessoal
                    </h3>
                    <ul class="space-y-3 text-gray-300">
                        <li class="flex items-start gap-3">
                            <span class="text-neon-accent mt-1">•</span>
                            <span><strong>Nome completo</strong> - Necessário para emissão de certificados e identificação acadêmica</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-neon-accent mt-1">•</span>
                            <span><strong>Endereço de e-mail</strong> - Para comunicações, acesso ao portal do aluno e recuperação de senha</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-neon-accent mt-1">•</span>
                            <span><strong>CPF</strong> - Obrigatório para emissão de notas fiscais e comprovação de identidade</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-neon-accent mt-1">•</span>
                            <span><strong>Telefone/WhatsApp</strong> - Para comunicações sobre cursos e suporte</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-neon-accent mt-1">•</span>
                            <span><strong>Endereço</strong> - Para emissão de documentos fiscais quando necessário</span>
                        </li>
                    </ul>
                </div>

                <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
                    <h3 class="text-xl font-semibold text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-neon-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Dados de Navegação
                    </h3>
                    <ul class="space-y-3 text-gray-300">
                        <li class="flex items-start gap-3">
                            <span class="text-neon-accent mt-1">•</span>
                            <span><strong>Endereço IP</strong> - Para segurança e análise de acesso</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-neon-accent mt-1">•</span>
                            <span><strong>Tipo de navegador e dispositivo</strong> - Para otimização da experiência</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-neon-accent mt-1">•</span>
                            <span><strong>Páginas visitadas</strong> - Para melhoria dos serviços</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-neon-accent mt-1">•</span>
                            <span><strong>Data e horário de acesso</strong> - Para análise de tráfego</span>
                        </li>
                    </ul>
                </div>

                <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
                    <h3 class="text-xl font-semibold text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-neon-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        Dados Acadêmicos
                    </h3>
                    <ul class="space-y-3 text-gray-300">
                        <li class="flex items-start gap-3">
                            <span class="text-neon-accent mt-1">•</span>
                            <span><strong>Cursos contratados</strong> - Para prestação do serviço educacional</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-neon-accent mt-1">•</span>
                            <span><strong>Progresso nos cursos</strong> - Para acompanhamento pedagógico</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-neon-accent mt-1">•</span>
                            <span><strong>Certificados emitidos</strong> - Para registro e verificação de autenticidade</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Section 2: Como Utilizamos -->
        <div id="section-2" class="scroll-mt-32 mb-16 gsap-reveal">
            <div class="flex items-center gap-4 mb-8">
                <span class="w-12 h-12 rounded-2xl bg-neon-accent/20 flex items-center justify-center font-mono text-neon-accent font-bold">02</span>
                <h2 class="text-3xl font-bold text-white">Como Utilizamos seus Dados</h2>
            </div>
            
            <div class="grid md:grid-cols-2 gap-6">
                <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
                    <div class="w-10 h-10 rounded-xl bg-neon-accent/20 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-neon-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">Comunicações</h3>
                    <p class="text-gray-400 text-sm">Envio de informações sobre cursos, atualizações, notificações importantes e suporte ao aluno.</p>
                </div>

                <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
                    <div class="w-10 h-10 rounded-xl bg-neon-accent/20 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-neon-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">Prestação de Serviços</h3>
                    <p class="text-gray-400 text-sm">Matrícula, acesso ao conteúdo dos cursos, emissão de certificados e notas fiscais.</p>
                </div>

                <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
                    <div class="w-10 h-10 rounded-xl bg-neon-accent/20 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-neon-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">Análise de Dados</h3>
                    <p class="text-gray-400 text-sm">Melhoria dos serviços, análise de tráfego e experiência do usuário no site.</p>
                </div>

                <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
                    <div class="w-10 h-10 rounded-xl bg-neon-accent/20 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-neon-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">Segurança</h3>
                    <p class="text-gray-400 text-sm">Proteção contra fraudes, verificação de identidade e prevenção de acessos não autorizados.</p>
                </div>
            </div>
        </div>

        <!-- Section 3: Compartilhamento -->
        <div id="section-3" class="scroll-mt-32 mb-16 gsap-reveal">
            <div class="flex items-center gap-4 mb-8">
                <span class="w-12 h-12 rounded-2xl bg-neon-accent/20 flex items-center justify-center font-mono text-neon-accent font-bold">03</span>
                <h2 class="text-3xl font-bold text-white">Compartilhamento de Dados</h2>
            </div>
            
            <div class="bg-white/5 border border-white/10 rounded-2xl p-6 mb-6">
                <p class="text-gray-300 leading-relaxed mb-4">
                    <strong>Não vendemos seus dados pessoais.</strong> Compartilhamos suas informações apenas nas situações necessárias para a prestação dos serviços, conforme detallado abaixo:
                </p>
            </div>

            <div class="space-y-4">
                <div class="flex items-start gap-4 bg-white/5 border border-white/10 rounded-2xl p-6">
                    <div class="w-10 h-10 rounded-xl bg-red-500/20 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-white mb-2">Processadores de Pagamento</h3>
                        <p class="text-gray-400 text-sm">Compartilhamos dados necessários (nome, CPF, valor) com processadoras de pagamento (Asaas, Mercado Pago, etc.) para processamento de mensalidades. Estes dados são utilizados exclusivamente para transação financeira.</p>
                    </div>
                </div>

                <div class="flex items-start gap-4 bg-white/5 border border-white/10 rounded-2xl p-6">
                    <div class="w-10 h-10 rounded-xl bg-yellow-500/20 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-white mb-2">Obrigações Legais</h3>
                        <p class="text-gray-400 text-sm">Podemos compartilhar dados quando exigido por lei, ordem judicial, ou para cumprir obrigações regulatórias (ex: Receita Federal para emissão de notas fiscais).</p>
                    </div>
                </div>

                <div class="flex items-start gap-4 bg-white/5 border border-white/10 rounded-2xl p-6">
                    <div class="w-10 h-10 rounded-xl bg-blue-500/20 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-white mb-2">Instituições de Ensino</h3>
                        <p class="text-gray-400 text-sm">Para cursos em parceria com instituições de ensino superior, compartilhamos dados de conclusão para emissão de certificados conjuntamente.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 4: Cookies -->
        <div id="section-4" class="scroll-mt-32 mb-16 gsap-reveal">
            <div class="flex items-center gap-4 mb-8">
                <span class="w-12 h-12 rounded-2xl bg-neon-accent/20 flex items-center justify-center font-mono text-neon-accent font-bold">04</span>
                <h2 class="text-3xl font-bold text-white">Cookies e Tecnologias de Rastreamento</h2>
            </div>
            
            <div class="bg-white/5 border border-white/10 rounded-2xl p-6 mb-6">
                <p class="text-gray-300 leading-relaxed">
                    Utilizamos <strong>cookies</strong> para melhorar sua experiência de navegação, remembering suas preferências e analyzing o uso do site. Cookies são pequenos arquivos de texto armazenados no seu navegador.
                </p>
            </div>

            <div class="space-y-4">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-white/10">
                                <th class="pb-4 text-white font-semibold">Tipo de Cookie</th>
                                <th class="pb-4 text-white font-semibold">Finalidade</th>
                                <th class="pb-4 text-white font-semibold">Duração</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-400 text-sm">
                            <tr class="border-b border-white/5">
                                <td class="py-4 text-neon-accent font-mono">Essenciais</td>
                                <td class="py-4">Funcionamento do site, login, segurança</td>
                                <td class="py-4">Sessão</td>
                            </tr>
                            <tr class="border-b border-white/5">
                                <td class="py-4 text-neon-accent font-mono">Funcionamento</td>
                                <td class="py-4">Preferências de idioma, tema visual</td>
                                <td class="py-4">1 ano</td>
                            </tr>
                            <tr class="border-b border-white/5">
                                <td class="py-4 text-neon-accent font-mono">Analytics</td>
                                <td class="py-4">Análise de acesso e melhoria do site</td>
                                <td class="py-4">2 anos</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6 bg-yellow-500/10 border border-yellow-500/30 rounded-2xl p-6">
                <div class="flex items-start gap-4">
                    <svg class="w-6 h-6 text-yellow-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <div>
                        <h4 class="text-yellow-400 font-semibold mb-2">Importante</h4>
                        <p class="text-gray-400 text-sm">Você pode gestionar ou desativar os cookies através das configurações do seu navegador. Note que algumas funcionalidades do site podem não funcionar corretamente sem cookies.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 5: Segurança -->
        <div id="section-5" class="scroll-mt-32 mb-16 gsap-reveal">
            <div class="flex items-center gap-4 mb-8">
                <span class="w-12 h-12 rounded-2xl bg-neon-accent/20 flex items-center justify-center font-mono text-neon-accent font-bold">05</span>
                <h2 class="text-3xl font-bold text-white">Segurança dos Dados</h2>
            </div>
            
            <div class="bg-white/5 border border-white/10 rounded-2xl p-8">
                <p class="text-gray-300 leading-relaxed mb-8">
                    Implementamos medidas técnicas e organizacionais adequadas para proteger seus dados pessoais contra acesso não autorizado, alteração, divulgação ou destruição. Our security measures include:
                </p>

                <div class="grid md:grid-cols-2 gap-6">
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 rounded-lg bg-green-500/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-white font-medium">Criptografia SSL/TLS</h4>
                            <p class="text-gray-500 text-sm">Todos os dados transmitidos são criptografados</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 rounded-lg bg-green-500/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-white font-medium">Hash de Senhas</h4>
                            <p class="text-gray-500 text-sm">Senhas armazenadas com bcrypt</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 rounded-lg bg-green-500/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-white font-medium">Prepared Statements</h4>
                            <p class="text-gray-500 text-sm">Proteção contra SQL Injection</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 rounded-lg bg-green-500/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-white font-medium">CSRF Protection</h4>
                            <p class="text-gray-500 text-sm">Tokens de segurança em formulários</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 rounded-lg bg-green-500/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-white font-medium">Acesso Restrito</h4>
                            <p class="text-gray-500 text-sm">Apenas pessoal autorizado acessa dados</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 rounded-lg bg-green-500/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-white font-medium">Backups Criptografados</h4>
                            <p class="text-gray-500 text-sm">Cópias de segurança protegidas</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 6: Seus Direitos -->
        <div id="section-6" class="scroll-mt-32 mb-16 gsap-reveal">
            <div class="flex items-center gap-4 mb-8">
                <span class="w-12 h-12 rounded-2xl bg-neon-accent/20 flex items-center justify-center font-mono text-neon-accent font-bold">06</span>
                <h2 class="text-3xl font-bold text-white">Seus Direitos (LGPD)</h2>
            </div>
            
            <p class="text-gray-300 leading-relaxed mb-8">
                De acordo com a LGPD, você possui os seguintes direitos sobre seus dados pessoais:
            </p>

            <div class="grid md:grid-cols-2 gap-6">
                <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
                    <div class="w-10 h-10 rounded-xl bg-neon-accent/20 flex items-center justify-center mb-4">
                        <span class="text-neon-accent font-bold">1</span>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">Confirmação e Acesso</h3>
                    <p class="text-gray-400 text-sm">Direito de confirmar que tratamos seus dados e obter uma cópia</p>
                </div>

                <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
                    <div class="w-10 h-10 rounded-xl bg-neon-accent/20 flex items-center justify-center mb-4">
                        <span class="text-neon-accent font-bold">2</span>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">Correção</h3>
                    <p class="text-gray-400 text-sm">Direito de solicitar correção de dados incompletos ou incorretos</p>
                </div>

                <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
                    <div class="w-10 h-10 rounded-xl bg-neon-accent/20 flex items-center justify-center mb-4">
                        <span class="text-neon-accent font-bold">3</span>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">Anonimização</h3>
                    <p class="text-gray-400 text-sm">Direito de solicitar anonimização de dados não necessários</p>
                </div>

                <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
                    <div class="w-10 h-10 rounded-xl bg-neon-accent/20 flex items-center justify-center mb-4">
                        <span class="text-neon-accent font-bold">4</span>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">Eliminação</h3>
                    <p class="text-gray-400 text-sm">Direito de solicitar exclusão de dados pessoais (com exceções legais)</p>
                </div>

                <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
                    <div class="w-10 h-10 rounded-xl bg-neon-accent/20 flex items-center justify-center mb-4">
                        <span class="text-neon-accent font-bold">5</span>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">Portabilidade</h3>
                    <p class="text-gray-400 text-sm">Direito de receber seus dados em formato legível por máquina</p>
                </div>

                <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
                    <div class="w-10 h-10 rounded-xl bg-neon-accent/20 flex items-center justify-center mb-4">
                        <span class="text-neon-accent font-bold">6</span>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">Informação</h3>
                    <p class="text-gray-400 text-sm">Direito de saber com quem compartilhamos seus dados</p>
                </div>
            </div>

            <div class="mt-8 bg-neon-accent/10 border border-neon-accent/30 rounded-2xl p-6">
                <div class="flex items-start gap-4">
                    <svg class="w-6 h-6 text-neon-accent flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <div>
                        <h4 class="text-white font-semibold mb-2">Como Exercitar seus Direitos</h4>
                        <p class="text-gray-400 text-sm">Para exercer qualquer um desses direitos, entre em contato conosco através do email: <strong class="text-neon-accent">convencaocgadrb@gmail.com</strong></p>
                        <p class="text-gray-500 text-sm mt-2">Responderemos sua solicitação em até 15 dias, conforme exigido pela LGPD.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 7: Retenção -->
        <div id="section-7" class="scroll-mt-32 mb-16 gsap-reveal">
            <div class="flex items-center gap-4 mb-8">
                <span class="w-12 h-12 rounded-2xl bg-neon-accent/20 flex items-center justify-center font-mono text-neon-accent font-bold">07</span>
                <h2 class="text-3xl font-bold text-white">Retenção de Dados</h2>
            </div>
            
            <div class="bg-white/5 border border-white/10 rounded-2xl p-8">
                <p class="text-gray-300 leading-relaxed mb-6">
                    Manemos seus dados pessoais apenas pelo tempo necessário para cumprir as finalidades para as quais foram coletados, incluindo requisitos legais, contábeis ou de relatórios.
                </p>

                <div class="space-y-4">
                    <div class="flex justify-between items-center py-3 border-b border-white/10">
                        <span class="text-white">Dados de cadastro</span>
                        <span class="text-gray-400 text-sm">Período de utilização + 5 anos após última interação</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-white/10">
                        <span class="text-white">Dados financeiros/fiscais</span>
                        <span class="text-gray-400 text-sm">10 anos (obrigação legal)</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-white/10">
                        <span class="text-white">Registros de acesso</span>
                        <span class="text-gray-400 text-sm">2 anos</span>
                    </div>
                    <div class="flex justify-between items-center py-3">
                        <span class="text-white">Dados de cursos concluídos</span>
                        <span class="text-gray-400 text-sm">Tempo indefinido (para emissão de certificados)</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 8: Alterações -->
        <div id="section-8" class="scroll-mt-32 mb-16 gsap-reveal">
            <div class="flex items-center gap-4 mb-8">
                <span class="w-12 h-12 rounded-2xl bg-neon-accent/20 flex items-center justify-center font-mono text-neon-accent font-bold">08</span>
                <h2 class="text-3xl font-bold text-white">Alterações nesta Política</h2>
            </div>
            
            <div class="bg-white/5 border border-white/10 rounded-2xl p-8">
                <p class="text-gray-300 leading-relaxed mb-6">
                    Esta Política de Privacidade pode ser atualizada periodicamente para refletir mudanças em nossas práticas de privacidade. Qualquer alteração será publicada nesta página com uma nova data de "Última atualização".
                </p>
                
                <div class="bg-black/30 rounded-xl p-4">
                    <p class="text-gray-400 text-sm">
                        <strong class="text-white">Última atualização:</strong> <span class="text-neon-accent font-mono"><?php echo date('d/m/Y'); ?></span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Contact CTA -->
        <div class="bg-gradient-to-br from-neon-accent/20 to-transparent border border-neon-accent/30 rounded-3xl p-8 md:p-12 text-center mt-16 gsap-reveal">
            <h3 class="text-2xl font-bold text-white mb-4">Ainda tem dúvidas?</h3>
            <p class="text-gray-400 mb-8 max-w-xl mx-auto">
                Nossa equipe está pronta para esclarecer qualquer questão sobre como tratamos seus dados pessoais.
            </p>
            <?php $whatsapp_number = preg_replace('/[^0-9]/', '', $site_settings['whatsapp_number'] ?? ''); ?>
            <a href="https://api.whatsapp.com/send?phone=<?php echo sanitize_output($whatsapp_number); ?>" 
               target="_blank"
               class="inline-flex items-center gap-3 bg-neon-accent text-black font-semibold px-8 py-4 rounded-full hover:scale-105 transition-transform">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.937 3.659 1.432 5.631 1.433h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                </svg>
                Falar no WhatsApp
            </a>
        </div>

    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

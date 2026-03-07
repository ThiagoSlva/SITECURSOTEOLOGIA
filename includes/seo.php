<?php
// includes/seo.php - SEO e Meta Tags Dinâmicas

/**
 * Gera meta tags otimizadas para SEO
 */
function generate_seo_meta($page_data = []) {
    $base_title = "CGADRB - Cursos Teológicos Online";
    $base_description = "Cursos teológicos online com certificação reconhecida. Formação acadêmica em teologia sistemática, pastoral e ministerial.";
    $base_keywords = "cursos teológicos online, teologia a distancia, curso de teologia, formação teológica, seminário teológico, certificado teológico";
    
    $title = $page_data['title'] ?? $base_title;
    $description = $page_data['description'] ?? $base_description;
    $keywords = $page_data['keywords'] ?? $base_keywords;
    $image = $page_data['image'] ?? 'https://' . $_SERVER['HTTP_HOST'] . '/assets/images/logotipo.jpeg';
    $url = $page_data['url'] ?? 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $type = $page_data['type'] ?? 'website';
    
    // Escape para HTML seguro
    $title_esc = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
    $description_esc = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');
    $keywords_esc = htmlspecialchars($keywords, ENT_QUOTES, 'UTF-8');
    $image_esc = htmlspecialchars($image, ENT_QUOTES, 'UTF-8');
    $url_esc = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
    
    return <<<HTML
    <!-- Meta Tags Básicas -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$title_esc}</title>
    <meta name="description" content="{$description_esc}">
    <meta name="keywords" content="{$keywords_esc}">
    <meta name="author" content="CGADRB - Instituto Teológico">
    <meta name="robots" content="index, follow">
    <meta name="language" content="pt-BR">
    <meta name="geo.region" content="BR">
    <meta name="geo.country" content="Brazil">
    
    <!-- Open Graph / Redes Sociais -->
    <meta property="og:type" content="{$type}">
    <meta property="og:title" content="{$title_esc}">
    <meta property="og:description" content="{$description_esc}">
    <meta property="og:image" content="{$image_esc}">
    <meta property="og:url" content="{$url_esc}">
    <meta property="og:site_name" content="CGADRB">
    <meta property="og:locale" content="pt_BR">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{$title_esc}">
    <meta name="twitter:description" content="{$description_esc}">
    <meta name="twitter:image" content="{$image_esc}">
    <meta name="twitter:site" content="@CGADRB">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="{$url_esc}">
    
    <!-- Favicon e App Icons -->
    <link rel="icon" type="image/x-icon" href="/assets/images/logotipo.jpeg">
    <link rel="apple-touch-icon" href="/assets/images/logotipo.jpeg">
    
    <!-- Schema.org Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@graph": [
            {
                "@type": "Organization",
                "@id": "https://{$_SERVER['HTTP_HOST']}#organization",
                "name": "CGADRB - Instituto Teológico",
                "url": "https://{$_SERVER['HTTP_HOST']}",
                "logo": "https://{$_SERVER['HTTP_HOST']}/assets/images/logotipo.jpeg",
                "description": "Instituto de formação teológica com cursos online e certificação reconhecida",
                "address": {
                    "@type": "PostalAddress",
                    "addressCountry": "BR",
                    "addressRegion": "SP"
                },
                "contactPoint": {
                    "@type": "ContactPoint",
                    "telephone": "+55-11-XXXX-XXXX",
                    "contactType": "customer service",
                    "availableLanguage": ["Portuguese"]
                },
                "sameAs": [
                    "https://instagram.com/cgadrb",
                    "https://facebook.com/cgadrb"
                ]
            }
HTML;
}

/**
 * Gera structured data para cursos
 */
function generate_course_schema($course) {
    $title_esc = htmlspecialchars($course['title'], ENT_QUOTES, 'UTF-8');
    $desc_esc = htmlspecialchars($course['description'], ENT_QUOTES, 'UTF-8');
    $image_esc = htmlspecialchars($course['image_url'] ?? '', ENT_QUOTES, 'UTF-8');
    $url_esc = htmlspecialchars('https://' . $_SERVER['HTTP_HOST'] . '/curso-single.php?slug=' . $course['slug'], ENT_QUOTES, 'UTF-8');
    
    return <<<JSON
    {
        "@context": "https://schema.org",
        "@type": "Course",
        "name": "{$title_esc}",
        "description": "{$desc_esc}",
        "provider": {
            "@type": "Organization",
            "name": "CGADRB - Instituto Teológico",
            "url": "https://{$_SERVER['HTTP_HOST']}"
        },
        "image": "{$image_esc}",
        "url": "{$url_esc}",
        "offers": {
            "@type": "Offer",
            "price": "{$course['price']}",
            "priceCurrency": "BRL",
            "availability": "https://schema.org/InStock",
            "validFrom": "2024-01-01"
        },
        "educationalLevel": "Intermediate",
        "inLanguage": "pt-BR",
        "coursePrerequisites": "Ensino Médio completo",
        "learningOutcome": "Certificado de Formação Teológica"
    }
JSON;
}

/**
 * Gera structured data para artigos do blog
 */
function generate_article_schema($post) {
    $title_esc = htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8');
    $content_esc = htmlspecialchars(strip_tags($post['content']), ENT_QUOTES, 'UTF-8');
    $url_esc = htmlspecialchars('https://' . $_SERVER['HTTP_HOST'] . '/blog-single.php?slug=' . $post['slug'], ENT_QUOTES, 'UTF-8');
    
    return <<<JSON
    {
        "@context": "https://schema.org",
        "@type": "Article",
        "headline": "{$title_esc}",
        "description": "{$content_esc}",
        "image": "https://{$_SERVER['HTTP_HOST']}/assets/images/logotipo.jpeg",
        "url": "{$url_esc}",
        "datePublished": "{$post['created_at']}",
        "dateModified": "{$post['updated_at']}",
        "author": {
            "@type": "Organization",
            "name": "CGADRB - Instituto Teológico"
        },
        "publisher": {
            "@type": "Organization",
            "name": "CGADRB - Instituto Teológico",
            "logo": "https://{$_SERVER['HTTP_HOST']}/assets/images/logotipo.jpeg"
        },
        "mainEntityOfPage": {
            "@type": "WebPage",
            "@id": "{$url_esc}"
        }
    }
JSON;
}

/**
 * Gera breadcrumbs schema
 */
function generate_breadcrumb_schema($breadcrumbs) {
    $items = [];
    foreach ($breadcrumbs as $i => $crumb) {
        $items[] = [
            "@type" => "ListItem",
            "position" => $i + 1,
            "name" => htmlspecialchars($crumb['name'], ENT_QUOTES, 'UTF-8'),
            "item" => htmlspecialchars($crumb['url'], ENT_QUOTES, 'UTF-8')
        ];
    }
    
    return json_encode([
        "@context" => "https://schema.org",
        "@type" => "BreadcrumbList",
        "itemListElement" => $items
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}
?>

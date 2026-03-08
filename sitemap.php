<?php
// sitemap.php - Gerador dinâmico de sitemap
error_reporting(0);
ini_set('display_errors', 0);

ob_start();
header('Content-Type: application/xml; charset=utf-8');

require_once __DIR__ . '/includes/db.php';

$baseUrl = 'https://cgadrb.shopdix.com.br';

$xml = '<?xml version="1.0" encoding="UTF-8"?>';
$xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

// Páginas estáticas
$staticPages = [
    ['loc' => '/', 'priority' => '1.0', 'changefreq' => 'weekly'],
    ['loc' => '/cursos.php', 'priority' => '0.9', 'changefreq' => 'daily'],
    ['loc' => '/blog.php', 'priority' => '0.8', 'changefreq' => 'weekly'],
    ['loc' => '/politica-privacidade.php', 'priority' => '0.5', 'changefreq' => 'monthly'],
    ['loc' => '/termos-de-uso.php', 'priority' => '0.5', 'changefreq' => 'monthly'],
];

foreach ($staticPages as $page) {
    $xml .= '<url>';
    $xml .= '<loc>' . $baseUrl . $page['loc'] . '</loc>';
    $xml .= '<changefreq>' . $page['changefreq'] . '</changefreq>';
    $xml .= '<priority>' . $page['priority'] . '</priority>';
    $xml .= '</url>';
}

// Cursos do banco de dados
try {
    $stmt = $pdo->query("SELECT slug, updated_at FROM courses WHERE status = 'active'");
    $courses = $stmt->fetchAll();
    
    foreach ($courses as $course) {
        $lastmod = !empty($course['updated_at']) ? date('c', strtotime($course['updated_at'])) : date('c');
        $xml .= '<url>';
        $xml .= '<loc>' . $baseUrl . '/curso-single.php?slug=' . htmlspecialchars($course['slug']) . '</loc>';
        $xml .= '<changefreq>weekly</changefreq>';
        $xml .= '<priority>0.7</priority>';
        $xml .= '<lastmod>' . $lastmod . '</lastmod>';
        $xml .= '</url>';
    }
} catch (Exception $e) {
    // Silencioso se falhar
}

// Posts do blog
try {
    $stmt = $pdo->query("SELECT slug, updated_at FROM blog_posts WHERE status = 'published'");
    $posts = $stmt->fetchAll();
    
    foreach ($posts as $post) {
        $lastmod = !empty($post['updated_at']) ? date('c', strtotime($post['updated_at'])) : date('c');
        $xml .= '<url>';
        $xml .= '<loc>' . $baseUrl . '/blog-single.php?id=' . htmlspecialchars($post['slug']) . '</loc>';
        $xml .= '<changefreq>monthly</changefreq>';
        $xml .= '<priority>0.6</priority>';
        $xml .= '<lastmod>' . $lastmod . '</lastmod>';
        $xml .= '</url>';
    }
} catch (Exception $e) {
    // Silencioso se falhar
}

$xml .= '</urlset>';

ob_end_clean();
echo $xml;

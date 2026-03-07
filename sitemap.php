<?php
// sitemap.xml - Sitemap dinâmico para Google
require_once __DIR__ . '/includes/db.php';

// Configurações
$base_url = 'https://' . $_SERVER['HTTP_HOST'];
$lastmod = date('Y-m-d');

// Buscar todos os cursos ativos
$courses_stmt = $pdo->query("SELECT id, title, slug, updated_at FROM courses WHERE status = 'active' ORDER BY updated_at DESC");
$courses = $courses_stmt->fetchAll();

// Buscar todos os posts do blog
$posts_stmt = $pdo->query("SELECT slug, updated_at FROM blog_posts WHERE status = 'published' ORDER BY updated_at DESC");
$posts = $posts_stmt->fetchAll();

// Buscar páginas estáticas
$static_pages = [
    ['url' => '/', 'lastmod' => $lastmod, 'changefreq' => 'weekly', 'priority' => '1.0'],
    ['url' => '/cursos.php', 'lastmod' => $lastmod, 'changefreq' => 'daily', 'priority' => '0.9'],
    ['url' => '/blog.php', 'lastmod' => $lastmod, 'changefreq' => 'daily', 'priority' => '0.8'],
    ['url' => '/sobre.php', 'lastmod' => $lastmod, 'changefreq' => 'monthly', 'priority' => '0.7'],
    ['url' => '/contato.php', 'lastmod' => $lastmod, 'changefreq' => 'monthly', 'priority' => '0.6']
];

// Headers XML
header('Content-Type: application/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

// Páginas estáticas
foreach ($static_pages as $page) {
    echo '
    <url>
        <loc>' . $base_url . $page['url'] . '</loc>
        <lastmod>' . $page['lastmod'] . '</lastmod>
        <changefreq>' . $page['changefreq'] . '</changefreq>
        <priority>' . $page['priority'] . '</priority>
    </url>';
}

// Cursos
foreach ($courses as $course) {
    $course_url = $base_url . '/curso-single.php?slug=' . $course['slug'];
    $lastmod = date('Y-m-d', strtotime($course['updated_at']));
    
    echo '
    <url>
        <loc>' . $course_url . '</loc>
        <lastmod>' . $lastmod . '</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>';
}

// Posts do blog
foreach ($posts as $post) {
    $post_url = $base_url . '/blog-single.php?slug=' . $post['slug'];
    $lastmod = date('Y-m-d', strtotime($post['updated_at']));
    
    echo '
    <url>
        <loc>' . $post_url . '</loc>
        <lastmod>' . $lastmod . '</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>';
}

echo '</urlset>';
?>

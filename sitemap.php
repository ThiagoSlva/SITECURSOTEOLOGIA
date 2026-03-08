<?php
// sitemap.php
require_once __DIR__ . '/includes/db.php';

header("Content-Type: application/xml; charset=utf-8");
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

$base_url = 'https://cgadrb.shopdix.com.br'; // Fallback base URL
if (isset($_SERVER['HTTP_HOST'])) {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    $base_url = $protocol . "://" . $_SERVER['HTTP_HOST'];
}

$current_date = date('Y-m-d');

// 1. Static Pages
$static_pages = [
    '/' => '1.0',
    '/cursos.php' => '0.8',
    '/blog.php' => '0.8',
    '/login.php' => '0.5',
    '/termos-de-uso.php' => '0.3',
    '/politica-privacidade.php' => '0.3'
];

foreach ($static_pages as $url => $priority) {
    echo "  <url>\n";
    echo "    <loc>" . htmlspecialchars($base_url . $url) . "</loc>\n";
    echo "    <lastmod>{$current_date}</lastmod>\n";
    echo "    <changefreq>weekly</changefreq>\n";
    echo "    <priority>{$priority}</priority>\n";
    echo "  </url>\n";
}

// 2. Dynamic Course Pages
try {
    $stmt = $pdo->query("SELECT slug, updated_at FROM courses WHERE status = 'active' ORDER BY id DESC");
    $courses = $stmt->fetchAll();

    foreach ($courses as $course) {
        $lastmod = date('Y-m-d', strtotime($course['updated_at'] ?? $current_date));
        echo "  <url>\n";
        echo "    <loc>" . htmlspecialchars($base_url . '/curso-single.php?slug=' . $course['slug']) . "</loc>\n";
        echo "    <lastmod>{$lastmod}</lastmod>\n";
        echo "    <changefreq>monthly</changefreq>\n";
        echo "    <priority>0.9</priority>\n";
        echo "  </url>\n";
    }
}
catch (Exception $e) {
// Ignore DB errors safely
}

// 3. Dynamic Blog Pages
try {
    $stmt = $pdo->query("SELECT slug, updated_at FROM blog_posts WHERE status = 'published' ORDER BY id DESC");
    $posts = $stmt->fetchAll();

    foreach ($posts as $post) {
        $lastmod = date('Y-m-d', strtotime($post['updated_at'] ?? $current_date));
        echo "  <url>\n";
        echo "    <loc>" . htmlspecialchars($base_url . '/blog-post.php?slug=' . $post['slug']) . "</loc>\n";
        echo "    <lastmod>{$lastmod}</lastmod>\n";
        echo "    <changefreq>monthly</changefreq>\n";
        echo "    <priority>0.7</priority>\n";
        echo "  </url>\n";
    }
}
catch (Exception $e) {
// Ignore DB errors safely
}

echo '</urlset>';
?>

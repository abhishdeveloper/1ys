<?php
// sitemap.php - Generates dynamic XML sitemap
require_once __DIR__ . '/core/config/database.php';

header("Content-Type: application/xml; charset=utf-8");

$db = getDB();
$host = $_SERVER['HTTP_HOST'] ?? 'myaayucare.com';
$baseUrl = 'https://' . $host;

echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

// Static pages
$staticPages = ['/', '/products', '/categories', '/contact', '/faq'];
foreach ($staticPages as $page) {
    echo '<url>';
    echo '<loc>' . $baseUrl . $page . '</loc>';
    echo '<changefreq>weekly</changefreq>';
    echo '<priority>' . ($page === '/' ? '1.0' : '0.8') . '</priority>';
    echo '</url>';
}

// Categories
$stmt = $db->query("SELECT slug, created_at FROM categories WHERE status = 1");
while ($cat = $stmt->fetch()) {
    echo '<url>';
    echo '<loc>' . $baseUrl . '/category/' . htmlspecialchars($cat['slug']) . '</loc>';
    echo '<changefreq>weekly</changefreq>';
    echo '<priority>0.7</priority>';
    echo '</url>';
}

// Products
$stmt = $db->query("SELECT slug, updated_at FROM products WHERE is_active = 1");
while ($prod = $stmt->fetch()) {
    echo '<url>';
    echo '<loc>' . $baseUrl . '/product/' . htmlspecialchars($prod['slug']) . '</loc>';
    echo '<lastmod>' . date('Y-m-d', strtotime($prod['updated_at'])) . '</lastmod>';
    echo '<changefreq>weekly</changefreq>';
    echo '<priority>0.9</priority>';
    echo '</url>';
}

echo '</urlset>';
?>
<?php
// Sitemap dynamique EcoDrive — généré depuis la base (voitures + bornes)
include __DIR__ . '/php/bootstrap.php';

$base = rtrim(getenv('SITE_URL') ?: app_url(''), '/');

$urls = [
    '', 'php/catalogue.php', 'bornes/index.php', 'pages/contact.php',
    'pages/mentions-legales.php', 'pages/cgv.php', 'pages/cgu.php', 'pages/confidentialite.php',
];

$voitures = $conn->query("SELECT details_page FROM voiture WHERE details_page IS NOT NULL AND details_page != ''")->fetch_all(MYSQLI_ASSOC);
$bornes = $conn->query("SELECT details_page FROM borne WHERE details_page IS NOT NULL AND details_page != ''")->fetch_all(MYSQLI_ASSOC);

header('Content-Type: application/xml; charset=UTF-8');
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

$now = date('Y-m-d');
foreach ($urls as $u) {
    echo "  <url><loc>{$base}/{$u}</loc><lastmod>{$now}</lastmod><changefreq>weekly</changefreq><priority>0.8</priority></url>\n";
}
foreach ($voitures as $v) {
    echo "  <url><loc>{$base}/{$v['details_page']}</loc><lastmod>{$now}</lastmod><changefreq>monthly</changefreq><priority>0.9</priority></url>\n";
}
foreach ($bornes as $b) {
    echo "  <url><loc>{$base}/{$b['details_page']}</loc><lastmod>{$now}</lastmod><changefreq>monthly</changefreq><priority>0.7</priority></url>\n";
}

echo '</urlset>' . "\n";

<?php
$page_title    = $page_title    ?? 'EcoDrive';
$page_desc     = $page_desc     ?? 'Premier showroom Ã©lectrique de Tunisie. DÃ©couvrez notre catalogue de voitures Ã©lectriques et bornes de recharge.';
$page_image    = !empty($page_image) ? $page_image : '';
$page_keywords = $page_keywords ?? 'voiture Ã©lectrique, borne recharge, Tunisie, EcoDrive, showroom Ã©lectrique';
$site_name     = 'EcoDrive';
$base_url      = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost');
$page_url      = $base_url . '/' . ltrim($page_url ?? '', '/');
$page_image    = !empty($page_image) ? ($base_url . '/' . ltrim($page_image, '/')) : '';
?><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<meta name="description" content="<?= htmlspecialchars($page_desc, ENT_QUOTES, 'UTF-8') ?>">
<meta name="keywords" content="<?= htmlspecialchars($page_keywords, ENT_QUOTES, 'UTF-8') ?>">
<meta name="robots" content="index, follow">
<link rel="canonical" href="<?= htmlspecialchars($page_url, ENT_QUOTES, 'UTF-8') ?>">
<meta property="og:type" content="website">
<meta property="og:site_name" content="<?= $site_name ?>">
<meta property="og:title" content="<?= htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') ?>">
<meta property="og:description" content="<?= htmlspecialchars($page_desc, ENT_QUOTES, 'UTF-8') ?>">
<meta property="og:url" content="<?= htmlspecialchars($page_url, ENT_QUOTES, 'UTF-8') ?>">
<?php if (!empty($page_image)): ?>
<meta property="og:image" content="<?= htmlspecialchars($page_image, ENT_QUOTES, 'UTF-8') ?>">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<?php endif; ?>
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') ?>">
<meta name="twitter:description" content="<?= htmlspecialchars($page_desc, ENT_QUOTES, 'UTF-8') ?>">
<?php if (!empty($page_image)): ?>
<meta name="twitter:image" content="<?= htmlspecialchars($page_image, ENT_QUOTES, 'UTF-8') ?>">
<?php endif; ?>

<?php
$uri = htmlspecialchars($_SERVER['REQUEST_URI'] ?? '', ENT_QUOTES, 'UTF-8');
session_start();
$loggedIn = isset($_SESSION['user']);

$page_url = '404.php';
$page_title = '404 — Page introuvable | EcoDrive';
$page_desc = 'La page que vous recherchez n\'existe pas ou a été déplacée. Retournez à l\'accueil EcoDrive.';
$page_image = 'images/tesla-model-3/Tesla_Model_3_Standard_2026-01@2x.jpg';
?><!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') ?></title>
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E%26%23x26A1%3B%3C/text%3E%3C/svg%3E">
  <?php include __DIR__ . '/php/partials/meta.php'; ?>
  <link rel="stylesheet" href="css/style.css?v=15">
  <style>
    .page-404{color:var(--dark);min-height:90vh;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;padding:2rem;flex:1}
    .page-404 h1{font-family:var(--font-display);font-size:clamp(6rem,12vw,10rem);font-weight:300;color:var(--accent);line-height:1;margin-bottom:.5rem}
    .page-404 h2{font-family:var(--font-display);font-size:clamp(1.5rem,3vw,2.2rem);font-weight:400;color:var(--gray);margin-bottom:1rem}
    .page-404 p{color:var(--gray);font-size:.92rem;margin-bottom:2rem;max-width:400px}
    .page-404 .path{font-size:.72rem;color:var(--gray-mid);margin-top:3rem}
  </style>
</head>
<body>
<?php $asset_base = ''; include __DIR__ . '/php/partials/header.php'; ?>

<main class="page-404">
  <h1>404</h1>
  <h2>Page introuvable</h2>
  <p>La page que vous cherchez n'existe pas ou a été déplacée.</p>
  <a href="index.php" class="btn btn-404">Retour à l'accueil</a>
  <div class="path"><?= $uri ?></div>
</main>

<?php include __DIR__ . '/php/partials/footer.php'; ?>

<?php
include '../php/configuration.php';
$loggedIn = isset($_SESSION['user']);
$page_title = 'Porsche Taycan — EcoDrive';
$page_desc  = 'Porsche Taycan, berline électrique de haute performance. 0-100 en 2,8s. Réservez votre essai.';
$page_url   = 'voitures/Porsche-Taycan.php';
$page_image = 'images/porsche-taycan/porsche-taycan-taycan-91005.webp';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Porsche Taycan 2026 — EcoDrive</title>
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E%26%23x26A1%3B%3C/text%3E%3C/svg%3E">
  <link rel="stylesheet" href="../css/style.css?v=14">
  <?php include __DIR__ . '/../php/partials/meta.php'; ?>
  <?php $jsonld_type = 'product'; $jsonld_product = ['name' => 'Porsche Taycan', 'description' => htmlspecialchars($page_desc, ENT_QUOTES, 'UTF-8'), 'image' => 'https://ecodrive.tn/'.$page_image, 'brand' => 'Porsche', 'price' => '448000']; include __DIR__ . '/../php/partials/jsonld.php'; ?>
</head>
<body>
<?php $asset_base = '../'; include __DIR__ . '/../php/partials/header.php'; ?>

<nav class="breadcrumb" aria-label="breadcrumb">
  <a href="../index.php">Accueil</a> / <a href="../php/catalogue.php">Catalogue</a> / <span class="breadcrumb-current">Porsche Taycan 2026</span>
</nav>

<main class="page-fade-in">
    <?php include '../php/car_slider.php'; renderCarSlider('images/porsche-taycan/', 'porsche-taycan-taycan-91005.webp', 'Porsche Taycan'); ?>
    <div class="car-actions-bar">
      <div class="price-block">
        <span class="price-label">À partir de</span>
        <span class="price-value">448 000 <small>DT</small></span>
      </div>
      <a href="../php/reservation.php?car=11" class="btn-reserve">Réserver un essai</a>
    </div>

    <section class="car-overview reveal reveal-up">
      <div class="overview-desc"><div class="desc-card"><p>Berline sportive 100% électrique Porsche. 408 ch propulsion, batterie 89 kWh, autonomie 503 km WLTP, architecture 800V, recharge 320 kW (10-80% en 18 min). Boîte 2 rapports, design iconique.</p></div></div>
      <div class="specs-highlight">
      <div class="spec-card">
        <div class="spec-label">Puissance</div>
        <div class="spec-value">408 ch<small>300 kW</small></div>
      </div>
      <div class="spec-card">
        <div class="spec-label">Batterie</div>
        <div class="spec-value">89 kWh<small>Lithium-ion NMC</small></div>
      </div>
      <div class="spec-card">
        <div class="spec-label">Autonomie</div>
        <div class="spec-value">503 km<small>Cycle WLTP</small></div>
      </div>
      <div class="spec-card">
        <div class="spec-label">0-100 km/h</div>
        <div class="spec-value">4,8 s<small>230 km/h</small></div>
      </div>
      <div class="spec-card">
        <div class="spec-label">Poids</div>
        <div class="spec-value">2 200 kg<small>Coffre 407 L</small></div>
      </div>
    </div>
    </section>
<div class="section-title-wrap reveal reveal-up">
      <h2>Fiche technique</h2>
    </div>

    <section class="specs-detail reveal reveal-up reveal-delay-1">
      <div class="specs-grid">
        <div class="spec-group">
          <h3>Motorisation</h3>
          <dl>
            <div class="spec-row"><dt>Puissance max</dt><dd>408 ch (300 kW)</dd></div>
            <div class="spec-row"><dt>Couple max</dt><dd>410 Nm</dd></div>
            <div class="spec-row"><dt>Transmission</dt><dd>Propulsion (RWD)</dd></div>
            <div class="spec-row"><dt>Vitesse max</dt><dd>230 km/h</dd></div>
          </dl>
        </div>
        <div class="spec-group">
          <h3>Batterie & Autonomie</h3>
          <dl>
            <div class="spec-row"><dt>Capacité batterie</dt><dd>89 kWh</dd></div>
            <div class="spec-row"><dt>Type de batterie</dt><dd>Lithium-ion NMC</dd></div>
            <div class="spec-row"><dt>Autonomie WLTP</dt><dd>503 km</dd></div>
            <div class="spec-row"><dt>Architecture</dt><dd>800V</dd></div>
          
            <div class="spec-row battery-visual"><dt>Niveau</dt><dd><div class="battery-bar"><div class="battery-track"><div class="battery-fill high" data-width="82%"></div></div><span class="battery-label">89 kWh</span></div></dd></div></dl>
        </div>
        <div class="spec-group">
          <h3>Recharge</h3>
          <dl>
            <div class="spec-row"><dt>AC (Wallbox)</dt><dd>9 h 30 (11 kW)</dd></div>
            <div class="spec-row"><dt>DC (Rapide)</dt><dd>18 min (10-80%)</dd></div>
            <div class="spec-row"><dt>Puissance max DC</dt><dd>320 kW</dd></div>
          </dl>
        </div>
        <div class="spec-group">
          <h3>Dimensions</h3>
          <dl>
            <div class="spec-row"><dt>Longueur</dt><dd>4 963 mm</dd></div>
            <div class="spec-row"><dt>Largeur</dt><dd>1 966 mm</dd></div>
            <div class="spec-row"><dt>Hauteur</dt><dd>1 395 mm</dd></div>
            <div class="spec-row"><dt>Coffre</dt><dd>407 L</dd></div>
          </dl>
        </div>
      </div>
    </section>
<section class="reservation-cta reveal reveal-up reveal-delay-2">
      <div class="cta-box">
        <h2>Essayez la Porsche Taycan 2026</h2>
        <p>Réservez votre essai gratuit dès maintenant et découvrez l'expérience de conduite électrique EcoDrive.</p>
        <a href="../php/reservation.php?car=11" class="cta-btn">Réserver un essai gratuit</a>
      </div>
    </section>
  </main>

<?php include __DIR__ . '/../php/partials/footer.php'; ?>

<?php
include '../php/configuration.php';
$loggedIn = isset($_SESSION['user']);
$page_title = 'Geely EX2 — EcoDrive';
$page_desc  = 'Geely EX2, SUV électrique compact au excellent rapport qualité-prix. Autonomie et confort garantis.';
$page_url   = 'voitures/Geely-EX2.php';
$page_image = 'images/geely-ex2/geely-ex2-39.4-kwh-max-101691.webp';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Geely EX2 — EcoDrive</title>
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E%26%23x26A1%3B%3C/text%3E%3C/svg%3E">
  <link rel="stylesheet" href="../css/style.css?v=19">
  <?php include __DIR__ . '/../php/partials/meta.php'; ?>
  <?php $jsonld_type = 'product'; $jsonld_product = ['name' => 'Geely EX2', 'description' => htmlspecialchars($page_desc, ENT_QUOTES, 'UTF-8'), 'image' => 'https://ecodrive.tn/'.$page_image, 'brand' => 'Geely', 'price' => '52000']; include __DIR__ . '/../php/partials/jsonld.php'; ?>
</head>
<body>
<?php $asset_base = '../'; include __DIR__ . '/../php/partials/header.php'; ?>

<nav class="breadcrumb" aria-label="breadcrumb">
  <a href="../index.php">Accueil</a> / <a href="../php/catalogue.php">Catalogue</a> / <span class="breadcrumb-current">Geely EX2</span>
</nav>

<main class="page-fade-in">
    <?php include '../php/car_slider.php'; renderCarSlider('images/geely-ex2/', 'geely-ex2-39.4-kwh-max-101691.webp', 'Geely EX2'); ?>
    <div class="car-actions-bar">
      <div class="price-block">
        <span class="price-label">À partir de</span>
        <span class="price-value">52 000 <small>DT</small></span>
      </div>
      <a href="../php/reservation.php?car=16" class="btn-reserve">Réserver un essai</a>
    </div>

    <section class="car-overview reveal reveal-up">
<div class="specs-highlight">
      <div class="spec-card">
        <div class="spec-label">Puissance</div>
        <div class="spec-value">115 ch<small>85 kW</small></div>
      </div>
      <div class="spec-card">
        <div class="spec-label">Batterie</div>
        <div class="spec-value">39,4 kWh<small>LFP</small></div>
      </div>
      <div class="spec-card">
        <div class="spec-label">Autonomie</div>
        <div class="spec-value">325 km<small>Cycle WLTP</small></div>
      </div>
      <div class="spec-card">
        <div class="spec-label">0-100 km/h</div>
        <div class="spec-value">10,2 s<small>130 km/h</small></div>
      </div>
      <div class="spec-card">
        <div class="spec-label">Poids</div>
        <div class="spec-value">1 380 kg<small>Coffre 400 L</small></div>
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
            <div class="spec-row"><dt>Puissance max</dt><dd>115 ch (85 kW)</dd></div>
            <div class="spec-row"><dt>Couple max</dt><dd>150 Nm</dd></div>
            <div class="spec-row"><dt>Transmission</dt><dd>Propulsion (RWD)</dd></div>
            <div class="spec-row"><dt>Vitesse max</dt><dd>130 km/h</dd></div>
          </dl>
        </div>
        <div class="spec-group">
          <h3>Batterie & Autonomie</h3>
          <dl>
            <div class="spec-row"><dt>Capacité batterie</dt><dd>39,4 kWh</dd></div>
            <div class="spec-row"><dt>Type de batterie</dt><dd>LFP</dd></div>
            <div class="spec-row"><dt>Autonomie WLTP</dt><dd>325 km</dd></div>
            <div class="spec-row"><dt>Consommation</dt><dd>12,1 kWh/100 km</dd></div>
          
            <div class="spec-row battery-visual"><dt>Niveau</dt><dd><div class="battery-bar"><div class="battery-track"><div class="battery-fill high" data-width="36%"></div></div><span class="battery-label">39.4 kWh</span></div></dd></div></dl>
        </div>
        <div class="spec-group">
          <h3>Recharge</h3>
          <dl>
            <div class="spec-row"><dt>AC (Wallbox)</dt><dd>5 h 30 (7 kW)</dd></div>
            <div class="spec-row"><dt>DC (Rapide)</dt><dd>21 min (30-80%)</dd></div>
          </dl>
        </div>
        <div class="spec-group">
          <h3>Dimensions</h3>
          <dl>
            <div class="spec-row"><dt>Longueur</dt><dd>4 005 mm</dd></div>
            <div class="spec-row"><dt>Largeur</dt><dd>1 760 mm</dd></div>
            <div class="spec-row"><dt>Hauteur</dt><dd>1 570 mm</dd></div>
            <div class="spec-row"><dt>Coffre</dt><dd>400 L</dd></div>
          </dl>
        </div>
      </div>
    </section>
<section class="reservation-cta reveal reveal-up reveal-delay-2">
      <div class="cta-box">
        <h2>Essayez la Geely EX2</h2>
        <p>Réservez votre essai gratuit dès maintenant et découvrez l'expérience de conduite électrique EcoDrive.</p>
        <a href="../php/reservation.php?car=16" class="cta-btn">Réserver un essai gratuit</a>
      </div>
    </section>
  </main>

<?php include __DIR__ . '/../php/partials/footer.php'; ?>

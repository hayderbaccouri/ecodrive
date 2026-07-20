<?php
include '../php/configuration.php';
$loggedIn = isset($_SESSION['user']);
$page_title = 'BYD Dolphin — EcoDrive';
$page_desc  = 'BYD Dolphin, citadine électrique accessible et polyvalente. Autonomie jusqu à 427 km. Découvrez-la chez EcoDrive.';
$page_url   = 'voitures/BYD-Dolphin.php';
$page_image = 'images/byd-dolphin/byd-dolphin-surf-38.88-kwh-102711.webp';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BYD Dolphin Surf — EcoDrive</title>
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E%26%23x26A1%3B%3C/text%3E%3C/svg%3E">
  <link rel="stylesheet" href="../css/style.css?v=17">
  <?php include __DIR__ . '/../php/partials/meta.php'; ?>
  <?php $jsonld_type = 'product'; $jsonld_product = ['name' => 'BYD Dolphin Surf', 'description' => htmlspecialchars($page_desc, ENT_QUOTES, 'UTF-8'), 'image' => 'https://ecodrive.tn/'.$page_image, 'brand' => 'BYD', 'price' => '55000']; include __DIR__ . '/../php/partials/jsonld.php'; ?>
</head>
<body>
<?php $asset_base = '../'; include __DIR__ . '/../php/partials/header.php'; ?>

<nav class="breadcrumb" aria-label="breadcrumb">
  <a href="../index.php">Accueil</a> / <a href="../php/catalogue.php">Catalogue</a> / <span class="breadcrumb-current">BYD Dolphin Surf</span>
</nav>

<main class="page-fade-in">
    <?php include '../php/car_slider.php'; renderCarSlider('images/byd-dolphin/', 'byd-dolphin-surf-38.88-kwh-102711.webp', 'BYD Dolphin Surf'); ?>
    <div class="car-actions-bar">
      <div class="price-block">
        <span class="price-label">À partir de</span>
        <span class="price-value">55 000 <small>DT</small></span>
      </div>
      <a href="../php/reservation.php?car=4" class="btn-reserve">Réserver un essai</a>
    </div>

    <section class="car-overview reveal reveal-up">
      <div class="overview-desc"><div class="desc-card"><p>Citadine électrique BYD batterie Blade LFP 43,2 kWh. 156 ch, autonomie 310 km WLTP, recharge DC 85 kW (10-80% en 30 min). Écran rotatif 10,1", V2L, idéale pour la ville.</p></div></div>
      <div class="specs-highlight">
      <div class="spec-card">
        <div class="spec-label">Puissance</div>
        <div class="spec-value">156 ch<small>115 kW</small></div>
      </div>
      <div class="spec-card">
        <div class="spec-label">Batterie</div>
        <div class="spec-value">43,2 kWh<small>Blade LFP</small></div>
      </div>
      <div class="spec-card">
        <div class="spec-label">Autonomie</div>
        <div class="spec-value">310 km<small>Cycle WLTP</small></div>
      </div>
      <div class="spec-card">
        <div class="spec-label">0-100 km/h</div>
        <div class="spec-value">9,1 s<small>160 km/h</small></div>
      </div>
      <div class="spec-card">
        <div class="spec-label">Poids</div>
        <div class="spec-value">1 350 kg<small>Coffre 345 L</small></div>
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
            <div class="spec-row"><dt>Puissance max</dt><dd>156 ch (115 kW)</dd></div>
            <div class="spec-row"><dt>Couple max</dt><dd>220 Nm</dd></div>
            <div class="spec-row"><dt>Transmission</dt><dd>Traction (FWD)</dd></div>
            <div class="spec-row"><dt>Vitesse max</dt><dd>160 km/h</dd></div>
          </dl>
        </div>
        <div class="spec-group">
          <h3>Batterie & Autonomie</h3>
          <dl>
            <div class="spec-row"><dt>Capacité batterie</dt><dd>43,2 kWh</dd></div>
            <div class="spec-row"><dt>Type de batterie</dt><dd>Blade LFP</dd></div>
            <div class="spec-row"><dt>Autonomie WLTP</dt><dd>310 km</dd></div>
            <div class="spec-row"><dt>Consommation</dt><dd>13,8 kWh/100 km</dd></div>
          
            <div class="spec-row battery-visual"><dt>Niveau</dt><dd><div class="battery-bar"><div class="battery-track"><div class="battery-fill high" data-width="40%"></div></div><span class="battery-label">43.2 kWh</span></div></dd></div></dl>
        </div>
        <div class="spec-group">
          <h3>Recharge</h3>
          <dl>
            <div class="spec-row"><dt>AC (Wallbox)</dt><dd>4 h 30 (7,4 kW)</dd></div>
            <div class="spec-row"><dt>DC (Rapide)</dt><dd>30 min (10-80%, 85 kW)</dd></div>
          </dl>
        </div>
        <div class="spec-group">
          <h3>Dimensions</h3>
          <dl>
            <div class="spec-row"><dt>Longueur</dt><dd>3 990 mm</dd></div>
            <div class="spec-row"><dt>Largeur</dt><dd>1 755 mm</dd></div>
            <div class="spec-row"><dt>Hauteur</dt><dd>1 580 mm</dd></div>
            <div class="spec-row"><dt>Coffre</dt><dd>345 L</dd></div>
          </dl>
        </div>
      </div>
    </section>
<section class="reservation-cta reveal reveal-up reveal-delay-2">
      <div class="cta-box">
        <h2>Essayez la BYD Dolphin Surf</h2>
        <p>Réservez votre essai gratuit dès maintenant et découvrez l'expérience de conduite électrique EcoDrive.</p>
        <a href="../php/reservation.php?car=4" class="cta-btn">Réserver un essai gratuit</a>
      </div>
    </section>
  </main>

<?php include __DIR__ . '/../php/partials/footer.php'; ?>

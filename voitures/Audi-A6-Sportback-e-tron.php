<?php
include '../php/configuration.php';
$loggedIn = isset($_SESSION['user']);
$page_title = 'Audi A6 Sportback e-tron — EcoDrive';
$page_desc  = 'Audi A6 Sportback e-tron, berline électrique premium avec 700 plus km d autonomie. Essai gratuit EcoDrive.';
$page_url   = 'voitures/Audi-A6-Sportback-e-tron.php';
$page_image = 'images/audi-a6-sportback-e-tron-electrique/essai-audi-a6-sportback-e-tron-la-grande-routiere-allemande-passe-au-tout-electrique-107381.webp';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Audi A6 Sportback e-tron — EcoDrive</title>
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E%26%23x26A1%3B%3C/text%3E%3C/svg%3E">
  <link rel="stylesheet" href="../css/style.css?v=17">
  <?php include __DIR__ . '/../php/partials/meta.php'; ?>
  <?php $jsonld_type = 'product'; $jsonld_product = ['name' => 'Audi A6 Sportback e-tron', 'description' => htmlspecialchars($page_desc, ENT_QUOTES, 'UTF-8'), 'image' => 'https://ecodrive.tn/'.$page_image, 'brand' => 'Audi', 'price' => '239000']; include __DIR__ . '/../php/partials/jsonld.php'; ?>
</head>
<body>
<?php $asset_base = '../'; include __DIR__ . '/../php/partials/header.php'; ?>

<nav class="breadcrumb" aria-label="breadcrumb">
  <a href="../index.php">Accueil</a> / <a href="../php/catalogue.php">Catalogue</a> / <span class="breadcrumb-current">Audi A6 Sportback e-tron</span>
</nav>

  <main class="page-fade-in">
    <?php include '../php/car_slider.php'; renderCarSlider('images/audi-a6-sportback-e-tron-electrique/', 'essai-audi-a6-sportback-e-tron-la-grande-routiere-allemande-passe-au-tout-electrique-107381.webp', 'Audi A6 Sportback e-tron'); ?>
    <div class="car-actions-bar">
      <div class="price-block">
        <span class="price-label">À partir de</span>
        <span class="price-value">239 000 <small>DT</small></span>
      </div>
      <a href="../php/reservation.php?car=1" class="btn-reserve">Réserver un essai</a>
    </div>

    <section class="car-overview reveal reveal-up">
      <div class="overview-desc"><div class="desc-card"><p>Berline premium 100% électrique sur plateforme PPE. 367 ch, batterie 100 kWh NMC, autonomie 757 km WLTP, architecture 800V, recharge 10-80% en 21 min (270 kW). Double écran MMI, Cx 0,21.</p></div></div>
      <div class="specs-highlight">
      <div class="spec-card">
        <div class="spec-label">Puissance</div>
        <div class="spec-value">367 ch<small>270 kW</small></div>
      </div>
      <div class="spec-card">
        <div class="spec-label">Batterie</div>
        <div class="spec-value">100 kWh<small>Lithium-ion NMC</small></div>
      </div>
      <div class="spec-card">
        <div class="spec-label">Autonomie</div>
        <div class="spec-value">757 km<small>Cycle WLTP</small></div>
      </div>
      <div class="spec-card">
        <div class="spec-label">0-100 km/h</div>
        <div class="spec-value">5,4 s<small>210 km/h</small></div>
      </div>
      <div class="spec-card">
        <div class="spec-label">Poids</div>
        <div class="spec-value">2 175 kg<small>Coffre 502 L</small></div>
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
            <div class="spec-row"><dt>Puissance max</dt><dd>367 ch (270 kW)</dd></div>
            <div class="spec-row"><dt>Couple max</dt><dd>565 Nm</dd></div>
            <div class="spec-row"><dt>Transmission</dt><dd>Propulsion (RWD)</dd></div>
            <div class="spec-row"><dt>Vitesse max</dt><dd>210 km/h</dd></div>
          </dl>
        </div>
        <div class="spec-group">
          <h3>Batterie & Autonomie</h3>
          <dl>
            <div class="spec-row"><dt>Capacité batterie</dt><dd>100 kWh</dd></div>
            <div class="spec-row"><dt>Type de batterie</dt><dd>Lithium-ion NMC</dd></div>
            <div class="spec-row"><dt>Autonomie WLTP</dt><dd>757 km</dd></div>
            <div class="spec-row"><dt>Émissions CO₂</dt><dd>0 g/km CO₂</dd></div>
          
            <div class="spec-row battery-visual"><dt>Niveau</dt><dd><div class="battery-bar"><div class="battery-track"><div class="battery-fill high" data-width="92%"></div></div><span class="battery-label">100 kWh</span></div></dd></div></dl>
        </div>
        <div class="spec-group">
          <h3>Recharge</h3>
          <dl>
            <div class="spec-row"><dt>AC (Wallbox)</dt><dd>9 h 10 (11 kW)</dd></div>
            <div class="spec-row"><dt>DC (Rapide)</dt><dd>21 min (10-80%, 270 kW)</dd></div>
          </dl>
        </div>
        <div class="spec-group">
          <h3>Dimensions</h3>
          <dl>
            <div class="spec-row"><dt>Longueur</dt><dd>4 960 mm</dd></div>
            <div class="spec-row"><dt>Largeur</dt><dd>1 960 mm</dd></div>
            <div class="spec-row"><dt>Hauteur</dt><dd>1 450 mm</dd></div>
            <div class="spec-row"><dt>Coffre</dt><dd>502 L</dd></div>
          </dl>
        </div>
      </div>
    </section>
<section class="reservation-cta reveal reveal-up reveal-delay-2">
      <div class="cta-box">
        <h2>Essayez la Audi A6 Sportback e-tron</h2>
        <p>Réservez votre essai gratuit dès maintenant et découvrez l'expérience de conduite électrique EcoDrive.</p>
        <a href="../php/reservation.php?car=1" class="cta-btn">Réserver un essai gratuit</a>
      </div>
    </section>
  </main>

<?php include __DIR__ . '/../php/partials/footer.php'; ?>

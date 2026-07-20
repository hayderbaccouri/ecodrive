<?php
include '../php/configuration.php';
$loggedIn = isset($_SESSION['user']);
$page_title = 'Tesla Model S Plaid — EcoDrive';
$page_desc  = 'Tesla Model S Plaid, la berline électrique la plus puissante. 1 020 ch, 0-100 en 2,1s. Essai chez EcoDrive.';
$page_url   = 'voitures/Tesla-Model-S-Plaid.php';
$page_image = 'images/tesla-model-s-plaid/tesla-model-s-plaid.jpg';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tesla Model S Plaid 2026 — EcoDrive</title>
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E%26%23x26A1%3B%3C/text%3E%3C/svg%3E">
  <link rel="stylesheet" href="../css/style.css?v=16">
  <?php include __DIR__ . '/../php/partials/meta.php'; ?>
  <?php $jsonld_type = 'product'; $jsonld_product = ['name' => 'Tesla Model S Plaid', 'description' => htmlspecialchars($page_desc, ENT_QUOTES, 'UTF-8'), 'image' => 'https://ecodrive.tn/'.$page_image, 'brand' => 'Tesla', 'price' => '359400']; include __DIR__ . '/../php/partials/jsonld.php'; ?>
</head>
<body>
<?php $asset_base = '../'; include __DIR__ . '/../php/partials/header.php'; ?>

<nav class="breadcrumb" aria-label="breadcrumb">
  <a href="../index.php">Accueil</a> / <a href="../php/catalogue.php">Catalogue</a> / <span class="breadcrumb-current">Tesla Model S Plaid 2026</span>
</nav>

<main class="page-fade-in">
    <?php include '../php/car_slider.php'; renderCarSlider('images/tesla-model-s-plaid/', 'tesla-model-s-plaid.jpg', 'Tesla Model S Plaid'); ?>
    <div class="car-actions-bar">
      <div class="price-block">
        <span class="price-label">À partir de</span>
        <span class="price-value">359 400 <small>DT</small></span>
      </div>
      <a href="../php/reservation.php?car=14" class="btn-reserve">Réserver un essai</a>
    </div>

    <section class="car-overview reveal reveal-up">
      <div class="overview-desc"><div class="desc-card"><p>Berline électrique la plus rapide au monde : 1 020 ch, 0-100 km/h en 2,1 s. Autonomie 600 km WLTP, volant yoke, 3 moteurs, transmission intégrale.</p></div></div>
      <div class="specs-highlight">
      <div class="spec-card">
        <div class="spec-label">Puissance</div>
        <div class="spec-value">1 020 ch<small>760 kW</small></div>
      </div>
      <div class="spec-card">
        <div class="spec-label">Batterie</div>
        <div class="spec-value">100 kWh<small>Lithium-ion NCA</small></div>
      </div>
      <div class="spec-card">
        <div class="spec-label">Autonomie</div>
        <div class="spec-value">600 km<small>Cycle WLTP</small></div>
      </div>
      <div class="spec-card">
        <div class="spec-label">0-100 km/h</div>
        <div class="spec-value">2,1 s<small>322 km/h</small></div>
      </div>
      <div class="spec-card">
        <div class="spec-label">Poids</div>
        <div class="spec-value">2 175 kg<small>Coffre 793 L</small></div>
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
            <div class="spec-row"><dt>Puissance max</dt><dd>1 020 ch (760 kW)</dd></div>
            <div class="spec-row"><dt>Couple max</dt><dd>1 420 Nm</dd></div>
            <div class="spec-row"><dt>Transmission</dt><dd>Intégrale (AWD)</dd></div>
            <div class="spec-row"><dt>Vitesse max</dt><dd>322 km/h</dd></div>
          </dl>
        </div>
        <div class="spec-group">
          <h3>Batterie & Autonomie</h3>
          <dl>
            <div class="spec-row"><dt>Capacité batterie</dt><dd>100 kWh</dd></div>
            <div class="spec-row"><dt>Type de batterie</dt><dd>Lithium-ion NCA</dd></div>
            <div class="spec-row"><dt>Autonomie WLTP</dt><dd>600 km</dd></div>
            <div class="spec-row"><dt>Émissions CO₂</dt><dd>0 g/km CO₂</dd></div>
          
            <div class="spec-row battery-visual"><dt>Niveau</dt><dd><div class="battery-bar"><div class="battery-track"><div class="battery-fill high" data-width="92%"></div></div><span class="battery-label">100 kWh</span></div></dd></div></dl>
        </div>
        <div class="spec-group">
          <h3>Recharge</h3>
          <dl>
            <div class="spec-row"><dt>AC (Wallbox)</dt><dd>9 h (11 kW)</dd></div>
            <div class="spec-row"><dt>DC (Rapide)</dt><dd>15 min (10-80%, 250 kW)</dd></div>
          </dl>
        </div>
        <div class="spec-group">
          <h3>Dimensions</h3>
          <dl>
            <div class="spec-row"><dt>Longueur</dt><dd>5 021 mm</dd></div>
            <div class="spec-row"><dt>Largeur</dt><dd>1 987 mm</dd></div>
            <div class="spec-row"><dt>Hauteur</dt><dd>1 431 mm</dd></div>
            <div class="spec-row"><dt>Coffre</dt><dd>793 L</dd></div>
          </dl>
        </div>
      </div>
    </section>
<section class="reservation-cta reveal reveal-up reveal-delay-2">
      <div class="cta-box">
        <h2>Essayez la Tesla Model S Plaid 2026</h2>
        <p>Réservez votre essai gratuit dès maintenant et découvrez l'expérience de conduite électrique EcoDrive.</p>
        <a href="../php/reservation.php?car=14" class="cta-btn">Réserver un essai gratuit</a>
      </div>
    </section>
  </main>

<?php include __DIR__ . '/../php/partials/footer.php'; ?>

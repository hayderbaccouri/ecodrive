<?php
include '../php/configuration.php';
$loggedIn = isset($_SESSION['user']);
$page_title = 'BYD Atto 3 â€” EcoDrive';
$page_desc  = 'BYD Atto 3, SUV compact Ã©lectrique au design audacieux. Autonomie 420 km WLTP. RÃ©servez votre essai.';
$page_url   = 'voitures/BYD-Atto-3.php';
$page_image = 'images/byd-atto-3/byd-atto-3.webp';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BYD Atto 3 â€” EcoDrive</title>
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E%26%23x26A1%3B%3C/text%3E%3C/svg%3E">
  <link rel="stylesheet" href="../css/style.css?v=15">
  <?php include __DIR__ . '/../php/partials/meta.php'; ?>
  <?php $jsonld_type = 'product'; $jsonld_product = ['name' => 'BYD Atto 3', 'description' => htmlspecialchars($page_desc, ENT_QUOTES, 'UTF-8'), 'image' => 'https://ecodrive.tn/'.$page_image, 'brand' => 'BYD', 'price' => '123990']; include __DIR__ . '/../php/partials/jsonld.php'; ?>
</head>
<body>
<?php $asset_base = '../'; include __DIR__ . '/../php/partials/header.php'; ?>

<nav class="breadcrumb" aria-label="breadcrumb">
  <a href="../index.php">Accueil</a> / <a href="../php/catalogue.php">Catalogue</a> / <span class="breadcrumb-current">BYD Atto 3</span>
</nav>

<main class="page-fade-in">
    <?php include '../php/car_slider.php'; renderCarSlider('images/byd-atto-3/', 'byd-atto-3.webp', 'BYD Atto 3'); ?>
    <div class="car-actions-bar">
      <div class="price-block">
        <span class="price-label">Ã€ partir de</span>
        <span class="price-value">123 990 <small>DT</small></span>
      </div>
      <a href="../php/reservation.php?car=3" class="btn-reserve">RÃ©server un essai</a>
    </div>

    <section class="car-overview reveal reveal-up">
      <div class="overview-desc"><div class="desc-card"><p>SUV compact 100% Ã©lectrique BYD e-Platform 3.0. 313 ch propulsion, batterie Blade LFP 74,8 kWh, autonomie 510 km WLTP, architecture 800V, recharge DC 220 kW (10-80% en 25 min).</p></div></div>
      <div class="specs-highlight">
      <div class="spec-card">
        <div class="spec-label">Puissance</div>
        <div class="spec-value">313 ch<small>230 kW</small></div>
      </div>
      <div class="spec-card">
        <div class="spec-label">Batterie</div>
        <div class="spec-value">74,8 kWh<small>Blade LFP</small></div>
      </div>
      <div class="spec-card">
        <div class="spec-label">Autonomie</div>
        <div class="spec-value">510 km<small>Cycle WLTP</small></div>
      </div>
      <div class="spec-card">
        <div class="spec-label">0-100 km/h</div>
        <div class="spec-value">5,5 s<small>180 km/h</small></div>
      </div>
      <div class="spec-card">
        <div class="spec-label">Poids</div>
        <div class="spec-value">1 850 kg<small>Coffre 440 L</small></div>
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
            <div class="spec-row"><dt>Puissance max</dt><dd>313 ch (230 kW)</dd></div>
            <div class="spec-row"><dt>Couple max</dt><dd>480 Nm</dd></div>
            <div class="spec-row"><dt>Transmission</dt><dd>Propulsion (RWD)</dd></div>
            <div class="spec-row"><dt>Vitesse max</dt><dd>180 km/h</dd></div>
          </dl>
        </div>
        <div class="spec-group">
          <h3>Batterie & Autonomie</h3>
          <dl>
            <div class="spec-row"><dt>CapacitÃ© batterie</dt><dd>74,8 kWh</dd></div>
            <div class="spec-row"><dt>Type de batterie</dt><dd>Blade LFP</dd></div>
            <div class="spec-row"><dt>Autonomie WLTP</dt><dd>510 km</dd></div>
            <div class="spec-row"><dt>Architecture</dt><dd>800V</dd></div>
          
            <div class="spec-row battery-visual"><dt>Niveau</dt><dd><div class="battery-bar"><div class="battery-track"><div class="battery-fill high" data-width="69%"></div></div><span class="battery-label">74.8 kWh</span></div></dd></div></dl>
        </div>
        <div class="spec-group">
          <h3>Recharge</h3>
          <dl>
            <div class="spec-row"><dt>AC (Wallbox)</dt><dd>7 h (11 kW)</dd></div>
            <div class="spec-row"><dt>DC (Rapide)</dt><dd>25 min (10-80%, 220 kW)</dd></div>
          </dl>
        </div>
        <div class="spec-group">
          <h3>Dimensions</h3>
          <dl>
            <div class="spec-row"><dt>Longueur</dt><dd>4 455 mm</dd></div>
            <div class="spec-row"><dt>Largeur</dt><dd>1 875 mm</dd></div>
            <div class="spec-row"><dt>Hauteur</dt><dd>1 615 mm</dd></div>
            <div class="spec-row"><dt>Coffre</dt><dd>440 L</dd></div>
          </dl>
        </div>
      </div>
    </section>
<section class="reservation-cta reveal reveal-up reveal-delay-2">
      <div class="cta-box">
        <h2>Essayez la BYD Atto 3</h2>
        <p>RÃ©servez votre essai gratuit dÃ¨s maintenant et dÃ©couvrez l'expÃ©rience de conduite Ã©lectrique EcoDrive.</p>
        <a href="../php/reservation.php?car=3" class="cta-btn">RÃ©server un essai gratuit</a>
      </div>
    </section>
  </main>

<?php include __DIR__ . '/../php/partials/footer.php'; ?>

<?php
include '../php/configuration.php';
$loggedIn = isset($_SESSION['user']);
$page_title = 'Peugeot e-208 â€” EcoDrive';
$page_desc  = 'Peugeot e-208, citadine Ã©lectrique chic et agile. Autonomie 362 km WLTP. DÃ©couvrez-la.';
$page_url   = 'voitures/Peugeot-e-208.php';
$page_image = 'images/peugeot-e-208/E-208_gallery_exterior_3_D_1920x1080.jpg';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Peugeot e-208 â€” EcoDrive</title>
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E%26%23x26A1%3B%3C/text%3E%3C/svg%3E">
  <link rel="stylesheet" href="../css/style.css?v=15">
  <?php include __DIR__ . '/../php/partials/meta.php'; ?>
  <?php $jsonld_type = 'product'; $jsonld_product = ['name' => 'Peugeot e-208', 'description' => htmlspecialchars($page_desc, ENT_QUOTES, 'UTF-8'), 'image' => 'https://ecodrive.tn/'.$page_image, 'brand' => 'Peugeot', 'price' => '80000']; include __DIR__ . '/../php/partials/jsonld.php'; ?>
</head>
<body>
<?php $asset_base = '../'; include __DIR__ . '/../php/partials/header.php'; ?>

<nav class="breadcrumb" aria-label="breadcrumb">
  <a href="../index.php">Accueil</a> / <a href="../php/catalogue.php">Catalogue</a> / <span class="breadcrumb-current">Peugeot e-208</span>
</nav>

<main class="page-fade-in">
    <?php include '../php/car_slider.php'; renderCarSlider('images/peugeot-e-208/', 'E-208_gallery_exterior_3_D_1920x1080.jpg', 'Peugeot e-208'); ?>
    <div class="car-actions-bar">
      <div class="price-block">
        <span class="price-label">Ã€ partir de</span>
        <span class="price-value">80 000 <small>DT</small></span>
      </div>
      <a href="../php/reservation.php?car=10" class="btn-reserve">RÃ©server un essai</a>
    </div>

    <section class="car-overview reveal reveal-up">
      <div class="overview-desc"><div class="desc-card"><p>Citadine Ã©lectrique franÃ§aise au design affirmÃ©. 156 ch, batterie 54 kWh, autonomie 433 km WLTP, recharge DC 100 kW (20-80% en 27 min). i-Cockpit, agrÃ©ment de conduite.</p></div></div>
      <div class="specs-highlight">
      <div class="spec-card">
        <div class="spec-label">Puissance</div>
        <div class="spec-value">156 ch<small>115 kW</small></div>
      </div>
      <div class="spec-card">
        <div class="spec-label">Batterie</div>
        <div class="spec-value">54 kWh<small>Lithium-ion NMC</small></div>
      </div>
      <div class="spec-card">
        <div class="spec-label">Autonomie</div>
        <div class="spec-value">433 km<small>Cycle WLTP</small></div>
      </div>
      <div class="spec-card">
        <div class="spec-label">0-100 km/h</div>
        <div class="spec-value">8,1 s<small>150 km/h</small></div>
      </div>
      <div class="spec-card">
        <div class="spec-label">Poids</div>
        <div class="spec-value">1 530 kg<small>Coffre 311 L</small></div>
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
            <div class="spec-row"><dt>Couple max</dt><dd>260 Nm</dd></div>
            <div class="spec-row"><dt>Transmission</dt><dd>Traction (FWD)</dd></div>
            <div class="spec-row"><dt>Vitesse max</dt><dd>150 km/h</dd></div>
          </dl>
        </div>
        <div class="spec-group">
          <h3>Batterie & Autonomie</h3>
          <dl>
            <div class="spec-row"><dt>CapacitÃ© batterie</dt><dd>54 kWh</dd></div>
            <div class="spec-row"><dt>Type de batterie</dt><dd>Lithium-ion NMC</dd></div>
            <div class="spec-row"><dt>Autonomie WLTP</dt><dd>433 km</dd></div>
            <div class="spec-row"><dt>Ã‰missions COâ‚‚</dt><dd>0 g/km COâ‚‚</dd></div>
          
            <div class="spec-row battery-visual"><dt>Niveau</dt><dd><div class="battery-bar"><div class="battery-track"><div class="battery-fill high" data-width="50%"></div></div><span class="battery-label">54 kWh</span></div></dd></div></dl>
        </div>
        <div class="spec-group">
          <h3>Recharge</h3>
          <dl>
            <div class="spec-row"><dt>AC (Wallbox)</dt><dd>5 h (11 kW)</dd></div>
            <div class="spec-row"><dt>DC (Rapide)</dt><dd>25 min (10-80%, 100 kW)</dd></div>
          </dl>
        </div>
        <div class="spec-group">
          <h3>Dimensions</h3>
          <dl>
            <div class="spec-row"><dt>Longueur</dt><dd>4 055 mm</dd></div>
            <div class="spec-row"><dt>Largeur</dt><dd>1 745 mm</dd></div>
            <div class="spec-row"><dt>Hauteur</dt><dd>1 430 mm</dd></div>
            <div class="spec-row"><dt>Coffre</dt><dd>311 L</dd></div>
          </dl>
        </div>
      </div>
    </section>
<section class="reservation-cta reveal reveal-up reveal-delay-2">
      <div class="cta-box">
        <h2>Essayez la Peugeot e-208</h2>
        <p>RÃ©servez votre essai gratuit dÃ¨s maintenant et dÃ©couvrez l'expÃ©rience de conduite Ã©lectrique EcoDrive.</p>
        <a href="../php/reservation.php?car=10" class="cta-btn">RÃ©server un essai gratuit</a>
      </div>
    </section>
  </main>

<?php include __DIR__ . '/../php/partials/footer.php'; ?>

<?php
include '../php/configuration.php';
$loggedIn = isset($_SESSION['user']);
$page_title = 'Mercedes EQC — EcoDrive';
$page_desc  = 'Mercedes EQC, premier SUV électrique Mercedes. 419 km d autonomie, luxe et performance.';
$page_url   = 'voitures/mercedes-EQC.php';
$page_image = 'images/mercedes-eqc/mercedes-eqc.jpg';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mercedes EQC 400 4MATIC — EcoDrive</title>
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E%26%23x26A1%3B%3C/text%3E%3C/svg%3E">
  <link rel="stylesheet" href="../css/style.css?v=13">
  <?php include __DIR__ . '/../php/partials/meta.php'; ?>
  <?php $jsonld_type = 'product'; $jsonld_product = ['name' => 'Mercedes-Benz EQC 400 4MATIC', 'description' => htmlspecialchars($page_desc, ENT_QUOTES, 'UTF-8'), 'image' => 'https://ecodrive.tn/'.$page_image, 'brand' => 'Mercedes-Benz', 'price' => '280000']; include __DIR__ . '/../php/partials/jsonld.php'; ?>
</head>
<body>
<?php $asset_base = '../'; include __DIR__ . '/../php/partials/header.php'; ?>

<nav class="breadcrumb" aria-label="breadcrumb">
  <a href="../index.php">Accueil</a> / <a href="../php/catalogue.php">Catalogue</a> / <span class="breadcrumb-current">Mercedes EQC 400 4MATIC</span>
</nav>

<main class="page-fade-in">
    <?php include '../php/car_slider.php'; renderCarSlider('images/mercedes-eqc/', 'mercedes-eqc.jpg', 'Mercedes EQC 400'); ?>
    <div class="car-actions-bar">
      <div class="price-block">
        <span class="price-label">À partir de</span>
        <span class="price-value">280 000 <small>DT</small></span>
      </div>
      <a href="../php/reservation.php?car=8" class="btn-reserve">Réserver un essai</a>
    </div>

    <section class="car-overview reveal reveal-up">
      <div class="overview-desc"><div class="desc-card"><p>SUV premium électrique Mercedes. 408 ch, transmission intégrale 4MATIC, batterie 80 kWh, autonomie 432 km WLTP, recharge DC 112 kW. Confort absolu, système MBUX, design élégant.</p></div></div>
      <div class="specs-highlight">
      <div class="spec-card">
        <div class="spec-label">Puissance</div>
        <div class="spec-value">408 ch<small>300 kW</small></div>
      </div>
      <div class="spec-card">
        <div class="spec-label">Batterie</div>
        <div class="spec-value">80 kWh<small>Lithium-ion NMC</small></div>
      </div>
      <div class="spec-card">
        <div class="spec-label">Autonomie</div>
        <div class="spec-value">432 km<small>Cycle WLTP</small></div>
      </div>
      <div class="spec-card">
        <div class="spec-label">0-100 km/h</div>
        <div class="spec-value">5,1 s<small>180 km/h</small></div>
      </div>
      <div class="spec-card">
        <div class="spec-label">Poids</div>
        <div class="spec-value">2 495 kg<small>Coffre 500 L</small></div>
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
            <div class="spec-row"><dt>Couple max</dt><dd>760 Nm</dd></div>
            <div class="spec-row"><dt>Transmission</dt><dd>Intégrale (4MATIC)</dd></div>
            <div class="spec-row"><dt>Vitesse max</dt><dd>180 km/h</dd></div>
          </dl>
        </div>
        <div class="spec-group">
          <h3>Batterie & Autonomie</h3>
          <dl>
            <div class="spec-row"><dt>Capacité batterie</dt><dd>80 kWh</dd></div>
            <div class="spec-row"><dt>Type de batterie</dt><dd>Lithium-ion NMC</dd></div>
            <div class="spec-row"><dt>Autonomie WLTP</dt><dd>432 km</dd></div>
            <div class="spec-row"><dt>Émissions CO₂</dt><dd>0 g/km CO₂</dd></div>
          
            <div class="spec-row battery-visual"><dt>Niveau</dt><dd><div class="battery-bar"><div class="battery-track"><div class="battery-fill high" data-width="74%"></div></div><span class="battery-label">80 kWh</span></div></dd></div></dl>
        </div>
        <div class="spec-group">
          <h3>Recharge</h3>
          <dl>
            <div class="spec-row"><dt>AC (Wallbox)</dt><dd>7 h 30 (11 kW)</dd></div>
            <div class="spec-row"><dt>DC (Rapide)</dt><dd>30 min (10-80%, 110 kW)</dd></div>
          </dl>
        </div>
        <div class="spec-group">
          <h3>Dimensions</h3>
          <dl>
            <div class="spec-row"><dt>Longueur</dt><dd>4 762 mm</dd></div>
            <div class="spec-row"><dt>Largeur</dt><dd>1 884 mm</dd></div>
            <div class="spec-row"><dt>Hauteur</dt><dd>1 624 mm</dd></div>
            <div class="spec-row"><dt>Coffre</dt><dd>500 L</dd></div>
          </dl>
        </div>
      </div>
    </section>
<section class="reservation-cta reveal reveal-up reveal-delay-2">
      <div class="cta-box">
        <h2>Essayez la Mercedes EQC 400 4MATIC</h2>
        <p>Réservez votre essai gratuit dès maintenant et découvrez l'expérience de conduite électrique EcoDrive.</p>
        <a href="../php/reservation.php?car=8" class="cta-btn">Réserver un essai gratuit</a>
      </div>
    </section>
  </main>

<?php include __DIR__ . '/../php/partials/footer.php'; ?>
<script>
document.querySelectorAll('.car-slider').forEach(function(s) {
  var track = s.querySelector('.slider-track');
  var slides = track.querySelectorAll('.slider-slide');
  if (slides.length < 2) return;
  var prev = s.querySelector('.slider-prev');
  var next = s.querySelector('.slider-next');
  var dotsEl = s.querySelector('.slider-dots');
  var cur = 0;
  for (var i = 0; i < slides.length; i++) {
    var dot = document.createElement('button');
    dot.className = 'slider-dot' + (i === 0 ? ' active' : '');
    dot.setAttribute('aria-label', 'Image ' + (i + 1));
    (function(idx){dot.addEventListener('click',function(){go(idx);});})(i);
    dotsEl.appendChild(dot);
  }
  function go(idx) {
    cur = (idx + slides.length) % slides.length;
    track.style.transform = 'translateX(-' + (cur * 100) + '%)';
    dotsEl.querySelectorAll('.slider-dot').forEach(function(d,i){d.classList.toggle('active',i===cur);});
  }
  if (prev) prev.addEventListener('click', function() { go(cur - 1); });
  if (next) next.addEventListener('click', function() { go(cur + 1); });
});
</script>
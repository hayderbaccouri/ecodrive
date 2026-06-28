<?php
session_start();
include '../php/configuration.php';
$loggedIn = isset($_SESSION['user']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BYD Dolphin Surf â€” EcoDrive</title>
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E%26%23x26A1%3B%3C/text%3E%3C/svg%3E">
  <link rel="stylesheet" href="../css/voitures.css">
  <link rel="stylesheet" href="../css/header.css" />
</head>
<body>
  <header class="site-header">
    <a href="../index.php" class="logo-text">eco<span>drive</span></a>
    <nav>
      <a href="../index.php">Accueil</a>
      <a href="../php/catalogue.php">Catalogue</a>
      <a href="../index.php#bornes">Bornes</a>
      <a href="../pages/contact.php">Contact</a>
      <?php if ($loggedIn): ?>
        <?php $prenom = explode(' ', $_SESSION['user']['nom'] ?? 'Client')[0]; $initial = mb_strtoupper(mb_substr($prenom, 0, 1)); $dashPage = '../php/' . (($_SESSION['user']['role'] ?? 'client') === 'admin' ? 'admin.php' : 'tableau-de-bord.php'); ?>
        <div class="user-menu">
          <div class="user-badge">
            <div class="avatar"><?= $initial ?></div>
            <span class="user-name"><?= htmlspecialchars($prenom) ?></span>
            <span class="chevron">â–¾</span>
          </div>
          <div class="user-dropdown">
            <a href="<?= $dashPage ?>">Mon espace</a>
            <hr>
            <a href="../php/deconnexion.php" class="logout">DÃ©connexion</a>
          </div>
        </div>
      <?php else: ?>
        <a href="../php/connexion.php">Se connecter</a>
        <a href="../php/inscription.php" class="nav-cta">S'inscrire</a>
      <?php endif; ?>
      <button class="burger" aria-label="Menu" onclick="this.classList.toggle('open');document.querySelector('.site-header nav').classList.toggle('open')"><span></span><span></span><span></span></button>
    </nav>
  </header>

  <main class="page-fade-in">
    <?php include '../php/car_slider.php'; renderCarSlider('images/byd-dolphin/', 'byd-dolphin.jpg', 'BYD Dolphin Surf'); ?>
    <div class="car-actions-bar">
      <div class="price-block">
        <span class="price-label">Ã€ partir de</span>
        <span class="price-value">55 000 <small>DT</small></span>
      </div>
      <a href="../php/reservation.php?car=4" class="btn-reserve">RÃ©server un essai</a>
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
            <div class="spec-row"><dt>CapacitÃ© batterie</dt><dd>43,2 kWh</dd></div>
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
        <p>RÃ©servez votre essai gratuit dÃ¨s maintenant et dÃ©couvrez l'expÃ©rience de conduite Ã©lectrique EcoDrive.</p>
        <a href="../php/reservation.php?car=4" class="cta-btn">RÃ©server un essai gratuit</a>
      </div>
    </section>
  </main>

  <footer>
    <p>&copy; 2026 EcoDrive â€” Showroom de voitures Ã©lectriques</p>
  </footer>
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
<button class="back-to-top" aria-label="Retour en haut">&uarr;</button>
<script src="../js/app.js"></script>
</body>
</html>
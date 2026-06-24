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
  <title>Audi A6 Sportback e-tron — EcoDrive</title>
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E%26%23x26A1%3B%3C/text%3E%3C/svg%3E">
  <link rel="stylesheet" href="../css/voitures.css">
</head>
<body>
  <header>
    <a href="../index.php" class="logo-text">eco<span>drive</span></a>
    <nav>
      <a href="../index.php">Accueil</a>
      <a href="../php/catalogue.php">Catalogue</a>
      <?php if ($loggedIn): ?>
        <a href="../php/<?= ($_SESSION['user']['role'] ?? 'client') === 'admin' ? 'admin.php' : 'tableau-de-bord.php' ?>">Mon espace</a>
        <a href="../php/deconnexion.php">Déconnexion</a>
      <?php else: ?>
        <a href="../php/connexion.php">Connexion / Inscription</a>
      <?php endif; ?>
    </nav>
  </header>

  <main>
    <section class="car-hero">
      <div class="hero-image-wrap">
        <img loading="lazy" src="../images/audi-a6-sportback-e-tron.avif" alt="Audi A6 Sportback e-tron">
        <div class="hero-overlay">
          <h1>Audi A6 Sportback e-tron</h1>
          <p class="hero-tagline">Berline premium allemande, élégante et technologique. Confort routier exceptionnel, double écran tactile MMI, autonomie élevée.</p>
        </div>
      </div>
    </section>

    <div class="car-actions-bar">
      <div class="price-block">
        <span class="price-label">À partir de</span>
        <span class="price-value">239 000 <small>DT</small></span>
      </div>
      <a href="../php/reservation.php?car=1" class="btn-reserve">Réserver un essai</a>
    </div>

    <section class="specs-highlight">
      <div class="spec-card">
        <div class="spec-label">Puissance</div>
        <div class="spec-value">367 ch<small>270 kW</small></div>
      </div>
      <div class="spec-card">
        <div class="spec-label">Batterie</div>
        <div class="spec-value">83 kWh<small>Lithium-ion NMC</small></div>
      </div>
      <div class="spec-card">
        <div class="spec-label">Autonomie</div>
        <div class="spec-value">520 km<small>Cycle WLTP</small></div>
      </div>
      <div class="spec-card">
        <div class="spec-label">0-100 km/h</div>
        <div class="spec-value">5,4 s<small>210 km/h</small></div>
      </div>
      <div class="spec-card">
        <div class="spec-label">Poids</div>
        <div class="spec-value">2 175 kg<small>Coffre 502 L</small></div>
      </div>
    </section>

    <div class="section-title-wrap">
      <h2>Fiche technique</h2>
    </div>

    <section class="specs-detail">
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
            <div class="spec-row"><dt>Capacité batterie</dt><dd>83 kWh</dd></div>
            <div class="spec-row"><dt>Type de batterie</dt><dd>Lithium-ion NMC</dd></div>
            <div class="spec-row"><dt>Autonomie WLTP</dt><dd>520 km</dd></div>
            <div class="spec-row"><dt>Émissions CO₂</dt><dd>0 g/km CO₂</dd></div>
          </dl>
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

    <section class="reservation-cta">
      <div class="cta-box">
        <h2>Essayez la Audi A6 Sportback e-tron</h2>
        <p>Réservez votre essai gratuit dès maintenant et découvrez l'expérience de conduite électrique EcoDrive.</p>
        <a href="../php/reservation.php?car=1" class="cta-btn">Réserver un essai gratuit</a>
      </div>
    </section>
  </main>

  <footer>
    <p>&copy; 2026 EcoDrive — Showroom de voitures électriques</p>
  </footer>
</body>
</html>
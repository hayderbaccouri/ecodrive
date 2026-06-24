<!DOCTYPE html>
<html lang="fr">
<?php
session_start();
include '../php/configuration.php';
$loggedIn = isset($_SESSION['user']);
?>

<head>
  <meta charset="UTF-8">
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E%26%23x26A1%3B%3C/text%3E%3C/svg%3E">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Exicom Spin Free 3 kW — EcoDrive</title>
  
  <link rel="stylesheet" href="../css/bornes.css">

</head>

<body>
  <div class="topbar">✦ Premier showroom de voitures électriques en Tunisie — Essai gratuit disponible</div>

  <header>
    <a href="../index.php" class="logo-text">eco<span>drive</span></a>
    <nav>
      <a href="../index.php">Accueil</a>
      <a href="../php/catalogue.php">Catalogue</a>
      <a href="../index.php#bornes">Bornes</a>
      <a href="../pages/contact.php">Contact</a>
      <?php if ($loggedIn): ?>
        <a href="../php/<?= ($_SESSION['user']['role'] ?? 'client') === 'admin' ? 'admin.php' : 'tableau-de-bord.php' ?>">Mon espace</a>
        <a href="../php/deconnexion.php">Déconnexion</a>
      <?php else: ?>
        <a href="../php/connexion.php">Connexion / Inscription</a>
      <?php endif; ?>
    </nav>
  </header>

  <div class="breadcrumb">
    <a href="../index.php">Accueil</a>
    <span>›</span>
    <a href="../index.php#bornes">Bornes de recharge</a>
    <span>›</span>
    <span style="color: var(--text)">Exicom Spin Free 3 kW</span>
  </div>

  <!-- HERO -->
  <section class="borne-hero">

    <div class="borne-visual">
      <div class="borne-visual-bg"></div>
      <div class="borne-visual-grid"></div>
      <div class="borne-img-frame">
        <div class="borne-img-box">
          <img src="../images/SPIN-FREE-3.png" alt="Exicom Spin Free 3 kW"
            onerror="this.style.display='none'; this.parentNode.innerHTML += '<div style=\'font-size:6rem;color:rgba(82,183,136,0.4)\'>⚡</div>'">
        </div>
        <span class="borne-badge-portable">⚡ Portable · Plug &amp; Charge</span>
      </div>
      <div class="borne-glow-dot"></div>
    </div>

    <div class="borne-info">
      <div class="borne-eyebrow">Chargeur portable · Exicom</div>

      <div class="borne-power-display">
        <span class="power-num">3</span>
        <span class="power-unit">kW</span>
      </div>

      <div class="borne-title">Exicom Spin Free</div>

      <div class="borne-divider"></div>

      <p class="borne-desc-text">
        Chargeur portable compact conçu pour la recharge d'appoint, les déplacements et les situations de secours.
        Branchez, rechargez, repartez — sans installation fixe.
      </p>

      <div class="specs-list">
        <div class="spec-row">
          <div class="spec-icon">⚡</div>
          <div class="spec-label">Puissance</div>
          <div class="spec-value">3 kW (monophasé)</div>
        </div>
        <div class="spec-row">
          <div class="spec-icon">🔌</div>
          <div class="spec-label">Connecteur</div>
          <div class="spec-value">Type 2 (IEC 62196)</div>
        </div>
        <div class="spec-row">
          <div class="spec-icon">📏</div>
          <div class="spec-label">Longueur de câble</div>
          <div class="spec-value">5 mètres</div>
        </div>
        <div class="spec-row">
          <div class="spec-icon">🏠</div>
          <div class="spec-label">Prise source</div>
          <div class="spec-value">Schuko / 230 V domestique</div>
        </div>
        <div class="spec-row">
          <div class="spec-icon">🌿</div>
          <div class="spec-label">Usage</div>
          <div class="spec-value">Voyage · Secours · Domicile</div>
        </div>
      </div>

      <div class="borne-price-bar">
      <span class="borne-price-label">À partir de</span>
      <span class="borne-price-value">1 290 DT</span>
      <span class="borne-price-tax">HT · Installation non incluse</span>
    </div>
    <div class="borne-cta">
      <a href="../pages/contact.php" class="btn-primary">Commander</a>
      <a href="../pages/contact.php" class="btn-ghost">Demander un devis</a>
    </div>
    </div>
  </section>

  <!-- COMMENT ÇA MARCHE -->
  <section class="how-section">
    <div class="section-eyebrow">Mode d'emploi</div>
    <h2 class="section-title">Recharge en 3 étapes</h2>
    <div class="section-rule"></div>
    <div class="steps-grid">
      <div class="step-card">
        <div class="step-num">01</div>
        <div class="step-title">Branchez à la prise</div>
        <p class="step-text">Connectez l'Exicom Spin Free à n'importe quelle prise Schuko domestique standard 230 V.
          Aucun câblage électrique requis.</p>
      </div>
      <div class="step-card">
        <div class="step-num">02</div>
        <div class="step-title">Reliez au véhicule</div>
        <p class="step-text">Connectez l'extrémité Type 2 au port de recharge de votre véhicule électrique. Le câble de
          5 m offre une grande liberté de positionnement.</p>
      </div>
      <div class="step-card">
        <div class="step-num">03</div>
        <div class="step-title">Rechargez &amp; repartez</div>
        <p class="step-text">La recharge démarre automatiquement. À 3 kW, comptez environ 6 à 8 h pour un ajout de 20 à
          25 kWh selon votre batterie.</p>
      </div>
    </div>
  </section>

  <!-- SPECS COMPLÈTES -->
  <section class="specs-section">
    <div class="section-eyebrow">Fiche technique</div>
    <h2 class="section-title">Spécifications complètes</h2>
    <div class="section-rule"></div>
    <table class="specs-table">
      <thead>
        <tr>
          <th>Paramètre</th>
          <th>Valeur</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Marque / Modèle</td>
          <td>Exicom Spin Free</td>
        </tr>
        <tr>
          <td>Puissance de sortie</td>
          <td>3 kW</td>
        </tr>
        <tr>
          <td>Type de courant</td>
          <td>AC monophasé</td>
        </tr>
        <tr>
          <td>Tension d'entrée</td>
          <td>230 V / 50 Hz</td>
        </tr>
        <tr>
          <td>Courant maximum</td>
          <td>13 A</td>
        </tr>
        <tr>
          <td>Connecteur côté véhicule</td>
          <td>Type 2 (IEC 62196-2)</td>
        </tr>
        <tr>
          <td>Prise côté réseau</td>
          <td>Schuko (CEE 7/4)</td>
        </tr>
        <tr>
          <td>Longueur de câble</td>
          <td>5 m</td>
        </tr>
        <tr>
          <td>Indice de protection</td>
          <td>IP54</td>
        </tr>
        <tr>
          <td>Température de fonctionnement</td>
          <td>-20 °C à +55 °C</td>
        </tr>
        <tr>
          <td>Format</td>
          <td>Portable, léger, transportable</td>
        </tr>
        <tr>
          <td>Certifications</td>
          <td>CE, RoHS</td>
        </tr>
        <tr>
          <td>Garantie</td>
          <td>2 ans constructeur</td>
        </tr>
      </tbody>
    </table>
  </section>

  <!-- COMPATIBILITÉ -->
  <section class="compat-section">
    <div class="section-eyebrow">Compatibilité universelle</div>
    <h2 class="section-title">Compatible avec tous les VE Type 2</h2>
    <div class="section-rule"></div>
    <div class="compat-grid">
      <div class="compat-card">
        <div class="compat-icon">🔵</div>
        <div class="compat-name">Renault Megane E-Tech</div>
        <div class="compat-sub">Type 2 · Compatible</div>
      </div>
      <div class="compat-card">
        <div class="compat-icon">🟢</div>
        <div class="compat-name">Volkswagen ID.4</div>
        <div class="compat-sub">Type 2 · Compatible</div>
      </div>
      <div class="compat-card">
        <div class="compat-icon">⚪</div>
        <div class="compat-name">Hyundai IONIQ 6</div>
        <div class="compat-sub">Type 2 · Compatible</div>
      </div>
      <div class="compat-card">
        <div class="compat-icon">🔴</div>
        <div class="compat-name">Citroën C3 Electric</div>
        <div class="compat-sub">Type 2 · Compatible</div>
      </div>
    </div>
    <p style="margin-top: 2rem; font-size: 0.8rem; color: var(--muted); text-align: center;">
      Compatible avec tous les véhicules électriques équipés d'un port Type 2 — la norme européenne universelle.
    </p>
  </section>

  <!-- CTA BANNER -->
  <section class="cta-banner">
    <div>
      <div class="cta-banner-title">Prêt à passer à l'électrique ?</div>
      <div class="cta-banner-sub">Commandez votre Exicom Spin Free ou obtenez un devis personnalisé.</div>
    </div>
    <a href="../pages/contact.php#contact" class="btn-white">Contacter EcoDrive</a>
  </section>

  <footer>
    <div class="footer-logo">eco<span>drive</span></div>
    <span>© 2026 EcoDrive. Tous droits réservés.</span>
    <nav>
      <a href="../pages/mentions-legales.php">Mentions légales</a>
      <a href="../pages/confidentialite.php">Confidentialité</a>
      <a href="../pages/contact.php">Contact</a>
    </nav>
  </footer>

</body>

</html>

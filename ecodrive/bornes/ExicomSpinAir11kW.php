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
  <title>Exicom Spin Air 11 kW — EcoDrive</title>
  
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
    <span class="breadcrumb-current">Exicom Spin Air 11 kW</span>
  </div>

  <!-- HERO -->
  <section class="borne-hero">

    <div class="borne-visual">
      <div class="borne-visual-bg"></div>
      <div class="borne-visual-grid"></div>
      <div class="borne-img-frame">
        <div class="borne-img-box">
          <img src="../images/SPIN-AIR-11 (1).png" alt="Exicom Spin Air 11 kW"
            onerror="this.style.display='none'; this.parentNode.innerHTML += '<div class=\'borne-fallback-icon\'>⚡</div>'">
        </div>
        <span class="borne-badge-portable">⚡ Triphasé · Semi-professionnel</span>
      </div>
      <div class="borne-glow-dot"></div>
    </div>

    <div class="borne-info">
      <div class="borne-eyebrow">Chargeur triphasé · Exicom</div>

      <div class="borne-power-display">
        <span class="power-num">11</span>
        <span class="power-unit">kW</span>
      </div>

      <div class="borne-title">Exicom Spin Air</div>

      <div class="borne-divider"></div>

      <p class="borne-desc-text">
        Solution triphasée haute performance pour maisons équipées, bureaux et parkings privés à usage régulier. La Spin
        Air 11 kW réduit le temps de recharge de moitié par rapport au monophasé, avec une gestion intelligente de
        l'énergie intégrée.
      </p>

      <div class="specs-list">
        <div class="spec-row">
          <div class="spec-icon">⚡</div>
          <div class="spec-label">Puissance</div>
          <div class="spec-value">11 kW (triphasé)</div>
        </div>
        <div class="spec-row">
          <div class="spec-icon">🔌</div>
          <div class="spec-label">Connecteur</div>
          <div class="spec-value">Type 2 (IEC 62196)</div>
        </div>
        <div class="spec-row">
          <div class="spec-icon">📶</div>
          <div class="spec-label">Connectivité</div>
          <div class="spec-value">Wi-Fi · Bluetooth · 4G/LTE</div>
        </div>
        <div class="spec-row">
          <div class="spec-icon">🏢</div>
          <div class="spec-label">Installation</div>
          <div class="spec-value">Intérieure ou extérieure</div>
        </div>
        <div class="spec-row">
          <div class="spec-icon">📱</div>
          <div class="spec-label">Contrôle</div>
          <div class="spec-value">Application mobile + programmation</div>
        </div>
      </div>

      <div class="borne-price-bar">
      <span class="borne-price-label">À partir de</span>
      <span class="borne-price-value">3 290 DT</span>
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
    <h2 class="section-title">Recharge triphasée en 3 étapes</h2>
    <div class="section-rule"></div>
    <div class="steps-grid">
      <div class="step-card">
        <div class="step-num">01</div>
        <div class="step-title">Installation triphasée</div>
        <p class="step-text">Un électricien qualifié raccorde la borne à votre tableau triphasé. Compatible intérieur et
          extérieur, elle s'intègre dans un garage, un parking ou une façade de bureau.</p>
      </div>
      <div class="step-card">
        <div class="step-num">02</div>
        <div class="step-title">Connexion intelligente</div>
        <p class="step-text">Configurez la borne via Wi-Fi ou 4G/LTE. Programmez vos horaires, suivez la consommation en
          temps réel et recevez des notifications depuis l'application EcoDrive.</p>
      </div>
      <div class="step-card">
        <div class="step-num">03</div>
        <div class="step-title">Recharge rapide &amp; efficace</div>
        <p class="step-text">À 11 kW triphasé, une session de 2 à 4 h suffit pour la plupart des véhicules. Idéal pour
          les utilisateurs à forte mobilité quotidienne.</p>
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
          <td>Exicom Spin Air</td>
        </tr>
        <tr>
          <td>Puissance de sortie</td>
          <td>11 kW</td>
        </tr>
        <tr>
          <td>Type de courant</td>
          <td>AC triphasé</td>
        </tr>
        <tr>
          <td>Tension d'entrée</td>
          <td>400 V / 50 Hz (3 phases)</td>
        </tr>
        <tr>
          <td>Courant maximum</td>
          <td>16 A par phase</td>
        </tr>
        <tr>
          <td>Connecteur côté véhicule</td>
          <td>Type 2 (IEC 62196-2)</td>
        </tr>
        <tr>
          <td>Connectivité</td>
          <td>Wi-Fi, Bluetooth, 4G/LTE (selon config.)</td>
        </tr>
        <tr>
          <td>Contrôle</td>
          <td>Application mobile, programmation horaire, OCPP 1.6</td>
        </tr>
        <tr>
          <td>Installation</td>
          <td>Intérieure ou extérieure</td>
        </tr>
        <tr>
          <td>Indice de protection</td>
          <td>IP55</td>
        </tr>
        <tr>
          <td>Température de fonctionnement</td>
          <td>-25 °C à +55 °C</td>
        </tr>
        <tr>
          <td>Certifications</td>
          <td>CE, RoHS, IEC 61851</td>
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
        <div class="compat-name">Audi A6 e-tron</div>
        <div class="compat-sub">Type 2 · Compatible</div>
      </div>
    </div>
    <p class="compat-note">
      Compatible avec tous les véhicules électriques équipés d'un port Type 2 acceptant la charge triphasée.
    </p>
  </section>

  <!-- CTA BANNER -->
  <section class="cta-banner">
    <div>
      <div class="cta-banner-title">Passez au triphasé.</div>
      <div class="cta-banner-sub">Commandez votre Exicom Spin Air 11 kW ou obtenez un devis personnalisé.</div>
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

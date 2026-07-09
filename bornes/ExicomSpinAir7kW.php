<!DOCTYPE html>
<html lang="fr">
<?php
session_start();
include '../php/bootstrap.php';
$loggedIn = isset($_SESSION['user']);
?>

<?php
$page_title = 'Exicom Spin Air 7 kW — Borne de recharge résidentielle | EcoDrive';
$page_desc = 'Borne de recharge murale Exicom Spin Air 7 kW pour véhicules électriques. Recharge rapide et intelligente pour la maison et l\'entreprise.';
$page_url = 'bornes/ExicomSpinAir7kW.php';
$page_image = 'images/bornes/SPIN-AIR-11-2.png';
?>
<head>
  <meta charset="UTF-8">
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E%26%23x26A1%3B%3C/text%3E%3C/svg%3E">
  <?php include __DIR__ . '/../php/partials/meta.php'; ?>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') ?></title>
  
  <link rel="stylesheet" href="../css/theme.css">
  <link rel="stylesheet" href="../css/header.css" />
  <link rel="stylesheet" href="../css/animations.css" />

</head>

<body class="has-topbar">
<?php $asset_base = '../'; include __DIR__ . '/../php/partials/header.php'; ?>

<main class="main-wrap page-fade-in">
  <div class="breadcrumb">
    <a href="../index.php">Accueil</a>
    <span>›</span>
    <a href="../index.php#bornes">Bornes de recharge</a>
    <span>›</span>
    <span style="color: var(--text)">Exicom Spin Air 7 kW</span>
  </div>

  <!-- HERO -->
  <section class="borne-hero hero-entrance">

    <div class="borne-visual">
      <div class="borne-visual-bg"></div>
      <div class="borne-visual-grid"></div>
      <div class="borne-img-frame">
        <div class="borne-img-box">
          <img src="../images/bornes/SPIN-AIR-11-2.png" alt="Exicom Spin Air 7 kW"
            onerror="this.style.display='none'; this.parentNode.innerHTML += '<div style=\'font-size:6rem;color:rgba(82,183,136,0.4)\'>⚡</div>'">
        </div>
        <span class="borne-badge-portable">⚡ Résidentiel · Smart Charging</span>
      </div>
      <div class="borne-glow-dot"></div>
    </div>

    <div class="borne-info">
      <div class="borne-eyebrow">Chargeur résidentiel · Exicom</div>

      <div class="borne-power-display">
        <span class="power-num">7.4</span>
        <span class="power-unit">kW</span>
      </div>

      <div class="borne-title">Exicom Spin Air</div>

      <div class="borne-divider"></div>

      <p class="borne-desc-text">
        Chargeur AC monophasé conçu pour la recharge résidentielle quotidienne. Doté d'un contrôle intelligent via
        Wi-Fi, Bluetooth ou 4G/LTE, il s'adapte à votre mode de vie et optimise la consommation énergétique depuis votre
        application mobile.
      </p>

      <div class="specs-list">
        <div class="spec-row">
          <div class="spec-icon">⚡</div>
          <div class="spec-label">Puissance</div>
          <div class="spec-value">7.4 kW (monophasé)</div>
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
          <div class="spec-icon">📶</div>
          <div class="spec-label">Connectivité</div>
          <div class="spec-value">Wi-Fi / Bluetooth / 4G/LTE</div>
        </div>
        <div class="spec-row">
          <div class="spec-icon">🏠</div>
          <div class="spec-label">Installation</div>
          <div class="spec-value">Intérieure ou extérieure</div>
        </div>
      </div>

      <div class="borne-price-bar">
      <span class="borne-price-label">À partir de</span>
      <span class="borne-price-value">2 490 DT</span>
      <span class="borne-price-tax">HT · Installation non incluse</span>
    </div>
    <div class="borne-cta">
      <a href="../pages/contact.php" class="btn-primary">Commander</a>
      <a href="../pages/contact.php" class="btn-ghost">Demander un devis</a>
    </div>
    </div>
  </section>

  <!-- COMMENT ÇA MARCHE -->
  <section class="how-section reveal reveal-up">
    <div class="section-eyebrow">Mode d'emploi</div>
    <h2 class="section-title">Recharge intelligente en 3 étapes</h2>
    <div class="blue-bar"></div>
    <div class="steps-grid stagger-children">
      <div class="step-card">
        <div class="step-num">01</div>
        <div class="step-title">Installation murale</div>
        <p class="step-text">La borne est fixée au mur de votre domicile, garage ou bureau par un électricien qualifié.
          Compatible intérieur et extérieur grâce à sa protection IP.</p>
      </div>
      <div class="step-card">
        <div class="step-num">02</div>
        <div class="step-title">Configuration intelligente</div>
        <p class="step-text">Connectez la borne à votre réseau Wi-Fi ou via 4G/LTE. Configurez vos horaires de recharge
          et suivez votre consommation en temps réel depuis l'application.</p>
      </div>
      <div class="step-card">
        <div class="step-num">03</div>
        <div class="step-title">Rechargez chaque nuit</div>
        <p class="step-text">À 7.4 kW, une nuit de recharge complète votre batterie en 4 à 6 h selon votre véhicule.
          Réveillez-vous chaque matin avec une charge pleine.</p>
      </div>
    </div>
  </section>

  <!-- SPECS COMPLÈTES -->
  <section class="specs-section reveal reveal-up reveal-delay-1">
    <div class="section-eyebrow">Fiche technique</div>
    <h2 class="section-title">Spécifications complètes</h2>
    <div class="blue-bar"></div>
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
          <td>7.4 kW</td>
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
          <td>32 A</td>
        </tr>
        <tr>
          <td>Connecteur côté véhicule</td>
          <td>Type 2 (IEC 62196-2)</td>
        </tr>
        <tr>
          <td>Longueur de câble</td>
          <td>5 m</td>
        </tr>
        <tr>
          <td>Connectivité</td>
          <td>Wi-Fi / Bluetooth / 4G LTE</td>
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
          <td>Installation</td>
          <td>Intérieure ou extérieure</td>
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
  <section class="compat-section reveal reveal-up reveal-delay-2">
    <div class="section-eyebrow">Compatibilité universelle</div>
    <h2 class="section-title">Compatible avec tous les VE Type 2</h2>
    <div class="blue-bar"></div>
    <div class="compat-grid stagger-children">
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
  <section class="cta-banner hero-entrance">
    <div>
      <div class="cta-banner-title">Prêt à passer à l'électrique ?</div>
      <div class="cta-banner-sub">Commandez votre Exicom Spin Air ou obtenez un devis personnalisé.</div>
    </div>
    <a href="../pages/contact.php#contact" class="btn-white">Contacter EcoDrive</a>
  </section>

</main>
<?php include __DIR__ . '/../php/partials/footer.php'; ?>


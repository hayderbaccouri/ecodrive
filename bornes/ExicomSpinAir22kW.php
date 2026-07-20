<?php
include '../php/bootstrap.php';
$loggedIn = isset($_SESSION['user']);
$page_title = 'Exicom Spin Air 22 kW — Borne de recharge professionnelle | EcoDrive';
$page_desc = 'Borne de recharge puissante Exicom Spin Air 22 kW pour véhicules électriques. Recharge ultra-rapide triphasée pour usage professionnel.';
$page_url = 'bornes/ExicomSpinAir22kW.php';
$page_image = 'images/bornes/SPIN-AIR-11-2.png';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E%26%23x26A1%3B%3C/text%3E%3C/svg%3E">
  <?php include __DIR__ . '/../php/partials/meta.php'; ?>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') ?></title>
  <link rel="stylesheet" href="../css/style.css?v=16">

</head>

<body class="has-topbar">
<?php $asset_base = '../'; include __DIR__ . '/../php/partials/header.php'; ?>

<main class="main-wrap page-fade-in">
  <div class="breadcrumb">
    <a href="../index.php">Accueil</a>
    <span>›</span>
    <a href="../bornes/index.php">Bornes de recharge</a>
    <span>›</span>
    <span style="color: var(--text)">Exicom Spin Air 22 kW</span>
  </div>

  <!-- HERO -->
  <section class="borne-hero hero-entrance">

    <div class="borne-visual">
      <div class="borne-visual-bg"></div>
      <div class="borne-visual-grid"></div>
      <div class="borne-img-frame">
        <div class="borne-img-box">
          <img src="../images/bornes/SPIN-AIR-11-2.png" alt="Exicom Spin Air 22 kW"
            onerror="this.style.display='none'; this.nextElementSibling.style.display='grid'">
          <div class="borne-img-fallback" style="display:none;font-size:6rem;color:rgba(60,154,190,0.4);place-items:center">⚡</div>
        </div>
        <span class="borne-badge-portable">⚡ Triphasé · Professionnel</span>
      </div>
      <div class="borne-glow-dot"></div>
    </div>

    <div class="borne-info">
      <div class="borne-eyebrow">Chargeur professionnel · Exicom</div>

      <div class="borne-power-display">
        <span class="power-num">22</span>
        <span class="power-unit">kW</span>
      </div>

      <div class="borne-title">Exicom Spin Air 22 kW</div>

      <div class="borne-divider"></div>

      <p class="borne-desc-text">
        Chargeur haute puissance AC triphasé pensé pour les flottes d'entreprise, les parkings multi-utilisateurs et les
        sites professionnels. Recharge la plus rapide en AC avec une gestion avancée compatible OCPP.
      </p>

      <div class="specs-list">
        <div class="spec-row">
          <div class="spec-icon">⚡</div>
          <div class="spec-label">Puissance</div>
          <div class="spec-value">22 kW (triphasé)</div>
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
          <div class="spec-icon">🌐</div>
          <div class="spec-label">Protocole réseau</div>
          <div class="spec-value">OCPP 1.6 / 2.0 · Gestion centralisée</div>
        </div>
        <div class="spec-row">
          <div class="spec-icon">📶</div>
          <div class="spec-label">Connectivité</div>
          <div class="spec-value">Wi-Fi / Ethernet / 4G/LTE</div>
        </div>
        <div class="spec-row">
          <div class="spec-icon">🏠</div>
          <div class="spec-label">Installation</div>
          <div class="spec-value">Intérieure ou extérieure (mural / colonne)</div>
        </div>
      </div>

      <div class="borne-price-bar">
      <span class="borne-price-label">À partir de</span>
      <span class="borne-price-value">4 490 DT</span>
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
    <h2 class="section-title">Déployez votre infrastructure en 3 étapes</h2>
    <div class="blue-bar"></div>
    <div class="steps-grid stagger-children">
      <div class="step-card">
        <div class="step-num">01</div>
        <div class="step-title">Installation professionnelle</div>
        <p class="step-text">Raccordement au tableau triphasé du site par un installateur certifié. La borne est conçue
          pour une installation murale ou sur colonne, en intérieur comme en extérieur.</p>
      </div>
      <div class="step-card">
        <div class="step-num">02</div>
        <div class="step-title">Configuration du réseau</div>
        <p class="step-text">Connectez la borne à votre système de gestion via OCPP 1.6 ou 2.0. Définissez les accès par
          utilisateur, les plages horaires et les tarifs de recharge.</p>
      </div>
      <div class="step-card">
        <div class="step-num">03</div>
        <div class="step-title">Recharge haut débit</div>
        <p class="step-text">À 22 kW, la plupart des véhicules atteignent leur charge maximale AC en 1 à 2 h. Le débit
          le plus élevé disponible sans infrastructure DC.</p>
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
          <td>Exicom Spin Air 22 kW</td>
        </tr>
        <tr>
          <td>Puissance de sortie</td>
          <td>22 kW</td>
        </tr>
        <tr>
          <td>Type de courant</td>
          <td>AC triphasé</td>
        </tr>
        <tr>
          <td>Tension d'entrée</td>
          <td>400 V / 50 Hz</td>
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
          <td>Protocole réseau</td>
          <td>OCPP 1.6 / 2.0</td>
        </tr>
        <tr>
          <td>Connectivité</td>
          <td>Wi-Fi / Ethernet / 4G LTE</td>
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
          <td>Intérieure ou extérieure (mural / colonne)</td>
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
      La puissance de recharge effective dépend de la capacité maximale AC acceptée par le véhicule.
    </p>
  </section>

  <!-- CTA BANNER -->
  <section class="cta-banner hero-entrance">
    <div>
      <div class="cta-banner-title">Prêt à équiper votre flotte ?</div>
      <div class="cta-banner-sub">Obtenez un devis sur-mesure pour votre déploiement multi-bornes.</div>
    </div>
    <a href="../pages/contact.php#contact" class="btn-white">Contacter EcoDrive</a>
  </section>

</main>
<?php include __DIR__ . '/../php/partials/footer.php'; ?>


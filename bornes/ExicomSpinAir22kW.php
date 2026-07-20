<?php
include '../php/bootstrap.php';
$loggedIn = isset($_SESSION['user']);
$page_title = 'Exicom Spin Air 22 kW â€” Borne de recharge professionnelle | EcoDrive';
$page_desc = 'Borne de recharge puissante Exicom Spin Air 22 kW pour vÃ©hicules Ã©lectriques. Recharge ultra-rapide triphasÃ©e pour usage professionnel.';
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
  <link rel="stylesheet" href="../css/style.css?v=15">

</head>

<body class="has-topbar">
<?php $asset_base = '../'; include __DIR__ . '/../php/partials/header.php'; ?>

<main class="main-wrap page-fade-in">
  <div class="breadcrumb">
    <a href="../index.php">Accueil</a>
    <span>â€º</span>
    <a href="../bornes/index.php">Bornes de recharge</a>
    <span>â€º</span>
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
          <div class="borne-img-fallback" style="display:none;font-size:6rem;color:rgba(60,154,190,0.4);place-items:center">âš¡</div>
        </div>
        <span class="borne-badge-portable">âš¡ TriphasÃ© Â· Professionnel</span>
      </div>
      <div class="borne-glow-dot"></div>
    </div>

    <div class="borne-info">
      <div class="borne-eyebrow">Chargeur professionnel Â· Exicom</div>

      <div class="borne-power-display">
        <span class="power-num">22</span>
        <span class="power-unit">kW</span>
      </div>

      <div class="borne-title">Exicom Spin Air 22 kW</div>

      <div class="borne-divider"></div>

      <p class="borne-desc-text">
        Chargeur haute puissance AC triphasÃ© pensÃ© pour les flottes d'entreprise, les parkings multi-utilisateurs et les
        sites professionnels. Recharge la plus rapide en AC avec une gestion avancÃ©e compatible OCPP.
      </p>

      <div class="specs-list">
        <div class="spec-row">
          <div class="spec-icon">âš¡</div>
          <div class="spec-label">Puissance</div>
          <div class="spec-value">22 kW (triphasÃ©)</div>
        </div>
        <div class="spec-row">
          <div class="spec-icon">ðŸ”Œ</div>
          <div class="spec-label">Connecteur</div>
          <div class="spec-value">Type 2 (IEC 62196)</div>
        </div>
        <div class="spec-row">
          <div class="spec-icon">ðŸ“</div>
          <div class="spec-label">Longueur de cÃ¢ble</div>
          <div class="spec-value">5 mÃ¨tres</div>
        </div>
        <div class="spec-row">
          <div class="spec-icon">ðŸŒ</div>
          <div class="spec-label">Protocole rÃ©seau</div>
          <div class="spec-value">OCPP 1.6 / 2.0 Â· Gestion centralisÃ©e</div>
        </div>
        <div class="spec-row">
          <div class="spec-icon">ðŸ“¶</div>
          <div class="spec-label">ConnectivitÃ©</div>
          <div class="spec-value">Wi-Fi / Ethernet / 4G/LTE</div>
        </div>
        <div class="spec-row">
          <div class="spec-icon">ðŸ </div>
          <div class="spec-label">Installation</div>
          <div class="spec-value">IntÃ©rieure ou extÃ©rieure (mural / colonne)</div>
        </div>
      </div>

      <div class="borne-price-bar">
      <span class="borne-price-label">Ã€ partir de</span>
      <span class="borne-price-value">4 490 DT</span>
      <span class="borne-price-tax">HT Â· Installation non incluse</span>
    </div>
    <div class="borne-cta">
      <a href="../pages/contact.php" class="btn-primary">Commander</a>
      <a href="../pages/contact.php" class="btn-ghost">Demander un devis</a>
    </div>
    </div>
  </section>

  <!-- COMMENT Ã‡A MARCHE -->
  <section class="how-section reveal reveal-up">
    <div class="section-eyebrow">Mode d'emploi</div>
    <h2 class="section-title">DÃ©ployez votre infrastructure en 3 Ã©tapes</h2>
    <div class="blue-bar"></div>
    <div class="steps-grid stagger-children">
      <div class="step-card">
        <div class="step-num">01</div>
        <div class="step-title">Installation professionnelle</div>
        <p class="step-text">Raccordement au tableau triphasÃ© du site par un installateur certifiÃ©. La borne est conÃ§ue
          pour une installation murale ou sur colonne, en intÃ©rieur comme en extÃ©rieur.</p>
      </div>
      <div class="step-card">
        <div class="step-num">02</div>
        <div class="step-title">Configuration du rÃ©seau</div>
        <p class="step-text">Connectez la borne Ã  votre systÃ¨me de gestion via OCPP 1.6 ou 2.0. DÃ©finissez les accÃ¨s par
          utilisateur, les plages horaires et les tarifs de recharge.</p>
      </div>
      <div class="step-card">
        <div class="step-num">03</div>
        <div class="step-title">Recharge haut dÃ©bit</div>
        <p class="step-text">Ã€ 22 kW, la plupart des vÃ©hicules atteignent leur charge maximale AC en 1 Ã  2 h. Le dÃ©bit
          le plus Ã©levÃ© disponible sans infrastructure DC.</p>
      </div>
    </div>
  </section>

  <!-- SPECS COMPLÃˆTES -->
  <section class="specs-section reveal reveal-up reveal-delay-1">
    <div class="section-eyebrow">Fiche technique</div>
    <h2 class="section-title">SpÃ©cifications complÃ¨tes</h2>
    <div class="blue-bar"></div>
    <table class="specs-table">
      <thead>
        <tr>
          <th>ParamÃ¨tre</th>
          <th>Valeur</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Marque / ModÃ¨le</td>
          <td>Exicom Spin Air 22 kW</td>
        </tr>
        <tr>
          <td>Puissance de sortie</td>
          <td>22 kW</td>
        </tr>
        <tr>
          <td>Type de courant</td>
          <td>AC triphasÃ©</td>
        </tr>
        <tr>
          <td>Tension d'entrÃ©e</td>
          <td>400 V / 50 Hz</td>
        </tr>
        <tr>
          <td>Courant maximum</td>
          <td>32 A</td>
        </tr>
        <tr>
          <td>Connecteur cÃ´tÃ© vÃ©hicule</td>
          <td>Type 2 (IEC 62196-2)</td>
        </tr>
        <tr>
          <td>Longueur de cÃ¢ble</td>
          <td>5 m</td>
        </tr>
        <tr>
          <td>Protocole rÃ©seau</td>
          <td>OCPP 1.6 / 2.0</td>
        </tr>
        <tr>
          <td>ConnectivitÃ©</td>
          <td>Wi-Fi / Ethernet / 4G LTE</td>
        </tr>
        <tr>
          <td>Indice de protection</td>
          <td>IP54</td>
        </tr>
        <tr>
          <td>TempÃ©rature de fonctionnement</td>
          <td>-20 Â°C Ã  +55 Â°C</td>
        </tr>
        <tr>
          <td>Installation</td>
          <td>IntÃ©rieure ou extÃ©rieure (mural / colonne)</td>
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

  <!-- COMPATIBILITÃ‰ -->
  <section class="compat-section reveal reveal-up reveal-delay-2">
    <div class="section-eyebrow">CompatibilitÃ© universelle</div>
    <h2 class="section-title">Compatible avec tous les VE Type 2</h2>
    <div class="blue-bar"></div>
    <div class="compat-grid stagger-children">
      <div class="compat-card">
        <div class="compat-icon">ðŸ”µ</div>
        <div class="compat-name">Renault Megane E-Tech</div>
        <div class="compat-sub">Type 2 Â· Compatible</div>
      </div>
      <div class="compat-card">
        <div class="compat-icon">ðŸŸ¢</div>
        <div class="compat-name">Volkswagen ID.4</div>
        <div class="compat-sub">Type 2 Â· Compatible</div>
      </div>
      <div class="compat-card">
        <div class="compat-icon">âšª</div>
        <div class="compat-name">Hyundai IONIQ 6</div>
        <div class="compat-sub">Type 2 Â· Compatible</div>
      </div>
      <div class="compat-card">
        <div class="compat-icon">ðŸ”´</div>
        <div class="compat-name">CitroÃ«n C3 Electric</div>
        <div class="compat-sub">Type 2 Â· Compatible</div>
      </div>
    </div>
    <p style="margin-top: 2rem; font-size: 0.8rem; color: var(--muted); text-align: center;">
      La puissance de recharge effective dÃ©pend de la capacitÃ© maximale AC acceptÃ©e par le vÃ©hicule.
    </p>
  </section>

  <!-- CTA BANNER -->
  <section class="cta-banner hero-entrance">
    <div>
      <div class="cta-banner-title">PrÃªt Ã  Ã©quiper votre flotte ?</div>
      <div class="cta-banner-sub">Obtenez un devis sur-mesure pour votre dÃ©ploiement multi-bornes.</div>
    </div>
    <a href="../pages/contact.php#contact" class="btn-white">Contacter EcoDrive</a>
  </section>

</main>
<?php include __DIR__ . '/../php/partials/footer.php'; ?>


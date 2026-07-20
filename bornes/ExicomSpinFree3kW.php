<?php
include '../php/bootstrap.php';
$loggedIn = isset($_SESSION['user']);
$page_title = 'Exicom Spin Free 3 kW â€” Borne de recharge portable | EcoDrive';
$page_desc = 'Borne de recharge portable Exicom Spin Free 3 kW â€” recharge tout type de vÃ©hicule Ã©lectrique sur prise standard. IdÃ©ale pour la maison et le dÃ©pannage.';
$page_url = 'bornes/ExicomSpinFree3kW.php';
$page_image = 'images/bornes/SPIN-FREE-3.png';
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
    <span style="color: var(--text)">Exicom Spin Free 3 kW</span>
  </div>

  <!-- HERO -->
  <section class="borne-hero hero-entrance">

    <div class="borne-visual">
      <div class="borne-visual-bg"></div>
      <div class="borne-visual-grid"></div>
      <div class="borne-img-frame">
        <div class="borne-img-box">
          <img src="../images/bornes/SPIN-FREE-3.png" alt="Exicom Spin Free 3 kW"
            onerror="this.style.display='none'; this.nextElementSibling.style.display='grid'">
          <div class="borne-img-fallback" style="display:none;font-size:6rem;color:rgba(60,154,190,0.4);place-items:center">âš¡</div>
        </div>
        <span class="borne-badge-portable">âš¡ Portable Â· Plug &amp; Charge</span>
      </div>
      <div class="borne-glow-dot"></div>
    </div>

    <div class="borne-info">
      <div class="borne-eyebrow">Chargeur portable Â· Exicom</div>

      <div class="borne-power-display">
        <span class="power-num">3</span>
        <span class="power-unit">kW</span>
      </div>

      <div class="borne-title">Exicom Spin Free</div>

      <div class="borne-divider"></div>

      <p class="borne-desc-text">
        Chargeur portable compact conÃ§u pour la recharge d'appoint, les dÃ©placements et les situations de secours.
        Branchez, rechargez, repartez â€” sans installation fixe.
      </p>

      <div class="specs-list">
        <div class="spec-row">
          <div class="spec-icon">âš¡</div>
          <div class="spec-label">Puissance</div>
          <div class="spec-value">3 kW (monophasÃ©)</div>
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
          <div class="spec-icon">ðŸ </div>
          <div class="spec-label">Prise source</div>
          <div class="spec-value">Schuko / 230 V domestique</div>
        </div>
        <div class="spec-row">
          <div class="spec-icon">ðŸŒ¿</div>
          <div class="spec-label">Usage</div>
          <div class="spec-value">Voyage Â· Secours Â· Domicile</div>
        </div>
      </div>

      <div class="borne-price-bar">
      <span class="borne-price-label">Ã€ partir de</span>
      <span class="borne-price-value">1 290 DT</span>
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
    <h2 class="section-title">Recharge en 3 Ã©tapes</h2>
    <div class="blue-bar"></div>
    <div class="steps-grid stagger-children">
      <div class="step-card">
        <div class="step-num">01</div>
        <div class="step-title">Branchez Ã  la prise</div>
        <p class="step-text">Connectez l'Exicom Spin Free Ã  n'importe quelle prise Schuko domestique standard 230 V.
          Aucun cÃ¢blage Ã©lectrique requis.</p>
      </div>
      <div class="step-card">
        <div class="step-num">02</div>
        <div class="step-title">Reliez au vÃ©hicule</div>
        <p class="step-text">Connectez l'extrÃ©mitÃ© Type 2 au port de recharge de votre vÃ©hicule Ã©lectrique. Le cÃ¢ble de
          5 m offre une grande libertÃ© de positionnement.</p>
      </div>
      <div class="step-card">
        <div class="step-num">03</div>
        <div class="step-title">Rechargez &amp; repartez</div>
        <p class="step-text">La recharge dÃ©marre automatiquement. Ã€ 3 kW, comptez environ 6 Ã  8 h pour un ajout de 20 Ã 
          25 kWh selon votre batterie.</p>
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
          <td>Exicom Spin Free</td>
        </tr>
        <tr>
          <td>Puissance de sortie</td>
          <td>3 kW</td>
        </tr>
        <tr>
          <td>Type de courant</td>
          <td>AC monophasÃ©</td>
        </tr>
        <tr>
          <td>Tension d'entrÃ©e</td>
          <td>230 V / 50 Hz</td>
        </tr>
        <tr>
          <td>Courant maximum</td>
          <td>13 A</td>
        </tr>
        <tr>
          <td>Connecteur cÃ´tÃ© vÃ©hicule</td>
          <td>Type 2 (IEC 62196-2)</td>
        </tr>
        <tr>
          <td>Prise cÃ´tÃ© rÃ©seau</td>
          <td>Schuko (CEE 7/4)</td>
        </tr>
        <tr>
          <td>Longueur de cÃ¢ble</td>
          <td>5 m</td>
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
          <td>Format</td>
          <td>Portable, lÃ©ger, transportable</td>
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
      Compatible avec tous les vÃ©hicules Ã©lectriques Ã©quipÃ©s d'un port Type 2 â€” la norme europÃ©enne universelle.
    </p>
  </section>

  <!-- CTA BANNER -->
  <section class="cta-banner hero-entrance">
    <div>
      <div class="cta-banner-title">PrÃªt Ã  passer Ã  l'Ã©lectrique ?</div>
      <div class="cta-banner-sub">Commandez votre Exicom Spin Free ou obtenez un devis personnalisÃ©.</div>
    </div>
    <a href="../pages/contact.php#contact" class="btn-white">Contacter EcoDrive</a>
  </section>

</main>
<?php include __DIR__ . '/../php/partials/footer.php'; ?>


<?php
session_start();
$loggedIn = isset($_SESSION['user']);
$page_title = 'CGU | EcoDrive';
$page_desc = 'Conditions gÃ©nÃ©rales d\'utilisation du site EcoDrive â€” showroom de voitures Ã©lectriques en Tunisie.';
$page_url = 'pages/cgu.php';
$page_image = 'images/tesla-model-3/Tesla_Model_3_Standard_2026-01@2x.jpg';
?><!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') ?></title>
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E%26%23x26A1%3B%3C/text%3E%3C/svg%3E">
  <?php include __DIR__ . '/../php/partials/meta.php'; ?>
  <link rel="stylesheet" href="../css/style.css?v=15">
</head>
<body class="page-legal">
<?php $asset_base = '../'; include __DIR__ . '/../php/partials/header.php'; ?>

<main class="page-fade-in">
  <div class="container">
    <h1 class="hero-entrance">Conditions GÃ©nÃ©rales d'Utilisation</h1>
    <div class="legal-meta">DerniÃ¨re mise Ã  jour : 13 juin 2026</div>

    <div class="content-section">
      <h2>Objet</h2>
      <p>Les prÃ©sentes Conditions GÃ©nÃ©rales d'Utilisation (CGU) dÃ©finissent les modalitÃ©s d'accÃ¨s et d'utilisation du site internet EcoDrive (ci-aprÃ¨s Â« le Site Â»).</p>
    </div>

    <div class="content-section">
      <h2>Acceptation</h2>
      <p>En accÃ©dant et en utilisant le Site, vous acceptez pleinement et sans rÃ©serve les prÃ©sentes CGU. Si vous n'acceptez pas ces conditions, veuillez ne pas utiliser le Site.</p>
    </div>

    <div class="content-section">
      <h2>AccÃ¨s au site</h2>
      <p>Le Site est accessible gratuitement Ã  tout utilisateur disposant d'un accÃ¨s Ã  Internet. EcoDrive se rÃ©serve le droit de suspendre ou limiter l'accÃ¨s au Site pour des raisons de maintenance, de sÃ©curitÃ© ou toute autre nÃ©cessitÃ© technique.</p>
    </div>

    <div class="content-section">
      <h2>Compte utilisateur</h2>
      <p>Certaines fonctionnalitÃ©s du Site nÃ©cessitent la crÃ©ation d'un compte utilisateur. L'utilisateur s'engage Ã  fournir des informations exactes et Ã  les maintenir Ã  jour. Le mot de passe est personnel et confidentiel.</p>
    </div>

    <div class="content-section">
      <h2>Conduite de l'utilisateur</h2>
      <p>L'utilisateur s'engage Ã  :</p>
      <ul>
        <li>Ne pas utiliser le Site Ã  des fins illicites</li>
        <li>Ne pas perturber le fonctionnement du Site</li>
        <li>Ne pas tenter d'accÃ©der aux donnÃ©es d'autres utilisateurs</li>
        <li>Ne pas diffuser de contenu nuisible ou illÃ©gal</li>
      </ul>
    </div>

    <div class="content-section">
      <h2>PropriÃ©tÃ© intellectuelle</h2>
      <p>Tout le contenu du Site (textes, images, logos, code source) est protÃ©gÃ© par le droit d'auteur. Toute reproduction ou utilisation sans autorisation est interdite.</p>
    </div>

    <div class="content-section">
      <h2>DonnÃ©es personnelles</h2>
      <p>Les donnÃ©es personnelles collectÃ©es via le Site sont traitÃ©es conformÃ©ment Ã  la <a href="confidentialite.php">Politique de confidentialitÃ©</a>. L'utilisateur dispose d'un droit d'accÃ¨s, de rectification et de suppression de ses donnÃ©es.</p>
    </div>

    <div class="content-section">
      <h2>Cookies</h2>
      <p>Le Site utilise des cookies pour amÃ©liorer l'expÃ©rience utilisateur. En naviguant sur le Site, l'utilisateur accepte l'utilisation de cookies conformÃ©ment Ã  la politique de confidentialitÃ©.</p>
    </div>

    <div class="content-section">
      <h2>Limitation de responsabilitÃ©</h2>
      <p>EcoDrive met tout en Å“uvre pour assurer l'exactitude des informations publiÃ©es, sans garantie absolue. EcoDrive ne peut Ãªtre tenu responsable des dommages directs ou indirects rÃ©sultant de l'utilisation du Site.</p>
    </div>

    <div class="content-section">
      <h2>Liens externes</h2>
      <p>Le Site peut contenir des liens vers des sites tiers. EcoDrive n'exerce aucun contrÃ´le sur ces sites et dÃ©cline toute responsabilitÃ© quant Ã  leur contenu.</p>
    </div>

    <div class="content-section">
      <h2>Modification des CGU</h2>
      <p>EcoDrive se rÃ©serve le droit de modifier les prÃ©sentes CGU Ã  tout moment. Les modifications prennent effet dÃ¨s leur publication sur le Site. L'utilisateur est invitÃ© Ã  consulter rÃ©guliÃ¨rement les CGU.</p>
    </div>

    <div class="content-section">
      <h2>Droit applicable</h2>
      <p>Les prÃ©sentes CGU sont rÃ©gies par le droit tunisien. Tout litige relÃ¨ve de la compÃ©tence exclusive des tribunaux de Tunis.</p>
    </div>

    <div class="content-section">
      <h2>Contact</h2>
      <p>Pour toute question relative aux CGU : <a href="mailto:info@ecodrive.tn">info@ecodrive.tn</a> ou via le <a href="contact.php">formulaire de contact</a>.</p>
    </div>
  </div>
</main>

<?php include __DIR__ . '/../php/partials/footer.php'; ?>

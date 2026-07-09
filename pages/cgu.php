<?php
session_start();
$loggedIn = isset($_SESSION['user']);
$page_title = 'CGU | EcoDrive';
$page_desc = 'Conditions générales d\'utilisation du site EcoDrive — showroom de voitures électriques en Tunisie.';
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
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/theme.css">
  <link rel="stylesheet" href="../css/header.css">
  <link rel="stylesheet" href="../css/animations.css">
</head>
<body class="page-legal">
<?php $asset_base = '../'; include __DIR__ . '/../php/partials/header.php'; ?>

<main class="page-fade-in">
  <div class="container">
    <h1 class="hero-entrance">Conditions Générales d'Utilisation</h1>
    <div class="legal-meta">Dernière mise à jour : 13 juin 2026</div>

    <div class="content-section">
      <h2>Objet</h2>
      <p>Les présentes Conditions Générales d'Utilisation (CGU) définissent les modalités d'accès et d'utilisation du site internet EcoDrive (ci-après « le Site »).</p>
    </div>

    <div class="content-section">
      <h2>Acceptation</h2>
      <p>En accédant et en utilisant le Site, vous acceptez pleinement et sans réserve les présentes CGU. Si vous n'acceptez pas ces conditions, veuillez ne pas utiliser le Site.</p>
    </div>

    <div class="content-section">
      <h2>Accès au site</h2>
      <p>Le Site est accessible gratuitement à tout utilisateur disposant d'un accès à Internet. EcoDrive se réserve le droit de suspendre ou limiter l'accès au Site pour des raisons de maintenance, de sécurité ou toute autre nécessité technique.</p>
    </div>

    <div class="content-section">
      <h2>Compte utilisateur</h2>
      <p>Certaines fonctionnalités du Site nécessitent la création d'un compte utilisateur. L'utilisateur s'engage à fournir des informations exactes et à les maintenir à jour. Le mot de passe est personnel et confidentiel.</p>
    </div>

    <div class="content-section">
      <h2>Conduite de l'utilisateur</h2>
      <p>L'utilisateur s'engage à :</p>
      <ul>
        <li>Ne pas utiliser le Site à des fins illicites</li>
        <li>Ne pas perturber le fonctionnement du Site</li>
        <li>Ne pas tenter d'accéder aux données d'autres utilisateurs</li>
        <li>Ne pas diffuser de contenu nuisible ou illégal</li>
      </ul>
    </div>

    <div class="content-section">
      <h2>Propriété intellectuelle</h2>
      <p>Tout le contenu du Site (textes, images, logos, code source) est protégé par le droit d'auteur. Toute reproduction ou utilisation sans autorisation est interdite.</p>
    </div>

    <div class="content-section">
      <h2>Données personnelles</h2>
      <p>Les données personnelles collectées via le Site sont traitées conformément à la <a href="confidentialite.php">Politique de confidentialité</a>. L'utilisateur dispose d'un droit d'accès, de rectification et de suppression de ses données.</p>
    </div>

    <div class="content-section">
      <h2>Cookies</h2>
      <p>Le Site utilise des cookies pour améliorer l'expérience utilisateur. En naviguant sur le Site, l'utilisateur accepte l'utilisation de cookies conformément à la politique de confidentialité.</p>
    </div>

    <div class="content-section">
      <h2>Limitation de responsabilité</h2>
      <p>EcoDrive met tout en œuvre pour assurer l'exactitude des informations publiées, sans garantie absolue. EcoDrive ne peut être tenu responsable des dommages directs ou indirects résultant de l'utilisation du Site.</p>
    </div>

    <div class="content-section">
      <h2>Liens externes</h2>
      <p>Le Site peut contenir des liens vers des sites tiers. EcoDrive n'exerce aucun contrôle sur ces sites et décline toute responsabilité quant à leur contenu.</p>
    </div>

    <div class="content-section">
      <h2>Modification des CGU</h2>
      <p>EcoDrive se réserve le droit de modifier les présentes CGU à tout moment. Les modifications prennent effet dès leur publication sur le Site. L'utilisateur est invité à consulter régulièrement les CGU.</p>
    </div>

    <div class="content-section">
      <h2>Droit applicable</h2>
      <p>Les présentes CGU sont régies par le droit tunisien. Tout litige relève de la compétence exclusive des tribunaux de Tunis.</p>
    </div>

    <div class="content-section">
      <h2>Contact</h2>
      <p>Pour toute question relative aux CGU : <a href="mailto:info@ecodrive.tn">info@ecodrive.tn</a> ou via le <a href="contact.php">formulaire de contact</a>.</p>
    </div>
  </div>
</main>

<?php include __DIR__ . '/../php/partials/footer.php'; ?>

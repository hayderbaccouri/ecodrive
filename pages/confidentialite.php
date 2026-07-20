<?php
session_start();
$loggedIn = isset($_SESSION['user']);
$page_title = 'Politique de ConfidentialitÃ© | EcoDrive';
$page_desc = 'Politique de confidentialitÃ© du site EcoDrive â€” showroom de voitures Ã©lectriques en Tunisie.';
$page_url = 'pages/confidentialite.php';
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
    <h1 class="hero-entrance">Politique de ConfidentialitÃ©</h1>
    <div class="legal-meta">DerniÃ¨re mise Ã  jour : 13 juin 2026</div>

    <div class="content-section">
      <h2>Introduction</h2>
      <p>EcoDrive accorde une grande importance Ã  la protection de vos donnÃ©es personnelles. La prÃ©sente politique de confidentialitÃ© a pour objectif de vous informer sur la maniÃ¨re dont nous collectons, utilisons et protÃ©geons vos informations lorsque vous utilisez notre site web.</p>
      <p>En utilisant le site EcoDrive, vous acceptez les pratiques dÃ©crites dans cette politique.</p>
    </div>

    <div class="content-section">
      <h2>Responsable du traitement</h2>
      <p>Le responsable du traitement des donnÃ©es est EcoDrive, reprÃ©sentÃ© par Hayder Baccouri, dans le cadre d'un projet de fin de formation 2026.</p>
    </div>

    <div class="content-section">
      <h2>DonnÃ©es collectÃ©es</h2>
      <h3>DonnÃ©es que vous nous fournissez</h3>
      <ul>
        <li>Nom et prÃ©nom</li>
        <li>Adresse e-mail</li>
        <li>NumÃ©ro de tÃ©lÃ©phone</li>
        <li>Message via le formulaire de contact</li>
        <li>Informations de compte (nom d'utilisateur, mot de passe hachÃ©)</li>
      </ul>
      <h3>DonnÃ©es collectÃ©es automatiquement</h3>
      <ul>
        <li>Adresse IP</li>
        <li>Type et version du navigateur</li>
        <li>Pages visitÃ©es et durÃ©e de la visite</li>
        <li>Cookies et technologies similaires</li>
      </ul>
    </div>

    <div class="content-section">
      <h2>Base lÃ©gale du traitement</h2>
      <p>Le traitement de vos donnÃ©es repose sur les bases lÃ©gales suivantes :</p>
      <ul>
        <li><strong>Consentement :</strong> pour l'envoi de communications et l'utilisation de cookies non essentiels</li>
        <li><strong>ExÃ©cution contractuelle :</strong> pour la gestion de votre compte et des services associÃ©s</li>
        <li><strong>IntÃ©rÃªt lÃ©gitime :</strong> pour l'amÃ©lioration du site et la sÃ©curitÃ©</li>
      </ul>
    </div>

    <div class="content-section">
      <h2>FinalitÃ©s du traitement</h2>
      <p>Nous utilisons vos donnÃ©es pour :</p>
      <ul>
        <li>GÃ©rer votre compte utilisateur</li>
        <li>RÃ©pondre Ã  vos demandes via le formulaire de contact</li>
        <li>AmÃ©liorer notre site et votre expÃ©rience utilisateur</li>
        <li>Assurer la sÃ©curitÃ© et le bon fonctionnement du site</li>
        <li>Respecter nos obligations lÃ©gales</li>
      </ul>
    </div>

    <div class="content-section">
      <h2>DurÃ©e de conservation</h2>
      <p>Vos donnÃ©es personnelles sont conservÃ©es aussi longtemps que nÃ©cessaire pour les finalitÃ©s pour lesquelles elles ont Ã©tÃ© collectÃ©es :</p>
      <ul>
        <li>DonnÃ©es de compte : jusqu'Ã  la suppression du compte</li>
        <li>DonnÃ©es de contact : 3 ans Ã  compter du dernier contact</li>
        <li>Cookies : durÃ©e spÃ©cifiÃ©e dans chaque cookie</li>
      </ul>
    </div>

    <div class="content-section">
      <h2>Partage des donnÃ©es</h2>
      <p>Nous ne vendons pas vos donnÃ©es personnelles Ã  des tiers. Vos donnÃ©es peuvent Ãªtre partagÃ©es uniquement dans les cas suivants :</p>
      <ul>
        <li>Avec votre consentement explicite</li>
        <li>Pour respecter une obligation lÃ©gale</li>
        <li>Avec des prestataires techniques (hÃ©bergement, maintenance) sous contrat</li>
      </ul>
    </div>

    <div class="content-section">
      <h2>SÃ©curitÃ© des donnÃ©es</h2>
      <p>Nous mettons en Å“uvre des mesures techniques et organisationnelles appropriÃ©es pour protÃ©ger vos donnÃ©es contre tout accÃ¨s non autorisÃ©, modification, divulgation ou destruction. Ces mesures incluent le chiffrement des mots de passe, l'utilisation de connexions sÃ©curisÃ©es et des contrÃ´les d'accÃ¨s stricts.</p>
    </div>

    <div class="content-section">
      <h2>Vos droits</h2>
      <p>ConformÃ©ment Ã  la rÃ©glementation applicable en matiÃ¨re de protection des donnÃ©es, vous disposez des droits suivants :</p>
      <ul>
        <li>Droit d'accÃ¨s Ã  vos donnÃ©es</li>
        <li>Droit de rectification des donnÃ©es inexactes</li>
        <li>Droit Ã  l'effacement (droit Ã  l'oubli)</li>
        <li>Droit Ã  la limitation du traitement</li>
        <li>Droit Ã  la portabilitÃ© de vos donnÃ©es</li>
        <li>Droit d'opposition au traitement</li>
      </ul>
      <p>Pour exercer ces droits, veuillez nous contacter via la page contact ou Ã  l'adresse email ci-dessous.</p>
    </div>

    <div class="content-section">
      <h2>Cookies</h2>
      <p>Notre site utilise des cookies pour amÃ©liorer votre expÃ©rience de navigation. Vous pouvez contrÃ´ler l'utilisation des cookies via les paramÃ¨tres de votre navigateur. Les cookies que nous utilisons peuvent inclure :</p>
      <ul>
        <li>Cookies de session (nÃ©cessaires au fonctionnement du site)</li>
        <li>Cookies d'analyse (pour comprendre l'utilisation du site)</li>
        <li>Cookies de prÃ©fÃ©rences (pour mÃ©moriser vos choix)</li>
      </ul>
    </div>

    <div class="content-section">
      <h2>Modifications de la politique</h2>
      <p>Nous nous rÃ©servons le droit de modifier cette politique de confidentialitÃ© Ã  tout moment. Les modifications seront publiÃ©es sur cette page avec une date de mise Ã  jour rÃ©visÃ©e. Nous vous encourageons Ã  consulter rÃ©guliÃ¨rement cette page.</p>
    </div>

    <div class="content-section">
      <h2>Contact</h2>
      <p>Pour toute question concernant cette politique de confidentialitÃ© ou pour exercer vos droits :</p>
      <p><strong>Email :</strong> <a href="mailto:info@ecodrive.tn">info@ecodrive.tn</a></p>
      <p><strong>Contact :</strong> <a href="contact.php">Formulaire de contact</a></p>
    </div>
  </div>
</main>

<?php include __DIR__ . '/../php/partials/footer.php'; ?>

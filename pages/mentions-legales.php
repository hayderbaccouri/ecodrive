<?php
session_start();
$loggedIn = isset($_SESSION['user']);
$page_title = 'Mentions LÃ©gales | EcoDrive';
$page_desc = 'Mentions lÃ©gales du site EcoDrive â€” showroom de voitures Ã©lectriques en Tunisie.';
$page_url = 'pages/mentions-legales.php';
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
    <h1 class="hero-entrance">Mentions LÃ©gales</h1>
    <div class="legal-meta">DerniÃ¨re mise Ã  jour : 13 juin 2026</div>

    <div class="content-section">
      <h2>Ã‰diteur du site</h2>
      <h3>EcoDrive â€” Premier Showroom Ã‰lectrique de Tunisie</h3>
      <p><strong>Nom du responsable :</strong> Hayder Baccouri</p>
      <p><strong>Type :</strong> Projet de fin de formation â€” AnnÃ©e 2026</p>
      <p><strong>Objet :</strong> Plateforme de prÃ©sentation et de commercialisation de vÃ©hicules Ã©lectriques en Tunisie.</p>
    </div>

    <div class="content-section">
      <h2>CaractÃ©ristiques du site</h2>
      <h3>Description gÃ©nÃ©rale</h3>
      <p>EcoDrive est un showroom Ã©lectrique en ligne offrant un catalogue complet de vÃ©hicules Ã©lectriques et de solutions de recharge. Le site propose la visualisation de nos produits, des informations dÃ©taillÃ©es et une interface utilisateur dÃ©diÃ©e Ã  l'expÃ©rience client.</p>
      <h3>FonctionnalitÃ©s principales</h3>
      <ul>
        <li>Catalogue interactif de voitures Ã©lectriques</li>
        <li>PrÃ©sentation des bornes de recharge</li>
        <li>Inscription et connexion utilisateur</li>
        <li>Recherche et filtrage des produits</li>
        <li>Formulaires de contact et d'intÃ©rÃªt</li>
      </ul>
    </div>

    <div class="content-section">
      <h2>PropriÃ©tÃ© intellectuelle</h2>
      <p>Tous les contenus prÃ©sents sur ce site (textes, images, logos, vidÃ©os, icÃ´nes, structure, mise en page, code source) sont la propriÃ©tÃ© exclusive ou sont utilisÃ©s avec autorisation. Toute reproduction, distribution, modification ou utilisation sans autorisation est strictement interdite.</p>
      <p><strong>Â© 2026 EcoDrive. Tous droits rÃ©servÃ©s.</strong></p>
      <h3>Utilisation autorisÃ©e</h3>
      <p>Vous Ãªtes autorisÃ© Ã  consulter et tÃ©lÃ©charger des copies pour votre usage personnel et non commercial uniquement.</p>
    </div>

    <div class="content-section">
      <h2>ResponsabilitÃ© de l'hÃ©bergeur</h2>
      <p>Ce site est hÃ©bergÃ© sur un serveur local (XAMPP) Ã  des fins Ã©ducatives et de formation. L'hÃ©bergeur ne peut Ãªtre tenu responsable des interruptions d'accÃ¨s, des pertes de donnÃ©es ou des dommages directs ou indirects rÃ©sultant de l'accÃ¨s Ã  ce site.</p>
    </div>

    <div class="content-section">
      <h2>Liens externes</h2>
      <p>Ce site peut contenir des liens vers d'autres sites web. EcoDrive n'est pas responsable du contenu de ces sites externes. L'inclusion de liens ne constitue pas une endorsement.</p>
    </div>

    <div class="content-section">
      <h2>DonnÃ©es personnelles et protection</h2>
      <h3>Collecte de donnÃ©es</h3>
      <p>Le site peut collecter les informations suivantes :</p>
      <ul>
        <li>Nom et prÃ©nom</li>
        <li>Adresse e-mail</li>
        <li>Mot de passe (hachÃ© et sÃ©curisÃ©)</li>
        <li>Historique de navigation</li>
        <li>Informations de formulaires</li>
      </ul>
      <h3>Utilisation des donnÃ©es</h3>
      <p>Les donnÃ©es personnelles collectÃ©es sont utilisÃ©es uniquement pour :</p>
      <ul>
        <li>GÃ©rer votre compte utilisateur</li>
        <li>AmÃ©liorer l'expÃ©rience utilisateur</li>
        <li>Envoyer des communications pertinentes</li>
        <li>Analyser les statistiques d'utilisation</li>
      </ul>
      <h3>SÃ©curitÃ©</h3>
      <p>EcoDrive s'engage Ã  protÃ©ger vos donnÃ©es personnelles. Cependant, aucune transmission sur Internet n'est totalement sÃ©curisÃ©e. Vous utilisez ce site Ã  vos risques et pÃ©rils.</p>
    </div>

    <div class="content-section">
      <h2>Cookies</h2>
      <p>Ce site peut utiliser des cookies pour amÃ©liorer votre expÃ©rience de navigation. Les cookies sont de petits fichiers stockÃ©s sur votre appareil. Vous pouvez dÃ©sactiver les cookies via les paramÃ¨tres de votre navigateur.</p>
    </div>

    <div class="content-section">
      <h2>Limitations de responsabilitÃ©</h2>
      <p>Le site est fourni Â« tel quel Â» sans garantie d'aucune sorte, expresse ou implicite. EcoDrive ne garantit pas :</p>
      <ul>
        <li>L'exactitude, l'exhaustivitÃ© ou la fiabilitÃ© des contenus</li>
        <li>L'absence d'interruption ou d'erreurs</li>
        <li>La conformitÃ© aux besoins spÃ©cifiques de l'utilisateur</li>
        <li>L'absence de virus ou de codes malveillants</li>
      </ul>
      <p>En aucun cas, EcoDrive ne sera responsable de dommages directs, indirects, accidentels, spÃ©ciaux ou consÃ©cutifs rÃ©sultant de l'utilisation ou de l'impossibilitÃ© d'utiliser ce site.</p>
    </div>

    <div class="content-section">
      <h2>Conditions d'utilisation</h2>
      <h3>ConformitÃ© lÃ©gale</h3>
      <p>En accÃ©dant et en utilisant ce site, vous acceptez de vous conformer Ã  toutes les lois et rÃ©glementations applicables en Tunisie et internationalement.</p>
      <h3>Comportement interdit</h3>
      <p>Il est strictement interdit de :</p>
      <ul>
        <li>AccÃ©der au site de maniÃ¨re non autorisÃ©e</li>
        <li>Utiliser le site pour des activitÃ©s illÃ©gales</li>
        <li>Transmettre des virus ou codes malveillants</li>
        <li>Harceler ou menacer d'autres utilisateurs</li>
        <li>Reproduire, distribuer ou modifier le contenu sans autorisation</li>
        <li>Surcharger les serveurs avec des requÃªtes automatiques</li>
      </ul>
    </div>

    <div class="content-section">
      <h2>Modifications des conditions</h2>
      <p>EcoDrive se rÃ©serve le droit de modifier ces mentions lÃ©gales Ã  tout moment. Les modifications entrent en vigueur dÃ¨s leur publication sur le site. Votre utilisation continue du site aprÃ¨s les modifications constitue votre acceptation des nouvelles conditions.</p>
    </div>

    <div class="content-section">
      <h2>Droit applicable et juridiction</h2>
      <p>Ces mentions lÃ©gales sont rÃ©gies par les lois de la Tunisie. Tout litige ou diffÃ©rend dÃ©coulant de ces conditions sera soumis Ã  la juridiction exclusive des tribunaux tunisiens.</p>
    </div>

    <div class="content-section">
      <h2>Contact</h2>
      <h3>Pour toute question concernant ces mentions lÃ©gales :</h3>
      <p><strong>Email :</strong> <a href="mailto:info@ecodrive.tn">info@ecodrive.tn</a></p>
      <p><strong>Formulaire de contact :</strong> Accessible via la <a href="contact.php">page contact</a></p>
      <h3>Responsable du projet</h3>
      <p><strong>Nom :</strong> Hayder Baccouri</p>
      <p><strong>Formation :</strong> Projet de fin de formation 2026</p>
      <p><strong>Date de mise Ã  jour :</strong> 13 juin 2026</p>
    </div>
  </div>
</main>

<?php include __DIR__ . '/../php/partials/footer.php'; ?>

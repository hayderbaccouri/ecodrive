<?php
if (!defined('CACHE_VERSION')) define('CACHE_VERSION', '20');
session_start();
$loggedIn = isset($_SESSION['user']);
$page_title = 'Mentions Légales | EcoDrive';
$page_desc = 'Mentions légales du site EcoDrive — showroom de voitures électriques en Tunisie.';
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
  <link rel="stylesheet" href="../css/style.css?v=<?= CACHE_VERSION ?>">
</head>
<body class="page-legal">
<?php $asset_base = '../'; include __DIR__ . '/../php/partials/header.php'; ?>

<main class="page-fade-in">
  <div class="container">
    <h1 class="hero-entrance">Mentions Légales</h1>
    <div class="legal-meta">Dernière mise à jour : 13 juin 2026</div>

    <div class="content-section">
      <h2>Éditeur du site</h2>
      <h3>EcoDrive — Premier Showroom Électrique de Tunisie</h3>
      <p><em>Nom du responsable :</em> Hayder Baccouri</p>
      <p><em>Type :</em> Projet de fin de formation — Année 2026</p>
      <p><em>Objet :</em> Plateforme de présentation et de commercialisation de véhicules électriques en Tunisie.</p>
    </div>

    <div class="content-section">
      <h2>Caractéristiques du site</h2>
      <h3>Description générale</h3>
      <p>EcoDrive est un showroom électrique en ligne offrant un catalogue complet de véhicules électriques et de solutions de recharge. Le site propose la visualisation de nos produits, des informations détaillées et une interface utilisateur dédiée à l'expérience client.</p>
      <h3>Fonctionnalités principales</h3>
      <ul>
        <li>Catalogue interactif de voitures électriques</li>
        <li>Présentation des bornes de recharge</li>
        <li>Inscription et connexion utilisateur</li>
        <li>Recherche et filtrage des produits</li>
        <li>Formulaires de contact et d'intérêt</li>
      </ul>
    </div>

    <div class="content-section">
      <h2>Propriété intellectuelle</h2>
      <p>Tous les contenus présents sur ce site (textes, images, logos, vidéos, icônes, structure, mise en page, code source) sont la propriété exclusive ou sont utilisés avec autorisation. Toute reproduction, distribution, modification ou utilisation sans autorisation est strictement interdite.</p>
      <p><em>© 2026 EcoDrive. Tous droits réservés.</em></p>
      <h3>Utilisation autorisée</h3>
      <p>Vous êtes autorisé à consulter et télécharger des copies pour votre usage personnel et non commercial uniquement.</p>
    </div>

    <div class="content-section">
      <h2>Responsabilité de l'hébergeur</h2>
      <p>Ce site est hébergé sur un serveur local (XAMPP) à des fins éducatives et de formation. L'hébergeur ne peut être tenu responsable des interruptions d'accès, des pertes de données ou des dommages directs ou indirects résultant de l'accès à ce site.</p>
    </div>

    <div class="content-section">
      <h2>Liens externes</h2>
      <p>Ce site peut contenir des liens vers d'autres sites web. EcoDrive n'est pas responsable du contenu de ces sites externes. L'inclusion de liens ne constitue pas une endorsement.</p>
    </div>

    <div class="content-section">
      <h2>Données personnelles et protection</h2>
      <h3>Collecte de données</h3>
      <p>Le site peut collecter les informations suivantes :</p>
      <ul>
        <li>Nom et prénom</li>
        <li>Adresse e-mail</li>
        <li>Mot de passe (haché et sécurisé)</li>
        <li>Historique de navigation</li>
        <li>Informations de formulaires</li>
      </ul>
      <h3>Utilisation des données</h3>
      <p>Les données personnelles collectées sont utilisées uniquement pour :</p>
      <ul>
        <li>Gérer votre compte utilisateur</li>
        <li>Améliorer l'expérience utilisateur</li>
        <li>Envoyer des communications pertinentes</li>
        <li>Analyser les statistiques d'utilisation</li>
      </ul>
      <h3>Sécurité</h3>
      <p>EcoDrive s'engage à protéger vos données personnelles. Cependant, aucune transmission sur Internet n'est totalement sécurisée. Vous utilisez ce site à vos risques et périls.</p>
    </div>

    <div class="content-section">
      <h2>Cookies</h2>
      <p>Ce site peut utiliser des cookies pour améliorer votre expérience de navigation. Les cookies sont de petits fichiers stockés sur votre appareil. Vous pouvez désactiver les cookies via les paramètres de votre navigateur.</p>
    </div>

    <div class="content-section">
      <h2>Limitations de responsabilité</h2>
      <p>Le site est fourni « tel quel » sans garantie d'aucune sorte, expresse ou implicite. EcoDrive ne garantit pas :</p>
      <ul>
        <li>L'exactitude, l'exhaustivité ou la fiabilité des contenus</li>
        <li>L'absence d'interruption ou d'erreurs</li>
        <li>La conformité aux besoins spécifiques de l'utilisateur</li>
        <li>L'absence de virus ou de codes malveillants</li>
      </ul>
      <p>En aucun cas, EcoDrive ne sera responsable de dommages directs, indirects, accidentels, spéciaux ou consécutifs résultant de l'utilisation ou de l'impossibilité d'utiliser ce site.</p>
    </div>

    <div class="content-section">
      <h2>Conditions d'utilisation</h2>
      <h3>Conformité légale</h3>
      <p>En accédant et en utilisant ce site, vous acceptez de vous conformer à toutes les lois et réglementations applicables en Tunisie et internationalement.</p>
      <h3>Comportement interdit</h3>
      <p>Il est strictement interdit de :</p>
      <ul>
        <li>Accéder au site de manière non autorisée</li>
        <li>Utiliser le site pour des activités illégales</li>
        <li>Transmettre des virus ou codes malveillants</li>
        <li>Harceler ou menacer d'autres utilisateurs</li>
        <li>Reproduire, distribuer ou modifier le contenu sans autorisation</li>
        <li>Surcharger les serveurs avec des requêtes automatiques</li>
      </ul>
    </div>

    <div class="content-section">
      <h2>Modifications des conditions</h2>
      <p>EcoDrive se réserve le droit de modifier ces mentions légales à tout moment. Les modifications entrent en vigueur dès leur publication sur le site. Votre utilisation continue du site après les modifications constitue votre acceptation des nouvelles conditions.</p>
    </div>

    <div class="content-section">
      <h2>Droit applicable et juridiction</h2>
      <p>Ces mentions légales sont régies par les lois de la Tunisie. Tout litige ou différend découlant de ces conditions sera soumis à la juridiction exclusive des tribunaux tunisiens.</p>
    </div>

    <div class="content-section">
      <h2>Contact</h2>
      <h3>Pour toute question concernant ces mentions légales :</h3>
      <p><em>Email :</em> <a href="mailto:info@ecodrive.tn">info@ecodrive.tn</a></p>
      <p><em>Formulaire de contact :</em> Accessible via la <a href="contact.php">page contact</a></p>
      <h3>Responsable du projet</h3>
      <p><em>Nom :</em> Hayder Baccouri</p>
      <p><em>Formation :</em> Projet de fin de formation 2026</p>
      <p><em>Date de mise à jour :</em> 13 juin 2026</p>
    </div>
  </div>
</main>

<?php include __DIR__ . '/../php/partials/footer.php'; ?>

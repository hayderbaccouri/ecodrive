<?php
session_start();
$loggedIn = isset($_SESSION['user']);
$page_title = 'Politique de Confidentialité | EcoDrive';
$page_desc = 'Politique de confidentialité du site EcoDrive — showroom de voitures électriques en Tunisie.';
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
    <h1 class="hero-entrance">Politique de Confidentialité</h1>
    <div class="legal-meta">Dernière mise à jour : 13 juin 2026</div>

    <div class="content-section">
      <h2>Introduction</h2>
      <p>EcoDrive accorde une grande importance à la protection de vos données personnelles. La présente politique de confidentialité a pour objectif de vous informer sur la manière dont nous collectons, utilisons et protégeons vos informations lorsque vous utilisez notre site web.</p>
      <p>En utilisant le site EcoDrive, vous acceptez les pratiques décrites dans cette politique.</p>
    </div>

    <div class="content-section">
      <h2>Responsable du traitement</h2>
      <p>Le responsable du traitement des données est EcoDrive, représenté par Hayder Baccouri, dans le cadre d'un projet de fin de formation 2026.</p>
    </div>

    <div class="content-section">
      <h2>Données collectées</h2>
      <h3>Données que vous nous fournissez</h3>
      <ul>
        <li>Nom et prénom</li>
        <li>Adresse e-mail</li>
        <li>Numéro de téléphone</li>
        <li>Message via le formulaire de contact</li>
        <li>Informations de compte (nom d'utilisateur, mot de passe haché)</li>
      </ul>
      <h3>Données collectées automatiquement</h3>
      <ul>
        <li>Adresse IP</li>
        <li>Type et version du navigateur</li>
        <li>Pages visitées et durée de la visite</li>
        <li>Cookies et technologies similaires</li>
      </ul>
    </div>

    <div class="content-section">
      <h2>Base légale du traitement</h2>
      <p>Le traitement de vos données repose sur les bases légales suivantes :</p>
      <ul>
        <li><strong>Consentement :</strong> pour l'envoi de communications et l'utilisation de cookies non essentiels</li>
        <li><strong>Exécution contractuelle :</strong> pour la gestion de votre compte et des services associés</li>
        <li><strong>Intérêt légitime :</strong> pour l'amélioration du site et la sécurité</li>
      </ul>
    </div>

    <div class="content-section">
      <h2>Finalités du traitement</h2>
      <p>Nous utilisons vos données pour :</p>
      <ul>
        <li>Gérer votre compte utilisateur</li>
        <li>Répondre à vos demandes via le formulaire de contact</li>
        <li>Améliorer notre site et votre expérience utilisateur</li>
        <li>Assurer la sécurité et le bon fonctionnement du site</li>
        <li>Respecter nos obligations légales</li>
      </ul>
    </div>

    <div class="content-section">
      <h2>Durée de conservation</h2>
      <p>Vos données personnelles sont conservées aussi longtemps que nécessaire pour les finalités pour lesquelles elles ont été collectées :</p>
      <ul>
        <li>Données de compte : jusqu'à la suppression du compte</li>
        <li>Données de contact : 3 ans à compter du dernier contact</li>
        <li>Cookies : durée spécifiée dans chaque cookie</li>
      </ul>
    </div>

    <div class="content-section">
      <h2>Partage des données</h2>
      <p>Nous ne vendons pas vos données personnelles à des tiers. Vos données peuvent être partagées uniquement dans les cas suivants :</p>
      <ul>
        <li>Avec votre consentement explicite</li>
        <li>Pour respecter une obligation légale</li>
        <li>Avec des prestataires techniques (hébergement, maintenance) sous contrat</li>
      </ul>
    </div>

    <div class="content-section">
      <h2>Sécurité des données</h2>
      <p>Nous mettons en œuvre des mesures techniques et organisationnelles appropriées pour protéger vos données contre tout accès non autorisé, modification, divulgation ou destruction. Ces mesures incluent le chiffrement des mots de passe, l'utilisation de connexions sécurisées et des contrôles d'accès stricts.</p>
    </div>

    <div class="content-section">
      <h2>Vos droits</h2>
      <p>Conformément à la réglementation applicable en matière de protection des données, vous disposez des droits suivants :</p>
      <ul>
        <li>Droit d'accès à vos données</li>
        <li>Droit de rectification des données inexactes</li>
        <li>Droit à l'effacement (droit à l'oubli)</li>
        <li>Droit à la limitation du traitement</li>
        <li>Droit à la portabilité de vos données</li>
        <li>Droit d'opposition au traitement</li>
      </ul>
      <p>Pour exercer ces droits, veuillez nous contacter via la page contact ou à l'adresse email ci-dessous.</p>
    </div>

    <div class="content-section">
      <h2>Cookies</h2>
      <p>Notre site utilise des cookies pour améliorer votre expérience de navigation. Vous pouvez contrôler l'utilisation des cookies via les paramètres de votre navigateur. Les cookies que nous utilisons peuvent inclure :</p>
      <ul>
        <li>Cookies de session (nécessaires au fonctionnement du site)</li>
        <li>Cookies d'analyse (pour comprendre l'utilisation du site)</li>
        <li>Cookies de préférences (pour mémoriser vos choix)</li>
      </ul>
    </div>

    <div class="content-section">
      <h2>Modifications de la politique</h2>
      <p>Nous nous réservons le droit de modifier cette politique de confidentialité à tout moment. Les modifications seront publiées sur cette page avec une date de mise à jour révisée. Nous vous encourageons à consulter régulièrement cette page.</p>
    </div>

    <div class="content-section">
      <h2>Contact</h2>
      <p>Pour toute question concernant cette politique de confidentialité ou pour exercer vos droits :</p>
      <p><strong>Email :</strong> <a href="mailto:info@ecodrive.tn">info@ecodrive.tn</a></p>
      <p><strong>Contact :</strong> <a href="contact.php">Formulaire de contact</a></p>
    </div>
  </div>
</main>

<?php include __DIR__ . '/../php/partials/footer.php'; ?>

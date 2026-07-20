<?php
session_start();
$loggedIn = isset($_SESSION['user']);
$page_title = 'CGV | EcoDrive';
$page_desc = 'Conditions générales de vente d\'EcoDrive — showroom de voitures électriques en Tunisie.';
$page_url = 'pages/cgv.php';
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
    <h1 class="hero-entrance">Conditions Générales de Vente</h1>
    <div class="legal-meta">Dernière mise à jour : 13 juin 2026</div>

    <div class="content-section">
      <h2>Objet</h2>
      <p>Les présentes Conditions Générales de Vente (CGV) régissent les relations contractuelles entre EcoDrive, premier showroom électrique de Tunisie, et tout client souhaitant acquérir un véhicule électrique ou une borne de recharge via le site EcoDrive.</p>
    </div>

    <div class="content-section">
      <h2>Produits et services</h2>
      <p>EcoDrive propose à la vente :</p>
      <ul>
        <li>Des véhicules électriques neufs</li>
        <li>Des bornes de recharge domestiques et professionnelles</li>
        <li>Des services de conseil et d'accompagnement à la mobilité électrique</li>
      </ul>
    </div>

    <div class="content-section">
      <h2>Prix</h2>
      <p>Les prix affichés sur le site sont indiqués en dinars tunisiens (TND) TTC. EcoDrive se réserve le droit de modifier ses prix à tout moment. Les produits sont facturés sur la base des tarifs en vigueur au moment de la validation de la commande.</p>
    </div>

    <div class="content-section">
      <h2>Commande</h2>
      <p>La validation d'une commande implique l'acceptation expresse et sans réserve des présentes CGV. EcoDrive confirme la commande par email après validation du paiement ou de la demande d'essai.</p>
    </div>

    <div class="content-section">
      <h2>Paiement</h2>
      <p>Les modalités de paiement sont convenues entre le client et EcoDrive lors de la validation de la commande. Un acompte peut être demandé pour la réservation d'un véhicule.</p>
    </div>

    <div class="content-section">
      <h2>Livraison</h2>
      <p>Les délais de livraison sont communiqués à titre indicatif et peuvent varier selon la disponibilité des produits et les contraintes logistiques. EcoDrive s'efforce de respecter les délais annoncés sans pouvoir en garantir la stricte observance.</p>
    </div>

    <div class="content-section">
      <h2>Droit de rétractation</h2>
      <p>Conformément à la législation tunisienne, le client dispose d'un délai de rétractation de 7 jours à compter de la réception du produit, sauf exceptions prévues par la loi (produits configurés sur mesure, etc.).</p>
    </div>

    <div class="content-section">
      <h2>Garantie</h2>
      <p>Les véhicules électriques sont couverts par la garantie constructeur. Les bornes de recharge bénéficient d'une garantie de 2 ans. Les conditions détaillées sont fournies avec chaque produit.</p>
    </div>

    <div class="content-section">
      <h2>Responsabilité</h2>
      <p>EcoDrive ne saurait être tenu responsable des dommages indirects résultant de l'utilisation des produits vendus. La responsabilité d'EcoDrive est limitée au montant de la commande.</p>
    </div>

    <div class="content-section">
      <h2>Litiges</h2>
      <p>Les présentes CGV sont soumises au droit tunisien. Tout litige relève de la compétence des tribunaux tunisiens.</p>
    </div>

    <div class="content-section">
      <h2>Contact</h2>
      <p>Pour toute question relative aux CGV : <a href="mailto:info@ecodrive.tn">info@ecodrive.tn</a> ou via le <a href="contact.php">formulaire de contact</a>.</p>
    </div>
  </div>
</main>

<?php include __DIR__ . '/../php/partials/footer.php'; ?>

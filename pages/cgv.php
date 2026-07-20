<?php
session_start();
$loggedIn = isset($_SESSION['user']);
$page_title = 'CGV | EcoDrive';
$page_desc = 'Conditions gÃ©nÃ©rales de vente d\'EcoDrive â€” showroom de voitures Ã©lectriques en Tunisie.';
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
    <h1 class="hero-entrance">Conditions GÃ©nÃ©rales de Vente</h1>
    <div class="legal-meta">DerniÃ¨re mise Ã  jour : 13 juin 2026</div>

    <div class="content-section">
      <h2>Objet</h2>
      <p>Les prÃ©sentes Conditions GÃ©nÃ©rales de Vente (CGV) rÃ©gissent les relations contractuelles entre EcoDrive, premier showroom Ã©lectrique de Tunisie, et tout client souhaitant acquÃ©rir un vÃ©hicule Ã©lectrique ou une borne de recharge via le site EcoDrive.</p>
    </div>

    <div class="content-section">
      <h2>Produits et services</h2>
      <p>EcoDrive propose Ã  la vente :</p>
      <ul>
        <li>Des vÃ©hicules Ã©lectriques neufs</li>
        <li>Des bornes de recharge domestiques et professionnelles</li>
        <li>Des services de conseil et d'accompagnement Ã  la mobilitÃ© Ã©lectrique</li>
      </ul>
    </div>

    <div class="content-section">
      <h2>Prix</h2>
      <p>Les prix affichÃ©s sur le site sont indiquÃ©s en dinars tunisiens (TND) TTC. EcoDrive se rÃ©serve le droit de modifier ses prix Ã  tout moment. Les produits sont facturÃ©s sur la base des tarifs en vigueur au moment de la validation de la commande.</p>
    </div>

    <div class="content-section">
      <h2>Commande</h2>
      <p>La validation d'une commande implique l'acceptation expresse et sans rÃ©serve des prÃ©sentes CGV. EcoDrive confirme la commande par email aprÃ¨s validation du paiement ou de la demande d'essai.</p>
    </div>

    <div class="content-section">
      <h2>Paiement</h2>
      <p>Les modalitÃ©s de paiement sont convenues entre le client et EcoDrive lors de la validation de la commande. Un acompte peut Ãªtre demandÃ© pour la rÃ©servation d'un vÃ©hicule.</p>
    </div>

    <div class="content-section">
      <h2>Livraison</h2>
      <p>Les dÃ©lais de livraison sont communiquÃ©s Ã  titre indicatif et peuvent varier selon la disponibilitÃ© des produits et les contraintes logistiques. EcoDrive s'efforce de respecter les dÃ©lais annoncÃ©s sans pouvoir en garantir la stricte observance.</p>
    </div>

    <div class="content-section">
      <h2>Droit de rÃ©tractation</h2>
      <p>ConformÃ©ment Ã  la lÃ©gislation tunisienne, le client dispose d'un dÃ©lai de rÃ©tractation de 7 jours Ã  compter de la rÃ©ception du produit, sauf exceptions prÃ©vues par la loi (produits configurÃ©s sur mesure, etc.).</p>
    </div>

    <div class="content-section">
      <h2>Garantie</h2>
      <p>Les vÃ©hicules Ã©lectriques sont couverts par la garantie constructeur. Les bornes de recharge bÃ©nÃ©ficient d'une garantie de 2 ans. Les conditions dÃ©taillÃ©es sont fournies avec chaque produit.</p>
    </div>

    <div class="content-section">
      <h2>ResponsabilitÃ©</h2>
      <p>EcoDrive ne saurait Ãªtre tenu responsable des dommages indirects rÃ©sultant de l'utilisation des produits vendus. La responsabilitÃ© d'EcoDrive est limitÃ©e au montant de la commande.</p>
    </div>

    <div class="content-section">
      <h2>Litiges</h2>
      <p>Les prÃ©sentes CGV sont soumises au droit tunisien. Tout litige relÃ¨ve de la compÃ©tence des tribunaux tunisiens.</p>
    </div>

    <div class="content-section">
      <h2>Contact</h2>
      <p>Pour toute question relative aux CGV : <a href="mailto:info@ecodrive.tn">info@ecodrive.tn</a> ou via le <a href="contact.php">formulaire de contact</a>.</p>
    </div>
  </div>
</main>

<?php include __DIR__ . '/../php/partials/footer.php'; ?>

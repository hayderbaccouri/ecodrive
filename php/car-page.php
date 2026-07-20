<?php
// Car page template — reads $car from voitures/data.php and renders the full page.
include __DIR__ . '/configuration.php';
$page_title = $car['page_title'];
$page_desc  = $car['page_desc'];
$page_url   = $car['page_url'];
$page_image = $car['page_image'];
$h = $car['highlights'];
$sp = $car['specs_batterie'];
$sr = $car['specs_recharge'];
$sd = $car['specs_dimensions'];
$sm = $car['specs_motorisation'];
$carName = $car['jsonld']['name'];
$carId   = $car['car_id'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') ?></title>
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E%26%23x26A1%3B%3C/text%3E%3C/svg%3E">
  <link rel="stylesheet" href="../css/style.css?v=<?= CACHE_VERSION ?>">
  <?php include __DIR__ . '/partials/meta.php'; ?>
  <?php $jsonld_type = 'product'; $jsonld_product = ['name' => $carName, 'description' => htmlspecialchars($page_desc, ENT_QUOTES, 'UTF-8'), 'image' => 'https://ecodrive.tn/'.$page_image, 'brand' => $car['jsonld']['brand'], 'price' => $car['jsonld']['price']]; include __DIR__ . '/partials/jsonld.php'; ?>
</head>
<body>
<?php $asset_base = '../'; include __DIR__ . '/partials/header.php'; ?>

<nav class="breadcrumb" aria-label="breadcrumb">
  <a href="../index.php">Accueil</a> / <a href="../php/catalogue.php">Catalogue</a> / <span class="breadcrumb-current"><?= htmlspecialchars($car['breadcrumb'], ENT_QUOTES, 'UTF-8') ?></span>
</nav>

<main class="page-fade-in">
    <?php include '../php/car_slider.php'; renderCarSlider($car['slider']['dir'], $car['slider']['img'], $car['slider']['alt']); ?>
    <div class="car-actions-bar">
      <div class="price-block">
        <span class="price-label">À partir de</span>
        <span class="price-value"><?= $car['price_display'] ?> <small>DT</small></span>
      </div>
      <a href="../php/reservation.php?car=<?= $carId ?>" class="btn-reserve">Réserver un essai</a>
    </div>

    <section class="car-overview reveal reveal-up">
      <div class="specs-highlight">
        <?php foreach ($h as $hl): ?>
        <div class="spec-card">
          <div class="spec-label"><?= htmlspecialchars($hl['label'], ENT_QUOTES, 'UTF-8') ?></div>
          <div class="spec-value"><?= $hl['value'] ?> <?= $hl['unit'] ?><small><?= htmlspecialchars($hl['sub'], ENT_QUOTES, 'UTF-8') ?></small></div>
        </div>
        <?php endforeach; ?>
      </div>
    </section>

    <div class="section-title-wrap reveal reveal-up">
      <h2>Fiche technique</h2>
    </div>

    <section class="specs-detail reveal reveal-up reveal-delay-1">
      <div class="specs-grid">
        <div class="spec-group">
          <h3>Motorisation</h3>
          <dl>
            <div class="spec-row"><dt>Puissance max</dt><dd><?= htmlspecialchars($sm[0], ENT_QUOTES, 'UTF-8') ?></dd></div>
            <div class="spec-row"><dt>Couple max</dt><dd><?= htmlspecialchars($sm[1], ENT_QUOTES, 'UTF-8') ?></dd></div>
            <div class="spec-row"><dt>Transmission</dt><dd><?= htmlspecialchars($sm[2], ENT_QUOTES, 'UTF-8') ?></dd></div>
            <div class="spec-row"><dt>Vitesse max</dt><dd><?= htmlspecialchars($sm[3], ENT_QUOTES, 'UTF-8') ?></dd></div>
          </dl>
        </div>
        <div class="spec-group">
          <h3>Batterie & Autonomie</h3>
          <dl>
            <div class="spec-row"><dt>Capacité batterie</dt><dd><?= htmlspecialchars($sp['capacite'], ENT_QUOTES, 'UTF-8') ?></dd></div>
            <div class="spec-row"><dt>Type de batterie</dt><dd><?= htmlspecialchars($sp['type'], ENT_QUOTES, 'UTF-8') ?></dd></div>
            <div class="spec-row"><dt>Autonomie WLTP</dt><dd><?= htmlspecialchars($sp['autonomie'], ENT_QUOTES, 'UTF-8') ?></dd></div>
            <div class="spec-row"><dt><?= htmlspecialchars($sp['extra_name'], ENT_QUOTES, 'UTF-8') ?></dt><dd><?= htmlspecialchars($sp['extra_value'], ENT_QUOTES, 'UTF-8') ?></dd></div>
            <div class="spec-row battery-visual"><dt>Niveau</dt><dd><div class="battery-bar"><div class="battery-track"><div class="battery-fill high" data-width="<?= htmlspecialchars($sp['battery_fill'], ENT_QUOTES, 'UTF-8') ?>"></div></div><span class="battery-label"><?= htmlspecialchars($sp['battery_kwh'], ENT_QUOTES, 'UTF-8') ?></span></div></dd></div>
          </dl>
        </div>
        <div class="spec-group">
          <h3>Recharge</h3>
          <dl>
            <div class="spec-row"><dt>AC (Wallbox)</dt><dd><?= htmlspecialchars($sr[0], ENT_QUOTES, 'UTF-8') ?></dd></div>
            <div class="spec-row"><dt>DC (Rapide)</dt><dd><?= htmlspecialchars($sr[1], ENT_QUOTES, 'UTF-8') ?></dd></div>
          </dl>
        </div>
        <div class="spec-group">
          <h3>Dimensions</h3>
          <dl>
            <div class="spec-row"><dt>Longueur</dt><dd><?= htmlspecialchars($sd[0], ENT_QUOTES, 'UTF-8') ?></dd></div>
            <div class="spec-row"><dt>Largeur</dt><dd><?= htmlspecialchars($sd[1], ENT_QUOTES, 'UTF-8') ?></dd></div>
            <div class="spec-row"><dt>Hauteur</dt><dd><?= htmlspecialchars($sd[2], ENT_QUOTES, 'UTF-8') ?></dd></div>
            <div class="spec-row"><dt>Coffre</dt><dd><?= htmlspecialchars($sd[3], ENT_QUOTES, 'UTF-8') ?></dd></div>
          </dl>
        </div>
      </div>
    </section>

    <section class="reservation-cta reveal reveal-up reveal-delay-2">
      <div class="cta-box">
        <h2><?= htmlspecialchars($car['page_title'], ENT_QUOTES, 'UTF-8') ?></h2>
        <p>Réservez votre essai gratuit dès maintenant et découvrez l'expérience de conduite électrique EcoDrive.</p>
        <a href="../php/reservation.php?car=<?= $carId ?>" class="cta-btn">Réserver un essai gratuit</a>
      </div>
    </section>
</main>

<?php include __DIR__ . '/partials/footer.php'; ?>

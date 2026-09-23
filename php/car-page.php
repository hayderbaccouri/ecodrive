<?php
// Car page template — reads $car from voitures/data.php and renders the full page.
include __DIR__ . '/configuration.php';
// $car est fourni par les pages voitures/*.php (data.php) ou par un stub généré par l'admin.
// En accès direct : fallback vers la base de données, sinon redirection vers le catalogue.
if (!isset($car) || !is_array($car)) {
    $slug = isset($slug) ? (string)$slug : basename($_SERVER['SCRIPT_NAME'] ?? '', '.php');
    $car = ecodrive_car_from_slug($slug);
}
if (!isset($car) || !is_array($car)) {
    header('Location: catalogue.php');
    exit;
}

// Synchronisation dynamique : fusionner les données à jour de la BDD si modifiées par l'admin
if (!empty($car['car_id']) && isset($conn)) {
    $stmtCar = $conn->prepare("SELECT * FROM voiture WHERE id_voiture = ? LIMIT 1");
    if ($stmtCar) {
        $stmtCar->bind_param("i", $car['car_id']);
        $stmtCar->execute();
        $dbCar = $stmtCar->get_result()->fetch_assoc();
        $stmtCar->close();
        if ($dbCar) {
            $car['price_display'] = number_format((float)$dbCar['prix'], 0, ',', ' ');
            if (isset($car['jsonld'])) {
                $car['jsonld']['price'] = (string)$dbCar['prix'];
            }
            if (!empty($dbCar['image'])) {
                $car['page_image'] = $dbCar['image'];
                $car['slider']['img'] = basename($dbCar['image']);
                $car['slider']['dir'] = dirname($dbCar['image']) . '/';
            }
            if (!empty($dbCar['description'])) {
                $car['page_desc'] = $dbCar['description'];
            }
            if (!empty($dbCar['horsepower']) && isset($car['highlights'])) {
                foreach ($car['highlights'] as &$hl) {
                    if ($hl['label'] === 'Puissance') {
                        $hl['value'] = (string)$dbCar['horsepower'];
                        $hl['sub'] = round($dbCar['horsepower'] * 0.7355) . ' kW';
                    }
                }
                unset($hl);
            }
            if (!empty($dbCar['battery_kwh']) && isset($car['highlights'])) {
                $kwhFmt = rtrim(rtrim(number_format((float)$dbCar['battery_kwh'], 1, ',', ' '), '0'), ',');
                foreach ($car['highlights'] as &$hl) {
                    if ($hl['label'] === 'Batterie') { $hl['value'] = $kwhFmt; }
                }
                unset($hl);
            }
            if (!empty($dbCar['range_km']) && isset($car['highlights'])) {
                foreach ($car['highlights'] as &$hl) {
                    if ($hl['label'] === 'Autonomie') { $hl['value'] = (string)$dbCar['range_km']; }
                }
                unset($hl);
            }
        }
    }
}
$page_title = $car['page_title'];
$page_desc  = $car['page_desc'];
$page_url   = $car['page_url'];
$page_image = $car['page_image'];
$h = $car['highlights'];
$sp = $car['specs_batterie'];
$sr = $car['specs_recharge'];
$sd = $car['specs_dimensions'];
$sm = $car['specs_motorisation'];
$carName = $car['jsonld']['name'] ?? $car['breadcrumb'] ?? ($car['marque'] . ' ' . $car['modele']);
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
  <?php $jsonld_type = 'product'; $jsonld_product = ['name' => $carName, 'description' => htmlspecialchars($page_desc, ENT_QUOTES, 'UTF-8'), 'image' => app_url($page_image), 'brand' => $car['jsonld']['brand'], 'price' => $car['jsonld']['price']]; include __DIR__ . '/partials/jsonld.php'; ?>
</head>
<body>
<?php $asset_base = '../'; include __DIR__ . '/partials/header.php'; ?>

<nav class="breadcrumb" aria-label="breadcrumb">
  <a href="../index.php">Accueil</a> / <a href="../php/catalogue.php">Catalogue</a> / <span class="breadcrumb-current"><?= htmlspecialchars($car['breadcrumb'], ENT_QUOTES, 'UTF-8') ?></span>
</nav>

<main class="page-fade-in">
    <?php include __DIR__ . '/car_slider.php'; renderCarSlider($car['slider']['dir'], $car['slider']['img'], $car['slider']['alt']); ?>
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
        <a href="../php/comparer.php?toggle=<?= (int)$carId ?>&ret=<?= urlencode($_SERVER['REQUEST_URI'] ?? '') ?>" class="btn-compare<?= in_array($carId, $_SESSION['compare'] ?? [], true) ? ' is-active' : '' ?>">
          <?= in_array($carId, $_SESSION['compare'] ?? [], true) ? '✓ Comparé' : 'Comparer' ?>
        </a>
      </div>
    </section>
</main>

<?php include __DIR__ . '/partials/footer.php'; ?>

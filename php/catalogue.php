<?php
include 'bootstrap.php';

$user = $_SESSION['user'] ?? null;
$loggedIn = $user !== null;

// ── Récupération des filtres ──────────────────────────────────
$search    = trim($_GET['q'] ?? '');
$brand     = trim($_GET['brand'] ?? '');
$price_min = trim($_GET['price_min'] ?? '');
$price_max = trim($_GET['price_max'] ?? '');
$year      = trim($_GET['year'] ?? '');
$sort      = $_GET['sort'] ?? 'popular';

$allowedSort = ['price-asc', 'price-desc', 'year', 'popular'];
if (!in_array($sort, $allowedSort, true)) $sort = 'popular';

$orderSql = 'id_voiture ASC';
switch ($sort) {
    case 'price-asc':  $orderSql = 'prix ASC'; break;
    case 'price-desc': $orderSql = 'prix DESC'; break;
    case 'year':       $orderSql = 'annee DESC'; break;
}

// ── Construction dynamique de la requête ────────────────────
$conditions = [];
$params = [];
$types = '';

if ($search !== '') {
    $conditions[] = '(modele LIKE ? OR marque LIKE ?)';
    $params[] = "%{$search}%"; $params[] = "%{$search}%";
    $types .= 'ss';
}
if ($brand !== '') {
    $conditions[] = 'marque = ?';
    $params[] = $brand;
    $types .= 's';
}
if ($price_min !== '') {
    $conditions[] = 'prix >= ?';
    $params[] = (float) $price_min;
    $types .= 'd';
}
if ($price_max !== '') {
    $conditions[] = 'prix <= ?';
    $params[] = (float) $price_max;
    $types .= 'd';
}
if ($year !== '') {
    $conditions[] = 'annee = ?';
    $params[] = (int) $year;
    $types .= 'i';
}

$where = '';
if ($conditions) {
    $where = ' WHERE ' . implode(' AND ', $conditions);
}

// ── Requête ──────────────────────────────────────────────
$dataSql = 'SELECT * FROM voiture' . $where . ' ORDER BY ' . $orderSql;
$stmt = $conn->prepare($dataSql);
if ($types) $stmt->bind_param($types, ...$params);
$stmt->execute();
$voitures = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// ── Récupérer la liste des marques pour le filtre ──────────
$brands = $conn->query("SELECT DISTINCT marque FROM voiture ORDER BY marque")->fetch_all(MYSQLI_ASSOC);

$allCars = $conn->query("SELECT marque, modele FROM voiture ORDER BY marque, modele")->fetch_all(MYSQLI_ASSOC);
$jsonld_products = array_map(fn($c) => $c['marque'].' '.$c['modele'], $allCars);

// Fetch specs from database
$specsStmt = $conn->query("SELECT id_voiture, battery_kwh, horsepower, range_km FROM voiture");
$specsFromDb = [];
while ($row = $specsStmt->fetch_assoc()) {
    $specsFromDb[$row['id_voiture']] = $row;
}
$specsStmt->free();
?>
<?php
$page_title = 'Catalogue des voitures électriques | EcoDrive';
$page_desc = 'Découvrez notre catalogue complet de voitures électriques en Tunisie. Tesla, BMW, Mercedes, Peugeot et plus — comparez les modèles, prix et autonomies.';
$page_url = 'php/catalogue.php';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') ?></title>
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E%26%23x26A1%3B%3C/text%3E%3C/svg%3E">
  <?php include __DIR__ . '/partials/meta.php'; ?>
  <link rel="stylesheet" href="../css/style.css?v=17">
  <?php $jsonld_type = 'localbusiness'; include __DIR__ . '/partials/jsonld.php'; ?>
</head>

  <body class="has-topbar">
  <?php $asset_base = '../'; include __DIR__ . '/partials/header.php'; ?>


  <section id="results" class="showroom reveal reveal-up">
    <div style="max-width:var(--wrap-max);margin:0 auto">
      <h2 class="section-title">Trouvez votre voiture idéale</h2>
      <div class="blue-bar"></div>
    </div>

    <form id="catalogue-search" action="catalogue.php" method="get" class="controls-form">
      <div class="showroom-controls">
        <div class="controls-left">
          <label class="search-input">
            <input type="search" name="q" value="<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>" placeholder="Rechercher un modèle, marque..." aria-label="Recherche">
          </label>
          <div class="filter-field">
            <select name="brand" aria-label="Marque">
              <option value="">Marque (toutes)</option>
              <?php foreach ($brands as $b): ?>
                <option value="<?= htmlspecialchars($b['marque'], ENT_QUOTES) ?>"<?= $brand === $b['marque'] ? ' selected' : '' ?>><?= htmlspecialchars($b['marque']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="filter-field">
            <input type="number" name="price_min" value="<?= htmlspecialchars($price_min, ENT_QUOTES, 'UTF-8') ?>" placeholder="Prix min" aria-label="Prix min" step="1000">
          </div>
          <div class="filter-field">
            <input type="number" name="price_max" value="<?= htmlspecialchars($price_max, ENT_QUOTES, 'UTF-8') ?>" placeholder="Prix max" aria-label="Prix max" step="1000">
          </div>
          <div class="filter-field">
            <input type="number" name="year" value="<?= htmlspecialchars($year, ENT_QUOTES, 'UTF-8') ?>" placeholder="Année" aria-label="Année" min="2010" max="2026">
          </div>
          <div class="sort-select">
            <select aria-label="Trier" name="sort">
              <option value="popular"<?= $sort === 'popular' ? ' selected' : '' ?>>Trier : Populaire</option>
              <option value="price-asc"<?= $sort === 'price-asc' ? ' selected' : '' ?>>Prix : Bas → Haut</option>
              <option value="price-desc"<?= $sort === 'price-desc' ? ' selected' : '' ?>>Prix : Haut → Bas</option>
              <option value="year"<?= $sort === 'year' ? ' selected' : '' ?>>Année : Récent</option>
            </select>
          </div>
        </div>
        <div class="controls-right">
          <button class="btn-primary" type="submit">Filtrer</button>
          <?php if ($search !== '' || $brand !== '' || $price_min !== '' || $price_max !== '' || $year !== ''): ?>
            <a href="catalogue.php" class="btn-reset">✕ Réinitialiser</a>
          <?php endif; ?>
        </div>
      </div>
    </form>

    <div class="cars-grid reveal reveal-up reveal-delay-2">
      <?php if (count($voitures) === 0): ?>
        <div style="text-align:center;padding:3rem 1rem;grid-column:1/-1">
          <div style="font-size:3rem;margin-bottom:1rem">🔍</div>
          <h3 style="margin-bottom:.5rem">Aucune voiture trouvée</h3>
          <p style="color:var(--gray);margin-bottom:1rem">Essayez de modifier vos filtres ou <a href="catalogue.php" style="color:var(--accent)">réinitialisez la recherche</a>.</p>
        </div>
      <?php else: ?>
        <?php foreach ($voitures as $voiture): ?>
          <div class="card">
            <a href="<?= htmlspecialchars('../' . ltrim($voiture['details_page'] ?: '#', '/'), ENT_QUOTES, 'UTF-8') ?>" class="card-img-link">
              <div class="card-img-wrap">
                <img loading="lazy" src="<?= empty($voiture['image']) ? 'data:image/svg+xml,' . rawurlencode('<svg xmlns="http://www.w3.org/2000/svg" width="400" height="250" viewBox="0 0 400 250"><rect fill="#f0f4f8" width="400" height="250"/><text x="200" y="125" text-anchor="middle" dy=".35em" fill="#8a9baa" font-family="sans-serif" font-size="18">Aucune image</text></svg>') : htmlspecialchars('../' . ltrim($voiture['image'], '/'), ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($voiture['marque'] . ' ' . $voiture['modele'], ENT_QUOTES, 'UTF-8') ?>">
                <span class="card-year"><?= htmlspecialchars($voiture['annee'] ?: '2026', ENT_QUOTES, 'UTF-8') ?></span>
              </div>
            </a>
            <div class="card-body">
              <h3><?= htmlspecialchars($voiture['marque'], ENT_QUOTES, 'UTF-8') ?> <span><?= htmlspecialchars($voiture['modele'], ENT_QUOTES, 'UTF-8') ?></span></h3>
              <p class="price"><?= htmlspecialchars(number_format((float)$voiture['prix'], 0, ',', ' '), ENT_QUOTES, 'UTF-8') ?> <small>DN</small></p>
              <div class="card-specs">
                <?php
                $s = $specsFromDb[$voiture['id_voiture']] ?? null;
                if ($s && ($s['horsepower'] || $s['battery_kwh'] || $s['range_km'])): ?>
                  <?php if ($s['horsepower']): ?><span class="spec-chip"><?= (int)$s['horsepower'] ?> ch</span><?php endif; ?>
                  <?php if ($s['battery_kwh']): ?><span class="spec-chip"><?= htmlspecialchars($s['battery_kwh']) ?> kWh</span><?php endif; ?>
                  <?php if ($s['range_km']): ?><span class="spec-chip"><?= (int)$s['range_km'] ?> km</span><?php endif; ?>
                <?php else: ?>
                  <span class="spec-chip">Électrique</span>
                <?php endif; ?>
              </div>
              <div class="card-actions">
                <?php if ($loggedIn): ?>
                  <a class="btn-primary" href="reservation.php?car=<?= (int) $voiture['id_voiture'] ?>">Réserver un essai</a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </section>

<?php $asset_base = '../'; include __DIR__ . '/partials/footer.php'; ?>

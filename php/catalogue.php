<?php
session_start();
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

// ── Pagination ──────────────────────────────────────────────
$page  = max(1, (int) ($_GET['page'] ?? 1));
$limit = 12;
$offset = ($page - 1) * $limit;

// Total count
$countSql = 'SELECT COUNT(*) AS cnt FROM voiture' . $where;
$stmt = $conn->prepare($countSql);
if ($types) $stmt->bind_param($types, ...$params);
$stmt->execute();
$total = (int) $stmt->get_result()->fetch_assoc()['cnt'];
$stmt->close();
$totalPages = max(1, (int) ceil($total / $limit));

// Data query
$dataSql = 'SELECT * FROM voiture' . $where . ' ORDER BY ' . $orderSql . ' LIMIT ? OFFSET ?';
$params[] = $limit;
$params[] = $offset;
$types .= 'ii';

$stmt = $conn->prepare($dataSql);
if ($stmt === false) die('Erreur de requête SQL.');
$stmt->bind_param($types, ...$params);
$stmt->execute();
$voitures = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// ── Récupérer la liste des marques pour le filtre ──────────
$brands = $conn->query("SELECT DISTINCT marque FROM voiture ORDER BY marque")->fetch_all(MYSQLI_ASSOC);

// Specs lookup for catalogue card display
$specs = [
  'Audi A6 Sportback e-tron'      => ['ch' => 367,  'kWh' => 100,  'km' => 720],
  'BMW iX3'                       => ['ch' => 286,  'kWh' => 80,   'km' => 460],
  'BYD Atto 3'                    => ['ch' => 204,  'kWh' => 60.5, 'km' => 420],
  'BYD Dolphin Surf'              => ['ch' => 95,   'kWh' => 44.9, 'km' => 340],
  'Citroën C3'                    => ['ch' => 113,  'kWh' => 44,   'km' => 320],
  'Kia EV-3'                     => ['ch' => 204,  'kWh' => 58.3, 'km' => 420],
  'Mercedes-Benz CLK'             => ['ch' => 1150, 'kWh' => '-',  'km' => '-'],
  'Mercedes-Benz EQC 400 4MATIC'  => ['ch' => 408,  'kWh' => 80,   'km' => 400],
  'MG 4 Urban'                    => ['ch' => 204,  'kWh' => 61.7, 'km' => 420],
  'Peugeot e-208'                 => ['ch' => 136,  'kWh' => 50,   'km' => 340],
  'Porsche Panamera'              => ['ch' => 600,  'kWh' => '-',  'km' => '-'],
  'Renault Megane E-Tech'         => ['ch' => 220,  'kWh' => 60,   'km' => 450],
  'Tesla Model 3'                 => ['ch' => 283,  'kWh' => 60,   'km' => 452],
  'Tesla Model S Plaid'           => ['ch' => 1020, 'kWh' => 100,  'km' => 600],
  'Toyota Yaris'                  => ['ch' => 116,  'kWh' => '-',  'km' => '-'],
];
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EcoDrive — Catalogue des voitures</title>
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E%26%23x26A1%3B%3C/text%3E%3C/svg%3E">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/catalogue.css">
  <link rel="stylesheet" href="../css/header.css">
</head>

  <body class="has-topbar">
  <?php $asset_base = '../'; include __DIR__ . '/partials/header.php'; ?>

  <!-- Hero -->
  <section class="hero" aria-label="Catalogue EcoDrive">
    <div class="hero-inner">
      <div>
        <div class="hero-eyebrow">Catalogue</div>
        <h1>Notre sélection de véhicules électriques</h1>
        <p>Explorez <?= (int)$total ?> modèles disponibles. Filtrez par marque, prix et année pour trouver la voiture qui vous convient.</p>
        <p><a href="#results" class="cta">Voir les modèles</a></p>
      </div>
    </div>
  </section>

  <section id="results" class="showroom">
    <h2>Catalogue des voitures</h2>

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
          <button class="nav-cta">Filtrer</button>
          <?php if ($search !== '' || $brand !== '' || $price_min !== '' || $price_max !== '' || $year !== ''): ?>
            <a href="catalogue.php" class="btn-reset">✕ Réinitialiser</a>
          <?php endif; ?>
        </div>
      </div>
    </form>

    <div class="grid" class="reveal reveal-up reveal-delay-2">
      <?php if (count($voitures) === 0): ?>
        <div class="empty-state">Aucune voiture trouvée pour votre recherche.</div>
      <?php else: ?>
        <?php foreach ($voitures as $voiture): ?>
          <div class="card">
            <img loading="lazy" src="<?= empty($voiture['image']) ? 'data:image/svg+xml,' . rawurlencode('<svg xmlns="http://www.w3.org/2000/svg" width="400" height="250" viewBox="0 0 400 250"><rect fill="#1a1d20" width="400" height="250"/><text x="200" y="125" text-anchor="middle" dy=".35em" fill="#475569" font-family="sans-serif" font-size="18">Aucune image</text></svg>') : htmlspecialchars('../' . ltrim($voiture['image'], '/'), ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($voiture['marque'] . ' ' . $voiture['modele'], ENT_QUOTES, 'UTF-8') ?>">
            <h3><?= htmlspecialchars($voiture['marque'] . ' ' . $voiture['modele'], ENT_QUOTES, 'UTF-8') ?></h3>
            <p>Année : <?= htmlspecialchars($voiture['annee'] ?: '2026', ENT_QUOTES, 'UTF-8') ?></p>
            <p class="price"><?= htmlspecialchars(number_format((float)$voiture['prix'], 0, ',', ' '), ENT_QUOTES, 'UTF-8') ?> DN</p>
            <div class="card-specs">
              <?php
              $key = $voiture['marque'] . ' ' . $voiture['modele'];
              $s = $specs[$key] ?? null;
              if ($s): ?>
                <span class="spec-chip"><?= $s['ch'] ?> ch</span>
                <span class="spec-chip"><?= $s['kWh'] ?> kWh</span>
                <span class="spec-chip"><?= $s['km'] ?> km</span>
              <?php endif; ?>
            </div>
            <div class="card-actions">
              <a href="<?= htmlspecialchars('../' . ltrim($voiture['details_page'] ?: '#', '/'), ENT_QUOTES, 'UTF-8') ?>">Voir détails</a>
              <?php if ($loggedIn): ?>
                <a class="btn-primary" href="reservation.php?car=<?= (int) $voiture['id_voiture'] ?>">Réserver un essai</a>
              <?php else: ?>
                <a class="btn-ghost" href="connexion.php">Connectez-vous pour réserver</a>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

    <?php if ($totalPages > 1): ?>
      <div class="pagination">
        <?php
        $qs = $_GET;
        for ($i = 1; $i <= $totalPages; $i++):
          $qs['page'] = $i;
          $url = 'catalogue.php?' . http_build_query($qs);
        ?>
          <a href="<?= htmlspecialchars($url) ?>" class="page-link<?= $i === $page ? ' active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
      </div>
    <?php endif; ?>
  </section>

<?php $asset_base = '../'; include __DIR__ . '/partials/footer.php'; ?>

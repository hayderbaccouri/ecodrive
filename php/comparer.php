<?php
include 'bootstrap.php';

$page_title = 'Comparer les voitures électriques | EcoDrive';
$page_desc = 'Comparez les modèles EcoDrive : prix, autonomie, puissance et batterie, côte à côte.';
$page_url = 'php/comparer.php';
$asset_base = '../';

if (isset($_GET['clear'])) {
    unset($_SESSION['compare']);
    if (isset($_GET['ret']) && strpos($_GET['ret'], '/') === 0) {
        header('Location: ' . $_GET['ret']);
        exit;
    }
}

$id = (int)($_GET['toggle'] ?? 0);
if ($id > 0) {
    if (!isset($_SESSION['compare']) || !is_array($_SESSION['compare'])) {
        $_SESSION['compare'] = [];
    }
    $key = array_search($id, $_SESSION['compare'], true);
    if ($key !== false) {
        unset($_SESSION['compare'][$key]);
    } elseif (count($_SESSION['compare']) < 4) {
        $_SESSION['compare'][] = $id;
    }
    $_SESSION['compare'] = array_values(array_unique($_SESSION['compare']));
    if (isset($_GET['ret']) && strpos($_GET['ret'], '/') === 0) {
        header('Location: ' . $_GET['ret']);
        exit;
    }
}

$remove = (int)($_GET['remove'] ?? 0);
if ($remove > 0 && !empty($_SESSION['compare'])) {
    $_SESSION['compare'] = array_values(array_filter($_SESSION['compare'], fn($x) => $x != $remove));
}

$ids = array_values(array_unique($_SESSION['compare'] ?? []));
$voitures = [];
if ($ids) {
    $ph = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $conn->prepare("SELECT id_voiture, marque, modele, annee, prix, battery_kwh, horsepower, range_km, image, description, details_page FROM voiture WHERE id_voiture IN ($ph)");
    $stmt->bind_param(str_repeat('i', count($ids)), ...$ids);
    $stmt->execute();
    $voitures = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $order = array_flip($ids);
    usort($voitures, fn($a, $b) => ($order[$a['id_voiture']] ?? 0) <=> ($order[$b['id_voiture']] ?? 0));
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') ?></title>
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E%E2%9A%A1%3C/text%3E%3C/svg%3E">
  <link rel="canonical" href="<?= app_url($page_url) ?>">
  <?php include 'partials/meta.php'; ?>
  <link rel="stylesheet" href="../css/style.css?v=<?= CACHE_VERSION ?>">
</head>
<body class="client-area">
<?php include 'partials/header.php'; ?>

<main class="main-wrap page-fade-in">
  <div class="client-section">
    <h1 class="section-title">Comparer les modèles</h1>
    <p class="compare-intro">Comparez jusqu'à 4 véhicules électriques (prix, autonomie, puissance, batterie) pour faire votre choix.</p>

    <?php if (empty($voitures)): ?>
      <div class="client-empty">
        <p>Aucun véhicule sélectionné pour la comparaison.</p>
        <a href="<?= $asset_base ?>php/catalogue.php" class="btn btn-primary">Parcourir le catalogue</a>
      </div>
    <?php else: ?>
      <div class="compare-table-wrap reveal reveal-up">
        <table class="compare-table">
          <thead>
            <tr>
              <th scope="col"></th>
              <?php foreach ($voitures as $v): ?>
                <th scope="col">
                  <div class="compare-car-head">
                    <span class="compare-car-name"><?= htmlspecialchars($v['marque'] . ' ' . $v['modele'], ENT_QUOTES, 'UTF-8') ?></span>
                    <a href="comparer.php?remove=<?= (int)$v['id_voiture'] ?>" class="compare-remove" aria-label="Retirer de la comparaison">×</a>
                  </div>
                </th>
              <?php endforeach; ?>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">Photo</th>
              <?php foreach ($voitures as $v): ?>
                <td>
                  <?php if (!empty($v['image'])): ?>
                    <img loading="lazy" src="<?= htmlspecialchars('../' . ltrim($v['image'], '/'), ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($v['marque'] . ' ' . $v['modele'], ENT_QUOTES, 'UTF-8') ?>" class="compare-img">
                  <?php else: ?>
                    <div class="compare-img compare-img-empty">Aucune image</div>
                  <?php endif; ?>
                </td>
              <?php endforeach; ?>
            </tr>
            <tr>
              <th scope="row">Prix</th>
              <?php foreach ($voitures as $v): ?>
                <td class="compare-price"><?= htmlspecialchars(number_format((float)$v['prix'], 0, ',', ' '), ENT_QUOTES, 'UTF-8') ?> <small>DT</small></td>
              <?php endforeach; ?>
            </tr>
            <tr>
              <th scope="row">Année</th>
              <?php foreach ($voitures as $v): ?>
                <td><?= htmlspecialchars($v['annee'] ?: '—', ENT_QUOTES, 'UTF-8') ?></td>
              <?php endforeach; ?>
            </tr>
            <tr>
              <th scope="row">Puissance</th>
              <?php foreach ($voitures as $v): ?>
                <td><?= $v['horsepower'] ? (int)$v['horsepower'] . ' ch' : '—' ?></td>
              <?php endforeach; ?>
            </tr>
            <tr>
              <th scope="row">Batterie</th>
              <?php foreach ($voitures as $v): ?>
                <td><?= $v['battery_kwh'] ? htmlspecialchars($v['battery_kwh']) . ' kWh' : '—' ?></td>
              <?php endforeach; ?>
            </tr>
            <tr>
              <th scope="row">Autonomie</th>
              <?php foreach ($voitures as $v): ?>
                <td><?= $v['range_km'] ? (int)$v['range_km'] . ' km' : '—' ?></td>
              <?php endforeach; ?>
            </tr>
            <tr>
              <th scope="row">Détails</th>
              <?php foreach ($voitures as $v): ?>
                <td>
                  <?php if (!empty($v['details_page'])): ?>
                    <a href="<?= htmlspecialchars('../' . ltrim($v['details_page'], '/'), ENT_QUOTES, 'UTF-8') ?>" class="compare-link">Voir la fiche →</a>
                  <?php else: ?>—<?php endif; ?>
                </td>
              <?php endforeach; ?>
            </tr>
            <tr>
              <th scope="row">Essai</th>
              <?php foreach ($voitures as $v): ?>
                <td>
                  <?php if (isset($_SESSION['user'])): ?>
                    <a href="reservation.php?car=<?= (int)$v['id_voiture'] ?>" class="btn btn-sm btn-primary">Réserver</a>
                  <?php else: ?>
                    <a href="<?= $asset_base ?>php/connexion.php" class="compare-link">Connexion</a>
                  <?php endif; ?>
                </td>
              <?php endforeach; ?>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="compare-actions">
        <a href="comparer.php?clear=1" class="btn btn-ghost">Vider la comparaison</a>
        <a href="<?= $asset_base ?>php/catalogue.php" class="btn btn-primary">Ajouter un véhicule</a>
      </div>
    <?php endif; ?>
  </div>
</main>

<?php include 'partials/footer.php'; ?>
</body>
</html>

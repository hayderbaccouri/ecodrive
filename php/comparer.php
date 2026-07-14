<?php
include 'bootstrap.php';
$loggedIn = isset($_SESSION['user']);

$ids = array_map('intval', array_filter($_GET['car'] ?? []));
$cars = [];
if (!empty($ids)) {
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $types = str_repeat('i', count($ids));
    $stmt = $conn->prepare("SELECT * FROM voiture WHERE id_voiture IN ($placeholders)");
    $stmt->bind_param($types, ...$ids);
    $stmt->execute();
    $cars = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Comparer des voitures — EcoDrive</title>
  <link rel="stylesheet" href="../css/style.css?v=13">
  <?php include __DIR__ . '/partials/meta.php'; ?>
</head>
<body>
<?php $asset_base = '../'; include __DIR__ . '/partials/header.php'; ?>

<main class="compare-page page-fade-in">
  <h1 style="margin-bottom:1.5rem">Comparer des voitures</h1>
  
  <?php if (empty($cars)): ?>
    <div class="compare-empty">
      <p style="font-size:1.2rem;margin-bottom:1rem">Aucune voiture sélectionnée pour la comparaison.</p>
      <a href="catalogue.php" class="btn-primary">Parcourir le catalogue</a>
    </div>
  <?php else: ?>
    <div style="overflow-x:auto">
      <table class="compare-table">
        <thead>
          <tr style="background:var(--gray-light)">
            <th>Caractéristique</th>
            <?php foreach ($cars as $car): ?>
            <th>
              <div class="car-name"><?= htmlspecialchars($car['marque'] . ' ' . $car['modele']) ?></div>
              <div class="car-price"><?= number_format($car['prix'], 0, ',', ' ') ?> DT</div>
            </th>
            <?php endforeach; ?>
          </tr>
        </thead>
        <tbody>
          <tr><td>Puissance</td>
            <?php foreach ($cars as $car): ?><td><?= $car['horsepower'] ? $car['horsepower'] . ' ch' : '—' ?></td><?php endforeach; ?>
          </tr>
          <tr><td>Batterie</td>
            <?php foreach ($cars as $car): ?><td><?= $car['battery_kwh'] ? $car['battery_kwh'] . ' kWh' : '—' ?></td><?php endforeach; ?>
          </tr>
          <tr><td>Autonomie</td>
            <?php foreach ($cars as $car): ?><td><?= $car['range_km'] ? $car['range_km'] . ' km' : '—' ?></td><?php endforeach; ?>
          </tr>
          <tr><td>Année</td>
            <?php foreach ($cars as $car): ?><td><?= htmlspecialchars($car['annee'] ?? '—') ?></td><?php endforeach; ?>
          </tr>
          <tr><td>Essai</td>
            <?php foreach ($cars as $car): ?><td><a href="reservation.php?car=<?= $car['id_voiture'] ?>" class="btn-primary btn-sm">Réserver</a></td><?php endforeach; ?>
          </tr>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</main>

<?php include __DIR__ . '/partials/footer.php'; ?>
</body>
</html>

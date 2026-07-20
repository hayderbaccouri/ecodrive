<?php
include 'bootstrap.php';

if (!isset($_SESSION['user']['id'])) {
    header('Location: connexion.php');
    exit;
}
if (($_SESSION['user']['role'] ?? '') === 'admin') {
    header('Location: admin.php');
    exit;
}

$userId = $_SESSION['user']['id'];

$stmt = $conn->prepare("SELECT nom, email FROM utilisateur WHERE id_utilisateur = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

$sql = "SELECT r.id_reservation, v.marque, v.modele, r.date_essai, r.heure_debut, r.heure_fin, r.statut
        FROM reservation r JOIN voiture v ON r.voiture_id = v.id_voiture
        WHERE r.utilisateur_id = ? ORDER BY r.date_essai DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$reservations = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>
<?php
$page_title = 'Mes essais | EcoDrive';
$page_desc = 'Consultez l\'historique de vos essais de voitures électriques et suivez le statut de vos réservations EcoDrive.';
$page_url = 'php/mes-essais.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') ?></title>
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E%26%23x26A1%3B%3C/text%3E%3C/svg%3E">
  <?php include __DIR__ . '/partials/meta.php'; ?>
  <link rel="stylesheet" href="../css/style.css?v=<?= CACHE_VERSION ?>">
</head>
<body>
<?php $asset_base = '../'; include __DIR__ . '/partials/header.php'; ?>

  <main class="main-wrap page-fade-in">

    <div class="client-hero">
      <h1>Mes essais</h1>
      <p>Consultez l'historique et le statut de toutes vos réservations d'essai.</p>
      <div class="hero-actions">
        <a href="reservation.php" class="btn btn-primary">Réserver un essai</a>
        <a href="catalogue.php" class="btn btn-ghost">Parcourir le catalogue</a>
      </div>
    </div>

    <nav class="client-nav">
      <a href="tableau-de-bord.php">📊 Tableau de bord</a>
      <a href="mes-essais.php" class="active">🚗 Mes essais</a>
      <a href="profil.php">👤 Mon profil</a>
    </nav>

    <div class="client-section">
      <?php if (count($reservations) === 0): ?>
        <div class="client-empty">
          <p>Vous n'avez pas encore réservé d'essai.</p>
          <a href="catalogue.php" class="btn btn-primary">Parcourir le catalogue</a>
        </div>
      <?php else: ?>
        <div class="table-wrap">
        <table>
          <tr>
            <th>Voiture</th>
            <th>Date</th>
            <th>Horaire</th>
            <th>Statut</th>
            <th>Actions</th>
          </tr>
          <?php foreach ($reservations as $r): ?>
          <tr>
            <td data-label="Voiture" style="font-weight:400"><?= htmlspecialchars($r['marque'].' '.$r['modele']) ?></td>
            <td data-label="Date"><?= date('d/m/Y', strtotime($r['date_essai'])) ?></td>
            <td data-label="Horaire"><?= htmlspecialchars($r['heure_debut']) ?> → <?= htmlspecialchars($r['heure_fin']) ?></td>
            <td data-label="Statut">
              <?php if ($r['statut'] === 'pending'): ?>
                <span class="statut-pending">⏳ En attente</span>
              <?php elseif ($r['statut'] === 'confirmed'): ?>
                <span class="statut-confirmed">✅ Confirmée</span>
              <?php else: ?>
                <span class="statut-cancelled">❌ Annulée</span>
              <?php endif; ?>
            </td>
            <td data-label="Actions">
              <?php if (in_array($r['statut'], ['pending','confirmed'])): ?>
                <a href="reservation.php" class="btn btn-sm btn-ghost">Revoir</a>
              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; ?>
        </table>
        </div>
      <?php endif; ?>
    </div>
  </main>

<?php include __DIR__ . '/partials/footer.php'; ?>
</body>
</html>

<?php
include 'bootstrap.php';

if (!isset($_SESSION['user']['id']) || ($_SESSION['user']['role'] ?? '') !== 'client') {
    header('Location: connexion.php');
    exit;
}

$userId = $_SESSION['user']['id'];
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel'])) {
    if (!csrf_verify($_POST['csrf_token'] ?? '')) {
        $message = 'Session invalide.';
    } else {
    $reservationId = (int)$_POST['reservation_id'];
    $stmt = $conn->prepare("UPDATE reservation SET statut='cancelled' WHERE id_reservation=? AND utilisateur_id=?");
    $stmt->bind_param("ii", $reservationId, $userId);
    $stmt->execute() ? $message = 'Réservation annulée avec succès.' : $message = 'Erreur lors de l\'annulation.';
    $stmt->close();
    }
}

$stmt = $conn->prepare("SELECT nom, email FROM utilisateur WHERE id_utilisateur = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

$counts = ['pending' => 0, 'confirmed' => 0, 'cancelled' => 0];
$stmt = $conn->prepare("SELECT statut, COUNT(*) AS total FROM reservation WHERE utilisateur_id = ? GROUP BY statut");
$stmt->bind_param("i", $userId);
$stmt->execute();
foreach ($stmt->get_result()->fetch_all(MYSQLI_ASSOC) as $row) {
    $counts[$row['statut']] = (int)$row['total'];
}
$stmt->close();

$reservations = [];
$sql = "SELECT r.id_reservation, v.marque, v.modele, r.date_essai, r.heure_debut, r.heure_fin, r.statut, r.notes
        FROM reservation r JOIN voiture v ON r.voiture_id = v.id_voiture
        WHERE r.utilisateur_id = ? ORDER BY r.date_essai DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$reservations = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Données pour les graphiques : réservations par mois (6 derniers mois)
$monthlyLabels = [];
$monthlyData = [];
for ($i = 5; $i >= 0; $i--) {
    $monthlyLabels[] = date('M Y', strtotime("-$i months"));
    $month = date('Y-m', strtotime("-$i months"));
    $stmt = $conn->prepare("SELECT COUNT(*) AS cnt FROM reservation WHERE utilisateur_id = ? AND DATE_FORMAT(date_essai, '%Y-%m') = ?");
    $stmt->bind_param("is", $userId, $month);
    $stmt->execute();
    $monthlyData[] = (int)$stmt->get_result()->fetch_assoc()['cnt'];
    $stmt->close();
}
?>
<?php
$page_title = 'Tableau de bord | EcoDrive';
$page_desc = 'Gérez vos essais, modifiez votre profil et suivez votre activité EcoDrive depuis votre tableau de bord.';
$page_url = 'php/tableau-de-bord.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') ?></title>
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E%26%23x26A1%3B%3C/text%3E%3C/svg%3E">
  <?php include __DIR__ . '/partials/meta.php'; ?>
  <link rel="stylesheet" href="../css/style.css?v=15">
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
</head>
<body>
<?php $asset_base = '../'; include __DIR__ . '/partials/header.php'; ?>

  <main class="main-wrap page-fade-in">
  <!-- Hero -->
  <section class="hero" aria-label="Tableau de bord client">
    <div class="hero-inner">
      <div>
        <div class="hero-eyebrow">Tableau de bord</div>
        <h1>Bonjour <?= htmlspecialchars($user['nom']) ?> 👋</h1>
        <p>Consultez vos réservations, gérez vos essais et réservez de nouveaux modèles.</p>
        <p><a href="catalogue.php" class="cta">Parcourir le catalogue</a> <a href="mes-essais.php" class="cta">Mes essais</a></p>
      </div>
    </div>
  </section>

    <?php if (!empty($message)): ?>
      <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <!-- Cartes résumé -->
    <div class="dashboard-summary reveal reveal-up">
      <div class="summary-card">
        <strong>En attente</strong>
        <span><?= $counts['pending'] ?></span>
      </div>
      <div class="summary-card">
        <strong>Confirmées</strong>
        <span><?= $counts['confirmed'] ?></span>
      </div>
      <div class="summary-card">
        <strong>Annulées</strong>
        <span><?= $counts['cancelled'] ?></span>
      </div>
      <div class="summary-card">
        <strong>Total</strong>
        <span><?= array_sum($counts) ?></span>
      </div>
    </div>

    <!-- Graphiques -->
    <div class="chart-row reveal reveal-up reveal-delay-1">
      <div class="chart-card">
        <h3>Réservations par mois</h3>
        <canvas id="chartMonthly" width="300" height="180"></canvas>
      </div>
      <div class="chart-card">
        <h3>Statut des réservations</h3>
        <canvas id="chartStatus" width="300" height="180"></canvas>
      </div>
    </div>

    <script>
    new Chart(document.getElementById('chartMonthly'), {
      type: 'bar',
      data: {
        labels: <?= json_encode($monthlyLabels) ?>,
        datasets: [{ label: 'Réservations', data: <?= json_encode($monthlyData) ?>, backgroundColor: 'rgba(60,154,190,0.6)', borderColor: '#3C9ABE', borderWidth: 1, borderRadius: 4 }]
      },
      options: { responsive: true, maintainAspectRatio: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
    });
    new Chart(document.getElementById('chartStatus'), {
      type: 'doughnut',
      data: {
        labels: ['En attente', 'Confirmées', 'Annulées'],
        datasets: [{ data: [<?= (int)$counts['pending'] ?>, <?= (int)$counts['confirmed'] ?>, <?= (int)$counts['cancelled'] ?>], backgroundColor: ['#f59e0b', '#22c55e', '#ef4444'], borderWidth: 0 }]
      },
      options: { responsive: true, maintainAspectRatio: true, plugins: { legend: { position: 'bottom', labels: { font: { size: 11 } } } } }
    });
    </script>

    <h2>📌 Mes réservations</h2>

    <?php if (count($reservations) === 0): ?>
      <p class="mt-lg text-muted">Vous n'avez pas encore réservé d'essai.</p>
      <a href="catalogue.php" class="btn btn-primary">Parcourir le catalogue</a>
    <?php else: ?>
      <div class="table-wrap">
      <table>
        <tr>
          <th>Voiture</th>
          <th>Date</th>
          <th>Début</th>
          <th>Fin</th>
          <th>Notes</th>
          <th>Statut</th>
          <th>Action</th>
        </tr>
        <?php foreach ($reservations as $r): ?>
        <tr>
          <td data-label="Voiture"><?= htmlspecialchars($r['marque'].' '.$r['modele']) ?></td>
          <td data-label="Date"><?= htmlspecialchars($r['date_essai']) ?></td>
          <td data-label="Début"><?= htmlspecialchars($r['heure_debut']) ?></td>
          <td data-label="Fin"><?= htmlspecialchars($r['heure_fin']) ?></td>
          <td data-label="Notes"><?= htmlspecialchars($r['notes'] ?? '') ?: '—' ?></td>
          <td data-label="Statut">
            <?php if ($r['statut'] === 'pending'): ?>
              <span class="statut-pending">⏳ En attente</span>
            <?php elseif ($r['statut'] === 'confirmed'): ?>
              <span class="statut-confirmed">✅ Confirmée</span>
            <?php else: ?>
              <span class="statut-cancelled">❌ Annulée</span>
            <?php endif; ?>
          </td>
          <td data-label="Action">
            <?php if ($r['statut'] === 'pending'): ?>
              <form method="POST" class="form-inline">
                <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                <input type="hidden" name="reservation_id" value="<?= (int)$r['id_reservation'] ?>">
                <button type="submit" name="cancel" class="btn btn-sm btn-danger" onclick="return confirm('Annuler cette réservation ?')">Annuler</button>
              </form>
            <?php else: ?>
              <em class="text-muted">—</em>
            <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </table>
      </div>
    <?php endif; ?>
  </main>

<?php include __DIR__ . '/partials/footer.php'; ?>

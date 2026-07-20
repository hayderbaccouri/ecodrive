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
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel'])) {
    if (!csrf_verify($_POST['csrf_token'] ?? '')) {
        $message = 'Session invalide.';
    } else {
    $reservationId = (int)$_POST['reservation_id'];
    $stmt = $conn->prepare("UPDATE reservation SET statut='cancelled' WHERE id_reservation=? AND utilisateur_id=? AND statut IN ('pending','confirmed')");
    $stmt->bind_param("ii", $reservationId, $userId);
    $stmt->execute() && $stmt->affected_rows > 0 ? $message = 'Réservation annulée avec succès.' : $message = 'Impossible d\'annuler cette réservation.';
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
$sql = "SELECT r.id_reservation, v.marque, v.modele, v.image, r.date_essai, r.heure_debut, r.heure_fin, r.statut, r.notes
        FROM reservation r JOIN voiture v ON r.voiture_id = v.id_voiture
        WHERE r.utilisateur_id = ? ORDER BY r.date_essai DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$reservations = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$nextReservation = null;
foreach ($reservations as $r) {
    if (in_array($r['statut'], ['pending','confirmed']) && $r['date_essai'] >= date('Y-m-d')) {
        $nextReservation = $r;
        break;
    }
}
?>
<?php
$page_title = 'Mon espace | EcoDrive';
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
  <link rel="stylesheet" href="../css/style.css?v=19">
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
</head>
<body>
<?php $asset_base = '../'; include __DIR__ . '/partials/header.php'; ?>

  <main class="main-wrap page-fade-in">

    <div class="client-hero">
      <h1>Bonjour <?= htmlspecialchars($user['nom']) ?> 👋</h1>
      <p>Bienvenue dans votre espace. Retrouvez vos réservations et gérez votre profil.</p>
      <div class="hero-actions">
        <a href="catalogue.php" class="btn btn-primary">Parcourir le catalogue</a>
        <a href="reservation.php" class="btn btn-ghost">Réserver un essai</a>
      </div>
    </div>

    <?php if (!empty($message)): ?>
      <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <nav class="client-nav">
      <a href="tableau-de-bord.php" class="active">📊 Tableau de bord</a>
      <a href="mes-essais.php">🚗 Mes essais</a>
      <a href="profil.php">👤 Mon profil</a>
    </nav>

    <?php if ($nextReservation): ?>
    <div class="client-section" style="margin-bottom:2rem">
      <div style="background:rgba(var(--blue-rgb),0.05);border:1px solid rgba(var(--blue-rgb),0.15);border-radius:var(--radius-lg);padding:1.25rem 1.5rem;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem">
        <div>
          <div style="font-size:.82rem;color:var(--gray);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.25rem">Prochain essai</div>
          <div style="font-size:1.1rem;font-weight:400;color:var(--dark)"><?= htmlspecialchars($nextReservation['marque'].' '.$nextReservation['modele']) ?> — <?= date('d/m/Y', strtotime($nextReservation['date_essai'])) ?></div>
          <div style="font-size:.9rem;color:var(--gray)"><?= htmlspecialchars($nextReservation['heure_debut']) ?> → <?= htmlspecialchars($nextReservation['heure_fin']) ?></div>
        </div>
        <span class="statut-<?= $nextReservation['statut'] ?>"><?= $nextReservation['statut'] === 'pending' ? '⏳ En attente' : '✅ Confirmée' ?></span>
      </div>
    </div>
    <?php endif; ?>

    <div class="client-section">
      <div class="dashboard-summary">
        <div class="summary-card">
          <em>En attente</em>
          <span><?= $counts['pending'] ?></span>
        </div>
        <div class="summary-card">
          <em>Confirmées</em>
          <span><?= $counts['confirmed'] ?></span>
        </div>
        <div class="summary-card">
          <em>Annulées</em>
          <span><?= $counts['cancelled'] ?></span>
        </div>
        <div class="summary-card">
          <em>Total</em>
          <span><?= array_sum($counts) ?></span>
        </div>
      </div>

      <div class="chart-row">
        <div class="chart-card">
          <h3>Réservations par mois</h3>
          <canvas id="chartMonthly" width="300" height="180"></canvas>
        </div>
        <div class="chart-card">
          <h3>Répartition par statut</h3>
          <canvas id="chartStatus" width="300" height="180"></canvas>
        </div>
      </div>

      <script>
      new Chart(document.getElementById('chartMonthly'), {
        type: 'bar',
        data: {
          labels: <?= json_encode($monthlyLabels ?? []) ?>,
          datasets: [{ label: 'Réservations', data: <?= json_encode($monthlyData ?? []) ?>, backgroundColor: 'rgba(60,154,190,0.6)', borderColor: '#3C9ABE', borderWidth: 1, borderRadius: 4 }]
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

      <h2>📋 Mes réservations</h2>

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
                <span class="statut-pending">En attente</span>
              <?php elseif ($r['statut'] === 'confirmed'): ?>
                <span class="statut-confirmed">Confirmée</span>
              <?php else: ?>
                <span class="statut-cancelled">Annulée</span>
              <?php endif; ?>
            </td>
            <td data-label="Actions">
              <?php if (in_array($r['statut'], ['pending', 'confirmed'])): ?>
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
    </div>
  </main>

<?php include __DIR__ . '/partials/footer.php'; ?>

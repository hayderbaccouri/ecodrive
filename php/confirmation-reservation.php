<?php
include 'bootstrap.php';

if (!isset($_SESSION['user']['id'])) {
    header('Location: connexion.php');
    exit;
}

$reservationId = $_SESSION['last_reservation_id'] ?? 0;
$reservation = null;

if ($reservationId) {
    $stmt = $conn->prepare("
        SELECT r.id_reservation, r.date_essai, r.heure_debut, r.heure_fin, r.statut, r.notes,
               v.marque, v.modele, v.image
        FROM reservation r
        JOIN voiture v ON r.voiture_id = v.id_voiture
        WHERE r.id_reservation = ? AND r.utilisateur_id = ?
    ");
    $stmt->bind_param("ii", $reservationId, $_SESSION['user']['id']);
    $stmt->execute();
    $reservation = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    unset($_SESSION['last_reservation_id']);
}

if (!$reservation) {
    header('Location: reservation.php');
    exit;
}
?>
<?php
$page_title = 'Confirmation de réservation | EcoDrive';
$page_desc = 'Votre réservation d\'essai a été confirmée. Retrouvez tous les détails sur votre tableau de bord.';
$page_url = 'php/confirmation-reservation.php';
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

    <div class="client-hero" style="text-align:center">
      <div class="confirmation-icon hero-entrance">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color:var(--accent)">
          <polyline points="20 6 9 17 4 12"></polyline>
        </svg>
      </div>
      <h1 class="hero-entrance">Réservation confirmée !</h1>
      <p class="hero-entrance" style="color:var(--gray)">Votre demande d'essai a bien été enregistrée.</p>
    </div>

    <nav class="client-nav">
      <a href="tableau-de-bord.php">📊 Tableau de bord</a>
      <a href="mes-essais.php">🚗 Mes essais</a>
      <a href="profil.php">👤 Mon profil</a>
    </nav>

    <div class="client-section">
      <div class="confirmation-details reveal reveal-up">
        <div class="detail-row">
          <span class="detail-label">Voiture</span>
          <span class="detail-value"><?= htmlspecialchars($reservation['marque'] . ' ' . $reservation['modele']) ?></span>
        </div>
        <div class="detail-row">
          <span class="detail-label">Date</span>
          <span class="detail-value"><?= date('d/m/Y', strtotime($reservation['date_essai'])) ?></span>
        </div>
        <div class="detail-row">
          <span class="detail-label">Horaire</span>
          <span class="detail-value"><?= htmlspecialchars($reservation['heure_debut']) ?> → <?= htmlspecialchars($reservation['heure_fin']) ?></span>
        </div>
        <div class="detail-row">
          <span class="detail-label">Statut</span>
          <span class="detail-value">
            <?php if ($reservation['statut'] === 'pending'): ?>
              <span class="statut-pending">⏳ En attente de confirmation</span>
            <?php elseif ($reservation['statut'] === 'confirmed'): ?>
              <span class="statut-confirmed">✅ Confirmée</span>
            <?php else: ?>
              <span class="statut-cancelled">❌ Annulée</span>
            <?php endif; ?>
          </span>
        </div>
        <?php if (!empty($reservation['notes'])): ?>
        <div class="detail-row">
          <span class="detail-label">Notes</span>
          <span class="detail-value"><?= htmlspecialchars($reservation['notes']) ?></span>
        </div>
        <?php endif; ?>
      </div>

      <div class="next-steps reveal reveal-up reveal-delay-1 text-center" style="margin-top:2rem">
        <h2 style="font-family:var(--font-display);font-weight:400">Prochaines étapes</h2>
        <p style="color:var(--gray);max-width:500px;margin:0 auto">
          Notre équipe examinera votre demande et vous confirmera le rendez-vous.<br>
          Vous pouvez suivre l'état de votre réservation dans votre tableau de bord.
        </p>
      </div>

      <div class="confirmation-actions" style="margin-top:2rem;text-align:center;display:flex;flex-wrap:wrap;gap:.75rem;justify-content:center">
        <a href="export-ics.php?id=<?= $reservationId ?>" class="btn btn-primary" style="display:inline-flex;align-items:center;gap:.5rem">📅 Ajouter au calendrier</a>
        <a href="tableau-de-bord.php" class="btn btn-primary">Voir mes réservations</a>
        <a href="catalogue.php" class="btn btn-ghost">Retour au catalogue</a>
      </div>
    </div>
  </main>

<?php include __DIR__ . '/partials/footer.php'; ?>
</body>
</html>

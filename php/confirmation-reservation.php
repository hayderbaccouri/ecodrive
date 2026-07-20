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
  <link rel="stylesheet" href="../css/style.css?v=16">
</head>
<body>
  <?php $asset_base = '../'; include __DIR__ . '/partials/header.php'; ?>

  <main class="main-wrap page-fade-in">
    <div class="confirmation-icon hero-entrance">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color:var(--accent)">
        <polyline points="20 6 9 17 4 12"></polyline>
      </svg>
    </div>

    <h1 class="hero-entrance text-center">Réservation confirmée !</h1>
    <p class="hero-entrance text-center" style="color:var(--grey-2);">Votre demande d'essai a bien été enregistrée.</p>

    <div class="confirmation-details reveal reveal-up">
      <div class="detail-row">
        <span class="detail-label">Voiture</span>
        <span class="detail-value"><?= htmlspecialchars($reservation['marque'] . ' ' . $reservation['modele']) ?></span>
      </div>
      <div class="detail-row">
        <span class="detail-label">Date</span>
        <span class="detail-value"><?= htmlspecialchars($reservation['date_essai']) ?></span>
      </div>
      <div class="detail-row">
        <span class="detail-label">Horaire</span>
        <span class="detail-value"><?= htmlspecialchars($reservation['heure_debut']) ?> &rarr; <?= htmlspecialchars($reservation['heure_fin']) ?></span>
      </div>
      <div class="detail-row">
        <span class="detail-label">Statut</span>
        <span class="detail-value">
          <?php if ($reservation['statut'] === 'pending'): ?>
            <span style="color:var(--accent);">&#9203; En attente de confirmation</span>
          <?php elseif ($reservation['statut'] === 'confirmed'): ?>
            <span style="color:var(--green);">&#9989; Confirm&eacute;e</span>
          <?php else: ?>
            <span style="color:var(--danger);">&#10060; Annul&eacute;e</span>
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

    <div class="next-steps reveal reveal-up reveal-delay-1 text-center">
      <h2>Prochaines &eacute;tapes</h2>
      <p style="color:var(--grey-2);max-width:500px;margin:0 auto;">
        Notre &eacute;quipe examinera votre demande et vous confirmera le rendez-vous.<br>
        Vous pouvez suivre l'&eacute;tat de votre r&eacute;servation dans votre tableau de bord.
      </p>
    </div>

    <div class="confirmation-actions">
      <a href="export-ics.php?id=<?= $reservationId ?>" class="btn-primary" style="display:inline-flex;align-items:center;gap:.5rem;padding:.6rem 1.2rem;font-size:.85rem">📅 Ajouter au calendrier</a>
      <a href="tableau-de-bord.php" class="btn-primary">Voir mes r&eacute;servations</a>
      <a href="catalogue.php" class="btn-ghost">Retour au catalogue</a>
    </div>
  </main>

  <?php $asset_base = '../'; include __DIR__ . '/partials/footer.php'; ?>

<?php
include 'bootstrap.php';

// Vérifier que l'utilisateur est connecté et est client
if (!isset($_SESSION['user']['id']) || ($_SESSION['user']['role'] ?? '') !== 'client') {
    header('Location: connexion.php');
    exit;
}

$userId = $_SESSION['user']['id'];

// Récupérer les infos utilisateur
$stmt = $conn->prepare("SELECT nom, email FROM utilisateur WHERE id_utilisateur = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Récupérer toutes les réservations du client
$sql = "SELECT r.id_reservation, v.marque, v.modele, r.date_essai, r.heure_debut, r.heure_fin, r.statut
        FROM reservation r
        JOIN voiture v ON r.voiture_id = v.id_voiture
        WHERE r.utilisateur_id = ?
        ORDER BY r.date_essai DESC";
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
  <link rel="stylesheet" href="../css/style.css?v=17">
</head>
<body>
<?php $asset_base = '../'; include __DIR__ . '/partials/header.php'; ?>

  <main class="main-wrap page-fade-in">
    <h1>Mes essais</h1>

  <section>
    <h2>📌 Historique de mes essais</h2>
    <?php if (count($reservations) === 0): ?>
      <p>Vous n'avez pas encore réservé d'essai.</p>
    <?php else: ?>
      <div class="table-wrap">
      <table>
        <tr>
          <th>ID</th>
          <th>Voiture</th>
          <th>Date</th>
          <th>Heure début</th>
          <th>Heure fin</th>
          <th>Statut</th>
        </tr>
        <?php foreach ($reservations as $r): ?>
        <tr>
          <td data-label="ID"><?= (int)$r['id_reservation'] ?></td>
          <td data-label="Voiture"><?= htmlspecialchars($r['marque'].' '.$r['modele']) ?></td>
          <td data-label="Date"><?= htmlspecialchars($r['date_essai']) ?></td>
          <td data-label="Heure début"><?= htmlspecialchars($r['heure_debut']) ?></td>
          <td data-label="Heure fin"><?= htmlspecialchars($r['heure_fin']) ?></td>
          <td data-label="Statut">
            <?php if ($r['statut'] === 'pending'): ?>
              ⏳ En attente
            <?php elseif ($r['statut'] === 'confirmed'): ?>
              ✅ Confirmée
            <?php else: ?>
              ❌ Annulée
            <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </table>
      </div>
    <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </table>
    <?php endif; ?>
  </section>
  </main>

<?php include __DIR__ . '/partials/footer.php'; ?>

<?php
session_start();
include 'configuration.php';

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
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Mes essais — EcoDrive</title>
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E%26%23x26A1%3B%3C/text%3E%3C/svg%3E">
  <link rel="stylesheet" href="../css/dashboard.css">
  <link rel="stylesheet" href="../css/header.css">
</head>
<body>
  <header class="site-header">
    <a href="../index.php" class="logo-text">eco<span>drive</span></a>
    <nav>
      <a href="../index.php">Accueil</a>
      <a href="catalogue.php">Catalogue</a>
      <a href="tableau-de-bord.php">Tableau de bord</a>
      <a href="profil.php">Profil</a>
      <a href="deconnexion.php">Déconnexion</a>
      <button class="burger" aria-label="Menu" onclick="this.classList.toggle('open');document.querySelector('.site-header nav').classList.toggle('open')"><span></span><span></span><span></span></button>
    </nav>
  </header>

  <main class="main-wrap">
    <h1>Mes essais</h1>

  <section>
    <h2>📌 Historique de mes essais</h2>
    <?php if (count($reservations) === 0): ?>
      <p>Vous n’avez pas encore réservé d’essai.</p>
    <?php else: ?>
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
          <td><?= (int)$r['id_reservation'] ?></td>
          <td><?= htmlspecialchars($r['marque'].' '.$r['modele']) ?></td>
          <td><?= htmlspecialchars($r['date_essai']) ?></td>
          <td><?= htmlspecialchars($r['heure_debut']) ?></td>
          <td><?= htmlspecialchars($r['heure_fin']) ?></td>
          <td>
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
    <?php endif; ?>
  </section>
  </main>

  <footer class="site-footer">&copy; 2026 EcoDrive — Showroom de voitures électriques</footer>
<button class="back-to-top" aria-label="Retour en haut">&uarr;</button>
<script src="../js/app.js"></script>
</body>
</html>

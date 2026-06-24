<?php
session_start();
include 'configuration.php';

if (!isset($_SESSION['user']['id'])) {
    header('Location: connexion.php');
    exit;
}

$message = '';
$messageType = '';
$voitureId = (int)($_GET['car'] ?? 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_verify($_POST['csrf_token'] ?? '')) {
        $message = 'Session invalide. Veuillez réessayer.';
        $messageType = 'error';
    } else {
    $utilisateurId = $_SESSION['user']['id'];
    $voitureId     = (int)($_POST['voiture_id'] ?? 0);
    $dateEssai     = $_POST['date_essai'] ?? '';
    $heureDebut    = $_POST['heure_debut'] ?? '';
    $heureFin      = $_POST['heure_fin'] ?? '';
    $notes         = trim($_POST['notes'] ?? '');

    // 1. Champs requis
    if (!$voitureId || !$dateEssai || !$heureDebut || !$heureFin) {
        $message = 'Veuillez remplir tous les champs obligatoires.';
        $messageType = 'error';
    }

    // 2. Vérifier que la voiture existe
    if (!$message) {
        $stmt = $conn->prepare("SELECT id_voiture, marque, modele FROM voiture WHERE id_voiture = ?");
        $stmt->bind_param("i", $voitureId);
        $stmt->execute();
        $car = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        if (!$car) {
            $message = 'Voiture introuvable.';
            $messageType = 'error';
        }
    }

    // 3. Date future ou aujourd'hui (pas dans le passé)
    if (!$message) {
        $today = date('Y-m-d');
        if ($dateEssai < $today) {
            $message = 'La date d\'essai doit être aujourd\'hui ou dans le futur.';
            $messageType = 'error';
        }
    }

    // 4. heure_debut < heure_fin
    if (!$message) {
        if ($heureDebut >= $heureFin) {
            $message = 'L\'heure de fin doit être après l\'heure de début.';
            $messageType = 'error';
        }
    }

    // 5. Vérifier les conflits (même voiture, même jour, créneaux qui se chevauchent)
    if (!$message) {
        $stmt = $conn->prepare(
            "SELECT id_reservation FROM reservation
             WHERE voiture_id = ? AND date_essai = ? AND statut != 'cancelled'
               AND heure_debut < ? AND heure_fin > ?"
        );
        $stmt->bind_param("isss", $voitureId, $dateEssai, $heureFin, $heureDebut);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            $message = 'Ce créneau est déjà réservé pour cette voiture. Veuillez choisir une autre heure ou une autre date.';
            $messageType = 'error';
        }
        $stmt->close();
    }

    // 6. Tout est bon → insertion
    if (!$message) {
        $stmt = $conn->prepare("INSERT INTO reservation (utilisateur_id, voiture_id, date_essai, heure_debut, heure_fin, notes, statut) VALUES (?,?,?,?,?,?, 'pending')");
        $stmt->bind_param("iissss", $utilisateurId, $voitureId, $dateEssai, $heureDebut, $heureFin, $notes);
        if ($stmt->execute()) {
            $message = 'Votre demande d\'essai a été enregistrée. Elle est en attente de confirmation.';
            $messageType = 'success';
            $_POST = []; // clear form
        } else {
            $message = 'Erreur lors de l\'enregistrement de la réservation.';
            $messageType = 'error';
        }
        $stmt->close();
    }
    } // fin else CSRF
}

$voitures = $conn->query("SELECT id_voiture, marque, modele FROM voiture ORDER BY marque, modele")->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Réservation d'essai — EcoDrive</title>
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E%26%23x26A1%3B%3C/text%3E%3C/svg%3E">
  <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>
  <header class="site-header">
    <a href="../index.php" class="logo-text">eco<span>drive</span></a>
    <nav>
      <a href="../index.php">Accueil</a>
      <a href="../php/catalogue.php">Catalogue</a>
      <a href="../php/tableau-de-bord.php">Mon espace</a>
      <a href="../php/deconnexion.php">Déconnexion</a>
    </nav>
  </header>

  <main class="main-wrap">
    <h1>Réservation d'essai</h1>

    <?php if (!empty($message)): ?>
      <div class="alert alert-<?= htmlspecialchars($messageType) ?>"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <div class="form-card">
      <form method="POST" action="reservation.php">
        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
        <label for="voiture_id">Voiture</label>
        <select name="voiture_id" id="voiture_id" required>
          <option value="">Sélectionnez une voiture</option>
          <?php foreach ($voitures as $v): ?>
            <option value="<?= (int)$v['id_voiture'] ?>"<?= $voitureId === (int)$v['id_voiture'] ? ' selected' : '' ?>>
              <?= htmlspecialchars($v['marque'] . ' ' . $v['modele']) ?>
            </option>
          <?php endforeach; ?>
        </select>

        <label for="date_essai">Date de l'essai</label>
        <input type="date" id="date_essai" name="date_essai" value="<?= htmlspecialchars($_POST['date_essai'] ?? '') ?>" required min="<?= date('Y-m-d') ?>">

        <label for="heure_debut">Heure de début</label>
        <input type="time" id="heure_debut" name="heure_debut" value="<?= htmlspecialchars($_POST['heure_debut'] ?? '') ?>" required>

        <label for="heure_fin">Heure de fin</label>
        <input type="time" id="heure_fin" name="heure_fin" value="<?= htmlspecialchars($_POST['heure_fin'] ?? '') ?>" required>

        <label for="notes">Notes (optionnel)</label>
        <textarea id="notes" name="notes" rows="2" placeholder="Informations complémentaires…"><?= htmlspecialchars($_POST['notes'] ?? '') ?></textarea>

        <button type="submit" class="btn btn-primary">Réserver l'essai</button>
      </form>
    </div>

    <p><a href="catalogue.php" class="btn-ghost">Retour au catalogue</a></p>
  </main>

  <footer class="site-footer">&copy; 2026 EcoDrive — Showroom de voitures électriques</footer>
</body>
</html>

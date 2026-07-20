<?php
include 'bootstrap.php';

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
    $notes         = trim($_POST['notes'] ?? '');

    if (!$voitureId || !$dateEssai || !$heureDebut) {
        $message = 'Veuillez remplir tous les champs obligatoires.';
        $messageType = 'error';
    }

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

    if (!$message) {
        $today = date('Y-m-d');
        if ($dateEssai < $today) {
            $message = 'La date d\'essai doit être aujourd\'hui ou dans le futur.';
            $messageType = 'error';
        }
    }

    if (!$message) {
        $heureFin = date('H:i', strtotime($heureDebut . ' +1 hour'));
        if ($heureDebut >= $heureFin) {
            $message = 'L\'heure de fin doit être après l\'heure de début.';
            $messageType = 'error';
        }
    }

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

    if (!$message) {
        $stmt = $conn->prepare("INSERT INTO reservation (utilisateur_id, voiture_id, date_essai, heure_debut, heure_fin, notes, statut) VALUES (?,?,?,?,?,?, 'pending')");
        $stmt->bind_param("iissss", $utilisateurId, $voitureId, $dateEssai, $heureDebut, $heureFin, $notes);
        if ($stmt->execute()) {
            $_SESSION['last_reservation_id'] = $conn->insert_id;
            include 'email.php';
            $emailUser = ['nom' => $_SESSION['user']['nom'], 'email' => $_SESSION['user']['email']];
            $emailCar = ['marque' => $car['marque'], 'modele' => $car['modele']];
            emailReservationConfirmation($emailUser, $_POST, $emailCar);
            emailAdminNewReservation('admin@ecodrive.tn', $emailUser, $emailCar, $_POST);
            header('Location: confirmation-reservation.php');
            exit;
        } else {
            $message = 'Erreur lors de l\'enregistrement de la réservation.';
            $messageType = 'error';
        }
        $stmt->close();
    }
    }
}

$voitures = $conn->query("SELECT id_voiture, marque, modele FROM voiture ORDER BY marque, modele")->fetch_all(MYSQLI_ASSOC);
?>
<?php
$page_title = 'Réserver un essai | EcoDrive';
$page_desc = 'Réservez un essai gratuit de voiture électrique en Tunisie. Choisissez votre modèle préféré et planifiez votre rendez-vous.';
$page_url = 'php/reservation.php';
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
      <h1>Réserver un essai</h1>
      <p>Choisissez votre voiture, sélectionnez une date et confirmez votre réservation.</p>
    </div>

    <nav class="client-nav">
      <a href="tableau-de-bord.php">📊 Tableau de bord</a>
      <a href="mes-essais.php">🚗 Mes essais</a>
      <a href="profil.php">👤 Mon profil</a>
    </nav>

    <div class="progress-steps">
      <div class="progress-step active">
        <span class="step-number">1</span>
        <span class="step-label">Voiture & Date</span>
      </div>
      <div class="progress-connector"><div class="connector-fill"></div></div>
      <div class="progress-step">
        <span class="step-number">2</span>
        <span class="step-label">Confirmation</span>
      </div>
    </div>

    <?php if (!empty($message)): ?>
      <div class="alert alert-<?= htmlspecialchars($messageType) ?>"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <div class="client-section">
      <div class="form-card reveal reveal-up">
        <form method="POST" action="reservation.php" data-validate>
          <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">

          <div class="step-panel">
            <label for="voiture_id">Voiture</label>
            <select name="voiture_id" id="voiture_id" required data-msg-required="Veuillez sélectionner une voiture.">
              <option value="">Sélectionnez une voiture</option>
              <?php foreach ($voitures as $v): ?>
                <option value="<?= (int)$v['id_voiture'] ?>"<?= $voitureId === (int)$v['id_voiture'] ? ' selected' : '' ?>>
                  <?= htmlspecialchars($v['marque'] . ' ' . $v['modele']) ?>
                </option>
              <?php endforeach; ?>
            </select>

            <label for="date_essai">Date de l'essai</label>
            <input type="date" id="date_essai" name="date_essai" value="<?= htmlspecialchars($_POST['date_essai'] ?? '') ?>" required min="<?= date('Y-m-d') ?>" data-msg-required="Veuillez choisir une date.">

            <label for="heure_debut">Heure de l'essai (1 heure)</label>
            <input type="time" id="heure_debut" name="heure_debut" value="<?= htmlspecialchars($_POST['heure_debut'] ?? '') ?>" required data-msg-required="Veuillez choisir un horaire.">

            <div class="btn-row">
              <button type="button" class="btn btn-primary step-next">Suivant</button>
            </div>
          </div>

          <div class="step-panel tab-hidden">
            <div class="summary-card" style="margin-bottom:1.5rem">
              <h3 style="margin-bottom:1rem;font-family:var(--font-display)">Récapitulatif</h3>
              <p class="summary-line"><em>Voiture :</em> <span id="summary-car">—</span></p>
              <p class="summary-line"><em>Date :</em> <span id="summary-date">—</span></p>
              <p class="summary-line"><em>Heure :</em> <span id="summary-time">—</span></p>
            </div>

            <label for="notes">Notes (optionnel)</label>
            <textarea id="notes" name="notes" rows="2" placeholder="Informations complémentaires…"><?= htmlspecialchars($_POST['notes'] ?? '') ?></textarea>

            <div class="btn-row-between">
              <button type="button" class="btn btn-ghost step-prev">Précédent</button>
              <button type="submit" class="btn btn-primary">Réserver l'essai</button>
            </div>
          </div>
        </form>
      </div>

      <p style="margin-top:1.5rem"><a href="catalogue.php" class="btn btn-ghost">Retour au catalogue</a></p>
    </div>
  </main>

  <script>
  (function(){
    var steps = document.querySelectorAll('.progress-step');
    var panels = document.querySelectorAll('.step-panel');
    var current = 0;

    function showStep(idx) {
      panels.forEach(function(p,i){ p.style.display = i === idx ? 'block' : 'none'; });
      steps.forEach(function(s,i){
        s.classList.remove('active','done');
        if(i < idx) s.classList.add('done');
        if(i === idx) s.classList.add('active');
      });
      current = idx;
    }

    document.querySelectorAll('.step-next').forEach(function(btn){
      btn.addEventListener('click', function(e){
        e.preventDefault();
        var voiture = document.getElementById('voiture_id');
        var date = document.getElementById('date_essai');
        var hDebut = document.getElementById('heure_debut');
        if (!voiture.value || !date.value || !hDebut.value) {
          alert('Veuillez remplir tous les champs avant de continuer.');
          return;
        }
        var hFin = hDebut.value.split(':');
        hFin = String(parseInt(hFin[0]) + 1).padStart(2,'0') + ':' + hFin[1];
        var carText = voiture.options[voiture.selectedIndex].text;
        document.getElementById('summary-car').textContent = carText;
        document.getElementById('summary-date').textContent = date.value;
        document.getElementById('summary-time').textContent = hDebut.value + ' — ' + hFin;
        if(current < panels.length - 1) showStep(current + 1);
      });
    });

    document.querySelectorAll('.step-prev').forEach(function(btn){
      btn.addEventListener('click', function(e){
        e.preventDefault();
        if(current > 0) showStep(current - 1);
      });
    });

    showStep(0);
  })();
  </script>

<?php include __DIR__ . '/partials/footer.php'; ?>
</body>
</html>

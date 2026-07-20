<?php
include 'bootstrap.php';

// Vérifier que l'utilisateur est connecté et est admin
if (!isset($_SESSION['user']['id'])) {
    header('Location: connexion.php');
    exit;
}

$idUtilisateur = (int) $_SESSION['user']['id'];

$stmt = $conn->prepare("SELECT role FROM utilisateur WHERE id_utilisateur = ?");
$stmt->bind_param("i", $idUtilisateur);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user || $user['role'] !== 'admin') {
    die("Accès refusé. Vous devez être administrateur.");
}

$message = '';
$uploadDir = realpath(__DIR__ . '/../images') ?: __DIR__ . '/../images';
if (substr($uploadDir, -1) !== DIRECTORY_SEPARATOR) $uploadDir .= DIRECTORY_SEPARATOR;

// === Upload d'image sécurisé ===
function handleUpload($file, $uploadDir) {
  // limits
  $maxBytes = 5 * 1024 * 1024; // 5MB
  if ($file['size'] > $maxBytes) return [false, 'Fichier trop volumineux (max 5MB).'];

  // basic image checks
  $info = @getimagesize($file['tmp_name']);
  if ($info === false) return [false, 'Le fichier n\'est pas une image valide.'];

  $mime = $info['mime'] ?? '';
  $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp', 'image/avif' => 'avif'];
  if (!isset($allowed[$mime])) return [false, 'Format d\'image non autorisé.'];

  $ext = $allowed[$mime];
  $name = uniqid('img_') . '.' . $ext;
  $dest = rtrim($uploadDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $name;

  if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
    return [false, 'Impossible de créer le dossier de destination.'];
  }

  if (!move_uploaded_file($file['tmp_name'], $dest)) {
    return [false, 'Erreur lors de l\'upload.'];
  }

  // return web-relative path
  $webPath = 'images/' . $name;
  return [true, $webPath];
}

function safe_unlink($relPath, $imagesDir) {
  // Normalize and ensure deletion happens only inside images directory
  $target = realpath(__DIR__ . '/../' . ltrim($relPath, '/'));
  $imagesBase = realpath($imagesDir);
  if ($target && $imagesBase && strpos($target, $imagesBase) === 0 && is_file($target)) {
    @unlink($target);
    return true;
  }
  return false;
}

// === Gestion des réservations (confirmer / annuler + envoi email) ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if (!csrf_verify($_POST['csrf_token'] ?? '')) {
        $message = "Session invalide.";
    } else {
    $reservationId = (int) ($_POST['reservation_id'] ?? 0);
    $action = $_POST['action'] ?? '';

    if ($reservationId > 0 && in_array($action, ['confirmed', 'cancelled'], true)) {
        $stmt = $conn->prepare("UPDATE reservation SET statut = ? WHERE id_reservation = ?");
        $stmt->bind_param("si", $action, $reservationId);

        if ($stmt->execute()) {
            $message = "✅ Réservation mise à jour.";
            $stmt->close();

            // Récupérer les infos du client pour l'email
            $stmt2 = $conn->prepare("SELECT u.email, u.nom, v.marque, v.modele, r.date_essai 
                                     FROM reservation r
                                     JOIN utilisateur u ON r.utilisateur_id = u.id_utilisateur
                                     JOIN voiture v ON r.voiture_id = v.id_voiture
                                     WHERE r.id_reservation = ?");
            $stmt2->bind_param("i", $reservationId);
            $stmt2->execute();
            $info = $stmt2->get_result()->fetch_assoc();
            $stmt2->close();

            // Envoi de l'email uniquement si on a bien récupéré les infos
            if ($info) {
                $to = $info['email'];
                $subject = "Mise à jour de votre réservation EcoDrive";

                if ($action === 'confirmed') {
                    $messageEmail = "Bonjour {$info['nom']},\n\nVotre réservation pour {$info['marque']} {$info['modele']} le {$info['date_essai']} a été CONFIRMÉE.\n\nMerci de votre confiance.\nEcoDrive Team";
                } else {
                    $messageEmail = "Bonjour {$info['nom']},\n\nVotre réservation pour {$info['marque']} {$info['modele']} le {$info['date_essai']} a été ANNULÉE.\n\nEcoDrive Team";
                }

                $headers = "From: noreply@ecodrive.tn\r\n" .
                           "Reply-To: noreply@ecodrive.tn\r\n" .
                           "X-Mailer: PHP/" . phpversion();

                $logBody = "To: $to\nSubject: $subject\nHeaders: $headers\nBody:\n$messageEmail\n---\n";
                file_put_contents(__DIR__ . '/../private/logs/mail_log.txt', $logBody, FILE_APPEND | LOCK_EX);
            }
        } else {
            $message = "❌ Erreur lors de la mise à jour.";
            $stmt->close();
        }
    }
    } // fin else CSRF
}

// === Gestion du catalogue voitures ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['car_action'])) {
  if (!csrf_verify($_POST['csrf_token'] ?? '')) {
    $message = 'Session invalide.';
  } else {
  $imgPath = $_POST['image'] ?? '';

    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
        [$ok, $result] = handleUpload($_FILES['image_file'], $uploadDir);
        if ($ok) {
            $imgPath = $result;
        } else {
            $message = "⚠️ " . $result;
        }
    }

    if ($_POST['car_action'] === 'add') {
        $annee = (int) ($_POST['annee'] ?? 0);
        $prix = (float) ($_POST['prix'] ?? 0);
        $batteryKwh = $_POST['battery_kwh'] !== '' ? (float) $_POST['battery_kwh'] : null;
        $horsepower = $_POST['horsepower'] !== '' ? (int) $_POST['horsepower'] : null;
        $rangeKm = $_POST['range_km'] !== '' ? (int) $_POST['range_km'] : null;

        $stmt = $conn->prepare("INSERT INTO voiture (marque, modele, annee, prix, battery_kwh, horsepower, range_km, description, image, details_page) VALUES (?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param(
            "ssidiiisss",
            $_POST['marque'],
            $_POST['modele'],
            $annee,
            $prix,
            $batteryKwh,
            $horsepower,
            $rangeKm,
            $_POST['description'],
            $imgPath,
            $_POST['details_page']
        );
        $stmt->execute();
        $stmt->close();
        $message = "✅ Voiture ajoutée.";
    }

    if ($_POST['car_action'] === 'update') {
        $annee = (int) ($_POST['annee'] ?? 0);
        $prix = (float) ($_POST['prix'] ?? 0);
        $idVoiture = (int) ($_POST['id_voiture'] ?? 0);
        $batteryKwh = $_POST['battery_kwh'] !== '' ? (float) $_POST['battery_kwh'] : null;
        $horsepower = $_POST['horsepower'] !== '' ? (int) $_POST['horsepower'] : null;
        $rangeKm = $_POST['range_km'] !== '' ? (int) $_POST['range_km'] : null;

        // Keep existing image if no new upload and no manual override
        if ($imgPath === '' && $_FILES['image_file']['error'] !== UPLOAD_ERR_OK) {
            $imgPath = $_POST['image_existing'] ?? '';
        }

        $stmt = $conn->prepare("UPDATE voiture SET marque=?, modele=?, annee=?, prix=?, battery_kwh=?, horsepower=?, range_km=?, description=?, image=?, details_page=? WHERE id_voiture=?");
        $stmt->bind_param(
            "ssidiiisssi",
            $_POST['marque'],
            $_POST['modele'],
            $annee,
            $prix,
            $batteryKwh,
            $horsepower,
            $rangeKm,
            $_POST['description'],
            $imgPath,
            $_POST['details_page'],
            $idVoiture
        );
        $stmt->execute();
        $stmt->close();
        $message = "✅ Voiture mise à jour.";
    }

    if ($_POST['car_action'] === 'delete') {
        $idVoiture = (int) ($_POST['id_voiture'] ?? 0);

        // Delete associated image file
        $stmt = $conn->prepare("SELECT image FROM voiture WHERE id_voiture=?");
        $stmt->bind_param("i", $idVoiture);
        $stmt->execute();
        $old = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        if ($old && $old['image']) {
          safe_unlink($old['image'], $uploadDir);
        }

        $stmt = $conn->prepare("DELETE FROM voiture WHERE id_voiture=?");
        $stmt->bind_param("i", $idVoiture);
        $stmt->execute();
        $stmt->close();
        $message = "✅ Voiture supprimée.";
    }
  }
}

// === Gestion du catalogue bornes ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['borne_action'])) {
  if (!csrf_verify($_POST['csrf_token'] ?? '')) {
    $message = 'Session invalide.';
  } else {
    $imgPath = $_POST['image'] ?? '';

    if (isset($_FILES['borne_image_file']) && $_FILES['borne_image_file']['error'] === UPLOAD_ERR_OK) {
        [$ok, $result] = handleUpload($_FILES['borne_image_file'], $uploadDir);
        if ($ok) {
            $imgPath = $result;
        } else {
            $message = "⚠️ " . $result;
        }
    }

    if ($_POST['borne_action'] === 'add') {
        $prix = (float) ($_POST['prix'] ?? 0);

        $stmt = $conn->prepare("INSERT INTO borne (nom, modele, puissance, prix, description, image, details_page) VALUES (?,?,?,?,?,?,?)");
        $stmt->bind_param(
            "sssdsss",
            $_POST['nom'],
            $_POST['modele'],
            $_POST['puissance'],
            $prix,
            $_POST['description'],
            $imgPath,
            $_POST['details_page']
        );
        $stmt->execute();
        $stmt->close();
        $message = "✅ Borne ajoutée.";
    }

    if ($_POST['borne_action'] === 'update') {
        $prix = (float) ($_POST['prix'] ?? 0);
        $idBorne = (int) ($_POST['id_borne'] ?? 0);

        if ($imgPath === '' && $_FILES['borne_image_file']['error'] !== UPLOAD_ERR_OK) {
            $imgPath = $_POST['image_existing'] ?? '';
        }

        $stmt = $conn->prepare("UPDATE borne SET nom=?, modele=?, puissance=?, prix=?, description=?, image=?, details_page=? WHERE id_borne=?");
        $stmt->bind_param(
            "sssdsssi",
            $_POST['nom'],
            $_POST['modele'],
            $_POST['puissance'],
            $prix,
            $_POST['description'],
            $imgPath,
            $_POST['details_page'],
            $idBorne
        );
        $stmt->execute();
        $stmt->close();
        $message = "✅ Borne mise à jour.";
    }

    if ($_POST['borne_action'] === 'delete') {
        $idBorne = (int) ($_POST['id_borne'] ?? 0);

        $stmt = $conn->prepare("SELECT image FROM borne WHERE id_borne=?");
        $stmt->bind_param("i", $idBorne);
        $stmt->execute();
        $old = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        if ($old && $old['image']) {
          safe_unlink($old['image'], $uploadDir);
        }

        $stmt = $conn->prepare("DELETE FROM borne WHERE id_borne=?");
        $stmt->bind_param("i", $idBorne);
        $stmt->execute();
        $stmt->close();
        $message = "✅ Borne supprimée.";
    }
  }
}

// Pagination réservations (avec filtres)
$pageRes = max(1, (int)($_GET['page_reservations'] ?? 1));
$limitRes = 10;
$offsetRes = ($pageRes - 1) * $limitRes;

$searchRes = $_GET['search'] ?? '';
$filterStatus = $_GET['filter_status'] ?? '';

$where = [];
$params = [];

if ($searchRes !== '') {
    $where[] = '(u.nom LIKE ? OR u.email LIKE ?)';
    $params[] = '%' . $searchRes . '%';
    $params[] = '%' . $searchRes . '%';
}
if ($filterStatus !== '') {
    $where[] = 'r.statut = ?';
    $params[] = $filterStatus;
}

$whereSQL = $where ? 'WHERE ' . implode(' AND ', $where) : '';

$countStmt = $conn->prepare("SELECT COUNT(*) AS cnt FROM reservation r JOIN utilisateur u ON r.utilisateur_id=u.id_utilisateur $whereSQL");
if ($params) { $countStmt->execute($params); } else { $countStmt->execute(); }
$totalRes = $countStmt->get_result()->fetch_assoc()['cnt'] ?? 0;
$countStmt->close();
$totalPagesRes = max(1, (int)ceil($totalRes / $limitRes));

$resParams = array_merge($params, [$limitRes, $offsetRes]);
$resStmt = $conn->prepare("SELECT r.id_reservation, u.nom AS client, u.email, v.marque, v.modele, r.date_essai, r.heure_debut, r.heure_fin, r.statut, r.notes 
                              FROM reservation r 
                              JOIN utilisateur u ON r.utilisateur_id=u.id_utilisateur 
                              JOIN voiture v ON r.voiture_id=v.id_voiture 
                              $whereSQL
                              ORDER BY r.date_essai ASC 
                              LIMIT ? OFFSET ?");
$resStmt->execute($resParams);
$reservations = $resStmt->get_result()->fetch_all(MYSQLI_ASSOC);
$resStmt->close();

$pendingCount = $conn->query("SELECT COUNT(*) AS cnt FROM reservation WHERE statut='pending'")->fetch_assoc()['cnt'] ?? 0;

// Données pour les graphiques admin
$res_stats = $conn->query("SELECT DATE_FORMAT(date_essai, '%Y-%m') AS mois, COUNT(*) AS total FROM reservation GROUP BY mois ORDER BY mois ASC")->fetch_all(MYSQLI_ASSOC);
$res_monthly_labels = array_column($res_stats, 'mois');
$res_monthly_data   = array_map('intval', array_column($res_stats, 'total'));

$res_voitures = $conn->query("SELECT v.marque, v.modele, COUNT(r.id_reservation) AS total FROM reservation r JOIN voiture v ON r.voiture_id = v.id_voiture GROUP BY v.id_voiture ORDER BY total DESC LIMIT 5")->fetch_all(MYSQLI_ASSOC);
$top_cars_labels = array_map(fn($v) => $v['marque'] . ' ' . $v['modele'], $res_voitures);
$top_cars_data   = array_map(fn($v) => (int)$v['total'], $res_voitures);

// Stats status (pour le pie)
$status_stats = $conn->query("SELECT statut, COUNT(*) AS total FROM reservation GROUP BY statut")->fetch_all(MYSQLI_ASSOC);
$status_labels = ['pending' => 'En attente', 'confirmed' => 'Confirmées', 'cancelled' => 'Annulées'];
$status_colors = ['pending' => '#f59e0b', 'confirmed' => '#22c55e', 'cancelled' => '#ef4444'];
$pie_labels = [];
$pie_data   = [];
$pie_colors = [];
foreach ($status_stats as $s) {
    $pie_labels[] = $status_labels[$s['statut']] ?? $s['statut'];
    $pie_data[]   = (int)$s['total'];
    $pie_colors[] = $status_colors[$s['statut']] ?? '#888';
}

$res_clients = $conn->query("SELECT u.nom, u.email, COUNT(r.id_reservation) AS total FROM reservation r JOIN utilisateur u ON r.utilisateur_id = u.id_utilisateur GROUP BY u.id_utilisateur ORDER BY total DESC LIMIT 5")->fetch_all(MYSQLI_ASSOC);

$voitures = $conn->query("SELECT * FROM voiture ORDER BY created_at DESC")->fetch_all(MYSQLI_ASSOC);
$bornes = $conn->query("SELECT * FROM borne ORDER BY created_at DESC")->fetch_all(MYSQLI_ASSOC);
// Token CSRF pour les formulaires
$token = csrf_token();

// === Gestion des rôles utilisateurs ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_role'])) {
    if (!csrf_verify($_POST['csrf_token'] ?? '')) {
        $message = "Session invalide.";
    } else {
        $userId = (int) ($_POST['user_id'] ?? 0);
        if ($userId > 0) {
            $stmt = $conn->prepare("SELECT role FROM utilisateur WHERE id_utilisateur = ?");
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $current = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            if ($current) {
                $newRole = $current['role'] === 'admin' ? 'client' : 'admin';
                $stmt = $conn->prepare("UPDATE utilisateur SET role = ? WHERE id_utilisateur = ?");
                $stmt->bind_param("si", $newRole, $userId);
                $stmt->execute();
                $stmt->close();
                $message = "✅ Rôle mis à jour.";
            }
        }
    }
}

$users = $conn->query("SELECT u.*, COUNT(r.id_reservation) AS reservation_count FROM utilisateur u LEFT JOIN reservation r ON u.id_utilisateur = r.utilisateur_id GROUP BY u.id_utilisateur ORDER BY u.nom")->fetch_all(MYSQLI_ASSOC);

$totalVoitures = $conn->query("SELECT COUNT(*) AS cnt FROM voiture")->fetch_assoc()['cnt'] ?? 0;
$totalBornes = $conn->query("SELECT COUNT(*) AS cnt FROM borne")->fetch_assoc()['cnt'] ?? 0;
$totalReservations = $conn->query("SELECT COUNT(*) AS cnt FROM reservation")->fetch_assoc()['cnt'] ?? 0;
$totalUsers = $conn->query("SELECT COUNT(*) AS cnt FROM utilisateur")->fetch_assoc()['cnt'] ?? 0;
?>
<?php
$page_title = 'Administration | EcoDrive';
$page_desc = 'Panneau d\'administration EcoDrive — gérez les voitures, les utilisateurs et les réservations.';
$page_url = 'php/admin.php';
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
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
</head>
<body>
<?php $asset_base = '../'; include __DIR__ . '/partials/header.php'; ?>

  <main class="main-wrap page-fade-in">

    <div class="admin-header">
      <h1>Tableau de bord Admin<?php if ($pendingCount > 0): ?> <span class="badge-pending"><?= (int)$pendingCount ?> en attente</span><?php endif; ?></h1>
      <div class="export-bar">
        <a href="export.php?type=backup" class="btn btn-sm btn-ghost">Backup SQL</a>
        <a href="export.php?type=reservations" class="btn btn-sm btn-ghost">Export réservations</a>
        <a href="export.php?type=voitures" class="btn btn-sm btn-ghost">Export voitures</a>
        <a href="export.php?type=bornes" class="btn btn-sm btn-ghost">Export bornes</a>
      </div>
    </div>

  <?php if (!empty($message)): ?>
    <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
  <?php endif; ?>

  <div class="admin-stats">
    <div class="admin-stat">
      <div class="admin-stat-icon blue">🚗</div>
      <div class="admin-stat-text">
        <div class="admin-stat-value"><?= (int)$totalVoitures ?></div>
        <div class="admin-stat-label">Voitures</div>
      </div>
    </div>
    <div class="admin-stat">
      <div class="admin-stat-icon accent">🔌</div>
      <div class="admin-stat-text">
        <div class="admin-stat-value"><?= (int)$totalBornes ?></div>
        <div class="admin-stat-label">Bornes</div>
      </div>
    </div>
    <div class="admin-stat">
      <div class="admin-stat-icon green">📋</div>
      <div class="admin-stat-text">
        <div class="admin-stat-value"><?= (int)$totalReservations ?></div>
        <div class="admin-stat-label">Réservations</div>
      </div>
    </div>
    <div class="admin-stat">
      <div class="admin-stat-icon danger">👥</div>
      <div class="admin-stat-text">
        <div class="admin-stat-value"><?= (int)$totalUsers ?></div>
        <div class="admin-stat-label">Utilisateurs</div>
      </div>
    </div>
  </div>

  <nav class="admin-tabs">
    <button class="admin-tab-btn active" data-tab="reservations">📋 Réservations<?php if ($pendingCount > 0): ?><span class="tab-count"><?= (int)$pendingCount ?></span><?php endif; ?></button>
    <button class="admin-tab-btn" data-tab="stats">📊 Statistiques</button>
    <button class="admin-tab-btn" data-tab="voitures">🚗 Voitures <span class="tab-count"><?= (int)$totalVoitures ?></span></button>
    <button class="admin-tab-btn" data-tab="bornes">🔌 Bornes <span class="tab-count"><?= (int)$totalBornes ?></span></button>
    <button class="admin-tab-btn" data-tab="users">👥 Utilisateurs <span class="tab-count"><?= (int)$totalUsers ?></span></button>
  </nav>

  <div id="tab-reservations" class="admin-tab-section active">
  <h2 class="admin-section-title"><span>📋</span> Gestion des réservations</h2>

  <div class="filter-bar">
    <form method="get" class="form-actions">
      <input type="hidden" name="tab" value="reservations">
      <input type="text" name="search" placeholder="Rechercher un client..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" class="filter-input">
      <select name="filter_status" class="filter-input">
        <option value="">Tous les statuts</option>
        <option value="pending" <?= ($_GET['filter_status'] ?? '') === 'pending' ? 'selected' : '' ?>>En attente</option>
        <option value="confirmed" <?= ($_GET['filter_status'] ?? '') === 'confirmed' ? 'selected' : '' ?>>Confirmée</option>
        <option value="cancelled" <?= ($_GET['filter_status'] ?? '') === 'cancelled' ? 'selected' : '' ?>>Annulée</option>
      </select>
      <button type="submit" class="btn-primary btn-sm">Filtrer</button>
    </form>
  </div>
  <div class="table-wrap">
  <table>
    <tr><th>ID</th><th>Client</th><th>Email</th><th>Voiture</th><th>Date</th><th>Début</th><th>Fin</th><th>Notes</th><th>Statut</th><th>Actions</th></tr>
    <?php foreach ($reservations as $r): ?>
    <tr>
      <td data-label="ID"><?= (int)$r['id_reservation'] ?></td>
      <td data-label="Client"><?= htmlspecialchars($r['client']) ?></td>
      <td data-label="Email"><?= htmlspecialchars($r['email']) ?></td>
      <td data-label="Voiture"><?= htmlspecialchars($r['marque'] . ' ' . $r['modele']) ?></td>
      <td data-label="Date"><?= htmlspecialchars($r['date_essai']) ?></td>
      <td data-label="Début"><?= htmlspecialchars($r['heure_debut']) ?></td>
      <td data-label="Fin"><?= htmlspecialchars($r['heure_fin']) ?></td>
      <td data-label="Notes"><?= htmlspecialchars($r['notes'] ?? '') ?: '—' ?></td>
      <td data-label="Statut"><span class="statut-<?= htmlspecialchars($r['statut']) ?>"><?= htmlspecialchars($r['statut']) ?></span></td>
      <td data-label="Actions">
        <form method="POST" class="form-inline">
          <?php $token = csrf_token(); ?>
          <input type="hidden" name="csrf_token" value="<?= $token ?>">
          <input type="hidden" name="reservation_id" value="<?= (int) $r['id_reservation'] ?>">
          <input type="hidden" name="action" value="confirmed">
          <button type="submit" class="btn btn-sm btn-primary" onclick="return confirm('Êtes-vous sûr de vouloir confirmer cette réservation ?')">Confirmer</button>
        </form>
        <form method="POST" class="form-inline">
          <input type="hidden" name="csrf_token" value="<?= $token ?>">
          <input type="hidden" name="reservation_id" value="<?= (int) $r['id_reservation'] ?>">
          <input type="hidden" name="action" value="cancelled">
          <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')">Annuler</button>
        </form>
      </td>
    </tr>
    <?php endforeach; ?>
  </table>
  </div>

  <?php if ($totalPagesRes > 1): ?>
  <div class="pagination mb-lg">
    <?php for ($i = 1; $i <= $totalPagesRes; $i++): ?>
      <a href="?page_reservations=<?= $i ?>&amp;tab=reservations&amp;search=<?= urlencode($searchRes) ?>&amp;filter_status=<?= urlencode($filterStatus) ?>" class="pagination-link <?= $i === $pageRes ? 'active' : '' ?>"><?= $i ?></a>
    <?php endfor; ?>
  </div>
  <?php endif; ?>
  </div>

  <div id="tab-stats" class="admin-tab-section">
  <h2 class="admin-section-title"><span>📊</span> Statistiques</h2>

  <div class="chart-row">
    <div class="chart-card">
      <h3>Réservations par mois</h3>
      <canvas id="chartMonthly" width="350" height="180"></canvas>
    </div>
    <div class="chart-card">
      <h3>Répartition par statut</h3>
      <canvas id="chartStatus" width="200" height="180"></canvas>
    </div>
  </div>

  <div class="chart-row">
    <div class="chart-card">
      <h3>Voitures les plus demandées</h3>
      <canvas id="chartTopCars" width="350" height="180"></canvas>
    </div>
    <div class="chart-card">
      <h3>Clients les plus actifs</h3>
      <div class="table-wrap">
      <table>
        <tr><th>Nom</th><th>Email</th><th>Réservations</th></tr>
        <?php foreach ($res_clients as $c): ?>
          <tr><td><?= htmlspecialchars($c['nom']) ?></td><td><?= htmlspecialchars($c['email']) ?></td><td><?= (int)$c['total'] ?></td></tr>
        <?php endforeach; ?>
      </table>
      </div>
    </div>
  </div>

  <script>
  new Chart(document.getElementById('chartMonthly'), {
    type: 'bar',
    data: {
      labels: <?= json_encode($res_monthly_labels) ?>,
      datasets: [{ label: 'Réservations', data: <?= json_encode($res_monthly_data) ?>, backgroundColor: 'rgba(60,154,190,0.6)', borderColor: '#3C9ABE', borderWidth: 1, borderRadius: 4 }]
    },
    options: { responsive: true, maintainAspectRatio: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
  });
  new Chart(document.getElementById('chartStatus'), {
    type: 'doughnut',
    data: {
      labels: <?= json_encode($pie_labels) ?>,
      datasets: [{ data: <?= json_encode($pie_data) ?>, backgroundColor: <?= json_encode($pie_colors) ?>, borderWidth: 0 }]
    },
    options: { responsive: true, maintainAspectRatio: true, plugins: { legend: { position: 'bottom', labels: { font: { size: 11 } } } } }
  });
  new Chart(document.getElementById('chartTopCars'), {
    type: 'bar',
    data: {
      labels: <?= json_encode($top_cars_labels) ?>,
      datasets: [{ label: 'Réservations', data: <?= json_encode($top_cars_data) ?>, backgroundColor: 'rgba(60,154,190,0.6)', borderColor: '#3C9ABE', borderWidth: 1, borderRadius: 4 }]
    },
    options: { indexAxis: 'y', responsive: true, maintainAspectRatio: true, plugins: { legend: { display: false } }, scales: { x: { beginAtZero: true, ticks: { stepSize: 1 } } } }
  });
  </script>
  </div>

  <div id="tab-voitures" class="admin-tab-section">
  <h2 class="admin-section-title"><span>🚗</span> Gestion des voitures</h2>
  <div class="admin-layout">
    <div class="admin-section">
      <h3>Ajouter une voiture</h3>
      <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="car_action" value="add">
        <input type="hidden" name="csrf_token" value="<?= $token ?>">
        <input type="text" name="marque" placeholder="Marque" required>
        <input type="text" name="modele" placeholder="Modèle" required>
        <input type="number" name="annee" placeholder="Année" required>
        <input type="number" step="0.01" name="prix" placeholder="Prix (DT)" required>
        <input type="number" step="0.1" name="battery_kwh" placeholder="Batterie (kWh)">
        <input type="number" name="horsepower" placeholder="Puissance (ch)">
        <input type="number" name="range_km" placeholder="Autonomie (km)">
        <textarea name="description" placeholder="Description" rows="2"></textarea>
        <input type="file" name="image_file" accept="image/jpeg,image/png,image/webp,image/avif">
        <input type="text" name="image" placeholder="Ou chemin direct (ex: images/marque/voiture.jpg)">
        <input type="text" name="details_page" placeholder="Page détails (ex: voitures/Modele.php)">
        <button type="submit" class="btn btn-primary">Ajouter</button>
      </form>
    </div>
    <div class="admin-section">
      <h3>Voitures existantes</h3>
      <div class="table-wrap">
      <table>
        <tr><th>ID</th><th>Marque</th><th>Modèle</th><th>Prix</th><th>Actions</th></tr>
        <?php foreach ($voitures as $v): ?>
        <tr>
          <td data-label="ID"><?= (int)$v['id_voiture'] ?></td>
          <td data-label="Marque"><?= htmlspecialchars($v['marque']) ?></td>
          <td data-label="Modèle"><?= htmlspecialchars($v['modele']) ?></td>
          <td data-label="Prix"><?= number_format((float)$v['prix'], 0, ',', ' ') ?> DT</td>
          <td data-label="Actions">
            <details class="edit-inline">
              <summary class="btn-edit">✏️ Modifier</summary>
              <form method="POST" class="edit-form" enctype="multipart/form-data">
                <input type="hidden" name="car_action" value="update">
                <input type="hidden" name="csrf_token" value="<?= $token ?>">
                <input type="hidden" name="id_voiture" value="<?= (int)$v['id_voiture'] ?>">
                <input type="hidden" name="image_existing" value="<?= htmlspecialchars($v['image'] ?? '') ?>">
                <?php if ($v['image'] && file_exists('../' . $v['image'])): ?>
                  <div class="preview-wrap"><img src="../<?= htmlspecialchars($v['image']) ?>" alt="Aperçu <?= htmlspecialchars($v['marque'].' '.$v['modele']) ?>" class="img-preview"></div>
                <?php endif; ?>
                <input type="text" name="marque" value="<?= htmlspecialchars($v['marque']) ?>" required>
                <input type="text" name="modele" value="<?= htmlspecialchars($v['modele']) ?>" required>
                <input type="number" name="annee" value="<?= (int)$v['annee'] ?>" required>
                <input type="number" step="0.01" name="prix" value="<?= (float)$v['prix'] ?>" required>
                <input type="number" step="0.1" name="battery_kwh" value="<?= htmlspecialchars($v['battery_kwh'] ?? '') ?>" placeholder="Batterie (kWh)">
                <input type="number" name="horsepower" value="<?= htmlspecialchars($v['horsepower'] ?? '') ?>" placeholder="Puissance (ch)">
                <input type="number" name="range_km" value="<?= htmlspecialchars($v['range_km'] ?? '') ?>" placeholder="Autonomie (km)">
                <textarea name="description" rows="2"><?= htmlspecialchars($v['description'] ?? '') ?></textarea>
                <input type="file" name="image_file" accept="image/jpeg,image/png,image/webp,image/avif">
                <input type="text" name="image" value="<?= htmlspecialchars($v['image'] ?? '') ?>" placeholder="Ou chemin direct">
                <input type="text" name="details_page" value="<?= htmlspecialchars($v['details_page'] ?? '') ?>">
                <button type="submit" class="btn btn-primary">💾 Enregistrer</button>
              </form>
            </details>
            <form method="POST" class="form-inline">
              <input type="hidden" name="car_action" value="delete">
              <input type="hidden" name="csrf_token" value="<?= $token ?>">
              <input type="hidden" name="id_voiture" value="<?= (int)$v['id_voiture'] ?>">
              <button type="submit" class="btn-delete" onclick="return confirm('Supprimer <?= htmlspecialchars($v['marque'].' '.$v['modele']) ?> ?')">🗑 Supprimer</button>
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
      </table>
      </div>
    </div>
  </div>
  </div>

  <div id="tab-bornes" class="admin-tab-section">
  <h2 class="admin-section-title"><span>🔌</span> Gestion des bornes</h2>
  <div class="admin-layout">
    <div class="admin-section">
      <h3>Ajouter une borne</h3>
      <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="borne_action" value="add">
        <input type="hidden" name="csrf_token" value="<?= $token ?>">
        <input type="text" name="nom" placeholder="Nom" required>
        <input type="text" name="modele" placeholder="Modèle" required>
        <input type="text" name="puissance" placeholder="Puissance (ex: 7 kW)" required>
        <input type="number" step="0.01" name="prix" placeholder="Prix (DT)" required>
        <textarea name="description" placeholder="Description" rows="2"></textarea>
        <input type="file" name="borne_image_file" accept="image/jpeg,image/png,image/webp,image/avif">
        <input type="text" name="image" placeholder="Ou chemin direct (ex: images/bornes/borne.png)">
        <input type="text" name="details_page" placeholder="Page détails (ex: bornes/Modèle.php)">
        <button type="submit" class="btn btn-primary">Ajouter</button>
      </form>
    </div>
    <div class="admin-section">
      <h3>Bornes existantes</h3>
      <div class="table-wrap">
      <table>
        <tr><th>ID</th><th>Nom</th><th>Modèle</th><th>Puissance</th><th>Prix</th><th>Actions</th></tr>
        <?php foreach ($bornes as $b): ?>
        <tr>
          <td data-label="ID"><?= (int)$b['id_borne'] ?></td>
          <td data-label="Nom"><?= htmlspecialchars($b['nom']) ?></td>
          <td data-label="Modèle"><?= htmlspecialchars($b['modele']) ?></td>
          <td data-label="Puissance"><?= htmlspecialchars($b['puissance']) ?></td>
          <td data-label="Prix"><?= number_format((float)$b['prix'], 0, ',', ' ') ?> DT</td>
          <td data-label="Actions">
            <details class="edit-inline">
              <summary class="btn-edit">✏️ Modifier</summary>
              <form method="POST" class="edit-form" enctype="multipart/form-data">
                <input type="hidden" name="borne_action" value="update">
                <input type="hidden" name="csrf_token" value="<?= $token ?>">
                <input type="hidden" name="id_borne" value="<?= (int)$b['id_borne'] ?>">
                <input type="hidden" name="image_existing" value="<?= htmlspecialchars($b['image'] ?? '') ?>">
                <?php if ($b['image'] && file_exists('../' . $b['image'])): ?>
                  <div class="preview-wrap"><img src="../<?= htmlspecialchars($b['image']) ?>" alt="Aperçu <?= htmlspecialchars($b['nom'].' '.$b['modele']) ?>" class="img-preview"></div>
                <?php endif; ?>
                <input type="text" name="nom" value="<?= htmlspecialchars($b['nom']) ?>" required>
                <input type="text" name="modele" value="<?= htmlspecialchars($b['modele']) ?>" required>
                <input type="text" name="puissance" value="<?= htmlspecialchars($b['puissance']) ?>" required>
                <input type="number" step="0.01" name="prix" value="<?= (float)$b['prix'] ?>" required>
                <textarea name="description" rows="2"><?= htmlspecialchars($b['description'] ?? '') ?></textarea>
                <input type="file" name="borne_image_file" accept="image/jpeg,image/png,image/webp,image/avif">
                <input type="text" name="image" value="<?= htmlspecialchars($b['image'] ?? '') ?>" placeholder="Ou chemin direct">
                <input type="text" name="details_page" value="<?= htmlspecialchars($b['details_page'] ?? '') ?>">
                <button type="submit" class="btn btn-primary">💾 Enregistrer</button>
              </form>
            </details>
            <form method="POST" class="form-inline">
              <input type="hidden" name="borne_action" value="delete">
              <input type="hidden" name="csrf_token" value="<?= $token ?>">
              <input type="hidden" name="id_borne" value="<?= (int)$b['id_borne'] ?>">
              <button type="submit" class="btn-delete" onclick="return confirm('Supprimer <?= htmlspecialchars($b['nom'].' '.$b['modele']) ?> ?')">🗑 Supprimer</button>
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
      </table>
      </div>
    </div>
  </div>
  </div>

  <div id="tab-users" class="admin-tab-section">
  <h2 class="admin-section-title"><span>👥</span> Gestion des utilisateurs</h2>
  <div class="table-wrap">
  <table>
    <tr><th>Nom</th><th>Email</th><th>Rôle</th><th>Réservations</th><th>Actions</th></tr>
    <?php foreach ($users as $u): ?>
    <tr>
      <td data-label="Nom"><?= htmlspecialchars($u['nom']) ?></td>
      <td data-label="Email"><?= htmlspecialchars($u['email']) ?></td>
      <td data-label="Rôle"><span class="statut-<?= htmlspecialchars($u['role']) ?>"><?= htmlspecialchars($u['role']) ?></span></td>
      <td data-label="Réservations"><?= (int)$u['reservation_count'] ?></td>
      <td data-label="Actions">
        <form method="POST" class="form-inline">
          <input type="hidden" name="csrf_token" value="<?= $token ?>">
          <input type="hidden" name="user_id" value="<?= (int)$u['id_utilisateur'] ?>">
          <input type="hidden" name="toggle_role" value="1">
          <button type="submit" class="btn btn-sm btn-primary" onclick="return confirm('Changer le rôle de <?= htmlspecialchars($u['nom']) ?> ?')">
            <?= $u['role'] === 'admin' ? '→ Client' : '→ Admin' ?>
          </button>
        </form>
      </td>
    </tr>
    <?php endforeach; ?>
  </table>
  </div>
  </div>

  </main>

  <script>
  document.querySelectorAll('.admin-tab-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.admin-tab-btn').forEach(b => b.classList.remove('active'));
      document.querySelectorAll('.admin-tab-section').forEach(t => { t.classList.remove('active'); t.style.display = 'none'; });
      btn.classList.add('active');
      const tab = document.getElementById('tab-' + btn.dataset.tab);
      tab.style.display = '';
      tab.classList.add('active');
    });
  });
  const params = new URLSearchParams(window.location.search);
  const tabParam = params.get('tab');
  if (tabParam) {
    const btn = document.querySelector('.admin-tab-btn[data-tab="' + tabParam + '"]');
    if (btn) btn.click();
  }
  </script>

<?php include __DIR__ . '/partials/footer.php'; ?>

<?php
session_start();
include 'bootstrap.php';

if (!isset($_SESSION['user']['id'])) {
    header('Location: connexion.php');
    exit;
}

$userId = $_SESSION['user']['id'];
$message = '';
$messageType = '';

// Mise à jour du profil
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    if (!csrf_verify($_POST['csrf_token'] ?? '')) {
        $message = 'Session invalide.';
        $messageType = 'error';
    } else {
        $nom = trim($_POST['nom'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($nom === '' || $email === '') {
            $message = 'Le nom et l\'email sont obligatoires.';
            $messageType = 'error';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = 'Email invalide.';
            $messageType = 'error';
        } else {
            $stmt = $conn->prepare("SELECT id_utilisateur FROM utilisateur WHERE email = ? AND id_utilisateur != ? LIMIT 1");
            $stmt->bind_param("si", $email, $userId);
            $stmt->execute();
            if ($stmt->get_result()->num_rows > 0) {
                $message = 'Cet email est déjà utilisé par un autre compte.';
                $messageType = 'error';
            } else {
                if ($password !== '') {
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("UPDATE utilisateur SET nom = ?, email = ?, mot_de_passe = ? WHERE id_utilisateur = ?");
                    $stmt->bind_param("sssi", $nom, $email, $hash, $userId);
                } else {
                    $stmt = $conn->prepare("UPDATE utilisateur SET nom = ?, email = ? WHERE id_utilisateur = ?");
                    $stmt->bind_param("ssi", $nom, $email, $userId);
                }
                $stmt->execute();
                $stmt->close();

                $names = preg_split('/\s+/', $nom, 2, PREG_SPLIT_NO_EMPTY);
                $_SESSION['user']['prenom'] = $names[0] ?? 'Utilisateur';
                $_SESSION['user']['nom'] = $names[1] ?? '';
                $_SESSION['user']['email'] = $email;

                $message = 'Profil mis à jour avec succès.';
                $messageType = 'success';
            }
        }
    }
}

$stmt = $conn->prepare("SELECT nom, email FROM utilisateur WHERE id_utilisateur = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Mon profil — EcoDrive</title>
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E%26%23x26A1%3B%3C/text%3E%3C/svg%3E">
  <link rel="stylesheet" href="../css/dashboard.css">
  <link rel="stylesheet" href="../css/header.css">
</head>
<body>
  <?php $asset_base = '../'; include __DIR__ . '/partials/header.php'; ?>

  <main class="main-wrap">
    <h1>Mon profil</h1>

    <?php if ($message): ?>
      <div class="alert alert-<?= $messageType === 'success' ? 'success' : 'error' ?>"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <div class="form-card" style="max-width:500px">
      <form method="POST" action="profil.php">
        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
        <input type="hidden" name="update_profile" value="1">

        <label for="nom">Nom complet</label>
        <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($user['nom']) ?>" required>

        <label for="email">Adresse e-mail</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

        <label for="password">Nouveau mot de passe <em style="font-size:0.75rem;color:var(--gray)">(laisser vide pour conserver)</em></label>
        <input type="password" id="password" name="password" placeholder="••••••••" autocomplete="new-password">

        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
      </form>
    </div>

    <p style="margin-top:1rem"><a href="tableau-de-bord.php" class="btn-ghost">← Retour au tableau de bord</a></p>
  </main>

  <footer class="site-footer">&copy; 2026 EcoDrive — Showroom de voitures électriques</footer>
<button class="back-to-top" aria-label="Retour en haut">&uarr;</button>
<?php $asset_base = '../'; include __DIR__ . '/partials/footer.php'; ?>

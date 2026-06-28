<?php
session_start();
include 'configuration.php';

$loggedIn = isset($_SESSION['user']);
if ($loggedIn) {
    header('Location: ../index.php');
    exit;
}

$message = '';
$messageType = '';
$validToken = false;

$token = $_GET['token'] ?? '';
if ($token) {
    $stmt = $conn->prepare("SELECT id_utilisateur FROM utilisateur WHERE reset_token = ? AND reset_expires > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    $validToken = (bool)$user;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';

    $stmt = $conn->prepare("SELECT id_utilisateur FROM utilisateur WHERE reset_token = ? AND reset_expires > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$user) {
        $message = 'Lien invalide ou expiré.';
        $messageType = 'error';
    } elseif (strlen($password) < 6) {
        $message = 'Le mot de passe doit faire au moins 6 caractères.';
        $messageType = 'error';
    } elseif ($password !== $confirm) {
        $message = 'Les mots de passe ne correspondent pas.';
        $messageType = 'error';
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE utilisateur SET mot_de_passe = ?, reset_token = NULL, reset_expires = NULL WHERE id_utilisateur = ?");
        $stmt->bind_param("si", $hash, $user['id_utilisateur']);
        $stmt->execute();
        $stmt->close();
        $message = 'Mot de passe réinitialisé. Vous pouvez maintenant vous connecter.';
        $messageType = 'success';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Réinitialisation mot de passe — EcoDrive</title>
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E%26%23x26A1%3B%3C/text%3E%3C/svg%3E" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="../css/header.css" />
</head>
<body>
  <header class="site-header">
    <a href="../index.php" class="logo-text">eco<span>drive</span></a>
    <nav>
      <a href="../index.php">Accueil</a>
      <a href="../php/catalogue.php">Catalogue</a>
      <a href="../pages/contact.php">Contact</a>
      <a href="connexion.php">Connexion</a>
      <button class="burger" aria-label="Menu" onclick="this.classList.toggle('open');document.querySelector('.site-header nav').classList.toggle('open')"><span></span><span></span><span></span></button>
    </nav>
  </header>

<div class="login-page">
  <div class="login-visual">
    <div class="login-visual-grid"></div>
    <div class="login-visual-glow"></div>
    <div class="login-visual-content">
      <a href="../index.php" class="login-visual-logo">eco<span>drive</span></a>
      <div class="login-visual-quote">
        Nouveau mot de passe,
        <strong>nouveau départ.</strong>
      </div>
      <div class="login-visual-sub">Choisissez un mot de passe sécurisé</div>
    </div>
  </div>

  <div class="login-form-col">
    <div class="login-form-wrap">
      <?php if ($messageType === 'success'): ?>
        <div class="login-error" style="background:#e6f2de;color:#2a6e1a"><?= htmlspecialchars($message) ?></div>
        <div class="login-footer-links"><span><a href="connexion.php">→ Se connecter</a></span></div>
      <?php elseif ($message): ?>
        <div class="login-error" style="background:#fef2f2;color:#991b1b"><?= htmlspecialchars($message) ?></div>
      <?php endif; ?>

      <?php if ($validToken && $messageType !== 'success'): ?>
        <div class="login-eyebrow">Nouveau mot de passe</div>
        <h2>Choisissez un<br>mot de passe.</h2>

        <form method="post" action="reinitialiser-mot-de-passe.php">
          <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
          <div>
            <label class="field-label" for="password">Nouveau mot de passe</label>
            <input type="password" id="password" name="password" placeholder="••••••••" autocomplete="new-password" required />
          </div>
          <div>
            <label class="field-label" for="confirm">Confirmer le mot de passe</label>
            <input type="password" id="confirm" name="confirm" placeholder="••••••••" autocomplete="new-password" required />
          </div>
          <button type="submit" class="btn-primary">Réinitialiser →</button>
        </form>
      <?php elseif (!$validToken && $messageType !== 'success'): ?>
        <div class="login-eyebrow">Lien invalide</div>
        <h2>Lien expiré<br>ou invalide.</h2>
        <p class="login-sub">Veuillez refaire une demande de réinitialisation.</p>
        <div class="login-footer-links"><span><a href="mot-de-passe-oublie.php">← Demander un nouveau lien</a></span></div>
      <?php endif; ?>
    </div>
  </div>
</div>

<button class="back-to-top" aria-label="Retour en haut">&uarr;</button>
<script src="../js/app.js"></script>
</body>
</html>

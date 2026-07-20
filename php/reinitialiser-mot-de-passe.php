<?php
include 'bootstrap.php';

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
    if (!csrf_verify($_POST['csrf_token'] ?? '')) { die('Session invalide.'); }
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
    } elseif (strlen($password) < 8) {
        $message = 'Le mot de passe doit faire au moins 8 caractères.';
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
<?php
$page_title = 'Réinitialisation du mot de passe | EcoDrive';
$page_desc = 'Définissez un nouveau mot de passe pour votre compte EcoDrive.';
$page_url = 'php/reinitialiser-mot-de-passe.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') ?></title>
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E%26%23x26A1%3B%3C/text%3E%3C/svg%3E" />
  <?php include __DIR__ . '/partials/meta.php'; ?>
  <link rel="stylesheet" href="../css/style.css?v=16">
</head>
<body>
<?php $asset_base = '../'; include __DIR__ . '/partials/header.php'; ?>

<div class="login-page hero-entrance">
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
        <div class="login-error" style="background:rgba(var(--green-rgb),0.1);color:var(--green)"><?= htmlspecialchars($message) ?></div>
        <div class="login-footer-links"><span><a href="connexion.php">→ Se connecter</a></span></div>
      <?php elseif ($message): ?>
        <div class="login-error" style="background:rgba(var(--danger-rgb),0.1);color:var(--danger)"><?= htmlspecialchars($message) ?></div>
      <?php endif; ?>

      <?php if ($validToken && $messageType !== 'success'): ?>
        <div class="login-eyebrow">Nouveau mot de passe</div>
        <h2>Choisissez un<br>mot de passe.</h2>

        <form method="post" action="reinitialiser-mot-de-passe.php" data-validate>
          <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
          <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
          <div>
            <label class="field-label" for="password">Nouveau mot de passe</label>
            <div class="pwd-wrap">
              <input type="password" id="password" name="password" placeholder="••••••••" autocomplete="new-password" required data-msg-required="Veuillez choisir un mot de passe." data-minlength="8" data-msg-minlength="Minimum 8 caractères." />
              <button type="button" class="pwd-toggle" aria-label="Afficher le mot de passe">👁</button>
            </div>
          </div>
          <div>
            <label class="field-label" for="confirm">Confirmer le mot de passe</label>
            <div class="pwd-wrap">
              <input type="password" id="confirm" name="confirm" placeholder="••••••••" autocomplete="new-password" required data-msg-required="Veuillez confirmer le mot de passe." data-match="password" data-msg-match="Les mots de passe ne correspondent pas." />
              <button type="button" class="pwd-toggle" aria-label="Afficher le mot de passe">👁</button>
            </div>
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

<?php include __DIR__ . '/partials/footer.php'; ?>

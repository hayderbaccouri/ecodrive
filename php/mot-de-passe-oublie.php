<?php
include 'bootstrap.php';

$loggedIn = isset($_SESSION['user']);
if ($loggedIn) {
    header('Location: ../index.php');
    exit;
}

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Adresse e-mail invalide.';
        $messageType = 'error';
    } else {
        $stmt = $conn->prepare("SELECT id_utilisateur FROM utilisateur WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if ($user) {
            $token = bin2hex(random_bytes(32));
            $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

            $stmt = $conn->prepare("UPDATE utilisateur SET reset_token = ?, reset_expires = ? WHERE id_utilisateur = ?");
            $stmt->bind_param("ssi", $token, $expires, $user['id_utilisateur']);
            $stmt->execute();
            $stmt->close();

            $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
            $resetLink = "$scheme://{$_SERVER['HTTP_HOST']}/php/reinitialiser-mot-de-passe.php?token=$token";
            $subject = "Réinitialisation mot de passe - EcoDrive";
            $body = "Bonjour,\n\nCliquez sur ce lien pour réinitialiser votre mot de passe :\n$resetLink\n\nCe lien expire dans 1 heure.\n\nEcoDrive Team";
            $headers = "From: contact@ecodrive.tn\r\nReply-To: contact@ecodrive.tn\r\nX-Mailer: PHP/" . phpversion();
            $log  = "[" . date('Y-m-d H:i:s') . "] Password reset requested for: $email\n";
            file_put_contents(__DIR__ . '/../mail_log.txt', $log, FILE_APPEND | LOCK_EX);
        }

        $message = 'Si un compte existe avec cet email, vous recevrez un lien de réinitialisation.';
        $messageType = 'success';
    }
}
?>
<?php
$page_title = 'Mot de passe oublié | EcoDrive';
$page_desc = 'Réinitialisez votre mot de passe EcoDrive. Entrez votre email pour recevoir un lien de réinitialisation.';
$page_url = 'php/mot-de-passe-oublie.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') ?></title>
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E%26%23x26A1%3B%3C/text%3E%3C/svg%3E" />
  <?php include __DIR__ . '/partials/meta.php'; ?>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../css/theme.css" />
  <link rel="stylesheet" href="../css/header.css" />
  <link rel="stylesheet" href="../css/animations.css" />
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
        Un problème de mot de passe ?
        <strong>On s'en occupe.</strong>
      </div>
      <div class="login-visual-sub">Réinitialisation sécurisée</div>
    </div>
  </div>

  <div class="login-form-col">
    <div class="login-form-wrap">
      <div class="login-eyebrow">Mot de passe oublié</div>
      <h2>Réinitialisez<br>votre mot de passe.</h2>
      <p class="login-sub">Saisissez votre adresse e-mail, nous vous enverrons un lien pour le réinitialiser.</p>

      <?php if ($message): ?>
        <div class="login-error" style="background:<?= $messageType === 'success' ? 'rgba(var(--green-rgb),0.1)' : 'rgba(var(--danger-rgb),0.1)' ?>;color:<?= $messageType === 'success' ? 'var(--green)' : 'var(--danger)' ?>"><?= htmlspecialchars($message) ?></div>
      <?php endif; ?>

      <form method="post" action="mot-de-passe-oublie.php" data-validate>
        <div>
          <label class="field-label" for="email">Adresse e-mail</label>
          <input type="email" id="email" name="email" placeholder="votre@email.com" autocomplete="email" required data-msg-required="Veuillez entrer votre email." data-msg-email="Email invalide." />
        </div>
        <button type="submit" class="btn-primary">Envoyer le lien →</button>
      </form>

      <div class="login-divider"></div>
      <div class="login-footer-links">
        <span><a href="connexion.php">← Retour à la connexion</a></span>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>

<?php
include 'bootstrap.php';

$loggedIn = isset($_SESSION['user']);
$success = '';
$error = '';

// Renvoi du lien de vérification (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    if (!csrf_verify($_POST['csrf_token'] ?? '')) {
        $error = 'Session invalide. Veuillez réessayer.';
    } else {
        $email = trim($_POST['email'] ?? '');
        $stmt = $conn->prepare("SELECT id_utilisateur, email_verified FROM utilisateur WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $acc = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if ($acc && (int)($acc['email_verified'] ?? 1) !== 1) {
            $vToken = bin2hex(random_bytes(32));
            $vExpires = date('Y-m-d H:i:s', strtotime('+24 hours'));
            $upd = $conn->prepare("UPDATE utilisateur SET verification_token = ?, verification_expires = ? WHERE id_utilisateur = ?");
            $upd->bind_param("ssi", $vToken, $vExpires, $acc['id_utilisateur']);
            $upd->execute();
            $upd->close();

            include 'email.php';
            emailVerification($email, $vToken);
            $logDir = private_storage_path('logs');
            if (!is_dir($logDir)) { @mkdir($logDir, 0700, true); }
            $verificationUrl = app_url('/php/verifier-email.php?token=' . urlencode($vToken));
            @file_put_contents($logDir . '/verification_links.txt', "[" . date('Y-m-d H:i:s') . "] $email -> $verificationUrl\n", FILE_APPEND | LOCK_EX);
            $success = 'Un nouveau lien de vérification a été envoyé.';
        } else {
            $error = 'Aucun compte en attente de vérification ne correspond à cet e-mail.';
        }
    }
} elseif (isset($_GET['token'])) {
    // Validation du token reçu par email
    $token = trim($_GET['token'] ?? '');
    $stmt = $conn->prepare("SELECT id_utilisateur FROM utilisateur WHERE verification_token = ? AND verification_expires > NOW() LIMIT 1");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $acc = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($acc) {
        $upd = $conn->prepare("UPDATE utilisateur SET email_verified = 1, verification_token = NULL, verification_expires = NULL WHERE id_utilisateur = ?");
        $upd->bind_param("i", $acc['id_utilisateur']);
        $upd->execute();
        $upd->close();
        $success = 'Votre adresse e-mail a été vérifiée avec succès. Vous pouvez maintenant vous connecter.';
    } else {
        $error = 'Lien de vérification invalide ou expiré. Vous pouvez renvoyer un nouveau lien ci-dessous.';
    }
}
?>
<?php
$page_title = 'Vérification e-mail | EcoDrive';
$page_desc = 'Vérifiez votre adresse e-mail pour activer votre compte EcoDrive.';
$page_url = 'php/verifier-email.php';
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

<div class="login-page hero-entrance">
  <div class="login-visual">
    <div class="login-visual-grid"></div>
    <div class="login-visual-glow"></div>
    <div class="login-visual-content">
      <a href="../index.php" class="login-visual-logo">eco<span>drive</span></a>
      <div class="login-visual-divider"></div>
      <div class="login-visual-quote">
        Votre e-mail,<br><em>c'est votre clé.</em>
      </div>
      <div class="login-visual-sub">Activation du compte</div>
    </div>
  </div>

  <div class="login-form-col">
    <div class="login-form-wrap">
      <div class="login-eyebrow">Vérification e-mail</div>
      <h2>Activez<br>votre compte.</h2>
      <p class="login-sub">Validez votre adresse e-mail pour pouvoir vous connecter et réserver vos essais.</p>

      <?php if ($success): ?>
        <div class="login-success">✓ <?= htmlspecialchars($success) ?></div>
      <?php endif; ?>
      <?php if ($error): ?>
        <div class="login-error">⚠ <?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form method="post" action="verifier-email.php" data-validate>
        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
        <div>
          <label class="field-label" for="email">Adresse e-mail</label>
          <input type="email" id="email" name="email" placeholder="votre@email.com" autocomplete="email" required data-msg-required="Veuillez entrer votre email." data-msg-email="Email invalide." />
        </div>
        <button type="submit" class="btn-primary">Renvoyer le lien →</button>
      </form>

      <div class="login-divider"></div>
      <div class="login-footer-links">
        <span><a href="connexion.php">← Retour à la connexion</a></span>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
</body>
</html>

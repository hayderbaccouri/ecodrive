<?php
include 'bootstrap.php';

$loggedIn = isset($_SESSION['user']);

if (isset($_SESSION['user'])) {
    header('Location: ../index.php');
    exit;
}

$error = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_verify($_POST['csrf_token'] ?? '')) { die('Session invalide.'); }
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $error = 'Veuillez entrer votre e-mail et mot de passe.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Adresse e-mail invalide.';
    } else {
        // Rate limiting: max 5 attempts per 15 minutes
        $ip = $_SERVER['REMOTE_ADDR'];
        $attempts = $conn->prepare("SELECT COUNT(*) AS cnt FROM login_attempts WHERE email=? AND ip_address=? AND attempted_at > DATE_SUB(NOW(), INTERVAL 15 MINUTE)");
        $attempts->bind_param("ss", $email, $ip);
        $attempts->execute();
        $count = $attempts->get_result()->fetch_assoc()['cnt'];
        $attempts->close();

        if ($count >= 5) {
            $error = 'Trop de tentatives. Réessayez dans 15 minutes.';
        } else {
        $stmt = $conn->prepare('SELECT id_utilisateur, nom, email, mot_de_passe, role FROM utilisateur WHERE email = ? LIMIT 1');

        if ($stmt) {
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $stmt->close();

            if ($user && password_verify($password, $user['mot_de_passe'])) {
              // Regenerate session id to prevent session fixation
              session_regenerate_id(true);
              $names = preg_split('/\s+/', $user['nom'] ?? '', 2, PREG_SPLIT_NO_EMPTY);
                $_SESSION['user'] = [
                    'id'     => $user['id_utilisateur'],
                    'prenom' => $names[0] ?? 'Utilisateur',
                    'nom'    => $names[1] ?? '',
                    'email'  => $user['email'],
                    'role'   => $user['role'] ?? 'client',
                ];
                $log = $conn->prepare("INSERT INTO login_attempts (email, ip_address, success) VALUES (?, ?, 1)");
                $log->bind_param("ss", $email, $ip);
                $log->execute();
                $log->close();
                header('Location: ../index.php');
                exit;
            }
        }

        if ($error === '') {
            $error = 'Email ou mot de passe incorrect.';
        }
        $log = $conn->prepare("INSERT INTO login_attempts (email, ip_address, success) VALUES (?, ?, 0)");
        $log->bind_param("ss", $email, $ip);
        $log->execute();
        $log->close();
        } // fin rate limiting
    }
}
?>
<?php
$page_title = 'Connexion | EcoDrive';
$page_desc = 'Connectez-vous à votre compte EcoDrive pour gérer vos réservations d\'essais, votre profil et vos voitures favorites.';
$page_url = 'php/connexion.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') ?></title>
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E%26%23x26A1%3B%3C/text%3E%3C/svg%3E">
  <?php include __DIR__ . '/partials/meta.php'; ?>
  <link rel="stylesheet" href="../css/style.css?v=17">
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
        L'avenir de la route,<br><em>sans émissions.</em>
      </div>
      <div class="login-visual-sub">Premier showroom électrique · Tunisie</div>
    </div>
  </div>

  <div class="login-form-col">
    <div class="login-form-wrap">

      <div class="login-eyebrow">Espace client</div>
      <h2>Bon retour<br>parmi nous.</h2>
      <p class="login-sub">Accédez à votre espace EcoDrive pour gérer vos essais et réservations.</p>

      <?php if (isset($_GET['registered'])): ?>
        <div class="login-success">✓ Compte créé avec succès. Vous pouvez maintenant vous connecter.</div>
      <?php endif; ?>

      <?php if ($error): ?>
        <div class="login-error">⚠ <?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form method="post" action="connexion.php" data-validate>
        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
        <div>
          <label class="field-label" for="email">Adresse e-mail</label>
          <input type="email" id="email" name="email"
                 placeholder="votre@email.com"
                 value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                 autocomplete="email" required data-msg-required="Veuillez entrer votre email." data-msg-email="Email invalide." />
        </div>

        <div>
          <label class="field-label" for="password">Mot de passe</label>
          <div class="pwd-wrap">
            <input type="password" id="password" name="password"
                   placeholder="••••••••"
                   autocomplete="current-password" required data-msg-required="Veuillez entrer votre mot de passe." />
            <button type="button" class="pwd-toggle" aria-label="Afficher le mot de passe">👁</button>
          </div>
        </div>

        <div class="login-extra">
          <a href="mot-de-passe-oublie.php">Mot de passe oublié ?</a>
        </div>

        <button type="submit" class="auth-btn">Se connecter →</button>
      </form>

      <div class="login-divider"></div>

      <div class="login-footer-links">
        Pas encore de compte ? <a href="inscription.php">Créer un compte gratuit</a>
      </div>

    </div>
  </div>

</div>

<?php $asset_base = '../'; include __DIR__ . '/partials/footer.php'; ?>

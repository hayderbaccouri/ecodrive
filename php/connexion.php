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
  <link rel="stylesheet" href="../css/style.css?v=15">
</head>
<body>

  <?php $asset_base = '../'; include __DIR__ . '/partials/header.php'; ?>

<div class="login-page hero-entrance">

  <!-- Colonne gauche : visuel -->
  <div class="login-visual">
    <div class="login-visual-grid"></div>
    <div class="login-visual-glow"></div>

    <div class="login-visual-content">
      <a href="../index.php" class="login-visual-logo">eco<span>drive</span></a>

      <div class="login-visual-energies">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 14h6l-2 8 10-12h-6l2-8z"/><path d="M18 10c2 2 2 5 0 7" opacity=".6"/></svg>
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 20A7 7 0 0 1 9.8 6.9C15.5 4.9 17 3.5 19 2c1 2 2 4.5 2 8 0 5.5-4.78 10-10 10Z"/></svg>
      </div>

      <div class="login-visual-quote">
        L'avenir de la route,
        <strong>sans émissions.</strong>
      </div>
      <div class="login-visual-sub">Premier showroom électrique · Tunisie</div>
    </div>
  </div>

  <!-- Colonne droite : formulaire -->
  <div class="login-form-col">
    <div class="login-form-wrap">

      <div class="login-eyebrow">Espace client</div>
      <h2>Bon retour<br>parmi nous.</h2>
      <p class="login-sub">Connectez-vous pour accéder à votre espace EcoDrive et gérer vos essais.</p>

      <?php if ($error): ?>
        <div class="login-error">
          ⚠ <?= htmlspecialchars($error) ?>
        </div>
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

        <button type="submit" class="btn-primary">Se connecter →</button>
      </form>

      <div class="login-footer-links" style="margin-top:0.5rem">
        <span><a href="mot-de-passe-oublie.php" style="font-weight:400;font-size:0.8rem">Mot de passe oublié ?</a></span>
      </div>

      <div class="login-divider"></div>

      <div class="login-footer-links">
        <span>Pas encore de compte ? <a href="inscription.php">S'inscrire gratuitement</a></span>
      </div>

    </div>
  </div>

</div>

<?php $asset_base = '../'; include __DIR__ . '/partials/footer.php'; ?>

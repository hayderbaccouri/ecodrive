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
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $error = 'Veuillez entrer votre e-mail et mot de passe.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Adresse e-mail invalide.';
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
                header('Location: ../index.php');
                exit;
            }
        }

        if ($error === '') {
            $error = 'Email ou mot de passe incorrect.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Connexion — EcoDrive</title>
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E%26%23x26A1%3B%3C/text%3E%3C/svg%3E">
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="../css/header.css" />
</head>
<body>

  <?php $asset_base = '../'; include __DIR__ . '/partials/header.php'; ?>

<div class="login-page">

  <!-- Colonne gauche : visuel -->
  <div class="login-visual">
    <div class="login-visual-grid"></div>
    <div class="login-visual-glow"></div>

    <div class="login-visual-content">
      <a href="../index.php" class="login-visual-logo">eco<span>drive</span></a>

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

      <form method="post" action="connexion.php">
        <div>
          <label class="field-label" for="email">Adresse e-mail</label>
          <input type="email" id="email" name="email"
                 placeholder="votre@email.com"
                 value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                 autocomplete="email" required />
        </div>

        <div>
          <label class="field-label" for="password">Mot de passe</label>
          <input type="password" id="password" name="password"
                 placeholder="••••••••"
                 autocomplete="current-password" required />
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

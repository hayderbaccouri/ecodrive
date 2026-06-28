<?php
session_start();
include 'configuration.php';

if (isset($_SESSION['user'])) {
  header('Location: ../index.php');
  exit;
}

$error = '';
$fullname = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $fullname = trim($_POST['fullname'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';

  if ($fullname === '' || $email === '' || $password === '') {
    $error = 'Veuillez remplir tous les champs.';
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = 'Adresse e-mail invalide.';
  } else {
    $names = preg_split('/\s+/', $fullname, 2, PREG_SPLIT_NO_EMPTY);
    $prenom = $names[0] ?? '';
    $nom = $names[1] ?? '';

    $stmt = $conn->prepare('SELECT id_utilisateur FROM utilisateur WHERE email = ? LIMIT 1');
    if ($stmt) {
      $stmt->bind_param('s', $email);
      $stmt->execute();
      $stmt->store_result();
      if ($stmt->num_rows > 0) {
        $error = 'Un compte existe deja avec cette adresse e-mail.';
      }
      $stmt->close();
    } else {
      $error = 'Erreur serveur. Veuillez reessayer plus tard.';
    }

    if ($error === '') {
      $hash = password_hash($password, PASSWORD_DEFAULT);
      $fullName = trim($prenom . ($nom ? ' ' . $nom : ''));
      if ($fullName === '') {
        $fullName = $email;
      }

      $stmt = $conn->prepare('INSERT INTO utilisateur (nom, email, mot_de_passe) VALUES (?, ?, ?)');
      if ($stmt) {
        $stmt->bind_param('sss', $fullName, $email, $hash);
        if ($stmt->execute()) {
          $stmt->close();
          $conn->close();
          header('Location: connexion.php?registered=1');
          exit;
        }
        $error = 'Impossible de creer le compte. ' . $stmt->error;
        $stmt->close();
      } else {
        $error = 'Erreur serveur. Veuillez reessayer plus tard.';
      }
    }
  }

  $conn->close();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inscription - EcoDrive</title>
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E%26%23x26A1%3B%3C/text%3E%3C/svg%3E">
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/header.css">
</head>
<body>
  <header class="site-header">
    <a href="../index.php" class="logo-text">eco<span>drive</span></a>
    <nav>
      <a href="../index.php">Accueil</a>
      <a href="catalogue.php">Catalogue</a>
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
        Rejoignez<br><strong>la révolution électrique.</strong>
      </div>
      <div class="login-visual-sub">Premier showroom électrique · Tunisie</div>
    </div>
  </div>

  <div class="login-form-col">
    <div class="login-form-wrap">

      <div class="login-eyebrow">Espace client</div>
      <h2>Créer un compte.</h2>
      <p class="login-sub">Rejoignez EcoDrive pour réserver vos essais et suivre vos demandes.</p>

      <?php if ($error): ?>
        <div class="login-error">&#9888; <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
      <?php endif; ?>

      <form method="post" action="inscription.php">
        <div>
          <label class="field-label" for="fullname">Nom complet</label>
          <input type="text" id="fullname" name="fullname"
                 placeholder="Votre nom"
                 value="<?= htmlspecialchars($fullname, ENT_QUOTES, 'UTF-8') ?>"
                 autocomplete="name" required />
        </div>

        <div>
          <label class="field-label" for="email">Adresse e-mail</label>
          <input type="email" id="email" name="email"
                 placeholder="votre@email.com"
                 value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>"
                 autocomplete="email" required />
        </div>

        <div>
          <label class="field-label" for="password">Mot de passe</label>
          <input type="password" id="password" name="password"
                 placeholder="••••••••"
                 autocomplete="new-password" required />
        </div>

        <button type="submit" class="auth-btn">Créer mon compte</button>
      </form>

      <p class="login-switch">Déjà inscrit ? <a href="connexion.php">Se connecter</a></p>
    </div>
  </div>

</div>

<button class="back-to-top" aria-label="Retour en haut">&uarr;</button>
<script src="../js/app.js"></script>
</body>
</html>

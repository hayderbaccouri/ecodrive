<?php
session_start();
include 'configuration.php';

$loggedIn = isset($_SESSION['user']);

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
  <title>Inscription - EcoDrive</title>
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E%26%23x26A1%3B%3C/text%3E%3C/svg%3E">
  <link rel="stylesheet" href="../css/style.css">
</head>

<body>
  <header>
    <a href="../index.php" class="logo-text">eco<span>drive</span></a>
    <nav>
      <a href="../index.php">Accueil</a>
      <a href="catalogue.php">Catalogue</a>
      <a href="../pages/contact.php">Contact</a>
      <?php if ($loggedIn): ?>
        <a href="<?= ($_SESSION['user']['role'] ?? 'client') === 'admin' ? 'admin.php' : 'tableau-de-bord.php' ?>">Mon espace</a>
        <a href="deconnexion.php">Déconnexion</a>
      <?php else: ?>
        <a href="connexion.php">Connexion / Inscription</a>
      <?php endif; ?>
    </nav>
  </header>

  <h2>Creer un compte EcoDrive</h2>

  <?php if ($error): ?>
    <div class="alert alert-error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
  <?php endif; ?>

  <form method="POST" action="inscription.php">
    <input type="text" name="fullname" placeholder="Nom complet" value="<?= htmlspecialchars($fullname, ENT_QUOTES, 'UTF-8') ?>" required>
    <input type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>" required>
    <input type="password" name="password" placeholder="Mot de passe" required>
    <button type="submit">S'inscrire</button>
  </form>

  <p>Deja inscrit ? <a href="connexion.php">Se connecter</a></p>
</body>

</html>

<?php
include 'bootstrap.php';

if (!isset($_SESSION['user']['id'])) {
    header('Location: connexion.php');
    exit;
}

$userId = $_SESSION['user']['id'];
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    if (!csrf_verify($_POST['csrf_token'] ?? '')) {
        $message = 'Session invalide.';
        $messageType = 'error';
    } else {
        $nom = trim($_POST['nom'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $telephone = trim($_POST['telephone'] ?? '');
        $password = $_POST['password'] ?? '';
        $passwordConfirm = $_POST['password_confirm'] ?? '';

        if ($nom === '' || $email === '') {
            $message = 'Le nom et l\'email sont obligatoires.';
            $messageType = 'error';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = 'Email invalide.';
            $messageType = 'error';
        } elseif ($password !== '' && $password !== $passwordConfirm) {
            $message = 'Les mots de passe ne correspondent pas.';
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
                    $stmt = $conn->prepare("UPDATE utilisateur SET nom = ?, email = ?, telephone = ?, mot_de_passe = ? WHERE id_utilisateur = ?");
                    $stmt->bind_param("ssssi", $nom, $email, $telephone, $hash, $userId);
                } else {
                    $stmt = $conn->prepare("UPDATE utilisateur SET nom = ?, email = ?, telephone = ? WHERE id_utilisateur = ?");
                    $stmt->bind_param("sssi", $nom, $email, $telephone, $userId);
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

$stmt = $conn->prepare("SELECT nom, email, telephone, role, created_at FROM utilisateur WHERE id_utilisateur = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

$initiale = mb_strtoupper(mb_substr(trim($user['nom'] ?? '') ?: 'U', 0, 1, 'UTF-8'), 'UTF-8');
$moisFrProfil = ['janvier','février','mars','avril','mai','juin','juillet','août','septembre','octobre','novembre','décembre'];
$membreDepuis = !empty($user['created_at']) ? $moisFrProfil[(int)date('n', strtotime($user['created_at'])) - 1] . ' ' . date('Y', strtotime($user['created_at'])) : '';
?>
<?php
$page_title = 'Mon profil | EcoDrive';
$page_desc = 'Modifiez vos informations personnelles, votre email et votre mot de passe sur votre profil EcoDrive.';
$page_url = 'php/profil.php';
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
<body class="admin-area">
<?php $asset_base = '../'; include __DIR__ . '/partials/header.php'; ?>

  <main class="main-wrap page-fade-in">

    <div class="client-hero">
      <div class="hero-avatar"><?= htmlspecialchars($initiale) ?></div>
      <div class="client-hero-text">
        <h1>Mon profil</h1>
        <p>Modifiez vos informations personnelles et votre mot de passe.</p>
        <div class="hero-meta">
          <?php if ($membreDepuis !== ''): ?><span>Membre depuis <strong><?= $membreDepuis ?></strong></span><?php endif; ?>
          <span>Statut <strong><?= htmlspecialchars($user['role'] ?? 'client') ?></strong></span>
        </div>
      </div>
    </div>

    <nav class="client-nav">
      <a href="tableau-de-bord.php">📊 Tableau de bord</a>
      <a href="mes-essais.php">🚗 Mes essais</a>
      <a href="profil.php" class="active">👤 Mon profil</a>
    </nav>

    <?php if ($message): ?>
      <div class="alert alert-<?= $messageType === 'success' ? 'success' : 'error' ?>"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <div class="client-section client-section--wide">
      <div class="form-card">
        <form method="POST" action="profil.php" data-validate class="profile-form-grid">
          <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
          <input type="hidden" name="update_profile" value="1">

          <h3 class="form-subtitle">Informations personnelles</h3>

          <div>
            <label for="nom">Nom complet</label>
            <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($user['nom']) ?>" required data-msg-required="Veuillez entrer votre nom.">
          </div>

          <div>
            <label for="email">Adresse e-mail</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required data-msg-required="Veuillez entrer votre email." data-msg-email="Email invalide.">
          </div>

          <div class="full-width">
            <label for="telephone">Téléphone</label>
            <input type="tel" id="telephone" name="telephone" value="<?= htmlspecialchars($user['telephone'] ?? '') ?>" placeholder="+216 XX XXX XXX">
          </div>

          <h3 class="form-subtitle">Sécurité</h3>

          <div>
            <label for="password">Nouveau mot de passe</label>
            <div class="pwd-wrap">
              <input type="password" id="password" name="password" placeholder="••••••••" autocomplete="new-password">
              <button type="button" class="pwd-toggle" aria-label="Afficher le mot de passe">👁</button>
            </div>
            <p class="pwd-hint">Laisser vide pour conserver l'actuel.</p>
          </div>

          <div>
            <label for="password_confirm">Confirmer le mot de passe</label>
            <div class="pwd-wrap">
              <input type="password" id="password_confirm" name="password_confirm" placeholder="••••••••" autocomplete="new-password" data-match="password">
              <button type="button" class="pwd-toggle" aria-label="Afficher le mot de passe">👁</button>
            </div>
          </div>

          <button type="submit" class="btn btn-primary full-width">Enregistrer les modifications</button>
        </form>
      </div>
    </div>
  </main>

<?php include __DIR__ . '/partials/footer.php'; ?>
</body>
</html>

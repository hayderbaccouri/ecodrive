<?php
// Partial header — expect $asset_base (e.g. '' or '../'), $loggedIn, $user, $prenom
$asset_base = $asset_base ?? '';
$prenom = $prenom ?? ($user['prenom'] ?? 'Visiteur');
?>
  <!-- Bannière de bienvenue personnalisée -->
  <?php if (!empty($prenom) && ($asset_base === '')): ?>
  <div class="welcome-banner">
    👋 Bienvenue, <strong><?= htmlspecialchars($prenom, ENT_QUOTES, 'UTF-8') ?></strong> ! Profitez de votre espace EcoDrive.
  </div>
  <?php endif; ?>

  <!-- Top announcement bar -->
  <div class="topbar">✦ Premier showroom de voitures électriques en Tunisie — Essai gratuit disponible</div>

  <!-- Header -->
  <header class="site-header">
    <a class="logo-link" href="<?= $asset_base ?>index.php" aria-label="Accueil EcoDrive">
      <div class="logo-text">eco<span>drive</span></div>
    </a>

    <nav class="main-nav" aria-label="Navigation principale">
      <a href="<?= $asset_base ?>index.php">Accueil</a>
      <a href="<?= $asset_base ?>php/catalogue.php">Catalogue</a>
      <a href="<?= $asset_base ?>#bornes">Bornes</a>
      <a href="<?= $asset_base ?>pages/contact.php">Contact</a>

      <?php if (!empty($loggedIn)): ?>
        <div class="user-menu">
          <div class="user-badge">
            <div class="avatar"><?= mb_strtoupper(mb_substr($prenom, 0, 1)) ?></div>
            <span class="user-name"><?= htmlspecialchars($prenom, ENT_QUOTES, 'UTF-8') ?></span>
            <span class="chevron">▾</span>
          </div>
          <div class="user-dropdown">
            <?php $dashboardPage = ($user['role'] ?? 'client') === 'admin' ? $asset_base . 'php/admin.php' : $asset_base . 'php/tableau-de-bord.php'; ?>
            <a href="<?= $dashboardPage ?>">👤 Mon espace</a>
            <hr>
            <a href="<?= $asset_base ?>php/deconnexion.php" class="logout">🚪 Se déconnecter</a>
          </div>
        </div>
      <?php else: ?>
        <a href="<?= $asset_base ?>php/connexion.php" class="nav-link">Se connecter</a>
        <a href="<?= $asset_base ?>php/inscription.php" class="nav-cta">S'inscrire</a>
      <?php endif; ?>
    </nav>
  </header>

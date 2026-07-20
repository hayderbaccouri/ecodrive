<?php
// Partial header — expect $asset_base (e.g. '' or '../'), $loggedIn, $user, $prenom
$asset_base = $asset_base ?? '';
$prenom = $prenom ?? ($user['prenom'] ?? 'Visiteur');
?>

  <!-- Top announcement bar -->
  <div class="topbar"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;vertical-align:-2px"><path d="M13 2L3 14h6l-2 8 10-12h-6l2-8z"/></svg> Premier showroom de voitures électriques en Tunisie — Essai gratuit disponible</div>

  <!-- Header -->
  <header class="site-header">
    <a class="logo-link" href="<?= $asset_base ?>index.php" aria-label="Accueil EcoDrive">
      <div class="logo-text">eco<span>drive</span></div>
      <div class="brand-tagline">Premier showroom électrique de Tunisie</div>
    </a>

    <button class="burger" aria-label="Menu" aria-expanded="false" aria-controls="site-nav">
      <span></span><span></span><span></span>
    </button>
    <nav id="site-nav" class="main-nav" aria-label="Navigation principale">
      <a href="<?= $asset_base ?>index.php">Accueil</a>
      <a href="<?= $asset_base ?>php/catalogue.php">Catalogue</a>
      <a href="<?= $asset_base ?>bornes/index.php">Bornes</a>
      <a href="<?= $asset_base ?>pages/contact.php">Contact</a>


      <?php if (!empty($loggedIn)): ?>
        <div class="user-menu">
          <div class="user-badge" tabindex="0" role="button" aria-haspopup="true" aria-expanded="false">
            <div class="avatar"><?= mb_strtoupper(mb_substr($prenom, 0, 1)) ?></div>
            <span class="user-name"><?= htmlspecialchars($prenom, ENT_QUOTES, 'UTF-8') ?></span>
            <span class="chevron">▾</span>
          </div>
          <div class="user-dropdown" role="menu">
            <?php $isAdmin = ($user['role'] ?? 'client') === 'admin'; ?>
            <a href="<?= $asset_base ?><?= $isAdmin ? 'php/admin.php' : 'php/tableau-de-bord.php' ?>" role="menuitem">👤 Mon espace</a>
            <?php if (!$isAdmin): ?>
              <a href="<?= $asset_base ?>php/mes-essais.php" role="menuitem">🚗 Mes essais</a>
            <?php endif; ?>
            <a href="<?= $asset_base ?>php/profil.php" role="menuitem">⚙️ Profil</a>
            <hr role="separator">
            <a href="<?= $asset_base ?>php/deconnexion.php" class="logout" role="menuitem">🚪 Se déconnecter</a>
          </div>
        </div>
      <?php else: ?>
        <a href="<?= $asset_base ?>php/connexion.php" class="nav-link">Se connecter</a>
        <a href="<?= $asset_base ?>php/inscription.php" class="nav-cta">S'inscrire</a>
      <?php endif; ?>
    </nav>
  </header>

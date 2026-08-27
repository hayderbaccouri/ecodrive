<?php
// Borne page template générique — rend une borne depuis la base de données.
// Utilisé par les stubs bornes/<slug>.php générés par l'admin (et en accès direct).
include __DIR__ . '/../php/configuration.php';

$slug = $slug ?? ($_GET['slug'] ?? basename($_SERVER['SCRIPT_NAME'] ?? '', '.php'));
$borne = null;
if ($slug !== '') {
    $stmt = $conn->prepare("SELECT * FROM borne WHERE details_page = ? LIMIT 1");
    $detailsPage = 'bornes/' . $slug . '.php';
    $stmt->bind_param("s", $detailsPage);
    $stmt->execute();
    $borne = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$borne) {
        $rows = $conn->query("SELECT * FROM borne")->fetch_all(MYSQLI_ASSOC);
        foreach ($rows as $r) {
            if (ecodrive_slugify(trim($r['nom'] . ' ' . $r['modele'])) === $slug) { $borne = $r; break; }
        }
    }
}
if (!$borne) { header('Location: index.php'); exit; }

$borneName  = trim($borne['nom'] . ' ' . $borne['modele']);
$page_title = $borneName . ' — Borne de recharge ' . $borne['puissance'] . ' | EcoDrive';
$page_desc  = ($borne['description'] ?: 'Borne de recharge ' . $borne['puissance'] . ' pour véhicule électrique.') . ' Commandez-la chez EcoDrive Tunisie.';
$page_url   = 'bornes/' . $slug . '.php';
$page_image = $borne['image'] ?: 'images/bornes/SPIN-AIR-11.png';
$price      = number_format((float) $borne['prix'], 0, ',', ' ');
$imgAlt     = $borneName;
$puissance  = $borne['puissance'] ?: '—';

if (preg_match('/^([\d.,]+)\s*(.*)$/', $puissance, $m)) {
    $powerNum  = $m[1];
    $powerUnit = trim($m[2]);
} else {
    $powerNum  = '—';
    $powerUnit = '';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E%26%23x26A1%3B%3C/text%3E%3C/svg%3E">
  <?php include __DIR__ . '/../php/partials/meta.php'; ?>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') ?></title>
  <link rel="stylesheet" href="../css/style.css?v=<?= CACHE_VERSION ?>">
</head>

<body class="has-topbar">
<?php $asset_base = '../'; include __DIR__ . '/../php/partials/header.php'; ?>

<main class="main-wrap page-fade-in">
  <div class="breadcrumb">
    <a href="../index.php">Accueil</a>
    <span>›</span>
    <a href="../bornes/index.php">Bornes de recharge</a>
    <span>›</span>
    <span style="color: var(--dark)"><?= htmlspecialchars($borneName) ?></span>
  </div>

  <!-- HERO -->
  <section class="borne-hero hero-entrance">
    <div class="borne-visual">
      <div class="borne-visual-bg"></div>
      <div class="borne-visual-grid"></div>
      <div class="borne-img-frame">
        <div class="borne-img-box">
          <?php if ($borne['image']): ?>
            <img src="../<?= htmlspecialchars(ltrim($borne['image'], '/')) ?>" alt="<?= htmlspecialchars($imgAlt) ?>"
              decoding="async" fetchpriority="high"
              onerror="this.style.display='none'; this.nextElementSibling.style.display='grid'">
          <?php endif; ?>
          <div class="borne-img-fallback" style="display:<?= $borne['image'] ? 'none' : 'grid' ?>;font-size:6rem;color:rgba(60,154,190,0.4);place-items:center">⚡</div>
        </div>
        <span class="borne-badge-portable">⚡ Recharge électrique · <?= htmlspecialchars($puissance) ?></span>
      </div>
      <div class="borne-glow-dot"></div>
    </div>

    <div class="borne-info">
      <div class="borne-eyebrow">Chargeur électrique · <?= htmlspecialchars($borne['nom']) ?></div>

      <div class="borne-power-display">
        <span class="power-num"><?= htmlspecialchars($powerNum) ?></span>
        <span class="power-unit"><?= htmlspecialchars($powerUnit) ?></span>
      </div>

      <div class="borne-title"><?= htmlspecialchars($borne['nom']) ?> <span style="color:var(--gray);font-size:.45em"><?= htmlspecialchars($borne['modele']) ?></span></div>

      <div class="borne-divider"></div>

      <p class="borne-desc-text"><?= htmlspecialchars($borne['description'] ?: 'Borne de recharge performante et fiable, adaptée à vos besoins quotidiens.') ?></p>

      <div class="specs-list">
        <div class="spec-row">
          <div class="spec-icon">⚡</div>
          <div class="spec-label">Puissance</div>
          <div class="spec-value"><?= htmlspecialchars($puissance) ?></div>
        </div>
        <div class="spec-row">
          <div class="spec-icon">🔌</div>
          <div class="spec-label">Connecteur</div>
          <div class="spec-value">Type 2 (IEC 62196)</div>
        </div>
        <div class="spec-row">
          <div class="spec-icon">🏠</div>
          <div class="spec-label">Installation</div>
          <div class="spec-value">Intérieure ou extérieure</div>
        </div>
      </div>

      <div class="borne-price-bar">
        <span class="borne-price-label">À partir de</span>
        <span class="borne-price-value"><?= $price ?> DT</span>
        <span class="borne-price-tax">HT · Installation non incluse</span>
      </div>
      <div class="borne-cta">
        <a href="../pages/contact.php" class="btn-primary">Commander</a>
        <a href="../pages/contact.php" class="btn-ghost">Demander un devis</a>
      </div>
    </div>
  </section>

  <!-- CTA BANNER -->
  <section class="cta-banner hero-entrance">
    <div>
      <div class="cta-banner-title">Prêt à passer à l'électrique ?</div>
      <div class="cta-banner-sub">Commandez votre <?= htmlspecialchars($borne['nom']) ?> ou obtenez un devis personnalisé.</div>
    </div>
    <a href="../pages/contact.php#contact" class="btn-white">Contacter EcoDrive</a>
  </section>

</main>
<?php include __DIR__ . '/../php/partials/footer.php'; ?>

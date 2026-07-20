<?php
include __DIR__ . '/../php/bootstrap.php';

$user = $_SESSION['user'] ?? null;
$loggedIn = $user !== null;

$page_title = 'Bornes de recharge | EcoDrive Tunisie';
$page_desc = 'Découvrez notre gamme de bornes de recharge Exicom pour voitures électriques en Tunisie. Installation à domicile, bureau ou flotte.';
$page_url = 'bornes/index.php';

$bornes = $conn->query("SELECT * FROM borne ORDER BY puissance DESC")->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') ?></title>
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E%26%23x26A1%3B%3C/text%3E%3C/svg%3E">
  <?php include __DIR__ . '/../php/partials/meta.php'; ?>
  <link rel="stylesheet" href="../css/style.css?v=19">
</head>

<body class="has-topbar">
<?php $asset_base = '../'; include __DIR__ . '/../php/partials/header.php'; ?>

  <section id="bornes-list" class="bornes-page">
    <div class="container" style="max-width:var(--wrap-max);margin:0 auto;padding:clamp(2rem,5vw,3rem) var(--wrap)">

      <div class="section-header" style="text-align:center;margin-bottom:2.5rem">
        <h1 style="font-family:var(--font-display);font-size:clamp(2rem,4vw,3rem);color:var(--dark);margin-bottom:.5rem">Nos bornes de recharge</h1>
        <p style="color:var(--gray);font-size:1rem;max-width:500px;margin:0 auto">Des solutions de recharge fiables pour chaque besoin — à domicile, au bureau ou pour votre flotte.</p>
        <div class="section-rule" style="margin:1rem auto 0"></div>
      </div>

      <div class="bornes-grid">
        <?php foreach ($bornes as $b):
          $img = '../' . htmlspecialchars(ltrim($b['image'] ?? 'images/placeholder.png', '/'), ENT_QUOTES, 'UTF-8');
          $details = '../' . htmlspecialchars(ltrim($b['details_page'] ?? '#', '/'), ENT_QUOTES, 'UTF-8');
          $nom = htmlspecialchars($b['nom'] . ' ' . $b['modele'], ENT_QUOTES, 'UTF-8');
          $puissance = htmlspecialchars($b['puissance'], ENT_QUOTES, 'UTF-8');
          $prix = number_format((float)$b['prix'], 0, ',', ' ');
          $desc = htmlspecialchars($b['description'] ?? '', ENT_QUOTES, 'UTF-8');
        ?>
        <a class="borne-card" href="<?= $details ?>">
          <img src="<?= $img ?>" alt="<?= $nom ?>" class="borne-image" loading="lazy" />
          <div><span class="borne-power"><?= $puissance ?></span></div>
          <div class="borne-name"><?= $nom ?></div>
          <p class="borne-desc"><?= $desc ?></p>
          <div class="borne-price"><?= $prix ?> DT</div>
        </a>
        <?php endforeach; ?>
      </div>

      <div class="section-header" style="margin-top:3rem">
        <div class="section-eyebrow">Pourquoi EcoDrive ?</div>
        <h2 class="section-title">Un accompagnement complet</h2>
        <div class="section-rule"></div>
      </div>

      <div class="about-values" style="max-width:700px;margin:0 auto">
        <div class="value-item"><div class="value-dot"></div><div class="value-text">Installation professionnelle à domicile ou en entreprise</div></div>
        <div class="value-item"><div class="value-dot"></div><div class="value-text">Pilotage et suivi via application mobile</div></div>
        <div class="value-item"><div class="value-dot"></div><div class="value-text">Compatible toutes voitures électriques</div></div>
        <div class="value-item"><div class="value-dot"></div><div class="value-text">Garantie constructeur incluse</div></div>
      </div>

      <div style="text-align:center;margin-top:3rem">
        <a href="../pages/contact.php" class="btn-primary">Demander un devis gratuit</a>
      </div>

    </div>
  </section>

<?php $asset_base = '../'; include __DIR__ . '/../php/partials/footer.php'; ?>
</body>
</html>

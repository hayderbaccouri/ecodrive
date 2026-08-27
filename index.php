
<?php
include 'php/bootstrap.php';
$user = $_SESSION['user'] ?? null;
$prenom = htmlspecialchars($user['prenom'] ?? 'Visiteur', ENT_QUOTES, 'UTF-8');
$email = htmlspecialchars($user['email'] ?? '', ENT_QUOTES, 'UTF-8');
$loggedIn = $user !== null;

$contactMessage = '';

// Traitement du formulaire de contact
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact'])) {
    if (!csrf_verify($_POST['csrf_token'] ?? '')) { die('Session invalide.'); }
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $model   = trim($_POST['model'] ?? '');
    $message = trim($_POST['message'] ?? '');

    $bucket = 'contact:' . rate_limit_ip();
    if (rate_limit_check($conn, $bucket, 3, 600)) {
        $contactMessage = 'Trop de tentatives. Réessayez dans 10 minutes.';
    } elseif ($name && $email && $message) {
        // Sanitize and prevent header injection
        $safeName = substr(preg_replace('/[\r\n]+/', ' ', $name), 0, 100);
        $subject = "Contact EcoDrive - " . $safeName;
        $body = "Nom: $safeName\nEmail: $email\nModèle: $model\n\nMessage:\n$message";

        // Use a fixed From header and set Reply-To only if the user email is valid
        $from = 'noreply@ecodrive.tn';
        $replyTo = filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : 'contact@ecodrive.tn';
        $headers = "From: EcoDrive <{$from}>\r\nReply-To: {$replyTo}\r\nX-Mailer: PHP/" . phpversion();

        // Persistance en base
        $stmt = $conn->prepare("INSERT INTO contact_message (nom, email, telephone, sujet, message) VALUES (?, ?, NULL, ?, ?)");
        $stmt->bind_param("ssss", $safeName, $email, $model, $message);
        $stmt->execute();
        $stmt->close();
        rate_limit_hit($conn, $bucket);

        $sent = @mail('contact@ecodrive.tn', $subject, $body, $headers);

        $logDir = __DIR__ . '/private/logs';
        if (!is_dir($logDir)) { @mkdir($logDir, 0755, true); }
        $log  = "[" . date('Y-m-d H:i:s') . "]\n";
        $log .= "Nom : $safeName\nEmail : $email\nModèle : $model\nMessage : $message\nMail envoyé : " . ($sent ? 'Oui' : 'Non (mail() a échoué)') . "\n---\n";
        @file_put_contents($logDir . '/mail_log.txt', $log, FILE_APPEND | LOCK_EX);

        $contactMessage = $sent ? 'Message envoyé. Notre équipe vous répondra rapidement.' : 'Merci ! Votre message a bien été transmis.';
    } else {
        $contactMessage = 'Veuillez remplir tous les champs obligatoires.';
    }
}

// Récupérer les voitures vedettes pour l'accueil
$voitures = $conn->query("SELECT id_voiture, marque, modele, prix, image, details_page FROM voiture WHERE is_featured = 1 ORDER BY marque")->fetch_all(MYSQLI_ASSOC);

$page_title = 'EcoDrive — Premier showroom électrique en Tunisie';
$page_desc = 'Découvrez les meilleures voitures électriques en Tunisie. Essai gratuit, bornes de recharge et accompagnement sur-mesure.';
$page_url = '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') ?></title>
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E%26%23x26A1%3B%3C/text%3E%3C/svg%3E">
  <?php include __DIR__ . '/php/partials/meta.php'; ?>
  <link rel="stylesheet" href="css/style.css?v=<?= CACHE_VERSION ?>">
  <?php $jsonld_type = 'localbusiness'; $jsonld_products = array_map(fn($v) => $v['marque'].' '.$v['modele'], $voitures); include __DIR__ . '/php/partials/jsonld.php'; ?>
</head>
<body>
<?php $asset_base = ''; include 'php/partials/header.php'; ?>

  <!-- Hero -->
  <section class="hero" aria-label="Présentation EcoDrive">
    <div class="hero-inner">
      <div class="hero-content">
        <div class="hero-eyebrow">Mobilité durable en Tunisie</div>
        <h1 class="hero-title">
          L'avenir de la route, <em>sans émissions.</em>
        </h1>
        <p class="hero-desc">
          EcoDrive est le premier showroom spécialisé en véhicules électriques en Tunisie.
          Découvrez une sélection premium, testez avant d'acheter, et rejoignez la révolution verte.
        </p>
        <div class="hero-actions">
          <a href="php/catalogue.php" class="btn-primary cta">Explorer le catalogue</a>
          <a href="bornes/index.php" class="btn-primary cta">Explorer les bornes</a>
        </div>
      </div>
    </div>
  </section>

  <!-- Showroom -->
  <section id="showroom" class="showroom-section">
    <div class="section-header">
      <div class="section-eyebrow">Nouvelles arrivées</div>
      <h2 class="section-title">Notre sélection premium</h2>
      <div class="section-rule"></div>
    </div>

    <div class="showroom">
      <div class="cars-grid reveal reveal-up reveal-delay-1">

        <?php foreach ($voitures as $v):
          $img = htmlspecialchars(ltrim($v['image'] ?? '', '/'), ENT_QUOTES, 'UTF-8');
          $details = htmlspecialchars(ltrim($v['details_page'] ?? '#', '/'), ENT_QUOTES, 'UTF-8');
          $nom = htmlspecialchars($v['marque'] . ' ' . $v['modele'], ENT_QUOTES, 'UTF-8');
          $prix = number_format((float)$v['prix'], 0, ',', ' ');
          $placeholders = ['🚗', '🚙', '🚘', '🏎️'];
        ?>
        <article class="car-card">
          <div class="car-img-wrap">
            <img src="<?= $img ?>" alt="<?= $nom ?>" loading="lazy"
              onerror="this.onerror=null; this.parentNode.innerHTML='<div class=&quot;car-placeholder&quot;><?= $placeholders[array_rand($placeholders)] ?></div>';" />
            <div class="car-overlay">
              <a href="<?= $details ?>">Voir détails</a>
            </div>
          </div>
          <div class="car-info">
            <div class="car-badge">Nouveau modèle</div>
            <div class="car-name"><?= $nom ?></div>
            <div class="car-meta">
              <span class="car-range">À partir de <?= $prix ?> DT</span>
              <a href="<?= $details ?>" class="car-arrow" aria-label="Aller aux détails">→</a>
            </div>
          </div>
        </article>
        <?php endforeach; ?>
        
      </div>

      <div class="showroom-all">
        <a href="php/catalogue.php" class="btn-ghost">Voir tout le catalogue →</a>
      </div>
    </div>
  </section>

  <!-- Marques -->
  <section class="brands-section">
    <div class="section-header">
      <div class="section-eyebrow">Explorer par marque</div>
      <h2 class="section-title">Les meilleures marques électriques</h2>
      <div class="section-rule"></div>
    </div>
    <div class="brands-grid">
      <?php
      $brandAll = $conn->query("SELECT marque, COUNT(*) AS cnt FROM voiture GROUP BY marque ORDER BY cnt DESC, marque LIMIT 8")->fetch_all(MYSQLI_ASSOC);
      foreach ($brandAll as $ba):
          $brand = $ba['marque'];
          $cnt = (int)$ba['cnt'];
          $label = mb_strtoupper($brand, 'UTF-8');
          $font = mb_strlen($label) > 12 ? 20 : (mb_strlen($label) > 7 ? 24 : 28);
          $ls = mb_strlen($label) > 12 ? 2 : 3;
          $labelCnt = $cnt > 1 ? "$cnt modèles" : "$cnt modèle";
      ?>
      <a href="php/catalogue.php?brand=<?= urlencode($brand) ?>" class="brand-card">
        <div class="brand-logo">
          <svg viewBox="0 0 200 30" fill="currentColor"><text x="50%" y="24" text-anchor="middle" font-family="'Cormorant Garamond',serif" font-size="<?= $font ?>" font-weight="600" letter-spacing="<?= $ls ?>"><?= htmlspecialchars($label) ?></text></svg>
        </div>
        <div class="brand-info">
          <span class="brand-count"><?= $labelCnt ?></span>
          <span class="brand-arrow">→</span>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- Bornes CTA -->
  <section class="bornes-cta">
    <div class="bornes-cta-content">
      <div class="bornes-cta-text">
        <div class="section-eyebrow">Infrastructure</div>
        <h2 class="section-title">Bornes de recharge Exicom</h2>
        <p>Rechargez votre véhicule à domicile, au bureau ou en déplacement. EcoDrive propose une gamme complète de bornes murales et autonomes, adaptées à chaque besoin — du résidentiel au professionnel.</p>
        <a href="bornes/index.php" class="btn-primary">Découvrir nos bornes</a>
      </div>
      <figure class="bornes-cta-visual">
        <img src="images/bornes/borne-recharge.jpg" alt="Borne de recharge pour véhicule électrique installée sur un mur" loading="lazy" decoding="async" width="1092" height="675">
      </figure>
    </div>
  </section>

  <!-- Contact -->
  <section id="contact" class="contact-section">
    <div class="contact-left">
      <div class="section-eyebrow">Contact</div>
      <h2 class="section-title">Parlons de votre prochain véhicule</h2>
      <p>Notre équipe est disponible pour répondre à toutes vos questions et organiser votre essai gratuit.</p>
      <div class="contact-details">
        <div class="contact-item">
          <div class="contact-icon">📞</div>
          <div><div class="contact-label">Téléphone</div><div class="contact-value">+216 90 311 428</div></div>
        </div>
        <div class="contact-item">
          <div class="contact-icon">✉️</div>
          <div><div class="contact-label">Email</div><div class="contact-value">contact@ecodrive.tn</div></div>
        </div>
        <div class="contact-item">
          <div class="contact-icon">📍</div>
          <div><div class="contact-label">Adresse</div><div class="contact-value">123 Rue de la Liberté, Tunis</div></div>
        </div>
      </div>
    </div>

    <div class="contact-form">
      <!-- Pour l'admin : le formulaire public est remplacé par l'accès direct à la boîte de réception -->
      <?php if (($user['role'] ?? '') === 'admin'): ?>
        <div style="background:rgba(var(--blue-rgb),0.05);border:1px solid rgba(var(--blue-rgb),0.15);border-radius:var(--radius-lg);padding:1.5rem">
          <div style="font-size:.82rem;color:var(--gray);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.25rem">Espace administrateur</div>
          <div style="font-size:1.05rem;font-weight:400;color:var(--dark);margin-bottom:.5rem">Les messages des visiteurs arrivent ici.</div>
          <p style="color:var(--gray);font-size:.9rem;margin-bottom:1.25rem">Consultez, filtrez et exportez les messages reçus, les abonnés à la newsletter et les réservations depuis votre panneau d'administration.</p>
          <a href="php/admin.php?tab=messages" class="btn btn-primary">📨 Messages reçus</a>
          <a href="php/admin.php?tab=newsletter" class="btn btn-ghost">✉️ Newsletter</a>
        </div>
      <?php else: ?>
        <?php if ($contactMessage): ?>
          <div class="contact-success"><?= htmlspecialchars($contactMessage) ?></div>
        <?php endif; ?>
        <form action="index.php#contact" method="post">
          <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
          <input type="hidden" name="contact" value="1">
          <input type="text" name="name" placeholder="Votre nom complet"
                 value="<?= $prenom ?>" autocomplete="name" required />
          <input type="email" name="email" placeholder="Adresse e-mail"
                 value="<?= $email ?>" autocomplete="email" required />
          <input type="text" name="model" placeholder="Modèle qui vous intéresse" />
          <textarea name="message" placeholder="Votre message ou demande d'essai..." required></textarea>
          <button class="btn-primary" type="submit">Envoyer le message</button>
        </form>
      <?php endif; ?>
    </div>
  </section>

<?php $asset_base = ''; include 'php/partials/footer.php'; ?>


<?php
include 'php/bootstrap.php';
$user = $_SESSION['user'] ?? null;
$prenom = htmlspecialchars($user['prenom'] ?? 'Visiteur', ENT_QUOTES, 'UTF-8');
$email = htmlspecialchars($user['email'] ?? '', ENT_QUOTES, 'UTF-8');
$loggedIn = $user !== null;

$contactMessage = '';
$contactSuccess = false;

// Traitement du formulaire de contact
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact'])) {
    if (!csrf_verify($_POST['csrf_token'] ?? '')) { die('Session invalide.'); }
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $model   = trim($_POST['model'] ?? '');
    $message = trim($_POST['message'] ?? '');
    if ($name && $email && $message) {
      // Sanitize and prevent header injection
      $safeName = substr(preg_replace('/[\r\n]+/', ' ', $name), 0, 100);
      $subject = "Contact EcoDrive - " . $safeName;
      $body = "Nom: $safeName\nEmail: $email\nModèle: $model\n\nMessage:\n$message";

      // Use a fixed From header and set Reply-To only if the user email is valid
      $from = 'noreply@ecodrive.tn';
      $replyTo = filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : 'contact@ecodrive.tn';
      $headers = "From: EcoDrive <{$from}>\r\nReply-To: {$replyTo}\r\nX-Mailer: PHP/" . phpversion();

      $sent = @mail('contact@ecodrive.tn', $subject, $body, $headers);
      $contactSuccess = true;
      $contactMessage = $sent ? 'Message envoyé. Notre équipe vous répondra rapidement.' : 'Merci ! Votre message a bien été transmis.';
    } else {
        $contactMessage = 'Veuillez remplir tous les champs obligatoires.';
    }
}

// Récupérer les voitures vedettes pour l'accueil
$voitures = $conn->query("SELECT id_voiture, marque, modele, prix, image, details_page FROM voiture WHERE is_featured = 1 ORDER BY marque")->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') ?></title>
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E%26%23x26A1%3B%3C/text%3E%3C/svg%3E">
  <?php include __DIR__ . '/php/partials/meta.php'; ?>
  <link rel="stylesheet" href="css/style.css?v=18">
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
          <a href="#showroom" class="btn-primary cta">Explorer le catalogue</a>
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
          $img = htmlspecialchars(ltrim($v['image'] ?? 'images/placeholder.png', '/'), ENT_QUOTES, 'UTF-8');
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
      <a href="php/catalogue.php?brand=Tesla" class="brand-card">
        <div class="brand-logo">
          <svg viewBox="0 0 200 30" fill="currentColor"><text x="50%" y="24" text-anchor="middle" font-family="'Cormorant Garamond',serif" font-size="26" font-weight="600" letter-spacing="3">TESLA</text></svg>
        </div>
        <div class="brand-info">
          <span class="brand-count">2 modèles</span>
          <span class="brand-arrow">→</span>
        </div>
      </a>
      <a href="php/catalogue.php?brand=BMW" class="brand-card">
        <div class="brand-logo">
          <svg viewBox="0 0 200 30" fill="currentColor"><text x="50%" y="24" text-anchor="middle" font-family="'Cormorant Garamond',serif" font-size="26" font-weight="600" letter-spacing="3">BMW</text></svg>
        </div>
        <div class="brand-info">
          <span class="brand-count">1 modèle</span>
          <span class="brand-arrow">→</span>
        </div>
      </a>
      <a href="php/catalogue.php?brand=Mercedes" class="brand-card">
        <div class="brand-logo">
          <svg viewBox="0 0 200 30" fill="currentColor"><text x="50%" y="24" text-anchor="middle" font-family="'Cormorant Garamond',serif" font-size="22" font-weight="600" letter-spacing="2">MERCEDES-BENZ</text></svg>
        </div>
        <div class="brand-info">
          <span class="brand-count">2 modèles</span>
          <span class="brand-arrow">→</span>
        </div>
      </a>
      <a href="php/catalogue.php?brand=Porsche" class="brand-card">
        <div class="brand-logo">
          <svg viewBox="0 0 200 30" fill="currentColor"><text x="50%" y="24" text-anchor="middle" font-family="'Cormorant Garamond',serif" font-size="26" font-weight="600" letter-spacing="3">PORSCHE</text></svg>
        </div>
        <div class="brand-info">
          <span class="brand-count">1 modèle</span>
          <span class="brand-arrow">→</span>
        </div>
      </a>
    </div>
  </section>

  <!-- Bornes CTA -->
  <section class="bornes-cta">
    <div class="bornes-cta-content">
      <div class="bornes-cta-text">
        <div class="section-eyebrow">Infrastructure</div>
        <h2 class="section-title">Bornes de recharge Exicom</h2>
        <p>Rechargez votre véhicule à domicile, au bureau ou en déplacement. EcoDrive propose une gamme complète de bornes murales et autonomes, adaptées à chaque besoin — du résidentiel au professionnel.</p>
      </div>
      <a href="bornes/index.php" class="btn-primary">Découvrir nos bornes</a>
    </div>
  </section>

  <!-- About -->
  <section id="about" class="about-strip">
    <div class="about-visual" aria-hidden="true">
      <div class="about-logo">
        <div class="about-logo-icon">
          <svg width="64" height="64" viewBox="0 0 64 64" fill="none">
            <path d="M32 8C20 8 12 16 12 28C12 36 18 46 24 52L32 56L32 28C32 20 42 12 44 10C40 8 36 8 32 8Z" fill="#0A7DA8" opacity="0.85"/>
            <path d="M30 24V48M30 28L38 20M30 34L22 26" stroke="#0A7DA8" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
        <div class="about-logo-text">eco<span>drive</span></div>
      </div>
    </div>
    <div class="about-content">
      <div class="section-eyebrow">Notre mission</div>
      <h2 class="section-title">Un avenir plus vert pour la Tunisie</h2>
      <p class="about-text">
        Chez EcoDrive, nous croyons que la mobilité durable doit être accessible à tous.
        Notre mission est d'accélérer la transition vers le véhicule électrique en Tunisie,
        en proposant une expérience d'achat irréprochable et un accompagnement sur-mesure.
      </p>
      <div class="about-values">
        <div class="value-item"><div class="value-dot"></div><div class="value-text">Véhicules certifiés zéro émission</div></div>
        <div class="value-item"><div class="value-dot"></div><div class="value-text">Financement flexible disponible</div></div>
        <div class="value-item"><div class="value-dot"></div><div class="value-text">Service après-vente dédié</div></div>
        <div class="value-item"><div class="value-dot"></div><div class="value-text">Installation de borne à domicile</div></div>
      </div>
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
      <!-- Formulaire PHP avec pré-remplissage automatique -->
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
    </div>
  </section>

<?php $asset_base = ''; include 'php/partials/footer.php'; ?>

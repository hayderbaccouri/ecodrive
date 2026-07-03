
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

// Récupérer les 3 voitures vedettes pour l'accueil
$voitures = $conn->query("SELECT id_voiture, marque, modele, prix, image, details_page FROM voiture WHERE id_voiture IN (2,1,8) ORDER BY id_voiture")->fetch_all(MYSQLI_ASSOC);
// Compter le nombre total de modèles dans le catalogue
$totalModeles = (int) $conn->query("SELECT COUNT(*) AS c FROM voiture")->fetch_assoc()['c'];
$conn->close();
?>
<!DOCTYPE html>
<html lang="fr">

<?php $asset_base = ''; include 'php/partials/header.php'; ?>

  <!-- Hero -->
  <section class="hero" aria-label="Présentation EcoDrive">
    <div class="hero-inner">
      <div class="hero-content">
      <div class="hero-eyebrow">Mobilité durable · Tunisie</div>

      <h1 class="hero-title">
        L'avenir de la route, <strong>sans émissions.</strong>
      </h1>

      <p class="hero-desc">
        EcoDrive est le premier showroom spécialisé en véhicules électriques en Tunisie.
        Découvrez une sélection premium, testez avant d'acheter, et rejoignez la révolution verte.
      </p>

      <div class="hero-actions">
        <a href="#showroom" class="btn-primary cta">Explorer le catalogue</a>
        <a href="php/inscription.php" class="btn-ghost">S'inscrire</a>
      </div>

      <div class="hero-cta-banner">
        <p>Prêt pour un essai ? Réservez un test drive directement depuis votre espace client.</p>
        <a href="<?= $loggedIn ? 'php/reservation.php' : 'php/connexion.php' ?>" class="btn-ghost"><?= $loggedIn ? 'Voir mes essais' : 'Se connecter pour réserver' ?></a>
      </div>
    </div>

    <div class="hero-visual" aria-hidden="true">
      <div class="hero-visual-bg"></div>
      <div class="hero-visual-grid"></div>
      <div class="hero-visual-glow"></div>

      <div class="hero-car-placeholder">
        <div class="hero-car-title">Découvrez les nouvelles voitures électriques 2026</div>
        <div class="hero-car-icon">
          <?php $hero = $voitures[0] ?? null; ?>
          <img src="<?= $hero ? htmlspecialchars(ltrim($hero['image'], '/')) : 'images/Mercedes-Benz-Classe-C-2026.jpg' ?>" alt="Véhicule EcoDrive" loading="lazy">
        </div>
        <div class="hero-stats">
          <div class="hero-stat">
            <div class="hero-stat-value">100%</div>
            <div class="hero-stat-label">Électrique</div>
          </div>
          <div class="hero-stat">
            <div class="hero-stat-value">0</div>
            <div class="hero-stat-label">Émissions CO<sub>2</sub></div>
          </div>
          <div class="hero-stat">
            <div class="hero-stat-value">+<?= $totalModeles ?></div>
            <div class="hero-stat-label">Modèles électriques</div>
          </div>
        </div>
      </div>
      <div class="hero-car-subtitle">Dernière arrivée : <?= $hero ? htmlspecialchars($hero['marque'] . ' ' . $hero['modele']) : 'Tesla Model 3' ?></div>
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

  <!-- Bornes de recharge -->
  <section id="bornes" class="bornes-section">
    <div class="section-header section-header--tight">
      <div class="section-eyebrow">Infrastructure</div>
      <h2 class="section-title">Bornes de recharge</h2>
      <div class="section-rule"></div>
    </div>

    <p class="bornes-intro">
      Rechargez partout, en toute confiance. EcoDrive propose une gamme complète de bornes Exicom
      adaptées à chaque usage — domicile, bureau ou flotte.
    </p>

    <div class="bornes-grid">
      <a class="borne-card" href="bornes/ExicomSpinFree3kW.php">
        <img src="images/bornes/SPIN-FREE-3.png" alt="Borne 3 kW" class="borne-image" loading="lazy" />
        <div><span class="borne-power">3</span><span class="borne-unit"> kW</span></div>
        <div class="borne-name">Exicom Spin Free</div>
        <p class="borne-desc">Chargeur portable compact pour recharge d'appoint et déplacements. Câble 5 m, compatible Type 2.</p>
        <div class="borne-price">1 290 DT</div>
        <div class="borne-tag">Portable</div>
      </a>

      <a class="borne-card" href="bornes/ExicomSpinAir7kW.php">
        <img src="images/bornes/SPIN-AIR-11 (2).png" alt="Borne 7.4 kW" class="borne-image" loading="lazy" />
        <div><span class="borne-power">7.4</span><span class="borne-unit"> kW</span></div>
        <div class="borne-name">Exicom Spin Air</div>
        <p class="borne-desc">Chargeur monophasé pour recharge résidentielle quotidienne avec contrôle intelligent.</p>
        <div class="borne-price">2 490 DT</div>
        <div class="borne-tag">Résidentiel</div>
      </a>

      <a class="borne-card" href="bornes/ExicomSpinAir11kW.php">
        <img src="images/bornes/SPIN-AIR-11.png" alt="Borne 11 kW" class="borne-image" loading="lazy" />
        <div><span class="borne-power">11</span><span class="borne-unit"> kW</span></div>
        <div class="borne-name">Exicom Spin Air</div>
        <p class="borne-desc">Solution triphasée pour maisons, bureaux et parkings privés avec usage régulier.</p>
        <div class="borne-price">3 290 DT</div>
        <div class="borne-tag">Semi-professionnel</div>
      </a>

      <a class="borne-card" href="bornes/ExicomSpinAir22kW.php">
        <img src="images/bornes/SPIN-AIR-11 (2).png" alt="Borne 22 kW" class="borne-image" loading="lazy" />
        <div><span class="borne-power">22</span><span class="borne-unit"> kW</span></div>
        <div class="borne-name">Exicom Spin Air</div>
        <p class="borne-desc">Chargeur haute puissance pour flottes, entreprises et sites à plusieurs utilisateurs.</p>
        <div class="borne-price">4 490 DT</div>
        <div class="borne-tag">Professionnel</div>
      </a>
    </div>
  </section>

  <!-- About -->
  <section id="about" class="about-strip">
    <div class="about-visual" aria-hidden="true">🌿</div>
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

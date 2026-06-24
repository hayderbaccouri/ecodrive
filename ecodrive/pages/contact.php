<?php
session_start();
$loggedIn = isset($_SESSION['user']);

$success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $phone = trim($_POST['phone'] ?? '');
  $subject = trim($_POST['subject'] ?? '');
  $message = trim($_POST['message'] ?? '');

  if ($name && $email && $subject && $message) {
    $to = 'contact@ecodrive.tn';
    $headers = 'From: ' . $email . "\r\n" .
               'Reply-To: ' . $email . "\r\n" .
               'X-Mailer: PHP/' . phpversion();
    $emailSubject = '[EcoDrive] ' . $subject . ' - ' . $name;
    $body = "Nom: $name\nEmail: $email\nTéléphone: $phone\nSujet: $subject\n\nMessage:\n$message";
    mail($to, $emailSubject, $body, $headers);
    $success = true;
  }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact - EcoDrive</title>
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E%26%23x26A1%3B%3C/text%3E%3Csvg%3E">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link
    href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600&family=DM+Sans:wght@300;400;500&display=swap"
    rel="stylesheet">
  <style>
    *,
    *::before,
    *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    :root {
      --black: #0b0c0e;
      --off-black: #111316;
      --surface: #181b20;
      --border: rgba(255, 255, 255, 0.07);
      --accent: #00e5a0;
      --accent-dim: rgba(0, 229, 160, 0.10);
      --white: #ffffff;
      --grey-1: #c4c9d4;
      --grey-2: #767d8a;
      --grey-3: #363b44;
      --font-display: 'Cormorant Garamond', Georgia, serif;
      --font-body: 'DM Sans', system-ui, sans-serif;
      --wrap: clamp(1.25rem, 5vw, 4.5rem);
      --max: 1200px;
    }

    html {
      scroll-behavior: smooth;
    }

    body {
      font-family: var(--font-body);
      background: var(--black);
      color: var(--grey-1);
      -webkit-font-smoothing: antialiased;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      line-height: 1.6;
    }

    a {
      text-decoration: none;
      color: inherit;
    }

    img {
      display: block;
      max-width: 100%;
    }

    /* Header */
    header {
      position: sticky;
      top: 0;
      z-index: 100;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 1rem var(--wrap);
      background: rgba(11, 12, 14, 0.88);
      backdrop-filter: blur(14px);
      -webkit-backdrop-filter: blur(14px);
      border-bottom: 1px solid var(--border);
    }

    .logo-text {
      font-family: var(--font-display);
      font-size: 1.6rem;
      font-weight: 300;
      color: var(--white);
      letter-spacing: 0.02em;
    }

    .logo-text span {
      color: var(--accent);
    }

    header nav {
      display: flex;
      align-items: center;
      gap: 2rem;
    }

    header nav a {
      font-size: 0.84rem;
      font-weight: 400;
      color: var(--grey-2);
      letter-spacing: 0.03em;
      transition: color 0.2s;
    }

    header nav a:hover {
      color: var(--white);
    }

    .nav-cta {
      background: var(--accent) !important;
      color: var(--black) !important;
      font-weight: 600 !important;
      padding: 0.42rem 1.1rem;
      border-radius: 5px;
      transition: opacity 0.2s !important;
    }

    .nav-cta:hover {
      opacity: 0.85;
      color: var(--black) !important;
    }

    /* Main content */
    .container {
      flex: 1;
      max-width: var(--max);
      width: 100%;
      margin: 0 auto;
      padding: 3rem var(--wrap);
    }

    .container h1 {
      font-family: var(--font-display);
      font-size: clamp(2rem, 4vw, 3rem);
      font-weight: 400;
      color: var(--white);
      margin-bottom: 0.5rem;
      letter-spacing: 0.02em;
    }

    .subtitle {
      font-size: 1rem;
      color: var(--grey-2);
      margin-bottom: 2rem;
      line-height: 1.6;
    }

    .contact-wrapper {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 3rem;
      margin-top: 2rem;
    }

    /* Contact form */
    .contact-form-section {
      display: flex;
      flex-direction: column;
      gap: 1.25rem;
    }

    .form-group {
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
    }

    .form-group label {
      font-weight: 600;
      font-size: 0.9rem;
      color: var(--white);
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
      background: rgba(255, 255, 255, 0.02);
      border: 1px solid var(--border);
      border-radius: 8px;
      padding: 0.75rem 1rem;
      color: var(--grey-1);
      font-family: var(--font-body);
      font-size: 0.95rem;
      outline: none;
      transition: border-color 0.2s, box-shadow 0.2s;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
      border-color: var(--accent);
      box-shadow: 0 0 0 3px rgba(0, 229, 160, 0.08);
    }

    .form-group textarea {
      resize: vertical;
      min-height: 140px;
    }

    .form-submit {
      background: var(--accent);
      color: var(--black);
      border: none;
      padding: 0.85rem 1.5rem;
      border-radius: 8px;
      font-weight: 600;
      font-size: 0.95rem;
      cursor: pointer;
      transition: opacity 0.2s, transform 0.15s;
      align-self: flex-start;
    }

    .form-submit:hover {
      opacity: 0.9;
      transform: translateY(-1px);
    }

    .form-submit:active {
      transform: translateY(0);
    }

    /* Contact info */
    .contact-info {
      display: flex;
      flex-direction: column;
      gap: 2rem;
    }

    .info-card {
      background: rgba(255, 255, 255, 0.02);
      border: 1px solid var(--border);
      border-radius: 12px;
      padding: 1.5rem;
      transition: border-color 0.2s, background 0.2s;
    }

    .info-card:hover {
      background: rgba(255, 255, 255, 0.04);
      border-color: rgba(0, 229, 160, 0.2);
    }

    .info-card-icon {
      font-size: 2rem;
      margin-bottom: 0.75rem;
    }

    .info-card h3 {
      font-size: 1rem;
      font-weight: 600;
      color: var(--white);
      margin-bottom: 0.5rem;
    }

    .info-card p {
      font-size: 0.9rem;
      color: var(--grey-2);
      line-height: 1.6;
    }

    .info-card a {
      color: var(--accent);
      font-weight: 500;
    }

    .info-card a:hover {
      text-decoration: underline;
    }

    .social-links {
      display: flex;
      gap: 1rem;
      margin-top: 1rem;
    }

    .social-links a {
      width: 40px;
      height: 40px;
      background: rgba(0, 229, 160, 0.1);
      border: 1px solid rgba(0, 229, 160, 0.2);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.1rem;
      transition: background 0.2s, border-color 0.2s;
    }

    .social-links a:hover {
      background: rgba(0, 229, 160, 0.2);
      border-color: var(--accent);
    }

    /* Map section */
    .map-section {
      margin-top: 3rem;
      background: rgba(255, 255, 255, 0.02);
      border: 1px solid var(--border);
      border-radius: 12px;
      overflow: hidden;
      height: 400px;
    }

    .map-placeholder {
      width: 100%;
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      gap: 1rem;
    }

    .map-placeholder p {
      color: var(--grey-2);
      text-align: center;
    }

    /* Success message */
    .success-message {
      display: none;
      background: rgba(0, 229, 160, 0.1);
      border: 1px solid rgba(0, 229, 160, 0.3);
      border-radius: 8px;
      padding: 1rem;
      color: var(--accent);
      margin-bottom: 1rem;
      text-align: center;
    }

    .success-message.show {
      display: block;
      animation: slideIn 0.3s ease;
    }

    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Footer */
    footer {
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 1rem;
      padding: 1.75rem var(--wrap);
      border-top: 1px solid var(--border);
      font-size: 0.78rem;
      color: var(--grey-3);
    }

    .footer-logo {
      font-family: var(--font-display);
      font-size: 1.3rem;
      font-weight: 300;
      color: var(--white);
    }

    .footer-logo span {
      color: var(--accent);
    }

    footer nav {
      display: flex;
      gap: 1.75rem;
    }

    footer nav a {
      color: rgba(255, 255, 255, 0.35);
      text-decoration: none;
      font-size: 0.72rem;
      letter-spacing: 0.05em;
      transition: color 0.2s;
    }

    footer nav a:hover {
      color: rgba(255, 255, 255, 0.7);
    }

    @media (max-width: 900px) {
      .contact-wrapper {
        grid-template-columns: 1fr;
      }
    }

    @media (max-width: 700px) {
      header {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.75rem;
      }

      header nav {
        gap: 1rem;
        flex-wrap: wrap;
      }

      .container {
        padding: 2rem 1.5rem;
      }

      .map-section {
        height: 300px;
      }

      footer {
        flex-direction: column;
        text-align: center;
      }

      footer nav {
        justify-content: center;
      }
    }
  </style>
</head>

<body>

  <!-- Header -->
  <header>
    <a href="../index.php" style="text-decoration:none">
      <div class="logo-text">eco<span>drive</span></div>
    </a>
    <nav>
      <a href="../index.php">Accueil</a>
      <a href="../php/catalogue.php">Catalogue</a>
      <?php if ($loggedIn): ?>
        <a href="../php/<?= ($_SESSION['user']['role'] ?? 'client') === 'admin' ? 'admin.php' : 'tableau-de-bord.php' ?>">Mon espace</a>
        <a href="../php/deconnexion.php">Déconnexion</a>
      <?php else: ?>
        <a href="../php/connexion.php">Connexion / Inscription</a>
      <?php endif; ?>
      <a href="contact.php">Contact</a>
    </nav>
  </header>

  <!-- Main content -->
  <div class="container">
    <h1>Contactez-nous</h1>
    <p class="subtitle">
      Nous sommes ici pour répondre à vos questions, vos demandes et vos suggestions.
      Remplissez le formulaire ci-dessous ou utilisez l'une de nos coordonnées de contact.
    </p>

    <div id="successMessage" class="success-message <?= $success ? 'show' : '' ?>">
      ✓ Merci ! Votre message a été envoyé avec succès. Nous vous répondrons au plus vite.
    </div>

    <div class="contact-wrapper">
      <!-- Contact Form -->
      <div class="contact-form-section">
        <h2 style="font-family: var(--font-display); font-size: 1.3rem; color: var(--white); margin-bottom: 1.5rem;">
          Envoyez-nous un message</h2>

        <form id="contactForm" method="post" action="contact.php">
          <div class="form-group">
            <label for="name">Nom complet *</label>
            <input type="text" id="name" name="name" required placeholder="Votre nom">
          </div>

          <div class="form-group">
            <label for="email">Adresse e-mail *</label>
            <input type="email" id="email" name="email" required placeholder="votre@email.com">
          </div>

          <div class="form-group">
            <label for="phone">Numéro de téléphone</label>
            <input type="tel" id="phone" name="phone" placeholder="+216 XX XXX XXX">
          </div>

          <div class="form-group">
            <label for="subject">Sujet *</label>
            <select id="subject" name="subject" required>
              <option value="">-- Sélectionnez un sujet --</option>
              <option value="general">Question générale</option>
              <option value="catalogue">Informations sur le catalogue</option>
              <option value="bornes">Informations sur les bornes</option>
              <option value="account">Compte utilisateur</option>
              <option value="technical">Problème technique</option>
              <option value="feedback">Retour/Suggestion</option>
              <option value="partnership">Partenariat</option>
            </select>
          </div>

          <div class="form-group">
            <label for="message">Message *</label>
            <textarea id="message" name="message" required
              placeholder="Décrivez votre question ou demande..."></textarea>
          </div>

          <button type="submit" class="form-submit">Envoyer le message</button>
        </form>
      </div>

      <!-- Contact Information -->
      <div class="contact-info">
        <h2 style="font-family: var(--font-display); font-size: 1.3rem; color: var(--white); margin-bottom: 1.5rem;">Nos
          coordonnées</h2>

        <div class="info-card">
          <div class="info-card-icon">📧</div>
          <h3>E-mail</h3>
          <p>Pour toute demande générale, n'hésitez pas à nous envoyer un e-mail :</p>
          <p style="margin-top: 0.75rem;">
            <a href="mailto:contact@ecodrive.tn">contact@ecodrive.tn</a>
          </p>
          <p style="font-size: 0.8rem; color: var(--grey-3); margin-top: 0.5rem;">
            Réponse sous 24h maximum
          </p>
        </div>

        <div class="info-card">
          <div class="info-card-icon">📱</div>
          <h3>Téléphone</h3>
          <p>Appelez-nous pendant les heures de bureau :</p>
          <p style="margin-top: 0.75rem;">
            <a href="tel:+21650123456">+216 50 123 456</a>
          </p>
          <p style="font-size: 0.8rem; color: var(--grey-3); margin-top: 0.5rem;">
            Lun-Ven : 9h-18h | Sam : 10h-14h
          </p>
        </div>

        <div class="info-card">
          <div class="info-card-icon">📍</div>
          <h3>Adresse</h3>
          <p>EcoDrive<br>
            Showroom Électrique<br>
            Tunis, Tunisie</p>
          <p style="margin-top: 0.75rem;">
            <a href="#">Voir sur la carte</a>
          </p>
        </div>

        <div class="info-card">
          <div class="info-card-icon">⏰</div>
          <h3>Heures d'ouverture</h3>
          <p>
            <strong>Lundi - Vendredi :</strong> 9h00 - 18h00<br>
            <strong>Samedi :</strong> 10h00 - 14h00<br>
            <strong>Dimanche :</strong> Fermé
          </p>
        </div>

        <div class="info-card">
          <h3>Suivez-nous</h3>
          <p>Restez connecté et suivez nos actualités :</p>
          <div class="social-links">
            <a href="#" title="Facebook">f</a>
            <a href="#" title="Twitter">𝕏</a>
            <a href="#" title="Instagram">📷</a>
            <a href="#" title="LinkedIn">in</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Map Section -->
    <div class="map-section">
      <div class="map-placeholder">
        <div style="font-size: 2.5rem;">🗺️</div>
        <p>Carte interactive en cours de développement<br><small>Vous serez bientôt en mesure de nous localiser
            facilement</small></p>
      </div>
    </div>

  </div>

  <!-- Footer -->
  <footer>
    <div class="footer-logo">eco<span>drive</span></div>
    <span>© 2026 EcoDrive. Tous droits réservés.</span>
    <nav>
      <a href="mentions-legales.php">Mentions légales</a>
      <a href="confidentialite.php">Confidentialité</a>
      <a href="contact.php">Contact</a>
    </nav>
  </footer>

  <script>
    // Auto-hide success message after 6 seconds
    const el = document.getElementById('successMessage');
    if (el.classList.contains('show')) {
      setTimeout(() => el.classList.remove('show'), 6000);
    }
  </script>

</body>

</html>

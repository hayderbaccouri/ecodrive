<?php
session_start();
$loggedIn = isset($_SESSION['user']);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mentions Légales - EcoDrive</title>
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E%26%23x26A1%3B%3C/text%3E%3C/svg%3E">
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
      margin-bottom: 2rem;
      letter-spacing: 0.02em;
    }

    .content-section {
      margin-bottom: 2.5rem;
      padding-bottom: 2rem;
      border-bottom: 1px solid var(--border);
    }

    .content-section:last-child {
      border-bottom: none;
    }

    .content-section h2 {
      font-family: var(--font-display);
      font-size: 1.4rem;
      font-weight: 400;
      color: var(--accent);
      margin-bottom: 1rem;
      letter-spacing: 0.01em;
    }

    .content-section h3 {
      font-size: 1rem;
      font-weight: 600;
      color: var(--white);
      margin-top: 1.2rem;
      margin-bottom: 0.5rem;
    }

    .content-section p {
      font-size: 0.95rem;
      color: var(--grey-2);
      line-height: 1.75;
      margin-bottom: 0.75rem;
    }

    .content-section ul,
    .content-section ol {
      margin-left: 1.5rem;
      margin-bottom: 1rem;
      color: var(--grey-2);
      font-size: 0.95rem;
      line-height: 1.75;
    }

    .content-section li {
      margin-bottom: 0.5rem;
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
    <h1>Mentions Légales</h1>

    <div class="content-section">
      <h2>Éditeur du site</h2>
      <h3>EcoDrive — Premier Showroom Électrique de Tunisie</h3>
      <p><strong>Nom du responsable :</strong> Hayder Baccouri</p>
      <p><strong>Type :</strong> Projet de fin de formation — Année 2026</p>
      <p><strong>Objet :</strong> Plateforme de présentation et de commercialisation de véhicules électriques en
        Tunisie.</p>
    </div>

    <div class="content-section">
      <h2>Caractéristiques du site</h2>
      <h3>Description générale</h3>
      <p>EcoDrive est un showroom électrique en ligne offrant un catalogue complet de véhicules électriques et de
        solutions de recharge. Le site propose la visualisation de nos produits, des informations détaillées et une
        interface utilisateur dédiée à l'expérience client.</p>

      <h3>Fonctionnalités principales</h3>
      <ul>
        <li>Catalogue interactif de voitures électriques</li>
        <li>Présentation des bornes de recharge</li>
        <li>Inscription et connexion utilisateur</li>
        <li>Recherche et filtrage des produits</li>
        <li>Formulaires de contact et d'intérêt</li>
      </ul>
    </div>

    <div class="content-section">
      <h2>Propriété intellectuelle</h2>
      <p>Tous les contenus présents sur ce site (textes, images, logos, vidéos, icônes, structure, mise en page, code
        source) sont la propriété exclusive ou sont utilisés avec autorisation. Toute reproduction, distribution,
        modification ou utilisation sans autorisation est strictement interdite.</p>

      <p><strong>© 2026 EcoDrive. Tous droits réservés.</strong></p>

      <h3>Utilisation autorisée</h3>
      <p>Vous êtes autorisé à consulter et télécharger des copies pour votre usage personnel et non commercial
        uniquement.</p>
    </div>

    <div class="content-section">
      <h2>Responsabilité de l'hébergeur</h2>
      <p>Ce site est hébergé sur un serveur local (XAMPP) à des fins éducatives et de formation. L'hébergeur ne peut
        être tenu responsable des interruptions d'accès, des pertes de données ou des dommages directs ou indirects
        résultant de l'accès à ce site.</p>
    </div>

    <div class="content-section">
      <h2>Liens externes</h2>
      <p>Ce site peut contenir des liens vers d'autres sites web. EcoDrive n'est pas responsable du contenu de ces sites
        externes. L'inclusion de liens ne constitue pas une endorsement.</p>
    </div>

    <div class="content-section">
      <h2>Données personnelles et protection</h2>
      <h3>Collecte de données</h3>
      <p>Le site peut collecter les informations suivantes :</p>
      <ul>
        <li>Nom et prénom</li>
        <li>Adresse e-mail</li>
        <li>Mot de passe (haché et sécurisé)</li>
        <li>Historique de navigation</li>
        <li>Informations de formulaires</li>
      </ul>

      <h3>Utilisation des données</h3>
      <p>Les données personnelles collectées sont utilisées uniquement pour :</p>
      <ul>
        <li>Gérer votre compte utilisateur</li>
        <li>Améliorer l'expérience utilisateur</li>
        <li>Envoyer des communications pertinentes</li>
        <li>Analyser les statistiques d'utilisation</li>
      </ul>

      <h3>Sécurité</h3>
      <p>EcoDrive s'engage à protéger vos données personnelles. Cependant, aucune transmission sur Internet n'est
        totalement sécurisée. Vous utilisez ce site à vos risques et périls.</p>
    </div>

    <div class="content-section">
      <h2>Cookies</h2>
      <p>Ce site peut utiliser des cookies pour améliorer votre expérience de navigation. Les cookies sont de petits
        fichiers stockés sur votre appareil. Vous pouvez désactiver les cookies via les paramètres de votre navigateur.
      </p>
    </div>

    <div class="content-section">
      <h2>Limitations de responsabilité</h2>
      <p>Le site est fourni « tel quel » sans garantie d'aucune sorte, expresse ou implicite. EcoDrive ne garantit pas :
      </p>
      <ul>
        <li>L'exactitude, l'exhaustivité ou la fiabilité des contenus</li>
        <li>L'absence d'interruption ou d'erreurs</li>
        <li>La conformité aux besoins spécifiques de l'utilisateur</li>
        <li>L'absence de virus ou de codes malveillants</li>
      </ul>

      <p>En aucun cas, EcoDrive ne sera responsable de dommages directs, indirects, accidentels, spéciaux ou consécutifs
        résultant de l'utilisation ou de l'impossibilité d'utiliser ce site.</p>
    </div>

    <div class="content-section">
      <h2>Conditions d'utilisation</h2>
      <h3>Conformité légale</h3>
      <p>En accédant et en utilisant ce site, vous acceptez de vous conformer à toutes les lois et réglementations
        applicables en Tunisie et internationalement.</p>

      <h3>Comportement interdit</h3>
      <p>Il est strictement interdit de :</p>
      <ul>
        <li>Accéder au site de manière non autorisée</li>
        <li>Utiliser le site pour des activités illégales</li>
        <li>Transmettre des virus ou codes malveillants</li>
        <li>Harceler ou menacer d'autres utilisateurs</li>
        <li>Reproduire, distribuer ou modifier le contenu sans autorisation</li>
        <li>Surcharger les serveurs avec des requêtes automatiques</li>
      </ul>
    </div>

    <div class="content-section">
      <h2>Modifications des conditions</h2>
      <p>EcoDrive se réserve le droit de modifier ces mentions légales à tout moment. Les modifications entrent en
        vigueur dès leur publication sur le site. Votre utilisation continue du site après les modifications constitue
        votre acceptation des nouvelles conditions.</p>
    </div>

    <div class="content-section">
      <h2>Droit applicable et juridiction</h2>
      <p>Ces mentions légales sont régies par les lois de la Tunisie. Tout litige ou différend découlant de ces
        conditions sera soumis à la juridiction exclusive des tribunaux tunisiens.</p>
    </div>

    <div class="content-section">
      <h2>Contact</h2>
      <h3>Pour toute question concernant ces mentions légales :</h3>
      <p><strong>Email :</strong> <a href="mailto:info@ecodrive.tn" style="color: var(--accent);">info@ecodrive.tn</a>
      </p>
      <p><strong>Formulaire de contact :</strong> Accessible via la <a href="contact.php"
          style="color: var(--accent);">page d'accueil</a></p>

      <h3>Responsable du projet</h3>
      <p><strong>Nom :</strong> Hayder Baccouri</p>
      <p><strong>Formation :</strong> Projet de fin de formation 2026</p>
      <p><strong>Date de mise à jour :</strong> 13 juin 2026</p>
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

</body>

</html>

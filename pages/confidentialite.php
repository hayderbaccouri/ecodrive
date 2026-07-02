<?php
session_start();
$loggedIn = isset($_SESSION['user']);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Confidentialité - EcoDrive</title>
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E%26%23x26A1%3B%3C/text%3E%3C/svg%3E">
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

    .highlight {
      background: rgba(0, 229, 160, 0.08);
      padding: 1rem;
      border-left: 3px solid var(--accent);
      border-radius: 4px;
      margin: 1rem 0;
    }

    .highlight p {
      margin: 0;
      font-weight: 500;
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
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/header.css" />
</head>

<body>

  <header class="site-header">
    <a href="../index.php" class="logo-text">eco<span>drive</span></a>
    <nav>
      <a href="../index.php">Accueil</a>
      <a href="../php/catalogue.php">Catalogue</a>
      <a href="../index.php#bornes">Bornes</a>
      <a href="contact.php">Contact</a>
      <?php if ($loggedIn): ?>
        <?php $prenom = explode(' ', $_SESSION['user']['nom'] ?? 'Client')[0]; $initial = mb_strtoupper(mb_substr($prenom, 0, 1)); $dashPage = '../php/' . (($_SESSION['user']['role'] ?? 'client') === 'admin' ? 'admin.php' : 'tableau-de-bord.php'); ?>
        <div class="user-menu">
          <div class="user-badge">
            <div class="avatar"><?= $initial ?></div>
            <span class="user-name"><?= htmlspecialchars($prenom) ?></span>
            <span class="chevron">▾</span>
          </div>
          <div class="user-dropdown">
            <a href="<?= $dashPage ?>">Mon espace</a>
            <hr>
            <a href="../php/deconnexion.php" class="logout">Déconnexion</a>
          </div>
        </div>
      <?php else: ?>
        <a href="../php/connexion.php">Se connecter</a>
        <a href="../php/inscription.php" class="nav-cta">S'inscrire</a>
      <?php endif; ?>
      <button class="burger" aria-label="Menu" onclick="this.classList.toggle('open');document.querySelector('.site-header nav').classList.toggle('open')"><span></span><span></span><span></span></button>
    </nav>
  </header>

  <!-- Main content -->
  <div class="container">
    <h1>Politique de Confidentialité</h1>

    <p style="color: var(--grey-2); font-size: 0.9rem; margin-bottom: 2rem;">
      <strong>Date d'entrée en vigueur :</strong> 13 juin 2026 |
      <strong>Dernière mise à jour :</strong> 13 juin 2026
    </p>

    <div class="content-section">
      <h2>Introduction</h2>
      <p>EcoDrive (« nous », « notre » ou « nos ») s'engage à protéger votre vie privée. Cette Politique de
        Confidentialité explique comment nous collectons, utilisons, divulguons et protégeons vos informations lorsque
        vous utilisez notre site web et nos services.</p>

      <div class="highlight">
        <p>🔒 Votre confidentialité est notre priorité. Nous nous engageons à respecter vos données personnelles
          conformément aux meilleures pratiques internationales.</p>
      </div>
    </div>

    <div class="content-section">
      <h2>1. Informations que nous collectons</h2>

      <h3>1.1 Informations fournies directement par vous</h3>
      <p>Nous collectons les informations que vous nous fournissez volontairement, notamment :</p>
      <ul>
        <li><strong>Données d'inscription :</strong> Nom complet, adresse email, mot de passe (haché et sécurisé)</li>
        <li><strong>Données de profil :</strong> Numéro de téléphone, adresse, préférences véhicules</li>
        <li><strong>Données de contact :</strong> Messages via formulaires, e-mails de support</li>
        <li><strong>Données de paiement :</strong> Informations de facturation (traitées via prestataires sécurisés)
        </li>
      </ul>

      <h3>1.2 Informations collectées automatiquement</h3>
      <p>Lors de votre navigation, nous collectons :</p>
      <ul>
        <li><strong>Données de navigation :</strong> Pages visitées, durée des visites, actions effectuées</li>
        <li><strong>Informations techniques :</strong> Adresse IP, type de navigateur, système d'exploitation,
          résolution d'écran</li>
        <li><strong>Données de localisation :</strong> Région/pays (via adresse IP uniquement)</li>
        <li><strong>Cookies et technologies similaires :</strong> Identifiants uniques, préférences utilisateur</li>
      </ul>

      <h3>1.3 Informations de tiers</h3>
      <p>Nous ne recevons pas d'informations de tiers, sauf en cas de partenariat explicite communiqué aux utilisateurs.
      </p>
    </div>

    <div class="content-section">
      <h2>2. Comment nous utilisons vos informations</h2>
      <p>Nous utilisons vos données personnelles pour les finalités suivantes :</p>

      <ul>
        <li><strong>Gérer votre compte :</strong> Créer, maintenir et sécuriser votre compte utilisateur</li>
        <li><strong>Fournir nos services :</strong> Afficher le catalogue, traiter les demandes, envoyer des
          confirmations</li>
        <li><strong>Améliorer notre site :</strong> Analyser l'utilisation, optimiser l'expérience utilisateur</li>
        <li><strong>Communications :</strong> Envoyer des notifications, newsletters (avec consentement) et informations
          de support</li>
        <li><strong>Sécurité et conformité :</strong> Prévenir la fraude, détecter les abus, respecter les obligations
          légales</li>
        <li><strong>Personnalisation :</strong> Adapter le contenu à vos préférences et historique</li>
        <li><strong>Recherche et développement :</strong> Améliorer nos produits et services</li>
      </ul>

      <h3>Base légale du traitement</h3>
      <p>Nous traitons vos données sur la base de :</p>
      <ul>
        <li><strong>Consentement :</strong> Pour la plupart des traitements, avec opt-out facile</li>
        <li><strong>Exécution de contrat :</strong> Pour gérer votre compte et nos services</li>
        <li><strong>Obligations légales :</strong> Conformité aux lois tunisiennes et internationales</li>
        <li><strong>Intérêt légitime :</strong> Amélioration de nos services et sécurité</li>
      </ul>
    </div>

    <div class="content-section">
      <h2>3. Partage de vos informations</h2>

      <h3>3.1 Avec qui nous partageons vos données</h3>
      <p>Vos informations ne sont partagées que dans les cas suivants :</p>
      <ul>
        <li><strong>Prestataires de services :</strong> Hébergeurs, fournisseurs de paiement, services d'email (liés par
          des contrats confidentiels)</li>
        <li><strong>Autorités légales :</strong> Si exigé par la loi ou pour protéger nos droits</li>
        <li><strong>Partenaires commerciaux :</strong> Uniquement avec votre consentement explicite</li>
      </ul>

      <h3>3.2 Pas de vente de données</h3>
      <p>Nous ne vendons, n'échangeons et ne louons jamais vos données personnelles à des tiers à des fins de marketing
        sans votre consentement préalable explicite.</p>
    </div>

    <div class="content-section">
      <h2>4. Sécurité de vos données</h2>

      <p>Nous mettons en œuvre des mesures de sécurité techniques et organisationnelles pour protéger vos informations :
      </p>
      <ul>
        <li><strong>Chiffrement :</strong> Les mots de passe sont hachés avec des algorithmes sécurisés</li>
        <li><strong>HTTPS :</strong> Les données en transit sont protégées par le protocole HTTPS</li>
        <li><strong>Accès restreint :</strong> Seuls les membres autorisés de l'équipe ont accès aux données sensibles
        </li>
        <li><strong>Pare-feu et antivirus :</strong> Protection contre les intrusions et malwares</li>
        <li><strong>Sauvegardes régulières :</strong> Protection contre la perte de données</li>
      </ul>

      <div class="highlight">
        <p><strong>⚠️ Aucune garantie absolue :</strong> Malgré nos efforts, aucune transmission sur Internet n'est 100%
          sécurisée. Vous utilisez ce site à vos risques et périls.</p>
      </div>
    </div>

    <div class="content-section">
      <h2>5. Cookies et technologies de suivi</h2>

      <h3>5.1 Qu'est-ce qu'un cookie ?</h3>
      <p>Un cookie est un petit fichier stocké sur votre appareil qui aide à mémoriser vos préférences et à améliorer
        votre expérience.</p>

      <h3>5.2 Types de cookies utilisés</h3>
      <ul>
        <li><strong>Cookies essentiels :</strong> Authentification, sécurité, fonctionnalité du site</li>
        <li><strong>Cookies de performance :</strong> Analyse des visites, optimisation</li>
        <li><strong>Cookies de préférences :</strong> Mémorisation de vos choix (thème, langue)</li>
        <li><strong>Cookies de marketing :</strong> Contenu personnalisé (avec consentement)</li>
      </ul>

      <h3>5.3 Contrôle des cookies</h3>
      <p>Vous pouvez contrôler les cookies via les paramètres de votre navigateur. La désactivation de certains cookies
        peut affecter les fonctionnalités du site.</p>

      <p><strong>Pour gérer les cookies :</strong></p>
      <ul>
        <li>Chrome : Menu > Paramètres > Confidentialité et sécurité > Cookies</li>
        <li>Firefox : Menu > Paramètres > Confidentialité > Cookies</li>
        <li>Safari : Préférences > Confidentialité > Cookies</li>
        <li>Edge : Paramètres > Confidentialité > Cookies</li>
      </ul>
    </div>

    <div class="content-section">
      <h2>6. Conservation des données</h2>

      <p>Nous conservons vos données personnelles aussi longtemps que nécessaire pour les finalités décrites :</p>
      <ul>
        <li><strong>Données de compte :</strong> Conservées pendant la durée active du compte + 1 an après suppression
        </li>
        <li><strong>Données de navigation :</strong> Conservées 12 mois maximum</li>
        <li><strong>Données de transaction :</strong> Conservées selon les obligations légales (min. 6 ans)</li>
        <li><strong>Données marketing :</strong> Conservées jusqu'au retrait du consentement</li>
      </ul>

      <p>Vous pouvez demander la suppression de vos données à tout moment (sauf obligations légales).</p>
    </div>

    <div class="content-section">
      <h2>7. Vos droits et libertés</h2>

      <p>Vous disposez des droits suivants concernant vos données :</p>

      <h3>7.1 Droit d'accès</h3>
      <p>Vous avez le droit de demander l'accès à toutes les données personnelles nous vous concernant.</p>

      <h3>7.2 Droit de rectification</h3>
      <p>Vous pouvez demander la correction de données inexactes ou incomplètes.</p>

      <h3>7.3 Droit à l'oubli</h3>
      <p>Vous pouvez demander la suppression de vos données (sauf obligations légales).</p>

      <h3>7.4 Droit à la portabilité</h3>
      <p>Vous pouvez demander une copie de vos données dans un format structuré et couramment utilisé.</p>

      <h3>7.5 Droit d'opposition</h3>
      <p>Vous pouvez vous opposer au traitement de vos données pour le marketing ou fins similaires.</p>

      <h3>7.6 Restriction du traitement</h3>
      <p>Vous pouvez demander la limitation du traitement de vos données en certaines circonstances.</p>

      <h3>Comment exercer vos droits</h3>
      <p>Pour exercer l'un de ces droits, contactez-nous à : <a href="mailto:privacy@ecodrive.tn"
          style="color: var(--accent);">privacy@ecodrive.tn</a></p>
      <p>Nous traiterons votre demande dans un délai de 30 jours ouvrables.</p>
    </div>

    <div class="content-section">
      <h2>8. Données des mineurs</h2>

      <p>Notre site est destiné aux personnes âgées de 13 ans ou plus. Nous ne collectons sciemment pas de données
        personnelles provenant d'enfants de moins de 13 ans.</p>

      <p>Si nous découvrons que nous avons collecté des données d'un enfant de moins de 13 ans, nous supprimerons
        immédiatement ces informations.</p>

      <p>Les parents/tuteurs suspectant une telle collecte peuvent nous contacter immédiatement.</p>
    </div>

    <div class="content-section">
      <h2>9. Transferts internationaux</h2>

      <p>Vos données sont traitées en Tunisie. En cas de transfert vers d'autres pays, nous utilisons des mécanismes
        approuvés (clauses types, consentement) pour assurer un niveau de protection équivalent.</p>
    </div>

    <div class="content-section">
      <h2>10. Modifications de cette politique</h2>

      <p>EcoDrive peut modifier cette Politique de Confidentialité à tout moment. Les modifications seront publiées sur
        cette page avec une date de mise à jour.</p>

      <p>Votre utilisation continue du site après les modifications constitue votre acceptation de la nouvelle
        politique.</p>
    </div>

    <div class="content-section">
      <h2>11. Nous contacter</h2>

      <h3>Responsable de la protection des données</h3>
      <p><strong>Nom :</strong> Hayder Baccouri</p>
      <p><strong>Email :</strong> <a href="mailto:privacy@ecodrive.tn"
          style="color: var(--accent);">privacy@ecodrive.tn</a></p>

      <h3>Adresse postale</h3>
      <p>EcoDrive<br>
        Tunisie</p>

      <h3>Formulaire de contact</h3>
      <p><a href="contact.php" style="color: var(--accent);">Visitez notre page de contact</a> pour nous envoyer un
        message.</p>

      <h3>Durée de réponse</h3>
      <p>Nous vous répondrons dans un délai de 5 jours ouvrables.</p>
    </div>

    <div class="content-section" style="border-bottom: none;">
      <h2>12. Dispositions finales</h2>

      <p><strong>Juridiction :</strong> Cette politique est régie par les lois de la Tunisie.</p>

      <p><strong>Date de dernière mise à jour :</strong> 13 juin 2026</p>

      <p><strong>Projet :</strong> Fin de formation 2026 — Hayder Baccouri</p>
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

<button class="back-to-top" aria-label="Retour en haut">&uarr;</button>
<script src="../js/app.js"></script>
</body>

</html>

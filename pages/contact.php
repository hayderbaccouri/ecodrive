<?php
session_set_cookie_params(['lifetime' => 7200, 'httponly' => true, 'samesite' => 'Lax']);
session_start();
$loggedIn = isset($_SESSION['user']);
$success = isset($_GET['success']);
$page_title = 'Contact | EcoDrive';
$page_desc = 'Contactez EcoDrive — showroom de voitures électriques en Tunisie. Demandez un essai, un devis ou des informations.';
$page_url = 'pages/contact.php';
$page_image = 'images/tesla-model-3/Tesla_Model_3_Standard_2026-01@2x.jpg';
?><!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') ?></title>
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E%26%23x26A1%3B%3C/text%3E%3C/svg%3E">
  <?php include __DIR__ . '/../php/partials/meta.php'; ?>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/theme.css">
  <link rel="stylesheet" href="../css/header.css">
  <link rel="stylesheet" href="../css/animations.css">
  <style>
    .page-contact{background:var(--dark);color:var(--gray);flex:1}
    .page-contact .container{max-width:var(--wrap-max,1200px);width:100%;margin:0 auto;padding:clamp(2rem,5vw,3rem) var(--wrap)}
    .page-contact h1{font-family:var(--font-display);font-size:clamp(2rem,4vw,3rem);font-weight:400;color:var(--white);margin-bottom:.5rem;letter-spacing:.02em}
    .page-contact .subtitle{font-size:1rem;color:var(--gray);margin-bottom:2rem;line-height:1.6}
    .page-contact .contact-wrapper{display:grid;grid-template-columns:1fr 1fr;gap:3rem;margin-top:2rem}
    .page-contact .contact-form-section{display:flex;flex-direction:column;gap:1.25rem}
    .page-contact .contact-form-section h2{font-family:var(--font-display);font-size:1.3rem;color:var(--white);margin-bottom:1.5rem}
    .page-contact .form-group{display:flex;flex-direction:column;gap:.5rem}
    .page-contact .form-group label{font-weight:500;font-size:.9rem;color:var(--white)}
    .page-contact .form-group input,.page-contact .form-group textarea,.page-contact .form-group select{background:rgba(var(--white-rgb),.02);border:1px solid rgba(var(--white-rgb),.07);border-radius:8px;padding:.75rem 1rem;color:var(--gray);font-family:var(--font-body);font-size:.95rem;outline:none;transition:border-color .2s,box-shadow .2s}
    .page-contact .form-group input:focus,.page-contact .form-group textarea:focus,.page-contact .form-group select:focus{border-color:var(--accent);box-shadow:0 0 0 3px rgba(var(--accent-rgb),.08)}
    .page-contact .form-group textarea{resize:vertical;min-height:140px}
    .page-contact .form-submit{background:var(--accent);color:var(--white);border:none;padding:.85rem 1.5rem;border-radius:8px;font-weight:500;font-size:.95rem;cursor:pointer;transition:opacity .2s,transform .15s;align-self:flex-start}
    .page-contact .form-submit:hover{opacity:.9;transform:translateY(-1px)}
    .page-contact .contact-info{display:flex;flex-direction:column;gap:2rem}
    .page-contact .contact-info h2{font-family:var(--font-display);font-size:1.3rem;color:var(--white);margin-bottom:1.5rem}
    .page-contact .info-card{background:rgba(var(--white-rgb),.02);border:1px solid rgba(var(--white-rgb),.07);border-radius:12px;padding:1.5rem;transition:border-color .2s,background .2s}
    .page-contact .info-card:hover{background:rgba(var(--white-rgb),.04);border-color:rgba(var(--accent-rgb),.2)}
    .page-contact .info-card-icon{font-size:2rem;margin-bottom:.75rem}
    .page-contact .info-card h3{font-size:1rem;font-weight:500;color:var(--white);margin-bottom:.5rem}
    .page-contact .info-card p{font-size:.9rem;color:var(--gray);line-height:1.6}
    .page-contact .info-card a{color:var(--accent);font-weight:500}
    .page-contact .info-card a:hover{text-decoration:underline}
    .page-contact .social-links{display:flex;gap:1rem;margin-top:1rem}
    .page-contact .social-links a{width:40px;height:40px;background:rgba(var(--accent-rgb),.1);border:1px solid rgba(var(--accent-rgb),.2);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.1rem;transition:background .2s,border-color .2s;text-decoration:none;color:var(--white)}
    .page-contact .social-links a:hover{background:rgba(var(--accent-rgb),.2);border-color:var(--accent)}
    .page-contact .map-section{margin-top:3rem;background:rgba(var(--white-rgb),.02);border:1px solid rgba(var(--white-rgb),.07);border-radius:12px;overflow:hidden;height:400px}
    .page-contact .map-placeholder{width:100%;height:100%;display:flex;align-items:center;justify-content:center;flex-direction:column;gap:1rem;color:var(--gray);text-align:center}
    .page-contact .success-message{display:none;background:rgba(var(--accent-rgb),.1);border:1px solid rgba(var(--accent-rgb),.3);border-radius:8px;padding:1rem;color:var(--accent);margin-bottom:1rem;text-align:center}
    .page-contact .success-message.show{display:block;animation:slideIn .3s ease}@keyframes slideIn{from{opacity:0;transform:translateY(-10px)}to{opacity:1;transform:translateY(0)}}
    @media (max-width:800px){.page-contact .contact-wrapper{grid-template-columns:1fr;gap:2rem}}
  </style>
</head>
<body>
<?php $asset_base = '../'; include __DIR__ . '/../php/partials/header.php'; ?>

<main class="page-contact page-fade-in">
  <div class="container">
    <h1 class="hero-entrance">Contactez-nous</h1>
    <p class="subtitle hero-entrance">Une question, un essai, un projet ? Notre équipe est à votre écoute.</p>

    <?php if ($success): ?>
    <div class="success-message show">Merci ! Votre message a été envoyé avec succès. Nous vous répondrons dans les plus brefs délais.</div>
    <?php endif; ?>
    <?php $error = $_SESSION['contact_error'] ?? ''; unset($_SESSION['contact_error']); if ($error): ?>
    <div style="background:rgba(var(--danger-rgb),.1);border:1px solid rgba(var(--danger-rgb),.3);border-radius:8px;padding:1rem;color:var(--danger);margin-bottom:1rem;text-align:center"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="contact-wrapper">
      <div class="contact-form-section">
        <h2>Envoyez-nous un message</h2>
        <form action="traiter-contact.php" method="post" data-validate>
          <div class="form-group">
            <label for="name">Nom complet *</label>
            <input type="text" id="name" name="name" required data-msg-required="Veuillez indiquer votre nom." />
          </div>
          <div class="form-group">
            <label for="email">Email *</label>
            <input type="email" id="email" name="email" required data-msg-required="Veuillez indiquer votre email." data-msg-email="Email invalide." />
          </div>
          <div class="form-group">
            <label for="phone">Téléphone</label>
            <input type="tel" id="phone" name="phone" data-msg-tel="Numéro de téléphone invalide." />
          </div>
          <div class="form-group">
            <label for="subject">Sujet</label>
            <select id="subject" name="subject">
              <option value="">Sélectionnez un sujet</option>
              <option value="essai">Demande d'essai</option>
              <option value="devis">Demande de devis</option>
              <option value="info">Information générale</option>
              <option value="reclamation">Réclamation</option>
            </select>
          </div>
          <div class="form-group">
            <label for="message">Message *</label>
            <textarea id="message" name="message" required data-msg-required="Veuillez écrire votre message." data-minlength="10" data-msg-minlength="Minimum 10 caractères."></textarea>
          </div>
          <button type="submit" class="form-submit">Envoyer le message</button>
        </form>
      </div>

      <div class="contact-info">
        <h2>Nos coordonnées</h2>
        <div class="info-card">
          <div class="info-card-icon">📍</div>
          <h3>Adresse</h3>
          <p>Tunis, Tunisie</p>
        </div>
        <div class="info-card">
          <div class="info-card-icon">📧</div>
          <h3>Email</h3>
          <p><a href="mailto:contact@ecodrive.tn">contact@ecodrive.tn</a></p>
        </div>
        <div class="info-card">
          <div class="info-card-icon">🕐</div>
          <h3>Horaires</h3>
          <p>Lun — Ven : 9h – 18h<br>Sam : 9h – 13h</p>
        </div>
        <h2>Suivez-nous</h2>
        <div class="social-links">
          <a href="#" aria-label="Facebook">f</a>
          <a href="#" aria-label="Instagram">◻</a>
          <a href="#" aria-label="LinkedIn">in</a>
          <a href="#" aria-label="YouTube">▶</a>
        </div>
      </div>
    </div>

    <div class="map-section">
      <div class="map-placeholder">
        <span style="font-size:3rem">🗺️</span>
        <p>Carte interactive bientôt disponible</p>
        <p style="font-size:.8rem">EcoDrive — Tunis, Tunisie</p>
      </div>
    </div>
  </div>
</main>

<?php include __DIR__ . '/../php/partials/footer.php'; ?>

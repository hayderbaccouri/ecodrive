<?php
session_set_cookie_params(['lifetime' => 7200, 'httponly' => true, 'samesite' => 'Lax']);
session_start();
$loggedIn = isset($_SESSION['user']);
$success = isset($_GET['success']);
$page_title = 'Contact | EcoDrive';
$page_desc = 'Contactez EcoDrive â€” showroom de voitures Ã©lectriques en Tunisie. Demandez un essai, un devis ou des informations.';
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
  <link rel="stylesheet" href="../css/style.css?v=15">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
</head>
<body>
<?php $asset_base = '../'; include __DIR__ . '/../php/partials/header.php'; ?>

<main class="page-contact page-fade-in">
  <div class="container">
    <h1 class="hero-entrance">Contactez-nous</h1>
    <p class="subtitle hero-entrance">Une question, un essai, un projet ? Notre Ã©quipe est Ã  votre Ã©coute.</p>

    <?php if ($success): ?>
    <div class="success-message show">Merci ! Votre message a Ã©tÃ© envoyÃ© avec succÃ¨s. Nous vous rÃ©pondrons dans les plus brefs dÃ©lais.</div>
    <?php endif; ?>
    <?php $error = $_SESSION['contact_error'] ?? ''; unset($_SESSION['contact_error']); if ($error): ?>
    <div style="background:rgba(var(--danger-rgb),.1);border:1px solid rgba(var(--danger-rgb),.3);border-radius:8px;padding:1rem;color:var(--danger);margin-bottom:1rem;text-align:center"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="contact-wrapper">
      <div class="contact-form-section">
        <h2>Envoyez-nous un message</h2>
        <form action="traiter-contact.php" method="post" data-validate>
          <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32)) ?>">
          <div class="form-group">
            <label for="name">Nom complet *</label>
            <input type="text" id="name" name="name" required data-msg-required="Veuillez indiquer votre nom." />
          </div>
          <div class="form-group">
            <label for="email">Email *</label>
            <input type="email" id="email" name="email" required data-msg-required="Veuillez indiquer votre email." data-msg-email="Email invalide." />
          </div>
          <div class="form-group">
            <label for="phone">TÃ©lÃ©phone</label>
            <input type="tel" id="phone" name="phone" data-msg-tel="NumÃ©ro de tÃ©lÃ©phone invalide." />
          </div>
          <div class="form-group">
            <label for="subject">Sujet</label>
            <select id="subject" name="subject">
              <option value="">SÃ©lectionnez un sujet</option>
              <option value="essai">Demande d'essai</option>
              <option value="devis">Demande de devis</option>
              <option value="info">Information gÃ©nÃ©rale</option>
              <option value="reclamation">RÃ©clamation</option>
            </select>
          </div>
          <div class="form-group">
            <label for="message">Message *</label>
            <textarea id="message" name="message" required data-msg-required="Veuillez Ã©crire votre message." data-minlength="10" data-msg-minlength="Minimum 10 caractÃ¨res."></textarea>
          </div>
          <button type="submit" class="form-submit">Envoyer le message</button>
        </form>
      </div>

      <div class="contact-info">
        <h2>Nos coordonnÃ©es</h2>
        <div class="info-card">
          <div class="info-card-icon">ðŸ“</div>
          <h3>Adresse</h3>
          <p>Tunis, Tunisie</p>
        </div>
        <div class="info-card">
          <div class="info-card-icon">ðŸ“§</div>
          <h3>Email</h3>
          <p><a href="mailto:contact@ecodrive.tn">contact@ecodrive.tn</a></p>
        </div>
        <div class="info-card">
          <div class="info-card-icon">ðŸ•</div>
          <h3>Horaires</h3>
          <p>Lun â€” Ven : 9h â€“ 18h<br>Sam : 9h â€“ 13h</p>
        </div>
        <h2>Suivez-nous</h2>
        <div class="social-links">
          <a href="https://facebook.com/ecodrive.tn" target="_blank" rel="noopener" aria-label="Facebook">f</a>
          <a href="https://instagram.com/ecodrive.tn" target="_blank" rel="noopener" aria-label="Instagram">â—»</a>
          <a href="https://linkedin.com/company/ecodrive" target="_blank" rel="noopener" aria-label="LinkedIn">in</a>
          <a href="https://youtube.com/@ecodrive" target="_blank" rel="noopener" aria-label="YouTube">â–¶</a>
        </div>
      </div>
    </div>

    <div class="map-section">
      <div id="contact-map" style="width:100%;height:100%;border-radius:12px"></div>
    </div>
  </div>
</main>

<?php include __DIR__ . '/../php/partials/footer.php'; ?>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
(function(){
  var map = L.map('contact-map').setView([36.8065, 10.1815], 15);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap',
    maxZoom: 19
  }).addTo(map);
  L.marker([36.8065, 10.1815]).addTo(map)
    .bindPopup('<strong>EcoDrive</strong><br>123 Rue de la LibertÃ©, Tunis')
    .openPopup();
})();
</script>

<?php
$asset_base = $asset_base ?? '';
?>
  <footer class="site-footer">
    <div class="footer-afterglow" aria-hidden="true">EV</div>
    <div class="footer-inner">
      <div class="footer-grid">
        <div class="footer-brand">
          <div class="footer-logo">eco<span>drive</span></div>
          <p class="footer-tagline">Premier showroom électrique de Tunisie — la mobilité durable pour tous.</p>
          <div class="footer-social">
            <a href="https://facebook.com/ecodrive.tn" target="_blank" rel="noopener" aria-label="Facebook" class="social-link">Facebook</a>
            <a href="https://instagram.com/ecodrive.tn" target="_blank" rel="noopener" aria-label="Instagram" class="social-link">Instagram</a>
            <a href="https://linkedin.com/company/ecodrive" target="_blank" rel="noopener" aria-label="LinkedIn" class="social-link">LinkedIn</a>
          </div>
        </div>
        <div class="footer-col">
          <h4>Navigation</h4>
          <nav class="footer-nav">
            <a href="<?= $asset_base ?>index.php" class="footer-link">Accueil</a>
            <a href="<?= $asset_base ?>php/catalogue.php" class="footer-link">Catalogue</a>
            <a href="<?= $asset_base ?>bornes/index.php" class="footer-link">Bornes de recharge</a>
            <a href="<?= $asset_base ?>pages/contact.php" class="footer-link">Contact</a>
          </nav>
        </div>
        <div class="footer-col">
          <h4>Informations</h4>
          <nav class="footer-nav">
            <a href="<?= $asset_base ?>pages/mentions-legales.php" class="footer-link">Mentions légales</a>
            <a href="<?= $asset_base ?>pages/cgv.php" class="footer-link">CGV</a>
            <a href="<?= $asset_base ?>pages/cgu.php" class="footer-link">CGU</a>
            <a href="<?= $asset_base ?>pages/confidentialite.php" class="footer-link">Confidentialité</a>
          </nav>
        </div>
        <div class="footer-col">
          <h4>Newsletter</h4>
          <?php if (($_SESSION['user']['role'] ?? '') === 'admin'): ?>
            <p class="footer-newsletter-text">Gérez les abonnés depuis votre espace.</p>
            <a href="<?= $asset_base ?>php/admin.php?tab=newsletter" class="btn btn-sm btn-ghost">Gérer les abonnés</a>
          <?php else: ?>
            <p class="footer-newsletter-text">Restez informé des nouveautés et offres exclusives.</p>
            <?php if (isset($_SESSION['newsletter_flash'])): ?>
              <div class="contact-success" style="margin-bottom:1rem">
                <?= $_SESSION['newsletter_flash'] === 'success'
                  ? '✓ Vous êtes abonné à la newsletter EcoDrive !'
                  : 'ℹ Vous êtes déjà abonné à la newsletter.' ?>
              </div>
              <?php unset($_SESSION['newsletter_flash']); ?>
            <?php endif; ?>
            <form method="post" action="<?= $asset_base ?>php/newsletter.php" class="footer-newsletter-form">
              <input type="email" name="email" placeholder="votre@email.com" required>
              <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
              <button type="submit" class="btn-newsletter">→</button>
            </form>
          <?php endif; ?>
        </div>
      </div>
      <div class="footer-bottom">
        <span>© 2026 EcoDrive Tunisie. Tous droits réservés.</span>
        <span class="footer-bottom-right">Fait par Hayder Baccouri</span>
      </div>
    </div>
  </footer>

<button class="back-to-top" aria-label="Retour en haut">&uarr;</button>
<noscript><style>.reveal,.reveal-up,.reveal-down,.reveal-left,.reveal-right,.reveal-scale{opacity:1!important;transform:none!important}</style></noscript>
<script src="<?= $asset_base ?>js/app.js?v=<?= CACHE_VERSION ?>" defer></script>
</body>
</html>

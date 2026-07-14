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
            <a href="#" aria-label="Facebook" class="social-link">Facebook</a>
            <a href="#" aria-label="Instagram" class="social-link">Instagram</a>
            <a href="#" aria-label="LinkedIn" class="social-link">LinkedIn</a>
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
          <p class="footer-newsletter-text">Restez informé des nouveautés et offres exclusives.</p>
          <form method="post" action="<?= $asset_base ?>php/newsletter.php" class="footer-newsletter-form">
            <input type="email" name="email" placeholder="votre@email.com" required>
            <button type="submit" class="btn-newsletter">→</button>
          </form>
        </div>
      </div>
      <div class="footer-bottom">
        <span>© 2026 EcoDrive Tunisie. Tous droits réservés.</span>
        <span class="footer-bottom-right">Fait avec ⚡ en Tunisie</span>
      </div>
    </div>
  </footer>

<button class="back-to-top" aria-label="Retour en haut">&uarr;</button>
<script src="<?= $asset_base ?>js/app.min.js"></script>
</body>
</html>

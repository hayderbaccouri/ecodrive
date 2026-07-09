<?php
$asset_base = $asset_base ?? '';
?>
  <!-- Footer -->
  <footer class="site-footer">
    <div class="footer-grid">
      <div class="footer-brand">
        <div class="footer-logo">eco<span>drive</span></div>
        <p class="footer-tagline">Premier showroom électrique de Tunisie — la mobilité durable pour tous.</p>
        <div class="footer-energy"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 14h6l-2 8 10-12h-6l2-8z"/><path d="M18 10c2 2 2 5 0 7" opacity=".6"/></svg></div>
      </div>
      <div class="footer-col">
        <h4>Navigation</h4>
        <nav class="footer-nav">
          <a href="<?= $asset_base ?>index.php" class="footer-link">Accueil</a>
          <a href="<?= $asset_base ?>php/catalogue.php" class="footer-link">Catalogue</a>
          <a href="<?= $asset_base ?>index.php#bornes" class="footer-link">Bornes</a>
          <a href="<?= $asset_base ?>pages/contact.php" class="footer-link">Contact</a>
        </nav>
      </div>
      <div class="footer-col">
        <h4>Infos</h4>
        <nav class="footer-nav">
          <a href="<?= $asset_base ?>pages/mentions-legales.php" class="footer-link">Mentions légales</a>
          <a href="<?= $asset_base ?>pages/cgv.php" class="footer-link">CGV</a>
          <a href="<?= $asset_base ?>pages/cgu.php" class="footer-link">CGU</a>
          <a href="<?= $asset_base ?>pages/confidentialite.php" class="footer-link">Confidentialité</a>
        </nav>
      </div>
      <div class="footer-col">
        <h4>Contact</h4>
        <nav class="footer-nav">
          <span class="footer-link">contact@ecodrive.tn</span>
          <span class="footer-link">Tunis, Tunisie</span>
        </nav>
      </div>
    </div>
    <div class="footer-bottom">© 2026 EcoDrive. Tous droits réservés.</div>
  </footer>

<button class="back-to-top" aria-label="Retour en haut">&uarr;</button>
<script src="<?= $asset_base ?>js/app.js"></script>
</body>
</html>

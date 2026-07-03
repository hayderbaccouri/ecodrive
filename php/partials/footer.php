<?php
$asset_base = $asset_base ?? '';
?>
  <!-- Footer -->
  <footer class="site-footer">
    <div class="footer-logo">eco<span>drive</span></div>
    <span>© 2026 EcoDrive. Tous droits réservés.</span>
    <nav class="footer-nav">
        <a href="<?= $asset_base ?>pages/mentions-legales.php" class="footer-link">Mentions légales</a>
        <a href="<?= $asset_base ?>pages/confidentialite.php" class="footer-link">Confidentialité</a>
        <a href="<?= $asset_base ?>pages/contact.php" class="footer-link">Contact</a>
    </nav>
  </footer>

<button class="back-to-top" aria-label="Retour en haut">&uarr;</button>
<script src="<?= $asset_base ?>js/app.js"></script>
</body>
</html>

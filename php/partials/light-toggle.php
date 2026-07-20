<?php
// light-toggle.php â€” LumiÃ¨re solaire toggle + simulateur trajet
// Usage: include this in car detail pages after the car slider
// Expected vars: $range_km (optional), $marque, $modele
$range_km = $range_km ?? 500;
?>
<div class="light-toggle">
  <button class="light-toggle-btn active" data-light="morning" type="button">â˜€ï¸ Matin</button>
  <button class="light-toggle-btn" data-light="noon" type="button">â˜€ï¸ Midi</button>
  <button class="light-toggle-btn" data-light="sunset" type="button">ðŸŒ… Coucher</button>
</div>

<div class="route-simulator reveal reveal-up">
  <div class="route-header">
    <span>âš¡</span>
    <h3>Simulateur d'autonomie</h3>
  </div>
  <div class="route-visual">
    <div class="route-point">
      <div class="route-point-name">Tunis</div>
      <div class="route-point-sub">Capitale</div>
    </div>
    <div class="route-line">
      <div class="route-line-fill" style="width:100%"></div>
      <div class="route-line-dot" style="left:100%"></div>
    </div>
    <div class="route-point">
      <div class="route-point-name">Djerba</div>
      <div class="route-point-sub">ÃŽle du sud</div>
    </div>
  </div>
  <div class="route-stats">
    <div class="route-stat">
      <div class="route-stat-value">480 km</div>
      <div class="route-stat-label">Distance trajet</div>
    </div>
    <div class="route-stat">
      <div class="route-stat-value"><?= (int)$range_km ?> km</div>
      <div class="route-stat-label">Autonomie vÃ©hicule</div>
    </div>
    <div class="route-stat">
      <div class="route-stat-value">0 arrÃªt</div>
      <div class="route-stat-label">Recharge nÃ©cessaire</div>
    </div>
  </div>
  <?php if ($range_km >= 480): ?>
    <div class="route-badge">âœ… Tunis â†’ Djerba sans recharge</div>
  <?php else: ?>
    <div class="route-badge">âš¡ 1 arrÃªt recharge recommandÃ© (~20 min)</div>
  <?php endif; ?>
</div>

<script>
document.querySelectorAll('.light-toggle-btn').forEach(function(btn) {
  btn.addEventListener('click', function() {
    document.querySelectorAll('.light-toggle-btn').forEach(function(b) { b.classList.remove('active'); });
    btn.classList.add('active');
    var slider = document.querySelector('.car-slider-wrap');
    if (!slider) return;
    slider.classList.remove('light-morning', 'light-noon', 'light-sunset');
    if (btn.dataset.light !== 'morning') slider.classList.add('light-' + btn.dataset.light);
  });
});
</script>

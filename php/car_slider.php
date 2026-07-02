<?php
if (!function_exists('renderCarSlider')) {
function renderCarSlider($folder, $heroImage, $carName) {
    $dir = __DIR__ . '/../' . $folder;
    $files = glob($dir . '*.{jpg,jpeg,png,webp,avif}', GLOB_BRACE);
    if (!$files) return;

    // Normalize paths and exclude the hero image
    $heroBase = basename($heroImage);
    $images = [];
    foreach ($files as $f) {
        $base = basename($f);
        if ($base === $heroBase) continue;
        $images[] = $folder . $base;
    }
    if (empty($images)) return;

    // Sort: exterior first, then interior, then other files by number
    usort($images, function ($a, $b) {
        $aName = basename($a);
        $bName = basename($b);
        // Files with smaller numbers first (numeric part at end)
        $aNum = preg_match('/[_-](\d+)\.\w+$/', $aName, $m) ? (int)$m[1] : 0;
        $bNum = preg_match('/[_-](\d+)\.\w+$/', $bName, $m) ? (int)$m[1] : 0;
        // Exterieur/interieur keywords
        $aExt = stripos($aName, 'exterior') !== false || stripos($aName, 'exterieur') !== false || stripos($aName, 'ext') !== false;
        $bExt = stripos($bName, 'exterior') !== false || stripos($bName, 'exterieur') !== false || stripos($bName, 'ext') !== false;
        $aInt = stripos($aName, 'interior') !== false || stripos($aName, 'interieur') !== false || stripos($aName, 'int') !== false;
        $bInt = stripos($bName, 'interior') !== false || stripos($bName, 'interieur') !== false || stripos($bName, 'int') !== false;
        // Priority: exterior < interior < others
        $aScore = $aExt ? 0 : ($aInt ? 1 : 2);
        $bScore = $bExt ? 0 : ($bInt ? 1 : 2);
        if ($aScore !== $bScore) return $aScore - $bScore;
        // Numeric sort by trailing number
        if ($aNum && $bNum) return $aNum - $bNum;
        return strcasecmp($aName, $bName);
    });
?>
<section class="car-slider">
  <div class="slider-viewport">
    <div class="slider-track">
      <?php foreach ($images as $i => $img): ?>
      <div class="slider-slide<?= $i === 0 ? ' active' : '' ?>">
        <img loading="lazy" src="../<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($carName) ?> - Vue <?= $i + 1 ?>">
      </div>
      <?php endforeach; ?>
    </div>
    <?php if (count($images) > 1): ?>
    <button class="slider-arrow slider-prev" type="button" aria-label="Précédent">‹</button>
    <button class="slider-arrow slider-next" type="button" aria-label="Suivant">›</button>
    <?php endif; ?>
  </div>
  <?php if (count($images) > 1): ?>
  <div class="slider-dots"></div>
  <?php endif; ?>
</section>
<?php
}
}

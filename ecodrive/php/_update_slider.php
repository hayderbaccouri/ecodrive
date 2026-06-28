<?php
$cars = [
    ['Audi-A6-Sportback-e-tron.php', 'images/audi-a6/', 'audi-a6-01.jpg', 'Audi A6 Sportback e-tron'],
    ['BMW-iX3.php', 'images/bmw-ix3/', 'BMW-iX3.jpg', 'BMW iX3'],
    ['BYD-Ato3.php', 'images/byd-atto-3/', 'byd-atto-3.jpg', 'BYD Atto 3'],
    ['BYD-Dolphin.php', 'images/byd-dolphin/', 'byd-dolphin.jpg', 'BYD Dolphin Surf'],
    ['citroene-c3.php', 'images/citroen-c3/', 'C3_1.jpg', 'Citroën ë-C3'],
    ['kia-ev-3.php', 'images/kia-ev3/', 'kia-ev3.png', 'Kia EV3'],
    ['mercedesCLK2026.php', 'images/mercedes-classe-c-2026/', 'Mercedes-Benz-Classe-C-2026.jpg', 'Mercedes CLK 2026'],
    ['mercedes-EQC.php', 'images/mercedes-eqc/', 'mercedes-eqc.jpg', 'Mercedes EQC 400'],
    ['mg4-urban.php', 'images/mg4/', 'mg-4-urban.jpg', 'MG4 Urban'],
    ['Peugeot-e-208.php', 'images/peugeot-e-208/', 'peugeot-e208.jpg', 'Peugeot e-208'],
    ['PorschePanamera.php', 'images/porsche-panamera/', 'porsche-panamera.jpg', 'Porsche Panamera'],
    ['Renault-Megane-E-Tech.php', 'images/renault-megane-e-tech/', 'renault-megane-e-tech.jpg', 'Renault Megane E-Tech'],
    ['Tesla-Model3.php', 'images/tesla-model-3/', 'tesla-model3.jpg', 'Tesla Model 3'],
    ['Tesla-Model-S-Plaid.php', 'images/tesla-model-s-plaid/', 'tesla-model-s-plaid.jpg', 'Tesla Model S Plaid'],
    ['toyota-yaris.php', 'images/toyota-yaris/', 'toyota-yaris.jpg', 'Toyota Yaris'],
];

$base = __DIR__ . '/../voitures/';

// Slider JS to add before </body>
$sliderJs = <<<'JS'
<script>
document.querySelectorAll('.car-slider').forEach(function(s) {
  var track = s.querySelector('.slider-track');
  var slides = track.querySelectorAll('.slider-slide');
  if (slides.length < 2) return;
  var prev = s.querySelector('.slider-prev');
  var next = s.querySelector('.slider-next');
  var dotsEl = s.querySelector('.slider-dots');
  var cur = 0;

  for (var i = 0; i < slides.length; i++) {
    var dot = document.createElement('button');
    dot.className = 'slider-dot' + (i === 0 ? ' active' : '');
    dot.setAttribute('aria-label', 'Image ' + (i + 1));
    (function(idx) {
      dot.addEventListener('click', function() { go(idx); });
    })(i);
    dotsEl.appendChild(dot);
  }

  function go(idx) {
    cur = (idx + slides.length) % slides.length;
    track.style.transform = 'translateX(-' + (cur * 100) + '%)';
    dotsEl.querySelectorAll('.slider-dot').forEach(function(d, i) {
      d.classList.toggle('active', i === cur);
    });
  }

  prev.addEventListener('click', function() { go(cur - 1); });
  next.addEventListener('click', function() { go(cur + 1); });
});
</script>
JS;

foreach ($cars as $c) {
    $file = $base . $c[0];
    $folder = $c[1];
    $heroImg = $c[2];
    $carName = $c[3];

    $content = file_get_contents($file);
    if ($content === false) { echo "Error reading $c[0]\n"; continue; }

    // Remove old gallery section
    $pattern = '#\n  <section class="car-gallery">.*?</section>\n#s';
    $newContent = preg_replace($pattern, "\n", $content, 1, $count);

    if ($count === 0) {
        echo "NO gallery found in $c[0]\n";
        continue;
    }

    // Insert slider include after </section> of car-hero
    $insertPoint = '</section>';
    $sliderCode = '</section>' . "\n\n" . '<?php include \'../php/car_slider.php\'; renderCarSlider(\'' . $folder . '\', \'' . $heroImg . '\', \'' . $carName . '\'); ?>' . "\n";
    $newContent = str_replace($insertPoint . "\n\n", $sliderCode, $newContent, $count2);

    if ($count2 === 0) {
        echo "NO insert point found in $c[0]\n";
        continue;
    }

    // Add slider JS before </body>
    if (strpos($newContent, 'car-slider') !== false && strpos($newContent, 'slider dots init') === false) {
        $newContent = str_replace('</body>', $sliderJs . "\n</body>", $newContent);
    }

    file_put_contents($file, $newContent);
    echo "OK: $c[0]\n";
}

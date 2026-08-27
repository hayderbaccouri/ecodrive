<?php
/**
 * Smoke test EcoDrive — vérifie que chaque page se charge sans erreur PHP.
 * Chaque page est incluse dans un sous-processus isolé (tests/runner.php) ;
 * on contrôle le code de sortie et le HTML produit.
 *
 * Usage : php tests/smoke_test.php
 * Retour : 0 si tout passe, 1 sinon.
 */

$php    = PHP_BINARY;
$runner = __DIR__ . DIRECTORY_SEPARATOR . 'runner.php';

// [page, query, code attendu, slug (optionnel)]
// 'render'  : la page doit produire du HTML et se terminer normalement
// 'redirect': la page doit exécuter header('Location: connexion.php') puis exit
//             (garde d'accès : en CLI le SAPI ignore les en-têtes, on détecte
//              donc une terminaison propre sans marqueur de fin ni HTML)
$pages = [
    ['index.php',                      '', 'render', ''],
    ['404.php',                        '', 'render', ''],
    ['sitemap.php',                    '', 'render', ''],
    ['php/catalogue.php',              '', 'render', ''],
    ['php/catalogue.php',       'page=2', 'render', ''],
    ['bornes/index.php',               '', 'render', ''],
    ['bornes/ExicomSpinAir7kW.php',    '', 'render', ''],
    ['bornes/borne-page.php',          '', 'render', 'exicom-spin-air-7kw'],
    ['pages/contact.php',              '', 'render', ''],
    ['pages/cgv.php',                  '', 'render', ''],
    ['pages/cgu.php',                  '', 'render', ''],
    ['pages/mentions-legales.php',     '', 'render', ''],
    ['pages/confidentialite.php',      '', 'render', ''],
    ['php/inscription.php',            '', 'render', ''],
    ['php/connexion.php',              '', 'render', ''],
    ['voitures/Tesla-Model-3.php',     '', 'render', ''],
    ['voitures/BMW-iX3.php',           '', 'render', ''],
    ['php/admin.php',                  '', 'redirect', ''],
    ['php/tableau-de-bord.php',        '', 'redirect', ''],
    ['php/mes-essais.php',             '', 'redirect', ''],
    ['php/profil.php',                 '', 'redirect', ''],
    ['php/reservation.php',            '', 'redirect', ''],
];

$failures = 0;
$checks   = 0;

foreach ($pages as [$page, $qs, $expected, $presetSlug]) {
    $cmd = escapeshellarg($php) . ' ' . escapeshellarg($runner) . ' '
         . escapeshellarg($page) . ' ' . escapeshellarg($qs) . ' ' . escapeshellarg($presetSlug) . ' 2>&1';
    $out = [];
    $ret = 0;
    exec($cmd, $out, $ret);
    $merged = implode("\n", $out);

    $checks++;

    $markerPos = strpos($merged, '@@SMOKE@@len=');
    $len = 0;
    if ($markerPos !== false) {
        $len = (int) substr($merged, $markerPos + strlen('@@SMOKE@@len='));
    }

    $fatal = $ret !== 0
          || stripos($merged, 'Fatal error') !== false
          || stripos($merged, 'Erreur de connexion à la base') !== false
          || stripos($merged, '@@THROW@@') !== false;

    if ($expected === 'render') {
        $ok = $markerPos !== false && !$fatal && $len > 0;
    } else {
        $ok = $ret === 0 && $markerPos === false && !$fatal;
    }

    if ($ok) {
        echo "[OK]   {$page}" . ($qs !== '' ? "?{$qs}" : '') . ($presetSlug !== '' ? " (slug={$presetSlug})" : '') . ($expected === 'redirect' ? " (redirect ok)" : '') . "\n";
    } else {
        echo "[FAIL] {$page}" . ($qs !== '' ? "?{$qs}" : '') . "\n";
        if ($ret !== 0) echo "       -> code de sortie {$ret}\n";
        if ($fatal)     echo "       -> erreur PHP détectée\n";
        if ($expected === 'redirect' && $markerPos !== false) echo "       -> HTML produit alors qu'une redirection est attendue\n";
        if ($expected === 'render' && $markerPos === false)    echo "       -> page terminée sans produire de HTML\n";
        if ($expected === 'render' && $len === 0)              echo "       -> corps vide\n";
        $failures++;
    }
}

echo "\n{$checks} page(s) testée(s), {$failures} échec(s).\n";
exit($failures === 0 ? 0 : 1);

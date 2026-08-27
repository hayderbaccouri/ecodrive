<?php
/**
 * Runner interne du smoke test — inclut une page dans un processus isolé.
 * Usage : php runner.php <chemin/vers/page.php> [query_string] [slug]
 *
 * Sortie :
 *   - le HTML de la page sur stdout (capturé via ob_start) ;
 *   - en fin de traitement (si la page ne fait pas exit) : "\n@@SMOKE@@len=<octets>\n"
 *   - les erreurs PHP vont sur stderr (le SAPI CLI ignore les en-têtes HTTP).
 */

$page = $argv[1] ?? '';
$qs   = $argv[2] ?? '';
$slug = $argv[3] ?? '';

parse_str($qs, $_GET);
$_SERVER['SCRIPT_NAME']     = '/' . $page;
$_SERVER['REQUEST_URI']     = '/' . $page . ($qs !== '' ? '?' . $qs : '');
$_SERVER['SCRIPT_FILENAME'] = dirname(__DIR__) . '/' . $page;
$_SERVER['HTTP_HOST']       = 'localhost';
$_SERVER['REQUEST_METHOD']  = 'GET';
$_SERVER['REMOTE_ADDR']     = '127.0.0.1';
$_SERVER['HTTPS']           = 'off';

ob_start();
try {
    $fullPath = dirname(__DIR__) . '/' . $page;
    // Comme Apache : le CWD = dossier de la page (les includes relatifs fonctionnent)
    chdir(dirname($fullPath));
    include $fullPath;
} catch (Throwable $e) {
    echo "\n@@THROW@@ " . $e->getMessage() . "\n";
    exit(1);
}
$html = ob_get_clean();
echo "\n@@SMOKE@@len=" . strlen($html) . "\n";

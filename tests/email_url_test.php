<?php
$_SERVER['HTTP_HOST'] = 'localhost';
$_SERVER['REQUEST_URI'] = '/ecodrive-main/php/inscription.php';
$_SERVER['HTTPS'] = 'off';

require __DIR__ . '/../php/bootstrap.php';

$expected = 'http://localhost/ecodrive-main/php/verifier-email.php?token=abc123';
$actual = app_url('/php/verifier-email.php?token=abc123');

if ($actual !== $expected) {
    fwrite(STDERR, "FAIL: expected {$expected} got {$actual}\n");
    exit(1);
}

echo "PASS\n";
exit(0);

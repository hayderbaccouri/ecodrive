<?php
$c = new mysqli('localhost', 'root', '', 'ecodrive');
$c->query("DELETE FROM reservation WHERE notes = 'Test E2E automatise'");
$c->query("DELETE FROM newsletter_subscribers WHERE email LIKE 'e2e-%'");
$c->query("DELETE FROM utilisateur WHERE email LIKE 'e2e-%'");
echo "Nettoyage OK\n";
foreach (['utilisateur', 'reservation', 'newsletter_subscribers'] as $t) {
    $cnt = $c->query("SELECT COUNT(*) AS c FROM `$t`")->fetch_assoc()['c'];
    echo "$t: $cnt lignes\n";
}
$c->close();

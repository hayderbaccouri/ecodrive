<?php
// Vérification structure BDD EcoDrive
require __DIR__ . '/../php/bootstrap.php';

$tables = ['utilisateur', 'voiture', 'borne', 'reservation', 'rate_limits', 'admin_audit'];
foreach ($tables as $t) {
    $r = $conn->query("SHOW TABLES LIKE '" . $t . "'");
    if ($r->num_rows === 0) { echo "MANQUANTE: $t\n"; continue; }
    $cnt = $conn->query("SELECT COUNT(*) AS c FROM `$t`")->fetch_assoc()['c'];
    echo "OK: $t ($cnt lignes)\n";
}

echo "\n-- Colonnes utilisateur --\n";
$r = $conn->query("SHOW COLUMNS FROM utilisateur");
while ($row = $r->fetch_assoc()) { echo $row['Field'] . ' (' . $row['Type'] . ")\n"; }

echo "\n-- Colonnes voiture --\n";
$r = $conn->query("SHOW COLUMNS FROM voiture");
while ($row = $r->fetch_assoc()) { echo $row['Field'] . ' (' . $row['Type'] . ")\n"; }

echo "\n-- Voitures (marque, modele, details_page) --\n";
$r = $conn->query("SELECT marque, modele, details_page FROM voiture LIMIT 20");
while ($row = $r->fetch_assoc()) { echo "{$row['marque']} {$row['modele']} => {$row['details_page']}\n"; }

echo "\n-- Colonnes borne --\n";
$r = $conn->query("SHOW COLUMNS FROM borne");
while ($row = $r->fetch_assoc()) { echo $row['Field'] . ' (' . $row['Type'] . ")\n"; }

echo "\n-- Bornes (nom, details_page) --\n";
if ($conn->query("SHOW COLUMNS FROM borne LIKE 'details_page'")->num_rows > 0) {
    $r = $conn->query("SELECT nom, details_page FROM borne LIMIT 20");
    while ($row = $r->fetch_assoc()) { echo "{$row['nom']} => {$row['details_page']}\n"; }
} else {
    echo "(colonne details_page absente)\n";
}

$conn->close();
echo "\nBDD OK\n";

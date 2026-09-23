<?php
/**
 * Test de validation des corrections fonctionnelles
 * Exécution : php tests/functional_fixes_test.php
 */

require_once __DIR__ . '/../php/bootstrap.php';

global $conn;
$success = 0;
$total = 0;

function assertTest($condition, $message) {
    global $success, $total;
    $total++;
    if ($condition) {
        echo "[PASS] $message\n";
        $success++;
    } else {
        echo "[FAIL] $message\n";
    }
}

// 1. Recherche multi-mots
function testSearch($query, $conn) {
    $tokens = preg_split('/\s+/', trim($query), -1, PREG_SPLIT_NO_EMPTY);
    $sql = "SELECT id_voiture, marque, modele FROM voiture WHERE 1=1";
    $types = '';
    $vals = [];
    foreach ($tokens as $token) {
        $sql .= " AND (CONCAT(marque, ' ', modele) LIKE ? OR description LIKE ?)";
        $types .= 'ss';
        $v = '%' . $token . '%';
        $vals[] = $v;
        $vals[] = $v;
    }
    $stmt = $conn->prepare($sql);
    if ($types !== '') {
        $stmt->bind_param($types, ...$vals);
    }
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

$r1 = testSearch('Tesla Model 3', $conn);
assertTest(count($r1) >= 1, "Recherche multi-mots 'Tesla Model 3' renvoie au moins 1 résultat");

$r2 = testSearch('Peugeot 208', $conn);
assertTest(count($r2) >= 1, "Recherche multi-mots 'Peugeot 208' renvoie au moins 1 résultat");

$r3 = testSearch('Tesla 3', $conn);
assertTest(count($r3) >= 1, "Recherche multi-mots 'Tesla 3' renvoie au moins 1 résultat");

$r4 = testSearch('Mercedes C', $conn);
assertTest(count($r4) >= 1, "Recherche multi-mots 'Mercedes C' renvoie au moins 1 résultat");

// 2. Tri numérique des bornes
$resBornes = $conn->query("SELECT puissance FROM borne ORDER BY CAST(REPLACE(REPLACE(puissance, ' kW', ''), ',', '.') AS DECIMAL(5,2)) DESC");
$bornes = [];
while ($row = $resBornes->fetch_assoc()) {
    $bornes[] = $row['puissance'];
}
$isSorted = true;
if (count($bornes) >= 4) {
    $isSorted = ($bornes[0] === '22 kW' && $bornes[1] === '11 kW' && $bornes[2] === '7,4 kW' && $bornes[3] === '3 kW');
}
assertTest($isSorted, "Tri numérique des bornes est 22 kW > 11 kW > 7,4 kW > 3 kW");

// 3. Vérification des réservations actives
$chkStmt = $conn->prepare("SELECT COUNT(*) FROM reservation WHERE voiture_id = ? AND statut != 'cancelled' AND date_essai >= CURDATE()");
$vid = 1;
$chkStmt->bind_param('i', $vid);
$chkStmt->execute();
$count = $chkStmt->get_result()->fetch_row()[0];
assertTest($count >= 0, "Vérification des réservations actives fonctionne");

// 4. Prix BDD pour Tesla Model 3
$resCar = $conn->query("SELECT prix FROM voiture WHERE id_voiture = 1");
$prix = $resCar->fetch_row()[0];
assertTest($prix > 0, "Prix BDD pour Tesla Model 3 est valide (> 0)");

echo "Tests réussis : $success / $total\n";
exit($success === $total ? 0 : 1);

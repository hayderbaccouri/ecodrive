<?php
include 'bootstrap.php';

// AccÃ¨s rÃ©servÃ© Ã  l'admin
if (!isset($_SESSION['user']['id'])) {
    header('Location: connexion.php');
    exit;
}
$stmt = $conn->prepare("SELECT role FROM utilisateur WHERE id_utilisateur = ?");
$stmt->bind_param("i", $_SESSION['user']['id']);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();
if (!$user || $user['role'] !== 'admin') {
    die("AccÃ¨s refusÃ©.");
}

$type = $_GET['type'] ?? '';

// â”€â”€ Helper : envoyer un fichier CSV â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
function csvOutput($filename, $headers, $rows) {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    $out = fopen('php://output', 'w');
    fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM UTF-8
    fputcsv($out, $headers, ';');
    foreach ($rows as $row) {
        fputcsv($out, $row, ';');
    }
    fclose($out);
    exit;
}

// â”€â”€ Helper : dumper la base en SQL â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
function sqlDump($conn, $dbname) {
    header('Content-Type: text/plain; charset=utf-8');
    header('Content-Disposition: attachment; filename="ecodrive_backup_' . date('Y-m-d_H-i-s') . '.sql"');

    $tables = $conn->query("SHOW TABLES")->fetch_all(MYSQLI_NUM);

    echo "-- EcoDrive â€” Backup du " . date('Y-m-d H:i:s') . "\n--\n\n";

    foreach ($tables as $t) {
        $table = $t[0];

        // Structure
        $create = $conn->query("SHOW CREATE TABLE `$table`")->fetch_assoc();
        echo "DROP TABLE IF EXISTS `$table`;\n";
        echo $create['Create Table'] . ";\n\n";

        // DonnÃ©es
        $rows = $conn->query("SELECT * FROM `$table`")->fetch_all(MYSQLI_ASSOC);
        if (empty($rows)) continue;

        $cols = array_keys($rows[0]);
        foreach ($rows as $row) {
            $vals = array_map(function($v) use ($conn) {
                if ($v === null) return 'NULL';
                return "'" . $conn->real_escape_string($v) . "'";
            }, array_values($row));
            echo "INSERT INTO `$table` (`" . implode('`, `', $cols) . "`) VALUES (" . implode(', ', $vals) . ");\n";
        }
        echo "\n";
    }
    exit;
}

// â”€â”€ Routage â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
switch ($type) {
    case 'backup':
        sqlDump($conn, 'ecodrive');
        break;

    case 'reservations':
        $data = $conn->query(
            "SELECT r.id_reservation, u.nom AS client, u.email, v.marque, v.modele,
                    r.date_essai, r.heure_debut, r.heure_fin, r.statut, r.notes, r.created_at
             FROM reservation r
             JOIN utilisateur u ON r.utilisateur_id = u.id_utilisateur
             JOIN voiture v ON r.voiture_id = v.id_voiture
             ORDER BY r.created_at DESC"
        )->fetch_all(MYSQLI_ASSOC);

        $headers = ['ID', 'Client', 'Email', 'Marque', 'ModÃ¨le', 'Date essai', 'DÃ©but', 'Fin', 'Statut', 'Notes', 'CrÃ©Ã© le'];
        $rows = [];
        foreach ($data as $r) {
            $rows[] = [$r['id_reservation'], $r['client'], $r['email'], $r['marque'], $r['modele'], $r['date_essai'], $r['heure_debut'], $r['heure_fin'], $r['statut'], $r['notes'] ?? '', $r['created_at']];
        }
        csvOutput('reservations.csv', $headers, $rows);
        break;

    case 'voitures':
        $data = $conn->query("SELECT * FROM voiture ORDER BY created_at DESC")->fetch_all(MYSQLI_ASSOC);
        $headers = ['ID', 'Marque', 'ModÃ¨le', 'AnnÃ©e', 'Prix', 'Description', 'Image', 'Page dÃ©tails', 'CrÃ©Ã© le'];
        $rows = [];
        foreach ($data as $r) {
            $rows[] = [$r['id_voiture'], $r['marque'], $r['modele'], $r['annee'], $r['prix'], $r['description'] ?? '', $r['image'] ?? '', $r['details_page'] ?? '', $r['created_at']];
        }
        csvOutput('voitures.csv', $headers, $rows);
        break;

    case 'bornes':
        $data = $conn->query("SELECT * FROM borne ORDER BY created_at DESC")->fetch_all(MYSQLI_ASSOC);
        $headers = ['ID', 'Nom', 'ModÃ¨le', 'Puissance', 'Prix', 'Description', 'Image', 'Page dÃ©tails', 'CrÃ©Ã© le'];
        $rows = [];
        foreach ($data as $r) {
            $rows[] = [$r['id_borne'], $r['nom'], $r['modele'], $r['puissance'], $r['prix'], $r['description'] ?? '', $r['image'] ?? '', $r['details_page'] ?? '', $r['created_at']];
        }
        csvOutput('bornes.csv', $headers, $rows);
        break;

    default:
        die("Type d'export invalide.");
}

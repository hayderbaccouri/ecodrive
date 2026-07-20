<?php
include 'bootstrap.php';

if (!isset($_SESSION['user']['id'])) { header('Location: connexion.php'); exit; }

$reservationId = (int)($_GET['id'] ?? 0);
if (!$reservationId) { exit('Réservation invalide.'); }

$userId = $_SESSION['user']['id'];
$stmt = $conn->prepare("SELECT r.*, v.marque, v.modele FROM reservation r JOIN voiture v ON r.voiture_id = v.id_voiture WHERE r.id_reservation = ? AND r.utilisateur_id = ?");
$stmt->bind_param("ii", $reservationId, $userId);
$stmt->execute();
$r = $stmt->get_result()->fetch_assoc();
$stmt->close();
if (!$r) { exit('Réservation introuvable.'); }

$date = $r['date_essai'];
$start = $date . 'T' . $r['heure_debut'] . ':00';
$end = $date . 'T' . $r['heure_fin'] . ':00';
$car = $r['marque'] . ' ' . $r['modele'];
$uid = 'ecodrive-' . $r['id_reservation'] . '@ecodrive.tn';
$now = date('Ymd\THis');

$ics = "BEGIN:VCALENDAR\r\n"
     . "VERSION:2.0\r\n"
     . "PRODID:-//EcoDrive//Essai//FR\r\n"
     . "BEGIN:VEVENT\r\n"
     . "UID:$uid\r\n"
     . "DTSTAMP:$now\r\n"
     . "DTSTART:$start\r\n"
     . "DTEND:$end\r\n"
     . "SUMMARY:Essai $car — EcoDrive\r\n"
     . "DESCRIPTION:Réservation d'essai gratuit pour $car chez EcoDrive.\r\n"
     . "LOCATION:EcoDrive, Tunis\r\n"
     . "STATUS:CONFIRMED\r\n"
     . "END:VEVENT\r\n"
     . "END:VCALENDAR";

header('Content-Type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename="essai-' . $r['id_reservation'] . '.ics"');
echo $ics;
exit;
?>

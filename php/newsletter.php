<?php
include 'bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: ../index.php'); exit; }

if (!csrf_verify($_POST['csrf_token'] ?? '')) { header('Location: ../index.php'); exit; }

$email = trim($_POST['email'] ?? '');
if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '../index.php'));
    exit;
}

$attempts = $conn->prepare("SELECT COUNT(*) AS cnt FROM newsletter_subscribers WHERE email = ? AND subscribed_at > DATE_SUB(NOW(), INTERVAL 1 HOUR)");
$attempts->bind_param("s", $email);
$attempts->execute();
$row = $attempts->get_result()->fetch_assoc();
$attempts->close();
if (($row['cnt'] ?? 0) >= 3) {
    $_SESSION['newsletter_info'] = true;
    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '../index.php'));
    exit;
}

$check = $conn->prepare("SELECT id FROM newsletter_subscribers WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
if ($check->get_result()->num_rows === 0) {
    $stmt = $conn->prepare("INSERT INTO newsletter_subscribers (email) VALUES (?)");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->close();
    $_SESSION['newsletter_success'] = true;
} else {
    $_SESSION['newsletter_info'] = true;
}
$check->close();

header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '../index.php'));
exit;

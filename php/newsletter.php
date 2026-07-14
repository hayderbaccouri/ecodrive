<?php
include 'bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    if ($email && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Check if already subscribed
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
    }
}
header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '../index.php'));
exit;
?>

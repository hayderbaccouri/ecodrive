<?php
function sendEmail($to, $subject, $body, $replyTo = null) {
    $headers  = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "From: EcoDrive <noreply@ecodrive.tn>\r\n";
    if ($replyTo) $headers .= "Reply-To: $replyTo\r\n";
    
    // Log to file as backup
    $log = "[" . date('Y-m-d H:i:s') . "] To: $to | Subject: $subject\n";
    file_put_contents(__DIR__ . '/../private/logs/mail_log.txt', $log, FILE_APPEND | LOCK_EX);
    
    // Try to send real email, fallback to log only
    return @mail($to, $subject, $body, $headers);
}

function emailReservationConfirmation($user, $reservation, $car) {
    $body = "<h2>Confirmation de réservation</h2>"
          . "<p>Bonjour " . htmlspecialchars($user['nom']) . ",</p>"
          . "<p>Votre réservation pour <strong>" . htmlspecialchars($car['marque'] . ' ' . $car['modele']) . "</strong> a été confirmée.</p>"
          . "<p><strong>Date :</strong> " . htmlspecialchars($reservation['date_essai']) . "<br>"
          . "<strong>Heure :</strong> " . htmlspecialchars($reservation['heure_debut']) . " - " . htmlspecialchars($reservation['heure_fin']) . "</p>"
          . "<p>A bientôt chez EcoDrive !</p>";
    return sendEmail($user['email'], "Réservation confirmée — EcoDrive", $body);
}

function emailPasswordReset($email, $token, $scheme, $host) {
    $link = "$scheme://$host/php/reinitialiser-mot-de-passe.php?token=$token";
    $body = "<h2>Réinitialisation de mot de passe</h2>"
          . "<p>Cliquez sur le lien ci-dessous pour réinitialiser votre mot de passe :</p>"
          . "<p><a href='$link' style='display:inline-block;padding:12px 24px;background:#0A7DA8;color:#fff;text-decoration:none;border-radius:999px;font-weight:600'>Réinitialiser</a></p>"
          . "<p>Ce lien expirera dans 1 heure.</p>"
          . "<p>Si vous n'avez pas demandé cette réinitialisation, ignorez cet email.</p>";
    return sendEmail($email, "Réinitialisation de mot de passe — EcoDrive", $body);
}

function emailWelcome($user) {
    $body = "<h2>Bienvenue chez EcoDrive !</h2>"
          . "<p>Bonjour " . htmlspecialchars($user['nom']) . ",</p>"
          . "<p>Votre compte a été créé avec succès. Vous pouvez maintenant réserver des essais gratuits de voitures électriques.</p>"
          . "<p><a href='https://ecodrive.tn/php/catalogue.php' style='display:inline-block;padding:12px 24px;background:#0A7DA8;color:#fff;text-decoration:none;border-radius:999px;font-weight:600'>Parcourir le catalogue</a></p>";
    return sendEmail($user['email'], "Bienvenue chez EcoDrive !", $body);
}

function emailAdminNewReservation($adminEmail, $user, $car, $reservation) {
    $body = "<h2>Nouvelle réservation</h2>"
          . "<p><strong>Client :</strong> " . htmlspecialchars($user['nom']) . " (" . htmlspecialchars($user['email']) . ")</p>"
          . "<p><strong>Voiture :</strong> " . htmlspecialchars($car['marque'] . ' ' . $car['modele']) . "</p>"
          . "<p><strong>Date :</strong> " . htmlspecialchars($reservation['date_essai']) . " " . htmlspecialchars($reservation['heure_debut']) . " - " . htmlspecialchars($reservation['heure_fin']) . "</p>"
          . "<p><a href='https://ecodrive.tn/php/admin.php'>Gérer dans l'admin</a></p>";
    return sendEmail($adminEmail, "Nouvelle réservation — EcoDrive", $body);
}
?>

<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'php/PHPMailer-5.2.28/src/Exception.php';
require 'php/PHPMailer-5.2.28/src/PHPMailer.php';
require 'php/PHPMailer-5.2.28/src/SMTP.php';

$mail = new PHPMailer(true);

try {

    $mail_from_email = $_POST['email'] ?? '';
    $mail_from_name  = $_POST['name'] ?? '';
    $mail_category   = $_POST['category'] ?? '';
    $mail_message    = $_POST['message'] ?? '';

    // SMTP settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'ramanweber5.o@gmail.com'; // your gmail
    $mail->Password   = 'dqkovkgibvhfwkwr';       // gmail app password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;

    // Sender (MUST be your email)
    $mail->setFrom('ramanweber5.o@gmail.com', 'Portfolio Website');

    // Receiver (YOU)
    $mail->addAddress('raman_joshi@outlook.com', 'Raman');

    // Reply to user
    if (!empty($mail_from_email)) {
        $mail->addReplyTo($mail_from_email, $mail_from_name);
    }

    // Attachments
    if (!empty($_FILES['file_attach']['tmp_name'][0])) {
        foreach ($_FILES['file_attach']['tmp_name'] as $key => $tmp_name) {
            $mail->addAttachment($tmp_name, $_FILES['file_attach']['name'][$key]);
        }
    }

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Inquiry From Portfolio';

    $mail->Body = "
        <strong>Category:</strong> {$mail_category}<br>
        <strong>Name:</strong> {$mail_from_name}<br>
        <strong>Email:</strong> {$mail_from_email}<br><br>
        <strong>Message:</strong><br>{$mail_message}
    ";

    $mail->send();
    echo 'Message has been sent successfully';

} catch (Exception $e) {
    echo "Mailer Error: {$mail->ErrorInfo}";
}

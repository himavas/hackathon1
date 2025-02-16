<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"]=="POST")
{
       if(isset($_POST['Accept']))
    {
$user_mail="jashandeepk14904@gmail.com";
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // Gmail SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'jashandeepk14904@gmail.com';  // Your Gmail email address
        $mail->Password = 'segl lbpz prwu wpzk';  // Your Gmail password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Use STARTTLS
        $mail->Port = 587;  // SMTP port (587 for TLS)

        // Sender and recipient details
        $mail->setFrom('jashandeepk14904@gmail.com', 'Jashandeep Kaur');  // Your Gmail email address
        $mail->addAddress($user_mail);  // User's email address

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'Match Found';
        $mail->Body = "Someone Showed interest in your profile.Go and check it on our website.";

        // Send the email
        $mail->send();

    }
    catch (Exception $e) {
        echo "$user_email";
        echo "<br>";
        echo 'Email delivery failed. Error: ' . $mail->ErrorInfo;
    }
    }
}
?>
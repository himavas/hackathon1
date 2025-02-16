<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["Umail"];
$password = $_POST["Upass"];
$name=$_POST["Uname"];

    // Generate a random 4-digit OTP
    $otp = sprintf("%04d", mt_rand(0, 9999));

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // Gmail SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'guneet.works01@gmail.com';  // Your Gmail email address
        $mail->Password = 'bniu neht janp heqd';  // Your Gmail password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Use STARTTLS
        $mail->Port = 587;  // SMTP port (587 for TLS)

        // Sender and recipient details
        $mail->setFrom('guneet.works01@gmail.com', 'Guneet Kaur');  // Your Gmail email address
        $mail->addAddress($email);  // User's email address

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'Your OTP for Registration';
        $mail->Body = "Your OTP is: $otp";

        // Send the email
        $mail->send();

        // Redirect to OTP verification page
        header("Location: verify_otp.php?email=$email&otp=$otp&password=$password&name=$name");
    } catch (Exception $e) {
        echo 'Email delivery failed. Error: ' . $mail->ErrorInfo;
    }
}
?>

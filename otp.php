<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userEnteredOTP = $_POST["otp"];
    
    // Retrieve the previously generated and stored OTP for the user
    $storedOTP = $otp; // This should be fetched from your storage method

    if ($userEnteredOTP == $storedOTP) {
        // OTPs match, email is verified
        // You can update your database or set a flag for the user as verified
        echo "Email verified successfully!";
    } else {
        // Incorrect OTP
        echo "Invalid OTP. Please try again.";
    }
}
?>

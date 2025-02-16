<!DOCTYPE html>
<html>
<body style="font-family: Arial, sans-serif; text-align: center; background-color: #f4f4f4; margin: 50px;">

    <h1 style="color: #333;">OTP Verification</h1>

    <form action="" method="post" style="display: inline-block; margin-top: 20px; padding: 20px; background-color: #fff; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        OTP: <input type="text" name="Uotp" style="padding: 8px; margin-right: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;" required>
        <button type="submit" name="Verify" value="Verify" style="padding: 8px 20px; background-color: #4CAF50; color: #fff; border: none; border-radius: 4px; cursor: pointer;">Verify</button>
    </form>

<?php
include("dataconnection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET["email"]) && isset($_GET["otp"]) && isset($_GET["name"]) && isset($_GET["password"])) {
    $user_email = $_GET["email"];
    $user_otp = $_POST["Uotp"]; // User-entered OTP
    $expected_otp = $_GET["otp"]; // Expected OTP
    $user_name = $_GET["name"]; // User's name
    $user_password = $_GET["password"]; // User's password

    if ($user_otp == $expected_otp) {
        // Save user data in the database
        $conn = mysqli_connect("localhost", "root", "", "dance_users");

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO user_profile (name, email, password) VALUES (?, ?, ?)");
        
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }

        $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);
        $stmt->bind_param("sss", $user_name, $user_email, $hashed_password);

        // Execute the statement
        if ($stmt->execute()) {
            // Registration successful, redirect to index.php
            header("Location: index.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close connections
        $stmt->close();
        mysqli_close($conn);
    } else {
        echo "OTP verification failed. Please check your OTP.";
    }
}
?>

</body>
</html>

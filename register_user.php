<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dance_users";

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get form data
$name = mysqli_real_escape_string($conn, $_POST["Uname"]);
$email = mysqli_real_escape_string($conn, $_POST["Umail"]);
$password = mysqli_real_escape_string($conn, $_POST["Upass"]);
$password_confirm = mysqli_real_escape_string($conn, $_POST["Upassconfirm"]);

// Check if passwords match
if ($password !== $password_confirm) {
    echo "Passwords do not match!";
    exit();
}

// Check if user already exists
$sql_check = "SELECT * FROM user_profile WHERE email='$email' OR userName='$name';";
$result_check = mysqli_query($conn, $sql_check);

if (mysqli_num_rows($result_check) > 0) {
    echo "User already exists!";
    exit();
}

// Insert new user into the database
$sql_insert = "INSERT INTO user_profile (userName, email, password) VALUES ('$name', '$email', '$password')";

if (mysqli_query($conn, $sql_insert)) {
    // User successfully registered, login them in
    $_SESSION['user_name'] = $name;
    $_SESSION['user_mail'] = $email;
    $_SESSION['user_id'] = mysqli_insert_id($conn); // get the user ID of the newly inserted user

    // Redirect to profile page
    header("Location: profile.php");
    exit();
} else {
    echo "Error: " . $sql_insert . "<br>" . mysqli_error($conn);
}

// Close connection
mysqli_close($conn);
?>

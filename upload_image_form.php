<?php
include("dataconnection.php");
session_start();

$user_email = "";
$user_name = "";
$user_password="";

if (isset($_SESSION["mail"]) && isset($_SESSION["name"])) {  
    $user_email = $_SESSION["mail"];
    $user_name = $_SESSION["name"];
    $user_password = $_SESSION["password"];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get file details
    $imageName = $_FILES['image']['name'];
    $imageData = file_get_contents($_FILES['image']['tmp_name']);

    // Update database using prepared statement
    $query = "UPDATE user_profile SET profilePicture = ? WHERE email = ? AND userName = ?";
    
    // Assuming your user_profile table has columns like email, userName, and profilePicture
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sss", $imageData, $user_email, $user_name);

    // Execute the statement
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        header("Location:AfterLogin/profile.html");
    } else {
        echo 'Error uploading image: ' . mysqli_error($conn);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}
?>

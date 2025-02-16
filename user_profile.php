

<?php
include("dataconnection.php");
session_start();

$user_email = "";
$user_password = "";
$user_name = "";

if (isset($_SESSION["mail"]) && isset($_SESSION["name"]) && isset($_SESSION["password"])) {
    $user_email = $_SESSION["mail"];
    $user_name = $_SESSION["name"];
    $user_password = $_SESSION["password"];
}

if (isset($_POST["CreateUser"])) {
    $user_realname = mysqli_real_escape_string($conn, $_POST["Username"]);
    $user_gender = mysqli_real_escape_string($conn, $_POST["Usergender"]);
    $user_dob = mysqli_real_escape_string($conn, $_POST["Userdob"]);
    $user_age = mysqli_real_escape_string($conn, $_POST["Userage"]);
    $user_nation = mysqli_real_escape_string($conn, $_POST["Unation"]);
    $user_lang = mysqli_real_escape_string($conn, $_POST["Ulang"]);
    $user_marital = mysqli_real_escape_string($conn, $_POST["UMS"]);
    $user_height = mysqli_real_escape_string($conn, $_POST["Userheight"]);
    $user_education = mysqli_real_escape_string($conn, $_POST["Usereducation"]);

    /*======MAKE SQL QUERY======*/
    $sql = "INSERT INTO user_profile (userName, userRealname, gender, age, dob, nation, language, maritalStatus, height, email, password, highestEducation) VALUES ('$user_name', '$user_realname', '$user_gender', '$user_age', '$user_dob', '$user_nation', '$user_lang', '$user_marital', '$user_height', '$user_email', '$user_password', '$user_education')";

    if (mysqli_query($conn, $sql)) {
    
        include("user_preference.html");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

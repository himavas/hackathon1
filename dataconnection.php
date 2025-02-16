<?php
$servername="Localhost";
$username="root";
$password= "";
$dbname= "dance_users";
$conn=mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    echo "Connection Failed";
}
?>
<?php
session_start();
$servername = "localhost"; // Use "localhost" instead of "Localhost"
$username = "root";
$password = "";
$dbname = "dance_users";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

function login($conn)
{
    // Fetching data from form
    $email = mysqli_real_escape_string($conn, $_POST["LoginEmail"]);
    $password = mysqli_real_escape_string($conn, $_POST["LoginPassword"]);

    // Perform the query
    $sql = "SELECT * FROM user_profile WHERE email='$email';";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Verify the password
        if (password_verify($password, $row["password"])) {
            // Login Successful
            $_SESSION['user_id'] = $row['userId'];
            $_SESSION['user_name'] = $row['name']; // Assuming you have a 'name' field
            $_SESSION['user_mail'] = $row['email'];

            // Redirect to index.php after successful login
            header("Location: index.php");
            exit(); // Always call exit after header redirection
        } else {
            // Password verification failed
            echo "Invalid Credentials - Password";
        }
    } else {
        // No user found
        echo "Invalid Credentials - User";
    }

    // Free the result set
    mysqli_free_result($result);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    login($conn);
}

// Close database connection
mysqli_close($conn);
?>
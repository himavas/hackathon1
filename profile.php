<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="main_style.css"> <!-- Link to your main_style.css -->
    <style>
        body {
            padding-top: 0px; /* Adjust the padding value to your liking */
            font-family: 'Open Sans', sans-serif; /* Consistent font style */
            background-color: #f9f9f9; /* Light background color */
        }

        nav {
            background: white;
            color: rgb(53, 42, 42);
            position: sticky; /* Change 'fixed' to 'sticky' */
            top: 0; /* Stick to the top of the viewport */
            width: 100%; /* Make it full-width */
            z-index: 1000; /* Ensure it appears above other content */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); /* Add a black shadow */
        }

        .video-container {
            display: flex; /* Use flexbox for horizontal layout */
            flex-wrap: wrap; /* Allow wrapping to the next line */
            justify-content: center; /* Center the thumbnails */
            margin: 20px 0; /* Add some margin */
        }

        .video-item {
        margin: 10px; /* Space between video items */
        text-align: center; /* Center the title under the thumbnail */
    }

    .thumbnail {
        width: 250px; /* Increased fixed width for thumbnails */
        height: 300px; /* Increased fixed height for thumbnails */
        transition: transform 0.3s; /* Add transition for hover effect */
        border-radius: 8px; /* Rounded corners for thumbnails */
        object-fit: cover; /* Maintain aspect ratio and cover the area */
    }

    .thumbnail:hover {
        transform: scale(1.1); /* Scale effect on hover */
    }

        .upload-form {
            margin: 20px 0;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .upload-form input[type="text"],
        .upload-form input[type="file"] {
            margin-bottom: 10px;
            width: 100%; /* Full width for inputs */
            padding: 10px; /* Padding for inputs */
            border: 1px solid #FA4B37; /* Pink border */
            border-radius: 4px; /* Rounded corners */
        }

        .upload-form button {
            padding: 10px 20px;
            background-color: #FA4B37; /* Pink background */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s; /* Transition for hover effect */
        }

        .upload-form button:hover {
            background-color: #DF2771; /* Darker pink on hover */
        }

        /* Additional styles for titles */
        .video-item p {
            font-size: 14px; /* Font size for video titles */
            color: #2E3D49; /* Dark text color for titles */
            margin-top: 5px; /* Space between thumbnail and title */
        }
        .video-title {
    font-family:  'Dancing Script', cursive; /* Fun, cursive font */
    color: #FA4B37; 
    padding-left: 20px; /* Pink color for the title */
}
.feedback-section {
    margin-top: 20px; /* Add some space above the feedback section */
}

.feedback-form {
    display: none; /* Initially hidden */
    margin-top: 20px;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
}
        /* Keyframes for bounce animation */
        
        
    </style>
</head>
<body>

<nav>
    <a href="index.php" class="home"><span class="icon">🏠</span> Home</a>
    <?php session_start(); ?>
    <?php if (isset($_SESSION['user_id'])): ?>
        <span class="menu-icon user-icon ml-auto" onclick="toggleUser Menu()">
            <img src="images/profile_icon.png" alt="User  Icon" style="border-radius: 50%; width: 40px; height: 40px;">
        </span>
        <div class="user-menu" id="userMenu" style="display: none;">
            <a href="logout.php">Logout</a>
        </div>
    <?php endif; ?>
</nav>

<!--==============PROFILE PAGE ===================-->
<?php
include("dataconnection.php");

$user_id = "";

if (isset($_SESSION["user_id"])) {  
    $user_id = $_SESSION["user_id"];    
}

$sql = "SELECT * FROM user_profile WHERE userId = $user_id;";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
  echo '<h1 class="video-title">Your Videos</h1>'; // Title for the videos section
    // Check for uploaded videos
    $videoSql = "SELECT * FROM user_videos WHERE userId = $user_id;";
    $videoResult = $conn->query($videoSql);

    echo "<div class='video-container'>";
    if ($videoResult && $videoResult->num_rows > 0) {
        // Fetch and display video information
        while ($videoRow = $videoResult->fetch_assoc()) {
            // Display video thumbnail
            $thumbnailPath = "uploads/thumbnails/{$videoRow['thumbnail']}";
            $videoPath = "uploads/videos/{$videoRow['videoFile']}";
            $videoTitle = htmlspecialchars($videoRow['title']); // Escape title for safety

            if (file_exists($thumbnailPath)) {
                echo "<div class='video-item'>
                        <a href='$videoPath' target='_blank'>
                            <img src='$thumbnailPath' alt='Video Thumbnail' class='thumbnail'>
                        </a>
                        <p>$videoTitle</p>
                      </div>";
            } else {
                echo "<p>Thumbnail not found for video: {$videoRow['videoFile']}</p>";
            }
        }
    } else {
        echo "<p>You haven't uploaded any videos yet. Upload your first video!</p>";
    }
    echo "</div>";
} else {
    echo "<p>User profile not found.</p>";
}
?>

<div class='upload-form'>
    <form action='upload_video.php' method='post' enctype='multipart/form-data'>
        <input type='text' name='videoTitle' placeholder='Enter video title' required>
        <input type='file' name='videoFile' accept='video/mp4' required>
        <button type='submit'>Upload Video</button>
    </form>
</div>
<div class="feedback-section">
<button id="feedback-button" onclick="toggleFeedbackForm()" style="position: relative; z-index: 10;">Do you want feedback from an expert?</button>
    <div class="feedback-form" id="feedback-form" style="display: none;">
        <h3>Feedback Request</h3>
        <input type="text" placeholder="Your Availability" required>
        <input type="text" placeholder="Preferred Medium (Zoom)" required>
        <button type="button" onclick="submitFeedback()">Submit</button>
        <p>Calendar invite for the meeting will reach out to you shortly.</p>
    </div>
</div>
<script>
    function toggleFeedbackForm() {
    let feedbackForm = document.getElementById('feedback-form');
    let button = document.getElementById('feedback-button');

    if (feedbackForm.style.display === 'none' || feedbackForm.style.display === '') {
        feedbackForm.style.display = 'block';
        button.textContent = 'Hide Feedback Form';
    } else {
        feedbackForm.style.display = 'none';
        button.textContent = 'Do you want feedback from an expert?';
    }
}

    function submitFeedback() {
        // Logic to handle feedback submission
        alert('Feedback submitted! We will reach out to you shortly.');
        document.getElementById('feedback-form').style.display = 'none'; // Hide form after submission
    }
</script>
</body>
</html>
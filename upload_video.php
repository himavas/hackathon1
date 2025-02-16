<?php
session_start();
include("dataconnection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['videoFile'])) {
    $user_id = $_SESSION['user_id'];
    $videoFile = $_FILES['videoFile'];
    $videoTitle = $_POST['videoTitle']; // Get the video title from the form

    
    // Define the upload directory
    $uploadDir = 'uploads/videos/';
    $thumbnailDir = 'uploads/thumbnails/';
    
    // Create directories if they don't exist
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    if (!is_dir($thumbnailDir)) {
        mkdir($thumbnailDir, 0755, true);
    }

    // Generate a unique filename
    $videoFileName = uniqid() . '-' . basename($videoFile['name']);
    $videoFilePath = $uploadDir . $videoFileName;

    // Move the uploaded video to the upload directory
    if (move_uploaded_file($videoFile['tmp_name'], $videoFilePath)) {
        // Generate a thumbnail using FFmpeg
        $thumbnailFileName = uniqid() . '.jpg'; // Thumbnail filename
        $thumbnailFilePath = $thumbnailDir . $thumbnailFileName;

        // Specify the full path to the FFmpeg executable
        $ffmpegPath = 'C:\\ffmpeg-2025-02-13-git-19a2d26177-full_build\\bin\\ffmpeg.exe'; // Adjust this path as necessary

        // Command to generate a thumbnail from the video
        $ffmpegCommand = "$ffmpegPath -i \"$videoFilePath\" -ss 00:00:01.000 -vframes 1 \"$thumbnailFilePath\"";
        
        // Initialize output and status variables
        $output = [];
        $status = 0;

        // Execute the FFmpeg command
        exec($ffmpegCommand, $output, $status);

        // Check if the command was successful
        if ($status !== 0) {
            echo "Error generating thumbnail: " . implode("\n", $output);
        } else {
            // Insert video information into the database
            $sql = "INSERT INTO user_videos (userId, videoFile, thumbnail,title) VALUES (?, ?, ?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $user_id, $videoFileName, $thumbnailFileName, $videoTitle);
            $stmt->execute();

            // Redirect or display success message
            header("Location: profile.php");
            exit();
        }
    } else {
        echo "Error uploading video.";
    }
}
?>
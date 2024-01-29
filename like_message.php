<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['like_message'])) {
    // Assuming you have a function to handle user authentication
    include 'authenticate_user.php';

    // Get the user's username (you may need to modify this based on your authentication logic)
    $username = getAuthenticatedUsername();

    // Get the message_id from the form submission
    $message_id = $_POST['message_id'];

    // Check if the user has already liked the message
    $likeCheckQuery = "SELECT * FROM likes WHERE message_id = $message_id AND username = '$username'";
    $likeCheckResult = $conn->query($likeCheckQuery);

    if ($likeCheckResult->num_rows == 0) {
        // User hasn't liked the message yet, so insert a new like record
        $insertLikeQuery = "INSERT INTO likes (message_id, username) VALUES ($message_id, '$username')";
        $conn->query($insertLikeQuery);

        // Update the like_count in the messages table
        $updateLikeCountQuery = "UPDATE messages SET like_count = like_count + 1 WHERE id = $message_id";
        $conn->query($updateLikeCountQuery);
    } else {
        // User has already liked the message, so remove the like
        $deleteLikeQuery = "DELETE FROM likes WHERE message_id = $message_id AND username = '$username'";
        $conn->query($deleteLikeQuery);

        // Update the like_count in the messages table
        $updateLikeCountQuery = "UPDATE messages SET like_count = like_count - 1 WHERE id = $message_id";
        $conn->query($updateLikeCountQuery);
    }

    // Redirect back to the original page
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}
?>

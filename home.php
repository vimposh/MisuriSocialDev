<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Социальная сеть</title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="WKM.png" />
</head>
<body>
<script>
        if (/*@cc_on!@*/false || (!!window.MSInputMethodContext && !!document.documentMode)){window.location.href="IE/index.html";}
    </script>
<?php
// Assuming you have a function to establish a database connection
include 'header.php';
include 'db_connect.php';

// Include the necessary PHP files
include 'post_message.php';
include 'display_messages.php';
?>
<h1>^</h1>
<div class="message-container">
    <form method="post" action="" enctype="multipart/form-data">
        <label for="message"></label>
        <textarea style="overflow:auto;resize:none" name="message" id="message" rows="1" cols="50" placeholder="Write your message here..." required></textarea>
        <input type="file" name="photo" accept=".png, .jpg, .jpeg, .bmp">
        <input type="submit" name="send_message" value="Publicate">
    </form>
</div>
<div class="messanger">
<?php
include 'one_post_include.php';
// Fetch and display messages
$messagesPerPage = 40; // Number of messages to display per page
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1; // Get current page from URL parameter

// Calculate the offset for fetching messages
$offset = ($currentPage - 1) * $messagesPerPage;

$query = "SELECT * FROM messages ORDER BY created_at DESC LIMIT $messagesPerPage OFFSET $offset";
$result = $conn->query($query);


// Display messages
while ($row = $result->fetch_assoc()) {
    echo '<div class="message-container">';

    // Add a link to the user's personal page
    echo '<p style="color: #ffffff;"><strong><a href="personal_page.php?username=' . $row['username'] . '" style="color: #ffffff; text-decoration: none;">' . $row['username'] . '</a></strong> <em>(' . $row['created_at'] . ')</em></p>';

    echo "<p>" . htmlspecialchars($row['message']) . "</p>";

    // Display photo if available
    if (!empty($row['photo'])) {
        echo "<p><img src='" . $row['photo'] . "' alt='User Photo' style='max-width: 300px; max-height: 300px;'></p>";
    }

    echo '<form method="post" action="" class="like-form">';
    echo '<input type="hidden" name="message_id" value="' . $row['id'] . '">';

    // Fetch and display the like count for the current message
    $likeCountQuery = "SELECT COUNT(*) AS like_count FROM likes WHERE message_id = " . $row['id'];
    $likeCountResult = $conn->query($likeCountQuery);
    $likeCount = $likeCountResult->fetch_assoc()['like_count'];

    echo '<button type="submit" name="like_message">';
    echo 'Like <span class="like-count">' . $likeCount . '</span>'; // Display the like count
    echo '</button>';
    echo '</form>';

    // View Comments button form
    echo '<form method="get" action="comments.php" class="view-comments-form button-form">';
    echo '<input type="hidden" name="message_id" value="' . $row['id'] . '">';
    echo '<button type="submit" name="view_comments">';
    echo 'View Comments';
    echo '</button>';
    echo '</form>';

    echo '</div>';
}
?>
</div>
<h1>_</h1>

<div class="footer">
    <div class="pagination">
        <?php
        // Add pagination buttons
        $totalMessages = $conn->query("SELECT COUNT(*) FROM messages")->fetch_row()[0];
        $totalPages = ceil($totalMessages / $messagesPerPage);

        // Display previous button
        if ($currentPage > 1) {
            echo '<a href="?page=' . ($currentPage - 1) . '">Previous</a>';
        }

        // Display page numbers
        for ($i = 1; $i <= $totalPages; $i++) {
            echo '<a href="?page=' . $i . '" ' . ($i == $currentPage ? 'class="active"' : '') . '>' . $i . '</a> ';
        }

        // Display next button
        if ($currentPage < $totalPages) {
            echo '<a href="?page=' . ($currentPage + 1) . '">Next</a>';
        }
        ?>
    </div>
</div>
<?php include "click.php"; ?>
</body>
</html>

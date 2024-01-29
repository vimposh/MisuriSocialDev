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
include 'header.php';
include 'db_connect.php';
?>
<h1>d</h1>
<h1></h1>
<?php
// Check if message ID is provided in the URL
if (isset($_GET['message_id'])) {
    $messageId = $_GET['message_id'];

    // Fetch the specific message by ID
    $query = "SELECT * FROM messages WHERE id = $messageId";
    $result = $conn->query($query);

    // Display the single message
    if ($row = $result->fetch_assoc()) {
        echo '<div class="message-container">';

        echo '<p style="color: #ffffff;"><strong><a href="personal_page.php?username=' . $row['username'] . '" style="color: #ffffff; text-decoration: none;">' . $row['username'] . '</a></strong> <em>(' . $row['created_at'] . ')</em></p>';

        echo "<p>" . $row['message'] . "</p>";

        if (!empty($row['photo'])) {
            echo "<p><img src='" . $row['photo'] . "' alt='User Photo' style='max-width: 300px; max-height: 300px;'></p>";
        }

        // Display like button (if needed)
        echo '<form method="post" action="" class="like-form">';
        echo '<input type="hidden" name="message_id" value="' . $row['id'] . '">';
        echo '<button type="submit" name="like_message">';
        echo 'Like';
        echo '</button>';
        echo '</form>';

        // Display comments button (if needed)
        echo '<form method="get" action="comments.php" class="view-comments-form button-form">';
        echo '<input type="hidden" name="message_id" value="' . $row['id'] . '">';
        echo '<button type="submit" name="view_comments">';
        echo 'View Comments';
        echo '</button>';
        echo '</form>';

        echo '</div>';
    } else {
        echo '<p>No message found with the provided ID.</p>';
    }
} else {
    echo '<p>No message ID provided.</p>';
}
?>

</body>
</html>

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
include 'db_connect.php';

// Set the initial value for $messageId
$messageId = 83;

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Check if message ID is provided
    if (!empty($_POST['message_id'])) {
        // Update $messageId with the submitted value
        $messageId = $_POST['message_id'];
    }
}

// Fetch the specific message by ID
$query = "SELECT * FROM messages WHERE id = $messageId";
$result = $conn->query($query);

// Display the single message
if ($row = $result->fetch_assoc()) {
    echo '<div class="message-container">';

    echo '<p style="color: #ffffff;"><strong><a href="personal_page.php?username=' . $row['username'] . '" style="color: #ffffff; text-decoration: none;">' . $row['username'] . '</a></strong> <em>Pinned</em></p>';

    echo "<p>" . $row['message'] . "</p>";

    if (!empty($row['photo'])) {
        echo "<p><img src='" . $row['photo'] . "' alt='User Photo' style='max-width: 300px; max-height: 300px;'></p>";
    }

    // Display like button (if needed)
    echo '<form method="post" action="" class="like-form">';
    echo '<input type="hidden" name="message_id" value="' . $row['id'] . '">';
    echo '</form>';

    // Display comments button (if needed)
    echo '<form method="get" action="comments.php" class="view-comments-form button-form">';
    echo '<input type="hidden" name="message_id" value="' . $row['id'] . '">';
    echo '</form>';

    echo '</div>';
} else {
    echo '<p>No message found with the provided ID.</p>';
}
?>
</body>
</html>

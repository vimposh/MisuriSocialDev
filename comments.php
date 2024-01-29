<?php
session_start(); // Start the session

$mysqli = new mysqli("localhost", "", "", "");

if ($mysqli->connect_error) {
    die("Ошибка подключения к базе данных: " . $mysqli->connect_error);
}

include 'comment_functions.php';

// Check if the message_id is provided
if (isset($_GET['message_id'])) {
    $messageId = $_GET['message_id'];

    // Fetch the message details
    $messageQuery = "SELECT * FROM messages WHERE id = $messageId";
    $messageResult = $mysqli->query($messageQuery);

    if ($messageResult && $messageResult->num_rows > 0) {
        $message = $messageResult->fetch_assoc();
    } else {
        die("Сообщение не найдено.");
    }
} else {
    die("Идентификатор сообщения не предоставлен.");
}

// Handle adding a new comment
if (isset($_POST['add_comment'])) {
    // Check if the user is logged in (has an active session)
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $commentText = $_POST['comment_text'];

        // Add a new comment with the username from the session
        addComment($messageId, $username, $commentText, $mysqli);
    } else {
        // Redirect to login or handle accordingly if user is not logged in
        header("Location: login.php"); // Replace with your login page
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Комментарии</title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="WKM.png" />
    <script>
        if (/*@cc_on!@*/false || (!!window.MSInputMethodContext && !!document.documentMode)){window.location.href="IE/index.html";}
    </script>
</head>
<body>
    
    <div class="message-container">
        <p><strong><?= $message['username']; ?> <em>(<?= $message['created_at']; ?>)</em></strong></p>
        <p><?= $message['message']; ?></p>
    </div>

    <h2>Комментарии</h2>

    <?php
    displayComments($messageId, $mysqli);
    ?>

    <form method="post" action="">
        <input type="hidden" name="message_id" value="<?= $messageId; ?>">
        <label for="comment_text">Оставить комментарий:</label>
        <textarea name="comment_text" id="comment_text" rows="3" required></textarea>
        <input type="submit" name="add_comment" value="Комментировать">
    </form>

    <a href="index.php">Вернуться к сообщениям</a>
</body>
</html>

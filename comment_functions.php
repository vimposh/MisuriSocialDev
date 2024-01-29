<!-- comment_functions.php -->
<?php
function getComments($messageId, $mysqli)
{
    $query = "SELECT * FROM comments WHERE message_id = $messageId ORDER BY created_at ASC";
    $result = $mysqli->query($query);

    if (!$result) {
        die("Ошибка выполнения запроса: " . $mysqli->error);
    }

    return $result;
}

function displayComments($messageId, $mysqli)
{
    $comments = getComments($messageId, $mysqli);

    echo '<div class="comments-container">';
    while ($comment = $comments->fetch_assoc()) {
        echo '<div class="comment">';
        echo "<p><strong>" . $comment['username'] . " <em>(" . $comment['created_at'] . ")</em></strong></p>";
        echo "<p>" . $comment['comment_text'] . "</p>";
        echo '</div>';
    }
    echo '</div>';
}

function addComment($messageId, $username, $commentText, $mysqli)
{
    $commentText = $mysqli->real_escape_string($commentText);

    $query = "INSERT INTO comments (message_id, username, comment_text) VALUES ($messageId, '$username', '$commentText')";
    $result = $mysqli->query($query);

    if (!$result) {
        die("Ошибка выполнения запроса: " . $mysqli->error);
    }
}
?>

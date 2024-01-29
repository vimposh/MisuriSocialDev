<?php
$mysqli = new mysqli("localhost", "", "", "");

if ($mysqli->connect_error) {
    die("Ошибка подключения к базе данных: " . $mysqli->connect_error);
} else {
    echo "Успешное подключение к базе данных.";
}


$query = "SELECT messages.id, messages.username, messages.message, messages.photo, messages.created_at, COUNT(likes.id) AS like_count
          FROM messages
          LEFT JOIN likes ON messages.id = likes.message_id
          GROUP BY messages.id
          ORDER BY messages.created_at DESC";
$result = $mysqli->query($query);

if (!$result) {
    die("Ошибка выполнения запроса: " . $mysqli->error);
}

include 'comment_functions.php'; // Include the comment functions file
?>
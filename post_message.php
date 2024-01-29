<?php
session_start();

function hasBadWords($message, $badWords) {
    $message = strtolower($message);
    foreach ($badWords as $badWord) {
        if (strpos($message, $badWord) !== false) {
            return true;
        }
    }
    return false;
}

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$badWordsFile = "badwords.txt";
$badWords = file($badWordsFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

if (!$badWords) {
    echo '<h1>Ошибка при публикации сообщения</h1>';
    echo '<h1>Мы заметили то что вы пишите запретное слово!</h1>';
    echo '<h1>Рекомендуем вам перестать этого делать</h1>';
    echo '<h1>Сообщение не отправлено на сервера Webkm</h1>';
    die("Ошибка загрузки файла с плохими словами.");
}

if (isset($_POST['send_message'])) {
    $mysqli = new mysqli("localhost", "", "", "");

    if ($mysqli->connect_error) {
        die("Ошибка подключения к базе данных: " . $mysqli->connect_error);
    }

    $username = $_SESSION['username'];
    $message = $mysqli->real_escape_string($_POST['message']);
    $photo = '';

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/photo/';
        $uploadFile = $uploadDir . basename($_FILES['photo']['name']);

        if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
            $photo = $uploadFile;
        } else {
            die('Ошибка при загрузке файла.');
        }
    }

    if (hasBadWords($message, $badWords)) {
        //header("Location: pages/errorbat.php");
        echo '<h1>Ошибка при публикации сообщения</h1>';
        echo '<h1>Мы заметили то что вы пишите запретное слово!</h1>';
        echo '<h1>Рекомендуем вам перестать этого делать</h1>';
        echo '<h1>Сообщение не отправлено на сервера Webkm</h1>';
        die("Сообщение содержит недопустимые слова.");
    }

    $lastPostHash = isset($_SESSION['last_post_hash']) ? $_SESSION['last_post_hash'] : null;
    $currentPostHash = md5($message);

    if ($lastPostHash === $currentPostHash) {
        echo '<h1>Ошибка при публикации сообщения</h1>';
        echo '<h1>Мы заметили то что вы пишите второе сообщение одинакового содержания с старым сообщением</h1>';
        echo '<h1>Рекомендуем вам перестать этого делать</h1>';
        echo '<h1>PS : Так-же это могло быть вызвано перезагрузкой страницы в вашем браузере</h1>';
        die("Нельзя опубликовать два одинаковых поста подряд.");
    }

    $query = "INSERT INTO messages (username, message, photo) VALUES ('$username', '$message', '$photo')";
    $result = $mysqli->query($query);

    if (!$result) {
        die("Ошибка выполнения запроса: " . $mysqli->error);
    }

    $_SESSION['last_post_hash'] = $currentPostHash;

    $mysqli->close();
}

if (isset($_POST['like_message'])) {
    $mysqli = new mysqli("localhost", "", "", "");

    if ($mysqli->connect_error) {
        die("Ошибка подключения к базе данных: " . $mysqli->connect_error);
    }

    $username = $_SESSION['username'];
    $messageId = $_POST['message_id'];

    // Check if the user already liked the message
    $checkQuery = "SELECT * FROM likes WHERE message_id = $messageId AND username = '$username'";
    $checkResult = $mysqli->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        // User already liked, remove the like
        $removeLikeQuery = "DELETE FROM likes WHERE message_id = $messageId AND username = '$username'";
        $removeLikeResult = $mysqli->query($removeLikeQuery);
    } else {
        // User didn't like, add the like
        $addLikeQuery = "INSERT INTO likes (message_id, username) VALUES ($messageId, '$username')";
        $addLikeResult = $mysqli->query($addLikeQuery);
    }

    $mysqli->close();
}
?>

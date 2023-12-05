<?php
// Начало сеанса
session_start();

// Проверка наличия SESSION переменной "Username"
if (!isset($_SESSION['username'])) {
    // Перенаправление на index.php, если "Username" отсутствует
    header("Location: index.php");
    exit();
}

// Если нажата кнопка выхода
if (isset($_POST['logout'])) {
    // Уничтожение текущей сессии
    session_destroy();
    // Перенаправление на index.php после выхода
    header("Location: index.php");
    exit();
}

// Если "Username" существует, продолжаем выполнение кода

// Обработка отправки сообщения
if (isset($_POST['send_message'])) {
    // Подключение к базе данных (замените данными вашей конфигурации)
    $mysqli = new mysqli("localhost", "root", "", "ohio2");

    // Проверка наличия ошибок при подключении
    if ($mysqli->connect_error) {
        die("Ошибка подключения к базе данных: " . $mysqli->connect_error);
    }

    // Подготовка данных для вставки в базу данных
    $username = $_SESSION['username'];
    $message = $mysqli->real_escape_string($_POST['message']);

    // Вставка сообщения в базу данных
    $query = "INSERT INTO messages (username, message) VALUES ('$username', '$message')";
    $result = $mysqli->query($query);

    // Проверка наличия ошибок при выполнении запроса
    if (!$result) {
        die("Ошибка выполнения запроса: " . $mysqli->error);
    }

    // Закрытие соединения с базой данных
    $mysqli->close();
}

// Получение сообщений из базы данных
$mysqli = new mysqli("localhost", "root", "", "ohio2");
if ($mysqli->connect_error) {
    die("Ошибка подключения к базе данных: " . $mysqli->connect_error);
}

$query = "SELECT * FROM messages ORDER BY created_at DESC";
$result = $mysqli->query($query);

if (!$result) {
    die("Ошибка выполнения запроса: " . $mysqli->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Социальная сеть</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #2c3e50; /* Черный фон */
            color: #ecf0f1; /* Белый текст */
            margin: 0;
            padding: 20px;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #8e44ad; /* Фиолетовый текст */
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #8e44ad; /* Фиолетовая кнопка */
            color: #ecf0f1;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #673AB7; /* Темно-фиолетовый при наведении */
        }

        h2 {
            color: #8e44ad; /* Фиолетовый заголовок */
        }

        p {
            margin: 0;
            padding: 10px 0;
            border-bottom: 1px solid #34495e; /* Темно-серый оттенок для разделителя */
        }

        em {
            color: #3498db; /* Голубой цвет для времени */
        }

        form[name="logout"] {
            margin-top: 20px;
        }

    </style>
</head>
<body>
    <!-- Форма для отправки сообщения -->
    <form method="post" action="">
        <label for="message"></label>
        <input type="text" name="message" id="message" required>
        <input type="submit" name="send_message" value="Publicate">
    </form>

    <!-- Вывод сообщений всех пользователей -->
    <?php
    while ($row = $result->fetch_assoc()) {
        echo "<p><strong>" . $row['username'] . ":</strong> " . $row['message'] . " <em>(" . $row['created_at'] . ")</em></p>";
    }
    ?>

    <!-- Кнопка выхода -->
    <form method="post" action="" name="logout">
        <input type="submit" name="logout" value="Exit">
    </form>
</body>
</html>

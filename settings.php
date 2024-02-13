<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webkm</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="newstyle.css" />
</head>
<body>
    <?php
        include "navigate.php";
    ?>
<main>
<?php
session_start();

// Проверяем, авторизован ли пользователь
if (!isset($_SESSION['username'])) {
    // Редиректим на страницу авторизации, если пользователь не авторизован
    header("Location: login.php");
    exit();
}

// Подключаемся к базе данных (замените на ваши данные подключения)
$servername = "";
$username = "";
$password = "";
$dbname = "";

$conn = new mysqli($servername, $username, $password, $dbname);

// Проверяем соединение
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Имя пользователя из сессии
$username = $_SESSION['username'];

// Путь к папке с загруженными аватарками
$uploadDirectory = 'uploads/avatars/';

// Проверяем, был ли загружен файл
if (isset($_FILES['avatar'])) {
    $avatar = $_FILES['avatar'];

    // Генерируем уникальное имя для файла
    $avatarName = uniqid('avatar_') . '_' . $avatar['name'];

    // Полный путь к файлу на сервере
    $avatarPath = $uploadDirectory . $avatarName;

    // Перемещаем файл в папку с аватарками
    move_uploaded_file($avatar['tmp_name'], $avatarPath);

    // Обновляем путь к аватарке в базе данных
    $sql = "UPDATE users SET avatars = '$avatarPath' WHERE username = '$username'";

    if ($conn->query($sql) === TRUE) {
        echo "Аватар успешно загружен и обновлен.";
    } else {
        echo "Ошибка при обновлении аватара: " . $conn->error;
    }
}

// Заголовок страницы
echo "<h1 style='color: #fff;'>Настройки пользователя</h1>";

// Форма для загрузки аватара
echo "<form action=\"settings.php\" method=\"post\" enctype=\"multipart/form-data\">";
echo "<input style='color: #fff;' type=\"file\" name=\"avatar\" accept=\"image/*\">";
echo "<input type=\"submit\" value=\"Загрузить аватар\">";
echo "</form>";

// Вывод текущего аватара пользователя, если он есть
$sql = "SELECT avatars FROM users WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Выводим аватар пользователя
    while($row = $result->fetch_assoc()) {
        $avatarPath = $row["avatars"];
        if ($avatarPath) {
            echo "<h2 style='color: #fff;'>Текущий аватар:</h2>";
            echo "<img src=\"$avatarPath\" alt=\"Аватар пользователя\">";
        } else {
            echo "<h2 style='color: #fff;'>У вас еще нет аватара.</h2>";
        }
    }
} else {
    echo "Ошибка при получении информации о пользователе.";
}

$conn->close();
?>
</main>
</body>
</html>

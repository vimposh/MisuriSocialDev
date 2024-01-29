<!-- logout.php -->

<?php
// Запускаем сессию
session_start();

// Сбрасываем все данные сессии
session_unset();

// Уничтожаем сессию
session_destroy();

// Перенаправляем пользователя на главную страницу или другую страницу по вашему выбору
header("Location: index.html");
exit();
?>

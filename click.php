<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        h3 {
            color: black; /* Черный цвет текста для элементов h3 */
            margin: 0; /* Убираем внешние отступы у h3 */
        }

        #contextMenu {
            display: none;
            position: absolute;
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            border-radius: 8px; /* Скругленные углы */
        }

        .menuItem {
            padding: 8px 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .menuItem:hover {
            background-color: #f2f2f2;
        }

        .icon {
            margin-right: 8px;
        }
    </style>
    <title>Контекстное меню</title>
</head>
<body>
    <!-- Ваш контент здесь -->

    <div id="contextMenu">
        <div class="menuItem" onclick="reloadPage()">
            <h3><i class="fas fa-sync-alt icon"></i> Перезагрузить</h3>
        </div>
        <div class="menuItem" onclick="goBack()">
            <h3><i class="fas fa-arrow-left icon"></i> Назад</h3>
        </div>
        <div class="menuItem" onclick="goForward()">
            <h3><i class="fas fa-arrow-right icon"></i> Вперёд</h3>
        </div>
        <div class="menuItem" onclick="logout()">
            <h3><i class="fas fa-sign-out-alt icon"></i> Выход из аккаунта</h3>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        document.addEventListener("contextmenu", function (event) {
            event.preventDefault();

            const contextMenu = document.getElementById("contextMenu");

            contextMenu.style.display = "block";
            contextMenu.style.left = event.pageX + "px";
            contextMenu.style.top = event.pageY + "px";
        });

        document.addEventListener("click", function () {
            const contextMenu = document.getElementById("contextMenu");
            contextMenu.style.display = "none";
        });

        function reloadPage() {
            // Перезагрузка страницы
            location.reload();
        }

        function goBack() {
            // Переход на предыдущую страницу
            history.back();
        }

        function goForward() {
            // Переход на следующую страницу
            history.forward();
        }

        function logout() {
            // Переход на страницу exit.php
            window.location.href = "exit.php";
        }
    </script>
</body>
</html>

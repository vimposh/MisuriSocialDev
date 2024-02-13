<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webkm</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="newstyle.css" />
    <style>
    </style>
</head>
<body>
    <?php 
    // Подключаемся к базе данных
    include "db_connect.php"; 

    // Подключаем необходимые скрипты
    include "click.php";
    include "post_message.php"; 
    include "navigate.php";
    ?>

<main>
    <div class="publish-block">
        <form method="post" action="" enctype="multipart/form-data">
            <label for="message"></label>
            <textarea class="publish-textarea" name="message" id="message" placeholder="What's on your mind?" required></textarea>
            <input type="file" name="photo" accept=".png, .jpg, .jpeg, .bmp">
            <button class="publish-button" style="color: #fff;" name="send_message">Publish</button>
        </form>
    </div>

    <?php
    // Fetch and display messages
    $messagesPerPage = 40; // Number of messages to display per page
    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1; // Get current page from URL parameter

    // Calculate the offset for fetching messages
    $offset = ($currentPage - 1) * $messagesPerPage;

    $query = "SELECT * FROM messages ORDER BY created_at DESC LIMIT $messagesPerPage OFFSET $offset";
    $result = $conn->query($query);

    // Display messages
    while ($row = $result->fetch_assoc()) {
        echo '<div class="post">';
        echo '<div class="post-user-info">';
        echo '<div class="post-user-avatar">';
        
        // Получаем путь к аватарке из базы данных
        $username = $row['username'];
        $avatarQuery = "SELECT avatars FROM users WHERE username = '$username'";
        $avatarResult = $conn->query($avatarQuery);
        $avatarRow = $avatarResult->fetch_assoc();
        $avatarPath = $avatarRow ? $avatarRow['avatars'] : '/uploads/avatars/fan.png'; // Если аватарка не найдена, используем заглушку
        
        // Отображаем аватарку пользователя
        echo '<img src="' . $avatarPath . '" alt="User Avatar">';
        
        echo '</div>';
        echo '<a style="color: #fff;" href="personal_page.php?username=' . urlencode($row['username']) . '" >';
        echo '<div class="post-user-name" >' . htmlspecialchars($row['username']) . '</div>';
        echo '</a>';
        echo '</div>';
        echo '<div class="post-content">';
        echo '<p style="color: #ffffff;">' . htmlspecialchars($row['message']) . '</p>';
        
        // Display photo if available
        if (!empty($row['photo'])) {
            echo '<img style="  width: 40%;
            height: 40%;" src="' . $row['photo'] . '" alt="Post Image" class="post-image">';
        }
    
        echo '<div class="post-actions">';
        
        // Like button form
        echo '<form method="post" action="" class="like-form">';
        echo '<input type="hidden" name="message_id" value="' . $row['id'] . '">';
        echo '<button style="background-color: transparent;
        border: 1px solid #ffffff00;" type="submit" name="like_message">';
        
        // Fetch and display the like count for the current message
        $likeCountQuery = "SELECT COUNT(*) AS like_count FROM likes WHERE message_id = " . $row['id'];
        $likeCountResult = $conn->query($likeCountQuery);
        $likeCount = $likeCountResult->fetch_assoc()['like_count'];
    
        // Like icon
        echo '<i style="color: rgb(103, 58, 182);" class="fas fa-thumbs-up like-icon"></i>';
        // Like text with count
        echo '<span class="like-text">' . $likeCount . ' Likes</span>';
        
        echo '</button>';
        echo '</form>';
    
        // View Comments button form
        echo '<form method="get" action="comments.php" class="view-comments-form button-form">';
        echo '<input type="hidden" name="message_id" value="' . $row['id'] . '">';
        echo '<button style="background-color: transparent;
        border: 1px solid #ffffff00;" type="submit" name="view_comments">';
        // Comment icon
        echo '<i style="color: rgb(103, 58, 182);" class="fas fa-comments comment-icon"></i>';
        // Comment text
        echo '<span class="comment-text">View Comments</span>';
        echo '</button>';
        echo '</form>';
    
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    ?>
</main>
</body>
<script>
    // Получаем ссылку на элемент
    var loginElement = document.getElementById("loginos");

    // Проверяем, является ли устройство мобильным
    var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);

    // Если устройство мобильное, скрываем элемент
    if (isMobile) {
        loginElement.style.display = "none";
    }
</script>
</html>

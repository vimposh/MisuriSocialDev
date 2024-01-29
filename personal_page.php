<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Page</title>
    <link rel="shortcut icon" href="WKM.png" />
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    // Include the necessary PHP files
    include 'header.php';
    include 'db_connect.php';
    ?>
    <h1>s</h1>
    <?php
    // Retrieve username from the URL
    $username = $_GET['username'];

    // Fetch user details from the database using 'username'
    $userQuery = "SELECT * FROM users WHERE username = '$username'";
    $userResult = $conn->query($userQuery);

    if ($userResult->num_rows > 0) {
        $user = $userResult->fetch_assoc();
        echo '<div class="message-container">';
        echo "<h1>{$user['username']}!</h1>";
        echo '</div>';

        // Fetch messages for the user
        $messagesQuery = "SELECT * FROM messages WHERE username = '$username' ORDER BY created_at DESC";
        $messagesResult = $conn->query($messagesQuery);

        if ($messagesResult->num_rows > 0) {
            while ($row = $messagesResult->fetch_assoc()) {
                echo '<div class="message-container">';
                echo "<p><strong>" . $row['username'] . " <em>(" . $row['created_at'] . ")</em></strong></p>";
                echo "<p>" . $row['message'] . "</p>";
                echo '</div>';
            }
        } else {
            echo "<p>No messages found for this user.</p>";
        }
    } else {
        echo "<p>User not found.</p>";
    }

    // Close the database connection
    $conn->close();
    ?>
        <script>
        if (/*@cc_on!@*/false || (!!window.MSInputMethodContext && !!document.documentMode)){window.location.href="IE/index.html";}
    </script>
</body>
</html>

<?php
session_start(); // Start the session

$servername = "localhost";
$username = "";
$password = "";
$dbname = "";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $birthdate = $_POST["birthdate"];

    $check_username_sql = "SELECT * FROM users WHERE username='$username'";
    $check_email_sql = "SELECT * FROM users WHERE email='$email'";

    $check_username_result = $conn->query($check_username_sql);
    $check_email_result = $conn->query($check_email_sql);

    if ($check_username_result->num_rows > 0) {
        echo "Username is already taken. Please choose another one.";
    } elseif ($check_email_result->num_rows > 0) {
        echo "Email is already registered. Please use a different email.";
    } elseif (strlen($password) < 6 || strpos($password, ' ') !== false) {
        echo "Password must be at least 6 characters long and should not contain spaces.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Updated SQL query without gender, region, and language
        $sql = "INSERT INTO users (username, email, password, birthdate)
                VALUES ('$username', '$email', '$hashed_password', '$birthdate')";

        if ($conn->query($sql) === TRUE) {
            $_SESSION["username"] = $username;
            header("Location: home.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $login_username = $_POST["login_username"];
    $login_password = $_POST["login_password"];

    $login_sql = "SELECT * FROM users WHERE username='$login_username'";
    $result = $conn->query($login_sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($login_password, $row["password"])) {
            $_SESSION["username"] = $login_username;
            header("Location: home.php");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "User not found.";
    }
}

if (isset($_SESSION["username"])) {
    header("Location: home.php");
    exit();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Registration</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400&display=swap">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(to right, #1e1e1e, #500080);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        #container {
    display: flex;
    background: #2a2a2a;
    border-radius: 8px;
    overflow: hidden;
    width: 600px;
    margin: 40px; /* Add this line for a margin of 40 pixels */
}


        #login, #register {
            flex: 1;
            padding: 20px;
            box-sizing: border-box;
        }

        #login {
            background: #1e1e1e;
        }

        #register {
            background: #500080;
        }

        form {
            margin-top: 20px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="date"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background: #ffffff;
            color: #2a2a2a;
            padding: 10px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }
    </style>
        <link rel="shortcut icon" href="WKM.png" />
</head>
<body>
<script>
        if (/*@cc_on!@*/false || (!!window.MSInputMethodContext && !!document.documentMode)){window.location.href="IE/index.html";}
    </script>
    <div id="container">
        <div id="login">
            <h2>Добро пожаловать на Webkm.ru!</h2>
            <h2>Webkm это новая социальная сеть с возможностью переписки на стене</h2>
            <h2>Вы сейчас находитесь на странице регистрации в которой вы можете войти в аккаунт или зарегестрировать новый</h2>
            <h2>Удачи!</h2>
            <a href="https://t.me/webkm2">
                <img src="Files/images/telegram.png" alt="Изображение" style="width:55px;height:55px;border:0;">
            </a>
            <a href="https://vk.ru/webkm2">
                <img src="Files/images/vk.png" alt="Изображение" style="width:55px;height:55px;border:0;">
            </a>
            <a href="https://discord.gg/DecxxqP8">
                <img src="Files/images/discordd.png" alt="Изображение" style="width:55px;height:55px;border:0;">
            </a>
            <a href="https://www.youtube.com/channel/UCf71NNESaIHavwyKSYA6Swg">
                <img src="Files/images/youtube.png" alt="Изображение" style="width:55px;height:55px;border:0;">
            </a>
        </div>
    </div>
<div id="container">
    <div id="login">
        <h2>Login</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            Username: <input type="text" name="login_username" required><br>
            Password: <input type="password" name="login_password" required><br>
            <input type="submit" name="login" value="Login">
        </form>
    </div>

    <div id="register">
        <h2>Registration</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            Username: <input type="text" name="username" required><br>
            Email: <input type="email" name="email" required><br>
            Password: <input type="password" name="password" required><br>
            Birthdate: <input type="date" name="birthdate"><br>
            <input type="submit" name="register" value="Register">
        </form>
    </div>
</div>
<?php include "click.php"; ?>
</body>
</html>

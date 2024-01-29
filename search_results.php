<!-- search_results.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="WKM.png" />
    <style>
</style>

</head>

<body>
    <?php
    include 'header.php';
    ?>
    <h1>s</h1>
    <?php
    include 'db_connect.php';

    if (isset($_GET['search_query'])) {
        $searchQuery = mysqli_real_escape_string($conn, $_GET['search_query']);

        // Perform the search query
        $searchResult = $conn->query("SELECT * FROM messages WHERE message LIKE '%$searchQuery%' ORDER BY created_at DESC");

        // Display search results
        while ($row = $searchResult->fetch_assoc()) {
            echo '<div class="message-container">';
            echo '<p style="color: #ffffff;"><strong><a href="personal_page.php?username=' . $row['username'] . '" style="color: #ffffff; text-decoration: none;">' . $row['username'] . '</a></strong> <em>(' . $row['created_at'] . ')</em></p>';
            echo "<p>" . $row['message'] . "</p>";

            // Display photo if available
            if (!empty($row['photo'])) {
                echo "<p><img src='" . $row['photo'] . "' alt='User Photo' style='max-width: 300px; max-height: 300px;'></p>";
            }

            // ... (other display logic)

            echo '</div>';
        }
    } else {
        echo '<p>No search query provided.</p>';
    }
    ?>

</body>

</html>
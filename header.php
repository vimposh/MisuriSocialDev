<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webkm</title>
</head>

<body>
    <header>
        <script>
            if (/*@cc_on!@*/false || (!!window.MSInputMethodContext && !!document.documentMode)) {
                window.location.href = "IE/index.html";
            }
        </script>
        <h1 href="home.php">Webkm</h1>

                <!-- Форма поиска -->
                <form id="searchForm" method="get" action="search_results.php">
            <input type="text" name="search_query" id="search" placeholder="Enter your search query">
        </form>

        <nav>
            <a href="home.php">Home</a>
            <a href="about.php">About</a>
        </nav>

        <script>
            // JavaScript to submit the search form on Enter key press
            document.getElementById('search').addEventListener('keyup', function (event) {
                if (event.key === 'Enter') {
                    document.getElementById('searchForm').submit();
                }
            });
        </script>
    </header>

    <!-- Остальной контент страницы здесь -->

</body>

</html>

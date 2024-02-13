<header style="height: 32px;">
    <div>
        <h1>Webkm</h1>
    </div>
    <div class="search-bar">
        <form id="searchForm" method="get" action="search_results.php">
            <input type="text" name="search-input" id="search" style="width: 70%; padding: 8px; margin: 5px; box-sizing: border-box; border: none; border-radius: 20px;" placeholder="Enter your search query">
        </form>
    </div>
    <div>
        <a href="home.php">
            <button style="color: #fff;"><i class="fas fa-home icon"></i>Лента</button>
        </a>
    </div>
</header>
<nav>
<a href="home.php">
        <button><i class="fas fa-newspaper icon"></i>Лента</button>
    </a>
    <a href="personal_page.php?username=<?php echo $_SESSION['username']; ?>">
        <button><i class="fas fa-user icon"></i>Моя страница</button>
    </a>
<a href="settings.php">
            <button><i class="fas fa-cog icon"></i>Настройки</button>
        </a>
        <a href="about.php">
            <button><i class="fas fa-book"></i>Инфо</button>
        </a>
<a href="https://www.youtube.com/watch?v=AbuijWnr7MQ&t=188s"><img src="Files/images/ad.png" alt="Реклама" style="width: 100%;" /></a>
</nav>

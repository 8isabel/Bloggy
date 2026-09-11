<?php
session_start();
require 'db/con.php';

$blogs = [];
try {
    $stmt = $pdo->query("SELECT * FROM blogs ORDER BY created_at DESC");
    $blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $blogs = [];
}

function blog_preview($text) {
    $clean = str_replace('|||', "\n", $text);
    if (strlen($clean) > 140) {
        return substr($clean, 0, 140) . '...';
    }
    return $clean;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bloggy</title>
    <link rel="stylesheet" href="styles/index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <script src="scripts/login.js" defer></script>
    <script src="scripts/search.js" defer></script>
</head>
<body>
    <header>
        <h1>Bloggy</h1>
        <a id="home" href="index.php">Home</a>
        <a id="create" href="add.php">+</a>
        <?php if (isset($_SESSION['username'])): ?>
            <span id="userName"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
            <a id="logout" href="login/logout.php">Logout</a>
        <?php else: ?>
            <button type="button" id="login">Login</button>
        <?php endif; ?>
    </header>
    <div id="main">
        <div id="reclame1">
            <a href="https://www.pornhub.com">
            <img src="assets/kattenvoer-reclame.png" alt="kattenvoer-reclame" width="280px">
                </a>
        </div>
        <div id="Search">
            <div id="sorting">
                <input type="text" id="searchInput" placeholder="Search...">
                <select id="sort">
                    <option value="all">All</option>
                    <option value="scary">Scary</option>
                    <option value="news">News</option>
                    <option value="fun">Fun</option>
                </select>
            </div>
            <div id="blogPosts">
                <?php if (count($blogs) === 0): ?>
                    <div class="blog-post">
                        <div class="blog-post-left">
                            <img class="blog-foto">
                            <div>
                                <h2>Nog geen blogs</h2>
                                <p>Author: -</p>
                                <p>Date: -</p>
                                <p>Category: -</p>
                            </div>
                        </div>
                        <div class="blog-post-right">
                            <p>Log in en maak je eerste blog via +</p>
                        </div>
                    </div>
                <?php endif; ?>
                <?php foreach ($blogs as $blog): ?>
                    <div class="blog-post"
                         data-category="<?php echo htmlspecialchars($blog['category']); ?>"
                         data-title="<?php echo htmlspecialchars(strtolower($blog['title'])); ?>"
                         data-author="<?php echo htmlspecialchars(strtolower($blog['author'])); ?>">
                        <div class="blog-post-left">
                            <?php if (!empty($blog['image'])): ?>
                                <img class="blog-foto" src="<?php echo htmlspecialchars($blog['image']); ?>" alt="">
                            <?php else: ?>
                                <img class="blog-foto">
                            <?php endif; ?>
                            <div>
                                <h2><?php echo htmlspecialchars($blog['title']); ?></h2>
                                <p>Author: <?php echo htmlspecialchars($blog['author']); ?></p>
                                <p>Date: <?php echo htmlspecialchars(substr($blog['created_at'], 0, 10)); ?></p>
                                <p>Category: <?php echo htmlspecialchars(ucfirst($blog['category'])); ?></p>
                            </div>
                        </div>
                        <div class="blog-post-right">
                            <p><?php echo nl2br(htmlspecialchars(blog_preview($blog['content']))); ?></p>
                            <a class="read-more" href="view.php?id=<?php echo (int)$blog['id']; ?>">Read More...</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div id="reclame2">
            <a href="https://www.pornhub.com">
            <img src="assets/kattenvoer-reclame.png" alt="kattenvoer-reclame" width="280px">
                </a>
        </div>
    </div>

    <?php if (!isset($_SESSION['username'])): ?>
    <div id="loginModal" class="login-modal" aria-hidden="true">
        <div class="login-box" role="dialog" aria-labelledby="loginTitle">
            <button type="button" class="login-close" id="loginClose" aria-label="Close">&times;</button>
            <h2 id="loginTitle">Login</h2>
            <form id="loginForm" method="post" action="login/login.php">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <button type="submit" formaction="login/register.php">Register</button>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>
    <?php endif; ?>
</body>
</html>

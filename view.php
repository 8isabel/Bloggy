<?php
session_start();
require 'db/con.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare("SELECT * FROM blogs WHERE id = :id");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$blog = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$blog) {
    header("Location: index.php");
    exit;
}

$layout = $blog['layout'];
if (strpos($blog['content'], '|||') !== false) {
    $parts = explode('|||', $blog['content'], 2);
} else {
    $parts = explode("\n\n", $blog['content'], 2);
}
$part1 = $parts[0] ?? '';
$part2 = $parts[1] ?? '';
$image = $blog['image'] ?? '';
$title = $blog['title'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="styles/add.css">
    <link rel="stylesheet" href="styles/index.css">

    <script src="scripts/login.js" defer></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">

    <title><?php echo htmlspecialchars($title); ?> - Bloggy</title>
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

<main>

    <div class="left">
        <h3>Blog</h3>

        <div class="edit">
            <button type="button" class="<?php echo $layout === 'landscape' ? 'active' : ''; ?>" disabled>Landscape</button>
            <button type="button" class="<?php echo $layout === 'portrait' ? 'active' : ''; ?>" disabled>Portrait</button>
            <button type="button" class="<?php echo $layout === 'panorama' ? 'active' : ''; ?>" disabled>Panorama</button>
            <button type="button" class="<?php echo $layout === 'boomerang' ? 'active' : ''; ?>" disabled>Boomerang</button>
        </div>

        <div class="settings">
            <h3>Info</h3>

            <div class="group">
                <label>Category</label>
                <input type="text" value="<?php echo htmlspecialchars(ucfirst($blog['category'])); ?>" readonly>

                <label>Auteur</label>
                <input type="text" value="<?php echo htmlspecialchars($blog['author']); ?>" readonly>

                <label>Datum</label>
                <input type="text" value="<?php echo htmlspecialchars(substr($blog['created_at'], 0, 10)); ?>" readonly>
            </div>
        </div>
    </div>

    <div class="blog">

        <div class="right">

            <?php if ($layout === 'landscape'): ?>
            <div class="template landscape">
                <h4>Landscape</h4>
                <div class="template-content">
                    <div class="group">
                        <label>Titel</label>
                        <div class="view-title"><?php echo htmlspecialchars($title); ?></div>
                    </div>
                    <div class="view-image large <?php echo $image ? '' : 'empty'; ?>">
                        <?php if ($image): ?>
                            <img src="<?php echo htmlspecialchars($image); ?>" alt="">
                        <?php else: ?>
                            <span>Geen foto</span>
                        <?php endif; ?>
                    </div>
                    <div class="group">
                        <label>Tekst</label>
                        <div class="view-text"><?php echo nl2br(htmlspecialchars($part1)); ?></div>
                    </div>
                </div>
            </div>

            <?php elseif ($layout === 'portrait'): ?>
            <div class="template portrait">
                <h4>Portrait</h4>
                <div class="portrait-content">
                    <div class="group">
                        <label>Titel</label>
                        <div class="view-title"><?php echo htmlspecialchars($title); ?></div>
                    </div>
                    <div class="view-image portrait-image <?php echo $image ? '' : 'empty'; ?>">
                        <?php if ($image): ?>
                            <img src="<?php echo htmlspecialchars($image); ?>" alt="">
                        <?php else: ?>
                            <span>Geen foto</span>
                        <?php endif; ?>
                    </div>
                    <div class="text-box">
                        <label>Intro</label>
                        <div class="view-text"><?php echo nl2br(htmlspecialchars($part1)); ?></div>
                    </div>
                    <?php if ($part2 !== ''): ?>
                    <div class="text-box">
                        <label>Verhaal</label>
                        <div class="view-text"><?php echo nl2br(htmlspecialchars($part2)); ?></div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php elseif ($layout === 'panorama'): ?>
            <div class="template panorama">
                <h4>Panorama</h4>
                <div class="panorama-content">
                    <div class="group">
                        <label>Titel</label>
                        <div class="view-title"><?php echo htmlspecialchars($title); ?></div>
                    </div>
                    <div class="view-image panorama-image <?php echo $image ? '' : 'empty'; ?>">
                        <?php if ($image): ?>
                            <img src="<?php echo htmlspecialchars($image); ?>" alt="">
                        <?php else: ?>
                            <span>Geen foto</span>
                        <?php endif; ?>
                    </div>
                    <div class="panorama-text">
                        <div class="text-box">
                            <label>Tekst</label>
                            <div class="view-text"><?php echo nl2br(htmlspecialchars($part1)); ?></div>
                        </div>
                        <div class="text-box">
                            <label>Extra tekst</label>
                            <div class="view-text"><?php echo nl2br(htmlspecialchars($part2)); ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <?php else: ?>
            <div class="template boomerang">
                <h4>Boomerang</h4>
                <div class="boomerang-content">
                    <div class="group">
                        <label>Titel</label>
                        <div class="view-title"><?php echo htmlspecialchars($title); ?></div>
                    </div>
                    <div class="boomerang-block">
                        <div class="view-image <?php echo $image ? '' : 'empty'; ?>">
                            <?php if ($image): ?>
                                <img src="<?php echo htmlspecialchars($image); ?>" alt="">
                            <?php else: ?>
                                <span>Geen foto</span>
                            <?php endif; ?>
                        </div>
                        <div class="text-box">
                            <label>Tekst</label>
                            <div class="view-text tall"><?php echo nl2br(htmlspecialchars($part1)); ?></div>
                        </div>
                    </div>
                    <?php if ($part2 !== ''): ?>
                    <div class="boomerang-block reverse">
                        <div class="text-box">
                            <label>Tekst</label>
                            <div class="view-text tall"><?php echo nl2br(htmlspecialchars($part2)); ?></div>
                        </div>
                        <div class="view-image empty">
                            <span>Geen foto</span>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>

    <a class="post-btn" href="index.php">Back</a>

</main>

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

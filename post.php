<?php
session_start();
require("db/con.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: add.php");
    exit;
}

$title = trim($_POST['title'] ?? '');
$author = trim($_POST['author'] ?? '');
$category = trim($_POST['category'] ?? 'news');
$content = trim($_POST['content'] ?? '');
$layout = trim($_POST['layout'] ?? 'landscape');
$user_id = (int)$_SESSION['user_id'];

if ($title === '' || $content === '') {
    echo "Titel en tekst zijn verplicht. <a href='add.php'>Terug</a>";
    exit;
}

if ($author === '') {
    $author = $_SESSION['username'] ?? 'Anoniem';
}

$image = null;
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = __DIR__ . "/uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $ext = strtolower($ext);
    if (in_array($ext, $allowed, true)) {
        $filename = uniqid("blog_", true) . "." . $ext;
        $target = $uploadDir . $filename;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $image = "uploads/" . $filename;
        }
    }
}

try {
    $query = "INSERT INTO blogs (user_id, title, author, category, content, layout, image)
              VALUES (:user_id, :title, :author, :category, :content, :layout, :image)";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindValue(':title', $title);
    $stmt->bindValue(':author', $author);
    $stmt->bindValue(':category', $category);
    $stmt->bindValue(':content', $content);
    $stmt->bindValue(':layout', $layout);
    $stmt->bindValue(':image', $image);
    $stmt->execute();

    $newId = (int)$pdo->lastInsertId();
    if ($newId < 1) {
        echo "Blog kon niet worden opgeslagen in de database. <a href='add.php'>Terug</a>";
        exit;
    }

    header("Location: view.php?id=" . $newId);
    exit;
} catch (PDOException $e) {
    echo "Opslaan mislukt: " . htmlspecialchars($e->getMessage()) . " <a href='add.php'>Terug</a>";
}

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
$user_id = $_SESSION['user_id'];

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
    $filename = uniqid("blog_", true) . "." . strtolower($ext);
    $target = $uploadDir . $filename;
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $image = "uploads/" . $filename;
    }
}

try {
    $query = "INSERT INTO blogs (user_id, title, author, category, content, layout, image)
              VALUES (:user_id, :title, :author, :category, :content, :layout, :image)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':author', $author);
    $stmt->bindParam(':category', $category);
    $stmt->bindParam(':content', $content);
    $stmt->bindParam(':layout', $layout);
    $stmt->bindParam(':image', $image);
    $stmt->execute();

    $newId = $pdo->lastInsertId();
    header("Location: view.php?id=" . $newId);
    exit;
} catch (PDOException $e) {
    echo $e->getMessage();
}

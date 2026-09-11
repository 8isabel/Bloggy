<?php
session_start();
require("../db/con.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $password = $_POST['password'] ?? '';

    try {
        $query = "SELECT * FROM users WHERE name = :name";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['name'];
            header("Location: ../index.php");
            exit;
        } else {
            echo "Foute gegevens. <a href='../index.php'>Terug</a>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

<?php
session_start();
require("../db/con.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $password = $_POST['password'];

    try {
        $query = "SELECT * FROM login WHERE name = :name";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['name'];
            echo "Ingelogd!";
        } else {
            echo "Foute gegevens";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

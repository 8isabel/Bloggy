<?php

$db = __DIR__ . "/../login.sqlite";

try {
    $pdo = new PDO("sqlite:" . $db);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die($e->getMessage());
}

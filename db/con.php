<?php

$db = __DIR__ . "login.sqlite";;

try {
    $pdo = new PDO("sqlite:$db");
} catch (PDOException $e) {
    echo $e->getMessage();
}
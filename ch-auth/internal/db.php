<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db = "chito";

    try {
        $pdo = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
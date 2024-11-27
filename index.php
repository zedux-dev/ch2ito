<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require 'internal/utils.php';
    require 'internal/db.php';

    if(!isset($_GET["cmd"])) {
        forbidden();
    }

    $cmd = $_GET["cmd"];

    switch($cmd) {
        case "login":
            if(isset($_POST["username"]) && isset($_POST["password"]) && $_POST["username"] != "" && $_POST["password"] != "") {
                $username = $_POST["username"];
                $pwd = $_POST["password"];
                
                $stmt = $pdo->prepare("SELECT id, password FROM users WHERE username=:username");
                $stmt->bindValue(":username", $username);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if($row !== false) {
                    if(password_verify($pwd, $row["password"])) {
                        $tk = generate_jwt($username, $row["id"]);

                        echo json_encode([
                            "state" => "success",
                            "token" => $tk
                        ]);
                        exit;
                    }
                }
            }
            break;
    }

    forbidden();
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require 'internal/utils.php';
    require 'internal/db.php';

    $headers = apache_request_headers();
    $token = null;

    if(isset($headers['Authorization'])) {
        $matches = array();

        preg_match('/Bearer (.*)/', $headers['Authorization'], $matches);

        if(isset($matches[1])) {
            $token = $matches[1];
        }
    }

    if($token == null) forbidden();

    $userid = "";

    $stmt = $pdo->prepare('SELECT id FROM users WHERE MD5(CONCAT(username, "--.", id, "--.", :secret)) = :token;');
    $stmt->bindValue(":secret", SECRET);
    $stmt->bindValue(":token", $token);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if($row === false) forbidden();

    $userid = $row["id"];

    if(!isset($_GET["cmd"])) {
        forbidden();
    }

    $cmd = $_GET["cmd"];

    switch($cmd) {
        case 'list-devices':
            $stmt = $pdo->prepare('SELECT * FROM devices WHERE owner = :userid;');
            $stmt->bindValue(":userid", $userid);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode([
                "status" => "success",
                "data" => $rows
            ]);
            exit;
            break;

        case 'add-device':
            if(!isset($_POST["name"]) || !isset($_POST["sensors"]) || $_POST["name"] == "" || $_POST["sensors"] == "") {
                forbidden();
                exit;
            }

            $name = $_POST["name"];
            $sensors = $_POST["sensors"];
            $location = '{"lat":0,"lon":0,"alt":0,"prec":0}';
            $info = '{"battery":0,"cpu":0,"memory":0,"temp":0}';

            $stmt = $pdo->prepare("SELECT id FROM devices WHERE name = :name;");
            $stmt->bindValue(":name", $name);
            $stmt->execute();
            $rs = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if($rs !== false) {
                echo json_encode([
                    "status" => "error",
                    "code" => "name_in_use"
                ]);
                exit;
            }

            try {
                $stmt = $pdo->prepare("INSERT INTO devices (name, location, info, sensors, owner) VALUES (:name, :location, :info, :sensors, :owner);");
                $stmt->bindValue(":name", $name);
                $stmt->bindValue(":location", $location);
                $stmt->bindValue(":info", $info);
                $stmt->bindValue(":sensors", $sensors);
                $stmt->bindValue(":owner", $userid);
                $stmt->execute();

            } catch(PDOException $e) {
                echo json_encode([
                    "status" => "error",
                    "message" => "Failed to add device: ". $e->getMessage()
                ]);
                exit;
            }

            echo json_encode([
                "status" => "success"
            ]);
            exit;
            break;
    }

    forbidden();
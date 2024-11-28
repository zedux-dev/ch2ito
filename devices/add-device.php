<?php
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
<?php
    if(!isset($_GET["id"]) || !isset($_POST["name"]) || !isset($_POST["sensors"]) || $_POST["name"] == "" || $_POST["sensors"] == "" || $_GET["id"] == "") {
        forbidden();
        exit;
    }

    $deviceid = $_GET["id"];
    $name = $_POST["name"];
    $sensors = $_POST["sensors"];

    $stmt = $pdo->prepare("SELECT name FROM devices WHERE id = :id;");
    $stmt->bindValue(":id", $deviceid);
    $stmt->execute();
    $rs = $stmt->fetch(PDO::FETCH_ASSOC);

    if($rs === false) {
        echo json_encode([
            "status" => "error",
            "code" => "not_found"
        ]);
        exit;
    }

    try {
        $stmt = $pdo->prepare("UPDATE devices SET name=:name, sensors=:sensors WHERE id = :id AND owner = :owner;");
        $stmt->bindValue(":name", $name);
        $stmt->bindValue(":sensors", $sensors);
        $stmt->bindValue(":id", $deviceid);
        $stmt->bindValue(":owner", $userid);
        $stmt->execute();

    } catch(PDOException $e) {
        echo json_encode([
            "status" => "error",
            "message" => "Failed to edit device: ". $e->getMessage()
        ]);
        exit;
    }

    echo json_encode([
        "status" => "success"
    ]);
    exit;
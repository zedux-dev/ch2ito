<?php
    if(!isset($_GET["id"]) || $_GET["id"] == "") {
        forbidden();
        exit;
    }

    $deviceid = $_GET["id"];

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
        $stmt = $pdo->prepare("DELETE FROM devices WHERE id = :id AND owner = :owner;");
        $stmt->bindValue(":id", $deviceid);
        $stmt->bindValue(":owner", $userid);
        $stmt->execute();

    } catch(PDOException $e) {
        echo json_encode([
            "status" => "error",
            "code" => "faileddevice",
            "message" => $e->getMessage()
        ]);
        exit;
    }

    try {
        $stmt = $pdo->prepare("DELETE FROM records WHERE device = :deviceid;");
        $stmt->bindValue(":deviceid", $deviceid);
        $stmt->execute();

    } catch(PDOException $e) {
        echo json_encode([
            "status" => "error",
            "code" => "failedrecords",
            "message" => $e->getMessage()
        ]);
        exit;
    }

    echo json_encode([
        "status" => "success"
    ]);
    exit;
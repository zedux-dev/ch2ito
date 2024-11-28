<?php
    if(!isset($_POST["device"]) || !isset($_POST["date"]) || !isset($_POST["rkey"]) || !isset($_POST["rvalue"]) || $_POST["device"] == "" || $_POST["date"] == "" || $_POST["rkey"] == "" || $_POST["rvalue"] == "") {
        forbidden();
        exit;
    }

    $deviceid = $_POST["device"];
    $formattedDate = date('Y-m-d H:i:s', $_POST["date"]);
    $rkey = $_POST["rkey"];
    $rvalue = $_POST["rvalue"];
    
    $stmt = $pdo->prepare("SELECT id FROM devices WHERE id = :deviceid;");
    $stmt->bindValue(":deviceid", $deviceid);
    $stmt->execute();
    $rs = $stmt->fetch(PDO::FETCH_ASSOC);

    if($rs === false) {
        echo json_encode([
            "status" => "error",
            "code" => "no_device_found"
        ]);
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO records (device, date, rkey, rvalue) VALUES (:device, :date, :rkey, :rvalue);");
        $stmt->bindValue(":device", $device);
        $stmt->bindValue(":date", $date);
        $stmt->bindValue(":rkey", $rkey);
        $stmt->bindValue(":rvalue", $rvalue);
        $stmt->execute();

    } catch(PDOException $e) {
        echo json_encode([
            "status" => "error",
            "message" => "Failed to add record: ". $e->getMessage()
        ]);
        exit;
    }

    echo json_encode([
        "status" => "success"
    ]);
    exit;
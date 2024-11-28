<?php
    if(!isset($_GET['device']) || $_GET['device'] == "") forbidden();

    $date_start = "";
    $date_end = "";

    if(isset($_POST["start"]) && $_POST["start"] != "") {
        $date_start = date('Y-m-d H:i:s', $_POST["start"]);
    }

    if(isset($_POST["end"]) && $_POST["end"] != "") {
        $date_end = date('Y-m-d H:i:s', $_POST["end"]);
    }

    $stmt = $pdo->prepare("SELECT id FROM devices WHERE id = :deviceid AND owner = :owner;");
    $stmt->bindValue(":deviceid", $_GET['device']);
    $stmt->bindValue(":owner", $userid);
    $stmt->execute();
    $rs = $stmt->fetch(PDO::FETCH_ASSOC);

    if($rs === false) {
        echo json_encode([
            "status" => "error",
            "code" => "no_device_found"
        ]);
        exit;
    }

    $conditions = [];

    if($date_start != "") $conditions[] = 'date >= :start';
    if($date_end != "") $conditions[] = 'date <= :end';

    $filter = "";
    if(count($conditions) > 0) $filter = ' AND ' . implode(' AND ', $conditions);

    $stmt = $pdo->prepare('SELECT * FROM records WHERE device = :deviceid' . $filter . ';');
    $stmt->bindValue(":deviceid", $_GET['device']);
    if($date_start != "") $stmt->bindValue(":start", $date_start);
    if($date_end != "") $stmt->bindValue(":end", $date_end);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "status" => "success",
        "data" => $rows
    ]);
    exit;
<?php
    $stmt = $pdo->prepare('SELECT * FROM devices WHERE owner = :userid;');
    $stmt->bindValue(":userid", $userid);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "status" => "success",
        "data" => $rows
    ]);
    exit;
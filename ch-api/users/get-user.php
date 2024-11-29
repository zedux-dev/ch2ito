<?php
    if(!isset($userid) || $userid == "") forbidden();

    $stmt = $pdo->prepare("SELECT id, username, displayname FROM users WHERE id = :userid;");
    $stmt->bindValue(":userid", $userid);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if($row !== false) {
        echo json_encode([
            "status" => "success",
            "data" => $row
        ]);
        exit;
    }

    forbidden();
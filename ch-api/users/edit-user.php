<?php
    if(!isset($userid) || $userid == "") forbidden();

    $username = $_POST["username"];
    $password = $_POST["password"];
    $displayname = $_POST["displayname"];

    $pc = '';
    if($password != "") {
        $pc = ', password=:password';
    }
    try {
        $stmt = $pdo->prepare("UPDATE users SET username=:username, displayname=:displayname" . $pc . " WHERE id = :userid;");
        $stmt->bindValue(":userid", $userid);
        $stmt->bindValue(":username", $username);
        $stmt->bindValue(":displayname", $displayname);
        if($password != "") {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $stmt->bindValue(":password", $hash);
        }
        $stmt->execute();
        
    } catch (PDOException $e) {
        echo json_encode([
            "status" => "error",
            "message" => $e->getMessage()
        ]);
        exit;
    }

    echo json_encode([
        "status" => "success"
    ]);
    exit;

    forbidden();
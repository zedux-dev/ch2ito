<?php
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
    if(!isset($headers['token_expires'])) forbidden();

    $currentTime = time();

    if($currentTime > $headers['token_expires']) {
        echo json_encode([
            "status" => "error",
            "code" => "tokenexpired"
        ]);
        exit;
    }

    $userid = "";

    $stmt = $pdo->prepare('SELECT id FROM users WHERE MD5(CONCAT(username, "--.", id, "--.", :secret, "--.", :expire)) = :token;');
    $stmt->bindValue(":secret", SECRET);
    $stmt->bindValue(":token", $token);
    $stmt->bindValue(":expire", $headers['token_expires']);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if($row === false) forbidden();

    $userid = $row["id"];

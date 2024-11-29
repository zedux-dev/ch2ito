
<?php
    $url = "http://ch2ito.it/ch-api/index.php?cmd=get-user";
    // $postData = [
    //     'key1' => 'value1',
    //     'key2' => 'value2',
    // ];

    // $jsonData = json_encode($postData);

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    // curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

    $headers = [
        'Authorization: Bearer ' . $_COOKIE["token"],
        'token_expires: ' . $_COOKIE["token_expires"],
    ];

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
    // echo 'Error: ' . curl_error($ch);
    } else {
        if($response != "") {
            $json = json_decode($response, true);
            $currentuser = $json["data"];
        } else {
            unset($_COOKIE["token"]);
            unset($_COOKIE["token_expires"]);
            setcookie("token", "", time()-(60*60*24*7));
            setcookie("token_expires", "", time()-(60*60*24*7));
            header("Location: /panel/login.php");
            exit; 
        }
    }

    curl_close($ch);
<?php
function sensors_map($n) {
    return ucfirst($n["key"]) . ' (' . $n["unit"] . ')';
}

function getDevice($id) {
    $ds = getDevices();
    
    foreach($ds as $d) {
        if($d["#"] == $id) {
            return $d;
        }
    }

    return null;
}

function getDevices() {
    $data = [];

    $url = "http://ch2ito.it/ch-api/index.php?cmd=list-devices";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
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
            
            foreach($json["data"] as $row) {
                $sensors = array_map('sensors_map', json_decode($row["sensors"], true));
                $info = json_decode($row["info"], true);

                $data[] = [
                    "#" => $row["id"],
                    "name" => $row["name"],
                    "sensors" => implode(", ", $sensors),
                    "battery" => $info["battery"] . "%"
                ];
            }
        }
    }

    curl_close($ch);

    return $data;
}
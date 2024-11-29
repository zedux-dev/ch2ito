<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require 'internal/utils.php';
    require 'internal/db.php';
    require 'internal/auth.php';
    
    if(!isset($_GET["cmd"])) {
        forbidden();
    }
    
    $cmd = $_GET["cmd"];

    switch($cmd) {
        case 'list-devices':
            require 'devices/list-devices.php';
            break;

        case 'add-device':
            require 'devices/add-device.php';
            break;

        case 'edit-device':
            require 'devices/edit-device.php';
            break;

        case 'delete-device':
            require 'devices/delete-device.php';
            break;

        case 'list-records':
            require 'records/list-records.php';
            break;

        case 'add-record':
            require 'records/add-record.php';
            break;

        case 'get-user':
            require 'users/get-user.php';
            break;

        case 'edit-user':
            require 'users/edit-user.php';
            break;
    }

    forbidden();
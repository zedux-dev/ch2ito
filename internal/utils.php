<?php
    define('SECRET', '');
    

    function forbidden() {
        http_response_code(401);
        exit;
    }

    function generate_jwt($username, $id) {
        $tk = md5($username . "--." . $id . "--." . SECRET);
        return $tk;
    }
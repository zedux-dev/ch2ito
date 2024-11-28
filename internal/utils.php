<?php
    define('SECRET', 'banana');

    function forbidden() {
        http_response_code(401);
        exit;
    }

    function generate_jwt($username, $id) {
        $expire = strtotime('+2 days');
        $tk = md5($username . "--." . $id . "--." . SECRET . '--.' . $expire);

        return [$tk, $expire];
    }
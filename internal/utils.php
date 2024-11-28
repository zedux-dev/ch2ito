<?php
    define('SECRET', 'banana');
    
    function forbidden() {
        http_response_code(401);
        exit;
    }
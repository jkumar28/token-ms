<?php
date_default_timezone_set('Asia/Kolkata');

if(isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST']=='localhost'){
    defined('DB_HOST')          OR define('DB_HOST','localhost'); 
    defined('DB_USER')          OR define('DB_USER','root'); 
    defined('DB_PASS')          OR define('DB_PASS',''); 
    defined('DB_NAME')          OR define('DB_NAME','token_ms'); 
}
else{
    defined('DB_HOST')          OR define('DB_HOST','localhost'); 
    defined('DB_USER')          OR define('DB_USER','token_ms'); 
    defined('DB_PASS')          OR define('DB_PASS','token_ms'); 
    defined('DB_NAME')          OR define('DB_NAME','token_ms'); 
}

$pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASS, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

$pdo->exec("SET time_zone = '+05:30'");
<?php
$protocol =  $_SERVER["REQUEST_SCHEME"] === 'http' ? 'http' : 'https';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';


$scripr_dir = dirname($_SERVER['SCRIPT_NAME']);
$explode_str = explode('/', $scripr_dir);
$base_path = '/' . $explode_str[1];

define("BASE_URL", $protocol . '://' . $host . $base_path);
define("ASSETS_URL", BASE_URL . "/assets");
define('CSS_URL', ASSETS_URL . '/css');
define('JS_URL', ASSETS_URL . '/js');
define('IMG_URL', ASSETS_URL . '/images');

//navigation links
define("NAV_LINKS", [
    [
        'name' => "Home",
        'link' => "#"
    ],
    [
        'name' => "Shop",
        'link' => "#"
    ],
    [
        'name' => "Pages",
        'link' => "#"
    ],
    [
        'name' => "Blog",
        'link' => "#"
    ],
    [
        'name' => "About Us",
        'link' => "#"
    ],
    [
        'name' => "Contact US",
        'link' => "#"
    ],

]);




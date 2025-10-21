<?php

$host = "127.0.0.1";
$dbname = "SHOPERY";
$username = "root";
$password = "Wisdom@123"; // substitute for env variablrs

$pdo_options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false
];
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password, $pdo_options);
} catch (PDOException $e) {
    die("Connection Failed: " . $e->getMessage());
}

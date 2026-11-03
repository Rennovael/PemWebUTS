<?php
$host = '127.0.0.1';
$db   = 'inventaris_mvc';
$user = 'root';
$pass = ''; // MAMP biasanya root; sesuaikan dengan konfigurasi lokal
$port = '3306'; // MAMP sering 8889

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
return new PDO($dsn, $user, $pass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
]);

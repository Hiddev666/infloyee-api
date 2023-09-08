<?php

require __DIR__ . '/vendor/autoload.php';

// Load .ENV
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/');
$dotenv->load();

$server = $_ENV['DB_SERVER'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];
$db = $_ENV['DB_NAME'];

try {
    $conn = mysqli_connect($server, $username, $password, $db);
} catch (Exception $e) {
    echo "Message : $e";
}


?>
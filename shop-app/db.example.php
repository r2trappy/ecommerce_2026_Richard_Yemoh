<?php
$host    = 'localhost';
$db_user = 'YOUR_DB_USERNAME';
$db_pass = 'YOUR_DB_PASSWORD';
$db_name = 'YOUR_DB_NAME';

$conn = new mysqli($host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
$conn->set_charset('utf8mb4');

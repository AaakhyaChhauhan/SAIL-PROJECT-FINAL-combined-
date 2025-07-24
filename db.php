<?php
$host = "sql12.freesqldatabase.com";
$user = "sql12791553";
$password = "B9Sva3lRQs";
$database = "sql12791553";
$port = 3306;

$conn = new mysqli($host, $user, $password, $database, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

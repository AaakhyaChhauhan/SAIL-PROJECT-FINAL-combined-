<?php
$conn = new mysqli(YOUR DATABASE DETAILS);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

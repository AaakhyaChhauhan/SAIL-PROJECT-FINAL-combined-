<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$host = "your_host";
$username = "your_username";
$password = "your_password";
$dbname = "your_db";

$conn = new mysqli($host, $user, $password, $dbname, $port);

if (isset($_FILES['invoice_file'])) {
    $filename = $_FILES['invoice_file']['name'];
    $tmpname = $_FILES['invoice_file']['tmp_name'];
    $target = "uploads/" . basename($filename);

    if (!is_dir("uploads")) {
        mkdir("uploads");
    }

    move_uploaded_file($tmpname, $target);

    // Insert dummy data
    $conn->query("INSERT INTO invoices (vendor_name, status, uploaded_by, created_at, amount) 
    VALUES ('sample_vendor', 'Pending', '$username', NOW(), 1000)");
}

header("Location: dashboard.php");
exit();

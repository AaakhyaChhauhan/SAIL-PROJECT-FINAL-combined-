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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['invoice_id'])) {
    $invoiceId = intval($_POST['invoice_id']);
    $conn->query("UPDATE invoices SET status = 'rejected' WHERE invoice_id = $invoiceId");
}

header("Location: dashboard.php");
exit();
?>

<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$host = "sql12.freesqldatabase.com";
$user = "sql12791553";
$password = "B9Sva3lRQs";
$dbname = "sql12791553";
$port = 3306;

$conn = new mysqli($host, $user, $password, $dbname, $port);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['invoice_id'])) {
    $invoiceId = intval($_POST['invoice_id']);
    $conn->query("UPDATE invoices SET status = 'rejected' WHERE invoice_id = $invoiceId");
}

header("Location: dashboard.php");
exit();
?>

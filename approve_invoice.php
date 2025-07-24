<?php
// approve_invoice.php
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
    $update = $conn->query("UPDATE invoices SET status = 'approved' WHERE invoice_id = $invoiceId");

    if ($update) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Failed to approve invoice.";
    }
} else {
    echo "Invalid request.";
}
?>

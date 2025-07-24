<?php
// approve_invoice.php
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

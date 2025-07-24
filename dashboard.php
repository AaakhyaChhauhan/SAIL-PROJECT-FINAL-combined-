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

// Handle approve/reject action
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['invoice_id'];
    $action = $_POST['action'];
    $status = ($action == 'approve') ? 'approved' : 'rejected';
    $conn->query("UPDATE invoices SET status='$status' WHERE invoice_id=$id");
}

// Total invoices
$result = $conn->query("SELECT COUNT(*) AS total FROM invoices");
$totalInvoices = $result->fetch_assoc()['total'];

// Sales data for chart
$salesData = $conn->query("SELECT MONTH(created_at) as month, SUM(amount) as total FROM sales_data GROUP BY MONTH(created_at)");
$months = $totals = [];
while ($row = $salesData->fetch_assoc()) {
    $months[] = date('F', mktime(0, 0, 0, $row['month'], 10));
    $totals[] = $row['total'];
}

// Pie chart: invoice status
$statusData = $conn->query("SELECT status, COUNT(*) as count FROM invoices GROUP BY status");
$statusLabels = $statusCounts = [];
while ($row = $statusData->fetch_assoc()) {
    $statusLabels[] = $row['status'];
    $statusCounts[] = $row['count'];
}

// Pending invoices
$pending = $conn->query("SELECT * FROM invoices WHERE status='pending'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Vendor Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: Arial; background: #f2f2f2; margin: 0; }
        .header {
            background-color: #003366; color: white; padding: 20px; text-align: center;
            display: flex; justify-content: space-between; align-items: center;
        }
        .header h2 { margin: 0 auto; }
        .logout-btn {
            position: absolute; right: 20px; top: 20px;
            background: #dc3545; color: white; padding: 10px 15px; border: none;
            border-radius: 5px; text-decoration: none;
        }
        .card {
            background: white; padding: 20px; margin: 20px auto; width: 90%;
            max-width: 1000px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .charts { display: flex; flex-wrap: wrap; justify-content: space-around; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: center; }
        .action-btn { padding: 5px 10px; border: none; border-radius: 4px; }
        .approve { background: #28a745; color: white; }
        .reject { background: #dc3545; color: white; }
    </style>
</head>
<body>

<div class="header">
    <h2>📊 Vendor Dashboard</h2>
    <a href="logout.php" class="logout-btn">Logout</a>
</div>

<div class="card">
    <h3>Total Invoices Uploaded: <?php echo $totalInvoices; ?></h3>
</div>

<div class="card charts">
    <div style="width: 45%;">
        <h4>Monthly Sales</h4>
        <canvas id="salesChart"></canvas>
    </div>
    <div style="width: 45%;">
        <h4>Invoice Status</h4>
        <canvas id="statusChart"></canvas>
    </div>
</div>

<div class="card">
    <h4>Pending Invoices</h4>
    <table>
        <tr>
            <th>ID</th>
            <th>Vendor</th>
            <th>Amount</th>
            <th>Uploaded By</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $pending->fetch_assoc()): ?>
        <tr>
            <td><?= $row['invoice_id'] ?></td>
            <td><?= $row['vendor_name'] ?></td>
            <td><?= $row['amount'] ?></td>
            <td><?= $row['uploaded_by'] ?></td>
            <td><?= $row['created_at'] ?></td>
            <td>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="invoice_id" value="<?= $row['invoice_id'] ?>">
                    <button name="action" value="approve" class="action-btn approve">Approve</button>
                </form>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="invoice_id" value="<?= $row['invoice_id'] ?>">
                    <button name="action" value="reject" class="action-btn reject">Reject</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

<!-- Floating Chatbot Button -->
<div style="position: fixed; bottom: 30px; right: 30px; z-index: 9999;">
  <button onclick="window.open('https://replit.com/@shizworkstuff/chatbot-of-PROJECT', '_blank', 'width=500,height=600')" 
    style="background-color:#003366; color:white; padding:15px 20px; border:none; border-radius:50%; font-size:22px; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
    💬
  </button>
</div>

<script>
const ctx1 = document.getElementById('salesChart').getContext('2d');
new Chart(ctx1, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($months); ?>,
        datasets: [{
            label: 'Total Sales',
            data: <?php echo json_encode($totals); ?>,
            backgroundColor: '#007bff'
        }]
    }
});

const ctx2 = document.getElementById('statusChart').getContext('2d');
new Chart(ctx2, {
    type: 'pie',
    data: {
        labels: <?php echo json_encode($statusLabels); ?>,
        datasets: [{
            data: <?php echo json_encode($statusCounts); ?>,
            backgroundColor: ['#28a745', '#ffc107', '#dc3545']
        }]
    }
});
</script>

</body>
</html>

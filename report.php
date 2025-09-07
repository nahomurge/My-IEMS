<?php
include 'db.php';

$selected_month = isset($_POST['month']) ? $_POST['month'] : date('Y-m');
$report = $conn->query("SELECT type, SUM(amount) as total FROM transactions WHERE DATE_FORMAT(date,'%Y-%m')='$selected_month' GROUP BY type");

$income = 0;
$expense = 0;
while($row = $report->fetch_assoc()){
    if($row['type'] == 'income') $income = $row['total'];
    if($row['type'] == 'expense') $expense = $row['total'];
}
$balance = $income - $expense;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Monthly Report</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        @media print {
            .btn, form { display: none; }
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Monthly Report</h1>

    <form method="post">
        <label>Select Month:</label>
        <input type="month" name="month" value="<?= $selected_month ?>" required>
        <button type="submit" class="btn">View Report</button>
    </form>

    <div class="summary">
        <div>Income: $<?= number_format($income,2) ?></div>
        <div>Expense: $<?= number_format($expense,2) ?></div>
        <div>Balance: $<?= number_format($balance,2) ?></div>
    </div>

    <canvas id="reportChart" width="400" height="200"></canvas>

    <a href="index.php" class="btn">Back to Dashboard</a>
    <button onclick="window.print();" class="btn">Print Report</button>
</div>

<script>
    const ctx = document.getElementById('reportChart').getContext('2d');
    const reportChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Income', 'Expense', 'Balance'],
            datasets: [{
                label: 'Amount in USD',
                data: [<?= $income ?>, <?= $expense ?>, <?= $balance ?>],
                backgroundColor: ['#28a745','#dc3545','#007bff']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: {
                    display: true,
                    text: 'Monthly Income vs Expense'
                }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
</body>
</html>

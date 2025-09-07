<?php
include 'db.php';

// Delete transaction
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $conn->query("DELETE FROM transactions WHERE id=$id");
    // Reset AUTO_INCREMENT to maintain sequential IDs
    $conn->query("ALTER TABLE transactions AUTO_INCREMENT = 1");
    header('Location: index.php');
}

// Fetch transactions
$result = $conn->query('SELECT * FROM transactions ORDER BY date DESC');
$income = $conn->query("SELECT SUM(amount) as total FROM transactions WHERE type='income'")->fetch_assoc()['total'];
$expense = $conn->query("SELECT SUM(amount) as total FROM transactions WHERE type='expense'")->fetch_assoc()['total'];
$balance = $income - $expense;
?>

<!DOCTYPE html>
<html>
<head>
<title>Nahom Income & Expense System</title>
<link rel='stylesheet' href='style.css'>
</head>
<body>
    <div>
<h1>Nahom</h1>
<div class='container'>
<h1>Income & Expense Management</h1>
<div class='summary'>
<div>Income: $<?= number_format($income,2) ?></div>
<div>Expense: $<?= number_format($expense,2) ?></div>
<div>Balance: $<?= number_format($balance,2) ?></div>
</div>
<a href='add_transaction.php' class='btn'>Add Transaction</a>
<a href='report.php' class='btn'>View Report</a>
<table>
<tr><th>Type</th><th>Amount</th><th>Category</th><th>Description</th><th>Date</th><th>Actions</th></tr>
<?php while($row = $result->fetch_assoc()): ?>
<tr>
<td><?= ucfirst($row['type']) ?></td>
<td>$<?= number_format($row['amount'],2) ?></td>
<td><?= $row['category'] ?></td>
<td><?= $row['description'] ?></td>
<td><?= $row['date'] ?></td>
<td>
    <a href='edit.php?id=<?= $row['id'] ?>' class='btn'>Edit</a>
    <a href='index.php?delete=<?= $row['id'] ?>' class='btn' style='background-color: red;' onclick="return confirm('Are you sure?')">Delete</a>
</td>
</tr>
<?php endwhile; ?>
</table>
</div>
</body>
</html>

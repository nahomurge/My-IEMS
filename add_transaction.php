<?php
include 'db.php';

if(isset($_POST['submit'])){
    $type = $_POST['type'];
    $amount = $_POST['amount'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $date = $_POST['date'];

    $stmt = $conn->prepare("INSERT INTO transactions (type, amount, category, description, date) VALUES (?,?,?,?,?)");
    $stmt->bind_param("sdsss", $type, $amount, $category, $description, $date);
    $stmt->execute();
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Transaction</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Add Transaction</h1>
    <form method="post">
        <label>Type</label>
        <select class="form-control border" name="type" required>
            <option style="background-color: blue" value="income">Income</option>
            <option style="background-color: red" value="expense">Expense</option>
        </select>
        <label>Amount</label>
        <input type="number" step="0.01" name="amount" required>
        <label>Category</label>
        <input type="text" name="category" required>
        <label>Description</label>
        <textarea name="description"></textarea>
        <label>Date</label>
        <input type="date" name="date" required>
        <button type="submit" class="btn" name="submit">Add</button>
    </form>
    <a href="index.php" class="btn">Back to Dashboard</a>
</div>
</body>
</html>

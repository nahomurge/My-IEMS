<?php
include 'db.php';

// Initialize variables
$id = $type = $amount = $category = $description = $date = '';

// Check if editing
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $res = $conn->query("SELECT * FROM transactions WHERE id=$id");
    if($res->num_rows > 0){
        $row = $res->fetch_assoc();
        $type = $row['type'];
        $amount = $row['amount'];
        $category = $row['category'];
        $description = $row['description'];
        $date = $row['date'];
    }
}

// Update transaction
if(isset($_POST['submit'])){
    $id = $_POST['id'];
    $type = $_POST['type'];
    $amount = $_POST['amount'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $date = $_POST['date'];

    $stmt = $conn->prepare("UPDATE transactions SET type=?, amount=?, category=?, description=?, date=? WHERE id=?");
    $stmt->bind_param('sdsssi', $type, $amount, $category, $description, $date, $id);
    $stmt->execute();
    header('Location: index.php');
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Transaction</title>
<link rel='stylesheet' href='style.css'>
</head>
<body>
<div class='container'>
<h1>Edit Transaction</h1>
<form method='post'>
<input type='hidden' name='id' value='<?= $id ?>'>
<label>Type</label>
<select name='type' required>
<option value='income' <?= $type=='income'?'selected':'' ?>>Income</option>
<option value='expense' <?= $type=='expense'?'selected':'' ?>>Expense</option>
</select>
<label>Amount</label>
<input type='number' step='0.01' name='amount' value='<?= $amount ?>' required>
<label>Category</label>
<input type='text' name='category' value='<?= $category ?>' required>
<label>Description</label>
<textarea name='description'><?= $description ?></textarea>
<label>Date</label>
<input type='date' name='date' value='<?= $date ?>' required>
<button type='submit' name='submit'>Update</button>
</form>
<a href='index.php' class='btn'>Back to Dashboard</a>
</div>
</body>
</html>

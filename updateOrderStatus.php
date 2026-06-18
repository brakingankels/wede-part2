<link rel="stylesheet" href="styles/style.css">

<?php

include 'DBConn.php';
session_start();

if(!isset($_SESSION['admin'])){
    die("Access denied.");
}

$id = intval($_GET['id']);

if($_SERVER['REQUEST_METHOD']=="POST"){

    $status = $_POST['status'];

    $stmt = $conn->prepare("
    UPDATE tblOrder
    SET status=?
    WHERE order_id=?
    ");

    $stmt->bind_param(
        "si",
        $status,
        $id
    );

    $stmt->execute();

    header("Location: manageOrders.php");
    exit();
}
?>

<form method="post">

<select name="status">

<option value="pending">Pending</option>

<option value="completed">Completed</option>

<option value="cancelled">Cancelled</option>

</select>

<br><br>

<input type="submit" value="Update Status">

</form>
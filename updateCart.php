<?php

include 'DBConn.php';
include 'nav.php';

$cart_id = intval($_POST['cart_id']);
$quantity = intval($_POST['quantity']);

$stmt = $conn->prepare("
UPDATE tblCart
SET quantity=?
WHERE cart_id=?
");

$stmt->bind_param("ii",$quantity,$cart_id);
$stmt->execute();

header("Location: cart.php");
exit();
?>
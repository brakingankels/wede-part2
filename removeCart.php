<?php

include 'DBConn.php';
include 'nav.php';

$id = intval($_GET['id']);

$stmt = $conn->prepare("
DELETE FROM tblCart
WHERE cart_id=?
");

$stmt->bind_param("i",$id);
$stmt->execute();

header("Location: cart.php");
exit();
?>
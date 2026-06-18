<?php

include 'DBConn.php';
session_start();
include 'nav.php';


if(!isset($_SESSION['admin'])){
    die("Access denied.");
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("
DELETE FROM tblClothes
WHERE item_id=?
");

$stmt->bind_param("i",$id);
$stmt->execute();

header("Location: manageClothes.php");
exit();
?>
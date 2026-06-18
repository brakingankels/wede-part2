<?php

include 'DBConn.php';
session_start();

if(!isset($_SESSION['admin'])){
    die("Access denied.");
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("
DELETE FROM tblUser
WHERE user_id=?
");

$stmt->bind_param("i",$id);
$stmt->execute();

header("Location: manageUsers.php");
exit();
?>
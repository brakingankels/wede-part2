<?php
include 'DBConn.php';
session_start();
if(!isset($_SESSION['admin'])){
    die("Access denied.");
}

$id = $_GET['id'];
$action = $_GET['action'];

if($action === 'approve') {
    $conn->query("UPDATE tblUser SET verified='approved' WHERE user_id=$id");
} elseif($action === 'reject') {
    $conn->query("UPDATE tblUser SET verified='rejected' WHERE user_id=$id");
}

header("Location: adminDashboard.php");
?>
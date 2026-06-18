<link rel="stylesheet" href="styles/style.css">

<?php

include 'DBConn.php';
session_start();
include 'nav.php';

if(!isset($_SESSION['admin'])){
    die("Access denied.");
}

if($_SERVER['REQUEST_METHOD']=="POST"){

    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $username = $_POST['username'];

    $password_hash = hash(
        'sha256',
        $_POST['password']
    );

    $verified = $_POST['verified'];

    $stmt = $conn->prepare("
    INSERT INTO tblUser
    (
        fullname,
        email,
        username,
        password_hash,
        verified
    )
    VALUES
    (
        ?,?,?,?,?
    )
    ");

    $stmt->bind_param(
        "sssss",
        $fullname,
        $email,
        $username,
        $password_hash,
        $verified
    );

    $stmt->execute();

    header("Location: manageUsers.php");
    exit();
}
?>

<h2>Add User</h2>

<form method="post">

Full Name:<br>
<input type="text" name="fullname" required>

<br><br>

Email:<br>
<input type="email" name="email" required>

<br><br>

Username:<br>
<input type="text" name="username" required>

<br><br>

Password:<br>
<input type="password" name="password" required>

<br><br>

Status:<br>

<select name="verified">

<option value="pending">Pending</option>

<option value="approved">Approved</option>

<option value="rejected">Rejected</option>

</select>

<br><br>

<input type="submit" value="Create User">

</form>
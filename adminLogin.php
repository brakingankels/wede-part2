<link rel="stylesheet" href="styles/style.css">

<?php
include 'DBConn.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password_hash = hash('sha256', $password);

    $stmt = $conn->prepare("SELECT * FROM tblAdmin WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    if($admin && $admin['password_hash'] === $password_hash){
        $_SESSION['admin'] = $admin;
        header("Location: adminDashboard.php");
        exit();
    } else {
        echo "Invalid admin credentials.";
    }
}
?>

<form method="post">
    Admin Username: <input type="text" name="username" required><br>
    Password: <input type="password" name="password" required><br>
    <input type="submit" value="Login as Admin">
</form>
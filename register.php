<link rel="stylesheet" href="styles/style.css">

<?php
include 'DBConn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $password_hash = hash('sha256', $password);

    $stmt = $conn->prepare("INSERT INTO tblUser (fullname,email,username,password_hash,verified) VALUES (?, ?, ?, ?, 'pending')");
    $stmt->bind_param("ssss", $fullname, $email, $username, $password_hash);
    if($stmt->execute()) {
        echo "Registration successful! Waiting for admin verification.";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<form method="post">
    Full Name: <input type="text" name="fullname" required><br>
    Email: <input type="email" name="email" required><br>
    Username: <input type="text" name="username" required><br>
    Password: <input type="password" name="password" required><br>
    <input type="submit" value="Register">
</form>
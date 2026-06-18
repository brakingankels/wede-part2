<link rel="stylesheet" href="styles/style.css">

<?php
include 'DBConn.php';
session_start();
include 'nav.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password_hash = hash('sha256', $password);

    $stmt = $conn->prepare("SELECT * FROM tblUser WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if($user){
        if($user['verified'] !== 'approved') {
            echo "Your account is not approved yet.";
        } elseif($user['password_hash'] === $password_hash){
            $_SESSION['user'] = $user;
            echo "User " . $user['fullname'] . " is logged in.";
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "User does not exist. <a href='register.php'>Register here</a>";
    }
}
?>

<form method="post">
    Username: <input type="text" name="username" value="<?php if(isset($_POST['username'])) echo $_POST['username']; ?>" required><br>
    Password: <input type="password" name="password" required><br>
    <input type="submit" value="Login">
</form>
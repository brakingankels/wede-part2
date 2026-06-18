<link rel="stylesheet" href="styles/style.css">

<?php

include 'DBConn.php';
session_start();
include 'nav.php';

if(!isset($_SESSION['admin'])){
    die("Access denied.");
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("
SELECT *
FROM tblUser
WHERE user_id=?
");

$stmt->bind_param("i",$id);
$stmt->execute();

$user = $stmt->get_result()->fetch_assoc();

if(!$user){
    die("User not found.");
}

if($_SERVER['REQUEST_METHOD']=="POST"){

    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $verified = $_POST['verified'];

    $update = $conn->prepare("
    UPDATE tblUser
    SET
        fullname=?,
        email=?,
        username=?,
        verified=?
    WHERE user_id=?
    ");

    $update->bind_param(
        "ssssi",
        $fullname,
        $email,
        $username,
        $verified,
        $id
    );

    $update->execute();

    header("Location: manageUsers.php");
    exit();
}
?>

<h2>Edit User</h2>

<form method="post">

Full Name:<br>
<input
type="text"
name="fullname"
value="<?php echo htmlspecialchars($user['fullname']); ?>"
required>

<br><br>

Email:<br>
<input
type="email"
name="email"
value="<?php echo htmlspecialchars($user['email']); ?>"
required>

<br><br>

Username:<br>
<input
type="text"
name="username"
value="<?php echo htmlspecialchars($user['username']); ?>"
required>

<br><br>

Status:<br>

<select name="verified">

<option value="pending"
<?php if($user['verified']=="pending") echo "selected"; ?>>
Pending
</option>

<option value="approved"
<?php if($user['verified']=="approved") echo "selected"; ?>>
Approved
</option>

<option value="rejected"
<?php if($user['verified']=="rejected") echo "selected"; ?>>
Rejected
</option>

</select>

<br><br>

<input type="submit" value="Update User">

</form>
<link rel="stylesheet" href="styles/style.css">

<?php
include 'DBConn.php';
session_start();
include 'nav.php';


if(!isset($_SESSION['admin'])){
    die("Access denied. <a href='adminLogin.php'>Login as admin</a>");
}

echo "<h1>Admin Dashboard</h1>";

echo "
<p>
<a href='manageUsers.php'>Manage Users</a> |
<a href='manageClothes.php'>Manage Clothes</a>
<a href='manageUsers.php'>Manage Users</a> |
<a href='manageClothes.php'>Manage Clothes</a>
<a href='sendMessage.php'>Send Messages</a>
</p>
";

$result = $conn->query("
SELECT *
FROM tblUser
WHERE verified='pending'
");

echo "<h2>Pending Users</h2>";

echo "
<table border='1'>
<tr>
<th>ID</th>
<th>Full Name</th>
<th>Email</th>
<th>Approve</th>
<th>Reject</th>
</tr>
";

while($row = $result->fetch_assoc()){

    echo "
    <tr>
        <td>{$row['user_id']}</td>
        <td>{$row['fullname']}</td>
        <td>{$row['email']}</td>

        <td>
        <a href='verifyUser.php?id={$row['user_id']}&action=approve'>
        Approve
        </a>
        </td>

        <td>
        <a href='verifyUser.php?id={$row['user_id']}&action=reject'>
        Reject
        </a>
        </td>
    </tr>
    ";
}

echo "</table>";
?>
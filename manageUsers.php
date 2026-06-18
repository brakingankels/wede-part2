<link rel="stylesheet" href="styles/style.css">

<?php

include 'DBConn.php';
session_start();
include 'nav.php';

if(!isset($_SESSION['admin'])){
    die("Access denied.");
}

$result = $conn->query("
SELECT *
FROM tblUser
ORDER BY user_id
");

echo "<h2>Manage Users</h2>";

echo "
<table border='1'>
<tr>
<th>ID</th>
<th>Full Name</th>
<th>Email</th>
<th>Username</th>
<th>Status</th>
<th>Edit</th>
<th>Delete</th>
</tr>
";

while($row = $result->fetch_assoc()){

    echo "
    <tr>

    <td>{$row['user_id']}</td>
    <td>{$row['fullname']}</td>
    <td>{$row['email']}</td>
    <td>{$row['username']}</td>
    <td>{$row['verified']}</td>

    <td>
    <a href='editUser.php?id={$row['user_id']}'>
    Edit
    </a>
    </td>

    <td>
    <a href='deleteUser.php?id={$row['user_id']}'>
    Delete
    </a>
    </td>

    </tr>
    ";
}

echo "</table>";

echo "<br>";
echo "<a href='addUser.php'>Add New User</a>";
?>
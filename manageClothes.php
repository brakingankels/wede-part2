<link rel="stylesheet" href="styles/style.css">

<?php

include 'DBConn.php';
session_start();

if(!isset($_SESSION['admin'])){
    die("Admin login required.");
}

$result = $conn->query("
SELECT *
FROM tblClothes
");

echo "<h2>Manage Clothes</h2>";

echo "
<table border='1'>
<tr>
<th>ID</th>
<th>Title</th>
<th>Brand</th>
<th>Price</th>
<th>Status</th>
<th>Edit</th>
<th>Delete</th>
</tr>
";

while($row = $result->fetch_assoc()){

    echo "
    <tr>

    <td>{$row['item_id']}</td>
    <td>{$row['title']}</td>
    <td>{$row['brand']}</td>
    <td>R{$row['price']}</td>
    <td>{$row['status']}</td>

    <td>
    <a href='editClothing.php?id={$row['item_id']}'>
    Edit
    </a>
    </td>

    <td>
    <a href='deleteClothing.php?id={$row['item_id']}'>
    Delete
    </a>
    </td>

    </tr>
    ";
}

echo "</table>";
?>
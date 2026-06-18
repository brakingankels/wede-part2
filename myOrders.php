<link rel="stylesheet" href="styles/style.css">

<?php

include 'DBConn.php';
session_start();

if(!isset($_SESSION['user'])){
    die("Please login.");
}

$user_id = $_SESSION['user']['user_id'];

$stmt = $conn->prepare("
SELECT
o.order_id,
o.status,
o.payment_status,
c.title
FROM tblOrder o
JOIN tblClothes c
ON o.item_id = c.item_id
WHERE o.buyer_id=?
");

$stmt->bind_param("i",$user_id);
$stmt->execute();

$result = $stmt->get_result();

echo "<h2>My Orders</h2>";

echo "
<table border='1'>
<tr>
<th>Order ID</th>
<th>Item</th>
<th>Status</th>
<th>Payment</th>
</tr>
";

while($row = $result->fetch_assoc()){

    echo "
    <tr>

    <td>{$row['order_id']}</td>

    <td>{$row['title']}</td>

    <td>{$row['status']}</td>

    <td>{$row['payment_status']}</td>

    </tr>
    ";
}

echo "</table>";
?>
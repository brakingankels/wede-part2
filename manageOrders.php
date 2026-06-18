<link rel="stylesheet" href="styles/style.css">

<?php

include 'DBConn.php';
session_start();
include 'nav.php';

if(!isset($_SESSION['admin'])){
    die("Access denied.");
}

$result = $conn->query("
SELECT
o.order_id,
o.status,
u.fullname,
c.title
FROM tblOrder o
JOIN tblUser u
ON o.buyer_id = u.user_id
JOIN tblClothes c
ON o.item_id = c.item_id
");
?>

<h2>Manage Orders</h2>

<table border="1">

<tr>
<th>ID</th>
<th>Customer</th>
<th>Item</th>
<th>Status</th>
<th>Update</th>
</tr>

<?php while($row = $result->fetch_assoc()): ?>

<tr>

<td><?php echo $row['order_id']; ?></td>

<td><?php echo htmlspecialchars($row['fullname']); ?></td>

<td><?php echo htmlspecialchars($row['title']); ?></td>

<td><?php echo $row['status']; ?></td>

<td>

<a href="updateOrderStatus.php?id=<?php echo $row['order_id']; ?>">
Update
</a>

</td>

</tr>

<?php endwhile; ?>

</table>
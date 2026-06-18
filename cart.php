<link rel="stylesheet" href="styles/style.css">

<?php
include 'DBConn.php';
session_start();
include 'nav.php';


if(!isset($_SESSION['user'])){
    die("Please login first.");
}

$user_id = $_SESSION['user']['user_id'];

$stmt = $conn->prepare("
SELECT
c.cart_id,
c.quantity,
cl.item_id,
cl.title,
cl.price,
cl.image
FROM tblCart c
JOIN tblClothes cl
ON c.item_id = cl.item_id
WHERE c.user_id=?
");

$stmt->bind_param("i",$user_id);
$stmt->execute();

$result = $stmt->get_result();

$total = 0;

echo "<h2>Shopping Cart</h2>";

echo "<table border='1'>";
echo "
<tr>
<th>Image</th>
<th>Title</th>
<th>Price</th>
<th>Quantity</th>
<th>Subtotal</th>
<th>Action</th>
</tr>
";

while($row = $result->fetch_assoc()){

    $subtotal = $row['price'] * $row['quantity'];
    $total += $subtotal;

    echo "<tr>";

    echo "<td>
    <img src='images/".$row['image']."'
    width='100'>
    </td>";

    echo "<td>".$row['title']."</td>";

    echo "<td>R".$row['price']."</td>";

    echo "<td>

    <form action='updateCart.php' method='post'>

    <input type='hidden'
    name='cart_id'
    value='".$row['cart_id']."'>

    <input type='number'
    name='quantity'
    value='".$row['quantity']."'
    min='1'>

    <input type='submit'
    value='Update'>

    </form>

    </td>";

    echo "<td>R".$subtotal."</td>";

    echo "<td>
    <a href='removeCart.php?id=".$row['cart_id']."'>
    Remove
    </a>
    </td>";

    echo "</tr>";
}

echo "</table>";

echo "<h3>Total: R".$total."</h3>";

echo "<br>";

echo "<a href='items.php'>Continue Shopping</a>";

echo "<br><br>";

echo "<a href='checkout.php'>Checkout</a>";
?>
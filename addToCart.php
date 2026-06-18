<link rel="stylesheet" href="styles/style.css">

<?php
include 'DBConn.php';
session_start();
include 'nav.php';


// Ch
if(!isset($_SESSION['user'])){
    die("Please login first.");
}

if(!isset($_GET['id'])){
    die("No item selected.");
}

$user_id = $_SESSION['user']['user_id'];
$item_id = intval($_GET['id']);

$check = $conn->prepare("
SELECT * FROM tblCart
WHERE user_id=? AND item_id=?
");

$check->bind_param("ii",$user_id,$item_id);
$check->execute();
$result = $check->get_result();

if($result->num_rows > 0){

    $update = $conn->prepare("
    UPDATE tblCart
    SET quantity = quantity + 1
    WHERE user_id=? AND item_id=?
    ");

    $update->bind_param("ii",$user_id,$item_id);
    $update->execute();

}else{

    $insert = $conn->prepare("
    INSERT INTO tblCart(user_id,item_id,quantity)
    VALUES(?,?,1)
    ");

    $insert->bind_param("ii",$user_id,$item_id);
    $insert->execute();
}

echo "<h2>Item added to cart!</h2>";

echo "<a href='items.php'>Continue Shopping</a><br><br>";
echo "<a href='cart.php'>View Cart</a>";
?>
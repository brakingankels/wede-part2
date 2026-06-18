<link rel="stylesheet" href="styles/style.css">

<?php

include 'DBConn.php';
session_start();
include 'nav.php';


if(!isset($_SESSION['user'])){
    die("Please login first.");
}

$user_id = $_SESSION['user']['user_id'];

if($_SERVER['REQUEST_METHOD']=="POST"){

    $address = $_POST['delivery_address'];

    $cart = $conn->prepare("
    SELECT * FROM tblCart
    WHERE user_id=?
    ");

    $cart->bind_param("i",$user_id);
    $cart->execute();

    $items = $cart->get_result();

    while($row = $items->fetch_assoc()){

        $order = $conn->prepare("
        INSERT INTO tblOrder
        (buyer_id,item_id,delivery_address)
        VALUES(?,?,?)
        ");

        $order->bind_param(
            "iis",
            $user_id,
            $row['item_id'],
            $address
        );

        $order->execute();

        $sold = $conn->prepare("
        UPDATE tblClothes
        SET status='sold'
        WHERE item_id=?
        ");

        $sold->bind_param(
            "i",
            $row['item_id']
        );

        $sold->execute();
    }

    $clear = $conn->prepare("
    DELETE FROM tblCart
    WHERE user_id=?
    ");

    $clear->bind_param("i",$user_id);
    $clear->execute();

    echo "<h2>Checkout successful!</h2>";

    exit();
}
?>

<h2>Checkout</h2>

<form method="post">

Delivery Address:<br>

<textarea
name="delivery_address"
required>
</textarea>

<br><br>

<input
type="submit"
value="Place Order">

</form>
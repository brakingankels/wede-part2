<link rel="stylesheet" href="styles/style.css">

<?php
// Include the database connection
include 'DBConn.php';
session_start();
include 'nav.php';

// Check if user is logged in
if(!isset($_SESSION['user'])){
    die("Please <a href='login.php'>login</a> first.");
}

// Only approved users can place orders
if($_SESSION['user']['verified'] !== 'approved'){
    die("Your account is not approved to place orders.");
}


// Check if item_id is provided via GET
if(!isset($_GET['id']) || empty($_GET['id'])){
    die("No item selected.");
}

$item_id = intval($_GET['id']);
$buyer_id = $_SESSION['user']['user_id'];


// Fetch the item to ensure it exists and is available
$stmt = $conn->prepare("SELECT * FROM tblClothes WHERE item_id = ? AND status = 'available'");
if(!$stmt){
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $item_id);
$stmt->execute();
$result = $stmt->get_result();
$item = $result->fetch_assoc();

if(!$item){
    die("Item not found or already sold.");
}


// Handle order form submission
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Trim and validate delivery address
    $delivery_address = trim($_POST['delivery_address']);

    if(empty($delivery_address)){
        die("Error: Delivery address cannot be empty.");
    }

    // Insert order into tblOrder
    $order_stmt = $conn->prepare("INSERT INTO tblOrder (buyer_id, item_id, delivery_address) VALUES (?, ?, ?)");
    if(!$order_stmt){
        die("Prepare failed: " . $conn->error);
    }

    $order_stmt->bind_param("iis", $buyer_id, $item_id, $delivery_address);

    if($order_stmt->execute()){
        // Mark the item as sold
        $update_stmt = $conn->prepare("UPDATE tblClothes SET status='sold' WHERE item_id=?");
        $update_stmt->bind_param("i", $item_id);
        $update_stmt->execute();

        echo "<p style='color:green;'>Order placed successfully!</p>";
    } else {
        echo "<p style='color:red;'>Error placing order: " . $order_stmt->error . "</p>";
    }
}
?>

<h2>Order Item: <?php echo htmlspecialchars($item['title']); ?></h2>
<p><strong>Price:</strong> R<?php echo $item['price']; ?></p>
<p><strong>Description:</strong> <?php echo htmlspecialchars($item['description']); ?></p>

<!----------------------
     Order Form
---------------------->
<form method="post">
    Delivery Address: <br>
    <textarea name="delivery_address" required placeholder="Enter your delivery address"></textarea><br><br>
    <input type="submit" value="Place Order">
</form>
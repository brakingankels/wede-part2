<link rel="stylesheet" href="styles/style.css">

<?php
// including database connection
include 'DBConn.php';
session_start();

// fetching all available items with seller information
$result = $conn->query("SELECT c.*, u.fullname AS seller_name FROM tblClothes c JOIN tblUser u ON c.seller_id = u.user_id WHERE c.status='available'");
echo "<h2>Available Clothes</h2>";
echo "<table border='1'>
<tr><th>Title</th><th>Description</th><th>Brand</th><th>Size</th><th>Condition</th><th>Price</th><th>Seller</th><th>Action</th></tr>";


if(!$result){
    die("Error fetching items: " . $conn->error);
}

if($result->num_rows === 0){
    echo "<h2>No items available yet.</h2>";
    exit;
}

?>

<h2>Available Clothes</h2>
<table border="1" cellpadding="10">
<tr>
    <th>Image</th>
    <th>Title</th>
    <th>Description</th>
    <th>Brand</th>
    <th>Size</th>
    <th>Condition</th>
    <th>Price</th>
    <th>Seller</th>
    <th>Action</th>
</tr>

<?php while($row = $result->fetch_assoc()): ?>
<tr>
    <!-- Display image from images folder -->
    <td>
        <img src="images/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>" width="100">
    </td>
    <td><?php echo htmlspecialchars($row['title']); ?></td>
    <td><?php echo htmlspecialchars($row['description']); ?></td>
    <td><?php echo htmlspecialchars($row['brand']); ?></td>
    <td><?php echo htmlspecialchars($row['size']); ?></td>
    <td><?php echo htmlspecialchars($row['condition']); ?></td>
    <td>
        <!-- Price popup -->
        <button onclick="alert('Sell Price: R<?php echo $row['price']; ?>')">
            Show Price
        </button>
    </td>
    <td><?php echo htmlspecialchars($row['seller_name']); ?></td>
    <td>
        <?php if(isset($_SESSION['user'])): ?>
            <a href="addToCart.php?id=<?php echo $row['item_id']; ?>">
                Add To Cart
            </a>
            <a href="login.php">Login to order</a>
        <?php endif; ?>
    </td>
</tr>
<?php endwhile; ?>
</table>
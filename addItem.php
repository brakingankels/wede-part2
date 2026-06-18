<link rel="stylesheet" href="styles/style.css">
<?php
include 'DBConn.php';
session_start();
include 'nav.php';


// Check if the user is logged in
if(!isset($_SESSION['user'])){
    die("Please <a href='login.php'>login</a> first.");
}

// Only approved users can add any items
if($_SESSION['user']['verified'] !== 'approved'){
    die("Your account is not approved to add items.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $brand = trim($_POST['brand']);
    $size = trim($_POST['size']);
    $condition = trim($_POST['condition']);
    $price = trim($_POST['price']);
    $image = trim($_POST['image']);

    // Checking if the values are empty
    if(empty($title) || empty($description) || empty($brand) || empty($size) || empty($condition) || empty($price)){
    die("Error: All fields are required.");
    }

    $seller_id = $_SESSION['user']['user_id'];
   // Sql statement to insert item into tblClothes 
    $stmt = $conn->prepare("INSERT INTO tblClothes (seller_id, title, description, brand, size, `condition`, price, image) VALUES (?,?,?,?,?,?,?,?)");
    $stmt->bind_param("isssssds", $seller_id, $title, $description, $brand, $size, $condition, $price, $image);

    if($stmt->execute()){
        echo "<p style='color:green;'>Item added successfully!</p>";
    } else {
        echo "<p style='color:red;'>Error: " . $stmt->error . "</p>";
    }
}
?>

<h2>Add a New Item</h2>
<form method="post">
    Title: <input type="text" name="title" required><br>
    Description: <textarea name="description" required></textarea><br>
    Brand: <input type="text" name="brand" required><br>
    Size: <input type="text" name="size" required><br>
    Condition: <input type="text" name="condition" required><br>
    Price: <input type="number" step="0.01" name="price" required><br>
    <input type="submit" value="Add Item">

    Image:
    <select name="image" required>
        <option value="">--Select Image--</option>
        <option value="item1.png">item1.png</option>
        <option value="item2.png">item2.png</option>
        <option value="item3.png">item3.png</option>
        <option value="item4.png">item4.png</option>
        <option value="item5.png">item5.png</option>
    </select><br><br>

    <input type="submit" value="Add Item">
</form>
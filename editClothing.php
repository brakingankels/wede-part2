<link rel="stylesheet" href="styles/style.css">

<?php

include 'DBConn.php';
session_start();

if(!isset($_SESSION['admin'])){
    die("Access denied.");
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("
SELECT *
FROM tblClothes
WHERE item_id=?
");

$stmt->bind_param("i",$id);
$stmt->execute();

$item = $stmt->get_result()->fetch_assoc();

if($_SERVER['REQUEST_METHOD']=="POST"){

    $title = $_POST['title'];
    $brand = $_POST['brand'];
    $price = $_POST['price'];

    $update = $conn->prepare("
    UPDATE tblClothes
    SET title=?,
        brand=?,
        price=?
    WHERE item_id=?
    ");

    $update->bind_param(
        "ssdi",
        $title,
        $brand,
        $price,
        $id
    );

    $update->execute();

    header("Location: manageClothes.php");
    exit();
}
?>

<h2>Edit Clothing</h2>

<form method="post">

Title:<br>
<input
type="text"
name="title"
value="<?php echo $item['title']; ?>"
required>

<br><br>

Brand:<br>
<input
type="text"
name="brand"
value="<?php echo $item['brand']; ?>"
required>

<br><br>

Price:<br>
<input
type="number"
step="0.01"
name="price"
value="<?php echo $item['price']; ?>"
required>

<br><br>

<input
type="submit"
value="Update Item">

</form>
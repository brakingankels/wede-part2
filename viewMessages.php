<link rel="stylesheet" href="styles/style.css">

<?php

include 'DBConn.php';
session_start();
include 'nav.php';

if(!isset($_SESSION['user'])){
    die("Please login.");
}

$user_id = $_SESSION['user']['user_id'];

$stmt = $conn->prepare("
SELECT *
FROM tblMessage
WHERE receiver_id=?
ORDER BY date_sent DESC
");

$stmt->bind_param("i",$user_id);
$stmt->execute();

$result = $stmt->get_result();

echo "<h2>My Messages</h2>";

while($row = $result->fetch_assoc()){

    echo "
    <div style='border:1px solid black;
    padding:10px;
    margin-bottom:10px;'>

    <strong>From:</strong>
    {$row['sender']}

    <br><br>

    {$row['message']}

    <br><br>

    <small>
    {$row['date_sent']}
    </small>

    </div>
    ";
}
?>
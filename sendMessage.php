<link rel="stylesheet" href="styles/style.css">

<?php

include 'DBConn.php';
session_start();

if(!isset($_SESSION['admin'])){
    die("Access denied.");
}

if($_SERVER['REQUEST_METHOD']=="POST"){

    $receiver_id = intval($_POST['receiver_id']);
    $message = $_POST['message'];

    $stmt = $conn->prepare("
    INSERT INTO tblMessage
    (
        sender,
        receiver_id,
        message
    )
    VALUES
    (
        'Admin',
        ?,
        ?
    )
    ");

    $stmt->bind_param(
        "is",
        $receiver_id,
        $message
    );

    $stmt->execute();

    echo "<p>Message sent successfully.</p>";
}

$users = $conn->query("
SELECT user_id, fullname
FROM tblUser
");
?>

<h2>Send Message</h2>

<form method="post">

Select User:<br>

<select name="receiver_id">

<?php while($user = $users->fetch_assoc()): ?>

<option value="<?php echo $user['user_id']; ?>">

<?php echo htmlspecialchars($user['fullname']); ?>

</option>

<?php endwhile; ?>

</select>

<br><br>

Message:<br>

<textarea
name="message"
required
rows="5"
cols="40">
</textarea>

<br><br>

<input
type="submit"
value="Send Message">

</form>
<?php
include 'DBConn.php';

// Drop tables in correct order
$conn->query("DROP TABLE IF EXISTS tblOrder");
$conn->query("DROP TABLE IF EXISTS tblClothes");
$conn->query("DROP TABLE IF EXISTS tblAdmin");
$conn->query("DROP TABLE IF EXISTS tblUser");

// Create tblUser
$conn->query("
CREATE TABLE IF NOT EXISTS tblUser (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    verified ENUM('pending','approved','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8
") or die("Error creating tblUser: ".$conn->error);

// Create tblAdmin
$conn->query("
CREATE TABLE IF NOT EXISTS tblAdmin (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL,
    password_hash VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8
") or die("Error creating tblAdmin: ".$conn->error);

// Create tblClothes
$conn->query("
CREATE TABLE IF NOT EXISTS tblClothes (
    item_id INT AUTO_INCREMENT PRIMARY KEY,
    seller_id INT NOT NULL,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    brand VARCHAR(50) NOT NULL,
    size VARCHAR(10) NOT NULL,
    `condition` VARCHAR(50) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(100) NOT NULL,
    status ENUM('available','sold') DEFAULT 'available',
    FOREIGN KEY (seller_id) REFERENCES tblUser(user_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8
") or die("Error creating tblClothes: ".$conn->error);

// Create tblOrder
$conn->query("
CREATE TABLE IF NOT EXISTS tblOrder (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    buyer_id INT NOT NULL,
    item_id INT NOT NULL,
    delivery_address TEXT NOT NULL,
    status ENUM('pending','completed','cancelled') DEFAULT 'pending',
    payment_status ENUM('pending','paid','failed') DEFAULT 'pending',
    FOREIGN KEY (buyer_id) REFERENCES tblUser(user_id) ON DELETE CASCADE,
    FOREIGN KEY (item_id) REFERENCES tblClothes(item_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8
") or die("Error creating tblOrder: ".$conn->error);

$conn->query("
CREATE TABLE IF NOT EXISTS tblCart (
    cart_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    item_id INT NOT NULL,
    quantity INT DEFAULT 1,
    FOREIGN KEY (user_id) REFERENCES tblUser(user_id) ON DELETE CASCADE,
    FOREIGN KEY (item_id) REFERENCES tblClothes(item_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8
") or die('Error creating tblCart: '.$conn->error);

$conn->query("
CREATE TABLE IF NOT EXISTS tblMessage (
    message_id INT AUTO_INCREMENT PRIMARY KEY,
    sender VARCHAR(50) NOT NULL,
    receiver_id INT NOT NULL,
    message TEXT NOT NULL,
    date_sent TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (receiver_id) REFERENCES tblUser(user_id)
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8
") or die('Error creating tblMessage: '.$conn->error);

// Load sample users
$lines = file('userData.txt');
foreach ($lines as $line) {
    list($fullname, $email, $username, $password_hash) = explode(",", trim($line));
    $stmt = $conn->prepare("INSERT INTO tblUser (fullname,email,username,password_hash) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $fullname, $email, $username, $password_hash);
    $stmt->execute();
}

// Load admin
$admin_pass = hash('sha256', 'admin123');
$conn->query("INSERT INTO tblAdmin (fullname,email,username,password_hash) VALUES ('Admin User','admin@pastimes.co.za','admin','$admin_pass')");

echo "All tables created successfully!";
?>
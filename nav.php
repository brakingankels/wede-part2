<link rel="stylesheet" href="styles/style.css">

<div style="padding:10px; background:#333;">

    <a href="index.php" style="color:white; margin-right:15px;">
        Home
    </a>

    <a href="items.php" style="color:white; margin-right:15px;">
        Browse Clothes
    </a>

    <?php if(isset($_SESSION['user'])): ?>

        <a href="addItem.php" style="color:white; margin-right:15px;">
            Sell Item
        </a>

        <a href="cart.php" style="color:white; margin-right:15px;">
            Cart
        </a>

        <a href="myOrders.php" style="color:white; margin-right:15px;">
            My Orders
        </a>

        <a href="viewMessages.php" style="color:white; margin-right:15px;">
            Messages
        </a>

        <a href="logout.php" style="color:white;">
            Logout
        </a>

    <?php endif; ?>

    <?php if(isset($_SESSION['admin'])): ?>

        <a href="adminDashboard.php" style="color:white; margin-right:15px;">
            Dashboard
        </a>

        <a href="manageUsers.php" style="color:white; margin-right:15px;">
            Users
        </a>

        <a href="manageClothes.php" style="color:white; margin-right:15px;">
            Clothes
        </a>

        <a href="manageOrders.php" style="color:white; margin-right:15px;">
            Orders
        </a>

        <a href="sendMessage.php" style="color:white; margin-right:15px;">
            Messages
        </a>

        <a href="logout.php" style="color:white;">
            Logout
        </a>

    <?php endif; ?>

    <?php if(!isset($_SESSION['user']) && !isset($_SESSION['admin'])): ?>

        <a href="register.php" style="color:white; margin-right:15px;">
            Register
        </a>

        <a href="login.php" style="color:white; margin-right:15px;">
            Login
        </a>

        <a href="adminLogin.php" style="color:white;">
            Admin Login
        </a>

    <?php endif; ?>

</div>

<br>
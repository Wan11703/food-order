<?php include('config/constants.php');
if (!isset($_SESSION['user_id'])) {
    header('location:'.SITEURL.'login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

if (!isset($_COOKIE['username'])) {
            
    header("Location: LOGIN.php");
    exit();
}


$username = $_COOKIE['username'];

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Website</title>

    <!-- Link to CSS file -->
    <link rel="stylesheet" href="css/style.css">
    
</head>

<body>
    <!-- Navbar Section Starts Here -->
    <section class="navbar">
        <div class="row">
            <div class="logo col-3">
                <a href="#" title="Logo">
                    <img src="images/logo.png" alt="Restaurant Logo" class="img-responsive w-50">
                </a>
            </div>

           

            <div class="menu col-9 text-center">
                <ul>
                    <li>
                    <?php echo "Welcome, $username!"; ?>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>index.php">Home</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>categories.php">Categories</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>foods.php">Products</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>cart.php">Cart</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>completed-order.php">Orders</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>account.php">Account</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>past-order.php">Completed Orders</a>
                    </li>
                    <!----<li>
                        <a href="<?php //echo SITEURL; ?>review.php">Reviews</a>
                    </li>--->
                    <li>
                        <a href="<?php echo SITEURL; ?>logout.php">Log Out</a>
                    </li>
                    <!----<li>
                        <a href="#">Contact</a>
                    </li>---->
                </ul>
            </div>

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Navbar Section Ends Here -->
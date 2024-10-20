
<?php include('partials-front/menu.php'); 
if (!isset($_SESSION['user_id'])) {
    header('location:'.SITEURL.'login.php');
    exit();
}

?>

<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search text-center">
    <div class="container">
        <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
            <input type="search" name="search" placeholder="Search for Food.." required>
            <input type="submit" name="submit" value="Search" class="btn btn-primary">
        </form>
    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->

<?php
if(isset($_SESSION['order'])){
    echo $_SESSION['order'];
    unset($_SESSION['order']);
}

// Add to Cart and Redirect to Edit Cart functionality
if(isset($_POST['order_now'])){
    $food_id = $_POST['food_id'];
    $qty = $_POST['qty'];

    $sql = "SELECT * FROM tbl_food WHERE id=$food_id";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($res);

    $title = $row['title'];
    $price = $row['price'];
    $image_name = $row['image_name'];

    $total = $price * $qty;

    $item_exists = false;

    // Check if the item already exists in the cart
    if(isset($_SESSION['cart'])){
        foreach($_SESSION['cart'] as $key => $item){
            if($item['food_id'] == $food_id && $item['qty'] + $qty <= 99){
                $_SESSION['cart'][$key]['qty'] += $qty;
                $_SESSION['cart'][$key]['total'] += $total;
                $item_exists = true;
                break;
            }
        }
    }

    if(!$item_exists){
        // Store cart items in session
        $cart_item = array(
            'food_id' => $food_id,
            'title' => $title,
            'price' => $price,
            'qty' => $qty,
            'total' => $total,
            'image_name' => $image_name,
            'status' => 'Pending' // Set status to Pending
        );

        if(!isset($_SESSION['cart'])){
            $_SESSION['cart'] = array();
        }

        $_SESSION['cart'][] = $cart_item;
    }

    // Get the key of the newly added cart item
    $key = array_key_last($_SESSION['cart']);

    // Redirect to edit-cart.php with the key parameter
    header('location:'.SITEURL.'edit-cart.php?key='.$key);
    exit();
}

if(isset($_POST['add_to_cart'])){
    $food_id = $_POST['food_id'];
    $qty = $_POST['qty'];

    $sql = "SELECT * FROM tbl_food WHERE id=$food_id";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($res);

    $title = $row['title'];
    $price = $row['price'];
    $image_name = $row['image_name'];

    $total = $price * $qty;
   

    $item_exists = false;

    // Check if the item already exists in the cart
    if(isset($_SESSION['cart'])){
        foreach($_SESSION['cart'] as $key => $item){
            if($item['food_id'] == $food_id && $item['qty'] + $qty <= 99){
                $_SESSION['cart'][$key]['qty'] += $qty;
                $_SESSION['cart'][$key]['total'] += $total;
                $item_exists = true;
                break;
            }
        }
    }

    if(!$item_exists){
        // Store cart items in session
        $cart_item = array(
            'food_id' => $food_id,
            'title' => $title,
            'price' => $price,
            'qty' => $qty,
            'total' => $total,
            'image_name' => $image_name,
            'status' => 'Pending' // Set status to Pending
        );

        if(!isset($_SESSION['cart'])){
            $_SESSION['cart'] = array();
        }

        $_SESSION['cart'][] = $cart_item;
    }

    $_SESSION['cart_msg'] = "<div class='success text-center'>Food Added to Cart</div>";
    header('location:'.SITEURL.'foods.php');
    exit();
}

if(isset($_SESSION['cart_msg'])){
    echo $_SESSION['cart_msg'];
    unset($_SESSION['cart_msg']);
}
?>

<!-- fOOD MEnu Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Our Menu</h2>

        <?php
        $sql = "SELECT * FROM tbl_food WHERE active = 'Yes'";
        $res = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($res);

        if($count > 0){
            while($row = mysqli_fetch_assoc($res)){
                $id = $row['id'];
                $title = $row['title'];
                $description = $row['description'];
                $price = $row['price'];
                $image_name = $row['image_name'];
                ?>
                <div class="food-menu-box">
                    <div class="food-menu-img">
                        <?php
                        if($image_name == ""){
                            echo "<div class='error'>Unavailable at the moment</div>";
                        } else {
                            ?>
                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                            <?php
                        }
                        ?>
                    </div>

                    <div class="food-menu-desc">
                        <h4><?php echo $title; ?></h4>
                        <p class="food-price">₱<?php echo $price; ?></p>
                        <p class="food-detail">
                            <?php echo $description; ?>
                        </p>
                        <br>

                        <!-- Order Now Form -->
                        <form action="" method="POST" class="order-now-form">
                            <input type="hidden" name="food_id" value="<?php echo $id; ?>">
                            <input type="hidden" name="qty" value="1">
                            
                        </form>
                        
                        <!-- Add to Cart Form -->
                        <form action="" method="POST" class="add-to-cart-form">
                            <input type="hidden" name="food_id" value="<?php echo $id; ?>">
                            <input type="number" name="qty" value="1" min="1" max="99" class="input-responsive" style="width: 60px;">
                            <input type="submit" name="add_to_cart" value="Add to Cart" class="btn btn-secondary">
                        </form>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<div class='error'>Unavailable at the moment</div>";
        }
        ?>

        <div class="clearfix"></div>
    </div>
</section>
<!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>
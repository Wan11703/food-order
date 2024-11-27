<?php include('partials-front/menu.php'); 

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header('location:'.SITEURL.'login.php');
    exit();
}

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];
?>

<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search">
    <div class="container">
        
        <h2 class="text-center text-black">Fill this form to confirm your order.</h2>
        
        <form action="" class="order" method="POST" enctype="multipart/form-data">
            <div class="col-6">
            <fieldset>
                <legend>Selected Food</legend>

                <?php 

                if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                    $cart = $_SESSION['cart'];
                    foreach ($cart as $item) {
                        $id = $item['food_id'];
                        $food = $item['title'];
                        $price = $item['price'];
                        $qty = $item['qty'];
                        $total = $item['total'];
                        $order_date = date("Y-m-d h:i:sa"); // Current date and time
                        
                        $food_id = $id;
                    
                        $sql = "SELECT * FROM tbl_food WHERE id = $food_id";
                    
                        $res = mysqli_query($conn, $sql);
                    
                        $count = mysqli_num_rows($res);
                    
                        if ($count == 1) {
                            $row = mysqli_fetch_assoc($res);
                            $title = $row['title'];
                            $price = $row['price'];
                            $image_name = $row['image_name'];
                        }

                        if ($image_name == "") {
                            echo "<div class='error'>Image Unavailable</div>";
                        } else {
                            ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" class="img-responsive img-curve">
                            <?php
                        }
                        ?>
                            <div class="food-menu-desc">
                                <h3><?php echo $title ?></h3>
                                <input type="hidden" name="food" value="<?php echo $title ?>">

                                <p class="food-price">₱<?php echo $total ?></p>
                                <input type="hidden" name="price" value="<?php echo $total ?>">

                                <div class="order-label">Quantity</div>
                                <input type="hidden" name="qty" value="<?php echo $qty ?>">
                                <span><?php echo $qty ?></span>
                            </div>
                        <?php
                    }
                }
                ?>

            </fieldset>
            </div>
            
            <div class="col-6">
            <fieldset>
                <legend>Delivery Details</legend>
                <div class="order-label">Full Name</div>
                <input type="text" name="full-name" placeholder="Enter your Full Name" class="input-responsive" required>
                <input type="hidden" name="user_id" value="<?php echo $user_id ?>">

                <div class="order-label">Phone Number</div>
                <input type="tel" name="contact" placeholder="Your Contact Number" class="input-responsive" pattern="09[0-9]{9}" maxlength="11" required>

                <div class="order-label">Email</div>
                <input type="email" name="email" placeholder="Your Email" class="input-responsive" required>

                <div class="order-label">Address</div>
                <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                <div class="order-label">Payment Method</div>
                <select name="payment_method" class="input-responsive" required>
                    <option value="Cash on delivery">Cash on delivery</option>
                    <option value="Gcash">Gcash</option>
                </select>

                <div class="proof-of-payment">Proof of Payment</div>
                <input type="file" name="image" required>

                <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
            </fieldset>
            </div>

        </form>

    </div>

    <?php
    if (isset($_POST['submit'])) {
        function generateUniqueOrderId($conn) {
            while (true) {
                $orderId = rand(10000, 99999);
                $sql = "SELECT id FROM tbl_orders WHERE id = $orderId";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) == 0) {
                    return $orderId;
                }

                mysqli_free_result($result);
            }
        }

        if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
            $image_name = $_FILES['image']['name'];
            if ($image_name != "") {
                $ext = end(explode('.', $image_name));
                $image_name = "Proof_Of_Payment" . rand(000, 999) . '.' . $ext;

                $source_path = $_FILES['image']['tmp_name'];
                $destination_path = "images/proof/" . $image_name;

                $upload = move_uploaded_file($source_path, $destination_path);

                if ($upload == FALSE) {
                    $_SESSION['upload'] = "<div class='error'>Failed to upload image</div>";
                    header('location:' . SITEURL . 'admin/add-category.php');
                    die();
                }
            }
        } else {
            $_SESSION['upload'] = "<div class='error'>Proof of Payment is required</div>";
            header('location:' . SITEURL . 'order.php');
            die();
        }

        $orderId = generateUniqueOrderId($conn);

        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            $cart = $_SESSION['cart'];

            foreach ($cart as $item) {
                $id = $item['food_id'];
                $food = $item['title'];
                $price = $item['price'];
                $qty = $item['qty'];
                $total = $item['total'];
                $order_date = date("Y-m-d h:i:sa");
                $status = "Preparing"; // ordered, on delivery, delivered, cancelled
                $customer_name = $_POST['full-name'];
                $customer_contact = $_POST['contact'];
                $customer_email = $_POST['email'];
                $customer_address = $_POST['address'];
                $payment_method = $_POST['payment_method'];

                $sql2 = "INSERT INTO tbl_orders SET
                    id = '$orderId',
                    food = '$food',
                    price = $price,
                    qty = $qty,
                    total = $total,
                    order_date = '$order_date',
                    status = '$status',
                    customer_name = '$customer_name',
                    customer_contact = '$customer_contact',
                    customer_email = '$customer_email',
                    customer_address = '$customer_address',
                    user_id = $user_id
                ";

                $res2 = mysqli_query($conn, $sql2);

                // Insert payment details
                $sql3 = "INSERT INTO payment SET
                    order_id = '$orderId',
                    payment_method = '$payment_method',
                    proof = '$image_name'
                ";

                $res3 = mysqli_query($conn, $sql3);
            }
        }

        unset($_SESSION['cart']);
        header("Location: " . SITEURL . "cart.php");
    }
    ?>

</section>
<!-- fOOD sEARCH Section Ends Here -->

<?php include('partials-front/footer.php'); ?>



<?php include('partials-front/menu.php'); 
if (!isset($_SESSION['user_id'])) {
    header('location:'.SITEURL.'login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
?>

<?php
// Check if the key parameter is set
if(isset($_GET['key'])){
    $key = $_GET['key'];
    $item = $_SESSION['cart'][$key];
} else {
    header('location:'.SITEURL.'cart.php');
    exit();
}

// Update the item in the cart
if(isset($_POST['update_cart'])){
    $qty = $_POST['qty'];
    $customer_name = $_POST['customer_name'];
    $customer_contact = $_POST['customer_contact'];
    $customer_email = $_POST['customer_email'];
    $customer_address = $_POST['customer_address'];

    // Validate the contact number
    if (!preg_match('/^09\d{9}$/', $customer_contact)) {
        $_SESSION['update'] = "<div class='error'>Invalid contact number. It should start with 09 and be exactly 11 digits.</div>";
        header('location:'.SITEURL.'edit-cart.php?key='.$key);
        exit();
    }

    // Update the cart item
    $_SESSION['cart'][$key]['qty'] = $qty;
    $_SESSION['cart'][$key]['total'] = $_SESSION['cart'][$key]['price'] * $qty;
    $_SESSION['cart'][$key]['customer_name'] = $customer_name;
    $_SESSION['cart'][$key]['customer_contact'] = $customer_contact;
    $_SESSION['cart'][$key]['customer_email'] = $customer_email;
    $_SESSION['cart'][$key]['customer_address'] = $customer_address;

    $_SESSION['update'] = "<div class='success'>Order Updated Successfully</div>";
    header('location:'.SITEURL.'cart.php');
    exit();
}
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Edit Order</h1>
        <br><br>

        <?php
        if(isset($_SESSION['update'])){
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Product Name: </td>
                    <td><b><?php echo $item['title']; ?></b></td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td>₱<span id="price"><?php echo $item['price']; ?></span></td>
                </tr>

                <tr>
                    <td>Quantity: </td>
                    <td>
                        <input type="number" name="qty" value="<?php echo $item['qty']; ?>" min="1" max="99" id="quantity">
                    </td>
                </tr>

                <tr>
                    <td>Total: </td>
                    <td>₱<span id="total"><?php echo $item['total']; ?></span></td>
                </tr>

                <tr>
                    <td>Customer Name: </td>
                    <td>
                        <input type="text" name="customer_name" value="<?php echo isset($item['customer_name']) ? $item['customer_name'] : ''; ?>" required>
                    </td>
                </tr>

                <tr>
                    <td>Customer Contact: </td>
                    <td>
                        <input type="text" name="customer_contact" value="<?php echo isset($item['customer_contact']) ? $item['customer_contact'] : ''; ?>" pattern="09\d{9}" title="Contact number must start with 09 and be 11 digits long" required>
                    </td>
                </tr>

                <tr>
                    <td>Customer Email: </td>
                    <td>
                        <input type="email" name="customer_email" value="<?php echo isset($item['customer_email']) ? $item['customer_email'] : ''; ?>" required>
                    </td>
                </tr>

                <tr>
                    <td>Customer Address: </td>
                    <td>
                        <textarea name="customer_address" cols="30" rows="5" required><?php echo isset($item['customer_address']) ? $item['customer_address'] : ''; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="update_cart" value="Update Order" class="btn btn-secondary">
                        <button type="button" class="btn btn-secondary" onclick="history.back()">Back</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<script>
document.getElementById('quantity').addEventListener('input', function() {
    var price = <?php echo $item['price']; ?>;
    var quantity = this.value;
    var total = price * quantity;
    document.getElementById('total').innerText = total.toFixed(2);
});
</script>

<?php include('partials-front/footer.php'); ?>
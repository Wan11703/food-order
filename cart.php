<?php 

include('partials-front/menu.php');

if (!isset($_SESSION['user_id'])) {
    header('location:'.SITEURL.'login.php');
    exit();
}


// Remove item from cart
if(isset($_POST['remove_selected'])){
    if (empty($_POST['selected_keys'])) {
        $_SESSION['delete'] = "<div class='error'>Please select at least one item to remove.</div>";
    } else {
        $keys_to_remove = $_POST['selected_keys'];
        foreach ($keys_to_remove as $key) {
            unset($_SESSION['cart'][$key]);
        }
        $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex array
        $_SESSION['delete'] = "<div class='success'>Selected Items Removed Successfully</div>";
    }
    header('location:'.SITEURL.'cart.php');
    exit();
}



$total_price = 0;
?>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<!--- main Section Start--->
<div class="main-content">
    <div class="wrapper">
        <h1>My Cart</h1>
        <br><br>

        <?php
            if(isset($_SESSION['update'])){
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }
            if(isset($_SESSION['delete'])){
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);
            }
            if(isset($_SESSION['confirm_error'])){
                echo $_SESSION['confirm_error'];
                unset($_SESSION['confirm_error']);
            }
            if(isset($_SESSION['confirm_success'])){
                echo $_SESSION['confirm_success'];
                unset($_SESSION['confirm_success']);
            }
            if(isset($_SESSION['upload'])){
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>

        <br /><br>
        <!--- Cart Items Table --->
        <form id="cart-form" action="" method="POST">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="select-column" style="display: none;">Select</th>
                        <th>S.N</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Order Date</th>
                        <th>Status</th>
                        
                        <th class="action-column">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $all_details_filled = true;
                if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])){
                    $sn = 1;
                    foreach($_SESSION['cart'] as $key => $item){
                        $id = $item['food_id'];
                        $food = $item['title'];
                        $price = $item['price'];
                        $qty = $item['qty'];
                        $total = $item['total'];
                        $total_price += $total;
                        $order_date = date("Y-m-d h:i:sa"); // Current date and time
                        $status = $item['status'];

                        

                        // Display cart item
                        ?>

                        <tr data-key="<?php echo $key; ?>">
                            <td class="select-column" style="display: none;"><input type="checkbox" name="selected_keys[]" value="<?php echo $key; ?>" class="select-item"></td>
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo $food; ?></td>
                            <td>₱<?php echo $price; ?></td>
                            <td><?php echo $qty; ?></td>
                            <td>₱<?php echo $total; ?></td>
                            <td><?php echo $order_date; ?></td>
                            <td><?php echo $status; ?></td>
                            
                            <td class="action-column">
                                <a href="<?php echo SITEURL; ?>edit-cart.php?key=<?php echo $key; ?>" class="btn btn-secondary float-end">Edit My Cart</a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='13' class='error'>Your Cart is Empty</td></tr>";
                }
                ?>
                </tbody>
            </table>
            <h3>Total Price: ₱<span id="total-price"><?php echo $total_price; ?></span></h3>
            <?php if(!empty($_SESSION['cart'])): ?>
                <div class="text-center">
                    

                    <a href="<?php echo SITEURL?>order.php" type="submit" name="confirm_order" id="confirm-order-btn" value="Confirm Order" class="btn btn-success">Order Now</a>
                    <button type="button" id="remove-multiple-orders" class="btn btn-danger">Remove Order/s</button>
                    <button type="submit" name="remove_selected" id="confirm-delete" class="btn btn-danger" style="display: none;">Confirm Delete</button>
                    <button type="button" id="back-button" class="btn btn-secondary" style="display: none;">Back</button>
                </div>
            <?php endif; ?>
        </form>
    </div>
</div>
<!--- main Section End--->

<?php include('partials-front/footer.php'); ?>

<script>
$(document).ready(function(){
    $('#remove-multiple-orders').on('click', function(){
        alert('Click the rows you want to delete.');
        $(this).hide();
        $('#confirm-delete').show();
        $('#back-button').show();
        $('#confirm-order-btn').hide();
        $('.select-column').show();
        $('.action-column').hide();
        $('table').addClass('selectable');
    });

    $('#back-button').on('click', function(){
        $('#remove-multiple-orders').show();
        $('#confirm-delete').hide();
        $('#back-button').hide();
        $('#confirm-order-btn').show();
        $('.select-column').hide();
        $('.action-column').show();
        $('table').removeClass('selectable');
        $('tr').removeClass('selected');
        $('.select-item').prop('checked', false);
    });

    $('tr[data-key]').on('click', function(){
        if($('table').hasClass('selectable')){
            $(this).toggleClass('selected');
            $(this).find('.select-item').prop('checked', $(this).hasClass('selected'));
        }
    });

    $('#cart-form').on('submit', function(){
        if($('#confirm-delete').is(':visible')){
            if ($('.select-item:checked').length === 0) {
                alert('Please select at least one item to delete.');
                return false;
            }
            return confirm('Are you sure you want to delete the selected items?');
        }
    });
});

// Update total price on quantity change
$('input[name="qty"]').on('change', function(){
    var key = $(this).closest('tr').data('key');
    var newQty = $(this).val();
    var price = parseFloat($(this).closest('tr').find('td:nth-child(4)').text().replace('₱', ''));
    var newTotal = newQty * price;

    $(this).closest('tr').find('td:nth-child(6)').text('₱' + newTotal.toFixed(2));

    var totalPrice = 0;
    $('tbody tr').each(function(){
        var rowTotal = parseFloat($(this).find('td:nth-child(6)').text().replace('₱', ''));
        totalPrice += rowTotal;
    });

    $('#total-price').text(totalPrice.toFixed(2));
});
</script>

<style>
tr.selected {
    background-color: #f8d7da !important;
}
.select-column {
    width: 50px;
}
</style>
<?php include('partials-front/menu.php');
if (!isset($_SESSION['user_id'])) {
    header('location:'.SITEURL.'login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
?>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
            

        ?>

        <br /><br>
        <!--- buttone to add admin--->
        
    <br />
        <table class="table table-bordered table-striped">
            <tr>
                <th>S.N</th>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Customer Name</th>
                <th>Customer Contact</th>
                <th>Email</th>
                <th>Address</th>
                <th>Actions</th>
            </tr> 

            <?php

            $sql = "SELECT * FROM tbl_orders WHERE status='Delivered' AND user_id=$user_id ORDER BY id DESC";

            $res = mysqli_query($conn, $sql);

            $count = mysqli_num_rows($res);

            $sn = 1;

            if($count>0){

                while($row=mysqli_fetch_assoc($res)){
                    $id = $row['id'];
                    $food = $row['food'];
                    $price = $row['price'];
                    $qty = $row['qty'];
                    $total = $row['total'];
                    $order_date = $row['oder_date'];
                    $status = $row['status'];
                    $customer_name = $row['customer_name'];
                    $customer_contact = $row['customer_contact'];
                    $customer_email = $row['customer_email'];
                    $customer_address = $row['customer_address'];

                    ?>

                        <tr>
                            <td><?php echo $sn++?></td>
                            <td><?php echo $food?></td>
                            <td><?php echo $price?></td>
                            <td><?php echo $qty?></td>
                            <td><?php echo $total?></td>
                            <td><?php echo $order_date?></td>
                            <td><?php echo $status?></td>

                            




                            <td><?php echo $customer_name?></td>
                            <td><?php echo $customer_contact?></td>
                            <td><?php echo $customer_email?></td>
                            <td><?php echo $customer_address?></td>
                            <td>
                                <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    Review
                                </button> -->

                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Product Review</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                           <p>Name: <input type = "text" id = "cname" name = "cname" value = "<?php echo $customer_name ?>" disabled></p>
                                           <p>Product: <input type = "text" id = "cname" name = "cname" value = "<?php echo $food ?>" disabled> </p>
                                           <p>Date: <input type = "text" id = "cname" name = "cname" value = "<?php echo $order_date ?>" disabled> </p>
                                           <p>Rating:</p>
                                                <div class="star-rating">
                                                <input type="radio" id="star5" name="rating" value="5" />
                                                <label for="star5" class="fas fa-star"></label>
                                                <input type="radio" id="star4" name="rating" value="4" />
                                                <label for="star4" class="fas fa-star"></label>
                                                <input type="radio" id="star3" name="rating" value="3" />
                                                <label for="star3" class="fas fa-star"></label>
                                                <input type="radio" id="star2" name="rating" value="2" />
                                                <label for="star2" class="fas fa-star"></label>
                                                <input type="radio" id="star1" name="rating" value="1" />
                                                <label for="star1" class="fas fa-star"></label>
                                                </div>
                                            <p>Feedback:</p>
                                            <textarea id="feedback" name="feedback" rows="4" cols="55" placeholder = " (optional)"></textarea><br><br>
                                            Image (optional):
                                            <input type="file" id="attachment" name="attachment">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Submit</button>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            
                        </tr>

                    <?php
                    
                }

            }else{
                echo "<tr><td colspan = '12'>No Orders Available</td></tr>";
            }

            ?>

           
        </table>
    </div>
</div>


<!--- main Section End--->

<?php include('partials-front/footer.php') ?>
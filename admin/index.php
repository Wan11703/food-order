<?php include('partials/menu.php') ?>

<!--- main Section Start--->
<div class="main-content">

    <br><br>
        <?php
            if(isset($_SESSION['add'])){
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }
        ?>
    <br><br>
    

    
    
    <section class="section-padding" style="margin-top: -20px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-header text-center pb-5">
                        <h1>DASHBOARD</h1>
                    </div>
                </div>
            </div>

            <div class="row g-5">

        
        
            <div class="col-lg-3 d-flex align-items-center">
                <div class="card bg-success bg-white pb-2 w-100 h-100">
                    <div class="card-body text-dark">
        

        <?php

        $sql = "SELECT * FROM tbl_category";

        $res = mysqli_query($conn, $sql);

        $count = mysqli_num_rows($res);



        ?>
            <h1><?php echo $count?></h1>
            <br />
            <h3 class="card-title">CATEGORIES</h3>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 d-flex align-items-center">
                <div class="card bg-success bg-white pb-2 w-100 h-100">
                    <div class="card-body text-dark">

        <?php

        $sql2 = "SELECT * FROM tbl_food";

        $res2 = mysqli_query($conn, $sql2);

        $count2 = mysqli_num_rows($res2);



        ?>


            <h1><?php echo $count2?></h1>
            <br />
            <h3 class="card-title">PRODUCTS</h3>
                </div>
            </div>
        </div>

        <div class="col-lg-3 d-flex align-items-center">
    <div class="card bg-success bg-white pb-2 w-100 h-100">
        <div class="card-body text-dark">

            <?php
                // Count the total number of orders
                $sql_total = "SELECT * FROM tbl_orders";
                $res_total = mysqli_query($conn, $sql_total);
                $count_total = mysqli_num_rows($res_total);

                // Count the number of orders for each status
                $sql_delivered = "SELECT * FROM tbl_orders WHERE status = 'Delivered'";
                $res_delivered = mysqli_query($conn, $sql_delivered);
                $count_delivered = mysqli_num_rows($res_delivered);

                $sql_cancelled = "SELECT * FROM tbl_orders WHERE status = 'Cancelled'";
                $res_cancelled = mysqli_query($conn, $sql_cancelled);
                $count_cancelled = mysqli_num_rows($res_cancelled);

                $sql_on_delivery = "SELECT * FROM tbl_orders WHERE status = 'On Delivery'";
                $res_on_delivery = mysqli_query($conn, $sql_on_delivery);
                $count_on_delivery = mysqli_num_rows($res_on_delivery);

                $sql_preparing = "SELECT * FROM tbl_orders WHERE status = 'Preparing'";
                $res_preparing = mysqli_query($conn, $sql_preparing);
                $count_preparing = mysqli_num_rows($res_preparing);
            ?>

            <!-- Display the Total Orders and Status Breakdown -->
            <h1><?php echo $count_total; ?> Total Orders</h1>
            <br />
            <h3 class="card-title">ORDER STATUS</h3>
            <ul>
                <li><strong>Delivered:</strong> <?php echo $count_delivered; ?></li>
                <li><strong>Cancelled:</strong> <?php echo $count_cancelled; ?></li>
                <li><strong>On Delivery:</strong> <?php echo $count_on_delivery; ?></li>
                <li><strong>Preparing:</strong> <?php echo $count_preparing; ?></li>
            </ul>

            <br />
            
        </div>
    </div>
</div>


<div class="col-lg-3 d-flex align-items-center">
    <div class="card bg-success bg-white pb-2 w-100 h-100">
        <div class="card-body text-dark">

            <?php
                // Total revenue from delivered orders
                $sql_total_revenue = "SELECT SUM(total) AS Total FROM tbl_orders WHERE status='Delivered'";
                $res_total_revenue = mysqli_query($conn, $sql_total_revenue);
                
                if ($res_total_revenue) {
                    $row_total_revenue = mysqli_fetch_assoc($res_total_revenue);
                    $total_revenue = $row_total_revenue['Total'];
                } else {
                    // If the query fails, output the error
                    echo "Error: " . mysqli_error($conn);
                    $total_revenue = 0; // Default to 0 if the query fails
                }

                // Query to get the top 3 latest dates and their revenue
                $sql_top_dates = "SELECT DATE(oder_date) AS oder_date, SUM(total) AS daily_revenue
                                  FROM tbl_orders
                                  WHERE status = 'Delivered'
                                  GROUP BY DATE(oder_date)
                                  ORDER BY oder_date DESC
                                  LIMIT 3";
                $res_top_dates = mysqli_query($conn, $sql_top_dates);
                
                if (!$res_top_dates) {
                    // If the query fails, output the error
                    echo "Error: " . mysqli_error($conn);
                }
            ?>

            <!-- Display the Total Revenue -->
            <h1>₱<?php echo number_format($total_revenue, 2); ?></h1>
            <br />
            <h3 class="card-title">TOTAL REVENUE</h3>

            <br />

            <!-- Display the top 3 latest dates with revenue -->
            <h4>Top 3 Latest Dates:</h4>
            <ul>
                <?php
                    if ($res_top_dates) {
                        while ($row_top_dates = mysqli_fetch_assoc($res_top_dates)) {
                            $order_date = $row_top_dates['oder_date'];
                            $daily_revenue = $row_top_dates['daily_revenue'];
                            echo "<li><strong>$order_date:</strong> ₱" . number_format($daily_revenue, 2) . "</li>";
                        }
                    }
                ?>
            </ul>
        </div>
    </div>
</div>


<!-- Top 5 Most Bought Products -->
<div class="row g-5">
    <div class="col-lg-12">
        <div class="card bg-white pb-2 w-100 h-100">
            <div class="card-body text-dark">
                <h3 class="text-center">Top 5 Most Bought Products</h3>
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>Rank</th>
                        <th>Product Name</th>
                        <th>Order Count</th>
                    </tr>

                    <?php
                        // Query to get the top 5 most bought products
                        $sql_top_bought_products = "
                            SELECT food, COUNT(food) AS order_count
                            FROM tbl_orders
                            WHERE status = 'Delivered' -- Only consider delivered orders
                            GROUP BY food
                            ORDER BY order_count DESC
                            LIMIT 5
                        ";
                        $res_top_bought_products = mysqli_query($conn, $sql_top_bought_products);

                        if ($res_top_bought_products && mysqli_num_rows($res_top_bought_products) > 0) {
                            $rank = 1;
                            while ($row = mysqli_fetch_assoc($res_top_bought_products)) {
                                $product_name = $row['food'];
                                $order_count = $row['order_count'];

                                echo "<tr>
                                        <td>$rank</td>
                                        <td>$product_name</td>
                                        <td>$order_count</td>
                                      </tr>";
                                $rank++;
                            }
                        } else {
                            echo "<tr><td colspan='3' class='error'>No products found</td></tr>";
                        }
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>





        </div>
        </div>
    </section>
</div>
<!--- main Section End--->

<?php include('partials/footer.php') ?>
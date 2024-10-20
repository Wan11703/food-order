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

                $sql3 = "SELECT * FROM tbl_orders";

                $res3 = mysqli_query($conn, $sql3);

                $count3 = mysqli_num_rows($res3);



                ?>
            <h1><?php echo $count3?></h1>
            <br />
            <h3 class="card-title">TOTAL ORDERS</h3>
                </div>
            </div>
        </div>

        <div class="col-lg-3 d-flex align-items-center">
                <div class="card bg-success bg-white pb-2 w-100 h-100">
                    <div class="card-body text-dark">

        <?php

                $sql4 = "SELECT SUM(total) AS Total FROM tbl_orders WHERE status='Delivered'";

                $res4 = mysqli_query($conn, $sql4);

                $row4 = mysqli_fetch_assoc($res4);

                $total_revenue = $row4['Total'];



        ?>

            <h1>₱<?php echo $total_revenue?></h1>
            <br />
            <h3 class="card-title">TOTAL REVENUE</h3>
            </div>
            </div>
        </div>




        </div>
        </div>
    </section>
</div>
<!--- main Section End--->

<?php include('partials/footer.php') ?>
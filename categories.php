<?php include('partials-front/menu.php'); 
if (!isset($_SESSION['user_id'])) {
    header('location:'.SITEURL.'login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
?>



    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Our Categories</h2>


            <?php
            $sql = "SELECT * FROM tbl_category WHERE active='YES'";
            $res=mysqli_query($conn,$sql);

            $count = mysqli_num_rows($res);

            if($count>0){

                while($row=mysqli_fetch_assoc($res)){
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];

                        ?>
                            <a href="<?php echo SITEURL?>category-food.php?category_id=<?php echo $id?>">
                                <div class="box-3 float-container">
                                    <?php
                                        if($image_name == ""){
                                            echo "<div class='error'>No Images Found</div>";
                                        }else{

                                            ?>
                                                <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name?>" alt="Pizza" class="img-responsive img-curve">
                                            <?php
                                            
                                        }
                                    ?>
                                    

                                    <h3 class="float-text text-white"><?php echo $title; ?></h3>
                                </div>
                            </a>

                        <?php
                }

            }else{
                echo "<div class='error'>No Images Found</div>";
            }

            ?>




            


            

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->


    <?php include('partials-front/footer.php'); ?>
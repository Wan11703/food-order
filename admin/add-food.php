<?php include('partials/menu.php');?>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<style>
    h1
    {
        text-align: center;
    }
    table
    {
        width: 500px;
        margin-left: auto;
        margin-right: auto;
        border-radius: 15px;
    }
    .wrapper
    {
        
        width: 1000px;
        text-align: center;
        margin-left: auto;
        margin-right: auto;
        border-radius: 15px;
    }
    .add
    {
        width: 500px;
        text-align: center;
        margin-left: auto;
        margin-right: auto;
        border-radius: 15px;
        background-color: lightgray;
        padding-top: 50px;
        padding-bottom: 50px;
        padding-left: 50px;
        padding-right: 50px;
    }
</style>
<div class="main-content">
    <div class="wrapper">
        <br>
        <br>
        <h1>Add Food</h1>

        <?php
            if(isset($_SESSION['upload'])){
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>

        <br><br>
        <div class="add">
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">

                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Enter Food Title">
                    </td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Description"></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price" >
                    </td>
                </tr>

                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">
                            <?php
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                            $res = mysqli_query($conn, $sql);

                            $count = mysqli_num_rows($res);

                            if($count>0){
                                while($row=mysqli_fetch_assoc($res)){
                                    //get details of category
                                    $id=$row['id'];
                                    $title=$row['title'];
                                    ?>
                                        <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                    <?php
                                }
                            }else{
                                ?>
                                    <option value="0">No Categories Available</option>
                                <?php
                            }
                            ?>

                            
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured:  </td>
                    <td>
                        <input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                    <input type="radio" name="active" value="Yes">Yes
                    <input type="radio" name="active" value="No">No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food" class="btn btn-secondary">

                    </td>
                </tr>

            </table>
        </form>
        </div>
        <?php 
            if(isset($_POST['submit'])){
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category = $_POST['category'];
                
                if(isset($_POST['featured'])){
                    $featured = $_POST['featured'];
                }else{
                    $featured = "No";
                }

                if(isset($_POST['active'])){
                    $active = $_POST['active'];
                }else{
                    $active = "No";
                }

                if(isset($_FILES['image']['name'])){
                    $image_name=$_FILES['image']['name'];

                    if($image_name!=""){
                        $ext = end(explode('.',$image_name));

                        $image_name = "Food-Name".rand(0000,9999).'.'.$ext;


                        $src = $_FILES['image']['tmp_name'];

                        $dst = "../images/food/".$image_name;

                        //upload the image
                        $upload = move_uploaded_file($src, $dst);

                        //check if image is uploaded
                        if($upload==FALSE){
                            $_SESSION['upload']="<div class='error'>Failed to upload image</div>";
                            header('location:'.SITEURL.'admin/add-food.php');
                            die();
                        }







                    }

                }else{
                    $image_name="";
                }

                $sql2 = "INSERT INTO tbl_food SET
                title = '$title',
                description = '$description',
                price = $price,
                image_name = '$image_name',
                category_id = $category,
                featured = '$featured',
                active = '$active'
                 
                ";
                $res2 = mysqli_query($conn, $sql2);

                if($res2==TRUE){
                    $_SESSION['add']="<div class='success'>Food Added Successfully</div>";
                    header('location:'.SITEURL.'admin/manage_foods.php');
                    
                }else{
                    $_SESSION['add']="<div class='error'>Failed to add food</div>";
                    header('location:'.SITEURL.'admin/manage_foods.php');
                }
            }
        
        ?>


    </div>
</div>


<?php include('partials/footer.php');?>
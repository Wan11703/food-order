<?php include('partials/menu.php');?>

<?php
    if(isset($_GET['id'])){

        $id = $_GET['id'];

        $sql2 = "SELECT * FROM tbl_food WHERE id=$id";
        $res2 = mysqli_query($conn, $sql2);

        $row2 = mysqli_fetch_assoc($res2);

        $title = $row2['title'];
        $description = $row2['description'];
        $price = $row2['price'];
        $current_image = $row2['image_name'];
        $current_category = $row2['category_id'];
        $featured = $row2['featured'];
        $active = $row2['active'];
        

    }else{
        header('location:'.SITEURL.'admin/manage_foods.php');
    }
?>




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
        padding-left: 30px;
    }
</style>

<div class="main-content">
    <div class="wrapper">
    <br><br>
        <h1>Update Food</h1>
        <div class="add">
            <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">

                <tr>
                    <td>Title: </td>
                    <td><input type="text" name="title" value="<?php echo $title; ?>"></td>
                </tr>

                <tr>
                    <td>Description</td>
                    <td>
                        <textarea name="description" cols="30" row="5"><?php echo $description; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td><input type="number" name="price" value="<?php echo $price; ?>"></td>
                </tr>

                <tr>
                    <td>Current image: </td>
                    <td>
                        <?php 
                        if($current_image != ""){
                            ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image?>" width="100px" alt="<?php echo $title ?>">
                            <?php
                        }else{
                            echo "<div class='error'>Image Unavailable</div>";
                        }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>New Image: </td>
                    <td><input type="file" name="image" ></td>
                </tr>

                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category" >

                        <?php
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                            $res = mysqli_query($conn, $sql);

                            $count = mysqli_num_rows($res);

                            if($count>0){
                                while($row=mysqli_fetch_assoc($res)){
                                    $category_title = $row['title'];
                                    $category_id = $row['id'];

                                    //echo "<option value='$category_id'>$category_title</option>";

                                    ?>
                                        <option <?php if($current_category==$category_id){echo "selected";}?> value="<?php echo $category_id ?>"><?php echo $category_title?></option>
                                    <?php

                                }
                            }else{
                                //not available
                                echo "<option value='0'>Category Unavailable</option>";
                            }

                        ?>

                        
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td><input <?php if($featured=="Yes"){echo "checked";}?> type="radio" name="featured" value="Yes">Yes

                    <input <?php if($featured=="No"){echo "checked";}?> type="radio" name="featured" value="No">No</td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td><input <?php if($active=="Yes"){echo "checked";}?> type="radio" name="active" value="Yes">Yes
                    <input <?php if($active=="No"){echo "checked";}?> type="radio" name="active" value="No">No
                    </td>
                    
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">

                        
                    </td>
                    
                </tr>

            </table>
            <br>
            <input type="submit" name="submit" value="Update Food" class="btn btn-secondary">
            </form>
        </div>
        <?php
            if(isset($_POST['submit'])){
                $id = $_POST['id'];
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $current_image = $_POST['current_image'];
                $category = $_POST['category'];

                $featured = $_POST['featured'];
                $active = $_POST['active'];

                //upload image if selected
                if(isset($_FILES['image']['name'])){
                    $image_name =$_FILES['image']['name'];

                    if($image_name != ""){





                        $ext=end(explode('.', $image_name));
                        $image_name = "Food_Name".rand(0000,9999).'.'.$ext;
                        

                        $src_path = $_FILES['image']['tmp_name'];

                        $dest_path = "../images/food/".$image_name;

                        //upload the image
                        $upload = move_uploaded_file( $src_path, $dest_path);

                        //check if image is uploaded
                        if($upload==FALSE){
                            $_SESSION['upload']="<div class='error'>Failed to upload image</div>";
                            header('location:'.SITEURL.'admin/manage_foods.php');
                            die();
                        }

                        if($current_image!=""){
                            $remove_path = "../images/food/".$current_image;
        
                            $remove = unlink($remove_path);
        
                            if($remove==FALSE){
                                $_SESSION['remove-failed']="<div class'error'>Failed to Remove Current Image</div>";
                                header('location:'.SITEURL.'admin/manage_foods.php');
                                die();
                        }
                        }




                    }else{
                        $image_name = $current_image;
                    }


                }else{
                    $image_name = $current_image;
                }

                $sql3 = "UPDATE tbl_food SET
                        title = '$title',
                        description = '$description',
                        price = $price,
                        image_name = '$image_name',
                        category_id = '$category',
                        featured = '$featured',
                        active = '$active'
                        WHERE id=$id
                "; 

                $res3 = mysqli_query($conn, $sql3);

                if($res3==TRUE){
                    $_SESSION['update']= "<div class='success'>Food Updated Successfully</div>";
                    header('location:'.SITEURL.'admin/manage_foods.php');
                }else{
                    $_SESSION['update']= "<div class='error'>Failed to Update Food</div>";
                    header('location:'.SITEURL.'admin/manage_foods.php');
                }
            }
        ?>



    </div>
</div>




<?php include('partials/footer.php');?>
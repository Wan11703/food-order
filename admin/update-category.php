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
        <h1>Update Category</h1>
        <br><br>

        <?php 
            if(isset($_GET['id'])){
                //echo "get data";

                $id = $_GET['id'];

                $sql = "SELECT * FROM tbl_category WHERE id=$id";

                $res=mysqli_query($conn, $sql);
                
                $count = mysqli_num_rows($res);

                if($count==1){
                    $row = mysqli_fetch_assoc($res);
                    $title = $row['title'];
                    $current_image = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
                }else{
                    $_SESSION['no-category-found']="<div>Category Not Found</div>";
                    header('location:'.SITEURL.'admin/manage_category.php');
                }
            }else{
                header('location:'.SITEURL.'admin/manage_category.php');
            }
        ?>


    <div class="add">
    <form action="" method="POST" enctype="multipart/form-data">
        <table class="tbl-30">
            <tr>
                <td>Title: </td>
                <td><input type="text" name="title" value="<?php echo $title; ?>"></td>
            </tr>

            <tr>
                <td>Current image: </td>
                <td>
                    <?php 
                    if($current_image != ""){
                        ?>
                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image?>" width="100px">
                        <?php
                    }else{
                        echo "<div class='error'>Image not added</div>";
                    }
                    ?>
                </td>
            </tr>

            <tr>
                <td>New Image: </td>
                <td><input type="file" name="image" ></td>
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
        <input type="submit" name="submit" id="" value="Update Category" class="btn btn-secondary">
        </form>
        </div>
        <?php 
        if(isset($_POST['submit'])){
            //echo"wdqw";
            $id = $_POST['id'];
            $title = $_POST['title'];
            $current_image = $_POST['current_image'];
            $featured = $_POST['featured'];
            $active = $_POST['active'];

            if(isset($_FILES['image']['name'])){
                $image_name=$_FILES['image']['name'];

                if($image_name != ""){
                    $ext=end(explode('.', $image_name));
                    $image_name = "Food_Category".rand(000,999).'.'.$ext;
                    

                    $source_path = $_FILES['image']['tmp_name'];

                    $destination_path = "../images/category/".$image_name;

                    //upload the image
                    $upload = move_uploaded_file($source_path, $destination_path);

                //check if image is uploaded
                if($upload==FALSE){
                    $_SESSION['upload']="<div class='error'>Failed to upload image</div>";
                    header('location:'.SITEURL.'admin/add-category.php');
                    die();
                }
                //b remove current image
                if($current_image!=""){
                    $remove_path = "../images/category/".$current_image;

                    $remove = unlink($remove_path);

                    if($remove==FALSE){
                        $_SESSION['failed-remove']="<div class'error'>Failed to Remove Current Image</div>";
                        header('location:'.SITEURL.'admin/manage_category.php');
                        die();
                }
                }
                

                }else{
                    $image_name = $current_image;
                }

            }else{
                $image_name = $current_image;
            }

            $sql2 = "UPDATE tbl_category SET
            title = '$title',
            image_name = '$image_name',
            featured = '$featured',
            active = '$active'
            WHERE id=$id
            ";

            $res2= mysqli_query($conn,$sql2);

            if($res2==TRUE){
                $_SESSION['update']= "<div class='success'>Category Updated Successfully</div>";
                header('location:'.SITEURL.'admin/manage_category.php');
            }else{
                $_SESSION['update']= "<div class='error'>Failed to Update Category</div>";
                header('location:'.SITEURL.'admin/manage_category.php');
            }
            
        }
        ?>


    </div>
</div>


<?php include('partials/footer.php');?>
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
        <h1>Add Category</h1>
        <br><br>

        <?php 
        if(isset($_SESSION['add'])){
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
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
                        <input type="text" name="title" placeholder="Category Title">
                    </td>
                </tr>

                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
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
                        <input type="submit" name="submit" class="btn btn-secondary" value="Add Category">
                    </td>
                </tr>
            </table>
        </form>
        </div>
        <!---Add Category to db--->
        <?php 
        if(isset($_POST['submit'])){

            //get the value from forms
            $title = $_POST['title'];


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

            //check if images is selected
            //print_r($_FILES['image']);

            //die();
            if(isset($_FILES['image']['name'])){
                //upload the image
                $image_name=$_FILES['image']['name'];

                //upload imageonli if image is selected
                if($image_name!="")
                {

                

                //rename image
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
                }
            }
            else{
                $image_name="";
            }

            //sql query to insert data in db

            $sql = " INSERT INTO tbl_category SET 
            title = '$title', 
            image_name = '$image_name', 
            featured = '$featured', 
            active = '$active'
            ";
    $res = mysqli_query($conn, $sql);

    if($res==TRUE){
        $_SESSION['add']="<div class='success'>Category added susccessfully</div>";
        header('location:'.SITEURL.'admin/manage_category.php');
    }else{
        $_SESSION['add']="<div class='error'>Failed to add category</div>";
        header('location:'.SITEURL.'admin/add-category.php');
    }


        }
        
        ?>
    


    </div>
</div>
<br>

<?php include('partials/footer.php');?>
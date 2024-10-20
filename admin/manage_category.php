 <?php include('partials/menu.php') ?>

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
        text-align: center;
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
</style>
<!--- main Section Start--->
<div class="main-content">
    <div class="wrapper">
        <br>
        <br>
        <h1>Manage Category</h1>
        <?php 
        if(isset($_SESSION['add'])){
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        if(isset($_SESSION['remove'])){
            echo $_SESSION['remove'];
            unset($_SESSION['remove']);
        }
        if(isset($_SESSION['delete'])){
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }
        if(isset($_SESSION['no-category-found'])){
            echo $_SESSION['no-category-found'];
            unset($_SESSION['no-category-found']);
        }
        if(isset($_SESSION['update'])){
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }
        if(isset($_SESSION['upload'])){
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        if(isset($_SESSION['failed-remove'])){
            echo $_SESSION['failed-remove'];
            unset($_SESSION['failed-remove']);
        }
        ?>

        <br><br>
        
        <!--- buttone to add admin--->
        <a href="add-category.php" class="btn btn-primary float-end">Add Category</a>
        <br><br>
        <table class="table table-bordered table-striped">
            <tr>
                <th>S.N</th>
                <th>Title</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>

            <?php 
            $sql = "SELECT * FROM tbl_category";
            $res = mysqli_query($conn, $sql);

            $count = mysqli_num_rows($res);

            $sn=1;
            if($count>0){
                while($row=mysqli_fetch_array($res)){
                    $id=$row['id'];
                    $title=$row['title'];
                    $image_name=$row['image_name'];
                    $featured=$row['featured'];
                    $active=$row['active'];

                    ?>

                            <tr>
                                <td><?php echo $sn++;?></td>
                                <td><?php echo $title;?></td>

                                <td>
                                    <?php 
                                        //check if image name is available
                                        if($image_name!=""){
                                            ?>

                                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name?>" width="100px">

                                            <?php
                                        }else{
                                            echo"<div class='error'>No Image Found</div>";
                                        }
                                    ?>
                                </td>

                                <td><?php echo $featured;?></td>
                                <td><?php echo $active;?></td>
                                <td>
                                    <a href="<?php echo SITEURL; ?>admin/update-category.php?id=<?php echo $id; ?>" class="btn btn-secondary float-end">Update Category</a>
                                    <a href="<?php echo SITEURL; ?>admin/delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn btn-danger float-end">Delete Category</a>
                                </td>
                            </tr>

                    <?php
                }
            }else{
                ?>
                <tr>
                    <td colspan="6"><div class="error">No Catgeory Added</div></td>
                </tr>


                <?php
            }
            ?>

            
        </table>
    </div>
</div>
<!--- main Section End--->

<?php include('partials/footer.php') ?>




<?php include('partials/menu.php');
ob_start();
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
        <h1 class="mt-5">Manage Admin</h1>


    <br /><br>
    <?php 
        if(isset($_SESSION['add'])){
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        if(isset($_SESSION['delete'])){
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }
        if(isset($_SESSION['update'])){
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }
        if(isset($_SESSION['user-not-found'])){
            echo $_SESSION['user-not-found'];
            unset($_SESSION['user-not-found']);
        }
        if(isset($_SESSION['pwd-not-match'])){
            echo $_SESSION['pwd-not-match'];
            unset($_SESSION['pwd-not-match']);
        }
        if(isset($_SESSION['change-pwd'])){
            echo $_SESSION['change-pwd'];
            unset($_SESSION['change-pwd']);
        }
        
    ?>

        <!--- buttone to add admin--->
        <a href="add-admin.php" class="btn btn-primary float-end">Add Admin</a>
        <br>
        <br>
        <table class="table table-bordered table-striped">
            <tr>
                <th>S.N</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Actions</th>
            </tr>

            <?php 
            //query to get all records
                $sql = "SELECT * FROM tbl_admin";
            //execute
                $res = mysqli_query($conn, $sql);
            
            //check is query is executed
            if($res == TRUE){
                //COUNT ROWS to check if there are data in db
                $count = mysqli_num_rows($res);

                $sn = 1;

                //check the number of rows
                if($count >0){ //true
                    while($rows=mysqli_fetch_assoc($res)){
                        //get all the data in  db 

                        //get individual data
                        $id = $rows['id'];
                        $full_name = $rows['full_name'];
                        $username = $rows['username'];
                        //$id = $rows['id'];

                        //display the records in the table 

                        ?>

                        <tr>
                            <td><?php echo $sn++?></td>
                            <td><?php echo $full_name?></td>
                            <td><?php echo $username?></td>
                            <td>
                                <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id;?>" class="btn btn-secondary float-end">Update Admin</a>
                                <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id;?>" class="btn btn-danger float-end">Delete Admin</a>
                                <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id;?>" class="btn btn-primary float-end">Change Password</a>
                            </td>
                        </tr>

                        <?php


                    }
                }else{//false

                }
            }
            ?>

            
        </table>
    </div>

</div>

<!--- main Section End--->


<?php
ob_end_flush();
?>
<?php include('partials/footer.php') ?>




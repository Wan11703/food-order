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
        <h1>Change Password</h1>
        <br><br>

        <?php 
            if(isset($_GET['id'])){
                $id=$_GET['id'];
            }
        
        ?>

        <form action="" method="POST">
            <table>
                <tr>
                    <td>Old Password: </td>
                    <td><input type="password" name="current_password" value="" placeholder="Old Password"></td>
                </tr>

                <tr>
                    <td>New Password: </td>
                    <td><input type="password" name="new_password" id="" placeholder="New Password"></td>
                </tr>

                <tr>
                    <td>Confirm Password: </td>
                    <td><input type="password" name="confirm_password" placeholder="Confirm Password"></td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id?>">
                        <input type="submit" name="submit" value="Change Password" class="btn btn-primary float-end mx-5" style="margin-left: 100px;">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php 
    if(isset($_POST['submit'])){
        $id=$_POST['id'];
        $current_password = md5($_POST['current_password']);
        $new_password = md5($_POST['new_password']);
        $confirm_password = md5($_POST['confirm_password']);

        $sql="SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";
        $res=mysqli_query($conn, $sql);

        if($res==TRUE){
            $count = mysqli_num_rows($res);
            if($count==1){
                //echo"user";
                if($new_password==$confirm_password){
                    $sql2 = "UPDATE tbl_admin SET
                    password = '$new_password'
                    WHERE id = $id
                    ";

                    $res2 = mysqli_query($conn, $sql2);

                    if($res2==TRUE){
                        $_SESSION['change-pwd'] = "<div class='success'>Password Changed</div>";
                        header('location:'.SITEURL.'admin/manage_admin.php');
                    }else{
                        $_SESSION['change-pwd'] = "<div class='error'>Failed to change password</div>";
                        header('location:'.SITEURL.'admin/manage_admin.php');
                    }
                }else{
                    $_SESSION['pwd-not-match'] = "<div class='error'>Password Did not Match</div>";
                    header('location:'.SITEURL.'admin/manage_admin.php');
                }
               
            }else{
                $_SESSION['user-not-found'] = "<div class='error'>User not Found</div>";
                header('location:'.SITEURL.'admin/manage_admin.php');
            }
        }

    }
?>


<?php include('partials/footer.php') ?>
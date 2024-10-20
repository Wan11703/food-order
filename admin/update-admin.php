<?php
include('partials/menu.php')
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
        <h1>
            Update Admin
        </h1>
        <br><br>

        <?php 
        //GET ID
        $id = $_GET['id'];
        $sql = "SELECT * FROM tbl_admin WHERE id=$id";

        $res= mysqli_query($conn, $sql);
        
        //check if query is executed

        if($res ==TRUE){
             $count = mysqli_num_rows($res);
             if($count==1){
                //echo"admin available";

                $row = mysqli_fetch_assoc($res);

                $id = $row['id'];
                $full_name = $row['full_name'];
                $username = $row['username'];
             }else{
                header('location:'.SITEURL.'admin/manage_admin.php');
             }
        }
        ?>



        <form action="" method="POST">
            <table>
            <tr>
                    <td>Full Name: </td>
                    <td><input type="text" name="full_name" id="" value="<?php echo $full_name?>"></td>
                </tr>

                <tr>
                    <td>Username: </td>
                    <td><input type="text" name="username" id="" value="<?php echo $username?>"></td>
                </tr>

                

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn btn-secondary float-end">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php 
if(isset($_POST['submit'])){
    //echo"wefjmwebfjweb";
    $id = $_POST['id'];
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];

    $sql = "UPDATE tbl_admin SET
    full_name = '$full_name',
    username = '$username' 
    WHERE id=$id
    ";

    $res = mysqli_query($conn, $sql);
    if($res==TRUE){
        $_SESSION['update'] = "<div class='success'> Admin updated successfully <div>";
        header('location:'.SITEURL.'admin/manage_admin.php');
    }else{
        $_SESSION['update'] = "<div class='error'> Admin not updated <div>";
        header('location:'.SITEURL.'admin/manage_admin.php');

    }


}
?>





<?php
include('partials/footer.php')
?>
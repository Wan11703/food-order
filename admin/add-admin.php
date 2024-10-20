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
        <h1>ADD ADMIN</h1>

        <?php 
        if(isset($_SESSION['add'])){
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
    ?>

        <br><br>

        <form action="" method="POST">
            <table>
                <tr>
                    <td>Full Name: </td>
                    <td><input type="text" name="full_name" id="" placeholder="Enter your name."></td>
                </tr>

                <tr>
                    <td>Username: </td>
                    <td><input type="text" name="username" id="" placeholder="Enter your username."></td>
                </tr>

                <tr>
                    <td>Password: </td>
                    <td><input type="password" name="password" id="" placeholder="Enter your password."></td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn btn-secondary float-end">
                    </td>
                </tr>
            </table>

        </form>
    </div>
</div>


<?php include('partials/footer.php') ?>

<?php 
//process the value from form and save it in the database
//check if add button is is clicked

if(isset($_POST['submit']))
{
    //button clicked
    //echo "clicked";
    //get the in form
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $password = md5($_POST['password']); //password encryption 

    //sql query to save data
    $sql = "INSERT INTO tbl_admin SET
    full_name = '$full_name',
    username = '$username',
    password = '$password'
    ";
    //echo $sql;

    

    $res = mysqli_query($conn, $sql) or die(mysqli_error());

    //check if the data is inserted in the database (query is executed or not)
    if($res==TRUE){
        //echo"data is inserted";
        //variable session to display messsage
        $_SESSION['add'] = "Admins added successfully";
        header("location:".SITEURL.'admin/manage_admin.php');
    }else{
        //button not clicked
    //echo "not clicked";
    //echo"data is inserted";
    //variable session to display messsage
    $_SESSION['add'] = "Failed to add admin";
    header("location:add-admin.php");
    }



}else{
    
}




?>
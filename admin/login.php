<?php
include('../config/constants.php')
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body>
    <div class="login">
        <h1>Login</h1>
    <br><br>

    <?php 
    if(isset($_SESSION['login'])){
        echo $_SESSION['login'];
        unset($_SESSION['login']);
    }
    if(isset($_SESSION['no-login-message'])){
        echo $_SESSION['no-login-message'];
        unset($_SESSION['no-login-message']);
    }
    ?>

    <br><br>
<!--Login starts here--->

        <form action="" method="POST" class="text-center">
            Username: <br>
            <input type="text" name="username" placeholder="Enter username"><br><br>
            Password:<br>
            <input type="password" name="password" placeholder="Enter Password"><br><br>
    <br><br>
            <input type="submit" name="submit" value="Login" class="btn btn-primary"><br>

        </form>

<!--login ends here--->

        
    </div>
    


</body>
</html>

<?php 
    //check if the submit button is clicked
    if(isset($_POST['submit'])){
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        //sql query
        $sql = "SELECT * FROM tbl_admin WHERE username = '$username' AND password = '$password'";
        $res= mysqli_query($conn, $sql);
        
        $count = mysqli_num_rows($res);

        if($count==1){
            $_SESSION['login'] = "<div class='success'>Login Success</div>";
            $_SESSION['user'] = $username;

            header('location:'.SITEURL.'admin/inde.php');
        }else{
            $_SESSION['login'] = "<div class='error text-center'>Login Failed: Wrong Username and Password</div>";
            header('location:'.SITEURL.'admin/login.php');
        }
    }


?>
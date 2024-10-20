<?php 
    //authorization of access control
    //check if the user is logged in
    if(!isset($_SESSION['user'])){
        $_SESSION['no-login-message'] = "<div class='error text-center'>Please login to access admin panel</div>";
        header('location:'.SITEURL.'admin/login.php');
    }
    
?>
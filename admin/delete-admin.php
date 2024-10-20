<?php 
    //get the id of admin to be deleted

    include('../config/constants.php');

     $id = $_GET['id'];

    $sql = "DELETE FROM tbl_admin WHERE id = '$id'";

    //execute
    $res = mysqli_query($conn, $sql);

    //check if the query executed is susccessful
    if($res==TRUE){
        //susccess

        //echo"Admin Deleted";

        //create session variable to display message
        $_SESSION['delete'] = "ADMIN DELETED SUCCESSFULLY";
        header('location:'.SITEURL.'admin/manage_admin.php');
    }else{
        //failed
        //echo"Admin Failed to Deleted";
        //create session variable to display message
        $_SESSION['delete'] = "FAILED TO DELETE ADMIN";
        header('location:'.SITEURL.'admin/manage_admin.php');
    }




?>
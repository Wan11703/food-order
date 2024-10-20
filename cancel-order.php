<?php 
    //get the id of admin to be deleted

    include('config/constants.php');

     $id = $_GET['id'];

    $sql = "DELETE FROM tbl_orders WHERE id = $id AND status='Ordered'";

    //execute
    $res = mysqli_query($conn, $sql);

    //check if the query executed is susccessful
    if($res==TRUE){
        //susccess

        //echo"Admin Deleted";

        //create session variable to display message
        $_SESSION['delete'] = "FAILED TO CANCEL ORDER";
        header('location:'.SITEURL.'cart.php');
        
    }else{
        //failed
        //echo"Admin Failed to Deleted";
        //create session variable to display message
        

        $_SESSION['delete'] = "ORDER CANCELLED SUCCESSFULLY";
        header('location:'.SITEURL.'cart.php');
    }




?>
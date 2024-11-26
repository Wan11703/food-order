<?php 
//start session
    session_start();

    //create constant to store non repeating values
    define('SITEURL', 'http://localhost/food-order/');
    define('LOCALHOST', 'localhost');
    define('DB_USERNAME', 'if0_37753721');
    define ('DB_PASSWORD', 'Yfi3PSbPr3');
    define('DB_NAME', 'if0_37753721_user');



    $conn = mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die(mysqli_error()); //connection
    $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());



?>
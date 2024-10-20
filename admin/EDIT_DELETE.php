


<?php
include('partials/menu.php');
//require 'db/database1.php';

if(isset($_POST['delete_user']))
{
    $users_id = mysqli_real_escape_string($conn, $_POST['delete_user']);

    $query = "DELETE FROM users WHERE id='$users_id' ";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $_SESSION['message'] = "User Deleted Successfully";
        header("Location: log.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "User Not Deleted";
        header("Location: log.php");
        exit(0);
    }
}

if(isset($_POST['update']))
{
    $user_id = mysqli_real_escape_string($conn, $_POST['users_id']);

    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $birthdate = mysqli_real_escape_string($conn, $_POST['birthdate']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    

    $query = "UPDATE users SET firstname='$firstname',lastname='$lastname',username='$username',gender='$gender',email='$email',birthdate='$birthdate' WHERE id= $user_id";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $_SESSION['message'] = "User Updated Successfully";
        header("Location: log.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "User Not Updated";
        header("Location: log.php");
        exit(0);
    }

    

}


if(isset($_POST['change']))
{
    $user_id = mysqli_real_escape_string($conn, $_POST['users_id']);

    
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $query = "UPDATE users SET password='$hash' WHERE id= $user_id";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Password Updated Successfully";
        header("Location: log.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Password Not Updated";
        header("Location: log.php");
        exit(0);
    }

    

}





?>
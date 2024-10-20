<?php 
    include('partials/menu.php');

    
    if (isset($_SESSION['counter'])) {
        $_SESSION['counter'] ++;
        $msg = "You have visited this page ". $_SESSION['counter'];
        $msg .= " times in this session.";
        }else {
        $_SESSION['counter'] =0 ;
       
        echo "session does not exist";
        }

        if (!isset($_COOKIE['username'])) {
            
            header("Location: LOGIN.php");
            exit();
        }
        
        
        $username = $_COOKIE['username'];
        
        
        
        
        
        


        
       
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        *
        {
            font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
        }
        body
        {
            background-image: url("https://images.unsplash.com/photo-1554118811-1e0d58224f24?q=80&w=2647&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D");

            /* Set a specific height */
            min-height: 500px;

            /* Create the parallax scrolling effect */
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;

        }
        .header
        {
            color: white;
            text-align: center;
            background-color: rgb(61, 38, 20, 0.75);
            font-size: 50px;
            padding-top: 50px;
            padding-bottom: 50px;
            border-radius: 15px;
            backdrop-filter: blur(5px);
            font-weight: 300;
        }
</style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <br>
                <br>
                <div class="card-header">
                    <h4>
                        <div class="header">
                            
                           
                            
                            <h5>User Details</h5>
                            <div style="font-size: 15px; margin-top:10px;">
                                <?php echo $msg; ?><br>
                                
                                
                            </div>
                        </div>
                        <br>
                        <a href="NEW_USER.php" class="btn btn-primary float-end" style="margin-left: 10px;">New User</a>
                        
                    </h4>
                    <br>
                    <br>
                </div>
        
                <h6 class="mt-5"><b>Search Name</b></h6>
                <div class="input-group mb-4 mt-3">
                    <div class="form-outline">
                        <input type="text" id="getName"/>
                    </div>
                </div>




                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Middle Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Contact Number</th>
                                <th>Gender</th>
                                <th>Birthdate</th>
                                <th>Age</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="showdata">

                        
                            <?php 
                            //echo $msg;
                            $query = "SELECT * FROM users";
                            $query_run=mysqli_query($conn, $query);
                            
                            if(mysqli_num_rows($query_run)>0){
                                foreach($query_run as $users){
                                    //echo $users['firstname'];
                                    ?>
                                    <tr>
                                        <td><?= $users['id'];?></td>
                                        <td><?= $users['firstname'];?></td>
                                        <td><?= $users['lastname'];?></td>
                                        <td><?= $users['middlename'];?></td>
                                        <td><?= $users['username'];?></td>
                                        <td><?= $users['email'];?></td>
                                        <td><?= $users['contact'];?></td>
                                        <td><?= $users['gender'];?></td>
                                        <td><?= $users['birthdate'];?></td>
                                        <td><?= $users['age'];?></td>
                                        <td>
                                            <!--<a href="UPDATE.php?id=<?= $users['id'];?>" class="btn btn-success btn-sm" onclick="return confirm('Are you sure you want to edit this user?')">Edit</a>-->
                                            <!--
                                            <a href="changepass.php?id=<?= $users['id'];?>" class="btn btn-success btn-sm" onclick="return confirm('Are you sure you want to edit this user\s password?')">Change Password</a>
                                            -->
                                            <form action="EDIT_DELETE.php" method="POST" class="d-inline" onsubmit="return confirmDelete()">
                                            <button type="submit" name="delete_user" value="<?=$users['id'];?>" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>

                                        <script>
                                            function confirmDelete() {
                                            return confirm('Are you sure you want to delete this user?');
                                            }
                                        </script>
                                        
                                    </tr>
                                    <?php
                                }
                            }else{
                                echo "No records Found";
                            }
                            ?>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <script>
    $(document).ready(function(){
    $('#getName').on("keyup", function(){
        var getName = $(this).val();
        $.ajax({
        method:'POST',
        url:'SEARCH.php',
        data:{firstname:getName},
        success:function(response)
        {
                $("#showdata").html(response);
        } 
        });
    });
    });
    </script>


</body>
</html>
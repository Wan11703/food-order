<?php 
include('config/constants.php');



            if(isset($_SESSION['notification'])){
                echo $_SESSION['notification'];
                unset($_SESSION['notification']);
            }
            
            

        

if (isset($_SESSION['counter'])) {
    $msg = "You have visited this page ". $_SESSION['counter'];
    $msg .= " time(s) in this session.";
    $_SESSION['counter']++;
} else {
    $_SESSION['counter'] = 1;
    $msg = "session does not exist";
}

if (!isset($_SESSION['creation_time'])) {
    $_SESSION['creation_time'] = time();
}
$_SESSION['last_access_time'] = time();

if(isset($_POST['submit'])){
    $username = mysqli_real_escape_string($conn,$_POST['username']);
    $password = mysqli_real_escape_string($conn,$_POST['password']);

    $result = mysqli_query($conn,"SELECT * FROM users WHERE username='$username'") or die("Select Error");
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            setcookie("username", $username, time() + (86400 * 30), "/"); 

            $id = $row['id'];
            
            header('location:'.SITEURL."ind.php");
            exit();
        } else {
            echo "<div class='message' style=\"text-align: center\">
                    <p>Wrong Password!</p>
                  </div> <br>";
            echo "<a href='LOGIN.php'><button class='btn'>Go Back</button></a>";
        }
    } else {
        echo "<div class='message'>
                <p>Wrong Username!</p>
              </div> <br>";
        echo "<a href='LOGIN.php'><button class='btn'>Go Back</button></a>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Login</title>
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
        header
        {
            font-style: italic;
            font-size: 40px;
            font-weight: bold;
            
        }
        button
        {
            margin-left: 690px;
        }
        .container
        {
            text-align: center;
            background-color: rgb(61, 38, 20, 0.75);
            border-style: solid;
            border-width: 1px;
            border-color: #e8f0fe;
            color: white;
            border-radius: 15px;
            margin-left: auto;
            margin-right: auto;
            margin-top: 150px;
            padding-top: 50px;
            padding-right: 20px;
            padding-bottom: 50px;
            padding-left: 20px;
            width: 720px;
            font-size: 20px;
            font-weight: 300;
            backdrop-filter: blur(5px);
        }
        .container2
        {
            text-align: center;
            background-color: rgb(61, 38, 20, 0.75);
            border-style: solid;
            border-width: 1px;
            border-color: #e8f0fe;
            color: white;
            border-radius: 15px;
            margin-left: auto;
            margin-right: auto;
            margin-top: 20px;
            padding-top: 5px;
            padding-right: 20px;
            padding-bottom: 5px;
            padding-left: 20px;
            width: 720px;
            font-size: 20px;
            font-weight: 300;
            backdrop-filter: blur(5px);
        }
        .fieldinput
        {
            font-size: 30px;
        }
        input[type=text] 
        {
        background-color: #e8f0fe;
        border-radius: 15px;
        color: black;
        font-size: 30px; 
        width: 250px;
        font-weight: 300;
        }
        input[type=password] 
        {
        background-color: #e8f0fe;
        border-radius: 15px;
        color: black;
        font-size: 30px; 
        width: 250px;
        margin-left: 8px;
        margin-top: 10px;
        font-weight: 300;
        }
        input[type=Submit] 
        {
        height: 50px;
        font-size: 30px; 
        padding-top: 1px;
        background-color: #77738d;
        color:white;
        border-radius: 15px;
        padding-right: 30px;
        padding-left: 30px;
        margin-top: 10px;
        font-size: 20px;
        font-weight: 300;
        transition: 0.3s;
        }

        input[type=Submit]:hover 
        {
        background-color: #a39eba;
        color: white;
        }

        .btn 
        {
        height: 50px;
        font-size: 30px; 
        padding-top: 1px;
        background-color: #77738d;
        color:white;
        border-radius: 15px;
        padding-right: 30px;
        padding-left: 30px;
        margin-top: 10px;
        font-size: 20px;
        font-weight: 300;
        transition: 0.3s;
        }

        .btn:hover 
        {
        background-color: #a39eba;
        color: white;
        }
        /* unvisited link */
        a:link 
        {
        color: #e4a6ff;
        }

        /* visited link */
        a:visited 
        {
        color: #e4a6ff;
        }

        /* mouse over link */
        a:hover 
        {
        color: hotpink;
        }
        .message
        {
            font-style: italic;
            font-size: 30px;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>
      <div class="container">
        <div class="box form-box">
            

            
            
            <header>Good to see you again!</header>
            <br>
            <br>
            <form action="" method="post">
                <div class="fieldinput">
                    <label for="username">Username: </label>
                    <input type="text" name="username" id="username" autocomplete="off" required>
                </div>

                <div class="fieldinput">
                    <label for="password">Password: </label>
                    <input type="password" name="password" id="password" autocomplete="off" required> <br>
                    <input type="checkbox" id="showPasswordCheckbox">
                    <label for="showPasswordCheckbox">Show Password</label>
                </div>

                <p><h5><a href = "pw_otp.php">Forgot Password?</a></h5></p>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Login" required>
                </div>
                <br>
                <br>
                <div class="links">
                    Don't have an account? <a href="REGISTER.php">Register Now!</a>
                </div>
            </form>
        </div>
       
      </div>

      

</body>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.getElementById('password');
        const password2Input = document.getElementById('password2');
        const showPasswordCheckbox = document.getElementById('showPasswordCheckbox');

        showPasswordCheckbox.addEventListener('change', function() {
            const isChecked = showPasswordCheckbox.checked;
            if (isChecked) {
                passwordInput.type = 'text';
                password2Input.type = 'text';
            } else {
                passwordInput.type = 'password';
                password2Input.type = 'password';
            }
        });
    });
</script>
</html>
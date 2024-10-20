<?php
   include("config/constants.php");
?>

<html>
    <head>
        <title>Password Reset Form</title>
    </head>

    <script>
         document.addEventListener('DOMContentLoaded', function() {

            showpassword.addEventListener("change", function() {
                let isChecked = showpassword.checked;

                if (isChecked) {
                    newpassword.type = 'text';
                    conpassword.type = 'text';
                }

                else {
                    newpassword.type = 'password';
                    conpassword.type = 'password';
                }
            })

         })
    </script>

   
    <body>
        <h2>Reset Password</h2>

        <form name = "pw_reset" id = "pw_reset" method = "post">
           Email: <input type = "text" named = "email" id = "email" value="<?php echo ($_SESSION['useremail']); ?>" disabled>
            <br><br>

            New Password: <input type = "password" name = "newpassword" id = "newpassword" placeholder = "Enter password" value="<?php if(isset($_POST['newpassword'])) echo $_POST['newpassword']; ?>" required>
            <br><br>
            Confirm Password: <input type = "password" name = "conpassword" id = "conpassword" placeholder = "Confirm password" value="<?php if(isset($_POST['newpassword'])) echo $_POST['newpassword']; ?>" required>
            <br><br>
            <input type = "checkbox" id = "showpassword">
            <label for = "showpassword">Show Password</label>

            <br><br>
            <input type = "submit" name = "submit" id = "submit" value = "Save">

        </form>
    </body>


    <?php 
        

         $valid = false;
    
         $email = (isset($_SESSION['useremail'])) ? $_SESSION['useremail'] : '';

        if(isset($_POST['submit'])) {
            
            $npw = $_POST['newpassword'];
            $cpw = $_POST['conpassword'];
        
            
            $errors = array();

            if (strlen($npw) < 8 || strlen($npw) > 16) {
                $errors[] = "Password should be min 8 characters and max 16 characters";
            }
            if (!preg_match("/\d/", $npw)) {
                $errors[] = "Password should contain at least one digit";
            }
            if (!preg_match("/[A-Z]/", $npw)) {
                $errors[] = "Password should contain at least one Capital Letter";
            }
            if (!preg_match("/[a-z]/", $npw)) {
                $errors[] = "Password should contain at least one small Letter";
            }
            if (!preg_match("/\W/", $npw)) {
                $errors[] = "Password should contain at least one special character";
            }
            if (preg_match("/\s/", $npw)) {
                $errors[] = "Password should not contain any white space";
            }

        
            if ($errors) {
                echo "<ul class='errors'>";
                foreach ($errors as $error) {
                  echo "<li>$error</li>";
                }
                echo "</ul>";
            } else {
                $valid = true;

                if ($valid) {
                    if ($npw === $cpw){ 
                            $hash = password_hash($npw, PASSWORD_DEFAULT);
                            $sql = "UPDATE users SET password = '$hash' WHERE email = '$email'";
                           try{
                            mysqli_query($conn, $sql);
                            echo "<script> document.getElementById('submit').disabled = true; document.getElementById('newpassword').disabled = true; document.getElementById('conpassword').disabled = true;</script>";
                            echo "<p>Password has been reset, <a href = 'LOGIN.php'>Log-in </a>now</p>";
                            unset($_SESSION['useremail']);
                            mysqli_close($conn);
                           }
                           catch(mysqli_sql_exception){
                            die(mysql_error());
                           }
                    }

                    else {
                        echo "Password do not match, please try again!";
                    }
                }
            }
        
        }
    ?>

</html>
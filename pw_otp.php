<?php 
    include("config/constants.php");   
    
?>

<html>
    <head>
        <title>FORGOT PASSWORD </title>

    </head>

    <script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        otp_text.addEventListener('input', function() {
            let otp = document.getElementById("otp_text");

            if (otp.value.length === 5) {
                document.getElementById("verify_otp").disabled = false;
            }

            else {
                document.getElementById("verify_otp").disabled = true;
            }
        })

        email.addEventListener('input', function validate() {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            let email = document.getElementById("email").value;
            
                if (!emailRegex.test(email)) {
                    document.getElementById("get_otp").disabled = true;
                    return;
                }

                else {
                    document.getElementById("get_otp").disabled = false;

                }
        })

        
        

      
    })


    </script>

    <style>
        .input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
         -webkit-appearance: none;
        }   

    </style>



    <body>
        <form name = "otp" id = "otp" method = "post">
            <h2><p>SEND OTP<i class="fa fa-optin-monster" aria-hidden="true"></i></h2></p>
            <input type = "text" name = "email" id = "email" placeholder = "Enter your email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" required>
            <button name = "get_otp" id = "get_otp">Send code</button>

            <br><br>
            <h2><p>VERIFY OTP</h2></p>
            <input type = "number" name = "otp_text" id = "otp_text" placeholder = "Enter your OTP" min = "0" maxlength = "5" oninput = "validity.valid||(value=''); if (this.value.length > 5) this.value = this.value.slice(0, this.maxLength);">
            <input type = "submit" name = "verify_otp" id = "verify_otp" value = "Submit" disabled>
        </form>

    
        <?php
       
           $num = null;

            if(isset($_POST['get_otp'])) {
               
                $emailto = $_POST['email'];
                

                $query = "SELECT email FROM users WHERE email = '$emailto'";
                $query_run=mysqli_query($conn, $query);

                if(mysqli_num_rows($query_run)>0){
                    foreach($query_run as $emaildb){
                      
                        if ($emailto == $emaildb['email']) {
                            $num = rand(10000, 99999);
                            $emailto = $_POST['email'];
                            $subject = "OTP CODE - REQUEST";
                            $message = "You have requested a password reset, here is your OTP code - " . " $num" ;		
                            $emailfrom = "From:actuallyvulk@gmail.com";
                            $result = mail($emailto,$subject,$message,$emailfrom);

                            $_SESSION['otp'] = $num;
                            $_SESSION['useremail'] = $_POST['email'];
 
                        }
                    }
                }

                else {
                    echo "<script> alert('Email does not have an existing account'); </script>";
                }

            }

            if(isset($_POST['verify_otp'])) {

                $otp_text = intval($_POST['otp_text']);
                if (isset($_SESSION['otp']) && $otp_text == $_SESSION['otp']) {
                    header("Location: http://localhost/food-order/pw_reset.php");
                    unset($_SESSION['otp']);
                }

                else {
                    echo "Failed";
                }
            }
        
        ?>

</html>

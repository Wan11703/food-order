<?php 
    include("designed\designed\M7_ACT\db\database1.php");   
?>

<html>
    <head>
        <title>FORGOT PASSWORD </title>

    </head>

    <script>
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

        get_otp.addEventListener('click', function() {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            let email = document.getElementById("email").value;

                if (!emailRegex.test(email)) {
                    alert('Invalid email format.');
                    return;
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
            <input type = "text" name = "email" id = "email" placeholder = "Enter your email" >
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

                $query = "SELECT email FROM users";
                $query_run=mysqli_query($conn, $query);

                

                if(mysqli_num_rows($query_run)>0){
                    foreach($query_run as $emaildb){

                        if ($emailto == $emaildb) {
                            $num = rand(10000, 99999);
                            $emailto = $_POST['email'];
                            $subject = "OTP CODE - REQUEST";
                            $message = "You have requested a password reset, here is your OTP code - " . " $num" ;		
                            $emailfrom = "From:actuallyvulk@gmail.com";
                            $result = mail($emailto,$subject,$message,$emailfrom);
                            break;
                        }

                        else {
                            echo "<script> alert('Email does not have an existing account'); </script>";
                            break;
                        }

                    }
                }

            }

            echo "$num";
        
        ?>

</html>
<?php
include('partials/menu.php');
?>

<!doctype html>
<html lang="en">
  <head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Update User Information</title>
    
</head>
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
        input[name=firstname] 
        {
        background-color: #e8f0fe;
        border-radius: 15px;
        color: black;
        font-size: 20px; 
        width: 250px;
        font-weight: 300;
        }
        input[name=lastname] 
        {
        background-color: #e8f0fe;
        border-radius: 15px;
        color: black;
        font-size: 20px; 
        width: 250px;
        font-weight: 300;
        }
        input[name=username] 
        {
        background-color: #e8f0fe;
        border-radius: 15px;
        color: black;
        font-size: 20px; 
        width: 250px;
        font-weight: 300;
        }
        input[name=email] 
        {
        background-color: #e8f0fe;
        border-radius: 15px;
        color: black;
        font-size: 20px; 
        width: 250px;
        font-weight: 300;
        }
        input[name=birthdate] 
        {
        background-color: #e8f0fe;
        border-radius: 15px;
        color: black;
        font-size: 20px; 
        width: 250px;
        font-weight: 300;
        }
        input[name=password] 
        {
        background-color: #e8f0fe;
        border-radius: 15px;
        color: black;
        font-size: 20px; 
        width: 250px;
        font-weight: 300;
        }
        input[name=password2] 
        {
        background-color: #e8f0fe;
        border-radius: 15px;
        color: black;
        font-size: 20px; 
        width: 250px;
        font-weight: 300;
        }
        .col-md-12
        {
            margin-left: auto;
            margin-right: auto;
            padding-top: 30px;
            padding-right: 10px;
            padding-bottom: 30px;
            padding-left: 10px;
            width: 512px;
            font-size: 20px;
            font-weight: 300;
            backdrop-filter: blur(5px);
            text-align: center;
            
            
        }
        .fieldinput
        {
            font-size: 15px;
            padding-top: 5px;
            padding-bottom: 5px;
        }
        .hidden {
            display: none;
        }

</style>
<body>
  
    <div class="container mt-5" >
        <div class="row" >
            <div class="col-md-12" >
                <div class="card" style="background-color:rgb(61, 38, 20, 0.75); backdrop-filter: blur(5px); color:white; border-style: solid;border-width: 1px; border-color: #e8f0fe;border-radius: 15px;">
                    <div class="card-header">
                        <h4>Update User Information 
                            <a href="log.php" class="btn btn-danger float-end">BACK</a>
                        </h4>
                    </div>
                    <div class="card-body" >

                        <?php
                        if(isset($_GET['id']))
                        {
                            $users_id = mysqli_real_escape_string($conn, $_GET['id']);
                            $query = "SELECT * FROM users WHERE id='$users_id'";
                            $query_run = mysqli_query($conn, $query);
            
                            if(mysqli_num_rows($query_run)>0){
                                $user = mysqli_fetch_array($query_run);
                                ?>

                                <form action="EDIT_DELETE.php" method="POST" id="registerForm" name="registerForm">
                                    <input type="hidden" name="users_id" value="<?= $users_id;; ?>">

                                    <div style="text-align: center;"> Personal Information </div>
                <div class="fieldinput"> 
                    <input type="text" name="firstname" id="firstname" value="<?= $user['firstname']?>" required>
                </div>
                <div class="fieldinput">
                    <input type="text" name="lastname" id="lastname" value="<?= $user['lastname']?>"  required>
                </div>
                <div class="fieldinput">
                    <input type="text" name="middlename" id="middlename" value="<?= $user['middlename']?>" >
                </div>

                <div class="fieldinput" >
                    <label for="gender">Gender: </label>
                    <input type="radio" name="gender" id="male" value="male" <?= ($user['gender'] == 'male') ? 'checked' : '' ?> required>
                    <label for="male">Male</label>
                    <input type="radio" name="gender" id="female" value="female" <?= ($user['gender'] == 'female') ? 'checked' : '' ?> required>
                    <label for="female">Female</label>
                    <input type="radio" name="gender" id="other" value="other" <?= ($user['gender'] == 'other') ? 'checked' : '' ?> required>
                    <label for="other">Other</label>
                </div>

                <div class="fieldinput" value="male" <?= ($user['gender'] == 'male') ? 'checked' : '' ?>>
                    <label for="birthdate">Birthdate: </label>
                    <br> 
                    <input type="date" name="birthdate" id="birthdate" min="1980-01-01" max="2024-12-31" value="<?= $user['birthdate'] ?>" required>
                </div>
                <div class="fieldinput">
                    <input type="text" name="age" id="age" value="<?= $user['age']?>"readonly>
                </div>
                <br>
                <div style="text-align: center;"> User Account Information </div>

                <div class="fieldinput">
                    <input type="text" name="username" id="username"  value="<?= $user['username']?>" required>
                </div>




                <div class="fieldinput">
                   
                    <input type="text" name="email" id="email" value="<?= $user['email']?>" required>
                </div>
                <div class="fieldinput">
                    <input type="text" name="contact" id="contact" value="<?= $user['contact']?>" required>
                </div>

                
                <div style="font-size: 15px; margin-top:20px;">
                    Fields marked with a "*" are required.
                </div>
                                <br>
                                    <div class="mb-3">
                                        <button type="submit" name="update" class="btn btn-primary" id="update">
                                            Update User Information
                                        </button>
                                    </div>

                                </form>


                                <?php
                            }
                            else
                            {
                                echo "<h4>No Such Id Found</h4>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('registerForm');
            let formSubmitted = false;


            const birthdateField = document.getElementById('birthdate');
            const ageField = document.getElementById('age');

            birthdateField.addEventListener('change', function() {
                const birthdateValue = birthdateField.value;
                if (birthdateValue) {
                    const dateUser = new Date(birthdateValue);
                    const dateToday = new Date();
                    const diff = (dateToday.getTime() - dateUser.getTime()) / (1000 * 60 * 60 * 24);
                    const age = Math.trunc(diff / 365);

                    ageField.value = age; 

                    if (age < 18) {
                        birthdateField.style.borderColor = 'red';
                        alert("You must be 18 years old and above to register!");
                        birthdateField.value = '';
                        ageField.value = ''; 
                    } else {
                        birthdateField.style.borderColor = 'green';
                    }
                } else {
                    ageField.value = ''; 
                }
            });


            form.addEventListener('submit', function(event) {
                
                if (!formSubmitted) {
                    event.preventDefault(); 
                    
                    
                    
                    const email = document.getElementById('email').value;
                    const firstname = document.getElementById('firstname').value;
                    const lastname = document.getElementById('lastname').value;
                    const username = document.getElementById('username').value;
                    const middlename = document.getElementById('middlename').value;
                    const contact = document.getElementById('contact').value;
                   

                    
                    
                    
                    const nameRegex = /^[a-zA-Z\s]*$/;
                    if (!nameRegex.test(firstname) || !nameRegex.test(lastname) || !nameRegex.test(username) || !nameRegex.test(middlename)) {
                        alert('Name fields should only contain letters and spaces.');
                        return;
                    }

                    

                    
                    

                    

                    
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(email)) {
                        alert('Invalid email format.');
                        return;
                    }

                    const contactRegex = /^09\d{9}$/;
                    if (!contactRegex.test(contact)) {
                        alert('Contact number must be 11 digits and start with "09".');
                        return;
                    }

                    

                    
                    
                                formSubmitted = true;
                                const notification = document.getElementById('notification');
                               
                                notification.style.display = 'block';

                                form.reset();
                                form.submit();
                           
                    
                }
            });

            
        });

        
    </script>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
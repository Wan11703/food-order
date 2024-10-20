<?php 
include("../config/constants.php");
//session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('registerForm');
            const confirmButton = document.getElementById('confirmButton');
            const modal = new bootstrap.Modal(document.getElementById('confirmationModal'));
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

                    const errors = [];
                    const password = document.getElementById('password').value;
                    const confirmPassword = document.getElementById('password2').value;
                    const email = document.getElementById('email').value;
                    const firstname = document.getElementById('firstname').value;
                    const lastname = document.getElementById('lastname').value;
                    const username = document.getElementById('username').value;
                    const middlename = document.getElementById('middlename').value;
                    const contact = document.getElementById('contact').value;

                    const nameRegex = /^[a-zA-Z\s]*$/;
                    if (!nameRegex.test(firstname)) {
                        errors.push('First name should only contain letters and spaces.');
                    }
                    if (!nameRegex.test(lastname)) {
                        errors.push('Last name should only contain letters and spaces.');
                    }
                    if (!nameRegex.test(middlename)) {
                        errors.push('Middle name should only contain letters and spaces.');
                    }
                    
                    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
                    if (!passwordRegex.test(password)) {
                        errors.push('Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character.');
                    }

                    if (password !== confirmPassword) {
                        errors.push('Passwords do not match.');
                    }

                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(email)) {
                        errors.push('Invalid email format.');
                    }

                    const contactRegex = /^09\d{9}$/;
                    if (!contactRegex.test(contact)) {
                        errors.push('Contact number must be 11 digits and start with "09".');
                    }

                    if (errors.length > 0) {
                        alert(errors.join('\n'));
                        return;
                    }

                    fetch('validate_username.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ username: username }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.exists) {
                            alert('Username already exists.');
                        } else {
                            document.getElementById('confirmFirstname').innerText = firstname;
                            document.getElementById('confirmLastname').innerText = lastname;
                            document.getElementById('confirmMiddlename').innerText = middlename;
                            document.getElementById('confirmUsername').innerText = username;
                            document.getElementById('confirmEmail').innerText = email;
                            document.getElementById('confirmContact').innerText = contact;
                            document.getElementById('confirmBirthdate').innerText = birthdateField.value;
                            document.getElementById('confirmAge').innerText = ageField.value;
                            document.getElementById('confirmGender').innerText = document.querySelector('input[name="gender"]:checked').value;

                            modal.show();
                        }
                    });
                }
            });

            confirmButton.addEventListener('click', function() {
                formSubmitted = true;
                form.submit();
            });

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

            <?php if(isset($_SESSION['notification'])): ?>
                alert("<?php echo $_SESSION['notification']; ?>");
                <?php unset($_SESSION['notification']); ?>
            <?php endif; ?>
        });
    </script>

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
        .notification {
            display: none; /* Initially hidden */
            padding: 10px;
            background-color: #4CAF50; /* Green background */
            color: white;
            margin-bottom: 15px;
        }
        .notification {
            display: none; /* Initially hidden */
            padding: 10px;
            background-color: #4CAF50; /* Green background */
            color: white;
            margin-bottom: 15px;
        }
        header
        {
            font-style: italic;
            font-size: 40px;
            font-weight: bold;
            text-align: center;
        }
        .container
        {
            
            background-color: rgb(61, 38, 20, 0.75);
            border-style: solid;
            border-width: 1px;
            border-color: #e8f0fe;
            color: white;
            border-radius: 15px;
            margin-left: auto;
            margin-right: auto;
            margin-top: 80px;
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
            font-size: 20px;
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
        input[name=middlename] 
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

        input[type=Submit] 
        {
        height: 50px;
        font-size: 20px; 
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
        .fieldinput
        {
            padding-top: 5px;
            padding-bottom: 5px;
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
        }
    </style>
</head>
<body>
<?php 
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $firstname = filter_input(INPUT_POST, "firstname", FILTER_SANITIZE_SPECIAL_CHARS);
    $lastname = filter_input(INPUT_POST, "lastname", FILTER_SANITIZE_SPECIAL_CHARS);
    $middlename = filter_input(INPUT_POST, "middlename", FILTER_SANITIZE_SPECIAL_CHARS);
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
    $birthdate = filter_input(INPUT_POST, "birthdate", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
    $gender = filter_input(INPUT_POST, "gender", FILTER_SANITIZE_SPECIAL_CHARS);
    $age = filter_input(INPUT_POST, "age", FILTER_SANITIZE_SPECIAL_CHARS);
    $contact = filter_input(INPUT_POST, "contact", FILTER_SANITIZE_SPECIAL_CHARS);

    if(empty($username)){
        $_SESSION['notification'] = "Username is required.";
        header("Location: register.php");
        exit();

    } else {
        // Check if username already exists
        $checkUsernameQuery = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($conn, $checkUsernameQuery);
        
        if(mysqli_num_rows($result) > 0) {
            $_SESSION['notification'] = "Username already exists.";
            header("Location: register.php");
            exit();
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (firstname, lastname, middlename, username, gender, email, contact, birthdate, age, password)
                    VALUES ('$firstname', '$lastname', '$middlename', '$username', '$gender', '$email', '$contact', '$birthdate', '$age', '$hash')";
           try {
            if (mysqli_query($conn, $sql)) {
                $_SESSION['notification'] = "Record Successful";
                echo "<script>
                        $(document).ready(function(){
                            $('successModal').modal('show');
                        });
                      </script>";
            } else {
                throw new Exception(mysqli_error($conn));
            }
        } catch (Exception $e) {
            $_SESSION['notification'] = "Registration failed. Please try again.";
            echo "<script>
                        $(document).ready(function(){
                            $('errorModal').modal('show');
                        });
                      </script>";
           
        
    }
        }
    }
}

//mysqli_close($conn);
?>

<div id="notification" class="notification"></div>


<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Success!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Registration successful!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="window.location.href='login.php'">Login</button>
            </div>
        </div>
    </div>
</div>

<!-- Error Modal -->
<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">Error!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Registration failed. Please try again.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>








<div class="container">
    <header>Sign Up</header>
    <br>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="registerForm" id="registerForm">
        <div style="text-align: center;"> Personal Information </div>
        <div class="fieldinput"> 
            <input type="text" name="firstname" id="firstname" placeholder="First Name*" required>
        </div>
        <div class="fieldinput">
            <input type="text" name="lastname" id="lastname" placeholder="Last Name*" required>
        </div>
        <div class="fieldinput">
            <input type="text" name="middlename" id="middlename" placeholder="Middle Name">
        </div>
        <div class="fieldinput">
            <label for="gender">Gender: </label>
            <input type="radio" name="gender" id="gender" value="Male" required> Male
            <input type="radio" name="gender" id="gender" value="Female" required> Female
        </div>
        <div class="fieldinput">
            <input type="date" name="birthdate" id="birthdate" placeholder="Birthdate*" required>
        </div>
        <div class="fieldinput">
            <label for="age">Age: </label>
            <br> 
            <input type="text" name="age" id="age" placeholder="Age" readonly>
        </div>
        <br>
        <div style="text-align: center;"> User Information </div>
        <div class="fieldinput">
            <input type="text" name="username" id="username" placeholder="Username*" required>
        </div>
        <div class="fieldinput">
            <input type="email" name="email" id="email" placeholder="Email*" required>
        </div>
        <div class="fieldinput">
            <input type="password" name="password" id="password" placeholder="Password*" required>
        </div>
        <div class="fieldinput">
            <input type="password" name="password2" id="password2" placeholder="Confirm Password*" required>
        </div>
        <div class="fieldinput">
            <label for="showPasswordCheckbox">Show Password: </label>
            <input type="checkbox" id="showPasswordCheckbox">
        </div>
        <div class="fieldinput">
            <input type="text" name="contact" id="contact" placeholder="Contact Number*" required>
        </div>
        <div class="fieldinput">
            <button type="submit" id="submitBtn">Submit</button>
        </div>
    </form>
</div>

<!-- Bootstrap Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirm Your Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>First Name:</strong> <span id="confirmFirstname"></span></p>
                <p><strong>Last Name:</strong> <span id="confirmLastname"></span></p>
                <p><strong>Middle Name:</strong> <span id="confirmMiddlename"></span></p>
                <p><strong>Username:</strong> <span id="confirmUsername"></span></p>
                <p><strong>Email:</strong> <span id="confirmEmail"></span></p>
                <p><strong>Contact:</strong> <span id="confirmContact"></span></p>
                <p><strong>Birthdate:</strong> <span id="confirmBirthdate"></span></p>
                <p><strong>Age:</strong> <span id="confirmAge"></span></p>
                <p><strong>Gender:</strong> <span id="confirmGender"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Edit</button>
                <button type="button" class="btn btn-primary" id="confirmButton">Confirm</button>
            </div>
        </div>
    </div>
</div>

<!-- Include Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- JavaScript to trigger modals -->


</body>
</html>
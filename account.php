<?php

include('partials-front/menu.php');

if (!isset($_SESSION['user_id'])) {
    header('location:' . SITEURL . 'login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM users WHERE id=$user_id";
$res = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($res);

$username = $row['username'];
$firstname = $row['firstname'];
$middlename = $row['middlename'];
$lastname = $row['lastname'];
$contact = $row['contact'];
$birthdate = $row['birthdate'];
$email = $row['email'];
?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const birthdateField = document.getElementById('birthdate');
        const ageField = document.getElementById('age');

        function calculateAge(birthdate) {
            const dateUser = new Date(birthdate);
            const dateToday = new Date();
            const diff = (dateToday.getTime() - dateUser.getTime()) / (1000 * 60 * 60 * 24);
            return Math.trunc(diff / 365);
        }

        function updateAge() {
            const birthdateValue = birthdateField.value;
            if (birthdateValue) {
                const age = calculateAge(birthdateValue);
                ageField.value = age;
            } else {
                ageField.value = '';
            }
        }

        birthdateField.addEventListener('change', updateAge);

        // Initial age calculation
        updateAge();
    });
</script>

<html>
<head>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-image: url("https://images.unsplash.com/photo-1554118811-1e0d58224f24?q=80&w=2647&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D");
            min-height: 500px;
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .container {
            background-color: rgba(61, 38, 20, 0.75);
            border: 1px solid #e8f0fe;
            color: white;
            border-radius: 15px;
            margin-left: auto;
            margin-right: auto;
            padding: 20px;
            font-size: 20px;
            font-weight: 300;
            backdrop-filter: blur(2px);
        }

        .container2 {
            background-color: rgba(61, 38, 20, 0.75);
            border: 1px solid #e8f0fe;
            color: white;
            border-radius: 15px;
            margin-left: auto;
            margin-right: auto;
            margin-top: 20px;
            padding: 5px 20px;
            font-size: 20px;
            font-weight: 300;
            backdrop-filter: blur(5px);
        }

        a:link,
        a:visited,
        a:hover {
            color: white;
        }

        .message {
            font-style: italic;
            font-size: 30px;
            font-weight: bold;
        }

        textarea {
            top: -100px;
        }
    </style>
</head>
<body>
    <div class="container col-12">
        <form name="account" id="account" method="post">
            <div class="card col-9-center">
                <h5 class="card-header">Account Details</h5>
                <div class="card-body col-12">
                    <div class="row">
                        <div class="col-6">
                            Username: <input type="text" name="uname" id="uname" class="editable" value="<?php echo $username ?>" disabled><br><br>
                            First name: <input type="text" name="fname" id="fname" class="editable" value="<?php echo $firstname ?>" disabled><br><br>
                            Middle name: <input type="text" name="mname" id="mname" class="editable" value="<?php echo $middlename ?>" disabled><br><br>
                            Last name: <input type="text" name="lname" id="lname" class="editable" value="<?php echo $lastname ?>" disabled><br><br>
                        </div>

                        <div class="col-6">
                            <label for="birthdate">Birthdate: </label><br>
                            <input type="date" name="birthdate" id="birthdate" class="editable" min="1980-01-01" max="2024-12-31" value="<?= $birthdate ?>" disabled required>
                            Age: <input type="text" name="age" id="age" value="" readonly>
                        </div>

                        <div class="col-6">
                            Email: <input type="text" name="email" id="email" class="editable" value="<?= $email ?>" required disabled><br><br>
                            Contact No: <input type="number" name="contact" id="contact" class="editable" value="<?php echo $contact ?>" disabled><br><br>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Include Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

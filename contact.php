<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fornix Corporation</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');

        *{
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* navbar */

        .navbar a{
            font-size: 14px;
            font-weight: 500;
        }

        .navbar-toggler{
            padding: 1px 5px;
            font-size: 18px;
            line-height: 0.3;
        }

        /* footer */

        .bg-footer{
            background-color: #000;
            padding: 50px 0 30px;
        }

        .bg-footer a{
            text-decoration: none;
            color: #aeaeae;
        }

        input[type="radio"] {
            display: inline;
            margin-right: 5px;
        }
    </style>

</head>
<body class="" style="background-color: rgb(255, 231, 152);">

    <!-- navbar -->

    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
        <a class="navbar-brand" href="#">
          <img src="Images/Home/logo.jpg" alt="" width="128" height="64">
        </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mr-lg-0">
                

            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="site.html">Home</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="site.html#about">About Us</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="site.html#products">Products</a>
            </li>


            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="site.html#gallery">Gallery</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="contact.php">Contact</a>
            </li>

            <li class="nav-item">
              <a class="nav-link btn text-white bg-success px-3 rounded-0" href="../food-order/ind.php">Order Here!</a>
            </li>
            </ul>
          </div>
        </div>
      </nav>

    <!-- contact -->
    
    <section>
        <div class="container mb-5">
            <div class="col-lg-8 col-md-12 col-sm-12" style="margin-top: 120px;">
                <h1 class="text-single">Contact Us</h1>
            </div>
        </div>
        <div class="contact mt-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 col-sm-12">
                    <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            $first_name = htmlspecialchars(trim($_POST['first-name']));
                            $last_name = htmlspecialchars(trim($_POST['last-name']));
                            $email = htmlspecialchars(trim($_POST['email']));
                            $subject = htmlspecialchars(trim($_POST['subject']));
                            $message = htmlspecialchars(trim($_POST['message']));
                            $rating = htmlspecialchars(trim($_POST['rating']));

                            $errors = [];

                            // Validate fields
                            if (empty($first_name)) {
                                $errors[] = "First name is required.";
                            }
                            if (empty($last_name)) {
                                $errors[] = "Last name is required.";
                            }
                            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                $errors[] = "A valid email address is required.";
                            }
                            if (empty($subject)) {
                                $errors[] = "Subject is required.";
                            }
                            if (empty($message)) {
                                $errors[] = "Comments are required.";
                            }
                            if (!isset($rating)) {
                                $errors[] = "Rating is required.";
                            }

                            if (empty($errors)) {
                                $to = 'actuallyvulk@gmail.com'; // Change this to your email address
                                $mail_subject = 'Contact Form Submission: ' . $subject;
                                $message = "First Name: $first_name\nLast Name: $last_name\nEmail: $email\nSubject: $subject\nRating: $rating stars\nComments: $message";
                                $headers = 'From: actuallyvulk@gmail.com' . "\r\n" .
                                        'Reply-To: actuallyvulk@gmail.com' . "\r\n" .
                                        'X-Mailer: PHP/' . phpversion();

                                if (mail($to, $mail_subject, $message, $headers)) {
                                    echo '<p>Thank you for your comments, ' . $first_name . '.</p>';
                                } else {
                                    echo '<p>Sorry, there was an error sending your message. Please try again later.</p>';
                                }
                            } else {
                                foreach ($errors as $error) {
                                    echo '<p style="color:red;">' . $error . '</p>';
                                }
                            }
                        }
                        ?>
                        <form method="post" action="">
                            <div class="row g-3">
                                <div class="col-md-6 col-sm-12">
                                    <label for="first-name" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="first-name" name="first-name" required>
                                </div>

                                <div class="col-md-6 col-sm-12">
                                    <label for="last-name" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="last-name" name="last-name" required>
                                </div>

                                <div class="col-md-6 col-sm-12">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>

                                <div class="col-md-6 col-sm-12">
                                    <label for="subject" class="form-label">Subject</label>
                                    <input type="text" class="form-control" id="subject" name="subject" required>
                                </div>

                                <div class="col-md-12 col-sm-12">
                                    <label for="message" class="form-label">Comments, Suggestions, and Feedback:</label>
                                    <textarea class="form-control" name="message" id="message" rows="5" required></textarea>
                                </div>

                                <div class="col-md-12 col-sm-12">
                                    <label for="rating">Rating:</label><br>
                                    <input type="radio" id="no_star" name="rating" value="0/5" required>No star &nbsp;&nbsp;
                                    <input type="radio" id="1_star" name="rating" value="1/5">1 star &nbsp;&nbsp;
                                    <input type="radio" id="2_star" name="rating" value="2/5">2 stars &nbsp;&nbsp;
                                    <input type="radio" id="3_star" name="rating" value="3/5">3 stars &nbsp;&nbsp;
                                    <input type="radio" id="4_star" name="rating" value="4/5">4 stars &nbsp;&nbsp;
                                    <input type="radio" id="5_star" name="rating" value="5/5">5 stars &nbsp;&nbsp;
                                </div>

                                <div class="mt-3 mb-5">
                                    <button class="btn text-white bg-success px-3 btn-lg rounded-0" type="submit">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div id="map" class="contact-map col-lg-5 col-sm-12 mb-4">
                        <iframe class="w-100" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d682.3635202969186!2d120.98818247670351!3d14.654182940329926!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397b681a68f8067%3A0x12d4895a88adf939!2s12th%20Ave%2C%20Caloocan%2C%20Metro%20Manila!5e0!3m2!1sen!2sph!4v1720114850769!5m2!1sen!2sph" width="auto" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- footer -->

    <footer class="bg-dark bg-footer" style="margin-top: 80px; background-color: #ffa500;">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                </div>
  
                <div class="col-lg-3">
                </div>
  
                <div class="col-lg-3">
                    <h5 class="text-light mb-3">Stay Connected</h5>
                    <ul class="list-unstyled">
                      <p class="text-light"><i class="fa-solid fa-location-dot"></i> 12th Ave Corner, San Diego Street, Caloocan City, Philippines</p>
                      <p class="text-light"><i class="fa-brands fa-facebook"></i> <a href="https://www.facebook.com/profile.php?id=61558700903788" style="color:white;">12th Avenue Cafe</a></p>
                      <p class="text-light"><i class="fa fa-phone"></i> 09173003912</p>
                      <p class="text-light"><i class="fa fa-envelope"></i> 12avenuecafe@gmail.com</p>
                    </ul>
                </div>
            </div>
  
            <hr>
  
            <div class="row">
                <div class="col-lg-12">
                    <p class="text-center text-light">
                        Copyright &copy; 2024 | For Educational Purposes Only.
                    </p>
                </div>
            </div>
        </div>
    </footer>

      

    <!-- bootstrap -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
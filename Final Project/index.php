
<?php
session_start();

// Database credentials
$host = "localhost";
$user = "root";
$password = "";
$database = "EliteHMS";

// Create a database connection
$conn = mysqli_connect($host, $user, $password, $database);

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle login form submission
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query the database for the user with the given username and password
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    // Check if the query was successful and if the user exists
    if (mysqli_num_rows($result) > 0) {
        // User exists, set session variables and redirect to welcome page
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
        exit();
    } else {
        // User doesn't exist, display error message
        $error = "Invalid username or password.";
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Elite Housing Management</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <style>
body {
  font-family: Arial, Helvetica, sans-serif;
}

* {
  box-sizing: border-box;
}

/* style the container */
.container1 {
  position: relative;
  border-radius: 10px;
  background-color: #000000;
  padding: 30px 0 30px 0;
  text-align: center
} 

/* style inputs */
input {
  width: 100%;
  padding: 10px;
  border: 2px solid #ffc451;
  border-radius: 30px;
  margin: 5px 0;
  opacity: 0.9;
  display: inline-block;
  font-size: 20px;
  line-height: 20px;
  text-decoration: none; /* remove underline from anchors */
  text-align: center; /* align the text in the center */
}


/* style inputs and link buttons */
input,
.btn {
  width: 50%;
  padding: 12px;
  border: 2px solid #ffc451;
  border-radius: 30px;
  margin: 5px 0;
  opacity: 0.9;
  display: inline-block;
  font-size: 20px;
  line-height: 20px;
  text-decoration: none; /* remove underline from anchors */
  /* background-color: #000000; */
}

.btn {
  border-radius: 5px; /* or any other value to adjust the curvature */
  /* other button styles... */
}


/* style the submit button */
/*--------------------------------------------------------------
#  Get Startet Button
--------------------------------------------------------------*/
input[type=submit] {
  color: #fff;
  border-radius: 4px;
  padding: 5px 5px;
  white-space: nowrap;
  transition: 0.3s;
  font-size: 14px;
  display: inline-block;
  border: 2px solid #ffc451;
  align: center;
  background-color: #ffc451;
}


input[type=submit]:hover  {
  background: #ffbb38;
  color: #343a40;
}

@media (max-width: 992px) {
input[type=submit] {
    padding: 7px 10px 8px 20px;
    margin-right: 15px;
  }
}

input:hover,
.btn:hover {
  opacity: 1;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}


/* hide some text on medium and large screens */
.hide-md-lg {
  display: none;
}

/* bottom container */
.bottom-container1 {
  text-align: center;
  background-color: #666;
  border-radius: 0px 0px 4px 4px;
}

/* Responsive layout - when the screen is less than 650px wide, make the two columns stack on top of each other instead of next to each other */
@media screen and (max-width: 650px) {
  .col {
    width: 100%;
    margin-top: 0;
  }

  /* show the hidden text on small screens */
  .hide-md-lg {
    display: block;
    text-align: center;
  }
}

</style>

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top ">
    <div class="container d-flex align-items-center justify-content-lg-between">

      <h1 class="logo me-auto me-lg-0"><a href="index.html">Elite<span>.</span></a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo me-auto me-lg-0"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->


      <a href="user.php" class="get-started-btn scrollto">Elite Home</a>


    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center justify-content-center">
  <style> 
  #hero{
    background: url(bg.jpg);
    background-size:cover;
  }
  </style>
      <div class="row justify-content-center" data-aos="fade-right" data-aos-delay="150">
        <div class="col-xl-6 col-lg-8">
          <h1>Elite Property Management<span>.</span></h1>
          <h2>Where Luxury and Convenience Converge</h2>
        </div>
      </div>

      <div class="container1" data-aos="fade-left">
            <?php if (isset($error)): ?>
                <p><?php echo $error; ?></p>
            <?php endif; ?>
            <form method="POST" action="index.php">
            <form method="POST" action="index.php">
                <input type="text" id="username" name="username" placeholder="Username" value="" required> <br>
                <input type="password" id="password" name="password" placeholder="Password" value="" required>
                <input class="get-started-btn scrollto" type="submit" name="submit" value="Log In">
            </form>
            </form>
        </div>

  </section><!-- End Hero -->

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Elite Property Management</title>
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

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top ">
    <div class="container d-flex align-items-center justify-content-lg-between">

      <h1 class="logo me-auto me-lg-0"><a href="user.php">Elite<span>.</span></a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo me-auto me-lg-0"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
          <li><a class="nav-link scrollto" href="#about">About</a></li>
          <li><a class="nav-link scrollto " href="#floorplan">Floor plans</a></li>
          <li><a class="nav-link scrollto" href="#team">Team</a></li>
          <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

      <a href="http://localhost/finalproject/index.php" class="get-started-btn scrollto">Admin Login</a>


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
    <div class="container" data-aos="fade-up">

      <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="150">
        <div class="col-xl-6 col-lg-8">
          <h1>Elite Housing Management<span>.</span></h1>
          <h2>Where Luxury and Convenience Converge</h2>
        </div>
      </div>

      <div class="row gy-4 mt-5 justify-content-center" data-aos="zoom-in" data-aos-delay="250">
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
      
             // Retrieve the data from the property table
      $sql = "SELECT * FROM property";
      $result = mysqli_query($conn, $sql);

      // Display the data as clickable property names
      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          echo '<div class="col-xl-2 col-md-4">';
          echo '<div class="icon-box">';
          echo '<i class="ri-home-heart-fill"></i>';
          echo '<h3><a href="info.php?property_name=' . urlencode($row['PropertyName']) . '">' . htmlspecialchars($row['PropertyName']) . '</a></h3>';
          echo '</div>';
          echo '</div>';
        }
      } else {
        echo "0 results";
      }
          // Close the database connection
          mysqli_close($conn);
        ?>
      </div>
      

    </div>
  </section><!-- End Hero -->

  <main id="main">

<!-- ======= About Section ======= -->
<section id="about" class="about">
  <div class="container" data-aos="fade-up">

    <div class="row">
      <div class="col-lg-6 order-1 order-lg-2" data-aos="fade-left" data-aos-delay="100">
        <img src="assets/img/about.jpg" class="img-fluid" alt="">
      </div>
      <div class="col-lg-6 pt-4 pt-lg-0 order-2 order-lg-1 content" data-aos="fade-right" data-aos-delay="100">
        <h3>Designed with you in mind, our houses will make you feel right at home.</h3>
        <p class="fst-italic">
          With 10 distinctive floor plans, Elite Apartments and Houses will have just the right one that will appeal to your unique sense of style and spirit. 
        </p>
        <ul>
          <li><i class="ri-check-double-line"></i>Located in beautiful Bloomington, Indiana, we are within walking distance to Indiana University and the land of the Indiana Hoosiers!</li>
          <li><i class="ri-check-double-line"></i>One of Bloomington's premier housing with a neighborhood feeling. Located in an enclave of nature, but still near downtown, Eastside shopping. </li>
          <li><i class="ri-check-double-line"></i>We know that a rental house or apartment is not just a place to live, it is a place to call home. To that end, we believe in quality communication, updated properties, and integrity in every interaction.</li>
        </ul>
        <p>
          Each community offers a variety of attractive amenities with a little something for everyone, including your furry friend! So if you’re looking for somewhere that you can not only live, but thrive, you’ve come to the right place. Your new home awaits.
        </p>
      </div>
    </div>

  </div>
</section>
<!-- End About Section -->

 <!-- ======= Features Section ======= -->
 <section id="features" class="features">
      <div class="container" data-aos="fade-up">

        <div class="row">
          <div class="image col-lg-6" style='background-image: url("assets/img/pic2.jpeg");' data-aos="fade-right"></div>
          <div class="col-lg-6" data-aos="fade-left" data-aos-delay="100">
            <div class="icon-box mt-5 mt-lg-0" data-aos="zoom-in" data-aos-delay="150">
              <i class="bx bx-home"></i>
              <h4>Luxury, prestige, refinement & location</h4>
              <p>Live in ultimate luxury with our prestigious and refined residences, perfectly situated in the most sought-after locations. We have curated with everything you’ve ever dreamt of at your fingertips, you may not want to leave.</p>
            </div>
            <div class="icon-box mt-5" data-aos="zoom-in" data-aos-delay="150">
              <i class="bx bx-home"></i>
              <h4>Quiet, convenient & affordable</h4>
              <p>We offer homes packed with amenities that make life stress-free. From our business center to our recreation spaces, The Monroe is the perfect place to enjoy life in Indiana.</p>
            </div>
            <div class="icon-box mt-5" data-aos="zoom-in" data-aos-delay="150">
              <i class="bx bx-home"></i>
              <h4>Intimate, elegant, historic & downtown</h4>
              <p>Experience the perfect blend of history and sophistication with our downtown housing options. Discover intimate, elegant homes that offer a unique glimpse into the past
              </p>
            </div>
            <div class="icon-box mt-5" data-aos="zoom-in" data-aos-delay="150">
              <i class="bx bx-home"></i>
              <h4>Attractive, refinished & peaceful</h4>
              <p>Indulge in the beauty of our attractive and refinished residences, offering a peaceful sanctuary for your relaxation and comfort. We offer homes located in pleasant neighborhoods and close to Bloomington schools, shopping and more.</p>
            </div>
          </div>
        </div>

      </div>
    </section>
    <!-- End Features Section -->


    <!-- ======= Cta Section ======= -->
        <section id="cta" class="cta">
      <div class="container" data-aos="zoom-in">

        <div class="text-center">
          <h3>Call To Action</h3>
          <p> At Elite Properties, we make it our goal to provide only the best services for our residents. We want to make ourselves available and offer modern solutions to make your experience with us the best it can be. We do what we can to help with this goal - we provide our Online Portal so you can easily pay rent online, submit maintenance requests, and more. Sign up today to get started!</p>
          <a class="cta-btn" href="#contact">Call To Action</a>
        </div>

      </div>
    </section>
    <!-- End Cta Section -->


 <!-- ======= Portfolio Section ======= -->
 <section id="floorplan" class="portfolio">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Floorplans</h2>
          <p>Check our House Types</p>
        </div>

        <div class="row" data-aos="fade-up" data-aos-delay="100">
          <div class="col-lg-12 d-flex justify-content-center">
            <ul id="portfolio-flters">
              <li data-filter="*" class="filter-active">All</li>
              <li data-filter=".filter-1bed">1 Bed</li>
              <li data-filter=".filter-2bed">2 Bed</li>
              <li data-filter=".filter-3bed">3 Bed</li>
              <li data-filter=".filter-4bed">4 Bed</li>
            </ul>
          </div>
        </div>

        <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">

          <div class="col-lg-4 col-md-6 portfolio-item filter-1bed">
            <div class="portfolio-wrap">
              <img src="assets/img/portfolio/Cozy Loft.png" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>Cozy Loft</h4>    
                <p>Floor Plan</p>
                <div class="portfolio-links">
                  <a href="assets/img/portfolio/Cozy Loft.png" data-gallery="portfolioGallery" class="portfolio-lightbox" title="1 Bed"><i class="bx bx-plus"></i></a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-1bed">
            <div class="portfolio-wrap">
              <img src="assets/img/portfolio/Willow.png" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>Willow</h4>
                <p>Floor Plan</p>
                <div class="portfolio-links">
                  <a href="assets/img/portfolio/Willow.png" data-gallery="portfolioGallery" class="portfolio-lightbox" title="1 Bed"><i class="bx bx-plus"></i></a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-2bed">
            <div class="portfolio-wrap">
              <img src="assets/img/portfolio/Maple Leaf.png" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>Maple Leaf</h4>
                <p>Floor Plan</p>
                <div class="portfolio-links">
                  <a href="assets/img/Maple Leaf.png" data-gallery="portfolioGallery" class="portfolio-lightbox" title="2 Bed"><i class="bx bx-plus"></i></a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-2bed">
            <div class="portfolio-wrap">
              <img src="assets/img/portfolio/Primrose.png" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>Primrose</h4>
                <p>Floor Plan</p>
                <div class="portfolio-links">
                  <a href="assets/img/portfolio/Primerose.png" data-gallery="portfolioGallery" class="portfolio-lightbox" title="2 Bed"><i class="bx bx-plus"></i></a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-2bed">
            <div class="portfolio-wrap">
              <img src="assets/img/portfolio/Cedar Creek.png" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>Cedar Creek</h4>
                <p>Floor Plan</p>
                <div class="portfolio-links">
                  <a href="assets/img/portfolio/Cedar Creek.png" data-gallery="portfolioGallery" class="portfolio-lightbox" title="2 Bed"><i class="bx bx-plus"></i></a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-3bed">
            <div class="portfolio-wrap">
              <img src="assets/img/portfolio/Riverfront Cottage.png" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>Riverfront Cottage</h4>
                <p>Floor Plan</p>
                <div class="portfolio-links">
                  <a href="assets/img/portfolio/Riverfront Cottage.png" data-gallery="portfolioGallery" class="portfolio-lightbox" title="3 Bed"><i class="bx bx-plus"></i></a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-3bed">
            <div class="portfolio-wrap">
              <img src="assets/img/portfolio/Ivy Terrace.png" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>Ivy Terrace</h4>
                <p>Floor Plan</p>
                <div class="portfolio-links">
                  <a href="assets/img/portfolio/Ivy Terrace.png" data-gallery="portfolioGallery" class="portfolio-lightbox" title="3 Bed"><i class="bx bx-plus"></i></a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-3bed">
            <div class="portfolio-wrap">
              <img src="assets/img/portfolio/Greenfield Cottage.png" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>Greenfield Cottage</h4>
                <p>Floor Plan</p>
                <div class="portfolio-links">
                  <a href="assets/img/portfolio/Greenfield Cottage.png" data-gallery="portfolioGallery" class="portfolio-lightbox" title="3 Bed"><i class="bx bx-plus"></i></a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-3bed">
            <div class="portfolio-wrap">
              <img src="assets/img/portfolio/Tranquil Terrace.png" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>Tranquil Terrace</h4>
                <p>Floor Plan</p>
                <div class="portfolio-links">
                  <a href="assets/img/portfolio/Tranquil Terrace.png" data-gallery="portfolioGallery" class="portfolio-lightbox" title="3 Bed"><i class="bx bx-plus"></i></a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-4bed">
            <div class="portfolio-wrap">
              <img src="assets/img/portfolio/Forest Glen Manor.png" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>Forest Glen Manor</h4>
                <p>Floor Plan</p>
                <div class="portfolio-links">
                  <a href="assets/img/portfolio/Forest Glen Manor.png" data-gallery="portfolioGallery" class="portfolio-lightbox" title="4 Bed"><i class="bx bx-plus"></i></a>
                </div>
              </div>
            </div>
          </div>

        </div>

      </div>
    </section>
    
  <!-- End Portfolio Section -->


<!-- ======= Counts Section ======= -->
<section id="counts" class="counts">
      <div class="container" data-aos="fade-up">

        <div class="row no-gutters">
          <div class="image col-xl-5 d-flex align-items-stretch justify-content-center justify-content-lg-start" data-aos="fade-right" data-aos-delay="100"></div>
          <div class="col-xl-7 ps-0 ps-lg-5 pe-lg-1 d-flex align-items-stretch" data-aos="fade-left" data-aos-delay="100">
            <div class="content d-flex flex-column justify-content-center">
              <h3>Enjoy Details That Define Timeless Living</h3>
              <p>
                At Elite Properties, we make it our goal to provide only the best services for our residents. We want to make ourselves available and offer modern solutions to make your experience with us the best it can be. We do what we can to help with this goal - we provide our Online Portal so you can easily pay rent online, submit maintenance requests, and more. Sign up today to get started!
              <div class="row">
                <div class="col-md-6 d-md-flex align-items-md-stretch">
                  <div class="count-box">
                    <i class="bi bi-emoji-smile"></i>
                    <span data-purecounter-start="0" data-purecounter-end="2139" data-purecounter-duration="2" class="purecounter"></span>
                    <p><strong>Happy Residents</strong>Convinience of our Residents are our first priority</p>
                  </div>
                </div>

                <div class="col-md-6 d-md-flex align-items-md-stretch">
                  <div class="count-box">
                    <i class="bi bi-clock"></i>
                    <span data-purecounter-start="0" data-purecounter-end="18" data-purecounter-duration="4" class="purecounter"></span>
                    <p><strong>Years of experience</strong> We have 18 years of experience is delivering excellance</p>
                  </div>
                </div>

                <div class="col-md-6 d-md-flex align-items-md-stretch">
                  <div class="count-box">
                    <i class="bi bi-journal-richtext"></i>
                    <span data-purecounter-start="0" data-purecounter-end="5" data-purecounter-duration="2" class="purecounter"></span>
                    <p><strong>Properties</strong> We currently manage 5 properties with excellent amenities</p>
                  </div>
                </div>

                <div class="col-md-6 d-md-flex align-items-md-stretch">
                  <div class="count-box">
                    <i class="bi bi-award"></i>
                    <span data-purecounter-start="0" data-purecounter-end="10" data-purecounter-duration="4" class="purecounter"></span>
                    <p><strong>Floor Plans</strong> We offer 10 unique floor plans</p>
                  </div>
                </div>
              </div>
            </div>
            <!-- End .content-->
          </div>
        </div>

      </div>
    </section><!-- End Counts Section -->

    <!-- ======= Testimonials Section ======= -->
    <section id="testimonials" class="testimonials">
      <div class="container" data-aos="zoom-in">

        <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="100">
          <div class="swiper-wrapper">

            <div class="swiper-slide">
              <div class="testimonial-item">
                <img src="assets/img/testimonials/testimonials-1.jpg" class="testimonial-img" alt="">
                <h3>Saul Goodman</h3>
                <h4>Fountain Park Reisdent 2020</h4>
                <p>
                  <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                  I lived at Fountain Park for two years and absolutely loved it!! The team at deer park management were ALWAYS responsive and willing to help with any issues! I'd recommend the apartments to anyone. The location cannot be beaten!
                  <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                </p>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <img src="assets/img/testimonials/testimonials-2.jpg" class="testimonial-img" alt="">
                <h3>Sara Wilsson</h3>
                <h4>Meadow Park Resident 2022</h4>
                <p>
                  <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                  I loved my experience at Meadow park. My apartment was large and in good condition for an older building. Pet rent may be a little spendy, but the buildings really are very pet friendly. The courtyard is really nice. I seriously considered staying for a third year, but needed more room
                  <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                </p>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <img src="assets/img/testimonials/testimonials-3.jpg" class="testimonial-img" alt="">
                <h3>Jena Karlis</h3>
                <h4>Crescent Park Resident 2021</h4>
                <p>
                  <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                  I have lived here for one year and recently renewed my lease for another year. Very nice spacious apartments. The leasing staff has always been friendly and helpful. Maintenance is always quick to respond. Great apartment, great location!
                  <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                </p>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <img src="assets/img/testimonials/testimonials-4.jpg" class="testimonial-img" alt="">
                <h3>Matt Brandon</h3>
                <h4>Briarwood Park Resident 2019</h4>
                <p>
                  <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                  Living here is so convenient. The location is near CVS pharmacy stores and Goodwill, and is not far from Kroger and Marsh groceries. In addition, there is an Elementary School–Binford and several churches near our apartments. Therefore, College Mall Apartments is an ideal place to move in.
                  <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                </p>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <img src="assets/img/testimonials/testimonials-5.jpg" class="testimonial-img" alt="">
                <h3>John Larson</h3>
                <h4>Orchard Park Resident 2021</h4>
                <p>
                  <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                  We have lived here for over two years and have never had a problem. Our neighbors are quiet and it isn’t a rowdy community. We have always had maintenance fix our problems either the same day we make the request or the next day. The staff has always been very nice to us. We mainly interact with Heidi and she is very nice and timely with email responses.            
                  <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                </p>
              </div>
            </div><!-- End testimonial item -->
          </div>
          <div class="swiper-pagination"></div>
        </div>

      </div>
    </section><!-- End Testimonials Section -->

        <!-- ======= Team Section ======= -->
        <section id="team" class="team">
      <div class="container" data-aos="fade-up" >

        <div class="section-title">
          <h2>Team</h2>
          <p>Check our Team</p>
        </div>

        <div class="row">

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch" >
            <div class="member" data-aos="fade-up" data-aos-delay="100">
                <div class="social">
                  <a href=""><i class="bi bi-twitter"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
              <div class="member-info">
                <h4>Chandrika Sowmini D</h4>
                <span>cdevabha@iu.edu</span>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
            <div class="member" data-aos="fade-up" data-aos-delay="200">
                <div class="social">
                  <a href=""><i class="bi bi-twitter"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
              <div class="member-info">
                <h4>SriKeerthana Reddy B</h4>
                <span>sribandi@iu.edu</span>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
            <div class="member" data-aos="fade-up" data-aos-delay="300">
                <div class="social">
                  <a href=""><i class="bi bi-twitter"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
              <div class="member-info">
                <h4>Pavani Lakshmi G</h4>
                <span>pgunnam@iu.edu</span>
              </div>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Team Section -->

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Contact</h2>
          <p>Contact Us</p>
        </div>

        <div class="row mt-5">

          <div class="col-lg-4">
            <div class="info">
              <div class="address">
                <i class="bi bi-geo-alt"></i>
                <h4>Location:</h4>
                <p>A108 Adam Street, Bloomington, IN 47401</p>
              </div>

              <div class="email">
                <i class="bi bi-envelope"></i>
                <h4>Email:</h4>
                <p>info@example.com</p>
              </div>

              <div class="phone">
                <i class="bi bi-phone"></i>
                <h4>Call:</h4>
                <p>+1 5589 55488 55s</p>
              </div>

            </div>

          </div>

          <div class="col-lg-8 mt-5 mt-lg-0">

            <form action="forms/contact.php" method="post" role="form" class="php-email-form">
              <div class="row">
                <div class="col-md-6 form-group">
                  <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
                </div>
                <div class="col-md-6 form-group mt-3 mt-md-0">
                  <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
                </div>
              </div>
              <div class="form-group mt-3">
                <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
              </div>
              <div class="form-group mt-3">
                <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
              </div>
              <div class="my-3">
                <div class="loading">Loading</div>
                <div class="error-message"></div>
                <div class="sent-message">Your message has been sent. Thank you!</div>
              </div>
              <div class="text-center"><button type="submit">Send Message</button></div>
            </form>

          </div>

        </div>

      </div>
    </section><!-- End Contact Section -->

  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6">
            <div class="footer-info">
              <h3>Gp<span>.</span></h3>
              <p>
                A108 Adam Street <br>
                Bloomington, IN 47401<br><br>
                <strong>Phone:</strong> +1 5589 55488 55<br>
                <strong>Email:</strong> info@example.com<br>
              </p>
              <div class="social-links mt-3">
                <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
                <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 footer-newsletter">
            <h4>Our Newsletter</h4>
            <p>Subscribe to know available houses immediately</p>
            <form action="" method="post">
              <input type="email" name="email"><input type="submit" value="Subscribe">
            </form>
          </div>

          <div class="col-lg-5 col-md-6">
          <p>          
          <div>
          <iframe style="border:0; width: 100%; height: 270px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3093.2924787099155!2d-86.52843842364726!3d39.16807117166745!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x886c66c3cd37fc17%3A0x45e7df9ab385d36d!2sDunn%20Meadow!5e0!3m2!1sen!2sus!4v1682288756336!5m2!1sen!2sus" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></iframe>
          </div>
          </p>
          </div>


        </div>
      </div>
    </div>

  </footer><!-- End Footer -->

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
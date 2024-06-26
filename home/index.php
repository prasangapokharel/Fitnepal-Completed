<?php
include 'db_connection.php';

// Fetch site settings to get the image path
$query = "SELECT * FROM sitesettings WHERE id = 1";
$stmt = $pdo->prepare($query);
$stmt->execute();
$site_settings = $stmt->fetch(PDO::FETCH_ASSOC);

$site_title = $site_settings['site_title'];
$header_image = $site_settings['header_image'];
$site_logo = $site_settings['site_logo'];

$image_path = "home/assets/"; // Base path for images
?>

<?php
include 'navbar.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Pacifico|Quicksand:400,600&display=swap">
  <link rel="stylesheet" href="styles.css" />

  <title><?php echo $site_title; ?></title>
</head>
<div class="container">
  <header class="header">
    <div class="section__container header__container" id="home">
      <div class="header__image">
        <img src="assets/header4.svg" alt="header" />
      </div>
      <div class="header__content">
        <h4>Build Your Body &</h4>
        <h1 class="section__header">Shape Yourself!</h1>
        <p>
          Unleash your potential and embark on a journey towards a stronger,
          fitter, and more confident you. Sign up for 'Make Your Body Shape'
          now and witness the incredible transformation your body is capable
          of!
        </p>
        <div class="header__btn">
          <a class="trsf" href="../registration.php"> <button class="btn">Join Today</a></button></a>
        </div>
      </div>
    </div>
  </header>

  <section class="section__container class__container" id="class">
    <div class="text">
      <h2 class="section__header">Our Services</h2>
      <p class="section__description">
        FitNepal provides personalized fitness solutions tailored to individual needs and goals
      </p>
    </div>

    <div class="class__grid">
      <div class="class__card">
        <!-- <img src="assets/dot-bg.png" alt="bg" class="class__bg" /> -->
        <img src="assets/bmi.png" alt="class" />
        <div class="class__content">
          <h4>BMI Calculator</h4>
          <p>Body Mass Index</p>
        </div>
      </div>
      <div class="class__card">
        <!-- <img src="assets/dot-bg.png" alt="bg" class="class__bg" /> -->
        <img src="assets/unnamed.png" alt="class" />
        <div class="class__content">
          <h4>Protein Tracker</h4>
          <p>Track your protein</p>
        </div>
      </div>
      <div class="class__card">
        <!-- <img src="assets/dot-bg.png" alt="bg" class="class__bg" /> -->
        <img src="assets/calorie.png" alt="class" />
        <div class="class__content">
          <h4>Calorie Tracker</h4>
          <p>Track your calorie</p>
        </div>
      </div>
    </div>
  </section>

  <section class="section__container price__container" id="price">
    <h2 class="section__header">Our Pricing</h2>
    <p class="section__description">
      Our pricing plan comes with a membership.
    </p>

    <div class="price__card">
      <div class="price__content">
        <h4>Paid Plan</h4>
        <img src="assets/price-2.png" alt="price" />
        <p>
          "Upgrade Your Fitness Journey: Empower Your Goals with FitNepal's Premium Plan!"

        </p>
        <hr />
        <h4>Key Features</h4>
        <p>Protein Tracker</p>
        <p>Calorie Tracker</p>
        <p>User diet</p>
      </div>
      <button class="btn">Join Now</button>
    </div>
</div>
</section>

<section class="section__container client__container" id="client">
  <h2 class="section__header">What People Says About Us?</h2>
  <p class="section__description">
    These testimonials serve as a testament to our commitment to helping
    individuals achieve their fitness goals, and fostering a supportive
    environment for everyone who walks through our doors.
  </p>
  <div class="swiper">
    <div class="swiper-wrapper">
      <div class="swiper-slide">
        <div class="client__card">
          <img src="assets/user.png" alt="client" />
          <div class="client__ratings">
            <span><i class="ri-star-fill"></i></span>
            <span><i class="ri-star-fill"></i></span>
            <span><i class="ri-star-fill"></i></span>
            <span><i class="ri-star-line"></i></span>
          </div>
          <p>
            "FitNepal has truly transformed my fitness journey. From providing reliable information to fostering a supportive environment.I feel confident, empowered, and healthier than ever before."
          </p>
          <h4>Abijeet Raut</h4>
          <h5>App Developer</h5>
        </div>
      </div>
      <div class="swiper-slide">
        <div class="client__card">
          <img src="assets/user.png" alt="client" />
          <div class="client__ratings">
            <span><i class="ri-star-fill"></i></span>
            <span><i class="ri-star-fill"></i></span>
            <span><i class="ri-star-fill"></i></span>
            <span><i class="ri-star-fill"></i></span>
          </div>
          <p>
            "Upgrading to the paid plan was a game-changer. The protein and calorie trackers are so helpful in maintaining a balanced diet and reaching my fitness goals. "
          </p>
          <h4>Kapil Tamang</h4>
          <h5>UI/UX Designer</h5>
        </div>
      </div>
      <div class="swiper-slide">
        <div class="client__card">
          <img src="assets/user.png" alt="client" />
          <div class="client__ratings">
            <span><i class="ri-star-fill"></i></span>
            <span><i class="ri-star-fill"></i></span>
            <span><i class="ri-star-fill"></i></span>
            <span><i class="ri-star-half-fill"></i></span>
            <span><i class="ri-star-line"></i></span>
          </div>
          <p>
            "FitNepal's personalized fitness plans are incredible! They truly understand my goals and tailor workouts that work specifically for me. "
          </p>
          <h4>Rakesh Niroula</h4>
          <h5>Professor</h5>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="container">
  <h2>Contact us</h2><br>
  <form action="subcontact.php" method="post">
    <div class="form-group">
      <label for="formName">Name</label>
      <input type="text" id="formName" name="name" class="form-control" placeholder="Name" required>
    </div>
    <div class="form-group">
      <label for="formEmail">E-mail</label>
      <input type="email" id="formEmail" name="email" class="form-control" placeholder="E-mail" required>
    </div>
    <div class="form-group">
      <label for="formSubject">Subject</label>
      <input type="text" id="formSubject" name="subject" class="form-control" placeholder="Subject" required>
    </div>
    <div class="form-group">
      <label for="formMessage">Message</label>
      <textarea id="formMessage" name="message" class="form-control" rows="5" placeholder="Your message" required></textarea>
    </div>
    <div class="text-center">
      <button type="submit" class="btn btn-primary">Send Message</button>
    </div>
  </form>
</div>
<footer class="footer">
  <div class="section__container footer__container">
    <div class="footer__col">
      <div class="footer__logo">
        <a href="#">FitNepal</a>
        Find your healthy, and your happy.
      </div>
    </div><br><br>

    <div class="footer__col">
      <h4>About Us</h4>

      <div class="footer__links">
        <a href="#">Blogs</a>
        <a href="#">Security</a>
        <a href="#">Careers</a>
      </div>

    </div>

    <div class="footer__col">
      <h4>Support</h4>

      <div class="footer__links">
        <a href="#">Contact Us</a>
        <a href="#">Privacy Policy</a>
        <a href="#">Terms & Conditions</a>
      </div>
    </div>
  </div>

  <div class="footer__socials">
    <a href="https://www.facebook.com/"><i class="ri-facebook-fill"></i></a>
    <a href="https://www.instagram.com/"><i class="ri-instagram-line"></i></a>
    <a href="https://twitter.com/"><i class="ri-twitter-fill"></i></a>
  </div>
  <div class="footer__bar">
    Copyright © 2024 fitnepal . All rights reserved.
  </div>
</footer>

<script src="https://unpkg.com/scrollreveal"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script src="main.js"></script>
</body>

</html>
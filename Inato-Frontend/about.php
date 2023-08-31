<?php include(__DIR__ . '/../inato-admin/config/dbcon.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about us</title>
   <link rel="icon" type="image/x-icon" href="images/inatosnew.png">

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

   <!---Aos animation link-->

   <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">


</head>
<body>
   
<header class="header">

   <section class="flex">

      <img  src="images/inatosnew.png" class="logo" alt="" >

      <nav class="navbar">
         <a href="home.php">Home</a>
         <a href="about.php">About</a>
         <a href="menu.php">Menu</a>
         <a href="orders.php">Orders</a>
         <a href="contact.php">Contact</a>
      </nav>

      <div class="icons">
    <?php
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        //sql query for cart
        $countcartsql = "SELECT * FROM tbl_cart WHERE user_id = $user_id";

        //check the query is executed or not
        $cartres = mysqli_query($conn, $countcartsql);

        $countcarts = mysqli_num_rows($cartres);

        echo '<a href="search.php"><i class="fas fa-search"></i></a>';
        echo '<a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(' . $countcarts . ')</span></a>';
    } else {
        echo '<a href="search.php"><i class="fas fa-search"></i></a>';
        echo '<a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(0)</span></a>';
    }
    ?>
    <div id="user-btn" class="fas fa-user"></div>
    <div id="menu-btn" class="fas fa-bars"></div>
</div>


      <div class="profile">
    <?php
    $name = ''; // Initialize the variable to an empty string

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // Assuming you have established the $conn variable for database connection

        // Your existing code to fetch user data
        $userquery = "SELECT * FROM tbl_user WHERE id = $user_id";
        $userresult = mysqli_query($conn, $userquery);
        $usercount = mysqli_num_rows($userresult);

        if ($usercount > 0) {
            while ($userow = mysqli_fetch_assoc($userresult)) {
                $name = $userow['name'];
                // You can process other data here if needed
            }
        } else {
            echo '<script>
                 swal({
                     title: "Error",
                     text: "User not available",
                     icon: "error"
                 }).then(function() {
                     window.location = "login.php";
                 });
             </script>';
            exit;
        }
    } else {
        $name = ''; // Set name to empty if user is not logged in
    }
    ?>
    <?php if ($name !== '') { ?>
    <p class="name"><?php echo $name; ?></p>
    <?php } ?>
    <div class="flex">
        <a href="profile.php" class="btn">profile</a>
        <a href="user-logut.php" class="delete-btn" onclick="return confirm('logout from the website?');">logout</a>
    </div>
    <p class="account"><a href="login.php">login</a> or <a href="register.php">register</a></p>
</div>

   </section>

</header>

<div class="heading">
   <h3>about us</h3>
   <p><a href="about.php">home </a> <span> / about</span></p>
</div>

<section class="about">

   <div class="row">

      <div  class="image" data-aos="fade-up-right" data-aos-delay="300" data-aos-duration="3000">
         <img  src="images/about-img.svg" alt="">
      </div>
 

      <div class="content" data-aos="fade-left" data-aos-delay="300" data-aos-duration="3000">
         <h3>why choose us?</h3>
         <p style="text-align: justify;">At Inato, we are passionate about bringing the authentic flavors of home-cooked meals to your doorstep. Our innovative Lutong Bahay Food Ordering Website is designed to cater to your cravings for wholesome Filipino dishes, conveniently available with just a few clicks. </p>
         <a href="menu.php" class="btn">our menu</a>
      </div>

      

   </div>

   

</section>

<section class="steps">

   <h1 class="title" data-aos="fade-up-right" data-aos-delay="300" data-aos-duration="3000">3 simple steps</h1>

   <div class="box-container">

      <div class="box" data-aos="fade-up" data-aos-delay="300" data-aos-duration="3000">
         <img src="images/step-1.png" alt="">
         <h3>select food</h3>
         <p style="text-align: justify;">Explore our exquisite selection of dishes, where every bite tells a story of flavor and tradition.</p>
      </div>

      <div class="box" data-aos="fade-down" data-aos-delay="300" data-aos-duration="3000">
         <img src="images/step-2.png" alt="">
         <h3>30 minutes delivery</h3>
         <p style="text-align: justify;">Experience the convenience of prompt 30-minute delivery, bringing the taste of excellence right to your doorstep.</p>
      </div>

      <div class="box" data-aos="fade-left" data-aos-delay="300" data-aos-duration="3000">
         <img src="images/step-3.png" alt="">
         <h3>enjoy food!</h3>
         <p style="text-align: justify;">Delight in the pleasure of savoring delectable cuisine that's prepared with passion and served with care</p>
      </div>

   </div>

</section>

<section class="reviews">

   <h1 class="title" data-aos="fade-right" data-aos-delay="300" data-aos-duration="3000">customer's reviews</h1>

   <div class="swiper reviews-slider">

      <div class="swiper-wrapper">

         <div class="swiper-slide slide">
            <img src="images/aj.png" alt="">
            <p>Absolutely amazing flavors that transport me back to my grandma's kitchen!</p>
            <div class="stars">
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>Aj Calcena</h3>
         </div>

         <div class="swiper-slide slide">
            <img src="images/ber.png" alt="">
            <p>The food was beyond my expectations, and the delivery was super swift!</p>
            <div class="stars">
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>Bernard Maraon</h3>
         </div>

         <div class="swiper-slide slide">
            <img src="images/raymond.png" alt="">
            <p>Authentic Filipino dishes that make my taste buds dance with joy.</p>
            <div class="stars">
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>Raymond Mapayo</h3>
         </div>

         <div class="swiper-slide slide">
            <img src="images/juswa.png" alt="">
            <p>A flavorful journey through Filipino cuisine that I can't get enough of.</p>
            <div class="stars">
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>Le Joshua Guzman</h3>
         </div>

         <div class="swiper-slide slide">
            <img src="images/janley.png" alt="">
            <p>Inato's Lutong Bahay is my go-to for satisfying my cravings for home-cooked.</p>
            <div class="stars">
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>Johnley Engyo</h3>
         </div>

         <div class="swiper-slide slide">
            <img src="images/marie.png" alt="">
            <p>The perfect blend of tradition and innovation in every dish they serve.</p>
            <div class="stars">
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>Marie Cris Alarilla</h3>
         </div>

         <div class="swiper-slide slide">
            <img src="images/eds.png" alt="">
            <p>From the first bite to the last, every morsel was a culinary masterpiece.</p>
            <div class="stars">
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>Edda Osorno</h3>
         </div>

         <div class="swiper-slide slide">
            <img src="images/hanz.png" alt="">
            <p>Their dedication to prompt delivery and flavorsome meals keeps me coming back.</p>
            <div class="stars">
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>Hanz Daryl Quezada</h3>
         </div>

      </div>

      <div class="swiper-pagination"></div>

   </div>

</section>




<footer class="footer">

   

   <div class="credit">&copy; copyright @ 2023 by <span>Inato's Lutong Bahay</span> | all rights reserved!</div>

</footer>






<div class="loader">
   <img src="images/cooking_loader_2.gif" alt="">
</div>



<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
   AOS.init();
 </script>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<script src="js/script.js"></script>

<script>

var swiper = new Swiper(".reviews-slider", {
   loop:true,
   grabCursor:true,
            spaceBetween: 20,
            autoplay: {
         delay: 3000, // Time in milliseconds between each slide
      },
   pagination: {
      el: ".swiper-pagination",
   },
   breakpoints: {
      550: {
        slidesPerView: 1,
      },
      768: {
        slidesPerView: 2,
      },
      1024: {
        slidesPerView: 3,
      },
   },
});

</script>

</body>
</html>
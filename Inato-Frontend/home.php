<?php include(__DIR__ . '/../inato-admin/config/dbcon.php');


session_start();


if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>
   <link rel="icon" type="image/x-icon" href="images/inatosnew.png">

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

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

<section class="home">

   <div class="swiper home-slider">

      <div class="swiper-wrapper">

         <div class="swiper-slide slide">
            <div class="content">
               
               <h3>Strawberry Chocolate</h3>
               <a href="menu.php" class="btn">see menus</a>
            </div>
            <div class="image">
               <img src="images/desertchok.png" alt="">
            </div>
         </div>

         <div class="swiper-slide slide">
            <div class="content">
             
               <h3>Grilled Pork</h3>
               <a href="menu.php" class="btn">see menus</a>
            </div>
            <div class="image">
               <img src="images/grilledpork.png" alt="">
            </div>
         </div>

         <div class="swiper-slide slide">
            <div class="content">
               
               <h3>roasted chicken</h3>
               <a href="menu.php" class="btn">see menus</a>
            </div>
            <div class="image">
               <img src="images/home-img-3.png" alt="">
            </div>
         </div>

         

      </div>

      <div class="swiper-pagination"></div>

   </div>

</section>

<section class="category">

   <h1 class="title" data-aos="fade-right" data-aos-delay="300" data-aos-duration="3000">Food Category</h1>

   <div class="swiper category-slider">

   <div class="swiper-wrapper">

   <a href="category.php?category=fried" class="swiper-slide slide">
      <img src="images/cat-1.png" alt="">
      <h3>Fried</h3>
   </a>

   <a href="category.php?category=soup" class="swiper-slide slide">
      <img src="images/soupicon.png" alt="">
      <h3>Soup</h3>
   </a>

   <a href="category.php?category=drinks" class="swiper-slide slide">
      <img src="images/cat-3.png" alt="">
      <h3>Drinks</h3>
   </a>

   <a href="category.php?category=desert" class="swiper-slide slide">
      <img src="images/cat-4.png" alt="">
      <h3>Deserts</h3>
   </a>


   <a href="category.php?category=grilled" class="swiper-slide slide">
      <img src="images/grilledicon.png" alt="">
      <h3>Grilled</h3>
   </a>
   

   </div>

   <div class="swiper-pagination"></div>

   </div>

</section>

<section class="products">

   <h1 class="title" data-aos="fade-right" data-aos-delay="300" data-aos-duration="3000">latest dishes</h1>

   <div class="swiper product-slider">
      <div class="swiper-wrapper">
         <?php
         $cartquery = "SELECT * FROM tbl_cart";

         //cartresukt
         $cartresult = mysqli_query($conn,$cartquery);
         $cartcount = mysqli_num_rows($cartresult);
         if($cartcount>0)
         {
            while($cartrow = mysqli_fetch_assoc($cartresult))
            {
               $idd = $cartrow['id'];
            }
         }
         ?>
         

         <?php
            //create sql query to display the food on front-end
            $foodisplayquery = "SELECT * FROM tbl_food";

            //check the sql query if executed or not
            $foodresult = mysqli_query($conn,$foodisplayquery);

            //count the numrows
            $foodcount = mysqli_num_rows($foodresult);

            if($foodcount>0)
            {
               while($foodrow = mysqli_fetch_assoc($foodresult))
               {
                  $pid = $foodrow['id'];
                  $foodname = $foodrow['name'];
                  $price = $foodrow['price'];
                  $stock = $foodrow['stock'];
                  $image = $foodrow['image'];
                  $categoryname = $foodrow['category']; 
                  $_SESSION['pid'] = $foodrow['id'];

                  ?>

         <div class="box-container swiper-slide slide">

         <form accept="" method="post" class="box">
            <a href="quick_view.php?id=<?php echo $pid; ?>" class="fas fa-eye"></a>
            <button class="fas fa-shopping-cart"  type="submit" name="add_to_cart"></button>
            <img src="../inato-admin/images/food/<?php echo $image;?>" alt="">
            <a href="category.php"  class="cat"><?php echo $categoryname;?></a>
            <div class="name"  ><?php echo $foodname;?></div>
            <div class="name">Stock: <?php echo $stock;?> </div>
            <div class="flex">
               <div class="price" name="price" value=""><span>₱ </span><?php echo $price;?><span></span></div>
               <input type="number" name="qty" class="qty" min="1" max="99" value="1" onkeypress="if(this.value.length == 2) return false;">
               <input type="hidden" name="pid" value="<?php echo $pid; ?>">
               <input type="hidden" name="name" value="<?php echo $foodname; ?>">
               <input type="hidden" name="price" value="<?php echo $price; ?>">
               <input type="hidden" name="image" value="<?php echo $image; ?>">
               <input type="hidden" name="stock" value="<?php echo $stock; ?>">
               <input type="hidden" name="category" value="<?php echo $categoryname; ?>">
            </div>
         </form>


         </div>


                  <?php

               }
            }
         
         ?>



            

         


         

         
            

    
    
      </div>
    
      
   </div>
   
   

</section>

<?php


if (isset($_POST['add_to_cart'])) {
    $user_id = $_SESSION['user_id'] ?? ''; // Use null coalescing operator to set default value

    if (empty($user_id)) {
        // Redirect if user is not logged in
        echo '<script>
            swal({
                title: "Error",
                text: "You need to be logged in to add items to the cart",
                icon: "error"
            }).then(function() {
                window.location = "login.php";
            });
        </script>';
        exit;
    } else {
      $pid = $_POST['pid'];
      $foodname = $_POST['name'];
      $price = $_POST['price'];
      $stock = $_POST['stock'];
      $categoryname = $_POST['category'];
      $qty = $_POST['qty'];
      $image = $_POST['image'];

      // Stock query
      $check_stock = "SELECT stock FROM tbl_food WHERE id = $pid";
      
      // Check the stock query execution
      $stock_result = mysqli_query($conn, $check_stock);

      if ($stock_result) {
          $stock_row = mysqli_fetch_assoc($stock_result);
          $available_stock = $stock_row['stock'];

          if ($available_stock <= 0) {
              echo '<script>
                  swal({
                      title: "Error",
                      text: "Sorry, this food is not available right now",
                      icon: "error"
                  }).then(function() {
                      window.location = "home.php";
                  });
              </script>';
              exit;
          } else {
              // Continue with adding to cart
              $cartinsert = "INSERT INTO tbl_cart SET name = '$foodname', user_id = '$user_id', food_id = '$pid', price = '$price', quantity = '$qty', image = '$image'";
              $cartresult = mysqli_query($conn, $cartinsert);

              if ($cartresult) {
                  echo '<script>
                      swal({
                          title: "Success",
                          text: "Food Successfully Added to cart",
                          icon: "success"
                      }).then(function() {
                          window.location = "home.php";
                      });
                  </script>';
                  exit;
              } else {
                  echo '<script>
                      swal({
                          title: "Error",
                          text: "Food Failed to be Added to cart",
                          icon: "error"
                      }).then(function() {
                          window.location = "login.php";
                      });
                  </script>';
                  exit;
              }
          }
      } else {
          echo '<script>
              swal({
                  title: "Error",
                  text: "Failed to check food availability",
                  icon: "error"
              }).then(function() {
                  window.location = "home.php";
              });
          </script>';
          exit;
      }
    }
}
?>







<section class="maps">
   <h1 class="title" data-aos="fade-right" data-aos-delay="300" data-aos-duration="3000">Maps & Information</h1>

   <div class="container">
      <div class="map-container" data-aos="fade-up-right" data-aos-delay="300" data-aos-duration="3000">
         <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3959.6122376045864!2d125.57042007457038!3d7.054766616762588!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x32f973fbf3cf5fa9%3A0x52b5f67dab581c73!2sINATO%20(LUTONG%20BAHAY)!5e0!3m2!1sen!2sph!4v1691921286582!5m2!1sen!2sph" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>

      <div class="info-container" data-aos="fade-up-left" data-aos-delay="300" data-aos-duration="3000">
         <div class="info">
            <h2>Contact Information</h2>
            <p>Phone: <a href="">0977 104 8302</a></p>
            <p>Address: 23 GARNET, San Antonio St, Davao City, 8000 Davao del Sur
            </p>
            <p>Follow us on <a href="https://www.facebook.com/DeliasLutongBahay">Facebook</a></p>
         </div>
      </div>
   </div>
</section>



<footer class="footer">

   

   <div class="credit">&copy; copyright @ 2023 by <span>Inato's Lutong Bahay</span> | all rights reserved!</div>

</footer>




<div class="loader">
   <img src="images/cooking_loader_2.gif" alt="">
</div>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
   AOS.init();
 </script>

<script src="js/script.js"></script>

<script>

var swiper = new Swiper(".home-slider", {
   loop:true,
   grabCursor:true,
   effect: "flip",
   autoplay: {
         delay: 3000, // Time in milliseconds between each slide
      },
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
});

var swiper = new Swiper(".category-slider", {
   loop:true,
   spaceBetween: 20,
   autoplay: {
         delay: 3000, // Time in milliseconds between each slide
      },
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   
   breakpoints: {
      0: {
         slidesPerView: 2,
       },
      650: {
        slidesPerView: 3,
      },
      768: {
        slidesPerView: 4,
      },
      1024: {
        slidesPerView: 5,
      },
   },
});


var swiper = new Swiper('.product-slider', {
   slidesPerView: 3,   // Default number of slides
   spaceBetween: 3,   // Space between slides
   autoplay: {
         delay: 3000, // Time in milliseconds between each slide
      },
   pagination: {
      el: '.swiper-pagination',
      clickable: true,
   },

   breakpoints: {
      // Breakpoint for screens with width less than 650px
      0: {
         slidesPerView: 1,
      },
      // Breakpoint for screens with width between 650px and 767px
      650: {
         slidesPerView: 2,
      },
      // Breakpoint for screens with width between 768px and 1023px
      900: {
         slidesPerView: 3,
      },
      // Breakpoint for screens with width equal to or greater than 1024px
     
   },
});



</script>





</body>
</html>
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
   <title>food menu</title>
   <link rel="icon" type="image/x-icon" href="images/inatosnew.png">

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
   <h3>Category</h3>
   <p><a href="home.php">home </a> <span> / Category</span></p>
</div>

<section class="products">

   <h1 class="title" data-aos="fade-right" data-aos-delay="300" data-aos-duration="3000">Categories</h1>

   <div class="box-container">

   <?php
      $category = $_GET['category'];
      $sqlfood = "SELECT * FROM tbl_food WHERE category LIKE '%{$category}%'";

      //check if the query is executed or not
      $resultfood = mysqli_query($conn,$sqlfood);

      $foodcount = mysqli_num_rows($resultfood);

      if($foodcount>0)
      {
         while($foodrow = mysqli_fetch_assoc($resultfood))
         {

            $pid = $foodrow['id'];
            $foodname = $foodrow['name'];
            $price = $foodrow['price'];
            $stock = $foodrow['stock'];
            $image = $foodrow['image'];
            $categoryname = $foodrow['category']; 
            ?>

            

         <form accept="" method="post" class="box">
         <a href="quick_view.php?id=<?php echo $pid; ?>" class="fas fa-eye"></a>
         <button class="fas fa-shopping-cart" type="submit" name="add_to_cart"></button>
         <img src="../inato-admin/images/food/<?php echo $image;?>" alt="">
         <a href="category.php" class="cat"><?php echo $categoryname;?></a>
         <div class="name" ><?php echo $foodname;?></div>
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




      <?php
         }
      }
      else{
         echo '<p class="empty">no food found!</p>';
      }


   
   ?>

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

<script src="js/script.js"></script>

</body>
</html>
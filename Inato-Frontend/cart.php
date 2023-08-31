<?php include(__DIR__ . '/../inato-admin/config/dbcon.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>my cart</title>
   <link rel="icon" type="image/x-icon" href="images/inatosnew.png">

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
   <h3>shopping cart</h3>
   <p><a href="home.php">home </a> <span> / cart</span></p>
</div>

<section class="products" id="products">

   <h1 class="title" data-aos="fade-right" data-aos-delay="300" data-aos-duration="3000">your cart</h1>

   <div class="box-container" >

   <?php
   //select cart query
   $grand_total = 0; 

   if (isset($_SESSION['user_id'])) {
      $user_id = $_SESSION['user_id'];
      $select_cart = "SELECT * FROM tbl_cart WHERE user_id = $user_id";
      //check the sql query executed or not
      $cart_results = mysqli_query($conn, $select_cart);
      $grand_total = 0;

      $cart_counts = mysqli_num_rows($cart_results);

      if ($cart_counts > 0) {
         while ($rowcarts = mysqli_fetch_assoc($cart_results)) {
            $id = $rowcarts['id'];
            $food_id = $rowcarts['food_id'];
            $food_qty = $rowcarts['quantity'];
            $foodname = $rowcarts['name'];
            $price = $rowcarts['price'];
            $image = $rowcarts['image'];

            $stock = ""; // Initialize stock variable

            $sub_total = $price * $food_qty; // Calculate sub total

            $grand_total += $sub_total; // Add to grand total
            
            ///stock query
            $stocksql = "SELECT stock FROM tbl_food WHERE id = $food_id";
            //check the query is executed or not
            $stockres = mysqli_query($conn, $stocksql);

            while ($stockrow = mysqli_fetch_assoc($stockres)) {
               $stock = $stockrow['stock']; // Assign the stock value

            }

        
            ?>

               <form action="code.php" method="post" class="box">
               <a href="quick_view.php?id=<?php echo $food_id; ?>" class="fas fa-eye"></a>
               <input type="hidden" name="cart_id" value="<?php echo $id;?>">
               <button class="fas fa-times delete_cartbtn"  type="submit" value="<?= $id;?>"  ></button>
               <img src="../inato-admin/images/food/<?php echo $image;?>" alt="">
               <div class="name"><?php echo $foodname;?></div>
               <div class="name">Stock: <?php echo $stock;?></div>
               
               <div class="flex">
                  <div class="price" name="price" value=""><span>₱ </span><?php echo $price;?><span></span></div>
                  <input type="number" name="quantity" class="qty" min="1" max="99" value="<?php echo $food_qty ?>" />
                  <button type="submit" name="update_cart" class="fas fa-edit update_cart" value="<?= $id;?>"></button>
                  <input type="hidden" name="pid" value="<?php echo $food_id; ?>">
                  <input type="hidden" name="name" value="<?php echo $foodname; ?>">
                  <input type="hidden" name="price" value="<?php echo $price; ?>">
                  <input type="hidden" name="image" value="<?php echo $image; ?>">
                  <input type="hidden" name="stock" value="<?php echo $stock; ?>">
                  <input type="hidden" name="category" value="<?php echo $categoryname; ?>">
               </div>
               
               <div class="sub-total"> sub total : <span>₱<?= number_format($sub_total, 2, '.', ','); ?></span> </div>
               </form>

              

<?php
         }
      }
   }
   else{
      echo '<p class="empty-message">your cart is empty</p>';
   }
?>


      

   </div>

   <div class="cart-total">
   <p>grand total : <span>₱<?= number_format($grand_total, 2, '.', ','); ?></span></p>
      <a href="checkout.php" class="btn">checkout orders</a>
      </div>
   </div>

   <form action="code.php" method="post" >
      <div class="more-btn">
      <a href="#" class="delete-btn deleteall-btn" value="<?= $id;?>">delete all</a>
      </div>
      </form>

</section>


<?php
   
?>





<footer class="footer">

   

   <div class="credit">&copy; copyright @ 2023 by <span>Inato's Lutong Bahay</span> | all rights reserved!</div>

</footer>

<div class="loader">
   <img src="images/cooking_loader_2.gif" alt="">
</div>

<script src="js/script.js"></script>
<script src="js/custom.del.js"></script>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
   AOS.init();
 </script>



</body>
</html>
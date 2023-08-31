<?php include(__DIR__ . '/../inato-admin/config/dbcon.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>
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
   <h3>checkout</h3>
   <p><a href="home.php">home </a> <span> / checkout</span></p>
</div>

<section class="checkout">
    <form action="" method="post" data-aos="fade-up-right" data-aos-delay="300" data-aos-duration="3000">
        <h1 class="title" data-aos="fade-right" data-aos-delay="300" data-aos-duration="3000">Order Summary</h1>

        <?php
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Fetch Cart Items
    $cartsql = "SELECT * FROM tbl_cart WHERE user_id = $user_id"; // Assuming the user_id is a column in tbl_cart
    $cartresult = mysqli_query($conn, $cartsql);

    // Fetch User Information and Delivery Address
    $usersql = "SELECT * FROM tbl_user WHERE id = $user_id";
    $useres = mysqli_query($conn, $usersql);

    if ($cartresult && $useres) {
        $grandTotal = 0; // Initialize the grand total
        $cart_items = '';

        echo '<div class="cart-items">';
        echo '<h3>Cart Items</h3>';

        while ($cartrow = mysqli_fetch_assoc($cartresult)) {
            $quantity = $cartrow['quantity'];
            $price = $cartrow['price'];
            $totalPrice = $quantity * $price;
            $grandTotal += $totalPrice; // Add to the grand total

            $cart_items .= $cartrow['name'] . ' (' . $cartrow['price'] . ' x ' . $cartrow['quantity'] . ') - ';
        }

        echo '<p>';
        echo '<span class="name">Food name: ' . $cart_items . '</span>';
        echo '<span class="price">₱' . $grandTotal . '</span>';
        echo '</p>';
        echo '<a href="cart.php" class="btn">View Cart</a>';
        echo '</div>';

        if ($user_row = mysqli_fetch_assoc($useres)) {
            $name = $user_row['name'];
            $email = $user_row['email'];
            $address = $user_row['address'];
            $number = $user_row['number'];

            echo '<div class="user-info">';
            echo '<h3>Your Info</h3>';
            echo '<p><i class="fas fa-user"></i> <span>' . $name . '</span></p>';
            echo '<p><i class="fas fa-phone"></i> <span>' . $number . '</span></p>';
            echo '<p><i class="fas fa-envelope"></i> <span>' . $email . '</span></p>';
            echo '<a href="update_profile.php" class="btn">Update Info</a>';
            echo '<h3>Delivery Address</h3>';
            echo '<p class="address"><i class="fas fa-map-marker-alt"></i> <span>' . $address . '</span></p>';
            echo '<a href="update_address.php" class="btn">Update Address</a>';
            echo '<select name="method" class="box" required>';
            echo '<option value="" disabled selected>Select payment method</option>';
            echo '<option value="cash on delivery">Cash on delivery</option>';
            echo '<option value="credit card">Credit card</option>';
            echo '<option value="paytm">Paytm</option>';
            echo '<option value="paypal">PayPal</option>';
            echo '</select>';
            echo '</div>';
        }
    }
}
?>

        
        <input type="submit" value="Place Order" name="order" class="btn order-btn">
    </form>
</section>



<?php

if(isset($_POST['order']))
{
   $method = $_POST['method'];
   $select_cart = "SELECT * FROM tbl_cart WHERE user_id = $user_id";
   //check the query if executed or not
   $cart_res = mysqli_query($conn, $select_cart);
   $cart_count = mysqli_num_rows($cart_res);

   if($cart_count > 0)
   {
      while($cart_row = mysqli_fetch_assoc($cart_res))
      {
         $food_id = $cart_row['food_id'];
         $quantity = $cart_row['quantity'];

         //select the stock on tbl_food
         $select_stock = "SELECT stock FROM tbl_food WHERE id = $food_id";
         $stock_res = mysqli_query($conn, $select_stock);
         $stock_row = mysqli_fetch_assoc($stock_res); // Assuming one result
         $current_stock = $stock_row['stock'];

         $newstock = $current_stock - $quantity;

         $update_stock = "UPDATE tbl_food SET stock = $newstock WHERE id = $food_id";
         mysqli_query($conn, $update_stock);
      }

      $insert_order = "INSERT INTO tbl_foodorder (user_id, name, email , number, method, address, total_products, total_price, place_on, payment_status) 
                        VALUES ($user_id, '$name',  '$email' ,'$number', '$method', '$address', '$cart_items', $grandTotal, NOW(), 'pending')";
      
      $insert_order_result = mysqli_query($conn, $insert_order);

      if ($insert_order_result) {
         $delete_cart = "DELETE FROM tbl_cart WHERE user_id = $user_id";
         mysqli_query($conn, $delete_cart);

         echo '<script>
            swal({
                title: "Success",
                text: "Order placed successfully!",
                icon: "success"
            }).then(function() {
                window.location = "home.php";
            });
         </script>';
         exit;
      } else {
         $error = mysqli_error($conn);
         echo '<script>
            swal({
                title: "Error",
                text: "Failed to place the order. ' . $error . '",
                icon: "error"
            }).then(function() {
                window.location = "checkout.php"; // Redirect to checkout page or appropriate page
            });
         </script>';
         exit;
      }
   } else {
      echo '<script>
         swal({
            title: "Error",
            text: "Cart is empty.",
            icon: "error"
         }).then(function() {
            window.location = "checkout.php"; // Redirect to checkout page or appropriate page
         });
      </script>';
      exit;
   }
}

?>









<footer class="footer">

   

   <div class="credit">&copy; copyright @ 2023 by <span>Inato's Lutong Bahay</span> | all rights reserved!</div>

</footer>

<div class="loader">
   <img src="images/cooking_loader_2.gif" alt="">
</div>

<script src="js/script.js"></script>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
   AOS.init();
 </script>

</body>
</html>
<?php include(__DIR__ . '/../inato-admin/config/dbcon.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>contact us</title>
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
   <h3>contact us</h3>
   <p><a href="home.php">home </a> <span> / contact</span></p>
</div>

<section class="contact">

   <div class="row">

      <div class="image" data-aos="fade-right" data-aos-delay="300" data-aos-duration="3000">
         <img src="images/contact-img.svg" alt="">
      </div>

      <form action="" method="post" >
         <h3>tell us something!</h3>
         <input type="text" name="name" required placeholder="enter your name" maxlength="50" class="box">
         <input type="number" name="number" required placeholder="enter your number" max="9999999999" min="0" class="box" onkeypress="if(this.value.length == 10) return false;">
         <input type="email" name="email" required placeholder="enter your email" maxlength="50" class="box">
         <textarea name="msg" placeholder="enter your message" required class="box" cols="30" rows="10" maxlength="500"></textarea>
         <input type="submit" value="send message" class="btn" name="send">
      </form>

   </div>

</section>

<?php

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];

    //get the data from the form
    if(isset($_POST['send'])) {
        // ... (other form data retrieval)
        
      $name = $_POST['name'];
      $email = $_POST['email'];
      $number = $_POST['number'];
      $msg = $_POST['msg'];
      $datetime = date("Y-m-d H:i:s");

        // SQL query to check if the current user has sent a message
        $sql = "SELECT * FROM tbl_message WHERE user_id = $user_id";

        // Execute the query
        $result = mysqli_query($conn, $sql);

        $count = mysqli_num_rows($result);

        if($count > 0) {
            // Message already sent by the current user
            echo '<script>
                swal({
                    title: "Error",
                    text: "Message already sent",
                    icon: "error"
                }).then(function() {
                    window.location = "home.php";
                });
            </script>';

            exit;
        } else {
            $sql2 = "INSERT INTO tbl_message SET name = '$name' , email = '$email' , number = $number , message = '$msg' , user_id = $user_id , datetime = '$datetime' ";

            $result2 = mysqli_query($conn, $sql2);

            if($result2 == true) {
                // Message sent successfully
                echo '<script>
                    swal({
                        title: "Success",
                        text: "Message Successfully Sent",
                        icon: "success"
                    }).then(function() {
                        window.location = "home.php";
                    });
                </script>';

                exit;
            } else {
                // Failed to send message
                echo '<script>
                    swal({
                        title: "Error",
                        text: "Failed to send message",
                        icon: "error"
                    }).then(function() {
                        window.location = "home.php";
                    });
                </script>';

                exit;
            }
        }
    }
} else {
    $user_id = '';
}
?>


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
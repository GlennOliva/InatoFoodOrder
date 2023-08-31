<?php
include(__DIR__ . '/../inato-admin/config/dbcon.php');
session_start();

if(isset($_POST['delete_cartbtn']))
{
    $cart_id = $_POST['cart_id'];
    $user_id = $_SESSION['user_id'];


    // Create SQL query for delete message
    $cartql = "DELETE FROM tbl_cart WHERE id = $cart_id";

    // Execute the delete query
    $msgresult = mysqli_query($conn, $cartql);

    if ($msgresult) {
        // Check if any rows were affected by the delete query
        if (mysqli_affected_rows($conn) > 0) {
            echo 200; // Success
        } else {
            echo 500; // Failed (no rows affected)
        }
    } else {
        echo 500; // Failed (query execution error)
    }
}
else if(isset($_POST['update_cart']))
{
   $cart_id = $_POST['cart_id'];
   $qty = $_POST['quantity'];

   //sql update
   $qtyupdatesql = "UPDATE tbl_cart SET quantity = $qty WHERE id = $cart_id";

   //check the query is executed or not
   $qtyres = mysqli_query($conn,$qtyupdatesql);

   if($qtyres == true)
   {
      //update success
      echo 300;
      
   }
   else
   {
      //failed to update
      echo 600;
   }
}
else if(isset($_POST['deleteall-btn']))
{
    $user_id = $_SESSION['user_id'];

    // Create SQL query for delete message
    $cartsql = "DELETE FROM tbl_cart WHERE user_id = $user_id";

    // Execute the delete query
    $cartresult = mysqli_query($conn, $cartsql);

    if ($cartresult) {
        // Check if any rows were affected by the delete query
        if (mysqli_affected_rows($conn) > 0) {
            echo 400; // Success
        } else {
            echo 800; // Failed (no rows affected)
        }
    } else {
        echo 800; // Failed (query execution error)
    }
}


?>
<?php
include('config/dbcon.php');
session_start();

if(isset($_POST['delete_adminbtn']))
{

    $id = $_POST['admin_id'];
    //Create SQL query to delete admin
$sql = "SELECT * FROM tbl_admin WHERE id=$id";

// Execute the query
$result = mysqli_query($conn, $sql);

$count2 = mysqli_fetch_array($result);


$image_name2 = $count2['image'];

   $sql1 = "DELETE FROM tbl_admin WHERE id=$id";
   $result1 = mysqli_query($conn,$sql1);

   if($result1)
   {
        if(file_exists("images/admin/".$image_name2))
        {
            unlink("images/admin/".$image_name2);
        }

        echo 200;

    }
    else
    {
        echo 500;
    }


}
else if(isset($_POST['delete_foodbtn']))
{
   $id = $_POST['food_id'];

   $sql2 = "SELECT * FROM tbl_food WHERE id=$id";

   $result2 = mysqli_query($conn,$sql2);
   
   $count = mysqli_fetch_array($result2);
   $image_name = $count['image'];

   $sql3 = "DELETE FROM tbl_food WHERE id=$id";
   $result3 = mysqli_query($conn,$sql3);

   if($result3)
   {
        if(file_exists("images/food/".$image_name))
        {
            unlink("images/food/".$image_name);
        }

        echo 400;

    }
    else
    {
        echo 800;
    }
 
    
  
 
}
else if(isset($_POST['delete_msgbtn']))
{
    $id = $_POST['msg_id'];
    $user_id = $_SESSION['user_id'];

    $usersql = "SELECT * FROM tbl_user WHERE id = $user_id";

    // Create SQL query for delete message
    $msgsql = "DELETE FROM tbl_message WHERE id = $id";

    // Execute the delete query
    $msgresult = mysqli_query($conn, $msgsql);

    if ($msgresult) {
        // Check if any rows were affected by the delete query
        if (mysqli_affected_rows($conn) > 0) {
            echo 600; // Success
        } else {
            echo 900; // Failed (no rows affected)
        }
    } else {
        echo 900; // Failed (query execution error)
    }
}


?>
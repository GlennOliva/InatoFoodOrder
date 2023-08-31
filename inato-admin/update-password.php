<?php   include('config/dbcon.php');
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="admin_css/admin.css">
    <link rel="stylesheet" href="admin_css/product.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="icon" href="images/inatologo.png" type="image/x-icon">
    <title>Admin Dashboard</title>
</head>

<body>

<?php
if(!isset($_SESSION['admin_id']))
{
    echo '<script>
                                    swal({
                                        title: "Error",
                                        text: "You must login first before you proceed!",
                                        icon: "error"
                                    }).then(function() {
                                        window.location = "admin-login.php";
                                    });
                                </script>';
                                exit;
}

?>

    <div class="container">
        <!-- Sidebar Section -->
        <aside>
            <div class="toggle">
                <div class="logo">
                    <img src="images/inatonewlogo.png">
                  
                </div>
                <div class="close" id="close-btn">
                    <span class="material-icons-sharp">
                        close
                    </span>
                </div>
            </div>

            <div class="sidebar">
                <a href="dashboard.php">
                    <span class="material-icons-sharp">
                        dashboard
                    </span>
                    <h3>Dashboard</h3>
                </a>
                <a href="users.php">
                    <span class="material-icons-sharp">
                        person_outline
                    </span>
                    <h3>Users</h3>
                </a>
                <a href="food.php" >
                    <span class="material-icons-sharp">
                        fastfood
                    </span>
                    <h3>Food</h3>
                </a>
                <a href="index.php" >
                    <span class="material-icons-sharp">
                        payments
                    </span>
                    <h3>Income Analytics</h3>
                </a>
                <a href="adminacc.php" class="active">
                    <span class="material-icons-sharp">
                        account_circle
                    </span>
                    <h3>Admin Accounts</h3>
                    
                </a>
                <a href="foodorder.php">
                    <span class="material-icons-sharp">
                        shopping_cart
                    </span>
                    <h3>Food Orders</h3>
                </a>
                <a href="message.php">
                    <span class="material-icons-sharp">
                        email
                    </span>
                    <h3>Messages</h3>
                </a>
                <a href="admin-logout.php">
                    <span class="material-icons-sharp">
                        logout
                    </span>
                    <h3>Logout</h3>
                </a>
            </div>
        </aside>
        <!-- End of Sidebar Section -->


        

        <!-- Main Content -->
    <main>
           <h1>Update Password</h1>

           <?php
           
           if(isset($_GET['id']))
           {
            $id = $_GET['id'];
           }
           ?>


           <form action="" method="post" enctype="multipart/form-data">
    <div class="flex">
         

           
         <div class="inputBox">
            <span>Update Password (required)</span>
            <input type="password" class="box" required maxlength="100" placeholder="Current Password" name="current_password">
         </div>


         <div class="inputBox">
            <span>Update Password (required)</span>
            <input type="password" class="box" required maxlength="100" placeholder="New Password" name="new_password">
         </div>


         <div class="inputBox">
            <span>Update Password (required)</span>
            <input type="password" class="box" required maxlength="100" placeholder="Confirm Password" name="confirm_password">
         </div>
         


        
         


      </div>
      <input type="hidden" name="id" value="<?php echo $id;?>">
      <input type="submit" value="Update Password" class="btn" name="updatepass_admin">
   </form>

   <?php
        //check if the button is clicked or nit

        if(isset($_POST['updatepass_admin']))
        {
            $id = $_POST['id'];
            $current_passowrd = md5($_POST['current_password']);
            $new_password = md5($_POST['new_password']);
            $confirm_password = md5($_POST['confirm_password']);

            //check whether the user with current id and currrent password exist or not
            $sql = "SELECT * FROM tbl_admin WHERE id=$id && password ='$current_passowrd'";

            //executre the query

            $result = mysqli_query($conn,$sql);

            if($result==true)
            {
                $count = mysqli_num_rows($result);

                if($count==1)
                {
                    //User exist and password can be changed

                    //check whether the new password confrim and match
                    if($new_password==$confirm_password)
                    {
                        //update the password
                        $sql2 = "UPDATE tbl_admin SET password ='$new_password' WHERE id=$id";

                        //execute the query
                        $result2 = mysqli_query($conn,$sql2);

                        //check if the query executed or not
                        if($result2==true)
                        {
                            //display success messaage
                            echo '<script>
                                swal({
                                    title: "Success",
                                    text: "Successfully Update the password!",
                                    icon: "success"
                                }).then(function() {
                                    window.location = "adminacc.php";
                                });
                            </script>';
                            
                            exit; 
                        }
                        else
                        {
                            //display error message
                            echo '<script>
                            swal({
                                title: "Error",
                                text: "Failed to update password",
                                icon: "error"
                            }).then(function() {
                                window.location = "adminacc.php";
                            });
                        </script>';

                        exit;
                        }
                    }
                    else
                    {
                        //redirect to adminaccpage with error
                        echo '<script>
                    swal({
                        title: "Error",
                        text: "Password not match",
                        icon: "error"
                    }).then(function() {
                        window.location = "adminacc.php";
                    });
                </script>';

                exit;
                    }
                }
                else{
                    //user doesn't exist
                    echo '<script>
                    swal({
                        title: "Error",
                        text: "User doesnt exist",
                        icon: "error"
                    }).then(function() {
                        window.location = "adminacc.php";
                    });
                </script>';

                exit;
                }
            }
        }
   ?>


</main>
        <!-- End of Main Content -->

        <!-- Right Section -->
       <!-- Right Section -->
       <div class="right-section" >
            <div class="nav">
                <button id="menu-btn">
                    <span class="material-icons-sharp">
                        menu
                    </span>
                </button>
                <div class="dark-mode">
                    <span class="material-icons-sharp active">
                        light_mode
                    </span>
                    <span class="material-icons-sharp">
                        dark_mode
                    </span>
                </div>

                <?php
              

            if(isset($_SESSION['admin_id']))

            {
                $admin_id = $_SESSION['admin_id'];
               
            
               
                //sql query to get all data in database
                $sql2 = "SELECT * FROM tbl_admin WHERE id = $admin_id";

                //check if the query is executed or not
                $result2 = mysqli_query($conn,$sql2);

                //count rows to check if we have foods or not in database
                $count2 = mysqli_num_rows($result2);

              

                if($count2>0)
                {
                    //we have food
                    while($row1=mysqli_fetch_assoc($result2))
                    {
                        //GET THE VALUE FROM INDI COLS
                        $username = $row1['username'];
                        $image_name = $row1['image'];

                    ?>
                            <div class="profile">
                        <div class="info">
                            <p>Welcome Back: <b><?php echo $username;?></b></p>
                        </div>
                        <div class="profile-photo">
                        <?php
                                if($image_name=="")
                                {
                                    // we don't have image 
                                    echo '<script>
                                        swal({
                                            title: "Error",
                                            text: "Food image not available",
                                            icon: "error"
                                        }).then(function() {
                                            window.location = "food.php";
                                        });
                                    </script>';
                                    exit;
                                }
                                else
                                {

                                    //we have image
                                    ?>

                                        <img src="images/admin/<?php echo $image_name?>" >

                                    <?php
                                }

                                ?>
                        </div>
                        </div>

                        <?php

                                

                        
                    }

                   
                
                
                
                }
                else
                {
                     //we don't have admin
                   
                     echo '<script>
                     swal({
                         title: "Error",
                         text: "Admin not available",
                         icon: "error"
                     }).then(function() {
                         window.location = "adminacc.php";
                     });
                 </script>';
                 exit;
                }

            }

                        ?>

                    


            </div>
            <!-- End of Nav -->

           

            </div>

        </div>

    


    <script src="index.js"></script>
</body>

</html>



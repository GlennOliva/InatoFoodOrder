<?php include('config/dbcon.php');
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
    <link rel="icon" href="images/inatologo.png" type="image/x-icon">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
                <a href="food.php" class="active" >
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
                <a href="adminacc.php">
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
           <h1>Add Food</h1>


           <form action="" method="post" enctype="multipart/form-data">
      <div class="flex">
         <div class="inputBox">
            <span>Food name (required)</span>
            <input type="text" class="box" required maxlength="100" placeholder="enter food name" name="food_name">
         </div>
         <div class="inputBox">
            <span>Food price (required)</span>
            <input type="number" min="0" class="box" required max="9999999999" placeholder="enter product price" onkeypress="if(this.value.length == 10) return false;" name="price">
         </div>
        <div class="inputBox">
            <span>image 01 (required)</span>
            <input type="file" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
        </div>
         <div class="inputBox">
            <span>Food details (required)</span>
            <textarea name="details" placeholder="enter product details" class="box" required maxlength="500" cols="30" rows="5"></textarea>
         </div>

         <div class="inputBox">
            <label for="category" style="font-size: 16px; ">Category:</label>
            <select id="category" name="category" required>
               <option value="" selected disabled>Select category</option>
               <option value="fried">Fried</option>
               <option value="grilled">Grilled</option>
               <option value="soup">Soup</option>
               <option value="drinks">Drinks</option>
               <option value="desert">Desert</option>
            </select>
         </div>

         <div class="inputBox">
            <span>Stock quantity (required)</span>
            <input type="number" min="0" class="box" required max="9999999999" placeholder="enter stock quantity" onkeypress="if(this.value.length == 10) return false;" name="stock_quantity">
         </div>



      </div>
      
      <input type="submit" value="add food" class="btn" name="add_food">
   </form>


   <?php
   
        if(isset($_POST['add_food']))
        {
            //get data from form
            $food_name = $_POST['food_name'];
            $price = $_POST['price'];
            $details = $_POST['details'];
            $category = $_POST['category'];
            $stock = $_POST['stock_quantity'];

            //upload the image if selected
            if(isset($_FILES['image_01']['name']))
            {
                //get the details of the selected image
                $image_name = $_FILES['image_01']['name'];

                //check if the imaage selected or not.
                if ($image_name != "") {
                    // Image is selected
                    // Rename the image
                    $ext_parts = explode('.', $image_name);
                    $ext = end($ext_parts);
                
                    // Create a new name for the image
                    $image_name = "Food-Inato-" . rand(0000, 9999) . "." . $ext;
                
                    // Upload the image
                
                    // Get the src path and destination path
                
                    // Source path is the current location of the image
                    $src = $_FILES['image_01']['tmp_name'];
                
                    // Destination path for the image to be uploaded
                    $destination = "images/food/" . $image_name;
                
                    // Upload the food image
                    $upload = move_uploaded_file($src, $destination);
                
                    // Check if the image uploaded or not
                    if ($upload == false) {
                        // Failed to upload the image
                        echo '<script>
                            swal({
                                title: "Error",
                                text: "Failed to upload image",
                                icon: "error"
                            }).then(function() {
                                window.location = "add-food.php";
                            });
                        </script>';
                
                        die();
                        exit;
                    } else {
                        // Image uploaded successfully
                    }
                }
                

            }
            else
            {
                $image_name = ""; 
            }


            //insert data to database
            $sql = "INSERT INTO tbl_food SET name = '$food_name' , details = '$details' , price = $price , category = '$category'
            , image = '$image_name' , stock = $stock
            ";

            //execute the query
            $result = mysqli_query($conn,$sql);

            //check if the data is inserted or not
            if($result==TRUE)
            {
                //DATA inserted successfully
                echo '<script>
                swal({
                    title: "Success",
                    text: "Food Successfully Inserted",
                    icon: "success"
                }).then(function() {
                    window.location = "food.php";
                });
            </script>';

            exit;
            }
            else
            {
                //failed to insert data
                echo '<script>
                        swal({
                            title: "Error",
                            text: "Failed to insert food",
                            icon: "error"
                        }).then(function() {
                            window.location = "add-food.php";
                        });
                    </script>';
                    exit;
            }

            //redorect with success and error message

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


    </div>


    <script src="index.js"></script>
</body>

</html>
<?php
include('config/dbcon.php');

session_start();

//check if id is set or not
if(isset($_GET['id']))
{
    //get all the details
    $id = $_GET['id'];

    //sql query to get the selected food
    $sql = "SELECT * FROM tbl_food WHERE id = $id";

    //execute the query
    $result = mysqli_query($conn,$sql);

    //get the value based on query executed
    $row = mysqli_fetch_assoc($result);

    //get the individuals values of selected food
    $food_name = $row['name'];
    $details = $row['details'];
    $price = $row['price'];
    $current_image = $row['image'];
    $category = $row['category'];
    $stock = $row['stock'];
}
else
{
    //redirect to food.php
    echo '<script>
                    swal({
                        title: "Error",
                        text: "food Failed to  Update",
                        icon: "error"
                    }).then(function() {
                        window.location = "food.php";
                    });
                </script>';

                exit;
}


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
                <a href="food.php" class="active">
                    <span class="material-icons-sharp">
                        fastfood
                    </span>
                    <h3>Food</h3>
                </a>
                <a href="index.php"  >
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
           <h1>Update Food</h1>

          


           <form action="" method="post" enctype="multipart/form-data">
      <div class="flex">

      <div class="dummy-image" >
        <?php

  
    
            if($current_image == "")
            {
                //image not available
                echo '<script>
                swal({
                    title: "Error",
                    text: "Image not available",
                    icon: "error"
                }).then(function() {
                    window.location = "food.php";
                });
            </script>';

            exit;

            }
            else
            {
                //image available
                ?>
                    <img src="images/food/<?php echo $current_image;?>" style="width: 30%;">

                <?php
            }
        
        ?>
        

    
    </div>

     
         <div class="inputBox">
            <span>Update product name (required)</span>
            <input type="text" class="box" required maxlength="100" placeholder="enter product name" name="name" value="<?php echo $food_name;?>">
         </div>
         <div class="inputBox">
            <span>Update product price (required)</span>
            <input type="number" min="0" class="box" required max="9999999999" placeholder="enter product price" onkeypress="if(this.value.length == 10) return false;" name="price" value="<?php echo $price;?>">
         </div>
        <div class="inputBox">
            <span>Update image 01 (required)</span>
            <input type="file" name="image" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
        </div>
         <div class="inputBox">
            <span>Update product details (required)</span>
            <textarea name="details" placeholder="enter product details" class="box" required maxlength="500" cols="30" rows="10"><?php echo $details;?></textarea>
         </div>

         <div class="inputBox">
    <label for="category" style="font-size: 16px;">Update Category:</label>
    <select id="category" name="category" required>
        <option value="" selected disabled>Select category</option>
        <option value="fried" <?php if ($category === 'fried') echo 'selected'; ?>>Fried</option>
        <option value="grilled" <?php if ($category === 'grilled') echo 'selected'; ?>>Grilled</option>
        <option value="soup" <?php if ($category === 'soup') echo 'selected'; ?>>Soup</option>
        <option value="drinks" <?php if ($category === 'drinks') echo 'selected'; ?>>Drinks</option>
        <option value="desert" <?php if ($category === 'desert') echo 'selected'; ?>>Dessert</option>
    </select>
</div>


         <div class="inputBox">
            <span>Update stock quantity (required)</span>
            <input type="number" min="0" class="box" required max="9999999999" placeholder="enter stock quantity" onkeypress="if(this.value.length == 10) return false;" name="stock_quantity" value="<?php echo $stock;?>">
         </div>



      </div>
      <input type="hidden" name="id" value="<?php echo $id;?>">
      <input type="hidden" name="current_image" value="<?php echo $current_image;?>">
      <input type="submit" value="Update Food" class="btn" name="update_food">
   </form>


   <?php
   
            if(isset($_POST['update_food']))
            {
                //get all the details from form
                $id = $_POST['id'];
                $food_name = $_POST['name'];
                $details = $_POST['details'];
                $price = $_POST['price'];
                $current_image = $_POST['current_image'];
                $category = $_POST['category'];
                $stock = $_POST['stock_quantity'];

                //uploadt the image if selected
                
                //check whether upload button is click or not
                if(isset($_FILES['image']['name']))
                {
                    $image_name = $_FILES['image']['name']; //new image nname

                    //check if the file is available or not
                    if($image_name!="")
                    {
                        //image is available

                        //rename the image
                        $ext = end(explode('.', $image_name));
                        $image_name = "Food-Inato-".rand(0000, 9999).'.'.$ext;

                        //get the source path and destination
                        $src_path = $_FILES['image']['tmp_name'];
                        $destination_path = "images/food/".$image_name;

                        //upload the image
                        $upload = move_uploaded_file($src_path,$destination_path);

                        //check if the image is uploaded or not
                        if($upload==false)
                        {
                            //failed to upload
                            echo '<script>
                            swal({
                                title: "Error",
                                text: "Failed to upload image",
                                icon: "error"
                            }).then(function() {
                                window.location = "food.php";
                            });
                        </script>';

                        exit;

                                        
                        }
                        //remove the current image if available
                        if($current_image!="")
                        {
                            //current image is available
                            $remove_path = "images/food/".$current_image;

                            $remove = unlink($remove_path);

                            //check whether the image is remove or not
                            if($remove==false)
                            {
                                //failed to remove current image
                                echo '<script>
                                swal({
                                    title: "Error",
                                    text: "Failed to remove current image",
                                    icon: "error"
                                }).then(function() {
                                    window.location = "food.php";
                                });
                            </script>';
    
                            exit;
    
                                
                            }
                        }
                    }
                }
                else
                {
                    $image_name = $current_image;
                }


                //update the food in database
                $sql2 = "UPDATE tbl_food SET name = '$food_name'
                , details = '$details' , price = $price , image = '$image_name' , category = '$category' , stock = $stock WHERE id = $id";

                //execute the sql query
                $result2 = mysqli_query($conn,$sql2);

                //check if the query is executed or not
                if($result2==true)
                {
                    //query executed and food updated successfully
                    echo '<script>
                    swal({
                        title: "Success",
                        text: "Food Successfully Update",
                        icon: "success"
                    }).then(function() {
                        window.location = "food.php";
                    });
                </script>';

                exit;


  
                }
                else
                {
                    //failed to update
                    echo '<script>
                    swal({
                        title: "Error",
                        text: "Failed to update",
                        icon: "error"
                    }).then(function() {
                        window.location = "food.php";
                    });
                </script>';

                exit;

                   
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
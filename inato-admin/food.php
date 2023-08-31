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
    <link rel="icon" href="images/inatologo.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        <main id="admin_table">
           <h1>Food</h1>


           <div class="btn-add">
            <a href="add-food.php" class="btn1"><i class="material-icons-sharp">add_circle</i> Add Food </a>
            </div>

            
           <table>
            
            <thead>
               
                <tr>
                    <th>Id #</th>
                    <th>Food Name</th>
                    <th>Food Price</th>
                    <th>Image</th>
                    <th>Product Details</th>
                    <th>Category</th>
                    <th>Stock quantity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>

            <?php
            // Define the number of records per page
            $recordsPerPage = 5;

            // SQL query to get the total count of records
            $countQuery = "SELECT COUNT(*) AS count FROM tbl_food";
            $countResult = mysqli_query($conn, $countQuery);
            $countRow = mysqli_fetch_assoc($countResult);
            $totalRecords = $countRow['count'];

            // Calculate the total number of pages
            $totalPages = ceil($totalRecords / $recordsPerPage);

            // Get the current page number from the URL
            $current_page = isset($_GET['page']) ? $_GET['page'] : 1;

            // Calculate the starting record for the current page
            $startFrom = ($current_page - 1) * $recordsPerPage;

            // Modify the SQL query to include LIMIT and OFFSET
            $sql = "SELECT * FROM tbl_food LIMIT $startFrom, $recordsPerPage";
            $result = mysqli_query($conn, $sql);

            $ids = ($current_page - 1) * $recordsPerPage + 1;

            if ($totalRecords > 0) {
                //we have food
                while ($row = mysqli_fetch_assoc($result)) {
                    //GET THE VALUE FROM INDIVIDUAL COLUMNS
                    $id = $row['id'];
                    $food_name = $row['name'];
                    $price = $row['price'];
                    $image_name = $row['image'];
                    $details = $row['details'];
                    $category = $row['category'];
                    $stock = $row['stock'];

                    ?>

                    <tr>
                        <td><?php echo $ids++;?></td>
                        <td><?php echo $food_name;?></td>
                        <td><?php echo $price;?></td>
                        <td class="food-image">
                            <?php
                                if ($image_name == "") {
                                    // we don't have an image
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
                                } else {

                                    //we have an image
                                    ?>

                                    <img src="images/food/<?php echo $image_name?>" style="width: 70px;">

                                    <?php
                                }
                            ?>
                        </td>
                        <td><?php echo $details;?></td>
                        <td><?php echo $category;?></td>
                        <td><?php echo $stock;?></td>
                        <td>
                            <div class="btn-group">
                                <a href="update-food.php?id=<?php echo $id;?>" class="btn"><i class="material-icons-sharp">edit</i> Update</a>

                                <form action="code.php" method="POST">
                                    <button type="button" class="btn-del delete_foodbtn" value="<?= $id;?>"><i class="material-icons-sharp">delete</i> Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
            <?php
        }
} else {
    //we don't have food in the database

    echo '<script>
        swal({
            title: "Error",
            text: "Food not available",
            icon: "error"
        }).then(function() {
            window.location = "food.php";
        });
    </script>';
    exit;
}
?>
                
                
            </tbody>

            

              
        </table>

        <!-- Pagination links with styling -->
        <div class="pagination">
    <?php if ($current_page > 1) : ?>
        <a href="food.php?page=<?php echo $current_page - 1; ?>" class="pagination-link">&laquo; Prev</a>
    <?php endif; ?>
    
    <?php for ($page = 1; $page <= $totalPages; $page++) : ?>
        <a href="food.php?page=<?php echo $page; ?>" class="pagination-link <?php if ($page == $current_page) echo 'active'; ?>">
            <?php echo $page; ?>
        </a>
    <?php endfor; ?>
    
    <?php if ($current_page < $totalPages) : ?>
        <a href="food.php?page=<?php echo $current_page + 1; ?>" class="pagination-link">Next &raquo;</a>
    <?php endif; ?>
</div>


        

        

      

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
    <script src="js/food-custom.js"></script>
</body>

</html>
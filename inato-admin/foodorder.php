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
                <a href="foodorder.php" class="active">
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
           <h1>Food Order</h1>
            

           <table class="tbl-user">
            
            <thead>
               
                <tr>
                    <th>ID:</th>
                    <th>placed on:</th>
                    <th>Name</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                    <th>Total Products</th>
                    <th>Total Price</th>
                    <th>Payment Method</th>
                    <th>Order Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php
// Define the number of records per page
$recordsPerPage = 5;

// SQL query to get the total count of records
$countQuery = "SELECT COUNT(*) AS count FROM tbl_foodorder";
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
$foodorderquery = "SELECT * FROM tbl_foodorder LIMIT $startFrom, $recordsPerPage";
$res = mysqli_query($conn, $foodorderquery);
$count = mysqli_num_rows($res);

$ids = ($current_page - 1) * $recordsPerPage + 1;

if ($count > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        $id = $row['id'];
        $name = $row['name'];
        $number = $row['number'];
        $email = $row['email'];
        $method = $row['method'];
        $address = $row['address'];
        $total_products = $row['total_products'];
        $total_price = $row['total_price'];
        $place_on1 = $row['place_on'];
        $payment_status = $row['payment_status'];

        $payment_status_class = '';
        if ($payment_status == 'delivered') {
            $payment_status_class = 'green';
        } elseif ($payment_status == 'cancel') {
            $payment_status_class = 'red';
        } elseif ($payment_status == 'pending') {
            $payment_status_class = 'brown';
        } elseif ($payment_status == 'on_delivery') {
            $payment_status_class = 'orange';
        }
        ?>
        <tr>
            <td><?php echo $ids; ?></td>
            <td><?php echo $place_on1; ?></td>
            <td><?php echo $name; ?></td>
            <td><?php echo $number; ?></td>
            <td><?php echo $address; ?></td>
            <td><?php echo $total_products; ?></td>
            <td><?php echo $total_price; ?></td>
            <td><?php echo $method; ?></td>
            <td class="<?php echo $payment_status_class; ?>"><?php echo $payment_status; ?></td>
            <td class="tbl-30">
                <div class="btn-group1">
                    <a href="update-foodorder.php?id=<?php echo $id; ?>" class="btn"><i class="material-icons-sharp">edit</i> Update</a>
                    <a class="btn-del" style="visibility: hidden;"><i class="material-icons-sharp">delete</i> Delete</a>
                </div>
            </td>
        </tr>
        <?php
        // Increment ids for the next row
        $ids++;
    }
} else {
    echo 'No food items found.';
}
?>





                    
          
                
            </tbody>
        </table>

          <!-- Pagination links with styling -->
          <div class="pagination">
    <?php if ($current_page > 1) : ?>
        <a href="foodorder.php?page=<?php echo $current_page - 1; ?>" class="pagination-link">&laquo; Prev</a>
    <?php endif; ?>
    
    <?php for ($page = 1; $page <= $totalPages; $page++) : ?>
        <a href="foodorder.php?page=<?php echo $page; ?>" class="pagination-link <?php if ($page == $current_page) echo 'active'; ?>">
            <?php echo $page; ?>
        </a>
    <?php endfor; ?>
    
    <?php if ($current_page < $totalPages) : ?>
        <a href="foodorder.php?page=<?php echo $current_page + 1; ?>" class="pagination-link">Next &raquo;</a>
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


    </div>


    <script src="index.js"></script>
</body>

</html>
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
    <link rel="icon" href="images/inatologo.png" type="image/x-icon">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <title>Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                <a href="dashboard.php" class="active">
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
                <a href="index.php">
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
            <h1>Dashboard</h1>

            <?php
                  $salesquery = "SELECT * FROM tbl_foodorder WHERE payment_status = 'delivered'";
                  $res1 = mysqli_query($conn, $salesquery);
                  $count1 = mysqli_num_rows($res1);
                  $ids = 1;
                  $total_sales = 0; // Initialize the total sales variable

                  if($count1>0)
                  {
                    while ($row = mysqli_fetch_assoc($res1))
                    {
                        $total_price1 = $row['total_price'];
                        $total_sales += $total_price1;
                    }
                  }
            
            ?>
        
            <div class="analyse">
                <div class="sales">
                    <div class="status">
                        <div class="info">
                            <h3>Total Sales</h3>
                            <h1 style="padding-left: 10px;">₱ <?php echo $total_sales;?></h1>
                        </div>
                        <div class="progresss">
                            <span class="material-icons-sharp" style="vertical-align: middle; padding-top: 25%; font-size: 4rem;">local_atm</span>
                            <!-- Your progress bar or other content here -->
                        </div>
                    </div>


                    <?php
                  $orderquery = "SELECT COUNT(*) AS delivered_order_count FROM tbl_foodorder";
                  $res2 = mysqli_query($conn, $orderquery);
                  $ids = 1;
                  $row = mysqli_fetch_assoc($res2);
                  $count_delivered_orders = $row['delivered_order_count'];
            
            ?>
                    
                </div>
                <div class="visits">
                    <div class="status">
                        <div class="info">
                            <h3>Total Orders</h3>
                            <h1 style="padding-left: 20px;"><?php echo $count_delivered_orders;?></h1>
                        </div>
                        <div class="progresss">
                            <span class="material-icons-sharp" style="vertical-align: middle; padding-top: 25%; font-size: 4rem;">shopping_cart</span>
                            <!-- Your progress bar or other content here -->
                        </div>
                    </div>
                </div>

                <?php
                  $userquery = "SELECT COUNT(*) AS User FROM tbl_user";
                  $res3 = mysqli_query($conn, $userquery);
                  $ids = 1;
                  $row = mysqli_fetch_assoc($res3);
                  $User = $row['User'];
            
            ?>


                <div class="searches">
                    <div class="status">
                        <div class="info">
                            <h3>Users</h3>
                            <h1 style="padding-left: 20px;"><?php echo $User;?></h1>
                        </div>
                        <div class="progresss">
                            <span class="material-icons-sharp" style="vertical-align: middle; padding-top: 25%; font-size: 4rem;">group</span>
                            <!-- Your progress bar or other content here -->
                        </div>
                    </div>
                </div>

</div>


<?php

    $sql = "SELECT category, SUM(stock) AS total_stock FROM tbl_food GROUP BY category";
    $result = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_array($result))
    {
        $category[] = $row['category'];
        $stock[] = $row['total_stock'];
    }

    $sql1 = "SELECT * FROM tbl_foodorder WHERE payment_status = 'delivered'";
    $result1 = mysqli_query($conn, $sql1);

    $incomeByMonth = array();

    while ($row2 = mysqli_fetch_array($result1)) {
        $total_price = $row2['total_price'];
        $place_on = date("F", strtotime($row2['place_on']));

        if (!isset($incomeByMonth[$place_on])) {
            $incomeByMonth[$place_on] = 0;
        }
        $incomeByMonth[$place_on] += $total_price;
    }


?>




                    <!--- BARGRAPHS HERE!-->
                    <div class="graphbox">
                        <div class="box">
                            <canvas id="myChart"></canvas>
                        </div>
                        <div class="box">
                            <canvas id="earnings"></canvas>
                        </div>
                    </div>


                    <script>
                            const ctx = document.getElementById('myChart');
                            const earning = document.getElementById('earnings');

                    new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: <?php echo json_encode($category);?>,
                        datasets: [{
                        label: '# of Food',
                        data: <?php echo json_encode($stock);?>,
                        backgroundColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(255, 205, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            
                        ],
                        borderColor: [
                            'rgb(255, 99, 132)',
                            'rgb(255, 159, 64)',
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)',
                        
                        ],
                        borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                    }
                    });


                    new Chart(earning, {
                        type: 'bar',
                        data: {
                        labels: <?php echo json_encode(array_keys($incomeByMonth)); ?>,
                        datasets: [{
                            label: 'Income Analytics Bar Chart',
                            data: <?php echo json_encode(array_values($incomeByMonth)); ?>,
                            backgroundColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 205, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(201, 203, 207, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(201, 203, 207, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(153, 102, 255, 1)'
                        
                            
                            ],
                            
                            borderWidth: 1
                        }]
                        },
                        options: {
                        responsive: true,
                        }
                    });
                        </script>


                    <!----GRAPHS END HERE!-->


                   <!-- Recent Orders Table -->
        <div class="recent-orders">
            <h2>Recent Orders</h2>
            <table>
                <thead>
                    <tr id="tblrow">
                        <th>ID</th>
                        <th>Name:</th>
                        <th>Phone Number:</th>
                        <th>Email</th>
                        <th>Method</th>
                        <th>Address</th>
                        <th>Total Food</th>
                        <th>Total Price</th>
                        <th>Place_on</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>


                <?php
$limit = 5; // Set the number of records to display

$foodorderquery = "SELECT * FROM tbl_foodorder LIMIT $limit";
$res = mysqli_query($conn, $foodorderquery);
$count = mysqli_num_rows($res);
$ids = 1;

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
        } elseif ($payment_status == 'cancel_order') {
            $payment_status_class = 'red';
        } elseif ($payment_status == 'pending') {
            $payment_status_class = 'brown';
        } elseif ($payment_status == 'on_delivery') {
            $payment_status_class = 'orange';
        }

        echo '<tr>
                <td>' . $ids++ . '</td>
                <td>' . $name . '</td>
                <td>' . $number . '</td>
                <td>' . $email . '</td>
                <td>' . $method . '</td>
                <td>' . $address . '</td>
                <td>' . $total_products . '</td>
                <td>' . $total_price . '</td>
                <td>' . $place_on1 . '</td>
                <td class="' . $payment_status_class . '">' . $payment_status . '</td>
            </tr>';
    }

    echo '</tbody>
        </table>
        <a href="foodorder.php">Show All</a>';
} else {
    echo 'No food items found.';
}
?>

   
        </div>

       
        <!-- End of Recent Orders -->


    
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
    <script src="chart.js"></script>

    
</body>

</html>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                <a href="message.php" class="active">
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
           <h1>Message</h1>

           <div class="print-btn-container">
            <form method="POST" class="dateform">
                <label for="from_date" class="from_date" >From Date:</label>
                <input type="date" id="from_date" name="from_date">
                <label for="to_date" class="to_date">To Date:</label>
                <input type="date" id="to_date" name="to_date">
                <input type="submit" name="submit" value="Filter">
            </form>
        
            
            </div>
            

           <table class="tbl-user">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>User ID:</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Number</th>
                    <th>Message</th>
                    <th>Date</th>
                    <th>Actions</th>

                </tr>
            </thead>
            <tbody>
            <?php
// ... (Your existing code)

if (isset($_POST['submit'])) {
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];

    // Create SQL query for filtered messages within the selected date range
    $sql = "SELECT * FROM tbl_message WHERE datetime BETWEEN '$from_date 00:00:00' AND '$to_date 23:59:59'";
} else {
    // Default SQL query to get all messages
    $sql = "SELECT * FROM tbl_message";
}

// Execute the SQL query
$result = mysqli_query($conn, $sql);

$ids = 1;
$count = mysqli_num_rows($result);

if ($count > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $user_id = $row['user_id'];
        $name = $row['name'];
        $email = $row['email'];
        $number = $row['number'];
        $msg = $row['message'];
        $datetime = $row['datetime'];

        // Display each message
        echo '<tr>';
        echo '<td>' . $ids++ . '</td>';
        echo '<td>' . $user_id . '</td>';
        echo '<td>' . $name . '</td>';
        echo '<td>' . $email . '</td>';
        echo '<td>' . $number . '</td>';
        echo '<td>' . $msg . '</td>';
        echo '<td>' . $datetime . '</td>';
        echo '<td>';
        echo '<div class="btn-group">';
        echo '<form action="code.php" method="POST">';
        echo '<button type="button" class="btn-del delete_msgbtn" value="' . $id . '"><i class="material-icons-sharp">delete</i> Delete</button>';
        echo '</form>';
        echo '</div>';
        echo '</td>';
        echo '</tr>';
    }
} else {
    // No messages found within the selected date range or in general
    echo '<tr><td colspan="8">No messages found.</td></tr>';
}
?>


               
                
                <!-- You can add more rows with dummy data here -->
            </tbody>
        </table>

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
    <script src="js/message-custom.js"></script>
</body>

</html>
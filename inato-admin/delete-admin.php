<head>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>


<?php
include('config/dbcon.php');

// Get the id of admin to delete
$id = $_GET['id'];

// Create SQL query to delete admin
$sql = "DELETE FROM tbl_admin WHERE id = $id";

// Execute the query
$result = mysqli_query($conn, $sql);

if ($result) {
    // Query executed successfully
    echo '<script>
    document.addEventListener("DOMContentLoaded", function () {
      swal({
          title: "Are you sure?",
          text: "Once deleted, you will not be able to recover this admin account",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            swal("Poof! Admin account has been deleted!", {
              icon: "success",
            }).then(() => {
              // Redirect to adminacc.php
              window.location.href = "adminacc.php";
            });
          } else {
            swal("Admin account is safe!");
          }
        });
    });
    </script>';
} else {
    // Query not executed successfully
    echo '<script>
    document.addEventListener("DOMContentLoaded", function () {
      swal({
          title: "Error",
          text: "Admin Failed to delete",
          icon: "error"
      }).then(function() {
          window.location = "adminacc.php";
      });
    });
    </script>';
}

// Redirect to adminacc.php with message
exit;
?>

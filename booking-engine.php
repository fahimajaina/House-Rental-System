<?php 
include("config.php");

if (isset($_POST['book_property'])) {

    // Check if user is logged in
    if (isset($_SESSION["email"])) {
        $u_email = $_SESSION["email"];
        $property_id = $_GET['property_id'];

        // Prepare the SQL query to get tenant information based on email
        $sql = "SELECT * FROM tenant WHERE email = ?";
        if ($stmt = mysqli_prepare($db, $sql)) {
            mysqli_stmt_bind_param($stmt, 's', $u_email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                // Fetch the tenant details
                $tenant = mysqli_fetch_assoc($result);
                $tenant_id = $tenant['tenant_id'];

                // Update the property to be booked
                $sql1 = "UPDATE add_property SET availability_status = 'Not Available' WHERE property_id = ?";
                if ($stmt1 = mysqli_prepare($db, $sql1)) {
                    mysqli_stmt_bind_param($stmt1, 'i', $property_id);
                    mysqli_stmt_execute($stmt1);
                }

                // Insert the booking into the booking table
                $sql2 = "INSERT INTO booking (property_id, tenant_id) VALUES (?, ?)";
                if ($stmt2 = mysqli_prepare($db, $sql2)) {
                    mysqli_stmt_bind_param($stmt2, 'ii', $property_id, $tenant_id);
                    mysqli_stmt_execute($stmt2);

                    // If booking is successful, display success message
                    if (mysqli_stmt_affected_rows($stmt2) > 0) {
                        // Display success message
                        echo "
                        <style>
                            .alert {
                                padding: 20px;
                                background-color: #DC143C;
                                color: white;
                            }
                            .closebtn {
                                margin-left: 15px;
                                color: white;
                                font-weight: bold;
                                float: right;
                                font-size: 22px;
                                line-height: 20px;
                                cursor: pointer;
                                transition: 0.3s;
                            }
                            .closebtn:hover {
                                color: black;
                            }
                        </style>
                        <script>
                            window.setTimeout(function() {
                                document.querySelector('.alert').style.display = 'none';
                            }, 2000);
                        </script>
                        <div class='container'>
                            <div class='alert' role='alert'>
                                <span class='closebtn' onclick='this.parentElement.style.display=\"none\";'>&times;</span> 
                                <center><strong>Thank you for booking this property. Please visit the property location to view it personally..</strong></center>
                            </div>
                        </div>";
                    }
                }
            } else {
                // Tenant not found, handle the error
                echo "<p>User not found!</p>";
            }
            // Close the statements
            mysqli_stmt_close($stmt);
            mysqli_stmt_close($stmt1);
            mysqli_stmt_close($stmt2);
        } else {
            echo "<p>Error in preparing the SQL query!</p>";
        }
    }
}
?> 

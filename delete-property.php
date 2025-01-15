<?php 
$property_id = '';
include("config.php");

if (isset($_POST['delete_property'])) {
    delete_property();
}

function delete_property() {
    global $db, $property_id;

    // Retrieve the property_id from the POST data
    $property_id = $_POST['property_id'];

    // Delete related photos from property_photo table
    $sql = "DELETE FROM property_photo WHERE property_id='$property_id'";
    $query = mysqli_query($db, $sql);

    if ($query) {
        // Delete related reviews from review table
        $sql2 = "DELETE FROM review WHERE property_id='$property_id'";
        $query2 = mysqli_query($db, $sql2);

        // Delete any bookings related to this property from booking table
        $sql4 = "DELETE FROM booking WHERE property_id='$property_id'";
        $query4 = mysqli_query($db, $sql4);

        // Now delete the property from add_property table
        $sql3 = "DELETE FROM add_property WHERE property_id='$property_id'";
        $query3 = mysqli_query($db, $sql3);

        if ($query3) {
            ?>

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
                $(".alert").fadeTo(1000, 0).slideUp(500, function(){
                    $(this).remove(); 
                });
            }, 2000);
            </script>
            <div class="container">
            <div class="alert" role='alert'>
              <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
              <center><strong>Your Property has been deleted.</strong></center>
            </div></div>

            <?php
        }
    }
}
?>

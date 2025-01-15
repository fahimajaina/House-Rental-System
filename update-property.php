<?php
// Include database connection
include('config.php');
session_start();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get form data
    $property_id = $_POST['property_id'];
    $country = $_POST['country'];
    $division = $_POST['division'];
    $district = $_POST['district'];
    $city = $_POST['city'];
    $rural_urban = $_POST['rural_urban'];
    $address = $_POST['address'];
    $contact_no = $_POST['contact_no'];
    $property_type = $_POST['property_type'];
    $rent = $_POST['rent'];
    $total_rooms = $_POST['total_rooms'];
    $bedroom = $_POST['bedroom'];
    $living_room = $_POST['living_room'];
    $kitchen = $_POST['kitchen'];
    $bathroom = $_POST['bathroom'];
    $availability_status = $_POST['availability_status'];

    // Prepare SQL statement to update property details
    $sql = "UPDATE add_property 
            SET country = ?, division = ?, district = ?, city = ?, rural_urban = ?, address = ?, contact_no = ?, property_type = ?, rent = ?, total_rooms = ?, bedroom = ?, living_room = ?, kitchen = ?, bathroom = ?, availability_status = ? 
            WHERE property_id = ?";

    // Prepare the statement
    $stmt = mysqli_prepare($db, $sql);

    // Check if the statement is prepared successfully
    if ($stmt === false) {
        die('Error preparing the SQL statement: ' . mysqli_error($db));
    }

    // Bind parameters (match type string and the number of fields)
    mysqli_stmt_bind_param($stmt, 'ssssssssssiiiiii', 
                           $country, $division, $district, $city, $rural_urban, 
                           $address, $contact_no, $property_type, $rent, 
                           $total_rooms, $bedroom, $living_room, $kitchen, 
                           $bathroom, $availability_status, $property_id);

    // Execute the query
    if (mysqli_stmt_execute($stmt)) {
        show_success_message("Property updated successfully!");
        header("location:owner-index.php");
    } else {
        show_error_message("Error updating property: " . mysqli_error($db));
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}



//  function to show error message
function show_error_message($message) {
    return "<div class='alert' style='background-color: #DC143C; color: white; padding: 10px; border-radius: 5px;'>
                <strong>$message</strong>
            </div>";
}

// function to show success message
function show_success_message($message) {
    return "<div class='alert' style='background-color: #4CAF50; color: white; padding: 10px; border-radius: 5px;'>
                <strong>$message</strong>
            </div>";
}
?>

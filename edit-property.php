<?php
// Include database connection
include('config.php');
session_start();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Get property_id from the URL
if (isset($_GET['property_id'])) {
    $property_id = $_GET['property_id'];

    // Query to fetch property details based on property_id
    $sql = "SELECT * FROM add_property WHERE property_id = ?";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, "i", $property_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if (mysqli_num_rows($result) > 0) {
        $property = mysqli_fetch_assoc($result);
    } else {
        echo "Property not found!";
        exit();
    }
    mysqli_stmt_close($stmt);
} else {
    echo "Invalid property ID.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Property</title>
    <!-- Bootstrap CDN for styling -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f4f9;
            font-family: Arial, sans-serif;
        }

        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .header {
            background-color: #007bff;
            color: white;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            text-align: center;
        }

        h3 {
            color: white;
            margin-bottom: 0;
        }

        label {
            font-weight: bold;
        }

        input[type="text"], input[type="number"], input[type="submit"], .cancel-btn {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        input[type="submit"] {
            background-color: green;
            color: white;
            border: none;
        }

        input[type="submit"]:hover {
            background-color: darkgreen;
            cursor: pointer;
        }

        .cancel-btn {
            background-color: #f44336;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 14px;
            padding: 10px;
            text-align: center;
            border-radius: 4px;
        }

        .cancel-btn:hover {
            background-color: #d32f2f;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 form-container">
            <!-- Header with background color -->
            <div class="header">
                <h3>Edit Property</h3>
            </div>
            
            <form method="POST" action="update-property.php">
                <input type="hidden" name="property_id" value="<?php echo $property['property_id']; ?>">

                <div class="form-group">
                    <label for="country">Country:</label>
                    <input type="text" name="country" class="form-control" value="<?php echo $property['country']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="division">Division:</label>
                    <input type="text" name="division" class="form-control" value="<?php echo $property['division']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="district">District:</label>
                    <input type="text" name="district" class="form-control" value="<?php echo $property['district']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="city">City:</label>
                    <input type="text" name="city" class="form-control" value="<?php echo $property['city']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="rural_urban">Rural/Urban:</label>
                    <input type="text" name="rural_urban" class="form-control" value="<?php echo $property['rural_urban']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="address">Address:</label>
                    <input type="text" name="address" class="form-control" value="<?php echo $property['address']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="contact_no">Contact No.:</label>
                    <input type="text" name="contact_no" class="form-control" value="<?php echo $property['contact_no']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="property_type">Property Type:</label>
                    <input type="text" name="property_type" class="form-control" value="<?php echo $property['property_type']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="rent">Rent:</label>
                    <input type="text" name="rent" class="form-control" value="<?php echo $property['rent']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="total_rooms">Total Rooms:</label>
                    <input type="number" name="total_rooms" class="form-control" value="<?php echo $property['total_rooms']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="bedroom">Bedroom:</label>
                    <input type="number" name="bedroom" class="form-control" value="<?php echo $property['bedroom']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="living_room">Living Room:</label>
                    <input type="number" name="living_room" class="form-control" value="<?php echo $property['living_room']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="kitchen">Kitchen:</label>
                    <input type="number" name="kitchen" class="form-control" value="<?php echo $property['kitchen']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="bathroom">Bathroom:</label>
                    <input type="number" name="bathroom" class="form-control" value="<?php echo $property['bathroom']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="availability_status">Availability Status:</label>
                    <input type="text" name="availability_status" class="form-control" value="<?php echo $property['availability_status']; ?>" required>
                </div>

                <div class="button-container">
                    <input type="submit" class="btn btn-success" value="Update Property">
                    <button type="button" class="btn cancel-btn" onclick="window.location.href='owner-index.php';">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS (Optional) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

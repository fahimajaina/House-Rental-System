<?php 
include("config.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  max-width: 100%;
  min-width: 100%;
  margin: auto;
  text-align: center;
  font-family: arial;
  display: inline;
}

.card:hover {
  box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
  opacity: 0.8;
}

.container {
  padding: 2px 16px;
}

.btn {
  width: 100%;
}

.image {
  min-width: 100%;
  min-height: 200px;
  max-width: 100%;
  max-height:200px;
}
</style>
</head>
<body>

<?php 
// SQL query to get all properties
$sql = "SELECT * FROM add_property";
$query = mysqli_query($db, $sql);

if (mysqli_num_rows($query) > 0) {
    // Loop through each property record
    while ($rows = mysqli_fetch_assoc($query)) {
        $property_id = $rows['property_id'];
        
        // Prepare SQL query to get the image of the current property using prepared statements
        $sql2 = "SELECT * FROM property_photo WHERE property_id = ?";
        $stmt = mysqli_prepare($db, $sql2);
        
        // Bind the parameter to the statement
        mysqli_stmt_bind_param($stmt, "i", $property_id);
        
        // Execute the statement
        mysqli_stmt_execute($stmt);
        
        // Get the result
        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $photo = $row['p_photo'];
            $image_path = $photo;
        } else {
            $image_path = "default.jpg"; // Default image if no image found
        }
        
        // Display the property information
        ?>
        <div class="col-sm-2">
            <div class="card">
                <img class="image" src="<?php echo $image_path; ?>" alt="Property Image">
                <h4><b><?php echo htmlspecialchars($rows['property_type']); ?></b></h4>
                <p><?php echo htmlspecialchars($rows['city']) . ', ' . htmlspecialchars($rows['district']); ?></p>
                <p>
                    <a href="view-property.php?property_id=<?php echo $rows['property_id']; ?>" class="btn btn-lg btn-primary btn-block">View Property</a> 
                </p>
            </div>
        </div>
        <?php
        // Free the result of the second query
        mysqli_free_result($result);
        // Close the prepared statement
        mysqli_stmt_close($stmt);
    }
} else {
    echo "<p>No properties found.</p>";
}

// Free the result of the first query
mysqli_free_result($query);

// Close the database connection
mysqli_close($db);
?>

</body>
</html>

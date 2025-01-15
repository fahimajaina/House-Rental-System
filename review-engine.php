<?php 

include("config.php");

// Handle form submission for review
if (isset($_POST['review'])) {
    review();
}

// Function to handle review submission
function review() {
    global $db;

    // Sanitize inputs
    $property_id = isset($_GET['property_id']) ? $_GET['property_id'] : '';
    $comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';
    $rating = isset($_POST['rating']) ? $_POST['rating'] : '';

    // Check if the review fields are not empty
    if (!empty($comment) && !empty($rating)) {
        
        // Use prepared statements to avoid SQL injection
        $sql = "INSERT INTO review (comment, rating, property_id) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($db, $sql);
        
        if ($stmt) {
            // Bind the parameters to the query
            mysqli_stmt_bind_param($stmt, "ssi", $comment, $rating, $property_id);
            
            // Execute the statement
            $result = mysqli_stmt_execute($stmt);
            
            // Check if the review was successfully inserted
            if ($result) {
                // Show success message
                showSuccessMessage();
            } else {
                // Show error message if insertion failed
                showErrorMessage();
            }
            
            // Close the prepared statement
            mysqli_stmt_close($stmt);
        } else {
            // Show error message if the prepared statement failed
            showErrorMessage();
        }
    } else {
        // Show error message if inputs are empty
        showErrorMessage();
    }
}

// Function to show success message
function showSuccessMessage() {
    ?>
    <style>
    .alert {
      padding: 20px;
      background-color: #4CAF50; /* Green */
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
        <div class="alert">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            <strong>Your review has been recorded.</strong>
        </div>
    </div>
    <?php
}

// Function to show error message
function showErrorMessage() {
    ?>
    <style>
    .alert {
      padding: 20px;
      background-color: #DC143C; /* Red */
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
        <div class="alert">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            <strong>There was an error recording your review. Please try again.</strong>
        </div>
    </div>
    <?php
}
?>

<?php

// Database connection
$db = mysqli_connect('localhost', 'root', '', 'renthouse');

if (!$db) {
    echo "Error connecting to the database: " . mysqli_connect_error();
}

//  owner registration, login, and update functions
if (isset($_POST['owner_register'])) {
    owner_register($db);
}

if (isset($_POST['owner_login'])) {
    owner_login($db);
}

if (isset($_POST['owner_update'])) {
    owner_update($db);
}

if (isset($_POST['add_property'])) {
    add_property($db);
}






// Registration Function
function owner_register($db){
   

    // Validate input data
    $owner_id = validate($_POST['$owner_id']);
    $full_name = validate($_POST['full_name']);
    $email = validate($_POST['email']);
    $password = $_POST['password'];
    $phone_no = validate($_POST['phone_no']);
    $address = validate($_POST['address']);


    // Check password length
    if (strlen($password) < 8) {
        echo "Password must be at least 8 characters long.";
        return;
    }

    // Check if password contains at least one number
    if (!preg_match('/\d/', $password)) {
        echo "Password must contain at least one number.";
        return;
    }

    // Check if password contains at least one special character
    if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
        echo "Password must contain at least one special character.";
        return;
    }

    // Encrypt password
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    // Check phone number length
    if (strlen($phone_no) < 11) {
        echo "Phone number must be at least 11 digits long.";
        return;
    }
   

    
    $sql = "INSERT INTO owner (owner_id, full_name, email, password, phone_no, address) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($db, $sql);

    if ($stmt) {
        
        mysqli_stmt_bind_param($stmt, "isssss", $owner_id, $full_name, $email, $password_hashed, $phone_no, $address);
        
        // Execute query
        if (mysqli_stmt_execute($stmt)) {
            header("location:owner-login.php");
        } else {
            echo "Error: " . mysqli_error($db);
        }
        
        mysqli_stmt_close($stmt);
    }
}

//Login Function
function owner_login($db) {
    // Validate input data
    $email = validate($_POST['email']);
    $password = validate($_POST['password']); // Plain text password input

    
    $sql = "SELECT * FROM owner WHERE email=? LIMIT 1";
    $stmt = mysqli_prepare($db, $sql);

    if ($stmt) {
        
        mysqli_stmt_bind_param($stmt, "s", $email);
        
        // Execute query
        mysqli_stmt_execute($stmt);
        
        
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) == 1) {
            $data = mysqli_fetch_assoc($result);

            // Verify password
            if (password_verify($password, $data['password'])) {
                session_start();
                $_SESSION['email'] = $data['email'];
                header('location:owner-index.php');
            } else {
                echo show_error_message("Incorrect Email/Password or not registered.");
            }
        } else {
            echo show_error_message("Incorrect Email/Password or not registered.");
        }
        
        mysqli_stmt_close($stmt);
    }
}





// Function to add a property
function add_property($db)
{
    // Sanitize form data from $_POST directly
    $country = validate($_POST['country']);
    $division = validate($_POST['division']);
    $district = validate($_POST['district']);
    $city = validate($_POST['city']);
    $rural_urban = validate($_POST['rural_urban']);
    $address = validate($_POST['address']);
    $contact_no = validate($_POST['contact_no']);
    $property_type = validate($_POST['property_type']);
    $rent = validate($_POST['rent']);
    $total_rooms = validate($_POST['total_rooms']);
    $bedroom = validate($_POST['bedroom']);
    $living_room = validate($_POST['living_room']);
    $kitchen = validate($_POST['kitchen']);
    $bathroom = validate($_POST['bathroom']);
    $availability_status = 'Available';
    $u_email = $_SESSION['email']; // Get user email from session

    // Get owner ID from the session email
    $sql1 = "SELECT owner_id FROM owner WHERE email = ?";
    $stmt1 = mysqli_prepare($db, $sql1);
    mysqli_stmt_bind_param($stmt1, 's', $u_email);
    mysqli_stmt_execute($stmt1);
    mysqli_stmt_store_result($stmt1);

    if (mysqli_stmt_num_rows($stmt1) > 0) {
        mysqli_stmt_bind_result($stmt1, $owner_id);
        mysqli_stmt_fetch($stmt1);

        // Insert the property details into the database
        $sql = "INSERT INTO add_property (country, division, district, city, rural_urban, address, 
                contact_no, property_type, rent, total_rooms, bedroom, living_room, kitchen, bathroom, 
                availability_status, owner_id) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($db, $sql);
        mysqli_stmt_bind_param($stmt, 'sssssssssiiiiisi', $country, $division, $district, $city, 
                               $rural_urban, $address, $contact_no, $property_type, $rent, 
                               $total_rooms, $bedroom, $living_room, $kitchen, $bathroom, $availability_status,  $owner_id);

        if (mysqli_stmt_execute($stmt)) {
            // Get the last inserted property ID
            $property_id = mysqli_insert_id($db);

            // Handle image uploads
            $countfiles = count($_FILES['p_photo']['name']);
            for ($i = 0; $i < $countfiles; $i++) {
                $path = $_FILES['p_photo']['tmp_name'][$i];
                if ($path != "") {
                    $filename = "product-photo/" . $_FILES['p_photo']['name'][$i];
                    if (move_uploaded_file($path, $filename)) {
                        // Insert the property photo into the database
                        $sql2 = "INSERT INTO property_photo (p_photo, property_id) VALUES (?, ?)";
                        $stmt2 = mysqli_prepare($db, $sql2);
                        mysqli_stmt_bind_param($stmt2, 'si', $filename, $property_id);
                        mysqli_stmt_execute($stmt2);
                    }
                }
            }

            // Display success message
            echo "<style>
                    .alert { padding: 20px; background-color: #DC143C; color: white; }
                    .closebtn { margin-left: 15px; color: white; font-weight: bold; float: right; font-size: 22px; line-height: 20px; cursor: pointer; transition: 0.3s; }
                    .closebtn:hover { color: black; }
                  </style>";
            echo "<script>
                    window.setTimeout(function() {
                        $('.alert').fadeTo(1000, 0).slideUp(500, function(){
                            $(this).remove(); 
                        });
                    }, 2000);
                  </script>";
            echo "<div class='container'>
                    <div class='alert' role='alert'>
                        <span class='closebtn' onclick='this.parentElement.style.display=\"none\";'>&times;</span> 
                        <center><strong>Your Product has been uploaded.</strong></center>
                    </div>
                  </div>";
        } else {
            echo "Error: " . mysqli_error($db);
        }
    }
}

// Close the database connection at the end of the script
//mysqli_close($db);










function owner_update($db){
// Validate input data
$owner_id = isset($_POST['owner_id']) ? validate($_POST['owner_id']) : null;
$full_name = isset($_POST['full_name']) ? validate($_POST['full_name']) : null;
$email = isset($_POST['email']) ? validate($_POST['email']) : null;
$phone_no = isset($_POST['phone_no']) ? validate($_POST['phone_no']) : null;
$address = isset($_POST['address']) ? validate($_POST['address']) : null;

// Handle password 
if (isset($_POST['password']) && !empty($_POST['password'])) {
    
    $password = password_hash(validate($_POST['password']), PASSWORD_DEFAULT);
} else {
    
    $query = "SELECT password FROM owner WHERE owner_id = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "i", $owner_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $password);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
  }



    
    // Ensure all required fields are present
    if ($owner_id && $full_name && $email && $phone_no && $address && $password) {
        // Prepared statement for update query
        $sql = "UPDATE owner SET full_name=?, email=?, phone_no=?, address=?, password=? WHERE owner_id=?";
        $stmt = mysqli_prepare($db, $sql);

        if ($stmt) {
            // Bind parameters to placeholders
            mysqli_stmt_bind_param($stmt, "sssssi", $full_name, $email, $phone_no, $address, $password, $owner_id);

            // Execute the query
            if (mysqli_stmt_execute($stmt)) {
                echo show_success_message("Your information has been updated.");
            } else {
                echo "Error updating record: " . mysqli_error($db);
            }
            // Close the statement
            mysqli_stmt_close($stmt);
        } else {
            echo "Error preparing statement: " . mysqli_error($db);
        }
    } else {
        // Handle missing or invalid fields
        echo "Error: Missing or invalid input data.";
    }
}




// function to show error message
function show_error_message($message) {
return "<div class='alert' style='background-color: #DC143C; color: white;'>
            <strong>$message</strong> <a href='tenant-register.php' style='color: lightblue;'><b>Register</b></a>
        </div>";
}

// function to show success message
function show_success_message($message) {
return "<div class='alert' style='background-color: #4CAF50; color: white;'>
            <strong>$message</strong>
        </div>";
}

// Validate input 
function validate($data) {
$data = trim($data);
$data = stripslashes($data);
$data = htmlspecialchars($data);
return $data;
}

?>
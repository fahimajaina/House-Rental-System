<?php

// Database connection
$db = mysqli_connect('localhost', 'root', '', 'renthouse');

if (!$db) {
    echo "Error connecting to the database: " . mysqli_connect_error();
}

//  tenant registration, login, and update functions
if (isset($_POST['tenant_register'])) {
    tenant_register($db);
}

if (isset($_POST['tenant_login'])) {
    tenant_login($db);
}

if (isset($_POST['tenant_update'])) {
    tenant_update($db);
}

// Registration Function
function tenant_register($db) {

   

    

    // Validate input data
    $tenant_id = validate($_POST['tenant_id']);
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

    // Preparing statement to insert data into the database
    $sql = "INSERT INTO tenant (tenant_id, full_name, email, password, phone_no, address) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($db, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "isssss", $tenant_id, $full_name, $email, $password_hashed, $phone_no, $address);

        // Execute query
        if (mysqli_stmt_execute($stmt)) {
            header("location:tenant-login.php");
        } else {
            echo "Error: " . mysqli_error($db);
        }

        mysqli_stmt_close($stmt);
    }
}








// Login Function
function tenant_login($db) {
    // Validate input data
    $email = validate($_POST['email']);
    $password = validate($_POST['password']); // Plain text password input

    
    $sql = "SELECT * FROM tenant WHERE email=? LIMIT 1";
    $stmt = mysqli_prepare($db, $sql);

    if ($stmt) {
        
        mysqli_stmt_bind_param($stmt, "s", $email);
        
        // Execute query
        mysqli_stmt_execute($stmt);
        
        
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) == 1) {
            $data = mysqli_fetch_assoc($result);

            //   password Verify
            if (password_verify($password, $data['password'])) {
                session_start();
                $_SESSION['email'] = $data['email'];
                header('location:index.php');
            } else {
                echo show_error_message("Incorrect Email/Password or not registered.");
            }
        } else {
            echo show_error_message("Incorrect Email/Password or not registered.");
        }
        
        mysqli_stmt_close($stmt);
    }
}

function tenant_update($db) {
    // Validate input data
    $tenant_id = isset($_POST['tenant_id']) ? validate($_POST['tenant_id']) : null;
    $full_name = isset($_POST['full_name']) ? validate($_POST['full_name']) : null;
    $email = isset($_POST['email']) ? validate($_POST['email']) : null;
    $phone_no = isset($_POST['phone_no']) ? validate($_POST['phone_no']) : null;
    $address = isset($_POST['address']) ? validate($_POST['address']) : null;

    // Handle password field
    if (isset($_POST['password']) && !empty($_POST['password'])) {
        // Hash the new password if provided
        $password = password_hash(validate($_POST['password']), PASSWORD_DEFAULT);
    } else {
        // Retrieve the existing password from the database
        $query = "SELECT password FROM tenant WHERE tenant_id = ?";
        $stmt = mysqli_prepare($db, $query);
        mysqli_stmt_bind_param($stmt, "i", $tenant_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $password);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }

    // Ensure all required fields are present
    if ($tenant_id && $full_name && $email && $phone_no && $address && $password) {
        // Prepared statement for update query
        $sql = "UPDATE tenant SET full_name=?, email=?, phone_no=?, address=?, password=? WHERE tenant_id=?";
        $stmt = mysqli_prepare($db, $sql);

        if ($stmt) {
            // Bind parameters to placeholders
            mysqli_stmt_bind_param($stmt, "sssssi", $full_name, $email, $phone_no, $address, $password, $tenant_id);

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





//  function to show error message
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
<?php 

include("navbar.php");





 ?>

 <style>



.container{
    border: 1px solid black;
    width: 900px;
    height: 700px;
    background:url('house.png');
    color: white;
    border-radius: 20px;
    box-shadow: 0px 0px 20px rgba(0,0,0,0.75);
    background-size: cover;
    background-position: center;
    overflow: hidden;
    backdrop-filter: brightness(30%);
   margin: 50px auto; 
    
}

 </style>

<div class="container">
  <h3 style="font-weight: bold; text-align: center;">Tenant Register</h3><hr><br>
  <form method="POST" action="tenant-engine.php" onsubmit="return Validate()"> 
    <div class="form-group">
      <label for="full_name">Full Name:</label>
      <input type="text" class="form-control" id="full_name" placeholder="Enter Full Name" name="full_name" required>
    </div>
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="email" placeholder="Enter Email" name="email" required>
    </div>
    <div class="form-group">
      <label for="password1">Password:</label>
      <input type="password" class="form-control" id="password1" placeholder="Enter Password" name="password" required>
    </div>
    <div class="form-group">
      <label for="password2">Confirm Password:</label>
      <input type="password" class="form-control" id="password2" placeholder="Enter Password Again" required>
    </div>
    <div class="form-group">
      <label for="phone_no">Phone No.:</label>
      <input type="text" class="form-control" id="phone_no" placeholder="Enter Phone No." name="phone_no" required>
    </div>
    <div class="form-group">
      <label for="address">Address:</label>
      <input type="text" class="form-control" id="address" placeholder="Enter Address" name="address" required>
    </div>
    <hr>
    <center><button id="submit" name="tenant_register" class="btn btn-primary btn-block" type="submit">Register</button></center><br>
    <div class="form-group text-right">
      <label class="">Register as a <a href="owner-register.php">Owner</a>?</label><br>
    </div><br><br>
  </form>
  
</div>

<script>
    function Validate() {
        var password = document.getElementById("password1").value;
        var confirmPassword = document.getElementById("password2").value;
        var phoneNo = document.getElementById("phone_no").value;

        // Check if passwords match
        if (password != confirmPassword) {
            alert("Passwords do not match.");
            return false;
        }

        // Check password length
        if (password.length < 8) {
            alert("Password must be at least 8 characters long.");
            return false;
        }

        // Check if password contains at least one number
        if (!/\d/.test(password)) {
            alert("Password must contain at least one number.");
            return false;
        }

        // Check if password contains at least one special character
        if (!/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
            alert("Password must contain at least one special character.");
            return false;
        }

        // Check phone number length
        if (phoneNo.length < 11) {
            alert("Phone number must be at least 11 digits long.");
            return false;
        }

        return true;
    }
</script>

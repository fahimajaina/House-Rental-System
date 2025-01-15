<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>House rental system</title>

    <link rel="stylesheet" href='style.css'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
   

  </head>
  <body>
    
  <nav class="navbar navbar-expand-sm navbar-light justify-content-between" style="background-color: #b6d0e3;">
  <div class="container-fluid">

  <a class="navbar-header" href="index.php"> 
    <img src="logo.png" alt="logo" style="height:50px;">
  </a>
  
  <!-- Links -->
  <ul class="nav navbar-nav">

    <li class="nav-item">
      <a class="nav-link" href="index.php">Home</a> 
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">About Us</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">Contact Us</a>
    </li>

  </ul>

  <ul class="nav navbar-nav navbar-right">
      <?php 
      
if(isset($_SESSION["email"]) && !empty($_SESSION['email']))
{
?>
<li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span> My Profile
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="tenant-profile.php">Profile</a></li>
          <li><a href="booked-property.php">Booked Property</a></li>
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </li>


<?php
  
}

else {?>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span> Register
        <span class="caret"></span></a>
        <ul class="dropdown-menu">

          <li><a href="tenant-register.php">Tenant</a></li> 
          <li><a href="owner-register.php">Owner</a></li> 

        </ul>
      </li>

     
      <li><a href="how-to-login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
    <?php } ?>
    </ul>
  </div>
</nav>



 
    
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  </body>
</html>

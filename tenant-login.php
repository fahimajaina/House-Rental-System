<?php 
session_start();
if(isset($_SESSION["email"])){
  header("location:index.php");
}

include("navbar.php");
include("tenant-engine.php");

 ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>tenant-login</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>


     <style>

.navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding-top: 70px; /* Adjust this based on the height of your navbar */
            box-sizing: border-box;
            background-color: #f4f4f4;
        }

        .login{
           
            border:1px solid black;
            width: 400px;
            height:500px;
            background: url('house.png');
            color:white;
            border-radius: 20px;
            box-shadow: 0px 0px 20px rgba(0,0,0,0.75);
            background-size: cover;
            background-position: center;
            overflow:hidden;
            margin-bottom: 10PX;

        }

        form{
            display:block;
            box-sizing:border-box;
            padding:40px;
            width: 100%;
            height:100%;
            backdrop-filter:brightness(40%);
            display:flex;
            flex-direction:column;
            gap:5px;
        }

        h1{
            font-weight: normal;
            font-size:24px;
            text-align:center;
            text-shadow: 0px 0px 2px rgba(0,0,0,0.5);
            margin-bottom:60px;

        }

        label{
            color:rgba(255,255,255,0.8);
            text-transform:uppercase;
            font-size:12px;
            letter-spacing:2px;
            padding-left:10px;
        }

        input{
            background:rgba(255,255,255,0.3);
            height:40px;
            line-height:40px;
            border-radius:15px;
            padding:0px 20px;
            border:none;
            margin-bottom:20px;
            color:white;
        }

        button{
            background:rgb(45,126,231);
            height:40px;
            line-height:40px;
            border-radius:40px;
            border:none;
            margin:10px 0px;
            box-shadow: 0px 0px 5px rgba(0,0,0,0.3);
            color:white;
            font-size:12px;
            text-transform:uppercase;
        }
     </style>
</head>
<body>

<div class="login">
    <form method="POST">
        <h1> Tenant Login </h1>
        <label for="email"> Email </label>
        <input type="email" name="email" id="email" required>
        <label for="pwd"> Password </label>
        <input type="password" name="password" id="pwd" required>
        <div class="forgot-password">
          <a href="forgot-password-owner.php">Lost your Password ? </a> 
        </div>
        <button type="submit" id="submit" name="tenant_login" class="btn">Login</button>


    </form>

 </div>
    
</body>
</html>

 
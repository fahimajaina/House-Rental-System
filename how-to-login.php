<?php 
session_start();
/*if(isset($_SESSION["email"])){
  header("location:index.php");
}*/
include("navbar.php");

 ?>


    <section class="container-fluid sign-in-form-section">
        <div class="container2">
            <div class="row">
                
                <div class="col-md-12 sign-up" style="text-align: center;">
                    <h3 style="font-weight: bold;">How do you want to Login?</h3><hr>
                    <p style="font-weight: bold;  font-size: 15px;">If you want to sign in as a tenant click on tenant login button or click on owner login button otherwise click on admin login button.</p><br><br>
                    <button type="submit" class="btn btn-info"  onclick="window.location.href='tenant-login.php'" style="width:200px; box-shadow: 0px 0px 20px rgba(0,0,0,0.25);margin-right:4px;">Tenant Login</button>
                    <button type="submit" class="btn btn-info"  onclick="window.location.href='owner-login.php'" style="width:200px; box-shadow: 0px 0px 20px rgba(0,0,0,0.25);margin-right:4px;">Owner Login</button>
                    <button type="submit" class="btn btn-info"  onclick="window.location.href='admin-login.php'" style="width:200px; box-shadow: 0px 0px 20px rgba(0,0,0,0.25);margin-right:4px;">Admin Login</button>
                </div>
                
            </div>
        </div>
    </section>
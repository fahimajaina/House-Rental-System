<?php 
session_start();

include("navbar.php");

 ?>
 <style>
body, html {
  height: 100%;
  margin: 0;
}

.bg {
  
  background-image: url("carousel.png");

 
  height: 60%; 

  
  background-position: bottom;
  background-repeat: no-repeat;
  background-size: cover;
}


.container-custom{
   
   width: 70%;
   margin: 0 auto;
   border-radius: 8px; 
   background-color: #f9f9f9;
   box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
} 
</style>

<div class="bg"></div><br>
<div class="container-custom active-cyan-4 mb-4 inline">
	<form method="POST" action="search-property.php">
  <input class="form-control" type="text" placeholder="Enter location to search house." name="search_property" aria-label="Search"> <!--search-property.php will work here-->
  </form>
</div>
<br><br>
<?php 

include("property-list.php");

 ?>
 <br><br>
<?php 
session_start();
if(!isset($_SESSION["email"])){
  header("location:index.php");
}

include("owner-navbar.php");
include("owner-engine.php");


 ?>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="owner-style.css">

<style>
	.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  max-width: 300px;
  margin: auto;
  text-align: center;
  font-family: arial;
}
button {
  border: none;
  outline: 0;
  display: inline-block;
  padding: 8px;
  color: white;
  background-color: #000;
  text-align: center;
  cursor: pointer;
  width: 100%;
  font-size: 18px;
}

button:hover, a:hover {
  opacity: 0.7;
}

.form-group {
  text-align: left;
}
</style>


</head>

<body>

 <div class="container-fluid">
  <ul class="nav nav-pills nav-justified">
    <li class="active" style="background-color: #FFF8DC"><a data-toggle="pill" href="#home">Profile</a></li>
    <li style="background-color: #FAC0E6"><a data-toggle="pill" href="#menu4">Messages</a></li>
    <li style="background-color: #FAF0E6"><a data-toggle="pill" href="#menu1">Add Property</a></li>
    <li style="background-color: #FFFACD"><a data-toggle="pill" href="#menu2">View Property</a></li>
    <li style="background-color: #FFFAF0"><a data-toggle="pill" href="#menu3">Update Property</a></li>
    <li style="background-color: #FAFAF0"><a data-toggle="pill" href="#menu6">Booked Property</a></li>
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <center><h3>Owner Profile</h3></center>
      <div class="form-container">
      <?php 
        include("config.php");
        $u_email= $_SESSION["email"];

        $sql="SELECT * from owner where email='$u_email'";
        $result=mysqli_query($db,$sql);

        if(mysqli_num_rows($result)>0)
      {
          while($rows=mysqli_fetch_assoc($result)){
          
       ?> 

         <div class="card">
     <img src="avatar.png" alt="John" style="height:200px; width: 100%">
     <h1><?php echo $rows['full_name']; ?></h1>
     <p class="title"><?php echo $rows['email']; ?></p>
     <p><b>Phone No.: </b><?php echo $rows['phone_no']; ?></p>
     <p><b>Address: </b><?php echo $rows['address']; ?></p>
  

      <!-- modal start-->
      <p><button type="button" class="btn btn-lg" data-toggle="modal" data-target="#myModal">Update Profile</button></p>


  
      <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog">
    
     
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Update Profile</h4>
        </div>
        <div class="modal-body">

            <form method="POST">
                <div class="form-group">
                  <label for="full_name">Full Name:</label>
                  <input type="hidden" value="<?php echo $rows['owner_id']; ?>" name="owner_id">
                  <input type="text" class="form-control" id="full_name" value="<?php echo $rows['full_name']; ?>" name="full_name">
                </div>
                <div class="form-group">
                  <label for="email">Email:</label>
                  <input type="email" class="form-control" id="email" value="<?php echo $rows['email']; ?>" name="email" readonly>
                </div>
                <div class="form-group">
                  <label for="phone_no">Phone No.:</label>
                  <input type="text" class="form-control" id="phone_no" value="<?php echo $rows['phone_no']; ?>" name="phone_no">
                </div>
                <div class="form-group">
                  <label for="address">Address:</label>
                  <input type="text" class="form-control" id="address" value="<?php echo $rows['address']; ?>" name="address">
                </div>
    
                <hr>
                <center><button id="submit" name="owner_update" class="btn btn-primary btn-block">Update</button></center><br>
                
              </form>


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        </div>
      
      </div>
    </div>
  </div>
 </div>
</div>
 <?php }
 } ?>


<!--for messages-->


<div id="menu4" class="tab-pane fade">
      <div class="container">
      <center><h3>See Messages</h3></center>
            <?php 
      $sql = "SELECT * FROM owner WHERE email = ?";
      if ($stmt = mysqli_prepare($db, $sql)) {
          mysqli_stmt_bind_param($stmt, "s", $_SESSION['email']);
          mysqli_stmt_execute($stmt);
          $result = mysqli_stmt_get_result($stmt);
      
          // Check if there's at least one row returned
          if (mysqli_num_rows($result) > 0) {
              $rows = mysqli_fetch_assoc($result);  // Fetch the row
              $owner_id = $rows['owner_id'];  
          } else {
              echo "No owner found with this email.";
              exit;
          }
          mysqli_stmt_close($stmt);
      }
      
      $sql1="SELECT * FROM chat where owner_id='$owner_id' ";

    $query1 = mysqli_query($db,$sql1);

  if(mysqli_num_rows($query1)>0)
  {
    while($row= mysqli_fetch_assoc($query1)){

      $tenant_id=$row['tenant_id'];
      $sql2="SELECT * FROM tenant where tenant_id='$tenant_id' ";

    $query2 = mysqli_query($db,$sql2);

  if(mysqli_num_rows($query2)>0)
  {
    while ($rows= mysqli_fetch_assoc($query2)){
    
?>

   
<link rel="stylesheet" type="text/css" href="message-style.css">

<div class="tab">   
  <button class="tablinks" id="defaultOpen" onmouseover="openCity(event, '<?php echo $rows["full_name"]; ?>')"><?php echo $rows["full_name"]; ?></button>
</div>

<div id="<?php echo $rows["full_name"]; ?>" class="tabcontent">
  <?php
   $sql3="SELECT * FROM chat where tenant_id='$tenant_id' AND owner_id='$owner_id' ";

    $query3 = mysqli_query($db,$sql3);

  if(mysqli_num_rows($query3)>0)
  {
    while($ro= mysqli_fetch_assoc($query3)){
      echo $ro["message"]."<br>";
    }}
  ?>
</div>

<div class="clearfix"></div>


<?php
        //echo '<a href="send-message.php?owner_id='.$owner_id.'&tenant_id='.$tenant_id.'">'.$rows["full_name"].'</a>';
    }
  }}
  }
  else {
    echo "<p>--No messages--</p>";
}?>
    </div>
    </div>











<!--for add property-->

<div id="menu1" class="tab-pane fade">

  <center><h3>Add Property</h3></center>
   <div class="form-container">

     <form method="POST" enctype="multipart/form-data">
      <div class="row"> 
         <div class="col-sm-6">
            <div class="form-group"> 

               <label for="country">Country:</label>
                 <select class="form-control" name="country" required="required">
                                   <option value="">--Select Country--</option>
                                   <option value="Bangladesh">Bangladesh</option>
                 </select>

            </div>
            <div class="form-group">
              <label for="division">Division:</label>
              <select class="form-control" name="division" required="required">
                                <option value="">--Select Division--</option>
                                <option value="Dhaka">Dhaka</option>
                                <option value="Chittagong">Chittagong</option>
                                <option value="Rajshahi">Rajshahi</option>
                                <option value="Khulna">Khulna</option>
                                <option value="Barisal">Barisal</option>
                                <option value="Sylhet">Sylhet</option>
                                <option value="Rangpur">Rangpur</option>
                                <option value="Mymensingh">Mymensingh</option>
              </select>
            </div>
            <div class="form-group">
              <label for="district">District:</label>
              <select class="form-control" name="district" required="required">
                                %{--Dhaka--}%
                                <option value="">--Select District--</option>
                                <option value="Dhaka">Dhaka</option>
                                <option value="Narayanganj">Narayanganj</option>
                                <option value=" Gazipur"> Gazipur</option>
                                <option value=" Manikgonj"> Manikgonj</option>
                                <option value="Munshigonj">Munshigonj</option>
                                <option value="Narsingdi">Narsingdi</option>
                                <option value="Tangail">Tangail</option>
                                <option value="Kishorgonj">Kishorgonj</option>
                                <option value="Netrokona">Netrokona</option>
                                <option value="Faridpur">Faridpur</option>
                                <option value="Gopalgonj">Gopalgonj</option>
                                <option value="Madaripur">Madaripur</option>
                                <option value="Rajbari">Rajbari</option>
                                <option value="Shariatpur">Shariatpur</option>
                                %{--Chittagong--}%
                                <option value="Chittagong">Chittagong</option>
                                <option value="Cox's Bazar">Cox's Bazar</option>
                                <option value="Rangamati">Rangamati</option>
                                <option value="Bandarban">Bandarban</option>
                                <option value="Khagrachhari">Khagrachhari</option>
                                <option value="Feni">Feni</option>
                                <option value="Lakshmipur">Lakshmipur</option>
                                <option value="Comilla">Comilla</option>
                                <option value="Brahmanbaria">Brahmanbaria</option>
                                <option value="Noakhali">Noakhali</option>
                                <option value="Chandpur">Chandpur</option>
                                %{--Rajshahi--}%
                                <option value="Rajshahi">Rajshahi</option>
                                <option value="Naogaon">Naogaon</option>
                                <option value="Natore">Natore</option>
                                <option value="Chapai Nawabganj">Chapai Nawabganj</option>
                                <option value="Pabna">Pabna</option>
                                <option value="Sirajganj">Sirajganj</option>
                                <option value="Bogra">Bogra</option>
                                <option value="Joypurhat">Joypurhat</option>
                                %{--Khulna--}%
                                <option value="Khulna">Khulna</option>
                                <option value="Bagherhat">Bagherhat</option>
                                <option value="Sathkhira">Sathkhira</option>
                                <option value="Jessore">Jessore</option>
                                <option value="Magura">Magura</option>
                                <option value="Jhenaidah">Jhenaidah</option>
                                <option value="Narail">Narail</option>
                                <option value="Kushtia">Kushtia</option>
                                <option value="Chuadanga">Chuadanga</option>
                                <option value="Meherpur">Meherpur</option>
                                %{--Barisal--}%
                                <option value="Barisal">Barisal</option>
                                <option value="Barguna">Barguna</option>
                                <option value="Bhola">Bhola</option>
                                <option value="Jhalokati">Jhalokati</option>
                                <option value="Patuakhali">Patuakhali</option>
                                <option value="Pirojpur">Pirojpur</option>
                                %{--Sylhet--}%
                                <option value="Sylhet">Sylhet</option>
                                <option value="Sunamganj">Sunamganj</option>
                                <option value="Moulvibazar">Moulvibazar</option>
                                <option value="Habiganj">Habiganj</option>
                                %{--Rangpur--}%
                                <option value="Rangpur">Rangpur</option>
                                <option value="Dinajpur">Dinajpur</option>
                                <option value="Gaibandha">Gaibandha</option>
                                <option value="Kurigram">Kurigram</option>
                                <option value="Lalmonirhat">Lalmonirhat</option>
                                <option value="Nilphamari">Nilphamari</option>
                                <option value="Panchagarh">Panchagarh</option>
                                <option value="Thakurgaon">Thakurgaon</option>
                                %{--Mymensingh--}%
                                <option value="Mymensingh">Mymensingh</option>
                                <option value="Jamalpur">Jamalpur</option>
                                <option value="Netrokona">Netrokona</option>
                                <option value="Sherpur">Sherpur</option>
               </select>
            </div>
            <div class="form-group">
              <label for="city">City:</label>
              <input type="text" class="form-control" id="city" placeholder="Enter City" name="city">
            </div>
            <div class="form-group">
              <label for="rural/urban">Rural/Urban Area:</label>
              <select class="form-control" name="rural_urban">
                <option value="">--Select Rural/Urban Area--</option>
                <option value="Rural">Rural</option>
                <option value="Urban">Urban</option>
              </select>

            </div>
            <div class="form-group">
              <label for="address">Address:</label>
              <input type="text" class="form-control" id="address" placeholder="Enter Address." name="address">
            </div>
            <div class="form-group">
              <label for="contact_no">Contact No.:</label>
              <input type="text" class="form-control" id="contact_no" placeholder="Enter Contact No." name="contact_no">
            </div>
            <div class="form-group">
               <label for="property_type">Property Type:</label>
                <select class="form-control" name="property_type">
                      <option value="">--Select Property Type--</option>
                      <option value="Full House Rent">Full House Rent</option>
                      <option value="Flat Rent">Flat Rent</option>
                      <option value="Room Rent">Room Rent</option>
                </select>
            </div> 
            <div class="form-group">
                <label for="rent">Rent:</label>
                <input type="rent" class="form-control" id="rent" placeholder="Enter Rent" name="rent">
            </div>  


         </div>

         <div class="col-sm-6">
                  <div class="form-group">
                    <label for="total_rooms">Total No. of Rooms:</label>
                    <input type="number" class="form-control" id="total_rooms" placeholder="Enter Total No. of Rooms" name="total_rooms">
                  </div>
                  <div class="form-group">
                    <label for="bedroom">No. of Bedroom:</label>
                    <input type="number" class="form-control" id="bedroom" placeholder="Enter No. of Bedroom" name="bedroom">
                  </div>
                  <div class="form-group">
                    <label for="living_room">No. of Living Room:</label>
                    <input type="number" class="form-control" id="living_room" placeholder="Enter No. of Living Room" name="living_room">
                  </div>
                  <div class="form-group">
                    <label for="kitchen">No. of Kitchen:</label>
                    <input type="number" class="form-control" id="kitchen" placeholder="Enter No. of Kitchen" name="kitchen">
                  </div>
                  <div class="form-group">
                    <label for="bathroom">No. of Bathroom/Washroom:</label>
                    <input type="number" class="form-control" id="bathroom" placeholder="Enter No. of Bathroom/Washroom" name="bathroom">
                  </div>
                  <div class="form-group">
                        <label for="availability_status">Availability Status:</label>
                        <select class="form-control" name="availability_status">
                            <option value="">--Select Availability--</option>
                            <option value="Available">Available</option>
                            <option value="Not Available">Not Available</option>
                        </select>
                    </div>
                  
                  <table class="table" id="dynamic_field">  
                  <tr> 
                    <div class="form-group"> 
                    <label><b>Photos:</b></label>                    
                    <td><input type="file" name="p_photo[]" placeholder="Photos" class="form-control name_list" required accept="image/*" /></td> 
                    <td><button type="button" id="add" name="add" class="btn btn-success col-lg-12">Add More</button></td>  
                  </div>
                  </tr>  
                </table>
                  <hr>
                  <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-lg col-lg-12" value="Add Property" name="add_property">
                  </div>
                </div>
              </div>
        </form>
     <br><br>

   </div>
</div>



<!--for View property-->

<div id="menu2" class="tab-pane fade">
    <center><h3>View Property</h3></center>
    <div class="container-fluid">
        <input type="text" id="myInput" onkeyup="viewProperty()" placeholder="Search..." title="Type in a name">
        <div style="overflow-x:auto;">
            <table id="myTable">
                <tr class="header">
                    <th>Id.</th>
                    <th>Country</th>
                    <th>Division</th>
                    <th>District</th>
                    <th>City</th>
                    <th>Rural/Urban Area</th>
                    <th>Address</th>
                    <th>Contact No.</th>
                    <th>Property Type</th>
                    <th>Rent</th>
                    <th>Total Rooms</th>
                    <th>Bedroom</th>
                    <th>Living Room</th>
                    <th>Kitchen</th>
                    <th>Bathroom</th>
                    <th>Booked</th>
                    <th>Photos</th>
                </tr>
                <?php
                
                

                // Get the email of the logged-in user
                $u_email = $_SESSION['email'];

                // Query to get owner_id of the logged-in user
                $sql1 = "SELECT owner_id FROM owner WHERE email = ?";
                $stmt1 = mysqli_prepare($db, $sql1);
                mysqli_stmt_bind_param($stmt1, "s", $u_email);
                mysqli_stmt_execute($stmt1);
                mysqli_stmt_bind_result($stmt1, $owner_id);
                mysqli_stmt_fetch($stmt1);
                mysqli_stmt_close($stmt1);

                // Check if the owner_id exists
                if (!empty($owner_id)) {
                    // Query to get properties owned by the owner
                    $sql2 = "SELECT * FROM add_property WHERE owner_id = ?";
                    $stmt2 = mysqli_prepare($db, $sql2);
                    mysqli_stmt_bind_param($stmt2, "i", $owner_id);
                    mysqli_stmt_execute($stmt2);
                    $result2 = mysqli_stmt_get_result($stmt2);

                    if (mysqli_num_rows($result2) > 0) {
                        while ($rows = mysqli_fetch_assoc($result2)) {
                            $property_id = $rows['property_id'];
                            ?>
                            <tr>
                                <td><?php echo $rows['property_id']; ?></td>
                                <td><?php echo $rows['country']; ?></td>
                                <td><?php echo $rows['division']; ?></td>
                                <td><?php echo $rows['district']; ?></td>
                                <td><?php echo $rows['city']; ?></td>
                                <td><?php echo $rows['rural_urban']; ?></td>
                                <td><?php echo $rows['address']; ?></td>
                                <td><?php echo $rows['contact_no']; ?></td>
                                <td><?php echo $rows['property_type']; ?></td>
                                <td>Rs.<?php echo $rows['rent']; ?></td>
                                <td><?php echo $rows['total_rooms']; ?></td>
                                <td><?php echo $rows['bedroom']; ?></td>
                                <td><?php echo $rows['living_room']; ?></td>
                                <td><?php echo $rows['kitchen']; ?></td>
                                <td><?php echo $rows['bathroom']; ?></td>
                                <td><?php echo $rows['availability_status']; ?></td>
                                <td>
                                    <?php
                                    // Query to get photos of the property
                                    $sql3 = "SELECT p_photo FROM property_photo WHERE property_id = ?";
                                    $stmt3 = mysqli_prepare($db, $sql3);
                                    mysqli_stmt_bind_param($stmt3, "i", $property_id);
                                    mysqli_stmt_execute($stmt3);
                                    $result3 = mysqli_stmt_get_result($stmt3);

                                    if (mysqli_num_rows($result3) > 0) {
                                        while ($photo = mysqli_fetch_assoc($result3)) {
                                            echo '<img src="' . $photo['p_photo'] . '" width="50px">';
                                        }
                                    }
                                    mysqli_stmt_close($stmt3);
                                    ?>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo "<tr><td colspan='21'>No properties found.</td></tr>";
                    }
                    mysqli_stmt_close($stmt2);
                } else {
                    echo "<tr><td colspan='21'>Owner not found.</td></tr>";
                }

                
                ?>
            </table>
        </div>
    </div>
</div>



<!--for Update property-->


<div id="menu3" class="tab-pane fade">
    <center><h3>Update Property</h3></center>
    <div class="container-fluid">
        <input type="text" id="myInput" onkeyup="updateProperty()" placeholder="Search..." title="Type in a name">
        <div style="overflow-x:auto;">
            <table id="myTable">
                <tr class="header">
                    <th>Id.</th>
                    <th>Country</th>
                    <th>Division</th>
                    <th>District</th>
                    <th>City</th>
                    <th>Rural/Urban Area</th>
                    <th>Address</th>
                    <th>Contact No.</th>
                    <th>Property Type</th>
                    <th>Rent</th>
                    <th>Total Rooms</th>
                    <th>Bedroom</th>
                    <th>Living Room</th>
                    <th>Kitchen</th>
                    <th>Bathroom</th>
                    <th>Booked</th>
                    <th>Photos</th>
                    <th>Edit/Delete</th>
                </tr>
                <?php 
              // Query to get owner_id of the logged-in user
              $u_email = $_SESSION['email'];
              $sql1 = "SELECT owner_id FROM owner WHERE email = ?";
              $stmt1 = mysqli_prepare($db, $sql1);
              mysqli_stmt_bind_param($stmt1, "s", $u_email);
              mysqli_stmt_execute($stmt1);
              mysqli_stmt_bind_result($stmt1, $owner_id);
              mysqli_stmt_fetch($stmt1);
              mysqli_stmt_close($stmt1);

              // Check if the owner_id exists
              if (!empty($owner_id)) {
                  // Query to get properties owned by the owner
                  $sql2 = "SELECT * FROM add_property WHERE owner_id = ?";
                  $stmt2 = mysqli_prepare($db, $sql2);
                  mysqli_stmt_bind_param($stmt2, "i", $owner_id);
                  mysqli_stmt_execute($stmt2);
                  $result2 = mysqli_stmt_get_result($stmt2);
              
                  if (mysqli_num_rows($result2) > 0) {
                      while ($rows = mysqli_fetch_assoc($result2)) {
                          $property_id = $rows['property_id'];
                          ?>
                          <tr>
                              <td><?php echo $rows['property_id']; ?></td>
                              <td><?php echo $rows['country']; ?></td>
                              <td><?php echo $rows['division']; ?></td>
                              <td><?php echo $rows['district']; ?></td>
                              <td><?php echo $rows['city']; ?></td>
                              <td><?php echo $rows['rural_urban']; ?></td>
                              <td><?php echo $rows['address']; ?></td>
                              <td><?php echo $rows['contact_no']; ?></td>
                              <td><?php echo $rows['property_type']; ?></td>
                              <td>Rs.<?php echo $rows['rent']; ?></td>
                              <td><?php echo $rows['total_rooms']; ?></td>
                              <td><?php echo $rows['bedroom']; ?></td>
                              <td><?php echo $rows['living_room']; ?></td>
                              <td><?php echo $rows['kitchen']; ?></td>
                              <td><?php echo $rows['bathroom']; ?></td>
                              <td><?php echo $rows['availability_status']; ?></td>
                              <td>
                                  <?php
                                  // Query to fetch property photos
                                  $sql_photos = "SELECT p_photo FROM property_photo WHERE property_id = ?";
                                  $stmt_photos = mysqli_prepare($db, $sql_photos);
                                  mysqli_stmt_bind_param($stmt_photos, "i", $property_id);
                                  mysqli_stmt_execute($stmt_photos);
                                  $result_photos = mysqli_stmt_get_result($stmt_photos);
              
                                  if (mysqli_num_rows($result_photos) > 0) {
                                      while ($photo = mysqli_fetch_assoc($result_photos)) {
                                          echo '<img src="' . $photo['p_photo'] . '" width="50px">';
                                      }
                                  }
                                  mysqli_stmt_close($stmt_photos);
                                  ?>
                              </td>
                              <form method="POST" action="delete-property.php">
                                  <td>
                                      <input type="hidden" name="property_id" value="<?php echo $rows['property_id']; ?>">
                                      <a class="btn btn-success" href="edit-property.php?property_id=<?php echo $rows['property_id']; ?>">Edit</a>
                                      <input type="submit" class="btn btn-danger" name="delete_property" value="Delete"> <!--delete-property.php will work here-->
                                  </td>
                              </form>
                          </tr>
                          <?php
                      }
                  } else {
                      echo "<tr><td colspan='22'>No properties found.</td></tr>";
                  }
                  mysqli_stmt_close($stmt2);
              } ?>
                
            
              
          </table>
        </div>
    </div>
</div>





<!--for Booked property-->

<div id="menu6" class="tab-pane fade">
    <center><h3>Booked Property</h3></center>
    <div class="form-container">
        <input type="text" id="myInput" onkeyup="bookedProperty()" placeholder="Search..." title="Type in a name">

        <table id="myTable">
            <tr class="header">
                <th>Booked By</th>
                <th>Booker Address</th>
                <th>Property Division</th>
                <th>Property District</th>
                <th>Property City</th>
                <th>Property Address</th>
                <th>Rent</th>
            </tr>

            <?php
            include("config.php");
           
            
            // Get the owner's email from session
            $u_email = $_SESSION["email"];

            // Query to get owner_id based on email
            $sql_owner = "SELECT owner_id FROM owner WHERE email = '$u_email'";
            $result_owner = mysqli_query($db, $sql_owner);

            if ($result_owner && mysqli_num_rows($result_owner) > 0) {
                $owner_row = mysqli_fetch_assoc($result_owner);
                $owner_id = $owner_row['owner_id'];

                // Query to get all properties of the owner
                $sql_properties = "SELECT * FROM add_property WHERE owner_id = '$owner_id'";
                $result_properties = mysqli_query($db, $sql_properties);

                if ($result_properties && mysqli_num_rows($result_properties) > 0) {
                    while ($property_row = mysqli_fetch_assoc($result_properties)) {
                        $property_id = $property_row['property_id'];

                        // Query to get bookings for the property
                        $sql_booking = "SELECT * FROM booking WHERE property_id = '$property_id'";
                        $result_booking = mysqli_query($db, $sql_booking);

                        if ($result_booking && mysqli_num_rows($result_booking) > 0) {
                            while ($booking_row = mysqli_fetch_assoc($result_booking)) {
                                $tenant_id = $booking_row['tenant_id'];

                                // Query to get tenant details
                                $sql_tenant = "SELECT full_name, address FROM tenant WHERE tenant_id = '$tenant_id'";
                                $result_tenant = mysqli_query($db, $sql_tenant);

                                if ($result_tenant && mysqli_num_rows($result_tenant) > 0) {
                                    $tenant_row = mysqli_fetch_assoc($result_tenant);
                                    ?>

                                    <!-- Display Booked Property Details -->
                                    <tr>
                                        <td><?php echo htmlspecialchars($tenant_row['full_name']); ?></td>
                                        <td><?php echo htmlspecialchars($tenant_row['address']); ?></td>
                                        <td><?php echo htmlspecialchars($property_row['division']); ?></td>
                                        <td><?php echo htmlspecialchars($property_row['district']); ?></td>
                                        <td><?php echo htmlspecialchars($property_row['city']); ?></td>
                                        <td><?php echo htmlspecialchars($property_row['address']); ?></td>
                                        <td><?php echo htmlspecialchars($property_row['rent']); ?></td>
                                    </tr>

                                    <?php
                                      }
                                   }
                              }
                          }
                       }
                  }
                   ?>
            </table>
          </div>
       </div>
     </div>
   </div>
</body>



<!--for searching properties in view property-->

<script>
  function viewProperty() {
    var input, filter, table, tr, td, i, j, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase(); // Convert the filter to uppercase for case-insensitive matching
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");

    for (i = 1; i < tr.length; i++) { // Start from 1 to skip the header row
      tr[i].style.display = "none"; // Initially hide the row
      td = tr[i].getElementsByTagName("td");

      for (j = 0; j < td.length; j++) { // Loop through each td element in the row
        if (td[j]) {
          txtValue = td[j].textContent || td[j].innerText; // Get the text content of the td
          if (txtValue.toUpperCase().indexOf(filter) > -1) { // If the filter matches any td content
            tr[i].style.display = ""; // Show the row if a match is found
            break; // Stop looping through columns once a match is found
          }
        }
      }
    }
  }
</script>




<!--for searching properties in Update property-->


<script>
      function updateProperty() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");
        th = table.getElementsByTagName("th");
        for (i = 1; i < tr.length; i++) {
          tr[i].style.display = "none";
            for(var j=0; j<th.length; j++){
               td = tr[i].getElementsByTagName("td")[j];      
              if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter.toUpperCase()) > -1)
                 {
                  tr[i].style.display = "";
                  break;
                  }
               }
            }
        }
      }
 </script>


<!--for searching properties in booked property-->

<script>
       function bookedProperty() {
         var input, filter, table, tr, td, i, txtValue;
         input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");
        th = table.getElementsByTagName("th");
         for (i = 1; i < tr.length; i++) {
          tr[i].style.display = "none";
            for(var j=0; j<th.length; j++){
               td = tr[i].getElementsByTagName("td")[j];      
               if (td) {
                 if (td.innerHTML.toUpperCase().indexOf(filter.toUpperCase()) > -1)
                 {
                  tr[i].style.display = "";
                  break;
                  }
              }
            }
        }
      }
  </script>


<!--Adding OR Removing property photos-->

<script>  
 $(document).ready(function(){  
      var i=1;  
      $('#add').click(function(){  
           i++;  
           $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="file" name="p_photo[]" placeholder="Photos" class="form-control name_list" required accept="image/*" /></td></td> <td><button id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>'); 
      });  

                 

      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  
      $('#submit').click(function(){            
           $.ajax({  
                url:"name.php",  
                method:"POST",  
                data:$('#add_name').serialize(),  
                success:function(data)  
                {  
                     alert(data);  
                     $('#add_name')[0].reset();  
                }  
           });  
      });  
 });  
 </script>



<script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>


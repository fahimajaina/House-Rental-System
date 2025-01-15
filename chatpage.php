<?php
session_start();
isset($_SESSION["email"]);
include("navbar.php");
include("config.php");

if (isset($_POST['send_message'])) {

    $u_email = $_SESSION["email"];
    $owner_id = $_POST['owner_id'];

    // Select tenant based on email
    $sql = "SELECT * FROM tenant WHERE email = '$u_email'";
    $query = mysqli_query($db, $sql);

    if (mysqli_num_rows($query) > 0) {
        while ($rows = mysqli_fetch_assoc($query)) {
            $tenant_id = $rows['tenant_id'];

            // Fetch chat messages between the tenant and the owner
            $sql1 = "SELECT * FROM chat WHERE owner_id = '$owner_id' AND tenant_id = '$tenant_id'";
            $query1 = mysqli_query($db, $sql1);
?>

<style>
  h2 {
    color: white;
  }

  label {
    color: white;
  }

  span {
    color: #673ab7;
    font-weight: bold;
  }

  .container {
    margin-top: 3%;
    width: 60%;
    padding-right: 10%;
    padding-left: 10%;
  }

  .btn-primary {
    background-color: ;
  }

  .display-chat {
    height: 300px;
    background-color: lightgrey;
    margin-bottom: 4%;
    overflow: auto;
    padding: 15px;
  }

  .message {
    background-color: #c616e469;
    color: white;
    border-radius: 5px;
    padding: 5px;
    margin-bottom: 3%;
  }
</style>

<div class="container">
  <center><h3>Send Messages</h3></center>
  <div class="display-chat">
<?php
            if (mysqli_num_rows($query1) > 0) {
                while ($row = mysqli_fetch_assoc($query1)) {
?>
    <div class="message">
      <p>
        <span><?php echo $row['message']; ?></span>
      </p>
    </div>
<?php
                }
            } else {
?>
<div class="message">
      <p>
        No previous chat available.
      </p>
</div>
<?php
            }
        }
    }
}
?>

  </div>
  <form class="form-horizontal" method="POST" action="">
    <div class="form-group">
      <div class="col-sm-10"> 
      <input type="hidden" name="owner_id" value="<?php echo $owner_id; ?>">    
      <input type="hidden" name="tenant_id" value="<?php echo $tenant_id; ?>">      
        <textarea name="message" class="form-control" placeholder="Type your message here..."></textarea>
      </div>
           
      <div class="col-sm-2">
        <input type="submit" name="send_message1" class="btn btn-primary" formmethod="post" value="Send">
      </div>

    </div>
  </form>
</div>

</body>
</html>
<?php
if (isset($_POST['send_message1'])) {
    $u_email = $_SESSION["email"];
    $message = trim($_POST['message']);  // Trim the input to avoid spaces as valid messages
    $owner_id = $_POST['owner_id'];
    $tenant_id = $_POST['tenant_id'];

    // Check if the message is empty
    if (empty($message)) {
        // Display an error message if no message is written
        echo "<script>alert('No message is written');</script>";
    } else {
        // Insert the new message into the chat table if it's not empty
        $sql = "INSERT INTO chat (message, owner_id, tenant_id) VALUES ('$message', '$owner_id', '$tenant_id')";
        $query = mysqli_query($db, $sql);

        if ($query) {
            // Refresh the page after sending the message
            header("Refresh:0");
        } else {
            // Handle the case when the insertion fails
            echo "<script>alert('Something went wrong. Please try again.');</script>";
        }
    }
}
?>

<center><button onclick="goBack()" class="btn btn-success">Go Back</button></center>

<script>
function goBack() {
  window.history.back();
}
</script>

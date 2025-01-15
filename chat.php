<?php
/*session_start();
isset($_SESSION["email"]);
include("navbar.php");
include("config.php");

if (isset($_GET['tenant_id']) && isset($_GET['owner_id'])) {
    $tenant_id = $_GET['tenant_id'];
    $owner_id = $_GET['owner_id'];
} else {
    echo "Invalid request.";
    exit;
}

if (isset($_POST['send-message'])) {
    $message = trim($_POST['message']);  // Trim the input to avoid spaces as valid messages

    if (!empty($message)) {
        // Insert the new message into the chat table if it's not empty
        $sql = "INSERT INTO chat (message, owner_id, tenant_id) VALUES ('$message', '$owner_id', '$tenant_id')";
        $query = mysqli_query($db, $sql);

        if (!$query) {
            echo "<script>alert('Message sending failed. Please try again.');</script>";
        }
    } else {
        echo "<script>alert('Please type a message to send.');</script>";
    }
}

// Fetch existing chat messages
$sql1 = "SELECT * FROM chat WHERE owner_id = '$owner_id' AND tenant_id = '$tenant_id' ORDER BY chat_id ASC";
$query1 = mysqli_query($db, $sql1);
?>

<style>
  h2 {
    color: white;
  }
  .container {
    margin-top: 3%;
    width: 60%;
    padding-right: 10%;
    padding-left: 10%;
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
  <center><h3>Chat with Tenant</h3></center>
  <div class="display-chat">
    <?php
    if (mysqli_num_rows($query1) > 0) {
        while ($row = mysqli_fetch_assoc($query1)) {
            echo '<div class="message"><span>' . htmlspecialchars($row['message']) . '</span></div>';
        }
    } else {
        echo '<div class="message"><span>No previous chat available.</span></div>';
    }
    ?>
  </div>

  <form method="POST" action="">
    <div class="form-group">
      <textarea name="message" class="form-control" placeholder="Type your message here..."></textarea>
      <input type="submit" name="send-message" class="btn btn-primary" value="Send">
    </div>
  </form>

  <center><button onclick="goBack()" class="btn btn-success">Go Back</button></center>
</div>

<script>
function goBack() {
  window.history.back();
}
</script>
</body>
</html>*/

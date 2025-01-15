<?php 

$db = mysqli_connect('localhost', 'root', '', 'renthouse');


if (!$db) {
    echo "Error connecting to the database: " . mysqli_connect_error();
}

?>
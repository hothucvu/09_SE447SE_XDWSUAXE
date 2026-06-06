<?php

// Create connection
$servername = "localhost";
$db_username = "root";
$db_password ="";
$dbname="cdio4";
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

if ($conn->connect_error === TRUE) {
  die("Connection failed: " . $conn->connect_error);
}

?>
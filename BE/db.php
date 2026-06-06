<?php

// Create connection
$servername = "localhost";
$db_username = "root";
$db_password ="";
$dbname="cdio4";
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection- kiếm trả thuộc tính connect_error của biến $conn
if ($conn->connect_error === TRUE) {
  die("Connection failed: " . $conn->connect_error);
}

?>
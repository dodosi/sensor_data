<?php 	 
$localhost = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "cmu_ur";

// db connection
$conn = new mysqli($localhost, $username, $password, $dbname);
// check connection
if($conn->connect_error) {
  die("Connection Failed : " . $connect->connect_error);
} else {
  // echo "Successfully connected";
}

?>
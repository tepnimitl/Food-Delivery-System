<?php
echo 'Connection Page'; 
# !!!! Come back to test this line na
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "geodelivery";
// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 
	echo "Connected successfully";
?>

<?php
$servername = "localhost";
$username = "visionar_writer";
$password = "visionarWriter";
$database = 'visionar_writing';
// Create connection
$conn = new mysqli($servername, $username, $password,$database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "UPDATE transaction SET cron='1' WHERE cron = '0'";

if ($conn->query($sql) === TRUE) {
    //echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>
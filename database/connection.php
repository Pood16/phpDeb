<?php



// Database configuration
$servername = 'localhost';
$username = 'root';
$password = '8951';
$dbname = 'situation';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// echo "connected";
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

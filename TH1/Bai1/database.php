<?php
$host = 'localhost';       
$username = 'root';        
$password = '';            
$database = 'flowers';     

// Kết nối đến database
$conn = new mysqli($host, $username, $password, $database);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

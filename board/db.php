<?php
// db.php
$host = 'localhost';
$username = 'root';
$password = 'e0425820';
$database = 'bulletin_board';

$connection = new mysqli($host, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
?>


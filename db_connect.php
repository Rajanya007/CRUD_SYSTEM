<?php
$servername = "";   // Enter your server host eg- localhost
$username = "";     // username associated with server
$password = "";     // server login password

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$createDB = "CREATE DATABASE IF NOT EXISTS rajanya";
$conn->query($createDB);
$dbname = "rajanya";
$conn = new mysqli($servername, $username, $password, $dbname);


$createtable = "CREATE TABLE IF NOT EXISTS MyGuests(
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
firstname VARCHAR(30) NOT NULL,
lastname VARCHAR(30) NOT NULL,
pass VARCHAR(30) NOT NULL,
email VARCHAR(50)
) ";

$conn->query($createtable);

// for ($i = 0; $i <= 10000; $i++) {
//     $INSERT = "INSERT INTO `myguests` (`firstname`, `lastname`,`pass`, `email`) VALUES ('Rajanya.$i', 'Joshi.$i', '123.$i','rajanya.$i.@gmail.com');";
//     $conn->query($INSERT);
// }

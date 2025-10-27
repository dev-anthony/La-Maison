<?php
$host = 'localhost';
$username = 'root';
$password = '';
$db_name = 'auth';

//$pdo = new PDO("mysql:host=$host; username=$username", $password, $db_name);
$conn = new mysqli($host, $username, $password, $db_name);

// $servername = "sql306.infinityfree.com";
// $username = "if0_40243861";
// $password = "d0IcnEX5zf7c"; // your vPanel password
// $dbname = "if0_40243861_auth";

// $conn = new mysqli($servername, $username, $password, $dbname);

// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }



?>
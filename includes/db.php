<?php
$servername = "localhost";
$username = "root";   // change if needed
$password = "";       // change if your MySQL has a password
$dbname = "studyplus";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

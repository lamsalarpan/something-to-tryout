<?php
// includes/db.php — update with your own DB info
$DB_HOST = "localhost";
$DB_NAME = "studyplus";
$DB_USER = "root";
$DB_PASS = "";

try{
  $pdo = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4", $DB_USER, $DB_PASS, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
  ]);
}catch(Exception $e){
  die("DB Error: " . $e->getMessage());
}

if (session_status() === PHP_SESSION_NONE) { session_start(); }
?>

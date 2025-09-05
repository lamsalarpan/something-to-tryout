<?php
// includes/header.php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
if(!isset($_SESSION['user'])){ header('Location: login.php'); exit; }
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Study+</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <div class="card">
    <header>
      <div>
        <h2>Hi, <?php echo htmlspecialchars($user['name']); ?> 👋</h2>
        <div class="small">Stay consistent. Little steps daily.</div>
      </div>
      <div class="nav">
        <a href="dashboard.php">Home</a>
        <a href="tasks.php">Tasks</a>
        <a href="studytimer.php">Study</a>
        <a href="timetable.php">Timetable</a>
        <a href="water.php">Water</a>
        <a href="analytics.php">Analytics</a>
        <a href="friends.php">Friends</a>
        <a href="notes.php">Notes</a>
        <a class="btn small outline" href="logout.php">Logout</a>
      </div>
    </header>

<?php
require_once __DIR__ . '/includes/db.php';
if(!isset($_SESSION['user'])){ http_response_code(403); exit; }
$subject = $_POST['subject'] ?? ($_GET['subject'] ?? 'General');
$minutes = (int)($_POST['minutes'] ?? ($_GET['minutes'] ?? 25));
$stmt=$pdo->prepare("INSERT INTO study_sessions (user_id,subject,duration,date) VALUES (?,?,?,CURDATE())");
$stmt->execute([$_SESSION['user']['id'],$subject,$minutes]);
echo 'ok';

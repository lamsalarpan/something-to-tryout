<?php
require_once __DIR__ . '/includes/db.php';
include __DIR__ . '/includes/header.php';

if($_SERVER['REQUEST_METHOD']==='POST'){
  $g = max(1, (int)($_POST['glasses'] ?? 1));
  $pdo->prepare("INSERT INTO water_intake (user_id,glasses,date) VALUES (?,?,CURDATE())")->execute([$user['id'],$g]);
}

$today = date('Y-m-d');
$w = $pdo->prepare("SELECT COALESCE(SUM(glasses),0) as g FROM water_intake WHERE user_id=? AND date=?");
$w->execute([$user['id'], $today]);
$glasses = (int)$w->fetch()['g'];
?>
  <h3>Water Intake</h3>
  <p class="small">Goal: 8 glasses per day</p>
  <div class="progress"><b style="width: <?php echo min(100,$glasses/8*100); ?>%"></b></div>
  <p><b><?php echo $glasses; ?></b>/8 glasses</p>
  <form method="post" class="row">
    <input class="input" style="max-width:100px" type="number" name="glasses" min="1" max="8" value="1">
    <button class="btn" type="submit">Add</button>
  </form>
<?php echo $footer_html; ?>

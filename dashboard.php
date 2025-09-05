<?php
require_once __DIR__ . '/includes/db.php';
include __DIR__ . '/includes/header.php';

// Fetch today's tasks
$today = date('Y-m-d');
$tasks = $pdo->prepare("SELECT * FROM tasks WHERE user_id=? AND (DATE(due_date)=? OR status='pending') ORDER BY status ASC, due_date ASC LIMIT 5");
$tasks->execute([$user['id'], $today]);
$tasks = $tasks->fetchAll();

// Water today
$w = $pdo->prepare("SELECT SUM(glasses) as g FROM water_intake WHERE user_id=? AND date=?");
$w->execute([$user['id'], $today]);
$glasses = (int)($w->fetch()['g'] ?? 0);
?>
  <section class="grid two">
    <div>
      <h3>Today's Tasks</h3>
      <ul>
        <?php foreach($tasks as $t): ?>
          <li class="row" style="justify-content:space-between">
            <span><?php echo htmlspecialchars($t['task_name']); ?></span>
            <span class="badge"><?php echo $t['status']; ?></span>
          </li>
        <?php endforeach; if(!count($tasks)) echo '<div class="small">No tasks yet.</div>'; ?>
      </ul>
      <div class="row" style="margin-top:10px">
        <a class="btn small" href="tasks.php">Add Task</a>
        <a class="btn small secondary" href="studytimer.php">Start Timer</a>
      </div>
    </div>
    <div>
      <h3>Water Intake</h3>
      <p class="small">Goal: 8 glasses</p>
      <div class="progress"><b style="width: <?php echo min(100, $glasses/8*100); ?>%"></b></div>
      <p><b><?php echo $glasses; ?></b>/8 glasses</p>
      <a class="btn small" href="water.php">Log water</a>
    </div>
  </section>
<?php echo $footer_html; ?>

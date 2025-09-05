<?php
require_once __DIR__ . '/includes/db.php';
include __DIR__ . '/includes/header.php';

$study=$pdo->prepare("SELECT subject, SUM(duration) as mins FROM study_sessions WHERE user_id=? GROUP BY subject");
$study->execute([$user['id']]);
$study=$study->fetchAll();

$done=$pdo->prepare("SELECT status, COUNT(*) c FROM tasks WHERE user_id=? GROUP BY status");
$done->execute([$user['id']]);
$done=$done->fetchAll();

?>
  <h3>Analytics</h3>
  <div class="grid two">
    <div>
      <h4>Study Minutes by Subject</h4>
      <canvas id="chart1" height="180"></canvas>
    </div>
    <div>
      <h4>Tasks Status</h4>
      <canvas id="chart2" height="180"></canvas>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const studyData = <?php echo json_encode($study); ?>;
    const tasksData = <?php echo json_encode($done); ?>;
    new Chart(document.getElementById('chart1'), {
      type:'bar',
      data:{ labels: studyData.map(x=>x.subject),
             datasets:[{ label:'Minutes', data: studyData.map(x=>x.mins) }] }
    });
    new Chart(document.getElementById('chart2'), {
      type:'doughnut',
      data:{ labels: tasksData.map(x=>x.status),
             datasets:[{ label:'Tasks', data: tasksData.map(x=>x.c) }] }
    });
  </script>
<?php echo $footer_html; ?>

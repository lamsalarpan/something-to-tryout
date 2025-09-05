<?php
require_once __DIR__ . '/includes/db.php';
include __DIR__ . '/includes/header.php';

if($_SERVER['REQUEST_METHOD']==='POST'){
  $stmt=$pdo->prepare("INSERT INTO timetable (user_id,subject,day_of_week,start_time,end_time) VALUES (?,?,?,?,?)");
  $stmt->execute([$user['id'], $_POST['subject'], $_POST['day_of_week'], $_POST['start_time'], $_POST['end_time']]);
}
if(isset($_GET['del'])){
  $pdo->prepare("DELETE FROM timetable WHERE id=? AND user_id=?")->execute([(int)$_GET['del'],$user['id']]);
  header('Location: timetable.php'); exit;
}
$rows=$pdo->prepare("SELECT * FROM timetable WHERE user_id=? ORDER BY FIELD(day_of_week,'Mon','Tue','Wed','Thu','Fri','Sat','Sun'), start_time");
$rows->execute([$user['id']]);
$rows=$rows->fetchAll();
?>
  <h3>Timetable</h3>
  <form method="post" class="grid two">
    <input class="input" name="subject" placeholder="Subject" required>
    <select class="input" name="day_of_week">
      <option>Mon</option><option>Tue</option><option>Wed</option><option>Thu</option><option>Fri</option><option>Sat</option><option>Sun</option>
    </select>
    <input class="input" type="time" name="start_time" required>
    <input class="input" type="time" name="end_time" required>
    <button class="btn" type="submit">Add</button>
  </form>
  <table>
    <tr><th>Day</th><th>Subject</th><th>Start</th><th>End</th><th></th></tr>
    <?php foreach($rows as $r): ?>
      <tr>
        <td><?php echo $r['day_of_week']; ?></td>
        <td><?php echo htmlspecialchars($r['subject']); ?></td>
        <td><?php echo $r['start_time']; ?></td>
        <td><?php echo $r['end_time']; ?></td>
        <td><a class="btn small danger" href="?del=<?php echo $r['id']; ?>">Delete</a></td>
      </tr>
    <?php endforeach; ?>
  </table>
<?php echo $footer_html; ?>

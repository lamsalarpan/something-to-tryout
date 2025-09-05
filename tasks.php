<?php
require_once __DIR__ . '/includes/db.php';
include __DIR__ . '/includes/header.php';

// Add
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['task_name'])){
  $stmt=$pdo->prepare("INSERT INTO tasks (user_id,task_name,due_date,status) VALUES (?,?,?, 'pending')");
  $stmt->execute([$user['id'], $_POST['task_name'], $_POST['due_date'] ?: NULL]);
}
// Toggle complete
if(isset($_GET['done'])){
  $id=(int)$_GET['done'];
  $pdo->prepare("UPDATE tasks SET status=IF(status='pending','completed','pending') WHERE id=? AND user_id=?")->execute([$id,$user['id']]);
  header('Location: tasks.php'); exit;
}
// Delete
if(isset($_GET['del'])){
  $id=(int)$_GET['del'];
  $pdo->prepare("DELETE FROM tasks WHERE id=? AND user_id=?")->execute([$id,$user['id']]);
  header('Location: tasks.php'); exit;
}

$list=$pdo->prepare("SELECT * FROM tasks WHERE user_id=? ORDER BY status ASC, due_date ASC, id DESC");
$list->execute([$user['id']]);
$rows=$list->fetchAll();
?>
  <h3>Tasks</h3>
  <form method="post" class="grid two">
    <input class="input" name="task_name" placeholder="Task name" required>
    <input class="input" type="datetime-local" name="due_date">
    <button class="btn" type="submit">Add Task</button>
  </form>
  <table>
    <tr><th>Task</th><th>Due</th><th>Status</th><th>Action</th></tr>
    <?php foreach($rows as $r): ?>
      <tr>
        <td><?php echo htmlspecialchars($r['task_name']); ?></td>
        <td><?php echo $r['due_date']; ?></td>
        <td><?php echo $r['status']; ?></td>
        <td class="row">
          <a class="btn small" href="?done=<?php echo $r['id']; ?>">Toggle</a>
          <a class="btn small danger" href="?del=<?php echo $r['id']; ?>" onclick="return confirm('Delete?')">Delete</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
<?php echo $footer_html; ?>

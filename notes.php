<?php
require_once __DIR__ . '/includes/db.php';
include __DIR__ . '/includes/header.php';

if($_SERVER['REQUEST_METHOD']==='POST'){
  $stmt=$pdo->prepare("INSERT INTO notes (user_id,title,content) VALUES (?,?,?)");
  $stmt->execute([$user['id'], $_POST['title'], $_POST['content']]);
}
$notes=$pdo->prepare("SELECT * FROM notes WHERE user_id=? ORDER BY id DESC");
$notes->execute([$user['id']]);
$notes=$notes->fetchAll();
?>
  <h3>Notes</h3>
  <form method="post" class="grid">
    <input class="input" name="title" placeholder="Title" required>
    <textarea class="input" name="content" rows="6" placeholder="Write your note..."></textarea>
    <button class="btn" type="submit">Save</button>
  </form>
  <h4>My Notes</h4>
  <ul>
    <?php foreach($notes as $n): ?>
      <li>
        <b><?php echo htmlspecialchars($n['title']); ?></b>
        <div class="small"><?php echo nl2br(htmlspecialchars($n['content'])); ?></div>
      </li>
    <?php endforeach; if(!count($notes)) echo '<div class="small">No notes yet.</div>'; ?>
  </ul>
<?php echo $footer_html; ?>

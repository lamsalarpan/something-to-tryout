<?php
require_once __DIR__ . '/includes/db.php';
include __DIR__ . '/includes/header.php';

// Send request
if(isset($_GET['add'])){
  $fid=(int)$_GET['add'];
  if($fid !== $user['id']){
    // Avoid duplicates
    $stmt=$pdo->prepare("SELECT 1 FROM friends WHERE user_id=? AND friend_id=?");
    $stmt->execute([$user['id'],$fid]);
    if(!$stmt->fetch()){
      $pdo->prepare("INSERT INTO friends (user_id,friend_id,status) VALUES (?,?, 'pending')")->execute([$user['id'],$fid]);
    }
  }
  header('Location: friends.php'); exit;
}
// Accept
if(isset($_GET['accept'])){
  $id=(int)$_GET['accept'];
  $pdo->prepare("UPDATE friends SET status='accepted' WHERE id=? AND friend_id=?")->execute([$id,$user['id']]);
  header('Location: friends.php'); exit;
}

$q = $_GET['q'] ?? '';
$search=[];
if($q){
  $stmt=$pdo->prepare("SELECT id,name,email FROM users WHERE (name LIKE ? OR email LIKE ?) AND id<>? LIMIT 10");
  $stmt->execute(['%'.$q.'%','%'.$q.'%',$user['id']]);
  $search=$stmt->fetchAll();
}

$incoming=$pdo->prepare("SELECT f.id,u.name FROM friends f JOIN users u ON u.id=f.user_id WHERE f.friend_id=? AND f.status='pending'");
$incoming->execute([$user['id']]);
$incoming=$incoming->fetchAll();

$friends=$pdo->prepare("SELECT u.id,u.name FROM friends f JOIN users u ON (u.id=f.friend_id) WHERE f.user_id=? AND f.status='accepted'");
$friends->execute([$user['id']]);
$friends=$friends->fetchAll();
?>
  <h3>Friends</h3>
  <form method="get" class="row">
    <input class="input" name="q" placeholder="Search name or email" value="<?php echo htmlspecialchars($q); ?>">
    <button class="btn" type="submit">Search</button>
  </form>
  <?php if($q): ?>
    <h4>Results</h4>
    <ul>
      <?php foreach($search as $s): ?>
        <li class="row" style="justify-content:space-between">
          <span><?php echo htmlspecialchars($s['name']).' ('.$s['email'].')'; ?></span>
          <a class="btn small" href="?add=<?php echo $s['id']; ?>">Add</a>
        </li>
      <?php endforeach; if(!count($search)) echo '<div class="small">No users.</div>'; ?>
    </ul>
  <?php endif; ?>
  <h4>Requests</h4>
  <ul>
    <?php foreach($incoming as $i): ?>
      <li class="row" style="justify-content:space-between">
        <span><?php echo htmlspecialchars($i['name']); ?></span>
        <a class="btn small" href="?accept=<?php echo $i['id']; ?>">Accept</a>
      </li>
    <?php endforeach; if(!count($incoming)) echo '<div class="small">No requests.</div>'; ?>
  </ul>
  <h4>My Friends</h4>
  <ul>
    <?php foreach($friends as $f): ?>
      <li><?php echo htmlspecialchars($f['name']); ?></li>
    <?php endforeach; if(!count($friends)) echo '<div class="small">No friends yet.</div>'; ?>
  </ul>
<?php echo $footer_html; ?>

<?php
require_once __DIR__ . '/includes/db.php';
if(isset($_SESSION['user'])){ header('Location: dashboard.php'); exit; }

$msg = "";
if($_SERVER['REQUEST_METHOD']==='POST'){
  $email = $_POST['email'] ?? '';
  $pass = $_POST['password'] ?? '';
  $stmt = $pdo->prepare("SELECT * FROM users WHERE email=?");
  $stmt->execute([$email]);
  $u = $stmt->fetch();
  if($u && password_verify($pass, $u['password'])){
    $_SESSION['user'] = $u;
    header('Location: dashboard.php'); exit;
  }else{
    $msg = "Wrong email or password.";
  }
}
?>
<!DOCTYPE html>
<html lang="en"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="assets/css/style.css"><title>Login • Study+</title></head>
<body class="center">
  <div class="card">
    <h2>Log In</h2>
    <?php if($msg): ?><div class="small" style="color:#ef4444"><?php echo $msg; ?></div><?php endif; ?>
    <form method="post" class="grid">
      <input class="input" name="email" type="email" placeholder="Email" required>
      <input class="input" name="password" type="password" placeholder="Password" required>
      <button class="btn" type="submit">Log In</button>
    </form>
    <p class="small">No account? <a href="signup.php">Sign up</a></p>
  </div>
</body></html>

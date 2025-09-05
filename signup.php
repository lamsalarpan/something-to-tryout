<?php
require_once __DIR__ . '/includes/db.php';
if(isset($_SESSION['user'])){ header('Location: dashboard.php'); exit; }
$msg = "";
if($_SERVER['REQUEST_METHOD']==='POST'){
  $name = $_POST['name'] ?? '';
  $email = $_POST['email'] ?? '';
  $pass = $_POST['password'] ?? '';
  try{
    $stmt = $pdo->prepare("INSERT INTO users (name,email,password,created_at) VALUES (?,?,?,NOW())");
    $stmt->execute([$name,$email,password_hash($pass, PASSWORD_BCRYPT)]);
    header('Location: login.php'); exit;
  }catch(Exception $e){
    $msg = "Sign up failed. Maybe email already used.";
  }
}
?>
<!DOCTYPE html>
<html lang="en"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="assets/css/style.css"><title>Sign Up • Study+</title></head>
<body class="center">
  <div class="card">
    <h2>Sign Up</h2>
    <?php if($msg): ?><div class="small" style="color:#ef4444"><?php echo $msg; ?></div><?php endif; ?>
    <form method="post" class="grid">
      <input class="input" name="name" placeholder="Full name" required>
      <input class="input" name="email" type="email" placeholder="Email" required>
      <input class="input" name="password" type="password" placeholder="Password" required>
      <button class="btn" type="submit">Create account</button>
    </form>
    <p class="small">Have an account? <a href="login.php">Log in</a></p>
  </div>
</body></html>

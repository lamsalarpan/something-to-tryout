<?php
include("includes/db.php");

if (isset($_POST['signup'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $query = $conn->prepare("INSERT INTO users (name, email, password, created_at) VALUES (?, ?, ?, NOW())");
    $query->bind_param("sss", $name, $email, $password);

    if ($query->execute()) {
        header("Location: login.php");
        exit;
    } else {
        $error = "Error: Could not sign up!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign Up - Study+</title>
</head>
<body>
<h2>Sign Up</h2>
<form method="POST" action="">
    <input type="text" name="name" placeholder="Full Name" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit" name="signup">Sign Up</button>
</form>
<?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
<p>Already have an account? <a href="login.php">Login</a></p>
</body>
</html>

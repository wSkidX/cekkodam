<?php
include 'connect.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$user' AND password='$pass'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        header("Location: interface.php");
        exit();
    } else {
        $message = "Username atau Password salah";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jaki</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<!-- ring div starts here -->
<div class="ring">
  <i style="--clr:#030637;"></i>
  <i style="--clr:#3C0753;"></i>
  <i style="--clr:#910A67;"></i>
  <div class="login">
    <h2>Login</h2>
    <form method="post" action="">
        <div class="inputBx">
            <input type="text" name="username" placeholder="Username" required>
        </div>
        <div class="inputBx">
            <input type="password" name="password" placeholder="Password" required>
        </div>
        <div class="inputBx">
            <input type="submit" value="Sign in">
        </div>
        <div class="links">
            <a href="signup.php">Signup</a>
        </div>
    </form>
    <?php if ($message): ?>
        <p class="message"><?php echo $message; ?></p>
    <?php endif; ?>
  </div>
</div>
<!-- ring div ends here -->
</body>
</html>

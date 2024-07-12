<?php
include 'connect.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $confirm_pass = $_POST['confirm_password'];

    if ($pass == $confirm_pass) {
        $sql = "INSERT INTO users (username, password) VALUES ('$user', '$pass')";
        if ($conn->query($sql) === TRUE) {
            $message = "Pendaftaran berhasil! Silakan login.";
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $message = "Password dan konfirmasi password tidak cocok";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- ring div starts here -->
    <div class="ring">
        <i style="--clr:#030637;"></i>
        <i style="--clr:#3C0753;"></i>
        <i style="--clr:#910A67;"></i>
        <div class="login">
            <h2>Signup</h2>
            <form method="post" action="">
                <div class="inputBx">
                    <input type="text" name="username" placeholder="Username" required>
                </div>
                <div class="inputBx">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <div class="inputBx">
                    <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                </div>
                <div class="inputBx">
                    <input type="submit" value="Signup">
                </div>
                <div class="links">
                    <a href="index.php">Login</a>
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
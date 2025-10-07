<?php 
require_once 'config.php';

if(isset($_POST['register'])){
    $username = (string)trim($_POST['username']);
    $password = (string)trim($_POST['password']);
    if($username !="" && $password !=""){
        $stmt = mysqli_prepare($conn, "INSERT INTO users (username, password) VALUES (?, ?)");
        mysqli_stmt_bind_param($stmt, "ss", $username, $password);
        mysqli_stmt_execute($stmt);
    }
    header('location: register.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Register</h2>
    <form action="" method="post">
        <input type="text" name="username" placeholder="Masukkan Username"> <br>
        <input type="text" name="password" placeholder="Masukkan Password"> <br>
        <button type="submit" name="register">Register</button>
    </form>
    <p>Sudah Punya Akun? <a href="login.php">Login</a></p>
</body>
</html>
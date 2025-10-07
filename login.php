<?php
require_once 'config.php';

session_start();
if(isset($_POST['login'])){
    $username = (string)trim($_POST['username']);
    $password = (string)trim($_POST['password']);
    if($username !="" && $password !=""){
        $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE username = ? AND password = ? ");
        mysqli_stmt_bind_param($stmt, "ss", $username, $password);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $_SESSION["username"] = $user["username"];
            $_SESSION["password"] = $user["password"];
            header("Location: index.php");
            exit;
        } else {
            // Login gagal
            $error_message = "user atau Password salah!";
        }
        $stmt->close();
        $conn->close();  
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Login</h2>
    <form action="" method="post">
        <input type="text" name="username" placeholder="Masukkan Username"> <br>
        <input type="text" name="password" placeholder="Masukkan Password"> <br>
        <button type="submit" name="login">Login</button>
    </form>
    <p>Belum Punya Akun? <a href="register.php">Register</a></p>
</body>
</html>
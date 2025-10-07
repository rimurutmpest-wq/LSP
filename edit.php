<?php
require 'config.php';

if(isset($_POST['update'])){
    $id = (string)$_GET['id']; 
    $nama = (string)trim($_POST['nama']);
    $deskripsi = (string)trim($_POST['deskripsi']);
    $prioritas = (string)trim($_POST['prioritas']);
    $status = (string)trim($_POST['status']);
    $tanggal_jatuh_tempo = $_POST['tanggal_jatuh_tempo'];
    if($nama !="" && $deskripsi !="" && $prioritas !="" && $status !="" && $tanggal_jatuh_tempo !=""){
        $stmt = mysqli_prepare($conn, "UPDATE tasks SET nama = ?, deskripsi = ?, prioritas = ?, status = ?, tanggal_jatuh_tempo = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "sssisi", $nama, $deskripsi, $prioritas, $status, $tanggal_jatuh_tempo, $id);
        mysqli_stmt_execute($stmt);
    }
    header ('location: index.php');
    exit;
}

$id = (string)$_GET['id'];
$getById = mysqli_query($conn, "SELECT * FROM tasks WHERE id = $id");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Manajemen Tugas</h2>
    <form action="" method="post">
        <?php while($row=mysqli_fetch_assoc($getById)) : ?>
        <input type="text" name="id" value="<?= $row['id'] ?>">
        <input type="text" name="nama" value="<?= $row['nama'] ?>">
        <input type="text" name="deskripsi" value="<?= $row['deskripsi'] ?>">
        <select name = "prioritas" value="<?= $row['prioritas'] ?>">
        <?php if($row['prioritas'] == "1") :?>
            <option value="<?= $row['prioritas']?>" selected style="color:green">Urgent</option>
            <option value= 0 name="tidak-urgent" style="color:green">Tidak_Urgent</option>
        <?php else : ?>
            <option value="<?= $row['prioritas']?>" selected style="color:green">Tidak Urgent</option>
            <option value= 1 name="urgent" style="color:red">Urgent</option>
        </select>
        <?php endif; ?>
        <select name="status" value="<?= $row['status'] ?>">
        <?php if($row['status'] == 1) :?>
            <option value="<?= $row['status']?>" selected> Selesai</option>
            <option value=0 style="color:red">Belum Selesai</option>
        <?php elseif ($row['status'] == 0): ?>
            <option value="<?= $row['status']?>" selected>Belum Selesai</option>
            <option value=1 style="color:green">Selesai</option>
        </select>
        <?php endif; ?>
        <input type="date" name="tanggal_jatuh_tempo" value="<?= $row['tanggal_jatuh_tempo'] ?>">
        <button type="submit" name="update">Submit</button>
    </form>
    <?php endwhile ?>
</body>
</html>
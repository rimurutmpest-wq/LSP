<?php
session_start();
require_once 'config.php' ;

if(isset($_POST['add'])){
    $nama = (string)trim($_POST['nama']);
    $deskripsi = (string)trim($_POST['deskripsi']);
    $prioritas = (integer)trim($_POST['prioritas']);
    $status = (string)trim($_POST['status']);
    $tanggal_jatuh_tempo = $_POST['tanggal_jatuh_tempo'];
    if($nama !="" && $deskripsi !="" && $prioritas !="" && $status !="" && $tanggal_jatuh_tempo !=""){
        $stmt = mysqli_prepare($conn, "INSERT INTO tasks (nama, deskripsi, prioritas, status, tanggal_jatuh_tempo) VALUES (?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sssis", $nama, $deskripsi, $prioritas, $status, $tanggal_jatuh_tempo);
        mysqli_stmt_execute($stmt);
    }
    header ('location: index.php');
    exit;
}

if(isset($_GET['delete'])){
    $id = $_GET['id'];
    if($id !=""){
        $stmt = mysqli_prepare($conn, "DELETE FROM tasks WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
    }
    header('location: index.php');
    exit;
}


$search = isset($_GET['search']) ? $_GET['search'] : '';

$getAll = mysqli_query($conn, "SELECT * FROM tasks");

$query = "SELECT * FROM tasks WHERE nama LIKE ? OR deskripsi LIKE ?";
$stmt = $conn->prepare($query);
$searchParam = '%' . $search . '%';
mysqli_stmt_bind_param($stmt, 'ss', $searchParam, $searchParam);
mysqli_stmt_execute($stmt);
$getAll = $stmt->get_result();


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
    <h2>Manajemen Tugas</h2>
    <a href="logout.php">Logout</a>
    <form action="" method="post">
        <input type="text" name="nama" placeholder="Masukkan Nama">
        <input type="text" name="deskripsi" placeholder="Masukkan Deskripsi">
        <select name = "prioritas">
            <option value="" selected disabled>Pilih Prioritas</option>
            <option value="1" style="color:red">urgent</option>
            <option value="0" style="color:green">tidak_urgent</option>
        </select>
        <select name="status">
            <option value="" selected disabled>Pilih Status</option>
            <option value=1 style="color:green">Selesai</option>
            <option value=0 style="color:red">Belum Selesai</option>
        </select>
        <input type="date" name="tanggal_jatuh_tempo">
        <button type="submit" name="add">Submit</button>
    </form>

    <form action="" method="get">
        <input type="text" name="search" placeholder="Cari Berdasarkan Nama atau Deskripsi" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        <button type="submit">Cari</button>
    </form>
    <table border="true">
        <tr>
            <th>ID</th>
            <th>Nama Tugas</th>
            <th>Deskripsi</th>
            <th>Prioritas</th>
            <th>Status</th>
            <th>Tanggal Jatuh Tempo</th>
            <th>Aksi</th>
        </tr> 
        <?php while ($row = $getAll->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['id']) ?></td>
            <?php if($row['status'] == 1) : ?>
            <td><s><?= htmlspecialchars($row['nama']) ?></s></td>
            <?php else : ?>
            <td><?= htmlspecialchars($row['nama']) ?></td>
            <?php endif ?>
            <td><?= htmlspecialchars($row['deskripsi']) ?></td>
            <?php if($row['prioritas'] == 1) : ?>
            <td style="color:red">Urgent</td>
            <?php elseif ($row['prioritas'] == 0) :?>
            <td style="color:green">Tidak Urgent</td>
            <?php endif ?>
            <?php if($row['status'] == 0) : ?>
            <td style="color: red;">Belum Selesai</td>
            <?php else : ?>
            <td style="color: green;">Selesai</td>
            <?php endif; ?>
            <td><?= htmlspecialchars($row['tanggal_jatuh_tempo']) ?></td>
            <td>
                <a href="edit.php?id=<?=$row['id'] ?>">Edit</a>
                <form action="" metdod="get" onclick="return confirm('Yakin ingin hapus tugas?')" >
                    <input type="hidden" name="id" value="<?=$row['id']?>">
                    <button type="submit" name="delete">Hapus</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <img src="gambar.jpeg" alt="">
</body>
</html>
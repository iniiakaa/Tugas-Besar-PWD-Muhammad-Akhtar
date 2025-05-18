
<link rel="stylesheet" href="css/pengguna.css">
<?php
include 'koneksi.php'; 

// Inisialisasi variabel edit
$edit_mode = false;
$edit_id = "";
$edit_username = "";

// Tambah Pengguna
if (isset($_POST['tambah'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // password aman
    $conn->query("INSERT INTO users (username, password) VALUES ('$username', '$password')");
    header("Location: dashboard.php?modul=pengguna");
    exit;
}

// Hapus Pengguna
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $conn->query("DELETE FROM users WHERE id = $id");
    header("Location: dashboard.php?modul=pengguna");
    exit;
}

// Ambil data untuk edit jika ada
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM users WHERE id = $edit_id");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $edit_mode = true;
        $edit_username = $row['username'];
    }
}

// Proses Update
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $conn->query("UPDATE users SET username = '$username', password = '$password' WHERE id = $id");
    header("Location: dashboard.php?modul=pengguna");
    exit;
}

// Ambil semua pengguna
$pengguna = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Pengguna</title>
  
</head>
<body>

<h1>Selamat datang di Audit Pengguna!</h1>




<?php if ($edit_mode): ?>
<!-- Form Edit -->
<h3>Edit Pengguna</h3>
<form method="POST">
    <input type="hidden" name="id" value="<?= $edit_id ?>">
    <input type="text" name="username" value="<?= $edit_username ?>" required>
    <input type="password" name="password" placeholder="Password Baru" required>
    <button type="submit" name="update">Update</button>
    <a href="dashboard.php?modul=pengguna">Batal</a>
</form>
<?php else: ?>
<!-- Form Tambah -->
<h3>Tambah Pengguna</h3>
<form method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" name="tambah">Tambah</button>
</form>
<?php endif; ?>

<!-- Tabel Pengguna -->
<table>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Aksi</th>
    </tr>
    <?php while ($row = $pengguna->fetch_assoc()): ?>
    <tr<?= $edit_mode && $edit_id == $row['id'] ? ' class="highlight"' : '' ?>>
        <td><?= $row['id'] ?></td>
        <td><?= $row['username'] ?></td>
        <td>
            <a href="dashboard.php?modul=pengguna&edit=<?= $row['id'] ?>">Edit</a> |
            <a href="dashboard.php?modul=pengguna&hapus=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus pengguna ini?')">Hapus</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>

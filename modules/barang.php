<link rel="stylesheet" href="css/barang.css">
<?php
include 'koneksi.php'; 

// Inisialisasi variabel 
$edit_mode = false;
$edit_id = "";
$edit_nama = "";
$edit_harga = "";
$edit_stok = "";
$edit_foto = "";
$edit_kategori = "";

// Tambah Barang
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $kategori = $_POST['kategori'];

    $foto = "";
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $foto = basename($_FILES['foto']['name']);
        $tmp = $_FILES['foto']['tmp_name'];
        move_uploaded_file($tmp, "uploads/" . $foto);
    }

    $conn->query("INSERT INTO barang (nama, harga, stok, foto, kategori) VALUES ('$nama', '$harga', '$stok', '$foto', '$kategori')");
    header("Location: dashboard.php?modul=barang");
    exit;
}

// Hapus Barang
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $data = $conn->query("SELECT foto FROM barang WHERE id = $id")->fetch_assoc();
    if ($data && $data['foto'] && file_exists("uploads/" . $data['foto'])) {
        unlink("uploads/" . $data['foto']);
    }

    $conn->query("DELETE FROM barang WHERE id = $id");
    header("Location: dashboard.php?modul=barang");
    exit;
}

// Ambil data untuk edit
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM barang WHERE id = $edit_id");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $edit_mode = true;
        $edit_nama = $row['nama']; 
        $edit_harga = $row['harga'];
        $edit_stok = $row['stok'];
        $edit_foto = $row['foto'];
        $edit_kategori = $row['kategori'];
    }
}

// Update Barang
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $foto = $_POST['foto'] ?? '';
    $kategori = $_POST['kategori'];

    if (!empty($_FILES['foto']['name'])) {
        $foto = basename($_FILES['foto']['name']);
        $tmp = $_FILES['foto']['tmp_name'];
        move_uploaded_file($tmp, "uploads/" . $foto);
        $conn->query("UPDATE barang SET nama = '$nama', harga = '$harga', stok = '$stok', foto = '$foto', kategori = '$kategori' WHERE id = $id");
    } else {
        $conn->query("UPDATE barang SET nama = '$nama', harga = '$harga', stok = '$stok', kategori = '$kategori' WHERE id = $id");
    }

    header("Location: dashboard.php?modul=barang");
    exit;
}

// Ambil semua data barang
$barang = $conn->query("SELECT * FROM barang");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Barang</title>
    <style>
        img { max-width: 50px; height: auto; }
        table, th, td { border: 1px solid black; border-collapse: collapse; padding: 5px; }
        form input { margin: 5px 0; display: block; }
    </style>
</head>
<body>

<h1>Manajemen Data Barang</h1>

<?php if ($edit_mode): ?>
<h3>Edit Barang</h3>
<form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $edit_id ?>">
    <input type="text" name="nama" value="<?= htmlspecialchars($edit_nama) ?>" required>
    <input type="number" name="harga" value="<?= $edit_harga ?>" required>
    <input type="number" name="stok" value="<?= $edit_stok ?>" required>
    <input type="text" name="kategori" value="<?= htmlspecialchars($edit_kategori) ?>" required>
    <input type="file" name="foto">
    <button type="submit" name="update">Update</button>
    <a href="dashboard.php?modul=barang">Batal</a>
</form>
<?php else: ?>
<h3>Tambah Barang</h3>
<form method="POST" enctype="multipart/form-data">
    <input type="text" name="nama" placeholder="Nama Barang" required>
    <input type="number" name="harga" placeholder="Harga" required>
    <input type="number" name="stok" placeholder="Stok" required>
    <input type="file" name="foto" required>
    <input type="text" name="kategori" placeholder="Kategori" required>
    <button type="submit" name="tambah">Tambah</button>
</form>
<?php endif; ?>

<!-- Tabel Barang -->
<table>
    <tr>
        <th>ID</th>
        <th>Nama</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Foto</th>
        <th>Aksi</th>
    </tr>
    <?php while ($row = $barang->fetch_assoc()): ?>
    <tr<?= $edit_mode && $edit_id == $row['id'] ? ' style="background:#eee;"' : '' ?>>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['nama']) ?></td>
        <td><?= number_format($row['harga'], 0, ',', '.') ?></td>
        <td><?= $row['stok'] ?></td>
        <td>
            <?php if ($row['foto']): ?>
                <img src="uploads/<?= htmlspecialchars($row['foto']) ?>" alt="foto">
            <?php else: ?>
                Tidak ada foto
            <?php endif; ?>
        </td>
        <td>
            <a href="dashboard.php?modul=barang&edit=<?= $row['id'] ?>">Edit</a> |
            <a href="dashboard.php?modul=barang&hapus=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus barang ini?')">Hapus</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
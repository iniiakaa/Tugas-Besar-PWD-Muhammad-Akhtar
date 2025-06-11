<link rel="stylesheet" href="css/manual.css">
<link rel="stylesheet" href="css/iya.css">
<?php
include 'koneksi.php';

$edit_mode = false;
$edit_id = "";
$edit_judul = "";
$edit_deskripsi = "";
$edit_file = "";

// Proses Tambah
if (isset($_POST['tambah'])) {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal_upload = date("Y-m-d H:i:s");

    $file_manual = "";
    if ($_FILES['file_manual']['error'] === UPLOAD_ERR_OK) {
        $file_manual = basename($_FILES['file_manual']['name']);
        move_uploaded_file($_FILES['file_manual']['tmp_name'], "uploads/manual/" . $file_manual);
    }

    $conn->query("INSERT INTO manual_book (judul, deskripsi, file_manual, tanggal_upload) VALUES 
        ('$judul', '$deskripsi', '$file_manual', '$tanggal_upload')");

    header("Location: dashboard.php?modul=manual-book");
    exit;
}

// Proses Hapus
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $result = $conn->query("SELECT file_manual FROM manual_book WHERE id = $id");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['file_manual'] && file_exists("uploads/manual/" . $row['file_manual'])) {
            unlink("uploads/manual/" . $row['file_manual']);
        }
    }

    $conn->query("DELETE FROM manual_book WHERE id = $id");
    header("Location: dashboard.php?modul=manual-book");
    exit;
}

// Proses Edit
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM manual_book WHERE id = $edit_id");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $edit_mode = true;
        $edit_judul = $row['judul'];
        $edit_deskripsi = $row['deskripsi'];
        $edit_file = $row['file_manual'];
    }
}

// Proses Update
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];

    if (!empty($_FILES['file_manual']['name'])) {
        $file_manual = basename($_FILES['file_manual']['name']);
        move_uploaded_file($_FILES['file_manual']['tmp_name'], "uploads/manual/" . $file_manual);
        $conn->query("UPDATE manual_book SET judul='$judul', deskripsi='$deskripsi', file_manual='$file_manual' WHERE id=$id");
    } else {
        $conn->query("UPDATE manual_book SET judul='$judul', deskripsi='$deskripsi' WHERE id=$id");
    }

    header("Location: dashboard.php?modul=manual-book");
    exit;
}

// Ambil semua data manual book
$manual_books = $conn->query("SELECT * FROM manual_book ORDER BY tanggal_upload DESC");
?>


<h1>Manajemen Manual Book</h1>

<?php if ($edit_mode): ?>
    <h3>Edit Manual Book</h3>
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $edit_id ?>">
        <input type="text" name="judul" value="<?= htmlspecialchars($edit_judul) ?>" required>
        <textarea name="deskripsi" required><?= htmlspecialchars($edit_deskripsi) ?></textarea>
        <p class="file-link">File sekarang: <a href="uploads/manual/<?= htmlspecialchars($edit_file) ?>" target="_blank"><?= $edit_file ?></a></p>
        <input type="file" name="file_manual">
        <button type="submit" name="update">Update</button>
        <a href="dashboard.php?modul=manual-book">Batal</a>
    </form>
<?php else: ?>
    <h3>Tambah Manual Book</h3>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="judul" placeholder="Judul" required>
        <textarea name="deskripsi" placeholder="Deskripsi" required></textarea>
        <input type="file" name="file_manual" required>
        <button type="submit" name="tambah">Tambah</button>
    </form>
<?php endif; ?>

<h3>Daftar Manual Book</h3>
<table>
    <tr>
        <th>ID</th>
        <th>Judul</th>
        <th>Deskripsi</th>
        <th>File</th>
        <th>Tanggal Upload</th>
        <th>Aksi</th>
    </tr>
    <?php while ($row = $manual_books->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['judul']) ?></td>
            <td><?= htmlspecialchars($row['deskripsi']) ?></td>
            <td><a href="uploads/manual/<?= htmlspecialchars($row['file_manual']) ?>" target="_blank">Lihat</a></td>
            <td><?= $row['tanggal_upload'] ?></td>
            <td>
                <a href="dashboard.php?modul=manual-book&edit=<?= $row['id'] ?>">Edit</a> |
                <a href="dashboard.php?modul=manual-book&hapus=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

</body>
</html>

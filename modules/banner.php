<link rel="stylesheet" href="css/banner.css">
<?php
include 'koneksi.php';

$edit_mode = false;
$edit_id = "";
$edit_judul = "";
$edit_gambar = "";

// Tambah Banner
if (isset($_POST['submit'])) {
    $judul = $conn->real_escape_string($_POST['judul']);

    $gambar = "";
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $gambar = basename($_FILES['gambar']['name']);
        $tmp = $_FILES['gambar']['tmp_name'];
        move_uploaded_file($tmp, "uploads/" . $gambar);
    }

    $conn->query("INSERT INTO banner (judul, gambar) VALUES ('$judul', '$gambar')");
    header("Location: dashboard.php?modul=banner");
    exit;
}

// Update Banner
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $judul = $conn->real_escape_string($_POST['judul']);

    if (!empty($_FILES['gambar']['name'])) {
        // Hapus gambar lama
        $old = $conn->query("SELECT gambar FROM banner WHERE id = $id")->fetch_assoc();
        if ($old && $old['gambar'] && file_exists("uploads/" . $old['gambar'])) {
            unlink("uploads/" . $old['gambar']);
        }

        $gambar = basename($_FILES['gambar']['name']);
        $tmp = $_FILES['gambar']['tmp_name'];
        move_uploaded_file($tmp, "uploads/" . $gambar);

        $conn->query("UPDATE banner SET judul = '$judul', gambar = '$gambar' WHERE id = $id");
    } else {
        $conn->query("UPDATE banner SET judul = '$judul' WHERE id = $id");
    }

    header("Location: dashboard.php?modul=banner");
    exit;
}

// Hapus Banner
if (isset($_GET['modul']) && $_GET['modul'] == 'banner' && isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];

    $result = $conn->query("SELECT gambar FROM banner WHERE id = $id");
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['gambar'] && file_exists("uploads/" . $row['gambar'])) {
            unlink("uploads/" . $row['gambar']);
        }
    }

    $conn->query("DELETE FROM banner WHERE id = $id");
    header("Location: dashboard.php?modul=banner");
    exit;
}

// Ambil data untuk edit
if (isset($_GET['modul']) && $_GET['modul'] == 'banner' && isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM banner WHERE id = $edit_id");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $edit_mode = true;
        $edit_judul = $row['judul'];
        $edit_gambar = $row['gambar'];
    }
}

// Ambil semua data
$banners = $conn->query("SELECT * FROM banner");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Banner</title>
    <link rel="stylesheet" href="css/banner.css">
    <style>
        img { max-width: 120px; height: auto; }
        table, th, td { border: 1px solid #ccc; border-collapse: collapse; padding: 5px; }
        input, button { margin: 5px 0; display: block; }
    </style>
</head>
<body>

<h2><?= $edit_mode ? 'Edit Banner' : 'Tambah Banner' ?></h2>

<form method="POST" enctype="multipart/form-data">
    <?php if ($edit_mode): ?>
        <input type="hidden" name="id" value="<?= $edit_id ?>">
    <?php endif; ?>
    <input type="text" name="judul" placeholder="Judul Banner" value="<?= htmlspecialchars($edit_judul) ?>" required>
    <input type="file" name="gambar" <?= $edit_mode ? '' : 'required' ?>>
    <?php if ($edit_mode && $edit_gambar): ?>
        <p>Gambar saat ini:</p>
        <img src="uploads/<?= htmlspecialchars($edit_gambar) ?>" alt="Gambar Lama">
    <?php endif; ?>
    <button type="submit" name="<?= $edit_mode ? 'update' : 'submit' ?>">
        <?= $edit_mode ? 'Update' : 'Simpan' ?> Banner
    </button>
    <?php if ($edit_mode): ?>
        <a href="dashboard.php?modul=banner">Batal</a>
    <?php endif; ?>
</form>

<hr>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Judul</th>
            <th>Gambar</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $banners->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['judul']) ?></td>
                <td>
                    <?php if ($row['gambar'] && file_exists("uploads/" . $row['gambar'])): ?>
                        <img src="uploads/<?= htmlspecialchars($row['gambar']) ?>" alt="Banner">
                    <?php else: ?>
                        Tidak ada gambar
                    <?php endif; ?>
                </td>
                <td>
                    <a href="dashboard.php?modul=banner&edit=<?= $row['id'] ?>">Edit</a> |
                    <a href="dashboard.php?modul=banner&hapus=<?= $row['id'] ?>" onclick="return confirm('Hapus banner ini?')">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

</body>
</html>

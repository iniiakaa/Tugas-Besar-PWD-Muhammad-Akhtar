<?php
// ===================== KONEKSI DATABASE =====================
include 'koneksi.php'; // koneksi ke database

// ===================== VARIABEL EDIT =====================
$edit_mode = false;
$edit_id = "";
$edit_judul = "";
$edit_tanggal = "";
$edit_isi = "";
$edit_gambar = "";

// ===================== PROSES CRUD =====================
// Tambah Artikel
if (isset($_POST['tambah'])) {
    $judul = $_POST['judul'];
    $tanggal = $_POST['tanggal'];
    $isi = $_POST['isi'];

    $gambar = "";
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $gambar = basename($_FILES['gambar']['name']);
        $tmp = $_FILES['gambar']['tmp_name'];
        move_uploaded_file($tmp, "uploads/" . $gambar);
    }

    $conn->query("INSERT INTO artikel (judul, tanggal, isi, gambar) 
                 VALUES ('$judul', '$tanggal', '$isi', '$gambar')");
    header("Location: dashboard.php?modul=artikel");
    exit;
}

// Hapus Artikel
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $data = $conn->query("SELECT gambar FROM artikel WHERE id = $id")->fetch_assoc();
    if ($data && $data['gambar'] && file_exists("uploads/" . $data['gambar'])) {
        unlink("uploads/" . $data['gambar']);
    }

    $conn->query("DELETE FROM artikel WHERE id = $id");
    header("Location: dashboard.php?modul=artikel");
    exit;
}

// Ambil data untuk edit
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM artikel WHERE id = $edit_id");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $edit_mode = true;
        $edit_judul = $row['judul']; 
        $edit_tanggal = $row['tanggal'];
        $edit_isi = $row['isi'];
        $edit_gambar = $row['gambar'];
    }
}

// Update Artikel
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $tanggal = $_POST['tanggal'];
    $isi = $_POST['isi'];
    $gambar = $_POST['gambar'] ?? '';

    if (!empty($_FILES['gambar']['name'])) {
        $gambar = basename($_FILES['gambar']['name']);
        $tmp = $_FILES['gambar']['tmp_name'];
        move_uploaded_file($tmp, "uploads/" . $gambar);
        $conn->query("UPDATE artikel SET judul = '$judul', tanggal = '$tanggal', 
                     isi = '$isi', gambar = '$gambar' WHERE id = $id");
    } else {
        $conn->query("UPDATE artikel SET judul = '$judul', tanggal = '$tanggal', 
                     isi = '$isi' WHERE id = $id");
    }

    header("Location: dashboard.php?modul=artikel");
    exit;
}

// Ambil semua data artikel
$artikel = $conn->query("SELECT * FROM artikel ORDER BY tanggal DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Artikel</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        
        body {
            
            background-color: #f5f5f5;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        h1, h2, h3 {
            margin-bottom: 15px;
            color: #333;
        }
        
        .form-container {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        input[type="text"],
        input[type="date"],
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        textarea {
            min-height: 100px;
            resize: vertical;
        }
        
        button {
            padding: 8px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 10px;
        }
        
        button:hover {
            background-color: #45a049;
        }
        
        .btn-cancel {
            background-color: #f44336;
        }
        
        .btn-cancel:hover {
            background-color: #d32f2f;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        
        tr:hover {
            background-color: #f9f9f9;
        }
        
        .action-links a {
            text-decoration: none;
            color: #2196F3;
            margin-right: 10px;
        }
        
        .action-links a:hover {
            text-decoration: underline;
        }
        
        .img-preview {
            max-width: 100px;
            height: auto;
            display: block;
        }
        
        .edit-row {
            background-color: #ffffcc !important;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Manajemen Artikel</h1>
        
        <?php if ($edit_mode): ?>
        <div class="form-container">
            <h3>Edit Artikel</h3>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $edit_id ?>">
                
                <div class="form-group">
                    <label for="judul">Judul Artikel</label>
                    <input type="text" name="judul" value="<?= htmlspecialchars($edit_judul) ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" name="tanggal" value="<?= $edit_tanggal ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="isi">Isi Artikel</label>
                    <textarea name="isi" required><?= htmlspecialchars($edit_isi) ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="gambar">Gambar</label>
                    <?php if ($edit_gambar): ?>
                        <img src="uploads/<?= $edit_gambar ?>" class="img-preview">
                    <?php endif; ?>
                    <input type="file" name="gambar">
                </div>
                
                <button type="submit" name="update">Update</button>
                <a href="dashboard.php?modul=artikel" class="btn-cancel">Batal</a>
            </form>
        </div>
        <?php else: ?>
        <div class="form-container">
            <h3>Tambah Artikel Baru</h3>
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="judul">Judul Artikel</label>
                    <input type="text" name="judul" placeholder="Judul artikel" required>
                </div>
                
                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" name="tanggal" required>
                </div>
                
                <div class="form-group">
                    <label for="isi">Isi Artikel</label>
                    <textarea name="isi" placeholder="Isi artikel" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="gambar">Gambar</label>
                    <input type="file" name="gambar">
                </div>
                
                <button type="submit" name="tambah">Tambah</button>
            </form>
        </div>
        <?php endif; ?>
        
        <!-- Tabel Artikel -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Judul</th>
                    <th>Tanggal</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $artikel->fetch_assoc()): ?>
                <tr<?= $edit_mode && $edit_id == $row['id'] ? ' class="edit-row"' : '' ?>>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['judul']) ?></td>
                    <td><?= date("d M Y", strtotime($row['tanggal'])) ?></td>
                    <td>
                        <?php if ($row['gambar']): ?>
                            <img src="uploads/<?= htmlspecialchars($row['gambar']) ?>" class="img-preview">
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td class="action-links">
                        <a href="dashboard.php?modul=artikel&edit=<?= $row['id'] ?>">Edit</a>
                        <a href="dashboard.php?modul=artikel&hapus=<?= $row['id'] ?>" 
                           onclick="return confirm('Yakin ingin menghapus artikel ini?')">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
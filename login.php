<?php
session_start();
require 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Validasi input sederhana
    if (empty($username) || empty($password)) {
        $_SESSION['error'] = "Username dan password wajib diisi!";
        header("Location: masuk.php");
        exit;
    }

    // Ambil data user dari database
    $stmt = $conn->prepare("SELECT username, password, role FROM users WHERE username = ?");
    
    if ($stmt === false) {
        die("Error prepare: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    // Jika user ditemukan
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($db_username, $db_password, $db_role);
        $stmt->fetch();

        // Verifikasi password
        if (password_verify($password, $db_password)) {
            $_SESSION["username"] = $db_username;
            $_SESSION["role"] = $db_role;

            // Redirect berdasarkan peran
            if ($db_role === 'admin') {
                header("Location: dashboard.php");
            } else {
                header("Location: index.php");
            }
            exit;
        } else {
            $_SESSION['error'] = "Password salah!";
            header("Location: masuk.php");
            exit;
        }
    } else {
        $_SESSION['error'] = "Username tidak ditemukan!";
        header("Location: masuk.php");
        exit;
    }

    $stmt->close();
}

$conn->close();
?>

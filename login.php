<?php
session_start();
require 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Cari user di database
    $stmt = $conn->prepare("SELECT username, password FROM users WHERE username = ?");
    
    if ($stmt === false) {
        die("Error: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    // Jika username ditemukan
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($db_username, $db_password);
        $stmt->fetch();

        // Verifikasi password
        if (password_verify($password, $db_password)) {
            $_SESSION["username"] = $db_username;
            header("Location: dashboard.php");
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
<?php
session_start();
require 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Validasi password
    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Konfirmasi password tidak sesuai";
        header("Location: daftar.php");
        exit();
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Cek username sudah ada
    $stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
    if ($stmt === false) die("Error: " . $conn->error);
    
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['error'] = "Username sudah digunakan";
        header("Location: daftar.php");
        exit();
    }

    // Insert ke database
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    if ($stmt === false) die("Error: " . $conn->error);
    
    $stmt->bind_param("ss", $username, $hashedPassword);

    if ($stmt->execute()) {
        $_SESSION["username"] = $username;
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['error'] = "Terjadi kesalahan server";
        header("Location: daftar.php");
        exit();
    }

    $stmt->close();
}

$conn->close();
?>
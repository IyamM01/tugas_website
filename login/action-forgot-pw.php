<?php
session_start();
include '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];

    // Cek apakah email terdaftar
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        // Hash password baru
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update password
        $query = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $query->execute([$hashed_password, $email]);

        echo "<script>alert('Password berhasil diubah! Silakan login.'); window.location.href='login.php';</script>";
        exit();
    } else {
        echo "<script>alert('Email tidak ditemukan!'); window.location.href='forgot_password.php';</script>";
        exit();
    }
}
?>
<?php
include '../config/config.php'; // Ganti dengan path ke file config.php Anda

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email_or_username = $_POST['email_or_username'];
    $password = $_POST['password'];

    // Query ke database untuk memeriksa email/username dan password
    $stmt = $conn->prepare("SELECT * FROM users WHERE (email = :email_or_username OR username = :email_or_username)");
    $stmt->execute(['email_or_username' => $email_or_username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {

        // Redirect berdasarkan tipe pengguna
        if ($user['role'] === 'admin') {
            header('Location: ../dashboard/index.php'); // Admin diarahkan ke dashboard
        } else {
            header('Location: ../loged/index.php'); // User diarahkan ke halaman logged
        }
        exit();
    } else {
        // Login gagal
        echo "<script>alert('Email/Username atau Password salah!'); window.location.href = 'login.php';</script>";
    }
}
?>
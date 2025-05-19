<?php
session_start();
include_once '../config/config.php'; // Ganti dengan path ke file config.php Anda

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // cek akun yg sudah ada
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    $sudah_ada = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($sudah_ada) {
        echo "<script>alert('Username atau Email sudah terdaftar!'); window.location.href = 'login.php';</script>";
        exit();
    }


    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, name, email, password) VALUES (?, ?, ?, ?)");
    $stmt->execute([$username, $name, $email, $hashed_password]);

    //redirect ke login
    header('Location: login.php');
}
?>
<?php
session_start(); // mulai session
include '../config/config.php'; // ganti dengan path ke file config.php Anda

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

    // hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // insert user baru
    $stmt = $conn->prepare("INSERT INTO users (username, name, email, password) VALUES (?, ?, ?, ?)");
    $stmt->execute([$username, $name, $email, $hashed_password]);

    // mengambil data user yang baru dibuat
    $user_id = $conn->lastInsertId();

    // simpan data user ke session
    $_SESSION['user_id'] = $user_id;
    $_SESSION['username'] = $username;
    $_SESSION['name'] = $name;
    $_SESSION['email'] = $email;
    $_SESSION['role'] = $role['role'];

    // redirect ke halaman index
    header('Location: ../loged/index.php');
}
?>

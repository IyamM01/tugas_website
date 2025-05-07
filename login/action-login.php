<?php
require_once __DIR__ . '/../config/config.php'; // Ganti dengan path ke file config.php Anda
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email_or_username = $_POST['email_or_username'];
    $password = $_POST['password'];
    $remember_me = isset($_POST['remember_me']) ? true : false;

    // Query ke database untuk memeriksa email/username dan password
    $stmt = $conn->prepare("SELECT * FROM users WHERE (email = :email_or_username OR username = :email_or_username)");
    $stmt->execute(['email_or_username' => $email_or_username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Login berhasil
        $_SESSION['user'] = $user['username'];

        // Jika "Remember Me" dicentang, set cookie
        if ($remember_me) {
            setcookie('user', $user['username'], time() + (86400 * 30), "/"); // Cookie berlaku 30 hari
        }

        // Redirect berdasarkan tipe pengguna
        if ($user['role'] === 'admin') {
            header('Location: /tugas_website/dashboard/index.php'); // Admin diarahkan ke dashboard
        } else {
            header('Location: /tugas_website/loged/index.php'); // User diarahkan ke halaman logged
        }
        exit();
    } else {
        // Login gagal
        echo "Email/Username atau Password salah!";
    }
}
?>
<?php
include_once '../config/config.php'; // Ganti dengan path ke file config.php Anda

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->execute([$username, $name, $email, $hashed_password]);

    //redirect ke login
    header('Location: login.php');
}
?>
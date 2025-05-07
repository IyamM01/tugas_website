<?php
$servername = "localhost";
$username = "admin";     // ganti sesuai username database Anda
$password = "123";       // ganti sesuai password Anda
$dbname = "db_hhi";      // nama database Anda

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>

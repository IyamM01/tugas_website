<?php
include '../config/config.php'; // atau file koneksi Anda

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $orderId = $_POST['order_id'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE order_id = ?");
    $stmt->execute([$status, $orderId]);

    // Redirect kembali ke halaman sebelumnya
    header("Location: index.php"); // ganti dengan nama file yang sesuai
    exit;
}
?>
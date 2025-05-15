<?php
session_start();

// Cek apakah form dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $index = isset($_POST['index']) ? $_POST['index'] : '';
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;

    // Validasi data
    if ($index !== '' && is_numeric($index) && isset($_SESSION['cart'][$index]) && $quantity > 0) {
        // Update quantity
        $_SESSION['cart'][$index]['quantity'] = $quantity;
        $_SESSION['message'] = "Jumlah buku berhasil diperbarui.";
    } else {
        $_SESSION['error'] = "Gagal memperbarui jumlah buku.";
    }
}

// Redirect ke halaman keranjang
header("Location: cart.php");
exit;
?>
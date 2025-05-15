<?php
session_start();

// Cek apakah form dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Kosongkan keranjang
    $_SESSION['cart'] = [];
    $_SESSION['message'] = "Keranjang belanja telah dikosongkan.";
}

// Redirect ke halaman keranjang
header("Location: cart.php");
exit;
?>
<?php
session_start();

// Cek apakah form dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $index = isset($_POST['index']) ? $_POST['index'] : '';

    // Validasi data
    if ($index !== '' && is_numeric($index) && isset($_SESSION['cart'][$index])) {
        // Simpan informasi buku yang dihapus untuk pesan
        $book_title = $_SESSION['cart'][$index]['title'];
        
        // Hapus item dari keranjang
        unset($_SESSION['cart'][$index]);
        
        // Reindex array untuk menghindari index yang bolong
        $_SESSION['cart'] = array_values($_SESSION['cart']);
        
        $_SESSION['message'] = "Buku \"$book_title\" telah dihapus dari keranjang.";
    } else {
        $_SESSION['error'] = "Gagal menghapus buku dari keranjang.";
    }
}

// Redirect ke halaman keranjang
header("Location: cart.php");
exit;
?>
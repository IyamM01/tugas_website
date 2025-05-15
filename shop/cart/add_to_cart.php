<?php
session_start();
include('../../config/config.php');

// Cek apakah form dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $book_id = isset($_POST['book_id']) ? $_POST['book_id'] : '';
    $book_title = isset($_POST['book_title']) ? $_POST['book_title'] : '';
    $book_price = isset($_POST['book_price']) ? $_POST['book_price'] : 0;
    $book_image = isset($_POST['book_image']) ? $_POST['book_image'] : '';
    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1;

    // Validasi data
    if (!empty($book_id) && !empty($book_title) && !empty($book_price)) {
        // Inisialisasi keranjang jika belum ada
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Cek apakah buku sudah ada di keranjang
        $item_index = -1;
        foreach ($_SESSION['cart'] as $index => $item) {
            if ($item['id'] == $book_id) {
                $item_index = $index;
                break;
            }
        }

        // Jika buku sudah ada di keranjang, tambah quantity
        if ($item_index >= 0) {
            $_SESSION['cart'][$item_index]['quantity'] += $quantity;
        } else {
            // Jika buku belum ada di keranjang, tambahkan sebagai item baru
            $_SESSION['cart'][] = [
                'id' => $book_id,
                'title' => $book_title,
                'price' => $book_price,
                'image' => $book_image,
                'quantity' => $quantity
            ];
        }

        // Set pesan berhasil
        $_SESSION['message'] = "Buku \"$book_title\" telah ditambahkan ke keranjang.";
    } else {
        // Set pesan error
        $_SESSION['error'] = "Gagal menambahkan buku ke keranjang.";
    }
}

// Redirect ke halaman keranjang
header("Location: cart.php");
exit;
?>
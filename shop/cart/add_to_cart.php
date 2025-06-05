<?php
session_start();
include '../../config/config.php';

// Ambil data dari form
$user_id = $_SESSION['user_id'];
$book_id = $_POST['book_id'];
$quantity = 1;

// Cari cart aktif user
$stmt = $conn->prepare("SELECT cart_id FROM cart WHERE user_id = ?");
$stmt->execute([$user_id]);
$cart = $stmt->fetch();

if (!$cart) {
    // Buat cart baru jika belum ada
    $stmt = $conn->prepare("INSERT INTO cart (user_id) VALUES (?)");
    $stmt->execute([$user_id]);
    $cart_id = $conn->lastInsertId();
} else {
    $cart_id = $cart['cart_id'];
}

// Cek apakah buku sudah di keranjang
$stmt = $conn->prepare("SELECT * FROM cart_items WHERE cart_id = ? AND book_id = ?");
$stmt->execute([$cart_id, $book_id]);
$existing = $stmt->fetch();

if ($existing) {
    // Update kuantitas
    $stmt = $conn->prepare("UPDATE cart_items SET quantity = quantity + ? WHERE cart_id = ? AND book_id = ?");
    $stmt->execute([$quantity, $cart_id, $book_id]);
} else {
    // Tambahkan item ke cart
    $stmt = $conn->prepare("INSERT INTO cart_items (cart_id, book_id, quantity) VALUES (?, ?, ?)");
    $stmt->execute([$cart_id, $book_id, $quantity]);
}


header("Location: ../Shop.php");
exit();
?>

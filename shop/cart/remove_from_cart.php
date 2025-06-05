<?php
session_start();
include('../../config/config.php');

// Cek apakah ada data yang dikirim melalui POST
if(!isset($_POST['cart_item_id'])) {
    $_SESSION['error'] = "ID item tidak ditemukan.";
    header("Location: cart.php");
    exit;
}

$cart_item_id = $_POST['cart_item_id'];

try {
    $stmt = $conn->prepare("DELETE FROM cart_items WHERE cart_item_id = ?");
    $result = $stmt->execute([$cart_item_id]);
    
    if($result) {
        $_SESSION['message'] = "Item berhasil dihapus.";
    } else {
        $_SESSION['error'] = "Gagal menghapus item.";
    }
} catch(PDOException $e) {
    $_SESSION['error'] = "Database error: " . $e->getMessage();
}

header("Location: cart.php");
exit;
?>
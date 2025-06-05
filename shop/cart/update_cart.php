<?php
session_start();
include('../../config/config.php');

// Cek apakah ada data yang dikirim melalui POST
if(!isset($_POST['cart_item_id']) || !isset($_POST['quantity'])) {
    $_SESSION['error'] = "Data tidak lengkap.";
    header("Location: cart.php");
    exit;
}

$cart_item_id = $_POST['cart_item_id'];
$quantity = (int)$_POST['quantity'];

try {
    if ($quantity > 0) {
        $stmt = $conn->prepare("UPDATE cart_items SET quantity = ? WHERE cart_item_id = ?");
        $result = $stmt->execute([$quantity, $cart_item_id]);
        
        if($result) {
            $_SESSION['message'] = "Jumlah berhasil diperbarui.";
        } else {
            $_SESSION['error'] = "Gagal memperbarui jumlah.";
        }
    } else {
        $_SESSION['error'] = "Jumlah tidak valid.";
    }
} catch(PDOException $e) {
    $_SESSION['error'] = "Database error: " . $e->getMessage();
}


header("Location: cart.php");
exit;
?>
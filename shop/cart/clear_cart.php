<?php
session_start();
include '../../config/config.php';

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT cart_id FROM cart WHERE user_id = ?");
$stmt->execute([$user_id]);
$cart = $stmt->fetch();

if ($cart) {
    $stmt = $conn->prepare("DELETE FROM cart_items WHERE cart_id = ?");
    $stmt->execute([$cart['cart_id']]);
}

header("Location: cart.php");
exit();
?>

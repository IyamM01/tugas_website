<?php
include '../config/config.php';

if (!isset($_GET['keyword'])) {
    echo "<tr><td colspan='6' class='py-4 text-center text-gray-500'>Masukkan kata kunci pencarian.</td></tr>";
    exit;
}

$keyword = "%{$_GET['keyword']}%";

$stmt = $conn->prepare("SELECT * FROM orders WHERE order_id LIKE ?");
$stmt->execute([$keyword]);
$orders = $stmt->fetchAll();

if (!$orders) {
    echo "<tr><td colspan='6' class='py-4 text-center text-gray-500'>Tidak ada hasil ditemukan.</td></tr>";
    exit;
}

foreach ($orders as $order) {
    echo "<tr class='border-t'>";
    echo "<td class='py-2 px-4'>{$order['order_id']}</td>";
    echo "<td class='py-2 px-4'>{$order['user_id']}</td>";
    echo "<td class='py-2 px-4'>{$order['price']}</td>";
    echo "<td class='py-2 px-4'>{$order['status']}</td>";
    echo "<td class='py-2 px-4'>{$order['created_at']}</td>";
    echo "</tr>";
}
?>
<?php
include '../config/config.php';

if (!isset($_GET['keyword'])) {
    echo "<tr><td colspan='6' class='py-4 text-center text-gray-500'>Masukkan kata kunci pencarian.</td></tr>";
    exit;
}

$keyword = "%{$_GET['keyword']}%";

$stmt = $conn->prepare("SELECT * FROM books WHERE title LIKE ? OR category LIKE ?");
$stmt->execute([$keyword, $keyword]);
$books = $stmt->fetchAll();

if (!$books) {
    echo "<tr><td colspan='6' class='py-4 text-center text-gray-500'>Tidak ada hasil ditemukan.</td></tr>";
    exit;
}

foreach ($books as $book) {
    echo "<tr class='border-t'>";
    echo "<td class='py-2 px-2'>{$book['book_id']}</td>";
    echo "<td class='py-2 px-2'>{$book['title']}</td>";
    echo "<td class='py-2 px-2'>{$book['stock']}</td>";
    echo "<td class='py-2 px-2'>{$book['category']}</td>";
    echo "<td class='py-2 px-2'>{$book['price']}</td>";
    echo "<td class='py-2 px-2'>{$book['created_at']}</td>";
    echo "</tr>";
}
?>
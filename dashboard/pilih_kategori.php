<?php
include '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $kategori = $_POST['category'];
    $query = $conn->prepare("SELECT * FROM books WHERE category = ?");
    $query->execute([$kategori]);
    $books = $query->fetchAll();
    header("Location: books.php");
    exit();
}
?>
<?php
include '../config/config.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul     = $_POST['judul'];
    $penulis   = $_POST['penulis'];
    $harga     = $_POST['harga'];
    $kategori  = $_POST['kategori'];
    $deskripsi = $_POST['deskripsi'];

    $gambar    = $_FILES['gambar'];
    $targetDir = '../books/image/';
    $namaFile  = $gambar['name'];
    $gambarPath = $namaFile;
    $tmpFile   = $gambar['tmp_name'];
    $ekstensi  = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));

    if ($ekstensi !== 'jpg') {
        echo "<script>alert('Gambar harus berformat JPG'); window.history.back();</script>";
        exit;
    }

    if (file_exists($targetDir . $namaFile)) {
        echo "<script>alert('Gambar dengan nama yang sama sudah ada. Silakan ganti nama file gambar.'); window.history.back();</script>";
        exit;
    }

    if (!move_uploaded_file($tmpFile, $targetDir . $namaFile)) {
        echo "<script>alert('Gagal mengupload gambar'); window.history.back();</script>";
        exit;
    }


    if (empty($judul) || empty($penulis) || empty($harga) || empty($kategori) || empty($deskripsi)) {
        echo "<script>alert('Semua field harus diisi'); window.history.back();</script>";
        exit;
    }

    $query = "SELECT * FROM books WHERE title = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$judul]);
    if ($stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<script>alert('Buku sudah ada!'); window.history.back();</script>";
        exit;
    }

    $query = "INSERT INTO books (title, author, price, category, description, image)
              VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->execute([$judul, $penulis, $harga, $kategori, $deskripsi, $gambarPath]);

    // Hindari header setelah output, cukup JS redirect:
    echo "<script>alert('Buku berhasil ditambahkan'); window.location.href='books.php';</script>";
    exit;
}
?>

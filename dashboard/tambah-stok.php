<?php
include '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_or_judul = ($_POST['id_or_judul']);
    $jumlah = ($_POST['jumlah']);

    if (empty($id_or_judul) || empty($jumlah)) {
        echo "<script>alert('Semua field harus diisi'); window.history.back();</script>";
        exit;
    }
        // Siapkan query dengan binding
        $query = "UPDATE books SET stock = stock + :jumlah WHERE book_id = :id OR title = :judul";
        $stmt = $conn->prepare($query);
        $stmt->execute([
            ':jumlah' => $jumlah,
            ':id' => $id_or_judul,
            ':judul' => $id_or_judul
        ]);

        if ($stmt->rowCount() > 0) {
            echo "<script>alert('Stok berhasil ditambahkan'); window.location.href='books.php';</script>";
        } else {
            echo "<script>alert('Buku tidak ditemukan'); window.history.back();</script>";
        }

}
?>

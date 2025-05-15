<?php
include "../config/config.php"; // koneksi ke database

$kategori = $_GET['kategori'] ?? '';

if ($kategori !== '') {
  $query = "SELECT * FROM books WHERE category = :kategori";
  $stmt = $conn->prepare($query);
  $stmt->execute(['kategori' => $kategori]);
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
  $results = [];
}
?>

<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Kategori: <?= htmlspecialchars($kategori) ?></title>
  <link href="shop.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-5 pt-5">
    <h3 class="mb-4">Kategori: <?= htmlspecialchars($kategori) ?></h3>

    <div class="row row-cols-1 row-cols-md-5 g-4">
      <?php
      if ($results) {
        foreach ($results as $book) {
          $img = file_exists("assets/img/" . $book['image']) ? $book['image'] : 'default_book.jpg';
          echo '
          <div class="col">
            <div class="card h-100">
              <img src="assets/img/' . htmlspecialchars($img) . '" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">' . htmlspecialchars($book['title']) . '</h5>
                <p class="card-text">
                  Penulis: ' . htmlspecialchars($book['author']) . '<br>
                  Kategori: ' . htmlspecialchars($book['category']) . '<br>
                  Deskripsi: ' . htmlspecialchars($book['description']) . '<br>
                  Harga: Rp ' . number_format($book['price'], 0, ',', '.') . '
                </p>
                <a href="cart.php" class="btn btn-primary">Add to cart</a>
              </div>
            </div>
          </div>';
        }
      } else {
        echo '<p class="text-muted">Tidak ada buku untuk kategori ini.</p>';
      }
      ?>
    </div>
  </div>
</body>
</html>

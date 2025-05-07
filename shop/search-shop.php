<?php
include "config/config.php"; // Pastikan file ini berisi koneksi database PDO

// Ambil keyword pencarian dari parameter GET
$keyword = $_GET['cari'] ?? '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Hasil Pencarian Buku</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/shop.css" rel="stylesheet">
</head>
<body>

<header class="p-3 bg-light border-bottom mb-4">
  <div class="container d-flex justify-content-between align-items-center">
    <a href="index.php" class="text-decoration-none">
      <h2 class="text-primary">Bookstore</h2>
    </a>
    <form class="d-flex" role="search" action="search-shop.php" method="GET">
      <input class="form-control me-2" type="search" name="cari" placeholder="Search" value="<?= htmlspecialchars($keyword) ?>">
      <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
  </div>
</header>

<div class="container">
  <h4 class="mb-4">Hasil Pencarian untuk: <em><?= htmlspecialchars($keyword) ?></em></h4>

  <div class="row row-cols-1 row-cols-md-4 g-4">

  <?php
  if ($keyword !== '') {
    $query = "SELECT * FROM books 
              WHERE title LIKE :keyword 
                 OR author LIKE :keyword 
                 OR category LIKE :keyword 
                 OR price LIKE :keyword";

    $stmt = $pdo->prepare($query);
    $stmt->execute(['keyword' => "%$keyword%"]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
                Harga: Rp ' . number_format($book['price'], 0, ',', '.') . '
              </p>
            </div>
          </div>
        </div>';
      }
    } else {
      echo '<p class="text-muted">Tidak ditemukan buku yang cocok.</p>';
    }
  } else {
    echo '<p class="text-muted">Masukkan kata kunci untuk mencari buku.</p>';
  }
  ?>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

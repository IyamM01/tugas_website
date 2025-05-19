<?php
include '../config/auth.php';
include "../config/config.php"; // koneksi PDO ke database
$keyword = $_GET['cari'] ?? '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Hasil Pencarian Buku</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="shop.css" rel="stylesheet">
  <link href="../image/2.png" rel="icon">
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

    try {
      $stmt = $conn->prepare($query);
      $stmt->execute(['keyword' => "%$keyword%"]);
      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if ($results) {
        foreach ($results as $book) {
          // Check if image exists in the image folder
          $imagePath = "../books/image/" . $book['image'];
          
          echo '
          <div class="col">
            <div class="card h-100">
              <img src="' . htmlspecialchars($imagePath) . '" class="card-img-top" alt="Cover buku ' . htmlspecialchars($book['title']) . '">
              <div class="card-body d-flex flex-column">
                <h5 class="card-title">' . htmlspecialchars($book['title']) . '</h5>
                <p class="card-text">
                  Penulis: ' . htmlspecialchars($book['author']) . '<br>
                  Kategori: ' . htmlspecialchars($book['category']) . '<br>
                  Deskripsi: ' . htmlspecialchars($book['description']) . '<br>
                  Harga: Rp ' . number_format($book['price'], 0, ',', '.') . '
                </p>
                <form action="cart/add_to_cart.php" method="POST" class="mt-auto">
                  <input type="hidden" name="book_id" value="' . (isset($book['id']) ? $book['id'] : (isset($book['book_id']) ? $book['book_id'] : '')) . '">
                  <input type="hidden" name="book_title" value="' . htmlspecialchars($book['title']) . '">
                  <input type="hidden" name="book_price" value="' . $book['price'] . '">
                  <input type="hidden" name="book_image" value="' . htmlspecialchars($book['image']) . '">
                  <button type="submit" class="btn btn-primary w-100">Add to cart</button>
                </form>
              </div>
            </div>
          </div>';
        }
      } else {
        echo '<div class="col"><p class="text-muted">Tidak ditemukan buku yang cocok.</p></div>';
      }
    } catch (PDOException $e) {
      echo '<div class="col"><p class="text-danger">Terjadi kesalahan: ' . $e->getMessage() . '</p></div>';
    }
  } else {
    echo '<div class="col"><p class="text-muted">Masukkan kata kunci untuk mencari buku.</p></div>';
  }
  ?>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

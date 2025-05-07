<?php
include "../config/config.php"; // koneksi PDO ke database

// Query untuk ambil semua data buku
$query = "SELECT * FROM books";
$stmt = $pdo->prepare($query);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Shop</title>
  <link href="shop.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/img/2.png" rel="icon">
  <link href="assets/img/2.jpg" rel="apple-touch-icon">
</head>
<body>
  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">
      <a href="index.php" class="logo d-flex align-items-center me-auto">
        <img src="assets/img/2.png" alt="">
        <h1 class="sitename">Bookstore</h1>
      </a>
      <form class="d-flex me-3" role="search" action="search-shop.php" method="GET">
        <input class="form-control me-2" type="search" name="cari" placeholder="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.php#hero"">Home</a></li>
          <li><a href="index.php#contact">Contact</a></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Kategori</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="kategori.php?kategori=Fiction">Novel</a></li>
              <li><a class="dropdown-item" href="kategori.php?kategori=Fantasy">Cerpen</a></li>
              <li><a class="dropdown-item" href="kategori.php?kategori=Science Fiction">Cerita Anak</a></li>
              <li><a class="dropdown-item" href="kategori.php?kategori=Mystery">Dongeng</a></li>
              <li><a class="dropdown-item" href="kategori.php?kategori=Romance">Komik</a></li>
              <li><a class="dropdown-item" href="kategori.php?kategori=Non-Fiction">Kamus</a></li>
            </ul>
          </li>
        </ul>
      </nav>
      <a class="btn-getstarted" href="login.php">Login</a>
    </div>
  </header>

  <div class="container mt-5 pt-5">
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
                  Harga: Rp ' . number_format($book['price'], 0, ',', '.') . '
                </p>
                <a href="cart.php" class="btn btn-primary">Add to cart</a>
              </div>
            </div>
          </div>';
        }
      } else {
        echo '<p class="text-muted">Tidak ada buku tersedia.</p>';
      }
      ?>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

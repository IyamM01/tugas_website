<?php
include "../config/config.php"; // koneksi PDO ke database

// Query untuk ambil semua data buku
$query = "SELECT * FROM books";
$stmt = $conn->prepare($query);
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
          <li><a href="#">Home</a></li>
          <li><a href="index.php#contact">Contact</a></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Kategori</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="kategori.php?kategori=novel">Novel</a></li>
              <li><a class="dropdown-item" href="kategori.php?kategori=cerpen">Cerpen</a></li>
              <li><a class="dropdown-item" href="kategori.php?kategori=dongeng">Cerita Anak</a></li>
              <li><a class="dropdown-item" href="kategori.php?kategori=komik">Dongeng</a></li>
              <li><a class="dropdown-item" href="kategori.php?kategori=cerita anak">Komik</a></li>
              <li><a class="dropdown-item" href="kategori.php?kategori=Non-Fiction">Kamus</a></li>
            </ul>
          </li>
          <li><a href="cart/cart.php">Keranjang</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <div class="container mt-5 pt-5">
    <div class="row row-cols-1 row-cols-md-5 g-4">
      <?php
      if ($results) {
        foreach ($results as $book) {
          // Check if image exists in the image folder
          $imagePath = "/books/image/" . $book['image'];
          $defaultImage = "assets/img/default_book.jpg";
          
          // Use the correct image path if the file exists, otherwise use default
          $imageToDisplay = file_exists($imagePath) ? $imagePath : $defaultImage;
          
          echo '
          <div class="col">
            <div class="card h-100">
              <img src="' . htmlspecialchars($imageToDisplay) . '" class="card-img-top" alt="Cover buku ' . htmlspecialchars($book['title']) . '">
              <div class="card-body">
                <h5 class="card-title">' . htmlspecialchars($book['title']) . '</h5>
                <p class="card-text">
                  Penulis: ' . htmlspecialchars($book['author']) . '<br>
                  Kategori: ' . htmlspecialchars($book['category']) . '<br>
                  Deskripsi: ' . htmlspecialchars($book['description']) . '<br>
                  Harga: Rp ' . number_format($book['price'], 0, ',', '.') . '
                </p>
                <form action="cart/add_to_cart.php" method="POST">
                  <input type="hidden" name="book_id" value="' . (isset($book['id']) ? $book['id'] : (isset($book['book_id']) ? $book['book_id'] : '')) . '">
                  <input type="hidden" name="book_title" value="' . htmlspecialchars($book['title']) . '">
                  <input type="hidden" name="book_price" value="' . $book['price'] . '">
                  <input type="hidden" name="book_image" value="' . htmlspecialchars($book['image']) . '">
                  <button type="submit" class="btn btn-primary">Add to cart</button>
                </form>
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
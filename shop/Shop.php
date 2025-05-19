<?php
include '../config/auth.php';
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
  <link href="../image/2.png" rel="icon">
  <link href="assets/img/2.jpg" rel="apple-touch-icon">
</head>
<body>
  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">
      <a href="index.php" class="logo d-flex align-items-center me-auto">
        <img src="../image/2.png" alt="">
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
          <li><a href="../profile/profile.php">Profile</a></li>
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
        echo '<p class="text-muted">Tidak ada buku tersedia.</p>';
      }
      ?>
    </div>
  </div>

  
</body>

<footer id="footer" class="footer position-relative">

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="index.html" class="logo d-flex align-items-center">
            <span class="sitename">QuickStart</span>
          </a>
          <div class="footer-contact pt-3">
            <p>Ilham</p>
            <p>Minggir, Sleman</p>
            <p class="mt-3"><strong>Phone:</strong> <span>+62</span></p>
            <p><strong>Email:</strong> <span>hhibookstore@gmail.com</span></p>
          </div>
          <div class="social-links d-flex mt-4">
            <a href=""><i class="bi bi-twitter-x"></i></a>
            <a href=""><i class="bi bi-facebook"></i></a>
            <a href=""><i class="bi bi-instagram"></i></a>
            <a href=""><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Useful Links</h4>
          <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Shop</a></li>
            <li><a href="#">Contact</a></li>
          </ul>
        </div>

        <div class="col-lg-4 col-md-12 footer-newsletter">
          <h4>Our Newsletter</h4>
          <p>Subscribe to our newsletter and receive the latest news about our products and services!</p>
          <form action="forms/newsletter.php" method="post" class="php-email-form">
            <div class="newsletter-form"><input type="email" name="email"><input type="submit" value="Subscribe"></div>
            <div class="loading">Loading</div>
            <div class="error-message"></div>
            <div class="sent-message">Your subscription request has been sent. Thank you!</div>
          </form>
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">HHI</strong><span>All Rights Reserved</span></p>
    </div>

  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
  
</html>
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
  
  <!-- PASTIKAN URUTAN PEMUATAN CSS BENAR -->
  <!-- 1. Bootstrap CSS (dari CDN) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- 2. CSS Kustom (setelah Bootstrap) -->
  <link href="shop.css" rel="stylesheet">
  
  <link href="../image/2.png" rel="icon">
  <link href="assets/img/2.jpg" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files - JANGAN include Bootstrap lagi -->
  <link href ="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
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
        <button class="btn btn-outline-light" type="submit">Search</button>
      </form>
      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="../loged/index.php">Home</a></li>
          <li><a href="../loged/index.php#contact">Contact</a></li>
          <li><a href="cart/cart.php">Keranjang</a></li>
          <!-- FIX: Menggunakan struktur dropdown yang benar untuk Bootstrap 5 -->
          <li class="nav-item dropdown" action="kategori.php">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Kategori
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="kategori.php?kategori=Novel">Novel</a></li>
              <li><a class="dropdown-item" href="kategori.php?kategori=cerpen">Cerpen</a></li>
              <li><a class="dropdown-item" href="kategori.php?kategori=cerita anak">Cerita Anak</a></li>
              <li><a class="dropdown-item" href="kategori.php?kategori=dongeng">Dongeng</a></li>
              <li><a class="dropdown-item" href="kategori.php?kategori=komik">Komik</a></li>
            </ul>
          </li>
          <li><a href="../profile/profile.php">Profile</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <div class="container mt-2 pt-2">
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

  <!-- Footer -->
  <footer class="text-center text-lg-start text-white" style="background-color: var(--primary-color);">
    <!-- Grid container -->
    <div class="container p-4">
      <!--Grid row-->
      <div class="row mt-4">
        <!--Grid column-->
        <div class="col-lg-6 col-md-6 mb-4 mb-md-0">
          <h5 class="text-uppercase">Our Team</h5>

          <ul class="list-unstyled">
            <li>
              <a href="https://www.instagram.com/_terse_rah_?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="blank" class="text-white"><i class="fas fa-shipping-fast fa-fw fa-sm me-2"></i>Ilham</a>
            </li>
            <li>
              <a href="https://www.instagram.com/hhniff__?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="blank" class="text-white"><i class="fas fa-backspace fa-fw fa-sm me-2"></i>Hanif</a>
            </li>
            <li>
              <a href="https://www.instagram.com/hilmyyaa?igsh=MTJ2YjhxNWR1dnBsNg==" target="blank" class="text-white"><i class="far fa-file-alt fa-fw fa-sm me-2"></i>Hilmy</a>
            </li>
          </ul>
        </div>
        <!--Grid column-->

        <!--Grid column-->
        <div class="col-lg-6 col-md-6 mb-4 mb-md-0">
          <h5 class="text-uppercase">Publishing house</h5>

          <ul class="list-unstyled">
            <li>
              <a href="#!" class="text-white">The BookStore</a>
            </li>
            <li>
              <a href="#!" class="text-white">Minggir</a>
            </li>
            <li>
              <a href="#!" class="text-white">085759712668</a>
            </li>
            <li>
              <a href="#!" class="text-white"><i class="fas fa-briefcase fa-fw fa-sm me-2"></i>Send us a book</a>
            </li>
          </ul>
        </div>
        <!--Grid column-->
      </div>
      <!--Grid row-->
    </div>
    <!-- Grid container -->

    <!-- Copyright -->
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.1)">
      ©Copyright:
      <a class="text-white">HHIBokstore</a>
    </div>
    
    <!-- Copyright -->
  </footer>

  <!-- PENTING: Memuat Bootstrap JS sebelum skrip kustom -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
  
  <!-- Skrip kustom untuk memastikan dropdown berfungsi -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Inisialisasi dropdown melalui JS
      var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
      var dropdownList = dropdownElementList.map(function(dropdownToggleEl) {
        return new bootstrap.Dropdown(dropdownToggleEl);
      });
      
      // Tambahan: reset dropdown yang mungkin terbuka secara default
      document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
        if(menu.classList.contains('show')) {
          menu.classList.remove('show');
        }
      });
    });
  </script>
  
  <!-- AOS dan validator JS -->
  <script src="../assets/vendor/aos/aos.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>
</body>
</html>
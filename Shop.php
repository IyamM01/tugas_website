<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shop</title>
    <link href="assets/css/shop.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
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
        <nav id="navmenu" class="navmenu">
          <ul>
            <form class="d-flex" role="search" action="search-shop.php" method="GET">
              <input class="form-control me-2 pr-10" type="search" name="cari" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
            <li><a href="index.php#hero" class="active">Home</a></li>
            <li><a href="index.php#contact">Contact</a></li>
            <div class="dropdown">
              <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Kategori</button>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Novel</a></li>
                <li><a class="dropdown-item" href="#">Cerpen</a></li>
                <li><a class="dropdown-item" href="#">Cerita Anak</a></li>
                <li><a class="dropdown-item" href="#">Dongeng</a></li>
                <li><a class="dropdown-item" href="#">Komik</a></li>
                <li><a class="dropdown-item" href="#">Kamus</a></li>
              </ul>
            </div>
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
        <a class="btn-getstarted" href="login.php">Login</a>
      </div>
    </header>
  <div class="row row-cols-1 row-cols-md-5 g-4">
    <?php
    include "config/config.php"; // Pastikan file ini berisi koneksi database PDO

      // Pastikan untuk mendefinisikan keyword
      $keyword = isset($_GET['cari']) ? $_GET['cari'] : '';

      // Query database
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
            <div class="col-4">
              <div class="card h-100">
                <img src="assets/img/' . htmlspecialchars($img) . '" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title">' . htmlspecialchars($book['title']) . '</h5>
                  <p class="card-text">
                    Penulis: ' . htmlspecialchars($book['author']) . '<br>
                    Kategori: ' . htmlspecialchars($book['category']) . '<br>
                    Harga: Rp ' . number_format($book['price'], 0, ',', '.') . '
                  </p>
                  <a href="cart.php" class="btn btn-primary">Add to chart</a>
                </div>
              </div>
            </div>';
        }
      }
    ?>
  </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
  </body>
</html>

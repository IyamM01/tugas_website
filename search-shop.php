<?php
<<<<<<< HEAD
include "config/config.php"; // Pastikan file ini berisi koneksi database PDO

// Ambil keyword pencarian dari parameter GET
$keyword = $_GET['cari'] ?? '';
=======
// Koneksi database
$dsn = "mysql:host=localhost;dbname=buku_anak;charset=UTF8";
try {
    $pdo = new PDO($dsn, "", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// Ambil kata kunci pencarian
$q = $_GET['q'] ?? '';

$sql = "SELECT * FROM books WHERE 
        title LIKE :q OR 
        author LIKE :q OR 
        category LIKE :q OR 
        description LIKE :q";

$stmt = $pdo->prepare($sql);
$stmt->execute(['q' => "%$q%"]);
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
>>>>>>> 658a35e (test)
?>

<!DOCTYPE html>
<html lang="id">
<head>
<<<<<<< HEAD
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
=======
    <meta charset="UTF-8">
    <title>Hasil Pencarian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .card {
            width: 250px;
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            background: #fff;
        }

        .card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            background: #eee;
        }

        .card-body {
            padding: 15px;
        }

        .card-title {
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .card-text {
            font-size: 14px;
            margin-bottom: 5px;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            text-align: center;
            background-color: #33b5e5;
            color: white;
            border: none;
            border-radius: 0 0 10px 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<h2>Hasil Pencarian untuk: <?= htmlspecialchars($q) ?></h2>
<a href="index.php">← Kembali</a><br><br>

<div class="card-container">
    <?php if ($books): ?>
        <?php foreach ($books as $book): ?>
            <div class="card">
                <img src="assets/img/buku.jpg" alt="Cover buku">
                <div class="card-body">
                    <div class="card-title"><?= htmlspecialchars($book['title']) ?></div>
                    <div class="card-text"><strong>Penulis:</strong> <?= htmlspecialchars($book['author']) ?></div>
                    <div class="card-text"><strong>Kategori:</strong> <?= htmlspecialchars($book['category']) ?></div>
                    <div class="card-text"><strong>Harga:</strong> Rp <?= number_format($book['price'], 0, ',', '.') ?></div>
                </div>
                <button class="btn">Tambah ke Keranjang</button>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Tidak ada hasil ditemukan.</p>
    <?php endif; ?>
</div>

>>>>>>> 658a35e (test)
</body>
</html>

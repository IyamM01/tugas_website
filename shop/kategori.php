<?php
include "../config/config.php"; // koneksi ke database
include '../config/auth.php'; // autentikasi pengguna

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
    <div class="col-12 mt-4"> 
        <a href="Shop.php" class="btn btn-outline-secondary">Kembali ke Keranjang</a>
      </div>
  </div>
</body>
</html>

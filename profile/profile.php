<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile Page - hhibookstore</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom Styles -->
    <link rel="stylesheet" href="profile.css">
  </head>
  <body>

    <header>
      <div class="container py-3 d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-book-open me-2"></i>hhibookstore</h1>
        <nav>
          <a href="#index.php" class="me-3"><i class="fas fa-home me-1"></i>Home</a>
        </nav>
      </div>
    </header>

    <main class="container my-5">
      <div class="row">
        <!-- PROFILE CARD -->
        <aside class="col-lg-4 mb-4">
          <div class="card shadow-sm">
            <div class="card-body text-center">
              <img src="https://via.placeholder.com/150" alt="Profile Picture" class="mb-3">
              <h2>Nama Pengguna</h2>
            </div>
          </div>
        </aside>

        <!-- ACCOUNT & CART LIST -->
        <section class="col-lg-8">
          <!-- ACCOUNT INFO -->
          <div class="card shadow-sm mb-4">
            <div class="card-header">
              <h3 class="mb-0"><i class="fas fa-id-card me-2"></i>Informasi Akun</h3>
            </div>
            <div class="card-body">
              <ul class="list-unstyled">
                <li class="mb-3"><strong><i class="fas fa-envelope me-2"></i>Email:</strong> user@example.com</li>
                <li class="mb-0"><strong><i class="fas fa-map-marker-alt me-2"></i>Alamat:</strong> Jl. Contoh No. 123, Jakarta</li>
              </ul>
            </div>
          </div>

          <!-- CART LIST -->
          <div class="card shadow-sm">
            <div class="card-header">
              <h3 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Daftar Keranjang</h3>
            </div>
            <div class="card-body p-0">
              <ul class="list-group list-group-flush">
                <li class="list-group-item">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <span class="fw-medium">Harry Potter - J.K. Rowling</span>
                      <p class="text-muted mb-0 small">Fantasy, Adventure</p>
                    </div>
                    <span class="badge">Rp150.000</span>
                  </div>
                </li>
                <li class="list-group-item">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <span class="fw-medium">Laskar Pelangi - Andrea Hirata</span>
                      <p class="text-muted mb-0 small">Novel, Drama</p>
                    </div>
                    <span class="badge">Rp85.000</span>
                  </div>
                </li>
                <li class="list-group-item">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <span class="fw-medium">Bumi Manusia - Pramoedya Ananta Toer</span>
                      <p class="text-muted mb-0 small">Sejarah, Novel</p>
                    </div>
                    <span class="badge">Rp95.000</span>
                  </div>
                </li>
              </ul>
              <div class="p-4">
                <div class="d-flex justify-content-between mb-3">
                  <span class="fw-bold">Total</span>
                  <span class="fw-bold">Rp330.000</span>
                </div>
                <button class="btn btn-success w-100">
                  <i class="fas fa-shopping-bag me-2"></i>Checkout
                </button>
              </div>
            </div>
          </div>
        </section>
      </div>
    </main>

    <footer class="bg-dark text-light py-4 mt-5">
      <div class="container text-center">
        <p class="mb-0">&copy; 2025 hhibookstore. Semua hak dilindungi.</p>
      </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="profile.js"> </script>
  </body>
</html>
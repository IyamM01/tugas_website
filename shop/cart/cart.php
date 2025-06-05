<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: ../../login/login.php');
    exit();
}

include('../../config/config.php');
// Check if user is logged in
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT cart_id FROM cart WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $cart = $stmt->fetch();

$items = [];
if ($cart) {
    $stmt = $conn->prepare("SELECT ci.*, b.book_id, b.title, b.price FROM cart_items ci JOIN books b ON ci.book_id = b.book_id WHERE ci.cart_id = ?");

    $stmt->execute([$cart['cart_id']]);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
    $total = 0;
    foreach ($items as $item):
        $subtotal = $item['price'] * $item['quantity'];
        $total += $subtotal;
    endforeach;

    // Update the total price in the cart
    $update = $conn->prepare("UPDATE cart SET total_price = ? WHERE cart_id = ?");
    $update->execute([$total, $cart['cart_id']]);

?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shopping Cart - Bookstore</title>
    <link href="../shop.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/img/2.png" rel="icon">
    <link href="assets/img/2.jpg" rel="apple-touch-icon">
    <style>
        .cart-item img {
            max-height: 100px;
            object-fit: cover;
        }
    </style>
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
                    <li><a href="../../loged/index.php">Home</a></li>
                    <li><a href="../../shop/Shop.php">Shop</a></li>
                    <li><a href="../../loged/index.php#contact">Contact</a></li>
                    <li><a href="cart.php" class="active">Keranjang</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container mt-5 pt-5">
        <h2 class="mb-4">Keranjang Belanja</h2>
        
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php 
                    echo $_SESSION['message'];
                    unset($_SESSION['message']); 
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php 
                    echo $_SESSION['error'];
                    unset($_SESSION['error']); 
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (empty($items)): ?>
            <div class="alert alert-info">
                Keranjang belanja Anda kosong. <a href="../Shop.php">Lihat koleksi buku kami</a>.
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Judul Buku</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $index => $item): 
                            ?>
                            <tr class="cart-item">
                                <td><?php echo htmlspecialchars($item['title']); ?></td>
                                <td>Rp <?php echo number_format($item['price'], 0, ',', '.'); ?></td>
                                <td>
                                    <form action="update_cart.php" method="POST" class="d-flex">
                                        <input type="hidden" name="cart_item_id" value="<?php echo $item['cart_item_id']; ?>">
                                        <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" max="99" class="form-control form-control-sm" style="width: 70px;">
                                        <button type="submit" class="btn btn-sm btn-outline-secondary ms-2">Update</button>
                                    </form>
                                </td>
                                <td>Rp <?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?></td>
                                <td>
                                    <form action="remove_from_cart.php" method="POST">
                                        <input type="hidden" name="cart_item_id" value="<?php echo $item['cart_item_id']; ?>">
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-end fw-bold">Total:</td>
                            <td class="fw-bold">Rp <?php echo number_format($total, 0, ',', '.'); ?></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="../Shop.php" class="btn btn-outline-primary">Lanjutkan Belanja</a>
                <div>
                    <form action="clear_cart.php" method="POST" class="d-inline">
                        <button type="submit" class="btn btn-outline-danger">Kosongkan Keranjang</button>
                    </form>
                    <a href="checkout.php" class="btn btn-success ms-2">Checkout</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>
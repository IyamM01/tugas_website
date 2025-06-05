<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: ../../login/login.php');
    exit();
}

include('../../config/config.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Anda harus login terlebih dahulu untuk checkout";
    header('Location: ../../login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Get cart information
$stmt = $conn->prepare("SELECT cart_id, total_price FROM cart WHERE user_id = ?");
$stmt->execute([$user_id]);
$cart = $stmt->fetch();

if (!$cart || $cart['total_price'] == 0) {
    $_SESSION['error'] = "Keranjang belanja Anda kosong";
    header('Location: cart.php');
    exit();
}

// Get cart items
$stmt = $conn->prepare("SELECT ci.*, b.title, b.price FROM cart_items ci 
                       JOIN books b ON ci.book_id = b.book_id 
                       WHERE ci.cart_id = ?");
$stmt->execute([$cart['cart_id']]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get user information if available
$stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

// Process checkout form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Get form data
        $name = $_POST['name'] ?? '';
        $address = $_POST['address'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $email = $_POST['email'] ?? '';
        $payment_method = $_POST['payment_method'] ?? '';
        $notes = $_POST['notes'] ?? '';
        
        // Validate form data
        if (empty($name) || empty($address) || empty($phone) || empty($payment_method)) {
            throw new Exception("Semua field dengan tanda * harus diisi");
        }
        
        // Clean phone number (remove spaces, dashes, etc.)
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // Ensure phone starts with proper country code for WhatsApp
        if (substr($phone, 0, 2) == '08') {
            // Convert 08 to 628 for Indonesia
            $phone = '62' . substr($phone, 1);
        } elseif (substr($phone, 0, 1) == '8') {
            // Convert 8 to 628 for Indonesia
            $phone = '62' . $phone;
        } elseif (substr($phone, 0, 1) == '0') {
            // Convert 0 to 62 for Indonesia
            $phone = '62' . substr($phone, 1);
        } elseif (substr($phone, 0, 1) != '6' && strlen($phone) <= 12) {
            // Add 62 prefix if not already there and looks like an Indonesia number
            $phone = '62' . $phone;
        }
        
        // Start transaction
        $conn->beginTransaction();
        
        // Create order with all required fields
        $sql = "INSERT INTO orders (user_id, price, status, created_at) VALUES (?, ?, 'pending', NOW())";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([$user_id, $cart['total_price']]);
        
        if (!$result) {
            throw new Exception("Gagal menyimpan data pesanan");
        }
        
        $order_id = $conn->lastInsertId();
        
        if (!$order_id) {
            throw new Exception("Gagal mendapatkan ID pesanan");
        }
        
        // Save customer details in session for confirmation page
        $_SESSION['customer_details'] = [
            'name' => $name,
            'address' => $address,
            'phone' => $phone,
            'email' => $email,
            'payment_method' => $payment_method,
            'notes' => $notes
        ];
        
        // Add order items with all required fields
        $stmt = $conn->prepare("INSERT INTO order_items (order_id, book_id, quantity, created_at) VALUES (?, ?, ?, NOW())");
        
        foreach ($items as $item) {
        // Tambahkan item ke order_items
        $result = $stmt->execute([$order_id, $item['book_id'], $item['quantity']]);

        if (!$result) {
            throw new Exception("Gagal menyimpan detail item pesanan");
        }

        // Kurangi stok buku
        $updateStok = $conn->prepare("UPDATE books SET stock = stock - ? WHERE book_id = ? AND stock >= ?");
        $updateStok->execute([$item['quantity'], $item['book_id'], $item['quantity']]);

        // Cek jika update gagal karena stok tidak cukup
        if ($updateStok->rowCount() === 0) {
            throw new Exception("Stok tidak mencukupi untuk buku: " . $item['title']);
        }
    
        }
        
        // Clear cart
        $stmt = $conn->prepare("DELETE FROM cart_items WHERE cart_id = ?");
        $stmt->execute([$cart['cart_id']]);
        
        $stmt = $conn->prepare("UPDATE cart SET total_price = 0 WHERE cart_id = ?");
        $stmt->execute([$cart['cart_id']]);
        
        // Commit transaction
        $conn->commit();
        
        // Store order ID in session for confirmation page
        $_SESSION['order_id'] = $order_id;
        
        // Redirect to confirmation page
        header('Location: confirm.php');
        exit();
        
    } catch (Exception $e) {
        // Rollback transaction on error
        if ($conn->inTransaction()) {
            $conn->rollBack();
        }
        
        $_SESSION['error'] = "Terjadi kesalahan: " . $e->getMessage();
        // Log the error (remove in production or implement proper logging)
        error_log("Checkout error: " . $e->getMessage());
    }
}
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout - Bookstore</title>
    <link href="../shop.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/img/2.png" rel="icon">
    <link href="assets/img/2.jpg" rel="apple-touch-icon">
    <style>
        .required::after {
            content: " *";
            color: red;
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
                    <li><a href="/shop/Shop.php">Shop</a></li>
                    <li><a href="../../loged/index.php#contact">Contact</a></li>
                    <li><a href="cart.php">Keranjang</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container mt-5 pt-5">
        <h2 class="mb-4">Checkout</h2>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php 
                    echo $_SESSION['error'];
                    unset($_SESSION['error']); 
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Ringkasan Pesanan</h5>
                    </div>
                    <div class="card-body">
                        <?php if (empty($items)): ?>
                            <div class="alert alert-info">
                                Keranjang belanja Anda kosong. <a href="../Shop.php">Lihat koleksi buku kami</a>.
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Judul Buku</th>
                                            <th>Harga</th>
                                            <th>Jumlah</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($items as $item): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($item['title']); ?></td>
                                                <td>Rp <?php echo number_format($item['price'], 0, ',', '.'); ?></td>
                                                <td><?php echo $item['quantity']; ?></td>
                                                <td>Rp <?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="text-end fw-bold">Total:</td>
                                            <td class="fw-bold">Rp <?php echo number_format($cart['total_price'], 0, ',', '.'); ?></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Informasi Pengiriman & Pembayaran</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="checkout.php">
                            <div class="mb-3">
                                <label for="name" class="form-label required">Nama Lengkap</label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="<?php echo htmlspecialchars($user['username'] ?? ''); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label required">Nomor WhatsApp</label>
                                <input type="tel" class="form-control" id="phone" name="phone" 
                                       value="<?php echo htmlspecialchars($user['no_hp'] ?? ''); ?>">
                                <small class="text-muted">Pastikan nomor WhatsApp aktif untuk konfirmasi pesanan</small>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label required">Alamat Pengiriman Lengkap</label>
                                <textarea class="form-control" id="address" name="address" rows="3" ><?php echo htmlspecialchars($user['alamat'] ?? ''); ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="notes" class="form-label">Catatan</label>
                                <textarea class="form-control" id="notes" name="notes" rows="2" 
                                          placeholder="Catatan khusus untuk pesanan Anda (opsional)"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="payment_method" class="form-label required">Metode Pembayaran</label>
                                <select class="form-select" id="payment_method" name="payment_method" required>
                                    <option value="">Pilih metode pembayaran</option>
                                    <option value="transfer">Transfer Bank</option>
                                    <option value="ewallet">E-Wallet (Dana/OVO/GoPay)</option>
                                    <option value="cod">Bayar di Tempat (COD)</option>
                                </select>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="terms" required>
                                <label class="form-check-label" for="terms">
                                    Saya setuju dengan syarat dan ketentuan pembelian
                                </label>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success">Konfirmasi Pesanan</button>
                                <a href="cart.php" class="btn btn-outline-secondary">Kembali ke Keranjang</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer id="footer" class="footer position-relative light-background mt-5">
        <div class="container copyright text-center mt-4">
            <p>© <span>Copyright</span> <strong class="px-1 sitename">HHI</strong><span>All Rights Reserved</span></p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>
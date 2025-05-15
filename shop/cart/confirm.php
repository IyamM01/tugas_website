<?php
session_start();
include "../../config/config.php";

// Periksa apakah ada order_id
if (!isset($_GET['order_id']) || empty($_GET['order_id'])) {
    header("Location: shop.php");
    exit;
}

$order_id = $_GET['order_id'];

// Ambil data order
try {
    $order_query = "SELECT * FROM orders WHERE id = :order_id";
    $order_stmt = $pdo->prepare($order_query);
    $order_stmt->execute([':order_id' => $order_id]);
    $order = $order_stmt->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        $_SESSION['error'] = "Order tidak ditemukan.";
        header("Location: shop.php");
        exit;
    }

    // Ambil detail order
    $detail_query = "SELECT od.*, b.title, b.image FROM order_details od 
                    LEFT JOIN books b ON od.book_id = b.id 
                    WHERE od.order_id = :order_id";
    $detail_stmt = $pdo->prepare($detail_query);
    $detail_stmt->execute([':order_id' => $order_id]);
    $order_details = $detail_stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $_SESSION['error'] = "Terjadi kesalahan saat mengambil data order.";
    header("Location: shop.php");
    exit;
}
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Konfirmasi Pesanan - Bookstore</title>
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
            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="shop.php">Shop</a></li>
                    <li><a href="index.php#contact">Contact</a></li>
                    <li><a href="cart.php">Keranjang</a></li>
                </ul>
            </nav>
            <a class="btn-getstarted" href="login.php">Login</a>
        </div>
    </header>

    <div class="container mt-5 pt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-success mb-4">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">Pesanan Berhasil!</h4>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
                            <h5 class="mt-3">Terima kasih atas pesanan Anda</h5>
                            <p class="lead">Nomor Pesanan: <strong>#<?php echo $order_id; ?></strong></p>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6>Informasi Pelanggan</h6>
                                <p>
                                    <strong>Nama:</strong> <?php echo htmlspecialchars($order['customer_name']); ?><br>
                                    <strong>Email:</strong> <?php echo htmlspecialchars($order['customer_email']); ?><br>
                                    <strong>Alamat:</strong> <?php echo htmlspecialchars($order['customer_address']); ?>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h6>Informasi Pesanan</h6>
                                <p>
                                    <strong>Tanggal Order:</strong> <?php echo date('d-m-Y H:i', strtotime($order['order_date'])); ?><br>
                                    <strong>Metode Pembayaran:</strong> <?php echo htmlspecialchars($order['payment_method']); ?><br>
                                    <strong>Total:</strong> Rp <?php echo number_format($order['total_amount'], 0, ',', '.'); ?>
                                </p>
                            </div>
                        </div>

                        <h6>Detail Pesanan</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Buku</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($order_details as $detail): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($detail['title']); ?></td>
                                            <td>Rp <?php echo number_format($detail['price'], 0, ',', '.'); ?></td>
                                            <td><?php echo $detail['quantity']; ?></td>
                                            <td class="text-end">Rp <?php echo number_format($detail['price'] * $detail['quantity'], 0, ',', '.'); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold">Total:</td>
                                        <td class="text-end fw-bold">Rp <?php echo number_format($order['total_amount'], 0, ',', '.'); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <?php if ($order['payment_method'] == 'transfer'): ?>
                            <div class="alert alert-info mt-3">
                                <h6>Instruksi Pembayaran:</h6>
                                <p>Silakan transfer ke rekening berikut:</p>
                                <ul>
                                    <li>Bank XYZ</li>
                                    <li>No. Rekening: 123-456-789</li>
                                    <li>Atas Nama: Bookstore</li>
                                    <li>Jumlah: Rp <?php echo number_format($order['total_amount'], 0, ',', '.'); ?></li>
                                </ul>
                                <p>Konfirmasi pembayaran melalui WhatsApp: 081234567890</p>
                            </div>
                        <?php elseif ($order['payment_method'] == 'emoney'): ?>
                            <div class="alert alert-info mt-3">
                                <h6>Instruksi Pembayaran E-Wallet:</h6>
                                <p>Silakan transfer ke:</p>
                                <ul>
                                    <li>OVO/GoPay/DANA: 081234567890</li>
                                    <li>Atas Nama: Bookstore</li>
                                    <li>Jumlah: Rp <?php echo number_format($order['total_amount'], 0, ',', '.'); ?></li>
                                </ul>
                                <p>Konfirmasi pembayaran melalui WhatsApp: 081234567890</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <a href="shop.php" class="btn btn-outline-primary">Lanjutkan Belanja</a>
                            <button class="btn btn-outline-secondary" onclick="window.print()">Cetak Konfirmasi</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"></script>
</body>
</html>
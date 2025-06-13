<?php
session_start();
include('../../config/config.php');

// Check if order ID is set in session
if (!isset($_SESSION['order_id']) || !isset($_SESSION['customer_details'])) {
    header('Location: ../Shop.php');
    exit();
}

$order_id = $_SESSION['order_id'];
$customer = $_SESSION['customer_details'];

// Get order information
$stmt = $conn->prepare("SELECT o.*, u.username FROM orders o 
                        JOIN users u ON o.user_id = u.user_id 
                        WHERE o.order_id = ?");
$stmt->execute([$order_id]);
$order = $stmt->fetch();

if (!$order) {
    $_SESSION['error'] = "Pesanan tidak ditemukan";
    header('Location: ../Shop.php');
    exit();
}

// Get order items
$stmt = $conn->prepare("SELECT oi.*, b.title, b.price FROM order_items oi 
                       JOIN books b ON oi.book_id = b.book_id 
                       WHERE oi.order_id = ?");
$stmt->execute([$order_id]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Generate order summary for WhatsApp
$whatsapp_message = "📚 *PESANAN BARU #" . $order_id . "* 📚\n\n";
$whatsapp_message .= "*Informasi Pelanggan:*\n";
$whatsapp_message .= "Nama: " . $customer['name'] . "\n";
$whatsapp_message .= "No. HP: " . $customer['phone'] . "\n";
$whatsapp_message .= "Alamat: " . $customer['address'] . "\n";
if (!empty($customer['email'])) {
    $whatsapp_message .= "Email: " . $customer['email'] . "\n";
}
$whatsapp_message .= "Metode Pembayaran: " . ucfirst($customer['payment_method']) . "\n";
if (!empty($customer['notes'])) {
    $whatsapp_message .= "Catatan: " . $customer['notes'] . "\n";
}

$whatsapp_message .= "\n*Detail Pesanan:*\n";
$total = 0;
foreach ($items as $item) {
    $subtotal = $item['price'] * $item['quantity'];
    $total += $subtotal;
    $whatsapp_message .= "- " . $item['title'] . " (x" . $item['quantity'] . ") - Rp " . number_format($subtotal, 0, ',', '.') . "\n";
}
$whatsapp_message .= "\n*Total: Rp " . number_format($total, 0, ',', '.') . "*\n";
$whatsapp_message .= "\nDipesan pada: " . date('d/m/Y H:i', strtotime($order['created_at']));

// URL encode the message for WhatsApp
$encoded_message = urlencode($whatsapp_message);

// WhatsApp API URL (Replace with the seller's phone number)
$whatsapp_url = "https://wa.me/6289665841243?text=$encoded_message";

// Store WhatsApp URL in a session variable for the button
$_SESSION['whatsapp_url'] = $whatsapp_url;

// Keep a copy of the order details for this page
$_SESSION['last_order'] = [
    'order_id' => $order_id,
    'items' => $items,
    'total' => $total,
    'created_at' => $order['created_at'],
    'customer' => $customer
];

// Clear the temporary session variables we don't need anymore
unset($_SESSION['order_id']);
unset($_SESSION['customer_details']);
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Konfirmasi Pesanan - Bookstore</title>
    <link href="../shop.css" rel="stylesheet">
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
                    <li><a href="/shop/Shop.php">Shop</a></li>
                    <li><a href="index.php#contact">Contact</a></li>
                    <li><a href="cart.php">Keranjang</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container mt-5 pt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-success mb-4">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">Pesanan Berhasil Dibuat!</h4>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-check-circle-fill text-success" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                            </svg>
                            <h3 class="mt-3">Terima Kasih atas Pesanan Anda!</h3>
                            <p class="lead">Nomor Pesanan: #<?php echo $order_id; ?></p>
                        </div>
                        
                        <div class="alert alert-warning">
                            <h5 class="alert-heading">Langkah Selanjutnya:</h5>
                            <p>Untuk menyelesaikan pesanan Anda, silakan klik tombol di bawah untuk menghubungi penjual via WhatsApp. Penjual akan memverifikasi pesanan dan mengirimkan instruksi pembayaran.</p>
                        </div>
                        
                        <div class="d-grid gap-2 col-md-8 mx-auto mb-4">
                            <a href="<?php echo $whatsapp_url; ?>" class="btn btn-success btn-lg" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-whatsapp me-2" viewBox="0 0 16 16">
                                    <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.920l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
                                </svg>
                                Hubungi Penjual via WhatsApp
                            </a>
                        </div>
                        
                        <div class="mb-4">
                            <h5>Detail Pesanan</h5>
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
                                            <td class="fw-bold">Rp <?php echo number_format($total, 0, ',', '.'); ?></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="text-center">
                            <a href="../Shop.php" class="btn btn-primary">Lanjutkan Belanja</a>
                        </div>
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
    <script>
        // Auto-redirect to WhatsApp after 3 seconds (optional - remove if not wanted)
        /*
        setTimeout(function() {
            window.open('<?php echo $whatsapp_url; ?>', '_blank');
        }, 3000);
        */
    </script>
</body>
</html>
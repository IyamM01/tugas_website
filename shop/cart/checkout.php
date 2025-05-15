<?php
session_start();
include "../../config/config.php";

// Redirect jika keranjang kosong
if (empty($_SESSION['cart'])) {
    $_SESSION['error'] = "Keranjang belanja Anda kosong.";
    header("Location: cart.php");
    exit;
}

// Hitung total belanja
$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['quantity'];
}

// Proses checkout jika form dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $address = isset($_POST['address']) ? trim($_POST['address']) : '';
    $payment_method = isset($_POST['payment_method']) ? $_POST['payment_method'] : '';

    // Validasi data
    $errors = [];
    if (empty($name)) {
        $errors[] = "Nama harus diisi.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email tidak valid.";
    }
    if (empty($address)) {
        $errors[] = "Alamat harus diisi.";
    }
    if (empty($payment_method)) {
        $errors[] = "Metode pembayaran harus dipilih.";
    }

    if (empty($errors)) {
        try {
            // Mulai transaksi
            $pdo->beginTransaction();

            // Simpan data order
            $order_query = "INSERT INTO orders (customer_name, customer_email, customer_address, payment_method, total_amount, order_date) 
                           VALUES (:name, :email, :address, :payment_method, :total, NOW())";
            $order_stmt = $pdo->prepare($order_query);
            $order_stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':address' => $address,
                ':payment_method' => $payment_method,
                ':total' => $total
            ]);

            $order_id = $pdo->lastInsertId();

            // Simpan detail order
            $detail_query = "INSERT INTO order_details (order_id, book_id, quantity, price) 
                            VALUES (:order_id, :book_id, :quantity, :price)";
            $detail_stmt = $pdo->prepare($detail_query);

            foreach ($_SESSION['cart'] as $item) {
                $detail_stmt->execute([
                    ':order_id' => $order_id,
                    ':book_id' => $item['id'],
                    ':quantity' => $item['quantity'],
                    ':price' => $item['price']
                ]);
            }

            // Commit transaksi
            $pdo->commit();

            // Kosongkan keranjang
            $_SESSION['cart'] = [];

            // Set pesan sukses
            $_SESSION['message'] = "Pesanan Anda berhasil diproses dengan nomor order: #" . $order_id;

            // Redirect ke halaman konfirmasi
            header("Location: order_confirmation.php?order_id=" . $order_id);
            exit;

        } catch (PDOException $e) {
            // Rollback transaksi jika ada error
            $pdo->rollBack();
            $errors[] = "Terjadi kesalahan: " . $e->getMessage();
        }
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
        <h2 class="mb-4">Checkout</h2>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Informasi Pengiriman</h5>
                    </div>
                    <div class="card-body">
                        <form action="checkout.php" method="POST">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Alamat Lengkap</label>
                                <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Metode Pembayaran</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" id="transfer" value="transfer" required>
                                    <label class="form-check-label" for="transfer">
                                        Transfer Bank
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" id="emoney" value="emoney">
                                    <label class="form-check-label" for="emoney">
                                        E-Wallet (OVO/GoPay/DANA)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod">
                                    <label class="form-check-label" for="cod">
                                        Cash on Delivery (COD)
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="cart.php" class="btn btn-outline-secondary">Kembali ke Keranjang</a>
                                <button type="submit" class="btn btn-success">Proses Pesanan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Ringkasan Pesanan</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <?php foreach ($_SESSION['cart'] as $item): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <?php echo htmlspecialchars($item['title']); ?>
                                        <span class="text-muted d-block">Jumlah: <?php echo $item['quantity']; ?></span>
                                    </div>
                                    <span>Rp <?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?></span>
                                </li>
                            <?php endforeach; ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center fw-bold">
                                <div>Total</div>
                                <span>Rp <?php echo number_format($total, 0, ',', '.'); ?></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
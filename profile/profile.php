<?php
include '../config/auth.php';
include('../config/config.php');

$user_id = $_SESSION['user_id'] ?? null;

// Ambil data user
$sql = "SELECT name, email, no_hp, username, alamat FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $user_id) {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $no_hp = $_POST['no_hp'] ?? '';
    $alamat = $_POST['alamat'] ?? '';

    if (!empty($name) && !empty($no_hp) && !empty($alamat) && !empty($email)) {
        $stmt = $conn->prepare("UPDATE users SET name = ?, no_hp = ?, alamat = ?, email = ? WHERE user_id = ?");
        $stmt->execute([$name, $no_hp, $alamat, $email, $user_id]);

        $_SESSION['no_hp'];
        $_SESSION['alamat'];
        $_SESSION['success'] = "Profil berhasil diperbarui.";
    } else {
        $_SESSION['error'] = "Semua field harus diisi.";
    }

    header('Location: profile.php');
    exit();
}


    $stmt = $conn->prepare("SELECT cart_id FROM cart WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $cart = $stmt->fetch();

$items = [];
if ($cart) {
    $stmt = $conn->prepare("SELECT ci.*, b.book_id, b.title, b.price FROM cart_items ci JOIN books b ON ci.book_id = b.book_id WHERE ci.cart_id = ?");

    $stmt->execute([$cart['cart_id']]);
    $items = $stmt->fetchAll();
}
    $total = 0;
    foreach ($items as $item):
        $subtotal = $item['price'] * $item['quantity'];
        $total += $subtotal;
    endforeach;

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Profile - Hhibookstore</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
    <link href="../image/2.png" rel="icon" />
  </head>
  <body class="bg-gray-100">
    <div class="container mx-auto mt-10">
      
      <!-- HEADER -->
      <header class="bg-blue-500 text-white p-4 flex justify-between items-center relative">
        <h1 class="font-bold text-xl">hhibookstore</h1>

        <!-- Desktop Nav -->
        <div class="hidden md:flex space-x-6">
          <a href="../loged/index.php" class="hover:underline">Home</a>
          <a href="../login/logout.php" class="hover:underline">Logout</a>
        </div>

        <!-- Mobile Toggle -->
        <button id="menu-toggle" class="md:hidden focus:outline-none">
          <!-- hamburger icon -->
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
               viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
                  stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
        </button>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="mobile-nav absolute top-full left-0 w-full bg-blue-600 text-white flex-col space-y-2 p-4 hidden z-50">
          <a href="../loged/index.php" class="hover:underline block">Home</a>
          <a href="../login/logout.php" class="hover:underline block">Logout</a>
        </div>
      </header>

      <!-- Notification Messages -->
      <?php if (isset($_SESSION['success'])): ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mt-4" role="alert">
          <p><?php echo $_SESSION['success']; ?></p>
        </div>
        <?php unset($_SESSION['success']); ?>
      <?php endif; ?>

      <?php if (isset($_SESSION['error'])): ?>
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mt-4" role="alert">
          <p><?php echo $_SESSION['error']; ?></p>
        </div>
        <?php unset($_SESSION['error']); ?>
      <?php endif; ?>

      <!-- PROFILE + KERANJANG -->
      <div class="flex flex-col md:flex-row mt-8">
        <div class="md:w-1/3 bg-white p-4 shadow-md rounded-lg md:mr-4 mb-4 md:mb-0">
          <div class="flex flex-col items-center">
            <div class="bg-blue-200 rounded-full h-24 w-24 flex items-center justify-center">
              <span class="text-3xl font-semibold">📸</span>
            </div>
            <h1 class="mt-4 text-xl font-semibold"><?php echo $_SESSION['username']; ?> </h1>
          </div>
        </div>

        <div class="md:w-2/3 bg-white p-4 shadow-md rounded-lg">
          <h2 class="text-xl font-semibold text-blue-500">Informasi Akun</h2>
          <p class="mt-2"><strong>Name :</strong> <?php echo htmlspecialchars($user['name']); ?> </p>
          <p class="mt-2"><strong>Email :</strong> <?php echo htmlspecialchars($user['email']); ?> </p>
          <p class="mt-2"><strong>No HP :</strong> <?php echo htmlspecialchars($user['no_hp']) ?? 'Belum diisi'; ?> </p>
          <p class="mt-2"><strong>Alamat :</strong> <?php echo htmlspecialchars($user['alamat']) ?? 'Belum diisi'; ?> </p>

          <button id="editProfileBtn" class="w-full mt-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
            Tambahkan/Edit Profil
          </button>

        <h2 class="mt-6 text-xl font-semibold text-blue-500">Daftar Keranjang</h2>
        <?php foreach ($items as $index => $item): ?>
        <div class="mt-2 space-y-2">
          <div class="flex justify-between border-b py-2">
            <span><?php echo htmlspecialchars($item['title'])?></span>
            <span><?php echo number_format($item['price'], 0, ',', '.');?></span>
          </div>
        <?php endforeach; ?>
        <div class="flex justify-between mt-4 font-semibold">
          <span>Total:</span>
          <span>Rp <?php echo number_format($total, 0, ',', '.'); ?></span>
        </div>

        <form action="../shop/cart/checkout.php" method="POST">
          <button class="mt-4 w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">CHECKOUT</button>
        </form>
        </div>
      </div>
    </div>

  <div class="modal-overlay" id="modalOverlay" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
    <div class="modal">
      <h2 id="modalTitle" class="text-xl font-bold mb-4">Edit Profil</h2>
      <form id="editProfileForm" method="post" action="">
        <label for="name">Username</label>
        <input type="text" id="name" name="name" value="<?=htmlspecialchars($user['name'] ?? '')?>" required />

        <label for="email">Alamat Email</label>
        <input type="email" id="email" name="email" value="<?=htmlspecialchars($user['email'] ?? '')?>" required />

        <label for="no_hp">Nomor Telepon</label>
        <input type="tel" id="no_hp" name="no_hp" value="<?=htmlspecialchars($user['no_hp'] ?? '')?>" required />

        <label for="alamat">Alamat Lengkap</label>
        <input type="text" id="alamat" name="alamat" value="<?=htmlspecialchars($user['alamat'] ?? '')?>" required />

        <div class="modal-buttons">
          <button type="button" id="cancelBtn">Batal</button>
          <button type="submit">Simpan</button>
        </div>
      </form>
    </div>
  </div>

    <!-- Include JS -->
    <script src="../profile/profile.js"></script>
  </body>


  <script>
    // Modal functionality
    document.addEventListener('DOMContentLoaded', function() {
      const modalOverlay = document.getElementById('modalOverlay');
      const editProfileBtn = document.getElementById('editProfileBtn');
      const cancelBtn = document.getElementById('cancelBtn');
      
      // Modal open
      editProfileBtn.addEventListener('click', function() {
        modalOverlay.style.display = 'flex';
      });
      
      // Modal close with cancel button
      cancelBtn.addEventListener('click', function() {
        modalOverlay.style.display = 'none';
      });
      
      // Modal close when clicking outside
      modalOverlay.addEventListener('click', function(e) {
        if (e.target === modalOverlay) {
          modalOverlay.style.display = 'none';
        }
      });
    });
  </script>

  <style>
    /* Modal styles */
    .modal-overlay {
      display: none;
      position: fixed;
      top: 0; left: 0; right:0; bottom:0;
      background: rgba(0,0,0,0.5);
      justify-content: center;
      align-items: center;
      z-index: 1000;
    }
    .modal {
      background: white;
      padding: 20px 30px;
      border-radius: 8px;
      width: 80%;
      max-width: 400px;
      box-shadow: 0 0 10px rgba(0,0,0,0.25);
    }
    .modal label {
      display: block;
      margin: 12px 0 5px;
      font-weight: 500;
    }
    .modal input[type="text"], .modal input[type="email"], .modal input[type="tel"] {
      width: 100%;
      padding: 8px;
      box-sizing: border-box;
      border: 1px solid #ddd;
      border-radius: 4px;
    }
    .modal input[readonly] {
      background-color: #eee;
      color: #666;
    }
    .modal-buttons {
      margin-top: 20px;
      text-align: right;
    }
    .modal-buttons button {
      padding: 8px 14px;
      margin-left: 10px;
      cursor: pointer;
      border-radius: 4px;
    }
    .modal-buttons button[type="button"] {
      background-color: #f3f4f6;
      border: 1px solid #d1d5db;
    }
    .modal-buttons button[type="submit"] {
      background-color: #3b82f6;
      color: white;
      border: none;
    }
    #updateMessage {
      margin-bottom: 15px;
      color: green;
    }
  </style>
</html>
<?php
include '../config/auth-admin.php';
include '../config/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .status-select {
      border: none;
      outline: none;
      color: white;
      padding: 0.25rem 0.75rem;
      border-radius: 9999px;
      font-size: 0.875rem;
      font-weight: 500;
    }
    .status-completed {
      background-color: #3b82f6; /* blue-500 */
    }
    .status-pending {
      background-color: #f97316; /* orange-500 */
    }
    .status-process {
      background-color: #eab308; /* yellow-400 */
    }
  </style>
</head>
<body class="bg-gray-100 font-sans">
  <div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg">
      <div class="p-6 flex items-center space-x-2 text-blue-600 font-bold text-2xl">
        <span>
          <img src="../image/2.png" alt="" class="w-8 h-8">
        </span>
        <span>Admin Panel</span>
      </div>
      <nav class="mt-6 space-y-2 px-4">
        <a href="index.php" class="flex items-center p-2 hover:bg-gray-100"><span class="mr-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chart-column-big-icon lucide-chart-column-big"><path d="M3 3v16a2 2 0 0 0 2 2h16"/><rect x="15" y="5" width="4" height="12" rx="1"/><rect x="7" y="8" width="4" height="9" rx="1"/></svg></span> Dashboard</a>
        <a href="users.php" class="flex items-center p-2 hover:bg-gray-100"><span class="mr-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-icon lucide-user"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></span> Users</a>
        <a href="books.php" class="flex items-center p-2 hover:bg-gray-100"><span class="mr-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-book-open-icon lucide-book-open"><path d="M12 7v14"/><path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"/></svg></span> Books</a>
        <a href="../login/logout.php" class="flex items-center p-2 text-red-500 mt-6 hover:bg-red-100"><span class="mr-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out-icon lucide-log-out"><path d="m16 17 5-5-5-5"/><path d="M21 12H9"/><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/></svg></span> Logout</a>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6">
      <!-- Header -->
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Daftar Orders</h1>
        <div class="flex items-center space-x-4">
          <div class="relative">
            <input id="searchInput" type="text" onkeyup="liveSearch(this.value)" placeholder="Search..." class="pl-10 pr-4 py-2 rounded-full border border-gray-300" />
            <span class="absolute left-3 top-2.5 text-gray-400"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search-icon lucide-search"><path d="m21 21-4.34-4.34"/><circle cx="11" cy="11" r="8"/></svg></span>
          </div>
          <span class="relative">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bell-icon lucide-bell"><path d="M10.268 21a2 2 0 0 0 3.464 0"/><path d="M3.262 15.326A1 1 0 0 0 4 17h16a1 1 0 0 0 .74-1.673C19.41 13.956 18 12.499 18 8A6 6 0 0 0 6 8c0 4.499-1.411 5.956-2.738 7.326"/></svg>
            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs px-1 rounded-full">8</span>
          </span>
          <img src="../image/2.png" alt="Profile" class="rounded-full w-8 h-8" />
        </div>
      </div>

      <!-- Stats -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Total Users -->
        <div class="bg-white p-6 rounded shadow flex items-center">
          <div class="bg-yellow-100 p-4 rounded-full text-yellow-600 mr-4 text-2xl">👥</div>
          <div>
            <p class="text-xl font-bold">
              <?php 
                $total = $conn->prepare("SELECT COUNT(*) AS total_users FROM users WHERE role = 'customer'");
                $total->execute();
                $total = $total->fetch(PDO::FETCH_ASSOC);
                echo $total['total_users'];
              ?>
            </p>
            <p class="text-gray-500">Total Users</p>
          </div>
        </div>
        <!-- Total Orders -->
        <div class="bg-white p-6 rounded shadow flex items-center">
          <div class="bg-blue-100 p-4 rounded-full text-blue-600 mr-4 text-2xl">🛒</div>
          <div>
            <p class="text-xl font-bold">
              <?php 
                $total = $conn->prepare("SELECT COUNT(*) AS total_orders FROM orders");
                $total->execute();
                $total = $total->fetch(PDO::FETCH_ASSOC);
                echo $total['total_orders'];
              ?>
            </p>
            <p class="text-gray-500">Total Orders</p>
          </div>
        </div>
      </div>

      <!-- Recent Orders -->
      <div id="defaultTable" class="w-full table bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4">Recent Orders</h2>
        <div class="overflow-x-auto">
          <table class="min-w-full text-left">
            <thead>
              <tr>
                <th class="py-2 px-4 font-semibold text-gray-600">Order ID</th>
                <th class="py-2 px-4 font-semibold text-gray-600">User ID</th>
                <th class="py-2 px-4 font-semibold text-gray-600">Price</th>
                <th class="py-2 px-4 font-semibold text-gray-600">Status</th>
                <th class="py-2 px-4 font-semibold text-gray-600">Tanggal</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $query = $conn->prepare("SELECT * FROM orders");
              $query->execute();
              $orders = $query->fetchAll();
              foreach ($orders as $order) {
                echo "<tr class='borderer-t'>";
                echo "<td class='py-2 px-4 flex items-center space-x-2'>";
                echo "<span> {$order['order_id']} </span>";
                echo "</td>";
                echo "<td class='py-2 px-4'>{$order['user_id']}</td>";
                echo "<td class='py-2 px-4'>{$order['price']}</td>";
                echo "<td class='py-2 px-4'>
                        <form method='POST' action='update-status.php'>
                          <input type='hidden' name='order_id' value='{$order['order_id']}'>
                            <select name='status' onchange='this.form.submit()' class='status-select'>
                              <option value='Pending'" . ($order['status'] == 'Pending' ? ' selected' : '') . ">Pending</option>
                              <option value='Process'" . ($order['status'] == 'Process' ? ' selected' : '') . ">Process</option>
                              <option value='Completed'" . ($order['status'] == 'Completed' ? ' selected' : '') . ">Completed</option>
                            </select>
                        </form>
                      </td>";
                echo "<td class='py-2 px-4'>{$order['created_at']}</td>";
                echo "</tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
      <div id="searchResults" class="mt-4"></div>
    </main>
  </div>

  <!-- JS untuk Ubah Warna Dropdown -->
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const selects = document.querySelectorAll(".status-select");

      function updateColor(select) {
        select.classList.remove("status-completed", "status-pending", "status-process");
        switch (select.value) {
          case "Completed":
            select.classList.add("status-completed");
            break;
          case "Pending":
            select.classList.add("status-pending");
            break;
          case "Process":
            select.classList.add("status-process");
            break;
        }
      }

      selects.forEach(select => {
        updateColor(select);
        select.addEventListener("change", () => updateColor(select));
      });
    });

    function liveSearch() {
      const keyword = document.getElementById('searchInput').value.trim();
      const resultsContainer = document.getElementById('searchResults');
      const defaultTable = document.getElementById('defaultTable');

      if (keyword.length === 0) {
        resultsContainer.innerHTML = '';
        defaultTable.style.display = 'table';  // tampilkan tabel default
        return;
      } else {
        defaultTable.style.display = 'none';  // sembunyikan tabel default
      }

      const xhr = new XMLHttpRequest();
      xhr.open('GET', 'search-order.php?keyword=' + encodeURIComponent(keyword), true);
      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
          resultsContainer.innerHTML = "<p class='text-gray-500'>Loading...</p>";
          resultsContainer.innerHTML = `
            <div class="bg-white p-6 rounded shadow">
              <div class="overflow-x-auto">
                <table class="min-w-full text-left">
                  <thead>
                    <tr>
                      <th class="py-2 px-4 font-semibold text-gray-600">Order ID</th>
                      <th class="py-2 px-4 font-semibold text-gray-600">User ID</th>
                      <th class="py-2 px-4 font-semibold text-gray-600">Price</th>
                      <th class="py-2 px-4 font-semibold text-gray-600">Status</th>
                      <th class="py-2 px-4 font-semibold text-gray-600">Tanggal</th>
                    </tr>
                  </thead>
                  <tbody>
                    ${xhr.responseText}
                  </tbody>
                </table>
              </div>
            </div>
          `;
        }
      };
      xhr.send();
    }
  </script>
</body>
</html>
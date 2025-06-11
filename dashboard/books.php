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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
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
        <h1 class="text-3xl font-bold">Daftar Buku</h1>
        <div class="flex items-center space-x-4">
          <div class="relative">
            <input id="searchInput" type="text" onkeyup="liveSearch(this.value)" placeholder="Search..." class="pl-10 pr-4 py-2 rounded-full border border-gray-300" />
            <span class="absolute left-3 top-2.5 text-gray-400"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search-icon lucide-search"><path d="m21 21-4.34-4.34"/><circle cx="11" cy="11" r="8"/></svg></span>
          </div>
          <span class="relative">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bell-icon lucide-bell"><path d="M10.268 21a2 2 0 0 0 3.464 0"/><path d="M3.262 15.326A1 1 0 0 0 4 17h16a1 1 0 0 0 .74-1.673C19.41 13.956 18 12.499 18 8A6 6 0 0 0 6 8c0 4.499-1.411 5.956-2.738 7.326"/></svg>
            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs px-1 rounded-full">8</span>
          </span>
          <img src="../image/2.png  " alt="Profile" class="rounded-full w-8 h-8" />
        </div>
      </div>

      <!-- Stats -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white p-6 rounded shadow flex items-center">
          <div class="bg-purple-100 p-4 rounded-full text-black-600 mr-4 text-2xl"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-book-icon lucide-book"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20"/></svg></div>
          <div>
            <p class="text-xl font-bold"> <?php
              $total = $conn->prepare("SELECT COUNT(*) AS total_buku FROM books");
              $total->execute();
              $total = $total->fetch();
              echo $total['total_buku'];
              ?>
            </p>
            <p class="text-gray-500">Total</p>  
          </div>
        </div>
      </div>

      <!-- Modal toggle -->

      <div class="flex gap-2 mb-6">
        <button data-modal-target="crud-modal" data-modal-toggle="crud-modal" class="flex items-center gap-1 mb-6 block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
          Tambah
        </button>
        <button data-modal-target="stok-modal" data-modal-toggle="stok-modal" class="flex items-center gap-1 mb-6 block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12h18"/><path d="M12 3v18"/></svg>
          Tambah Stok
        </button>
      </div>


      <!-- Main modal -->
      <!-- Modal tambah buku -->
      <div id="crud-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
          <div class="relative p-4 w-full max-w-md max-h-full">
              <!-- Modal content -->
              <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                  <!-- Modal header -->
                  <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                      <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                          Create New Product
                      </h3>
                      <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
                          <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                          </svg>
                          <span class="sr-only">Close modal</span>
                      </button>
                  </div>
                  <!-- Modal body -->
                  <form action="tambah-buku.php" method="POST" enctype="multipart/form-data" class="p-4 md:p-5">
                      <div class="grid gap-4 mb-4 grid-cols-2">
                          <div class="col-span-2">
                              <label for="judul" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Judul</label>
                              <input type="text" name="judul" id="judul" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Masukan Judul" required="">
                          </div>
                          <div class="col-span-2 sm:col-span-1">
                              <label for="harga" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Harga</label>
                              <input type="text" name="harga" id="harga" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="59999" required="">
                          </div>
                          <div class="col-span-2 sm:col-span-1">
                              <label for="penulis" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Penulis</label>
                              <input type="text" name="penulis" id="penulis" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Nama Penulis" required="">
                            </div>
                            <div class="col-span-2 sm:col-span-1 flex flex-col justify-end">
                              <label for="gambar" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tambah Gambar</label>
                              <input type="file" name="gambar" id="gambar" accept="image/*" class="dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required>
                            </div>
                          <div class="col-span-2 sm:col-span-1">
                              <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
                              <select name="kategori" id="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                  <option selected="">Select category</option>
                                  <option value="novel">novel</option>
                                  <option value="cerpen">cerpen</option>
                                  <option value="komik">komik</option>
                                  <option value="dongeng">dongeng</option>
                                  <option value="dongeng">cerita anak</option>
                              </select>
                          </div>
                          <div class="col-span-2">
                              <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Product Description</label>
                              <textarea name="deskripsi" id="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write product description here"></textarea>                    
                          </div>
                      </div>
                      <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                          <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                          Tambah Buku
                      </button>
                  </form>
              </div>
          </div>
      </div> 

      <!-- modal tambah stok -->
      <div id="stok-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
          <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
              <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                Tambah Stok Buku
              </h3>
              <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="stok-modal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close modal</span>
              </button>
            </div>
            <!-- Modal Body -->
            <form action="tambah-stok.php" method="POST" class="p-4 md:p-5">
              <div class="grid gap-4 mb-4 grid-cols-2">
                <div class="col-span-2">
                  <label for="id_or_judul" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ID atau Judul Buku</label>
                  <input type="text" name="id_or_judul" id="id_or_judul" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white" placeholder="Misalnya: 12 atau 'Laskar Pelangi'" required>
                </div>
                <div class="col-span-2">
                  <label for="jumlah" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah Stok</label>
                  <input type="number" name="jumlah" id="jumlah" min="1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white" placeholder="Contoh: 5" required>
                </div>
              </div>
              <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Simpan Stok
              </button>
            </form>
          </div>
        </div>
      </div>



      <!-- Recent Orders -->

      <div id="defaultTable" class="w-full table bg-white p-6 rounded shadow">
        <div class="overflow-x-auto">
          <table class="min-w-full text-left">
            <thead>
              <tr>
                <th class="py-2 px-2 font-semibold text-gray-600">ID</th>
                <th class="py-2 px-2 font-semibold text-gray-600">Judul</th>
                <th class="py-2 px-2 font-semibold text-gray-600">Stok</th>
                <th class="py-2 px-2 font-semibold text-gray-600">Kategori</th>
                <th class="py-2 px-2 font-semibold text-gray-600">Harga</th>
                <th class="py-2 px-2 font-semibold text-gray-600">Tanggal</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $query = $conn->prepare("SELECT * FROM books");
              $query->execute();
              $books = $query->fetchAll();
              foreach ($books as $book) {
                echo "<tr class='border-t'>";
                echo "<td class='py-2 px-2 flex items-center space-x-2'>";
                echo "<span> {$book['book_id']} </span>";
                echo "</td>";
                echo "<td class='py-2 px-2'>{$book['title']}</td>";
                echo "<td class='py-2 px-2'>{$book['stock']}</td>";
                echo "<td class='py-2 px-2'>{$book['category']}</td>";
                echo "<td class='py-2 px-2'>{$book['price']}</td>";
                echo "<td class='py-2 px-2'>{$book['created_at']}</td>";
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
  <script>
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
      xhr.open('GET', 'search-books.php?keyword=' + encodeURIComponent(keyword), true);
      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
          resultsContainer.innerHTML = "<p class='text-gray-500'>Loading...</p>";
          resultsContainer.innerHTML = `
            <div class="bg-white p-6 rounded shadow">
              <div class="overflow-x-auto">
                <table class="min-w-full text-left">
                  <thead>
                    <tr>
                      <th class="py-2 px-2 font-semibold text-gray-600">ID</th>
                      <th class="py-2 px-2 font-semibold text-gray-600">Judul</th>
                      <th class="py-2 px-2 font-semibold text-gray-600">Stok</th>
                      <th class="py-2 px-2 font-semibold text-gray-600">Kategori</th>
                      <th class="py-2 px-2 font-semibold text-gray-600">Harga</th>
                      <th class="py-2 px-2 font-semibold text-gray-600">Tanggal</th>
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
<?php
include '../config/auth.php';
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings - Hhibookstore</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="../image/2.png" rel="icon">
  </head>
  <body class="bg-gray-100">
    <div class="container mx-auto mt-10">
        <header class="bg-blue-500 text-white p-4 flex justify-between items-center">
            
            <h1 class="font-bold text-xl">hhibookstore</h1>
            <div>
                <a href="../loged/index.php" class="hover:underline">Home</a>
                <a href="../login/logout.php" class="ml-4 hover:underline">Logout</a>
            </div>
        </header>

        <div class="flex mt-8">
            <div class="w-1/3 bg-white p-4 shadow-md rounded-lg mr-4">
                <div class="flex flex-col items-center">
                    <div class="bg-blue-200 rounded-full h-24 w-24 flex items-center justify-center">
                        <span class="text-3xl font-semibold">📸</span>
                    </div>
                    <h2 class="mt-4 text-xl font-semibold"> <?php echo $_SESSION['username'] ?> </h2>
                </div>
            </div>

            <div class="w-2/3 bg-white p-4 shadow-md rounded-lg">
                <h2 class="text-xl font-semibold text-blue-500">Informasi Akun</h2>
                <p class="mt-2"><strong>Email:</strong> user@example.com</p>
                <p><strong>Alamat:</strong> Jl. Contoh No. 123, Jakarta</p>

                <h2 class="mt-6 text-xl font-semibold text-blue-500">Daftar Keranjang</h2>
                <div class="mt-2">
                    <div class="flex justify-between items-center border-b py-2">
                        <span>Harry Potter - J.K. Rowling</span>
                        <span>Rp150.000</span>
                    </div>
                    <div class="flex justify-between items-center border-b py-2">
                        <span>Laskar Pelangi - Andrea Hirata</span>
                        <span>Rp85.000</span>
                    </div>
                    <div class="flex justify-between items-center border-b py-2">
                        <span>Bumi Manusia - Pramoedya Ananta Toer</span>
                        <span>Rp95.000</span>
                    </div>
                </div>

                <div class="flex justify-between items-center mt-4">
                    <strong>Total:</strong>
                    <strong>Rp330.000</strong>
                </div>

                <button class="mt-4 w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">CHECKOUT</button>
            </div>
        </div>
    </div>
  </body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="bg-white shadow-lg rounded-xl p-8 w-full max-w-md">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Lupa Password</h2>

        <form method="POST" action="action-forgot-pw.php" class="space-y-4">
            <!-- Email Input -->
            <div>
                <label for="email" class="block text-gray-700 font-semibold">Email</label>
                <input type="email" name="email" id="email" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- New Password Input -->
            <div>
                <label for="new_password" class="block text-gray-700 font-semibold">Password Baru</label>
                <input type="password" name="new_password" id="new_password" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">
                    Ganti Password
                </button>
            </div>
        </form>

        <div class="mt-4 text-center text-sm">
            <a href="login.php" class="text-blue-600 hover:underline">Kembali ke Login</a>
        </div>
    </div>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Header</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="/style.css">
</head>
<body>
    <nav class="flex items-center justify-between p-4 bg-gray-800 text-white">
        <img src="/assets/img/2.png" alt="" class="w-10 h-10">
        <a href="index.php"><h1>DASHBOARD</h1></a>
        <ul class="flex space-x-4 ml-4">
            <li><a href="users.php" class="hover:text-gray-400">Users</a></li>
            <li><a href="/books" class="hover:text-gray-400">Books</a></li>
            <li><a href=""><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-user-round-icon lucide-circle-user-round">
                        <path d="M18 20a6 6 0 0 0-12 0"/>
                        <circle cx="12" cy="10" r="4"/>
                        <circle cx="12" cy="12" r="10"/>
                    </svg>
                </a>
            </li>   
        </ul>
    </nav>
    <?php if (basename($_SERVER['SCRIPT_NAME']) === 'index.php'): ?>
    <div class="text-center justify-center">
        <h1>Welcome to the Admin Dashboard</h1>
        <p>Use the menu to navigate through the admin panel.</p>
    </div>
    <?php endif; ?>
</body>
</html>
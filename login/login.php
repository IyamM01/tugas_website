<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login dan Sign up</title>
    <link rel="stylesheet" href="Login.css">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="assets/img/2.png" rel="icon">
    <link href="assets/img/2.jpg" rel="apple-touch-icon">
</head>
<body>
    <div class="container" id="container">
        <div class="form-container register-container">
            <form action="action_login.php" method="POST">
                <h1>Register Here</h1>
                <input type="text" placeholder="Username" name="username" required>
                <input type="text" placeholder="Name" name="name" required>
                <input type="email" placeholder="Email" name="email" required>
                <input type="password" placeholder="Password" name="password" required>
                <button type="submit">Register</button>
            </form>
        </div>

        <div class="form-container login-container">
            <form action="action-login.php" method="POST">
                <h1>Login Here</h1>
                <input type="text" placeholder="Email or username" name="email_or_username" required>
                <input type="password" placeholder="Password" name="password" required>
                <div class="content">
                    <div class="checkbox">
                        <input type="checkbox" name="checkbox" id="checkbox">
                        <label for="checkbox">Remember me</label>
                    </div>
                    <div class="pass-link">
                        <a href="forgot-pw.php">Forgot Password</a>
                    </div>
                </div>
                <button type="submit">Login</button>
            </form>
        </div>

        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1 class="title">Hello <br> friends</h1>
                    <p>if You have an account, login There and have fun</p>
                    <button class="ghost" id="login">Login
                        <i class="lni lni-arrow-left login"></i>
                    </button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1 class="title">Start your <br> journey now</h1>
                    <p>if you don't have account yet, join us and start your journey</p>
                    <button class="ghost" id="register">Register
                        <i class="lni lni-arrow-right register"></i>
                    </button>
                </div>
            </div>
        </div>   
    </div>

<script src="script.js"></script>

</body>
</html>
<?php
session_start();
include "db.php";

// Handle Register
if (isset($_POST['register'])) {
    $email = $_POST['reg_email'];
    $pass = password_hash($_POST['reg_pass'], PASSWORD_BCRYPT);

    $cek = $conn->query("SELECT * FROM users WHERE email = '$email'");
    if ($cek->num_rows > 0) {
        $_SESSION['error'] = "Email sudah terdaftar.";
    } else {
        $conn->query("INSERT INTO users (email, password) VALUES ('$email', '$pass')");
        $_SESSION['success'] = "Berhasil daftar. Silakan login.";
    }
    header("Location: auth.php#login");
    exit;
}

// Handle Login
if (isset($_POST['login'])) {
    $email = $_POST['log_email'];
    $pass = $_POST['log_pass'];

    $data = $conn->query("SELECT * FROM users WHERE email = '$email'");
    if ($data->num_rows > 0) {
        $row = $data->fetch_assoc();
        if (password_verify($pass, $row['password'])) {
            $_SESSION['user'] = $row['email'];
            header("Location: index.php");
            exit;
        } else {
            $_SESSION['error'] = "Password salah.";
        }
    } else {
        $_SESSION['error'] = "Email tidak ditemukan.";
    }
    header("Location: auth.php#login");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login / Daftar</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    // Script untuk toggle tab berdasarkan anchor hash
    window.onload = function () {
        const loginForm = document.getElementById('loginForm');
        const registerForm = document.getElementById('registerForm');
        const loginTab = document.getElementById('loginTab');
        const registerTab = document.getElementById('registerTab');

        function switchTab(tab) {
            if (tab === 'login') {
                loginForm.style.display = 'block';
                registerForm.style.display = 'none';
                loginTab.classList.add('text-white', 'border-yellow-500');
                registerTab.classList.remove('text-white', 'border-yellow-500');
                registerTab.classList.add('text-gray-400');
            } else {
                loginForm.style.display = 'none';
                registerForm.style.display = 'block';
                loginTab.classList.remove('text-white', 'border-yellow-500');
                loginTab.classList.add('text-gray-400');
                registerTab.classList.add('text-white', 'border-yellow-500');
            }
        }

        if (window.location.hash === '#register') {
            switchTab('register');
        } else {
            switchTab('login');
        }

        loginTab.onclick = function () {
            switchTab('login');
        };
        registerTab.onclick = function () {
            switchTab('register');
        };
    };
  </script>
</head>
<body class="bg-gray-900 text-white min-h-screen flex items-center justify-center px-4">
  <div class="w-full max-w-md bg-gray-800 rounded-lg p-6 shadow-lg">
    <?php if (isset($_SESSION['error'])): ?>
      <div class="bg-red-600 p-3 rounded mb-4 text-sm"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['success'])): ?>
      <div class="bg-green-600 p-3 rounded mb-4 text-sm"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <div class="flex justify-between mb-6">
      <a id="loginTab" href="#login" class="w-1/2 p-2 text-center font-bold border-b-2">Login</a>
      <a id="registerTab" href="#register" class="w-1/2 p-2 text-center font-bold border-b-2">Daftar</a>
    </div>

    <!-- Login Form -->
    <form method="post" action="auth.php" id="loginForm" class="space-y-4">
      <input type="hidden" name="login">
      <input required type="email" name="log_email" placeholder="Email" class="w-full p-2 bg-gray-700 rounded">
      <input required type="password" name="log_pass" placeholder="Password" class="w-full p-2 bg-gray-700 rounded">
      <button class="w-full bg-red-600 hover:bg-red-500 p-2 rounded font-semibold">Masuk</button>
    </form>

    <!-- Register Form -->
    <form method="post" action="auth.php" id="registerForm" class="space-y-4 mt-6 hidden">
      <input type="hidden" name="register">
      <input required type="email" name="reg_email" placeholder="Email" class="w-full p-2 bg-gray-700 rounded">
      <input required type="password" name="reg_pass" placeholder="Password" class="w-full p-2 bg-gray-700 rounded">
      <button class="w-full bg-yellow-600 hover:bg-yellow-500 p-2 rounded font-semibold">Daftar</button>
    </form>

    <div class="text-center mt-6">
      <a href="index.php" class="text-sm text-blue-400 hover:underline">← Kembali ke Halaman Utama</a>
    </div>
  </div>
</body>
</html>

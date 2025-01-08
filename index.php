<?php
// Memulai sesi
session_start();

// Cek apakah pengguna sudah login, jika ya langsung alihkan ke dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php"); // Mengarahkan ke halaman dashboard jika sudah login
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f7f3f2;
        }
        .container {
            text-align: center;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .container h1 {
            color: #800000;
            margin-bottom: 20px;
        }
        .container p {
            margin-bottom: 30px;
            color: #333;
        }
        .btn-login {
            display: inline-block;
            padding: 10px 20px;
            font-size: 1rem;
            color: #fff;
            background-color: #800000;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn-login:hover {
            background-color: #a52a2a;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Selamat Datang di Novia Kalibrasi</h1>
        <p>Silakan login untuk mengakses fitur manajemen perusahaan Novia Kalibrasi.</p>
        <a href="login.php" class="btn-login">Login</a>
    </div>
</body>
</html>

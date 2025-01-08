<?php
session_start();
include 'config.php';

// Periksa apakah pengguna login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Periksa apakah ID ada di URL
if (!isset($_GET['id'])) {
    header("Location: schedule.php");
    exit();
}

$id = intval($_GET['id']);

// Hapus data jadwal berdasarkan ID
$query = "DELETE FROM schedules WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: schedule.php");
    exit();
} else {
    $error = "Terjadi kesalahan saat menghapus jadwal. Coba lagi.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Jadwal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f3f2;
            margin: 0;
            padding: 0;
            color: #333;
        }
        header, nav, footer {
            background-color: #800000;
            color: white;
            padding: 10px 20px;
            text-align: center;
        }
        nav a {
            margin: 0 10px;
            color: white;
            text-decoration: none;
        }
        nav a:hover {
            text-decoration: underline;
        }
        .container {
            padding: 20px;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Manajemen Perusahaan Kalibrasi</h1>
    </header>
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="schedule.php">Kembali ke Jadwal</a>
    </nav>
    <div class="container">
        <h2>Hapus Jadwal Kalibrasi</h2>

        <!-- Tampilkan pesan error jika ada -->
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

        <p>Jadwal kalibrasi telah berhasil dihapus. Anda akan diarahkan kembali ke halaman jadwal.</p>
    </div>
    <footer>
        <p>&copy; 2025 Novia Kalibrasi</p>
    </footer>
</body>
</html>

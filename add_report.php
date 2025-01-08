<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

$message = "";

// Proses tambah laporan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $upload_dir = 'uploads/reports/';
    $file_name = basename($_FILES['file']['name']);
    $target_file = $upload_dir . $file_name;

    // Periksa apakah file diunggah
    if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
        // Simpan informasi laporan ke database
        $sql = "INSERT INTO reports (title, file_name) VALUES (?, ?)";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ss", $title, $file_name);
            if ($stmt->execute()) {
                $message = "Laporan berhasil ditambahkan.";
            } else {
                $message = "Gagal menyimpan laporan: " . $conn->error;
            }
            $stmt->close();
        }
    } else {
        $message = "Gagal mengunggah file.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Laporan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f3f2;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
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

        footer {
            margin-top: auto;
        }

        .container {
            max-width: 500px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            background-color: #800000;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #a52a2a;
        }

        .btn-back {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #800000;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }

        .btn-back:hover {
            background-color: #a52a2a;
        }

        .message {
            margin-bottom: 20px;
            padding: 10px;
            color: #fff;
            background-color: #4caf50;
            border-radius: 5px;
        }

        .message.error {
            background-color: #f44336;
        }
    </style>
</head>
<body>
    <header>
        <h1>Manajemen Perusahaan Kalibrasi</h1>
    </header>
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="calibration.php">Alat Kalibrasi</a>
        <a href="schedule.php">Jadwal Kalibrasi</a>
        <a href="clients.php">Klien</a>
        <a href="reports.php">Laporan</a>
        <a href="logout.php">Logout</a>
    </nav>
    <div class="container">
        <h2>Tambah Laporan Baru</h2>
        <?php if ($message): ?>
            <div class="message <?php echo strpos($message, 'berhasil') !== false ? '' : 'error'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data">
            <label for="title">Judul Laporan</label>
            <input type="text" name="title" id="title" required>

            <label for="file">File Laporan (PDF)</label>
            <input type="file" name="file" id="file" accept=".pdf" required>

            <button type="submit">Unggah Laporan</button>
        </form>
        <a href="reports.php" class="btn-back">Kembali ke Laporan</a>
    </div>
    <footer>
        <p>&copy; 2025 Novia Kalibrasi</p>
    </footer>
</body>
</html>

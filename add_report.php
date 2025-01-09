<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $file_name = $_FILES['report_file']['name'];
    $file_tmp = $_FILES['report_file']['tmp_name'];

    // Validasi input
    if (empty($title) || empty($file_name)) {
        $error_message = "Semua field harus diisi!";
    } else {
        // Menyimpan file
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($file_name);
        if (move_uploaded_file($file_tmp, $target_file)) {
            // Menyimpan data ke database
            $sql = "INSERT INTO reports (title, file_name) VALUES ('$title', '$file_name')";
            if ($conn->query($sql) === TRUE) {
                $success_message = "Laporan berhasil ditambahkan!";
            } else {
                $error_message = "Gagal menambahkan laporan: " . $conn->error;
            }
        } else {
            $error_message = "Gagal mengupload file.";
        }
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
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            background-color: #800000;
            color: white;
            padding: 10px 20px;
            text-align: center;
        }

        .container {
            padding: 20px;
            flex: 1;
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }

        form {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="text"], input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .submit-btn {
            background-color: #800000;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        .submit-btn:hover {
            background-color: #a52a2a;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .back-btn {
            display: inline-block;
            padding: 10px 15px;
            background-color: #800000;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        .back-btn:hover {
            background-color: #a52a2a;
        }
    </style>
</head>
<body>
    <header>
        <h1>Novia Kalibrasi</h1>
    </header>

    <div class="container">
        <h2>Tambah Laporan</h2>

        <?php if (isset($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php elseif (isset($success_message)): ?>
            <div class="success-message"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <form action="add_report.php" method="POST" enctype="multipart/form-data">
            <label for="title">Judul Laporan</label>
            <input type="text" id="title" name="title" required>

            <label for="report_file">File Laporan</label>
            <input type="file" id="report_file" name="report_file" accept=".pdf,.docx,.xlsx" required>

            <button type="submit" class="submit-btn">Tambah Laporan</button>
        </form>

        <!-- Tombol Kembali ke Laporan -->
        <a href="reports.php" class="back-btn">Kembali ke Laporan</a>
    </div>
</body>
</html>

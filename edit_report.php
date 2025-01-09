<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Mengambil data laporan berdasarkan ID
    $sql = "SELECT * FROM reports WHERE id = $id";
    $result = $conn->query($sql);
    $report = $result->fetch_assoc();

    if (!$report) {
        header("Location: reports.php");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $file_name = $_FILES['report_file']['name'];
    $file_tmp = $_FILES['report_file']['tmp_name'];

    // Validasi input
    if (empty($title)) {
        $error_message = "Semua field harus diisi!";
    } else {
        // Menyimpan file jika ada yang baru
        if (!empty($file_name)) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($file_name);
            move_uploaded_file($file_tmp, $target_file);

            // Mengupdate file lama
            $sql = "UPDATE reports SET title = '$title', file_name = '$file_name' WHERE id = $id";
        } else {
            // Jika tidak ada file baru, hanya mengupdate judul
            $sql = "UPDATE reports SET title = '$title' WHERE id = $id";
        }

        if ($conn->query($sql) === TRUE) {
            $success_message = "Laporan berhasil diperbarui!";
        } else {
            $error_message = "Gagal memperbarui laporan: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
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
    position: relative;
}

.container {
    padding: 20px;
    flex: 1;
    width: 100%;
    max-width: 600px;
    margin: 0 auto;
}

h2 {
    text-align: center;
    margin-bottom: 20px;
    font-size: 24px;
    color: #333;
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
    box-sizing: border-box;
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
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Laporan</title>
    <style>
        /* Sama seperti sebelumnya */
    </style>
</head>
<body>
    <header>
        <h1>Novia Kalibrasi</h1>
    </header>

    <div class="container">
        <h2>Edit Laporan</h2>

        <?php if (isset($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php elseif (isset($success_message)): ?>
            <div class="success-message"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <form action="edit_report.php?id=<?php echo $report['id']; ?>" method="POST" enctype="multipart/form-data">
            <label for="title">Judul Laporan</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($report['title']); ?>" required>

            <label for="report_file">File Laporan (Opsional)</label>
            <input type="file" id="report_file" name="report_file" accept=".pdf,.docx,.xlsx">

            <button type="submit" class="submit-btn">Update Laporan</button>
        </form>
       <!-- Tombol Kembali ke Laporan -->
       <a href="reports.php" class="back-btn">Kembali ke Laporan</a>
</body>
</html>

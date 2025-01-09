<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

// Proses penyimpanan data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tool_name = trim($_POST['tool_name']);
    $calibration_status = trim($_POST['calibration_status']);
    $last_calibrated = trim($_POST['last_calibrated']);

    if (!empty($tool_name) && !empty($calibration_status) && !empty($last_calibrated)) {
        $stmt = $conn->prepare("INSERT INTO calibration_tools (tool_name, calibration_status, last_calibrated) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $tool_name, $calibration_status, $last_calibrated);

        if ($stmt->execute()) {
            header("Location: calibration.php?success=Alat berhasil ditambahkan");
            exit();
        } else {
            $error_message = "Gagal menambahkan alat. Silakan coba lagi.";
        }
        $stmt->close();
    } else {
        $error_message = "Semua field harus diisi.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Alat Kalibrasi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f3f2;
            padding: 20px;
        }
        form {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffe4e1;
            border: 1px solid #cd5c5c;
            border-radius: 10px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 15px;
        }
        input[type="text"],
        input[type="date"],
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background-color: #800000;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #a52a2a;
        }
        .error {
            color: red;
            margin-bottom: 15px;
        }
        .back-btn {
            display: inline-block;
            margin-bottom: 20px;
            text-decoration: none;
            background-color: #800000;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
        }
        .back-btn:hover {
            background-color: #a52a2a;
        }
    </style>
</head>
<body>
    <a href="calibration.php" class="back-btn">Kembali</a>
    <h1>Tambah Alat Kalibrasi</h1>
    <?php if (isset($error_message)): ?>
        <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
    <?php endif; ?>
    <form method="POST" action="">
        <label for="tool_name">Nama Alat:</label>
        <input type="text" id="tool_name" name="tool_name" required>

        <label for="calibration_status">Status Kalibrasi:</label>
        <select id="calibration_status" name="calibration_status" required>
            <option value="Terkalibrasi">Terkalibrasi</option>
            <option value="Belum Terkalibrasi">Belum Terkalibrasi</option>
        </select>

        <label for="last_calibrated">Tanggal Kalibrasi Terakhir:</label>
        <input type="date" id="last_calibrated" name="last_calibrated" required>

        <button type="submit">Simpan</button>
    </form>
</body>
</html>

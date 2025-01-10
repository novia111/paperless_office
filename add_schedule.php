<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tool_name = $_POST['tool_name'];
    $client_name = $_POST['client_name'];
    $schedule_date = $_POST['schedule_date'];
    $status = $_POST['status'];

    // Ganti 'schedules' dengan nama tabel baru, misalnya 'calibration_schedule'
    $stmt = $conn->prepare("INSERT INTO calibration_schedules (tool_name, client_name, schedule_date, status) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        die("Kesalahan pada query: " . $conn->error);
    }

    $stmt->bind_param("ssss", $tool_name, $client_name, $schedule_date, $status);

    if (!$stmt->execute()) {
        die("Gagal menyimpan data: " . $stmt->error);
    }

    $stmt->close();
    header("Location: schedule.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Jadwal Kalibrasi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f3f2;
            padding: 20px;
        }
        .form-container {
            background-color: #ffe4e1;
            padding: 20px;
            border-radius: 10px;
            max-width: 500px;
            margin: auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-container form {
            display: flex;
            flex-direction: column;
        }
        .form-container form input,
        .form-container form select,
        .form-container form button {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form-container form button {
            background-color: #800000;
            color: white;
            cursor: pointer;
            border: none;
        }
        .form-container form button:hover {
            background-color: #a52a2a;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Tambah Jadwal Kalibrasi</h2>
        <form method="POST" action="">
            <input type="text" name="tool_name" placeholder="Nama Alat" required>
            <input type="text" name="client_name" placeholder="Nama Klien" required>
            <input type="date" name="schedule_date" required>
            <select name="status" required>
                <option value="Scheduled">Scheduled</option>
                <option value="Completed">Completed</option>
            </select>
            <button type="submit">Simpan</button>
        </form>
        <a href="schedule.php" class="back-link">&larr; Kembali ke Jadwal</a>
    </div>
</body>
</html>

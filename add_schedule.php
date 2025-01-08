<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

// Menangani form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tool_name = $_POST['tool_name'];
    $client_name = $_POST['client_name'];
    $schedule_date = $_POST['schedule_date'];
    $status = $_POST['status'];

    // Periksa apakah input kosong
    if (empty($tool_name) || empty($client_name) || empty($schedule_date) || empty($status)) {
        $error_message = "Semua kolom harus diisi!";
    } else {
        // Menyimpan data ke database
        $sql = "INSERT INTO schedules (tool_name, client_name, schedule_date, status) 
                VALUES ('$tool_name', '$client_name', '$schedule_date', '$status')";
        
        if ($conn->query($sql) === TRUE) {
            header("Location: schedule.php"); // Redirect ke halaman jadwal
            exit();
        } else {
            $error_message = "Terjadi kesalahan: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Jadwal Kalibrasi</title>
    <style>
        /* Gaya dasar */
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f3f2;
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Header */
        header {
            background-color: #800000;
            color: white;
            padding: 10px 20px;
            text-align: center;
            position: relative;
        }

        /* Dropdown button */
        .dropdown {
            position: absolute;
            top: 15px;
            right: 20px;
            cursor: pointer;
            font-size: 30px;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: #800000;
            min-width: 160px;
            z-index: 1;
            border-radius: 5px;
        }

        .dropdown-content a {
            color: white;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #a52a2a;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        /* Kontainer */
        .container {
            padding: 20px;
            flex: 1;
        }

        /* Tombol */
        .btn-back {
            display: inline-block;
            padding: 10px 20px;
            background-color: #800000;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 0;
            text-align: center;
        }

        .btn-back:hover {
            background-color: #a52a2a;
        }

        /* Form */
        form {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 8px;
            margin: 8px 0;
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

        .error {
            color: red;
            margin-bottom: 20px;
        }

        /* Footer */
        footer {
            background-color: #800000;
            color: white;
            text-align: center;
            padding: 10px;
            margin-top: auto; /* Push footer to the bottom */
        }
    </style>
</head>
<body>
    <header>
        <h1>Novia Kalibrasi</h1>
        <!-- Dropdown button -->
        <div class="dropdown">
            &#x22EE; <!-- Unicode untuk titik tiga -->
            <div class="dropdown-content">
                <a href="dashboard.php">Dashboard</a>
                <a href="calibration.php">Alat Kalibrasi</a>
                <a href="schedule.php">Jadwal Kalibrasi</a>
                <a href="clients.php">Klien</a>
                <a href="reports.php">Laporan</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </header>
    <div class="container">
        <h2>Tambah Jadwal Kalibrasi</h2>

        <?php if (isset($error_message)): ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form action="add_schedule.php" method="POST">
            <label for="tool_name">Nama Alat</label>
            <input type="text" id="tool_name" name="tool_name" required>

            <label for="client_name">Nama Klien</label>
            <input type="text" id="client_name" name="client_name" required>

            <label for="schedule_date">Tanggal Jadwal</label>
            <input type="date" id="schedule_date" name="schedule_date" required>

            <label for="status">Status</label>
            <select id="status" name="status" required>
                <option value="Scheduled">Scheduled</option>
                <option value="Completed">Completed</option>
            </select>

            <button type="submit">Simpan Jadwal</button>
        </form>

        <a href="schedule.php" class="btn-back">Kembali ke Jadwal</a>
    </div>
</body>
</html>

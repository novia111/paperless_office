<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

// Variabel untuk menyimpan data yang diedit
$schedule_id = null;
$tool_name = "";
$client_name = "";
$schedule_date = "";
$status = "";

// Proses Edit Jadwal
if (isset($_GET['id'])) {
    $schedule_id = $_GET['id'];

    // Mengambil data jadwal berdasarkan id
    $stmt = $conn->prepare("SELECT id, tool_name, client_name, schedule_date, status FROM schedules WHERE id = ?");
    $stmt->bind_param("i", $schedule_id);
    $stmt->execute();
    $stmt->bind_result($schedule_id, $tool_name, $client_name, $schedule_date, $status);
    $stmt->fetch();
    $stmt->close();
}

// Proses Update Jadwal
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tool_name = $_POST['tool_name'];
    $client_name = $_POST['client_name'];
    $schedule_date = $_POST['schedule_date'];
    $status = $_POST['status'];

    // Update data jadwal
    $stmt = $conn->prepare("UPDATE schedules SET tool_name = ?, client_name = ?, schedule_date = ?, status = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $tool_name, $client_name, $schedule_date, $status, $schedule_id);
    $stmt->execute();
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
    <title>Edit Jadwal Kalibrasi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f3f2;
            padding: 20px;
        }
        .form-container {
            margin: auto;
            max-width: 600px;
            background-color: #ffe4e1;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-container h2 {
            text-align: center;
        }
        .input-field {
            margin-bottom: 15px;
            width: 100%;
        }
        .input-field input,
        .input-field select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .submit-button {
            display: block;
            width: 100%;
            padding: 10px 15px;
            background-color: #800000;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }
        .submit-button:hover {
            background-color: #a52a2a;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Edit Jadwal Kalibrasi</h2>
        <form method="POST">
            <div class="input-field">
                <label for="tool_name">Nama Alat</label>
                <input type="text" id="tool_name" name="tool_name" value="<?php echo htmlspecialchars($tool_name); ?>" required>
            </div>
            <div class="input-field">
                <label for="client_name">Nama Klien</label>
                <input type="text" id="client_name" name="client_name" value="<?php echo htmlspecialchars($client_name); ?>" required>
            </div>
            <div class="input-field">
                <label for="schedule_date">Tanggal Kalibrasi</label>
                <input type="date" id="schedule_date" name="schedule_date" value="<?php echo htmlspecialchars($schedule_date); ?>" required>
            </div>
            <div class="input-field">
                <label for="status">Status</label>
                <select id="status" name="status" required>
                <option value="Scheduled">Scheduled</option>
                <option value="Completed">Completed</option>
                </select>
            </div>
            <button type="submit" class="submit-button">Simpan Perubahan</button>
        </form>
    </div>
</body>
</html>

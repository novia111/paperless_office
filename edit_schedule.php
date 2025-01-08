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

// Ambil data jadwal berdasarkan ID
$query = "SELECT * FROM schedules WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: schedule.php");
    exit();
}

$row = $result->fetch_assoc();

// Update data jadwal jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tool_name = htmlspecialchars($_POST['tool_name']);
    $client_name = htmlspecialchars($_POST['client_name']);
    $schedule_date = htmlspecialchars($_POST['schedule_date']);
    $status = htmlspecialchars($_POST['status']);

    $update_query = "UPDATE schedules SET tool_name = ?, client_name = ?, schedule_date = ?, status = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("ssssi", $tool_name, $client_name, $schedule_date, $status, $id);

    if ($update_stmt->execute()) {
        header("Location: schedule.php");
        exit();
    } else {
        $error = "Terjadi kesalahan saat memperbarui jadwal. Coba lagi.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Jadwal</title>
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
        form {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        form input, form select, form button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            font-size: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        form button {
            background-color: #800000;
            color: white;
            border: none;
            cursor: pointer;
        }
        form button:hover {
            background-color: #a00000;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Edit Jadwal Kalibrasi</h1>
    </header>
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="schedule.php">Kembali ke Jadwal</a>
    </nav>
    <div class="container">
        <h2>Edit Jadwal</h2>
        
        <!-- Tampilkan pesan error jika ada -->
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

        <!-- Form Edit Jadwal -->
        <form method="POST" action="">
            <label for="tool_name">Nama Alat</label>
            <input type="text" id="tool_name" name="tool_name" value="<?php echo $row['tool_name']; ?>" required>

            <label for="client_name">Nama Klien</label>
            <input type="text" id="client_name" name="client_name" value="<?php echo $row['client_name']; ?>" required>

            <label for="calibration_date">Tanggal Kalibrasi</label>
            <input type="date" id="schedule_date" name="schedule_date" value="<?php echo $row['schedule_date']; ?>" required>

            <label for="status">Status</label>
            <select id="status" name="status" required>
                <option value="Scheduled" <?php echo $row['status'] === 'Scheduled' ? 'selected' : ''; ?>>Scheduled</option>
                <option value="Completed" <?php echo $row['status'] === 'Completed' ? 'selected' : ''; ?>>Completed</option>
            </select>

            <button type="submit">Simpan Perubahan</button>
        </form>
    </div>
    <footer>
        <p>&copy; 2025 Novia Kalibrasi</p>
    </footer>
</body>
</html>

<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

// Proses Hapus Jadwal
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    $stmt = $conn->prepare("DELETE FROM schedules WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();

    header("Location: schedule.php");
    exit();
}

// Mengambil data jadwal kalibrasi
$sql_schedules = "SELECT id, tool_name, client_name, DATE_FORMAT(schedule_date, '%d %M %Y') AS formatted_date, status FROM schedules ORDER BY schedule_date ASC";
$result_schedules = $conn->query($sql_schedules);
$schedules_list = [];

if ($result_schedules && $result_schedules->num_rows > 0) {
    while ($row = $result_schedules->fetch_assoc()) {
        $schedules_list[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Kalibrasi</title>
    <style>
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
    padding: 15px 30px;
    text-align: center;
    position: relative;
}
h2 {
    font-size: 2rem; /* Ukuran font yang lebih besar */
    color: #800000;  /* Warna merah gelap yang senada dengan tema */
    margin: 20px 0;  /* Memberikan jarak atas dan bawah */
    text-align: center; /* Menyusun teks ke tengah */
    font-weight: bold; /* Membuat teks lebih tebal */
    text-transform: uppercase; /* Mengubah teks menjadi huruf kapital semua */
    letter-spacing: 1px; /* Memberikan jarak antar huruf */
    padding: 10px 0; /* Memberikan padding di atas dan bawah teks */
    border-bottom: 3px solid #800000; /* Garis bawah dengan warna yang sama */
    width: fit-content; /* Menyesuaikan lebar dengan panjang teks */
    margin-left: auto; /* Rata tengah secara horizontal */
    margin-right: auto; /* Rata tengah secara horizontal */
}


/* Dropdown button */
.dropdown {
    position: absolute;
    top: 15px;
    right: 30px;
    cursor: pointer;
    font-size: 30px;
}

.dropdown-content {
    display: none;
    position: absolute;
    right: 0;
    background-color: #800000;
    min-width: 180px;
    z-index: 1;
    border-radius: 5px;
}

.dropdown-content a {
    color: white;
    padding: 12px 20px;
    text-decoration: none;
    display: block;
    transition: background-color 0.3s;
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
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
}

/* Tombol Tambah Jadwal */
.add-button {
            display: inline-block;
            width: fit-content;
            padding: 10px 15px;
            background-color: #800000;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            text-align: center;
        }

        .add-button:hover {
            background-color: #a52a2a;
        }

/* Tabel */
table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px auto;
    text-align: left;
    border-radius: 5px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

th, td {
    border: 1px solid #ddd;
    padding: 12px 20px;
}

th {
    background-color: #800000;
    color: white;
    text-align: center;
}

td {
    text-align: center;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
}

tr:hover {
    background-color: #f1f1f1;
}

/* Tombol Aksi */
.action-btn {
    padding: 8px 15px;
    margin-right: 10px;
    background-color: #800000;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-size: 14px;
    transition: background-color 0.3s;
}

.action-btn:hover {
    background-color: #a52a2a;
}

/* Responsif untuk ukuran layar kecil */
@media (max-width: 768px) {
    .dropdown {
        font-size: 24px;
        top: 10px;
        right: 15px;
    }

    table {
        font-size: 14px;
        margin: 10px;
    }

    .add-btn {
        padding: 10px 15px;
    }

    .container {
        padding: 10px;
    }
}
    </style>
</head>
<body>
    <div class="table-container">
        <h2>Jadwal Kalibrasi</h2>
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
        <a href="add_schedule.php" class="add-button">Tambah Jadwal Baru</a>
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Alat</th>
                    <th>Nama Klien</th>
                    <th>Tanggal Kalibrasi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($schedules_list)): ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">Tidak ada jadwal kalibrasi</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($schedules_list as $schedule): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($schedule['tool_name']); ?></td>
                            <td><?php echo htmlspecialchars($schedule['client_name']); ?></td>
                            <td><?php echo htmlspecialchars($schedule['formatted_date']); ?></td>
                            <td><?php echo htmlspecialchars($schedule['status']); ?></td>
                            <td class="action-buttons">
                                <a href="edit_schedule.php?id=<?php echo $schedule['id']; ?>">Edit</a>
                                <a href="schedule.php?delete_id=<?php echo $schedule['id']; ?>" onclick="return confirm('Yakin ingin menghapus jadwal ini?');">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

// Mengambil data laporan dari database
$sql = "SELECT * FROM reports ORDER BY created_at DESC";
$result = $conn->query($sql);
$reports = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reports[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - Novia Kalibrasi</title>
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

        .container {
            padding: 20px;
            flex: 1;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px auto;
            text-align: left;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            word-wrap: break-word;
        }

        th {
            background-color: #800000;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .action-btn {
            padding: 5px 10px;
            text-decoration: none;
            color: white;
            background-color: #800000;
            border-radius: 5px;
            margin-right: 5px;
        }

        .action-btn:hover {
            background-color: #a52a2a;
        }

        .add-btn {
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

        .add-btn:hover {
            background-color: #a52a2a;
        }
    </style>
</head>
<body>
    <header>
        <h1>Novia Kalibrasi</h1>
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

    <a href="add_report.php" class="add-btn">Tambah Laporan</a>

    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>Nomor</th>
                    <th>Judul</th>
                    <th>Nama File</th>
                    <th>Tanggal Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($reports)): ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">Tidak ada laporan yang tersedia</td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; ?>
                    <?php foreach ($reports as $report): ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo htmlspecialchars($report['title']); ?></td>
                            <td><?php echo htmlspecialchars($report['file_name']); ?></td>
                            <td><?php echo date('d M Y H:i', strtotime($report['created_at'])); ?></td>
                            <td>
                                <!-- Tombol Lihat -->
                                <a href="uploads/<?php echo htmlspecialchars($report['file_name']); ?>" class="action-btn" target="_blank">Lihat</a>

                                <!-- Tombol Edit -->
                                <a href="edit_report.php?id=<?php echo $report['id']; ?>" class="action-btn">Edit</a>

                                <!-- Tombol Hapus -->
                                <a href="delete_report.php?id=<?php echo $report['id']; ?>" class="action-btn" onclick="return confirm('Anda yakin ingin menghapus laporan ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

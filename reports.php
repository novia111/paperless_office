<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan</title>
    <style>
        /* Gaya Umum */
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f3f2;
            margin: 0;
            padding: 0;
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
            position: relative;
        }

        /* Tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            text-align: center;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
        }

        table th {
            background-color: #800000;
            color: white;
        }

        /* Tombol */
        .btn-add, .btn-download, .btn-delete, .btn-options {
            display: inline-block;
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 5px;
            margin: 5px 5px;
            color: white;
            font-weight: bold;
        }

        .btn-add {
            background-color: #800000;
        }

        .btn-add:hover {
            background-color: #a52a2a;
        }

        .btn-download {
            background-color: #800000;
        }

        .btn-download:hover {
            background-color: #a52a2a;
        }

        .btn-delete {
            background-color: #800000;
        }

        .btn-delete:hover {
            background-color: #c9302c;
        }

        /* Three dot menu button */
        .btn-options {
            background-color: #666;
            color: white;
            padding: 8px;
            border-radius: 50%;
            font-size: 16px;
            cursor: pointer;
            border: none;
            transition: background-color 0.3s ease;
            position: relative;
        }

        .btn-options:hover {
            background-color: #444;
        }

        /* Dropdown Menu */
        .dropdown {
            display: none;
            position: absolute;
            background-color: #ffffff;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
            border-radius: 5px;
            min-width: 120px;
            right: 0;
            top: 30px;
        }

        .dropdown a {
            color: black;
            padding: 10px 12px;
            text-decoration: none;
            display: block;
            border-bottom: 1px solid #ddd;
        }

        .dropdown a:last-child {
            border-bottom: none;
        }

        .dropdown a:hover {
            background-color: #f1f1f1;
        }

        .show {
            display: block;
        }

        /* Back Button */
        .btn-back {
            background-color: #800000;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            font-weight: bold;
            text-align: center;
        }

        .btn-back:hover {
            background-color: #a52a2a;
        }

        /* Responsif */
        @media (max-width: 768px) {
            table, .btn-add, .btn-download {
                width: 100%;
                margin: 5px 0;
            }
        }
    </style>
    <script>
        function toggleDropdown(event) {
            const dropdown = event.currentTarget.nextElementSibling;
            dropdown.classList.toggle("show");
        }

        window.onclick = function(event) {
            if (!event.target.matches('.btn-options')) {
                const dropdowns = document.querySelectorAll('.dropdown');
                dropdowns.forEach(function(dropdown) {
                    dropdown.classList.remove('show');
                });
            }
        }
    </script>
</head>
<body>
    <header>
        <h1>Manajemen Perusahaan Kalibrasi</h1>
    </header>
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
    <div class="container">
        <h2>Daftar Laporan</h2>
        <a href="add_report.php" class="btn-add">Tambah Laporan</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Judul Laporan</th>
                    <th>Tanggal Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
    <?php if (empty($reports)): ?>
        <tr>
            <td colspan="4">Belum ada laporan yang tersedia.</td>
        </tr>
    <?php else: ?>
        <?php foreach ($reports as $report): ?>
            <tr>
                <td><?php echo $report['id']; ?></td>
                <td><?php echo htmlspecialchars($report['title']); ?></td>
                <td><?php echo date("d-m-Y", strtotime($report['created_at'])); ?></td>
                <td>
                    <!-- Three Dot Menu Button -->
                    <button class="btn-options" onclick="toggleDropdown(event)">...</button>
                    <!-- Dropdown Menu -->
                    <div class="dropdown">
                        <a href="view_report.php?id=<?php echo $report['id']; ?>" class="btn-download">Lihat</a>
                        <a href="delete_report.php?delete_id=<?php echo $report['id']; ?>" class="btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus laporan ini?');">Hapus</a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
        </table>
        <!-- Back Button -->
        <a href="dashboard.php" class="btn-back">Kembali</a>
    </div>
    <footer>
        <p>&copy; 2025 Novia Kalibrasi</p>
    </footer>
</body>
</html>

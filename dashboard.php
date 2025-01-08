<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

// Mengambil data jumlah alat terkalibrasi
$sql_tools = "SELECT COUNT(*) AS total_tools FROM calibration_tools";
$result_tools = $conn->query($sql_tools);
$total_tools = ($result_tools && $result_tools->num_rows > 0) ? $result_tools->fetch_assoc()['total_tools'] : 0;

// Mengambil data jadwal kalibrasi mendatang tanpa LIMIT
$sql_schedules = "SELECT tool_name, DATE_FORMAT(schedule_date, '%d %M %Y') AS formatted_date FROM schedules WHERE schedule_date >= CURDATE() ORDER BY schedule_date ASC";
$result_schedules = $conn->query($sql_schedules);
$schedules_list = [];

if ($result_schedules && $result_schedules->num_rows > 0) {
    while ($row = $result_schedules->fetch_assoc()) {
        $schedules_list[] = $row;
    }
}

// Mengambil data jumlah klien
$sql_clients = "SELECT COUNT(*) AS total_clients FROM clients";
$result_clients = $conn->query($sql_clients);
$total_clients = ($result_clients && $result_clients->num_rows > 0) ? $result_clients->fetch_assoc()['total_clients'] : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f3f2;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        header {
            background-color: #800000;
            color: white;
            padding: 15px;
            text-align: center;
            position: relative;
        }

        /* Tombol titik tiga */
        .menu-toggle {
            position: absolute;
            top: 20px;
            right: 20px;
            cursor: pointer;
            font-size: 30px;
            color: white;
        }

        /* Dropdown menu */
        .menu {
            display: none;
            position: absolute;
            top: 50px;
            right: 20px;
            background-color: #800000;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 100;
        }
        .menu a {
            color: white;
            padding: 10px;
            text-decoration: none;
            display: block;
        }
        .menu a:hover {
            background-color: #a52a2a;
        }

        .container {
            padding: 20px;
            flex: 1;
        }
        .grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .card {
            background-color: #ffe4e1;
            border: 1px solid #cd5c5c;
            border-radius: 10px;
            padding: 20px;
            width: 300px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }
        footer {
            text-align: center;
            padding: 10px;
        }

        /* CSS untuk memastikan grafik penuh lebar */
        .chart-container {
            width: 100%;
            height: 400px;
            margin-top: 20px;
        }
        canvas {
            width: 100% !important; /* Memastikan canvas memenuhi lebar container */
            height: 100% !important; /* Memastikan canvas memenuhi tinggi container */
        }
    </style>
</head>
<body>
    <header>
        <h1>Novia Kalibrasi</h1>
        <p>Selamat datang, <?php echo htmlspecialchars($_SESSION['username']); ?></p>
        <span class="menu-toggle" onclick="toggleMenu()">&#8230;</span> <!-- Tombol titik tiga -->
        <div class="menu" id="menu">
            <a href="dashboard.php">Dashboard</a>
            <a href="calibration.php">Alat Kalibrasi</a>
            <a href="schedule.php">Jadwal Kalibrasi</a>
            <a href="clients.php">Klien</a>
            <a href="reports.php">Laporan</a>
            <a href="logout.php">Logout</a>
        </div>
    </header>

    <div class="container">
        <div class="grid">
            <div class="card">
                <h3>Jumlah Alat Terkalibrasi</h3>
                <p>Total: <?php echo $total_tools; ?></p>
            </div>
            <div class="card">
                <h3>Jadwal Kalibrasi Mendatang</h3>
                <ul>
                    <?php if (empty($schedules_list)): ?>
                        <li>Tidak ada jadwal mendatang</li>
                    <?php else: ?>
                        <?php foreach ($schedules_list as $schedule): ?>
                            <li><?php echo htmlspecialchars($schedule['tool_name']) . ' - ' . htmlspecialchars($schedule['formatted_date']); ?></li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="card">
                <h3>Jumlah Klien</h3>
                <p>Total: <?php echo $total_clients; ?></p>
            </div>
        </div>

        <!-- Chart.js -->
        <div class="chart-container">
            <canvas id="dashboardChart"></canvas>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Novia Kalibrasi</p>
    </footer>

    <script>
        // Fungsi untuk toggle menu
        function toggleMenu() {
            const menu = document.getElementById('menu');
            menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
        }

        // Data untuk grafik
        const ctx = document.getElementById('dashboardChart').getContext('2d');
        const dashboardChart = new Chart(ctx, {
            type: 'bar', // Jenis grafik
            data: {
                labels: ['Alat Terkalibrasi', 'Jadwal Mendatang', 'Klien'], // Label kategori
                datasets: [{
                    label: 'Jumlah Data',
                    data: [<?php echo $total_tools; ?>, <?php echo count($schedules_list); ?>, <?php echo $total_clients; ?>], // Data jumlah
                    backgroundColor: ['#ff5733', '#33c1ff', '#b0e57c'], // Warna grafik
                    borderColor: ['#c0392b', '#2980b9', '#27ae60'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: true
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.raw + ' item(s)';
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>

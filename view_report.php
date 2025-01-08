<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

// Periksa apakah ID laporan diberikan
if (isset($_GET['id'])) {
    $report_id = intval($_GET['id']);

    // Ambil informasi laporan dari database
    $sql = "SELECT * FROM reports WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $report_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $report = $result->fetch_assoc();
            $file_path = 'uploads/reports/' . $report['file_name'];

            if (file_exists($file_path)) {
                // Tampilkan laporan dalam iframe
                $report_title = htmlspecialchars($report['title']);
            } else {
                echo "File laporan tidak ditemukan.";
                exit();
            }
        } else {
            echo "Laporan tidak ditemukan.";
            exit();
        }
        $stmt->close();
    }
} else {
    echo "ID laporan tidak valid.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat Laporan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f3f2;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #800000;
        }

        iframe {
            width: 100%;
            height: 500px;
            border: none;
            margin-top: 20px;
        }

        .btn-download {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #800000;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }

        .btn-download:hover {
            background-color: #a52a2a;
        }

        .btn-back {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color:  #800000;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }

        .btn-back:hover {
            background-color:  #800000;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2><?php echo $report_title; ?></h2>
        <iframe src="<?php echo $file_path; ?>" frameborder="0"></iframe>
        <div style="text-align: center;">
            <a href="download_report.php?id=<?php echo $report_id; ?>" class="btn-download">Unduh Laporan</a>
            <a href="reports.php" class="btn-back">Kembali</a>
        </div>
    </div>
</body>
</html>

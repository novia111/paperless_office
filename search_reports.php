<?php
include 'config.php';

// Mendapatkan kata kunci pencarian dari parameter URL
$search_query = isset($_GET['search']) ? $_GET['search'] : '';

// Menyiapkan SQL untuk mencari laporan berdasarkan judul atau nama file
$sql_reports = "SELECT id, title, file_name, created_at 
                FROM reports 
                WHERE title LIKE ? OR file_name LIKE ?";

// Menyiapkan statement untuk query
$stmt = $conn->prepare($sql_reports);

if (!$stmt) {
    // Jika query gagal disiapkan, tampilkan pesan error
    die("Error dalam query SQL: " . $conn->error);
}

// Menggunakan parameter pencarian dengan wildcard untuk LIKE
$search_param = "%" . $search_query . "%";

// Mengikat parameter ke query
$stmt->bind_param("ss", $search_param, $search_param);

// Menjalankan query
$stmt->execute();
$result_reports = $stmt->get_result();

// Menampilkan hasil pencarian
if ($result_reports && $result_reports->num_rows > 0) {
    $no = 1;
    while ($row = $result_reports->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $no++ . '</td>';
        echo '<td>' . htmlspecialchars($row['title']) . '</td>';
        echo '<td>' . htmlspecialchars($row['file_name']) . '</td>';
        echo '<td>' . date('d M Y H:i', strtotime($row['created_at'])) . '</td>';
        echo '<td>';
        echo '<a href="uploads/' . htmlspecialchars($row['file_name']) . '" class="action-btn" target="_blank">Lihat</a>';
        echo '<a href="edit_report.php?id=' . $row['id'] . '" class="action-btn">Edit</a>';
        echo '<a href="delete_report.php?id=' . $row['id'] . '" class="action-btn" onclick="return confirm(\'Hapus laporan ini?\');">Hapus</a>';
        echo '</td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="5" style="text-align: center;">Tidak ada laporan yang cocok</td></tr>';
}

// Menutup statement dan koneksi
$stmt->close();
$conn->close();
?>

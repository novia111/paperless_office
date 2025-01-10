<?php
include 'config.php';

// Mendapatkan kata kunci pencarian
$search_query = "";
if (isset($_GET['search'])) {
    $search_query = $_GET['search'];
}

// Mengambil data alat kalibrasi berdasarkan pencarian
$sql_tools = "SELECT id, tool_name, calibration_status, last_calibrated 
              FROM calibration_tools 
              WHERE tool_name LIKE ? 
              OR calibration_status LIKE ? 
              OR last_calibrated LIKE ?";

$stmt = $conn->prepare($sql_tools);
$search_param = "%$search_query%";
$stmt->bind_param("sss", $search_param, $search_param, $search_param);
$stmt->execute();
$result_tools = $stmt->get_result();

// Menampilkan hasil pencarian
if ($result_tools && $result_tools->num_rows > 0) {
    $no = 1;
    while ($row = $result_tools->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $no++ . '</td>';
        echo '<td>' . htmlspecialchars($row['tool_name']) . '</td>';
        echo '<td>' . htmlspecialchars($row['calibration_status']) . '</td>';
        echo '<td>' . htmlspecialchars($row['last_calibrated']) . '</td>';
        echo '<td>';
        echo '<a href="edit_tool.php?id=' . $row['id'] . '" class="action-btn">Edit</a>';
        echo '<a href="delete_tool.php?id=' . $row['id'] . '" class="action-btn" onclick="return confirm(\'Hapus alat ini?\');">Hapus</a>';
        echo '</td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="5" style="text-align: center;">Tidak ada data alat kalibrasi</td></tr>';
}
?>

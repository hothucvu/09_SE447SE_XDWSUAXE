<?php
include("../../db.php");

if (isset($_GET['loaixe'])) {
    $loaixe = $_GET['loaixe'];

    // Lấy các dịch vụ thuộc loại xe được chọn
    $sql = "SELECT * FROM dichvu WHERE Loaixe = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $loaixe);
    $stmt->execute();
    $result = $stmt->get_result();

    // In ra các tùy chọn để trả về cho giao diện
    echo '<option value="" disabled selected>-- Chọn phân khúc dịch vụ & giá linh kiện --</option>';
    while ($row = $result->fetch_assoc()) {
        echo "<option value='".$row['id']."'>".$row['Tendv']." (".number_format($row['Gia'])." VNĐ)</option>";
    }
}
?>
<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$message = "";

if (isset($_POST['add_service'])) {
    $Loaixe = $_POST['Loaixe'];
    $Tendv = $_POST['Tendv'];
    $Gia = $_POST['Gia'];
    $Mota = $_POST['Mota'];
    
    // ĐÃ SỬA: Đổi trạng thái mặc định thành 'Đang hoạt động' để trang danh sách nhận diện được luôn
    $sql = "INSERT INTO dichvu (Loaixe, Tendv, Gia, Mota, TrangThai) VALUES (?, ?, ?, ?, 'Đang hoạt động')";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssis", $Loaixe, $Tendv, $Gia, $Mota);
    
    if ($stmt->execute()) {
        $message = "<p style='color:green; font-weight:bold; text-align:center;'>Thêm dịch vụ mới thành công!</p>";
    } else {
        $message = "<p style='color:red; text-align:center;'>Lỗi hệ thống: " . $stmt->error . "</p>";
    }
}
?>

<link rel="stylesheet" href="../FE/">


<div class="container">
    <form class="register-form" method="POST">
        <h2>THÊM DỊCH VỤ MỚI</h2>
        
        <?php echo $message; ?>
        
        <div class="form-input">
            <p>Phân loại dòng xe: </p>
            <select name="Loaixe" required>
                <option value="" disabled selected>-- Chọn loại xe áp dụng --</option>
                <option value="Xe máy số">Xe máy (Xe số)</option>
                <option value="Xe tay ga">Xe tay ga</option>
                <option value="Xe điện">Xe máy điện / Xe đạp điện</option>
                <option value="Xe ô tô">Xe ô tô</option>
            </select>
        </div>

        <div class="form-input">
            <p>Tên dịch vụ: </p>
            <input type="text" name="Tendv">
        </div>

        <div class="form-input">
            <p>Giá tiền niêm yết (VNĐ): </p>
            <input type="number" name="Gia">
        </div>

        <div class="form-input">
            <p>Mô tả chi tiết gói dịch vụ: </p>
            <textarea name="Mota" rows="4"></textarea>
        </div>
        
        <button type="submit" name="add_service" class="btn">XÁC NHẬN THÊM</button>
        
        <p class="footer-text" style="text-align:center;">
            <a href="index.php?page=qly_dichvu">← Quay lại xem danh sách dịch vụ</a>
        </p>
    </form>
</div>
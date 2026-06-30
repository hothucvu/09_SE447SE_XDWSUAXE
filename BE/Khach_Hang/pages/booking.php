<?php

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id_khach = $_SESSION['user_id'];
$message = "";

if (isset($_POST['booking'])) {
    $Dichvu_id = $_POST['Dichvu_id'];
    $Loaixe = $_POST['Loaixe'];
    $Diachi = $_POST['Diachi'];
    
    $sql = "INSERT INTO datlich (Khach_id, Dichvu_id, Loaixe, Diachi, `Time`, TrangThai) VALUES (?, ?, ?, ?, NOW(), 'cho_nhan')";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $id_khach, $Dichvu_id, $Loaixe, $Diachi);
    
    if ($stmt->execute()) {
        $message = "<p style='color:green; font-weight:bold; text-align:center;'>Đặt lịch thành công! Vui lòng chờ thợ xác nhận.</p>";
    } else {
        $message = "<p style='color:red; text-align:center;'>Lỗi hệ thống: " . $stmt->error . "</p>";
    }
}
?>

<link rel="stylesheet" href="../FE/Khach_Hang/profile.css">

<div class="container">
    <form class="form" method="POST">
        <h2>Đặt dịch vụ sửa xe chuyên nghiệp</h2>
        
        <?php echo $message; ?>
        
        <div class="form-input">
            <p>Loại xe của bạn: </p>
            <select name="Loaixe" onchange="fetchDichVu(this.value)" required>
                <option value="" disabled selected>-- Chọn loại xe của bạn --</option>
                <option value="Xe máy số">Xe máy (Xe số)</option>
                <option value="Xe tay ga">Xe tay ga</option>
                <option value="Xe điện">Xe máy điện / Xe đạp điện</option>
                <option value="Xe ô tô">Xe ô tô</option>
            </select>
        </div>

        <div class="form-input">
            <p>Chọn dịch vụ & Phân khúc giá: </p>
            <select name="Dichvu_id" id="o_dichvu" required>
                <option value="" disabled selected>-- Vui lòng chọn loại xe trước --</option>
            </select>
        </div>

        <div class="form-input">
            <p>Địa chỉ của bạn: </p>
            <input type="text" name="Diachi" placeholder="Nhập địa chỉ thợ cần đến" required>
        </div>

        <button type="submit" name="booking" class="btn-submit">ĐẶT LỊCH NGAY</button>
        
        <p class="footer-text" style="text-align:center; margin-top:15px;">
            <a href="index.php?page=list">Xem danh sách dịch vụ</a>
        </p>
    </form>
</div>

<script>
function fetchDichVu(tenLoaiXe) {
    // 1. Tìm tới ô select Dịch vụ bằng ID
    const oDichVu = document.getElementById('o_dichvu');
    
    // 2. Gửi yêu cầu lấy dữ liệu ngầm đến file get_dichvu.php kèm theo tên loại xe
    fetch('Khach_Hang/pages/get_dichvu.php?loaixe=' + encodeURIComponent(tenLoaiXe))
        .then(response => response.text()) // Chuyển kết quả nhận được thành dạng chữ (HTML)
        .then(data => {
            oDichVu.innerHTML = data; // Thay thế nội dung ô Dịch vụ bằng danh sách mới nhận được
        });
}
</script>
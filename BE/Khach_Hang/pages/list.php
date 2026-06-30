<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id_khach = $_SESSION['user_id'];
$message = "";

// 2. XỬ LÝ KHI KHÁCH HÀNG BẤM NÚT "HỦY LỊCH"
if (isset($_POST['cancel'])) {
    $datlich_id = $_POST['datlich_id'];
    
    $sql_cancel = "UPDATE datlich SET TrangThai = 'huy' WHERE id = ? AND Khach_id = ?";
    $stmt_cancel = $conn->prepare($sql_cancel);
    $stmt_cancel->bind_param("ii", $datlich_id, $id_khach);
    
    if ($stmt_cancel->execute()) {
        $message = "<p style='color:green; text-align:center; font-weight:bold;'>Đã hủy đơn đặt lịch thành công!</p>";
    } else {
        $message = "<p style='color:red; text-align:center;'>Hủy lịch thất bại: " . $conn->error . "</p>";
    }
}

// 3. TRUY VẤN LẤY LỊCH SỬ ĐƠN HÀNG (Sắp xếp mới nhất lên đầu)
$sql = "SELECT dl.*, dv.Tendv, dv.Gia 
        FROM datlich dl 
        INNER JOIN dichvu dv ON dl.Dichvu_id = dv.id 
        WHERE dl.Khach_id = ? 
        ORDER BY dl.Time DESC";

$stmt_get = $conn->prepare($sql);
$stmt_get->bind_param("i", $id_khach);
$stmt_get->execute();
$result = $stmt_get->get_result();
?>

<link rel="stylesheet" href="../FE/Khach_Hang/list.css">


<div class="booking-list">
    <h2 style="text-align: center">Lịch sử đặt dịch vụ của bạn</h2>
    
    <?php echo $message; ?>

    <?php
    if ($result && $result->num_rows > 0) {

        // Dùng vòng lặp while để duyệt qua từng đơn hàng có trong DB
        while ($dl = $result->fetch_assoc()) {
            $text_trang_thai = "";
            if ($dl['TrangThai'] === 'cho_nhan') $text_trang_thai = "Chờ thợ nhận lịch";
            else if ($dl['TrangThai'] === 'da_nhan') $text_trang_thai = "Thợ đang di chuyển";
            else if ($dl['TrangThai'] === 'da_thanh_toan') $text_trang_thai = "Đã thanh toán";
            else if ($dl['TrangThai'] === 'hoan_thanh') $text_trang_thai = "Hoàn thành";
            else if ($dl['TrangThai'] === 'huy') $text_trang_thai = "Đơn đã hủy";
            ?>
            
            <div class="booking-card" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 8px;">
                <h3>🛠️ Đơn hàng mã số: #<?php echo $dl['id']; ?></h3>
                
                <div class="info-row"><strong>Dịch vụ yêu cầu:</strong> <?php echo $dl['Tendv']; ?></div>
                <div class="info-row"><strong>Phân khúc giá linh kiện:</strong> <span style="color: #28a745; font-weight: bold;"><?php echo number_format($dl['Gia']); ?> VNĐ</span></div>
                <div class="info-row"><strong>Loại xe:</strong> <?php echo $dl['Loaixe']; ?></div>
                <div class="info-row"><strong>Địa chỉ sửa chữa:</strong> <?php echo $dl['Diachi']; ?></div>
                <div class="info-row"><strong>Thời gian đặt:</strong> <?php echo date('d/m/Y H:i', strtotime($dl['Time'])); ?></div>
                
                <div class="info-row">
                    <strong>Trạng thái:</strong> 
                    <span>
                        <?php echo $text_trang_thai; ?>
                    </span>
                </div>

                <div class="action-group">
                    
                    <?php if ($dl['TrangThai'] === 'cho_nhan'): ?>
                        <form method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn đặt lịch này không?');" style="padding: 5px;">
                            <input type="hidden" name="datlich_id" value="<?php echo $dl['id']; ?>">
                            <button type="submit" name="cancel" class="btn btn-cancel">Hủy đặt lịch</button>
                        </form>
                    <?php endif; ?>

                    <?php if ($dl['TrangThai'] === 'da_nhan'): ?>
                        <form method="POST" action="index.php?page=pay" style="padding: 5px">
                            <input type="hidden" name="datlich_id" value="<?php echo $dl['id']; ?>">
                            <button type="submit" name="pay" class="btn btn-pay">Thanh toán</button>
                        </form>
                    <?php endif; ?>

                    <?php if ($dl['TrangThai'] === 'hoan_thanh'): ?>
                        <a href="index.php?page=review&datlich_id=<?php echo $dl['id']; ?>">
                            ⭐ Đánh giá dịch vụ
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            
            <?php
        }
    } else {
        echo "<p style='text-align:center; color:#666;'>Bạn chưa đặt dịch vụ sửa chữa nào trên hệ thống.</p>";
    }
    ?>
</div>
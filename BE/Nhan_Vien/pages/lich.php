<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id_tho = $_SESSION['user_id'];
$message = "";

// 2. XỬ LÝ KHI THỢ BẤM NÚT "HỦY NHẬN LỊCH" (Trả đơn về trạng thái chờ)
if (isset($_POST['cancel'])) {
    $datlich_id = $_POST['datlich_id'];
    
    $sql_cancel = "UPDATE datlich SET Tho_id = NULL, TrangThai = 'cho_nhan' WHERE id = ? AND Tho_id = ?";
    $stmt_cancel = $conn->prepare($sql_cancel);
    $stmt_cancel->bind_param("ii", $datlich_id, $id_tho);
    
    if ($stmt_cancel->execute()) {
        $message = "<p style='color:green; text-align:center; font-weight:bold;'>Đã hủy nhận lịch!</p>";
    } else {
        $message = "<p style='color:red; text-align:center;'>Hủy lịch thất bại: " . $conn->error . "</p>";
    }
}

// 3. XỬ LÝ KHI THỢ BẤM NÚT "HOÀN THÀNH" (Xác nhận sửa xong xe)
if (isset($_POST['complete'])) {
    $datlich_id = $_POST['datlich_id'];
    
    $sql_complete = "UPDATE datlich SET TrangThai = 'hoan_thanh' WHERE id = ? AND Tho_id = ?";
    $stmt_complete = $conn->prepare($sql_complete);
    $stmt_complete->bind_param("ii", $datlich_id, $id_tho);
    
    if ($stmt_complete->execute()) {
        $message = "<p style='color:green; text-align:center; font-weight:bold;'>Đã xác nhận hoàn thành đơn hàng thành công.</p>";
    } else {
        $message = "<p style='color:red; text-align:center;'>Thất bại: " . $conn->error . "</p>";
    }
}

$sql = "SELECT dl.*, dv.Tendv, dv.Gia 
        FROM datlich dl 
        INNER JOIN dichvu dv ON dl.Dichvu_id = dv.id 
        WHERE dl.Tho_id = ? 
        ORDER BY dl.Time DESC";

$stmt_get = $conn->prepare($sql);
$stmt_get->bind_param("i", $id_tho);
$stmt_get->execute();
$result = $stmt_get->get_result();
?>

<link rel="stylesheet" href="../FE/Nhan_Vien/nhan_lich.css">

<div class="booking-list">
    <h2 style="text-align: center; font-weight: bolder;">Lịch làm việc của bạn</h2>
    
    <?php echo $message; ?>

    <?php
    if ($result && $result->num_rows > 0) {
        while ($dl = $result->fetch_assoc()) {
            
            // Xử lý text hiển thị trạng thái
            $text_trang_thai = ($dl['TrangThai'] === 'da_nhan') ? "Đang tiến hành / Di chuyển" : "Đã sửa hoàn thành";
            ?>
            
            <div class="booking-card" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 8px; background: #fff;">
                <h3>🛠️ Đơn hàng mã số: #<?php echo $dl['id']; ?></h3>
                
                <div class="info-row"><strong>Dịch vụ yêu cầu:</strong> <?php echo $dl['Tendv']; ?></div>
                <div class="info-row"><strong>Giá linh kiện:</strong> <span style="color: #28a745; font-weight: bold;"><?php echo number_format($dl['Gia']); ?> VNĐ</span></div>
                <div class="info-row"><strong>Loại xe:</strong> <?php echo $dl['Loaixe']; ?></div>
                <div class="info-row"><strong>Địa chỉ khách hàng:</strong> <?php echo $dl['Diachi']; ?></div>
                <div class="info-row"><strong>Thời gian đặt:</strong> <?php echo date('d/m/Y H:i', strtotime($dl['Time'])); ?></div>
                
                <div class="info-row" style="margin-top: 5px;">
                    <strong>Trạng thái:</strong> 
                    <span class="">
                        <?php echo $text_trang_thai; ?>
                    </span>
                </div>

                <div class="action-group">
                    <?php if ($dl['TrangThai'] === 'da_nhan' || $dl['TrangThai'] === 'da_thanh_toan'): ?>
                        
                        <form method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn hủy và trả lịch này về danh sách chờ không?');" style="margin: 0;">
                            <input type="hidden" name="datlich_id" value="<?php echo $dl['id']; ?>">
                            <button type="submit" name="cancel" class="btn btn-cancel">Hủy nhận lịch</button>
                        </form>
                        
                        <form method="POST" onsubmit="return confirm('Bạn đã sửa xong xe cho khách và xác nhận hoàn thành đơn này?');" style="margin: 0;">
                            <input type="hidden" name="datlich_id" value="<?php echo $dl['id']; ?>">
                            <button type="submit" name="complete" class="btn btn-complete">Hoàn thành sửa</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
            
            <?php
        }
    } else {
        echo "<p style='text-align:center; color:#666; margin-top: 30px;'>Bạn chưa nhận lịch sửa chữa nào trên hệ thống.</p>";
    }
    ?>
</div>
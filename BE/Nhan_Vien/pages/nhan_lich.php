<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id_tho = $_SESSION['user_id']; 
$message = "";

// 2. XỬ LÝ KHI THỢ BẤM NÚT "NHẬN LỊCH"
if (isset($_POST['get_booking'])) {
    $datlich_id = $_POST['datlich_id']; // Lấy ID đơn hàng từ thẻ input ẩn
    $sql_update = "UPDATE datlich SET Tho_id = ?, TrangThai = 'da_nhan' WHERE id = ? AND Tho_id IS NULL";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ii", $id_tho, $datlich_id);
    
    if ($stmt_update->execute() && $stmt_update->affected_rows > 0) {
        $message = "<p style='color:green; text-align:center; font-weight:bold;'>Nhận lịch thành công! Hãy chuẩn bị đồ nghề di chuyển.</p>";
    } else {
        $message = "<p style='color:red; text-align:center;'>Nhận lịch thất bại hoặc đơn này đã có thợ khác nhận trước!</p>";
    }
}
$sql = "SELECT dl.*, dv.Tendv, dv.Gia 
        FROM datlich dl 
        INNER JOIN dichvu dv ON dl.Dichvu_id = dv.id 
        WHERE dl.Tho_id IS NULL AND dl.TrangThai = 'cho_nhan'
        ORDER BY dl.Time DESC";

$result = $conn->query($sql);
?>

<link rel="stylesheet" href="../FE/Nhan_Vien/nhan_lich.css">

<div class="booking-list">
    <h2 style="text-align: center; font-weight: bolder;">Danh sách đơn chờ nhận lịch</h2>
    
    <?php echo $message; ?>

    <?php 
    if ($result && $result->num_rows > 0) {
        while ($dl = $result->fetch_assoc()) {
            ?>
            <div class="booking-card" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 8px; background: #fff;">
                <h3>🛠️ Đơn hàng mã số: #<?php echo $dl['id']; ?></h3>
                
                <div class="info-row"><strong>Dịch vụ yêu cầu:</strong> <?php echo $dl['Tendv']; ?></div>
                <div class="info-row"><strong>Giá linh kiện:</strong> <span style="color: #28a745; font-weight: bold;"><?php echo number_format($dl['Gia']); ?> VNĐ</span></div>
                <div class="info-row"><strong>Loại xe:</strong> <?php echo $dl['Loaixe']; ?></div>
                <div class="info-row"><strong>Địa chỉ khách:</strong> <?php echo $dl['Diachi']; ?></div>
                <div class="info-row"><strong>Thời gian khách đặt:</strong> <?php echo date('d/m/Y H:i', strtotime($dl['Time'])); ?></div>
                
                <div style="margin-top: 15px; border-top: 1px dashed #eee; padding-top: 10px;">
                    <form method="POST" onsubmit="return confirm('Bạn chắc chắn muốn nhận sửa đơn hàng này chứ?');">
                        <input type="hidden" name="datlich_id" value="<?php echo $dl['id']; ?>">
                        <button type="submit" name="get_booking">
                            Nhận lịch này
                        </button>
                    </form>
                </div>
            </div>
            <?php
        }
    } else {
        echo "<p style='text-align:center; color:#666; margin-top: 30px;'>Hiện tại không có đơn hàng nào đang chờ sửa chữa.</p>";
    }
    ?>
</div>
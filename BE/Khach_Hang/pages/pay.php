<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id_khach = $_SESSION['user_id'];
$message = "";

$datlich_id = isset($_POST['datlich_id']) ? intval($_POST['datlich_id']) : 0;

$sql_check = "SELECT dl.*, dv.Tendv, dv.Gia 
              FROM datlich dl 
              INNER JOIN dichvu dv ON dl.Dichvu_id = dv.id 
              WHERE dl.id = ? AND dl.Khach_id = ? AND dl.TrangThai = 'da_nhan' 
              LIMIT 1";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("ii", $datlich_id, $id_khach);
$stmt_check->execute();
$res_check = $stmt_check->get_result();
$don_hang = $res_check->fetch_assoc();

if (!$don_hang) {
    echo "<div style='max-width:500px; margin:50px auto; text-align:center; padding:25px; background:#fff; border-radius:8px; box-shadow:0 2px 10px rgba(0,0,0,0.05); font-family:Arial;'>
            <p style='color:#e53e3e; font-weight:bold;'>⚠️ Đơn hàng không tồn tại hoặc trạng thái không hợp lệ để thanh toán!</p>
            <a href='index.php?page=list' style='color:#3182ce; text-decoration:none; font-weight:bold;'>← Quay lại lịch sử đặt lịch</a>
          </div>";
    exit();
}

if (isset($_POST['btn_confirm_pay'])) {
    $sql_update = "UPDATE datlich SET TrangThai = 'da_thanh_toan' WHERE id = ? AND Khach_id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ii", $datlich_id, $id_khach);

    if ($stmt_update->execute()) {
        $message = "<div class='msg-success'>
                        🎉 Thanh toán thành công!
                    </div>";
        echo "<script>
                setTimeout(function(){
                    window.location.href = 'index.php?page=list';
                }, 2500);
              </script>";
    } else {
        $message = "<div class='msg-error'>Lỗi hệ thống khi cập nhật thanh toán: " . htmlspecialchars($conn->error) . "</div>";
    }
}
?>
<link rel="stylesheet" href='./../FE/Khach_Hang/pay.css'>
<div class="pay-container">
    <div class="pay-box">
        <h2>THANH TOÁN QUA VÍ / NGÂN HÀNG</h2>

        <?php echo $message; ?>

        <div class="bill-detail">
            <div class="bill-row"><span>Mã đơn đặt lịch:</span> <strong>#<?php echo $don_hang['id']; ?></strong></div>
            <div class="bill-row"><span>Dịch vụ sử dụng:</span> <span><?php echo htmlspecialchars($don_hang['Tendv']); ?></span></div>
            <div class="bill-row"><span>Loại xe cứu hộ:</span> <span><?php echo htmlspecialchars($don_hang['Loaixe']); ?></span></div>
            <div class="bill-row"><span>Thời gian thực hiện:</span> <span><?php echo date('d/m/Y H:i', strtotime($don_hang['Time'])); ?></span></div>
            <div class="bill-total"><span>Tổng chi phí:</span> <span><?php echo number_format($don_hang['Gia'], 0, ',', '.'); ?> VNĐ</span></div>
        </div>

        <form method="POST" action="">
            <input type="hidden" name="datlich_id" value="<?php echo $datlich_id; ?>">

            <div class="method-group">
                <div id="qr_info_block" class="qr-block">
                    <p style=" font-weight:bold"><i class="fa-solid fa-mobile-screen"></i> Quét mã QR để chuyển khoản trực tuyến</p>

                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=CHUYENKHOAN_DON_<?php echo $don_hang['id']; ?>_TIEN_<?php echo $don_hang['Gia']; ?>" alt="Mã QR Chuyển Khoản" style="border: 4px solid #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 15px;">
                    
                    <div>
                        <p style="margin: 4px 0;"><strong>Ngân hàng:</strong> MB Bank (Quân Đội)</p>
                        <p style="margin: 4px 0;"><strong>Số TK:</strong> 0337831249</p>
                        <p style="margin: 4px 0;"><strong>Chủ TK:</strong> HO THUC VU</p>
                    </div>
                </div>
            </div>

            <button type="submit" name="btn_confirm_pay" class="btn-pay-submit">
                Hoàn thành chuyển khoản
            </button>
        </form>
    </div>
</div>
<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$danhgia_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($danhgia_id <= 0) {
    echo "<p class='msg-e'>Mã đánh giá không hợp lệ!</p>";
    exit();
}

$sql = "SELECT dg.*, dl.Time, dl.Loaixe, dv.Tendv, dl.Khach_id, tk.SDT
        FROM danh_gia dg
        INNER JOIN datlich dl ON dg.dat_lich_id = dl.id
        INNER JOIN dichvu dv ON dl.Dichvu_id = dv.id
        INNER JOIN taikhoan tk ON dl.Khach_id = tk.id
        WHERE dg.id = ? 
        LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $danhgia_id);
$stmt->execute();
$result = $stmt->get_result();
$dg_detail = $result->fetch_assoc();

if (!$dg_detail) {
    echo "<p class='msg-e''>Không tìm thấy dữ liệu đánh giá này!</p>";
    exit();
}
?>

<style>
    .detail-container { max-width: 700px; margin: 30px auto; font-family: Arial, sans-serif; padding: 0 15px; }
    .detail-box { background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; }
    .detail-box h3 { border-bottom: 2px solid #edf2f7; padding-bottom: 10px; color: #2d3748; margin-top: 20px; }
    .detail-box h3:first-child { margin-top: 0; }
    .info-grid { display: grid; grid-template-columns: 180px 1fr; gap: 10px; margin-bottom: 10px; font-size: 15px; }
    .info-label { font-weight: bold; color: #4a5568; }
    .info-value { color: #2d3748; }
    .star-rating { color: #f6ad55; font-size: 18px; }
    .comment-text { background: #f7fafc; padding: 15px; border-radius: 6px; border-left: 4px solid #f6ad55; font-style: italic; color: #4a5568; }
    .btn-back { display: inline-block; background: #718096; color: white; padding: 8px 16px; border-radius: 4px; text-decoration: none; font-size: 14px; font-weight: bold; margin-bottom: 20px; }
    .btn-back:hover { background: #4a5568; }
</style>

<div class="detail-container">
    <a href="index.php?page=qly_danhgia" class="btn">← Quay lại danh sách</a>

    <div class="detail-box">
        <h2 style="text-align: center">CHI TIẾT ĐÁNH GIÁ TỪ KHÁCH HÀNG</h2>

        <h3><i class="fa-solid fa-star"></i> Nội dung phản hồi</h3>
        <div class="info-grid" style="margin-top: 15px;">
            <div class="info-label">Mức độ hài lòng:</div>
            <div class="info-value star-rating">
                <?php echo  $dg_detail['so_sao'] . " / 5";?>
            </div>
        </div>
        <div class="info-grid">
            <div class="info-label">Bình luận của khách:</div>
        </div>
        <div class="comment-text">
            "<?php echo nl2br(($dg_detail['binh_luan'])); ?>"
        </div>

        <h3><i class="fa-solid fa-file-invoice"></i> Đơn đặt lịch liên quan</h3>
        <div class="info-grid" style="margin-top: 15px;">
            <div class="info-row classinfo-label">Mã lịch đặt:</div>
            <div class="info-value">#<?php echo $dg_detail['dat_lich_id']; ?></div>
            
            <div class="info-label">Dịch vụ đã dùng:</div>
            <div class="info-value"><?php echo ($dg_detail['Tendv']); ?></div>
            
            <div class="info-label">Loại xe cứu hộ:</div>
            <div class="info-value"><?php echo ($dg_detail['Loaixe']); ?></div>
            
            <div class="info-label">Số điện thoại khách:</div>
            <div class="info-value"><?php echo ($dg_detail['SDT']); ?></div>

            <div class="info-label">Thời gian đặt lịch:</div>
            <div class="info-value"><?php echo date('d/m/Y H:i', strtotime($dg_detail['Time'])); ?></div>
        </div>
    </div>
</div>
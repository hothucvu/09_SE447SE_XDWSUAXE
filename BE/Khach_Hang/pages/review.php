<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id_khach = $_SESSION['user_id'];
$message = "";

$datlich_id = isset($_GET['datlich_id']) ? intval($_GET['datlich_id']) : 0;

$sql_check = "SELECT dl.*, dv.Tendv
              FROM datlich dl 
              INNER JOIN dichvu dv ON dl.Dichvu_id = dv.id 
              WHERE dl.id = ? AND dl.Khach_id = ? AND dl.TrangThai = 'hoan_thanh' 
              LIMIT 1";

$stmt_check = $conn->prepare($sql_check);

$stmt_check->bind_param("ii", $datlich_id, $id_khach);
$stmt_check->execute();
$res_check = $stmt_check->get_result();
$don_hang = $res_check->fetch_assoc();

if (!$don_hang) {
    echo "<div>
            <p class='msg-e'>Lỗi: Đơn hàng không tồn tại hoặc chưa hoàn thành để có thể đánh giá!</p>
            <a href='index.php?page=list' btn>← Quay lại lịch sử đặt lịch</a>
          </div>";
    exit();
}

$sql_check_reviewed = "SELECT id FROM danh_gia WHERE dat_lich_id = ? LIMIT 1";
$stmt_reviewed = $conn->prepare($sql_check_reviewed);
$stmt_reviewed->bind_param("i", $datlich_id);
$stmt_reviewed->execute();
$res_reviewed = $stmt_reviewed->get_result();

if ($res_reviewed->num_rows > 0) {
    echo "<div>
            <p class='msg-e'>Lỗi: Đơn hàng đã đánh giá!</p>
            <a href='index.php?page=list' class='btn'>← Quay lại lịch sử đặt lịch</a>
          </div>";
    exit(); 
}

if (isset($_POST['submit_review'])) {
    $sosao = intval($_POST['sosao']);
    $noidung = trim($_POST['noidung']);

    if ($sosao < 1 || $sosao > 5) {
        $message = "<p class='msg-e'>Vui lòng chọn số sao đánh giá từ 1 đến 5!</p>";
    } else {
        $sql_insert = "INSERT INTO danh_gia (dat_lich_id, so_sao, binh_luan) VALUES (?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        
        if ($stmt_insert === false) {
            $message = "<p class='msg-e'>Lỗi cấu trúc bảng danh_gia: " . htmlspecialchars($conn->error) . "</p>";
        } else {
            $stmt_insert->bind_param("iis", $datlich_id, $sosao, $noidung);
            if ($stmt_insert->execute()) {
                $message = "<p class='msg-s'> Cảm ơn bạn! Đánh giá dịch vụ đã được gửi thành công.</p>";
            } else {
                $message = "<p class='msg-e'>Đã xảy ra lỗi hệ thống khi lưu: " . htmlspecialchars($stmt_insert->error) . "</p>";
            }
        }
    }
}
?>

<div class="review-container">
    <div class="review-box">
        <h2><i class="fa-solid fa-star"></i> ĐÁNH GIÁ DỊCH VỤ</h2>
        
        <?php echo $message; ?>

        <div class="order-summary">
            <p><strong>Mã đơn cứu hộ:</strong> #<?php echo $don_hang['id']; ?></p>
            <p><strong>Dịch vụ thực hiện:</strong> <?php echo htmlspecialchars($don_hang['Tendv']); ?></p>
            <p><strong>Thời gian đặt lịch:</strong> <?php echo date('d/m/Y H:i', strtotime($don_hang['Time'])); ?></p>
        </div>

        <form method="POST" action="">
            <div class="form-group" style="text-align: center;">
                <label>Vui lòng chọn mức độ hài lòng của bạn:</label>
                <div class="rating-stars">
                    <input type="radio" id="star1" name="sosao" value="1" required>
                    <label for="star1" title="1 sao"><i class="fa-solid fa-star"></i></label>
                    
                    <input type="radio" id="star2" name="sosao" value="2">
                    <label for="star2" title="2 sao"><i class="fa-solid fa-star"></i></label>
                    
                    <input type="radio" id="star3" name="sosao" value="3">
                    <label for="star3" title="3 sao"><i class="fa-solid fa-star"></i></label>
                    
                    <input type="radio" id="star4" name="sosao" value="4">
                    <label for="star4" title="4 sao"><i class="fa-solid fa-star"></i></label>
                    
                    <input type="radio" id="star5" name="sosao" value="5">
                    <label for="star5" title="5 sao"><i class="fa-solid fa-star"></i></label>
                </div>
            </div>

            <div class="form-group">
                <textarea style="width: 40%; height :200px"  id="noidung" name="noidung" placeholder="Nhập cảm nhận của bạn về chất lượng dịch vụ..."></textarea>
            </div>

            <button type="submit" name="submit_review" class="btn-submit-review">
                Gửi đánh giá ngay
            </button>
        </form>
    </div>
</div>

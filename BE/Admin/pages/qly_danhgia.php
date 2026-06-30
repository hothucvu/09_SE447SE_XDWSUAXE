<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$message = "";


// 2. TRUY VẤN LẤY DANH SÁCH ĐẠI LÝ
$sql = "SELECT * FROM danh_gia ORDER BY id DESC";
$result = $conn->query($sql);
?>

<link rel="stylesheet" href="../FE/Admin/quan_ly.css">

<div class="admin-container">
    <h2 style="text-align: center">HỆ THỐNG QUẢN LÝ ĐÁNH GIÁ</h2>
    
    <?php echo $message; ?>    
    <?php
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            ?>
            <div class="booking-card" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 8px; background: #fff;">
                    <div class="info-row"><strong>ID</strong> <?php echo ($row['id']); ?></div>
                    <div class="info-row"><strong>Số sao</strong> <?php echo ($row['so_sao']); ?></div>
                        <a href="index.php?page=danhgia&id=<?php echo $row['id']; ?>" class="btn">
                            Chi tiết đánh giá
                        </a>
                    </div>
                </div>
            <?php
        }
    } else {
        echo "<p style='text-align:center'>Hiện tại không có dịch vụ nào đang hoạt động trên hệ thống.</p>";
    }
    ?>
</div>
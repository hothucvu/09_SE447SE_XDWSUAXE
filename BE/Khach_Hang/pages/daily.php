<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$message = isset($message) ? $message : "";

// Truy vấn danh sách đại lý
$sql = "SELECT * FROM tram_dai_ly";
$stmt_get = $conn->prepare($sql);
$stmt_get->execute();
$result = $stmt_get->get_result();
?>


<div>
    <h2 style="text-align: center;">DANH SÁCH ĐẠI LÝ & VỊ TRÍ TRẠM</h2>
    
    <?php echo $message; ?>

    <?php
    if ($result && $result->num_rows > 0) {
        while ($dl = $result->fetch_assoc()) {
            $random_distance = number_format(1.2 + (mt_rand() / mt_getrandmax()) * 3.6, 1);
            $maps_link = "https://www.google.com/maps/search/?api=1&query=" . urlencode($dl['Ten'] . " " . $dl['Diachi']);
            ?>
            
            <div style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 8px;">
                <span style="font-weight: bold; color:chocolate">Cách đây ~ <?php echo $random_distance; ?> km</span>

                <div><strong>Tên đại lý:</strong> <?php echo htmlspecialchars($dl['Ten']); ?></div>
                <div><strong>Phân loại:</strong> <?php echo htmlspecialchars($dl['Loai']); ?></div>
                <div><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($dl['Diachi']); ?></div>
                <div><strong>Liên hệ khẩn cấp: </strong><?php echo htmlspecialchars($dl['Sodienthoai']); ?></div>
                
                <div>
                    <a href="<?php echo $maps_link; ?>" target="_blank" class="btn-map">📍 Xem vị trí & Chỉ đường</a>
                </div>
            </div>
            
            <?php
        }
    } else {
        echo "<p style='text-align:center; color:#666;'>Chưa có đại lý nào trên hệ thống.</p>";
    }
    ?>
</div>
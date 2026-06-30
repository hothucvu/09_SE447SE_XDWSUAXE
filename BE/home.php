<?php
$sql_dichvu = "SELECT Tendv, Gia FROM dichvu WHERE TrangThai = 'Đang hoạt động' LIMIT 3";
$result_dichvu = $conn->query($sql_dichvu);

$sql_daily = "SELECT Ten, Diachi, Sodienthoai FROM tram_dai_ly LIMIT 3";
$result_daily = $conn->query($sql_daily);
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href='./../FE/home.css'>

<div class="main">
    <div class="left">
        <h3><i class="fa-solid fa-screwdrivers-wrench"></i> Dịch vụ mới</h3>
        
        <div>
            <?php 
            if ($result_dichvu->num_rows> 0): 
                while($row = $result_dichvu->fetch_assoc()):
            ?>
                <div>
                    <span>
                        <i class="fa-solid fa-circle-check" style="color: #2ecc71; margin-right: 8px;"></i>
                        <?php echo $row['Tendv']; ?> :
                    </span>
                    <span><?php echo number_format($row['Gia'], 0, ',', '.'); ?> đ</span>
                </div>
            <?php 
                endwhile; 
            else:
                echo "<p style='color:#666; font-size:14px;'>Chưa có dịch vụ nào hoạt động.</p>";
            endif; 
            ?>
        </div>
        <hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 20px 0;">
        <h3><i class="fa-solid fa-screwdrivers-wrench"></i> Đại lý mới</h3>
        <div>
            <?php 
            if ($result_daily->num_rows> 0): 
                while($row = $result_daily->fetch_assoc()):
            ?>
                <div >
                    <span>
                        <i class="fa-solid fa-circle-check" style="color: #2ecc71; margin-right: 8px;"></i>
                        <?php echo $row['Ten']; ?> 
                    </span>
                    <p>Liên hệ: <?php echo $row['Diachi']; ?></p>
                    <p>Liên hệ: <?php echo $row['Sodienthoai']; ?></p>
                </div>
                <hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 20px 0;">
            <?php 
                endwhile; 
            else:
                echo "<p style='color:#666; font-size:14px;'>Chưa có dịch vụ nào hoạt động.</p>";
            endif; 
            ?>
        </div>
        <h3>Thông tin liên hệ</h3>
        <p><strong><i class="fa-solid fa-envelope"></i> Email:</strong> hovu21102005@gmail.com</p>
        <p><strong><i class="fa-solid fa-phone"></i> Điện thoại:</strong> 0337.831.249</p>
    </div>

    <div class="right">
        <h2>Về chúng tôi</h2>
        <p style="line-height: 1.7; color: #4a5568; margin-bottom: 20px;">
            Giải pháp công nghệ hàng đầu giúp kết nối cứu hộ và sửa chữa xe máy lưu động một cách nhanh chóng, an toàn và minh bạch. 
            Khi xe máy của bạn gặp sự cố hỏng hóc, thủng lốp hoặc chết máy trên đường, hệ thống của chúng tôi sẽ lập tức tìm kiếm 
            và điều phối những người thợ sửa xe uy tín nhất ở gần vị trí của bạn để hỗ trợ kịp thời.
        </p>
        
        <div>
            <img src="https://1000logos.net/wp-content/uploads/2018/04/Autobots-Logo.png" style="width: 500px; height: auto">
        </div>
    </div>
</div>
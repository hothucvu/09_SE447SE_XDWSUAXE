<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$message = "";

if (isset($_POST['delete'])) {
    $id_dv = intval($_POST['id_dv']);
    
    $sql_del = "DELETE FROM tram_dai_ly WHERE id = ?";
    $stmt_del = $conn->prepare($sql_del);
    
    // BỔ SUNG: Gán tham số id vào câu lệnh xóa
    $stmt_del->bind_param("i", $id_dv);
    
    if ($stmt_del->execute()) {
        $message = "<p style='color:green; text-align:center; font-weight:bold;'>Đã xóa trạm đại lý thành công!</p>";
    } else {
        $message = "<p style='color:red; text-align:center;'> Xóa thất bại: " . htmlspecialchars($conn->error) . "</p>";
    }
}

// 2. TRUY VẤN LẤY DANH SÁCH ĐẠI LÝ
$sql = "SELECT * FROM tram_dai_ly ORDER BY id DESC";
$result = $conn->query($sql);
?>

<link rel="stylesheet" href="../FE/Admin/quan_ly.css">

<div class="admin-container">
    <h2 style="text-align: center; color: #2d3748;">HỆ THỐNG QUẢN LÝ DANH MỤC ĐẠI LÝ</h2>
    
    <?php echo $message; ?>
    
    <a href="index.php?page=add_daily" class="btn" style="text-decoration: none;" >➕ Thêm đại lý mới</a>
    
    <?php
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            ?>
            <div class="booking-card" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 8px; background: #fff;">
                <div class="info-row" style="margin-bottom: 8px;"><strong>Tên đại lý:</strong> <?php echo ($row['Ten']); ?></div>
                <div class="info-row" style="margin-bottom: 8px;"><strong>Loại dịch vụ:</strong> <?php echo ($row['Loai']); ?></div>
                <div class="info-row" style="margin-bottom: 8px;"><strong>Số điện thoại:</strong> <?php echo ($row['Sodienthoai']); ?></div>
                <div class="info-row" style="margin-bottom: 8px;"><strong>Địa chỉ:</strong> <?php echo ($row['Diachi']); ?></div>
                
                <div class="btn-group" style="display: flex; gap: 10px;">
                    <a href="index.php?page=edit_daily&id=<?php echo $row['id']; ?>" class="btn-edit">
                         Sửa thông tin
                    </a>
                    
                    <form method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa đại lý này không?');" style="margin: 0;">
                        <input type="hidden" name="id_dv" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="delete" class="btn-delete">
                             Xóa đại lý
                        </button>
                    </form>
                </div>
            </div>
            <?php
        }
    } else {
        echo "<p style='text-align:center; color: #718096; padding: 20px;'>Hiện tại không có trạm đại lý nào trên hệ thống.</p>";
    }
    ?>
</div>
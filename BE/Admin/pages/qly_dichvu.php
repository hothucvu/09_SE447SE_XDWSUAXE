<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$message = "";

// 2. XỬ LÝ KHI BẤM NÚT "XÓA DỊCH VỤ" 
if (isset($_POST['delete_dv'])) {
    $id_dv = $_POST['id_dv'];
    
    $sql_del = "UPDATE dichvu SET TrangThai = 'Ngừng cung cấp' WHERE id = ?";
    $stmt_del = $conn->prepare($sql_del);
    $stmt_del->bind_param("i", $id_dv);
    
    if ($stmt_del->execute()) {
        $message = "<p style='color:green; text-align:center; font-weight:bold;'>Đã xóa dịch vụ thành công!</p>";
    } else {
        $message = "<p style='color:red; text-align:center;'>Xóa thất bại: " . $conn->error . "</p>";
    }
}

$sql = "SELECT * FROM dichvu WHERE TrangThai = 'Đang hoạt động' ORDER BY id DESC";
$result = $conn->query($sql);
?>

<link rel="stylesheet" href="../FE/Admin/quan_ly.css">


<div class="admin-container">
    <h2 style="text-align: center">HỆ THỐNG QUẢN LÝ DANH MỤC DỊCH VỤ</h2>
    
    <?php echo $message; ?>
    
    <a href="index.php?page=add_dichvu" class="btn">Thêm dịch vụ mới</a>
    
    <?php
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            ?>
            <div class="booking-card" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 8px">
                <div class="info-row"><strong>Tên dịch vụ:</strong> <?php echo $row['Tendv']; ?></div>
                <div class="info-row"><strong>Loại xe áp dụng:</strong> <?php echo $row['Loaixe']; ?></div>
                <div class="info-row"><strong>Giá niêm yết:</strong> <?php echo number_format($row['Gia']); ?> VNĐ</div>
                <div class="info-row"><strong>Mô tả:</strong><?php echo  $row['Mota']; ?></div>
                
                <div class="btn-group">
                    <form method="POST" action="index.php?page=edit_dichvu" >
                        <input type="hidden" name="id_dv" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="edit_click" class="btn">Sửa thông tin</button>
                    </form>
                    
                    <?php if($row['TrangThai'] == 'Đang hoạt động'): ?>
                        <form method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn ngừng cung cấp dịch vụ này không?');" style="margin:0;">
                            <input type="hidden" name="id_dv" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="delete_dv" class="btn">Xóa dịch vụ</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
            <?php
        }
    } else {
        echo "<p style='text-align:center'>Hiện tại không có dịch vụ nào đang hoạt động trên hệ thống.</p>";
    }
    ?>
</div>
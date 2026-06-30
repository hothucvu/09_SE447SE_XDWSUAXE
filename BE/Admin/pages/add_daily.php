<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$message = "";

if (isset($_POST['add'])) {
    $Ten = $_POST['Ten'];
    $Loai = $_POST['Loai'];
    $Diachi = $_POST['Diachi'];
    $Bando_Url = $_POST['Bando_Url'];
    $Sodienthoai = $_POST['Sodienthoai'];
    
    $sql = "INSERT INTO tram_dai_ly (Ten, Loai, Diachi, Bando_Url, Sodienthoai) VALUES (?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $Ten, $Loai, $Diachi, $Bando_Url, $Sodienthoai);
    
    if ($stmt->execute()) {
        $message = "<p style='color:green; font-weight:bold; text-align:center;'>Thêm đại lý mới thành công!</p>";
    } else {
        $message = "<p style='color:red; text-align:center;'>Lỗi hệ thống: " . $stmt->error . "</p>";
    }
}
?>

<link rel="stylesheet" href="../FE/">


<div class="container">
    <form class="register-form" method="POST">
        <h2>THÊM ĐẠI LÝ MỚI</h2>
        
        <?php echo $message; ?>

        <div class="form-input">
            <p>Tên: </p>
            <input type="text" name="Ten">
        </div>

        <div class="form-input">
            <p>Loại: </p>
            <input type="text" name="Loai">
        </div>

        <div class="form-input">
            <p>Địa chỉ: </p>
            <textarea name="Diachi" rows="4"></textarea>
        </div>

        <div class="form-input">
            <p>Link map: </p>
            <input type="text" name="Bando_Url">
        </div>

        <div class="form-input">
            <p>Số điện thoại: </p>
            <input type="text" name="Sodienthoai">
        </div>
        
        <button type="submit" name="add" class="btn_add">XÁC NHẬN THÊM</button>
        
        <p class="back" style="text-align:center;">
            <a href="index.php?page=qly_daily">← Quay lại xem danh sách dịch vụ</a>
        </p>
    </form>
</div>
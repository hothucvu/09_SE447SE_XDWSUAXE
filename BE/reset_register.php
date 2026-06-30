<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("db.php");

$message = "";

if (isset($_POST['reset_password'])) {
    $Taikhoan = $_POST['Taikhoan'];
    $SDT= $_POST['SDT'];
    $Matkhau_M = $_POST['Matkhau_M'];
    
        $sql = "SELECT id FROM taikhoan WHERE Taikhoan = ? AND SDT = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $Taikhoan, $SDT);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // 3. Nếu khớp, tiến hành mã hóa mật khẩu mới và cập nhật
            $update_sql = "UPDATE taikhoan SET Matkhau = ? WHERE username = ? AND SDT = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("ssss", $Matkhau_M, $Taikhoan, $SDT);
            
            if ($update_stmt->execute()) {
                echo "<script>alert('Đổi mật khẩu thành công!'); window.location='login.php';</script>";
            } else {
                $message = "<p style='color:red;'>Lỗi hệ thống, vui lòng thử lại sau.</p>";
            }
        } else {
            $message = "<p style='color:red;'>Thông tin tài khoản hoặc Email không chính xác!</p>";
        }
    }
?>

<head>
    <link rel="stylesheet" href="./../FE/login.css">
</head>
<div class="container">
    <form class="register-form" method="POST">
        <h2>Quên mật khẩu</h2>
        <?php echo $message; ?>
        
        <div class="form-group">
            <label>Tên đăng nhập</label>
            <input type="text" name="Taikhoan" placeholder="Nhập username" required>
        </div>
        <div class="form-group">
            <label>Số điện thoại đã đăng ký</label>
            <input type="text" name="SDT" placeholder="Nhập số điện thoại của bạn" required>
        </div>

        <div class="form-group">
            <label>Mật khẩu mới</label>
            <input type="password" name="Matkhau_M" placeholder="Nhập mật khẩu mới" required>
        </div>


        <button type="submit" name="reset_password" class="btn-submit">Cập nhật mật khẩu</button>
        
        <p class="footer-text"><a href="login">Quay lại đăng nhập</a></p>
    </form>
</div>
<?php
include('db.php');

$message = ""; 

if (isset($_POST['register'])) {
    $Taikhoan = $_POST['Taikhoan'];
    $Matkhau = $_POST['Matkhau'];
    $Hoten = $_POST['Hoten'];
    $SDT = $_POST['SDT'];        

    $check_sql = "SELECT id FROM taikhoan WHERE Taikhoan = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $Taikhoan);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        $message = "<p style='color:red;'>Tài khoản này đã tồn tại. Vui lòng chọn tên khác.</p>";
    } else {
        $sql = "INSERT INTO taikhoan (Taikhoan, Matkhau, Hoten, SDT) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        
        $stmt->bind_param("ssss", $Taikhoan, $Matkhau, $Hoten, $SDT);

        if ($stmt->execute()) {
            echo "<script>alert('Đăng ký thành công!'); window.location='index.php?page=login';</script>";
            exit();
        } else {
            $message = "<p style='color:red;'>Lỗi: " . $conn->error . "</p>";
        }
    }
}
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản</title>
    <link rel="stylesheet" href="./../FE/login.css">
</head>
<body>
    <div class="container">
        <form class="register-form" method="POST">
            <h2>Đăng ký tài khoản</h2>

            <?php echo $message; ?>

            <div class="form-group">
                <label>Tên đăng nhập</label>
                <input type="text" name="Taikhoan" placeholder="Nhập tài khoản" required>
            </div>

            <div class="form-group">
                <label>Mật khẩu</label>
                <input type="password" name="Matkhau" placeholder="Nhập mật khẩu" required>
            </div>

            <div class="form-group">
                <label>Họ tên</label>
                <input type="text" name="Hoten" placeholder="Nhập họ tên đầy đủ  " required>
            </div>

            <div class="form-group">
                <label>Số điện thoại</label>
                <input type="text" name="SDT" placeholder="Nhập số điện thoại" required>
            </div>

            <button type="submit" name="register" class="btn-submit">Đăng ký</button>

            <p class="footer-text"><a href="index.php?page=login">Đã có tài khoản</a></p>
        </form>
    </div>
</body>
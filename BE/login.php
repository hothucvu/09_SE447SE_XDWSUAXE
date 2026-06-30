<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("db.php");

$message = "";

if (isset($_POST['login'])) {
    $Taikhoan = $_POST['Taikhoan'];
    $Matkhau = $_POST['Matkhau'];

    // 1. Tìm user theo username
    $sql = "SELECT * FROM taikhoan WHERE Taikhoan = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $Taikhoan);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if($Matkhau == $user["Matkhau"]){
            $_SESSION['user_id'] = $user['id']; 
            $_SESSION['user_name'] = $user['Taikhoan']; 
            $_SESSION['Taikhoan'] = $user['Taikhoan'];
            $_SESSION['Vaitro'] = $user['Vaitro'];
            if($user['Vaitro']== 'khach'){header("Location: index.php?page=home");exit();}
            if($user['Vaitro']== 'tho'){header("Location: index.php?page=home");exit();}
            if($user['Vaitro']== 'admin'){header("Location: index.php?page=home");exit();}
        } 
    else {
            $message = "<p style='color:red; text-align:center;'>Mật khẩu không chính xác!</p>";
        }
    }
    else {
            $message = "<p style='color:red; text-align:center;'>Tài khoản không chính xác!</p>";
        }
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập tài khoản</title>
    <link rel="stylesheet" href="./../FE/login.css">
</head>
<body>
    <div class="container">
        <form class="register-form" method="POST">
            <h2>Đăng nhập tài khoản</h2>

            <?php echo $message; ?>

            <div class="form-group">
                <input type="text" name="Taikhoan" placeholder="Nhập tài khoản" required>
            </div>

            <div class="form-group">
                <input type="password" name="Matkhau" placeholder="Nhập mật khẩu" required>
            </div>

            <button type="submit" name="login" class="btn-submit">Đăng nhập</button>

            <p class="footer-text"><a href="reset_register.php">Quên mật khẩu</a></p>
            <p class="footer-text">Chưa có tài khoản? <a href="register.php">Đăng ký</a></p>
        </form>
    </div>
</body>
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='utf-8'>
    <link rel='stylesheet' href='../Css/style.css'>
</head>
<body>
    <header>
        <table style="border-spacing: 20px;">
            <tr style="align-items: center;">
                <td><a href="index.php?page=home">Trang chủ</a></td>
                <td><a href="">Thông tin cá nhân</a></td>
                <td><a href="">Đặt dịch vụ</a></td>
                <td><a href="">Danh sách dịch vụ</a></td>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <td><a href="../logout.php">Đăng xuất</a></td>
                <?php else: ?>
                    <td><a href="../login.php">Đăng nhập </a></td>
                <?php endif; ?>
            </tr>
        </table>
    </header>
</body>
</html>

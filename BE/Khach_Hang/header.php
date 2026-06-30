<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='utf-8'>
    <link rel="stylesheet" href="../FE/header.css">
</head>
<body>
    <header>
        <table>
            <tr>
                <td><a href="index.php?page=home">Trang chủ</a></td>
                <td><a href="index.php?page=daily">Xem trạm sạc / đại lý gần nhất</a></td>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <td><a href="index.php?page=profile">Thông tin cá nhân</a></td>
                    <td><a href="index.php?page=booking">Đặt dịch vụ</a></td>
                    <td><a href="index.php?page=list">Danh sách dịch vụ đã đặt</a></td>
                    <td><a href="logout.php">Đăng xuất</a></td>
                <?php else: ?>
                    <td><a href="./login.php">Đăng nhập </a></td>
                <?php endif; ?>
            </tr>
        </table>
    </header>
</body>
</html>
<!DOCTYPE html>
<html lang='en'>
<link rel="stylesheet" href="../FE/Khach_Hang/header.css">

<body>
    <header>
        <table style="border-spacing: 20px;">
            <tr style="align-items: center;">
                <td><a href="index.php?page=home">Trang chủ</a></td>
                <td><a href="index.php?page=lich">Danh sách đơn làm việc</a></td>
                <td><a href="index.php?page=nhan_lich">Nhận đơn làm việc</a></td>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <td><a href="logout.php">Đăng xuất</a></td>
                <?php else: ?>
                    <td><a href="./login.php">Đăng nhập </a></td>
                <?php endif; ?>
            </tr>
        </table>
    </header>
</body>
</html>
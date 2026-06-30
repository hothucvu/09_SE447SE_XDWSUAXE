<!DOCTYPE html>
<html lang='en'>
<link rel="stylesheet" href="../FE/header.css">

<body>
    <header>
        <table>
            <tr>
                <td><a href="index.php?page=home">Trang chủ</a></td>
                <td><a href="index.php?page=qly_dichvu">Quản lý dịch vụ</a></td>
                <td><a href="index.php?page=qly_daily">Quản lý đại lý</a></td>
                <td><a href="index.php?page=qly_danhgia">Quản lý đánh giá</a></td>
                <td><a href="index.php?page=thongke">Thống kê doanh thu</a></td>
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
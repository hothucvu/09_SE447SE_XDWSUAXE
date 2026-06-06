<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("../db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// 2. Kiểm tra vai trò quyền hạn truy cập
if ($_SESSION['Vaitro'] !== 'khach') {
    if ($_SESSION['Vaitro'] === 'admin') {
        header("Location: ../Admin/index.php?page=home");
    } elseif ($_SESSION['Vaitro'] === 'tho') {
        header("Location: ../Nhan_Vien/index.php?page=home");
    } else {
        header("Location: ../login.php");
    }
    exit();
}

// 3. Xử lý lấy tên trang con
$page = isset($_GET['page']) ? $_GET['page'] : "home";

include("header.php");

$file_path = "pages/$page.php"; 

if (file_exists($file_path)) {
    include($file_path);
} else {
    echo "<h3 style='text-align:center; margin-top:50px; color:red;'>Trang yêu cầu không tồn tại</h3>";
}
?>
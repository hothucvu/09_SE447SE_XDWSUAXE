<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("db.php");

$get_page = isset($_GET['page']) ? $_GET['page'] : "home";

$folder = "";

if (isset($_SESSION['user_id']) && isset($_SESSION['Vaitro'])) {
    if ($_SESSION['Vaitro'] === 'khach') {
        $folder = "Khach_Hang";
    }
    else if ($_SESSION['Vaitro'] === 'tho') {
        $folder = "Nhan_Vien";
    }
    else { 
        $folder = "Admin"; 
    }
} else {
    $folder = "Khach_Hang"; 
}


if ($get_page === "home") {
    include("$folder/header.php"); 
    
    $public_home = "home.php";
    if (file_exists($public_home)) {
        include($public_home); 
    } 
    exit(); 
}


if (!isset($_SESSION['user_id']) || !isset($_SESSION['Vaitro'])) {
    header("Location: login.php"); 
    exit(); 
}


include("$folder/header.php");

$file_path = "$folder/pages/$get_page.php"; 

if (file_exists($file_path)) {
    include($file_path);
} else {
    echo "<h3 style='text-align:center; color:red; margin-top:50px;'>Trang yêu cầu không tồn tại ($file_path)</h3>";
}
?>
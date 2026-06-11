<?php

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$message = "";

$id = $_POST['id_dv'];

if (isset($_POST['update'])) {
    $Tendv = $_POST['Tendv'];
    $Loaixe = $_POST['Loaixe'];
    $Gia = $_POST['Gia'];
    $Mota = $_POST['Mota'];

    $sqlud = "UPDATE dichvu SET Tendv = ?, Loaixe = ?, Gia = ?, Mota = ? WHERE id = ?";
    $stmt = $conn->prepare($sqlud);
    $stmt->bind_param("ssisi", $Tendv, $Loaixe, $Gia, $Mota, $id);
    
    if ($stmt->execute()) {
        $message = "<p style='color:green; font-weight:bold; text-align:center;'>Cập nhật thông tin dịch vụ thành công!</p>";
    } else {
        $message = "<p style='color:red; text-align:center;'>Lỗi cập nhật: " . $conn->error . "</p>";
    }
}

$sql = "SELECT * FROM dichvu WHERE id = ? LIMIT 1";
$stmt_get = $conn->prepare($sql);
$stmt_get->bind_param("i", $id);
$stmt_get->execute();
$result = $stmt_get->get_result();
$dichvu = $result->fetch_assoc();
?>

<link rel="stylesheet" href="../FE/">

<div class="container">
    <form class="register-form" method="POST">
        <h2 style="text-align: center;">CHỈNH SỬA DỊCH VỤ #<?php echo $dichvu['id']; ?></h2>
        
        <?php echo $message; ?>
        
        <input type="hidden" name="id_dv" value="<?php echo $dichvu['id']; ?>">

        <div class="form-input">
            <p>Tên dịch vụ: </p>
            <input type="text" name="Tendv" value="<?php echo $dichvu['Tendv']; ?>">
        </div>

        <div class="form-input">
            <p>Phân loại dòng xe áp dụng: </p>
            <select name="Loaixe" required>
                <option value="Xe máy số" <?php if($dichvu['Loaixe'] == 'Xe máy số') echo 'selected'; ?>>Xe máy (Xe số)</option>
                <option value="Xe tay ga" <?php if($dichvu['Loaixe'] == 'Xe tay ga') echo 'selected'; ?>>Xe tay ga</option>
                <option value="Xe điện" <?php if($dichvu['Loaixe'] == 'Xe điện') echo 'selected'; ?>>Xe máy điện</option>
            </select>
        </div>
        
        <div class="form-input">
            <p>Giá niêm yết (VNĐ): </p>
            <input type="number" name="Gia" value="<?php echo $dichvu['Gia']; ?>">
        </div>

        <div class="form-input">
            <p>Mô tả chi tiết gói dịch vụ: </p>
            <textarea name="Mota" rows="4"><?php echo htmlspecialchars($dichvu['Mota']); ?></textarea>
        </div>
        
        <button type="submit" name="update" class="btn-submit">CẬP NHẬT THÔNG TIN</button>
        
        <p class="footer-text" style="text-align:center;">
            <a href="index.php?page=qly_dichvu" style="text-decoration: none">← Quay lại danh sách dịch vụ</a>
        </p>
    </form>
</div>
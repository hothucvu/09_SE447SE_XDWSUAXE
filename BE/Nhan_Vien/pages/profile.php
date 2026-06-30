    <?php
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
    $id = $_SESSION['user_id'];
    $message="";

    if(isset($_POST['update'])){
    $Hoten = $_POST['Hoten'];
    $SDT = $_POST['SDT'];

    $sqlud = "UPDATE taikhoan SET Hoten=?,SDT=? WHERE id =? ";
    $stmt = $conn->prepare($sqlud);
    $stmt->bind_param("ssi", $Hoten, $SDT, $id);
    if($stmt->execute()){
        $message="<p style='color:green;'>Cập nhật thông tin thành công</p>";
    }
    }

    $sql = "SELECT * FROM taikhoan WHERE id = ? LIMIT 1";
    $stmt_get = $conn->prepare($sql);
    $stmt_get->bind_param("i", $id);
    $stmt_get->execute();
    $result = $stmt_get->get_result();
    $user = $result->fetch_assoc();
    ?>

    <link rel="stylesheet" href="../FE/Khach_Hang/profile.css">

        <div class="container">
            <form class="form" method="POST">
                <h2>Thông tin tài khoản</h2>
                <?php echo $message; ?>
                <div>
                    <p>Tên Đăng nhập: <?php echo $user['Taikhoan'] ;?></p>
                </div>
                <div>
                    <p>Vai trò: <?php echo $user['Vaitro'] ;?></p>
                </div>
                <div class="form-input">
                    <p>Tên người dùng: </p>
                    <input type="text" name ="Hoten" value="<?php echo $user['Hoten']; ?>">
                </div>

                <div class="form-input">
                    <p>Số điện thoại đăng ký: </p>
                    <input type="text" name ="SDT" value="<?php echo $user['SDT']; ?>">
                </div>

                <button type="submit" name="update" class="btn-submit">Cập nhât thông tin</button>
                <p class="footer-text"><a href="index.php?page=edit_pass">Đổi mật khẩu</a></p>
            </form>
        </div>
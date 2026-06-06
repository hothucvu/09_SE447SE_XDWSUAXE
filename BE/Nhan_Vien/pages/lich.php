<?php
if (!isset($_SESSION['user_id'])) {
        header("Location: ../login.php");
        exit();
    }
    $id = $_SESSION['user_id'];

    $sql = "SELECT * FROM datlich WHERE id = ? LIMIT 1";
    $stmt_get = $conn->prepare($sql);
    $stmt_get->bind_param("i", $id);
    $stmt_get->execute();
    $result = $stmt_get->get_result();
    $user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Xem lịch làm</title>
    <link rel='stylesheet' href='main.css'>
</head>
<body>
    <div>
        <label for="">id : <?php $user['id'] ?></label>
        <label for="">id : <?php $user['Diachi'] ?></label>
        <label for="">id : <?php $user['Time'] ?></label>
        <button>Nhận lịch</button>
    </div>
</body>
</html>
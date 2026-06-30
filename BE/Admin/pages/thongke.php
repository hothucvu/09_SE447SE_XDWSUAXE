<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// 1. LẤY SỐ LIỆU TỔNG QUAN
// Tổng số đơn và doanh thu

$sql_tong_quan = "SELECT COUNT(dl.id) AS tong_don, SUM(dv.Gia) AS doanh_thu 
                  FROM datlich dl 
                  INNER JOIN dichvu dv ON dl.Dichvu_id = dv.id 
                  WHERE dl.TrangThai = 'da_thanh_toan' & dl.TrangThai = 'hoan_thanh'";


$res_tq = $conn->query($sql_tong_quan);
$data_tq = $res_tq->fetch_assoc();
$tong_don = $data_tq['tong_don'] ?? 0;
$tong_doanh_thu = $data_tq['doanh_thu'] ?? 0;

// Tổng số khách hàng
$sql_khach = "SELECT COUNT(id) AS tong_khach FROM taikhoan WHERE VaiTro = 'khach'"; 
$res_khach = $conn->query($sql_khach);
$tong_khach = $res_khach ? ($res_khach->fetch_assoc()['tong_khach'] ?? 0) : 0;

// Tổng số đại lý
$sql_tram = "SELECT COUNT(id) AS tong_tram FROM tram_dai_ly";
$res_tram = $conn->query($sql_tram);
$tong_tram = $res_tram ? ($res_tram->fetch_assoc()['tong_tram'] ?? 0) : 0;


// 2. TRUY VẤN XU HƯỚNG DỊCH VỤ (Top dịch vụ được đặt nhiều nhất)
$sql_top_dv = "SELECT dv.Tendv, COUNT(dl.id) AS so_luot, SUM(dv.Gia) AS doanh_thu_dv
               FROM datlich dl
               INNER JOIN dichvu dv ON dl.Dichvu_id = dv.id
               WHERE dl.TrangThai = 'da_thanh_toan' & dl.TrangThai = 'hoan_thanh'
               GROUP BY dl.Dichvu_id
               ORDER BY so_luot DESC 
               LIMIT 5";
$result_top_dv = $conn->query($sql_top_dv);
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href='./../FE/Admin/thongke.css'>
<div class="dashboard-container">
    <h2 style="text-align: center; color: #2b6cb0; margin-bottom: 30px;">📊 TRANG BÁO CÁO & THỐNG KÊ HỆ THỐNG</h2>

    <div class="card-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: #ebf8ff; color: #3182ce;"><i class="fa-solid fa-hand-holding-dollar"></i></div>
            <div class="stat-info">
                <h3>Doanh thu</h3>
                <p><?php echo number_format($tong_doanh_thu, 0, ',', '.'); ?> đ</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon" style="background: #f0fff4; color: #38a169;"><i class="fa-solid fa-truck-medical"></i></div>
            <div class="stat-info">
                <h3>Đơn thành công</h3>
                <p><?php echo $tong_don; ?> đơn</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: #feebc8; color: #dd6b20;"><i class="fa-solid fa-users"></i></div>
            <div class="stat-info">
                <h3>Khách hàng</h3>
                <p><?php echo $tong_khach; ?> người</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: #e2e8f0; color: #4a5568;"><i class="fa-solid fa-shop"></i></div>
            <div class="stat-info">
                <h3>Trạm đại lý</h3>
                <p><?php echo $tong_tram; ?> trạm</p>
            </div>
        </div>
    </div>

    <div class="charts-section">
        <h2><i class="fa-solid fa-chart-line" style="color: #3182ce;"></i> Top dịch vụ cứu hộ được yêu cầu nhiều nhất</h2>
        
        <table class="report-table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên dịch vụ</th>
                    <th style="text-align: center;">Số lượt đặt cứu hộ</th>
                    <th style="text-align: right;">Tổng doanh thu mang lại</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if ($result_top_dv && $result_top_dv->num_rows > 0):
                    $stt = 1;
                    while ($row = $result_top_dv->fetch_assoc()):
                ?>
                    <tr>
                        <td><?php echo $stt++; ?></td>
                        <td style="font-weight: bold;"><?php echo htmlspecialchars($row['Tendv']); ?></td>
                        <td style="text-align: center; color: #3182ce; font-weight: bold;"><?php echo $row['so_luot']; ?> lượt</td>
                        <td style="text-align: right; color: #e53e3e; font-weight: bold;"><?php echo number_format($row['doanh_thu_dv'], 0, ',', '.'); ?> đ</td>
                    </tr>
                <?php 
                    endwhile;
                else: 
                ?>
                    <tr>
                        <td colspan="4" style="text-align: center; color: #a0aec0;">Chưa có dữ liệu thống kê đơn hàng thành công.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
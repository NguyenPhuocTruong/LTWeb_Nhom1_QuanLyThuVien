<?php
// 1. Kết nối cơ sở dữ liệu
require_once("../mysqlConnect.php");
$conn->select_db("library");

// 2. Truy vấn lấy số liệu cho 4 thẻ thống kê
// Tổng số đầu sách
$sql_sach = "SELECT COUNT(*) as total FROM sach";
$result_sach = $conn->query($sql_sach);
$total_sach = $result_sach ? $result_sach->fetch_assoc()['total'] : 0;

// Tổng số thành viên
$sql_user = "SELECT COUNT(*) as total FROM nguoidung";
$result_user = $conn->query($sql_user);
$total_user = $result_user ? $result_user->fetch_assoc()['total'] : 0;

// Tổng sách đang mượn (Tính tổng cột so_luong_sach_muon trong bảng muon_sach)
$sql_dangmuon = "SELECT SUM(so_luong_sach_muon) as total FROM muon_sach";
$result_dangmuon = $conn->query($sql_dangmuon);
$total_dangmuon = ($result_dangmuon && $result_dangmuon->num_rows > 0) ? $result_dangmuon->fetch_assoc()['total'] : 0;
if ($total_dangmuon == null) $total_dangmuon = 0; // Xử lý nếu bảng chưa có dữ liệu

// Tổng sách quá hạn (CSDL chưa có cột ngày mượn/trả nên tạm để 0)
$total_quahan = 0;

// 3. Truy vấn danh sách mới nhất
// Lấy 5 người dùng mới nhất (Do không có cột thời gian tạo nên lấy ngẫu nhiên 5)
$list_users = $conn->query("SELECT * FROM nguoidung LIMIT 5");

// Lấy 5 cuốn sách mới thêm vào (Sắp xếp theo ma_sach giảm dần)
$list_books = $conn->query("SELECT * FROM sach ORDER BY ma_sach DESC LIMIT 5");
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>

    <link rel="stylesheet" href="../index.css">
    <link rel="stylesheet" href="../assets_admin/css/sidebar.css">
    <link rel="stylesheet" href="../assets_admin/css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="admin-body">

    <?php include '../header.php'; ?>

    <section class="dashboard-page">
        <div class="admin-layout">

            <?php include 'sidebar.php'; ?>

            <main class="dashboard-content">

                <div class="dashboard_title">
                    <h1>Thống kê</h1>
                    <h2>Tổng quan hệ thống quản lý thư viện</h2>
                </div>

                <div class="stat_grid">
                    <div class="stat_card">
                        <div class="stat_icon blue">
                            <i class="fa-solid fa-book"></i>
                        </div>
                        <div>
                            <h2><?php echo $total_sach; ?></h2>
                            <p>Đầu sách</p>
                        </div>
                    </div>

                    <div class="stat_card">
                        <div class="stat_icon green">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <div>
                            <h2><?php echo $total_user; ?></h2>
                            <p>Thành viên</p>
                        </div>
                    </div>

                    <div class="stat_card">
                        <div class="stat_icon yellow">
                            <i class="fa-solid fa-book-open-reader"></i>
                        </div>
                        <div>
                            <h2><?php echo $total_dangmuon; ?></h2>
                            <p>Sách đang mượn</p>
                        </div>
                    </div>

                    <div class="stat_card">
                        <div class="stat_icon red">
                            <i class="fa-solid fa-clock"></i>
                        </div>
                        <div>
                            <h2><?php echo $total_quahan; ?></h2>
                            <p>Quá hạn</p>
                        </div>
                    </div>
                </div>

                <div class="dashboard_grid">

                    <div class="dashboard_box">
                        <div class="box_title">
                            <h3>Danh sách thành viên</h3>
                            <a href="users.php">Xem tất cả</a>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th>Tên thành viên</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($list_users && $list_users->num_rows > 0) {
                                    while ($row = $list_users->fetch_assoc()) {
                                ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['hoten']); ?></td>
                                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                                        </tr>
                                <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='2'>Chưa có thành viên nào</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>


                    <div class="dashboard_box">
                        <div class="box_title">
                            <h3>Danh sách sách</h3>
                            <a href="books.php">Xem tất cả</a>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th>Mã sách</th>
                                    <th>Tên sách</th>
                                    <th>Tác giả</th>
                                    <th>Kho</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($list_books && $list_books->num_rows > 0) {
                                    $stt = 1;
                                    while ($book = $list_books->fetch_assoc()) {
                                ?>
                                        <tr>
                                            <td><?php echo $stt++; ?></td>
                                            <td><?php echo htmlspecialchars($book['ten_sach']); ?></td>
                                            <td><?php echo htmlspecialchars($book['tac_gia']); ?></td>
                                            <td>
                                                <?php if ($book['so_luong'] > 0) { ?>
                                                    <span class="status available">Còn <?php echo $book['so_luong']; ?></span>
                                                <?php } else { ?>
                                                    <span class="status overdue">Hết sách</span>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='4'>Chưa có sách nào</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                </div>

            </main>

        </div>
    </section>

    <?php include '../footer.php'; ?>

</body>

</html>
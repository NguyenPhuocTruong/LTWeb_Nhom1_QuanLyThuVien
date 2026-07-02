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
                    <h1>Dashboard</h1>
                    <h2>Tổng quan hệ thống quản lý thư viện</h2>
                </div>

                <div class="stat_grid">

                    <div class="stat_card">
                        <div class="stat_icon blue">
                            <i class="fa-solid fa-book"></i>
                        </div>
                        <div>
                            <h2>120</h2>
                            <p>Tổng số sách</p>
                        </div>
                    </div>

                    <div class="stat_card">
                        <div class="stat_icon green">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <div>
                            <h2>45</h2>
                            <p>Thành viên</p>
                        </div>
                    </div>

                    <div class="stat_card">
                        <div class="stat_icon yellow">
                            <i class="fa-solid fa-book-open-reader"></i>
                        </div>
                        <div>
                            <h2>18</h2>
                            <p>Đang mượn</p>
                        </div>
                    </div>

                    <div class="stat_card">
                        <div class="stat_icon red">
                            <i class="fa-solid fa-clock"></i>
                        </div>
                        <div>
                            <h2>5</h2>
                            <p>Quá hạn</p>
                        </div>
                    </div>

                </div>

                <div class="dashboard_grid">

                    <div class="dashboard_box">
                        <div class="box_title">
                            <h3>Danh sách thành viên</h3>
                            <a href="#">Xem tất cả</a>
                        </div>

                        <table>
                            <thead>
                                <tr>
                                    <th>Tên thành viên</th>
                                    <th>Mã</th>
                                    <th>Sách đang mượn</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>Nguyễn Văn An</td>
                                    <td>TV001</td>
                                    <td>Dế Mèn Phiêu Lưu Ký</td>
                                    <td><i class="fa-solid fa-ellipsis"></i></td>
                                </tr>

                                <tr>
                                    <td>Trần Thị Bình</td>
                                    <td>TV002</td>
                                    <td>Lão Hạc</td>
                                    <td><i class="fa-solid fa-ellipsis"></i></td>
                                </tr>

                                <tr>
                                    <td>Lê Minh Quân</td>
                                    <td>TV003</td>
                                    <td>Tắt Đèn</td>
                                    <td><i class="fa-solid fa-ellipsis"></i></td>
                                </tr>

                                <tr>
                                    <td>Phạm Hoàng Nam</td>
                                    <td>TV004</td>
                                    <td>Không có</td>
                                    <td><i class="fa-solid fa-ellipsis"></i></td>
                                </tr>
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
                                    <th>Tên sách</th>
                                    <th>Mã sách</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>Dế Mèn Phiêu Lưu Ký</td>
                                    <td>S001</td>
                                    <td><span class="status available">Còn sách</span></td>
                                    <td><i class="fa-solid fa-ellipsis"></i></td>
                                </tr>

                                <tr>
                                    <td>Lão Hạc</td>
                                    <td>S002</td>
                                    <td><span class="status borrowed">Đang mượn</span></td>
                                    <td><i class="fa-solid fa-ellipsis"></i></td>
                                </tr>

                                <tr>
                                    <td>Tắt Đèn</td>
                                    <td>S003</td>
                                    <td><span class="status overdue">Quá hạn</span></td>
                                    <td><i class="fa-solid fa-ellipsis"></i></td>
                                </tr>

                                <tr>
                                    <td>Tôi Thấy Hoa Vàng Trên Cỏ Xanh</td>
                                    <td>S004</td>
                                    <td><span class="status available">Còn sách</span></td>
                                    <td><i class="fa-solid fa-ellipsis"></i></td>
                                </tr>
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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý người dùng</title>
    <link rel="stylesheet" href="../index.css">
    <link rel="stylesheet" href="../assets_admin/css/sidebar.css">
    <link rel="stylesheet" href="../assets_admin/css/books.css">
    <link rel="stylesheet" href="../assets_admin/css/btnuser.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body class="admin-body">
    <div class="books-page">
        <div class="admin-layout">
            <?php include "sidebar.php"; ?>
            <main class="books-content">
                <div class="books-header">
                    <h2>Quản lý người dùng</h2>
                </div>
                <div class="books-table-box">
                    <table class="books-table">
                        <thead>
                            <tr>
                                <th>Thao tác</th>
                                <th>STT</th>
                                <th>Tên người dùng</th>
                                <th>Email</th>
                                <th>Số sách đã mượn</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require_once("../mysqlConnect.php");
                            $mysqli->select_db("library");
                            $result = $mysqli->query("SELECT * FROM nguoidung");
                            $stt = 1;

                            while ($row = $result->fetch_assoc()) {
                                $email = $row['email'];

                                $countQuery = $mysqli->query("SELECT COUNT(*) as total FROM muon_sach WHERE email = '$email'");
                                $soSachMuon = 0;
                                if ($countQuery) {
                                    $countRow = $countQuery->fetch_assoc();
                                    $soSachMuon = $countRow['total'];
                                }
                            ?>
                                <tr>
                                    <td>
                                        <div class="table-actions">
                                            <a href="editUser.php?id=<?php echo $row['email']; ?>" class="btn-edit">Sửa</a>

                                            <a href="deleteUser.php?id=<?php echo $row['email']; ?>" class="btn-delete"
                                                onclick="return confirm('Bạn có chắc muốn xóa người dùng <?php echo htmlspecialchars($row['hoten']); ?> (email: <?php echo htmlspecialchars($row['email']); ?>) ?');">
                                                Xóa
                                            </a>
                                        </div>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <span class="stt-highlight"><?php echo $stt++; ?></span>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['hoten']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td style="text-align: center;">
                                        <?php if ($soSachMuon > 0) { ?>
                                            <a href="detailBorrow.php?email=<?php echo urlencode($email); ?>&hoten=<?php echo urlencode($row['hoten']); ?>"
                                                class="btn-count-active">
                                                <?php echo $soSachMuon; ?>
                                            </a>
                                        <?php } else { ?>
                                            <span class="btn-count-empty">
                                                0
                                            </span>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết mượn sách</title>
    <link rel="stylesheet" href="../index.css">
    <link rel="stylesheet" href="../assets_admin/css/sidebar.css">
    <link rel="stylesheet" href="../assets_admin/css/books.css">
    <link rel="stylesheet" href="../assets_admin/css/btnuser.css">
</head>

<body class="admin-body">
    <div class="books-page">
        <div class="admin-layout">
            <?php include "sidebar.php"; ?>
            <main class="books-content">
                <?php
                require_once("../mysqlConnect.php");
                $mysqli->select_db("library");

                $email = isset($_GET['email']) ? $_GET['email'] : '';
                $fullname = isset($_GET['hoten']) ? $_GET['hoten'] : '';
                ?>
                <div class="books-header">
                    <h2>Chi tiết mượn sách của: <?php echo htmlspecialchars($fullname); ?></h2>
                    <a href="users.php" class="back">Quay lại</a>
                </div>

                <div class="books-table-box">
                    <table class="books-table">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên sách</th>
                                <th>Số lượng mượn</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($email != '') {
                                $query = "SELECT sach.ten_sach, muon_sach.so_luong_sach_muon 
                                          FROM muon_sach 
                                          JOIN sach ON muon_sach.ma_sach = sach.ma_sach 
                                          WHERE muon_sach.email = '$email'";

                                $result = $mysqli->query($query);
                                if ($result && $result->num_rows > 0) {
                                    $stt = 1;
                                    while ($row = $result->fetch_assoc()) {
                            ?>
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;">
                                                <span class="stt-highlight"><?php echo $stt++; ?></span>
                                            </td>
                                            <td><?php echo htmlspecialchars($row['ten_sach']); ?></td>
                                            <td><?php echo htmlspecialchars($row['so_luong_sach_muon']); ?></td>
                                        </tr>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="3" style="text-align:center;">Người dùng này chưa mượn sách nào hoặc không
                                            có dữ liệu.</td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
</body>

</html>
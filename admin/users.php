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

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require_once("../mysqlConnect.php");
                            $conn->select_db("library");
                            $result = $conn->query("SELECT * FROM nguoidung");
                            $stt = 1;
                            while ($row = $result->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td>
                                        <div class="table-actions">
                                            <a href="editUser.php?id=<?php echo $row['email']; ?>" class="btn-edit">Sửa</a>

                                            <a href="deleteUser.php?id=<?php echo $row['email']; ?>" class="btn-delete"
                                                onclick="return confirm('Bạn có chắc muốn xóa?');">
                                                Xóa
                                            </a>
                                        </div>
                                    </td>
                                    <td><?php echo $stt++; ?></td>
                                    <td><?php echo htmlspecialchars($row['hoten']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>

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
<!DOCTYPE html>
<html>

<head>
    <title>Books</title>

    <link rel="stylesheet" href="../index.css">

    <link rel="stylesheet" href="../assets_admin/css/sidebar.css">
    <link rel="stylesheet" href="../assets_admin/css/books.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://kit.fontawesome.com/67ecaf9947.js" crossorigin="anonymous"></script>
</head>

<body class="admin-body">
    <?php include "../mysqlConnect.php"; ?>
    <div class="books-page">

        <div class="admin-layout">

            <?php include "sidebar.php"; ?>

            <main class="books-content">

                <div class="books-header">
                    <h2>Quản lý Sách</h2>
                    <button class="btn-add"><a href="addBooks.php">Thêm sách</a></button>
                </div>

                <div class="books-table-box">
                    <table class="books-table">
                        <thead>
                            <tr>
                                <th>Thao tác</th>
                                <th>Mã sách</th>
                                <th>Tên sách</th>
                                <th>Tác giả</th>
                                <th>Nhà xuất bản</th>
                                <th>Thể loại</th>
                                <th>Quốc gia</th>
                                <th>Nhà cung cấp</th>
                                <th>Số lượng</th>
                                <th>Năm XB</th>

                            </tr>
                        </thead>

                        <tbody>

                            <?php

                            $sql = "SELECT * FROM sach";

                            $result = mysqli_query($conn, $sql);
                            $stt = 1;
                            while ($row = mysqli_fetch_assoc($result)) {

                            ?>

                                <tr>
                                    <td>

                                        <button class="btn-edit"><a href="addBooks.php?id=<?php echo $row['ma_sach']; ?>"
                                                class="btn-edit"
                                                style="text-decoration: none; display: inline-block;">Sửa</a></button>

                                        <button class="btn-delete"><a
                                                href="deleteBooks.php?id=<?php echo $row['ma_sach']; ?>" class="btn-delete"
                                                style="text-decoration: none; display: inline-block;"
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa cuốn sách này không?');">Xóa</a></button>

                                    </td>
                                    <td><?php echo $stt++; ?></td>

                                    <td><?php echo $row['ten_sach']; ?></td>

                                    <td><?php echo $row['tac_gia']; ?></td>

                                    <td><?php echo $row['nha_xb']; ?></td>

                                    <td><?php echo $row['the_loai']; ?></td>

                                    <td><?php echo $row['quoc_gia']; ?></td>

                                    <td><?php echo $row['nha_cung_cap']; ?></td>

                                    <td><?php echo $row['so_luong']; ?></td>

                                    <td><?php echo $row['nam_xb']; ?></td>



                                </tr>

                            <?php
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
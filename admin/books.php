<!DOCTYPE html>
<html>

<head>
    <title>Books</title>

    <link rel="stylesheet" href="../index.css">

    <link rel="stylesheet" href="../assets_admin/css/sidebar.css">
    <link rel="stylesheet" href="../assets_admin/css/books.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body class="admin-body">
    <?php include "../mysqlConnect.php"; ?>
    <div class="books-page">

        <div class="admin-layout">

            <?php include "sidebar.php"; ?>

            <main class="books-content">

                <div class="books-header">
                    <div class="header-left">
                        <h2>Quản lý Sách</h2>

                        <!-- Form tìm kiếm -->
                        <form action="" method="GET" class="search-form">
                            <input onkeyup="showHint(this.value)" onclick="showHint(this.value)" type="text" name="search" placeholder="Nhập tên sách cần tìm..."
                                value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                            <button type="submit" class="btn-search"><i class="fa-solid fa-magnifying-glass"></i> Tìm
                                kiếm</button>
                        </form>
                        <script>
                            // Hiển thị kết quả tìm kiếm theo thời gian thực
                            function showHint(str){
                                var xhr = new XMLHttpRequest();
                                xhr.onreadystatechange = function() {
                                    if (this.readyState == 4 && this.status == 200){
                                        document.getElementById("tbody").innerHTML = this.responseText;
                                    }
                                };
                                xhr.open("GET", "./search.php?f=" + str, true); // true la bat dong bo
                                xhr.send();
                            }
                        </script>
                    </div>

                    <button class="btn-add"><a href="addBooks.php">Thêm sách</a></button>
                </div>

                <div class="books-table-box">
                    <table class="books-table">
                        <thead>
                            <tr>
                                <th>Thao tác</th>
                                <th>STT</th>
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

                        <tbody id="tbody">

                            <?php
                            $search_keyword = "";
                            if (isset($_GET['search'])) {
                                $search_keyword = mysqli_real_escape_string($mysqli, trim($_GET['search']));
                            }

                            if ($search_keyword != "") {
                                $sql = "SELECT * FROM sach WHERE ten_sach LIKE '%$search_keyword%'";
                            } else {
                                $sql = "SELECT * FROM sach";
                            }

                            $result = mysqli_query($mysqli, $sql);
                            $stt = 1;


                            if (mysqli_num_rows($result) > 0) {
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
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa sách <?php echo $row['ten_sach']; ?> (Mã sách: <?php echo $row['ma_sach']; ?>) ?');">Xóa</a></button>

                                        </td>
                                        <td style="text-align: center; vertical-align: middle;">
                                            <span class="stt-highlight"><?php echo $stt++; ?></span>
                                        </td>
                                        <td style="text-align: center;"><?php echo sprintf("%02d", $row['ma_sach']); ?></td>

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
                            } else {

                                echo "<tr><td colspan='11' style='text-align: center; color: red; padding: 20px;'>Không tìm thấy quyển sách nào có tên này!</td></tr>";
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
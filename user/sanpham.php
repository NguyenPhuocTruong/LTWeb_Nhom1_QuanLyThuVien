<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library</title>
    <link rel="stylesheet" href="../index.css">
    <link rel="stylesheet" href="../assets_user/sanpham.css">
    <script src="https://kit.fontawesome.com/67ecaf9947.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/vnd.microsoft.icon" href="../images/sky4.jpg">
</head>
<body>
    <?php include "../header.php" ?>
    <main>
        <div class="book_image">
            <div class="image_container">
                <?php 
                    require_once("../mysqlConnect.php");
                    $mysqli->select_db("library");

                    try {
                        if (isset($_REQUEST['ma_sach'])){
                            $ma_sach = (int)$_REQUEST['ma_sach'];
                            $stm = $mysqli->prepare("SELECT * FROM sach WHERE ma_sach = ?");
                            $stm->bind_param("i", $ma_sach);
                            if ($stm->execute()){
                                global $result;
                                $result = $stm->get_result()->fetch_assoc();
                                $image_encode = base64_encode($result['anh_bia']);
                                echo "<img src=\"data:image/jpg;charset=utf8;base64,$image_encode\" alt=\"image\">";
                            } else {
                                echo "<p>Lỗi không tải được ảnh:</p>" . $stm->error;
                            }
                        } else {
                            echo "<p>Không có yêu cầu tải ảnh được xác định</p>";
                            exit();
                        }
                    } catch (Exception $e) {
                        echo "<p>Xin lỗi bạn ! Trang đang gặp một số vấn đề:</p>" . $e->getMessage();
                    }
                ?>
                <button id="butt">Mượn sách</button>
                <script>
                    const butt = document.getElementById("butt");
                    butt.addEventListener('click', (e) => {
                        butt.textContent = "Bạn đã mượn sách này";
                    })
                </script>
            </div>
        </div>
        <div class="book_info">
            <div class="general_info">
                <div class="title"><h1 id="book_name"><?php echo $result['ten_sach'] ?></h1><br><br></div>
                <div class="info">
                    <div>
                        <p>Nhà cung cấp: <b><?php echo $result['nha_cung_cap'] ?></b></p><br>
                        <p id="nha_xuat_ban">Nhà xuất bản: <b><?php echo $result['nha_xb'] ?></b></p>
                    </div>
                    <div>
                        <p>Tác giả: <b><?php echo $result['tac_gia'] ?></b></p><br>
                        <p>Số lượng sách còn lại: <b><?php echo $result['so_luong'] ?></b></p>
                    </div>
                </div>
            </div>
            <div class="detail_info">
                <h2>Thông tin chi tiết</h2>
                <div><p class="info_name">Mã sách</p><p><?php echo $result['ma_sach'] ?></p></div>
                <div><p class="info_name">Tên nhà cung cấp</p><p><?php echo $result['nha_cung_cap'] ?></p></div>
                <div><p class="info_name">Tác giả</p><p><?php echo $result['tac_gia'] ?></p></div>
                <div><p class="info_name">NXB</p><p><?php echo $result['nha_xb'] ?></p></div>
                <div><p class="info_name">Năm XB</p><p><?php echo $result['nam_xb'] ?></p></div>
            </div>
            <div class="book_description">
                <h2>Mô tả sách</h2><br>
                <?php echo $result['mo_ta'] ?>
            </div>
        </div>
    </main>
    <?php include "../footer.php" ?>
</body>
</html>
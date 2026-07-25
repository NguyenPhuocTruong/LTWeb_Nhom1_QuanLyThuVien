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
            <div class="image_container" id="image_container">
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

                                // // kiem tra so luong con lai cua sach
                                // if ($result['so_luong'] == 0) echo "<button id=\"inform\" style=\"background-color: darkred\">Sách đã hết</button>";
                                // // kiem tra user da dang nhap chua
                                // else if (!isset($_SESSION['email'])) echo "<button id=\"inform\" style=\"background-color: darkred\">Đăng nhập để mượn sách</button>";
                                // // kiem tra user da muon sach nay chua
                                // else if (array_key_exists($ma_sach, $_SESSION['sach_da_muon'])){
                                //     echo "<button id=\"inform\" style=\"background-color: darkred\">Bạn đã mượn sách này</button>";
                                //     echo "<button id=\"butt\" onclick=\"tra_sach()\">Trả sách</button>";
                                // }
                                // else echo "<button id=\"butt\" onclick=\"muon_sach()\">Mượn sách</button>";
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
                <script>
                    function muon_sach(){
                        // lay ma sach va ten sach sau do gui yeu cau cho muonsach.php
                        const ma_sach = document.getElementById("ma_sach").textContent;
                        const ten_sach = document.getElementById("book_name").textContent;

                        // xac nhan muon sach
                        if (!confirm("Bạn có chắc chắn muốn mượn sách " + ten_sach + " ?")) return;
                        const butt = document.getElementById("butt");
                        butt.textContent = "Chờ chút...";
                        butt.disabled = true;
                        butt.style.backgroundColor = "black";
                        butt.style.cursor = "default";

                        var xhr = new XMLHttpRequest();
                        xhr.onreadystatechange = function(){
                            if (this.readyState == 4 && this.status == 200){
                                document.innerHTML = this.responseText;
                            }
                        }
                        xhr.open("GET", "./muonsach.php?ma_sach=" + ma_sach + "&ten_sach=" + ten_sach, true);
                        xhr.send();
                        alert("Bạn đã mượn sách thành công (Mã sách: " + ma_sach + ")");
                        window.location.reload();
                    };

                    function tra_sach(){
                        // lay ma sach va ten sach
                        const ma_sach = document.getElementById("ma_sach").textContent;
                        const ten_sach = document.getElementById("book_name").textContent;

                        // xac nhan tra sach
                        if (!confirm("Bạn có chắc chắn muốn trả sách " + ten_sach + " ?")) return;

                        // gui yeu cau toi server bang xmlhttprequest
                        var xhr = new XMLHttpRequest();
                        xhr.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                document.innerHTML = this.responseText;
                            }
                        }
                        xhr.open("GET", "./trasach.php?ma_sach=" + ma_sach + "&ten_sach=" + ten_sach, true);
                        xhr.send();
                        alert("Bạn đã trả sách thành công (Mã sách: " + ma_sach + ")");
                        window.location.reload();
                    }
                </script>
            </div>
        </div>
        <div class="book_info">
            <div class="general_info">
                <div class="title">
                    <h1 id="book_name"><?php echo $result['ten_sach'] ?></h1>
                    <?php 
                        // kiem tra so luong con lai cua sach
                        if ($result['so_luong'] == 0) echo "<button id=\"inform\" style=\"background-color: darkred\">Sách đã hết</button>";
                        // kiem tra user da dang nhap chua
                        else if (!isset($_SESSION['email'])) echo "<button id=\"inform\" style=\"background-color: darkred\">Đăng nhập để mượn sách</button>";
                        // kiem tra user da muon sach nay chua
                        else if (array_key_exists($ma_sach, $_SESSION['sach_da_muon'])){
                            echo "<button id=\"inform\" style=\"background-color: darkred\">Bạn đã mượn sách này</button>";
                            echo "<button id=\"butt\" onclick=\"tra_sach()\">Trả sách</button>";
                        }
                        else echo "<button id=\"butt\" onclick=\"muon_sach()\">Mượn sách</button>";
                    ?>
                    
                </div>
                <div class="info">
                    <div>
                        <p>Nhà cung cấp: <b><?php echo $result['nha_cung_cap'] ?></b></p><br>
                        <p id="nha_xuat_ban">Nhà xuất bản: <b><?php echo $result['nha_xb'] ?></b></p>
                    </div>
                    <div>
                        <p>Tác giả: <b><?php 
                            $tac_gia = $result['tac_gia'];
                            echo "<a href=\"./display_books.php?tac_gia=$tac_gia\">$tac_gia</a>";
                        ?></b></p><br>
                        <p>Số lượng sách còn lại: <b><?php echo $result['so_luong'] ?></b></p>
                    </div>
                </div>
            </div>
            <div class="detail_info">
                <h2>Thông tin chi tiết</h2>
                <div><p class="info_name">Mã sách</p><p id="ma_sach"><?php echo $result['ma_sach'] ?></p></div>
                <div><p class="info_name">Thể loại</p><p><?php 
                    $the_loai = $result['the_loai'];
                    $quoc_gia = $result['quoc_gia'];
                    $lan = ($quoc_gia == "vietnam") ? "Sách Tiếng Việt":"Foreign Books";
                    echo "<a href=\"./display_books.php?quoc_gia=$quoc_gia\">$lan</a> > <a href=\"./display_books.php?the_loai=$the_loai\">$the_loai</a>";
                ?></p></div>
                <div><p class="info_name">Tên nhà cung cấp</p><p><?php echo $result['nha_cung_cap'] ?></p></div>
                <div><p class="info_name">Tác giả</p><?php 
                    $tac_gia = $result['tac_gia'];
                    echo "<a href=\"./display_books.php?tac_gia=$tac_gia\">$tac_gia</a>";
                ?></div>
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
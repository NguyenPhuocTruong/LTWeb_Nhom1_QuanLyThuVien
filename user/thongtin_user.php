<?php session_start() ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets_auth/form.css"> 
    <link rel="stylesheet" href="../assets_user/thongtin_user.css">
    <script src="https://kit.fontawesome.com/67ecaf9947.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="form-container">
        <div class="form-container__bg"></div>
        <div class="info_form-container__content">
            <div class="form-container__header">
                <h3>Thông Tin Tài Khoản</h3><br>
            </div>
            <div class="form-container__form">
                <?php 
                    $email = $_SESSION['email'];
                    $name = $_SESSION['name'];
                    $sach_da_muon = $_SESSION['sach_da_muon'];
                    $so_luong = count($sach_da_muon);
                    echo "<h4>Email: $email</h4><h4>Họ Tên: $name</h4><h4>Sách Đã Mượn: $so_luong</h4><br>";
                    if ($so_luong > 0){
                        $i = 0;
                        echo "
                            <table>
                                <caption>Danh Sách Sách Đã Mượn</caption>
                                <tr>
                                    <th>Mã Sách</th>
                                    <th>Tên Sách</th>
                                </tr>
                        ";
                        foreach ($sach_da_muon as $ma_sach=>$ten_sach){
                            echo "
                                <tr>
                                    <td>$ma_sach</td>
                                    <td><a href=\"./sanpham.php?ma_sach=$ma_sach\">$ten_sach</td>
                                </tr>
                            ";
                        }
                        echo "</table><br>";
                    }
                ?>
                <!-- <div><p class="form-login">Bạn đã có tài khoản? <a href="dangnhap.php">Đăng nhập</a></p></div>
                <div><p class="form-login"><a href="../user/trangchu.php">Quay về trang chủ</a></p></div> -->
                <div class="navi">
                    <a href="./trangchu.php"><button class="navi_btn">Quay Về Trang Chủ</button></a>
                    <button onclick="dangxuat()" class="navi_btn">Đăng Xuất</button>
                    <script>
                        function dangxuat(){
                            if (confirm("Bạn Có Chắc Chắn Muốn Đăng Xuất ?")){
                                window.location.href = "./dangxuat.php";
                            }
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</body>
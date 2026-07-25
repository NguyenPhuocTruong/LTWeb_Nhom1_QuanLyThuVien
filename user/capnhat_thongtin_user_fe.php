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
    <div class="info-container">
        <div class="info_form-container__content">
            <div class="form-container__header">
                <h3>Cập Nhật Thông Tin</h3><br><br>
            </div>
            <div class="form-container__form">
                <form id="input_form">
                    <div class="form-container__row">
                        <label class="form_label">E-mail</label>
                        <input class="form_input" id="email" name="email" value="<?php echo $_SESSION['email']; ?>" type="email" placeholder="Nhập email của bạn">
                    </div>
                    <div class="form-container__row">
                        <label class="form_label">Họ và tên</label>
                        <input class="form_input" id="hoten" name="hoten" value="<?php echo $_SESSION['name'];?>" type="text" placeholder="Nhập họ và tên của bạn">
                    </div>
                    <!-- <div class="form-container__row">
                        <label class="form_label">Mật khẩu</label>
                        <input class="form_input" name="password" value="<?php if(isset($_POST['password'])) echo $_POST['password'];?>" type="password" placeholder="Nhập mật khẩu của bạn">
                    </div>
                    <div class="form-container__row">
                        <label class="form_label">Nhập lại mật khẩu</label>
                        <input class="form_input" name="re-enter" value="<?php if(isset($_POST['re-enter'])) echo $_POST['re-enter'];?>" type="password" placeholder="Nhập lại mật khẩu của bạn">
                    </div> -->
                </form>
                <div class="navi">
                    <button onclick="luuThongTin()" class="navi_btn" style="background-color: green; width: 81%;">Lưu</button>
                    <a href="./trangchu.php"><button class="navi_btn">Quay Về Trang Chủ</button></a>
                    <button onclick="window.location.reload();" class="navi_btn" style="background-color: brown;">Hủy Bỏ Thay Đổi</button>
                    <script>
                        function luuThongTin(){
                            const newEmail = document.getElementById("email").value;
                            const newName = document.getElementById("hoten").value;
                            const oldEmail = "<?php echo $_SESSION['email']; ?>";
                            const oldName = "<?php echo $_SESSION['name']; ?>";

                            if ((newEmail !== oldEmail) || (newName !== oldName)){
                                var xhr = new XMLHttpRequest();
                                xhr.onreadystatechange = function() {
                                    if (this.readyState == 4 && this.status == 200){
                                        document.getElementById("server_response").innerText = this.responseText;
                                        // alert(this.responseText);
                                    }
                                }
                                const formData = new FormData(document.getElementById("input_form"));
                                xhr.open("POST", "./capnhat_thongtin_user_be.php", true);
                                xhr.send(formData);
                            }
                        }
                    </script>
                    <script id="server_response"></script>
                </div>
            </div>
        </div>
    </div>
</body>
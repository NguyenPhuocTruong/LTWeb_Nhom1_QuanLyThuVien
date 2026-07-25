<?php session_start() ?>

<?php 
    require_once("../mysqlConnect.php");

    // function to test user input
    function test_input(string $data): string {
        $data = trim($data);
        $data = stripslashes($data);
        return htmlspecialchars($data);
    }

    function validEmail(string $email): bool { 
        return (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) ? true:false;
    }

    function validName(string $name): bool {
        // ten chi duoc chua chu cai va khoang trang
        return preg_match("/^[a-zA-ZÀ-ỹ\s]+$/", $name);
    }

    if (isset($_POST['email']) and isset($_POST['hoten'])){
        $newEmail = $_POST['email'];
        $newName = $_POST['hoten'];
        $oldEmail = $_SESSION['email'];

        $response = "";

        if (!validEmail(test_input($newEmail))) $response = "<script>alert(\"Email không hợp lệ\")</script>";
        else if (!validName(test_input($newName))) $response = "<script>alert(\"Họ tên chỉ được chứa chữ cái và khoảng trắng\")</script>";
        else {
            // kiem tra email da ton tai chua
            $stm = $mysqli->prepare("SELECT * FROM nguoidung WHERE email = ?");
            $stm->bind_param("s", $newEmail);
            if ($stm->execute()){
                if ($stm->get_result()->num_rows == 0){
                    // update thong tin user trong bang nguoidung
                    $stm = $mysqli->prepare("UPDATE nguoidung SET email = ?, hoten = ? WHERE email = '$oldEmail'");
                    $stm->bind_param("ss", $newEmail, $newName);
                    if ($stm->execute()){
                        // thay doi gia tri session
                        $_SESSION['email'] = $newEmail;
                        $_SESSION['name'] = $newName;

                        $response = "
                            <script>
                                alert(\"Đã lưu những thay đổi\");
                                window.location.href = \"./thongtin_user.php\";
                            </script>
                        ";
                    } else $response = "<script>alert(\"Xảy ra lỗi trong quá trình thay đổi thông tin: " . $stm->error . "\")</script>";
                } else $response = "<script>alert(\"Email đã tồn tại\")</script>";
            } else $response = "<script>alert(\"Xảy ra lỗi trong quá trình thay đổi thông tin: " . $stm->error . "\")</script>";
        }
        echo $response;
    }
?>

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
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" enctype="multipart/form-data">
                    <div class="form-container__row">
                        <label class="form_label">E-mail</label>
                        <input class="form_input" id="email" name="email" value="<?php if (isset($_POST['email'])) echo $_POST['email']; else echo $_SESSION['email']; ?>" type="email" placeholder="Nhập email của bạn">
                    </div>
                    <div class="form-container__row">
                        <label class="form_label">Họ và tên</label>
                        <input class="form_input" id="hoten" name="hoten" value="<?php if (isset($_POST['hoten'])) echo $_POST['hoten']; else echo $_SESSION['name']; ?>" type="text" placeholder="Nhập họ và tên của bạn">
                    </div>
                    <!-- <div class="form-container__row">
                        <label class="form_label">Mật khẩu</label>
                        <input class="form_input" name="password" value="<?php if(isset($_POST['password'])) echo $_POST['password'];?>" type="password" placeholder="Nhập mật khẩu của bạn">
                    </div>
                    <div class="form-container__row">
                        <label class="form_label">Nhập lại mật khẩu</label>
                        <input class="form_input" name="re-enter" value="<?php if(isset($_POST['re-enter'])) echo $_POST['re-enter'];?>" type="password" placeholder="Nhập lại mật khẩu của bạn">
                    </div> -->
                    <div class="navi">
                        <button onclick="return confirm('Bạn có chắc chắn muốn lưu những thay đổi ?')" type="submit" class="navi_btn" style="background-color: green; width: 81%;">Lưu</button>
                    </div>
                </form>
                <div class="navi">
                    <a href="./trangchu.php"><button class="navi_btn">Quay Về Trang Chủ</button></a>
                    <a href=""><button class="navi_btn" style="background-color: brown;">Hủy Bỏ Thay Đổi</button></a>
                    <!-- <script>
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
                    </script> -->
                    <!-- <script id="server_response"></script> -->
                </div>
            </div>
        </div>
    </div>
</body>
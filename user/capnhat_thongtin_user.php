<?php session_start() ?>

<?php 
    require_once("../mysqlConnect.php");

    // function to test user input
    function test_input(string $data): string {
        $data = trim($data);
        $data = stripslashes($data);
        return htmlspecialchars($data);
    }

    // kiem tra email hop le
    function validEmail(string $email): bool { 
        return (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) ? true:false;
    }

    // kiem tra ten hop le
    function validName(string $name): bool {
        // ten chi duoc chua chu cai va khoang trang
        return preg_match("/^[a-zA-ZÀ-ỹ\s]+$/", $name);
    }

    if (isset($_POST['email']) and isset($_POST['hoten'])){
        $newEmail = $_POST['email'];
        $newName = $_POST['hoten'];
        $oldEmail = $_SESSION['email'];
        $oldName = $_SESSION['name'];
        $currPassword = "";
        $newPassword = "";
        $reEnterNewPassword = "";
        $passwordVerified = false;

        // neu user muon doi mat khau
        if (isset($_POST['new_password'])) {
            $currPassword = $_POST['curr_password'];
            $newPassword = $_POST['new_password'];
            $reEnterNewPassword = $_POST['re_enter_new_password'];

            // kiem tra mat khau
            $stm = $mysqli->prepare("SELECT * FROM nguoidung WHERE email = ?");
            $stm->bind_param("s", $oldEmail);
            if ($stm->execute()){
                $hashedPassword = $stm->get_result()->fetch_assoc()['mat_khau'];
                if (password_verify($currPassword, $hashedPassword)) $passwordVerified = true;
            }
        }

        $response = "";

        // kiem tra email hop le
        if (!validEmail(test_input($newEmail))) $response = "<script>alert(\"Email không hợp lệ\")</script>";

        // kiem tra ten hop le
        else if (!validName(test_input($newName))) $response = "<script>alert(\"Họ tên chỉ được chứa chữ cái và khoảng trắng\")</script>";

        // kiem tra mat khau neu user muon doi mat khau (strlen($currPassword) != 0)
        else if (strlen($currPassword) != 0 and !$passwordVerified) $response = "<script>alert(\"Mật khẩu hiện tại không chính xác\")</script>";
        else if (strlen($currPassword) != 0 and strlen($newPassword) < 8) $response = "<script>alert(\"Mật khẩu mới phải có ít nhất 8 ký tự\")</script>";
        else if (strlen($currPassword) != 0 and $newPassword !== $reEnterNewPassword) $response = "<script>alert(\"Mật khẩu nhập lại không khớp\")</script>";
        
        else if (($newEmail !== $oldEmail) or ($newName !== $oldName) or (strlen($currPassword) != 0)) {
            // kiem tra email da ton tai chua
            $stm = $mysqli->prepare("SELECT * FROM nguoidung WHERE email = ?");
            $stm->bind_param("s", $newEmail);
            if ($stm->execute()){
                $result = $stm->get_result();
                // neu email chua ton tai hoac da ton tai nhung la email hien tai cua user (user chi thay doi ten, mat khau)
                if ($result->num_rows == 0 || ($result->num_rows == 1 and $newEmail === $oldEmail)){
                    $stm = "";

                    // neu user muon doi mat khau
                    if (strlen($currPassword) != 0) {
                        $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                        $stm = $mysqli->prepare("UPDATE nguoidung SET email = ?, hoten = ?, mat_khau = ? WHERE email = '$oldEmail'");
                        $stm->bind_param("sss", $newEmail, $newName, $newHashedPassword);
                    } else {
                        $stm = $mysqli->prepare("UPDATE nguoidung SET email = ?, hoten = ? WHERE email = '$oldEmail'");
                        $stm->bind_param("ss", $newEmail, $newName);
                    }
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
        } else $response = "<script>window.location.href = \"./thongtin_user.php\";</script>";
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
                    <div class="form-container__row">
                        <label class="form_label">Mật khẩu hiện tại <b>(Bỏ trống nếu bạn không muốn đổi mật khẩu)</b></label>
                        <input onkeyup="enterCurrPassword()" class="form_input" id="curr_password" name="curr_password" value="<?php if (isset($_POST['curr_password'])) echo $_POST['curr_password'];?>" type="password" placeholder="Nhập mật khẩu hiện tại">
                    </div>
                    <div class="form-container__row">
                        <label class="form_label">Mật khẩu mới</label>
                        <input <?php if (!isset($_POST['new_password'])) echo "disabled"; ?> class="form_input" id="new_password" name="new_password" value="<?php if (isset($_POST['new_password'])) echo $_POST['new_password'];?>" type="password" placeholder="Nhập mật khẩu mới">
                    </div>
                    <div class="form-container__row">
                        <label class="form_label">Nhập lại mật khẩu mới</label>
                        <input <?php if (!isset($_POST['new_password'])) echo "disabled"; ?> class="form_input" id="re_enter_new_password" name="re_enter_new_password" value="<?php if (isset($_POST['re_enter_new_password'])) echo $_POST['re_enter_new_password'];?>" type="password" placeholder="Nhập lại mật khẩu mới">
                    </div>
                    <div class="navi">
                        <button onclick="return confirm('Bạn có chắc chắn muốn lưu những thay đổi ?')" type="submit" class="navi_btn" style="background-color: green; width: 81%;">Lưu</button>
                    </div>
                </form>
                <div class="navi">
                    <button class="navi_btn" onclick="backToMainPage()">Quay Về Trang Chủ</button>
                    <script>
                        function backToMainPage(){
                            const newEmail = document.getElementById("email").value;
                            const newName = document.getElementById("hoten").value;
                            const oldEmail = "<?php echo $_SESSION['email']; ?>";
                            const oldName = "<?php echo $_SESSION['name']; ?>";

                            // neu co thay doi chua luu thi hoi user co chac chan thoat
                            if (newEmail !== oldEmail || newName !== oldName) {
                                if (confirm("Bạn chưa lưu những thay đổi. Bạn có chắc chắn thoát ?")) window.location.href = "./trangchu.php";
                            } else window.location.href = "./trangchu.php";
                        }

                        function enterCurrPassword(){
                            const curr_password = document.getElementById("curr_password").value;
                            if (curr_password.length != 0) {
                                document.getElementById("new_password").disabled = false;
                                document.getElementById("re_enter_new_password").disabled = false;
                            } else {
                                document.getElementById("new_password").disabled = true;
                                document.getElementById("re_enter_new_password").disabled = true;
                            }
                        }
                    </script>
                    <a href=""><button class="navi_btn" style="background-color: brown;">Khôi Phục</button></a>
                </div>
            </div>
        </div>
    </div>
</body>
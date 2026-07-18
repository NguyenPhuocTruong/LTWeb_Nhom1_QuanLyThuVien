<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'library');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = '';

if (isset($_POST['dangki'])) {
    $email    = trim($_POST['email']);
    $hoten    = trim($_POST['hoten']);
    $password = trim($_POST['password']);
    $re_enter   = trim($_POST['re-enter']);
    $agree    = isset($_POST['check']);

    if (empty($email) || empty($hoten) || empty($password) || empty($re_enter)) {
        $error = '<script>alert("Vui lòng điền đầy đủ thông tin!")</script>';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = '<script>alert("Email không hợp lệ!")</script>';
    } else if (strlen($password) < 8) {
        $error = '<script>alert("Mật khẩu phải có ít nhất 8 ký tự!")</script>';
    } else if (!$agree) {
        $error = '<script>alert("Bạn cần đồng ý với Điều khoản dịch vụ và Chính sách bảo mật!")</script>';
    } else if ($password !== $re_enter){
        $error = '<script>alert("Mật khẩu không trùng khớp")</script>';
    } else {
        $checkSql = 'SELECT email FROM nguoidung WHERE email = ?';
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bind_param('s', $email);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();
        if ($checkResult->num_rows > 0) {
            $error = '<script>alert("Email đã tồn tại!")</script>';
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $sql = 'INSERT INTO nguoidung (email, ho_ten, mat_khau) VALUES (?, ?, ?)';
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param('sss', $email, $hoten, $hashedPassword);

                if ($stmt->execute()) {
                    echo '<script>
                        alert("Đăng ký thành công!");
                        window.location.href = "dangnhap.php";
                    </script>';
                    exit();
                } else {
                    $error = '<script>alert("Đăng ký thất bại, vui lòng thử lại!")</script>';
                }
                $stmt->close();
            }
        }
        $checkStmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets_auth/form.css"> 
    <script src="https://kit.fontawesome.com/67ecaf9947.js" crossorigin="anonymous"></script>
    <title>Đăng ký tài khoản</title>
    <!-- <style>
        
        .form-container{
            position: fixed;
            top: 0;
            right: 0;
            left:0;
            bottom: 0;
            display:flex;
        }
        .form-container__bg{
            position: absolute;
            width: 100%;
            height:100%;
            background: linear-gradient(0deg,#5AB9EA, #C1C8E4, #8860D0);    
        }
        .form-container__content{
            width: 500px;
            height: 700px;
            background-color: #fff;
            border-radius: 7px;
            margin: auto;
            position: relative;
        }

        h3{
            font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            text-align: center;
            margin-top: 60px;
        }
        .form-container__form{
            padding: 0px 40px;
        }
        .form-container__row{
            padding: 10px 0;
        }
        .form_label{
            display: block;
            margin-bottom: 10px;
        
        }
        .form_input{
            width: 100%;
            height: 40px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form_policy{
            display: flex;
            align-items: flex-start;
            gap:2px;
            margin: 10px 0;
        }

        .policy-text{
            text-align: center;
        }
        .policy-a{
            text-decoration: none;
        }
        .btn{
            color: #fff;
            cursor: pointer;
            transition: opacity 0.2s ease;
        }
        .btn:hover{
            opacity: 0.8;
        }
        .btn-control{
            width: 100%;
            height: 40px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #8860D0;
        }
        /* .btn-social{
            width: 100%;
            height: 40px;
            border: 1px solid #ccc;
            border-radius: 5px;
            gap: 2px;
        } */
        .form-login{
            text-align: center;
            text-decoration: none;
        }
    </style> -->
</head>
<body>
    <div class="form-container">
        <div class="form-container__bg"></div>
        <div class="signup_form-container__content">
            <div class="form-container__header">
                <h3>Tạo tài khoản của bạn</h3>
            </div>
            <div class="form-container__form">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                    <div class="form-container__row">
                        <label class="form_label">E-mail</label>
                        <input class="form_input" name="email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" type="email" placeholder="Nhập email của bạn">
                    </div>
                    <div class="form-container__row">
                        <label class="form_label">Họ và tên</label>
                        <input class="form_input" name="hoten" value="<?php if(isset($_POST['hoten'])) echo $_POST['hoten'];?>" type="text" placeholder="Nhập họ và tên của bạn">
                    </div>
                    <div class="form-container__row">
                        <label class="form_label">Mật khẩu</label>
                        <input class="form_input" name="password" value="<?php if(isset($_POST['password'])) echo $_POST['password'];?>" type="password" placeholder="Nhập mật khẩu của bạn">
                    </div>
                    <div class="form-container__row">
                        <label class="form_label">Nhập lại mật khẩu</label>
                        <input class="form_input" name="re-enter" value="<?php if(isset($_POST['re-enter'])) echo $_POST['re-enter'];?>" type="password" placeholder="Nhập lại mật khẩu của bạn">
                    </div>
                    <div class="form_policy">
                        <input class="policy" type="checkbox" name="check"><label class="policy-text">Khi đăng kí, bạn đồng ý với chúng tôi về <a href="" class="policy-a">Điều khoản dịch vụ</a> & <a href="" class="policy-a">Chính sách bảo mật</a> 
                        </label>
                    </div>
                    <?php if(!empty($error)): ?>
                        <?php echo $error; ?>
                    <?php endif; ?>
                    <div class="form-container__row">
                        <button type="submit" class="btn btn-control" name="dangki">Tạo tài khoản</button>
                    </div>
                </form>
                <!-- <div class="form-container__social">
                    <button class="btn-social"><a href="" class="google-icon"><i class="fa-brands fa-google"></i>Đăng ký bằng Google</a></button>
                </div> -->
                <div><p class="form-login">Bạn đã có tài khoản? <a href="dangnhap.php">Đăng nhập</a></p></div>
            </div>
        </div>
    </div>
</body>
</html>
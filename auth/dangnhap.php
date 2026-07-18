<?php
    session_start();
    require_once("../mysqlConnect.php");

    $error = ''; 

    if(isset($_POST['login'])){
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
       
        if(empty($email) || empty($password)){
            $error = '<script>alert("Email và mật khẩu không được để trống!")</script>';
        } else {
            // lay ra hashed password cua user thong qua email
            $sql = 'SELECT * FROM nguoidung WHERE email=?';
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param('s', $email);
            if ($stmt->execute()){
                $result = $stmt->get_result();
                if($result->num_rows == 1){
                    $row = $result->fetch_assoc();
                    // kiem tra mat khau
                    if (password_verify($password, $row['mat_khau'])){
                        // luu thong tin email va ho ten user vao session
                        $_SESSION['email'] = $row['email'];
                        $_SESSION['name'] = $row['hoten'];
                        
                        // lay danh sach sach da muon cua user
                        $sql = "SELECT muon_sach.ma_sach, sach.ten_sach FROM muon_sach INNER JOIN sach ON muon_sach.ma_sach = sach.ma_sach 
                        WHERE muon_sach.email = '$email'";
                        $result = $mysqli->query($sql);
                        if ($result->num_rows > 0){
                            while ($row = $result->fetch_assoc()){
                                // $_SESSION['sach_da_muon'] la mot associative array, ma_sach la key, ten_sach la value
                                $_SESSION['sach_da_muon'][$row['ma_sach']] = $row['ten_sach'];
                            }
                        } else $_SESSION['sach_da_muon'] = array();

                        // thong bao dang nhap thanh cong va chuyen huong den trang chu
                        echo '<script>
                            alert("Đăng nhập thành công!");
                            window.location.href = "../user/trangchu.php";
                        </script>';
                        exit();
                    } else $error = '<script>alert("Email hoặc mật khẩu không chính xác!")</script>';
                } else $error = '<script>alert("Email hoặc mật khẩu không chính xác!")</script>';
            } else $error = '<script>alert("Lỗi trong lúc truy vấn dữ liệu đăng nhập!")</script>';
            $stmt->close();
            // $sql = 'SELECT email FROM nguoidung WHERE email=? AND mat_khau=?';
            // if($stmt = $mysqli->prepare($sql)){
            //     $stmt->bind_param('ss', $email, $password);
            //     $stmt->execute();
            //     $result = $stmt->get_result();
                
            //     if($result->num_rows == 1){
            //         $row = $result->fetch_assoc();

            //         // luu thong tin email va ho ten user vao session
            //         $_SESSION['email'] = $row['email'];
            //         $_SESSION['name'] = $row['hoten'];

            //         // thong bao dang nhap thanh cong va chuyen huong den trang chu
            //         echo '<script>
            //             alert("Đăng nhập thành công!");
            //             window.location.href = "../user/trangchu.php";
            //         </script>';
            //         exit();
            //     } else {
            //         $error = '<script>alert("Email hoặc mật khẩu không chính xác!")</script>';
            //     }
            //     $stmt->close();
            // }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets_auth/form.css">
    <title>Đăng nhập tài khoản</title>
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
            height: 500px;
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
        .btn-social{
            width: 100%;
            height: 40px;
            border: 1px solid #ccc;
            border-radius: 5px;
            gap: 2px;
        }
        .form-login{
            text-align: center;
            text-decoration: none;
        }
    </style> -->
</head>
<body>
    <div class="form-container">
        <div class="form-container__bg"></div>
        <div class="login_form-container__content">
            <div class="form-container__header">
                <h3>ĐĂNG NHẬP</h3>
            </div>
            <div class="form-container__form">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                    <div class="form-container__row">
                        <label class="form_label">Email:</label>
            
                        <input class="form_input" type="email" name="email" value="<?php if(isset($_POST['email'])) echo $_POST['email'];?>" placeholder="Nhập email của bạn">
                    </div>
                    <div class="form-container__row">
                        <label class="form_label">Mật khẩu</label>
                        <input class="form_input" type="password" name="password" value="<?php if(isset($_POST['password'])) echo $_POST['password'];?>" placeholder="Nhập mật khẩu của bạn">
                    </div>
                   
                    <?php if(!empty($error)): ?>
                        <?php echo $error; ?>
                    <?php endif; ?>

                    <div class="form-container__row">
                        <button type="submit" class="btn btn-control" name="login">Đăng nhập</button>
                    </div>
                </form>
                <hr>
                <div><p class="form-login">Bạn chưa có tài khoản? <a href="dangky.php">Đăng kí</a></p></div>
                <div><p class="form-login"><a href="../user/trangchu.php">Quay về trang chủ</a></p></div>
            </div>
        </div>
    </div>
</body>
</html>
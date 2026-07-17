<?php
    session_start();
    $conn = new mysqli('localhost', 'root', '', 'library');
    if($conn->connect_error){
        die("Connection failed: " .$conn->connect_error);
    }

    $error = ''; 

    if(isset($_POST['login'])){
        $user = trim($_POST['user']);
        $password = trim($_POST['password']);
       
        if(empty($user) || empty($password)){
            $error = '<script>alert("Tên đăng nhập và mật khẩu không được để trống!")</script>';
        } else {
            $sql = 'SELECT user FROM nguoidung WHERE username=? AND mat_khau=?';
            if($stmt = $conn->prepare($sql)){
                $stmt->bind_param('ss', $user, $password);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if($result->num_rows == 1){
                    $row = $result->fetch_assoc();
                    $_SESSION['user'] = $row['user'];
                    $_SESSION['password'] = $row['password'];
                    echo '<script>
                        alert("Đăng nhập thành công!");
                        window.location.href = "index.php";
                    </script>';
                    exit();
                } else {
                    $error = '<script>alert("Tên đăng nhập hoặc mật khẩu không chính xác!")</script>';
                }
                $stmt->close();
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập tài khoản</title>
    <style>
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
    </style>
</head>
<body>
    <div class="form-container">
        <div class="form-container__bg"></div>
        <div class="form-container__content">
            <div class="form-container__header">
                <h3>ĐĂNG NHẬP</h3>
            </div>
            <div class="form-container__form">
                <form action="" method="post">
                    <div class="form-container__row">
                        <label class="form_label">Tên đăng nhập</label>
            
                        <input class="form_input" type="text" name="user" value="<?php if(isset($_POST['user'])) echo $_POST['user'];?>" placeholder="Nhập tên đăng nhập của bạn">
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
                <div><p class="form-login">Bạn chưa có tài khoản? <a href="dangki.php">Đăng kí</a></p></div>
            </div>
        </div>
    </div>
</body>
</html>
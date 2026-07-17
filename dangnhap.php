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
    <link rel="stylesheet" href="form.css"> 
    <title>Đăng nhập tài khoản</title>
</head>
<body>
    <div class="form-container">
        <div class="form-container__content log-in">
            <div class="form-container__header">
                <h3>ĐĂNG NHẬP</h3>
            </div>
            <div class="form-container__form">
                <form action="" method="post">  
                    <div class="form-container__row">
                        <label class="form_label">Tên đăng nhập</label>
            
                        <input class="form_input" type="text" name="user" placeholder="Nhập tên đăng nhập của bạn">
                    </div>
                    <div class="form-container__row">
                        <label class="form_label">Mật khẩu</label>
                        <input class="form_input" type="password" name="password" placeholder="Nhập mật khẩu của bạn">
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
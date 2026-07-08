<?php session_start() ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sign in test</title>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
        Email: <input type="email" name="email" id="email" required value=<?php if (isset($_POST['email'])) echo $_POST['email'] ?>><br><br>
        Mat khau: <input type="password" name="password" id="password" required value=<?php if (isset($_POST['password'])) echo $_POST['password'] ?>><br><br>
        <input type="submit"> <input type="reset">
    </form><br>
    <a href="./user/trangchu.php"><button>Quay ve trang chu</button></a>  
    <script>
        if (window.history.replaceState){
            window.history.replaceState(null, null, window.location.href);
        }
    </script>

    <?php 
        require_once("./mysqlConnect.php");
        $mysqli->select_db("library");

        if ($_SERVER['REQUEST_METHOD'] == "POST"){
            if (isset($_POST['email']) and isset($_POST['password'])){
                $email = $_POST['email'];
                $password = $_POST['password'];

                $stm = $mysqli->prepare("SELECT mat_khau FROM nguoidung WHERE email=?");
                $stm->bind_param("s", $email);
                $message = "";

                if ($stm->execute()){
                    $result = $stm->get_result();
                    if ($result->num_rows == 1){
                        $stored_password = $result->fetch_assoc()['mat_khau'];
                        if (password_verify($password, $stored_password)){
                            $_SESSION['email'] = $email; // lay email cho session
                            $stm = $mysqli->prepare("SELECT hoten FROM nguoidung WHERE email = ?");
                            $stm->bind_param("s", $email);
                            if ($stm->execute()){
                                $result = $stm->get_result();
                                if ($result->num_rows > 0){
                                    $_SESSION['name'] = $result->fetch_assoc()['hoten']; // lay ten user cho session

                                    // lay danh sach sach da muon cua user
                                    $sql = "SELECT muon_sach.ma_sach, sach.ten_sach FROM muon_sach INNER JOIN sach ON muon_sach.ma_sach = sach.ma_sach 
                                    WHERE muon_sach.email = '$email'";
                                    $result = $mysqli->query($sql);
                                    while ($row = $result->fetch_assoc()){
                                        // $_SESSION['sach_da_muon'] la mot associative array, ma_sach la key, ten_sach la value
                                        $_SESSION['sach_da_muon'][$row['ma_sach']] = $row['ten_sach'];
                                    }

                                    header("Location: ./user/trangchu.php");
                                } else echo "Loi khong tim thay ten trong csdl";
                            } else echo "Loi trong luc truy van csdl: " . $stm->error;
                        } else $message = "
                            <h3 style=\"color: red\">Sai mat khau !</h3>
                            <script>
                                document.getElementById(\"password\").style.border = \"2px red solid\";
                            </script>
                        ";
                    } else $message = "
                        <h3 style=\"color: red\">Tai khoan chua dang ky !</h3>
                        <script>
                            document.getElementById(\"email\").style.border = \"2px red solid\";
                        </script>
                    ";
                    echo $message;
                } else echo "Loi trong luc truy van tai khoan: " . $stm->error;
            }
        }
    ?>
</body>
</html>
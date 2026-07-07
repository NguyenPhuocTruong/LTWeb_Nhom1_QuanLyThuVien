<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sign up test</title>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
        Email: <input id="email" type="email" name="email" required value=<?php if (isset($_POST['email'])) echo $_POST['email'] ?>><br><br>
        Ho ten: <input type="text" name="name" required value=<?php if (isset($_POST['name'])) echo $_POST['name'] ?>><br><br>
        Mat khau: <input type="password" name="password" required value=<?php if (isset($_POST['password'])) echo $_POST['password'] ?>><br><br>
        <input type="submit"> <input type="reset">
    </form>
    <script>
        if (window.history.replaceState) window.history.replaceState(null, null, window.location.href);
    </script>

    <?php 
        require_once("./mysqlConnect.php");
        $mysqli->select_db("library");

        // xu ly du lieu user nhap vao
        function test_input(string $data): string {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        function isEmailExist(string $email, mysqli $mysqli) : bool {
            $stm = $mysqli->prepare("SELECT * FROM nguoidung WHERE email=?");
            $stm->bind_param("s", $email);
            if ($stm->execute()){
                $result = $stm->get_result();
                return $result->num_rows > 0;
            } else {
                echo "Loi trong luc truy van thong tin: " . $stm->error;
                exit();
            }
        }

        if ($_SERVER['REQUEST_METHOD'] == "POST"){
            if (isset($_POST['email']) and isset($_POST['name']) and isset($_POST['password'])){
                // xu ly du lieu nhap vao
                $email = test_input($_POST['email']);
                $name = test_input($_POST['name']);

                // kiem tra email da ton tai chua, neu co roi thi khong cho tao tai khoan
                if (!isEmailExist($email, $mysqli)){
                    // ma hoa mat khau
                    $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

                    $stm = $mysqli->prepare("INSERT INTO nguoidung (email, hoten, mat_khau) VALUES (?, ?, ?)");
                    $stm->bind_param("sss", $email, $name, $hashed_password);
                    if ($stm->execute()){
                        // chuyen huong nguoi dung den trang thong tin ca nhan userProfile
                        header("Location: ./userProfile_test.php?email=$email");
                    } else echo "Loi trong luc tao tai khoan: " . $stm->error;
                } else echo "
                    <h3 style=\"color: red\">Tai khoan $email da ton tai !</h3>
                    <script>
                        document.getElementById(\"email\").style.border = \"2px red solid\";
                    </script>
                ";
            }
        }
    ?>
</body>
</html>
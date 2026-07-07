<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>user profile test</title>
</head>
<body>
    <h1 style="color: chartreuse;">Ban da dang ky thanh cong</h1><br><br>
    <h3>Thong tin ca nhan:</h3><br>
    <?php 
        require_once("./mysqlConnect.php");
        $mysqli->select_db("library");

        if (isset($_REQUEST['email'])){
            $email = $_REQUEST['email'];

            $stm = $mysqli->prepare("SELECT hoten FROM nguoidung WHERE email = ?");
            $stm->bind_param("s", $email);
            if ($stm->execute()){
                $result = $stm->get_result();
                if ($result->num_rows > 0){
                    $name = $result->fetch_assoc()['hoten'];
                    echo "<h4>Email: $email</h4><br><h4>Ho ten: $name</h4>";
                } else echo "Loi trong luc luu tru thong tin";
            } else echo "Loi trong luc truy van thong tin: " . $stm->error;
        }
    ?>
    <a href="./user/trangchu.php"><button>Quay ve trang chu</button></a>
</body>
</html>
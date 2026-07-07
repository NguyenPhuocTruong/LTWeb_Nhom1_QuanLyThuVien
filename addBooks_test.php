<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>test</title>
</head>
<body>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
        ten sach: <input type="text" name="ten_sach"><br>
        tac gia: <input type="text" name="tac_gia"><br>
        nam xuat ban: <input type="number" name="nam_xb"><br>
        nha xuat ban: <input type="text" name="nha_xb"><br>
        nha cung cap: <input type="text" name="nha_cung_cap"><br>
        the loai: <input type="text" name="the_loai"><br>
        quoc gia: <input type="text" name="quoc_gia"><br>
        so luong: <input type="number" name="so_luong"><br>
        <label for="mo_ta">mo ta:</label><br>
        <textarea name="mo_ta" rows="10" cols="40"></textarea><br>
        anh bia: <input type="file" name="anh_bia"><br><br>
        <input type="submit">
        <input type="reset">
    </form>
    <script>
        if (window.history.replaceState) window.history.replaceState(null, null, window.location.href);
    </script>
</body>
</html>

<?php
    require_once("mysqlConnect.php");
    $mysqli->select_db("library");
    
    if (
        isset($_POST['ten_sach']) && 
        isset($_POST['tac_gia']) && 
        isset($_POST['nam_xb']) && 
        isset($_POST['nha_xb']) && 
        isset($_POST['nha_cung_cap']) && 
        isset($_POST['the_loai']) && 
        isset($_POST['quoc_gia']) && 
        isset($_POST['so_luong']) &&
        isset($_POST['mo_ta']) && 
        isset($_FILES['anh_bia'])
    ) {
        $stm = $mysqli->prepare(
            "INSERT INTO sach (ten_sach, tac_gia, nam_xb, nha_xb, nha_cung_cap, the_loai, quoc_gia, so_luong, mo_ta, anh_bia) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );

        // luu thong tin va anh vao csdl
        $image_data = file_get_contents($_FILES['anh_bia']['tmp_name']);
        $stm->bind_param(
            "ssissssiss", 
            $_POST['ten_sach'], 
            $_POST['tac_gia'], 
            $_POST['nam_xb'], 
            $_POST['nha_xb'], $_POST['nha_cung_cap'], $_POST['the_loai'], $_POST['quoc_gia'], 
            $_POST['so_luong'], $_POST['mo_ta'], $image_data
        );

        if ($stm->execute()){
            echo "<h1>upload successfully</h1>";

            // xuat anh
            echo "<h1>image:</h1><br>";
            $img_encode = base64_encode($image_data);
            echo "<img src=\"data:image/jpeg;charset=utf8;base64,$img_encode\">";

            //mo ta
            echo "<h1>Mo ta:</h1><br>" . $_POST['mo_ta'];
        } else echo "upload fail: " . $stm->error;
        $stm->close();

        // kiem tra the loai da ton tai trong bang theloai chua, neu chua thi them vao
        $theloai = $_POST['the_loai'];
        if ($mysqli->query("SELECT * FROM theloai WHERE ten_the_loai = \"$theloai\"")->num_rows == 0){
            $stm = $mysqli->prepare("INSERT INTO theloai (ten_the_loai) VALUES (?)");
            $stm->bind_param("s", $_POST['the_loai']);
            if (!$stm->execute()) echo "update theloai fail: " . $stm->error;
        }
    } else echo "<p style=\"color: red\">book information required</p>";
?>
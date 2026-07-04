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
        so luong: <input type="number" name="so_luong"><br>
        anh bia: <input type="file" name="anh_bia"><br>
        <input type="submit">
        <input type="reset">
    </form>
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
        isset($_POST['so_luong']) &&
        isset($_FILES['anh_bia'])
    ) {
        $stm = $mysqli->prepare(
            "INSERT INTO sach (ten_sach, tac_gia, nam_xb, nha_xb, nha_cung_cap, the_loai, so_luong, anh_bia) VALUES(?, ?, ?, ?, ?, ?, ?, ?)"
        );

        // luu anh vao csdl
        $image_data = file_get_contents($_FILES['anh_bia']['tmp_name']);
        $stm->bind_param(
            "ssisssis", 
            $_POST['ten_sach'], 
            $_POST['tac_gia'], 
            $_POST['nam_xb'], 
            $_POST['nha_xb'], $_POST['nha_cung_cap'], $_POST['the_loai'], $_POST['so_luong'], $image_data
        );

        if ($stm->execute()){
            echo "<h1>upload successfully</h1>";

            // xuat anh
            echo "<h1>image:</h1><br>";
            $img_encode = base64_encode($image_data);
            echo "<img src=\"data:image/jpeg;charset=utf8;base64,$img_encode\">";
        } else echo "upload fail: " . $stm->error;
        $stm->close();
    } else echo "<p style=\"color: red\">book information required</p>";
?>
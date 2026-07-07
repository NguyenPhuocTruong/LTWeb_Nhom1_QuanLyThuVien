<?php
    require_once("../mysqlConnect.php");
    $mysqli->select_db("library");

    // xu ly du lieu user nhap vao
    function test_input(string $data):string {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if (isset($_REQUEST['f'])){
        $keyword = test_input($_REQUEST['f']);
        $result = $mysqli->query("SELECT * FROM sach WHERE ten_sach LIKE '$keyword%'");
        if ($result->num_rows > 0){
            while ($row = $result->fetch_assoc()){
                $ten_sach = $row['ten_sach'];
                $ma_sach = $row['ma_sach'];
                echo "<a href=\"./sanpham.php?ma_sach=$ma_sach\">$ten_sach</a>";
            }
        }
    }
?>
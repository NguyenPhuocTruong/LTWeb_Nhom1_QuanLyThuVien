<?php
    require_once("../mysqlConnect.php");
    $mysqli->select_db("library");

    if (isset($_REQUEST['f'])){
        $keyword = $_REQUEST['f'];
        // $stm = $mysqli->prepare("SELECT * FROM sach WHERE ten_sach LIKE '%?%'");
        // $stm->bind_param("s", $keyword);
        // if ($stm->execute()){
        //     $result = $stm->get_result();
        //     if ($result->num_rows > 0){
        //         while ($row = $result->fetch_assoc()){
        //             $ten_sach = $row['ten_sach'];
        //             echo $ten_sach;
        //         }
        //     } else echo "";
        // } else echo "Lỗi trong lúc tìm tên sách: " . $stm->error;
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
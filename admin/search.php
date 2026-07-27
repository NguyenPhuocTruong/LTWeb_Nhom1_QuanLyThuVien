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
        if (strlen($keyword) == 0) $result = $mysqli->query("SELECT * FROM sach");
        else $result = $mysqli->query("SELECT * FROM sach WHERE ten_sach LIKE '%$keyword%'");
        if ($result->num_rows > 0){
            $stt = 1;
            while ($row = $result->fetch_assoc()){
                $ma_sach = $row['ma_sach'];
                // dinh dang lai ma sach
                $format_ma_sach = sprintf("%02d", $ma_sach);
                $ten_sach = $row['ten_sach'];
                $tac_gia = $row['tac_gia'];
                $namxb = $row['nam_xb'];
                $nhaxb = $row['nha_xb'];
                $nhacc = $row['nha_cung_cap'];
                $the_loai = $row['the_loai'];
                $quoc_gia = $row['quoc_gia'];
                $so_luong = $row['so_luong'];
                $mo_ta = $row['mo_ta'];
                echo "
                    <tr>
                        <td>

                            <button class=\"btn-edit\"><a href=\"addBooks.php?id=$ma_sach; ?>\"
                                    class=\"btn-edit\"
                                    style=\"text-decoration: none; display: inline-block;\">Sửa</a></button>

                            <button class=\"btn-delete\"><a
                                    href=\"deleteBooks.php?id=$ma_sach;\" class=\"btn-delete\"
                                    style=\"text-decoration: none; display: inline-block;\"
                                    onclick=\"return confirm('Bạn có chắc chắn muốn xóa sách $ten_sach (Mã sách: $ma_sach) ?');\">Xóa</a></button>

                        </td>
                        <td style=\"text-align: center; vertical-align: middle;\">
                            <span class=\"stt-highlight\">$stt</span>
                        </td>
                        <td style=\"text-align: center;\">$format_ma_sach</td>

                        <td>$ten_sach</td>

                        <td>$tac_gia</td>

                        <td>$nhaxb</td>

                        <td>$the_loai</td>

                        <td>$quoc_gia</td>

                        <td>$nhacc</td>

                        <td>$so_luong</td>

                        <td>$namxb</td>



                    </tr>
                ";
                $stt++;
            }
        } else {
            echo "<tr><td colspan='11' style='text-align: center; color: red; padding: 20px;'>Không tìm thấy quyển sách nào có tên chứa chữ \"$keyword\"</td></tr>";
        }
    }
?>
<?php
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

// $conn = mysqli_connect(
//         'localhost',
//         'root',
//         '1234',
//         'webmail50');

$conn = mysqli_connect(
        'localhost',
        'root',
        'durian12#',
        'webmail');

mysqli_set_charset($conn,'utf8');

//snmp mib값 가져올 제품
$sql = "SELECT * FROM bigfile WHERE insert_date = date_format(DATE_ADD(DATE_ADD(NOW(), INTERVAL -2 MONTH), INTERVAL -1 DAY),'%Y-%m-%d') AND delete_date IS NULL";
$result = mysqli_query($conn, $sql);
// $file_dir = "C:/xampp/ictmail/misc/upload/bigfile/";
$file_dir = "/var/www/html/misc/upload/bigfile/";
if (mysqli_num_rows($result) > 0) {
   while($row = mysqli_fetch_assoc($result)) {
   $filename = $row["filename"];
   $file_delete = @unlink($file_dir.$filename);
     if ($file_delete) {
       $del_date = date("Y-m-d");
       $file_seq = $row["seq"];
       $sql = "UPDATE bigfile SET delete_date = '{$del_date}' WHERE seq = {$file_seq}";
       $delete = mysqli_query($conn, $sql);
     }
   }
} else {
  echo "없습니다.";
}

mysqli_close($conn);

?>

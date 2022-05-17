<?php
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

$conn = mysqli_connect(
        'localhost',
        'root',
        'durian12#',
        'webmail');

mysqli_set_charset($conn,'utf8');
$mailaddress = $argv[1];
// $mailaddress = "bhkim@durianit.co.kr";
exec("whoami", $output1);
$mailaddress = $output1[0];
$sql = "INSERT INTO quota44 VALUES ('{$mailaddress}')";
$result = mysqli_query($conn, $sql);
exit;

$sql = "SELECT * FROM categori_mail WHERE userid = '{$mailaddress}'";
$result = mysqli_query($conn, $sql);

// $sql = "INSERT INTO quota44 VALUES ('{$mailaddress2}')";
// $result = mysqli_query($conn, $sql);
// exit;
if (mysqli_num_rows($result) > 0) {
  $user_explode = explode( '@', $mailaddress);
  $user_id = $user_explode[0];
  $user_domain = $user_explode[1];
  $path = "/home/vmail/{$user_domain}/{$user_id}/cur/";
  // exec("sudo find /home/vmail/durianit.co.kr/bhkim/cur/ -type f -cmin -60 | xargs grep -H 'From: '", $output3, $output4);
  exec("sudo find {$path} -type f -cmin -5", $output1);
  if (count($output1) > 0) {
    foreach ($output1 as $filename) {
        // echo $filename;
//       // $mailname = explode( '/', $filename);
//       // $mailnamecnt = count($mailname) -1;
//       // echo $mailname[$mailnamecnt];
//
//       // echo $filename;
      // echo "sudo grep 'From: ' {$filename}";
      // echo $filename;
      exec("sudo grep 'From: ' {$filename}", $output, $output6);
      // var_dump($output);
      // foreach ($output as $out) {
        // echo "<br>";
        // echo htmlspecialchars($out);
      // }
      $mail_addr = htmlspecialchars($output[0]);
      preg_match_all( "/[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}/i", $mail_addr, $matches );
      $match_mail = $matches[0][0];
      $match_domain = explode('@', $match_mail)[1];

      $sql = "SELECT *
FROM categori_mail
WHERE userid = '{$mailaddress}'
AND ((usertype = 0 AND address = '{$match_mail}') OR (usertype = 1 AND address = '{$match_domain}'))
ORDER BY usertype LIMIT 1";
// echo $sql;
      $search_classify = mysqli_query($conn, $sql);
      if (mysqli_num_rows($search_classify) > 0) {
        $row = mysqli_fetch_array($search_classify);
        $mailbox = "'.".$row["mailbox"]."'";
        $targetpath = "/home/vmail/{$user_domain}/{$user_id}/{$mailbox}/cur";
        exec("sudo mv {$filename} {$targetpath}", $output2, $err_msg);
        var_dump($output2);
        echo "<br>";
        var_dump($err_msg);
      } else {
        echo "없다";
      }

    }

  } else {
    echo "none2";
  }
} else {
  echo "테이블에 데이터가 없습니다.";
}
mysqli_close($conn); // 디비 접속 닫기
//snmp mib값 가져올 제품
// $sql = "INSERT INTO quota33 VALUES ('{$mailaddress}')";
// $result = mysqli_query($conn, $sql);
// mysqli_close($conn);
?>

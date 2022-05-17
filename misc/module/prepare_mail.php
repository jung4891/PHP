<?php
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';


$conn = mysqli_connect(
        'localhost',
        'root',
        'durian12#',
        'webmail');

mysqli_set_charset($conn,'utf8');
// $mailaddress = $argv[1];
// $mailaddress = "bhkim@durianit.co.kr";
$time = date("Y-m-d H:i:s");

$time_difference = date("Y-m-d H:i:s", strtotime("-1 minutes", strtotime($time)));
// echo $time_difference."<br>";


$sql = "SELECT * FROM categori_wait WHERE update_date IS NULL AND insert_date >= '{$time_difference}'";
// echo $sql."<br>";
$wait_list = mysqli_query($conn, $sql);
if (mysqli_num_rows($wait_list) > 0) {
  while ($row = mysqli_fetch_assoc($wait_list)){
    print_r($row);
    // echo "<br>";
    // exit;
    // $user_explode = explode( '@', $row['userid']);
    // $user_id = $user_explode[0];
    // $user_domain = $user_explode[1];
    $file_arr = get_filename($row['userid']);
    // echo "<br>";
    // print_r($file_arr);
    $check_file = classify_check($file_arr, $row['userid']);
    // var_dump($check_file);
    // echo "<br>";
    $update_sql = "UPDATE categori_wait SET update_date = NOW() WHERE seq = {$row['seq']}";
    mysqli_query($conn, $update_sql);
    // $path = "/home/vmail/{$user_domain}/{$user_id}/cur/";
    // $mail_list = array();
    // exec("sudo find {$path} -type f -cmin -5", $output1);
    // echo count($output1);

  }
}


mysqli_close($conn); // 디비 접속 닫기

function get_filename($user = "bhkim"){
  $user_explode = explode( '@', $user);
  $user_id = $user_explode[0];
  $user_domain = $user_explode[1];
  $path = "/home/vmail/{$user_domain}/{$user_id}/cur/";
  exec("sudo find {$path} -type f -cmin -1", $output1);
  $path = "/home/vmail/{$user_domain}/{$user_id}/new/";
  exec("sudo find {$path} -type f -cmin -1", $output2);
  $return_arr = array_merge($output1, $output2);

  return $return_arr;
}

function classify_check($file, $mailaddress){
  if (count($file) > 0) {
    $user_explode = explode( '@', $mailaddress);
    $user_id = $user_explode[0];
    $user_domain = $user_explode[1];
    $from_arr = array();
    foreach ($file as $filename) {
      // array_push($from_arr, $filename);
      // exec("sudo grep 'From: ' {$filename}", $output, $output6);
        $output8 = match_mail($filename);
        $mail_addr = htmlspecialchars($output8[0]);
        preg_match_all( "/[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}/i", $mail_addr, $matches );
        $match_mail = $matches[0][0];
        $match_domain = explode('@', $match_mail)[1];
        $connector = mysqli_connect(
                'localhost',
                'root',
                'durian12#',
                'webmail');

        mysqli_set_charset($connector,'utf8');
        $sql = "SELECT *
  FROM categori_mail
  WHERE userid = '{$mailaddress}'
  AND ((usertype = 0 AND address = '{$match_mail}') OR (usertype = 1 AND address = '{$match_domain}'))
  ORDER BY usertype LIMIT 1";
    $search_classify = mysqli_query($connector, $sql);
    if (mysqli_num_rows($search_classify) > 0) {
      $row = mysqli_fetch_array($search_classify);
      $mailbox = "'.".$row["mailbox"]."'";
      $targetpath = "/home/vmail/{$user_domain}/{$user_id}/{$mailbox}/cur";
      // $grep = "sudo mv {$filename} {$targetpath}";
      // array_push($from_arr, $grep);
      exec("sudo mv {$filename} {$targetpath}", $output2, $err_msg);
      // array_push($from_arr, $grep);

    } else {
      array_push($from_arr, "없다");
    }


    }
  }
  return $from_arr;
}

function match_mail($filename){
  exec("sudo grep 'From: ' {$filename}", $output, $output6);
  return $output;
}

//snmp mib값 가져올 제품
// $sql = "INSERT INTO quota33 VALUES ('{$mailaddress}')";
// $result = mysqli_query($conn, $sql);
// mysqli_close($conn);


?>

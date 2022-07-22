<?php
$SHA_PASSWD = base64_encode(hash('sha512',$_POST['PASSWD'], true));
header('Content-Type: text/html; charset=UTF-8');

$data = array(
$USERID=iconv('utf8', 'euckr', $_POST['USERID']),
$USERNAME=iconv('utf8', 'euckr',$_POST['USERNAME']),
$PASSWD=iconv('utf8', 'euckr',$SHA_PASSWD),
$AGREE_CHECK=iconv('utf8', 'euckr',$_POST['AGREE_CHECK'])
);

$AGREE_CHECK=1;

$conn = mysqli_connect(
  '192.168.0.100',
  'durianit',
  'durian0529',
  'KIC_USER');

$conn->query("SET NAMES euckr");

$pw_check_sql = "select * from dictionary where '{$_POST['PASSWD']}' like concat('%',word,'%')"; 
$pw_check_result = mysqli_query($conn, $pw_check_sql);
$pwRow = mysqli_fetch_array($pw_check_result);

if(count($pwRow) >= 1){
  echo "<script>alert('일반 사전에 등록 되어있는 단어는 비밀번호로 사용 하실 수 없습니다.');history.go(-1);</script>";
}else{
  $duplicate_check_sql = "select * from USERS where USERID = '{$USERID}'";
$duplicate_check_result = mysqli_query($conn, $duplicate_check_sql);
$row = mysqli_fetch_array($duplicate_check_result);

if(count($row) >= 1){
  echo "<script>alert('존재하는 아이디 입니다.');history.go(-1);</script>";
}else{
  $MACADDR=strtolower($_POST['MAC1']);
  $MACADDR.=":";
  $MACADDR.=strtolower($_POST['MAC2']);
  $MACADDR.=":";
  $MACADDR.=strtolower($_POST['MAC3']);
  $MACADDR.=":";
  $MACADDR.=strtolower($_POST['MAC4']);
  $MACADDR.=":";
  $MACADDR.=strtolower($_POST['MAC5']);
  $MACADDR.=":";
  $MACADDR.=strtolower($_POST['MAC6']);
  $MACADDR = iconv('utf8', 'euckr', $MACADDR);

  $sql = "insert into USERS (USERID,USERNAME,PASSWD,AGREE_CHECK,MAC_ADDR) values ('".$USERID."','".$USERNAME."','".$PASSWD."','".$AGREE_CHECK."','".$MACADDR."')";

  $result=mysqli_query($conn, $sql);



  // $conn2 = mysqli_connect(
  //   '172.16.127.201',
  //   'durian',
  //   'durian123',
  //   'anyclick_nac');
  
  // $conn2->query("set names euckr");
  if($result){
    $add = iconv('utf8', 'euckr','등록');
    $user_add = iconv('utf8', 'euckr','회원등록');
    // $sql3 = "insert into user_tbl (user_id,pwd,name,status,level,type,one_x_use,pwd_life_time,pwd_fail_count,eap_algo,hr_sync,user_option,pwd_to_change,simultaneous_use,mac_check,ssl_pwd_fail_count) values ('{$USERID}','','{$USERNAME}','A',2,'R','Y','G',0,0,'I',0,'N','0','D',0)";
    // $result3 = mysqli_query($conn2, $sql3);
    // $sql4= "insert into user_mac_tbl values ('".$USERID."','".$MACADDR."')";
    // $result4=mysqli_query($conn2, $sql4);
    $sql2 ="insert into LOG (USERID,USERNAME,WORKERNAME,STATUS,work_contents) values ('{$USERID}','{$USERNAME}','{$USERNAME}','{$add}','{$user_add}')";
    $result2 = mysqli_query($conn, $sql2);
    if($result2){
      echo "<script>alert('등록되었습니다.');location.href='{$_SERVER['DOCUMENT-ROOT']}index.php';</script>";
    }else{
      echo "로그 에러";
    }
  }else{
    echo "<script>alert('등록 실패');history.go(-1);</script>";
  }
  // $conn2->close();
}
$conn->close();
}
?>

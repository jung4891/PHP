<?php
$SHA_PASSWD = base64_encode(hash('sha512', $_POST['PASSWD'], true));
header('Content-Type: text/html; charset=UTF-8');

$conn = mysqli_connect(
  '192.168.0.100',
  'durianit',
  'durian0529',
  'KIC_USER');

$conn->query("SET NAMES euckr");

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
  $seq = iconv('utf8', 'euckr', $_POST['seq']);

  $sql = "update USERS set MAC_ADDR='{$MACADDR}' where SEQ = {$seq} ";

  $result=mysqli_query($conn, $sql);

  if($result){
      echo '<script>alert("수정되었습니다.");opener.parent.location.reload();self.close();</script>';
  }else{
      echo '<script>alert("정상적으로 처리 되지 않았습니다.")self.close();</script>';
  }

$conn->close();
?>

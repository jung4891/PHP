<?php
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';


$conn = mysqli_connect(
        'localhost',
        'root',
        'durian12#',
        'webmail');

mysqli_set_charset($conn,'utf8');
$uid = "bhkim@durianit.co.kr";
$sql = "SELECT * FROM categori_mail WHERE sendtype = 0 AND userid = '{$uid}'";
$check_classify = mysqli_query($conn, $sql);

if (mysqli_num_rows($check_classify) > 0) {
  $sql = "SELECT uid, pkey FROM aes_key WHERE uid = '{$uid}'";
  $get_pkey = mysqli_query($conn, $sql);
  $pkey = mysqli_fetch_assoc($get_pkey);
  $encryp_password = $pkey["pkey"];
  $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
  $key = "durian12#";
  $key = substr(hash('sha256', $key, true), 0, 32);
  $decrypted = openssl_decrypt(base64_decode($encryp_password), 'aes-256-cbc', $key, 1, $iv);
  $mailserver = "192.168.0.100";
  $host = "{" . $mailserver . ":143/imap/novalidate-cert}";
  $mails = @imap_open($host, $uid, $decrypted);
  $mailno_arr = imap_sort($mails, SORTDATE, 1, 0);
  var_dump($mailno_arr);
}

mysqli_close($conn); // 디비 접속 닫기
// $sql = "SELECT * FROM categori_wait WHERE update_date IS NULL AND insert_date >= '{$time_difference}'";
// $sql = "SELECT uid, pkey FROM aes_key WHERE uid = '{$uid}'";
// $encryp_password = $this->M_account->mbox_conf($_SESSION['userid']);
// $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
// $key = "durian12#";
// $key = substr(hash('sha256', $key, true), 0, 32);
// $decrypted = openssl_decrypt(base64_decode($encryp_password), 'aes-256-cbc', $key, 1, $iv);


 ?>

<?php
$host ='192.168.0.100';
$user = 'durianit';
$pw = 'durian0529';
$dbName="KIC_USER";

$dbConnect = new mysqli($host,$user,$pw,$dbName);
$dbConnect->set_charset('utf8');

if(mysqli_connect_errno()){
    echo "디비 접속 실패";
}else{
    echo "디비접속성공";
}
?>

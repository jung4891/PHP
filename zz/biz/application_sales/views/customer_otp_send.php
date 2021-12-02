<?php
//메일 보낼 seq, 수신인 mailaddress
$otp = $_POST['otp'];
$to = str_replace(';','',$_POST['loginMail']);

//메일 제목 작성
$subject = "사용자 인증 번호 발송 메일입니다.";
$subject = "=?EUC-KR?B?".base64_encode(iconv("UTF-8","EUC-KR",$subject))."?=\r\n";

//메일 본문 작성
$html_code =$otp;
$message = "$html_code";

$headers = "From: =?utf-8?B?".base64_encode("support@durianit.co.kr")."?= <support@durianit.co.kr> \n";
$headers .= 'MIME-Version: 1.0' . "\r\n"; 
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
$headers .= 'Content-Transfer-Encoding: quoted-printable';
// $headers .= 'Message-ID: <' . $i . ">";	

//메일 보내기
$result = mail($to, $subject, $message, $headers);

if($result){
    echo "<script>alert('정상적으로 처리되었습니다.');window.close();</script>";
} else { 
        echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.')</script>";
}
$headers = "";
?>

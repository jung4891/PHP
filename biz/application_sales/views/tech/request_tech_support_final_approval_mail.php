<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
header("Content-Type:text/html;charset=utf-8");
//메일 보낼 seq, 수신인 mailaddress
?>
<body>
<?php

if(strpos($seq,',') === false){
    $filter=array();
    $filter[0] = $view_val;
    $view_val = $filter;
}

$addr = '';
$txt ='';
$txt .= "<br><br>
<div width=730 style='max-width:550pt;'>
<table border=1 frame=void cellpadding=0 cellspacing=1 width=730 style='border-collapse:collapse;table-layout:fixed;width:550pt;'>";
for($i=0; $i < count($view_val); $i++){
  // var_dump($view_val[$i]);
    $file = "X";
    if($view_val[$i]['file_change_name'] != '' && $view_val[$i]['file_change_name'] != null){
        $file="O";
    }
    $txt .= "
    <tr height=30 width='100%' align='center'>
    <td style='background:#D9D9D9;width:10%;'>고객사</td>
    <td style='width:10%;'>{$view_val[$i]['customer_company']}</td>
    <td style='background:#D9D9D9;width:10%;'>사업장명</td>
    <td style='width:10%;'>{$view_val[$i]['workplace_name']}</td>
    <td style='background:#D9D9D9;width:10%;'>지원유형</td>
    <td style='width:15%;'>{$view_val[$i]['support_type']}</td>
    <td style='background:#D9D9D9;width:10%;'>설치완료일</td>
    <td style='width:15%;'>{$view_val[$i]['installation_date']}</td>
    <td style='width:10%;' rowspan='2'><a href='http://support.durianit.co.kr/index.php/account/cooperative_login_view?seq={$view_val[$i]['seq']}'>상세보기</a></td></tr>
    <tr height=30 width='100%' align='center'>
    <td style='background:#D9D9D9;width:10%;'>구분</td>
    <td style='width:10%;'>{$view_val[$i]['sortation']}</td>
    <td style='background:#D9D9D9;width:10%;'>장비</td>
    <td style='width:15%;'>{$view_val[$i]['produce']}</td>
    <td style='background:#D9D9D9;width:10%;'>첨부파일</td>
    <td style='width:10%;'>{$file}</td>
    <td style='background:#D9D9D9;width:10%;'>기술담당자</td>";
    if( $view_val[$i]['insert_date'] < '2021-06-09 18:00:00'){
      $txt .= "<td style='width:15%;'>김갑진,김가람</td>";
    }else{
      $txt .= "<td style='width:15%;'>김갑진,신진선</td>";
    }
    // "<td style='width:15%;'>김갑진,신진선</td>"
    $txt .= "</tr>
    <tr height=30 style='border:none;'><td colspan=9 style='border:none'></td></tr>";
}

$txt.= "<tr style='border:none;'><td colspan=9 style='border:none;'><img src='http://support.durianit.co.kr/misc/img/mail_img.png' alt='' width=800 style='display:block;width:100%;max-width:100%;'></td></tr>
        </table>
        </div>";

//메일 제목 작성
$month = substr($view_val[0]['installation_date'], 5, 2);
$subject = "두리안정보기술에서 {$month}월 설치지원내역 송부드립니다.";
$subject = "=?EUC-KR?B?".base64_encode(iconv("UTF-8","EUC-KR",$subject))."?=\r\n";

//메일 본문 작성
$html_code = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
	<title>두리안정보기술센터-Tech Center</title>
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
</head>
<body>
        안녕하세요 두리안정보기술입니다.<br>
        {$view_val[0]['customer_company']} 유통망(협력업체) 및 과금망(구내통신망)
        {$month}월 최종 승인 된 설치 지원내역 확인 부탁드립니다.

        {$txt}
</body>
</html>";

//영업담당자도 추가
// var_dump($manager);
for($i=0; $i<count($manager); $i++){
    $addr .= ','.$manager[$i]['user_email'];
}
$to = trim($addr,',');
$message = $html_code;
$headers = "From: =?utf-8?B?".base64_encode("support@durianit.co.kr")."?= <support@durianit.co.kr> \n";
$headers .= 'Cc: tech@durianit.co.kr' . "\r\n";
// $headers .= "Bcc: sylim@durianit.co.kr" ."\r\n";
$headers .= 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
$headers .= "Content-Transfer-Encoding: base64\r\n";
$headers .= 'Message-ID: <>';

//메일 보내기
$result = mail($to, $subject, chunk_split(base64_encode($message)), $headers);

if($result){
    echo "<script>alert('협력처 기술,영업 담당자에게 메일이 보내졌습니다.');</script>;";
} else {
    echo "<script>alert('협력처 기술,영업 담당자에게 메일이 정상적으로 보내지지 않았습니다.')</script>";
}

$headers = "";
echo "<script>location.href='".site_url()."/tech/tech_board/request_tech_support_list';</script>";
?>
</body>
</html>

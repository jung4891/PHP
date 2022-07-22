<?php
include $this->input->server('DOCUMENT_ROOT') . "/include/base.php";
include $this->input->server('DOCUMENT_ROOT') . "/include/customer_top.php";
header("Content-Type:text/html;charset=utf-8");
//메일 보낼 seq, 수신인 mailaddress
?>
<style>
</style>
<body>
<script>
    function mailSendYN(seq,check){
        $.ajax({
            type: "POST",
            cache: false,
            url: "<?php echo site_url(); ?>/ajax/mailSendCheck",
            dataType: "json",
            async: false,
            data: {
                seq : seq,
                check : check,
                check_value : 'Y'
            },
            success: function (data){
            }
        });
    }
</script>

<?php
$seq = $_GET['seq'];
$addr = '';
$txt ='';
$check = '';
$installation_request_date='';
if($view_val['installation_request_date'] == "0000-00-00"){
    $installation_request_date = "일정협의";
}else{
    $installation_request_date = $view_val['installation_request_date'];
}

$txt .= "<div style='margin-top:20px'>
<table border=1 cellpadding=1 cellspacing=1 width=730 style='border-collapse:collapse;table-layout:fixed;width:550pt'>
<tr height=30 width='100%' align='center'>
<td style='background:#D9D9D9;width:10%;'>고객사</td>
<td style='width:10%;'>{$view_val['customer_company']}</td>
<td style='background:#D9D9D9;width:10%;'>사업장명</td>
<td style='width:10%;'>{$view_val['workplace_name']}</td>
<td style='background:#D9D9D9;width:10%;'>주소</td>
<td style='width:15%;'>{$view_val['workplace_address']}</td>
<td style='background:#D9D9D9;width:10%;'>설치요청일</td>
<td style='width:15%;'>{$installation_request_date}</td>
<td style='width:10%;' rowspan='2'><a href='http://support.durianit.co.kr/index.php/account/cooperative_login_view?seq={$seq}'>상세보기</a></td></tr>
<tr height=30 width='100%' align='center'>
<td style='background:#D9D9D9;width:10%;'>구분</td>
<td style='width:10%;'>{$view_val['sortation']}</td>
<td style='background:#D9D9D9;width:10%;'>지원유형</td>
<td style='width:10%;'>{$view_val['support_type']}</td>
<td style='background:#D9D9D9;width:10%;'>장비</td>
<td style='width:15%;'>{$view_val['produce']}</td>
<td style='background:#D9D9D9;width:10%;'>기술담당자</td>
<td style='width:15%;'>김갑진,박유석</td>
</tr>
</table>
</div>
<br>
<br>
<div><img src='http://support.durianit.co.kr/misc/img/mail_img.png' alt='' width=800 style='display:block;width:800;max-width:800;'>
</div>";


//메일 제목 작성
$subject = "두리안정보기술에서 기술지원요청 드립니다.";
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
        아래 {$view_val['sortation']} {$view_val['workplace_name']} {$view_val['support_type']} 확인 부탁드립니다.
 
		{$txt} 
</body>
</html>";

if($view_val['manager_mail_send'] == 'N'){
    if($view_val['cooperative_email'] != ''){
        $check = 'manager_mail_send';
        $addr = $view_val['cooperative_email'];
        $to = $addr;
        $message = $html_code;
        $headers = "From: =?utf-8?B?".base64_encode("support@durianit.co.kr")."?= <support@durianit.co.kr> \n";
        $headers .= 'Cc: tech@durianit.co.kr' . "\r\n";
        $headers .= 'MIME-Version: 1.0' . "\r\n"; 
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= "Content-Transfer-Encoding: base64\r\n";
        $headers .= 'Message-ID: <>';	

        //메일 보내기
        $result = mail($to, $subject, chunk_split(base64_encode($message)), $headers);

        if($result){
            echo("<script language='javascript'>mailSendYN({$seq},'{$check}');</script>");
            echo "<script>alert('협력처 담당자에게 메일이 보내졌습니다.');</script>;";
        } else { 
            echo "<script>alert('협력처 담당자에게 메일이 정상적으로 보내지지 않았습니다.')</script>";
        }
        $headers = "";
    }
    if($view_val['engineer_mail_send'] == 'N'){
        if($view_val['engineer_email'] != ''){
            $check = 'engineer_mail_send';
            $addr = $view_val['engineer_email'];
            $to = $addr;
            $message = $html_code;
            $headers = "From: =?utf-8?B?".base64_encode("support@durianit.co.kr")."?= <support@durianit.co.kr> \n";
            $headers .= 'Cc: tech@durianit.co.kr' . "\r\n";
            $headers .= 'MIME-Version: 1.0' . "\r\n"; 
            $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
            $headers .= "Content-Transfer-Encoding: base64\r\n";
            $headers .= 'Message-ID: <>';	
    
            //메일 보내기
            $result = mail($to, $subject, chunk_split(base64_encode($message)), $headers);
    
            if($result){
                echo("<script language='javascript'>mailSendYN({$seq},'{$check}');</script>");
                echo "<script>alert('협력처 엔지니어에게 메일이 보내졌습니다.');</script>";
            } else { 
                echo "<script>alert('협력처 엔지니어에게 메일이 정상적으로 보내지지 않았습니다.')</script>";
            }
            $headers = "";  
        }
    }
    // echo "<script>location.href='".site_url()."/tech_board/request_tech_support_list';</script>";
}else{
    if($view_val['engineer_mail_send'] == 'N'){
        if($view_val['engineer_email'] != ''){
            $check = 'engineer_mail_send';
            $addr = $view_val['engineer_email'];
            $to = $addr;
            $message = $html_code;
            $headers = "From: =?utf-8?B?".base64_encode("support@durianit.co.kr")."?= <support@durianit.co.kr> \n";
            $headers .= 'Cc: tech@durianit.co.kr' . "\r\n";
            $headers .= 'MIME-Version: 1.0' . "\r\n"; 
            $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
            $headers .= "Content-Transfer-Encoding: base64\r\n";
            $headers .= 'Message-ID: <>';	
    
            //메일 보내기
            $result = mail($to, $subject, chunk_split(base64_encode($message)), $headers);
    
            if($result){
                echo("<script language='javascript'>mailSendYN({$seq},'{$check}');</script>");
                echo "<script>alert('협력처 엔지니어에게 메일이 보내졌습니다.');</script>";
            } else { 
                echo "<script>alert('협력처 엔지니어에게 메일이 정상적으로 보내지지 않았습니다.')</script>";
            }
            $headers = "";  
        }
    }
}
echo "<script>location.href='".site_url()."/tech_board/request_tech_support_view?seq={$seq}&mode=view';</script>";
?>
</body>
</html>


<?php
$seq = $_GET['seq'];

//메일 제목 작성
$subject = "[".$view_val['customer']."]고객님 두리안정보기술에서 보내어드리는 기술지원보고서 입니다.";
$subject = "=?EUC-KR?B?".base64_encode(iconv("UTF-8","EUC-KR",$subject))."?=\r\n";

//수신인 address
$to = trim($view_val['manager_mail'],';');
$to = str_replace(';',',',$to);


$txt ='';
$income_time = substr($view_val['income_time'],0,10);


	$txt .= "<div style='margin-top:10px'><br>";
	$txt .= " <table border=0 cellpadding=0 cellspacing=0 width=730 style='border-collapse:collapse;table-layout:fixed;width:550pt'>";
	$txt .= "<col width=91 height=50 style='mso-width-source:userset;mso-width-alt:864;width:68pt;height:30pt;'>
	<col width=91 height=50 style='mso-width-source:userset;mso-width-alt:960;width:68pt;height:30pt;'>
	<col width=91 height=50 style='mso-width-source:userset;mso-width-alt:672;width:68pt;height:30pt;'>
	<col width=91 height=50 style='mso-width-source:userset;mso-width-alt:864;width:68pt;height:30pt;'>
	<col width=91 height=50 style='mso-width-source:userset;mso-width-alt:416;width:68pt;height:30pt;'>
	<col width=91 height=50 style='mso-width-source:userset;mso-width-alt:960;width:68pt;height:30pt;'>
	<col width=91 height=50 style='mso-width-source:userset;mso-width-alt:96;width:68pt;height:30pt;'>
	<col width=91 height=50 style='mso-width-source:userset;mso-width-alt:768;width:68pt;height:30pt;'>";
	
	$firstProduce = explode(',',$view_val['produce']);
	$produceCount = count($firstProduce)-1; //첫번째 제품 제외한 갯수
	$firstProduce = $firstProduce[0];
	if($produceCount == 0){
		$produceName = $firstProduce;
	}else{
		$produceName = $firstProduce." 외 ".$produceCount."식";
	}  

	$txt .= "<tr height=50 style='mso-height-source:userset;height:30pt;'>
		<td style='text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;'>고객명</td>
		<td style='text-align:center;vertical-align:middle;border:.5pt solid windowtext;'>{$view_val['customer']}</td>
		<td style='text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;'>제품명</td>
		<td colspan=2 width=123 style='text-align:center;vertical-align:middle;border:.5pt solid windowtext;'>{$produceName}</td>
		<td style='text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;'>작성자</td>
		<td style='text-align:center;vertical-align:middle;border:.5pt solid windowtext;'>{$view_val['writer']}</td>";
	if($_GET['pdf_type'] == 1){
		$txt .= "<td rowspan=2 style='text-align:center;vertical-align:middle;border:.5pt solid windowtext;'><a href='http://support.durianit.co.kr/index.php/account/customer_login?".base64_encode("seq=".$seq)."'>상세보기 및 서명</a></td>";
	}
	
	$txt .= "</tr>
	<tr height=50 style='mso-height-source:userset;height:30pt;'>
		<td style='text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;'>작업명</td>
		<td colspan=4 style='text-align:center;vertical-align:middle;border:.5pt solid windowtext;'>{$view_val['subject']}</td>
		<td style='text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;'>작업일</td>
		<td style='text-align:center;vertical-align:middle;border:.5pt solid windowtext;'>{$income_time}</td>
	</tr>
	<tr height=20>
	 <td></td>
	</tr>
	<tr>
		<td colspan=8>
		<img src='http://support.durianit.co.kr/misc/img/mail_img.png' alt='' width=800 style='display:block;width:100%;max-width:100%;'>
		</td>
	</tr>
	</table>
	</div>";

	if($_GET['pdf_type'] == 1){//상세보기 및 서명 전송
		//메일 본문 작성
		$html_code = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
		<html xmlns='http://www.w3.org/1999/xhtml'>
		<head>
			<title>두리안정보기술센터-Tech Center</title>
			<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
		</head>
		<body>
				두리안정보기술의 고객지원사업부 입니다.<br>
				고객님의 사이트에 아래와 같은 기술지원이 이루어졌습니다.<br>
				상세보기 및 서명을  클릭하여 내용을 확인하시고 실제와 다르거나 만족스럽지 못한 부분이 있으시면 메일을 회신하여 주십시요.<br>
				고객님의 의견을 최대한 적극 반영하도록 노력 하겠습니다.<br>
				고객을 최선으로 모시는 기업 두리안정보기술이 되겠습니다.  
				$txt 
		</body>
		</html>";

		$message = $html_code;

		$headers = "From: =?utf-8?B?".base64_encode("support@durianit.co.kr")."?= <support@durianit.co.kr> \n";
		$headers .= 'Cc: tech@durianit.co.kr' . "\r\n";
		$headers .= 'MIME-Version: 1.0' . "\r\n"; 
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$headers .= "Content-Transfer-Encoding: base64\r\n";
		// $headers .= 'Message-ID: <' . $i . ">";	

		$result = mail($to, $subject, chunk_split(base64_encode($message)), $headers);
	}else{//pdf 전송
		exec("/usr/local/bin/wkhtmltopdf --encoding UTF-8 -L 19mm -B 10mm  --footer-html http://tech.durianit.co.kr/index.php/tech_board/tech_doc_pdf_logo?seq={$seq} http://tech.durianit.co.kr/index.php/tech_board/tech_doc_pdf?seq={$seq} /var/www/html/stc/misc/upload/tech/tech/techpdf.pdf");

        //첨부 파일을 가져오자
            $boundary = "----" . uniqid("part");
            $attachment = "/var/www/html/stc/misc/upload/tech/tech/techpdf.pdf";
            $filename = $view_val['customer']."_기술지원보고서".$income_time.".pdf";
            $content = file_get_contents($attachment);
			$content = chunk_split(base64_encode($content));
			
        //메일 본문 작성
        $html_code = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
        <html xmlns='http://www.w3.org/1999/xhtml'>
        <head>
            <title>두리안정보기술센터-Tech Center</title>
            <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
        </head>
        <body>
                두리안정보기술의 고객지원사업부 입니다.<br>
                {$income_time} 고객님의 사이트에 아래와 같은 기술지원이 이루어졌습니다.<br>
                첨부파일을 확인하시고 실제와 다르거나 만족스럽지 못한 부분이 있으시면 메일을 회신하여 주십시요.<br>
                고객님의 의견을 최대한 적극 반영하도록 노력 하겠습니다.<br>
				고객을 최선으로 모시는 기업 두리안정보기술이 되겠습니다.
				$txt 
            </body>
		</html>";

		$message = $html_code;
		
		$headers = "From: =?utf-8?B?".base64_encode("support@durianit.co.kr")."?= <support@durianit.co.kr> \n";
		$headers .= 'Cc: tech@durianit.co.kr' . "\r\n";
		$headers .= 'MIME-Version: 1.0' . "\r\n";
		$headers .= "Content-Type: Multipart/mixed; boundary=\"$boundary\"";	
		$body = "This is a multi-part message in MIME format.\r\n\r\n"."--$boundary\r\n"."Content-Type: text/html; charset=UTF-8\r\n"."Content-Transfer-Encoding: base64\r\n\r\n".chunk_split(base64_encode($message))."\r\n"."--$boundary\r\n"; 
		$body .="Content-Type: application/octet-stream; charset=UTF-8\r\n name=\"".$filename."\"\r\n"."Content-Transfer-Encoding: base64\r\n"."Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n".$content."\r\n\r\n"."--$boundary--"; //3
		$strto = explode("@", $to);

		$result = mail($to, $subject, $body, $headers);
		unlink("/var/www/html/stc/misc/upload/tech/tech/techpdf.pdf"); //파일삭제
	}

if($result){
	echo "<script>alert('정상적으로 처리되었습니다.');location.href='".site_url()."/tech_board/tech_doc_list';</script>";
} else { 
	echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
}
$headers = "";

?>

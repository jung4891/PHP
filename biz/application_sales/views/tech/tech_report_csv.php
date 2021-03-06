<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
header("Content-Type:text/html;charset=utf-8");

$csvLoad = $view_val['manager_mail'];
$csvArray = explode(";",$csvLoad);
$tmp = explode(';;', $view_val['work_process_time']);
$process_txt =  explode(';;', $view_val['work_process']);

$arr_manager = explode(';',$view_val['customer_manager']);

//메일 제목 작성
$subject = "[".$view_val['customer']."]고객님 두리안정보기술에서 보내어드리는 ".substr($view_val['income_time'], 0, 10)." 기술지원보고서 입니다.";
$subject = "=?EUC-KR?B?".base64_encode(iconv("UTF-8","EUC-KR",$subject))."?=\r\n";


//제품명 가져오는거
$produce_txt="<ul>";

$produce= explode(",",$view_val['produce']);
$version= explode(",",$view_val['version']);
$hardware= explode(",",$view_val['hardware']);
$license= explode(",",$view_val['license']);
$host = array();
if(trim($view_val['host']) == "" || $view_val['host'] == null){//host가 후에 생겨서 빈값인 경우
	for($i=0; $i<count($produce); $i++){
		$host[$i]= '';
	}
}else{
	$host = explode(",",$view_val['host']);
}
for($i=1; $i<=count($produce); $i++){
	$produce_txt.='<li id="li'.$i.'"><span id="produce'.$i.'" class="click_produce" ><span class="produce">'.$produce[($i-1)].'</span> / <span class="host">'.$host[($i-1)].'</span> / <span class="version">'.$version[($i-1)].'</span> / <span class="hardware">'.$hardware[($i-1)].'</span> / <span class="license">'.$license[($i-1)].'</span></span></li>';
}
$produce_txt.= "</ul>";



//첨부 파일을 가져오자
if($view_val['file_changename'] != '' && $view_val['file_realname'] !=''){
	$boundary = "----" . uniqid("part");
	$attachment = "/var/www/html/stc/misc/upload/tech/tech/{$view_val['file_changename']}";
	$filename = $view_val['file_realname'];
	$content = file_get_contents($attachment);
	$content = chunk_split(base64_encode($content));
}


//지원 내용 만들기
$tmp_doc_body = "";
for($j=0;$j<count($process_txt)-1;$j++){
	$tmp_2 = "";
	$time = explode('-',$tmp[$j]);
	$tmp_2.= "<tr height=90 style='mso-height-source:userset;min-height:67.5pt'>
	<td colspan=2 style='text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;'>{$time[0]}</td>
	<td colspan=2 style='text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;'>{$time[1]}</td>
	<td colspan=21 style='border-left:none;text-align:left;vertical-align:middle;border:.5pt solid windowtext;'>
	{$process_txt[$j]}</td></tr>";
	$tmp_doc_body.=$tmp_2;
}


$customer_code="";
$tmp_email="email@durianit.co.kr";
for($i=0;$i<count($arr_manager);$i++){

        if($arr_manager[$i]!=""){

	$customer_code.="<tr height=22 style='height:16.5pt'><td colspan=4 height=22 style='height:16.5pt;text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;'>담당자명</td><td colspan=9 style='border-left:none;text-align:center;vertical-align:middle;border:.5pt solid windowtext;'>".$arr_manager[$i]."</td><td colspan=3 style='border-left:none;text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;'>이메일</td><td colspan=9 style='border-left:none;text-align:center;vertical-align:middle;border:.5pt solid windowtext;'>".$csvArray[$i]."</td></tr>";

  }
}

if($view_val['sign_consent']=="true"){
	$durianSign = "<img src='http://support.durianit.co.kr/misc/img/{$view_val['writer']}.png' alt='' width=53 height=53 style='display:block;width:100%;max-width:100%;'>";
}else{
	$durianSign = "";
}


//메일 본문 작성
$html_code = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
	<title>두리안정보기술센터-Tech Center</title>
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
</head>
<body>
		두리안정보기술의 고객지원사업부 입니다.<br>
	 	".substr($view_val['income_time'], 0, 10)." 고객님의 사이트에 아래와 같은 기술지원이 이루어졌습니다.<br>
		내용을 확인하시고 실제와 다르거나 만족스럽지 못한 부분이 있으시면 메일을 회신하여 주십시요.<br>
		고객님의 의견을 최대한 적극 반영하도록 노력 하겠습니다.<br>
		고객을 최선으로 모시는 기업 두리안정보기술이 되겠습니다.<br><br><br>
	<div style='width:550pt'>
		<table border=0 cellpadding=0 cellspacing=0 width=730 style='border-collapse:collapse;table-layout:fixed;>
		<col width=27 span=3 style='mso-width-source:userset;mso-width-alt:864;
		width:20pt'>
		<col width=30 span=5 style='mso-width-source:userset;mso-width-alt:960;
		width:23pt'>
		<col width=21 style='mso-width-source:userset;mso-width-alt:672;width:16pt'>
		<col width=27 span=2 style='mso-width-source:userset;mso-width-alt:864;
		width:20pt'>
		<col width=13 style='mso-width-source:userset;mso-width-alt:416;width:10pt'>
		<col width=30 span=4 style='mso-width-source:userset;mso-width-alt:960;
		width:23pt'>
		<col width=3 style='mso-width-source:userset;mso-width-alt:96;width:2pt'>
		<col width=24 span=2 style='mso-width-source:userset;mso-width-alt:768;
		width:18pt'>
		<col width=35 span=2 style='mso-width-source:userset;mso-width-alt:1120;
		width:26pt'>
		<col width=65 style='mso-width-source:userset;mso-width-alt:2080;width:49pt'>
		<col width=35 span=3 style='mso-width-source:userset;mso-width-alt:1120;
		width:26pt'>
		<tr>   </tr>
		<tr>   </tr>
		<tr height=15 style='mso-height-source:userset;height:11.25pt'>
			<td colspan=3 rowspan=2 height=30 width=81 style='height:22.5pt;width:60pt;text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;'><a name='RANGE!A1:Y19'>고객명</a></td>
			<td colspan=6 rowspan=2 style='text-align:center;vertical-align:middle;border:.5pt solid windowtext;word-break:break-all;'>".$view_val['customer']."</td>
			<td colspan=3 rowspan=2 width=67 style='width:50pt;text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;'>작업명</td>
			<td colspan=5 rowspan=2 width=123 style='width:94pt;text-align:center;vertical-align:middle;border:.5pt solid windowtext;word-break:break-all;'>".$view_val['work_name']."</td>
			<td colspan=2 rowspan=2 width=48 style='width:36pt;text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;'>고객사</td>
			<td colspan=3 rowspan=2 width=135 style='width:101pt;text-align:center;vertical-align:middle;border:.5pt solid windowtext;word-break:break-all;'>".$view_val['customer']."</td>
			<td colspan=3 rowspan=2 width=105 style='width:78pt;text-align:center;vertical-align:middle;border:.5pt solid windowtext;word-break:break-all;'>두리안정보기술</td>
		</tr>
		<tr height=15 style='mso-height-source:userset;height:11.25pt'>
		</tr>
		<tr height=14 style='mso-height-source:userset;height:10.5pt'>
			<td colspan=3 rowspan=2 height=28 style='height:21.0pt;text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;'>문서번호</td>
			<td colspan=6 rowspan=2 style='text-align:center;vertical-align:middle;border:.5pt solid windowtext;'>DUIT-TECH-08-20-01-001</td>
			<td colspan=3 rowspan=2 style='text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;'>작성자</td>
			<td colspan=5 rowspan=2 style='text-align:center;vertical-align:middle;border:.5pt solid windowtext;'>".$view_val['writer']."</td>
			<td colspan=2 rowspan=4 style='text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;'>확인</td>
			<td colspan=3 rowspan=4 style='text-align:center;vertical-align:middle;border:.5pt solid windowtext;'></td>
			<td colspan=3 rowspan=4 style='text-align:center;vertical-align:middle;border:.5pt solid windowtext;'>{$durianSign}</td>

		</tr>
		<tr height=14 style='mso-height-source:userset;height:10.5pt'>
		</tr>
		<tr height=14 style='mso-height-source:userset;height:10.5pt'>
			<td colspan=3 rowspan=2 height=28 style='height:21.0pt;text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;'>개정버전</td>
			<td colspan=6 rowspan=2 style='text-align:center;vertical-align:middle;border:.5pt solid windowtext;'>V1.0</td>
			<td colspan=3 rowspan=2 style='text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;'>날짜</td>
			<td colspan=5 rowspan=2 style='text-align:center;vertical-align:middle;border:.5pt solid windowtext;'>".substr($view_val['income_time'], 0, 10)."</td>
		</tr>
		<tr height=14 style='mso-height-source:userset;height:10.5pt'>
		</tr>
		<tr height=29 style='mso-height-source:userset;height:21.75pt'>
			<td height=29 class=xl6323169 style='height:21.75pt'></td>
			<td class=xl6323169></td>
			<td class=xl6323169></td>
			<td class=xl6323169></td>
			<td class=xl6323169></td>
			<td class=xl6323169></td>
			<td class=xl6323169></td>
			<td class=xl6323169></td>
			<td class=xl6323169></td>
			<td class=xl6323169></td>
			<td class=xl6323169></td>
			<td class=xl6323169></td>
			<td class=xl6323169></td>
			<td class=xl6323169></td>
			<td class=xl6323169></td>
			<td class=xl6323169></td>
			<td class=xl6323169></td>
			<td class=xl6323169></td>
			<td class=xl6323169></td>
			<td class=xl6323169></td>
			<td class=xl6323169></td>
			<td class=xl6323169></td>
			<td class=xl6323169></td>
			<td class=xl6323169></td>
			<td class=xl6323169></td>
		</tr>";

		if($view_val['work_name'] != "정기점검2"){
			$html_code.="<tr height=22 style='mso-height-source:userset;height:16.5pt'>
			<td colspan=25 rowspan=2 height=44 style='border-right:1.0pt solid black;border-bottom:1.0pt solid black;height:33.0pt;text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;'>기술지원보고서</td>
		</tr>
		<tr height=22 style='mso-height-source:userset;height:16.5pt'>
		</tr>
		<tr height=14 style='mso-height-source:userset;height:10.5pt'>
			<td height=14 class=xl1523169 style='height:10.5pt'></td>
			<td class=xl1523169></td><td class=xl1523169></td><td class=xl1523169></td>
			<td class=xl1523169></td>
			<td class=xl1523169></td>
			<td class=xl1523169></td>
			<td class=xl1523169></td>
			<td class=xl1523169></td>
			<td class=xl1523169></td>
			<td class=xl1523169></td>
			<td class=xl1523169></td>
			<td class=xl1523169></td>
			<td class=xl1523169></td>
			<td class=xl1523169></td>
			<td class=xl1523169></td>
			<td class=xl1523169></td>
			<td class=xl1523169></td>
			<td class=xl1523169></td>
			<td class=xl1523169></td>
			<td class=xl1523169></td>
			<td class=xl1523169></td>
			<td class=xl1523169></td>
			<td class=xl1523169></td>
			<td class=xl1523169></td>
		</tr>
		<tr height=22 style='height:16.5pt'>
			<td colspan=4 height=22 style='height:16.5pt;text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;'>고객명</td>
			<td colspan=9 style='border-left:none;text-align:center;vertical-align:middle;border:.5pt solid windowtext;word-break:break-all;'>".$view_val['customer']."</td>
			<td colspan=3 style='text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;'>날짜</td>
			<td colspan=9 style='text-align:center;vertical-align:middle;border:.5pt solid windowtext;word-break:break-all;'>".substr($view_val['income_time'],0,10)."</td>
		</tr>

</td>
			  </tr>";

			  $html_code.= $customer_code;
			  $html_code.="<tr height=22 style='height:16.5pt'>
							<td colspan=4 height=22 style='height:16.5pt;text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;'>시작시간</td>
							<td colspan=9 style='border-left:none;text-align:center;vertical-align:middle;border:.5pt solid windowtext;'>".substr($view_val['start_time'],0,5)."</td>
							<td colspan=3 style='border-left:none;text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;'>종료시간</td>
							<td colspan=9 style='border-left:none;text-align:center;vertical-align:middle;border:.5pt solid windowtext;'>".substr($view_val['end_time'],0,5)."</td>
						</tr>
						<tr height=22 style='height:16.5pt'>
							<td colspan=4 height=22 style='height:16.5pt;text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;'>담당SE</td>
							<td colspan=9 style='border-left:none;text-align:center;vertical-align:middle;border:.5pt solid windowtext;'>".$view_val['engineer']."</td>
							<td colspan=3 style='border-left:none;text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;'>지원방법</td>
							<td colspan=9 style='border-left:none;text-align:center;vertical-align:middle;border:.5pt solid windowtext;'>".$view_val['handle']."</td>
						</tr>
						<tr height=37 style='mso-height-source:userset;'>
							<td colspan=4 rowspan=2 height=74 style='text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;' >지원시스템</td>
							<td colspan=21 style='border-left:none;text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;'>제품명/host/버전/서버/라이선스</td>
						</tr>
						<tr height=37 style='mso-height-source:userset;vertical-align:middle;border:.5pt solid windowtext;'>
							<td colspan=21 style='border-left:none;vertical-align:middle;border:.5pt solid windowtext;word-break:break-all;'>{$produce_txt}</td>
						</tr>
						<tr height=28 style='mso-height-source:userset;height:21.0pt'>
							<td colspan=4 height=28 style='height:21.0pt;text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;'>지원내용</td>
							<td colspan=21 style='border-left:none;text-align:center;vertical-align:middle;border:.5pt solid windowtext;word-break:break-all;'>".$view_val['subject']."</td>
						</tr>";


			$html_code.="<tr height=22 style='height:16.5pt'>
			<td colspan=4 height=22 style='border-right:.5pt solid black;height:16.5pt;text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;'>시간</td>
			<td colspan=21 style='font-weight: 700px; border-right:.5pt solid black;border-left:none;text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;'>지원 내역</td>
			</tr>
			{$tmp_doc_body}
			<tr height=55 style='mso-height-source:userset;min-height:41.25pt'>
			<td colspan=4 height=55 style='min-height:41.25pt;text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;'>지원의견</td><td colspan=21 class=xl8223169 width=619 style='border-right:.5pt solid black;width:467pt'>{$view_val['comment']}</td>
			</tr>";
			$html_code .= "<tr height=55 style='mso-height-source:userset;min-height:41.25pt'>
			<td colspan=4 height=55 style='word-break:break-all;min-height:41.25pt;text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;'>지원결과</td>
			<td colspan=21 class=xl8223169 width=619 style='word-break:break-all;border-right:.5pt solid black;width:467pt;border:.5pt solid windowtext;'>".$view_val['result']."</td>
			</tr>";
		}else{
			function br2nl($string){
				return preg_replace('/\<br(\s*)?\/?\>/i', "\n", $string);
			}
			  $total_process_text = rtrim(str_replace(';','',br2nl($view_val['work_process'])),'|');
			  $total_process_text = explode('|||',$total_process_text); // 제품별 나누기

			for($a=0; $a < count($produce); $a++){
			$html_code.="<tr height=29 style='mso-height-source:userset;height:21.75pt'>
			<td colspan=25 height=29 class=xl6323169 style='height:21.75pt'></td></tr>
			<tr height=22 style='mso-height-source:userset;height:16.5pt'>
			<td colspan=25 rowspan=2 height=44 style='border-right:1.0pt solid black;border-bottom:1.0pt solid black;height:33.0pt;text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;'>정기점검보고서</td>
		</tr>
		<tr height=22 style='mso-height-source:userset;height:16.5pt'>
		</tr>
		<tr height=14 style='mso-height-source:userset;height:10.5pt'>
			<td height=14 class=xl1523169 style='height:10.5pt'></td>
			<td class=xl1523169></td><td class=xl1523169></td><td class=xl1523169></td>
			<td class=xl1523169></td>
			<td class=xl1523169></td>
			<td class=xl1523169></td>
			<td class=xl1523169></td>
			<td class=xl1523169></td>
			<td class=xl1523169></td>
			<td class=xl1523169></td>
			<td class=xl1523169></td>
			<td class=xl1523169></td>
			<td class=xl1523169></td>
			<td class=xl1523169></td>
			<td class=xl1523169></td>
			<td class=xl1523169></td>
			<td class=xl1523169></td>
			<td class=xl1523169></td>
			<td class=xl1523169></td>
			<td class=xl1523169></td>
			<td class=xl1523169></td>
			<td class=xl1523169></td>
			<td class=xl1523169></td>
			<td class=xl1523169></td>
		</tr>
		<tr height=22 style='height:16.5pt'>
			<td colspan=4 height=22 style='height:16.5pt;text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;'>고객명</td>
			<td colspan=9 style='border-left:none;text-align:center;vertical-align:middle;border:.5pt solid windowtext;word-break:break-all;'>{$view_val['customer']}</td>
			<td colspan=3 style='text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;'>날짜</td>
			<td colspan=9 style='text-align:center;vertical-align:middle;border:.5pt solid windowtext;word-break:break-all;'>".substr($view_val['income_time'],0,10)."</td>
		</tr>";

			  $html_code.=$customer_code;
			  $html_code.="<tr height=22 style='height:16.5pt'>
							<td colspan=4 height=22 style='height:16.5pt;text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;'>시작시간</td>
							<td colspan=9 style='border-left:none;text-align:center;vertical-align:middle;border:.5pt solid windowtext;'>".substr($view_val['start_time'],0,5)."</td>
							<td colspan=3 style='border-left:none;text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;'>종료시간</td>
							<td colspan=9 style='border-left:none;text-align:center;vertical-align:middle;border:.5pt solid windowtext;'>".substr($view_val['end_time'],0,5)."</td>
						</tr>
						<tr height=22 style='height:16.5pt'>
							<td colspan=4 height=22 style='height:16.5pt;text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;'>담당SE</td>
							<td colspan=9 style='border-left:none;text-align:center;vertical-align:middle;border:.5pt solid windowtext;'>".$view_val['engineer']."</td>
							<td colspan=3 style='border-left:none;text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;'>지원방법</td>
							<td colspan=9 style='border-left:none;text-align:center;vertical-align:middle;border:.5pt solid windowtext;'>".$view_val['handle']."</td>
						</tr>
						<tr height=37 style='mso-height-source:userset;'>
							<td colspan=4 rowspan=2 height=74 style='text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;' >지원시스템</td>
							<td colspan=3 style='border-left:none;text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;'>제품명</td>
							<td colspan=6 width=148 style='border-left:none;width:112pt;text-align:center;vertical-align:middle;border:.5pt solid windowtext;word-break:break-all;'>".$produce[$a]."</td>
							<td colspan=3 style='border-left:none;text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;'>버전정보</td>
							<td colspan=9 style='border-left:none;text-align:center;vertical-align:middle;border:.5pt solid windowtext;word-break:break-all;'>".$version[$a]."</td>
						</tr>
						<tr height=37 style='mso-height-source:userset;text-align:center;vertical-align:middle;border:.5pt solid windowtext;'>
							<td colspan=3 height=37 style='border-left:none;text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;'>서버</td>
							<td colspan=6 style='border-left:none;text-align:center;vertical-align:middle;border:.5pt solid windowtext;word-break:break-all;'>".$hardware[$a]."</td>
							<td colspan=3 style='border-left:none;text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;'>라이선스</td>
							<td colspan=9 style='border-left:none;text-align:center;vertical-align:middle;border:.5pt solid windowtext;word-break:break-all;'>".$license[$a]."</td>
						</tr>
						<tr height=28 style='mso-height-source:userset;height:21.0pt'>
							<td colspan=4 height=28 style='height:21.0pt;text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;'>지원내용</td>
							<td colspan=21 style='border-left:none;text-align:center;vertical-align:middle;border:.5pt solid windowtext;word-break:break-all;'>".$view_val['subject']."</td>
						</tr>";

			$html_code.='<tr height=28 style="mso-height-source:userset;height:21.0pt">
				<td colspan=4 height="28" style="border-left:none;text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;"><input value="점검항목" readonly onfocus="javascrpt:blur();" style="width:100%;cursor:default; border:none; text-align:center; background-color:transparent;"/></td>
				<td colspan=9 height="28" style="border-left:none;text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;"><input value="점검내용" readonly onfocus="javascrpt:blur();" style="width:100%;cursor:default; border:none; text-align: center; background-color:transparent;"/></td>
				<td colspan=3 height="28" style="border-left:none;text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;"><input value="점검결과" readonly onfocus="javascrpt:blur();" style="width:100%;cursor:default; border:none; text-align: center; background-color:transparent;"/></td>
				<td colspan=9 height="28" style="border-left:none;text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;"><input value="특이사항" readonly onfocus="javascrpt:blur();" style="width:100%;cursor:default; border:none; text-align: center; background-color:transparent;"/></td>
			  </tr>';

			  $process_text = explode('@@',$total_process_text[$a]); //점검항목 별로 나누기

			  for($i=1; $i<count($process_text); $i++){
				$process_text1 = explode('#*',$process_text[$i]); //점검 내용 별로 나누기
				if($i <> 1){ //기타 특이사항을 제외한 나머지
				  $process_text1 = explode('#*',$process_text[$i]);
				  for($j=1; $j<count($process_text1); $j++){
					if($j==1){
						$html_code.="<tr height=28 style='mso-height-source:userset;height:21.0pt'><td colspan=4 rowspan='".floor((count($process_text1)-1)/3)."' style='word-break:break-all;border-left:none;text-align:center;vertical-align:middle;border:.5pt solid windowtext;'>{$process_text1[$j]}</td>"; //cpu, 메모리
					}elseif($j<=4){ //점검항목 중 첫번째 점검내용
					  if($j!=4){
						if($j%3==0){
						  if($process_text1[$j] == "normal"){
							$html_code.="<td colspan=3 style='border-left:none;text-align:center;vertical-align:middle;border:.5pt solid windowtext'>정상</td>";
						  }else if($process_text1[$j] == "abnormal"){
							$html_code.="<td colspan=3 style='border-left:none;text-align:center;vertical-align:middle;border:.5pt solid windowtext'>비정상</td>";
						  }else{
							$html_code.="<td colspan=3 style='border-left:none;text-align:center;vertical-align:middle;border:.5pt solid windowtext'></td>";
						  }
						}else{
						  if(strpos($process_text1[$j],"::") === false){
							  if($process_text1[$j] == "::"){
								$text = explode('::',$process_text1[$j]);
								$html_code.="<td colspan=4 style='border-left:none;vertical-align:middle;border:.5pt solid windowtext;word-break:break-all;'>{$text[0]}</td>
											<td colspan=5 style='border-left:none;vertical-align:middle;border:.5pt solid windowtext;word-break:break-all;'>{$text[1]}</td>";
							  }else{
								$html_code.="<td colspan=9 style='border-left:none;vertical-align:middle;border:.5pt solid windowtext;word-break:break-all;'>{$process_text1[$j]}</td>";
							  }
						  }else{
							$text = explode('::',$process_text1[$j]);
							$html_code.="<td colspan=4 style='border-left:none;vertical-align:middle;border:.5pt solid windowtext;word-break:break-all;'>{$text[0]}</td>
							<td colspan=5 style='border-left:none;vertical-align:middle;border:.5pt solid windowtext;word-break:break-all;'>{$text[1]}</td>";
						  }
						}
					  }else{
						$html_code.="<td colspan=9 style='border-left:none;vertical-align:middle;border:.5pt solid windowtext;word-break:break-all;'>{$process_text1[$j]}</td></tr>";
					  }
					}else{ //점검 항목 중 첫번 째가 아닌 나머지들
					  if($j%3==2){
						if(strpos($process_text1[$j],"::") === false){
							if($process_text1[$j] == "::"){
								$text = explode('::',$process_text1[$j]);
								  $html_code.="<tr height=28 style='mso-height-source:userset;height:21.0pt'>
								  <td colspan=4 style='border-left:none;vertical-align:middle;border:.5pt solid windowtext;word-break:break-all;'>{$text[0]}</td>
								  <td colspan=5 style='border-left:none;vertical-align:middle;border:.5pt solid windowtext;word-break:break-all;'>{$text[1]}</td>";
							}else{
								$html_code.="<tr><td colspan=9 style='border-left:none;vertical-align:middle;border:.5pt solid windowtext;word-break:break-all;'>{$process_text1[$j]}</td>";
							}
						}else{
						  $text = explode('::',$process_text1[$j]);
						  $html_code.="<tr height=28 style='mso-height-source:userset;height:21.0pt'>
						  			  <td colspan=4 style='border-left:none;vertical-align:middle;border:.5pt solid windowtext;word-break:break-all;'>{$text[0]}</td>
						  			  <td colspan=5 style='border-left:none;vertical-align:middle;border:.5pt solid windowtext;word-break:break-all;'>{$text[1]}</td>";
						}
					  }elseif($j%3==0){
						if($process_text1[$j] == "normal"){
							$html_code.="<td colspan=3 style='border-left:none;text-align:center;vertical-align:middle;border:.5pt solid windowtext'>정상</td>";
						}else if($process_text1[$j] == "abnormal"){
							$html_code.="<td colspan=3 style='border-left:none;text-align:center;vertical-align:middle;border:.5pt solid windowtext'>비정상</td>";
						}else{
							$html_code.="<td colspan=3 style='border-left:none;text-align:center;vertical-align:middle;border:.5pt solid windowtext'></td>";
						}
					  }elseif($j%3==1){
						$html_code.="<td colspan=9 style='border-left:none;vertical-align:middle;border:.5pt solid windowtext;word-break:break-all;'>{$process_text1[$j]}</td></tr>";
					  }
					}
				  }
				}
			  }
			  //기타 특이사항
			  for($i=1; $i<count($process_text); $i++){
				if($i == 1){
					$process_text1 = explode('#*',$process_text[1]);
					for($j=1; $j<count($process_text1); $j++){
						if($j+1 <> count($process_text1)){
							$html_code.="<tr height=28 style='mso-height-source:userset;height:21.0pt'><td colspan='4' style='word-break:break-all;border-left:none;text-align:center;vertical-align:middle;border:.5pt solid windowtext;word-break:break-all;'>{$process_text1[$j]}</td>";
						}else{
							$html_code.="<td colspan='21' height='35' style='border-left:none;vertical-align:middle;border:.5pt solid windowtext;word-break:break-all;'>{$process_text1[$j]}</td></tr>";
						}
					}
				}
			  }
		}
		$html_code.="<tr height=29 style='mso-height-source:userset;height:21.75pt'>
		<td colspan=25 height=29 class=xl6323169 style='height:21.75pt'></td></tr>
		<tr height=55 style='mso-height-source:userset;min-height:41.25pt'><td colspan=4 height=55 style='min-height:41.25pt;text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;'>지원의견</td><td colspan=21 class=xl8223169 width=619 style='border:.5pt solid black;
		width:467pt'>{$view_val['comment']}</td></tr>";
		}
$html_code.="
		<tr height=20>
			<td></td>
		</tr>
		</table>
		<img src='http://support.durianit.co.kr/misc/img/mail_img.png' alt='' width=800 style='display:block;width:100%;max-width:100%;'>
	</div>
	</body>
</html>";

for($i=0;$i<count($csvArray);$i++){
	$real_mail_address_array = explode(",",$csvArray[$i]);
	$to = trim($real_mail_address_array[0]);
	$news_letter = str_replace("send_address",$to,$html_code);
	$message = $news_letter;
}

	//encoding base64로 해주고 chunk_split(base64_encode($body))해줘야 한글 안깨져
	if($view_val['file_changename'] != '' && $view_val['file_realname'] !=''){//첨부파일 있을때
		$headers = "From: =?utf-8?B?".base64_encode("support@durianit.co.kr")."?= <support@durianit.co.kr> \n";
		$headers .= 'Cc: tech@durianit.co.kr' . "\r\n";
		// $headers .= "Bcc: sylim@durianit.co.kr" ."\r\n";
		$headers .= 'MIME-Version: 1.0' . "\r\n";
		$headers .= "Content-Type: Multipart/mixed; boundary=\"$boundary\"";
		$body = "This is a multi-part message in MIME format.\r\n\r\n"."--$boundary\r\n"."Content-Type: text/html; charset=UTF-8\r\n"."Content-Transfer-Encoding: base64\r\n\r\n".chunk_split(base64_encode($message))."\r\n"."--$boundary\r\n";
		$body .="Content-Type: application/octet-stream; charset=UTF-8\r\n name=\"=?UTF-8?B?".base64_encode($filename)."?=\"\r\n"."Content-Transfer-Encoding: base64\r\n"."Content-Disposition: attachment; filename=\"=?UTF-8?B?".base64_encode($filename)."?=\"\r\n\r\n".$content."\r\n\r\n"."--$boundary--";
		$strto = explode("@", $to);

		//메일 보내기
		$result = mail($csvLoad, $subject, $body, $headers);
	}else{//첨부파일 없을때
		$headers = "From: =?utf-8?B?".base64_encode("support@durianit.co.kr")."?= <support@durianit.co.kr> \n";
		$headers .= 'Cc: tech@durianit.co.kr' . "\r\n";
		// $headers .= "Bcc: sylim@durianit.co.kr" ."\r\n";
		$headers .= 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		// $headers .= 'Content-Transfer-Encoding: quoted-printable';
		$headers .= "Content-Transfer-Encoding: base64\r\n";
		$headers .= 'Message-ID: <' . $i . ">";
		$body = $message;
		$strto = explode("@", $to);

		//메일 보내기
		$result = mail($csvLoad, $subject, chunk_split(base64_encode($body)), $headers);
	}



	if($result){
		echo "<script>alert('정상적으로 처리되었습니다.');location.href='".site_url()."/tech/tech_board/tech_doc_list?type=Y';</script>";
	} else {
		echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
	}
	$headers = "";

?>

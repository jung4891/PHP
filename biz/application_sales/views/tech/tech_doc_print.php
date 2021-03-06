<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
require_once $this->input->server('DOCUMENT_ROOT')."/include/KISA_SEED_CBC.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<style>
	.work_text_table {
		border-collapse: collapse;
		table-layout: fixed;
		border-right: 1px;
		border-left: 1px;
		border-color: black;
		color: black;
		font-size: 10.0pt;
		font-weight: 700;
		font-style: normal;
		text-decoration: none;
		font-family: "맑은 고딕", monospace;
	}

	.work_text_table td {
		word-break: break-all;
		border: 0.5pt solid windowtext;
		padding-left: 10px;
		padding-right: 10px;
	}

	#work_text {
		padding-left: 10px;
		padding-right: 10px;
	}

	.work_text_table th {
		word-break: break-all;
		border: 0.5pt solid windowtext;
	}

	td{
		white-space:normal;
		word-break:break-word;
        word-wrap: break-word;
		text-overflow:clip;
  	}

	.footer-space {
		height: 35px;
		width: 101%;
	}

	.header-space {
		height: 25px;
		width: 101%;
	}

	.footer {
		position: fixed;
		bottom: 0;
		right: 0;
		margin-right: 10px;
	}

	.header {
		position: fixed;
		top: 0;
		right: 0;
	}

	.footer,
	.footer-space,
	.header,
	.header-space {
		background-color: white;
		border-color: white;
	}

	@media print {
		table tr:not(.borderNone) {
			outline: #000 solid thin\9;
		}

		td:not(.borderNone) {
			outline: #000 solid thin\9;
		}
	}

	@page {
		margin: 2mm
	}

	</style>
	<?php
    //imagesrc 암호화 복호화
		$g_bszUser_key = null;
		if(isset($_POST['KEY']))
			$g_bszUser_key = $_POST['KEY'];
		if($g_bszUser_key == null)
		{
			$g_bszUser_key = "88,E3,4F,8F,08,17,79,F1,E9,F3,94,37,0A,D4,05,89";
		}

		$g_bszIV = null;
		if(isset($_POST['IV']))
			$g_bszIV = $_POST['IV'];
		if($g_bszIV == null)
		{
			$g_bszIV = "26,8D,66,A7,35,A8,1A,81,6F,BA,D9,FA,36,16,25,01";
		}

		function decrypt($bszIV, $bszUser_key, $str) {
			$planBytes = explode(",",$str);
			$keyBytes = explode(",",$bszUser_key);
			$IVBytes = explode(",",$bszIV);

			for($i = 0; $i < 16; $i++)
			{
				$keyBytes[$i] = hexdec($keyBytes[$i]);
				$IVBytes[$i] = hexdec($IVBytes[$i]);
			}

			for ($i = 0; $i < count($planBytes); $i++) {
				$planBytes[$i] = hexdec($planBytes[$i]);
			}

			if (count($planBytes) == 0) {
				return $str;
			}

			$pdwRoundKey = array_pad(array(),32,0);

			$bszPlainText = null;

			// 방법 1
      $bszPlainText = KISA_SEED_CBC::SEED_CBC_Decrypt($keyBytes, $IVBytes, $planBytes, 0, count($planBytes));
      $planBytresMessage = null; //이거 내가쓴거
			if ($bszPlainText != null) {
				for($i=0;$i< count($bszPlainText);$i++) {
					$planBytresMessage .=  sprintf("%02X", $bszPlainText[$i]).",";
				}
			}

			return substr($planBytresMessage,0,strlen($planBytresMessage)-1);

		}

		function hexToStr($hex){
			$string='';
			for ($i=0; $i < strlen($hex)-1; $i+=2){
				$string .= chr(hexdec($hex[$i].$hex[$i+1]));
			}
			return $string;
    }

    $imageSrc = '';
    $srcData = $view_val['customer_sign_src'];
    $srcData = explode('@',$srcData);

    for($j =0; $j<count($srcData); $j++){
      $result = $srcData[$j];
      $result = decrypt($g_bszIV, $g_bszUser_key, $result);
      $result = str_replace(",","", $result);
      $result = hexToStr($result);
      $imageSrc .= $result;
    }

	?>
	<title><?php echo $this->config->item('site_title');?></title>
	<link href="/misc/css/print_doc.css" type="text/css" rel="stylesheet">
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<script src="/misc/js/m_script.js"></script>
	<script type="text/javascript" src="/misc/js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="/misc/js/jquery.min.js"></script>
	<script type="text/javascript" src="/misc/js/jquery-1.8.3.min"></script>
	<script type="text/javascript" src="/misc/js/common.js"></script>
	<script type="text/javascript" src="/misc/js/jquery.validate.js"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<table class="totalTable">
  <thead><tr class="borderNone"><td class="borderNone">
    <div class="header-space">&nbsp;</div>
  </td></tr></thead>
  <tbody><tr class="borderNone">
    <?php if($view_val['work_name'] == "정기점검2" && strpos($view_val['produce'],',') !== false){ ?>
          <td><img src="<?php echo $misc; ?>img/btn_left.jpg" id="leftBtn" style="float:right;cursor:pointer;"
              onclick="changePage('left')" /></td>
    <?php } ?>
    <td class="borderNone">
    <div style="margin-bottom:10px;">
      <input type="button" class="basicBtn" value="프린트" onclick="printPage();">
    </div>
    <div class="content">
		<table class="tttest" border=0.5 cellpadding=0 cellspacing=0 width=730 style='border-collapse:collapse;table-layout:fixed;width:550pt'>
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
		<tr height=15 style='mso-height-source:userset;height:11.25pt'>
			<td colspan=3 rowspan=2 height=30 class=xl7223169 width=81 style='height:
			22.5pt;width:60pt'><a name="RANGE!A1:Y19">고객명</a></td>
			<td colspan=6 rowspan=2 class=xl7123169 width=171 style='width:131pt;word-break:break-all;white-space:pre-wrap;'><?php echo $view_val['customer'];?></td>
			<td colspan=3 rowspan=2 class=xl7223169 width=67 style='width:50pt'>작업명</td>
			<td colspan=5 rowspan=2 class=xl7123169 width=123 style='width:94pt;'><?php echo $view_val['work_name'];?></td>
			<td colspan=2 rowspan=2 class=xl7123169 width=48 style='width:36pt'>고객사</td>
			<td colspan=3 rowspan=2 class=xl7123169 width=135 style='width:101pt;word-break:break-all;white-space:pre-wrap;'><?php echo $view_val['customer'];?></td>
			<td colspan=3 rowspan=2 class=xl7123169 width=105 style='width:78pt'>두리안정보기술</td>
		</tr>
		<tr height=15 style='mso-height-source:userset;height:11.25pt'>
		</tr>
		<tr height=14 style='mso-height-source:userset;height:10.5pt'>
			<td colspan=3 rowspan=2 height=28 class=xl7223169 style='height:21.0pt'>문서번호</td>
			<td colspan=6 rowspan=2 class=xl7123169><?php echo $view_val['doc_num'];?></td>
			<td colspan=3 rowspan=2 class=xl7223169>작성자</td>
			<td colspan=5 rowspan=2 class=xl7123169><?php echo $view_val['writer'];?></td>
			<td colspan=2 rowspan=4 class=xl7123169>확인</td>
			<td colspan=3 rowspan=4 class=xl7123169><?php if($view_val['customer_sign_consent']=="true"){echo "<img src='{$imageSrc}' height = '53' width = '53' ><div>".$view_val['signer']."</div>";}else{echo '<div id="signCheck">서명<input type="checkbox" id="customer_sign_consent" name="customer_sign_consent" value="'.$view_val['customer_sign_consent'].'" ></div><div id="customer_sign"></div>';}?></td>
			<td colspan=3 rowspan=4 class=xl7123169><?php if($view_val['sign_consent']=="true"){echo "<img src='{$sign_path}' width = '53' height = '53'><div>{$view_val['writer']}</div>";}?></td>
		</tr>
		<tr height=14 style='mso-height-source:userset;height:10.5pt'>
		</tr>
		<tr height=14 style='mso-height-source:userset;height:10.5pt'>
			<td colspan=3 rowspan=2 height=28 class=xl7223169 style='height:21.0pt'>개정버전</td>
			<td colspan=6 rowspan=2 class=xl7123169>V1.0</td>
			<td colspan=3 rowspan=2 class=xl7223169>날짜</td>
			<td colspan=5 rowspan=2 class=xl7323169>
			<?php echo substr($view_val['income_time'], 0, 10); ?>
			</td>
		</tr>
		<tr height=14 style='mso-height-source:userset;height:10.5pt'>
		</tr>
		<tr class="borderNone" height=29 style='mso-height-source:userset;height:21.75pt'>
			<td colspan="25" height=29 class="borderNone" style='height:21.75pt'></td>
		</tr>
		<tr height=22 style='mso-height-source:userset;height:16.5pt'>
			<td colspan=25 rowspan=2 height=44 class=xl7423169 style='border-right:1.0pt solid black;
			border-bottom:1.0pt solid black;height:33.0pt'>기술지원보고서</td>
		</tr>
		<tr height=22 style='mso-height-source:userset;height:16.5pt'>
		</tr>
		<tr class="borderNone" height=14 style='mso-height-source:userset;height:10.5pt'>
			<td colspan="25" height=14 class="borderNone" style='height:10.5pt'></td>
		</tr>
		<tr height=22 style='height:16.5pt'>
			<td colspan=4 height=22 class=xl6723169 style='height:16.5pt'>고객명</td>
			<td colspan=9 class=xl6723169 style='border-left:none;word-break:break-all;white-space:pre-wrap;'><?php echo $view_val['customer'];?></td>
			<td colspan=3 class=xl6723169 style='border-left:none'>담당자명</td>
			<td colspan=9 class=xl6723169 style='border-left:none;word-break:break-all;white-space:pre-wrap;'><?php echo str_replace(';',' ',$view_val['customer_manager']);?></td>
		</tr>
		<!-- <tr height=22 style='height:16.5pt'>
			<td colspan=4 height=22 class=xl6723169 style='height:16.5pt'>프로젝트명</td>
			<td colspan=21 class=xl6723169 style='border-left:none; text-align:left;'>&nbsp;&nbsp;<?php echo $view_val['project_name'];?></td>
		</tr> -->

<?php if($view_val['work_name']=="장애지원"){?>
			<tr height=22 style='height:16.5pt'>
				<td colspan=4 height="22" class=xl6723169 style='height:16.5pt'>장애구분</td>
				<td colspan=9 class=xl6723169 style='border-left:none'><?php echo $view_val['err_type'];?></td>
				<td colspan=3 class=xl6723169 style='border-left:none'>심각도</td>
				<td colspan=9 class=xl6723169 style='border-left:none'><?php
					switch($view_val['warn_level']){
						case '001': echo "전체서비스중단";break;
						case '002': echo "일부서비스중단/서비스지연";break;
						case '003': echo "관리자불편/대고객신뢰도저하";break;
						case '004': echo "특정기능장애";break;
						case '005': echo "서비스무관단순장애";break;
					}?></td>
			</tr>
			<tr height=22 style='height:16.5pt'>
				<td colspan=4 height="22" class=xl6723169 style='height:16.5pt'>장애유형</td>
				<td colspan=9 class=xl6723169 style='border-left:none'><?php
					switch($view_val['warn_type']){
												case '001': echo "파워불량";break;
												case '002': echo "하드웨어결함";break;
												case '003': echo "인터페이스불량";break;
												case '004': echo "DISK 불량";break;
												case '005': echo "LED 불량";break;
												case '006': echo "FAN 불량";break;
												case '007': echo "하드웨어 소음";break;
												case '008': echo "설정 오류";break;
												case '009': echo "고객 과실";break;
												case '010': echo "기능 버그";break;
												case '011': echo "OS 오류";break;
												case '012': echo "펌웨어 오류";break;
												case '013': echo "타사제품문제";break;
												case '014': echo "호환문제";break;
												case '015': echo "시스템부하";break;
												case '016': echo "PC문제";break;
												case '017': echo "원인불명";break;
												case '018': echo "기타오류";break;
					}?></td>
				<td colspan=3 class=xl6723169 style='border-left:none'>장애처리방법</td>
				<td colspan=9 class=xl6723169 style='border-left:none'><?php
					switch($view_val['work_action']){
						case '001': echo "기술지원";break;
						case '002': echo "설정지원";break;
						case '003': echo "장비교체";break;
						case '004': echo "업그레이드";break;
						case '005': echo "패치";break;
						case '006': echo "협의중";break;
					}
				}?></td>
			</tr>


		<tr height=22 style='height:16.5pt'>
			<td colspan=4 height=22 class=xl6623169 style='height:16.5pt'>날짜</td>
			<td colspan=9 class=xl6823169 style='border-left:none'>
				<?php echo substr($view_val['income_time'], 0, 10);
                if($view_val['end_work_day'] != ''){
                    echo " ~ ".substr($view_val['end_work_day'], 0, 10);
                }
                ?>
			</td>
			<td colspan=3 class=xl6423169 style='border-left:none'>투입시간</td>
			<td colspan=9 class=xl6523169 style='border-left:none'><?php echo substr($view_val['total_time'],0,5);?></td>
		</tr>
		<tr height=22 style='height:16.5pt'>
			<td colspan=4 height=22 class=xl6723169 style='height:16.5pt'>시작시간</td>
			<td colspan=9 class=xl7023169 style='border-left:none'><?php echo substr($view_val['start_time'],0,5);?></td>
			<td colspan=3 class=xl6923169 style='border-left:none'>종료시간</td>
			<td colspan=9 class=xl7023169 style='border-left:none'><?php echo substr($view_val['end_time'],0,5);?></td>
		</tr>
		<tr height=22 style='height:16.5pt'>
			<td colspan=4 height=22 class=xl6723169 style='height:16.5pt'>담당SE</td>
			<td colspan=9 class=xl6723169 style='border-left:none;word-break:break-all;white-space:pre-wrap;'><?php echo $view_val['engineer'];?></td>
			<td colspan=3 class=xl6723169 style='border-left:none'>지원방법</td>
			<td colspan=9 class=xl6723169 style='border-left:none'><?php echo $view_val['handle'];?></td>
		</tr>
		<tr height=37 style='mso-height-source:userset;'>
			<td colspan=4 height=74 class=xl6723169 >지원시스템</td>
			<td colspan=3 class=xl6723169 style='border-left:none;word-break:break-word;'>제품명 <br> host <br> 버전 <br> 서버 <br>라이선스 <?php if((trim($view_val['customer']) == "SKB(유통망)" || trim($view_val['customer']) == "SKB(과금망)") && strpos($view_val['produce'],',')=== false) {echo "<br>serial";} ?></td>
         	<td colspan=18 class=xl8823169 width=148 style='border-left:none;width:112pt'>
            <input type="hidden" name="currentPage" id="currentPage" class="input2_red" value=1 />
			<ul id="sortable">
				<?php
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
				$sn = explode(",",$view_val['sn']);
				for($i=1; $i<=count($produce); $i++){
					echo '<li id="li'.$i.'"><span style="cursor:pointer;" id="produce'.$i.'" class="click_produce" onclick="clickProduce('.$i.')"><span class="produce">'.$produce[($i-1)].'</span> / <span class="host">'.$host[($i-1)].'</span> / <span class="version">'.$version[($i-1)].'</span> / <span class="hardware">'.$hardware[($i-1)].'</span> / <span class="license">'.$license[($i-1)].'</span> ';
					if((trim($view_val['customer']) == "SKB(유통망)" || trim($view_val['customer']) == "SKB(과금망)") && strpos($view_val['produce'],',')=== false){
						echo '/ <span class="serial">'.$sn[($i-1)].'</span></span></li>';
					}else{
						echo '<span class="serial" style="display:none;">'.$sn[($i-1)].'</span></span></li>';
					}
				}
				?>
			</ul>
         	</td>
		</tr>
		<tr height=28 style='mso-height-source:userset;height:21.0pt'>
			<td colspan=4 height=28 class=xl6723169 style='height:21.0pt'>작업명</td>
			<td colspan=21 class=xl6723169 style='border-left:none;text-align:left;'>&nbsp;&nbsp;<?php echo $view_val['subject'];?></td>
		</tr>
<?php if($view_val['work_name'] <> "정기점검2"){ ?>
			<tr height=22 style='height:16.5pt'>
				<td colspan=4 height=22 class=xl8023169 style='border-right:.5pt solid black;
				height:16.5pt'>시간</td>
				<td colspan=21 class=xl8923169 style='font-weight: 700px; border-right:.5pt solid black;
				border-left:none'>지원 내역</td>
			</tr>
			<?php
			$tmp = explode(";;", $view_val['work_process_time']);
			$process_txt =  explode(";;", $view_val['work_process']);

			for($i=0;$i<count($tmp)-1;$i++){
				if(strpos($tmp[$i],"/")!==false){
                    $w_date = explode("/",$tmp[$i]);
                    $time = explode("-",$w_date[1]);
                    $w_date = $w_date[0];
                }else{
                    $time = explode("-",$tmp[$i]);
                }
				?>
				<tr height=90 style='mso-height-source:userset;min-height:67.5pt'>
					<td colspan=4 height=90 class=xl6523169 style='min-height:67.5pt'>
					<?php
					if(isset($w_date)){
						if(strpos($w_date,"~")!==false){
							$w_date = explode('~',$w_date);
							for($j=0;$j<count($w_date);$j++){
								if ($j==0) {
									echo $w_date[$j]."~"."<br>";
								} else {
									echo $w_date[$j]."<br><br>";
								}
							}
						}
					}
					?>
					<?php echo $time[0];?> ~ <?php echo $time[1];?>
					</td>
					<!-- <td colspan=2 class=xl6523169 style='border-left:none'><?php echo $time[1];?></td> -->
					<td colspan=21 class=xl8523169 width=619 style='border-right:.5pt solid black;border-left:none;width:467pt'>
						<div id="work_text"><?php echo nl2br($process_txt[$i]);?></div>
					</td>
				</tr>
			<?php } ?>

			<?php
			if($view_val['work_name']=='장애지원' && $view_val['failure_contents'] != '') {
				$failure_data = explode('*/*', $view_val['failure_contents']);
				foreach($failure_data as $fd) {
					$fd_arr = explode(':::', $fd);
					$failure_title = $fd_arr[0];
					$failure_content = $fd_arr[1]; ?>
					<tr height=55 style='mso-height-source:userset;min-height:41.25pt'>
						<td colspan=4 height=55 class=xl8023169 style='min-height:41.25pt'><?php echo $failure_title; ?></td>
						<td colspan=21 class=xl8223169 width=619 style='border-right:.5pt solid black;
						width:467pt'><?php echo nl2br($failure_content);;?></td>
					</tr>
				<?php	}
			} ?>


			<tr height=55 style='mso-height-source:userset;min-height:41.25pt'>
				<td colspan=4 height=55 class=xl8023169 style='min-height:41.25pt'>지원의견</td>
				<td colspan=21 class=xl8223169 width=619 style='border-right:.5pt solid black;
				width:467pt'><?php echo $view_val['comment'];?></td>
			</tr>
			<tr height=55 style='mso-height-source:userset;min-height:41.25pt;'>
				<td colspan=4 height=55 class=xl8023169 style='min-height:41.25pt'>지원결과</td>
				<td colspan=21 class=xl8223169 width=619 style='border-right:.5pt solid black;
				width:467pt;padding-left:10px;padding-right:10px;'><?php echo $view_val['result'];?></td>
			</tr>
		<?php
		}else{
		?>
			</table>
			<?php

				$total_process_text = rtrim(str_replace(';','',$view_val['work_process']),'|');
				$total_process_text = explode('|||',$total_process_text); // 제품별 나누기
				for($a=0; $a<count($total_process_text); $a++){
			?>
			<table id="work_text_table<?php echo ($a+1) ;?>" class ="work_text_table" frame=void border=0.5 cellpadding=0 cellspacing=0 width=730 style='display:none;border-collapse:collapse;table-layout:fixed;width:550pt'>
				<tr style="border-top:none">
					<th width ="111.5" height=22><input value="점검항목" readonly onfocus="javascrpt:blur();" style="cursor:default; font-weight:bold; border:none; text-align:center; width:95%;"></input></th>
					<th colspan="2" height=22><input value="점검내용" readonly onfocus="javascrpt:blur();" style="cursor:default; font-weight:bold; border:none; text-align:center; width:95%;" ></input></th>
					<th height=22><input value="점검결과" readonly onfocus="javascrpt:blur();" style="cursor:default; font-weight:bold; border:none; text-align:center; width:95%;"></input></th>
					<th height=22><input value="특이사항" readonly onfocus="javascrpt:blur();" style="cursor:default; font-weight:bold; border:none; text-align:center; width:95%;"></input></th>
				</tr >
			<?php
			$process_text = explode('@@',$total_process_text[$a]); //점검항목 별로 나누기
			for($i=1; $i<count($process_text); $i++){
				$process_text1 = explode('#*',$process_text[$i]); //점검 내용 별로 나누기
				if($i <> 1){ //기타 특이사항을 제외한 나머지
				$process_text1 = explode('#*',$process_text[$i]);
				for($j=1; $j<count($process_text1); $j++){
					if($j==1){
					echo '<tr><td rowspan="'.floor((count($process_text1)-1)/3).'" style="text-align:center;">'.$process_text1[$j].'</td>'; //cpu, 메모리
					}elseif($j<=4){ //점검항목 중 첫번째 점검내용
					if($j!=4){
						if($j%3==0){
							if($process_text1[$j] == "normal"){
								echo '<td align="center">정상</td>';
							}else if($process_text1[$j] == "abnormal"){
								echo '<td align="center">비정상</td>';
							}else{
								echo '<td></td>';
							}
						}else{
							if(strpos($process_text1[$j],"::") === false){
								if($process_text1[$j] == "::"){
									$text = explode('::',$process_text1[$j]);
									echo '<td>'.$text[0].'</td>';
									echo '<td>'.$text[1].'</td>';
								}else{
									echo '<td colspan="2">'.$process_text1[$j].'</td>';
								}
							}else{
								$text = explode('::',$process_text1[$j]);
								echo '<td>'.$text[0].'</td>';
								echo '<td>'.$text[1].'</td>';
							}
						}
					}else{
						echo '<td>'.$process_text1[$j].'</td></tr>';
					}
					}else{ //점검 항목 중 첫번 째가 아닌 나머지들
					if($j%3==2){
						if(strpos($process_text1[$j],"::") === false){
							if($process_text1[$j] == "::"){
								$text = explode('::',$process_text1[$j]);
								echo '<tr><td>'.$text[0].'</td>';
								echo '<td>'.$text[1].'</td>';
							}else{
								echo'<tr><td colspan="2">'.$process_text1[$j].'</td>';
							}
						}else{
						$text = explode('::',$process_text1[$j]);
						echo '<tr><td>'.$text[0].'</td>';
						echo '<td>'.$text[1].'</td>';
						}
					}elseif($j%3==0){
						if($process_text1[$j] == "normal"){
						  echo '<td align="center" >정상</td>';
						}else if($process_text1[$j] == "abnormal"){
						  echo '<td align="center">비정상</td>';
						}else{
						  echo '<td></td>';
						}
					}elseif($j%3==1){
						echo '<td>'.$process_text1[$j].'</td></tr>';
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
                  echo '<tr><td>'.$process_text1[$j].'</td>';
                }else{
                  echo '<td colspan="4">'.$process_text1[$j].'</td></tr>';
                }
              }
            }
		  }
		  ?>
		<tr height=55 style='mso-height-source:userset;min-height:41.25pt'>
			<td height=55 class=xl8023169 style='min-height:41.25pt'>지원의견</td>
			<td colspan=4 class=xl8223169 width=619 style='border-right:.5pt solid black;width:467pt;'><?php echo $view_val['comment'];?></td>
		</tr>
		<tr height=0 style='mso-height-source:userset;min-height:41.25pt'>
		</tr>
		<?php } ?>
		</table>
	<?php } ?>
	</div>
  <td>
  <?php if($view_val['work_name'] == "정기점검2" && strpos($view_val['produce'],',') !== false){ ?>
    <td><img src="<?php echo $misc; ?>img/btn_right.jpg" id="rightBtn" onclick="changePage('right');" style="cursor:pointer;"/></td>
  <?php } ?>
  </tr></tbody>
  <tfoot ><tr class="borderNone"><td class="borderNone">
    <div class="footer-space" >&nbsp;</div>
  </td></tr></tfoot>
</table>
<div class="header" style="width:100%;"><img src='<?php echo $misc ?>img/header.png' height="25" style ="float:right;"></div>
<div class="footer" style="width:100%;" ><img src='<?php echo $misc ?>img/logo/<?php echo $view_val['logo']; ?>' height="35" style ="float:right;"></div>

<script language="javascript">
textareaSize();

if("<?php echo $view_val['work_name']; ?>" == "정기점검2"){
    $("#work_text_table1").show();
    $("#produce1").css("color","red");
    // $("#leftBtn").show();
    // $("#rightBtn").show();
    textareaSize();
  }

var seq = "<?php echo $view_val['seq']; ?>";
var text ="";

//textarea height 글자수에 맞게 늘려주는 거
function textareaSize() {
  var textarea = document.getElementsByTagName("textarea");
  for (var i = 0; i < textarea.length; i++) {
    if (textarea[i].value != '') {
      textarea[i].style.height = '1px';
      textarea[i].style.height = (textarea[i].scrollHeight) + 'px';
    }
  }
}

function signPage() {
	var settings = 'height=500,width=1000,left=0,top=0';
	window.open('/index.php/tech/tech_board/tech_doc_signature', '_blank', settings);
}

function customerSignSrc(image) {
	var signer = "<?php if(isset($_GET['login'])){echo $_GET['login'];}else{?>"+ text +"<?php } ?>";
	$.ajax({
		type: "POST",
		cache: false,
		url: "<?php echo site_url(); ?>/tech/tech_board/customerSignSrc",
		dataType: "json",
		async: false,
		data: {
			seq: seq,
			src: image,
			signer: signer
		},
		success: function (data) {
			tech_doc_pdf_mail();
			document.getElementById("signCheck").style.display = 'none';
		},
		error: function(data){
			document.getElementById("signCheck").style.display = 'none';
			tech_doc_pdf_mail();
		}
	});
}

function tech_doc_pdf_mail(){
	window.open("<?php echo site_url();?>/tech/tech_board/tech_doc_pdf_send_mail?seq=<?php echo $view_val['seq']; ?>");
}

$(document).ready(function () {
	$("#customer_sign_consent").change(function(){
    if($("#customer_sign_consent").is(":checked")){
          var sign_confirm = confirm( '서명하시겠습니까?' );
          if(sign_confirm == false){
            $("input[name='customer_sign_consent']").prop("checked", false);
            return false;
          }
          <?php if(isset($_GET['login'])){ ?>
			  text = prompt("서명자 이름을 입력하세요.","<?php echo urldecode($_GET['login']); ?>");
		  <?php }else{?>
			  text = prompt("서명자 이름을 입력하세요.");
		  <?php } ?>
          if(text==null || text ==''){
           alert("서명자 이름을 다시 입력해 주세요.");
           $("input[name='customer_sign_consent']").prop("checked", false);
          }else{
            $.ajax({
              type: "POST",
              cache: false,
              url: "<?php echo site_url(); ?>/tech/tech_board/customerSignConsentUpdate",
              dataType: "json",
              async: false,
              data: {
                seq: seq
              },
              success: function (data) {
                $("#customer_sign_consent").val(true);
                signPage();
              }
            });
          }
		}else{
			$.ajax({
				type: "POST",
				cache: false,
				url: "<?php echo site_url(); ?>/tech/tech_board/customerSignConsentCancle",
				dataType: "json",
				async: false,
				data: {
					seq: seq
				},
				success: function (data) {
					alert("서명동의 취소");
					$("#customer_sign").empty();
				}
			});
		}
	});
});

  // 이전,다음 제품 (버튼 <,>) 누를 때
  function changePage(direction){
    var currentTable = '';
    var nextTable = '';
    var prevTable ='';

    for(i=0; i<$(".work_text_table").length; i++){
      if($(".work_text_table").eq(i).css("display") != "none"){
      currentTable = $(".work_text_table").eq(i).attr('id')
      }
    }

    currentNum = currentTable.replace("work_text_table","");

    if(direction == "left"){
      prevTable = $("#"+currentTable).prev().attr('id');
      if(prevTable == undefined){
        alert("이전 제품이 없습니다.");
      }else{
        var prevNum = prevTable.replace("work_text_table","");
        $("#"+currentTable).hide();
        $("#"+prevTable).show();
        $("#produce"+currentNum).css("color","black");
        $("#produce"+prevNum).css("color","red");
        $('#templateOnOFF'+currentNum).hide();
        $('#templateOnOFF'+prevNum).show();
      }
    }else{
      nextTable = $("#"+currentTable).next().attr('id');
      if(nextTable == undefined){
        alert("다음 제품이 없습니다.");
      }else{
        var nextNum = nextTable.replace("work_text_table","");
        $("#"+currentTable).hide();
        $("#"+nextTable).show();
        $("#produce"+currentNum).css("color","black");
        $("#produce"+nextNum).css("color","red");
        $('#templateOnOFF'+currentNum).hide();
        $('#templateOnOFF'+nextNum).show();
      }
    }
    textareaSize();
  }

  //제품명 클릭 할때
  function clickProduce(i,produceSeq){
    if("<?php echo $view_val['work_name']; ?>" == "정기점검2"){
      $(".work_text_table").hide();
      $(".click_produce").css('color','black');
      $('#work_text_table'+i).show();
      $("#produce"+i).css('color','red');

      textareaSize();
    }
  }

  function printPage(){
    window.open("<?php echo site_url();?>/tech/tech_board/tech_doc_print_page?seq=<?php echo base64_encode($view_val['seq'] ); ?>", "cform", 'scrollbars=yes,width=850,height=600');
  }

</script>
</body>
</html>

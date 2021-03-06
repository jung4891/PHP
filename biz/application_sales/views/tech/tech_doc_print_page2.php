<?php
require_once $this->input->server('DOCUMENT_ROOT')."/include/KISA_SEED_CBC.php";
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<style>
html,
body {
    height: 297mm;
    width: 210mm;
}

#check_table td {
    word-break: break-all;
    white-space: pre-wrap;
}

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
    word-break: break-word;
}

#work_text {
    padding-left: 10px;
    padding-right: 10px;
}

.work_text_table th {
    word-break: break-all;
    border: 0.5pt solid windowtext;
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
    <table id="cover" class="borderNone" border=0.5 cellpadding=0 cellspacing=0 width=730 height=1100 style='page-break-after:always;border-collapse:collapse;table-layout:fixed;width:100%;background-image:url("<?php echo $misc?>img/cover/<?php if($view_val['cover'] != 'basic'){echo $cover[0]['cover_name'];} ?>");background-size:100% 100%;'>
        <tr class="borderNone" height=100>
            <td class="borderNone"></td>
            <td colspan=2 class="borderNone"></td>
            <td class="borderNone">
                <?php if($view_val['work_name'] == "정기점검2" && $view_val['cover'] !='basic'){$date = date('Y년 m월 d일', strtotime($view_val['income_time']));?>
                <?php if($view_val['sign_consent']=="true"){echo "<img src='".$misc."img/".$view_val['writer'].".png' id='durian_sign' >";}?>
                <?php if($view_val['customer_sign_consent']=="true"){echo "<img src='{$imageSrc}' id='customer_sign' >"; }?>
                <?php echo "<div id='subject' style='border:none;font-size:30px;font-weight:bold;text-align:center'>{$view_val['customer']} 정기점검 보고서</div>" ;?>
                <?php echo "<div id='income_time' style='border:none;font-size:20px'>{$date}</div>";?>
                <?php echo "<div id='customer_company' style='border:none;font-size:20px'>{$view_val['customer']}</div>";?>
                <?php echo "<div id='writer' style='border:none;font-size:20px' >{$view_val['writer']}</div>" ;?>
                <?php echo "<div id='durian_engineer' style='border:none;font-size:20px;text-align:center;'>{$view_val['writer']}</div>";?>
                <?php echo "<div id='customer_manager' style='border:none;font-size:20px;text-align:center;'>{$view_val['signer']}</div>" ;?>
                <?php } ?>
            </td>
        </tr>
        <?php if($view_val['cover'] == "basic"){ ?>
        <tr class="borderNone" height=100>
            <?php if($view_val['work_name'] <> "정기점검2"){ ?>
            <td colspan=4 class="borderNone" style="font-size:30px;font-weight:bold;text-align:center;">[<?php echo $view_val['customer'];?> 기술지원 보고서 ]</td>
            <?php }else{ ?>
            <td colspan=4 class="borderNone" style="font-size:30px;font-weight:bold;text-align:center;">[<?php echo $view_val['customer'];?> 정기점검 보고서 ]</td>
            <?php } ?>
        </tr>
        <tr class="borderNone" height=250>
            <td class="borderNone"></td>
            <td colspan=2 class="borderNone"></td>
            <td class="borderNone"></td>
        </tr>
        <tr class="borderNone">
            <td class="borderNone" colspan=4 style="font-size:20px;margin:0 auto;">
                <span width=50% style="position:relative;left:40%;">
                    고 객 명 : <?php echo $view_val['customer'];?>
                    <br>
                    작 성 일 : <?php echo date('Y년 m월 d일', strtotime($view_val['income_time']));?>
                    <br>
                    점 검 자 : <?php echo $view_val['writer'];?>
                    <br>
                    작 성 자 : <?php echo $view_val['writer'];?>
                </span>
            </td>
        </tr>
        <tr class="borderNone" height=250>
            <td class="borderNone"></td>
            <td class="borderNone" colspan=2></td>
            <td class="borderNone"></td>
        </tr>
        <tr class="borderNone" height=100>
            <td class="borderNone"></td>
            <td class="borderNone"></td>
            <td class="borderNone" colspan=2>
                <table align="center" border="1" width=400 cellpadding=0 cellspacing=0
                    style="float:right;text-align:center;">
                    <tr height="65">
                        <td>지원 엔지니어</td>
                        <td width=100><?php echo $view_val['writer'];?></td>
                        <td width=100>
                            <?php if($view_val['sign_consent']=="true"){echo "<img src='".$misc."img/".$view_val['writer'].".png' width = '60' height = '60'>";}?>
                        </td>
                    </tr>
                    <tr height="65">
                        <td>담당자</td>
                        <td width=100><?php if($view_val['signer']!=""){echo $view_val['signer'];}?></td>
                        <td width=100>
                            <?php if($view_val['customer_sign_consent']=="true"){echo "<img src='{$imageSrc}' height = '60' width = '60' >"; }?>
                        </td>
                    </tr>
                </table>
            </td>
            <?php }?>
    </table>
    <?php if($view_val['work_name'] == "정기점검2"){ ?>
    <table id="check_table" border=0.5 align="center" cellpadding=0 cellspacing=0 style="border-collapse:collapse;table-layout:fixed;width:100%;page-break-after: always;">
        <tr>
            <!-- <div class="header-space">&nbsp;</div> -->
            <td height=22 class=xl6723169 style='height:16.5pt'>점검대상</td>
            <td height=22 class=xl6723169 style='height:16.5pt'>특이사항</td>
        </tr>
        <?php
		$total_process_text = rtrim(str_replace(';','',$view_val['work_process']),'|');
		$total_process_text = explode('|||',$total_process_text); // 제품별 나누기
		$produce= explode(",",$view_val['produce']);

		if($view_val['host'] != ""){
			$host= explode(",",$view_val['host']);
		}

		for($a=0; $a < count($produce); $a++){
			$hostText = '';
			if($view_val['host'] != ""){
				if(trim($host[($a)]) != ""){
					$hostText = "(".trim($host[($a)]).")";
				}
			}
			echo '<tr>';
			echo "<td height=22 class=xl6723169 style='height:16.5pt;'>{$produce[$a]}{$hostText}</td>";
			echo "<td height=22 class=xl6723169 style='height:16.5pt;'>";
			$process_text = explode('@@',$total_process_text[$a]);
			// print_r($process_text);
			for($i=1; $i<count($process_text); $i++){
				if($i == 1){
				$process_text1 = explode('#*',$process_text[1]);
					echo $process_text1[2];
				}
			}
			echo "</td>";
			echo '</tr>';
		}
	?>
    </table>
    <?php }?>

                        <table border=0.5 cellpadding=0 cellspacing=0 width=730 style='border-collapse:collapse;table-layout:fixed;width:100%;'>
                            <col width=27 span=3 style='mso-width-source:userset;mso-width-alt:864;width:20pt'>
                            <col width=30 span=5 style='mso-width-source:userset;mso-width-alt:960;width:23pt'>
                            <col width=21 style='mso-width-source:userset;mso-width-alt:672;width:16pt'>
                            <col width=27 span=2 style='mso-width-source:userset;mso-width-alt:864;width:20pt'>
                            <col width=13 style='mso-width-source:userset;mso-width-alt:416;width:10pt'>
                            <col width=30 span=4 style='mso-width-source:userset;mso-width-alt:960;width:23pt'>
                            <col width=3 style='mso-width-source:userset;mso-width-alt:96;width:2pt'>
                            <col width=24 span=2 style='mso-width-source:userset;mso-width-alt:768;width:18pt'>
                            <col width=35 span=2 style='mso-width-source:userset;mso-width-alt:1120;width:26pt'>
                            <col width=65 style='mso-width-source:userset;mso-width-alt:2080;width:49pt'>
                            <col width=35 span=3 style='mso-width-source:userset;mso-width-alt:1120;width:26pt'>
                            <?php if($view_val['work_name'] <> "정기점검2"){ ?>
                            <tr height=22 style='mso-height-source:userset;height:16.5pt'>
                                <td colspan=25 rowspan=2 height=44 class=xl7423169 style='border-right:1.0pt solid black;border-bottom:1.0pt solid black;height:33.0pt'>기술지원보고서</td>
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
                                <td colspan=9 class=xl6723169 style='border-left:none'>
                                    <?php echo str_replace(';',' ',$view_val['customer_manager']);?></td>
                            </tr>
                            <tr height=22 style='height:16.5pt'>
                                <td colspan=4 height=22 class=xl6723169 style='height:16.5pt'>프로젝트명</td>
                                <td colspan=21 class=xl6723169 style='border-left:none; text-align:left;'>
                                    &nbsp;&nbsp;<?php echo $view_val['project_name'];?></td>
                            </tr>

                            <?php if($view_val['work_name']=="장애지원"){?>
                            <tr height=22 style='height:16.5pt'>
                                <td colspan=4 height="22" class=xl6723169 style='height:16.5pt'>장애구분</td>
                                <td colspan=9 class=xl6723169 style='border-left:none'>
                                    <?php echo $view_val['err_type'];?></td>
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
                                    <?php echo substr($view_val['income_time'], 0, 10);?></td>
                                <td colspan=3 class=xl6423169 style='border-left:none'>투입시간</td>
                                <td colspan=9 class=xl6523169 style='border-left:none'>
                                    <?php echo substr($view_val['total_time'],0,5);?></td>
                            </tr>
                            <tr height=22 style='height:16.5pt'>
                                <td colspan=4 height=22 class=xl6723169 style='height:16.5pt'>시작시간</td>
                                <td colspan=9 class=xl7023169 style='border-left:none'>
                                    <?php echo substr($view_val['start_time'],0,5);?></td>
                                <td colspan=3 class=xl6923169 style='border-left:none'>종료시간</td>
                                <td colspan=9 class=xl7023169 style='border-left:none'>
                                    <?php echo substr($view_val['end_time'],0,5);?></td>
                            </tr>
                            <tr height=22 style='height:16.5pt'>
                                <td colspan=4 height=22 class=xl6723169 style='height:16.5pt'>담당SE</td>
                                <td colspan=9 class=xl6723169 style='border-left:none'>
                                    <?php echo $view_val['engineer'];?></td>
                                <td colspan=3 class=xl6723169 style='border-left:none'>지원방법</td>
                                <td colspan=9 class=xl6723169 style='border-left:none'><?php echo $view_val['handle'];?>
                                </td>
                            </tr>
                            <tr height=37 style='mso-height-source:userset;'>
                                <td colspan=4 rowspan=2 height=74 class=xl6723169>지원시스템</td>
                                <td colspan=21 class=xl6723169 style='border-left:none'>제품명 / host / 버전 / 서버 / 라이선스</td>
                </td>
            </tr>
            <tr height=37 style='mso-height-source:userset;'>
                <td colspan=21 height=37 class=xl6723169
                    style='border-left:none;word-break:break-all;white-space:normal;text-align:center'>
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
				echo "<div>";
				for($i=1; $i<=count($produce); $i++){
					echo $produce[($i-1)].' / '.$host[($i-1)].' / '.$version[($i-1)].' / '.$hardware[($i-1)].' / '.$license[($i-1)].'<br>';
				}
				echo "</div>";
				?>
                </td>
            </tr>
            <tr height=28 style='mso-height-source:userset;height:21.0pt'>
                <td colspan=4 height=28 class=xl6723169 style='height:21.0pt'>작업명</td>
                <td colspan=21 class=xl9323169 style='border-left:none;padding-left:10px;padding-right:10px;'>
                    <?php echo $view_val['subject'];?></td>
            </tr>
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
				$time = explode("-",$tmp[$i]);
				?>
            <tr height=90 style='mso-height-source:userset;min-height:67.5pt'>
                <td colspan=2 height=90 class=xl6523169 style='min-height:67.5pt'><?php echo $time[0];?></td>
                <td colspan=2 class=xl6523169 style='border-left:none'><?php echo $time[1];?></td>
                <td colspan=21 class=xl8523169 width=619
                    style='border-right:.5pt solid black;border-left:none;width:467pt'>
                    <div id="work_text"><?php echo $process_txt[$i];?></div>
                </td>
            </tr>
            <?php
			}
		}else{
        $total_process_text = rtrim(str_replace(';','',$view_val['work_process']),'|');
        $total_process_text = explode('|||',$total_process_text); // 제품별 나누기

		$produce= explode(",",$view_val['produce']);
		if($view_val['host'] != ""){
			$host= explode(",",$view_val['host']);
		}
        $version= explode(",",$view_val['version']);
        $hardware= explode(",",$view_val['hardware']);
        $license= explode(",",$view_val['license']);
        for($a=0; $a < count($produce); $a++){
      ?>
        </table>
        <table border=0.5 align="center" cellpadding=0 cellspacing=0 style="border-collapse:collapse;table-layout:fixed;width:100%;page-break-after:always;" >
            <tr style='mso-height-source:userset;height:16.5pt'>
                <td colspan=25 rowspan=2 height=44 class=xl7423169 style='border-right:1.0pt solid black;border-bottom:1.0pt solid black;height:33.0pt'>정기점검보고서</td>
            </tr>
            <tr height=22 style='mso-height-source:userset;height:16.5pt'></tr>
            <tr class="borderNone" height=14 style='mso-height-source:userset;height:10.5pt'>
                <td colspan="25" height=14 class="borderNone" style='height:10.5pt'></td>
            </tr>
            <tr height=22 style='height:16.5pt'>
                <td colspan=4 height=22 class=xl6723169 style='height:16.5pt'>고객명</td>
                <td colspan=9 class=xl6723169 style='border-left:none;word-break:break-all;white-space:pre-wrap;'><?php echo $view_val['customer'];?></td>
                <td colspan=3 class=xl6723169 style='border-left:none'>담당자명</td>
                <td colspan=9 class=xl6723169 style='border-left:none'>
                    <?php echo str_replace(';',' ',$view_val['customer_manager']);?></td>
            </tr>
            <tr height=22 style='height:16.5pt'>
                <td colspan=4 height=22 class=xl6723169 style='height:16.5pt'>프로젝트명</td>
                <td colspan=21 class=xl6723169 style='border-left:none; text-align:left;'>
                    &nbsp;&nbsp;<?php echo $view_val['project_name'];?></td>
            </tr>
            <tr height=22 style='height:16.5pt'>
                <td colspan=4 height=22 class=xl6623169 style='height:16.5pt'>날짜</td>
                <td colspan=9 class=xl6823169 style='border-left:none'>
                    <?php echo substr($view_val['income_time'], 0, 10);?></td>
                <td colspan=3 class=xl6423169 style='border-left:none'>투입시간</td>
                <td colspan=9 class=xl6523169 style='border-left:none'><?php echo substr($view_val['total_time'],0,5);?>
                </td>
            </tr>
            <tr height=22 style='height:16.5pt'>
                <td colspan=4 height=22 class=xl6723169 style='height:16.5pt'>시작시간</td>
                <td colspan=9 class=xl7023169 style='border-left:none'><?php echo substr($view_val['start_time'],0,5);?>
                </td>
                <td colspan=3 class=xl6923169 style='border-left:none'>종료시간</td>
                <td colspan=9 class=xl7023169 style='border-left:none'><?php echo substr($view_val['end_time'],0,5);?>
                </td>
            </tr>
            <tr height=22 style='height:16.5pt'>
                <td colspan=4 height=22 class=xl6723169 style='height:16.5pt'>담당SE</td>
                <td colspan=9 class=xl6723169 style='border-left:none'><?php echo $view_val['engineer'];?></td>
                <td colspan=3 class=xl6723169 style='border-left:none'>지원방법</td>
                <td colspan=9 class=xl6723169 style='border-left:none'><?php echo $view_val['handle'];?></td>
            </tr>
            <tr height=28 style='mso-height-source:userset;height:21.0pt'>
                <td colspan=4 height=28 class=xl6723169 style='height:21.0pt'>작업명</td>
                <td colspan=21 class=xl6723169 style='border-left:none; text-align:left;'>
                    &nbsp;&nbsp;<?php echo $view_val['subject'];?></td>
            </tr>
            <tr class="borderNone" height=14 style='mso-height-source:userset;height:10.5pt'>
                <td colspan="25" height=14 class="borderNone" style='height:10.5pt'></td>
            </tr>
            <tr height=37 style='mso-height-source:userset;'>
                <td colspan=4 rowspan=2 height=74 class=xl6723169>지원시스템</td>
                <td colspan=3 class=xl6723169 style='border-left:none'>제품명(host)</td>
                <td colspan=6 class=xl8823169 width=148 style='border-left:none;width:112pt'>
                    <input type="hidden" name="currentPage" id="currentPage" class="input2_red" value=1 />
        <?php
        $hostText="";
        if($view_val['host'] != ""){
            if(trim($host[$a])!=''){
                $hostText="(".trim($host[$a]).")";
            }
        }
        echo $produce[$a].$hostText;
        ?>
                <td colspan=3 class=xl6723169 style='border-left:none'>버전정보</td>
                <td colspan=9 class=xl6723169 style='border-left:none'>
                    <?php echo $version[$a];?>
                </td>
            </tr>
            <tr height=37 style='mso-height-source:userset;'>
                <td colspan=3 height=37 class=xl6723169 style='border-left:none;'>서버</td>
                <td colspan=6 class=xl6723169 width=148 style='border-left:none;width:112pt;word-break:break-all; white-space:pre-line;'><?php echo $hardware[$a]; ?></td>
                <td colspan=3 class=xl6723169 style='border-left:none'>라이선스</td>
                <td colspan=9 class=xl6723169 style='border-left:none'><?php echo $license[$a]; ?></td>
            </tr>
            <tr class="borderNone">
                <td colspan="25" height="40" align="center" style="font-weight:bold;" class="t_border borderNone">
                    <table id="work_text_table<?php echo ($a+1) ;?>" class="work_text_table" frame=void width=100% border=0 cellpadding=0 cellspacing=0 style='border-collapse:collapse;table-layout:fixed;width:100%;border-bottom:1px;'>
                        <tr>
                            <th width="126" height=22><input value="점검항목" readonly onfocus="javascrpt:blur();"
                                    style="cursor:default; font-weight:bold; border:none; text-align:center; width:95%; height:95%;"></input>
                            </th>
                            <th colspan="2" height=22><input value="점검내용" readonly onfocus="javascrpt:blur();"
                                    style="cursor:default; font-weight:bold; border:none; text-align:center; width:95%; height:95%;"></input>
                            </th>
                            <th height=22><input value="점검결과" readonly onfocus="javascrpt:blur();"
                                    style="cursor:default; font-weight:bold; border:none; text-align:center; width:95%; height:95%;"></input>
                            </th>
                            <th height=22><input value="특이사항" readonly onfocus="javascrpt:blur();"
                                    style="cursor:default; font-weight:bold; border:none; text-align:center; width:95%; height:95%;"></input>
                            </th>
                        </tr>
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
                        echo '<tr height="35"><td>'.$process_text1[$j].'</td>';
                        }else{
                        echo '<td colspan="4">'.$process_text1[$j].'</td></tr>';
                        }
                    }
                    }
                }
                        ?>
                    </table>
                </td>
            </tr>
        </table>
<?php }?>
<table border=0.5 cellpadding=0 cellspacing=0 width=730 style='border-collapse:collapse;table-layout:fixed;width:100%;'>
    <tr height=55 style='mso-height-source:userset;min-height:41.25pt'>
        <td colspan=4 width="126" height=55 class=xl8023169 style='min-height:41.25pt'>지원의견</td>
        <td colspan=21 class=xl8223169 width=619 style='border-right:.5pt solid black;width:467pt'><?php echo $view_val['comment'];?></td>
    </tr>
</table>
<?php } ?>
<?php if($view_val['work_name'] != "정기점검2"){ ?>
    <tr height=55 style='mso-height-source:userset;min-height:41.25pt'>
        <td colspan=4 height=55 class=xl8023169 style='min-height:41.25pt'>지원의견</td>
        <td colspan=21 class=xl8223169 width=619 style='border-right:.5pt solid black;width:467pt'><?php echo $view_val['comment'];?></td>
    </tr>
    <tr height=55 style='mso-height-source:userset;min-height:41.25pt'>
        <td colspan=4 height=55 class=xl8023169 style='min-height:41.25pt'>지원결과</td>
        <td colspan=21 class=xl8223169 width=619 style='border-right:.5pt solid black;width:467pt;padding-left:10px;padding-right:10px;'><?php echo $view_val['result'];?></td>
    </tr>
</table>
<?php } ?>
<script language="javascript">
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

<?php
if ($view_val['cover'] != "basic") {
    $durian_sign = explode(",", "{$cover[0]['durian_sign']}");
    $customer_sign = explode(",", "{$cover[0]['customer_sign']}");
    $subject = explode(",", "{$cover[0]['subject']}");
    $income_time = explode(",", "{$cover[0]['income_time']}");
    $customer_company = explode(",", "{$cover[0]['customer_company']}");
    $writer = explode(",", "{$cover[0]['writer']}");
    $durian_engineer = explode(",", "{$cover[0]['durian_engineer']}");
    $customer_manager = explode(",", "{$cover[0]['customer_manager']}");

?>
    $("#durian_sign").css({
        position: 'absolute',
        top: '<?php echo $durian_sign[0]; ?>',
        left: '<?php echo $durian_sign[1]; ?>'
    });
    $("#durian_sign").height('<?php echo $durian_sign[2]; ?>');
    $("#durian_sign").width('<?php echo $durian_sign[3]; ?>');

    $("#customer_sign").css({
        position: 'absolute',
        top: '<?php echo $customer_sign[0]; ?>',
        left: '<?php echo $customer_sign[1]; ?>'
    });
    $("#customer_sign").height('<?php echo $customer_sign[2]; ?>');
    $("#customer_sign").width('<?php echo $customer_sign[3]; ?>');

    $("#subject").css({
        position: 'absolute',
        top: '<?php echo $subject[0]; ?>',
        left: '<?php echo $subject[1]; ?>'
    });
    $("#subject").height('<?php echo $subject[2]; ?>');
    $("#subject").width('<?php echo $subject[3]; ?>');

    $("#income_time").css({
        position: 'absolute',
        top: '<?php echo $income_time[0]; ?>',
        left: '<?php echo $income_time[1]; ?>'
    });
    $("#income_time").height('<?php echo $income_time[2]; ?>');
    $("#income_time").width('<?php echo $income_time[3]; ?>');

    $("#customer_company").css({
        position: 'absolute',
        top: '<?php echo $customer_company[0]; ?>',
        left: '<?php echo $customer_company[1]; ?>'
    });
    $("#customer_company").height('<?php echo $customer_company[2]; ?>');
    $("#customer_company").width('<?php echo $customer_company[3]; ?>');

    $("#writer").css({
        position: 'absolute',
        top: '<?php echo $writer[0]; ?>',
        left: '<?php echo $writer[1]; ?>'
    });
    $("#writer").height('<?php echo $writer[2]; ?>');
    $("#writer").width('<?php echo $writer[3]; ?>');

    $("#durian_engineer").css({
        position: 'absolute',
        top: '<?php echo $durian_engineer[0]; ?>',
        left: '<?php echo $durian_engineer[1]; ?>'
    });
    $("#durian_engineer").height('<?php echo $durian_engineer[2]; ?>');
    $("#durian_engineer").width('<?php echo $durian_engineer[3]; ?>');

    $("#customer_manager").css({
        position: 'absolute',
        top: '<?php echo $customer_manager[0]; ?>',
        left: '<?php echo $customer_manager[1]; ?>'
    });
    $("#customer_manager").height('<?php echo $customer_manager[2]; ?>');
    $("#customer_manager").width('<?php echo $customer_manager[3]; ?>');

<?php } ?>
</script>
</body>

</html>

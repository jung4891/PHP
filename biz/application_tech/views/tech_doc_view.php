<?php
  // 김수성 추가
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/customer_top.php";
require_once $this->input->server('DOCUMENT_ROOT')."/include/KISA_SEED_CBC.php";

$g_member = array();
foreach($group_member as $member){
  array_push( $g_member, $member['user_name'] );
}
/////////////////////     읽기 권한    /////////////////////
if(substr($at,0,1) < 4){ //본인 읽기 권한 x
  if ($view_val['writer'] == $name){
    echo "<script>alert('본인 글에 읽기 권한이 없습니다.');history.go(-1);</script>";
    echo exit;
  }else{
    if(substr($at,1,1) < 4){//같은팀 읽기 권한 없음
      if (in_array($view_val['writer'], $g_member)) {//같은팀
        echo "<script>alert('같은 부서 사용자 글에 읽기 권한이 없습니다.');history.go(-1);</script>";
        echo exit;
      }else{// 같은팀x
        if(substr($at,2,1) < 4){
          echo "<script>alert('다른 사용자 글에 읽기 권한이 없습니다.');history.go(-1);</script>";
          echo exit;
        }
      }
    }else{
      if(substr($at,2,1) < 4){
        if(!in_array($view_val['writer'], $g_member)){
          echo "<script>alert('다른 사용자 글에 읽기 권한이 없습니다.');history.go(-1);</script>";
          echo exit;
        }
      }
    }
  }
}else{
  if ($view_val['writer'] != $name){
    if(substr($at,1,1) < 4){//같은팀 읽기 권한 없음
      if (in_array($view_val['writer'], $g_member)) {//같은팀
        echo "<script>alert('같은 부서 사용자 글에 읽기 권한이 없습니다.');history.go(-1);</script>";
        echo exit;
      }else{// 같은팀x
        if(substr($at,2,1) < 4){
          echo "<script>alert('다른 사용자 글에 읽기 권한이 없습니다.');history.go(-1);</script>";
          echo exit;
        }
      }
    }else{
      if(substr($at,2,1) < 4){
        if(!in_array($view_val['writer'], $g_member)){
          echo "<script>alert('다른 사용자 글에 읽기 권한이 없습니다.');history.go(-1);</script>";
          echo exit;
        }
      }
    }
  } 
}

/////////////////////     읽기 권한 끝    /////////////////////
?>

<style>
  .login_input {

		width: 150px;
		height: 20px;
	
	}
  .work_text{
    padding-left:10px;
    padding-right:10px;
  }

  .work_text_table{
    margin-left:auto;
    margin-right:auto;
    margin-top: 10px;
    margin-bottom: 10px;
  }

  .work_text_table
  td{padding-left:10px;padding-right:10px;word-break:break-all;word-break:break-word}textarea {font-family:'Nanum Gothic', '나눔고딕', Tahoma, 'Georgia', '맑은 고딕', sans-serif; line-height:150%; font-size:12px; color:#333; border:none; border-right:0px; border-top:0px; border-left:0px; border-bottom:0px; width:90%; height:90%; overflow-y:hidden; resize:none;} input {border:none; border-right:0px; border-top:0px; border-left:0px; border-bottom:0px;}
  
  td{
    word-break:break-all;
    word-break:break-word;
  }

  .work_text_table td{
    border-top:1px solid;
    border-right:1px solid;
    border-color:#d7d7d7;
  }

  .work_text_table th{
    border-top:1px solid;
    border-right:1px solid;
    border-color:#d7d7d7;
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
			for($i=0;$i< sizeof($bszPlainText);$i++) {
				$planBytresMessage .=  sprintf("%02X", $bszPlainText[$i]).",";
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

<script language="javascript">
  function chkForm( type ) {
    if(type == 1) {
      <?php
        if(substr($at,0,1) != 1 && substr($at,0,1) != 3 && substr($at,0,1) != 5 && substr($at,0,1) != 7){ //본인 수정 권한 x
          if ($view_val['writer'] == $name){
      ?>
      alert('본인 글에 삭제 권한이 없습니다.');
      return false;
      <?php

          }else{
            if(substr($at,1,1) != 1 && substr($at,1,1) != 3 && substr($at,1,1) != 5 && substr($at,1,1) != 7){//같은팀 수정 권한 없음
              if (in_array($view_val['writer'], $g_member)) {//같은팀
      ?>
      alert('같은 부서 사용자 글에 삭제 권한이 없습니다.');
      return false;
      <?php
              }else{// 같은팀x
                if(substr($at,2,1) != 1 && substr($at,2,1) != 3 && substr($at,2,1) != 5 && substr($at,2,1) != 7){
      ?>
       alert('다른 사용자 글에 삭제 권한이 없습니다.');
        return false;
      <?php            
                }
              }
            }else{
              if(substr($at,2,1) != 1 && substr($at,2,1) != 3 && substr($at,2,1) != 5 && substr($at,2,1) != 7){
                if(!in_array($view_val['writer'], $g_member)){
      ?>
      alert('다른 사용자 글에 삭제 권한이 없습니다.');
      return false;
      <?php
                }
              }
            }
          }
        }else{
          if ($view_val['writer'] != $name){
            if(substr($at,1,1) != 1 && substr($at,1,1) != 3 && substr($at,1,1) != 5 && substr($at,1,1) != 7){//같은팀 수정 권한 없음
              if (in_array($view_val['writer'], $g_member)) {//같은팀
      ?>
      alert('같은 부서 사용자 글에 삭제 권한이 없습니다.');
      return false;
      <?php
              }else{// 같은팀x
                if(substr($at,2,1) != 1 && substr($at,2,1) != 3 && substr($at,2,1) != 5 && substr($at,2,1) != 7){
      ?>
      alert('다른 사용자 글에 삭제 권한이 없습니다.');
      return false;
      <?php
                }
              }
            }else{
              if(substr($at,2,1) != 1 && substr($at,2,1) != 3 && substr($at,2,1) != 5 && substr($at,2,1) != 7){
                if(!in_array($view_val['writer'], $g_member)){
      ?>
      alert('다른 사용자 글에 삭제 권한이 없습니다.');
      return false;
      <?php
                }
              }
            }
          } 
        }
      ?> 
      if (confirm("정말 삭제하시겠습니까?") == true){
        var mform = document.cform;
        mform.action="<?php echo site_url();?>/tech_board/tech_doc_delete_action";
        mform.submit();
        return false;
      }
    }else if(type == 2) {
      //var mform = document.cform;

      // mform.action="<?php echo site_url();?>/tech_board/tech_doc_print_action";
      window.open("<?php echo site_url();?>/tech_board/tech_doc_print_action?seq=<?php echo $_GET['seq']?>", "cform", 'scrollbars=yes,width=850,height=600'); 
      //mform.submit();
      return false;
    }else if(type==3){
      var mailConfirm = confirm("메일을 전송하시겠습니까?");
      if(mailConfirm == true){
        var mform = document.cform;
        mform.mail_send.value='Y';
        mform.send_ck.value='Y';
      //	mform.action="http://dev_tech.durianit.co.kr/index.php/tech_board/tech_report_csv?seq=<?php echo $_GET['seq'];?>";
        mform.action="<?php echo site_url();?>/tech_board/tech_report_csv?seq=<?php echo $_GET['seq'];?>";
        mform.submit();
      }else{
        return false;
      }
  	}else {
      var mform = document.cform;
      mform.action="<?php echo site_url();?>/tech_board/tech_doc_view";
      mform.submit();
      return false;
    }
  }

</script>
<body>
  <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
    <script src="<?php echo $misc;?>ckeditor/ckeditor.js"></script>
    <?php
      include $this->input->server('DOCUMENT_ROOT')."/include/tech_header.php";
    ?>
  <tr>
    <td align="center" valign="top">
      <table width="1130" height="100%" cellspacing="0" cellpadding="0">
        <tr>
<?php if($view_val['work_name'] == "정기점검2" && strpos($view_val['produce'],',') !== false){ ?>
          <td><img src="<?php echo $misc; ?>img/btn_left.jpg" id="leftBtn" style="float:right;cursor:pointer;"
              onclick="changePage('left')" /></td>
<?php } ?>
          <td width="923" align="center" valign="top">

            <!-- 시작합니다. 여기서 부터  -->
            <form name="cform" method="get">
              <input type="hidden" name="seq" value="<?php echo $seq;?>">
              <input type="hidden" name="mode" value="modify">
              <input type="hidden" name="pdf_type" value=0> 
              <input type="hidden" id="mail_send" name="mail_send" value="<?php echo $view_val['mail_send'];?>">
              <input type="hidden" id="send_ck" name="send_ck">
              <table width="890" border="0" style="margin-top:20px;">
                <tr>
                  <td class="title3">
                    <table height=50 style="border-collapse:collapse;">
                      <tr>
                        <td width="65%"></td>
                        <td width="150px" height="15" style="font-weight:bold;font-size: 12px; border: 1px solid #4444;"
                          class="t_border"><?php echo $view_val['customer']?> : 서명 <input type="checkbox"
                            id="customer_sign_consent" name="customer_sign_consent"
                            value="<?php echo $view_val['customer_sign_consent'] ?>"></td>
                        <td width="150px" height="15"
                          style="padding-left:10px;font-size: 12px; border: 1px solid #4444;" class="t_border">두리안 :
                          서명<input type="checkbox" id="sign_consent" name="sign_consent"
                            value="<?php echo $view_val['sign_consent'] ?>"></td>
                      </tr>
                      <tr>
                        <td width="63%">기술지원보고서 보기</td>
                        <td width="150px" height="50" align="center"
                          style="font-weight:bold;font-size: 12px; border: 1px solid #4444;" class="t_border">
                          <div id="customer_sign"></div>
                        </td>
                        <td width="150px" height="50" align="center"
                          style="font-weight:bold;font-size: 12px; border: 1px solid #4444;" class="t_border">
                          <div id="sign"></div>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <!-- <td>&nbsp;</td> -->
                </tr>
                <tr>
                  <td>
                    <table width="890" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td colspan="5" height="2" bgcolor="#797c88"></td>
                      </tr>
                      <tr>
                      <tr>
                        <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9"
                          style="font-weight:bold;" class="t_border">고객사</td>
                        <td width="35%" style="padding-left:10px;" class="t_border"><?php echo $view_val['customer'];?>
                        </td>
                        <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;"
                          class="t_border">등록자</td>
                        <td width="35%" align="center" class="t_border"><?php echo $view_val['writer'];?></td>
                      </tr>
                      <tr>
                        <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                      </tr>
                      <!-- 프로젝트명 추가 -->
                      <tr>
                        <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9"
                          style="font-weight:bold;" class="t_border">프로젝트명</td>
                        <td width="35%" style="padding-left:10px;" class="t_border">
                          <?php echo $view_val['project_name'];?>
                        </td>
                        <td width="15%" height="40" align="center" bgcolor="f8f8f9"
                          style="font-weight:bold;" class="t_border">표지</td>
                        <td width="35%" style="padding-left:10px;" class="t_border">
                          <?php
                            if($view_val['cover'] == "basic"){
                              echo "기본";
                            }else{
                              echo $cover[0]['cover_name'];
                            }
                          ?>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                      </tr>
                      <!-- 프로젝트명 추가 끝 -->
                      <tr>
                        <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9"
                          style="font-weight:bold;" class="t_border">작업명(종류)</td>
                        <td width="35%" style="padding-left:10px;" class="t_border"><input id="work_name"
                            value="<?php echo $view_val['work_name'];?>" readonly onfocus="javascrpt:blur();"
                            style="cursor:default;border:none;font-size: 12px;"></input></td>
                        <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;"
                          class="t_border">작업일</td>
                        <td width="35%" style="padding-left:10px;" class="t_border">
                          <?php echo substr($view_val['income_time'], 0, 10);?></td>
                      </tr>

<?php if($view_val['work_name']=="장애지원"){?>
              <tr>
                <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
              </tr>
              <tr>
                <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border" >장애구분</td>
                <td width="35%" style="padding-left:10px;"class="t_border"><?php echo $view_val['err_type'];?></td>
                <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border" >심각도</td>
                <td width="35%" style="padding-left:10px;" class="t_border" ><?php 
					switch($view_val['warn_level']){
						case '001': echo "전체서비스중단";break;
						case '002': echo "일부서비스중단/서비스지연";break;
						case '003': echo "관리자불편/대고객신뢰도저하";break;
						case '004': echo "특정기능장애";break;
						case '005': echo "서비스무관단순장애";break;
					}?></td>
              </tr>
              <tr>
                <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
              </tr>

              <tr>
                <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border" >장애유형</td>
                <td width="35%" style="padding-left:10px;"class="t_border"><?php
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
                <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border" >장애처리방법</td>
                <td width="35%" style="padding-left:10px;" class="t_border" ><?php
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
              <tr>
                <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
              </tr>

              <!-- 여기서부터 해야되는데 -->
              <tr>
                <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border" >담당자명</td>
                <td width="35%" style="padding:10px;"class="t_border" ><?php echo $view_val['customer_manager'];?></td>
                <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border"  >이메일</td>
                <td width="35%" style="padding:10px;word-break:break-all;white-space:pre-wrap;" class="t_border" ><?php echo $view_val['manager_mail'];?></td>
              </tr>
              <tr>
                <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
              </tr>
              <tr>
                <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border" >시작시간</td>
                <td width="35%" style="padding-left:10px;" class="t_border" ><?php echo substr($view_val['start_time'],0,5);?></td>
                <td width="15%"align="center" bgcolor="f8f8f9"  style="font-weight:bold;" class="t_border" >종료시간</td>
                <td width="35%" style="padding:10px;" class="t_border" ><?php echo substr($view_val['end_time'],0,5);?></td>
              </tr>
              <tr>
                <td colspan="5" height="1" bgcolor="#e8e8e8" class="t_border" ></td>
              </tr>
              <tr>
                <td width="15%" colspan="2" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border" >담당SE</td>
                <td width="35%" style="padding-left:10px;" class="t_border" ><?php echo $view_val['engineer'];?></td>
                <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border" >지원방법</td>
                <td width="35%" style="padding-left:10px;" class="t_border" ><?php echo $view_val['handle'];?></td>
              </tr>
              <tr>
                <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
              </tr>
              <tr>
                <td width="15%" colspan="2" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border" >제품명/host/버전/서버/라이선스<?php if((trim($view_val['customer']) == "SKB(유통망)" || trim($view_val['customer']) == "SKB(과금망)") && strpos($view_val['produce'],',')=== false) {echo "/serial";} ?></td>
                <td width="35%" colspan="3" style="padding-left:10px;" class="t_border">
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
                        echo '<li id="li'.$i.'"><span style="cursor:pointer;" id="produce'.$i.'" class="click_produce" onclick="clickProduce('.$i.')"><span class="produce">'.$produce[($i-1)].'</span> / <span class="host">'.$host[($i-1)].'</span> / <span class="version">'.$version[($i-1)].'</span> / <span class="hardware">'.$hardware[($i-1)].'</span> / <span class="license">'.$license[($i-1)].'</span>';
                        if((trim($view_val['customer']) == "SKB(유통망)" || trim($view_val['customer']) == "SKB(과금망)") && strpos($view_val['produce'],',')=== false){
                          echo '/ <span class="serial">'.$sn[($i-1)].'</span></span></li>';
                        }else{
                          '<span class="serial" style="display:none;">'.$sn[($i-1)].'</span></span></li>';
                        } 
                      }
                    ?>
                  </ul>
                </td>
             </tr>
             <tr>
              <td colspan="5" height="1" bgcolor="#797c88"></td>
            </tr>
            <tr>
              <td width="15%" colspan="2" size="100" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border" >지원내용</td>
              <td colspan="3"  style="padding-left:10px;" class="t_border" ><?php echo $view_val['subject'];?>
              </td>
            </tr>
<?php if($view_val['work_name'] != "정기점검2"){ ?>
            <tbody id ="nonPeriodic">
              <tr>
                <td colspan="5" height="1" bgcolor="#797c88"></td>
              </tr>
              <tr>
                <td colspan="2" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">시간</td>
                <td height="40" colspan="3" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">지원내역</td>

              </tr>
              <tr>
                <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
              </tr>

              <?php
              $tmp = explode(";;", $view_val['work_process_time']);
              $process_txt =  explode(";;", $view_val['work_process']);

              for($i=0;$i<count($tmp)-1;$i++){
                $time = explode("-",$tmp[$i]);
              ?>
                <tr>
                  <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">
                    <?php echo $time[0];?>
                  </td>
                  <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">
                    <?php echo $time[1];?>
                  </td>
                  <td colspan="4" height="40" align="left" class="t_border">
                    <div id="work_text"><?php echo nl2br($process_txt[$i]);?></div>

                  </td>
                </tr>
                <tr>
                  <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                </tr>
            <?php
              }
            ?>
            </tbody>
<?php }else{?>
            <!-- 정기점검2 -->
            <tbody id ="periodic">
             <tr>
              <td colspan="5" height="40" align="center" style="font-weight:bold;" class="t_border">
                <?php
                  function br2nl($string){
                    return preg_replace('/\<br(\s*)?\/?\>/i', "\n", $string); 
                  }
                  $total_process_text = rtrim(str_replace(';','',br2nl($view_val['work_process'])),'|');
                  $total_process_text = explode('|||',$total_process_text); // 제품별 나누기
                  for($a=0; $a<count($total_process_text); $a++){
                ?>
                    <table id="work_text_table<?php echo ($a+1) ;?>" class="work_text_table" height=100% width=890 border=0 style="display:none;border-collapse:collapse;table-layout:fixed;border-right:none;border-left:none";>
                      <tr>
                        <th width="14.9%" height="30" bgcolor="f8f8f9"><input value="점검항목" readonly onfocus="javascrpt:blur();" style="width:100%;cursor:default; font-weight:bold; border:none; text-align:center; background-color:transparent;"></input></th>
                        <th colspan="2" height="30" bgcolor="f8f8f9"><input value="점검내용" readonly onfocus="javascrpt:blur();" style="width:100%;cursor:default; font-weight:bold; border:none; text-align: center; background-color:transparent;" ></input></th>
                        <th width="15%" height="30" bgcolor="f8f8f9"><input value="점검결과" readonly onfocus="javascrpt:blur();" style="width:100%;cursor:default; font-weight:bold; border:none; text-align: center; background-color:transparent;"></input></th>
                        <th width="30%" height="30" bgcolor="f8f8f9"><input value="특이사항" readonly onfocus="javascrpt:blur();" style="width:100%;cursor:default; font-weight:bold; border:none; text-align: center; background-color:transparent;"></input></th>
                      </tr>
                      <?php   
                      $process_text = explode('@@',$total_process_text[$a]); //점검항목 별로 나누기
                      for($i=1; $i<count($process_text); $i++){
                        if($i <> 1){ //기타 특이사항을 제외한 나머지
                          $process_text1 = explode('#*',$process_text[$i]);
                          for($j=1; $j<count($process_text1); $j++){
                            if($j==1){
                              echo '<tr><td height="30" rowspan="'.floor((count($process_text1)-1)/3).'">'.$process_text1[$j].'</td>'; //cpu, 메모리 
                            }elseif($j<=4){ //점검항목 중 첫번째 점검내용 
                              if($j!=4){
                                if($j%3==0){
                                  if($process_text1[$j] == "normal"){
                                    echo '<td align="center" style="font-weight:normal;">정상</td>';
                                  }else if($process_text1[$j] == "abnormal"){
                                    echo '<td align="center" style="font-weight:normal;">비정상</td>';
                                  }else{
                                    echo '<td></td>';
                                  }
                                }else{
                                  if(strpos($process_text1[$j],"::") === false){
                                    if($process_text1[$j] == "::"){
                                      $text = explode('::',$process_text1[$j]);
                                      echo '<td><textarea onkeyup="xSize(this)" onfocus="javascrpt:blur();" readonly="readonly" disabled;>'.$text[0].'</textarea></td>';
                                      echo '<td><textarea onkeyup="xSize(this)" onfocus="javascrpt:blur();" readonly="readonly" disabled;>'.$text[1].'</textarea></td>';
                                    }else{
                                      echo '<td colspan="2"><textarea onkeyup="xSize(this)" onfocus="javascrpt:blur();" readonly="readonly" disabled;>'.$process_text1[$j].'</textarea></td>';
                                    }
                                  }else{
                                    $text = explode('::',$process_text1[$j]);
                                    echo '<td><textarea onkeyup="xSize(this)" onfocus="javascrpt:blur();" readonly="readonly" disabled;>'.$text[0].'</textarea></td>';
                                    echo '<td><textarea onkeyup="xSize(this)" onfocus="javascrpt:blur();" readonly="readonly" disabled;>'.$text[1].'</textarea></td>';
                                  }    
                                }
                              }else{
                                echo '<td><textarea onkeyup="xSize(this)" onfocus="javascrpt:blur();" readonly="readonly" disabled;>'.$process_text1[$j].'</textarea></td></tr>'; 
                              }
                            }else{ //점검 항목 중 첫번 째가 아닌 나머지들 
                              if($j%3==2){
                                if(strpos($process_text1[$j],"::") === false){
                                  if($process_text1[$j] == "::"){
                                    $text = explode('::',$process_text1[$j]);
                                    echo '<td><textarea onkeyup="xSize(this)" onfocus="javascrpt:blur();" readonly="readonly" disabled;>'.$text[0].'</textarea></td>';
                                    echo '<td><textarea onkeyup="xSize(this)" onfocus="javascrpt:blur();" readonly="readonly" disabled;>'.$text[1].'</textarea></td>';
                                  }else{
                                    echo'<tr><td colspan="2"><textarea onkeyup="xSize(this)" onfocus="javascrpt:blur();" readonly="readonly" disabled;>'.$process_text1[$j].'</textarea></td>';
                                  }
                                }else{
                                  $text = explode('::',$process_text1[$j]);
                                  echo '<tr><td><textarea onkeyup="xSize(this)" onfocus="javascrpt:blur();" readonly="readonly" disabled;>'.$text[0].'</textarea></td>';
                                  echo '<td><textarea onkeyup="xSize(this)" onfocus="javascrpt:blur();" readonly="readonly" disabled;>'.$text[1].'</textarea></td>';
                                }  
                              }elseif($j%3==0){
                                if($process_text1[$j] == "normal"){
                                  echo '<td align="center" style="font-weight:normal;">정상</td>';
                                }else if($process_text1[$j] == "abnormal"){
                                  echo '<td align="center" style="font-weight:normal;">비정상</td>';
                                }else{
                                  echo '<td></td>';
                                }
                              }elseif($j%3==1){
                                echo '<td ><textarea onkeyup="xSize(this)" onfocus="javascrpt:blur();" readonly="readonly" disabled;>'.$process_text1[$j].'</textarea></td></tr>';
                              }
                            }          
                          }
                        }
                      }
                      //기타 특이사항
                      for($i=1; $i<count($process_text); $i++){
                        if($i == 1){ //기타 특이사항을 제외한 나머지
                          $process_text1 = explode('#*',$process_text[$i]);
                          for($j=1; $j<count($process_text1); $j++){
                            if($j+1 <> count($process_text1)){
                              echo '<tr><td>'.$process_text1[$j].'</td>';
                            }else{
                              echo '<td colspan="4"><textarea onkeyup="xSize(this)" onfocus="javascrpt:blur();" readonly="readonly" disabled;>'.$process_text1[$j].'</textarea></td></tr>';
                            } 
                          }
                        }
                      }
                      ?>
                    </table>
                <?php } ?>
              </td>
             </tr>
            </tbody>
<?php }?>
            <!-- 정기점검2끝 -->

              <tr>
                <td colspan="5" height="1" bgcolor="#797c88"></td>
              </tr>
              <tr>
                <td colspan="2" size="100" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border" >지원의견</td>
                <td colspan="3" style="padding-left:10px;" class="t_border" ><?php echo $view_val['comment'];?></td>
              </tr>
              <?php if($view_val['work_name'] != "정기점검2"){ ?>
              <tr>
                <td colspan="5" height="1" bgcolor="#797c88"></td>
              </tr>
              <tr>
                <td colspan="2" size="100" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border" >지원결과</td>
                <td colspan="3" style="padding-left:10px;" class="t_border" ><?php echo $view_val['result'];?></td>
              </tr>
              <?php } ?>
            <tr>
              <td colspan="5" height="1" bgcolor="#797c88"></td>
            </tr>
            <tr>
              <td class="t_border" colspan="2" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">첨부파일</td>
              <td class="t_border" style="padding-left:10px;" colspan="3"><?php if($view_val['file_changename']) {?><a href="<?php echo site_url();?>/tech_board/tech_doc_download/<?php echo $seq;?>/<?php echo $view_val['file_changename'];?>"><?php echo $view_val['file_realname'];?></a><?php } else {?>파일없음<?php }?> </td>
            </tr>
              <tr>
                <td colspan="5" height="2" bgcolor="#797c88"></td>
              </tr>
            </table></td>
          </tr<td>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>
              <span style="float:left">
                <img src="<?php echo $misc;if($view_val['mail_send']=="N"){echo 'img/btn_send.jpg';}else{echo 'img/btn_resend.jpg';}?>" border="0" style="width:64px;hight:31px;cursor:pointer" onClick="chkForm(3);return false;"/>
                <input type="button" class="basicBtn" value="<?php if($view_val['mail_send']=="N"){echo 'PDF전송';}else{echo 'PDF재전송';} ?>" onclick="pdfMail();">
              </span>
              <span style="float:right">
                <img src="<?php echo $misc;?>img/btn_list.jpg" border="0" style="cursor:pointer" onClick="javascript:history.go(-1);"/>
                <img src="<?php echo $misc;?>img/btn_print.jpg" border="0" style="cursor:pointer;width:64px;height:31px;" onClick="chkForm(2);return false;"/>
                <img src="<?php echo $misc;?>img/btn_adjust.jpg" style="cursor:pointer" border="0" onClick="javascript:chkForm(0);return false;"/> <img src="<?php echo $misc;?>img/btn_add_column4.jpg" style="cursor:pointer;width:64px;hight:31px;" border="0" onClick="javascript:chkForm(1);return false;"/>
              </span>
              <div id="dialog" title="비밀번호를 입력하세요">
                <input id="passwordCheck" type="password" size="30" style="height:28px;" />
              </div>
            </td>
          </tr>
          <tr>
                <td>&nbsp;</td>
          </tr>
            </table>
          </td>
          <?php if($view_val['work_name'] == "정기점검2" && strpos($view_val['produce'],',') !== false){ ?>  
           <td><img src="<?php echo $misc; ?>img/btn_right.jpg" id="rightBtn" onclick="changePage('right');" style="cursor:pointer;" /></td>
          <?php } ?>
      </tr>
      </table>

    </td>

  </tr>


	</form>

<!-- 폼 끝 -->
<tr>
 <td align="center" height="100" bgcolor="#CCCCCC"><table width="1130" cellspacing="0" cellpadding="0" >
  <tr>
    <td width="197" height="100" align="center" background="<?php echo $misc;?>img/customer_f_bg.png"><img src="<?php echo $misc;?>img/f_ci.png"/></td>
    <td><?php include $this->input->server('DOCUMENT_ROOT')."/include/customer_bottom.php"; ?></td>
  </tr>
</table></td>
</tr>
</table>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.min.js"></script>
<script>
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

  textareaSize();

  if("<?php echo $view_val['work_name']; ?>" == "정기점검2"){
    $("#work_text_table1").show();
    $("#produce1").css("color","red");
    $("#leftBtn").show();
    $("#rightBtn").show();
    textareaSize();
  }

  var seq ="<?php echo $seq;?>";
  var text ="";
  
  if($("#sign_consent").val()=="true"){
    $("#sign_consent").prop("checked", true);
    $("#sign").html("<?php echo "<img src='".$misc."img/".$view_val['writer'].".png' width='50' height = '50'><div>{$view_val['writer']}</div>";?>");  
  }

  if($("#customer_sign_consent").val()=="true" && "<?php echo $view_val['customer_sign_src'];?>" != ''){
    $("#customer_sign_consent").prop("checked", true);
    $("#customer_sign").html("<?php echo "<img src='".$imageSrc."' width='50' height = '50'><div>".$view_val['signer']."</div>";?>");
  }
  
  function customerSignSrc(image){
    $.ajax({
      type: "POST",
      cache: false,
      url: "<?php echo site_url(); ?>/ajax/customerSignSrc",
      dataType: "json",
      async: false,
      data: {
          seq:seq,
          src:image,
          signer:text,
      },
      success: function (data) {
        alert("이미지src 저장");
      }
    });
  }

  $(document).ready(function(){
    $("#sign_consent").change(function(){
      if("<?php echo $_SESSION['stc']['name']; ?>" != "<?php echo  $view_val['writer'] ?>"){
          alert("담당자가 아닙니다.");
          if($("input:checkbox[name=sign_consent]").is(":checked") == true) {
            $("input[name=sign_consent]").prop("checked", false);
          }else{
            $("input[name=sign_consent]").prop("checked", true);
          }
      }else{
        if($("#sign_consent").is(":checked")){
         $("#passwordCheck").val('');
        //  $(".ui-button ui-corner-all ui-widget ui-button-icon-only ui-dialog-titlebar-close").hide();
         $("#dialog").dialog({
            open: function(event, ui) {
              $(".ui-dialog-titlebar-close", $(this).parent()).hide();
            },
            buttons: {
              "확인": function() { 
                $(this).dialog('close');
                var dialogValue = $("#passwordCheck").val();
                var pw =CryptoJS.SHA1(dialogValue);
                var name = "<?php echo  $view_val['writer'] ?>"; //작성자 name

                $.ajax({
                  type: "POST",
                  cache: false,
                  url: "<?php echo site_url(); ?>/ajax/pwcheck",
                  dataType: "json",
                  async: false,
                  data: {
                    name:name
                  },
                  success: function (data) {
                    if(data.user_password==CryptoJS.enc.Hex.stringify(pw)){
                      $.ajax({
                        type: "POST",
                        cache: false,
                        url: "<?php echo site_url(); ?>/ajax/signConsentUpdate",
                        dataType: "json",
                        async: false,
                        data: {
                            seq:seq
                        },
                        success: function (data) {
                          $("#sign_consent").val(true);
                          alert("인증되었습니다");
                          $("#sign").html("<?php echo "<img src='".$misc."img/".$view_val['writer'].".png' width='50' height = '50'>";?>");  
                        }
                      }); 
                    }else{
                      $("input[type=checkbox]").prop("checked", false);
                      alert("비밀번호가 틀렸습니다")
                    }
                  }
                });
              },
              "취소": function() { $(this).dialog('close');$("input[name=sign_consent]").prop("checked", false);}
            }
          });        
        }else{
          $.ajax({
            type: "POST",
            cache: false,
            url: "<?php echo site_url(); ?>/ajax/signConsentCancle",
            dataType: "json",
            async: false,
            data: {
                seq:seq
            },
            success: function (data) {
              $("#dialog").dialog('close');
              alert("서명동의 취소");
              $("#sign").empty();
            }
          });
        }
      }
    });

    $("#customer_sign_consent").change(function(){
        if($("#customer_sign_consent").is(":checked")){
          var sign_confirm = confirm( '서명하시겠습니까?' );
          if(sign_confirm == false){
            $("input[name='customer_sign_consent']").prop("checked", false);
            return false;
          }
          text = prompt("서명자 이름을 입력하세요.");
          if(text==null || text ==''){
           alert("서명자 이름을 다시 입력해 주세요.");
           $("input[name='customer_sign_consent']").prop("checked", false);
          }else{
            $.ajax({
              type: "POST",
              cache: false,
              url: "<?php echo site_url(); ?>/ajax/customerSignConsentUpdate",
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
            url: "<?php echo site_url(); ?>/ajax/customerSignConsentCancle",
            dataType: "json",
            async: false,
            data: {
                seq:seq
            },
            success: function (data) {
              alert("서명동의 취소");
              $("#customer_sign").empty();
            }
          }); 
        }
    });
  });

  function signPage(){
    var settings = 'height=500,width=1000,left=0,top=0';
    window.open('/index.php/tech_board/tech_doc_signature', '_blank',settings);
  }

</script>
<script>
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

  //pdf mail 전송
  function pdfMail(){
      var mailConfirm = confirm("메일을 전송하시겠습니까?");
      if(mailConfirm == true){
        if("<?php echo $view_val['work_name']; ?>" == "정기점검2"){
          var signConfirm = confirm("pdf파일 전송은 확인, 상세보기 및 서명 전송은 취소를 눌러주세요.");
          if(signConfirm == true){//pdf파일 전송
            var mform = document.cform;
            mform.mail_send.value='Y';
            mform.send_ck.value='Y';
            mform.action="<?php echo site_url();?>/tech_board/tech_report2_csv";
            mform.submit();
          }else{//상세보기 서명 전송
            var mform = document.cform;
            mform.mail_send.value='Y';
            mform.send_ck.value='Y';
            mform.pdf_type.value=1;
            mform.action="<?php echo site_url();?>/tech_board/tech_report2_csv";
            mform.submit();
          }
        }else{
            var mform = document.cform;
            mform.mail_send.value='Y';
            mform.send_ck.value='Y';
            mform.action="<?php echo site_url();?>/tech_board/tech_report2_csv";
            mform.submit();
        }
      }else{
        return false;
      }
  }
</script>

</body>
</html>


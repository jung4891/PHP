<?php
  // 김수성 추가
  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
  require_once $this->input->server('DOCUMENT_ROOT')."/include/KISA_SEED_CBC.php";
  //본인 그룹 멤버가져오기

  if($this->cooperation_yn != 'Y') {
    $g_member = array();
    foreach($group_member as $member){
      array_push( $g_member, $member['user_name'] );
    }
  }
?>
<link rel="stylesheet" href="/misc/css/view_page_common.css">

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

  .work_text_table td:last-child{
    border-top:1px solid;
    border-right:none;
    border-color:#d7d7d7;
  }

  .work_text_table th{
    border-top:1px solid;
    border-right:1px solid;
    border-color:#d7d7d7;
  }

  .layerpop {
      display: none;
      z-index: 1000;
      border: 2px solid #ccc;
      background: #fff;
      /* cursor: move;  */
      cursor: default;
      font-family:"Noto Sans KR", sans-serif !important;
      font-size: 14px !important;
     }

  .layerpop_area .modal_title {
      padding: 30px 10px 10px 10px;
      /* border: 0px solid #aaaaaa; */
      font-size: 20px;
      font-weight: bold;
      line-height: 24px;
      text-align: left !important;
     }

  .layerpop_area .layerpop_close {
      width: 25px;
      height: 25px;
      display: block;
      position: absolute;
      top: 10px;
      right: 10px;
      background: transparent url('btn_exit_off.png') no-repeat;
    }

  .layerpop_area .layerpop_close:hover {
      background: transparent url('btn_exit_on.png') no-repeat;
      cursor: pointer;
    }

  .layerpop_area .content {
      width: 96%;
      margin: 2%;
      color: #828282;
    }

    .modal-input-tbl {
      border-spacing: 0;
      margin: 0 auto;
    }
    .modal-input-tbl tr {
      height: 60px;
      /* background-clip: padding-box; */
      /* border-bottom: thin solid #DFDFDF !important; */
      background-color: white !important;
    }
    .modal-input-tbl td:not(.non-border) {
      height: 40px;
      border-bottom-color: #DFDFDF !important;
      border-bottom-style: solid !important;
      border-bottom-width:1px !important;
      /* border-bottom: thin solid #DFDFDF !important; */
      background-color: white !important;
    }
    .modal-input-tbl {
      margin-bottom: 10px;
    }

    .hashtag_div {
      text-align:left;
      margin-bottom: 20px;
    }

    .hashtag_item {
      height:20px;
      background-color: #959595;
      color:white;
      padding: 7px 13px 7px 13px;
      border-radius: 3px;
      font-size: 14px !important;
      margin-right: 10px;
      cursor:pointer;
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

<script language="javascript">
  function chkForm( type ) {
    if(type == 1) {
      <?php if( $tech_lv == 1 ){
        if($view_val['writer'] != $name){?>
          alert("삭제 권한이 없습니다.");
          return false;
      <?php
        }
      }else if ($tech_lv == 2){
        if(!in_array($view_val['writer'],$g_member)){?>
          alert("삭제 권한이 없습니다.");
          return false;
      <?php
        }
      }?>
      if (confirm("정말 삭제하시겠습니까?") == true){
        var mform = document.cform;
        mform.action="<?php echo site_url();?>/tech/tech_board/tech_doc_delete_action";
        mform.submit();
        return false;
      }
    }else if(type == 2) {
      //var mform = document.cform;

      // mform.action="<?php echo site_url();?>/tech_board/tech_doc_print_action";
      window.open("<?php echo site_url();?>/tech/tech_board/tech_doc_print_action?seq=<?php echo $_GET['seq']?>", "cform", 'scrollbars=yes,width=850,height=600');
      //mform.submit();
      return false;
    }else if(type==3){
      var mailConfirm = confirm("메일을 전송하시겠습니까?");
      if(mailConfirm == true){
        var mform = document.cform;
        mform.mail_send.value='Y';
        mform.send_ck.value='Y';
      //	mform.action="http://dev_tech.durianit.co.kr/index.php/tech_board/tech_report_csv?seq=<?php echo $_GET['seq'];?>";
        mform.action="<?php echo site_url();?>/tech/tech_board/tech_report_csv?seq=<?php echo $_GET['seq'];?>";
        mform.submit();
      }else{
        return false;
      }
  	}else { //type == 0
      var mform = document.cform;
      mform.action="<?php echo site_url();?>/tech/tech_board/tech_doc_view";
      mform.submit();
      return false;
    }
  }

  //보고서작성 버튼
  // function create_document(mode) {
  //   var tech_seq = $('input[name=seq]').val();
  //
  //   if(mode == 'trip') { //출장
  //     if($("#trip_status").val() == 001) {
  //       alert("출장보고서 결재 진행 중입니다.");
  //     } else {
  //     location.href = "<?php echo site_url(); ?>/biz/approval/electronic_approval_doc_input?seq=17&tech_seq="+tech_seq;
  //     }
  //   } else if(mode == 'night') { //야간
  //     if($("#night_status").val() == 001) {
  //       alert("야간근무결과보고서 결재 진행 중입니다.");
  //     } else {
  //     location.href = "<?php echo site_url(); ?>/biz/approval/electronic_approval_doc_input?seq=56&tech_seq="+tech_seq;
  //     }
  //   } else if(mode == 'weekend') { //주말
  //     if($("#weekend_status").val() == 001) {
  //       alert("주말근무결과보고서 결재 진행 중입니다.");
  //     } else {
  //     location.href = "<?php echo site_url(); ?>/biz/approval/electronic_approval_doc_input?seq=21&tech_seq="+tech_seq;
  //   }
  // }
  // }

  // 보고서 작성 버튼
  function create_document() {
    var tech_seq = $('input[name=seq]').val();
    var status = $('input[name=approval_document_status]').val();

    if(status == '001') {
      alert('근무결과보고서 결재가 진행 중입니다.');
    } else {
      location.href = "<?php echo site_url(); ?>/biz/approval/electronic_approval_doc_input?seq=74&tech_seq=" + tech_seq;
    }
  }

</script>
<script type="text/javascript" src="/misc/js/jquery.bpopup-0.1.1.min.js"></script>
<script src='/misc/js/exif.js'></script>
<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=be899438c615f0b45f7b6f838aa7cef3"></script>
<body>
  <?php
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
<div align="center">
<div class="dash1-1">
<table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
    <script src="<?php echo $misc;?>ckeditor/ckeditor.js"></script>
    <!-- 타이틀 이미지 자리요 -->
    <tr height="5%">
      <td class="dash_title">
        기술지원보고서 보기
      </td>
    </tr>

    <tr>
      <td align="center" valign="top">
        <table width="100%" height="100%" cellspacing="0" cellpadding="0" class="list_tbl">
          <tr>
  <?php if($view_val['work_name'] == "정기점검2" && strpos($view_val['produce'],',') !== false){ ?>
            <td><img src="<?php echo $misc; ?>img/btn_left.jpg" id="leftBtn" style="float:right;cursor:pointer;"
                onclick="changePage('left')" /></td>
  <?php } ?>
            <td align="center" valign="top" width="100%">
              <!-- 시작합니다. 여기서 부터  -->
              <form name="cform" method="get">
                <input type="hidden" name="seq" value="<?php echo $seq;?>">
                <input type="hidden" name="mode" value="modify">
                <input type="hidden" name="pdf_type" value=0>
                <input type="hidden" id="mail_send" name="mail_send" value="<?php echo $view_val['mail_send'];?>">
                <input type="hidden" id="send_ck" name="send_ck">
                <input type="hidden" id="schedule_seq" name="schedule_seq" value="<?php echo $view_val['schedule_seq']; ?>">
                <input type="hidden" id="type" name="type" value="<?php echo $_GET['type']; ?>">
              <table width="100%" border="0" cellspacing="0" style="padding:50px 0px">
                <tr>
                  <td width="200px" height="30" align="center" class="tbl-title" style="border:thin solid #DFDFDF;">
                    <?php echo $view_val['customer']?> : 서명
                    <input type="checkbox"
                      id="customer_sign_consent" name="customer_sign_consent"
                      value="<?php echo $view_val['customer_sign_consent'] ?>">
                  </td>
                  <td width="20px" height="30" align="center"  class="tbl-title" style="border:thin solid #DFDFDF;">
                    두리안 : 서명
                    <input type="checkbox" id="sign_consent" name="sign_consent"
                      value="<?php echo $view_val['sign_consent'] ?>">
                  </td>
                  <input type="hidden" name="approval_document_status" value="<?php if(isset($approval_document['approval_doc_status'])){echo $approval_document['approval_doc_status'];} ?>">
        <?php if($view_val['writer'] == $name && $this->cooperation_yn == 'N'){ ?>
                  <td align="right" style="border:none;">
                    <!-- <?php if(substr($view_val['end_time'],0,2) >= 18 || $view_val['income_time'] != $view_val['end_work_day']) { ?>
                    <button type="button" id="c_night" name="button" class="btn-common btn-color2" style="width:170px" onclick="create_document('night')">야간근무결과보고서 작성</button>
                    <input type="hidden" id="night_status" value="<?php
                    if(isset($night['approval_doc_status'])) { echo $night['approval_doc_status']; } ?>">
                  <?php }

                    $is_weekend = false;
                    $start_day = $view_val['income_time'];
                    $end_day = $view_val['end_work_day'];

                    $week = array("일","월","화","수","목","금","토");

                    while (strtotime($start_day) <= strtotime($end_day)) {
                      $dayOfWeek = $week[date('w', strtotime($start_day))];

                      if($dayOfWeek == '토' || $dayOfWeek == '일') {
                        $is_weekend = true;
                      }

                     $start_day = date ("Y-m-d", strtotime("+1 day", strtotime($start_day)));
                    }

                    if($is_weekend == true) { ?>
                      <button type="button" id="c_weekend" name="button" class="btn-common btn-color2" style="width:170px" onclick="create_document('weekend')">주말근무결과보고서 작성</button>
                      <input type="hidden" id="weekend_status" value="<?php
                      if(isset($weekend['approval_doc_status'])) { echo $weekend['approval_doc_status']; }?>">
                    <?php
                    }

                    if($view_val['handle'] == '현장지원') { ?>
                    <button type="button" id="c_trip" name="button" class="btn-common btn-color2" style="width:130px" onclick="create_document('trip')">출장보고서 작성</button>
                    <input type="hidden" id="trip_status" value="<?php
                    if(isset($trip['approval_doc_status'])) { echo $trip['approval_doc_status']; } ?>">
                    <?php } ?> -->

                    <input type="button" id="approval_doc_btn" class="btn-common btn-color2" value="근무결과보고서 작성" style="width:auto;" onclick="create_document();">
                  </td>
        <?php } ?>
                </tr>
                <tr>
                  <td width="200px" height="50" align="center" style="border:thin solid #DFDFDF;">
                    <div id="customer_sign"></div>
                  </td>
                  <td width="200px" height="50" align="center" style="border:thin solid #DFDFDF;">
                    <div id="sign"></div>
                  </td>
                  <td align="right" style="border:none;">
                    <?php
                    if($_GET['type'] == "Y" || $_GET['type']==''){
                    ?>
                      <button type="button" name="button" class="btn-common btn-color1" onclick="chkForm(2);return false;">상세보기</button>
                    <?php
                    }
                    ?>
              <?php if($this->cooperation_yn == 'N' || ($this->cooperation_yn == 'Y' && $name == $view_val['writer'])) { ?>
                      <button type="button" name="button" class="btn-common btn-color1" onClick="javascript:chkForm(0);return false;">수정</button>
                      <button type="button" name="button" class="btn-common btn-color1" onClick="javascript:chkForm(1);return false;">삭제</button>
              <?php } ?>
                      <button type="button" name="button" class="btn-common btn-color2" onClick="javascript:history.go(-1);">목록</button>
                  </td>
                </tr>
              </table>

              <div class="hashtag_div">
              <?php
              if(!empty($hashtag)) {
                for($i = 0; $i < count($hashtag); $i++) {
                  ?> <span class="hashtag_item" onclick="hashtagSearch('<?php echo $hashtag[$i]['hashtag_name']; ?>')">
                  <?php echo '#'.$hashtag[$i]['hashtag_name'].' '; ?> </span> <?php
                }
              }
              ?>
              </div>

              <table width="100%" border="0" cellspacing="0">
                  <tr class="border-t">
                    <td colspan="2" width="15%" height="40" align="center" class="tbl-title"
                      style="font-weight:bold;">고객사</td>
                    <td width="35%" style="padding-left:10px;"> <?php echo $view_val['customer'];?>
                    </td>
                    <td width="15%" height="40" align="center" style="font-weight:bold;"
                     class="tbl-title">등록자</td>
                    <td width="35%" style="padding-left:10px;"> <?php echo $view_val['writer'];?></td>
                  </tr>

                  <tr>
                    <td colspan="2" width="15%" height="40" align="center"
                      style="font-weight:bold;" class="tbl-title">프로젝트명</td>
                    <td width="35%" style="padding-left:10px;">
                      <?php echo $view_val['project_name'];?>
                    </td>
                    <td width="15%" height="40" align="center"
                      style="font-weight:bold;" class="tbl-title">표지</td>
                    <td width="35%" style="padding-left:10px;">
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
                    <td colspan="2" width="15%" height="40" align="center"
                      style="font-weight:bold;" class="tbl-title">작업명(종류)</td>
                    <td colspan="3" width="35%" style="padding-left:10px;">
                      <input id="work_name" value="<?php echo $view_val['work_name'];?>" readonly onfocus="javascrpt:blur();" style="cursor:default;border:none;font-size: 12px;"></input>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2" width="15%" height="40" align="center" style="font-weight:bold;" class="tbl-title"
                    >작업시작일</td>
                    <td width="35%" style="padding-left:10px;" >
                      <?php echo substr($view_val['income_time'], 0, 10);?></td>
                    <td width="15%" height="40" align="center" style="font-weight:bold;" class="tbl-title"
                    >작업종료일</td>
                    <td width="35%" style="padding-left:10px;" >
                      <?php
                      if($view_val['end_work_day'] == NULL){
                        echo substr($view_val['income_time'], 0, 10);
                      }else{
                        echo substr($view_val['end_work_day'], 0, 10);
                      }
                      ?>
                    </td>
                  </tr>
                  <?php if($view_val['work_name']=="장애지원"){?>
                                <tr>
                                  <td colspan="2" width="15%" height="40" align="center" style="font-weight:bold;"  class="tbl-title">장애구분</td>
                                  <td width="35%" style="padding-left:10px;"><?php echo $view_val['err_type'];?></td>
                                  <td width="15%" height="40" align="center" style="font-weight:bold;"   class="tbl-title">심각도</td>
                                  <td width="35%" style="padding-left:10px;"  ><?php
                  					switch($view_val['warn_level']){
                  						case '001': echo "전체서비스중단";break;
                  						case '002': echo "일부서비스중단/서비스지연";break;
                  						case '003': echo "관리자불편/대고객신뢰도저하";break;
                  						case '004': echo "특정기능장애";break;
                  						case '005': echo "서비스무관단순장애";break;
                  					}?></td>
                                </tr>
                                <tr>
                                  <td colspan="2" width="15%" height="40" align="center" style="font-weight:bold;"  class="tbl-title" >장애유형</td>
                                  <td width="35%" style="padding-left:10px;"><?php
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
                                  <td width="15%" height="40" align="center" style="font-weight:bold;"  class="tbl-title" >장애처리방법</td>
                                  <td width="35%" style="padding-left:10px;"  ><?php
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
                                  <td colspan="2" width="15%" height="40" align="center" style="font-weight:bold;"  class="tbl-title" >담당자명</td>
                                  <td width="35%" style="padding:10px;" ><?php echo $view_val['customer_manager'];?></td>
                                  <td width="15%" height="40" align="center" style="font-weight:bold;"  class="tbl-title">이메일</td>
                                  <td width="35%" style="padding:10px;word-break:break-all;white-space:pre-wrap;" ><?php echo $view_val['manager_mail'];?></td>
                                </tr>
                                <tr>
                                  <td colspan="2" width="15%" height="40" align="center" style="font-weight:bold;" class="tbl-title">시작시간</td>
                                  <td width="35%" style="padding-left:10px;"  ><?php echo substr($view_val['start_time'],0,5);?></td>
                                  <td width="15%"align="center"  style="font-weight:bold;"  class="tbl-title" >종료시간</td>
                                  <td width="35%" style="padding:10px;"  ><?php echo substr($view_val['end_time'],0,5);?></td>
                                </tr>
                                <?php if(isset($schedule)){
                                        if( ( $schedule['s_file_realname']!='' || $schedule['start_reason']!='' ) && ( $schedule['e_file_realname']!='' || $schedule['end_reason']!='' ) ){ ?>
                                          <tr>
                                            <td colspan="2" width="15%" height="40" align="center" style="font-weight:bold;"  class="tbl-title" >
                                              <?php if($schedule['start_reason'] != ''){echo "사유(시작)";}if($schedule['s_file_realname']){echo '사진(시작)';} ?>
                                            </td>
                                            <td width="35%" style="padding-left:10px;"  >
                                              <?php if($schedule['start_reason'] != ''){echo $schedule['start_reason'];}
                                              if($schedule['s_file_realname']){ ?>
                                                <a onclick="img_detail('<?php echo $schedule['s_file_changename']; ?>')" style="cursor:pointer;"><?php echo $schedule['s_file_realname']; ?></a>
                                        <?php } ?>
                                            </td>
                                            <td width="15%"align="center"  style="font-weight:bold;"  class="tbl-title" >
                                              <?php if($schedule['end_reason'] != ''){echo "사유(종료)";}if($schedule['e_file_realname']){echo '사진(종료)';} ?>
                                            </td>
                                            <td width="35%" style="padding:10px;"  >
                                              <?php if($schedule['end_reason'] != ''){echo $schedule['end_reason'];}
                                              if($schedule['e_file_realname']){ ?>
                                                <a onclick="img_detail('<?php echo $schedule['e_file_changename']; ?>')" style="cursor:pointer;"><?php echo $schedule['e_file_realname']; ?></a>
                                        <?php } ?>
                                            </td>
                                          </tr>
                                    <?php }
                                        }
                                        ?>

                                  <tr>
                                    <td width="15%" colspan="2" height="40" align="center" style="font-weight:bold;"  class="tbl-title" >담당SE</td>
                                    <td width="35%" style="padding-left:10px;"  ><?php echo $view_val['engineer'];?></td>
                                    <td width="15%" height="40" align="center" style="font-weight:bold;"  class="tbl-title" >지원방법</td>
                                    <td width="35%" style="padding-left:10px;"  ><?php echo $view_val['handle'];?></td>
                                  </tr>
                                  <tr>
                                    <td width="15%" colspan="2" height="40" align="center" style="font-weight:bold;" class="tbl-title"  >제품</td>
                                    <td width="35%" colspan="3" style="padding-left:10px;" >
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
                                          $manufacturer = array();
                                          if(trim($view_val['manufacturer']) == "" || $view_val['manufacturer'] == null){//host가 후에 생겨서 빈값인 경우
                                            for($i=0; $i<count($produce); $i++){
                                              $manufacturer[$i]= '';
                                            }
                                          }else{
                                            $manufacturer = explode(",",$view_val['manufacturer']);
                                          }
                                          $duplication_yn = array();
                                          if(trim($view_val['duplication_yn']) == "" || $view_val['duplication_yn'] == null){//host가 후에 생겨서 빈값인 경우
                                            for($i=0; $i<count($produce); $i++){
                                              $duplication_yn[$i]= '';
                                            }
                                          }else{
                                            $duplication_yn = explode(",",$view_val['duplication_yn']);
                                          }
                                          $sn = explode(",",$view_val['sn']);
                                          for($i=1; $i<=count($produce); $i++){
                                            echo '<li id="li'.$i.'"><span style="cursor:pointer;" id="produce'.$i.'" class="click_produce" onclick="clickProduce('.$i.')">';
                                            echo '<span style="font-weight:bold;">제품명 : </span><span class="produce">'.$produce[($i-1)].'</span>';
                                            echo '<span style="font-weight:bold;"> / 제조사 : </span><span class="manufacturer">'.$manufacturer[($i-1)].'</span>';
                                            echo '<span style="font-weight:bold;"> / host : </span><span class="host">'.$host[($i-1)].'</span>';
                                            echo '<span style="font-weight:bold;"> / 버전정보 : </span><span class="version">'.$version[($i-1)].'</span>';
                                            echo '<span style="font-weight:bold;"> / 하드웨어 : </span><span class="hardware">'.$hardware[($i-1)].'</span>';
                                            echo '<span style="font-weight:bold;"> / 라이선스 : </span><span class="license">'.$license[($i-1)].'</span>';
                                            echo '<span style="font-weight:bold;"> / 시리얼 : </span><span class="serial">'.$sn[($i-1)].'</span>';
                                            echo '<span style="font-weight:bold;"> / 이중화 : </span><span class="duplication_yn">'.$duplication_yn[($i-1)].'</span>';
                                            echo '</span></li>';
                                          }
                                        ?>
                                      </ul>
                                    </td>
                                 </tr>
                                 <tr>
                                   <td width="15%" colspan="2" size="100" height="40" align="center" style="font-weight:bold;"  class="tbl-title" >지원내용</td>
                                   <td colspan="3"  style="padding-left:10px;"  ><?php echo $view_val['subject'];?>
                                   </td>
                                 </tr>
                             <?php if($view_val['work_name'] != "정기점검2"){ ?>
                         <tbody id ="nonPeriodic">
                           <tr>
                             <td colspan="2" height="40" align="center" style="font-weight:bold;"  class="tbl-title">시간</td>
                             <td height="40" colspan="3" align="center" style="font-weight:bold;"  class="tbl-title">지원내역</td>
                           </tr>

                           <?php
                           $tmp = explode(";;", $view_val['work_process_time']);
                           $process_txt =  explode(";;", $view_val['work_process']);

                           for($i=0; $i<count($tmp)-1; $i++){
                             // ;;2021-05-10_2021-05-11/10:00-11:00;;
                             $slash = explode("/",$tmp[$i]);
                             if(count($slash) >1){
                               // $date = $slash[0];
                               $date = explode("~",$slash[0]);
                               $time = explode("-",$slash[1]);
                             }else{
                               $date = array('','');
                               $time = explode("-",$slash[0]);
                             }
                             // $time = explode("-",$tmp[$i]);
                           ?>
                             <tr>
                               <td height="40" align="center" style="font-weight:bold;" class="tbl-title">
                                 <?php echo $date[0];?>&nbsp<?php echo $time[0];?>
                                 <br>
                                 ~
                                 <br>
                                 <?php if( !empty($date[1]) ){ echo $date[1]; }else{ echo $date[0]; }?>&nbsp<?php echo $time[1];?>
                                 <br>
                               </td>
                               <td colspan="4" height="40" align="left" >
                                 <div id="work_text"><?php echo nl2br($process_txt[$i]);?></div>
                               </td>
                             </tr>
                         <?php
                           }
                         ?>
                         </tbody>
                                 <?php }else{?>
                         <!-- 정기점검2 -->
                         <tbody id ="periodic">
                          <tr>
                           <td colspan="5" height="40" align="center" style="font-weight:bold;" >
                             <?php
                               function br2nl($string){
                                 return preg_replace('/\<br(\s*)?\/?\>/i', "\n", $string);
                               }
                               $total_process_text = rtrim(str_replace(';','',br2nl($view_val['work_process'])),'|');
                               $total_process_text = explode('|||',$total_process_text); // 제품별 나누기
                               for($a=0; $a<count($total_process_text); $a++){
                             ?>
                                 <table id="work_text_table<?php echo ($a+1) ;?>" class="work_text_table" width="100%" height=100% border=0 style="display:none;border-collapse:collapse;table-layout:fixed;border-right:none;border-left:none";>
                                   <tr>
                                     <th width="15%" height="30" class="tbl-title">
                                       <input value="점검항목" readonly onfocus="javascrpt:blur();" style="width:100%;cursor:default; font-weight:bold; border:none; text-align:center; background-color:transparent;"></input>
                                     </th>
                                     <th width="35%" colspan="2" height="30" class="tbl-title">
                                       <input value="점검내용" readonly onfocus="javascrpt:blur();" style="width:100%;cursor:default; font-weight:bold; border:none; text-align: center; background-color:transparent;" ></input>
                                     </th>
                                     <th width="15%" height="30" class="tbl-title">
                                       <input value="점검결과" readonly onfocus="javascrpt:blur();" style="width:100%;cursor:default; font-weight:bold; border:none; text-align: center; background-color:transparent;"></input>
                                     </th>
                                     <th width="35%" height="30" class="tbl-title">
                                       <input value="특이사항" readonly onfocus="javascrpt:blur();" style="width:100%;cursor:default; font-weight:bold; border:none; text-align: center; background-color:transparent;"></input>
                                     </th>
                                   </tr>
                                   <?php
                                   $process_text = explode('@@',$total_process_text[$a]); //점검항목 별로 나누기
                                   for($i=1; $i<count($process_text); $i++){
                                     if($i <> 1){ //기타 특이사항을 제외한 나머지
                                       $process_text1 = explode('#*',$process_text[$i]);
                                       for($j=1; $j<count($process_text1); $j++){
                                         if($j==1){
                                           echo '<tr><td height="30" align="center" rowspan="'.floor((count($process_text1)-1)/3).'">'.$process_text1[$j].'</td>'; //cpu, 메모리
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
                                           echo '<tr><td align="center">'.$process_text1[$j].'</td>';
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
             <!-- <tr>
               <td colspan="2" width="15%" height="40" align="center"
                 style="font-weight:bold;" class="tbl-title">버전정보</td>
               <td width="35%" style="padding-left:10px;"><?php echo $view_val['version_info'];?></td>
               <td width="15%" height="40" align="center" style="font-weight:bold;" class="tbl-title">제조사</td>
               <td width="35%" style="padding-left:10px;"><?php echo $view_val['manufacturer']; ?></td>
             </tr>
             <tr>
               <td colspan="2" width="15%" height="40" align="center"
                 style="font-weight:bold;" class="tbl-title">시리얼번호</td>
               <td width="35%" style="padding-left:10px;"><?php echo $view_val['serial_number'];?></td>
               <td width="15%" height="40" align="center" style="font-weight:bold;" class="tbl-title">이중화여부</td>
               <td width="35%" style="padding-left:10px;">
                 <input type="checkbox" name="" value="" <?php if($view_val['duplication_yn'] == 'Y'){echo "checked";} ?> onclick="return false;">
               </td>
             </tr> -->

<?php if($view_val['work_name']=="장애지원" && $view_val['failure_contents'] != ''){
        $failure_data = explode('*/*', $view_val['failure_contents']);
        foreach($failure_data as $fd) {
          $fd_arr = explode(':::', $fd);
          $failure_title = $fd_arr[0];
          $failure_content = $fd_arr[1]; ?>
          <tr>
            <td colspan="2" size="100" height="40" align="center" style="font-weight:bold;" class="tbl-title"><?php echo $failure_title; ?></td>
            <td colspan="3" style="padding-left:10px;"  ><?php echo nl2br($failure_content);?></td>
          </tr>
  <?php } ?>
<?php }?>

             <tr>
               <td colspan="2" size="100" height="40" align="center" style="font-weight:bold;" class="tbl-title">지원의견</td>
               <td colspan="3" style="padding-left:10px;"  ><?php echo $view_val['comment'];?></td>
             </tr>
             <?php if($view_val['work_name'] != "정기점검2"){ ?>
             <tr>
               <td colspan="2" size="100" height="40" align="center" style="font-weight:bold;" class="tbl-title">지원결과</td>
               <td colspan="3" style="padding-left:10px;"  ><?php echo $view_val['result'];?></td>
             </tr>
             <?php } ?>

             <!-- 요청사항 있으면 보여죠 -->
             <?php if (!empty($request)){ ?>

             <tr>
               <td colspan="2" size="100" height="40" align="center" style="font-weight:bold;" class="tbl-title">요청사항</td>
               <td colspan="3" style="padding-left:10px;"  ><?php echo $request['contents'];?></td>
             </tr>
             <?php } ?>
             <!-- 이슈 있으면 보여죠 -->
             <?php if (!empty($issue)){ ?>
             <tr>
               <td colspan="2" size="100" height="40" align="center" style="font-weight:bold;" class="tbl-title">이슈</td>
               <td colspan="3" style="padding-left:10px;"  ><?php echo $issue['contents'];?></td>
             </tr>
             <?php } ?>

              <!-- 버그 있으면 보여죠 -->
              <?php if (!empty($bug_val)){ ?>
              <tr>
                <td colspan="2" size="100" height="40" align="center" style="font-weight:bold;" class="tbl-title">버그</td>
                <td colspan="3" style="padding-left:10px;"  ><?php echo $bug_val['contents'];?></td>
              </tr>
              <?php } ?>
             <tr>
               <td  colspan="2" height="40" align="center" style="font-weight:bold;" class="tbl-title">첨부파일</td>
               <td  style="padding-left:10px;" colspan="3"><?php if($view_val['file_changename']) {?><a href="<?php echo site_url();?>/tech/tech_board/tech_doc_download/<?php echo $seq;?>/<?php echo $view_val['file_changename'];?>"><?php echo $view_val['file_realname'];?></a><?php } else {?>파일없음<?php }?> </td>
             </tr>
             <tr>
               <td  colspan="2" height="40" align="center" style="font-weight:bold;" class="tbl-title">우수 보고서</td>
               <td  style="padding-left:10px;" colspan="3">
             <?php
             $excellent_checked = false;
             if(!empty($excellent_check)) {
               foreach($excellent_check as $ec) {
                 if($ec['selector_seq'] == $this->seq) {$excellent_checked = true;} ?>
                 <input type="button" class="btn-common btn-color1" value="<?php echo $ec['user_name'].' '.$ec['user_duty']; ?>" style="cursor:default;">
         <?php }
             }
             if($this->pGroupName == "기술본부" && ( $this->duty == '이사' || $this->duty == '팀장' )) {
               if($excellent_checked == true) { ?>
                <input type="button" class="btn-common btn-style2" value="선택 취소" style="float:right;width:auto;margin-right:10px;" onclick="check_excellent('cancel');">
         <?php } else { ?>
                <input type="button" class="btn-common btn-style2" value="우수보고서 선택" style="float:right;width:auto;margin-right:10px;" onclick="check_excellent('check');">
         <?php } ?>
       <?php } ?>
               </td>
             </tr>
             <tr>
               <td  colspan="2" height="40" align="center" style="font-weight:bold;" class="tbl-title">전자 결재</td>
               <td  style="padding-left:10px;" colspan="3">
                 <!-- <span style="font-weight:bold;">야간근무결과보고서</span><input type="checkbox" style="margin-right:10px;" name="night" id="night" value="" onclick="return false;">
                 <span style="font-weight:bold;">주말근무결과보고서</span><input type="checkbox" style="margin-right:10px;" name="weekend" id="weekend" value="" onclick="return false;">
                 <span style="font-weight:bold;">출장보고서</span><input type="checkbox" name="trip" id="trip" value="" onclick="return false;"> -->
                 <span style="font-weight:bold;">근무결과보고서</span><input type="checkbox" name="approval_document" id="approval_document" value="" onclick="return false;">
               </td>
             </tr>
                </table>
              </form>
              <!-- 폼 끝 -->
        </td>
      <?php if($view_val['work_name'] == "정기점검2" && strpos($view_val['produce'],',') !== false){ ?>
       <td><img src="<?php echo $misc; ?>img/btn_right.jpg" id="rightBtn" onclick="changePage('right');" style="cursor:pointer;" /></td>
      <?php } ?>
          </tr>
      </table>
      <!-- list tbl -->
      </td>
    </tr>
    <tr>
      <td style="padding:20px 0px 100px 0px;">
        <span style="float:right">
          <!-- <img src="<?php echo $misc;if($view_val['mail_send']=="N"){echo 'img/btn_send.jpg';}else{echo 'img/btn_resend.jpg';}?>" border="0" style="width:64px;hight:31px;cursor:pointer" onClick="chkForm(3);return false;"/> -->
          <?php
          if($_GET['type'] == "Y" || $_GET['type']==''){
          ?>
          <input type="button" class="btn-common" value="<?php if($view_val['mail_send']=="N"){echo 'PDF전송';}else{echo 'PDF재전송';} ?>" onclick="pdfMail();">
            <input type="button" class="btn-common btn-style1" style="width:90px;" value="<?php if($view_val['mail_send']=="N"){echo '전송';}else{echo '재전송';} ?>" onclick="chkForm(3);return false;">
          <?php
          }
          ?>
        </span>
        <div id="dialog" title="비밀번호를 입력하세요">
          <input id="passwordCheck" type="password" size="30" style="height:28px;" />
        </div>
      </td>
    </tr>
</table>

</div>
</div>
  <div id='img_detail' style="width:400px; height: auto;" class="layerpop" >
    <article class="layerpop_area">
      <div align="left" class="modal_title" style="padding-bottom:10px;padding-left:10px;">사진 상세
      </div>
      <table border="0" cellspacing="0" cellpadding="0" width="95%" class="modal-input-tbl">
        <colgroup>
          <col width="25%" />
          <col width="75%" />
        </colgroup>
        <tr>
          <td style="font-weight:bold;">제조사</td>
          <td id="imgMake"></td>
        </tr>
        <tr>
          <td style="font-weight:bold;">모델명</td>
          <td id="imgModel"></td>
        </tr>
        <tr>
          <td class="non-border" style="font-weight:bold;">찍은 날짜</td>
          <td class="non-border" id="imgDateTime"></td>
        </tr>
        <tr>
          <td></td>
          <td><div id="thumbnail" class="thumbnail" style="margin: 0 auto;margin-bottom:10px;"></div></td>
        </tr>
        <tr>
          <td style="font-weight:bold;vertical-align:top;padding-top:30px;">위치</td>
          <td>
            <div id="map" style="width:250px;height:300px;"></div>
          </td>
        </tr>
      </table>
    </article>
  </div>
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
<?php if(isset($sign_img['sign_changename']) && $sign_img['sign_changename'] != '') { ?>
  $("#sign").html("<?php echo "<img src='{$misc}upload/user_sign/{$sign_img['sign_changename']}' width='50' height = '50'><div>{$view_val['writer']}</div>";?>");
<?php } ?>
  }

  if($("#customer_sign_consent").val()=="true" && "<?php echo $view_val['customer_sign_src'];?>" != ''){
    $("#customer_sign_consent").prop("checked", true);
    $("#customer_sign").html("<?php echo "<img src='".$imageSrc."' width='50' height = '50'><div>".$view_val['signer']."</div>";?>");
  }

  function customerSignSrc(image){
    $.ajax({
      type: "POST",
      cache: false,
      url: "<?php echo site_url(); ?>/tech/tech_board/customerSignSrc",
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
                        url: "<?php echo site_url(); ?>/tech/tech_board/signConsentUpdate",
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
            url: "<?php echo site_url(); ?>/tech/tech_board/signConsentCancle",
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

  function hashtagSearch(hashtag_name) { //해시태그 눌렀을때
    <?PHP if($_GET['type'] == "Y") { ?>
      location.href="<?php echo site_url(); ?>/tech/tech_board/tech_doc_list?type=Y&hashtag=" + hashtag_name;
    <?PHP } else { ?>
      location.href="<?php echo site_url(); ?>/tech/tech_board/tech_doc_list?type=N&hashtag=" + hashtag_name; //임시저장함
    <?PHP } ?>

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
            mform.action="<?php echo site_url();?>/tech/tech_board/tech_report2_csv";
            mform.submit();
          }else{//상세보기 서명 전송
            var mform = document.cform;
            mform.mail_send.value='Y';
            mform.send_ck.value='Y';
            mform.pdf_type.value=1;
            mform.action="<?php echo site_url();?>/tech/tech_board/tech_report2_csv";
            mform.submit();
          }
        }else{
            var mform = document.cform;
            mform.mail_send.value='Y';
            mform.send_ck.value='Y';
            mform.action="<?php echo site_url();?>/tech/tech_board/tech_report2_csv";
            mform.submit();
        }
      }else{
        return false;
      }
  }

  function img_detail(fileName) {
    var img = '<img id="detail_img" src="<?php echo $misc; ?>upload/biz/schedule/'+fileName+'" style="width:150px;margin-top:10px;">';
    $("#thumbnail").html(img);

    setTimeout(function() {
      get_exif();
    }, 500);
  }

  function get_exif() {
    var detail_img = document.getElementById("detail_img");
    EXIF.getData(detail_img, function() {
      var allMetaData = EXIF.getAllTags(this);
      var make = allMetaData.Make;
      var model = allMetaData.Model;
      var dateTime = allMetaData.DateTime;
      var latitude = allMetaData.GPSLatitude;
      var longitude = allMetaData.GPSLongitude;

      $("#imgMake").text(make);
      $("#imgModel").text(model);
      $("#imgDateTime").text(dateTime);

      latitude_map = dmsToDec(latitude[0],latitude[1],latitude[2]);
      longitude_map = dmsToDec(longitude[0],longitude[1],longitude[2]);

      drawMap(latitude_map, longitude_map);
    });


    $("#img_detail").bPopup();
  }

  function dmsToDec(deg, min, sec) {
    return deg+(((min*60)+(sec))/3600);
  }

  function drawMap(lat, lng) {

    var mapContainer = document.getElementById('map'), // 지도를 표시할 div
        mapOption = {
            center: new kakao.maps.LatLng(lat, lng), // 지도의 중심좌표
            level: 5 // 지도의 확대 레벨
        };

    var map = new kakao.maps.Map(mapContainer, mapOption); // 지도를 생성합니다

    // 마커가 표시될 위치입니다
    var markerPosition  = new kakao.maps.LatLng(lat, lng);

    // 마커를 생성합니다
    var marker = new kakao.maps.Marker({
        position: markerPosition
    });

    // 마커가 지도 위에 표시되도록 설정합니다
    map.relayout();
    marker.setMap(map);

  }

  function check_excellent(type) {
    if (type == 'cancel') {
      var request_url = "<?php echo site_url(); ?>/tech/tech_board/excellentReportCancle";
      var message = "우수 보고서 선택이 취소되었습니다.";
    } else if (type == 'check') {
      var request_url = "<?php echo site_url(); ?>/tech/tech_board/excellentReportInsert";
      var message = "우수 보고서로 선택되었습니다.";
    }

    $.ajax({
      type: "POST",
      cache: false,
      url: request_url,
      dataType: "json",
      async: false,
      data: {
          seq:seq
      },
      success: function (data) {
        alert(message);
        location.reload();
      }
    });
  }

  //보고서 체크박스
  <?php
    if(isset($night['approval_doc_status'])) {
      if($night['approval_doc_status'] == 002) { ?>
        $('#night').prop('checked', true);
        $('#c_night').hide();
  <?php } }
    if(isset($weekend['approval_doc_status'])) {
      if($weekend['approval_doc_status'] == 002) { ?>
        $('#weekend').prop('checked', true);
        $('#c_weekend').hide();
  <?php } }
    if(isset($trip['approval_doc_status'])) {
      if($trip['approval_doc_status'] == 002) { ?>
        $('#trip').prop('checked', true);
        $('#c_trip').hide();
  <?php } } ?>

  if($('input[name=approval_document_status]').val() == '002') {
    $('#approval_document').prop('checked', true);
    $('#approval_doc_btn').hide();
  }

</script>
<?php
 include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php";
?>
</body>
</html>

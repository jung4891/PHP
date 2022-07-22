<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
$duty = $this->phpsession->get( 'duty', 'stc' );

$final_approval="N"; //마지막 결재라인
if(empty($cur_approval_line) != true){
   // $approval_completion = $cur_approval_line['approval_status'];

   if($approval_line[count($approval_line)-1]['seq'] == $cur_approval_line['seq']){
      $final_approval ="Y";
   }
}

$approval_cancel_status = 'N'; //취소되는지(내 다음결재라인의 결재 여부에 따라)


$my_approval_line = array();
$cancel_line = array();
if(!empty($approval_line)){
   $n = 0;
   foreach($approval_line as $ap){
      if($ap['assignment_date'] != '' && $ap['approval_date'] == ''){
         $my_approval_line = $ap;
         if(isset($approval_line[$n+1])){
            $next_approval_line = $approval_line[$n+1];
         }
      }

      if($id == $ap['user_id']){
        $cancel_line = $ap;
        if(isset($approval_line[$n+1])){
           $cancel_next_line = $approval_line[$n+1];
        }
      }

      $n++;
   }

   if(!empty($cancel_line) && !empty($cancel_next_line)){
      if($cancel_next_line['approval_status'] == "" && ($cancel_line['approval_status'] == "Y" || $cancel_line['approval_status'] == "N" ) ){
         $approval_cancel_status="Y";
      }
   }
}

// //내 기준에서 내 다음사람
// if(!empty($my_approval_line)){
//    if(isset($approval_line[((int)$my_approval_line['step']+1)])){
//       $my_next_approval_line = $approval_line[((int)$my_approval_line['step']+1)]; //내 다음사람꺼
//       if($my_next_approval_line['approval_status'] == "" && ($my_approval_line['approval_status'] == "Y" || $my_approval_line['approval_status'] == "N" ) ){
//          $approval_cancel_status="Y";
//       }
//    }
// }
// echo $approval_cancel_status;
// print_r($next_approval_line);

$tech_approval = [17, 21, 56, 74];
?>
<style>
   p,span, a, a:hover, a:visited, a:active, label, input, h1,h2,h3,h4,h5,h6,input,textarea:not(#summernote),select{
      font-family: "Noto Sans KR" !important;
   }

   #formLayoutDiv:not(#summernote){
      font-size:13px !important;
   }

   .basic_td{
      padding:0px 10px 0px 10px;
      border:1px solid;
      border-color:#d7d7d7;
   }

   .basic_table{
      border-collapse:collapse;
      border:1px solid;
      border-color:#d7d7d7;
   }

   .basic_table td{
      padding:0px 10px 0px 10px;
      border:1px solid;
      border-color:#d7d7d7;
   }

   .basicBtn2{
      cursor:pointer;
      height:31px;
      background-color:#fff;
      vertical-align:top;
      font-weight:bold;
      border : .5px solid;
      margin-right: 5px;
   }

   .btn-common{
     margin-right: 5px;
   }

   .file_upload{
      outline: 2px dashed #92b0b3 ;
      outline-offset:-10px;
      text-align: center;
      transition: all .15s ease-in-out;
      width: 300px;
      height: 300px;
      background-color: gray;
   }

   /* 모달 css */
   .searchModal {
      display: none; /* Hidden by default */
      position: fixed; /* Stay in place */
      z-index: 10; /* Sit on top */
      left: 0;
      top: 0;
      width: 100%; /* Full width */
      height: 100%; /* Full height */
      overflow: auto; /* Enable scroll if needed */
      background-color: rgb(0,0,0); /* Fallback color */
      background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
      z-index: 1002;
   }
      /* Modal Content/Box */
   .search-modal-content {
      background-color: #fefefe;
      margin: 15% auto; /* 15% from the top and centered */
      padding: 20px;
      border: 1px solid #888;
      width: 70%; /* Could be more or less, depending on screen size */
      z-index: 1002;
   }
   ul{
      list-style:none;
      padding-left:0px;
   }

   li{
      list-style:none;
      padding-left:0px;
   }

   #formLayoutDiv input:not(input[type='radio']){
      border: none !important;
      background: transparent !important;
   }

   #formLayoutDiv select{
      border:none;
      border-radius:0;
      -webkit-appearance: none;
      appearance: none;
      background: transparent !important;
   }
   #formLayoutDiv textarea{
      /* color: transparent;
      text-shadow: 0 0 0 black; */
      border: none !important;
      background: transparent !important;
   }
   #formLayoutDiv select {
      pointer-events: none;
   }
   #formLayoutDiv input:not(input[type='radio']) {
      border: none !important;
      background: transparent !important;
   }

   #formLayoutDiv input[type=date] {
      pointer-events: none;
   }

    #formLayoutDiv ::-webkit-calendar-picker-indicator{
      display:none;
   }
   .select2-hidden-accessible,.select2-selection__choice__remove,.select2-search,.select2-container--below,.select2-selection__rendered{
      display:none;
   }
   .select2-selection__rendered{
      margin-top :0px !important;
   }
   .note-editable[contenteditable="false"] {
      background: transparent !important;
   }
   /* input[type='radio']:checked {
     appearance: none;
     width: 0.74rem;
     height: 0.74rem;
     border-radius:100%;
     margin-right: 0.20rem;
     margin-top:0.5px;
   }
   input[type='radio']:checked {
      background-color: black !important;
    } */
    #formLayoutDiv input[type='radio']:checked {
      appearance:none;
    }
    .stamp {
    	position: static;
    	background-size:contain;
    	/* background-position: right bottom; */
    	background-repeat:no-repeat;
    	padding-top:10px;
    	padding-bottom:10px;
    	padding-right:50px;
    	padding-left:10px;
    }
</style>
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.min.js"></script>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<script>
   function chkForm(){
		var mform = document.cform;
      $("#contents_html").val($("#formLayoutDiv").html());
      $("#editor_contents").val($('#summernote').summernote('code'));
      $("#approver_line").val($("#select_approver").html());

		mform.submit();
		return false;
	}
</script>
<body>
<?php
if($type != 'performanceAppraisal') {
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
}
?>
<form name="cform" action="<?php echo site_url(); ?>/biz/approval/electronic_approval_doc_input_action" method="post" onSubmit="javascript:chkForm();return false;">
   <input type="hidden" id="seq" name="seq" value="<?php echo $seq; ?>">
   <input type="hidden" id="select_user_id" name="select_user_id" value="">
   <input type="hidden" id="approval_form_seq" name="approval_form_seq" value="<?php echo $view_val['approval_form_seq']; ?>">
   <input type="hidden" id="contents_html" name="contents_html" value="" />
   <input type="hidden" id="editor_contents" name="editor_contents" value='<?php echo htmlspecialchars($view_val['editor_contents']); ?>' />
   <input type="hidden" id="approver_line" name="approver_line" value="" />
   <input type="hidden" id="cur_approver_line_seq" name="cur_approver_line_seq" value="<?php if(empty($cur_approval_line) != true){echo $cur_approval_line['seq']; }?>" />
   <input type="hidden" id="next_approver_line_seq" name="next_approver_line_seq" value="<?php if(empty($next_approval_line) != true){echo $next_approval_line['seq']; } ?>" />
   <input type="hidden" id="sign_confirm_yn" value="<?php echo $sign_confirm; ?>" />

   <input type="hidden" id="cancel_line_seq" value="<?php if(empty($cancel_next_line) != true){echo $cancel_next_line['seq']; } ?>">


   <input type="hidden" id="click_user_seq" name="click_user_seq" />
   <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
         <td align="center" valign="top">
            <table width="90%" height="100%" cellspacing="0" cellpadding="0">
               <tr>
                  <td width="100%" align="center" valign="top">
                     <!--내용-->
                     <table width="100%" border="0" style="margin-top:50px; margin-bottom: 50px;">
                        <!--타이틀-->
                        <tr>
                           <td class="title3">
                           <?php if($type == "request"){
                              echo "결재요청함";
                           }else if($type == "temporary"){
                              echo "임시저장함";
                           }else if($type == "standby"){
                              echo "결재대기함";
                           }else if ($type == "progress"){
                              echo "결재진행함";
                           }else if ($type == "completion"){
                              echo "완료문서함";
                           }else if ($type == "back"){
                              echo "반려문서함";
                           }else if ($type == "reference"){
                              echo "참조/열람문서함";
                           }else if ($type == "admin"){
                              echo "결재문서관리";
                           }
                           ?>
                           </td>
                        </tr>
                        <!--타이틀-->
                        <tr>
                           <td>&nbsp;</td>
                        </tr>
                        <tr>
                           <!-- 내용 -->
                           <td>
                              <div style="font-family:Noto Sans KR;">
                                 <div style="text-align:right">
                                 <?php
                                    if($type == "standby"){
                                       if($cur_approval_line['user_id'] == $id || !empty($mandatary)){
                                          if(($cur_approval_line['approval_type'] == "결재" || $cur_approval_line['approval_type'] == "합의") && $view_val['approval_doc_hold'] == "N"){
                                             echo '<input type="button" class="btn-common btn-color2" style="margin-right:5px;" value="'.$cur_approval_line['approval_type'].'" onclick="approval_ok();" />';
                                             echo '<input type="button" class="btn-common btn-color1" value="보류" onclick="hold(1)" />';
                                          }else if (($cur_approval_line['approval_type'] == "결재" || $cur_approval_line['approval_type'] == "합의") && $view_val['approval_doc_hold'] == "Y"){
                                             echo '<input type="button" class="btn-common btn-color1" value="보류해제" onclick="hold(0)" />';
                                          }
                                       }

                                       echo '<input type="button" class="btn-common btn-color1" value="진행현황" onclick="progressStatus();" />';
                                       echo '<input type="button" class="btn-common btn-color1" value="인쇄/PDF" onclick="print();" />';
                                       echo '<input type="button" class="btn-common btn-color1" value="목록" onclick="list_view();" />';
                                    }else if($type == "progress"){
                                       // if(!empty($next_approval_line)){
                                          if($approval_cancel_status == "Y"){
                                             echo '<input type="button" class="btn-common btn-color2" style="margin-right:5px;" value="결재취소" onclick="approval_save(0)" />';
                                          }
                                       // }
                                       if($id == $view_val['writer_id'] && $approval_line[0]['approval_status'] == "" && $view_val['approval_doc_hold'] != "Y" ){
                                          echo '<input type="button" class="btn-common btn-color2" style="margin-right:5px;" value="결재회수" onclick="approval_withdraw();" />';
                                       }
                                       echo '<input type="button" class="btn-common btn-color1" value="진행현황" onclick="progressStatus();" />';
                                       echo '<input type="button" class="btn-common btn-color1" value="인쇄/PDF" onclick="print();" />';
                                       echo '<input type="button" class="btn-common btn-color1" value="목록" onclick="list_view();" />';

                                    }else if($type == "completion"){
                                       if($view_val['approval_form_seq'] != "annual"){
                                          echo '<input type="button" class="btn-common btn-color2" style="margin-right:5px;" value="재기안" onclick="reApproval();" />';
                                       }
                                       echo '<input type="button" class="btn-common btn-color1" value="개인보관" onclick="personal_storage();" />';
                                       echo '<input type="button" class="btn-common btn-color1" value="진행현황" onclick="progressStatus();" />';
                                       echo '<input type="button" class="btn-common btn-color1" value="인쇄/PDF" onclick="print();" />';
                                       echo '<input type="button" class="btn-common btn-color1" value="목록" onclick="list_view();" />';
                                    }else if($type == "back"){
                                       if($view_val['approval_form_seq'] != "annual"){
                                          echo '<input type="button" class="btn-common btn-color2" style="margin-right:5px;" value="재기안" onclick="reApproval();" />';
                                       }
                                       if($approval_cancel_status == "Y"){
                                          echo '<input type="button" class="btn-common btn-color2" style="margin-right:5px;" value="결재취소" onclick="approval_save(0)" />';
                                       }
                                       echo '<input type="button" class="btn-common btn-color1" value="진행현황" onclick="progressStatus();" />';
                                       echo '<input type="button" class="btn-common btn-color1" value="인쇄/PDF" onclick="print();" />';
                                       echo '<input type="button" class="btn-common btn-color1" value="목록" onclick="list_view();" />';
                                    }else if($type == "request"){
                                       if($_GET['type2'] == "004"){
                                          echo '<input type="button" class="btn-common btn-color2" style="margin-right:5px;" value="수정" onclick="modifyApproval();" />';
                                          // echo '<input type="button" class="btn-common btn-color22" value="삭제" />';
                                          echo '<input type="button" class="btn-common btn-color1" value="인쇄/PDF" onclick="print();" />';
                                          echo '<input type="button" class="btn-common btn-color1" value="목록" onclick="list_view();" />';
                                       }else if ($_GET['type2'] == "002"){
                                          if($view_val['approval_form_seq'] != "annual"){
                                             echo '<input type="button" class="btn-common btn-color2" style="margin-right:5px;" value="재기안" onclick="reApproval();" />';
                                          }
                                          // echo '<input type="button" class="btn-common btn-color22" value="pdf변환" />';
                                          // echo '<input type="button" class="btn-common btn-color22" value="열람권한" />';
                                          echo '<input type="button" class="btn-common btn-color1" value="개인보관" onclick="personal_storage();" />';
                                          echo '<input type="button" class="btn-common btn-color1" value="진행현황" onclick="progressStatus();" />';
                                          echo '<input type="button" class="btn-common btn-color1" value="인쇄/PDF" onclick="print();" />';
                                          echo '<input type="button" class="btn-common btn-color1" value="목록" onclick="list_view();" />';
                                       }else if ($_GET['type2'] == "003"){
                                          if($view_val['approval_form_seq'] != "annual"){
                                             echo '<input type="button" class="btn-common btn-color2" style="margin-right:5px;" value="재기안" onclick="reApproval();" />';
                                          }
                                          echo '<input type="button" class="btn-common btn-color1" value="진행현황" onclick="progressStatus();" />';
                                          echo '<input type="button" class="btn-common btn-color1" value="인쇄/PDF" onclick="print();" />';
                                          echo '<input type="button" class="btn-common btn-color1" value="목록" onclick="list_view();" />';
                                       }else if($_GET['type2'] == "001"){
                                          if(!empty($next_approval_line)){
                                             if($approval_cancel_status == "Y"){
                                                echo '<input type="button" class="btn-common btn-color4" style="margin-right:5px;" value="결재취소" onclick="approval_save(0)" />';
                                             }
                                          }
                                          if($id == $view_val['writer_id'] && $approval_line[0]['approval_status'] == "" && $view_val['approval_doc_hold'] != "Y" ){
                                             echo '<input type="button" class="btn-common btn-color2" style="margin-right:5px;" value="결재회수" onclick="approval_withdraw();" />';
                                          }
                                          echo '<input type="button" class="btn-common btn-color1" value="진행현황" onclick="progressStatus();" />';
                                          echo '<input type="button" class="btn-common btn-color1" value="인쇄/PDF" onclick="print();" />';
                                          echo '<input type="button" class="btn-common btn-color1" value="목록" onclick="list_view();" />';
                                       }
                                    }else if ($type == "temporary"){
                                       echo '<input type="button" class="btn-common btn-color2" style="margin-right:5px;" value="수정" onclick="modifyApproval();" />';
                                       echo '<input type="button" class="btn-common btn-color2" style="margin-right:5px;" value="복사" onclick="duplicationApproval();" />';
                                       echo '<input type="button" class="btn-common btn-color4" value="삭제" onclick="delete_doc();"/>';
                                       echo '<input type="button" class="btn-common btn-color1" value="인쇄/PDF" onclick="print();" />';
                                       echo '<input type="button" class="btn-common btn-color1" value="목록" onclick="list_view();" />';
                                    }else if ($type == "admin"){
                                       if($_GET['type2'] != "002"){
                                          echo '<input type="button" class="btn-common btn-color2" style="margin-right:5px;" value="결재선" onclick="select_approval_modal();" />';
                                          echo '<input type="button" class="btn-common btn-color1" value="참조자" onClick="select_user('."'referrer'".');"/>';
                                          echo '<input type="button" class="btn-common btn-color1" value="결재복원" onClick="restore_approval_modal();" />';
                                       }
                                       echo '<input type="button" class="btn-common btn-color1" value="';
                                       if($view_val['approval_doc_security'] == "N"){
                                          echo "보안설정";
                                       }else{
                                          echo "보안해제";
                                       }
                                       echo '" onclick="security_setting();" />';
                                       echo '<input type="button" class="btn-common btn-color4" value="삭제" onclick="delete_doc();"/>';
                                       echo '<input type="button" class="btn-common btn-color1" value="진행현황" onclick="progressStatus();" />';
                                       echo '<input type="button" class="btn-common btn-color1" value="인쇄/PDF" onclick="print();" />';
                                       echo '<input type="button" class="btn-common btn-color1" value="목록" onclick="list_view();" />';
                                    } else if ($type == 'reference') {
                                      echo '<input type="button" class="btn-common btn-color1" value="인쇄/PDF" onclick="print();" />';
                                      echo '<input type="button" class="btn-common btn-color1" value="목록" onclick="list_view();" />';
                                    } else if($type == 'performanceAppraisal') {
                                      echo '<input type="button" class="btn-common btn-color1" value="돌아가기" onclick="history.go(-1);" />';
                                    } else if($type == 'wage') {
                                      echo '<input type="button" class="btn-common btn-color1" value="진행현황" onclick="progressStatus();" />';
                                      echo '<input type="button" class="btn-common btn-color1" value="인쇄/PDF" onclick="print();" />';
                                      echo '<input type="button" class="btn-common btn-color1" value="목록" onclick="list_view();" />';
                                    }
                                 ?>
                                 </div>
                                 <div style="text-align:center;font-size:30px;height:40px;margin-top:30px;">
                                 <!-- <input type="hidden" id="template_name" name="template_name" value="<?php echo $view_val['template_name']; ?>"> -->
                                    <?php
                                    if ($view_val['approval_form_seq'] != 'annual') {
                                      echo $view_val['template_name'];
                                    } else {
                                      echo '연차신청서';
                                    }
                                    ?>
                                 </div>
                                 <div>
                                    <table id="approver_line_table" class="basic_table" style="width:auto;text-align:center;margin-bottom:30px;">
                                       <tr>
                                          <td height=40 rowspan=2 class="basic_td" width="20px" bgcolor="f8f8f9" >결재</td>
                                          <td class="basic_td" width="80px" bgcolor="f8f8f9">1.<?php echo $view_val['user_duty']; ?></td>
                                          <?php
                                          if(empty($approval_line) != true){
                                             foreach($approval_line as $al){
                                               $step = $al['step'] + 2;
                                                if($al['approval_type'] == "결재"){
                                                   if($al['delegation_seq'] == ""){
                                                      echo "<td class='basic_td' width='80px' bgcolor='f8f8f9'>{$step}.{$al['user_duty']}</td>";
                                                   }else{
                                                      $mendatary_duty = explode(' ', $al['mandatary']);
                                                      $mendatary_duty = $mendatary_duty[1];
                                                      echo "<td class='basic_td' width='80px' bgcolor='f8f8f9'>{$step}.{$mendatary_duty}</td>";
                                                   }

                                                }
                                             }
                                          }
                                          ?>
                                       </tr>
                                       <tr>
                                          <td height=40 class="basic_td" width="80px">
                                             <?php echo $view_val['writer_name']; ?><br><span style="font-weight:bold">승인</span><br><?php echo $view_val['write_date']; ?>
                                          </td>
                                          <?php
                                          if(empty($approval_line) != true){
                                             foreach($approval_line as $al){
                                               $step = $al['step'] + 2;
                                                if($al['approval_type'] == "결재"){
                                                   if($al['delegation_seq'] == ""){
                                                      echo "<td class='basic_td' width='80px'>{$al['user_name']}<br>";
                                                   }else{
                                                      $mendatary_name = explode(' ', $al['mandatary']);
                                                      $mendatary_name = $mendatary_name[0];
                                                      echo "<td class='basic_td' width='80px'>{$mendatary_name}(대결)<br>";
                                                   }
                                                   if($al['approval_status'] == "Y"){
                                                      echo "<span style='font-weight:bold'>승인</span>";
                                                   }else if($al['approval_status'] == "N"){
                                                      echo "<span style='font-weight:bold'>반려</span>";
                                                   }else if ($al['approval_status'] == ""){
                                                      echo "<span style='font-weight:bold'>미결</span>";
                                                   }
                                                   echo "<br>".$al['approval_date'];
                                                   echo "</td>" ;
                                                }
                                             }
                                          }
                                          ?>
                                       </tr>
                                    </table>
                                 </div>
                                 <div>
                                    <table id="agreement_line_table" class="basic_table" style="width:auto;text-align:center;margin-bottom:30px;">
                                       <tr bgcolor="f8f8f9">
                                          <td height=40 rowspan=2 class="basic_td" width="20px" bgcolor="f8f8f9" >합의</td>
                                          <?php
                                          if(empty($approval_line) != true){
                                             foreach($approval_line as $al){
                                                if($al['approval_type'] == "합의"){
                                                  $step = $al['step'] + 2;
                                                   echo "<td class='basic_td' width='80px'>{$step}.{$al['user_duty']}</td>" ;
                                                }
                                             }
                                          }
                                          ?>
                                       </tr>
                                       <tr>
                                          <?php
                                          if(empty($approval_line) != true){
                                             foreach($approval_line as $al){
                                                if($al['approval_type'] == "합의"){
                                                  if($al['delegation_seq'] == ""){
                                                     echo "<td class='basic_td' width='80px'>{$al['user_name']}<br>";
                                                  }else{
                                                     $mendatary_name = explode(' ', $al['mandatary']);
                                                     $mendatary_name = $mendatary_name[0];
                                                     echo "<td class='basic_td' width='80px'>{$mendatary_name}(대결)<br>";
                                                  }
                                                   if($al['approval_status'] == "Y"){
                                                      echo "<span style='font-weight:bold'>합의</span>";
                                                   }else if($al['approval_status'] == "N"){
                                                      echo "<span style='font-weight:bold'>반려</span>";
                                                   }else if ($al['approval_status'] == ""){
                                                      echo "<span style='font-weight:bold'>미결</span>";
                                                   }
                                                   echo "<br>".$al['approval_date'];
                                                   echo "</td>" ;
                                                }
                                             }
                                          }
                                          ?>
                                       </tr>
                                    </table>
                                 </div>
                                 <div>
                                    <table class="basic_table" style="width:100%;">
                                       <tr>
                                          <td width="15%" align="center" height=40 class="basic_td" bgcolor="f8f8f9">문서번호</td>
                                          <td width="35%" class="basic_td"> <?php echo $view_val['writer_group']; ?>-<?php echo $view_val['doc_num']; ?></td>
                                          <td width="15%" align="center" class="basic_td" bgcolor="f8f8f9">기안일자</td>
                                          <td width="35%" class="basic_td"><input type="hidden" name="write_date" id="write_date" value="<?php echo $view_val['write_date']; ?>" /><?php echo $view_val['write_date']; ?></td>
                                       </tr>
                                       <tr>
                                          <td width="15%" align="center" height=40 class="basic_td" bgcolor="f8f8f9">기안자</td>
                                          <td width="35%" class="basic_td"><input type="hidden" name="writer_name" id="writer_name" value="<?php echo $view_val['writer_name']; ?>" /><?php echo $view_val['writer_name']; ?></td>
                                          <td width="15%" align="center" class="basic_td" bgcolor="f8f8f9">기안부서</td>
                                          <td width="35%" class="basic_td"><input type="hidden" name="writer_group" id="writer_group" value="<?php echo $view_val['writer_group']; ?>" /><?php echo $view_val['writer_group'];  ?></td>
                                       </tr>
                                       <tr>
                                          <td width="15%" align="center" height=40 class="basic_td" bgcolor="f8f8f9">참조자</td>
                                          <td width="35%" class="basic_td">
                                             <input id="referrer" name="referrer" type="hidden" class="input2" value="<?php echo $view_val['referrer']; ?>" />
                                             <?php echo $view_val['referrer']; ?>
                                          </td>
                                          <td width="15%" align="center" class="basic_td" bgcolor="f8f8f9">기결재첨부</td>
                                          <td width="35%" class="basic_td">
                                             <?php
                                                $attach_seq = '';
                                                $attach_list = '';
                                                if($view_val['approval_attach'] != ''){
                                                   $attach = explode('*/*',$view_val['approval_attach']);
                                                   for($i=0; $i<count($attach); $i++){
                                                      $att = explode('--',$attach[$i]);
                                                      $attach_seq .= ','.$att[0];
                                                      $attach_list .= "<div id='attach_".$att[0]."'><span name='attach_name' onclick='attach_view(".$att[0].")' style='cursor:pointer;'>".$att[1]."</span></div>";
                                                   }
                                                }
                                              ?>
                                             <input id="approval_attach" name="approval_attach" type="hidden" class="input7" value="<?php echo $attach_seq; ?>" />
                                             <div id="approval_attach_list" name="approval_attach_list">
                                                <?php echo $attach_list; ?>
                                             </div>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td width="15%" align="center" height=40 class="basic_td" bgcolor="f8f8f9">문서제목</td>
                                          <td colspan=3 class="basic_td">
                                             <?php echo $view_val['approval_doc_name']; ?>
                                          </td>
                                       </tr>
                                       <?php if($view_val['official_doc_attach'] != '') { ?>
                                         <tr>
                                           <td width="15%" align="center" height=40 class="basic_td" bgcolor="f8f8f9">발송공문</td>
                                           <td colspan="3" class="basic_td">
                                             <?php
                                             $official_doc_seq = '';
                                             $official_doc_list = '';
                                             if($view_val['official_doc_attach'] != ''){
                                               $official_doc = explode('*/*',$view_val['official_doc_attach']);
                                               for($i=0; $i<count($official_doc); $i++){
                                                 $off_doc = explode('--',$official_doc[$i]);
                                                 $official_doc_seq .= ','.$off_doc[0];
                                                 $official_doc_list .= "<div id='official_doc_".$off_doc[0]."'><span name='official_doc_name' onclick='official_doc_view(".$off_doc[0].")' style='cursor:pointer;'>".$off_doc[1]."</span><img src='/misc/img/btn_search.jpg' style='width:18px;vertical-align:middle;cursor:pointer;margin:5px 0px 5px 10px;' onclick='official_doc_view(".$off_doc[0].")'/></div>";
                                               }
                                             }
                                             ?>
                                             <input id="approval_attach" name="approval_attach" type="hidden" class="input7" value="<?php echo $official_doc_seq; ?>" />
                                             <div id="approval_attach_list" name="approval_attach_list">
                                               <?php echo $official_doc_list; ?>
                                             </div>
                                           </td>
                                         </tr>
                                       <?php } ?>
                                       <input id="approval_tech_doc_attach" name="approval_tech_doc_attach" type="hidden" value="<?php echo $view_val['approval_tech_doc_attach']; ?>" />
                              <?php if(in_array($view_val['approval_form_seq'], $tech_approval)) {
                                      if(trim($view_val['approval_tech_doc_attach']) != '') {
                                        $tech_doc_attach = explode('::', $view_val['approval_tech_doc_attach']);
                                        $tech_doc_seq = $tech_doc_attach[0];
                                        $tech_doc_name = $tech_doc_attach[1];
                                      }  ?>
                                      <tr>
                                        <td width="15%" align="center" height=40 class="basic_td" bgcolor="f8f8f9">첨부기술지원보고서</td>
                                        <td colspan=3 class="basic_td">
                                          <div id="approval_tech_doc_attach_list" name="approval_tech_doc_attach_list">
                                  <?php if($view_val['approval_tech_doc_attach'] != '') { ?>
                                            <div id="attach_tech_doc_<?php echo $tech_doc_seq; ?>">
                                              <span name="attach_name"><?php echo $tech_doc_name; ?></span>
                                              <img src="/misc/img/btn_search.jpg" style="width:18px;vertical-align:middle;cursor:pointer;margin:5px 0px 5px 10px;" onclick="tech_doc_view(<?php echo $tech_doc_seq; ?>)">
                                            </div>
                                  <?php } ?>
                                          </div>
                                        </td>
                                      </tr>
                              <?php } ?>
                                       <tr>
                                          <td width="15%" align="center" height=40 class="basic_td" bgcolor="f8f8f9">첨부파일</td>
                                          <td colspan=3 class="basic_td">
                                             <?php
                                                if($view_val['file_realname'] != ""){
                                                   $file = explode('*/*',$view_val['file_realname']);
                                                   $file_url = explode('*/*',$view_val['file_changename']);
                                                   for($i=0; $i<count($file); $i++){
                                                      echo $file[$i];
                                                      echo "<a href='{$misc}upload/sales/electronic_approval/{$file_url[$i]}' download='{$file[$i]}'> <img src='{$misc}img/download.svg' style='width:15px;vertical-align:middle;cursor:pointer;margin:5px 0px 5px 10px;'></a><br>";
                                                   }
                                                }
                                             ?>
                                       <?php if($view_val['approval_form_seq'] == 71){ ?>
                                              <div><span onclick='salary_contract_view("<?php echo $seq; ?>")' style='cursor:pointer;' id="salary_contract"></span><img src='/misc/img/btn_search.jpg' style='width:18px;vertical-align:middle;cursor:pointer;margin:5px 0px 5px 10px;' onclick='salary_contract_view("<?php echo $seq; ?>")'/></div>
                                       <?php } ?>
                                       <?php if($view_val['approval_form_seq'] == 75) { ?>
                                             <div>
                                         <?php echo $view_val['writer_name'].' '.$employment_doc['user_duty'].' 재직증명서'; ?>
                                               <span onclick='employment_doc_view("<?php echo $seq; ?>")' style='cursor:pointer;' id="employment_doc"></span>
                                               <img src='/misc/img/btn_search.jpg' style='width:18px;vertical-align:middle;cursor:pointer;margin:5px 0px 5px 10px;' onclick='employment_doc_view("<?php echo $seq; ?>")'/>
                                             </div>
                                       <?php } ?>
                                          </td>
                                       </tr>
                                    </table>
                                 </div>
                                 <div id="formLayoutDiv" style="margin-top:30px;">
                                    <?php
                                       echo $view_val['contents_html'];
                                    ?>
                                 </div>
                                 <?php if($view_val['editor_use'] == 'Y'){ ?>
                                    <!-- <div id="summernote" style="margin-top:30px;"></div> -->
                                    <textarea id="summernote"><?php echo $view_val['editor_contents']; ?></textarea>
                                 <?php } ?>
                                 <?php if(empty($approval_line) != true){?>
                                 <div style="margin-top:30px;">
                                    <h3>결재의견</h3>
                                    <table class="basic_table" style="text-align:center;width:100%">
                                       <tr bgcolor="f8f8f9">
                                          <td width="15%" height="30" class="basic_td">결재</td>
                                          <td width="15%" class="basic_td">결재자</td>
                                          <td width="15%" class="basic_td">부서</td>
                                          <td width="20%" class="basic_td">결재일시</td>
                                          <td width="30%" class="basic_td">의견</td>
                                          <td width="5%" class="basic_td">상세보기</td>
                                       </tr>
                                       <?php foreach($approval_line as $al){
                                          if($al['approval_status'] != ""){
                                             echo "<tr>";
                                             if($al['approval_status'] == "N"){
                                                echo "<td height='30' class='basic_td' style='color:red;'>반려</td>";
                                             }else{
                                                echo "<td height='30' class='basic_td'>{$al['approval_type']}</td>";
                                             }
                                             echo "<td height='30' class='basic_td'>{$al['user_name']} {$al['user_duty']}";
                                             if($al['delegation_seq'] != ""){
                                                echo "<br> (위임) {$al['mandatary']}";
                                             }
                                             echo "</td>";
                                             echo "<td height='30' class='basic_td'>{$al['user_group']}</td>";
                                             echo "<td height='30' class='basic_td'>{$al['approval_date']}</td>";
                                             echo "<td height='30' class='basic_td'>{$al['approval_opinion']}</td>";
                                             echo "<td height='30' class='basic_td'>";
                                             if(trim($al['details']) != "" && trim($al['details']) != '<p><br></p>' && trim($al['details']) != '<br>'){
                                                echo "<img src='{$misc}img/dashboard/btn/btn_search.png' width=25 style='cursor:pointer;' onclick='details_view({$al['seq']});'>";
                                             }
                                             echo "</td></tr>";
                                          }
                                       }?>
                                    </table>
                                 </div>
                                 <?php }?>
                                 <?php if(empty($hold) != true){?>
                                 <div style="margin-top:30px;">
                                    <h3>보류의견</h3>
                                    <table class="basic_table" style="text-align:center;width:100%">
                                       <tr bgcolor="f8f8f9">
                                          <td width="15%" height="30" class="basic_td">상태</td>
                                          <td width="15%" class="basic_td">보류자</td>
                                          <td width="15%" class="basic_td">부서</td>
                                          <td width="20%" class="basic_td">처리일시</td>
                                          <td width="35%" class="basic_td">의견</td>
                                       </tr>
                                       <?php foreach($hold as $h){
                                          echo "<tr>";
                                          if($h['hold_status'] == "Y"){
                                             echo "<td height='30' class='basic_td'>보류</td>";
                                          }else{
                                             echo "<td height='30' class='basic_td'>해제</td>";
                                          }
                                          echo "<td height='30' class='basic_td'>{$h['holder']}</td>";
                                          echo "<td height='30' class='basic_td'>{$h['user_group']}</td>";
                                          echo "<td height='30' class='basic_td'>{$h['processing_date']}</td>";
                                          echo "<td height='30' class='basic_td'>{$h['hold_opinion']}</td>";
                                          echo "</tr>";
                                       }?>
                                    </table>
                                 </div>
                                 <?php }?>
                                 <div style="text-align:right;margin-top:30px;">
                                       <!-- //버튼들어갈자리임 -->
                                 </div>
                              </div>
                           </td>
                        </tr>
                     </table>
                     <div id="group_tree_modal" class="searchModal">
                        <div class="search-modal-content" style='height:auto; min-height:400px;overflow: auto;'>
                           <h2>사용자 선택</h2>
                              <div style="margin-top:30px;height:auto; min-height:300px;overflow:auto;">
                                 <input type="button" class="btn-common btn-color1" value="조직원 전체 선택" style="float:right;margin-bottom:5px;width:130px;" onclick="select_user_add('all');" >
                                 <table class="basic_table" style="width:100%;height:300px;vertical-align:middle;">
                                    <tr>
                                       <td class ="basic_td" width="30%">
                                          <div id="groupTree">
                                             <ul>
                                                <li>
                                                <span style="cursor:pointer;" id="all" onclick="groupView(this)">
                                                   (주)두리안정보기술
                                                </span>
                                                <ul>
                                                <?php
                                                   foreach ( $group_val as $parentGroup ) {
                                                      if($parentGroup['childGroupNum'] <= 1){
                                                      ?>
                                                         <li>
                                                            <ins>&nbsp;</ins>
                                                            <span style="cursor:pointer;" id="<?php echo $parentGroup['groupName'];?>" onclick="groupView(this)">
                                                            <ins>&nbsp;</ins>
                                                            <?php echo $parentGroup['groupName'];?>
                                                            </span>
                                                         </li>
                                                      <?php
                                                      }else{
                                                      ?>
                                                         <li>
                                                            <img src="<?php echo $misc; ?>img/btn_add.jpg" id="<?php echo $parentGroup['groupName'];?>Btn" width="13" style="cursor:pointer;" onclick="viewMore(this)">
                                                            <span style="cursor:pointer;" id="<?php echo $parentGroup['groupName'];?>" onclick="groupView(this)">
                                                            <?php echo $parentGroup['groupName'];?>
                                                            </span>
                                                         </li>
                                                      <?php
                                                      }
                                                   }
                                                ?>
                                                </ul>
                                                </li>
                                             </ul>
                                          </div>
                                       </td>
                                       <td class ="basic_td" width="30%" align="center">
                                          <div class="click_group_user"></div>
                                       </td>
                                       <td class ="basic_td" width="10%" align="center">
                                          <div>
                                             <img src="<?php echo $misc;?>img/btn_right.jpg" style="cursor:pointer;width:22px;height:22px;" border="0" onClick="select_user_add();"/><br><br>
                                             <img src="<?php echo $misc;?>img/btn_left.jpg" style="cursor:pointer;width:22px;height:22px;" border="0" onClick="select_user_del();"/><br><br>
                                             <img src="<?php echo $misc;?>img/btn_del.jpg" style="cursor:pointer;width:22px;height:22px;" border="0" onClick="select_user_del('all');"/>
                                          </div>
                                       </td>
                                       <td class ="basic_td" width="30%" align="center">
                                          <div id="select_user">
                                          </div>
                                       </td>
                                    </tr>
                                 </table>
                              </div>
                              <div align="right">
                                <input type ="button" class="btn-common btn-color2" value="등록" style="width:61px;" onClick="saveUserModal();">
                                <input type ="button" class="btn-common btn-color4" value="취소" style="width:61px;" onClick="closeModal();">

                              </div>
                        </div>
                     </div>
                     <!-- <div id="select_approval_modal" class="searchModal">
                        <div class="search-modal-content" style='height:auto; min-height:400px;overflow: auto;'>
                           <h2>결재선지정</h2>
                              <div style="margin-top:30px;height:auto; min-height:300px;overflow:auto;">
                                 <table class="basic_table" style="width:100%;height:300px;vertical-align:middle;">
                                    <tr>
                                       <td class ="basic_td" width="30%">
                                          <div id="groupTree">
                                             <ul>
                                                <li>
                                                <span style="cursor:pointer;" id="all" onclick="groupView(this)">
                                                   (주)두리안정보기술
                                                </span>
                                                <ul>
                                                <?php
                                                   foreach ( $group_val as $parentGroup ) {
                                                      if($parentGroup['childGroupNum'] <= 1){
                                                      ?>
                                                         <li>
                                                            <ins>&nbsp;</ins>
                                                            <span style="cursor:pointer;" id="<?php echo $parentGroup['groupName'];?>" onclick="groupView(this)">
                                                            <ins>&nbsp;</ins>
                                                            <?php echo $parentGroup['groupName'];?>
                                                            </span>
                                                         </li>
                                                      <?php
                                                      }else{
                                                      ?>
                                                         <li>
                                                            <img src="<?php echo $misc; ?>img/btn_add.jpg" id="<?php echo $parentGroup['groupName'];?>Btn" width="13" style="cursor:pointer;" onclick="viewMore(this)">
                                                            <span style="cursor:pointer;" id="<?php echo $parentGroup['groupName'];?>" onclick="groupView(this)">
                                                            <?php echo $parentGroup['groupName'];?>
                                                            </span>
                                                         </li>
                                                      <?php
                                                      }
                                                   }
                                                ?>
                                                </ul>
                                                </li>
                                             </ul>
                                          </div>
                                       </td>
                                       <td class ="basic_td" width="30%" align="center">
                                          <div class="click_group_user"></div>
                                       </td>
                                       <td class ="basic_td" width="10%" align="center">
                                          결재방법
                                          <div>
                                             <input type="radio" name="approval_type" value="결재" checked />결재<br>
                                             <input type="radio" name="approval_type" value="합의" />합의<br><br>
                                             <img src="<?php echo $misc;?>img/btn_right.jpg" style="cursor:pointer;width:22px;height:22px;" border="0" onClick="approver_add();"/><br><br>
                                             <img src="<?php echo $misc;?>img/btn_left.jpg" style="cursor:pointer;width:22px;height:22px;" border="0" onClick="approver_del();"/><br><br>
                                          </div>
                                       </td>
                                       <td class ="basic_td" width="30%" align="center">
                                          <table id="select_approver" width="90%" class="basic_table sortable">
                                             <?php echo $view_val['approver_line']; ?>
                                          </table>
                                       </td>
                                    </tr>
                                 </table>
                              </div>
                              <div>
                                 <img src="<?php echo $misc;?>img/btn_cancel.jpg" style="cursor:pointer;float:right;margin-left:5px;margin-top:5px;" border="0" onClick="closeModal();"/>
                                 <img src="<?php echo $misc;?>img/btn_ok.jpg" style="cursor:pointer;float:right;margin-top:5px;" border="0" onClick="saveApproverLineModal();"/><br>
                              </div>
                        </div>
                     </div> -->
                     <!-- 결재모달 -->
                     <div id="approval_modal" class="searchModal">
                        <div class="search-modal-content" style='height:auto; min-height:400px;overflow: auto;'>
                           <h2>결재처리</h2>
                              <div style="margin-top:30px;height:auto; min-height:300px;overflow:auto;">
                                 <table class="basic_table" style="width:100%;">
                                    <tr>
                                       <td bgcolor="f8f8f9" height="40" align="right" class="basic_td">결재처리</td>
                                       <td class="basic_td">
                                          <input type="radio" name="approval_status" value="Y" onchange="approval_status_txt(this.value,'<?php echo $cur_approval_line['approval_type']; ?>');" checked /><?php echo $cur_approval_line['approval_type']; ?>
                                          <input type="radio" name="approval_status" value="N" onchange="approval_status_txt(this.value,'<?php echo $cur_approval_line['approval_type']; ?>');" />반려
                                       </td>
                                    </tr>
                                    <tr>
                                       <td bgcolor="f8f8f9" align="right" class="basic_td">결재의견</td>
                                       <td class="basic_td">
                                          <textarea id="approval_opinion" name="approval_opinion" style="width:100%;height:200px;"><?php if($cur_approval_line['approval_type']=="결재"){echo "승인합니다.";}else{echo "합의합니다.";} ?></textarea>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td bgcolor="f8f8f9" align="right" class="basic_td">상세</td>
                                       <td class="basic_td">
                                          <!-- <textarea id="approval_opinion" name="approval_opinion" style="width:100%;height:200px;"><?php if($cur_approval_line['approval_type']=="결재"){echo "승인합니다.";}else{echo "합의합니다.";} ?></textarea> -->
                                          <div id="details">
                                          </div>
                                       </td>
                                    </tr>
                                 </table>

                              </div>
                              <div>
                                 <img src="<?php echo $misc;?>img/btn_cancel.jpg" style="cursor:pointer;float:right;margin-left:5px;margin-top:5px;" border="0" onClick="closeModal();"/>
                                 <input type="button" value="결재" class="btn-common btn-color2" style="cursor:pointer;float:right;margin-left:5px;margin-top:5px;width:64px;height:31px;" onclick="approval_save(1);" >
                              </div>
                        </div>
                     </div>
                     <!-- 진행현황모달 -->
                     <div id="progress_status_modal" class="searchModal">
                        <div class="search-modal-content" style='height:auto; min-height:400px;overflow: auto;'>
                           <h2>진행현황</h2>
                              <div style="margin-top:30px;height:auto; min-height:300px;overflow:auto;">
                                 <table class="basic_table" style="width:100%;text-align:center;">
                                    <tr bgcolor="f8f8f9">
                                       <td width = "5%" height=50 class="basic_td">순번</td>
                                       <td width = "15%" class="basic_td">결재자</td>
                                       <td width = "8%" class="basic_td">결재유형</td>
                                       <td width = "8%" class="basic_td">결재</td>
                                       <td width = "10%" class="basic_td">배정일시</td>
                                       <td width = "10%" class="basic_td">확인일시</td>
                                       <td width = "10%" class="basic_td">결재일시</td>
                                       <td width = "34%" class="basic_td">의견</td>
                                    </tr>

                                    <?php
                                    $idx=1;
                                    foreach($approval_line as $al){
                                       echo "<tr>";
                                       echo "<td height=40 class='basic_td'>{$idx}</td>";
                                       echo "<td class='basic_td'>{$al['user_name']} {$al['user_duty']} {$al['user_group']}";
                                       if($al['delegation_seq']!=''){
                                          echo "<br>(위임) {$al['mandatary']} {$al['mandatary_group']}";
                                       }
                                       echo "</td>";
                                       echo "<td class='basic_td'>{$al['approval_type']}</td>";
                                       if($al['approval_status'] == "N"){
                                          echo "<td class='basic_td'>반려</td>";
                                       }else if($al['approval_status'] == "Y" && $al['approval_type']=="결재"){
                                          echo "<td class='basic_td'>승인</td>";
                                       }else if($al['approval_status'] == "Y" && $al['approval_type']=="합의"){
                                          echo "<td class='basic_td'>합의</td>";
                                       }else{
                                          echo "<td class='basic_td'>미결</td>";
                                       }

                                       echo "<td class='basic_td'>{$al['assignment_date']}</td>";
                                       echo "<td class='basic_td'>{$al['check_date']}</td>";
                                       echo "<td class='basic_td'>{$al['approval_date']}</td>";
                                       echo "<td align='left' class='basic_td'>{$al['approval_opinion']}</td>";
                                       echo "</tr>";
                                       $idx++;
                                    }?>
                                 </table>
                              </div>
                              <div align="right">
                            <input type ="button" class="btn-common btn-color4" value="취소" style="width:61px;" onClick="closeModal();">
                              </div>
                        </div>
                     </div>
                     <!-- 보류모달 -->
                     <div id="hold_modal" class="searchModal">
                        <div class="search-modal-content" style='height:auto; min-height:400px;overflow: auto;'>
                           <h2>보류</h2>
                              <div style="margin-top:30px;height:auto; min-height:300px;overflow:auto;">
                                 <table class="basic_table" style="width:100%;text-align:center;">
                                    <tr>
                                       <td bgcolor="f8f8f9" align="right" height=200 class="basic_td">보류의견</td>
                                       <td  height=200 class="basic_td">
                                          <textarea id="hold_opinion" name="hold_opinion" style="width:100%;height:100%"></textarea>
                                       </td>
                                    </tr>
                                 </table>
                              </div>
                              <div>
                                 <img src="<?php echo $misc;?>img/btn_cancel.jpg" style="cursor:pointer;float:right;margin-left:5px;margin-top:5px;" border="0" onClick="closeModal();"/>
                                 <input type="button" value="저장" class="btn-common btn-color2" style="cursor:pointer;float:right;margin-left:5px;margin-top:5px;width:64px;height:31px;" onclick="hold('save');" >
                              </div>
                        </div>
                     </div>
                     <!-- 결재선변경모달 -->
                     <div id="select_approval_modal" class="searchModal">
                        <div class="search-modal-content" style='height:auto; min-height:400px;overflow: auto;'>
                           <h2>결재선변경</h2>
                              <div style="margin-top:30px;height:auto; min-height:300px;overflow:auto;">
                                 <!-- <input type="button" value="조직원 전체 선택" style="float:right;margin-bottom:5px;" onclick="select_user_add('all');" > -->
                                 <table class="basic_table" style="width:100%;height:300px;vertical-align:middle;">
                                    <tr>
                                       <td class ="basic_td" width="30%">
                                          <div id="groupTree">
                                             <ul>
                                                <li>
                                                <span style="cursor:pointer;" id="all" onclick="groupView(this)">
                                                   (주)두리안정보기술
                                                </span>
                                                <ul>
                                                <?php
                                                   foreach ( $group_val as $parentGroup ) {
                                                      if($parentGroup['childGroupNum'] <= 1){
                                                      ?>
                                                         <li>
                                                            <ins>&nbsp;</ins>
                                                            <span style="cursor:pointer;" id="<?php echo $parentGroup['groupName'];?>" onclick="groupView(this)">
                                                            <ins>&nbsp;</ins>
                                                            <?php echo $parentGroup['groupName'];?>
                                                            </span>
                                                         </li>
                                                      <?php
                                                      }else{
                                                      ?>
                                                         <li>
                                                            <img src="<?php echo $misc; ?>img/btn_add.jpg" id="<?php echo $parentGroup['groupName'];?>Btn" width="13" style="cursor:pointer;" onclick="viewMore(this)">
                                                            <span style="cursor:pointer;" id="<?php echo $parentGroup['groupName'];?>" onclick="groupView(this)">
                                                            <?php echo $parentGroup['groupName'];?>
                                                            </span>
                                                         </li>
                                                      <?php
                                                      }
                                                   }
                                                ?>
                                                </ul>
                                                </li>
                                             </ul>
                                          </div>
                                       </td>
                                       <td class ="basic_td" width="30%" align="center">
                                          <div class="click_group_user"></div>
                                       </td>
                                       <td class ="basic_td" width="10%" align="center">
                                          결재방법
                                          <div>
                                             <input type="radio" name="approval_type" value="결재" checked />결재<br>
                                             <input type="radio" name="approval_type" value="합의" />합의<br><br>
                                             <img src="<?php echo $misc;?>img/btn_right.jpg" style="cursor:pointer;width:22px;height:22px;" border="0" onClick="approver_add();"/><br><br>
                                             <img src="<?php echo $misc;?>img/btn_left.jpg" style="cursor:pointer;width:22px;height:22px;" border="0" onClick="approver_del();"/><br><br>
                                          </div>
                                       </td>
                                       <td class ="basic_td" width="30%" align="center" style="position: relative;">
                                          <!-- <div style="background-color:#f8f8f9;margin-top:20px;text-align:left;position: absolute;top:5px;">
                                            &nbsp;&nbsp; 사용자 결재선
                                            <select id="select_user_approval_line" name="select_user_approval_line" class="input5" style="margin-left:15px;" onchange="click_user_approval_line();">
                                               <option value="">-- 선택 --</option>
                                               <?php foreach($user_approval_line as $ual){
                                                echo "<option value='{$ual['seq']}'>{$ual['approval_line_name']}</option>";
                                               }?>
                                            </select>
                                            <img src="<?php echo $misc;?>img/btn_delete.jpg" style="cursor:pointer;vertical-align:middle;width:50px;margin-left:15px;" border="0" onClick="user_approval_line_save();"/>
                                          </div> -->
                                          <table id="select_approver" width="90%" class="basic_table sortable">
                                             <tr bgcolor="f8f8f9" class="sortable_disabled">
                                                <td height="30"></td>
                                                <td height="30">결재</td>
                                                <td height="30"><?php echo $name." ".$duty." ".$group; ?></td>
                                             </tr>
                                             <?php
                                             if(!empty($approval_line)){
                                                foreach($approval_line as $al){
                                                   echo "<tr class='select_approver ";
                                                   if($al['assignment_date'] != ""){
                                                      echo "sortable_disabled' >";
                                                   }else{
                                                      echo "' onclick='click_user({$al['user_seq']},".'"'.$al['user_name'].' '.$al['user_duty'].' '.$al['user_group'].'"'.",this)'>";
                                                   }
                                                   echo "<td height=30></td>";
                                                   if($al['assignment_date'] != ""){
                                                      echo "<td>{$al['approval_type']}</td>";
                                                   }else{
                                                      echo "<td onclick='change_approval_type(this)'>{$al['approval_type']}</td>";
                                                   }
                                                   echo "<td>{$al['user_name']} {$al['user_duty']} {$al['user_group']}
                                                      <input type ='hidden' name='approval_line_seq' value='{$al['user_seq']}'>
                                                      <input type ='hidden' name='approval_line_type' value='{$al['approval_type']}'>
                                                   </td>
                                                   </tr>";
                                                }
                                             }
                                             ?>
                                          </table>
                                          <!-- <div style="background-color:#f8f8f9;margin-top:20px;text-align:left;position: absolute;bottom:5px;">
                                            &nbsp;&nbsp; 사용자 결재선명 <input type="text" id="approval_line_name" name="approval_line_name"class="input5" style="margin-left:15px;">
                                            <img src="<?php echo $misc;?>img/btn_add2.jpg" style="cursor:pointer;vertical-align:middle;width:50px;margin-left:15px;" border="0" onClick="user_approval_line_save();"/>
                                          </div> -->
                                       </td>
                                    </tr>
                                 </table>
                              </div>
                              <div style="margin-top:5px;float:right;" >
                                 <input type ="button" class="btn-common btn-color2" value="변경" style="width:61px;" onClick="changeApproverLine();">
                                 <input type ="button" class="btn-common btn-color4" value="취소" style="width:61px;" onClick="closeModal();">

                                 <!-- <img src="<?php echo $misc;?>img/btn_ok.jpg" style="cursor:pointer;float:right;margin-top:5px;" border="0" onClick="saveApproverLineModal();"/><br> -->
                              </div>
                        </div>
                     </div>
                     <div id="restore_approval_modal" class="searchModal">
                        <div class="search-modal-content" style='height:auto; min-height:400px;overflow: auto;'>
                           <h2>결재복원</h2>
                              <div style="margin-top:30px;height:auto; min-height:300px;overflow:auto;">
                              <div style="background-color:#f8f8f9;padding:10px 10px 10px 10px;margin-bottom:30px;text-align:left;">
                                 결재 회수 : 결재문서를 기안자의 결재요청 이전 상태로 변경<br>
                                 결재 복원 : 결재문서를 선택한 복원위치(결재자)의 결재대기 상태로 변경
                                 <br>
                              </div>
                              <table class="basic_table" style="width:100%;text-align:center;">
                                    <tr bgcolor="f8f8f9">
                                       <td width = "5%" height=50 class="basic_td">순번</td>
                                       <td width = "15%" class="basic_td">결재자</td>
                                       <td width = "8%" class="basic_td">결재유형</td>
                                       <td width = "8%" class="basic_td">결재상태</td>
                                       <td width = "10%" class="basic_td">복원위치</td>
                                    </tr>
                                    <?php
                                    $idx=1;
                                    foreach($approval_line as $al){
                                       echo "<tr>";
                                       echo "<td height=40 class='basic_td'>{$idx}</td>";
                                       echo "<td class='basic_td'>{$al['user_name']} {$al['user_duty']} {$al['user_group']}";
                                       if($al['delegation_seq']!=''){
                                          echo "<br>(위임) {$al['mandatary']} {$al['mandatary_group']}";
                                       }
                                       echo "</td>";
                                       echo "<td class='basic_td'>{$al['approval_type']}</td>";
                                       if($al['approval_status'] == "N"){
                                          echo "<td class='basic_td'>반려</td>";
                                       }else if($al['approval_status'] == "Y" && $al['approval_type']=="결재"){
                                          echo "<td class='basic_td'>승인</td>";
                                       }else if($al['approval_status'] == "Y" && $al['approval_type']=="합의"){
                                          echo "<td class='basic_td'>합의</td>";
                                       }else{
                                          echo "<td class='basic_td'>미결</td>";
                                       }

                                       echo "<td class='basic_td'>";
                                       if($al['approval_status'] == "Y" or $al['approval_status'] == "N" ){
                                          echo "<input type='checkbox' name='step' value='{$al['step']}' onclick='stepCheck(this);' />";
                                       }
                                       echo "</td>";
                                       echo "</tr>";
                                       $idx++;
                                    }?>
                                 </table>
                              </div>
                              <div style='float:right;margin-top:5px;' >
                                 <input type='button' class="btn-common btn-color2" style='margin-right:5px;' value='결재복원' onclick="restore_approval();" />
                                 <input type='button' class="btn-common btn-color1" value='결재회수' onclick="approval_withdraw();" />
                                <input type='button' class="btn-common btn-color4" value='취소' onClick="closeModal();"/>
                              </div>
                        </div>
                     </div>
                     <!-- 상세보기모달 -->
                     <div id="details_modal" class="searchModal">
                        <div class="search-modal-content" style='height:auto; min-height:400px;overflow: auto;'>
                           <h2>상세보기</h2>
                              <div id="details_contents" class="summernote_view" style="margin-top:30px;height:auto; min-height:300px;overflow:auto;">
                                 <!-- <table class="basic_table" style="width:100%;text-align:center;">
                                    <tr>
                                       <td bgcolor="f8f8f9" align="right" height=200 class="basic_td">보류의견</td>
                                       <td  height=200 class="basic_td">
                                          <textarea id="hold_opinion" name="hold_opinion" style="width:100%;height:100%"></textarea>
                                       </td>
                                    </tr>
                                 </table> -->
                              </div>
                              <div>
                                 <img src="<?php echo $misc;?>img/btn_cancel.jpg" style="cursor:pointer;float:right;margin-left:5px;margin-top:5px;" border="0" onClick="closeModal();"/>
                                 <!-- <input type="button" value="저장" class="btn-common btn-color2" style="cursor:pointer;float:right;margin-left:5px;margin-top:5px;width:64px;height:31px;" onclick="hold('save');" > -->
                              </div>
                        </div>
                     </div>
                     <!-- 서명확인모달 -->
                     <div id="sign_confirm" class="searchModal">
                        <div class="search-modal-content" style='height:auto; min-height:300px;overflow: auto;width:340px;'>
                           <h2>서명확인</h2>
                              <div style="margin-top:30px;height:auto;overflow:auto;">
                        <?php if(isset($contract_party)){ ?>
                                <input type="hidden" id="sign_user_birthday" value="<?php echo $contract_party['user_birthday']; ?>">
                                <input type="hidden" id="sign_user_signfile" value="<?php echo $contract_party['sign_changename']; ?>">
                        <?php } ?>
                                 <table class="basic_table" style="width:100%;">
                                   <tr>
                               			<td style="font-weight:bold;text-align:center;height:40px;">생년월일</td>
                               			<td>
                               	      <?php if(isset($contract_party) && $contract_party['user_birthday'] != ''){echo date('Y-m-d', strtotime($contract_party['user_birthday']));} ?>
                               			</td>
                               		</tr>
                               		<tr>
                               			<td style="font-weight:bold;text-align:center;height:40px;">서명</td>
                               			<td>
                               				<div>
                               					서명 : <span style="letter-spacing:15px;"><?php echo $this->name; ?></span><span class="stamp" style="background-image:url('/misc/upload/user_sign/<?php if(isset($contract_party)){echo $contract_party['sign_changename'];} ?>')">(인)</span>
                               				</div>
                               			</td>
                               		</tr>
                                  <tr>
                                    <td style="font-weight:bold;text-align:center;height:40px;">서명 비밀번호</td>
                                    <td>
                                      <input type="password" style="width:90%" class="input-common" id="sign_user_password" value="" onkeyup="if(window.event.keyCode==13){sign_confirm()}">
                                    </td>
                                  </tr>
                                 </table>
                              </div>
                              <div style="margin-top:20px;">
                                 <img src="<?php echo $misc;?>img/btn_cancel.jpg" style="cursor:pointer;float:right;margin-left:5px;margin-top:5px;" border="0" onClick="$('#sign_confirm').hide();"/>
                                 <input type="button" value="확인" class="btn-common btn-color2" style="cursor:pointer;float:right;margin-left:5px;margin-top:5px;width:64px;height:31px;" onclick="sign_confirm();" >
                              </div>
                        </div>
                     </div>

                     <!--내용-->
                  </td>
               </tr>
               <!--댓글-->
               <?php if($_GET['type'] != "temporary" ){ ?>
               <tr style="font-family:Noto Sans KR;">
                  <td align="center">
                     <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <form name="rform" method="post">
                           <!-- <input type="hidden" name="seq" value="<?php echo $seq; ?>">
                           <input type="hidden" name="cseq" value=""> -->
                           <tr>
                              <td><h3>댓글</h3></td>
                           </tr>
                           <tr>
                              <td height="1" bgcolor="#d7d7d7"></td>
                           </tr>
                           <?php
                           if(!empty($comment)){
                           foreach ($comment as $item) {
                           ?>
                              <tr>
                                 <td bgcolor="f8f8f9">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="5">
                                       <tr>
                                          <td width="5%" class="answer"><?php echo $item['user_name']; ?></td>
                                          <td width="10%"><?php echo $item['update_date']; ?></td>
                                          <td width="850%" align="left">
                                             <?php if ($id == $item['user_id'] || $biz_lv == 3) { ?>
                                                <img src="<?php echo $misc; ?>img/pencil_btn.png" width="17" height="16" style="cursor:pointer" border="0" onclick="$('#answer<?php echo $item['seq'] ;?>').toggle();" />
                                                <img src="<?php echo $misc; ?>img/btn_del.jpg" width="18" height="17" style="cursor:pointer;margin-left:10px;" border="0" onclick="javascript:commentSave(2,<?php echo $item['seq']; ?>);return false;"  />
                                             <?php } ?>
                                          </td>
                                       </tr>
                                    </table>
                                 </td>
                              </tr>
                              <tr>
                                 <td height="1" bgcolor="#e8e8e8"></td>
                              </tr>
                              <tr>
                                 <td class="answer2">
                                    <?php echo nl2br(str_replace(" ", "&nbsp;", htmlspecialchars($item['contents']))) ?>
                                    <div id ="answer<?php echo $item['seq'] ;?>" style="display:none;">
                                       <textarea id="comment<?php echo $item['seq'] ;?>" cols="130" rows="5" class="input_answer1"><?php echo str_replace(" ", "&nbsp;", htmlspecialchars($item['contents'])) ?></textarea>
                                       <br><input type="button" class ="input5" value="수정" onclick="javascript:commentSave(1,<?php echo $item['seq']; ?>);return false;" />
                                       <input type="button" class ="input5" value="취소" onclick="$('#answer<?php echo $item['seq'] ;?>').toggle();" />
                                    </div>

                                 </td>
                              </tr>
                              <tr>
                                 <td height="1" bgcolor="#e8e8e8"></td>
                              </tr>
                           <?php
                           }}
                           ?>
                           <tr>
                              <td bgcolor="f8f8f9">
                                 <table width="100%" border="0" cellspacing="0" cellpadding="5">
                                    <tr>
                                       <td width="5%" class="answer"><?php echo $name; ?></td>
                                       <td width="95%" align="right">
                                          <!-- <img src="<?php echo $misc; ?>img/btn_del.jpg" width="18" height="17" /> -->
                                          <input type="image" src="<?php echo $misc; ?>img/btn_answer2.jpg" width="60" height="20" style="cursor:pointer;margin-right:10px;" onclick="javascript:commentSave(0);return false;" />
                                       </td>
                                    </tr>
                                 </table>
                              </td>
                           </tr>
                           <tr>
                              <td height="1" bgcolor="#e8e8e8"></td>
                           </tr>
                           <tr>
                              <td class="answer2" align="center"><textarea name="comment" id="comment" cols="130" rows="5" class="input_answer1"></textarea></td>
                           </tr>
                           <tr>
                              <td height="1" bgcolor="#d7d7d7"></td>
                           </tr>
                        </form>
                     </table>
                  </td>
               </tr>
               <tr>
                  <td height="50"></td>
               </tr>
               <?php } ?>
               <!-- 버튼
               <tr>
                  <td align="center"><input type="image" src="<?php echo $misc; ?>img/btn_answer2.jpg" width="60" height="20" style="cursor:pointer" onclick="javascript:chkForm2();return false;" /></td>
               </tr> -->
               <!-- 댓글끝 -->
            </table>
         </td>
      </tr>
   </table>
</form>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
<!-- <input type="button" value="썸머노트" onclick="summer();"> -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.js"></script>
<script>
   //들어왔는데 내가 결재라인인데 check_date가 비었을경우
   <?php
   if(empty($cur_approval_line) != true){
      if(($cur_approval_line['user_id'] == $id || !empty($mandatary)) && $cur_approval_line['check_date'] == ""){
   ?>
   $.ajax({
      type: "POST",
      cache: false,
      url: "<?php echo site_url(); ?>/biz/approval/approval_check_date_update",
      dataType: "json",
      async :false,
      data: {
         seq : $("#cur_approver_line_seq").val()
      },
      success: function (data) {
      }
   });
   <?php
      }
   }
   ?>
   // saveApproverLineModal();
    // 파일 리스트 번호
    var fileIndex = 0;
    // 등록할 전체 파일 사이즈
    var totalFileSize = 0;
    // 파일 리스트
    var fileList = new Array();
    // 파일 사이즈 리스트
    var fileSizeList = new Array();
    // 등록 가능한 파일 사이즈 MB
    var uploadSize = 50;
    // 등록 가능한 총 파일 사이즈 MB
    var maxUploadSize = 500;

    $(function (){
        // 파일 드롭 다운
        fileDropDown();
    });

    // 파일 드롭 다운
    function fileDropDown(){
        var dropZone = $("#dropZone");
        //Drag기능
        dropZone.on('dragenter',function(e){
            e.stopPropagation();
            e.preventDefault();
            // 드롭다운 영역 css
            dropZone.css('background-color','#E3F2FC');
        });
        dropZone.on('dragleave',function(e){
            e.stopPropagation();
            e.preventDefault();
            // 드롭다운 영역 css
            dropZone.css('background-color','#FFFFFF');
        });
        dropZone.on('dragover',function(e){
            e.stopPropagation();
            e.preventDefault();
            // 드롭다운 영역 css
            dropZone.css('background-color','#E3F2FC');
        });
        dropZone.on('drop',function(e){
            e.preventDefault();
            // 드롭다운 영역 css
            dropZone.css('background-color','#FFFFFF');

            var files = e.originalEvent.dataTransfer.files;
            if(files != null){
                if(files.length < 1){
                    alert("폴더 업로드 불가");
                    return;
                }
                selectFile(files)
            }else{
                alert("ERROR");
            }
        });
    }

    // 파일 선택시
    function selectFile(files){
        // 다중파일 등록
        if(files != null){
            for(var i = 0; i < files.length; i++){
                // 파일 이름
                var fileName = files[i].name;
                var fileNameArr = fileName.split("\.");
                // 확장자
                var ext = fileNameArr[fileNameArr.length - 1];
                // 파일 사이즈(단위 :MB)
                var fileSize = files[i].size / 1024 / 1024;

                if($.inArray(ext, ['exe', 'bat', 'sh', 'java', 'jsp', 'html', 'js', 'css', 'xml']) >= 0){
                    // 확장자 체크
                    alert("등록 불가 확장자");
                    break;
                }else if(fileSize > uploadSize){
                    // 파일 사이즈 체크
                    alert("용량 초과\n업로드 가능 용량 : " + uploadSize + " MB");
                    break;
                }else{
                    // 전체 파일 사이즈
                    totalFileSize += fileSize;

                    // 파일 배열에 넣기
                    fileList[fileIndex] = files[i];

                    // 파일 사이즈 배열에 넣기
                    fileSizeList[fileIndex] = fileSize;

                    // 업로드 파일 목록 생성
                    addFileList(fileIndex, fileName, fileSize);

                    // 파일 번호 증가
                    fileIndex++;
                }
            }
        }else{
            alert("ERROR");
        }
    }

    // 업로드 파일 목록 생성
    function addFileList(fIndex, fileName, fileSize){
        var html = "";
        html += "<tr id='fileTr_" + fIndex + "'>";
        html += "    <td class='left' >";
        html +=         fileName + " / " + fileSize + "MB "  + "<a href='#' onclick='deleteFile(" + fIndex + "); return false;' class='btn small bg_02'><img src='<?php echo $misc;?>/img/btn_del2.jpg' style='vertical-align:middle;'></a>"
        html += "    </td>"
        html += "</tr>"

        $('#fileTableTbody').append(html);
    }

    // 업로드 파일 삭제
    function deleteFile(fIndex){
        // 전체 파일 사이즈 수정
        totalFileSize -= fileSizeList[fIndex];

        // 파일 배열에서 삭제
        delete fileList[fIndex];

        // 파일 사이즈 배열 삭제
        delete fileSizeList[fIndex];

        // 업로드 파일 테이블 목록에서 삭제
        $("#fileTr_" + fIndex).remove();
    }

    // 파일 등록
    function uploadFile(){
        // 등록할 파일 리스트
        var uploadFileList = Object.keys(fileList);

        // 파일이 있는지 체크
        if(uploadFileList.length == 0){
            // 파일등록 경고창
            alert("파일이 없습니다.");
            return;
        }

        // 용량을 500MB를 넘을 경우 업로드 불가
        if(totalFileSize > maxUploadSize){
            // 파일 사이즈 초과 경고창
            alert("총 용량 초과\n총 업로드 가능 용량 : " + maxUploadSize + " MB");
            return;
        }

        if(confirm("등록 하시겠습니까?")){
            // 등록할 파일 리스트를 formData로 데이터 입력
            var form = $('#uploadForm');
            var formData = new FormData(form);
            for(var i = 0; i < uploadFileList.length; i++){
                formData.append('files', fileList[uploadFileList[i]]);
            }

            $.ajax({
                url:"업로드 경로",
                data:formData,
                type:'POST',
                enctype:'multipart/form-data',
                processData:false,
                contentType:false,
                dataType:'json',
                cache:false,
                success:function(result){
                    if(result.data.length > 0){
                        alert("성공");
                        location.reload();
                    }else{
                        alert("실패");
                        location.reload();
                    }
                }
            });
        }
    }


    $('#summernote').summernote({ placeholder: 'Hello stand alone ui', tabsize: 2, height: 200 });

   //사용자 선택
   function select_user(s_id){
      $("#click_user").attr('id','');
      $("#group_tree_modal").show();
      $("#select_user_id").val(s_id);
      if($("#"+$("#select_user_id").val()).val() != ""){
         var select_user = ($("#"+$("#select_user_id").val()).val()).split(',');
         var txt = '';
         for(i=0; i<select_user.length; i++){
            txt += "<div class='select_user' onclick='click_user(-1,"+'"'+select_user[i]+'"'+",this)'>"+select_user[i]+"</div>";
         }
         $("#select_user").html(txt);
      }
   }

   //사용자 선택 저장
   function saveUserModal(){
      var txt ='';
      for(i=0; i <$(".select_user").length; i++){
         var val = $(".select_user").eq(i).text().split(' ');
         if(i == 0){
            txt += val[0]+" "+val[1];
         }else{
            txt += "," + val[0]+" "+val[1];
         }
      }
      $.ajax({
         type: "POST",
         cache: false,
         url: "<?php echo site_url(); ?>/biz/approval/electronic_approval_doc_modify_action",
         dataType: "json",
         async: false,
         data: {
            type:1,
            seq: <?php echo $seq; ?>,
            referrer : txt
         },
         success: function (data) {
            if(data){
               alert("수정완료");
               location.reload();
            }else{
               alert("수정실패");
            }
         }
      });
   }

   // groupView();

   //상위 그룹에서 하위 그룹 보기
   function viewMore(button){
   var parentGroup = (button.id).replace('Btn','');
   if($(button).attr("src")==="<?php echo $misc; ?>img/btn_add.jpg"){
      var src = "<?php echo $misc; ?>img/btn_del0.jpg";
      $.ajax({
         type: "POST",
         cache: false,
         url: "<?php echo site_url(); ?>/ajax/childGroup",
         dataType: "json",
         async: false,
         data: {
         parentGroup:parentGroup
         },
         success: function (data) {
         var text = '<ul id="'+parentGroup+'Group" class="'+parentGroup+'" >';
         for(i=0; i<data.length; i++){
               text += '<li><ins>&nbsp;</ins><span style="cursor:pointer;" id="'+data[i].groupName+'" onclick="groupView(this)"><ins>&nbsp;</ins>'+data[i].groupName+'</span></li>';
         }
         text += '</ul>'
         //   $("#"+parentGroup).html($("#"+parentGroup).html()+text);
         $("#"+parentGroup).after(text);

         }
      });
   }else{
      var src = "<?php echo $misc; ?>img/btn_add.jpg";
      $("#"+parentGroup+"Group").hide();
      $("."+parentGroup).remove();
   }
   $("#"+parentGroup+"Btn").attr('src', src);
   }

   //그룹 클릭했을 떄 해당하는 user 보여주기
   function groupView(group) {
      if (group == undefined) {
         var groupName = "all";
      } else {
         var groupName = $(group).attr("id");
      }

      $.ajax({
         type: "POST",
         cache: false,
         url: "<?php echo site_url(); ?>/ajax/groupView",
         dataType: "json",
         async: false,
         data: {
            group: groupName
         },
         success: function (data) {
            var txt = '';
            for (i = 0; i < data.length; i++) {
               txt += "<div class='click_user' onclick='click_user(" + data[i].seq + ',"' + data[i].user_name + '",this' + ");'>" + data[i].user_name + " " + data[i].user_duty + " " + data[i].user_group + "</div>";
            }
            $(".click_group_user").html(txt);
         }
      });
   }

   //user || approver 선택
   function click_user(seq,name,obj){
      $(".click_user").css('background-color','');
      $(".select_user").css('background-color','');
      $(".select_approver").css('background-color','');
      $(".click_user").attr('id','');
      $(".select_user").attr('id','');
      $(".select_approver").attr('id','');
      $(obj).css('background-color','#f8f8f9');
      $(obj).attr('id','click_user');
      $("#click_user_seq").val(seq);
   }
   //user 추가
   function select_user_add(type){
      if(type == 'all'){
         var result = confirm("회사 내 전체 조직원을 선택하시겠습니까?");
         if(result){
            $.ajax({
               type: "POST",
               cache: false,
               url: "<?php echo site_url(); ?>/ajax/groupView",
               dataType: "json",
               async :false,
               data: {
                  group: 'all'
               },
               success: function (data) {
                  var html = '';
                  for (i = 0; i < data.length; i++) {
                     html += "<div class='select_user' onclick='click_user("+'"'+data[i].user_name+'"'+",this)'>"+data[i].user_name+" "+data[i].user_duty+" "+data[i].user_group+"</div>";
                  }
                  $("#select_user").html(html);
               }
            });
         }else{
         return false;
         }
      }else{
         var duplicate_check = false;
         for(i=0; i<$(".select_user").length; i++){
            if($("#click_user").html() == $(".select_user").eq(i).text()){
               duplicate_check = true
            }
         }
         if(duplicate_check == true || $("#click_user").html() == undefined){
            return false;
         }else{
            var html = "<div class='select_user' onclick='click_user("+'"'+$("#click_user").html()+'"'+",this)'>"+$("#click_user").html()+"</div>";
            $("#select_user").html($("#select_user").html()+html);
         }
      }

   }

   //추가된 user 중에 삭제
   function select_user_del(type){
      if(type == "all"){
         $(".select_user").remove();
      }else{
         if($("#click_user").attr('class') == 'select_user'){
            $("#click_user").remove();
         }
      }
   }

   //사용자 선택 모달 닫아
   function closeModal(){
      var check = confirm("이 페이지에서 나가시겠습니까? 작성중인 내용은 저장 되지 않습니다.")
      if(check == true){
         $(".searchModal").hide();
      }else{
         return false;
      }
   }

   //sortable tr 상하이동
   $(".sortable").sortable({
      start: function(event, ui) {
         finalReferrer();
      },
      stop: function(event, ui) {
         finalReferrer();
      },
   });

   //결재선 마지막 줄 최종으로 표시
   function finalReferrer(){
      for(i=0; i < $("#select_approver").find($("td")).length; i++){
         if($("#select_approver").find($("td")).eq(i).html() == "최종"){
            $("#select_approver").find($("td")).eq(i).html("");
         }else if(i == ($("#select_approver").find($("td")).length)-3){
            $("#select_approver").find($("td")).eq(i).html("최종");
         }
      }
   }

   //결재 <-> 합의 바꿔
   function change_approval_type(obj){
      var approval_line_type = $(obj).parent().find($("input[name=approval_line_type]"));
      if($(obj).html()=="결재"){
         $(obj).html("합의");
         approval_line_type.val("합의");
      }else{
         $(obj).html("결재");
         approval_line_type.val("결재");
      }
   }

   function attach_view(seq){
      window.open('<?php echo site_url();?>/biz/approval/electronic_approval_doc_preview?seq='+seq,'_blank',"width = 1200, height = 1000, top = 100, left = 400, location = no,status=no,status=no,toolbar=no,scrollbars=no");

   }

   //결재모달
   function approval_ok(){
      $("#approval_modal").show();
   }

   //결재 승인/반려
   function approval_save(t){
      var delegation_seq = '';
      <?php if(!empty($mandatary)){ ?>
         delegation_seq = "<?php echo $mandatary['seq']; ?>";
      <?php } ?>
      if(t == '1' && $('#sign_confirm_yn').val() == 'N'){
         $.ajax({
            type: "POST",
            cache: false,
            url: "<?php echo site_url(); ?>/biz/approval/approval_save",
            dataType: "json",
            async :false,
            data: {
               seq : $("#cur_approver_line_seq").val(),
               approval_form_seq : $("#approval_form_seq").val(),
               next_seq : $("#next_approver_line_seq").val(),
               approval_status: $("input[name=approval_status]:checked").val(),
               approval_opinion: $("#approval_opinion").val(),
               details:$("#details").summernote("code"),
               approval_doc_seq: "<?php echo $seq ;?>",
               final_approval: "<?php echo $final_approval; ?>",
               delegation_seq : delegation_seq,
               doc_subject: "<?php echo str_replace('"', "'", $view_val['approval_doc_name']); ?>",
               writer_id : "<?php echo $view_val['writer_id']; ?>"
            },
            success: function (data) {
               if(data){
                  alert("결재가 저장되었습니다.");
                  location.href ="<?php echo site_url();?>/biz/approval/electronic_approval_list?type=<?php echo $_GET['type']; ?>";
               }else{
                  alert("결재저장 실패!");
               }
            }
         });
      } else if(t == '1' && $('#sign_confirm_yn').val() == 'Y') {
        if($("input[name=approval_status]:checked").val() == 'N') {
          $.ajax({
             type: "POST",
             cache: false,
             url: "<?php echo site_url(); ?>/biz/approval/approval_save",
             dataType: "json",
             async :false,
             data: {
                seq : $("#cur_approver_line_seq").val(),
                approval_form_seq : $("#approval_form_seq").val(),
                next_seq : $("#next_approver_line_seq").val(),
                approval_status: $("input[name=approval_status]:checked").val(),
                approval_opinion: $("#approval_opinion").val(),
                details:$("#details").summernote("code"),
                approval_doc_seq: "<?php echo $seq ;?>",
                final_approval: "<?php echo $final_approval; ?>",
                delegation_seq : delegation_seq,
                doc_subject: "<?php echo str_replace('"', "'", $view_val['approval_doc_name']); ?>",
                writer_id : "<?php echo $view_val['writer_id']; ?>"
             },
             success: function (data) {
                if(data){
                   alert("결재가 저장되었습니다.");
                   location.href ="<?php echo site_url();?>/biz/approval/electronic_approval_list?type=<?php echo $_GET['type']; ?>";
                }else{
                   alert("결재저장 실패!");
                }
             }
          });
        } else {
          alert('결재시 계약서에 서명이 추가됩니다.\r서명과 생년월일을 확인하고 비밀번호 인증을 진행해주세요.');
          $('#sign_confirm').show();
        }
      }else{ //결재 취소 눌렀을때
         if(confirm("결재 취소 하시겠습니까?")){
            $.ajax({
               type: "POST",
               cache: false,
               url: "<?php echo site_url(); ?>/biz/approval/approval_save",
               dataType: "json",
               async :false,
               data: {
                  seq : "<?php if(!empty($cancel_line)){echo $cancel_line['seq'] ;}?>",
                  approval_form_seq : $("#approval_form_seq").val(),
                  next_seq : $("#cancel_line_seq").val(),
                  approval_status: '',
                  approval_opinion: '',
                  approval_doc_seq: '<?php echo $seq ;?>',
                  details:'',
                  delegation_seq :'',
                  doc_subject: "<?php echo str_replace('"', "'", $view_val['approval_doc_name']); ?>",
                  writer_id : "<?php echo $view_val['writer_id']; ?>"
               },
               success: function (data) {
                  if(data){
                     alert("결재가 취소되었습니다.");
                     // location.reload();
                     location.href ="<?php echo site_url();?>/biz/approval/electronic_approval_list?type=<?php echo $_GET['type']; ?>";
                  }else{
                     alert("결재취소 실패!");
                  }
               }
            });
         }
      }
   }

   //진행현황 클릭!
   function progressStatus(){
      $("#progress_status_modal").show();
   }

   //결재회수
   function approval_withdraw(){
      $.ajax({
         type: "POST",
         cache: false,
         url: "<?php echo site_url(); ?>/biz/approval/approval_withdraw",
         dataType: "json",
         async :false,
         data: {
            seq : $("#seq").val(),
            approval_form_seq:$("#approval_form_seq").val(),
            approval_doc_status : "004",
            doc_subject : "<?php echo str_replace('"', "'", $view_val['approval_doc_name']); ?>", //메일보내야해서
            writer_id : "<?php echo $view_val['writer_id']; ?>"
         },
         success: function (data) {
            if(data){
               alert("결재가 회수되었습니다.");
               location.href ="<?php echo site_url();?>/biz/approval/electronic_approval_doc_list?type=request";
            }else{
               alert("결재 회수가 실패하였습니다.");
            }
         }
      })
   }

   function hold(t){
      if(t == 1){ // 보류
         $("#hold_modal").show();

      }else if(t == 0){ //보류해제
         $.ajax({
            type: "POST",
            cache: false,
            url: "<?php echo site_url(); ?>/biz/approval/approval_hold",
            dataType: "json",
            async :false,
            data: {
               seq : $("#seq").val(),
               approval_doc_hold : "N",
               hold_opinion: $("#hold_opinion").val(),
               doc_subject : "<?php echo str_replace('"', "'", $view_val['approval_doc_name']); ?>", //메일보내야해서
               writer_id : "<?php echo $view_val['writer_id']; ?>"
            },
            success: function (data) {
               if(data){
                  alert("보류 취소 되었습니다.");
                  location.reload();
               }else{
                  alert("보류 취소 처리에 실패하였습니다.");
               }
            }
         })
      }else if (t == 'save'){
         $.ajax({
            type: "POST",
            cache: false,
            url: "<?php echo site_url(); ?>/biz/approval/approval_hold",
            dataType: "json",
            async :false,
            data: {
               seq : $("#seq").val(),
               approval_doc_hold : "Y",
               hold_opinion: $("#hold_opinion").val(),
               doc_subject : "<?php echo str_replace('"', "'", $view_val['approval_doc_name']); ?>", //메일보내야해서
               writer_id : "<?php echo $view_val['writer_id']; ?>"
            },
            success: function (data) {
               if(data){
                  alert("보류되었습니다.");
                  location.reload();
               }else{
                  alert("보류처리 실패하였습니다.");
               }
            }
         })
      }
   }
   //여기 뷰여서 수정안돼고 버튼 없애는 거
   $("#formLayoutDiv").find($("input:not(input[type=date])")).prop('disabled', true);
   $("#formLayoutDiv").find($("textarea")).prop('disabled', true);
   $("#formLayoutDiv input:not(input[type=radio]):not(input[type=checkbox])").each(function(){
      $(this).replaceWith("<span style='display:inline-block;word-break:break-all;width:95%;"+$(this).attr('style')+"'>"+$(this).val()+"</span>");
   })
   $('#summernote').summernote('disable');

   var zz = $("#formLayoutDiv").find($("tr")).length;
   for(i =0; i<zz; i++){
      // console.log($("#formLayoutDiv").find($("tr")).eq(i).attr('name'))
      if($("#formLayoutDiv").find($("tr")).eq(i).attr('name') != undefined){
         if($("#formLayoutDiv").find($("tr")).eq(i).attr('name').indexOf("multi_row") != -1){
            $("#formLayoutDiv").find($("tr")).eq(i).find("td").eq($("#formLayoutDiv").find($("tr")).eq(i).find("td").length -1).remove();
         }
      }
      $("#formLayoutDiv").find($("img")).remove(); //버튼다지웡

   }

   //개인보관함 팝업
   function personal_storage(){
      window.open("<?php echo site_url(); ?>/biz/approval/electronic_approval_personal_storage_popup?seq=<?php echo $seq; ?>", "popup_window", "width = 500, height = 500, top = 100, left = 400, location = no,status=no,status=no,toolbar=no,scrollbars=no");
   }

   //재기안하러 이동!
   function reApproval(){
      location.href = "<?php echo site_url(); ?>/biz/approval/electronic_approval_doc_modify?seq=<?php echo $_GET['seq']; ?>&type=1";
   }

   //수정하러
   function modifyApproval(){
      location.href = "<?php echo site_url(); ?>/biz/approval/electronic_approval_doc_modify?seq=<?php echo $_GET['seq']; ?>&type=0";
   }

   //복사
   function duplicationApproval(){
      location.href = "<?php echo site_url(); ?>/biz/approval/electronic_approval_doc_modify?seq=<?php echo $_GET['seq']; ?>&type=1";
   }

   //목록버튼
   function list_view(){
     history.back();
      // var type = "<?php echo $type; ?>";
      // if( type == "request" || type == "temporary" ){
      //    location.href = "<?php echo site_url(); ?>/biz/approval/electronic_approval_doc_list?type="+type;
      // }else{
      //    location.href = "<?php echo site_url(); ?>/biz/approval/electronic_approval_list?type="+type;
      // }
   }

   //댓글달기
   function commentSave(type,seq){
      if(type == 0){//등록
         $.ajax({
            type: "POST",
            cache: false,
            url: "<?php echo site_url(); ?>/biz/approval/commentSave",
            dataType: "json",
            async: false,
            data: {
               type : type,
               approval_doc_seq: <?php echo $_GET['seq']; ?> ,
               contents : $("#comment").val()
            },
            success: function (data) {
               if (data) {
                  location.reload();
               } else {
                  alert("답변 등록에 실패하였습니다.");
               }
            }
         })
      }else if(type == 1) {//수정
         $.ajax({
            type: "POST",
            cache: false,
            url: "<?php echo site_url(); ?>/biz/approval/commentSave",
            dataType: "json",
            async: false,
            data: {
               type : type,
               comment_seq: seq,
               contents : $("#comment"+seq).val()
            },
            success: function (data) {
               if (data) {
                  location.reload();
               } else {
                  alert("답변 수정에 실패하였습니다.");
               }
            }
         })
      }else{//삭제
         if(confirm("삭제하시겠습니까?")){
            $.ajax({
               type: "POST",
               cache: false,
               url: "<?php echo site_url(); ?>/biz/approval/commentSave",
               dataType: "json",
               async: false,
               data: {
                  type: type,
                  comment_seq: seq
               },
               success: function (data) {
                  if (data) {
                     location.reload();
                  } else {
                     alert("답변 삭제에 실패하였습니다.");
                  }
               }
            })
         }else{
            return false;
         }
      }
   }


   //결재선 모달 open
   function select_approval_modal(){
      finalReferrer();
      $("#click_user").css('background-color','');
      $("#click_user").attr('id','');
      $("#select_approval_modal").show();
   }

   //결재선 추가
   function approver_add(){
      var duplicate_check = false;
      for(i=0; i<$(".select_approver").length; i++){
         if($(".select_approver").eq(i).html().indexOf($("#click_user").html())!= -1){
            duplicate_check = true
         }
      }

      var approval_type = $('input:radio[name=approval_type]:checked').val();

      if(duplicate_check == true || $("#click_user").html() == undefined){
         return false;
      }else{
         for(i=0; i < $("#select_approver").find($("td")).length; i++){
            if($("#select_approver").find($("td")).eq(i).html() == "최종"){
               $("#select_approver").find($("td")).eq(i).html("");
            }
         }
         var html = "<tr class='select_approver' onclick='click_user("+$("#click_user_seq").val()+',"'+$("#click_user").html()+'"'+",this)'>";
         html += "<td height=30>최종</td><td onclick='change_approval_type(this);' style='cursor:pointer;'>"+approval_type+"</td><td>"+$("#click_user").html()+"<input type='hidden' name='approval_line_seq' value='"+$("#click_user_seq").val()+"' /><input type='hidden' name='approval_line_type' value='"+approval_type+"' /></td>";
         html += "</tr>";
         $("#select_approver").html($("#select_approver").html()+html);
      }
   }
   //결재선 삭제
   function approver_del(){
      if($("#click_user").attr('class').indexOf('select_approver') != -1 ){
         $("#click_user").remove();
         finalReferrer();
      }
   }

   //결재복원 모달 열기
   function restore_approval_modal(){
      $("#restore_approval_modal").show();
   }

   //결재복원
   function restore_approval(){
      if(confirm("결재 복원 하시겠습니까?")){
         var step='';
         $('input:checkbox[name="step"]').each(function () {
            if (this.checked == true) {
               if (step == "") {
                  step += this.value;
               } else {
                  step += ',' + this.value;
               }
            }
         });

         $.ajax({
            type: "POST",
            cache: false,
            url: "<?php echo site_url(); ?>/biz/approval/restore_approval",
            dataType: "json",
            async: false,
            data: {
               seq : <?php echo $seq ?>,
               step: step
            },
            success: function (data) {
               if (data) {
                  alert("결재 복원 되었습니다.");
                  location.reload();
               } else {
                  alert("결재 복원에 실패하였습니다.");
               }
            }
         })
      }
   }

   //결재복원 체크박스 선택
   function stepCheck(obj){
      var eq = $("input[name=step]").index(obj);
      if($("input[name=step]").eq(eq).is(":checked")){
         for(i=0; i<$("input[name=step]").length; i++){
            if(i >= eq){
               $("input[name=step]").eq(i).prop("checked", true);
            }else{
               $("input[name=step]").eq(i).prop("checked", false);
            }
         }
      }

   }

   //sortable tr 상하이동
   $(".sortable").sortable({
      items: "tr:not(.sortable_disabled)",
      start: function(event, ui) {
         finalReferrer();
      },
      stop: function(event, ui) {
         finalReferrer();
      },
   });

   //결재선 변경
   <?php if($type == "admin"){?>
      function changeApproverLine(){
         //변경되는 부분 삭제 후에 새로 다시 넣기
         var approval_line_seq = '';
         var approval_line_type = '';
         var delete_row_num = 0;
         <?php if($_GET['type2'] == "004"){?>
            for(i=0; i<$("input[name=approval_line_seq]").length; i++){
               var tr = $("input[name=approval_line_seq]").eq(i).parent().parent();
               if(delete_row_num ==''){
                  delete_row_num = i;
               }
               approval_line_seq += ','+$("input[name=approval_line_seq]").eq(i).val();
               approval_line_type += ','+$("input[name=approval_line_type]").eq(i).val();
            }
         <?php }else{ ?>
            for(i=0; i<$("input[name=approval_line_seq]").length; i++){
               var tr = $("input[name=approval_line_seq]").eq(i).parent().parent();
               if(tr.attr("class").indexOf("sortable_disabled") == -1){
                  if(delete_row_num ==''){
                     delete_row_num = i;
                  }
                  approval_line_seq += ','+$("input[name=approval_line_seq]").eq(i).val();
                  approval_line_type += ','+$("input[name=approval_line_type]").eq(i).val();
               }
            }
         <?php } ?>

         if(approval_line_seq != ""){
               approval_line_seq = approval_line_seq.replace(',','');
         }

         if(approval_line_type != ""){
            approval_line_type = approval_line_type.replace(',','');
         }

         $.ajax({
            type: "POST",
            cache: false,
            url: "<?php echo site_url(); ?>/biz/approval/changeApproverLine",
            dataType: "json",
            async: false,
            data: {
               seq : <?php echo $seq ?>,
               delete_row_num: delete_row_num,
               approval_line_seq:approval_line_seq,
               approval_line_type:approval_line_type
            },
            success: function (data) {
               if (data) {
                  alert("결재선 변경 되었습니다.");
                  location.reload();
               } else {
                  alert("결재선 변경에 실패하였습니다.");
               }
            }
         })
      }
   <?php } ?>

   //보안설정
   function security_setting(){
      var security_status = "<?php echo $view_val['approval_doc_security']?>";
      if(security_status == "N"){
         if(confirm("보안설정 하시겠습니까?")){
            $.ajax({
               type: "POST",
               cache: false,
               url: "<?php echo site_url(); ?>/biz/approval/security_setting",
               dataType: "json",
               async: false,
               data: {
                  seq: <?php echo $seq; ?> ,
                  approval_doc_security: "Y"
               },
               success: function (data) {
                  if (data) {
                     alert("보안설정 완료");
                     location.reload();
                  } else {
                     alert("보안설정에 실패하였습니다.");
                  }
               }
            })
         }
      }else{
         if(confirm("보안설정을 해제 하시겠습니까?")){
            $.ajax({
               type: "POST",
               cache: false,
               url: "<?php echo site_url(); ?>/biz/approval/security_setting",
               dataType: "json",
               async: false,
               data: {
                  seq: <?php echo $seq; ?> ,
                  approval_doc_security: "N"
               },
               success: function (data) {
                  if (data) {
                     alert("보안해제 완료");
                     location.reload();
                  } else {
                     alert("보안해제에 실패하였습니다.");
                  }
               }
            })
         }
      }
   }

   //기안문 삭제
   function delete_doc(){
      if(confirm("결재 문서를 삭제하시겠습니까?")){
         $.ajax({
            type: "POST",
            cache: false,
            url: "<?php echo site_url(); ?>/biz/approval/electronic_approval_doc_delete",
            dataType: "json",
            async: false,
            data: {
               seq: <?php echo $seq; ?>
            },
            success: function (data) {
               if("<?php echo $type; ?>" == "temporary"){
                  if (data) {
                     alert("임시저장문서 삭제 완료");
                     location.href='<?php echo site_url();?>/biz/approval/electronic_approval_doc_list?type=temporary'
                  } else {
                     alert("임시저장문서 삭제에 실패하였습니다.");
                  }
               }else if ("<?php echo $type; ?>" == "admin"){
                  if (data) {
                     alert("결재문서 삭제 완료");
                     location.href='<?php echo site_url();?>/biz/approval/electronic_approval_list?type=admin'
                  } else {
                     alert("결재문서 삭제에 실패하였습니다.");
                  }
               }
            }
         })
      }
   }

   //인쇄 && pdf
   function print(){
      window.open('<?php echo site_url();?>/biz/approval/electronic_approval_doc_print?seq=<?php echo $seq ;?>','_blank');
   }

   $('#details').summernote({ placeholder: 'Hello stand alone ui', tabsize: 2, height: 200 });

   //상세보기 뷰
   function details_view(seq){
      $.ajax({
            type: "POST",
            cache: false,
            url: "<?php echo site_url(); ?>/biz/approval/approval_line_select",
            dataType: "json",
            async: false,
            data: {
               seq:seq
            },
            success: function (data) {
               $("#details_contents").html(data['details']);
               $("#details_modal").show();
            }
         })
   }
   // //모달 외부 클릭시 모달 close
   // $(document).mouseup(function (e) {
   //    var container = $('.searchModal');
   //    if (container.has(e.target).length === 0) {
   //       container.css('display', 'none');
   //    }
   // });
   function approval_status_txt(val,type){
      if(val == "Y"){
         if(type == "결재"){
            $("#approval_opinion").text("승인합니다.");
         }else{
            $("#approval_opinion").text("합의합니다.");
         }
      }else{
         $("#approval_opinion").text("반려합니다.");
      }
   }

   $(window).ready(function() {
     $.ajax({
       type: "POST",
       cache: false,
       url: "<?php echo site_url(); ?>/biz/approval/read_doc",
       dataType: "json",
       async: false,
       data: {
         seq: '<?php echo $_GET['seq']; ?>',
         type: '<?php echo substr($_GET['type'],0,1); ?>'
       },
       success: function(data) {

       }
     })
   })

  function official_doc_view(seq) {
    window.open("<?php echo site_url(); ?>/biz/official_doc/official_doc_print?seq="+seq, "popup_window", "width = 5000, height = 5000, top = 100, left = 400, location = no,status=no,status=no,toolbar=no,scrollbars=no");
  }

  $(function() {
    $('#formLayoutDiv input[type=radio]:checked').each(function() {
      var img = "<img src='/misc/img/radiobox.svg' style='width:13px;margin-right:3px;'/>";
      $(this).after(img);
    })
  })

  function tech_doc_view(seq) {
    window.open("<?php echo site_url();?>/tech/tech_board/tech_doc_print_page?seq="+btoa(seq), "cform", 'scrollbars=yes,width=850,height=600');
  }

  <?php if($view_val['approval_form_seq'] == 71){ ?>
    $('#salary_contract').text($('#tr5_td2_select > option:selected').val() + ' 연봉계약서');
  <?php } ?>

  function salary_contract_view(seq) {
    window.open("<?php echo site_url();?>/biz/approval/salary_contract_print?seq="+seq, "cform", 'scrollbars=yes,width=850,height=600');
  }

  function employment_doc_view(seq) {
    window.open("<?php echo site_url();?>/biz/approval/employment_doc_print?seq="+seq, "cform", 'scrollbars=yes,width=850,height=600');
  }

  function sign_confirm() {
    var user_birthday = $.trim($('#sign_user_birthday').val());
    var sign_file = $.trim($('#sign_user_signfile').val());
    var user_password = $.trim($('#sign_user_password').val());
    var pw =CryptoJS.SHA1(user_password);

    if(user_birthday == '') {
      alert('생년월일이 설정되지 않았습니다.\r회원정보수정 페이지에서 생년월일을 설정해 주세요.');
      return false;
    }
    if(sign_file == '') {
      alert('서명이 등록되지 않았습니다.\r회원정보수정 페이지에서 서명을 등록해 주세요.');
      return false;
    }
    if(user_password == '') {
      alert('비밀번호를 입력해 주세요.');
      return false;
    }

    $.ajax({
      type:'POST',
      cache: false,
      url: "<?php echo site_url(); ?>/biz/approval/pwcheck",
      dataType: "json",
      async: false,
      success: function(data) {
        if(data.sign_password==CryptoJS.enc.Hex.stringify(pw)){
          $('#sign_confirm_yn').val('N');
          approval_save(1);
        }else{
          alert("비밀번호가 틀렸습니다");
          return false;
        }
      }
    })
  }
</script>
</body>
</html>

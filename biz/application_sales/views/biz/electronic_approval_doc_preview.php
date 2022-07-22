<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
$duty = $this->phpsession->get( 'duty', 'stc' );
$ap = "N"; //결재라인에 들어있니?
$final_approval="N";
if(empty($cur_approval_line) != true){
   $ap = "Y";
   $approval_completion = $cur_approval_line['approval_status'];

   if($approval_line[count($approval_line)-1]['seq'] == $cur_approval_line['seq']){
      $final_approval ="Y";
   }
}

$approval_cancel_status = 'N';
$mystep = '';
$my_approval_line_seq = '';
$my_appoval_status = '';
if(!empty($approval_line)){
   foreach($approval_line as $ap){
      if($ap['user_id'] == $id){
         $my_approval_line_seq = $ap['seq'];
         $my_appoval_status = $ap['approval_status'];
         $mystep = $ap['step'];
      }
   }
}

// if($mystep != ""){
//    if($approval_line[($mystep+1)]['approval_status'] == ""  && ($my_appoval_status == "Y" || $my_appoval_status == "N" ) ){
//       $approval_cancel_status="Y";
//    }
// }


?>
<style>
   p, div, span, a, a:hover, a:visited, a:active, label, input, h1,h2,h3,h4,h5,h6{font-family: "Noto Sans KR";}
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

   #formLayoutDiv input{
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
      border: none !important;
      background: transparent !important;
   }
   #formLayoutDiv select {
      pointer-events: none;
   }
   #formLayoutDiv input {
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
</style>
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">
<script>
   function chkForm(){
		var mform = document.cform;
      $("#contents_html").val($("#formLayoutDiv").html());
      $("#editor_contents").val($('#summernote').summernote('code'));
      $("#approver_line").val($("#select_approver").html());
      alert($("#approver_line").val());
      $("#approval_request").val();
		// var regex3 = /^[0-9]+$/;

		mform.submit();
		return false;
	}


  // $(function (){
  //   alert(<?php echo $view_val['approval_form_seq']; ?>);
  // });
</script>
<body>
<form name="cform" action="<?php echo site_url(); ?>/biz/approval/electronic_approval_doc_input_action" method="post" onSubmit="javascript:chkForm();return false;">
   <input type="hidden" id="seq" name="seq" value="<?php echo $seq; ?>">
   <input type="hidden" id="select_user_id" name="select_user_id" value="">
   <input type="hidden" id="approval_form_seq" name="approval_form_seq" value="<?php echo $view_val['approval_form_seq']; ?>">
   <input type="hidden" id="contents_html" name="contents_html" value="" />
   <input type="hidden" id="editor_contents" name="editor_contents" value='<?php echo $view_val['editor_contents']; ?>'>
   <input type="hidden" id="approver_line" name="approver_line" value="" />
   <input type="hidden" id="cur_approver_line_seq" name="cur_approver_line_seq" value="<?php if(empty($cur_approval_line) != true){echo $cur_approval_line['seq']; }?>" />
   <!-- <input type="hidden" id="approval_doc_seq" name="approval_doc_seq" value="<?php echo $view_val['seq']; ?>" /> -->
   <input type="hidden" id="next_approver_line_seq" name="next_approver_line_seq" value="<?php if(empty($next_approval_line) != true){echo $next_approval_line['seq']; } ?>" />
   <!-- <input type="hidden" id="approval_request" name="approval_request" value="" /> -->
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
                                          echo '<input type="button" class="basicBtn" style="margin-right:5px;" value="'.$cur_approval_line['approval_type'].'" onclick="approval_ok();" />';
                                          if($cur_approval_line['approval_type'] == "결재" && $view_val['approval_doc_hold'] == "N"){
                                             echo '<input type="button" class="basicBtn2" value="보류" onclick="hold(1)" />';
                                          }else if ($cur_approval_line['approval_type'] == "결재" && $view_val['approval_doc_hold'] == "Y"){
                                             echo '<input type="button" class="basicBtn2" value="보류해제" onclick="hold(0)" />';
                                          }
                                          echo '<input type="button" class="basicBtn2" value="결재선" />';
                                          echo '<input type="button" class="basicBtn2" value="참조자" />';
                                       }

                                       echo '<input type="button" class="basicBtn2" value="진행현황" onclick="progressStatus();" />';
                                       echo '<input type="button" class="basicBtn2" value="인쇄" />';
                                       echo '<input type="button" class="basicBtn2" value="목록" />';
                                    }else if($type == "progress"){
                                       if(empty($next_approval_line) != true){
                                          if($approval_cancel_status == "Y"){
                                             echo '<input type="button" class="basicBtn" style="margin-right:5px;" value="결재취소" onclick="approval_save(0)" />';
                                          }
                                       }
                                       if($id == $view_val['writer_id'] && $approval_line[0]['approval_status'] == "" && $view_val['approval_doc_hold'] != "Y" ){
                                          echo '<input type="button" class="basicBtn" style="margin-right:5px;" value="결재회수" onclick="approval_withdraw();" />';
                                       }
                                       echo '<input type="button" class="basicBtn2" value="진행현황" onclick="progressStatus();" />';
                                       echo '<input type="button" class="basicBtn2" value="인쇄" />';
                                       echo '<input type="button" class="basicBtn2" value="목록" />';

                                    }else if($type == "completion"){
                                       echo '<input type="button" class="basicBtn" style="margin-right:5px;" value="재기안" onclick="reApproval();" />';
                                       echo '<input type="button" class="basicBtn2" value="pdf변환" />';
                                       echo '<input type="button" class="basicBtn2" value="열람권한" />';
                                       echo '<input type="button" class="basicBtn2" value="개인보관" onclick="personal_storage();" />';
                                       echo '<input type="button" class="basicBtn2" value="진행현황" onclick="progressStatus();" />';
                                       echo '<input type="button" class="basicBtn2" value="인쇄" />';
                                       echo '<input type="button" class="basicBtn2" value="목록" />';
                                    }else if($type == "back"){
                                       echo '<input type="button" class="basicBtn" style="margin-right:5px;" value="재기안" onclick="reApproval();" />';
                                       echo '<input type="button" class="basicBtn2" value="진행현황" onclick="progressStatus();" />';
                                       echo '<input type="button" class="basicBtn2" value="인쇄" />';
                                       echo '<input type="button" class="basicBtn2" value="목록" />';
                                    }else if($type == "request"){
                                       if($_GET['type2'] == "004"){
                                          echo '<input type="button" class="basicBtn" style="margin-right:5px;" value="수정" onclick="modifyApproval();" />';
                                          echo '<input type="button" class="basicBtn2" value="삭제" />';
                                          echo '<input type="button" class="basicBtn2" value="인쇄" />';
                                          echo '<input type="button" class="basicBtn2" value="목록" />';
                                       }else if ($_GET['type2'] == "002"){
                                          echo '<input type="button" class="basicBtn" style="margin-right:5px;" value="재기안" onclick="reApproval();" />';
                                          echo '<input type="button" class="basicBtn2" value="pdf변환" />';
                                          echo '<input type="button" class="basicBtn2" value="열람권한" />';
                                          echo '<input type="button" class="basicBtn2" value="개인보관" onclick="personal_storage();" />';
                                          echo '<input type="button" class="basicBtn2" value="진행현황" onclick="progressStatus();" />';
                                          echo '<input type="button" class="basicBtn2" value="인쇄" />';
                                          echo '<input type="button" class="basicBtn2" value="목록" />';
                                       }else if ($_GET['type2'] == "003"){
                                          echo '<input type="button" class="basicBtn" style="margin-right:5px;" value="재기안" onclick="reApproval();" />';
                                          echo '<input type="button" class="basicBtn2" value="진행현황" onclick="progressStatus();" />';
                                          echo '<input type="button" class="basicBtn2" value="인쇄" />';
                                          echo '<input type="button" class="basicBtn2" value="목록" />';
                                       }else if($_GET['type2'] == "001"){
                                          if(!empty($next_approval_line)){
                                             if($approval_cancel_status == "Y"){
                                                echo '<input type="button" class="basicBtn" style="margin-right:5px;" value="결재취소" onclick="approval_save(0)" />';
                                             }
                                          }
                                          if($id == $view_val['writer_id'] && $approval_line[0]['approval_status'] == "" && $view_val['approval_doc_hold'] != "Y" ){
                                             echo '<input type="button" class="basicBtn" style="margin-right:5px;" value="결재회수" onclick="approval_withdraw();" />';
                                          }
                                          echo '<input type="button" class="basicBtn2" value="진행현황" onclick="progressStatus();" />';
                                          echo '<input type="button" class="basicBtn2" value="인쇄" />';
                                          echo '<input type="button" class="basicBtn2" value="목록" />';
                                       }
                                    }else if ($type == "temporary"){
                                       echo '<input type="button" class="basicBtn" style="margin-right:5px;" value="수정" onclick="modifyApproval();" />';
                                       echo '<input type="button" class="basicBtn" style="margin-right:5px;" value="복사" onclick="();" />';
                                       echo '<input type="button" class="basicBtn2" value="삭제" />';
                                       echo '<input type="button" class="basicBtn2" value="인쇄" />';
                                       echo '<input type="button" class="basicBtn2" value="목록" />';
                                    }
                                 ?>
                                 </div>
                                 <div style="text-align:center;font-size:30px;height:40px;">
                                 <!-- <input type="hidden" id="template_name" name="template_name" value="<?php echo $view_val['template_name']; ?>"> -->
                                    <?php echo $view_val['template_name']; ?>
                                 </div>
                                 <div style="margin-top:30px;">
                                    <table id="approver_line_table" class="basic_table" style="width:auto;text-align:center;margin-bottom:30px;">
                                       <tr>
                                          <td height=40 rowspan=2 class="basic_td" width="20px" bgcolor="f8f8f9" >결재</td>
                                          <td class="basic_td" width="80px" bgcolor="f8f8f9"><?php echo $view_val['user_duty']; ?></td>
                                          <?php
                                          if(empty($approval_line) != true){
                                             foreach($approval_line as $al){
                                                if($al['approval_type'] == "결재"){
                                                   if($al['delegation_seq'] == ""){
                                                      echo "<td class='basic_td' width='80px' bgcolor='f8f8f9'>{$al['user_duty']}</td>";
                                                   }else{
                                                      $mendatary_duty = explode(' ', $al['mandatary']);
                                                      $mendatary_duty = $mendatary_duty[1];
                                                      echo "<td class='basic_td' width='80px' bgcolor='f8f8f9'>{$mendatary_duty}</td>";
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
                                                if($al['approval_type'] == "결재"){
                                                   if($al['delegation_seq'] == ""){
                                                      echo "<td class='basic_td' width='80px'>{$al['user_name']}<br>";
                                                   }else{
                                                      $mendatary_name = explode(' ', $al['mandatary']);
                                                      $mendatary_name=$mendatary_name[0];
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
                                                   echo "<td class='basic_td' width='80px'>{$al['user_duty']}</td>" ;
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
                                                   echo "<td height=40 class='basic_td' width='80px'>{$al['user_name']}<br>";
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
                                          <td width="35%" class="basic_td"><?php echo $view_val['writer_group']; ?>-<?php echo $view_val['doc_num']; ?></td>
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
                                    <?php echo $view_val['editor_contents']; ?>
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
                                             if(trim($al['details']) != ""){
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
                                 <input type="button" value="조직원 전체 선택" style="float:right;margin-bottom:5px;" onclick="select_user_add('all');" >
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
                              <div>
                                 <img src="<?php echo $misc;?>img/btn_cancel.jpg" style="cursor:pointer;float:right;margin-left:5px;margin-top:5px;" border="0" onClick="closeModal();"/>
                                 <img src="<?php echo $misc;?>img/btn_ok.jpg" style="cursor:pointer;float:right;margin-top:5px;" border="0" onClick="saveUserModal();"/><br>
                              </div>
                        </div>
                     </div>
                     <div id="select_approval_modal" class="searchModal">
                        <div class="search-modal-content" style='height:auto; min-height:400px;overflow: auto;'>
                           <h2>결재선지정</h2>
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
                                       <td class ="basic_td" width="30%" align="center">
                                          <table id="select_approver" width="90%" class="basic_table sortable">
                                             <?php echo $view_val['approver_line']; ?>
                                             <!-- <tr bgcolor="f8f8f9">
                                                <td height="30"></td>
                                                <td height="30">결재</td>
                                                <td height="30"><?php echo $name." ".$duty." ".$group; ?></td>
                                             </tr> -->
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
                     </div>
                     <!-- 결재모달 -->
                     <div id="approval_modal" class="searchModal">
                        <div class="search-modal-content" style='height:auto; min-height:400px;overflow: auto;'>
                           <h2>결재처리</h2>
                              <div style="margin-top:30px;height:auto; min-height:300px;overflow:auto;">
                                 <table class="basic_table" style="width:100%;">
                                    <tr>
                                       <td bgcolor="f8f8f9" height="40" align="right" class="basic_td">결재처리</td>
                                       <td class="basic_td">
                                          <input type="radio" name="approval_status" value="Y" checked /><?php echo $cur_approval_line['approval_type']; ?>
                                          <input type="radio" name="approval_status" value="N" />반려
                                       </td>
                                    </tr>
                                    <tr>
                                       <td bgcolor="f8f8f9" align="right" class="basic_td">결재의견</td>
                                       <td class="basic_td">
                                          <textarea id="approval_opinion" name="approval_opinion" style="width:100%;height:200px;"></textarea>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td bgcolor="f8f8f9" align="right" class="basic_td">상세</td>
                                       <td class="basic_td">
                                          <div id="details">
                                          </div>
                                       </td>
                                    </tr>
                                 </table>
                              </div>
                              <div>
                                 <img src="<?php echo $misc;?>img/btn_cancel.jpg" style="cursor:pointer;float:right;margin-left:5px;margin-top:5px;" border="0" onClick="closeModal();"/>
                                 <input type="button" value="결재" class="basicBtn" style="cursor:pointer;float:right;margin-left:5px;margin-top:5px;width:64px;height:31px;" onclick="approval_save(1);" >
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
                                       <td width =height=50 class="basic_td">순번</td>
                                       <td class="basic_td">결재자</td>
                                       <td class="basic_td">결재유형</td>
                                       <td class="basic_td">결재</td>
                                       <td class="basic_td">배정일시</td>
                                       <td class="basic_td">확인일시</td>
                                       <td class="basic_td">결재일시</td>
                                       <td class="basic_td">의견</td>
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
                                       echo "<td class='basic_td'>{$al['details']}</td>";
                                       echo "</tr>";
                                       $idx++;
                                    }?>
                                 </table>
                              </div>
                              <div>
                                 <img src="<?php echo $misc;?>img/btn_cancel.jpg" style="cursor:pointer;float:right;margin-left:5px;margin-top:5px;" border="0" onClick="closeModal();"/>
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
                                 <input type="button" value="저장" class="basicBtn" style="cursor:pointer;float:right;margin-left:5px;margin-top:5px;width:64px;height:31px;" onclick="hold('save');" >
                              </div>
                        </div>
                     </div>
                     <!-- 상세보기모달 -->
                     <div id="details_modal" class="searchModal">
                        <div class="search-modal-content" style='height:auto; min-height:400px;overflow: auto;'>
                           <h2>상세보기</h2>
                              <div id="details_contents" class= "summernote_view" style="margin-top:30px;height:auto; min-height:300px;overflow:auto;">
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
                                 <!-- <input type="button" value="저장" class="basicBtn" style="cursor:pointer;float:right;margin-left:5px;margin-top:5px;width:64px;height:31px;" onclick="hold('save');" > -->
                              </div>
                        </div>
                     </div>
                     <!--내용-->
                  </td>
               </tr>

               <!--댓글-->
               <?php if($mode != "pdf" ){ ?>
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
                                                <!-- <img src="<?php echo $misc; ?>img/pencil_btn.png" width="17" height="16" style="cursor:pointer" border="0" onclick="$('#answer<?php echo $item['seq'] ;?>').toggle();" /> -->
                                                <!-- <img src="<?php echo $misc; ?>img/btn_del.jpg" width="18" height="17" style="cursor:pointer;margin-left:10px;" border="0" onclick="javascript:commentSave(2,<?php echo $item['seq']; ?>);return false;"  /> -->
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
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.js"></script>
<script>
   //여기 뷰여서 수정안돼고 버튼 없애는 거
   $("#formLayoutDiv").find($("input")).prop('disabled', true);
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
   $('#details').summernote({ placeholder: 'Hello stand alone ui', tabsize: 2, height: 200 });


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

   function attach_view(seq){
      window.open('<?php echo site_url();?>/biz/approval/electronic_approval_doc_preview?seq='+seq,'_blank',"width = 1200, height = 1000, top = 100, left = 400, location = no,status=no,status=no,toolbar=no,scrollbars=no");

   }
</script>
</body>
</html>

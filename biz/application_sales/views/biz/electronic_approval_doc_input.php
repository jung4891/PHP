<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
  $duty = $this->phpsession->get( 'duty', 'stc' );
  $tech_approval = [17, 21, 56, 74];
?>
<style>
   p, div, span, a, a:hover, a:visited, a:active, label, input, h1,h2,h3,h4,h5,h6{
      font-family: "Noto Sans KR";
      /* font-size:13px !important; */
   }
   #formLayoutDiv{
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

   .select2-search__field {
     font-family:"Noto Sans KR", sans-serif !important;
     border: 1px solid #DEDEDE !important;
     outline: none !important;
     width:80px!important;
   }
</style>
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">
<link rel="stylesheet" href="/misc/css/bootstrap-datepicker.css">
<link rel="stylesheet" href="/misc/css/bootstrap-timepicker.css">
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css" rel="stylesheet" />
<script type="text/javascript" src="/misc/js/bootstrap-timepicker.js"></script>
<script type="text/javascript" src="/misc/js/bootstrap-datepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/js/select2.min.js"></script>
<body>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php"; ?>
<form id="cform" name="cform" action="<?php echo site_url(); ?>/biz/approval/electronic_approval_doc_input_action" method="post" enctype="multipart/form-data" onSubmit="javascript:chkForm('request');return false;">
   <input type="hidden" id="select_user_id" name="select_user_id" value="">
   <input type="hidden" id="approval_form_seq" name="approval_form_seq" value="<?php echo $_GET['seq']; ?>">
   <input type="hidden" id="contents_html" name="contents_html" />
   <input type="hidden" id="editor_contents" name="editor_contents" />
   <input type="hidden" id="approval_request" name="approval_request" />
   <input type="hidden" id="approval_doc_status" name="approval_doc_status" />
   <input type="hidden" id="click_user_seq" name="click_user_seq" />
   <input type="hidden" id="type" name="type" value="1" />
   <input type="hidden" id="sales_seq" name="sales_seq" value="<?php if(isset($_GET['sales_seq'])){echo "forcasting_seq=".$_GET['sales_seq'];}else if(isset($_GET['maintain_seq'])){echo "maintain_seq=".$_GET['maintain_seq'];} ?>" />
   <input type="hidden" id="req_support_seq" name="req_support_seq" value="<?php if(isset($_GET['req_support_seq'])){echo $_GET['req_support_seq'];} ?>" />
   <input type="hidden" id="req_support_data" name="req_support_data" value="" />
   <input type="hidden" id="req_file_real_name" name="req_file_real_name" value="" />
   <input type="hidden" id="req_file_change_name" name="req_file_change_name" value="" />
   <?php if(isset($_GET['schedule_seq'])) { ?>
   <input type="hidden" id="schedule_seq" name="schedule_seq" value="<?php echo $_GET['schedule_seq']; ?>" /> <?php } ?>
   <?php if(isset($_GET['tech_seq'])) { ?>
   <input type="hidden" id="tech_seq" name="tech_seq" value="<?php echo $_GET['tech_seq']; ?>" />
   <?php } ?>
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
                           <td class="title3">기안문 작성</td>
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
                                    <input type="button" class="btn-common btn-color2" value="결재선" onclick="select_approval_modal();" />
                                    <input type="button" class="btn-common btn-color2" value="결재요청" onclick="chkForm('request');" />
                              <?php if(in_array($seq, $tech_approval) || (isset($_GET['tech_seq']) && $_GET['tech_seq'] != '')) { ?>
                                    <input type="button" class="btn-common btn-color1" style="width:auto;" value="기술지원보고서첨부" onclick="techDocAttachment();">
                              <?php } ?>
                                    <input type="button" class="btn-common btn-color1" value="기결재첨부" onclick="approvalAttachment();">
                              <?php if(isset($view_val) && $view_val['official_doc'] == "Y") { ?>
                                    <input type="button" class="btn-common btn-color1" value="발송공문" onclick="officialDocAttachment();">
                              <?php } ?>
                                    <input type="button" class="btn-common btn-color1" value="임시저장" onclick="chkForm('temporary');" />
                              <?php if($seq == 6 && $corporation_card_num['corporation_card_yn'] == "Y") { ?>
                                    <input type="button" class="btn-common btn-color1" value="카드내역서업로드" style="width:auto;" onclick="excelUpload();" />
                                    <input style="display:none;" type="file" id="excelFile" onchange="excelImport(event)" />
                              <?php } ?>
                                    <input type="button" class="btn-common btn-color4" value="취소" onclick="cancel();">
                                 </div>
                                 <div style="text-align:center;font-size:30px;height:40px;">
                                    <?php if($seq == "annual"){
                                       echo "연차신청서";
                                    }else if ($seq == "attendance"){
                                       echo "근태조정계";
                                    }else{
                                       echo $view_val['template_name'];
                                    }?>
                                 </div>
                                 <div>
                                    <table id="approver_line_table" class="basic_table" style="width:auto;text-align:center;margin-bottom:30px;">
                                       <tr><td height=40 rowspan=2 class="basic_td" width="20px" bgcolor="f8f8f9" >결재</td><td class="basic_td" width="100px" bgcolor="f8f8f9"><?php echo $duty; ?></td></tr>
                                       <tr><td height=40 class="basic_td" width="80px"><?php echo $name; ?></td></tr>
                                    </table>
                                 </div>
                                 <div>
                                    <table id="agreement_line_table" class="basic_table" style="width:auto;text-align:center;margin-bottom:30px;">
                                       <tr></tr>
                                       <tr></tr>
                                    </table>
                                 </div>
                                 <div>
                                    <table class="basic_table" style="width:100%;">
                                       <tr>
                                          <td width="15%" align="center" height=40 class="basic_td" bgcolor="f8f8f9">문서번호</td>
                                          <td width="35%" class="basic_td">자동채번</td>
                                          <td width="15%" align="center" class="basic_td" bgcolor="f8f8f9">기안일자</td>
                                          <td width="35%" class="basic_td"><?php echo date("Y-m-d"); ?></td>
                                       </tr>
                                       <tr>
                                          <td width="15%" align="center" height=40 class="basic_td" bgcolor="f8f8f9">기안자</td>
                                          <td width="35%" class="basic_td"><input type="hidden" name="writer_name" id="writer_name" value="<?php echo $name; ?>" /><?php echo $name; ?></td>
                                          <td width="15%" align="center" class="basic_td" bgcolor="f8f8f9">기안부서</td>
                                          <td width="35%" class="basic_td"><input type="hidden" name="writer_group" id="writer_group" value="<?php echo $group; ?>" /><?php echo $group; ?></td>
                                       </tr>
                                       <tr>
                                          <td width="15%" align="center" height=40 class="basic_td" bgcolor="f8f8f9">참조자</td>
                                          <td width="35%" class="basic_td">
                                                <input id="referrer" name="referrer" type="hidden" class="input2" value="<?php if($seq != "annual" && $seq != "attendance" ){ echo $view_val['default_referrer'];} ?>" />
                                                <select id="referrer_select" class="user_select" name="referrer_select" onchange="referrerSelect('referrer',this);" multiple=multiple style="width:90%;">
                                                  <option value=""></option>
                                                    <?php if($seq != "annual" && $seq != "attendance" ){ echo "<option value='".$view_val['default_referrer']."'></option>"; } ?>
                                                    <?php foreach ($user_info as $ui) {
                                                      echo "<option value='{$ui['user_name']} {$ui['user_duty']}'>{$ui['user_name']} {$ui['user_duty']}</option>";
                                                    } ?>
                                                </select>
                                                <img src="<?php echo $misc;?>img/btn_add.jpg" style="cursor:pointer;vertical-align:middle;" border="0" onClick="select_user('referrer');"/>
                                          </td>
                                          <td width="15%" align="center" class="basic_td" bgcolor="f8f8f9">기결재첨부</td>
                                          <td width="35%" class="basic_td">
                                             <input id="approval_attach" name="approval_attach" type="hidden" value="" />
                                             <div id="approval_attach_list" name="approval_attach_list"> </div>
                                          </td>
                                       </tr>
                                       <input id="approval_tech_doc_attach" name="approval_tech_doc_attach" type="hidden" value="<?php if(isset($_GET['tech_seq']) && $_GET['tech_seq'] != ''){echo $tech_data_val['seq'].'::'.$tech_data_val['subject'];} ?>"/>
                               <?php if((isset($_GET['tech_seq']) && $_GET['tech_seq'] != '') || in_array($seq, $tech_approval)) { ?>
                                        <tr>
                                          <td width="15%" align="center" height=40 class="basic_td" bgcolor="f8f8f9">기술지원보고서첨부</td>
                                          <td colspan=3 class="basic_td">
                                            <div id="approval_tech_doc_attach_list" name="approval_tech_doc_attach_list">
                                      <?php if(isset($_GET['tech_seq']) && $_GET['tech_seq'] != '') { ?>
                                              <div id='attach_tech_doc_<?php echo $tech_data_val['seq']; ?>'>
                                                <span name='attach_name'><?php echo $tech_data_val['subject']; ?></span>
                                                <img src='/misc/img/btn_search.jpg' style='width:18px;vertical-align:middle;cursor:pointer;margin:5px 0px 5px 10px;' onclick='tech_doc_view("<?php echo $tech_data_val['seq']; ?>")'/>
                                                <img src='<?php echo $misc; ?>/img/btn_del2.jpg' style='vertical-align:middle;cursor:pointer;margin-left:5px;' onclick='attachTechDocRemove(<?php echo $tech_data_val['seq']; ?>)'/>
                                              </div>
                                      <?php } ?>
                                            </div>
                                          </td>
                                        </tr>
                               <?php } ?>

                                       <tr>
                                          <td width="15%" align="center" height=40 class="basic_td" bgcolor="f8f8f9">문서제목</td>
                                          <td colspan=3 class="basic_td"><input type="text" id="approval_doc_name" name="approval_doc_name" class="input7" value="<?php
                                          if(isset($sales_val)){
                                            echo "[";
                                            if($sales_val['cooperation_companyname']=='더망고'){
                                              echo 'MG';
                                            } else if ($sales_val['cooperation_companyname']=='두리안정보통신기술') {
                                              echo 'ICT';
                                            } else {
                                              echo 'IT';
                                            }
                                            echo "-".$group."]".$sales_val['customer_companyname'].' '.$sales_val['project_name']; }
                                          ?>"></td>
                                       </tr>
                                       <input type="hidden" name="official_doc_attach" id="official_doc_attach" value="<?php if(isset($official_doc_seq)){echo ','.$official_doc_seq;} ?>">
                                       <?php if(isset($view_val) && $view_val['official_doc'] == "Y") { ?>
                                         <tr>
                                           <td width="15%" align="center" height=40 class="basic_td" bgcolor="f8f8f9">발송공문</td>
                                           <td colspan=3 class="basic_td">
                                             <div id="official_doc_attach_list" name="official_doc_attach_list">
                                               <?php if(isset($official_doc) && count($official_doc) > 0){
                                                 foreach($official_doc as $od) {?>
                                                   <div id="<?php echo "officialDoc_".$od['seq']; ?>">
                                                     <span name="attach_name"><?php echo $od['subject']; ?></span>
                                                     <img src='<?php echo $misc; ?>/img/btn_del2.jpg' style='vertical-align:middle;cursor:pointer;margin-left:5px;' onclick='officialDocRemove("<?php echo $od['seq']; ?>")'/>
                                                   </div>
                                                 <?php }} ?>
                                               </div>
                                             </td>
                                           </tr>
                                         <?php } ?>
                                    </table>
                                 </div>
                                 <div id="formLayoutDiv" style="margin-top:30px;">
                                    <?php
                                       if($seq != "annual" && $seq != "attendance"){
                                          echo $view_val['preview_html'];
                                       }else if($seq == "annual"){?>
                                          <table class="basic_table" width="100%" style="">
                                             <tr>
                                                <td align="center" bgcolor="f8f8f9" height=40 class="basic_td">연차발생일수</td>
                                                <td height=40 class="basic_td"><?php echo ($annual['month_annual_cnt']+$annual['annual_cnt']+$annual['adjust_annual_cnt']);?></td>
                                                <td align="center" bgcolor="f8f8f9" height=40 class="basic_td">휴가사용일수(누적)</td>
                                                <td height=40 class="basic_td"><?php echo $annual['use_annual_cnt'];?></td>
                                                <td align="center" bgcolor="f8f8f9" height=40 class="basic_td">휴가잔여일수</td>
                                                <td height=40 class="basic_td"><?php echo $annual['remainder_annual_cnt'];?></td>
                                             </tr>
                                             <tr>
                                                <td align="center" bgcolor="f8f8f9" height=40 class="basic_td"><span style='color:red'>*</span>휴가신청일</td>
                                                <td height=40 class="basic_td"><input type="date" id="annual_application_date" name="annual_application_date" class="input2" value="<?php echo date("Y-m-d") ; ?>" required /></td>
                                                <td align="center" bgcolor="f8f8f9" height=40 class="basic_td"><span style='color:red'>*</span>휴가구분</td>
                                                <td height=40 class="basic_td">
                                                   <select class="input2" id="annual_type" name="annual_type" required >
                                                      <option value="">선택</option>
                                                      <option value="001">보건휴가</option>
                                                      <option value="002">출산휴가</option>
                                                      <option value="003">연/월차 휴가</option>
                                                      <option value="004">특별유급 휴가</option>
                                                      <option value="005">공가</option>
                                                   </select>
                                                </td>
                                                <td align="center" bgcolor="f8f8f9" height=40 class="basic_td"><span style='color:red'>*</span>전일/반일</td>
                                                <td height=40 class="basic_td">
                                                   <select class="input2" id="annual_type2" name="annual_type2" onchange="annual_count();" required>
                                                      <option value="">선택</option>
                                                      <option value="001">전일</option>
                                                      <option value="002">오전반차</option>
                                                      <option value="003">오후반차</option>
                                                   </select>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td align="center" bgcolor="f8f8f9" height=40 class="basic_td"><span style='color:red'>*</span>휴가기간</td>
                                                <td colspan=3 height=40 class="basic_td"><input type="date" id="annual_start_date" name="annual_start_date" class="input2" value="<?php echo date("Y-m-d");?>" onchange="annual_end_date_change(this.value)" style="width:115px;" /> ~ <input type="date" id="annual_end_date" name="annual_end_date" class="input2" value="<?php echo date("Y-m-d");?>" onchange="annual_count();" style="width:115px;"/> &nbsp; (일수 : <input type='text' id="annual_cnt" name="annual_cnt" class="input5" value="1" style="width:115px;text-align:center;" readonly /> ) </td>
                                                <td align="center" bgcolor="f8f8f9" height=40 class="basic_td">휴가사유</td>
                                                <td height=40 class="basic_td"><input type="text" id="annual_reason" name="annual_reason" class="input2" /></td>
                                             </tr>
                                          </table>
                                          <div style='margin:30px 0px 10px 0px;'>
                                             * 직무대행자
                                          </div>
                                          <table class="basic_table" width="100%" style="table-layout:fixed;">
                                            <colgroup>
                                              <col width="12%">
                                              <col width="21%">
                                              <col width="12%">
                                              <col width="21%">
                                              <col width="12%">
                                              <col width="21%">
                                            </colgroup>
                                             <tr>
                                                <td align="center" bgcolor="f8f8f9" height=40 class="basic_td"><span style='color:red'>*</span>성명/소속</td>
                                                <td height=40 class="basic_td">
                                                   <input type="hidden" id="functional_agent" name="functional_agent" class="input2" required readonly />
                                                   <select id="functional_agent_select" class="user_select" name="referrer_select" onchange="referrerSelect('functional_agent',this);" multiple=multiple style="width:80%;">
                                                      <option value=""></option>
                                                      <?php if($seq != "annual" && $seq != "attendance" ){ echo "<option value='".$view_val['default_referrer']."'></option>"; } ?>
                                                      <?php foreach ($user_info as $ui) {
                                                         echo "<option value='{$ui['user_name']} {$ui['user_duty']}'>{$ui['user_name']} {$ui['user_duty']}</option>";
                                                      } ?>
                                                   </select>
                                                   <img src="<?php echo $misc; ?>img/btn_add.jpg" style="vertical-align:middle;margin-left:10px;" onclick="select_user('functional_agent')">
                                                </td>
                                                <td align="center" bgcolor="f8f8f9" height=40 class="basic_td"><span style='color:red'>*</span>긴급연락처</td>
                                                <td height=40 class="basic_td">
                                                   <input type="text" id="emergency_phone_num" name="emergency_phone_num" class="input2" onchange="regex(this,'phone_num');" required />
                                                </td>
                                                <td align="center" bgcolor="f8f8f9" height=40 class="basic_td"><span style='color:red'>*</span>자동위임</td>
                                                <td height=40 class="basic_td">
                                                  사용<input type="radio" name="auto_deligation" value="Y" style="margin-right:10px;" checked>
                                                  미사용<input type="radio" name="auto_deligation" value="N">
                                                </td>
                                             </tr>
                                          </table>
                                    <?php }else if ($seq == "attendance"){ ?>
                                        <table class="basic_table" width="100%" style="">
                                        <tr>
                                           <td align="center" bgcolor="f8f8f9" height=40 class="basic_td">신청날짜</td>
                                           <td height=40 class="basic_td">
                                              <input type ="hidden" id="attendance_seq" name="attendance_seq" value="<?php echo $_GET['attendance_seq']; ?>">
                                              <input type="text" class="input2" id="attendance_date" name="attendance_date" value="" readonly> </td>
                                        </tr>
                                        <tr>
                                           <td align="center" bgcolor="f8f8f9" height=40 class="basic_td">현재상태</td>
                                           <td height=40 class="basic_td"><input type="text" id="attendance_cur_status" name="attendance_cur_status" class="input2" value="" readonly /></td>
                                        </tr>
                                        <tr>
                                           <td align="center" bgcolor="f8f8f9" height=40 class="basic_td"><span style='color:red'>*</span>정정시간</td>
                                           <td colspan=3 height=40 class="basic_td">
                                              출근 시간 : <input type="text" id="ws_time" name="ws_time" class="input2" value="" style="width:115px;" autocomplete="off" required/>
                                              <br>
                                              퇴근 시간 : <input type="text" id="wc_time" name="wc_time" class="input2" value="" style="width:115px;" autocomplete="off" required/>
                                              <!-- <inpu/>t type="text" class="input2" name="wc_time" id="wc_time" value="" style="width:115px" autocomplete="off">                                           -->
                                           </td>
                                        </tr>
                                        <tr>
                                           <td align="center" bgcolor="f8f8f9" height=40 class="basic_td"><span style='color:red'>*</span>변경상태</td>
                                           <td height=40 class="basic_td">
                                             <select name="attendance_change_status" id="attendance_change_status" class="input2" required>
                                                <option value="정상출근">정상출근</option>
                                                <option value="출근전">출근전</option>
                                                <option value="미처리">미처리</option>
                                                <option value="연차">연차</option>
                                                <option value="오전반차">오전반차</option>
                                                <option value="오후반차">오후반차</option>
                                                <option value="지각">지각</option>
                                                <option value="휴직">휴직</option>
                                                <option value="결근">결근</option>
                                                <option value="조퇴">조퇴</option>
                                                <!-- <option value="병가">병가</option> -->
                                                <option value="출산휴가">출산휴가</option>
                                                <option value="특별유급휴가">특별유급휴가</option>
                                                <option value="공가">공가</option>
                                                <option value="외출">외출</option>
                                                <option value="건강검진">건강검진</option>
                                             </select>
                                           </td>
                                        </tr>
                                        <tr>
                                           <td align="center" bgcolor="f8f8f9" height=40 class="basic_td"><span style='color:red'>*</span>사유</td>
                                           <td height=40 class="basic_td" style="padding:10px 10px;">
                                             <textarea id="attendance_reason" name="attendance_reason" rows=5 style="width:100%;border: 1px solid #b4b4b4"></textarea>
                                           </td>
                                        </tr>
                                     </table>
                                    <?php } ?>
                                 </div>
                                 <?php if(isset($view_val)){ if($view_val['editor_use'] == 'Y'){ ?>
                                    <div id="summernote" style="margin-top:30px;">

                                    </div>

                                 <?php }} ?>
                                 <div style="margin-top:30px;">
                                    <img src="<?php echo $misc; ?>/img/file_upload.png" style="width:20px;float:left;vertical-align:middle;"><h3 style="float:left;margin:0px;">&nbsp;파일업로드</h3><br>
                                    <table class="basic_table" width="100%" bgcolor="f8f8f9" height="auto" border="1px" style="margin-top:20px;" >
                                          <tbody id="fileTableTbody">
                                             <tr>
                                                <td id="dropZone" height="200px">
                                                      이곳에 파일을 드래그 하세요.
                                                </td>
                                             </tr>
                                          </tbody>
                                    </table>
                                 </div>
                                 <div style="text-align:right;margin-top:30px;">
                                    <input type="button" class="btn-common btn-color2" value="결재선" onclick="select_approval_modal();">
                                    <input type="button" class="btn-common btn-color2" value="결재요청" onclick="chkForm('request');">
                              <?php if(in_array($seq, $tech_approval) || (isset($_GET['tech_seq']) && $_GET['tech_seq'] != '')) { ?>
                                    <input type="button" class="btn-common btn-color1" style="width:auto;" value="기술지원보고서첨부" onclick="techDocAttachment();">
                              <?php } ?>
                                    <input type="button" class="btn-common btn-color1" value="기결재첨부" onclick="approvalAttachment();">
                                    <input type="button" class="btn-common btn-color1" value="임시저장" onclick="chkForm('temporary');">
                                    <input type="button" class="btn-common btn-color4" value="취소" onclick="cancel();">
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
                                          <div class="groupTree">
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
                     <div id="group_tree_modal2" class="searchModal">
                        <div class="search-modal-content" style='height:auto; min-height:400px;overflow: auto;'>
                           <h2>그룹 선택</h2>
                              <div style="margin-top:30px;height:auto; min-height:300px;overflow:auto;">
                                 <!-- <input type="button" value="조직원 전체 선택" style="float:right;margin-bottom:5px;" onclick="select_user_add('all');" > -->
                                 <table class="basic_table" style="width:100%;height:300px;vertical-align:middle;">
                                    <tr>
                                       <td class ="basic_td" width="30%">
                                          <div class="groupTree">
                                             <ul>
                                                <li>
                                                <span style="cursor:pointer;" id="all" onclick="click_group(this,'(주)두리안정보기술')">
                                                   (주)두리안정보기술
                                                </span>
                                                <ul>
                                                <?php
                                                foreach ( $group_val as $parentGroup ) {
                                                   if($parentGroup['childGroupNum'] <= 1){
                                                   ?>
                                                      <li>
                                                         <ins>&nbsp;</ins>
                                                         <span style="cursor:pointer;" id="<?php echo $parentGroup['groupName'];?>" onclick="click_group(this,'<?php echo $parentGroup['groupName'];?>')">
                                                         <ins>&nbsp;</ins>
                                                         <?php echo $parentGroup['groupName'];?>
                                                         </span>
                                                      </li>
                                                   <?php
                                                   }else{
                                                   ?>
                                                      <li>
                                                         <img src="<?php echo $misc; ?>img/btn_add.jpg" id="<?php echo $parentGroup['groupName'];?>Btn" width="13" style="cursor:pointer;" onclick="viewMore(this)">
                                                         <span style="cursor:pointer;" id="<?php echo $parentGroup['groupName'];?>" onclick="click_group(this,'<?php echo $parentGroup['groupName'];?>')">
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
                                       <!-- <td class ="basic_td" width="30%" align="center">
                                          <div class="click_group_user"></div>
                                       </td> -->
                                       <td class ="basic_td" width="10%" align="center">
                                          <div id="user_select_delete">
                                             <img src="<?php echo $misc;?>img/btn_right.jpg" style="cursor:pointer;width:22px;height:22px;" border="0" onClick="select_group_add();"/><br><br>
                                             <img src="<?php echo $misc;?>img/btn_left.jpg" style="cursor:pointer;width:22px;height:22px;" border="0" onClick="select_group_del();"/><br><br>
                                             <img src="<?php echo $misc;?>img/btn_del.jpg" style="cursor:pointer;width:22px;height:22px;" border="0" onClick="select_group_del('all');"/>
                                          </div>
                                       </td>
                                       <td class ="basic_td" width="30%" align="center">
                                          <div id="select_group">
                                          </div>
                                       </td>
                                    </tr>
                                 </table>
                              </div>
                              <div>
                                 <img src="<?php echo $misc;?>img/btn_cancel.jpg" style="cursor:pointer;float:right;margin-left:5px;margin-top:5px;" border="0" onClick="closeModal();"/>
                                 <img src="<?php echo $misc;?>img/btn_ok.jpg" style="cursor:pointer;float:right;margin-top:5px;" border="0" onClick="saveGroupModal();"/><br>
                              </div>
                        </div>
                     </div>
                     <!-- 모달끝 -->
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
                                             <img src="<?php echo $misc;?>img/btn_del.jpg" style="cursor:pointer;width:22px;height:22px;" border="0" onClick="approver_del('all');"/>
                                          </div>
                                       </td>
                                       <td class ="basic_td" width="30%" align="center" style="position: relative;">
                                          <div style="background-color:#f8f8f9;margin-top:20px;text-align:left;position: absolute;top:5px;">
                                            &nbsp;&nbsp; 사용자 결재선
                                            <select id="select_user_approval_line" name="select_user_approval_line" class="input5" style="margin-left:15px;" onchange="click_user_approval_line();">
                                               <option value="">-- 선택 --</option>
                                               <?php
                                               if(!empty($user_approval_line)){
                                               foreach($user_approval_line as $ual){
                                                echo "<option value='{$ual['seq']}'>{$ual['approval_line_name']}</option>";
                                               }}?>
                                            </select>
                                            <img src="<?php echo $misc;?>img/btn_delete.jpg" style="cursor:pointer;vertical-align:middle;width:50px;margin-left:15px;" border="0" onClick="user_approval_line_delete();"/>
                                          </div>
                                          <table id="select_approver" width="90%" class="basic_table sortable">
                                             <tr class="ui-state-disabled" bgcolor="f8f8f9">
                                                <td height="30"></td>
                                                <td height="30">결재</td>
                                                <td height="30"><?php echo $name." ".$duty." ".$group; ?></td>
                                             </tr>
                                          </table>
                                          <div style="background-color:#f8f8f9;margin-top:20px;text-align:left;position: absolute;bottom:5px;">
                                            &nbsp;&nbsp; 사용자 결재선명 <input type="text" id="approval_line_name" name="approval_line_name"class="input5" style="margin-left:15px;">
                                            <img src="<?php echo $misc;?>img/btn_add2.jpg" style="cursor:pointer;vertical-align:middle;width:50px;margin-left:15px;" border="0" onClick="user_approval_line_save();"/>
                                          </div>
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

                     <!--내용-->
                  </td>
               </tr>
            </table>
         </td>
      </tr>
   </table>

</form>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.js"></script>
<script>
   $("tr[name*=multi_row]").closest("table").find("tr:eq(1) img").each(function(){
     if ($(this).attr('onclick')=="delRow(this)") {
       $(this).hide();
     }
   });
   //사용자선택 있으면 하자
   // if($(".user_select").length > 1){
      var option = '<option value=""></option>';
      <?php foreach ($user_info as $ui) {?>
      option += "<option value='<?php echo $ui['user_name'].' '.$ui['user_duty'];?>'><?php echo $ui['user_name'].' '.$ui['user_duty']; ?></option>";
      <?php } ?>

      $(".user_select").html(option);

      $(".user_select").select2({
         placeholder: '검색어 입력'
      });
   // }

   <?php if(isset($tech_data_val)) { ?> //기지보에서 작성 시
    <?php if($seq == 17) { ?>
            var target_e = 'tr1_td1';
    <?php } else if($seq == 21) { ?>
            var target_e = 'tr3_td2';
    <?php } else if($seq == 74) { ?>
            var target_e = 'tr1_td1';
    <?php } ?>
   $(document).ready(function(){
     $("#" + target_e).val('<?php echo $tech_data_val["engineer"]; ?>');
      //사용자선택 있으면 하자
      // if($(".user_select").length > 1){
         var option = '<option value=""></option>';
         <?php foreach ($user_info as $ui) {?>
         option += "<option value='<?php echo $ui['user_name'].' '.$ui['user_duty'];?>'><?php echo $ui['user_name'].' '.$ui['user_duty']; ?></option>";
         <?php } ?>

         for(var i=0; i < $(".user_select").length; i++){
            var id = $(".user_select").eq(i).attr("id").replace("_select","");
            if(id == target_e) {
              $(".user_select").eq(i).html(option);
              $(".user_select").eq(i).select2({
                placeholder: '검색어 입력'
              });

              var val = $("#"+id).val();
              console.log(val);
              if(val != ""){
                // $("#"+id+"_select").val(val);
                var txtarr = val.split(", ")
                for (var j = 0; j < txtarr.length; j++) {
                  var txt = txtarr[j].split(' ');
                  txt = txt[0];
                  console.log(txt);
                  // alert(txt);
                  $("#"+id+"_select > option[value^='"+txt+"']").attr("selected","selected");
                }
                $("#"+id+"_select").select2().val(txtarr);
                $(".select2-container--below").hide(); //이거 왜해야하는지 모르겠음
                $('.user_select').eq(i).siblings('.select2-container').each(function(i) {
                  console.log(i);
                  if(i>0) {
                    $(this).remove();
                  }
                })

              }
            }
          }
      // }
   })
   <?php } ?>

   //사용자 선택 select2 multi
   function referrerSelect(name,obj){
    var selected = $("#"+name+"_select").val();
    var val = "";
    for(i=0; i<selected.length; i++){
       if(i==0){
         val += selected[i];
       }else{
         val += ","+selected[i];
       }
    }
    $("input[name="+name+"]").val(val);
   }


   //근태조정계일때
   <?php if ($seq == "attendance"){?>
      $.ajax({
         type: "POST",
         cache: false,
         url: "<?php echo site_url(); ?>/admin/attendance_admin/attendance_individual",
         dataType: "json",
         async: false,
         data: {
           type: 0,
           seq:<?php echo $_GET['attendance_seq']; ?>
         },
         success: function (data) {
            $("#attendance_date").val(data.workdate.replace(/(\d{4})(\d{2})(\d{2})/g, '$1-$2-$3'));
            $("#attendance_cur_status").val(data.status)
            var wstime = data.wstime
            if(wstime != "" && wstime != null){
               wstime = wstime.substring(8);
               wstime = wstime.substring(0,4);
               wstime =wstime.replace(/(.{2})/,"$1:");
            }
            var wctime = data.wctime;
            if(wctime != "" && wctime != null){
               wctime = wctime.substring(8);
               wctime = wctime.substring(0,4);
               wctime =wctime.replace(/(.{2})/,"$1:");
            }

            $("#ws_time").val(wstime);
            $("#wc_time").val(wctime);

            $('#ws_time, #wc_time').timepicker({
               showMeridian: false,
               defaultTime: false,
            });
         }
      });
   <?php } ?>

   //템플릿에 기본 결재라인이 있을때
   <?php if(isset($view_val)){
            if($view_val['default_approval_line']!="" && $view_val['default_approval_line']!="N") {?>
            click_user_approval_line(<?php echo $view_val['default_approval_line']?>);
            saveApproverLineModal();
   <?php }} ?>


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
        html +=         fileName + " / " + fileSize + "MB "  + "<a href='#' onclick='deleteFile(" + fIndex + "); return false;' class='btn small bg_02'><img src='<?php echo $misc;?>/img/btn_del2.jpg' style='vertical-align:middle;'></a>";
        html += "    </td>";
        html += "</tr>";

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

   <?php if(isset($view_val)){?>
   if('<?php echo $view_val['editor_use']; ?>' =='Y'){
      $('#summernote').summernote({ placeholder: 'Hello stand alone ui', tabsize: 2, height: 200 });
   }
   <?php } ?>

   //사용자 선택
   function select_user(s_id){
      $(".click_group_user").html("");
      $("#click_user").attr('id','');
      $("#group_tree_modal").show();
      $("#select_user_id").val(s_id);
      if($("input[name="+$("#select_user_id").val()+"]").val() != ""){
         var select_user = ($("#"+$("#select_user_id").val()).val()).split(',');
         var txt = '';
         for(i=0; i<select_user.length; i++){
            txt += "<div class='select_user' onclick='click_user(-1,"+'"'+select_user[i]+'"'+",this)'>"+select_user[i]+"</div>";
         }
         $("#select_user").html(txt);
      }else{
         $("#select_user").html('');
      }
   }

   //그룹 선택
   function select_group(s_id){
      $("#click_group").remove();
      $("#group_tree_modal2").show();
      $("#select_user_id").val(s_id);
      if($("input[name="+$("#select_user_id").val()+"]").val() != ""){
         var select_user = ($("input[name="+$("#select_user_id").val()+"]").val()).split(',');
         var txt = '';
         for(i=0; i<select_user.length; i++){
            txt += "<div class='select_group' onclick='click_group(this,"+'"'+select_user[i]+'"'+")'>"+select_user[i]+"</div>";
         }
         $("#select_group").html(txt);
      }else{
         $("#select_group").html('');
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
         $("input[name="+$("#select_user_id").val()+"]").val(txt);
         $("#group_tree_modal").hide();
      }

      var select_id = $("#select_user_id").val()+'_select';
      var txtarr= txt.split(",")
      for (var i = 0; i < txtarr.length; i++) {
         $("#"+select_id+" > option[value='"+txtarr[i]+"']").attr("selected","selected");
      }

      $("#"+select_id).select2().val(txtarr);
   }

   //그룹 선택 저장
   function saveGroupModal(){
      var txt ='';
      for(i=0; i <$(".select_group").length; i++){
         var val = $(".select_group").eq(i).text();
         if(i == 0){
            txt += val;
         }else{
            txt += "," + val;
         }
         $("input[name="+$("#select_user_id").val()+"]").val(txt);
         $("#group_tree_modal2").hide();
      }
   }

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
      $(obj).css('background-color','#d7d7d7');
      $(obj).attr('id','click_user');
      $("#click_user_seq").val(seq);
   }

   //group 선택
   function click_group(obj,val){
      $(".groupTree").find("span").css('background-color','');
      $(".select_group").css('background-color','');
      $("#click_user").attr('id','');
      $(obj).css('background-color','#d3d3d3');
      $(obj).attr('id','click_user');
      $("#click_user_seq").val(val);
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
                     html += "<div class='select_user' onclick='click_user("+data[i].seq+',"'+data[i].user_name+'"'+",this)'>"+data[i].user_name+" "+data[i].user_duty+" "+data[i].user_group+"</div>";
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
            var html = "<div class='select_user' onclick='click_user(-1,"+'"'+$("#click_user").html()+'"'+",this)'>"+$("#click_user").html()+"</div>";
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

   //group 추가
   function select_group_add(){
      var html = "<div class='select_group' onclick='click_group(this)'>"+$("#click_user_seq").val()+"</div>";
      $("#select_group").html($("#select_group").html()+html);
   }

   //추가된 user 중에 삭제
   function select_group_del(type){
      if(type == "all"){
         $(".select_group").remove();
      }else{
         if($("#click_user").attr('class') == 'select_group'){
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

   function select_approval_modal(){
      $("#click_user").css('background-color','');
      $("#click_user").attr('id','');
      $("#select_approval_modal").show();
   }

   //결재선 추가
   function approver_add(){
      var duplicate_check = false;
      if($("#click_user_seq").val() == "<?php echo $_SESSION['stc']['seq']; ?>") { //기안자 중복방지
        duplicate_check = true;
      }

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
   function approver_del(type){
      if(type != undefined){
         $(".select_approver").remove();
      }else{
         if($("#click_user").attr('class') == 'select_approver'){
            $("#click_user").remove();
            finalReferrer();
         }
      }
   }

   //sortable tr 상하이동
   $(".sortable").sortable({
      items: "tr:not(.ui-state-disabled)",
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
   //결재선 저장
   function saveApproverLineModal(){
      var tr = $("#select_approver").find($("tr"));
      $("#approver_line_table").find($("tr")).eq(0).html('<td height=40 rowspan=2 class="basic_td" width="20px" bgcolor="f8f8f9" >결재</td>');
      $("#approver_line_table").find($("tr")).eq(1).html("");

      $("#agreement_line_table").find($("tr")).eq(0).html('<td height=40 rowspan=2 class="basic_td" width="20px" bgcolor="f8f8f9" >합의</td>');
      $("#agreement_line_table").find($("tr")).eq(1).html("");
      for(i=0; i<tr.length; i++){
         if(tr.eq(i).html().indexOf("결재") != -1){ //결재부분
            var text = tr.eq(i).find($("td")).eq(tr.eq(i).find($("td")).length -1).html();
            text = text.split(' ');
            var duty = text[1];
            var name = text[0];
            $("#approver_line_table").find($("tr")).eq(0).append('<td class="basic_td" width="80px" bgcolor="f8f8f9">'+duty+'</td>');
            $("#approver_line_table").find($("tr")).eq(1).append("<td height=40>"+name+"</td>");
         }else{
            var text = tr.eq(i).find($("td")).eq(tr.eq(i).find($("td")).length -1).html();
            text = text.split(' ');
            var duty = text[1];
            var name = text[0];
            $("#agreement_line_table").find($("tr")).eq(0).append('<td class="basic_td" width="80px" bgcolor="f8f8f9">'+duty+'</td>');
            $("#agreement_line_table").find($("tr")).eq(1).append("<td height=40>"+name+"</td>");
         }
      }
      var test = $("#select_approver").html();
      $("#select_approver").html(test);
      $("#select_approval_modal").hide();
   }

   function chkForm(t) {
      if(trim($("#approval_doc_name").val()) == ""){
         $("#approval_doc_name").focus();
         alert("문서제목을 입력해주세요.");
         return false;
      }
      var check = true;
      $("#formLayoutDiv").find("input, select, textarea").each(function(i) {
         var tt = jQuery(this);
         if(tt.prop("type") == "radio"){
            var name = tt.prop("name");
            if(tt.prop("required")) {
               if (!$('input[name='+name+']:checked').val()) {
                  check = false;
                  tt.focus();
                  alert('필수 옵션을 선택해주세요.');
                  return false;
               }
            }
         }else{
            if(tt.prop("required")) {
               if(!jQuery.trim(tt.val())) {
                  check = false;
                  tt.focus();
                  alert(" 필수 입력값을 채워주세요.");
                  return false;
               }
            }
         }
      });
      if(check == false){ // 필수 값 체크
         return false;
      }

      if("<?php echo $seq ?>" == "annual"){
         $.ajax({
            type: "POST",
            cache: false,
            url: "<?php echo site_url(); ?>/biz/approval/electronic_approal_annual_duplication_check",
            dataType: "json",
            async :false,
            data: {
               doc_seq :'' ,
               annual_start_date: $("#annual_start_date").val(),
               annual_end_date: $("#annual_end_date").val()
            },
            success: function (result) {
               if (result) {
                  alert("중복된 날짜의 연차신청서가 존재합니다.")
                  check = false;
                  return false;
               }
            }
         });

         var functional_agent = $('#functional_agent_select').val();
         if(functional_agent.length > 1) {
           alert('직무대행자는 한명만 입력해주세요.');
           return false;
         }
      }

      if(check == false){ // 필수 값 체크
         return false;
      }

      if (confirm("등록 하시겠습니까?")) {
         var mform = document.cform;
         $("#formLayoutDiv").find($("input")).each(function(){ this.defaultValue = this.value;});
         $("#formLayoutDiv").find($("[type=text],textarea")).each(function(){ this.defaultValue = this.value;});
         $("#formLayoutDiv").find($("select option")).each(function(){ this.defaultSelected = this.selected;});
         $("#formLayoutDiv").find($("[type=checkbox],[type=radio]")).each(function(){ this.defaultChecked = this.checked;});
         $("#contents_html").val($("#formLayoutDiv").html());

         // 용역 하도급 품의서일 경우
         if ($("#req_support_seq").val()!="") {
           var schedule_date = $(".tr6_td9").eq(0).val();
           var m1 = $("#tr6_td5_sum").val();
           var m2 = $("#tr6_td6_sum").val();
           var m3 = $("#tr6_td7_sum").val();

           $("#req_support_data").val(m1 + "*/*" + m2 + "*/*" + m3 + "*/*" + schedule_date);
           // alert($("#req_support_data").val());
           // return false;
         }

         <?php if(isset($view_val)){?>
            if('<?php echo $view_val['editor_use']; ?>' =='Y'){
               $("#editor_contents").val($('#summernote').summernote('code'));
            }else{
               $("#editor_contents").val('');
            }
         <?php } ?>


         // $("#approver_line").val($("#select_approver").html());


         var approval_attach_val = '';
         if($("#approval_attach").val() != ''){
            var approval_attach = $("#approval_attach").val().replace(',','').split(',');
            for(i=0; i<approval_attach.length; i++){
               approval_attach_val += '*/*'+approval_attach[i]+'--'+$("span[name=attach_name]").eq(i).text();
            }
            approval_attach_val = approval_attach_val.replace('*/*','');
         }

         $("#approval_attach").val(approval_attach_val);
<?php if(isset($view_val) && $view_val['official_doc'] == "Y") { ?>
         var official_doc_attach_val = '';
         if($("#official_doc_attach").val() != ''){
            var official_doc_attach = $("#official_doc_attach").val().replace(',','').split(',');
            for(i=0; i<official_doc_attach.length; i++){
               official_doc_attach_val += '*/*'+official_doc_attach[i]+'--'+$("span[name=attach_name]").eq(i).text();
            }
            official_doc_attach_val = official_doc_attach_val.replace('*/*','');
         }

         $("#official_doc_attach").val(official_doc_attach_val);
<?php } ?>
         if(t == "request"){
            $("#approval_doc_status").val("001");
         }else{
            $("#approval_doc_status").val("005");
         }

         var approval_line_seq = '';
         var approval_line_type = '';
         for(i=0; i<$("input[name = approval_line_seq]").length; i++){
            approval_line_seq += ','+$("input[name=approval_line_seq]").eq(i).val();
            approval_line_type += ','+$("input[name=approval_line_type]").eq(i).val();
         }

         if(approval_line_seq == ""){
            alert("결재선을 지정해주세요.");
            return false;
         }

         var formData = new FormData(document.getElementById("cform"));

         if(approval_line_seq != ""){
            approval_line_seq = approval_line_seq.replace(',','');
            formData.append('test1', approval_line_seq);
         }

         if(approval_line_type != ""){
            approval_line_type = approval_line_type.replace(',','');
            formData.append('test2', approval_line_type);
         }

         // 등록할 파일 리스트
         var uploadFileList = Object.keys(fileList);

         // 파일이 있는지 체크
         formData.append('file_length', uploadFileList.length);
         if(uploadFileList.length > 0){
             // 용량을 500MB를 넘을 경우 업로드 불가
            if (totalFileSize > maxUploadSize) {
               // 파일 사이즈 초과 경고창
               alert("총 용량 초과\n총 업로드 가능 용량 : " + maxUploadSize + " MB");
               return;
            }

            // 등록할 파일 리스트를 formData로 데이터 입력
            for (var i = 0; i < uploadFileList.length; i++) {
               formData.append('files' + i, fileList[uploadFileList[i]]);
            }

         }

// 연차신청서 자동위임
<?php if($seq == 'annual') { ?>
        formData.append('functional_agent', $('#functional_agent').val());
<?php } ?>

// 던킨, 지출결의서 지출내역 저장
<?php if($seq == 63 || $seq == 6) { ?>
  <?php if($seq == 63) { ?>
          var t = 'tr3';
  <?php } else { ?>
          var t = 'tr2';
  <?php } ?>

        var expense_list_length = $('.'+t+'_td1').length;
        formData.append('expense_list_length', expense_list_length);

        for (var i = 0; i < expense_list_length; i++) {
          formData.append('expense_t_date[]', $('.'+t+'_td1').eq(i).val());
          formData.append('expense_details[]', $('.'+t+'_td2').eq(i).val());
          formData.append('expense_company[]', $('.'+t+'_td3').eq(i).val());
          formData.append('expense_use_area[]', $('.'+t+'_td4').eq(i).val());
          formData.append('expense_history_user[]', $('.'+t+'_td5').eq(i).val());
          formData.append('expense_use_where[]', $('.'+t+'_td6').eq(i).val());
          formData.append('expense_corporation_card[]', $('.'+t+'_td7').eq(i).val().replace(/,/gi, ""));
          formData.append('expense_personal_card[]', $('.'+t+'_td8').eq(i).val().replace(/,/gi, ""));
          formData.append('expense_simple_receipt[]', $('.'+t+'_td9').eq(i).val().replace(/,/gi, ""));
        }
<?php } ?>
// 출장보고서 지출내역 저장
<?php if($seq == 17) { ?>
        var expense_list_length = $('.tr8_td1').length;
        formData.append('expense_list_length', expense_list_length);

        for (var i = 0; i < expense_list_length; i++) {
          formData.append('expense_t_date[]', $('.tr8_td1').eq(i).val());
          formData.append('expense_details[]', $('.tr8_td2').eq(i).val());
          formData.append('expense_company[]', $('.tr4_td1').val());
          formData.append('expense_history_user[]', $('.tr8_td5').eq(i).val());
          formData.append('expense_corporation_card[]', $('.tr8_td4').eq(i).val().replace(/,/gi, ""));
          formData.append('expense_personal_card[]', $('.tr8_td6').eq(i).val().replace(/,/gi, ""));
          formData.append('expense_simple_receipt[]', $('.tr8_td7').eq(i).val().replace(/,/gi, ""));
        }
<?php } ?>
// 출장보고서 지출내역 저장
<?php if($seq == 74) { ?>
        var expense_list_length = $('.tr9_td1').length;
        formData.append('expense_list_length', expense_list_length);

        for (var i = 0; i < expense_list_length; i++) {
          formData.append('expense_t_date[]', $('.tr9_td1').eq(i).val());
          formData.append('expense_details[]', $('.tr9_td2').eq(i).val());
          formData.append('expense_company[]', $('.tr3_td1').val());
          formData.append('expense_history_user[]', $('.tr9_td7').eq(i).val());
          formData.append('expense_corporation_card[]', $('.tr9_td4').eq(i).val().replace(/,/gi, ""));
          formData.append('expense_personal_card[]', $('.tr9_td5').eq(i).val().replace(/,/gi, ""));
          formData.append('expense_simple_receipt[]', $('.tr9_td6').eq(i).val().replace(/,/gi, ""));
        }
<?php } ?>

// 연봉꼐약서
<?php if($seq == 71) { ?>
        var contract_year = $('.tr5_td1').val();
        var contracting_party = $('#tr5_td2').val();
        var salary = $('.tr5_td3').val().replace(/,/gi, '');

        formData.append('contract_year', contract_year);
        formData.append('contracting_party', contracting_party);
        formData.append('salary', salary);
<?php } ?>

<?php if($seq == 75) { ?>
        var purpose_of_use = $('input[name=tr1_td1]:checked').val();
        var required_date = $('.tr2_td1').val();
        var a_company = $('input[name=tr1_td2]:checked').val();
        if(a_company == '두리안정보기술') {
          var doc_num1 = 'DIT';
        } else if (a_company == '두리안정보통신기술') {
          var doc_num1 = 'DICT';
        } else if (a_company == '더망고') {
          var doc_num1 = 'MG';
        } else if (a_company == '던킨(더망고)') {
          var doc_num1 = 'DD';
        }

        formData.append('purpose_of_use', purpose_of_use);
        formData.append('required_date', required_date);
        formData.append('doc_num1', doc_num1);
<?php } ?>

         $.ajax({
            url: "<?php echo site_url(); ?>/biz/approval/electronic_approval_doc_input_action",
            data: formData,
            type: 'POST',
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            dataType: 'json',
            cache: false,
            success: function (result) {
               if (result) {
                  alert("저장 성공");
                  if($("#approval_doc_status").val() == "001"){
                     location.href ="<?php echo site_url();?>/biz/approval/electronic_approval_doc_list?type=request";
                  }else{
                     location.href ="<?php echo site_url();?>/biz/approval/electronic_approval_doc_list?type=temporary";
                  }
               } else {
                  alert("저장에 실패하였습니다. 관리자에게 문의주세요.");
               }
            }
         });
      }
      return false;
   }

   function multi_calculation(expression,changeInput,eq){
      if(eq == 'all'){
         var class_name = expression.replace(/\[/gi,'').replace(/\]/gi,'');
         class_name = class_name.split(',');
         expression='';
         for(i=0; i<class_name.length; i++){
            if(isNaN(class_name[i]) == true && /[+-/)(*]/g.test(class_name[i]) == false){
               class_name[i] = $('.'+class_name[i]);
               var sum = 0;
               for(j=0; j<class_name[i].length; j++){
                  sum += Number(class_name[i].eq(j).val().replace(/,/gi, ""));
               }
               class_name[i] =  "("+sum+")";
            }
            expression += class_name[i];
         }
         var html_input = $("#html").find($("."+changeInput)).eq(0);
         html_input.val(eval(expression));
         html_input.trigger("change");
      }else{
         var class_name = $(eq).attr("class").replace("input7","");
         var index = $("."+class_name).index($(eq));
         expression=expression.split("eq(0)").join("eq("+index+")");
         var html_input = $("#html").find($("."+changeInput)).eq(index);
         html_input.val(eval(expression));
         html_input.trigger("change");
      }

   }

   function multi_sum(multi_id){
      var multi_input = multi_id + "_sum"
      var sum_value = 0;

      for(j=0; j < $("."+multi_id).length; j++){
         sum_value += Number($("."+multi_id).eq(j).val().replace(/,/gi, ""));
      }
      $("#"+multi_input).val(sum_value);
      $("#"+multi_input).change();
   }

   //반올림 올림 , 내림
   function round(obj,n,type){
      if(n != 0){
         if(type == "round"){//반올림
            var num = Number(obj.value);
            $(obj).val(num.toFixed(n));
         }else if(type == "down"){//내림
            var decimal_point = obj.value.indexOf('.');
            var num = (obj.value).substring(0,(decimal_point+n+1));
            $(obj).val(num);
         }else if(type == "up"){//올림
            var decimal_point = obj.value.indexOf('.');
            var num = (obj.value).substring(0,(decimal_point+n+1));
            var up_value = String(Number(num[(decimal_point+n)])+1);
            up_value = num.substr(0,(decimal_point+n)) + up_value + num.substr((decimal_point+n)+ up_value.length);
            $(obj).val(up_value);
         }
      }else{
         if(type == "round"){//반올림
            var num = Math.round(obj.value);
            $(obj).val(num);
         }else if(type == "down"){//내림
            var num = Math.floor(obj.value);
            $(obj).val(num);
         }else if(type == "up"){//올림
            var num = Math.ceil(obj.value);
            $(obj).val(num);
         }
      }
   }

   function addRow(obj){
      var tr_name = $(obj).parent().parent().attr('name');
      var tr_last = $('tr[name='+tr_name+']')[$('tr[name='+tr_name+']').length-1];
      var tr_last_html = tr_last.outerHTML;
      $(tr_last).after(tr_last_html);
      var new_tr = $('tr[name='+tr_name+']')[$('tr[name='+tr_name+']').length-1];
      $(new_tr).find("img").show();
      for(i=0; i<$(new_tr).find($("input")).length; i++){
         if($(new_tr).find($("input")).eq(i).val().indexOf("express") != -1){
            $(new_tr).find($("input")).eq(i).val(''); //표현식 들어있는 input 비워
         }
      }
   }
   function addRow2(tr_name){
      var tr_last = $('tr[name='+tr_name+']')[$('tr[name='+tr_name+']').length-1];
      var tr_last_html = tr_last.outerHTML;
      $(tr_last).after(tr_last_html);
      var new_tr = $('tr[name='+tr_name+']')[$('tr[name='+tr_name+']').length-1];
      $(new_tr).find("img").show();
      for(i=0; i<$(new_tr).find($("input")).length; i++){
         if($(new_tr).find($("input")).eq(i).val().indexOf("express") != -1){
            $(new_tr).find($("input")).eq(i).val(''); //표현식 들어있는 input 비워
         }
      }
   }
   function addRow3(obj){
      var tr = $(obj).parent().parent();
      var tr_name = $(obj).parent().parent().attr('name');
      var tr_last = $('tr[name='+tr_name+']')[$('tr[name='+tr_name+']').length-1];
      var tr_last_html = tr_last.outerHTML;
      $(tr).after(tr_last_html);
      var new_tr = $('tr[name='+tr_name+']')[$('tr[name='+tr_name+']').length-1];
      $(new_tr).find("img").show();
      for(i=0; i<$(new_tr).find($("input")).length; i++){
         if($(new_tr).find($("input")).eq(i).val().indexOf("express") != -1){
            $(new_tr).find($("input")).eq(i).val(''); //표현식 들어있는 input 비워
         }
      }
   }

   function delRow(obj){
      var tr = $(obj).closest('tr');
      var prev = tr.prev();
      tr.remove();
      for(var i =0; i< prev.find("input").length; i++){
         if(prev.find("input").eq(i).attr("onchange") != "" && prev.find("input").eq(i).attr("onchange") != undefined){
            prev.find("input").eq(i).trigger("change");
         }
      }
   }

   function approvalAttachment(){
      window.open('<?php echo site_url();?>/biz/approval/approval_attachment','_blank',"width = 1200, height = 500, top = 100, left = 400, location = no,status=no,status=no,toolbar=no,scrollbars=no");
   }

   function techDocAttachment(){
      window.open('<?php echo site_url();?>/biz/approval/tech_doc_attachment?type=Y','_blank',"width = 1200, height = 500, top = 100, left = 400, location = no,status=no,status=no,toolbar=no,scrollbars=no");
   }

   function officialDocAttachment(){
      window.open('<?php echo site_url();?>/biz/official_doc/official_doc_attachment','_blank',"width = 1200, height = 500, top = 100, left = 400, location = no,status=no,status=no,toolbar=no,scrollbars=no");
   }

   //기결재 첨부 삭제
   function attachRemove(seq){
     if($('tr[class=attach_'+seq+']').length > 0) {
       if(confirm("기결재와 연결된 " + $('tr[class=attach_'+seq+']').length + '건의 지출 내역도 삭제됩니다.\r삭제하시겠습니까?')) {
         if($('tr[name=multi_row2]').length - 1 <= $('tr[class=attach_'+seq+']').length) {
           var tr = $('.tr2_td1').last().closest('tr');
           tr.attr('class', '');
           for(j=0; j<$(tr).find($("input")).length; j++){
             $(tr).find($("input")).eq(j).val('');
           }
         }
         $('tr[class=attach_'+seq+']').remove();
         $('.tr2_td7, .tr2_td8, .tr2_td9').change()
       } else {
         return false;
       };
     }
      $("#attach_"+seq).remove();
      if($("#approval_attach").val().indexOf(','+seq) != -1){
         $("#approval_attach").val($("#approval_attach").val().replace(','+seq,''))
      }else{
         $("#approval_attach").val($("#approval_attach").val().replace(seq+',',''));
      }
   }

  function attachTechDocRemove(seq) {
    $('#attach_tech_doc_'+seq).remove();
    $('#approval_tech_doc_attach').val('');
  }
   //공문 첨부 삭제
   function officialDocRemove(seq){
      $("#officialDoc_"+seq).remove();
      if($("#official_doc_attach").val().indexOf(','+seq) != -1){
         $("#official_doc_attach").val($("#official_doc_attach").val().replace(','+seq,''))
      }else{
         $("#official_doc_attach").val($("#official_doc_attach").val().replace(seq+',',''));
      }
   }

   //사용자 결재선 저장
   function user_approval_line_save(){
      if($("#approval_line_name").val() == ""){
         $("#approval_line_name").focus();
         alert("결재선명을 입력하세요");
         return false;
      }else{
         var approval_line_seq = '';
         var approval_line_type = '';
         for(i=0; i<$("input[name = approval_line_seq]").length; i++){
            approval_line_seq += ','+$("input[name=approval_line_seq]").eq(i).val();
            approval_line_type += ','+$("input[name=approval_line_type]").eq(i).val();
         }

         if(approval_line_seq != ""){
            approval_line_seq = approval_line_seq.replace(',','');
         }

         if(approval_line_type != ""){
            approval_line_type = approval_line_type.replace(',','');
         }
         $.ajax({
            type: "POST",
            cache: false,
            url: "<?php echo site_url(); ?>/biz/approval/user_approval_line_save",
            dataType: "json",
            async :false,
            data: {
               type : 1,
               approval_line_name: $("#approval_line_name").val(),
               approver_seq: approval_line_seq,
               approval_type: approval_line_type,
               user_id : "<?php echo $id ;?>"
            },
            success: function (result) {
               if(result){
                  alert("결재선 저장되었습니다.");
                  $("#approval_line_name").val("");
               }else{
                  alert("결재선 저장에 실패하였습니다.");
               }
            }
         });
      }
   }

   //사용자 결재선 삭제
   function user_approval_line_delete(){
      var delete_seq = $("#select_user_approval_line").val();
      $.ajax({
         type: "POST",
         cache: false,
         url: "<?php echo site_url(); ?>/biz/approval/user_approval_line_save",
         async :false,
         data: {
            type:3,
            seq : delete_seq
         },
         success: function (result) {
            if(result){
               alert("결재선 삭제되었습니다.");
               $("#approval_line_name").val("");
            }else{
               alert("결재선 삭제에 실패하였습니다.");
            }
         }
      });
   }

   //사용자 결재선 선택
   function click_user_approval_line(seq){
      $("#select_approver").html('<tr class="ui-state-disabled" bgcolor="f8f8f9"><td height="30"></td><td height="30">결재</td><td height="30"><?php echo $name." ".$duty." ".$group; ?></td></tr>');
      if(seq != undefined){
         var select_seq = seq;
      }else{
         var select_seq = $("#select_user_approval_line").val();
      }
      var approver_seq ="";
      var approval_type ="";
      <?php
         if(empty($user_approval_line) != true){
            foreach($user_approval_line as $ual){ ?>
               if("<?php echo $ual['seq']; ?>" == select_seq){
                  approver_seq = "<?php echo $ual['approver_seq'];?>";
                  approval_type= "<?php echo $ual['approval_type'];?>";
               }
      <?php }
       } ?>

      approver_seq = approver_seq.split(',');
      approval_type = approval_type.split(',');
      for(i=0; i<approver_seq.length; i++){
         var html = '';
         $.ajax({
            type: "POST",
            cache: false,
            url: "<?php echo site_url(); ?>/biz/approval/user_approval_line_approver",
            dataType: "json",
            async :false,
            data: {
               user_seq: approver_seq[i]
            },
            success: function (data) {
               html += "<tr class='select_approver' onclick='click_user("+data['seq']+',"'+data['user_name']+' '+data['user_duty']+' '+data['user_group']+'"'+",this)'>";
               html += "<td height=30></td><td onclick='change_approval_type(this);' style='cursor:pointer;'>"+approval_type[i]+"</td><td>"+data['user_name']+' '+data['user_duty']+' '+data['user_group']+"<input type='hidden' name='approval_line_seq' value='"+data['seq']+"' /><input type='hidden' name='approval_line_type' value='"+approval_type[i]+"' /></td>";
               html += "</tr>";
               $("#select_approver").html($("#select_approver").html()+html);
            }
         });
      }
      finalReferrer();
   }

   //취소버튼
   function cancel(){
      if(confirm("이 페이지에서 나가시겠습니까? 작성중인 내용은 저장 되지 않습니다.")){
         location.href='<?php echo site_url(); ?>/biz/approval/electronic_approval_form_list?mode=user'
      }else{
         return false;
      }
   }

   //모달 외부 클릭시 모달 close
   $(document).mouseup(function (e) {
   var container = $('.searchModal');
   if (container.has(e.target).length === 0) {
      container.css('display', 'none');
   }
   });

   //휴가시작일 바뀌면 휴가끝나는날도 같이 수정
   function annual_end_date_change(val){
      $("#annual_end_date").val(val);
      $("#annual_end_date").change();
   }

   //휴가 일수 계산(주말 제외 계산)
   function annual_count(){
      var start_date = new Date($("#annual_start_date").val());
      var end_date = new Date($("#annual_end_date").val());
      var count = 0;

      while(true) {
         var temp_date = start_date;
         if(temp_date.getTime() > end_date.getTime()) {
            break;
         } else {
            var tmp = temp_date.getDay();
            if(tmp == 0 || tmp == 6) {  // 주말
            } else {  // 평일
               count++;
            }
            temp_date.setDate(start_date.getDate() + 1);
         }
      }
      if($("#annual_type2").val() != "001"){//반차인경우
         count = count * 0.5;
      }
      $("#annual_cnt").val(count);
   }

   //정규표현식
   function regex(obj,type){
      if(type == "money"){
         // val = $(obj).val().replace(/^0+|\D+/g, '').replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,');
         val = $(obj).val().replace(/[^0-9-]/g, '').replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,');
         $(obj).val(val);
      }else if (type == "number"){
         // val = $(obj).val().replace(/^0+|\D+/g, '');
         val = $(obj).val().replace(/[^0-9-]/g, '');
         $(obj).val(val);
      }else if (type=="decimal_point"){
         val = $(obj).val().replace(/[^0-9.-]/g, "");
         $(obj).val(val);
      }else if (type=="phone_num"){
         val = $(obj).val().replace(/(^02.{0}|^01.{1}|[0-9]{3})([0-9]+)([0-9]{4})/,"$1-$2-$3");
         $(obj).val(val);
      }else if (type =="email"){
         var regex =  /^[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$/i;
         if(regex.test($(obj).val()) === false){
            $(obj).focus();
            alert("email 형식이 틀렸습니다.")
            return false
         }
      }else if (type == "post_num"){
         var regex =  /^[0-9]{1,6}$/
         if(regex.test($(obj).val()) === false){
            $(obj).focus();
            alert("우편번호는 숫자 6자리만 입력해주세요")
            return false;
         }
      }
   }
/////////////////////////////////////////////////여기서부터 품의서 연동///////////////////////////////////////
   <?php
   if(isset($_GET['sales_seq']) || isset($_GET['maintain_seq'])){ ?> //상품,조달,용역,유지보수 공통
     <?php if($seq ==39){ ?>
       $('#html td:contains("End-User")').next().find("textarea").val('<?php echo $sales_val['customer_companyname']; ?>'); //end-user
     <?php }else{ ?>
       $('#html td:contains("End-User")').next().find("input").val('<?php echo $sales_val['customer_companyname']; ?>'); //end-user
     <?php } ?>

     <?php if($seq == 38){ ?>
      $('#html td:contains("VAT")').next().find("input").val('<?php echo $sales_val['procurement_sales_amount']; ?>');
     <?php } ?>
      var purchase_tb=  $('#html .basic_table td:contains("매입처")').closest("table");
      var sales_tb=  $('#html .basic_table td:contains("매출처")').closest("table");
   <?php if(isset($_GET['sales_seq'])){ ?>
     var sales_type = '<?php echo $sales_val['sales_type'] ?>';
     if(sales_type == 'delivery') {
       $('input:radio[name="tr17_td1"][value="납품"]').attr('checked', true);
     } else if (sales_type == 'circulation') {
       $('input:radio[name="tr17_td1"][value="유통"]').attr('checked', true);
     }
   <?php
   if(isset($sales_val2)){?>
      var sales_val_cnt = <?php echo count($sales_val2); ?>;
      <?php for($i=0; $i<count($sales_val2); $i++){ ?>
         if(<?php echo $i?> != 0){
            $(purchase_tb).find("tr:first td:last img").click();
         }
         $("#html .basic_table:eq(0) tr:eq(<?php echo ($i+1); ?>) td:first input").val('<?php echo $sales_val2[$i]['main_companyname'];?>');
        <?php
        $j = 0;
         foreach($sales_val4 as $sv4){
             if($sales_val2[$i]['main_companyname'] == $sv4['product_supplier'] && $seq !=39){?>
               <?php if($j == 0){
                  if($sv4['product_row'] <= 1){?>
                     $(purchase_tb).find("tr:eq(<?php echo ($i+1); ?>) td:eq(1) input").val('<?php echo $sv4['product_name']; ?>');
                     $(purchase_tb).find("tr:eq(<?php echo ($i+1); ?>) td:eq(2) input").val('<?php echo $sv4['product_cnt']; ?>');
                     $(purchase_tb).find("tr:eq(<?php echo ($i+1); ?>) td:eq(3) input").val('<?php echo number_format($sv4['total']/$sv4['product_cnt']); ?>');
                     $(purchase_tb).find("tr:eq(<?php echo ($i+1); ?>) td:eq(3) input").change();
                     $(purchase_tb).find("tr:eq(<?php echo ($i+1); ?>) td:eq(5) input").val('<?php echo number_format($sv4['total']*0.1); ?>');

                  <?php }else{?>
                     $(purchase_tb).find("tr:eq(<?php echo ($i+1); ?>) td:eq(1) input").val('<?php echo $sv4['product_name']; ?>'+" 외")
                     $(purchase_tb).find("tr:eq(<?php echo ($i+1); ?>) td:eq(2) input").val(1);
                     $(purchase_tb).find("tr:eq(<?php echo ($i+1); ?>) td:eq(3) input").val('<?php echo number_format($sv4['total']); ?>');
                     $(purchase_tb).find("tr:eq(<?php echo ($i+1); ?>) td:eq(3) input").change();
                     $(purchase_tb).find("tr:eq(<?php echo ($i+1); ?>) td:eq(5) input").val('<?php echo number_format($sv4['total']*0.1); ?>');
                  <?php }?>

                  $("#html .basic_table:eq(0) tr:eq(<?php echo ($i+1); ?>) td:eq(5) input").change();
                  // $("#html .basic_table:eq(0) tr:eq(<?php echo ($i+1); ?>) td:eq(7) input").val('<?php echo $sales_val['exception_saledate']; ?>');
               <?php
               }
               $j++;
            }else if($sales_val2[$i]['main_companyname'] == $sv4['product_supplier'] && $seq ==39){ ?>
              <?php if($j == 0){
                 if($sv4['product_row'] <= 1){?>
                    $(purchase_tb).find("tr:eq(<?php echo ($i+1); ?>) td:eq(1) input").val('<?php echo $sv4['product_name']; ?>');
                    $(purchase_tb).find("tr:eq(<?php echo ($i+1); ?>) td:eq(4) input").val('<?php echo number_format($sv4['total']); ?>');
                    $(purchase_tb).find("tr:eq(<?php echo ($i+1); ?>) td:eq(4) input").change();
                    $(purchase_tb).find("tr:eq(<?php echo ($i+1); ?>) td:eq(5) input").val('<?php echo number_format($sv4['total']*0.1); ?>');

                 <?php }else{?>
                    $(purchase_tb).find("tr:eq(<?php echo ($i+1); ?>) td:eq(1) input").val('<?php echo $sv4['product_name']; ?>'+" 외")
                    $(purchase_tb).find("tr:eq(<?php echo ($i+1); ?>) td:eq(4) input").val('<?php echo number_format($sv4['total']); ?>');
                    $(purchase_tb).find("tr:eq(<?php echo ($i+1); ?>) td:eq(4) input").change();
                     <?php if($sv4['total'] > 0 ) {?>
                    $(purchase_tb).find("tr:eq(<?php echo ($i+1); ?>) td:eq(5) input").val('<?php echo number_format($sv4['total']*0.1); ?>');
                    <?php } ?>
                 <?php }?>

                 $("#html .basic_table:eq(0) tr:eq(<?php echo ($i+1); ?>) td:eq(5) input").change();
              <?php
              }
              $j++;
            }
         }
      }
   } ?>

   $(sales_tb).find("tr:eq(1) td:first input").val('<?php echo $sales_val['sales_companyname'];?>');
   <?php
   $product_name = $sales_val3[0]['product_name'];
   $distinct_product_cnt = $sales_val5[0]['cnt'];
   $product_cnt = 1;
   if($distinct_product_cnt == 1){
      $product_cnt = count($sales_val3);
   }else{
      if(count($sales_val3) > 1){
        $product_name .= " 외";
      }
   }?>
    <?php if($seq !=39){ ?>
   $(sales_tb).find("tr:eq(1) td:eq(1) input").val('<?php echo $product_name; ?>');
   $(sales_tb).find("tr:eq(1) td:eq(2) input").val(<?php echo $product_cnt; ?>);
   $(sales_tb).find("tr:eq(1) td:eq(3) input").val('<?php echo number_format($sales_val['forcasting_sales']/$product_cnt); ?>');
   $(sales_tb).find("tr:eq(1) td:eq(3) input").change();

   $(sales_tb).find("tr:eq(1) td:eq(5) input").val('<?php echo number_format($sales_val['forcasting_sales']*0.1); ?>');
   $(sales_tb).find("tr:eq(1) td:eq(5) input").change();
   $(sales_tb).find("tr:eq(1) td:eq(7) input").val('<?php echo $sales_val['exception_saledate']; ?>');
  <?php }else{ ?>
    $(sales_tb).find("tr:eq(1) td:eq(1) input").val('<?php echo $product_name; ?>');
    $(sales_tb).find("tr:eq(1) td:eq(4) input").val('<?php echo number_format($sales_val['forcasting_sales']); ?>');
    $(sales_tb).find("tr:eq(1) td:eq(4) input").change();
    $(sales_tb).find("tr:eq(1) td:eq(5) input").val('<?php echo number_format($sales_val['forcasting_sales']*0.1); ?>');
    $(sales_tb).find("tr:eq(1) td:eq(5) input").change();
    $(sales_tb).find("tr:eq(1) td:eq(7) input").val('<?php echo $sales_val['exception_saledate']; ?>');
    <?php } ?>

<?php }else if (isset($_GET['maintain_seq'])){ ?>//여기서부터 유지보수 매출품의서
   <?php
   if(isset($sales_val2)){?>
      var sales_val_cnt = <?php echo count($sales_val2); ?>;
      <?php for($i=0; $i<count($sales_val2); $i++){ ?>
         if(<?php echo $i?> != 0){
            $(purchase_tb).find("tr:first td:last img").click();
         }
         $(purchase_tb).find("tr:eq(<?php echo ($i+1); ?>) td:first input").val('<?php echo $sales_val2[$i]['main_companyname'];?>');

        <?php
        $j = 0;
         foreach($sales_val4 as $sv4){
            if($sales_val2[$i]['main_companyname'] == $sv4['product_supplier']){ ?>
               <?php if($j == 0){
                  if($sv4['product_row'] <= 1){
                     $p_cnt ='';
                     if($sv4['product_cnt'] > 1){
                        $p_cnt = " ".$sv4['product_cnt'].'식';
                     }?>
                     $(purchase_tb).find("tr:eq(<?php echo ($i+1); ?>) td:eq(1) input").val('<?php echo $sv4['product_name']; ?>'+'<?php echo $p_cnt; ?>'+" 유지보수");
                  <?php }else{?>
                     $(purchase_tb).find("tr:eq(<?php echo ($i+1); ?>) td:eq(1) input").val('<?php echo $sv4['product_name']; ?>'+" 외 "+<?php echo $sv4['product_row']-1; ?> +"식")
                  <?php }?>
                  $(purchase_tb).find("tr:eq(<?php echo ($i+1); ?>) td:eq(2) input").val('<?php echo $sales_val['exception_saledate2']; ?>');
                  $(purchase_tb).find("tr:eq(<?php echo ($i+1); ?>) td:eq(3) input").val('<?php echo $sales_val['exception_saledate3']; ?>');
                  $(purchase_tb).find("tr:eq(<?php echo ($i+1); ?>) td:eq(4) input").val('<?php echo number_format($sv4['total']); ?>');
                  $(purchase_tb).find("tr:eq(<?php echo ($i+1); ?>) td:eq(4) input").change();
                  $(purchase_tb).find("tr:eq(<?php echo ($i+1); ?>) td:eq(5) input").val('<?php echo number_format($sv4['total']*0.1); ?>');
                  $(purchase_tb).find("tr:eq(<?php echo ($i+1); ?>) td:eq(5) input").change();
                  $(purchase_tb).find("tr:eq(<?php echo ($i+1); ?>) td:eq(7) select").val('<?php echo $sales_val2[$i]['issue_cycle']; ?>');
                  <?php
                  if(isset($purchase_bill) && !empty($purchase_bill)){
                  foreach($purchase_bill as $pb){
                     if($sales_val2[$i]['main_companyname'] == $pb['company_name']){

                         $issue_schedule_date = $pb['issue_schedule_date'];

                     }
                  }?>
                  $(purchase_tb).find("tr:eq(<?php echo ($i+1); ?>) td:eq(8) select").val('<?php if(isset($issue_schedule_date)){echo  date_format(date_create($issue_schedule_date),"j");}else{ echo "-"; } ?>');
                  <?php } ?>
               <?php
               }
               $j++;
            }
         }
      }
   }?>

   $(sales_tb).find("tr:eq(1) td:first input").val('<?php echo $sales_val['sales_companyname'];?>');
   var product_name = '<?php echo $sales_val3[0]['product_name']; ?>';
   <?php
   $sales_val3_cnt = 0;
   $sales_val5_cnt = 0;
   if(isset($sales_val3) && !empty($sales_val3)){
      $sales_val3_cnt = count($sales_val3);
   }
   if(isset($sales_val5) && !empty($sales_val5)){
      $sales_val5_cnt = count($sales_val5);
   }
   if(count($sales_val4) == 1){ ?>
      product_name += ' <?php echo ($sales_val3_cnt+$sales_val5_cnt); ?>'+"식";
   <?php }else if(($sales_val3_cnt+$sales_val5_cnt)>1){ ?>
      product_name += " 외 " + '<?php echo (($sales_val3_cnt+$sales_val5_cnt)-1); ?>' + "식";
   <?php } ?>
      product_name += " 유지보수";
   $(sales_tb).find("tr:eq(1) td:eq(1) input").val(product_name);
   $(sales_tb).find("tr:eq(1) td:eq(2) input").val('<?php echo $sales_val['exception_saledate2']; ?>');
   $(sales_tb).find("tr:eq(1) td:eq(3) input").val('<?php echo $sales_val['exception_saledate3']; ?>');
   $(sales_tb).find("tr:eq(1) td:eq(4) input").val('<?php echo number_format($sales_val['forcasting_sales']); ?>');
   $(sales_tb).find("tr:eq(1) td:eq(4) input").change();
   $(sales_tb).find("tr:eq(1) td:eq(5) input").val('<?php echo number_format($sales_val['forcasting_sales']*0.1); ?>');
   $(sales_tb).find("tr:eq(1) td:eq(5) input").change();
   $(sales_tb).find("tr:eq(1) td:eq(7) select").val('<?php echo $sales_val['issue_cycle']; ?>');
   <?php if(isset($sales_bill) && !empty($sales_bill)){ ?>
   $(sales_tb).find("tr:eq(1) td:eq(8) select").val('<?php echo date_format(date_create($sales_bill[0]['issue_schedule_date']),"j"); ?>');
   <?php } ?>
<?php }
} ?>

<?php if(isset($_GET['req_support_seq'])) { ?>
  $(function() {
    var req_support_seq = $('#req_support_seq').val();
    req_support_seq = req_support_seq.split('_');
    req_support_seq.splice(req_support_seq.indexOf(''),1);
    var req_file_change_name = '';
    var req_file_real_name = '';

    for(i=0; i<req_support_seq.length; i++) {
      (function(i) {
        var seq = req_support_seq[i];
        // alert(i);
        $.ajax({
          type: "POST",
          cache: false,
          url: "<?php echo site_url(); ?>/tech/tech_board/req_support_info",
          dataType: 'json',
          async: false,
          data: {
            seq: seq
          },
          success: function(data) {
            if (data[0].file_change_name != null){
              if (req_file_change_name != '') {
                req_file_change_name += '*/*';
                req_file_real_name += '*/*';
              }
              req_file_change_name += data[0].file_change_name;
              req_file_real_name += data[0].file_real_name;
            }
            if (data[0].visit_date != null) {
              var visit_date = data[0].visit_date.split('/*/');
              visit_date.splice(visit_date.indexOf(''),1);
              visit_date.push(data[0].installation_date);
              for(j=0;j<visit_date.length;j++){
                var tr = $('tr[name=multi_row5]:last');
                tr.find('td').eq(0).find('input').val(data[0].cooperative_company);
                tr.find('td').eq(1).find('input').val(data[0].workplace_name);
                tr.find('td').eq(2).find('input').val(data[0].produce);
                tr.find('td').eq(3).find('input').val(visit_date[j]);
                tr.find('td').eq(4).find('input').val('80,000');
                tr.find('td').eq(5).find('input').val('8,000');
                tr.find('td').eq(6).find('input').val('88,000');
                tr.after(tr.clone(true));
              }
            } else {
              var visit_date = [];
              visit_date.push(data[0].installation_date);
              for(j=0;j<visit_date.length;j++){
                var tr = $('tr[name=multi_row5]:last');
                tr.find('td').eq(0).find('input').val(data[0].cooperative_company);
                tr.find('td').eq(1).find('input').val(data[0].workplace_name);
                tr.find('td').eq(2).find('input').val(data[0].produce);
                tr.find('td').eq(3).find('input').val(visit_date[j]);
                tr.find('td').eq(4).find('input').val('80,000');
                tr.find('td').eq(5).find('input').val('8,000');
                tr.find('td').eq(6).find('input').val('88,000');
                tr.after(tr.clone(true));
              }
            }
          }
        });
      })(i);
    }
    var tr = $('tr[name=multi_row5]:last');
    tr.remove();
    // alert(req_file_real_name);
    // alert(req_file_change_name);
    multi_sum('tr6_td5');
    multi_sum("tr6_td6");
    multi_sum("tr6_td7");
    // alert(req_file_real_name);
    // alert(req_file_change_name);
    $('#req_file_real_name').val(req_file_real_name);
    $('#req_file_change_name').val(req_file_change_name);
    req_file_real_name_arr = req_file_real_name.split('*/*');
    for (i=0; i<req_file_real_name_arr.length; i++) {
      $('#fileTableTbody:last').after('<tr><td>'+req_file_real_name_arr[i]+'<span style="font-weight:bold;"> (자동첨부)</span></td></tr>');
    }
  })
<?php } ?>

<?php if($seq == 45) { ?>
  $('.tr2_td1').change(function() {
    var val = $('.tr2_td1 option:selected').val();

    if (val == '화환(근조)') {
      var txt = '1. 회사명/소속/직함/이름/ :\n2. 고인(관계): \n3. 받는 곳 주소 : \n4. 발인날짜: ';
    } else if (val == '화환(축하)') {
      var txt = '1. 회사명/소속/이름(신랑신부구분) :\n2. 받는 곳 주소(예식장):\n3. 예식 시간: ';
    } else if (val == '난(승진)') {
      var txt = '1. 회사명/소속/이름 :\n2. 받는곳 주소: ';
    } else if (val == '화분(개업)') {
      var txt = '1. 회사명/소속/이름 :\n2. 받는곳 주소: ';
    } else if (val == '과일바구니(출산)') {
      var txt = '1. 회사명/소속/이름 :\n2. 받는곳 주소: ';
    }

    $('.tr4_td1').text(txt);
  })

  $('.tr2_td1').change();
<?php } ?>

// 지출결의서 <-> 출장보고서 연동
<?php if($seq == 6) { ?>
  $('#approval_attach').change(function() {
    var attach_seq = $(this).val().replace(',', '');
    var attach_seq_arr = attach_seq.split(',');
    var attach_seq_arr_adjust = [];
    for(i=0; i<attach_seq_arr.length; i++) {
      if($('.attach_'+attach_seq_arr[i]).length == 0) {
        attach_seq_arr_adjust.push(attach_seq_arr[i]);
      }
    }
    attach_seq = attach_seq_arr_adjust.join(',');
    console.log(attach_seq);
    $.ajax({
      type:"POST",
      cache:false,
      url:"<?php echo site_url(); ?>/biz/approval/expense_list_tech",
      dataType:"json",
      async:false,
      data:{
        attach_seq: attach_seq
      },
      success: function(data) {
        if(data) {
          var last_blank = true;
          var last_tr = $('.tr2_td1').last().closest('tr');
          var last_value = '';
          last_tr.find('input').each(function() {
            if($.trim($(this).val()) != '') {
              last_blank = false;
            }
          });

          for(var i = 0; i < data.length; i++) {
            var t = $('.tr2_td1').last().closest('tr');

            if(last_blank) {
              t.addClass('attach_'+data[i].approval_seq);
              t.find('.tr2_td1').val(data[i].t_date);
              t.find('.tr2_td2').val(data[i].details);
              t.find('.tr2_td3').val(data[i].company);
              t.find('.tr2_td5').val(data[i].history_user);
              t.find('.tr2_td7').val(commaStr(data[i].corporation_card));
              t.find('.tr2_td8').val(commaStr(data[i].personal_card));
              t.find('.tr2_td9').val(commaStr(data[i].simple_receipt));
              t.find('.tr2_td7, .tr2_td8, .tr2_td9').change();
              last_blank = false;
            } else {
              var tr = $('.tr2_td1').last().closest('tr');
              var tr_name = tr.attr('name');
              var tr_last = $('tr[name='+tr_name+']')[$('tr[name='+tr_name+']').length-1];
              var tr_last_html = tr_last.outerHTML;
              $(tr).after(tr_last_html);
              var new_tr = $('tr[name='+tr_name+']')[$('tr[name='+tr_name+']').length-1];
              $(new_tr).find("img").show();
              for(j=0; j<$(new_tr).find($("input")).length; j++){
                 // if($(new_tr).find($("input")).eq(i).val().indexOf("express") != -1){
                    $(new_tr).find($("input")).eq(j).val(''); //표현식 들어있는 input 비워
                 // }
              }
              $(new_tr).attr('class', '');
              $(new_tr).addClass('attach_'+data[i].approval_seq);
              $(new_tr).find('.tr2_td1').val(data[i].t_date);
              $(new_tr).find('.tr2_td2').val(data[i].details);
              $(new_tr).find('.tr2_td3').val(data[i].company);
              $(new_tr).find('.tr2_td5').val(data[i].history_user);
              $(new_tr).find('.tr2_td7').val(commaStr(data[i].corporation_card));
              $(new_tr).find('.tr2_td8').val(commaStr(data[i].personal_card));
              $(new_tr).find('.tr2_td9').val(commaStr(data[i].simple_receipt));
              $(new_tr).find('.tr2_td7, .tr2_td8, .tr2_td9').change();
            }
          }
        }
      }
    })
  })
<?php } ?>

// 금액 부분 콤마 추가
function commaStr(n) {
  var reg = /(^[+-]?\d+)(\d{3})/;
  n += "";

  while (reg.test(n))
    n = n.replace(reg, "$1" + "," + "$2");
  return n;
}

<?php if(in_array($seq, $tech_approval)) { ?>
  $('#approval_tech_doc_attach').change(function() {
    var approval_form_seq = $('#approval_form_seq').val();
    var attach_seq = $(this).val();
    attach_seq = attach_seq.split('::')[0];

    $.ajax({
      type:'POST',
      cache:false,
      url:"<?php echo site_url(); ?>/biz/approval/tech_doc_data",
      dataType:'json',
      async:false,
      data: {
        attach_seq: attach_seq
      },
      success: function(data) {
        if(data) {
          if(approval_form_seq == 56) {
            var start_time = data.start_time;
            var end_time = data.end_time;
            start_time = start_time.substr(0, 5);
            end_time = end_time.substr(0, 5);
            if(start_time < '19:00') {
              start_time = '19:00';
            }
            $('.tr3_td1').val(start_time);
            $('.tr3_td2').val(end_time);
          } else if (approval_form_seq == 21) {
            var start_day = data.income_time;
            start_day = start_day.substring(0, 10);
            $('input[name=tr3_td1]').val(start_day);
          } else if (approval_form_seq == 17) {
            var start_day = data.income_time;
            var end_day = data.end_work_day;
            start_day = start_day.substring(0, 10);
            end_day = end_day.substring(0, 10);
            $('input[name=tr2_td1]').val(start_day);
            $('input[name=tr2_td2]').val(end_day);
          } else if (approval_form_seq == 74) {
            var start_day = data.income_time;
            var end_day = data.end_work_day;
            start_day = start_day.substring(0, 10);
            end_day = end_day.substring(0, 10);
            $('.tr8_td1').val(start_day);
            $('.tr8_td2').val(end_day);
          }
        }
      }
    })

  })

  $('#approval_tech_doc_attach').trigger('change');
<?php } ?>

<?php if(isset($tech_data_val)) { //기지보에서 작성 시
  if($seq == 17) { ?>
    $('.tr4_td1').val('<?php echo $tech_data_val["customer"]; ?>'); //출장처
    $('input[name=tr2_td1]').val('<?php echo substr($tech_data_val['income_time'], 0, 10);?>'); //출장시작일
<?php if($tech_data_val['end_work_day'] == NULL) { ?> //출장종료일
    $('input[name=tr2_td2]').val('<?php echo substr($tech_data_val['income_time'], 0, 10);?>');
<?php } else { ?>
    $('input[name=tr2_td2]').val('<?php echo substr($tech_data_val['end_work_day'], 0, 10);?>');
<?php }
  } else if ($seq == 21) { ?>
    $('input[name=tr3_td1]').val('<?php echo substr($tech_data_val['end_work_day'], 0, 10); ?>');
<?php
  } else if ($seq == 56) { ?>
    $('.tr3_td1').val('<?php if(substr($tech_data_val['start_time'], 0, 5) < '19:00' ){echo '19:00';} else {echo substr($tech_data_val['start_time'], 0, 5);} ?>')
    $('.tr3_td2').val('<?php echo substr($tech_data_val['end_time'], 0, 5); ?>')
<?php
  } else if ($seq == 74) { ?>
    $('.tr3_td1').val('<?php echo $tech_data_val["customer"]; ?>'); //출장처
    $('.tr8_td1').val('<?php echo substr($tech_data_val['income_time'], 0, 10);?>'); //출장시작일
<?php if($tech_data_val['end_work_day'] == NULL) { ?> //출장종료일
      $('.tr8_td2').val('<?php echo substr($tech_data_val['income_time'], 0, 10);?>');
<?php } else { ?>
      $('.tr8_td2').val('<?php echo substr($tech_data_val['end_work_day'], 0, 10);?>');
<?php }
  }
} ?>

// 사직원 퇴사계획일 30일 이후 선택 가능
<?php if($seq == 73) { ?>
  $(function() {
    var tDay = new Date();
    var target_date = new Date(tDay.setDate(tDay.getDate() + 30));

    $('.tr6_td2').change( function() {
      var val = $(this).val();

      if(val != '') {
        var d = new Date(val);

        if(d < target_date) {
          alert('퇴사계획일은 30일 이후부터 선택 가능합니다.');
          $(this).val('');
          return false;
        }
      }
    })

    $('.tr6_td2').change();
  })
<?php } ?>

function tech_doc_view(seq) {
  window.open("<?php echo site_url();?>/tech/tech_board/tech_doc_print_page?seq="+btoa(seq), "cform", 'scrollbars=yes,width=850,height=600');
}
</script>

<!-- 지출결의서 엑셀 임포트 -->
<?php
if($seq == 6) {
  include $this->input->server('DOCUMENT_ROOT')."/misc/js/approval_excel_import.php";
} ?>
</body>
</html>

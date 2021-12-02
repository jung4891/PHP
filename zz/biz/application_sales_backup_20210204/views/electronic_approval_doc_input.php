<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
  $duty = $this->phpsession->get( 'duty', 'stc' );
?>
<style>
   p, div, span, a, a:hover, a:visited, a:active, label, input, h1,h2,h3,h4,h5,h6{font-family: "Noto Sans KR";}
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
</style>
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet"> 
<body>
<form id="cform" name="cform" action="<?php echo site_url(); ?>/approval/electronic_approval_doc_input_action" method="post" enctype="multipart/form-data" onSubmit="javascript:chkForm('request');return false;">
   <input type="hidden" id="select_user_id" name="select_user_id" value="">
   <input type="hidden" id="approval_form_seq" name="approval_form_seq" value="<?php echo $_GET['seq']; ?>">
   <input type="hidden" id="contents_html" name="contents_html" />
   <input type="hidden" id="editor_contents" name="editor_contents" />
   <input type="hidden" id="approval_request" name="approval_request" />
   <input type="hidden" id="approval_doc_status" name="approval_doc_status" />
   <input type="hidden" id="click_user_seq" name="click_user_seq" />
   <input type="hidden" id="type" name="type" value="1" />
   <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
      <?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php"; ?>
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
                                    <input type="button" class="basicBtn" value="결재선" onclick="select_approval_modal();" />
                                    <input type="button" class="basicBtn" value="결재요청" onclick="chkForm('request');" />
                                    <input type="button" class="basicBtn2" value="기결재첨부" onclick="approvalAttachment();">
                                    <input type="button" class="basicBtn2" value="임시저장" onclick="chkForm('temporary');" />
                                    <input type="button" class="basicBtn2" value="취소" onclick="cancel();">
                                 </div>
                                 <div style="text-align:center;font-size:30px;height:40px;">
                                    <?php if($seq == "annual"){
                                       echo "연차신청서";
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
                                                <input id="referrer" name="referrer" type="text" class="input2" value="<?php if($seq != "annual"){ echo $view_val['default_referrer'];} ?>" />
                                                <img src="<?php echo $misc;?>img/btn_add.jpg" style="cursor:pointer;vertical-align:middle;" border="0" onClick="select_user('referrer');"/>
                                          </td>
                                          <td width="15%" align="center" class="basic_td" bgcolor="f8f8f9">기결재첨부</td>
                                          <td width="35%" class="basic_td">
                                             <input id="approval_attach" name="approval_attach" type="hidden" value="" />
                                             <div id="approval_attach_list" name="approval_attach_list"> </div>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td width="15%" align="center" height=40 class="basic_td" bgcolor="f8f8f9">문서제목</td>
                                          <td colspan=3 class="basic_td"><input type="text" id="approval_doc_name" name="approval_doc_name" class="input7" value=""></td>
                                       </tr>
                                    </table>
                                 </div>
                                 <div id="formLayoutDiv" style="margin-top:30px;">
                                    <?php
                                       if($seq != "annual"){
                                          echo $view_val['preview_html'];
                                       }else{?>
                                          <table class="basic_table" width="100%" style="">
                                             <tr>
                                                <td align="center" bgcolor="f8f8f9" height=40 class="basic_td">연차발생일수</td>
                                                <td height=40 class="basic_td"><?php echo $annual['annual_cnt'];?></td>
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
                                                   <select class="input2" id="annual_type2" name="annual_type2" required>
                                                      <option value="">선택</option>
                                                      <option value="001">전일</option>
                                                      <option value="002">오전반차</option>
                                                      <option value="003">오후반차</option>
                                                   </select>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td align="center" bgcolor="f8f8f9" height=40 class="basic_td"><span style='color:red'>*</span>휴가기간</td>
                                                <td colspan=3 height=40 class="basic_td"><input type="date" id="annual_start_date" name="annual_start_date" class="input2" value="<?php echo date("Y-m-d");?>" onchange="annual_end_date_change(this.value)" style="width:115px;" /> ~ <input type="date" id="annual_end_date" name="annual_end_date" class="input2" value="<?php echo date("Y-m-d");?>" onchange="annual_count();" style="width:115px;"/> &nbsp; (일수 : <input type='text' id="annual_cnt" name="annual_cnt" class="input5" value="1" style="text-align:center;" readonly /> ) </td>
                                                <td align="center" bgcolor="f8f8f9" height=40 class="basic_td">휴가사유</td>
                                                <td height=40 class="basic_td"><input type="text" id="annual_reason" name="annual_reason" class="input2" /></td>
                                             </tr>
                                          </table>
                                          <div style='margin:30px 0px 10px 0px;'>
                                             * 직무대행자
                                          </div>
                                          <table class="basic_table" width="100%" >
                                             <tr>
                                                <td align="center" bgcolor="f8f8f9" height=40 class="basic_td"><span style='color:red'>*</span>성명/소속</td>
                                                <td height=40 class="basic_td"><input type="text" id="functional_agent" name="functional_agent" class="input2" required readonly /><img src="<?php echo $misc; ?>img/btn_add.jpg" style="vertical-align:middle;margin-left:10px;" onclick="select_user('functional_agent')"></td>
                                                <td align="center" bgcolor="f8f8f9" height=40 class="basic_td"><span style='color:red'>*</span>긴급연락처</td>
                                                <td height=40 class="basic_td">
                                                   <input type="text" id="emergency_phone_num" name="emergency_phone_num" class="input2" onchange="regex(this,'phone_num');" required />
                                                </td>
                                             </tr>
                                          </table>

                                    <?php }
                                    ?>
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
                                    <input type="button" class="basicBtn" value="결재선" onclick="select_approval_modal();">
                                    <input type="button" class="basicBtn" value="결재요청" onclick="chkForm('request');">
                                    <input type="button" class="basicBtn2" value="기결재첨부">
                                    <input type="button" class="basicBtn2" value="임시저장" onclick="chkForm('temporary');">
                                    <input type="button" class="basicBtn2" value="취소">
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
                                 <img src="<?php echo $misc;?>img/btn_cancel.jpg" style="cursor:pointer;float:right;margin-left:5px;margin-top:5px;" border="0" onClick="closeUserModal();"/>
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
                                             <tr bgcolor="f8f8f9">
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
      <!--하단-->
      <tr>
         <td align="center" height="100" bgcolor="#CCCCCC">
            <table width="1130" cellspacing="0" cellpadding="0">
               <tr>
                  <td width="197" height="100" align="center" background="<?php echo $misc;?>img/customer_f_bg.png"><img
                        src="<?php echo $misc;?>img/f_ci.png" /></td>
                  <td><?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?></td>
               </tr>
            </table>
         </td>
      </tr>
   </table>
</form>
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.css" rel="stylesheet"> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.js"></script>
<script>
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
      $("#click_user").attr('id','');
      $("#group_tree_modal").show();
      $("#select_user_id").val(s_id);
      if($("input[name="+$("#select_user_id").val()+"]").val() != ""){
         var select_user = ($("#"+$("#select_user_id").val()).val()).split(',');
         var txt = '';
         for(i=0; i<select_user.length; i++){
            txt += "<div class='select_user' onclick='click_user("+'"'+select_user[i]+'"'+",this)'>"+select_user[i]+"</div>";
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
      $(obj).css('background-color','#f8f8f9');
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
                     html += "<div class='select_user' onclick='click_user("+data[i].seq+'"'+data[i].user_name+'"'+",this)'>"+data[i].user_name+" "+data[i].user_duty+" "+data[i].user_group+"</div>";
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
      if($("#click_user").attr('class') == 'select_approver'){
         $("#click_user").remove();
         finalReferrer();
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
         if(tt.prop("required")) {
            if(!jQuery.trim(tt.val())) {
               var t = jQuery("label[for='"+tt.attr("id")+"']").text();
               check = false;
               tt.focus();
               alert(t+" 필수 입력값을 채워주세요.");
               return false;
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
            url: "<?php echo site_url(); ?>/approval/electronic_approal_annual_duplication_check",
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
               approval_attach_val += ','+approval_attach[i]+'--'+$("span[name=attach_name]").eq(i).text(); 
            }
            approval_attach_val = approval_attach_val.replace(',','');
         }

         $("#approval_attach").val(approval_attach_val);
         
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

         $.ajax({
            url: "<?php echo site_url(); ?>/approval/electronic_approval_doc_input_action",
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
                     location.href ="<?php echo site_url();?>/approval/electronic_approval_doc_list?type=request";
                  }else{
                     location.href ="<?php echo site_url();?>/approval/electronic_approval_doc_list?type=temporary";
                  }
               } else {
                  alert("저장 실패");
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
               class_name[i] = sum; 
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
      var new_tr = $('tr[name='+tr_name+']')[$('tr[name='+tr_name+']').length-1]
      for(i=0; i<$(new_tr).find($("input")).length; i++){
         if($(new_tr).find($("input")).eq(i).val().indexOf("express") != -1){
            $(new_tr).find($("input")).eq(i).val(''); //표현식 들어있는 input 비워
         }
      }
   }

   function delRow(obj){
      $(obj).parent().parent().remove();
   }

   function approvalAttachment(){
      window.open('<?php echo site_url();?>/approval/approval_attachment','_blank',"width = 1200, height = 500, top = 100, left = 400, location = no,status=no,status=no,toolbar=no,scrollbars=no");
   }

   //기결재 첨부 삭제
   function attachRemove(seq){
      $("#attach_"+seq).remove();
      if($("#approval_attach").val().indexOf(','+seq) != -1){
         $("#approval_attach").val($("#approval_attach").val().replace(','+seq,''))
      }else{
         $("#approval_attach").val($("#approval_attach").val().replace(seq+',',''));
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
            url: "<?php echo site_url(); ?>/approval/user_approval_line_save",
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
         url: "<?php echo site_url(); ?>/approval/user_approval_line_save",
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
      $("#select_approver").html('<tr bgcolor="f8f8f9"><td height="30"></td><td height="30">결재</td><td height="30"><?php echo $name." ".$duty." ".$group; ?></td></tr>');
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
            url: "<?php echo site_url(); ?>/approval/user_approval_line_approver",
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
         location.href='<?php echo site_url(); ?>/approval/electronic_approval_form_list?mode=user' 
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
      $("#annual_cnt").val(count);
   }

   //정규표현식
   function regex(obj,type){
      if(type == "money"){
         val = $(obj).val().replace(/^0+|\D+/g, '').replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,');
         $(obj).val(val);
      }else if (type == "number"){
         val = $(obj).val().replace(/^0+|\D+/g, '');
         $(obj).val(val);
      }else if (type=="decimal_point"){
         val = $(obj).val().replace(/[^0-9.]/g, "");
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
</script>
</body>
</html>
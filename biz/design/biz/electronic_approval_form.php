<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
  $mode = $_GET['mode'];
?>
<style>
   p, div, span, a, a:hover, a:visited, a:active, label, input, h1,h2,h3,h4,h5,h6{font-family: "Noto Sans KR";}
   .tabs {position: relative;margin: 35px auto;width: 600px;}
   .tabs_input {position: absolute;z-index: 1000;width: 120px;height: 35px;left: 0px;top: 0px;opacity: 0;-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";filter: alpha(opacity=0);}
   .tabs_input:not(:checked) {cursor: pointer;}
   .tabs_input:not(:checked) + label {color:#fff;}
   .tabs_input:not(:checked) + label {background: white;color:#1A8DFF;z-index: 6;border-color:#1A8DFF;}
   .tabs_input:hover + label {background: #0575E6;color:#fff;}
   .tabs_input#tab-2{left: 120px;}
   .tabs_input#tab-3{left: 240px;}
   .tabs_input#tab-4{left: 360px;}
   .tabs_input.tab-selector-1:checked ~ .content .content-1,
   .tabs_input.tab-selector-2:checked ~ .content .content-2,
   .tabs_input.tab-selector-3:checked ~ .content .content-3,
   .tabs_input.tab-selector-4:checked ~ .content .content-4
   {z-index: 100;filter: alpha(opacity=100);opacity: 1;}

   .tabs label {background: #0575E6;color: #FFFFFF;font-size: 14px;line-height: 35px;height: 35px;position: relative;padding: 0 20px;float: left;display: block;width: 80px;letter-spacing: 0px;text-align: center;border-radius: 5px;border: 1px solid #0575E6;margin-right: 5px; }
   /* .tabs label:after {content: '';background: #fff;position: absolute;bottom: -2px;left: 0;width: 100%;height: 2px;display: block;} */
   /* .tabs label:first-of-type {z-index: 4;box-shadow: 1px 0 3px rgba(0,0,0,0.1);} */

   .tab-label-2 {z-index: 2;}
   .tab-label-3 {z-index: 3;}
   .tab-label-4 {z-index: 4;}

   .clear-shadow {clear: both;}

   .content {background: #fff;position: relative;width: 100%;height:auto; min-height:600px;overflow: auto;z-index: 999;}
   /* .content div {width:100%;position: absolute;top: 0;left: 0;padding: 10px 40px;z-index: 1;opacity: 0;box-sizing: border-box;} */
   .content div {width:100%;position: absolute;left: 0;z-index: 1;opacity: 0;box-sizing: border-box;}
   /* .content div h3{color: #398080;border-bottom:1px solid rgba(63,148,148, 0.1);} */
   /* .content div h3:before{content: " - ";} */
   .content div p {font-size: 14px;line-height: 22px;text-align: left;margin: 0;color: #777;padding-left: 15px;}
   .basic_td{
      border:1px solid;
      border-color:#d7d7d7;
   }
   .basic_table{
      border-collapse:collapse;
      border:1px solid;
      border-color:#d7d7d7;
   }

   .popupLayer {
      position: absolute;
      display: none;
      background-color: #ffffff;
      border: solid 2px #d0d0d0;
      width: 200px;
      height: 200px;
      padding: 10px;
      z-index: 1001;
   }
   .popup_menu:hover{
      color:#d0d0d0;
   }

   /* ?????? css */
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
   .basic_table td{
      padding:0px 10px 0px 10px;
      border:thin solid;
      border-color:#DFDFDF;
   }
   #form_table td{
      padding:0px 0px 0px 0px;
   }

   #form_table span{
      display:inline-block;
      width:100%;
      height:30px;
      padding:10px 0px 0px 0px;
   }

   .form_btn {
     margin-right: 5px;
     border: 2px solid black;
     background-color: white;
     width:60px;
     border-radius: 3px;
     background:white;
     border-color:#B0B0B0;
     color:#B0B0B0;
     cursor:pointer;
     margin-bottom:10px;
   }
   .form_btn:hover {
     background:#B0B0B0;
     color:white;
   }
</style>
<!-- <link rel="stylesheet" href="/misc/css/dashboard.css"> -->
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">
<script>
</script>
<body>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php"; ?>
<form name="cform" action="<?php echo site_url(); ?>/biz/approval/electronic_approval_form_popup" method="post" target="popup_window" onSubmit="javascript:openPopup();return false;">
   <input type="hidden" id="select_user_id" name="select_user_id" value="">
   <input type="hidden" name="popup_id" value="">
   <input type="hidden" name="popup_multi" value="">
   <input type="hidden" name="popup_template" value="">
</form>
<form name="pform" action="<?php echo site_url(); ?>/biz/approval/electronic_approval_form_preview" method="post" target="popup_window2" onSubmit="javascript:preview();return false;">
   <div style="display:none;">
      <table id="html" width="100%" border="0" style='font-family: "Noto Sans KR";border-collapse:collapse;'></table>
   </div>
   <input type="hidden" id="preview_html_val" name="preview_html_val" value="" />
</form>
<div align="center">
  <div class="dash1-1">
    <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
      <tbody>
        <tr>
          <td class="dash_title">
            <!-- <img src="<?php echo $misc; ?>img/dashboard/title_electronic_approval_form.png"/> -->
            ???????????? ?????? ??????
          </td>
        </tr>
        <tr height="8%">
        </tr>
        <tr style="max-height:45%">
          <td colspan="2" valign="top" style="padding:10px 0px;">
            <table class="content_dash_tbl" style="border:none;" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center" valign="top">
                  <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
                        <input type="hidden" name="mode" value="<?php echo $mode; ?>">
                        <tr>
                           <td align="center" valign="top">
                              <table width="100%" height="100%" cellspacing="0" cellpadding="0">
                                 <tr>
                                    <?php if($mode == "input"){ ?>
                                    <td width="100%" align="center" valign="top">
                                       <!--??????-->
                                       <input type="hidden" id="seq" name="seq" value="">
                                       <table width="100%" border="0" style="margin-top:50px; margin-bottom: 50px;">
                                          <tr>
                                             <td>
                                                <section class="tabs" style="width:100%">
                                                   <input id="tab-1" type="radio" name="radio-set" class="tab-selector-1 tabs_input" checked="checked">
                                                   <label for="tab-1" class="tab-label-1">????????????</label>
                                                   <input id="tab-2" type="radio" name="radio-set" class="tab-selector-2 tabs_input" onclick="approval_info_save_check();">
                                                   <label for="tab-2" class="tab-label-2">????????????</label>
                                                   <div class="clear-shadow"></div>
                                                   <div class="content">
                                                      <div class="content-1">
                                                         <input type="hidden" id="approval_info_check" name="approval_info_check" value="N" />
                                                         <input type="hidden" id="form_table_html" name="form_table_html" />
                                                         <input type="hidden" id="preview_html" name="preview_html" />
                                                         <input type="button" class="btn-common btn-color2" value="??????" onClick="approval_info_save();" style="float:right;">
                                                         <input type="button" class="btn-common btn-color1" value="??????" onClick="location.href='<?php echo site_url(); ?>/biz/approval/electronic_approval_form_list?mode=admin';" style="float:right;margin-right:10px;">
                                                         <h3>?????? ??????</h3>
                                                         <table width="100%" class ="basic_table">
                                                            <tr >
                                                               <td height="40" width="15%" class="basic_td row-color1" align="center" style="font-weight:bold;" >
                                                                  <span style="color:red;" > * </span>?????????
                                                               </td>
                                                               <td width="35%" class="basic_td" align="left" style="font-weight:bold;" >
                                                                  <input type="text" class="input-common" id="template_name" name="template_name" />
                                                               </td>
                                                               <td width="15%" class="basic_td row-color1" align="center" style="font-weight:bold;" >
                                                                  <span style="color:red;"> * </span>?????????
                                                               </td>
                                                               <td width="35%" class="basic_td" align="left" style="font-weight:bold;" >
                                                                  <select class="select-common" style="width:250px;" id="template_category" name="template_category">
                                                                     <option value="">?????????</option>
                                                                     <?php foreach($category as $format_categroy){
                                                                        echo "<option value='{$format_categroy['seq']}'>{$format_categroy['category_name']}</option>";
                                                                     } ?>
                                                                  </select>
                                                               </td>
                                                            </tr>
                                                            <tr >
                                                               <td height="40" width="15%" class="basic_td row-color1" align="center" style="font-weight:bold;" >
                                                                  ????????????
                                                               </td>
                                                               <td colspan=3 width="35%" class="basic_td" align="left" style="font-weight:bold;" >
                                                                  <input type="radio" name="template_type" value="????????????" checked="checked"  />????????????
                                                                  <input type="radio" name="template_type" value="?????????" />?????????
                                                               </td>
                                                            </tr>
                                                            <tr >
                                                               <td height="40" width="15%" class="basic_td row-color1" align="center" style="font-weight:bold;" >
                                                                  ????????????
                                                               </td>
                                                               <td width="35%" class="basic_td" align="left" >
                                                                  <input type="text" id="template_sort_seq" name="template_sort_seq" class="input-common" style="width:100px;" value="0" />&nbsp * ????????? ?????? ??? ???????????? ????????? ?????? ??????, ????????? ?????? ?????? ????????? ?????????.
                                                               </td>
                                                               <td height="40" width="15%" class="basic_td row-color1" align="center" style="font-weight:bold;" >
                                                                  ????????????
                                                               </td>
                                                               <td width="35%" class="basic_td" align="left" >
                                                                 <input type="radio" name="official_doc" value="N" checked="checked"  />?????????
                                                                 <input type="radio" name="official_doc" value="Y" />??????
                                                               </td>
                                                            </tr>
                                                            <tr >
                                                               <td width="15%" class="basic_td row-color1" align="center" style="font-weight:bold;" >
                                                                  <span style="color:red;"> * </span>????????????
                                                               </td>
                                                               <td height="60" colspan=3 width="35%" class="basic_td" align="left" style="font-weight:bold;" >
                                                                  <textarea id="template_explanation" name="template_explanation" class="textarea-common" style="height:85%;width:100%"></textarea>
                                                               </td>
                                                            </tr>
                                                         </table>
                                                         <h3>????????? ??????</h3>
                                                         <table width="100%" class ="basic_table">
                                                            <tr >
                                                               <td width="15%" class="basic_td row-color1" align="center" style="font-weight:bold;" >
                                                                  ???????????????
                                                               </td>
                                                               <td width="85%" height="40" colspan=3 class="basic_td" align="left" style="font-weight:bold;" >
                                                                  <select  id="default_approval_line" name="default_approval_line" class="select-common" onchange='click_user_approval_line(this.value)' style="width:256px;" >
                                                                     <option value="N" selected>????????? ?????? ??????(????????? ?????? ??? ??????)</option>
                                                                     <?php foreach($approver_line as $al){
                                                                        echo "<option value='{$al['seq']}'";
                                                                        if(isset($seq)){
                                                                           if($al['seq'] == $view_val['default_approval_line']){
                                                                              echo "selected";
                                                                           }
                                                                        }
                                                                        echo ">{$al['approval_line_name']}</option>";
                                                                     } ?>
                                                                  </select>
                                                                  <table id="select_approver" width="90%" class="basic_table" style='text-align:center;'>
                                                                  </table>
                                                               </td>
                                                            </tr>
                                                         </table>
                                                         <h3>????????????</h3>
                                                         <table width="100%" class ="basic_table">
                                                            <tr >
                                                               <td width="15%" class="basic_td row-color1" align="center" style="font-weight:bold;" >
                                                                  ?????? ?????????
                                                               </td>
                                                               <td width="85%" height=40 colspan=3 class="basic_td" align="left" style="font-weight:bold;" >
                                                                  <input id="default_referrer" name="default_referrer" type="text" class="input-common" style="width:95%;" />
                                                                  <img src="<?php echo $misc;?>img/btn_add.jpg" style="cursor:pointer;vertical-align:middle;" border="0" onClick="select_user('default_referrer');"/>
                                                               </td>
                                                            </tr>
                                                         </table><br>
                                                         <!-- <img src="<?php echo $misc;?>img/dashboard/btn/btn_cancel.png" style="cursor:pointer;float:right;margin-left:5px;" border="0" onClick="location.href='<?php echo site_url(); ?>/biz/approval/electronic_approval_form_list?mode=admin';"/> -->
                                                         <!-- <img src="<?php echo $misc;?>img/dashboard/btn/btn_add.png" style="cursor:pointer;float:right" border="0" onClick="approval_info_save();"/> -->
                                                         <input type="button" class="btn-common btn-color2" value="??????" onClick="approval_info_save();" style="float:right;">
                                                         <input type="button" class="btn-common btn-color1" value="??????" onClick="location.href='<?php echo site_url(); ?>/biz/approval/electronic_approval_form_list?mode=admin';" style="float:right;margin-right:10px;">
                                                      </div>
                                                      <div class="content-2">
                                                         <!-- <img src="<?php echo $misc;?>img/dashboard/btn/btn_delete.png" style="cursor:pointer;float:right;margin-left:5px;" border="0" onClick="template_delete();"/>
                                                         <img src="<?php echo $misc;?>img/dashboard/btn/btn_cancel.png" style="cursor:pointer;float:right;margin-left:5px;" border="0" onClick="location.href= '<?php echo site_url(); ?>/biz/approval/electronic_approval_form_list?mode=admin';"/>
                                                         <img src="<?php echo $misc;?>img/dashboard/btn/btn_add.png" style="cursor:pointer;float:right" border="0" onClick="template_info_save();"/><br> -->
                                                         <input type="button" class="btn-common btn-color2" style="float:right;" value="??????" onClick="template_info_save();">
                                                         <input type="button" class="btn-common btn-color1" style="float:right;margin-right:10px;" value="??????" onClick="location.href= '<?php echo site_url(); ?>/biz/approval/electronic_approval_form_list?mode=admin';">
                                                         <input type="button" class="btn-common btn-color1" style="float:right;margin-right:10px;" value="??????" onClick="template_delete();">
                                                         <h3>????????????</h3>
                                                         <table width="100%" class ="basic_table">
                                                            <tr >
                                                               <td height="40" width="15%" class="basic_td row-color1" align="center" style="font-weight:bold;" >
                                                                  ?????????
                                                               </td>
                                                               <td colspan=3 width="85%" class="basic_td" align="left" style="font-weight:bold;" >
                                                                  <input type="radio" name="editor_use" value="Y" />??????
                                                                  <input type="radio" name="editor_use" value="N" checked="checked" />?????????
                                                               </td>
                                                            </tr>
                                                            <tr >
                                                               <td height="60" width="15%" class="basic_td row-color1" align="center" style="font-weight:bold;" >
                                                                  ???????????????
                                                               </td>
                                                               <td height="60" colspan=3 width="85%" class="basic_td" align="left" style="font-weight:bold;" >
                                                                  <textarea id="writing_guide" name="writing_guide" class="textarea-common" style="height:85%;width:100%"></textarea>
                                                               </td>
                                                            </tr>
                                                         </table>
                                                         <h3>?????? ?????????</h3>
                                                         <div class="content-2" style="width:100%">
                                                            <input type="button" class="btn-common btn-color1" value="?????????" onclick="reset();" style="margin-bottom:5px;">
                                                            <input type="button" class="btn-common btn-color1" value="????????????" onclick="preview();" style="margin-bottom:5px;">
                                                            <input type="button" class="btn-common btn-color2" value="??????????????? ??????" onclick="form_save_modal_open();" style="margin-bottom:5px;width:110px;">
                                                            <span style="float:right;">
                                                               <img src="<?php echo $misc;?>img/input.png" width="23" style="vertical-align:middle"> ?????????
                                                               <img src="<?php echo $misc;?>img/textbox.png" width="23" style="vertical-align:middle"> ???????????????
                                                               <img src="<?php echo $misc;?>img/select.png" width="20" style="vertical-align:middle"> ?????????
                                                               <img src="<?php echo $misc;?>img/radio.png" width="20" style="vertical-align:middle"> ?????????
                                                               <img src="<?php echo $misc;?>img/checkbox.png" width="20" style="vertical-align:middle"> ????????????
                                                               <img src="<?php echo $misc;?>img/writebox.png" width="20" style="vertical-align:middle"> ?????????
                                                               <img src="<?php echo $misc;?>img/component.png" width="20" style="vertical-align:middle"> ????????????
                                                               <img src="<?php echo $misc;?>img/line.png" width="20" style="vertical-align:middle"> ?????????
                                                            </span>
                                                            <br>
                                                            <?php for($i=1; $i<=10; $i++){
                                                               echo "<input type='button' class='form_btn' value='{$i}???' style='margin-left:2px;' onclick='form_add($i);'>";
                                                            } ?>
                                                            <input type="button" value="?????????" style='margin-left:2px;' onclick="form_add('line');" />
                                                            <div class="content-2" style="width:100%">
                                                               <table id="form_table" width="80%" class ="basic_table sortable"></table>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </section>
                                             </td>
                                          </tr>
                                       </table>
                                       <!--??????-->
                                       <!-- ?????? -->
                                       <div id="modal" class="searchModal">
                                          <div class="search-modal-content">
                                             <h2>??? ?????? ??????</h2>
                                             <table width="100%" class ="basic_table">
                                                <tr>
                                                   <td height="40" width="15%" class="basic_td row-color1" align="center" style="font-weight:bold;">??????</td>
                                                   <td width="35%" class="basic_td" align="left">
                                                      <input type="text" id ="multi_subject" class="input-common" style="width:100%" />
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td height="40" width="15%" class="basic_td row-color1" align="center" style="font-weight:bold;">??????</td>
                                                   <td width="35%" class="basic_td" align="left">
                                                      <input type="text" id ="multi_num" class="input-common" value="1" />
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td height="40" width="15%" class="basic_td row-color1" align="center" style="font-weight:bold;">??????</td>
                                                   <td width="35%" class="basic_td" align="left">
                                                      <input type="text" id ="multi_width" class="input-common" /><span id ="multi_width_comment"></span>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td height="40" width="15%" class="basic_td row-color1" align="center" style="font-weight:bold;">??????</td>
                                                   <td width="35%" class="basic_td" align="left">
                                                      <input type="text" id ="multi_sum" class="input-common" />
                                                      ex)tr1_td1,tr1_td2
                                                   </td>
                                                </tr>
                                             </table>
                                             <!-- <img src="<?php echo $misc;?>img/dashboard/btn/btn_cancel.png" style="cursor:pointer;float:right;margin-left:5px;margin-top:5px;" border="0" onClick="closeMultiForm();"/>
                                             <img src="<?php echo $misc;?>img/dashboard/btn/btn_add.png" style="cursor:pointer;float:right;margin-top:5px;" border="0" onClick="multiForm_save();"/><br> -->
                                             <button type="button" class="btn-common btn-color1" onClick="closeMultiForm();" style="float:right;margin-left:5px;margin-top:5px;">??????</button>
                                             <button type="button" class="btn-common btn-color2" onClick="multiForm_save();" style="float:right;margin-top:5px;">??????</button><br><br>
                                          </div>
                                       </div>
                                       <div id="line_modal" class="searchModal">
                                          <div class="search-modal-content">
                                             <h2>????????? ??????</h2>
                                             <table width="100%" class ="basic_table">
                                                <tr>
                                                   <td height="40" width="15%" class="basic_td row-color1" align="center" style="font-weight:bold;">??????</td>
                                                   <td width="35%" class="basic_td" align="left">
                                                      <input type="text" id ="line_subject" class="input-common" style="width:100%" />
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td height="40" width="15%" class="basic_td row-color1" align="center" style="font-weight:bold;">??????</td>
                                                   <td width="35%" class="basic_td" align="left">
                                                      <input type="text" id ="line_comment" class="input-common" />
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td height="40" width="15%" class="basic_td row-color1" align="center" style="font-weight:bold;">??????</td>
                                                   <td width="35%" class="basic_td" align="left">
                                                      <input type="text" id ="line_height" class="input-common" /> &nbsp; (px)
                                                   </td>
                                                </tr>

                                             </table>
                                             <!-- <img src="<?php echo $misc;?>img/dashboard/btn/btn_cancel.png" style="cursor:pointer;float:right;margin-left:5px;margin-top:5px;" border="0" onClick="closeLineModal();"/>
                                             <img src="<?php echo $misc;?>img/dashboard/btn/btn_add.png" style="cursor:pointer;float:right;margin-top:5px;" border="0" onClick="saveLineModal();"/><br> -->
                                             <button type="button" class="btn-common btn-color1" onClick="closeLineModal();" style="float:right;margin-left:5px;margin-top:5px;">??????</button>
                                             <button type="button" class="btn-common btn-color2" onClick="saveLineModal();" style="float:right;margin-top:5px;">??????</button><br><br>
                                          </div>
                                       </div>
                                       <div id="group_tree_modal" class="searchModal">
                                          <div class="search-modal-content" style='height:auto; min-height:400px;overflow: auto;'>
                                             <h2>????????? ??????</h2>
                                                <div style="margin-top:30px;height:auto; min-height:300px;overflow:auto;">
                                                   <input type="button" class="btn-common btn-color1" value="????????? ?????? ??????" style="float:right;margin-bottom:5px;width:120px;" onclick="select_user_add('all');" >
                                                   <table class="basic_table" style="width:100%;height:300px;vertical-align:middle;">
                                                      <tr>
                                                         <td class ="basic_td" width="30%">
                                                            <div id="groupTree">
                                                               <ul>
                                                                  <li>
                                                                  <span style="cursor:pointer;" id="all" onclick="groupView(this)">
                                                                     (???)?????????????????????
                                                                  </span>
                                                                  <ul>
                                                                  <?php
                                                                  foreach ( $group_data as $parentGroup ) {
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
                                                            <div id="click_group_user"></div>
                                                         </td>
                                                         <td class ="basic_td" width="10%" align="center">
                                                            <div id="user_select_delete">
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
                                                   <!-- <img src="<?php echo $misc;?>img/dashboard/btn/btn_cancel.png" style="cursor:pointer;float:right;margin-left:5px;margin-top:5px;" border="0" onClick="closeUserModal();"/>
                                                   <img src="<?php echo $misc;?>img/dashboard/btn/btn_add.png" style="cursor:pointer;float:right;margin-top:5px;" border="0" onClick="saveUserModal();"/><br> -->
                                                   <button type="button" class="btn-common btn-color1" onClick="closeUserModal();" style="float:right;margin-left:5px;margin-top:5px;">??????</button>
                                                   <button type="button" class="btn-common btn-color2" onClick="saveUserModal();" style="float:right;margin-top:5px;">??????</button><br><br>
                                                </div>
                                          </div>
                                       </div>
                                       <div id="form_save_modal" class="searchModal" >
                                          <div class="search-modal-content" style="width:50%">
                                             <h2>????????????</h2>
                                             <table id="form_save_table" width="100%" class ="basic_table">
                                                <tr>
                                                   <td width="15%"height="40" class="basic_td row-color1" align="center" style="font-weight:bold;">?????????</td>
                                                   <td width="35%" class="basic_td" align="left">
                                                      <input type="hidden" id ="form_seq" />
                                                      <input type="text" id ="form_name" class="input-common" />
                                                      <!-- <img id="form_save_btn" src="<?php echo $misc;?>img/dashboard/btn/btn_save.png" width=60 style="vertical-align:middle;cursor:pointer;" onclick="form_save(0);">
                                                      <img id="form_adjust_btn" src="<?php echo $misc;?>img/dashboard/btn/btn_adjust.png" width=60 style="vertical-align:middle;cursor:pointer;display:none;" onclick="form_save(1);">
                                                      <img id="form_save_cancel_btn" src="<?php echo $misc;?>img/dashboard/btn/btn_cancel.png" style="vertical-align:middle;cursor:pointe;display:none;" border="0" width=60 onclick="form_change_cancel();" /> -->
                                                      <button id="form_save_btn" type="button" class="btn-common btn-style1" onclick="form_save(0);" style="vertical-align:middle;cursor:pointer;float:right;">??????</button>
                                                      <button id="form_adjust_btn" type="button" class="btn-common btn-color2" onclick="form_save(1);" style="vertical-align:middle;cursor:pointer;display:none;float:right;width:60px">??????</button>
                                                      <button id="form_save_cancel_btn" type="button" class="btn-common btn-color1" onclick="form_change_cancel();" style="vertical-align:middle;cursor:pointer;display:none;float:right;margin-right:10px;width:60px">??????</button>
                                                   </td>
                                                </tr>
                                             </table>
                                             <table id="form_management_list" width="100%" class ="basic_table" style="margin-top:50px;">
                                                <tr bgcolor="#f8f8f9">
                                                   <td width="15%" height="40" class="basic_td" align="center" style="font-weight:bold;"></td>
                                                   <td width="15%" class="basic_td" align="center" style="font-weight:bold;">?????????</td>
                                                   <td width="15%" class="basic_td" align="center" style="font-weight:bold;"> </td>
                                                </tr>
                                                <?php
                                                if(!empty($form_management)){
                                                   foreach($form_management as $form_m){ ?>
                                                      <tr>
                                                         <td width="15%" height="40" class="basic_td" align="center" style="font-weight:bold;">
                                                            <input type="checkbox" name="form_seq" value="<?php echo $form_m['seq']; ?>" />
                                                         </td>
                                                         <td width="15%" class="basic_td" align="center" style="font-weight:bold;"><?php echo $form_m['form_name']; ?></td>
                                                         <td width="15%" class="basic_td" align="center"  style="font-weight:bold;vertical-align:middle;">
                                                         <textarea name="form_html" style="display:none;"><?php echo $form_m['form_table_html']; ?></textarea>

                                                         <!-- <img src="<?php echo $misc;?>img/dashboard/btn/btn_apply.png" style="cursor:pointer" border="0" width=60 onclick="form_apply(this);"/>
                                                         <img src="<?php echo $misc;?>img/dashboard/btn/btn_adjust.png" style="cursor:pointer" border="0" width=60 onclick="form_change(<?php echo $form_m['seq']; ?>,'<?php echo $form_m['form_name']; ?>')" /> -->
                                                         <button type="button" class="btn-common btn-color1" onclick="form_apply(this);" style="width:60px;">??????</button>
                                                         <button type="button" class="btn-common btn-color2" onclick="form_change(<?php echo $form_m['seq']; ?>,'<?php echo $form_m['form_name']; ?>')" style="width:60px;">??????</button>
                                                         </td>
                                                      </tr>
                                                <?php
                                                   }
                                                }else{
                                                   echo "<tr><td height='40' colspan=3 align='center'> - ?????? ????????? ???????????? ????????????.</td></tr>";
                                                }
                                                ?>
                                             </table>
                                             <table style="width:100%;margin-top:30px;">
                                                <tr>
                                                   <td align="right">
                                                      <!-- <img src="<?php echo $misc;?>img/dashboard/btn/btn_delete.png" style="cursor:pointer;" border="0" onclick="form_save(2);"/>
                                                      <img src="<?php echo $misc;?>img/dashboard/btn/btn_cancel.png" style="cursor:pointer;" border="0" onClick="$('#form_save_modal').hide();"/> -->
                                                      <button type="button" class="btn-common btn-color1" onclick="form_save(2);">??????</button>
                                                      <button type="button" class="btn-common btn-color1" onClick="$('#form_save_modal').hide();">??????</button>
                                                   </td>
                                                </tr>
                                             </table>
                                          </div>
                                       </div>
                                       <!-- ????????? -->
                                    </td>
                                    <?php }else{?>
                                    <td width="100%" align="center" valign="top">
                                       <!--??????-->
                                       <input type="hidden" id="seq" name="seq" value="<?php echo $view_val['seq']; ?>">
                                       <table width="100%" border="0" style="margin-top:50px; margin-bottom: 50px;">
                                          <tr>
                                             <td>
                                                <section class="tabs" style="width:100%">
                                                   <input id="tab-1" type="radio" name="radio-set" class="tab-selector-1 tabs_input" checked="checked">
                                                   <label for="tab-1" class="tab-label-1">????????????</label>
                                                   <input id="tab-2" type="radio" name="radio-set" class="tab-selector-2 tabs_input" onclick="approval_info_save_check();">
                                                   <label for="tab-2" class="tab-label-2">????????????</label>
                                                   <div class="clear-shadow"></div>
                                                   <div class="content">
                                                      <div class="content-1">
                                                         <input type="hidden" id="approval_info_check" name="approval_info_check" value="Y" />
                                                         <input type="hidden" id="form_table_html" name="form_table_html" />
                                                         <input type="hidden" id="preview_html" name="preview_html" />
                                                         <input type="button" class="btn-common btn-color2" value="??????" onClick="approval_info_save();" style="float:right;">
                                                         <input type="button" class="btn-common btn-color1" value="??????" onClick="location.href='<?php echo site_url(); ?>/biz/approval/electronic_approval_form_list?mode=admin';" style="float:right;margin-right:10px;">
                                                         <h3>?????? ??????</h3>
                                                         <table width="100%" class ="basic_table">
                                                            <tr >
                                                               <td height="40" width="15%" class="basic_td row-color1" align="center" style="font-weight:bold;" >
                                                                  <span style="color:red;" > * </span>?????????
                                                               </td>
                                                               <td width="35%" class="basic_td" align="left" style="font-weight:bold;" >
                                                                  <input type="text" class="input-common" id="template_name" name="template_name" value="<?php echo $view_val['template_name']; ?>" onchange="$('#approval_info_check').val('N');" />
                                                               </td>
                                                               <td width="15%" class="basic_td row-color1" align="center" style="font-weight:bold;" >
                                                                  <span style="color:red;"> * </span>?????????
                                                               </td>
                                                               <td width="35%" class="basic_td" align="left" style="font-weight:bold;" >
                                                                  <select class="select-common" style="width:250px;" id="template_category" name="template_category" onchange = "$('#approval_info_check').val('N');">
                                                                     <option value="">?????????</option>
                                                                     <?php foreach($category as $format_categroy){
                                                                        echo "<option value='{$format_categroy['seq']}'";
                                                                        if($view_val['template_category'] == $format_categroy['seq']){
                                                                           echo "selected";
                                                                        }
                                                                        echo ">{$format_categroy['category_name']}</option>";
                                                                     } ?>
                                                                  </select>
                                                               </td>
                                                            </tr>
                                                            <tr >
                                                               <td height="40" width="15%" class="basic_td row-color1" align="center" style="font-weight:bold;" >
                                                                  ????????????
                                                               </td>
                                                               <td width="35%" class="basic_td" align="left" style="font-weight:bold;" >
                                                                  <input type="radio" name="template_type" value="????????????" onclick="$('#approval_info_check').val('N');" <?php if($view_val['template_type'] == "????????????"){echo 'checked';} ?>  />????????????
                                                                  <input type="radio" name="template_type" value="?????????" onclick="$('#approval_info_check').val('N');" <?php if($view_val['template_type'] == "?????????"){echo 'checked';} ?> />?????????
                                                               </td>
                                                               <td height="40" width="15%" class="basic_td row-color1" align="center" style="font-weight:bold;" >
                                                                  ????????????
                                                               </td>
                                                               <td width="35%" class="basic_td" align="left" style="font-weight:bold;" >
                                                                  <input type="radio" name="template_use" value="Y" onclick="$('#approval_info_check').val('N');" <?php if($view_val['template_use'] == "Y"){echo 'checked';} ?>  />???
                                                                  <input type="radio" name="template_use" value="N" onclick="$('#approval_info_check').val('N');" <?php if($view_val['template_use'] == "N"){echo 'checked';} ?> />???
                                                               </td>
                                                            </tr>
                                                            <tr >
                                                               <td height="40" width="15%" class="basic_td row-color1" align="center" style="font-weight:bold;" >
                                                                  ????????????
                                                               </td>
                                                               <td width="35%" class="basic_td" align="left" style="font-weight:bold;" >
                                                                  <input type="text" id="template_sort_seq" name="template_sort_seq" class="input-common" style="width:100px;" value="<?php echo $view_val['template_sort_seq'] ;?>" onchange="$('#approval_info_check').val('N');" />&nbsp * ????????? ?????? ??? ???????????? ????????? ?????? ??????, ????????? ?????? ?????? ????????? ?????????.
                                                               </td>
                                                               <td height="40" width="15%" class="basic_td row-color1" align="center" style="font-weight:bold;" >
                                                                  ????????????
                                                               </td>
                                                               <td width="35%" class="basic_td" align="left" >
                                                                 <input type="radio" name="official_doc" value="N" <?php if($view_val['official_doc']=="N"){echo 'checked="checked"';} ?> />?????????
                                                                 <input type="radio" name="official_doc" value="Y" <?php if($view_val['official_doc']=="Y"){echo 'checked="checked"';} ?> />??????
                                                               </td>
                                                            </tr>
                                                            <tr >
                                                               <td width="15%" class="basic_td row-color1" align="center" style="font-weight:bold;" >
                                                                  <span style="color:red;"> * </span>????????????
                                                               </td>
                                                               <td height="60" colspan=3 width="35%" class="basic_td" align="left" style="font-weight:bold;" >
                                                                  <textarea id="template_explanation" name="template_explanation" class="textarea-common" style="height:85%;width:100%" onchange="$('#approval_info_check').val('N');"><?php echo $view_val['template_explanation'] ;?></textarea>
                                                               </td>
                                                            </tr>
                                                         </table>
                                                         <h3>????????? ??????</h3>
                                                         <table width="100%" class ="basic_table">
                                                            <tr >
                                                               <td width="15%" class="basic_td row-color1" align="center" style="font-weight:bold;" >
                                                                  ???????????????
                                                               </td>
                                                               <td width="85%" height="40" colspan=3 class="basic_td" align="left" style="font-weight:bold;" >
                                                                  <select id="default_approval_line" name="default_approval_line" class="select-common" onchange="click_user_approval_line(this.value);$('#approval_info_check').val('N');" style="width:256px;">
                                                                     <option value="N" <?php if($view_val['default_approval_line'] == "N"){echo 'selected';} ?>>????????? ?????? ??????(????????? ?????? ??? ??????)</option>
                                                                     <?php foreach($approver_line as $al){
                                                                        echo "<option value='{$al['seq']}'";
                                                                        if($view_val['default_approval_line'] == $al['seq'] ){
                                                                           echo 'selected';
                                                                        }
                                                                        echo ">{$al['approval_line_name']}</option>";
                                                                     }?>
                                                                  </select>
                                                                  <table id="select_approver" width="90%" class="basic_table sortable" style='text-align:center;'>
                                                                  </table>
                                                               </td>
                                                            </tr>
                                                         </table>
                                                         <h3>????????????</h3>
                                                         <table width="100%" class ="basic_table">
                                                            <tr >
                                                               <td width="15%" class="basic_td row-color1" align="center" style="font-weight:bold;" >
                                                                  ?????? ?????????
                                                               </td>
                                                               <td width="85%" height=40 colspan=3 class="basic_td" align="left" style="font-weight:bold;" >
                                                                  <input id="default_referrer" name="default_referrer" type="text" class="input-common" style="width:95%;" value="<?php echo $view_val['default_referrer']; ?>" onchange="$('#approval_info_check').val('N');" />
                                                                  <img src="<?php echo $misc;?>img/btn_add.jpg" style="cursor:pointer;vertical-align:middle;" border="0" onClick="select_user('default_referrer');"/>
                                                               </td>
                                                            </tr>
                                                         </table><br>
                                                         <!-- <img src="<?php echo $misc;?>img/dashboard/btn/btn_cancel.png" style="cursor:pointer;float:right;margin-left:5px;" border="0" onClick="location.href= '<?php echo site_url(); ?>/biz/approval/electronic_approval_form_list?mode=admin';"/>
                                                         <img src="<?php echo $misc;?>img/dashboard/btn/btn_save.png" style="cursor:pointer;float:right;margin-left:5px;" border="0" onClick="approval_info_save();"/><br> -->
                                                         <input type="button" class="btn-common btn-color2" value="??????" onClick="approval_info_save();" style="float:right;">
                                                         <input type="button" class="btn-common btn-color1" value="??????" onClick="location.href= '<?php echo site_url(); ?>/biz/approval/electronic_approval_form_list?mode=admin';" style="float:right;margin-right:10px;">
                                                      </div>
                                                      <div class="content-2">
                                                         <!-- <img src="<?php echo $misc;?>img/dashboard/btn/btn_delete.png" style="cursor:pointer;float:right;margin-left:5px;" border="0" onClick="template_delete();"/>
                                                         <img src="<?php echo $misc;?>img/dashboard/btn/btn_cancel.png" style="cursor:pointer;float:right;margin-left:5px;" border="0" onClick="location.href= '<?php echo site_url(); ?>/biz/approval/electronic_approval_form_list?mode=admin';"/>
                                                         <img src="<?php echo $misc;?>img/dashboard/btn/btn_save.png" style="cursor:pointer;float:right;margin-left:5px;" border="0" onClick="template_info_save();"/><br> -->
                                                         <input type="button" class="btn-common btn-color2" style="float:right;" value="??????" onClick="template_info_save();">
                                                         <input type="button" class="btn-common btn-color1" style="float:right;margin-right:10px;" value="??????" onClick="location.href= '<?php echo site_url(); ?>/biz/approval/electronic_approval_form_list?mode=admin';">
                                                         <input type="button" class="btn-common btn-color1" style="float:right;margin-right:10px;" value="??????" onClick="template_delete();">
                                                         <h3>????????????</h3>
                                                         <table width="100%" class ="basic_table">
                                                            <tr >
                                                               <td height="40" width="15%" class="basic_td row-color1" align="center" style="font-weight:bold;" >
                                                                  ?????????
                                                               </td>
                                                               <td colspan=3 width="85%" class="basic_td" align="left" style="font-weight:bold;" >
                                                                  <input type="radio" name="editor_use" value="Y" <?php if($view_val['editor_use'] == "Y"){echo 'checked';} ?>/>??????
                                                                  <input type="radio" name="editor_use" value="N" <?php if($view_val['editor_use'] == "N"){echo 'checked';} ?> />?????????
                                                               </td>
                                                            </tr>
                                                            <tr >
                                                               <td height="60" width="15%" class="basic_td row-color1" align="center" style="font-weight:bold;" >
                                                                  ???????????????
                                                               </td>
                                                               <td height="60" colspan=3 width="85%" class="basic_td" align="left" style="font-weight:bold;" >
                                                                  <textarea id="writing_guide" name="writing_guide" class="textarea-common" style="height:85%;width:100%;"><?php echo $view_val['writing_guide']; ?></textarea>
                                                               </td>
                                                            </tr>
                                                         </table>
                                                         <h3>?????? ?????????</h3>
                                                         <div class="content-2" style="width:100%">
                                                            <input type="button" class="btn-common btn-color1" value="?????????" onclick="reset();" style="margin-bottom:5px;">
                                                            <input type="button" class="btn-common btn-color1" value="????????????" onclick="preview();" style="margin-bottom:5px;">
                                                            <input type="button" class="btn-common btn-color2" value="??????????????? ??????" onclick="form_save_modal_open();" style="margin-bottom:5px;width:110px;">
                                                            <span style="float:right;">
                                                               <img src="<?php echo $misc;?>img/input.png" width="23" style="vertical-align:middle"> ?????????
                                                               <img src="<?php echo $misc;?>img/textbox.png" width="23" style="vertical-align:middle"> ???????????????
                                                               <img src="<?php echo $misc;?>img/select.png" width="20" style="vertical-align:middle"> ?????????
                                                               <img src="<?php echo $misc;?>img/radio.png" width="20" style="vertical-align:middle"> ?????????
                                                               <img src="<?php echo $misc;?>img/checkbox.png" width="20" style="vertical-align:middle"> ????????????
                                                               <img src="<?php echo $misc;?>img/writebox.png" width="20" style="vertical-align:middle"> ?????????
                                                               <img src="<?php echo $misc;?>img/component.png" width="20" style="vertical-align:middle"> ????????????
                                                               <img src="<?php echo $misc;?>img/line.png" width="20" style="vertical-align:middle"> ?????????
                                                            </span>
                                                            <br><br>
                                                            <?php for($i=1; $i<=10; $i++){
                                                               echo "<input type='button' class='form_btn' value='{$i}???' style='margin-left:2px;' onclick='form_add($i);'>";
                                                            } ?>
                                                            <input type="button" class='form_btn' value="?????????" style='margin-left:2px;' onclick="form_add('line');" />

                                                            <div class="content-2" style="width:100%">

                                                               <?php if($view_val['form_table_html'] != ""){//modify
                                                                  echo $view_val['form_table_html'];
                                                                }else{
                                                                  echo '<table id="form_table" width="80%" class ="basic_table sortable"></table>';
                                                                } ?>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </section>
                                             </td>
                                          </tr>
                                       </table>
                                       <!--??????-->
                                       <!-- ?????? -->
                                       <div id="modal" class="searchModal">
                                          <div class="search-modal-content">
                                             <h2>??? ?????? ??????</h2>
                                             <table width="100%" class ="basic_table">
                                                <tr>
                                                   <td height="40" width="15%" class="basic_td row-color1" align="center" style="font-weight:bold;">??????</td>
                                                   <td width="35%" class="basic_td" align="left">
                                                      <input type="text" id ="multi_subject" class="input-common" style="width:100%" />
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td height="40" width="15%" class="basic_td row-color1" align="center" style="font-weight:bold;">??????</td>
                                                   <td width="35%" class="basic_td" align="left">
                                                      <input type="text" id ="multi_num" class="input-common" value="1" />
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td height="40" width="15%" class="basic_td row-color1" align="center" style="font-weight:bold;">??????</td>
                                                   <td width="35%" class="basic_td" align="left">
                                                      <input type="text" id ="multi_width" class="input-common" /><span id ="multi_width_comment"></span>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td height="40" width="15%" class="basic_td row-color1" align="center" style="font-weight:bold;">??????</td>
                                                   <td width="35%" class="basic_td" align="left">
                                                      <input type="text" id ="multi_sum" class="input-common" />
                                                      ex)tr1_td1,tr1_td2
                                                   </td>
                                                </tr>
                                             </table>
                                             <!-- <img src="<?php echo $misc;?>img/dashboard/btn/btn_cancel.png" style="cursor:pointer;float:right;margin-left:5px;margin-top:5px;" border="0" onClick="closeMultiForm();"/>
                                             <img src="<?php echo $misc;?>img/dashboard/btn/btn_add.png" style="cursor:pointer;float:right;margin-top:5px;" border="0" onClick="multiForm_save();"/><br> -->
                                             <button type="button" class="btn-common btn-color1" onClick="closeMultiForm();" style="float:right;margin-left:5px;margin-top:5px;">??????</button>
                                             <button type="button" class="btn-common btn-color2" onClick="multiForm_save();" style="float:right;margin-top:5px;">??????</button><br><br>
                                          </div>
                                       </div>
                                       <div id="line_modal" class="searchModal">
                                          <div class="search-modal-content">
                                             <h2>????????? ??????</h2>
                                             <table width="100%" class ="basic_table">
                                                <tr>
                                                   <td height="40" width="15%" class="basic_td row-color1" align="center" style="font-weight:bold;">??????</td>
                                                   <td width="35%" class="basic_td" align="left">
                                                      <input type="text" id ="line_subject" class="input-common" style="width:100%" />
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td height="40" width="15%" class="basic_td row-color1" align="center" style="font-weight:bold;">??????</td>
                                                   <td width="35%" class="basic_td" align="left">
                                                      <input type="text" id ="line_comment" class="input-common" />
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td height="40" width="15%" class="basic_td row-color1" align="center" style="font-weight:bold;">??????</td>
                                                   <td width="35%" class="basic_td" align="left">
                                                      <input type="text" id ="line_height" class="input-common" /> &nbsp; (px)
                                                   </td>
                                                </tr>

                                             </table>
                                             <!-- <img src="<?php echo $misc;?>img/dashboard/btn/btn_cancel.png" style="cursor:pointer;float:right;margin-left:5px;margin-top:5px;" border="0" onClick="closeLineModal();"/>
                                             <img src="<?php echo $misc;?>img/dashboard/btn/btn_add.png" style="cursor:pointer;float:right;margin-top:5px;" border="0" onClick="saveLineModal();"/><br> -->
                                             <button type="button" class="btn-common btn-color1" onClick="closeLineModal();" style="float:right;margin-left:5px;margin-top:5px;">??????</button>
                                             <button type="button" class="btn-common btn-color2" onClick="saveLineModal();" style="float:right;margin-top:5px;">??????</button><br><br>
                                          </div>
                                       </div>
                                       <div id="group_tree_modal" class="searchModal">
                                          <div class="search-modal-content" style='height:auto; min-height:400px;overflow: auto;'>
                                             <h2>????????? ??????</h2>
                                                <div style="margin-top:30px;height:auto; min-height:300px;overflow:auto;">
                                                   <input type="button" class="btn-common btn-color1" value="????????? ?????? ??????" style="float:right;margin-bottom:5px;width:120px;" onclick="select_user_add('all');" >
                                                   <table class="basic_table" style="width:100%;height:300px;vertical-align:middle;">
                                                      <tr>
                                                         <td class ="basic_td" width="30%">
                                                            <div id="groupTree">
                                                               <ul>
                                                                  <li>
                                                                  <span style="cursor:pointer;" id="all" onclick="groupView(this)">
                                                                     (???)?????????????????????
                                                                  </span>
                                                                  <ul>
                                                                  <?php
                                                                  foreach ( $group_data as $parentGroup ) {
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
                                                            <div id="click_group_user"></div>
                                                         </td>
                                                         <td class ="basic_td" width="10%" align="center">
                                                            <div id="user_select_delete">
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
                                                   <!-- <img src="<?php echo $misc;?>img/dashboard/btn/btn_cancel.png" style="cursor:pointer;float:right;margin-left:5px;margin-top:5px;" border="0" onClick="closeUserModal();"/>
                                                   <img src="<?php echo $misc;?>img/dashboard/btn/btn_add.png" style="cursor:pointer;float:right;margin-top:5px;" border="0" onClick="saveUserModal();"/><br> -->
                                                   <button type="button" class="btn-common btn-color1" onClick="closeUserModal();" style="float:right;margin-left:5px;margin-top:5px;">??????</button>
                                                   <button type="button" class="btn-common btn-color2" onClick="saveUserModal();" style="float:right;margin-top:5px;">??????</button><br><br>
                                                </div>
                                          </div>
                                       </div>
                                       <div id="form_save_modal" class="searchModal">
                                          <div class="search-modal-content" style="width:50%">
                                             <h2>????????????</h2>
                                             <table id="form_save_table" width="100%" class ="basic_table">
                                                <tr>
                                                   <td width="15%"height="40" class="basic_td row-color1" align="center" style="font-weight:bold;">?????????</td>
                                                   <td width="35%" class="basic_td" align="left">
                                                      <input type="hidden" id ="form_seq" />
                                                      <input type="text" id ="form_name" class="input-common" />
                                                      <!-- <img id="form_save_btn" src="<?php echo $misc;?>img/dashboard/btn/btn_save.png" width=60 style="vertical-align:middle;cursor:pointer;" onclick="form_save(0);">
                                                      <img id="form_adjust_btn" src="<?php echo $misc;?>img/dashboard/btn/btn_adjust.png" width=60 style="vertical-align:middle;cursor:pointer;display:none;" onclick="form_save(1);">
                                                      <img id="form_save_cancel_btn" src="<?php echo $misc;?>img/dashboard/btn/btn_cancel.png" style="vertical-align:middle;cursor:pointer;display:none;" border="0" width=60 onclick="form_change_cancel();" /> -->
                                                      <button id="form_save_btn" type="button" class="btn-common btn-style1" onclick="form_save(0);" style="vertical-align:middle;cursor:pointer;float:right;">??????</button>
                                                      <button id="form_adjust_btn" type="button" class="btn-common btn-color2" onclick="form_save(1);" style="vertical-align:middle;cursor:pointer;display:none;float:right;width:60px">??????</button>
                                                      <button id="form_save_cancel_btn" type="button" class="btn-common btn-color1" onclick="form_change_cancel();" style="vertical-align:middle;cursor:pointer;display:none;float:right;margin-right:10px;width:60px">??????</button>
                                                   </td>
                                                </tr>
                                             </table>
                                             <table id="form_management_list" width="100%" class ="basic_table" style="margin-top:50px;">
                                                <tr bgcolor="#f8f8f9">
                                                   <td width="15%" height="40" class="basic_td" align="center" style="font-weight:bold;"></td>
                                                   <td width="15%" class="basic_td" align="center" style="font-weight:bold;">?????????</td>
                                                   <td width="15%" class="basic_td" align="center" style="font-weight:bold;"> </td>
                                                </tr>
                                                <?php
                                                if(!empty($form_management)){
                                                   foreach($form_management as $form_m){ ?>
                                                      <tr>
                                                         <td width="15%" height="40" class="basic_td" align="center" style="font-weight:bold;">
                                                            <input type="checkbox" name="form_seq" value="<?php echo $form_m['seq']; ?>" />
                                                         </td>
                                                         <td width="15%" class="basic_td" align="center" style="font-weight:bold;"><?php echo $form_m['form_name']; ?></td>
                                                         <td width="15%" class="basic_td" align="center"  style="font-weight:bold;vertical-align:middle;">
                                                         <textarea name="form_html" style="display:none;"><?php echo $form_m['form_table_html']; ?></textarea>

                                                         <!-- <img src="<?php echo $misc;?>img/dashboard/btn/btn_apply.png" style="cursor:pointer" border="0" width=60 onclick="form_apply(this);"/>
                                                         <img src="<?php echo $misc;?>img/dashboard/btn/btn_adjust.png" style="cursor:pointer" border="0" width=60 onclick="form_change(<?php echo $form_m['seq']; ?>,'<?php echo $form_m['form_name']; ?>')" /> -->
                                                         <button type="button" class="btn-common btn-color1" onclick="form_apply(this);" style="width:60px;">??????</button>
                                                         <button type="button" class="btn-common btn-color2" onclick="form_change(<?php echo $form_m['seq']; ?>,'<?php echo $form_m['form_name']; ?>')" style="width:60px;">??????</button>
                                                         </td>
                                                      </tr>
                                                <?php
                                                   }
                                                }else{
                                                   echo "<tr><td height='40' colspan=3 align='center'> - ?????? ????????? ???????????? ????????????.</td></tr>";
                                                }
                                                ?>
                                             </table>
                                             <table style="width:100%;margin-top:30px;">
                                                <tr>
                                                   <td align="right">
                                                      <!-- <img src="<?php echo $misc;?>img/dashboard/btn/btn_delete.png" style="cursor:pointer;" border="0" onclick="form_save(2);"/>
                                                      <img src="<?php echo $misc;?>img/dashboard/btn/btn_cancel.png" style="cursor:pointer;" border="0" onClick="$('#form_save_modal').hide();"/> -->
                                                      <button type="button" class="btn-common btn-color1" onclick="form_save(2);">??????</button>
                                                      <button type="button" class="btn-common btn-color1" onClick="$('#form_save_modal').hide();">??????</button>
                                                   </td>
                                                </tr>
                                             </table>

                                             <!-- <img src="<?php echo $misc;?>img/dashboard/btn/btn_cancel.png" style="cursor:pointer;float:right;margin-left:5px;margin-top:5px;margin-bottom:5px;" border="0" onClick="$('#form_save_modal').hide();"/>
                                             <img src="<?php echo $misc;?>img/dashboard/btn/btn_delete.png" style="cursor:pointer;float:right;margin-top:5px;margin-bottom:5px;" border="0" onclick="form_save(2);"/><br> -->
                                          </div>
                                       </div>
                                       <!-- ????????? -->
                                    </td>
                                    <?php } ?>
                                 </tr>
                              </table>
                           </td>
                        </tr>
                     <div class="popupLayer">
                        <div style="float:left;width:50%;">
                           <input type="hidden" id="popup_td" value="" />
                           <div width="50px" class="popup_menu" style="cursor:pointer;" onclick="openMultiForm();">??????</div>
                           <div width="50px" class="popup_menu" id="multi_delete_btn" style="cursor:pointer;display:none;" onclick="deleteMultiForm();">????????????</div>
                           <div width="50px" class="popup_menu" style="cursor:pointer;" onclick="add_item();">item??????</div>
                           <div width="50px" class="popup_menu" style="cursor:pointer;" onclick="delete_item('td');">item??????</div>
                           <div width="50px" class="popup_menu" style="cursor:pointer;" onclick="element_change('left');">??????</div>
                           <div width="50px" class="popup_menu" style="cursor:pointer;" onclick="element_change('right');">?????????</div>
                           <div width="50px" class="popup_menu" style="cursor:pointer;" onclick="delete_item('row');">??? ??????</div>
                        </div>
                        <div id='template_info' style="float:left;width:50%;">
                        </div>
                     </div>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<!--??????-->
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
<!--??????-->
<script>
   if("<?php echo $mode; ?>" == "input"){
      var trLength = 1;
   }else{
      if($("#form_table").find($("tr")).length == 0){
         var trLength = 1
      }else{
         var tr_id=[];
         for(i=0; i<$("#form_table").find($("tr")).length; i++){
            tr_id[i] = Number($("#form_table").find($("tr")).eq(i).attr('id').replace("tr",""));
         }
         var trLength = Math.max.apply(null,tr_id)+1;
      }
   }

   //????????????
   function form_add(add_num){
      if(add_num != 'line'){
         var add_html = "<tr id='tr"+trLength+"' style='cursor:pointer'>";
         var col = 100 / add_num;
         for(i=1; i<=add_num; i++){
            add_html += "<td height='40' id='tr"+trLength+"_td"+i+"' colspan='"+col+"' align='center' class='basic_td'><span style='cursor:pointer;' onclick='openPopup(this);' onmousedown='others(event,this);'>????????????</span></td>";
         }
         add_html += "</tr>";
         $("#form_table").html($("#form_table").html()+add_html);
      }else{
         var add_html = "<tr id='tr"+trLength+"' style='cursor:pointer'><td height='40' id='tr"+trLength+"_td1' colspan='100' align='center' class='basic_td'><span style='cursor:pointer;' onclick='openLineModal(this);' onmousedown='others(event,this);'>?????????</span></td></tr>";
         $("#form_table").html($("#form_table").html()+add_html);
      }
      trLength++
   }

   //??????~
   function openPopup(obj){

      var mform = document.cform;
      var parentId = $(obj).parent().attr('id');

      var tr = $("#"+parentId).closest("tr");
      if(tr.find($("input[name=multi_row]")).length > 0){
         var multi = "Y"
      }else{
         var multi = "N"
      }

      var template = $("#"+parentId).find($("input[name=template]")).val();
      if(template != undefined){
         template = template;
      }else{
         template='';
      }

      mform.popup_id.value = parentId;
      mform.popup_multi.value = multi;
      mform.popup_template.value = template;

      window.open("", "popup_window", "width = 1200, height = 500, top = 100, left = 400, location = no,status=no,status=no,toolbar=no,scrollbars=no");
      mform.submit();
		return false;
   }

   //??????????????? ????????? ??????  ?????? ?????????
   function others(e,obj){
      document.addEventListener('contextmenu', function() {
         event.preventDefault();
      });
      if ((e.button == 2) || (e.which == 3)) {
         var sWidth = window.innerWidth;
         var sHeight = window.innerHeight;

         var oWidth = $('.popupLayer').width();
         var oHeight = $('.popupLayer').height();

         // ???????????? ????????? ????????? ????????????.
         var divLeft = $("#form_table").offset().left + $("#form_table").width() + 30;

         var divTop = $("#form_table").offset().top + 5;

         //????????? ????????? ???????????? ???????????? ?????? td ????????? ??????
         if($(obj).closest('td').css('background-color') == "rgba(0, 0, 0, 0)" || $(obj).closest('td').css('background-color') == "transparent"){
            $(obj).closest('td').css('background-color','#666666');
            var click_td = $(obj).closest('td');
            $("#form_table").find('td').not(click_td).css('background-color','');
            $('.popupLayer').show();
         }else{
            $(obj).closest('td').css('background-color','');
            $('.popupLayer').hide();
         }

         $("#popup_td").val($(obj).closest('td').attr('id'));//?????? ?????? td ???????????????

         template_info_change(); // template ?????? ????????????

         //?????? ????????? ???????????? ?????? show()
         var tr = $("#"+$("#popup_td").val()).closest('tr');
         var multiLength = tr.find($('input[name=multi_row]')).length;
         if(multiLength > 0){
            $("#multi_delete_btn").show();
         }else{
            $("#multi_delete_btn").hide();
         }

         $('.popupLayer').css({
            "top": divTop,
            "left": divLeft,
            "position": "absolute"
         })
      }
   }

   //sortable tr ????????????
   $(".sortable").sortable({

   });

   //td ????????? ??????
   function element_change(direction){
      if(direction == "left"){//?????? ?????????
         $("#"+$("#popup_td").val()).prev().before($("#"+$("#popup_td").val()));
      }else{//????????????
         $("#"+$("#popup_td").val()).next().after($("#"+$("#popup_td").val()));
      }
   }

   //????????? ??????
   function add_item(){
      var tr = $("#"+$("#popup_td").val()).closest('tr');
      var tr_num = $(tr).attr('id').replace('tr','');
      var tdLength = tr.find('td').length; // tr?????? ?????? td ??????
      var col = 100/(tdLength+1);
      var add_html = "<td height='40' id='tr"+tr_num+"_td"+(tdLength+1)+"' colspan='"+col+"' align='center' class='basic_td'><span style='cursor:pointer;' onclick='openPopup(this);' onmousedown='others(event,this);'>????????????</span></td>";
      $(tr).append(add_html);
      $(tr).find('td').attr("colspan",col);
   }

   //????????? ??????
   function delete_item(type){
      var tr = $("#"+$("#popup_td").val()).closest('tr');
      if(type == 'td'){
         var tdLength = tr.find('td').length;
         if(tdLength == 1){ // ?????? ?????? td ????????? ?????? tr ??????
            $(tr).remove();
         }else{
            $("#"+$("#popup_td").val()).remove(); // ?????? td ??????
            var tdLength = tr.find('td').length; // tr?????? ?????? td ??????
            var col = 100/(tdLength-1);
            $(tr).find('td').attr("colspan",col);//colspan ??????
         }
      }else{
         $(tr).remove();
      }
      $('.popupLayer').hide();
   }

   //????????? ??????
   function openMultiForm(){
      var multi_check = true;
      var tr = $("#"+$("#popup_td").val()).closest('tr');
      var column_length = tr.find($("td")).length;
      var width_comment = "  ex)?????????("+column_length+")+??????=";
      for(i=0; i<column_length; i++){
         width_comment += (90/column_length)+',';
      }
      width_comment += "10";
      $("#multi_width_comment").text(width_comment);
      for(i=0; i<tr.find($("input[name=template]")).length; i++){
         var template_type = tr.find($("input[name=template]")).eq(i).val().split('|');
         if(template_type[0] != 1 && template_type[0] != 3){
            multi_check = false;
         }
      }
      if(multi_check == true){
         var multiLength = tr.find($('input[name=multi_row]')).length;
         $("#modal").find($('input')).val(''); //input??? ????????????~!
         $("#multi_num").val(1)
         if(multiLength == 0){
            $("#modal").show();
         }else{
            var multi_info = tr.find($('input[name=multi_row]')).val().split('|');
            $("#multi_subject").val(multi_info[0]);
            if(multi_info[1] != ''){
               $("#multi_num").val(multi_info[1]);
            }

            $("#multi_width").val(multi_info[2]);
            $("#multi_sum").val(multi_info[3]);
            $("#modal").show();
         }
      }else{
         alert("????????? ???????????? ?????????????????? ???????????????.");
         $("#"+$("#popup_td").val()).css('background-color','');
         $('.popupLayer').hide();
      }
   }

   //????????? ??????
   function closeMultiForm() {
      var check = confirm("??? ??????????????? ?????????????????????? ???????????? ????????? ?????? ?????? ????????????.")
      if(check == true){
         $("#modal").hide();
         $('.popupLayer').hide();
      }else{
         return false;
      }
   };

   //????????? ??????
   function multiForm_save(){
      var tr = $("#"+$("#popup_td").val()).closest('tr');

      var multi_subject = $("#multi_subject").val();
      var multi_num = $("#multi_num").val();
      var multi_width = $("#multi_width").val();
      var multi_sum = $("#multi_sum").val();

      var multi_info = multi_subject +'|'+ multi_num +'|'+ multi_width +'|'+ multi_sum;

      var multiLength = tr.find($('input[name=multi_row]')).length;
      if(multiLength == 0){//?????? ?????????
         var txt = "<input type='hidden' name='multi_row' value='"+multi_info+"'>";
         tr.html(tr.html()+txt);
      }else{
         tr.find($('input[name=multi_row]')).val(multi_info);
      }

      $("#modal").hide();
      $('.popupLayer').hide();
   }

   //????????? ??????
   function deleteMultiForm(){
      var tr = $("#"+$("#popup_td").val()).closest('tr');
      var check = confirm("????????? ?????????????????????????");
      if(check == true){
         tr.find($('input[name=multi_row]')).remove();
         $('.popupLayer').hide();
      }else{
         return false;
      }
   }

   //????????? ?????? ??????
   function openLineModal(obj){
      var td = $(obj).closest('td').attr('id');

      $("#popup_td").val(td);

      var tr = $("#"+$("#popup_td").val()).closest('tr');
      var templateLength = tr.find($('input[name=template]')).length;
      $("#line_modal").find($('input')).val('');
      if(templateLength == 0){
         $("#line_modal").show();
      }else{
         var template_info = tr.find($('input[name=template]')).val().split('|');
         $("#line_subject").val(template_info[1]);
         $("#line_comment").val(template_info[2]);
         $("#line_height").val(template_info[3]);
         $("#line_modal").show();
      }

   }

   //????????? ?????? ??????
   function closeLineModal(){
      var check = confirm("??? ??????????????? ?????????????????????? ???????????? ????????? ?????? ?????? ????????????.")
      if(check == true){
         $("#line_modal").hide();
         $('.popupLayer').hide();
      }else{
         return false;
      }
   }

   //????????? ?????? ??????
   function saveLineModal(){
      var td = $("#"+$("#popup_td").val());
      var tr = td.closest('tr');
      var tr_row = tr.attr('id').replace('tr','');

      var line_subject = $("#line_subject").val();
      var line_comment = $("#line_comment").val();
      var line_height = $("#line_height").val();

      var line_info = '0' + '|' + line_subject +'|'+ line_comment +'|'+ line_height;

      var templateLength = tr.find($('input[name=template]')).length;
      if(templateLength == 0){//template ?????????
         var txt = "<input type='hidden' name='template' id='template"+tr_row+"' value='"+line_info+"'>";
         td.html(td.html()+txt);
      }else{
         td.find($('input[name=template]')).val(line_info);
      }
      $("#line_modal").hide();
      $('.popupLayer').hide();
   }

   //????????????
   var open_preview = null;
   function preview(type){
      var tdLength = $("#form_table").find($("td")).length;
      var templateLength = $("#form_table").find($("input[name=template]")).length;

      if(tdLength==templateLength){
         makeHtml();
         var pform = document.pform;
         $("#preview_html_val").val($("#html").html());
         open_preview = window.open("", "popup_window2", "width = 1200, height = 700, top = 100, left = 400, location = no,toolbar=no,scrollbars=no");

         pform.submit();
         return false;
      }else{
         if(!type){
            alert("???????????? ???????????????");
         }
         return false;
      }
   }

   // //???????????? ??????
   // function preview_close(){
   //    $("#preview_modal").hide();
   // }

   //????????? ?????? ?????? ??????
   function closeUserModal(){
      var check = confirm("??? ??????????????? ?????????????????????? ???????????? ????????? ?????? ?????? ????????????.")
      if(check == true){
         $("#group_tree_modal").hide();
         $('.popupLayer').hide();
      }else{
         return false;
      }
   }

   //???????????? ????????? html ????????? ???
   function makeHtml() {
      var tr = $("#form_table").find('tr');
      var html ='';

      for (i = 0; i < tr.length; i++) {//tr
         var text = '';
         var th = '';
         var multi = '';
         var multi_sum = '';
         var template = tr.eq(i).find($('input[name=template]'));
         var multi_row=[];

         if(tr.eq(i).find($('input[name=multi_row]')).length > 0){
            multi_row = tr.eq(i).find($('input[name=multi_row]')).val().split('|');
            var button_width ='';
            var button_colspan ='';

            if(multi_row[2] != ""){
               var multi_width = multi_row[2].split(',');
               button_width = " width:" + multi_width[multi_width.length-1]+"%";
               button_colspan= " colspan="+multi_width[multi_width.length-1];
            }

            th += "<tr><td colspan=100 style='padding:0;border:none;'><table width ='100%' class='basic_table' border='0' cellspacing='0' cellpadding='0' style='border-collapse:collapse;table-layout:fixed;border-spacing;0px;'><tr name='multi_row"+i+"'>"
            multi = "<tr name='multi_row"+i+"'>";
            if(multi_row[3] != ""){
               multi_sum = "<tr name='multi_row"+i+"sum'>";
            }
         }else{
            text += "<tr>";
         }


         for (j = 0; j < template.length; j++) {//td
            var td_width="";
            var colspan ="";
            if( multi_row.length > 0 && multi_row[2] != ""){
               td_width = Number(multi_width[j]);
               colspan =  Number(multi_width[j]);
            }


            //??????????????????????????????
            var parrallel_num = 0;
            for(a=j+1; a < template.length; a++){
               var next_template_data = template.eq(a).val().split('$$');
               var next_parallel = "";
               if(next_template_data[1]){
                  next_parallel = next_template_data[1];
               }

               if(next_parallel == "Y"){
                  if(multi_row.length > 0 && multi_row[2] != ""){
                     td_width += Number(multi_width[a]);
                     colspan += Number(multi_width[a]);
                  }
                  parrallel_num++
               }else{
                  break;
               }
            }

            if(multi_row.length > 0 && multi_row[2] != ""){
               td_width = " width:" + Number(td_width) + "%";
               colspan = " colspan= " + Number(colspan) ;
            }

            var each_td_width = " width:" + (100/(parrallel_num+1)) + "%";

            //??????????????? ?????????
            for(a = j; a <=j+parrallel_num; a++){
               var template_data = template.eq(a).val().split('$$');
               var parallel = "";
               if(template_data[1]){
                  parallel = template_data[1];
               }

               var template_info = template_data[0].split('|');
               var type = template_info[0];

               if(type == 0){ //?????????
                  var line_subject = template_info[1];
                  var line_comment = template_info[2];
                  var line_height = template_info[3];

                  text += "<td height="+line_height+" align='left' style='border:none;border-bottom:1px solid;border-color:#d7d7d7'>" + line_subject + "</td>";
                  text += "<td height="+line_height+"  style='border:none;border-bottom:1px solid;border-color:#d7d7d7'>"+line_comment+"</td>";

               }else if (type == 1) { //input
                  var column_name = template_info[1];
                  if (template_info[2] == "Y") {
                     column_name = '';
                  }

                  if (template_info[3] == "Y") {
                     var essential = "required";
                     var required_input_display = "<span style='color:red;'> * </span>"
                  } else {
                     var essential = "";
                     var required_input_display = "";
                  }

                  if (template_info[4] == 0) { //??????
                     var input_type = ''
                  } else if (template_info[4] == 1) { //??????
                     var input_type = 'oninput="regex(this,'+"'number'"+');"';
                  } else if (template_info[4] == 2) { //?????? ?????????
                     var input_type = 'type="number" step="any"';
                     var input_type = 'oninput="regex(this,'+"'decimal_point'"+');"';
                  } else if (template_info[4] == 3) { //??????
                     var input_type = 'oninput="regex(this,'+"'money'"+');"';
                  } else if (template_info[4] == 4) { //??????
                     var input_type = 'type="date" max="9999-12-31" '
                  } else if (template_info[4] == 5) { //?????????
                     var input_type = 'onchange="regex(this,'+"'email'"+')"';
                  } else if (template_info[4] == 6) { //????????????
                     // var input_type = 'pattern="[0-9]{2,3}-[0-9]{3,4}-[0-9]{3,4}"';
                     var input_type = 'onchange="regex(this,'+"'phone_num'"+');"';
                  } else if (template_info[4] == 7) { //????????????
                     var input_type = 'onchange="regex(this,'+"'post_num'"+');"';
                  } else { //?????????
                     var input_type = "";
                  }

                  if(template_info[4].indexOf('//') != -1){ //??????????????? $("input[name=zgzgz]").val()
                     var round_num  = template_info[4].split('//')[1];
                     var round_type  = template_info[4].split('//')[2];
                     var onChange = "round(this,"+round_num+","+'"'+round_type+'"'+")";
                     if(template_info[5].trim() != ''){
                        var default_value = " value='expression="+template_info[5]+"'";
                     }else{//?????????????????? ????????? ?????? ????????????(?????????????????? ??????)
                        var default_value = " value='" + template_info[5] + "'";
                     }
                  }else{
                     var onChange = "";
                     var default_value = " value='" + template_info[5] + "'";
                  }

                  if (template_info[6] != "") {
                     var width = " width:" + template_info[6] + template_info[7];
                  } else {
                     var width = '';
                  }

                  if(template_info[4] == 1 || template_info[4] == 2 ||template_info[4] == 3  ){ //??????,????????? ????????? ??????~~~
                     width += ";text-align:right;"
                  }

                  if (template_info[8] != "") {
                     var maximum = "maxlength=" + template_info[8];
                  } else {
                     var maximum = "";
                  }

                  if (template_info[9] != "") {
                     var comment =  template_info[9];
                  }else{
                     var comment =  "";
                  }

                  var name = template_info[10];

                  if(tr.eq(i).find($('input[name=multi_row]')).length > 0){

                     if(a == j){
                        th += "<td height=40 "+colspan+" bgcolor='#f8f8f9' align='center' class='basic_td' style='"+td_width+"'>"+required_input_display+column_name;
                        multi += "<td height=40 "+colspan+" class='basic_td' style='"+td_width+"'><span style='display:inline-block;"+each_td_width+"'><input " + input_type + " class='"+name+" input7' "+default_value + maximum + " onchange='"+onChange+"' style='" + width + "' " + essential + "/>"+comment+"</span>";
                     }else{
                        th += column_name;
                        multi += "<span style='display:inline-block;"+each_td_width+"'><input " + input_type + " class='"+name+" input7' "+default_value + maximum + " onchange='"+onChange+"' style='" + width + "' " + essential + "/>"+comment+"</span>";
                     }

                     if(a == j+parrallel_num){
                        th += "</td>";
                        multi+="</td>";
                     }

                     // if(a == j){
                     //    multi += "<td height=40 "+colspan+" class='basic_td' style='"+td_width+"'><span style='display:inline-block;"+each_td_width+"'><input " + input_type + " class='"+name+" input7' "+default_value + maximum + " onchange='"+onChange+"' style='" + width + "' " + essential + "/>"+comment+"</span>";
                     // }else{
                     //    multi += "<span style='display:inline-block;"+each_td_width+"'><input " + input_type + " class='"+name+" input7' "+default_value + maximum + " onchange='"+onChange+"' style='" + width + "' " + essential + "/>"+comment+"</span>";
                     // }
                     // if(a == j+parrallel_num){
                     //    multi+="</td>";

                     // }
                     if(multi_row[3] != ""){
                        if(a == j){
                           if(multi_row[3].indexOf(name) != -1){
                              multi_sum += "<td height=40 "+colspan+" class='basic_td' style='"+td_width+"'><span style='display:inline-block;"+each_td_width+"'><input " + input_type + " id='"+name+"_sum' name='multisum' onchange='regex(this,"+'"money"'+")' class='input7' style='" + width + ";text-align:right;' readonly/></span>";
                           }else{
                              multi_sum += "<td height=40 "+colspan+" class='basic_td' style='"+td_width+"'><span style='display:inline-block;"+each_td_width+"'></span>";
                           }
                        }else{
                           if(multi_row[3].indexOf(name) != -1){
                              multi_sum += "<span style='display:inline-block;"+each_td_width+"'><input " + input_type + " id='"+name+"_sum' name='multisum' onchange='regex(this,"+'"money"'+")' class='input7' style='" + width + ";text-align:right;' readonly/></span>";
                           }else{
                              multi_sum += "<span style='display:inline-block;"+each_td_width+"'></span>";
                           }
                        }

                        if(a == j+parrallel_num){
                           multi_sum += "</td>";
                        }
                     }
                  }else{
                     if(a == j){
                        text += "<td height=40 bgcolor='#f8f8f9' align='center' class='basic_td'>" +required_input_display+ column_name + "</td>";
                        text += "<td height=40 class='basic_td'><input " + input_type + " class='"+name+" input7' "+ default_value + maximum + " onchange='"+onChange+"' style='" + width + "' " + essential + "/>"+comment
                     }else{
                        text += column_name+"<br>";
                        text += "<input " + input_type + " class='"+name+" input7' "+ default_value + maximum + " onchange='"+onChange+"' style='" + width + "' " + essential + "/>"+comment
                     }

                     if(a == j+parrallel_num){
                        text += "</td>";
                     }
                  }
               } else if (type == 2) { //textarea
                  var column_name = template_info[1];
                  if (template_info[2] == "Y") {
                     column_name = '';
                  }

                  if (template_info[3] == "Y") {
                     var essential = "required";
                     var required_input_display = "<span style='color:red;'> * </span>"
                  } else {
                     var essential = "";
                     var required_input_display = "";
                  }

                  if (template_info[4] != "") {
                     var width = "width:" + template_info[4] + template_info[5] + ";";
                  } else {
                     var width = '';
                  }

                  if (template_info[6] != "") {
                     var height = "height:" + template_info[6] + "px;";
                  } else {
                     var height = '';
                  }

                  var textarea_value =  template_info[7];

                  if (template_info[8] != "") {
                     var comment =  template_info[8];
                  }else{
                     var comment =  "";
                  }

                  var name = template_info[9];

                  // if(tr.eq(i).find($('input[name=multi_row]')).length >0){
                  //    th += "<td height=40 bgcolor='#f8f8f9' align='center' class='basic_td'>"+required_input_display+column_name+"</td>";
                  //    multi += "<td height=40 class='basic_td'><textarea class='"+name+" input7' style='" + width + height + "' " + essential + ">"+textarea_value+"</textarea>"+comment+"</td>";
                  // }else{
                     if(a == j){
                        text += "<td height=40 bgcolor='#f8f8f9' align='center' class='basic_td'>" + required_input_display + column_name + "</td>";
                        text += "<td height=40 class='basic_td'><textarea class='"+name+" input7' style='" + width + height + "' " + essential + ">"+textarea_value+"</textarea>"+comment;
                     }else{
                        text += column_name+"<br>";
                        text += "<textarea class='"+name+" input7' style='" + width + height + "' " + essential + ">"+textarea_value+"</textarea>"+comment;
                     }
                     if(a == j+parrallel_num){
                        text += "</td>";
                     }
                  // }

               } else if (type == 3) { //select box
                  var column_name = template_info[1];
                  if (template_info[2] == "Y") {
                     column_name = '';
                  }

                  if (template_info[3] == "Y") {
                     var essential = "required";
                     var required_input_display = "<span style='color:red;'> * </span>";
                  } else {
                     var essential = "";
                     var required_input_display = "";
                  }

                  var option_html = '';
                  if (template_info[4] != "") {
                     var option = template_info[4].split('**');
                     for (k = 0; k < option.length; k++) {
                        var option_value = option[k].split('//')[1];
                        if (option[k].split('//')[0] == 'true') {
                           var option_selected = 'selected';
                        } else {
                           var option_selected = '';
                        }
                        option_html += "<option value='" + option_value + "'" + option_selected + ">" + option_value + "</option>";
                     }
                  }

                  if (template_info[5] != "") {
                     var comment =  template_info[5];
                  }else{
                     var comment =  "";
                  }

                  var name = template_info[6];

                  if(tr.eq(i).find($('input[name=multi_row]')).length >0){
                     if(a == j){
                        th += "<td height=40 "+colspan+" bgcolor='#f8f8f9' align='center' class='basic_td' style='"+td_width+"'>"+required_input_display+column_name;
                        multi += "<td height=40 "+colspan+" class='basic_td' style='"+td_width+"'><span style='display:inline-block;"+each_td_width+"'><select class='"+name+" input7' " + essential + ">" + option_html + "</select>"+comment+"</span>";
                     }else{
                        th += column_name;
                        multi += "<span style='display:inline-block;"+each_td_width+"'><select class='"+name+" input7' " + essential + ">" + option_html + "</select>"+comment+"</span>";
                     }

                     if(a == j+parrallel_num){
                        th += "</td>";
                        multi+="</td>";
                     }

                     if(multi_row[3] != ""){
                        if(a == j){
                              multi_sum += "<td height=40 "+colspan+" class='basic_td' style='"+td_width+"'><span style='display:inline-block;"+each_td_width+"'></span>";
                        }else{
                              multi_sum += "<span style='display:inline-block;"+each_td_width+"'></span>";
                        }

                        if(a == j+parrallel_num){
                           multi_sum += "</td>";
                        }
                     }
                  }else{
                     if(a == j){
                        text += "<td height=40 bgcolor='#f8f8f9' align='center' class='basic_td'>" + required_input_display +column_name + "</td>";
                        text += "<td height=40 class='basic_td'><select class='"+name+" input7' " + essential + ">" + option_html + "</select>"+comment;
                     }else{
                        text += column_name+"<br>";
                        text += "<select class='"+name+" input7' " + essential + ">" + option_html + "</select>"+comment;
                     }
                     if(a == j+parrallel_num){
                        text += "</td>";
                     }
                  }

               } else if (type == 4) { //radio
                  var column_name = template_info[1];
                  if (template_info[2] == "Y") {
                     column_name = '';
                  }

                  var name = template_info[7];

                  if (template_info[3] == "Y") {
                     var essential = " required";
                     var required_input_display = "<span style='color:red;'> * </span>";
                  } else {
                     var essential = "";
                     var required_input_display = "";
                  }

                  if(template_info[4] == "horizontal"){
                     var sort = '';
                  }else{
                     var sort = '<br>';
                  }

                  var option_html = '';
                  if (template_info[5] != "") {
                     var option = template_info[5].split('**');
                     for (k = 0; k < option.length; k++) {
                        var option_value = option[k].split('//')[1];
                        if (option[k].split('//')[0] == 'true') {
                           var option_selected = ' checked';
                        } else {
                           var option_selected = '';
                        }
                        option_html += '<input type="radio" name="'+name+'" class="'+name+'" value="'+option_value+'" '+option_selected+essential+'>'+option_value+sort;
                     }
                  }

                  if (template_info[6] != "") {
                     var comment =  template_info[6];
                  }else{
                     var comment =  "";
                  }


                  if(tr.eq(i).find($('input[name=multi_row]')).length >0){
                     th += "<td height=40 bgcolor='#f8f8f9' align='center' class='basic_td'>"+required_input_display+column_name+"</td>";
                     multi += "<td height=40 class='basic_td'>"+option_html+comment+"</td>";
                  }else{
                     if(a == j){
                        text += "<td height=40 bgcolor='#f8f8f9' align='center' class='basic_td'>" +required_input_display+ column_name + "</td>";
                        text += "<td height=40 class='basic_td'>"+option_html+comment;
                     }else{
                        text += column_name+"<br>";
                        text += option_html + comment;
                     }
                     if(a == j+parrallel_num){
                        text += "</td>";
                     }
                  }
               } else if (type == 5) { //check_box
                  var column_name = template_info[1];
                  if (template_info[2] == "Y") {
                     column_name = '';
                  }

                  var name = template_info[6];

                  if(template_info[3] == "horizontal"){
                     var sort = '';
                  }else{
                     var sort = '<br>';
                  }

                  var option_html = '';
                  if (template_info[4] != "") {
                     var option = template_info[4].split('**');
                     for (k = 0; k < option.length; k++) {
                        var option_value = option[k].split('//')[1];
                        if (option[k].split('//')[0] == 'true') {
                           var option_selected = ' checked';
                        } else {
                           var option_selected = '';
                        }
                        option_html += '<input type="checkbox" name="'+name+'" class="'+name+'" value="'+option_value+'" '+option_selected+'>'+option_value+sort;
                     }
                  }

                  if (template_info[5] != "") {
                     var comment =  template_info[5];
                  }else{
                     var comment =  "";
                  }


                  if(tr.eq(i).find($('input[name=multi_row]')).length >0){
                     th += "<td height=40 bgcolor='#f8f8f9' align='center' class='basic_td'>"+column_name+"</td>";
                     multi += "<td height=40 class='basic_td'>"+option_html+comment+"</td>";
                  }else{
                     if(a == j){
                        text += "<td height=40 bgcolor='#f8f8f9' align='center' class='basic_td'>" + column_name + "</td>";
                        text += "<td height=40 class='basic_td'>"+option_html+comment;
                     }else{
                        text += column_name+"<br>";
                        text += option_html + comment;
                     }
                     if(a == j+parrallel_num){
                        text += "</td>";
                     }
                  }

               } else if (type == 6) { //?????????
                  if(template_info[1] == "Y"){
                     var header1 = "background-color:#f8f8f9;border-right:none;";
                     var header2 = "background-color:#f8f8f9;border-left:none;";
                  }else{
                     var header1 = "";
                     var header2 = "";
                  }

                  var column_name = template_info[2];
                  if (template_info[3] == "Y") {
                     column_name = '';
                  }
                  var comment = template_info[4];
                  if(tr.eq(i).find($('input[name=multi_row]')).length >0){
                     th += "<td height=40 bgcolor='#f8f8f9' align='center' class='basic_td' style='"+header1+"'>" + column_name + "</td>";
                     multi += "<td height=40 class='basic_td' style='"+header2+"'>"+comment+"</td>";
                  }else{
                     if(a == j){
                        text += "<td height=40 bgcolor='#f8f8f9' align='center' class='basic_td' style='"+header1+"'>" + column_name + "</td>";
                        text += "<td height=40 class='basic_td' style='"+header2+"'>"+comment;
                     }else{
                        text += column_name+"<br>";
                        text += comment;
                     }

                     if(a == j+parrallel_num){
                        text += "</td>";
                     }
                  }
               }else if(type == 7) { //????????????
                  var column_name = template_info[1];
                  if (template_info[2] == "Y") {
                     column_name = '';
                  }

                  if (template_info[3] == "Y") {
                     var essential = " required";
                     var required_input_display = "<span style='color:red;'> * </span>";
                  } else {
                     var essential = "";
                     var required_input_display = "";
                  }

                  var component = template_info[4];
                  var maximum = template_info[5];

                  if (template_info[6] != "") {
                     var comment =  template_info[6];
                  }else{
                     var comment =  "";
                  }

                  var name = template_info[7];

                  if(tr.eq(i).find($('input[name=multi_row]')).length >0){
                     th += "<td height=40 bgcolor='#f8f8f9' align='center' class='basic_td' >" + required_input_display +column_name + "</td>";
                     if(component == "date"){
                        multi += "<td height=40 class='basic_td'><div><input class='input2' name='"+name+"' type='date' max='9999-12-31' style='vertical-align:middle;' onkeydown='return false' "+essential+"/></div>"+comment+"</td>";
                     }else{
                        multi += "<td height=40 class='basic_td'><div><input class='input2' name='"+name+"' title='"+component+"' placeholder='"+component+"' style='border:none;background:transparent;vertical-align:middle;' "+essential+"/><img src='<?php echo $misc;?>img/btn_add.jpg' style='cursor:pointer;vertical-align:middle;' border='0' onClick='select_"+component+"("+'"'+name+'"'+");'/></div>"+comment+"</td>";
                     }
                  }else{
                     if(a == j){
                        text += "<td height=40 bgcolor='#f8f8f9' align='center' class='basic_td' >" + required_input_display + column_name + "</td>";
                        if(component == "date"){
                           text += "<td height=40 class='basic_td'><div><input class='input2' name='"+name+"' type='date' max='9999-12-31' style='vertical-align:middle;' onkeydown='return false' "+essential+"/></div>"+comment;
                        }else if (component == "user"){
                           text += "<td height=40 class='basic_td'><div><input id='"+name+"' type='hidden' name='"+name+"' class='input2' title='"+component+"' placeholder='"+component+"' style='border:none;background:transparent;vertical-align:middle;' "+essential+"/>";
                           text += '<select id="'+name+'_select" onchange="referrerSelect('+"'"+name+"'"+',this);" class="user_select" multiple=multiple style="width:50%;"></select>';
                           text += "<img src='<?php echo $misc;?>img/btn_add.jpg' style='cursor:pointer;vertical-align:top;' border='0' onClick='select_"+component+"("+'"'+name+'"'+");'/></div>"+comment;
                        }else{
                           text += "<td height=40 class='basic_td'><div><input name='"+name+"' class='input2' title='"+component+"' placeholder='"+component+"' style='border:none;background:transparent;vertical-align:middle;' "+essential+"/><img src='<?php echo $misc;?>img/btn_add.jpg' style='cursor:pointer;vertical-align:middle;' border='0' onClick='select_"+component+"("+'"'+name+'"'+");'/></div>"+comment;
                        }
                     }else{
                        text += column_name+"<br>";
                        if(component == "date"){
                           text += "<div><input class='input2' name='"+name+"' type='date' max='9999-12-31' style='vertical-align:middle;' onkeydown='return false' "+essential+"/></div>";
                        }else if (component == "user"){
                           text += "<div><input id='"+name+"' type='hidden' name='"+name+"' class='input2' title='"+component+"' placeholder='"+component+"' style='border:none;background:transparent;vertical-align:middle;'  "+essential+"/>";
                           text += '<select id="'+name+'_select" onchange="referrerSelect('+"'"+name+"'"+',this);" class="user_select" multiple=multiple style="width:50%;"></select>';
                           text += "<img src='<?php echo $misc;?>img/btn_add.jpg' style='cursor:pointer;vertical-align:top;' border='0' onClick='select_"+component+"("+'"'+name+'"'+");'/></div>";
                        }else{
                           text += "<div><input name='"+name+"' class='input2' title='"+component+"' placeholder='"+component+"' style='border:none;background:transparent;vertical-align:middle;' "+essential+"/><img src='<?php echo $misc;?>img/btn_add.jpg' style='cursor:pointer;vertical-align:middle;' border='0' onClick='select_"+component+"("+'"'+name+'"'+");'/></div>";
                        }

                        text += comment;
                     }

                     if(a == j+parrallel_num){
                        text += "</td>";
                     }
                  }
               }

            }
            j = j+parrallel_num;
         }
         if(tr.eq(i).find($('input[name=multi_row]')).length > 0){//?????? ?????????
            th += "<td "+button_colspan+" align='center' class='basic_td' style='"+button_width+"'><img src='<?php echo $misc;?>/img/btn_add.jpg' style='cursor:pointer;' onclick='addRow(this)'></td></tr>";
            html += th;
            multi += "<td "+button_colspan+" align='center' class='basic_td' style='"+button_width+"'><img src='<?php echo $misc;?>/img/btn_del0.jpg' style='cursor:pointer;' onclick='delRow(this)'><img src='<?php echo $misc;?>/img/btn_add.jpg' style='cursor:pointer;' onclick='addRow3(this)'></td></tr>";
            if(multi_row[3] == ""){
               multi += "</table></td></tr>"
            }
            if(multi_row[1] != ''){
               for(z=0; z < multi_row[1]; z++){
                  html += multi;
               }
            }
            if(multi_row[3] != ""){
               multi_sum +="<td "+button_colspan+" align='center' class='basic_td'>"+multi_row[0]+"</td></tr></table></td></tr>"
            }
            html += multi_sum;
         }else{
            text += "</tr>";
            html += text
         }
      }

      $("#html").html(html);

      //?????? input??????????????????????????????
      var html_input = $("#html").find($("input"));
      for (i = 0; i < html_input.length; i++) {
         if (html_input.eq(i).val().indexOf('expression=') != -1 && html_input.eq(i).val() != '') {
            var html_input_class = html_input.eq(i).attr('class').replace("input7", "") // ????????? ?????? ?????????
            $("." + html_input_class).attr('readonly', true);
            var onchange = $("." + html_input_class).attr('onchange');
            var style = $("." + html_input_class).attr('style');
            if(onchange.indexOf('round(this,0,"round")') != -1){
               $("." + html_input_class).attr('onchange',onchange+";regex(this,'money')");
               $("." + html_input_class).attr('style',style+";text-align:right;");
            }

            if ($("." + html_input_class).length == 1 && html_input.eq(i).closest("tr").attr('name') == undefined) {

               var expression = $("." + html_input_class).eq(0).val().replace('expression=', '');
               var expression2 = expression.split(/[+-/*)(]/g);
               var calculation_symbol = expression.match(/[+-/*)(]/g);
               //?????? ???????????? ?????????
               var onchange_name = '';
               var expression3 = expression.split(/[+-/*)(]/g);

               for (k = 0; k < expression2.length; k++) {
                  if (isNaN(expression2[k]) == true) {
                     expression2[k] = expression2[k].replace('[', '').replace(']', '').replace('(', '').replace(')', '');
                     var sum = 0;
                     for (l = 0; l < $("." + expression2[k]).length; l++) {
                        var onchange = $("." + expression2[k]).eq(l).attr("onchange");
                        sum += Number($("." + expression2[k]).eq(l).val().replace(/,/gi, ""));
                        var txt = '';
                        for (f = 0; f < expression2.length; f++) {
                           if (expression2[f] != undefined) {
                              txt += expression2[f] + ',';
                           }
                           if (calculation_symbol[f] != undefined) {
                              txt += calculation_symbol[f] + ',';
                           }
                        }
                        $("." + expression2[k]).eq(l).attr("onchange", onchange + ";multi_calculation('" + txt + "','" + html_input_class + "','all')");
                     }
                     expression3[k] = sum;
                  }
               }

               if (calculation_symbol != null) {
                  var txt2 = '';
                  for (f = 0; f < expression3.length; f++) {
                     if (expression3[f] != undefined) {
                        txt2 += expression3[f] + ',';
                     }
                     if (calculation_symbol[f] != undefined) {
                        txt2 += calculation_symbol[f] + ',';
                     }
                  }

                  txt2 = txt2.replace(/[,]/g, '');
                  $("." + html_input_class).eq(0).val(eval(txt2));
                  $("." + html_input_class).each(function(){ this.defaultValue = this.value;});
               }
            }
            if(($("." + html_input_class).length >= 1 && html_input.eq(i).closest("tr").attr('name') != undefined)) {
               for (j = 0; j < $("." + html_input_class).length; j++) {
                  var expression = $("." + html_input_class).eq(0).val().replace('expression=', '');
                  var expression2 = expression.split(/[+-/*]/g);
                  expression = expression.replace(/\[/gi, 'Number($(".').replace(/\]/gi, '").eq(' + j + ').val().replace(/,/gi, ""))');

                  var onchange_name = '';
                  for (k = 0; k < expression2.length; k++) {
                     if (isNaN(expression2[k]) == true) {
                        expression2[k] = expression2[k].replace('[', '').replace(']', '').replace('(', '').replace(')', '');
                        var onchange = $("." + expression2[k]).eq(j).attr("onchange");
                        // $("." + expression2[k]).eq(j).attr("onchange", onchange + ";multi_calculation('" + expression + "','" + html_input_class + "','" + j + "')");
                        for(l = 0; l < expression2[k].length; l++){
                           $("." + expression2[k]).eq(l).attr("onchange", onchange + ";multi_calculation('" + expression + "','" + html_input_class + "'," + 'this' + ")");
                        }
                     }
                  }
                  $("." + html_input_class).eq(j).val(eval(expression));
                  $("." + html_input_class).each(function(){ this.defaultValue = this.value;});
               }
            }
         }
      }



      //?????? ??????...
      var multi_sum_input = $("input[name=multisum]");

      for(i=0; i<multi_sum_input.length; i++){
         var multi_input = $("input[name=multisum]").eq(i)
         var multi_id = multi_input.attr('id').replace("_sum",'');
         var sum_value = 0;

         for(j=0; j < $("."+multi_id).length; j++){
            sum_value += Number($("."+multi_id).eq(j).val().replace(/,/gi, ""));
            var multi_id_onchange = $("."+multi_id).eq(j).attr('onchange');
            $("."+multi_id).eq(j).attr('onchange',multi_id_onchange+';multi_sum("'+multi_id+'")');
         }

         multi_input.val(sum_value);
         $(multi_input).each(function(){ this.defaultValue = this.value;});

      }

      //colspan width ?????? (????????????????????? ??????)
      for(i=0; i< $("#html").find($("tr")).length; i++){
         var tdLength = $("#html").find($("tr")).eq(i).find($('td')).length;
         var td_col=[];
         if(tdLength == 2){
            td_col[0] = 15
            td_col[1] = 85
         }else if (tdLength == 4){
            td_col[0] = 15
            td_col[1] = 35
            td_col[2] = 15
            td_col[3] = 35
         }else{
            var col = 100 / tdLength;
            for(k=0; k<tdLength; k++){
               td_col[k] = col;
            }
         }

         for(j=0; j< $("#html").find($("tr")).eq(i).find($('td')).length; j++){
            if($("#html").find($("tr")).eq(i).find($('td')).eq(j).attr("colspan") == undefined){
               $("#html").find($("tr")).eq(i).find($('td')).eq(j).attr("colspan",td_col[j]);
               $("#html").find($("tr")).eq(i).find($('td')).eq(j).width( td_col[j]+'%');
            }

         }
      }

      //?????? width ...

   }

   //????????? ?????? ??????
   function addRow(obj){
      var tr_name = $(obj).closest('tr').attr('name');
      var tr_last = $('tr[name='+tr_name+']')[$('tr[name='+tr_name+']').length-1];
      var tr_last_html = tr_last.outerHTML;
      $(tr_last).after(tr_last_html);
      var new_tr = $('tr[name='+tr_name+']')[$('tr[name='+tr_name+']').length-1]
      for(i=0; i<$(new_tr).find($("input")).length; i++){
         if($(new_tr).find($("input")).eq(i).val().indexOf("express") != -1){
            $(new_tr).find($("input")).eq(i).val(''); //????????? ???????????? input ??????
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
            $(new_tr).find($("input")).eq(i).val(''); //????????? ???????????? input ??????
         }
      }
   }

   function delRow(obj){
      $(obj).parent().parent().remove();
   }

   function moveUp(el) {
     var tr = $(el).closest('tr');
     tr.prev().before(tr);
   }

   function moveDown(el) {
     var tr = $(el).closest('tr');
     tr.next().after(tr);
   }

   function template_info_change(){
      var td = $("#"+$("#popup_td").val());

      if(td.find($("input[name=template]")).length > 0){
         var templateInfo = td.find($("input[name=template]")).val().split('|');

         if(templateInfo[0] == 1){//input
            var input_type;
            if(templateInfo[4] == '0'){
               input_type="??????";
            }else if(templateInfo[4] == '1'){
               input_type="??????";
            }else if(templateInfo[4] == '2'){
               input_type="??????(???????????????)";
            }else if(templateInfo[4] == '3'){
               input_type="??????";
            }else if(templateInfo[4] == '4'){
               input_type="??????";
            }else if(templateInfo[4] == '5'){
               input_type="?????????";
            }else if(templateInfo[4] == '6'){
               input_type="????????????";
            }else if(templateInfo[4] == '7'){
               input_type="????????????";
            }else{
               input_type="?????????";
            }
            var txt ="<div>?????? : "+templateInfo[1]+"</div>";
            txt += "<div>?????? : ?????????</div>";
            txt += "<div>name : "+templateInfo[10].split("$$")[0]+"</div>";
            txt += "<div>?????? : "+templateInfo[3]+"</div>";
            txt += "<div>???????????? : "+templateInfo[2]+"</div>";
            txt += "<div>???????????? : "+input_type+"</div>";
            txt += "<div>?????? : "+templateInfo[6]+templateInfo[7]+"</div>";
            txt += "<div>?????? : "+templateInfo[8]+"</div>";
            txt += "<div>????????? : "+templateInfo[5]+"</div>";
         }else if (templateInfo[0] == 2){ //textarea
            var txt ="<div>?????? : "+templateInfo[1]+"</div>";
            txt += "<div>?????? : ???????????????</div>";
            txt += "<div>name : "+templateInfo[9].split("$$")[0]+"</div>";
            txt += "<div>?????? : "+templateInfo[3]+"</div>";
            txt += "<div>???????????? : "+templateInfo[2]+"</div>";
            txt += "<div>?????? : "+templateInfo[4]+templateInfo[5]+"</div>";
            txt += "<div>?????? : "+templateInfo[6]+"</div>";
            txt += "<div>????????? : "+templateInfo[7]+"</div>";
         }else if (templateInfo[0] == 3){ //select
            var txt ="<div>?????? : "+templateInfo[1]+"</div>";
            txt += "<div>?????? : ?????????</div>";
            txt += "<div>name : "+templateInfo[6].split("$$")[0]+"</div>";
            txt += "<div>?????? : "+templateInfo[3]+"</div>";
            txt += "<div>???????????? : "+templateInfo[2]+"</div>";
         }else if (templateInfo[0] == 4){ //radio
            var txt ="<div>?????? : "+templateInfo[1]+"</div>";
            txt += "<div>?????? : ?????????</div>";
            txt += "<div>name : "+templateInfo[7].split("$$")[0]+"</div>";
            txt += "<div>?????? : "+templateInfo[3]+"</div>";
            txt += "<div>???????????? : "+templateInfo[2]+"</div>";
            txt += "<div>?????? : "+templateInfo[4]+"</div>";
         }else if (templateInfo[0] == 5){ //????????????
            var txt ="<div>?????? : "+templateInfo[1]+"</div>";
            txt += "<div>?????? : ????????????</div>";
            txt += "<div>name : "+templateInfo[6].split("$$")[0]+"</div>";
            txt += "<div>???????????? : "+templateInfo[2]+"</div>";
            txt += "<div>?????? : "+templateInfo[3]+"</div>";
         }else if (templateInfo[0] == 6){ //?????????
            var txt ="<div>?????? : "+templateInfo[2]+"</div>";
            txt += "<div>?????? : ?????????</div>";
            txt += "<div>???????????? : "+templateInfo[1]+"</div>";
            txt += "<div>???????????? : "+templateInfo[3]+"</div>";
         }else if (templateInfo[0] == 7){ //????????????
            var txt ="<div>?????? : "+templateInfo[1]+"</div>";
            txt += "<div>?????? : ????????????</div>";
            txt += "<div>?????? : "+templateInfo[4]+"</div>";
            txt += "<div>name : "+templateInfo[7].split("$$")[0]+"</div>";
            txt += "<div>?????? : "+templateInfo[3]+"</div>";
            txt += "<div>???????????? : "+templateInfo[2]+"</div>";
            txt += "<div>?????? : "+templateInfo[5]+"</div>";
         }
         $("#template_info").html(txt);
      }
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
               class_name[i] = "("+sum+")";
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

   //???????????? ??????
   function approval_info_save(){
      //??????????????? ????????????
      if($("#template_name").val() == ''){ //?????????
         $("#template_name").focus();
         alert("???????????? ??????????????????.");
         return false;
      }

      if($("#template_category").val() == ''){ //?????????
         $("#template_category").focus();
         alert("???????????? ??????????????????.");
         return false;
      }

      if($("#template_explanation").val() == ''){ //????????????
         $("#template_explanation").focus();
         alert("??????????????? ??????????????????.");
         return false;
      }

      if('<?php echo $mode; ?>' == "input"){ //????????????
         $.ajax({
            type: "POST",
            cache: false,
            url: "<?php echo site_url();?>/biz/approval/approval_info_save",
            dataType: "json",
            async: false,
            data: {
               template_name: $("#template_name").val(),
               template_category: $("#template_category").val(),
               template_type: $("input[name=template_type]:checked").val(),
               official_doc: $("input[name=official_doc]:checked").val(),
               template_use: 'Y',
               template_sort_seq: $("#template_sort_seq").val(),
               template_explanation: $("#template_explanation").val(),
               default_approval_line: $("#default_approval_line").val(),
               default_referrer: $("#default_referrer").val(),
            },
            success: function (data) {
               alert("????????????");
               // $("#seq").val(data);
               // $("#approval_info_check").val("Y");
               location.href="<?php echo site_url();?>/biz/approval/electronic_approval_form?seq="+data+"&mode=modify"
            }
         });
      }else{ // ????????????
         var tdLength = $("#form_table").find($("td")).length;
         var templateLength = $("#form_table").find($("input[name=template]")).length;
         var template_use = $("input[name=template_use]:checked").val();
         if(tdLength!=templateLength){
            alert("???????????? ??? ????????? ??? ???????????? ?????? ??????????????? ???????????????.");
            $("input:radio[name=template_use]:radio[value='N']").prop('checked', true);
         }
         $.ajax({
            type: "POST",
            cache: false,
            url: "<?php echo site_url();?>/biz/approval/approval_info_save",
            dataType: "json",
            async: false,
            data: {
               seq: $("#seq").val(),
               template_name: $("#template_name").val(),
               template_category: $("#template_category").val(),
               template_type: $("input[name=template_type]:checked").val(),
               official_doc: $("input[name=official_doc]:checked").val(),
               template_use: $("input[name=template_use]:checked").val(),
               template_sort_seq: $("#template_sort_seq").val(),
               template_explanation: $("#template_explanation").val(),
               default_approval_line: $("#default_approval_line").val(),
               default_referrer: $("#default_referrer").val(),
            },
            success: function (data) {
              if(data == true){
                 alert("?????? ??????");
                 $("#approval_info_check").val("Y");
              }else{
                 alert("?????? ??????");
              }
            }
         });
      }
   }

   //???????????? ???????????? ??????????????? ???????????????
   function approval_info_save_check(){
      if($("#approval_info_check").val() == "N"){
         alert("???????????? ?????? ??? ?????????????????? ????????? ??? ????????????.")
         $("input:radio[name='radio-set']:radio[id='tab-1']").prop('checked', true); // ????????????
         return false;
      }
   }

   //???????????? ??????
   function template_info_save(){
      var tdLength = $("#form_table").find($("td")).length;
      var templateLength = $("#form_table").find($("input[name=template]")).length;
      var template_use = $("input[name=template_use]:checked").val();
      if(tdLength!=templateLength){
         template_use = "N";
      }

      makeHtml();
      $("#form_table_html").val(document.getElementById('form_table').outerHTML);
      $("#preview_html").val(document.getElementById('html').outerHTML);

      $.ajax({
			type: "POST",
			cache: false,
			url: "<?php echo site_url();?>/biz/approval/template_info_save",
			dataType: "json",
			async: false,
			data: {
				seq : $("#seq").val(),
            editor_use: $("input[name=editor_use]:checked").val(),
            writing_guide: $("#writing_guide").val(),
            form_table_html: $("#form_table_html").val(),
            preview_html: $("#preview_html").val(),
            template_use: template_use,
			},
			success: function (data) {
            if(data == true){
               alert("??????????????????");
            }else{
               alert("??????");
            }
			}
		});
   }

   //????????? ??????
   function select_user(s_id){
      // $("#group_tree_modal").show();
      $("#click_user").remove();
      $("#group_tree_modal").show();
      $("#select_user_id").val(s_id);
      if($("#"+$("#select_user_id").val()).val() != ""){
         var select_user = ($("#"+$("#select_user_id").val()).val()).split(',');
         var txt = '';
         for(i=0; i<select_user.length; i++){
            txt += "<div class='select_user' onclick='click_user("+'"'+select_user[i]+'"'+",this)'>"+select_user[i]+"</div>";
         }
         $("#select_user").html(txt);
      }
   }

   //????????? ?????? ??????
   function saveUserModal(){
      var txt ='';
      for(i=0; i <$(".select_user").length; i++){
         var val = $(".select_user").eq(i).text().split(' ');
         if(i == 0){
            txt += val[0]+" "+val[1];
         }else{
            txt += "," + val[0]+" "+val[1];
         }
         $("#"+$("#select_user_id").val()).val(txt);
         $("#"+$("#select_user_id").val()).change();
         $("#group_tree_modal").hide();
      }
   }

   // groupView();

   //?????? ???????????? ?????? ?????? ??????
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

   //?????? ???????????? ??? ???????????? user ????????????
   function groupView(group){
   if(group == undefined){
      var groupName = "all";
   }else{
      var groupName = $(group).attr("id");
   }

   $.ajax({
         type: "POST",
         cache: false,
         url: "<?php echo site_url(); ?>/ajax/groupView",
         dataType: "json",
         async: false,
         data: {
         group:groupName
         },
         success: function (data) {
            var txt = '';
            for(i=0; i<data.length; i++){
                  txt +=  "<div class='click_user' onclick='click_user("+'"'+data[i].user_name+'",this'+");'>"+data[i].user_name+" "+data[i].user_duty+" "+data[i].user_group+ "</div>";
            }
            $("#click_group_user").html(txt);
         }
   });

   }

   //user ??????
   function click_user(name,obj){
      $(".click_user").css('background-color','');
      $(".select_user").css('background-color','');
      $(".click_user").attr('id','');
      $(".select_user").attr('id','');
      $(obj).css('background-color','#f8f8f9');
      $(obj).attr('id','click_user');
   }

   //user ??????
   function select_user_add(type){
      if(type == 'all'){
         var result = confirm("?????? ??? ?????? ???????????? ?????????????????????????");
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
         if(duplicate_check == true){
            return false;
         }else{
            var html = "<div class='select_user' onclick='click_user("+'"'+$("#click_user").html()+'"'+",this)'>"+$("#click_user").html()+"</div>";
            $("#select_user").html($("#select_user").html()+html);
         }
      }

   }

   //????????? user ?????? ??????
   function select_user_del(type){
      if(type == "all"){
         $(".select_user").remove();
      }else{
         if($("#click_user").attr('class') == 'select_user'){
            $("#click_user").remove();
         }
      }
   }

   //????????? ?????? , ??????
   function round(obj,n,type){
      if(n != 0){
         if(type == "round"){//?????????
            var num = Number(obj.value);
            $(obj).val(num.toFixed(n));
         }else if(type == "down"){//??????
            var decimal_point = obj.value.indexOf('.');
            var num = (obj.value).substring(0,(decimal_point+n+1));
            $(obj).val(num);
         }else if(type == "up"){//??????
            var decimal_point = obj.value.indexOf('.');
            var num = (obj.value).substring(0,(decimal_point+n+1));
            var up_value = String(Number(num[(decimal_point+n)])+1);
            up_value = num.substr(0,(decimal_point+n)) + up_value + num.substr((decimal_point+n)+ up_value.length);
            $(obj).val(up_value);
         }
      }else{
         if(type == "round"){//?????????
            var num = Math.round(obj.value);
            $(obj).val(num);
         }else if(type == "down"){//??????
            var num = Math.floor(obj.value);
            $(obj).val(num);
         }else if(type == "up"){//??????
            var num = Math.ceil(obj.value);
            $(obj).val(num);
         }
      }
   }

   //????????? ????????? ??????
   function click_user_approval_line(seq){
      if(seq != "N"){
         $("#select_approver").html("");
         var select_seq = seq
         var approver_seq ="";
         var approval_type ="";
         <?php
            if(empty($approver_line) != true){
               foreach($approver_line as $ual){ ?>
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
      }else{
         $("#select_approver").html("");
      }
   }

   //????????? ????????? ??? ???????????? ??????
   function finalReferrer(){
      for(i=0; i < $("#select_approver").find($("td")).length; i++){
         if($("#select_approver").find($("td")).eq(i).html() == "??????"){
            $("#select_approver").find($("td")).eq(i).html("");
         }else if(i == ($("#select_approver").find($("td")).length)-3){
            $("#select_approver").find($("td")).eq(i).html("??????");
         }
      }
   }

   //???????????????
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
            alert("email ????????? ???????????????.")
            return false
         }
      }else if (type == "post_num"){
         var regex =  /^[0-9]{1,6}$/
         if(regex.test($(obj).val()) === false){
            $(obj).focus();
            alert("??????????????? ?????? 6????????? ??????????????????")
            return false;
         }
      }
   }

   //??????????????? ??????
   function template_delete(){
      if(confirm("????????? ????????? ?????????????????????????")){
         $.ajax({
               type: "POST",
               cache: false,
               url: "<?php echo site_url(); ?>/biz/approval/template_delete",
               dataType: "json",
               async :false,
               data: {
                  seq : $("#seq").val()
               },
               success: function (data) {
                if(data){
                   alert("????????????");
                   location.href= "<?php echo site_url(); ?>/biz/approval/electronic_approval_form_list?mode=admin";
                }else{
                   alert("????????????")
                }
               }
            });
      }
   }

   //?????????
   function reset(){
      if(confirm("????????? ????????? ?????? ???????????? ????????? ?????????. ????????????????????????????")){
         $("#form_table").html("");
      }else{
         return false;
      }
   }

   //??????????????? ??????
   function form_save_modal_open(){
      var tdLength = $("#form_table").find($("td")).length;
      var templateLength = $("#form_table").find($("input[name=template]")).length;
      if(tdLength==templateLength){
         $("#form_save_modal").show();
      }else{
         alert("???????????? ???????????????");
         return false;
      }
   }

   //??????????????? ??????!
   function form_save(type){
      var seq = "";
      if(type != 0){
         seq = $("#form_seq").val();
      }

      if(type == 0 || type == 1){
         $.ajax({
            type: "POST",
            cache: false,
            url: "<?php echo site_url();?>/biz/approval/form_management_save",
            dataType: "json",
            async: false,
            data: {
               type : type,
               seq : seq,
               form_name: $("#form_name").val(),
               form_table_html : document.getElementById('form_table').outerHTML
            },
            success: function (data) {
               if(data == true){
                  alert("?????? ??????");
                  $('#form_management_list').load(document.URL +  ' #form_management_list');
                  $('#form_save_table').load(document.URL +  ' #form_save_table');
               }else{
                  alert("?????? ??????");
               }
            }
         });
      }else{
         if($('input:checkbox[name="form_seq"]:checked').length!=0){
            if(confirm("????????? ???????????? ?????????????????????????")){
               var res = true;
               $('input:checkbox[name="form_seq"]').each(function () {
                  if (this.checked == true) {
                     $.ajax({
                        type: "POST",
                        cache: false,
                        url: "<?php echo site_url(); ?>/biz/approval/form_management_save",
                        dataType: "json",
                        async: false,
                        data: {
                           type : type,
                           seq : this.value
                        },
                        success: function (data) {
                           if(data != true){
                              res = false;
                           }
                        }
                     });
                  }
               });

               if(res == true){
                  alert("?????? ??????");
                  $('#form_management_list').load(document.URL +  ' #form_management_list');
                  $('#form_save_table').load(document.URL +  ' #form_save_table');
               }else{
                  alert("?????? ??????");
               }
            }
         } else {
            alert("????????? ????????? ??????????????????");
            return false;
         }
      }
   }

   //?????????????????? ??????????????? ?????? ??????!
   function form_change(seq,name){
      $("#form_seq").val(seq);
      $("#form_name").val(name);
      $("#form_save_btn").toggle();
      $("#form_adjust_btn").toggle();
      $("#form_save_cancel_btn").toggle();
   }

   //?????????????????? ??????????????? ?????? ?????? ??????!!
   function form_change_cancel(){
      $("#form_seq").val("");
      $("#form_name").val("");
      $("#form_save_cancel_btn").toggle();
      $("#form_save_btn").toggle();
      $("#form_adjust_btn").toggle();
   }

   //?????????????????? ??????????????? ??????
   function form_apply(obj){
      if(confirm("????????? ???????????? ?????????????????? ??????????????? ?????? ???????????? ?????? ?????????. ?????? ???????????????????")){
         var val = $(obj).parent().find($("textarea[name=form_html]")).val();
         document.getElementById('form_table').outerHTML = val;
         $('#form_save_modal').hide();
      }
   }

   //?????? ?????? ????????? ?????? close
   $(document).mouseup(function (e) {
   var container = $('.searchModal');
   if (container.has(e.target).length === 0) {
      container.css('display', 'none');
   }
   });

   //????????????????????? ????????? ????????????
   for(var i=0; i<$("#form_table").find($("span")).length; i++){
      var text = $("#form_table").find($("span")).eq(i).html();
      if($("#form_table").find($("span")).eq(i).find($("img")).length == 0){
         if(text.indexOf("?????????(") !== -1){
            var img = '<img src="<?php echo $misc;?>img/input.png" width="23" style="vertical-align:middle">';
            $("#form_table").find($("span")).eq(i).html(img+text);
         }else if (text.indexOf("???????????????(") !== -1){
            var img = '<img src="<?php echo $misc;?>img/textbox.png" width="23" style="vertical-align:middle">';
            $("#form_table").find($("span")).eq(i).html(img+text);
         }else if (text.indexOf("?????????(") !== -1){
            var img = '<img src="<?php echo $misc;?>img/select.png" width="23" style="vertical-align:middle">';
            $("#form_table").find($("span")).eq(i).html(img+text);
         }else if (text.indexOf("?????????(") !== -1){
            var img = '<img src="<?php echo $misc;?>img/radio.png" width="23" style="vertical-align:middle">';
            $("#form_table").find($("span")).eq(i).html(img+text);
         }else if (text.indexOf("????????????(") !== -1){
            var img = '<img src="<?php echo $misc;?>img/checkbox.png" width="23" style="vertical-align:middle">';
            $("#form_table").find($("span")).eq(i).html(img+text);
         }else if (text.indexOf("?????????(") !== -1){
            var img = '<img src="<?php echo $misc;?>img/writebox.png" width="23" style="vertical-align:middle">';
            $("#form_table").find($("span")).eq(i).html(img+text);
         }else if (text.indexOf("????????????(") !== -1){
            var img = '<img src="<?php echo $misc;?>img/component.png" width="23" style="vertical-align:middle">';
            $("#form_table").find($("span")).eq(i).html(img+text);
         }else if (text.indexOf("?????????(") !== -1){
            var img = '<img src="<?php echo $misc;?>img/line.png" width="23" style="vertical-align:middle">';
            $("#form_table").find($("span")).eq(i).html(img+text);
         }
      }
   }


</script>
</body>
</html>

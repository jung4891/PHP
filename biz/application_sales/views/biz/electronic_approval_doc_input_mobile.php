<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
	$duty = $this->phpsession->get( 'duty', 'stc' );

	?>
<body>
	<meta name="viewport" content="width=device-width,height=device-width, initial-scale=1.0">
	<style>
	body {
		font-size: 14px;
	}
	.basic_table{
		width:100%;
		 border-collapse:collapse;
		 border:1px solid;
		 border-color:#DEDEDE;
		 table-layout: auto !important;
		 border-left:none;
		 border-right:none;
	}

	.basic_table td{
		height:35px;
		 padding:0px 10px 0px 10px;
		 border:1px solid;
		 border-color:#DEDEDE;
	}
	.border_n {
		border:none;
	}
	.border_n td {
		border:none;
	}
	.basic_table tr > td:first-child {
		border-left:none;
	}
	.basic_table tr > td:last-child {
		border-right:none;
	}
	div.editor_div div.note-toolbar {
		display: none;
	}
	#formLayoutDiv {
		overflow-x: scroll;
		white-space:nowrap;
	}

  #formLayoutDiv table{
    width:100%;
    min-width: 1100px;
  }
	#formLayoutDiv input{
		 /* border: none !important;
		 background: transparent !important; */
		 /* -webkit-appearance: none;
        -moz-appearance: none;
             appearance: none; */
	}

	#formLayoutDiv input[type=radio]{
		appearance: none;
	  width: 0.9rem;
	  height: 0.9rem;
	  border-radius: 100%;
	  margin-right: 0.1rem;
	 	border: 2px solid #A1A1A1;
		vertical-align: text-top;

	}

	#formLayoutDiv input[type=radio]:checked{
		background-color: #A1A1A1;
	}

	/* #formLayoutDiv select{
		 border:none;
		 border-radius:0;
		 -webkit-appearance: none;
		 appearance: none;
		 background: transparent !important;
	} */
	/* #formLayoutDiv textarea{
		 color: transparent;
		 text-shadow: 0 0 0 black;
		 border: none !important;
		 background: transparent !important;
	} */
	/* #formLayoutDiv select {
		 pointer-events: none;
		 width:130%;
	} */

	/* #formLayoutDiv input {
		 border: none !important;
		 background: transparent !important;
	} */

	/* #formLayoutDiv input[type=date] {
		 pointer-events: none;
	} */

	 /* #formLayoutDiv ::-webkit-calendar-picker-indicator{
		 display:none;
	} */
	#html {
		/* table-layout: fixed; */
		/* width: auto !important; */
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
	/* ?????? css */
	.searchModal {
		 display: none; /* Hidden by default */
		 width:90%; /* Full width */
		 margin-top: 30px;
		 overflow: scroll;; /* Enable scroll if needed */
		 background-color: rgb(0,0,0); /* Fallback color */
		 background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
		 z-index: 1002;
	}
		 /* Modal Content/Box */
	.search-modal-content {
		 background-color: #fefefe;
		 padding: 20px;
		 border: 1px solid #888;
		 z-index: 1002;
	}

 .search-modal-content input[type=radio]{
	 appearance: none;
	 width: 0.9rem;
	 height: 0.9rem;
	 border-radius: 100%;
	 margin-right: 0.1rem;
	 border: 2px solid #A1A1A1;
	 vertical-align: text-top;
 }

 .search-modal-content input[type=radio]:checked{
	 background-color: #A1A1A1;
 }

	.btn_div .btn-common {
		width:auto;
		padding-left:10px;
		padding-right:10px;
		border-radius: 3px;
		margin-top: 10px;
	}
	.btn_div .btn-common:not(:last-child) {
		margin-right: 5px;
	}
	.last_border_n {
		border:none;
	}
	.last_border_n tr:last-child td {
		border:none;
	}
	.btn-common {
		border-radius: 3px !important;
	}
	.note-editable {
		font-size: 16px;
	}

	.file_label {
		display: inline-block;
		padding: .5em .75em;
		color: #FFFFFF;
		font-size: inherit;
		line-height: normal;
		vertical-align: middle;
		background-color: #A1A1A1;
		cursor: pointer;
		border: 1px solid #ebebeb;
		border-bottom-color: #e2e2e2;
		border-radius: .25em;
	}

.click_user{
	width:auto;
	height: 30px;
	border: 1px solid #888;
	text-align: center;
	display: table-cell;
	vertical-align: middle;
	border-radius: 5px;
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

	<?php
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_side.php";
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_header.php";
	  ?>
<div class="" style="width:90%; margin:0 auto;padding-bottom:60px;overflow-x:scroll;">
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

    <div style="text-align:right">
       <input type="button" class="btn-common btn-color2" value="?????????" onclick="select_approval_modal();" />
       <input type="button" class="btn-common btn-color1" value="???????????????" onclick="approvalAttachment();">
       <input type="button" class="btn-common btn-color1" value="??????" onclick="cancel();">
    </div>
    <div style="text-align:left;font-size:20px;margin-bottom:20px;margin-top:20px;width:100%;font-weight:bold;line-height:25px;">
      <?php if($seq == "annual"){
         echo "???????????????";
      }else if ($seq == "attendance"){
         echo "???????????????";
      }else{
         echo $view_val['template_name'];
      }?>
    </div>
  	<div style="width:100%;">
      <div>
        <!-- <table id="approver_line_table" class="basic_table">
          <colgroup>
            <col width='30%'>
            <col width='50%'>
            <col width='20%'>
          </colgroup>
          <tr>
            <td height=40 class="basic_td" bgcolor="f8f8f9" >??????</td>
            <td colspan="2" class="basic_td" bgcolor="f8f8f9"><?php echo $name; ?><?php echo $duty; ?></td>
          </tr>
        </table>
      </div>
      <div>
        <table id="agreement_line_table" class="basic_table" style="width:auto;text-align:center;margin-bottom:30px;">
          <colgroup>
            <col width='30%'>
            <col width='50%'>
            <col width='20%'>
          </colgroup>
           <tr></tr>
           <tr></tr>
        </table> -->
				<table id="approver_line_table" class="basic_table" style="width:auto;text-align:center;margin-bottom:30px;">
					 <tr><td height=40 rowspan=2 class="basic_td" width="20px" bgcolor="f8f8f9" >??????</td><td class="basic_td" width="100px" bgcolor="f8f8f9"><?php echo $duty; ?></td></tr>
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
        <table class="basic_table">
          <colgroup>
            <col width='30%'>
            <col width='50%'>
            <col width='20%'>
          </colgroup>
          <tr>
             <td height=40 class="basic_td" bgcolor="f8f8f9">????????????</td>
             <td colspan="2" class="basic_td">????????????</td>
          </tr>
          <tr>
             <td class="basic_td" bgcolor="f8f8f9">????????????</td>
             <td colspan="2" class="basic_td"><?php echo date("Y-m-d"); ?></td>
          </tr>
          <tr>
            <td class="basic_td" bgcolor="f8f8f9">????????????</td>
            <td class="basic_td"><input type="hidden" name="writer_group" id="writer_group" value="<?php echo $group; ?>" /><?php echo $group; ?></td>
          </tr>
          <tr>
            <td height=40 class="basic_td" bgcolor="f8f8f9">?????????</td>
            <td colspan="2" class="basic_td">
                  <input id="referrer" name="referrer" type="hidden" class="input2" value="<?php if($seq != "annual" && $seq != "attendance" ){ echo $view_val['default_referrer'];} ?>" />
                  <select id="referrer_select" class="user_select" name="referrer_select" onchange="referrerSelect('referrer',this);" multiple=multiple style="width:80%;">
                    <option value=""></option>
                      <?php if($seq != "annual" && $seq != "attendance" ){ echo "<option value='".$view_val['default_referrer']."'></option>"; } ?>
                      <?php foreach ($user_info as $ui) {
                        echo "<option value='{$ui['user_name']} {$ui['user_duty']}'>{$ui['user_name']} {$ui['user_duty']}</option>";
                      } ?>
                  </select>
                  <img src="<?php echo $misc;?>img/btn_add.jpg" style="cursor:pointer;vertical-align:middle;" border="0" onClick="select_user('referrer');"/>
            </td>
          </tr>
          <tr>
            <td class="basic_td" bgcolor="f8f8f9">???????????????</td>
            <td class="basic_td">
               <input id="approval_attach" name="approval_attach" type="hidden" value="" />
               <div id="approval_attach_list" name="approval_attach_list"> </div>
            </td>
          </tr>
          <tr>
             <td height=40 class="basic_td" bgcolor="f8f8f9">????????????</td>
             <td colspan=3 class="basic_td"><input type="text" id="approval_doc_name" name="approval_doc_name" class="input7" value="<?php if(isset($sales_val)){echo "[IT-".$group."]".$sales_val['customer_companyname'].' '.$sales_val['project_name']; }?>"></td>
          </tr>
        </table>
      </div>

      <div id="formLayoutDiv" style="margin-top:30px;" >
         <?php
            if($seq != "annual" && $seq != "attendance"){
               echo $view_val['preview_html'];
            }else if($seq == "annual"){?>
               <table class="basic_table" width="100%" style="">
                  <tr>
                     <td align="center" bgcolor="f8f8f9" height=40 class="basic_td">??????????????????</td>
                     <td height=40 class="basic_td"><?php echo ($annual['month_annual_cnt']+$annual['annual_cnt']+$annual['adjust_annual_cnt']);?></td>
                     <td align="center" bgcolor="f8f8f9" height=40 class="basic_td">??????????????????(??????)</td>
                     <td height=40 class="basic_td"><?php echo $annual['use_annual_cnt'];?></td>
                     <td align="center" bgcolor="f8f8f9" height=40 class="basic_td">??????????????????</td>
                     <td height=40 class="basic_td"><?php echo $annual['remainder_annual_cnt'];?></td>
                  </tr>
                  <tr>
                     <td align="center" bgcolor="f8f8f9" height=40 class="basic_td"><span style='color:red'>*</span>???????????????</td>
                     <td height=40 class="basic_td"><input type="date" id="annual_application_date" name="annual_application_date" class="input2" value="<?php echo date("Y-m-d") ; ?>" required /></td>
                     <td align="center" bgcolor="f8f8f9" height=40 class="basic_td"><span style='color:red'>*</span>????????????</td>
                     <td height=40 class="basic_td">
                        <select class="input2" id="annual_type" name="annual_type" required >
                           <option value="">??????</option>
                           <option value="001">????????????</option>
                           <option value="002">????????????</option>
                           <option value="003">???/?????? ??????</option>
                           <option value="004">???????????? ??????</option>
                           <option value="005">??????</option>
                        </select>
                     </td>
                     <td align="center" bgcolor="f8f8f9" height=40 class="basic_td"><span style='color:red'>*</span>??????/??????</td>
                     <td height=40 class="basic_td">
                        <select class="input2" id="annual_type2" name="annual_type2" onchange="annual_count();" required>
                           <option value="">??????</option>
                           <option value="001">??????</option>
                           <option value="002">????????????</option>
                           <option value="003">????????????</option>
                        </select>
                     </td>
                  </tr>
                  <tr>
                     <td align="center" bgcolor="f8f8f9" height=40 class="basic_td"><span style='color:red'>*</span>????????????</td>
                     <td colspan=3 height=40 class="basic_td"><input type="date" id="annual_start_date" name="annual_start_date" class="input2" value="<?php echo date("Y-m-d");?>" onchange="annual_end_date_change(this.value)" style="width:115px;" /> ~ <input type="date" id="annual_end_date" name="annual_end_date" class="input2" value="<?php echo date("Y-m-d");?>" onchange="annual_count();" style="width:115px;"/> &nbsp; (?????? : <input type='text' id="annual_cnt" name="annual_cnt" class="input5" value="1" style="width:115px;text-align:center;" readonly /> ) </td>
                     <td align="center" bgcolor="f8f8f9" height=40 class="basic_td">????????????</td>
                     <td height=40 class="basic_td"><input type="text" id="annual_reason" name="annual_reason" class="input2" /></td>
                  </tr>
               </table>
               <div style='margin:30px 0px 10px 0px;'>
                  * ???????????????
               </div>
               <table class="basic_table" width="100%" >
                  <tr>
                     <td align="center" bgcolor="f8f8f9" height=40 class="basic_td"><span style='color:red'>*</span>??????/??????</td>
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
                     <td align="center" bgcolor="f8f8f9" height=40 class="basic_td"><span style='color:red'>*</span>???????????????</td>
                     <td height=40 class="basic_td">
                        <input type="text" id="emergency_phone_num" name="emergency_phone_num" class="input2" onchange="regex(this,'phone_num');" required />
                     </td>
                  </tr>
               </table>
         <?php }else if ($seq == "attendance"){ ?>
             <table class="basic_table" width="100%" style="">
             <tr>
                <td align="center" bgcolor="f8f8f9" height=40 class="basic_td">????????????</td>
                <td height=40 class="basic_td">
                   <input type ="hidden" id="attendance_seq" name="attendance_seq" value="<?php echo $_GET['attendance_seq']; ?>">
                   <input type="text" class="input2" id="attendance_date" name="attendance_date" value="" readonly> </td>
             </tr>
             <tr>
                <td align="center" bgcolor="f8f8f9" height=40 class="basic_td">????????????</td>
                <td height=40 class="basic_td"><input type="text" id="attendance_cur_status" name="attendance_cur_status" class="input2" value="" readonly /></td>
             </tr>
             <tr>
                <td align="center" bgcolor="f8f8f9" height=40 class="basic_td"><span style='color:red'>*</span>????????????</td>
                <td colspan=3 height=40 class="basic_td">
                   ?????? ?????? : <input type="text" id="ws_time" name="ws_time" class="input2" value="" style="width:115px;" autocomplete="off" required/>
                   <br>
                   ?????? ?????? : <input type="text" id="wc_time" name="wc_time" class="input2" value="" style="width:115px;" autocomplete="off" required/>
                   <!-- <inpu/>t type="text" class="input2" name="wc_time" id="wc_time" value="" style="width:115px" autocomplete="off">                                           -->
                </td>
             </tr>
             <tr>
                <td align="center" bgcolor="f8f8f9" height=40 class="basic_td"><span style='color:red'>*</span>????????????</td>
                <td height=40 class="basic_td">
                  <select name="attendance_change_status" id="attendance_change_status" class="input2" required>
                     <option value="????????????">????????????</option>
                     <option value="?????????">?????????</option>
                     <option value="?????????">?????????</option>
                     <option value="??????">??????</option>
                     <option value="????????????">????????????</option>
                     <option value="????????????">????????????</option>
                     <option value="??????">??????</option>
                     <option value="??????">??????</option>
                     <option value="??????">??????</option>
                     <option value="??????">??????</option>
                     <!-- <option value="??????">??????</option> -->
                     <option value="????????????">????????????</option>
                     <option value="??????????????????">??????????????????</option>
                     <option value="??????">??????</option>
                     <option value="??????">??????</option>
                     <option value="????????????">????????????</option>
                  </select>
                </td>
             </tr>
             <tr>
                <td align="center" bgcolor="f8f8f9" height=40 class="basic_td"><span style='color:red'>*</span>??????</td>
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
				 <table class="basic_table" width="100%" height="auto">
							 <tbody id="fileTableTbody">
									<tr>
										 <td id="dropZone">
											 <label class="file_label" for="file_up">???????????????</label>
											 <input type="file" id="file_up" class="file-input" style="display:none;">
										 </td>
									</tr>
							 </tbody>
				 </table>
			</div>

			<div style="text-align:right;margin-top:30px;">
         <input type="button" class="btn-common btn-color2" value="????????????" onclick="chkForm('request');">
         <input type="button" class="btn-common btn-color1" value="????????????" onclick="chkForm('temporary');">
			</div>

    </div>


  </form>
</div>

<div style="position:fixed;bottom:100px;right:5px;">
	<!-- <a href="#"> -->
		<img src="<?php echo $misc; ?>img/mobile/btn_top.svg" onclick="goTop();">
	<!-- </a> -->
</div>

<!-- ????????? ?????? ?????? -->
<div id="select_approval_modal" class="searchModal">
	 <div class="search-modal-content">
				 <div style="height:auto; min-height:300px;overflow:auto;">
						<!-- <input type="button" value="????????? ?????? ??????" style="float:right;margin-bottom:5px;" onclick="select_user_add('all');" > -->
						<table class="basic_table">
								<tr>
									<td align="center">
										<h2 align="center">???????????????</h2>
										 <div class="click_group_user">

											 <?php foreach($user_parents_group as $upg) { ?>
											 				<tr>
											 					<td style="border:none;font-weight: bold;"><?php echo $upg['parentGroupName']; ?></td>
											 				</tr>
											 <?php if(isset($depth1_user[$upg['parentGroupName']])){ ?>
											 				<tr>
											 					<td style="display:flex;align-items:center;flex-wrap:wrap;height:auto;border:none;">
											 <?php foreach($depth1_user[$upg['parentGroupName']] as $du) { ?>
											 						<div class="click_user" seq="<?php echo $du['seq']; ?>" user_name = "<?php echo $du['user_name']; ?>" user_duty="<?php echo $du['user_duty']; ?>" user_group = <?php echo $du['user_group']; ?> style="padding:6px 6px 0px 6px;" onclick="click_user(<?php echo $du['seq'].",'".$du['user_name']; ?>',this);">
																		<?php echo $du['user_name']." ".$du['user_duty']; ?>
																	</div>
											 <?php } ?>
											 					</td>
											 				</tr>
											 <?php } ?>
											 <?php for ($i=0; $i<count($user_group); $i++) { ?>
											 <?php if($upg['parentGroupName'] == $user_group[$i]['parentGroupName'] && $user_group[$i]['groupName'] != $user_group[$i]['parentGroupName']){ ?>
											 				<tr>
											 					<td style="border:none;font-weight: bold;"><?php echo $user_group[$i]['groupName']; ?></td>
											 				</tr>
											 <?php if(isset($depth2_user[$user_group[$i]['groupName']])){ ?>
											 				<tr>
											 					<td style="display:flex;align-items:center;flex-wrap:wrap;height:auto;border:none;">
											 <?php foreach($depth2_user[$user_group[$i]['groupName']] as $du) { ?>
											 						<div class="click_user" style="padding:6px 6px 0px 6px;" seq="<?php echo $du['seq']; ?>" user_name = "<?php echo $du['user_name']; ?>" user_duty="<?php echo $du['user_duty']; ?>" user_group = <?php echo $du['user_group']; ?> onclick="click_user(<?php echo $du['seq'].",'".$du['user_name']; ?>',this);">
																	<?php echo $du['user_name']." ".$du['user_duty']; ?>
																</div>


											 <?php } ?>
											 					</td>
											 				</tr>
											 <?php } ?>
											 <?php } ?>
											 <?php } ?>
											 <?php } ?>

										 </div>
									</td>
								</tr>
								<tr>
									<td class ="basic_td" align="left">
										 <span style="font-weight:bold;">????????????</span>
										 <div>
											 <span>
												<input type="radio" name="approval_type" value="??????" checked />??????
												<input type="radio" name="approval_type" value="??????" />??????
												<img src="<?php echo $misc;?>img/btn_del.jpg" style="cursor:pointer;width:22px;height:22px;vertical-align: bottom;float:right;" border="0" onClick="approver_del('all');"/>
												<img src="<?php echo $misc;?>img/mobile/btn_up.svg" style="cursor:pointer;width:22px;height:22px;vertical-align: bottom;float:right;" border="0" onClick="approver_del();"/>
												<img src="<?php echo $misc;?>img/mobile/btn_down.svg" style="cursor:pointer;width:22px;height:22px;vertical-align: bottom;float:right;" border="0" onClick="approver_add();"/>
											</span>
										 </div>
									</td>
								</tr>
								<tr>
									<td class ="" align="center">
										 <div style="background-color:#f8f8f9;margin-top:20px;text-align:left;">
											 <table cellspacing="0">
											 	 	<td style="width:40%;padding:0;background-color:#F4F4F4;">????????? ?????????</td>
													<td style="width:40%;padding:0;">
														<select id="select_user_approval_line" name="select_user_approval_line" class="input5" onchange="click_user_approval_line();" style="height:100%;">
		 													<option value="">-- ?????? --</option>
		 													<?php
		 													if(!empty($user_approval_line)){
		 													foreach($user_approval_line as $ual){
		 													 echo "<option value='{$ual['seq']}'>{$ual['approval_line_name']}</option>";
		 													}}?>
		 											 </select>
													</td>
													<td style="width:20%;padding:0;">
														 <button type="button" name="button" class="btn-common btn-style2" style="width:100%;height:100%" onclick="user_approval_line_delete();">??????</button>
													</td>
											 	 </tr>
											 </table>

										 <table id="select_approver" width="90%" class="basic_table sortable">
												<tr class="ui-state-disabled" bgcolor="f8f8f9">
													 <td height="30"></td>
													 <td height="30">??????</td>
													 <td height="30"><?php echo $name." ".$duty." ".$group; ?></td>
												</tr>
										 </table>
										 <table cellspacing="0">
											 <td style="width:40%;padding:0;background-color:#F4F4F4;">????????? ????????????</td>

											 <td style="width:40%;padding:0;">
												 <input type="text" id="approval_line_name" name="approval_line_name"class="input5" style="height:100%;">
											 </td>
											 <td style="width:20%;padding:0;">
												 <button type="button" class="btn-common btn-style2" style="width:100%;height:100%;" name="button" onclick="user_approval_line_save();">??????</button>
											 </td>

										 </table>
									 	</div>
									</td>
							 </tr>
						</table>
				 </div>
				 <div style=" text-align: center; margin-top:10px;">
					 <button type="button" name="button" class="btn-common btn-color1" style="width:45%;" onClick="closeModal();">??????</button>
					 <button type="button" name="button" class="btn-common btn-color2" style="width:45%;" onClick="saveApproverLineModal();">??????</button>
				 </div>
	 </div>
</div>
<!-- ????????? ?????? ??? -->

	<?php include $this->input->server('DOCUMENT_ROOT')."/include/mobile_bottom.php"; ?>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.css" rel="stylesheet">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.js"></script>
  <script>
     $("tr[name*=multi_row]").closest("table").find("tr:eq(1) img").each(function(){
       if ($(this).attr('onclick')=="delRow(this)") {
         $(this).hide();
       }
     });
     //??????????????? ????????? ??????
     // if($(".user_select").length > 1){
        var option = '<option value=""></option>';
        <?php foreach ($user_info as $ui) {?>
        option += "<option value='<?php echo $ui['user_name'].' '.$ui['user_duty'];?>'><?php echo $ui['user_name'].' '.$ui['user_duty']; ?></option>";
        <?php } ?>

        $(".user_select").html(option);

        $(".user_select").select2({
           placeholder: '????????? ??????'
        });
     // }

     //????????? ?????? select2 multi
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


     //?????????????????????
     <?php if ($seq == "attendance"){ ?>
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

     //???????????? ?????? ??????????????? ?????????
     <?php if(isset($view_val)){
              if($view_val['default_approval_line']!="" && $view_val['default_approval_line']!="N") {?>
              click_user_approval_line(<?php echo $view_val['default_approval_line']?>);
              saveApproverLineModal();
     <?php }} ?>


      // ?????? ????????? ??????
      var fileIndex = 0;
      // ????????? ?????? ?????? ?????????
      var totalFileSize = 0;
      // ?????? ?????????
      var fileList = new Array();
      // ?????? ????????? ?????????
      var fileSizeList = new Array();
      // ?????? ????????? ?????? ????????? MB
      var uploadSize = 50;
      // ?????? ????????? ??? ?????? ????????? MB
      var maxUploadSize = 500;

      $(function (){
          // ?????? ?????? ??????
          fileDropDown();
      });

			$("#file_up").change(function(e){
				var file = this.files;
				selectFile(file);

			})
      // ?????? ?????? ??????
      function fileDropDown(){
          var dropZone = $("#dropZone");
          //Drag??????
          dropZone.on('dragenter',function(e){
              e.stopPropagation();
              e.preventDefault();
              // ???????????? ?????? css
              dropZone.css('background-color','#E3F2FC');
          });
          dropZone.on('dragleave',function(e){
              e.stopPropagation();
              e.preventDefault();
              // ???????????? ?????? css
              dropZone.css('background-color','#FFFFFF');
          });
          dropZone.on('dragover',function(e){
              e.stopPropagation();
              e.preventDefault();
              // ???????????? ?????? css
              dropZone.css('background-color','#E3F2FC');
          });
          dropZone.on('drop',function(e){
              e.preventDefault();
              // ???????????? ?????? css
              dropZone.css('background-color','#FFFFFF');

              var files = e.originalEvent.dataTransfer.files;
							// console.log(e);
              if(files != null){
                  if(files.length < 1){
                      alert("?????? ????????? ??????");
                      return;
                  }
                  selectFile(files)
              }else{
                  alert("ERROR");
              }
          });
      }

      // ?????? ?????????
      function selectFile(files){
          // ???????????? ??????
          if(files != null){
              for(var i = 0; i < files.length; i++){
                  // ?????? ??????
                  var fileName = files[i].name;
                  var fileNameArr = fileName.split("\.");
                  // ?????????
                  var ext = fileNameArr[fileNameArr.length - 1];
                  // ?????? ?????????(?????? :MB)
                  var fileSize = files[i].size / 1024 / 1024;

                  if($.inArray(ext, ['exe', 'bat', 'sh', 'java', 'jsp', 'html', 'js', 'css', 'xml']) >= 0){
                      // ????????? ??????
                      alert("?????? ?????? ?????????");
                      break;
                  }else if(fileSize > uploadSize){
                      // ?????? ????????? ??????
                      alert("?????? ??????\n????????? ?????? ?????? : " + uploadSize + " MB");
                      break;
                  }else{
                      // ?????? ?????? ?????????
                      totalFileSize += fileSize;

                      // ?????? ????????? ??????
                      fileList[fileIndex] = files[i];

                      // ?????? ????????? ????????? ??????
                      fileSizeList[fileIndex] = fileSize;

                      // ????????? ?????? ?????? ??????
                      addFileList(fileIndex, fileName, fileSize);

                      // ?????? ?????? ??????
                      fileIndex++;
                  }
              }
          }else{
              alert("ERROR");
          }
      }

      // ????????? ?????? ?????? ??????
      function addFileList(fIndex, fileName, fileSize){
          var html = "";
          html += "<tr id='fileTr_" + fIndex + "'>";
          html += "    <td class='left' >";
          html +=         fileName + " / " + fileSize + "MB "  + "<a href='#' onclick='deleteFile(" + fIndex + "); return false;' class='btn small bg_02'><img src='<?php echo $misc;?>/img/btn_del2.jpg' style='vertical-align:middle;'></a>";
          html += "    </td>";
          html += "</tr>";

          $('#fileTableTbody').append(html);
      }

      // ????????? ?????? ??????
      function deleteFile(fIndex){
          // ?????? ?????? ????????? ??????
          totalFileSize -= fileSizeList[fIndex];

          // ?????? ???????????? ??????
          delete fileList[fIndex];

          // ?????? ????????? ?????? ??????
          delete fileSizeList[fIndex];

          // ????????? ?????? ????????? ???????????? ??????
          $("#fileTr_" + fIndex).remove();
      }

     <?php if(isset($view_val)){?>
     if('<?php echo $view_val['editor_use']; ?>' =='Y'){
        $('#summernote').summernote({ placeholder: 'Hello stand alone ui', tabsize: 2, height: 200 });
     }
     <?php } ?>

     //????????? ??????
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

     //?????? ??????
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

     //?????? ?????? ??????
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

     //user || approver ??????
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

     //group ??????
     function click_group(obj,val){
        $(".groupTree").find("span").css('background-color','');
        $(".select_group").css('background-color','');
        $("#click_user").attr('id','');
        $(obj).css('background-color','#d3d3d3');
        $(obj).attr('id','click_user');
        $("#click_user_seq").val(val);
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

     //group ??????
     function select_group_add(){
        var html = "<div class='select_group' onclick='click_group(this)'>"+$("#click_user_seq").val()+"</div>";
        $("#select_group").html($("#select_group").html()+html);
     }

     //????????? user ?????? ??????
     function select_group_del(type){
        if(type == "all"){
           $(".select_group").remove();
        }else{
           if($("#click_user").attr('class') == 'select_group'){
              $("#click_user").remove();
           }
        }
     }

     //????????? ?????? ?????? ??????
     function closeModal(){
        var check = confirm("??? ??????????????? ?????????????????????? ???????????? ????????? ?????? ?????? ????????????.")
        if(check == true){
           // $(".searchModal").hide();
					 	$("#select_approval_modal").bPopup().close();
        }else{
           return false;
        }
     }

     function select_approval_modal(){
        // $("#click_user").css('background-color','');
        // $("#click_user").attr('id','');
        // $("#select_approval_modal").show();
				$("#select_approval_modal").bPopup();
     }

     //????????? ??????
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
              if($("#select_approver").find($("td")).eq(i).html() == "??????"){
                 $("#select_approver").find($("td")).eq(i).html("");
              }
           }
					 var click_group = $("#click_user").attr("user_group");
					 var click_name = $("#click_user").attr("user_name");
					 var click_duty = $("#click_user").attr("user_duty");
					 var click_html = click_name +" " + click_duty+ " " +click_group;
           var html = "<tr class='select_approver' onclick='click_user("+$("#click_user_seq").val()+',"'+click_html+'"'+",this)'>";
           html += "<td height=30>??????</td><td onclick='change_approval_type(this);' style='cursor:pointer;'>"+approval_type+"</td><td>"+click_html+"<input type='hidden' name='approval_line_seq' value='"+$("#click_user_seq").val()+"' /><input type='hidden' name='approval_line_type' value='"+approval_type+"' /></td>";
           html += "</tr>";
           $("#select_approver").html($("#select_approver").html()+html);
        }
     }

     //????????? ??????
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

     //sortable tr ????????????
     // $(".sortable").sortable({
     //    items: "tr:not(.ui-state-disabled)",
     //    start: function(event, ui) {
     //       finalReferrer();
     //    },
     //    stop: function(event, ui) {
     //       finalReferrer();
     //    },
     // });

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

     //?????? <-> ?????? ??????
     function change_approval_type(obj){
        var approval_line_type = $(obj).parent().find($("input[name=approval_line_type]"));
        if($(obj).html()=="??????"){
           $(obj).html("??????");
           approval_line_type.val("??????");
        }else{
           $(obj).html("??????");
           approval_line_type.val("??????");
        }
     }
     //????????? ??????
     function saveApproverLineModal(){
        var tr = $("#select_approver").find($("tr"));
        $("#approver_line_table").find($("tr")).eq(0).html('<td height=40 rowspan=2 class="basic_td" width="20px" bgcolor="f8f8f9" >??????</td>');
        $("#approver_line_table").find($("tr")).eq(1).html("");

        $("#agreement_line_table").find($("tr")).eq(0).html('<td height=40 rowspan=2 class="basic_td" width="20px" bgcolor="f8f8f9" >??????</td>');
        $("#agreement_line_table").find($("tr")).eq(1).html("");
        for(i=0; i<tr.length; i++){
           if(tr.eq(i).html().indexOf("??????") != -1){ //????????????
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
        // $("#select_approval_modal").hide();
				$("#select_approval_modal").bPopup().close();
     }


     function chkForm(t) {
        if(trim($("#approval_doc_name").val()) == ""){
           $("#approval_doc_name").focus();
           alert("??????????????? ??????????????????.");
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
                    alert('?????? ????????? ??????????????????.');
                    return false;
                 }
              }
           }else{
              if(tt.prop("required")) {
                 if(!jQuery.trim(tt.val())) {
                    check = false;
                    tt.focus();
                    alert(" ?????? ???????????? ???????????????.");
                    return false;
                 }
              }
           }
        });
        if(check == false){ // ?????? ??? ??????
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
                    alert("????????? ????????? ?????????????????? ???????????????.")
                    check = false;
                    return false;
                 }
              }
           });
        }

        if(check == false){ // ?????? ??? ??????
           return false;
        }

        if (confirm("?????? ???????????????????")) {
           var mform = document.cform;
           $("#formLayoutDiv").find($("input")).each(function(){ this.defaultValue = this.value;});
           $("#formLayoutDiv").find($("[type=text],textarea")).each(function(){ this.defaultValue = this.value;});
           $("#formLayoutDiv").find($("select option")).each(function(){ this.defaultSelected = this.selected;});
           $("#formLayoutDiv").find($("[type=checkbox],[type=radio]")).each(function(){ this.defaultChecked = this.checked;});
           $("#contents_html").val($("#formLayoutDiv").html());

           // ?????? ????????? ???????????? ??????
           if ($("#req_support_seq").val()!="") {
             var schedule_date = $(".tr6_td9").eq(0).val();
             var m1 = $("#tr6_td5_sum").val();
             var m2 = $("#tr6_td6_sum").val();
             var m3 = $("#tr6_td7_sum").val();

             $("#req_support_data").val(m1 + "*/*" + m2 + "*/*" + m3 + "*/*" + schedule_date);
             // alert($("#req_support_data").val());
             // return false;
           }

           <?php if(isset($view_val)){ ?>
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
              alert("???????????? ??????????????????.");
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

           // ????????? ?????? ?????????
           var uploadFileList = Object.keys(fileList);

           // ????????? ????????? ??????
           formData.append('file_length', uploadFileList.length);
           if(uploadFileList.length > 0){
               // ????????? 500MB??? ?????? ?????? ????????? ??????
              if (totalFileSize > maxUploadSize) {
                 // ?????? ????????? ?????? ?????????
                 alert("??? ?????? ??????\n??? ????????? ?????? ?????? : " + maxUploadSize + " MB");
                 return;
              }

              // ????????? ?????? ???????????? formData??? ????????? ??????
              for (var i = 0; i < uploadFileList.length; i++) {
                 formData.append('files' + i, fileList[uploadFileList[i]]);
              }

           }

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
                    alert("?????? ??????");
                    if($("#approval_doc_status").val() == "001"){
                       location.href ="<?php echo site_url();?>/biz/approval/electronic_approval_doc_list?type=request";
                    }else{
                       location.href ="<?php echo site_url();?>/biz/approval/electronic_approval_doc_list?type=temporary";
                    }
                 } else {
                    alert("????????? ?????????????????????. ??????????????? ???????????????.");
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

     function addRow(obj){
        var tr_name = $(obj).parent().parent().attr('name');
        var tr_last = $('tr[name='+tr_name+']')[$('tr[name='+tr_name+']').length-1];
        var tr_last_html = tr_last.outerHTML;
        $(tr_last).after(tr_last_html);
        var new_tr = $('tr[name='+tr_name+']')[$('tr[name='+tr_name+']').length-1];
        $(new_tr).find("img").show();
        for(i=0; i<$(new_tr).find($("input")).length; i++){
           if($(new_tr).find($("input")).eq(i).val().indexOf("express") != -1){
              $(new_tr).find($("input")).eq(i).val(''); //????????? ???????????? input ??????
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

     //????????? ?????? ??????
     function attachRemove(seq){
        $("#attach_"+seq).remove();
        if($("#approval_attach").val().indexOf(','+seq) != -1){
           $("#approval_attach").val($("#approval_attach").val().replace(','+seq,''))
        }else{
           $("#approval_attach").val($("#approval_attach").val().replace(seq+',',''));
        }
     }

     //????????? ????????? ??????
     function user_approval_line_save(){
        if($("#approval_line_name").val() == ""){
           $("#approval_line_name").focus();
           alert("??????????????? ???????????????");
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
                    alert("????????? ?????????????????????.");
                    $("#approval_line_name").val("");
                 }else{
                    alert("????????? ????????? ?????????????????????.");
                 }
              }
           });
        }
     }

     //????????? ????????? ??????
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
                 alert("????????? ?????????????????????.");
                 $("#approval_line_name").val("");
              }else{
                 alert("????????? ????????? ?????????????????????.");
              }
           }
        });
     }

     //????????? ????????? ??????
     function click_user_approval_line(seq){
        $("#select_approver").html('<tr class="ui-state-disabled" bgcolor="f8f8f9"><td height="30"></td><td height="30">??????</td><td height="30"><?php echo $name." ".$duty." ".$group; ?></td></tr>');
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

     //????????????
     function cancel(){
        if(confirm("??? ??????????????? ?????????????????????? ???????????? ????????? ?????? ?????? ????????????.")){
           location.href='<?php echo site_url(); ?>/biz/approval/electronic_approval_form_list?mode=user'
        }else{
           return false;
        }
     }

     //?????? ?????? ????????? ?????? close
     $(document).mouseup(function (e) {
     var container = $('.searchModal');
     if (container.has(e.target).length === 0) {
        container.css('display', 'none');
     }
     });

     //??????????????? ????????? ????????????????????? ?????? ??????
     function annual_end_date_change(val){
        $("#annual_end_date").val(val);
        $("#annual_end_date").change();
     }

     //?????? ?????? ??????(?????? ?????? ??????)
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
              if(tmp == 0 || tmp == 6) {  // ??????
              } else {  // ??????
                 count++;
              }
              temp_date.setDate(start_date.getDate() + 1);
           }
        }
        if($("#annual_type2").val() != "001"){//???????????????
           count = count * 0.5;
        }
        $("#annual_cnt").val(count);
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
  /////////////////////////////////////////////////??????????????? ????????? ??????///////////////////////////////////////
     <?php
     if(isset($_GET['sales_seq']) || isset($_GET['maintain_seq'])){ ?> //??????,??????,??????,???????????? ??????
       <?php if($seq ==39){ ?>
         $('#html td:contains("End-User")').next().find("textarea").val('<?php echo $sales_val['customer_companyname']; ?>'); //end-user
       <?php }else{ ?>
         $('#html td:contains("End-User")').next().find("input").val('<?php echo $sales_val['customer_companyname']; ?>'); //end-user
       <?php } ?>

       <?php if($seq == 38){ ?>
        $('#html td:contains("VAT")').next().find("input").val('<?php echo $sales_val['procurement_sales_amount']; ?>');
       <?php } ?>
        var purchase_tb=  $('#html .basic_table td:contains("?????????")').closest("table");
        var sales_tb=  $('#html .basic_table td:contains("?????????")').closest("table");
     <?php if(isset($_GET['sales_seq'])){
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
                       $(purchase_tb).find("tr:eq(<?php echo ($i+1); ?>) td:eq(1) input").val('<?php echo $sv4['product_name']; ?>'+" ???")
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
                      $(purchase_tb).find("tr:eq(<?php echo ($i+1); ?>) td:eq(1) input").val('<?php echo $sv4['product_name']; ?>'+" ???")
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
     $product_cnt = 1;
     if(count($sales_val4) == 1){
        $product_cnt = count($sales_val3);
     }else{
        if(count($sales_val3) > 1){
        $product_name .= " ???";
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

  <?php }else if (isset($_GET['maintain_seq'])){ ?>//??????????????? ???????????? ???????????????
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
              if($sales_val2[$i]['main_companyname'] == $sv4['product_supplier']){?>
                 <?php if($j == 0){
                    if($sv4['product_row'] <= 1){
                       $p_cnt ='';
                       if($sv4['product_cnt'] > 1){
                          $p_cnt = " ".$sv4['product_cnt'].'???';
                       }?>
                       $(purchase_tb).find("tr:eq(<?php echo ($i+1); ?>) td:eq(1) input").val('<?php echo $sv4['product_name']; ?>'+'<?php echo $p_cnt; ?>'+" ????????????");
                    <?php }else{?>
                       $(purchase_tb).find("tr:eq(<?php echo ($i+1); ?>) td:eq(1) input").val('<?php echo $sv4['product_name']; ?>'+" ??? "+<?php echo $sv4['product_row']-1; ?> +"???")
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
                    $(purchase_tb).find("tr:eq(<?php echo ($i+1); ?>) td:eq(8) select").val('<?php echo date_format(date_create($issue_schedule_date),"j"); ?>');
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
        product_name += ' <?php echo ($sales_val3_cnt+$sales_val5_cnt); ?>'+"???";
     <?php }else if(($sales_val3_cnt+$sales_val5_cnt)>1){ ?>
        product_name += " ??? " + '<?php echo (($sales_val3_cnt+$sales_val5_cnt)-1); ?>' + "???";
     <?php } ?>
        product_name += " ????????????";
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
        $('#fileTableTbody:last').after('<tr><td>'+req_file_real_name_arr[i]+'<span style="font-weight:bold;"> (????????????)</span></td></tr>');
      }
    })
  <?php } ?>

	function goTop() {
		$('html').scrollTop(0);
	}

  </script>

</body>

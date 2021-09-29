
<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_header.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_side.php";
 ?>
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" /> <!-- 조직도 생성 -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
<script type="text/javascript" src="/misc/js/jquery.bpopup-0.1.1.min.js"></script>
<script language="javascript">

function chkForm () {
	var mform = document.cform;

	if (mform.room_name.value == "") {
		mform.room_name.focus();
		alert("회의실 명을 입력해 주세요.");
		return false;
	}
	if (mform.location.value == "") {
		mform.location.focus();
		alert("위치를 입력해 주세요.");
		return false;
	}

	mform.submit();
	return false;
}

function chkForm2 () {
	if (confirm("정말 삭제하시겠습니까?") == true){
		var mform = document.cform;
		mform.action="<?php echo site_url();?>/equipment/meeting_room_delete_action";
		mform.submit();
		return false;
	}
}
</script>

<div align="main_contents">
	<div class="dash1-1">
		<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
			<form name="cform" action="<?php echo site_url();?>/equipment/meeting_room_input_action" method="post" onSubmit="javascript:chkForm();return false;">
				<input type="hidden" name="seq" value="<?php echo $seq;?>">
				<tbody>
					<tr height="5%">
						<td class="dash_title">
							<img src="<?php echo $misc; ?>img/dashboard/title_meeting_room_list.png"/>
						</td>
					</tr>
					<tr height="13%">
					</tr>
					<tr style="max-height:45%">
						<td colspan="2" valign="top" style="padding:10px 0px;">
					    <table class="content_dash_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
				        <tr>
				          <td align="center" valign="top">
				            <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
					              <tr>
					                <td align="center" valign="top">
														<table width="100%" border="0" cellspacing="0" cellpadding="0">
						                  <colgroup>
																<col width="15%" />
						                  	<col width="15%" />
						                    <col width="55%" />
																<col width="15%" />
						                  </colgroup>
						                  <tr>
																<td></td>
						                  	<td height="60" align="center" style="font-weight:bold;">*회의실 명</td>
						                    <td align="left" style="padding-left:10px;">
																	<input name="room_name" type="text" class="input2" id="room_name" value="<?php echo stripslashes($view_val['room_name']);?>"/>
																</td>
																<td></td>
						                 </tr>
						                 <tr>
															 <td></td>
						                    <td height="60" align="center" style="font-weight:bold;">*위치</td>
						                    <td align="left" style="padding-left:10px;">
																	<input name="location" type="text" class="input2" style="width:90%" id="location" value="<?php echo stripslashes($view_val['location']);?>"/>
																</td>
																<td></td>
						                  </tr>
						                </table>
													</td>
					              </tr>
						              <!--//등록-->
											</table>
										</td>
									</tr>
								</table>
	            <tr>
	              <td height="10"></td>
	            </tr>
	            <!--버튼-->
	            <tr>
	              <td align="center">
									<img src="<?php echo $misc;?>img/dashboard/btn/btn_list.png" width="64" height="31" onClick="javascript:history.go(-1)" style="cursor:pointer"/>뒤로

	                <input type="image" src="<?php echo $misc;?>img/dashboard/btn/btn_adjust.png" width="64" height="31" style="cursor:pointer" onclick="javascript:chkForm();return false;"/> <img src="<?php echo $misc;?>img/dashboard/btn/btn_delete.png" width="64" height="31" style="cursor:pointer" border="0" onclick="javascript:chkForm2();return false;"/>삭제</td>

	            </tr>
	            <!--//버튼-->
	            <tr>
	              <td>&nbsp;</td>
	            </tr>
          <!--//내용-->
				    </td>
				  </tr>
				</tbody>
			</form>
		</table>
	</div>
</div>

</body>
</html>

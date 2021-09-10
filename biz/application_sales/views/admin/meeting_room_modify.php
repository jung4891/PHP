<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<style>
	p, div, span, a, a:hover, a:visited, a:active, label, input, h1,h2,h3,h4,h5,h6{font-family: "Noto Sans KR";}
</style>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" /> <!-- 조직도 생성 -->
<link rel="stylesheet" href="/misc/css/tech_schedule/proton/style.min.css" /> <!-- 조직도 생성 -->
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
		mform.action="<?php echo site_url();?>/admin/equipment/meeting_room_delete_action";
		mform.submit();
		return false;
	}
}
</script>
<body>
<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
<div align="center">
	<div class="dash1-1">
		<table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
			<form name="cform" action="<?php echo site_url();?>/admin/equipment/meeting_room_input_action" method="post" onSubmit="javascript:chkForm();return false;">
				<input type="hidden" name="seq" value="<?php echo $seq;?>">
				<tbody>
					<tr height="5%">
						<td class="dash_title">
							회의실관리
						</td>
					</tr>
					<tr>
						<td height="40"></td>
					</tr>
					<tr>
						<td align="right">
						<?php if($admin_lv == 3){?>
							<input type="button" class="btn-common btn-color1" value="삭제" onclick="javascript:chkForm2();return false;" style="margin-right:10px">
							<input type="button" class="btn-common btn-color1" value="수정" onclick="javascript:chkForm();return false;" style="margin-right:10px">
						<?php } ?>
							<input type="button" class="btn-common btn-color2" value="목록" onClick="javascript:history.go(-1)">
						</td>
	        </tr>
					<tr>
						<td height="40"></td>
					</tr>
					<tr style="max-height:45%">
						<td colspan="2" valign="top" style="padding:10px 0px;">
					    <table class="content_dash_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
				        <tr>
				          <td align="center" valign="top">
				            <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
					              <tr>
					                <td align="center" valign="top">
														<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list_tbl">
						                  <colgroup>
																<col width="15%" />
						                  	<col width="35%" />
						                    <col width="15%" />
						                    <col width="35%" />
						                  </colgroup>
						                  <tr class="border-t">
						                  	<td class="tbl-title border-l">*회의실 명</td>
						                    <td class="tbl-cell">
																	<input name="room_name" type="text" class="input-common" id="room_name" value="<?php echo stripslashes($view_val['room_name']);?>"/>
																</td>
																<td class="tbl-title">*위치</td>
																<td class="tbl-cell border-r">
																	<input name="location" type="text" class="input-common" style="width:90%" id="location" value="<?php echo stripslashes($view_val['location']);?>"/>
																</td>
						                 </tr>
						                </table>
													</td>
					              </tr>
						              <!--//등록-->
											</table>
										</td>
									</tr>
								</table>
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
<!--하단-->
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
<!--//하단-->
</body>
</html>

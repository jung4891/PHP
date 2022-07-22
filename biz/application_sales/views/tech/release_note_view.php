<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<script language="javascript">
function chkForm( type ) {
	if(type == 1) {
		if (confirm("등록된 모든 코멘트들도 삭제됩니다. 정말 삭제하시겠습니까?") == true){

			var mform = document.cform;
			mform.action="<?php echo site_url();?>/tech/board/release_note_delete_action";
			mform.submit();
			return false;
		}
	} else {
		var mform = document.cform;
		mform.action="<?php echo site_url();?>/tech/board/release_note_view";
		mform.submit();
		return false;
	}
}

function chkForm2() {
	var rform = document.rform;

	if (rform.comment.value == "") {
		rform.comment.focus();
		alert("답변을 등록해 주세요.");
		return false;
	}

	rform.action="<?php echo site_url();?>/tech/board/release_note_comment_action";
	rform.submit();
	return false;
}

function chkForm3(seq) {
	if (confirm("정말 삭제하시겠습니까?") == true){
		var rform = document.rform;
		rform.cseq.value = seq;
		rform.action="<?php echo site_url();?>/tech/board/release_note_comment_delete";
		rform.submit();
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
			<form name="cform" method="get">
				<input type="hidden" name="seq" value="<?php echo $seq;?>">
				<input type="hidden" name="mode" value="modify">
				<tr height="5%">
					<td class="dash_title">
						릴리즈노트
					</td>
				</tr>
				<tr>
					<td height="40"></td>
				</tr>
				<tr>
					<td align="right">
		<?php if($id == $view_val['user_id'] || $tech_lv == 3) {?>
						<input type="button" class="btn-common btn-color4" value="삭제" onClick="javascript:chkForm(1);return false;" style="margin-right:10px">
						<input type="button" class="btn-common btn-color4" value="수정" onClick="javascript:chkForm(0);return false;" style="margin-right:10px">
		<?php }?>
						<input type="button" class="btn-common btn-color2" value="목록" onClick="javascript:history.go(-1);">
					</td>
				</tr>
    		<tr>
      		<td width="100%" align="center" valign="top">
						<table class="list_tbl" width="100%" border="0" cellspacing="0" cellpadding="0" style="table-layout:fixed; word-break:break-all;border: thin solid #DFDFDF;margin-bottom:50px;margin-top:20px;">
							<colgroup>
								<col width="15%">
								<col width="35%">
								<col width="15%">
								<col width="35%">
							</colgroup>
        			<tr>
          			<td class="tbl-title">카테고리</td>
          			<td class="tbl-cell">
						<?php
						foreach ($category  as $val) {
							if( $view_val['category_code'] == $val['seq'] ) {
								echo $val['company_name'];
							}
						}
						?></td>
          			<td class="tbl-title">날짜</td>
          			<td class="tbl-mid"><?php echo $view_val['insert_date'];?></td>
              </tr>
              <tr>
                <td class="tbl-title">제목</td>
                <td class="tbl-cell"><?php echo stripslashes($view_val['subject']);?></td>
                <td class="tbl-title">등록자</td>
                <td class="tbl-mid"><?php echo $view_val['user_name'];?></td>
              </tr>
              <tr>
                <td colspan="4" class="tbl-contents"><?php echo $view_val['contents'];?></td>
              </tr>
							<tr>
								<td class="tbl-title">첨부파일</td>
								<td colspan=3 class="tbl-cell">
									 <?php
										 if($view_val['file_realname'] != ""){
												$file = explode('*/*',$view_val['file_realname']);
												$file_url = explode('*/*',$view_val['file_changename']);
												for($i=0; $i<count($file); $i++){
													 echo $file[$i];
													 echo "<a href='{$misc}upload/tech/release_note/{$file_url[$i]}' download='{$file[$i]}'> <img src='{$misc}img/download.svg' style='width:15px;vertical-align:middle;cursor:pointer;margin:5px 0px 5px 10px;'></a><br>";
												}
										 }
									 ?>
								</td>
              </tr>
            </table>
					</td>
				</tr>
			</form>
		</table>
		<table width="95%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:20px;">
			<form name="rform" method="post">
			<input type="hidden" name="seq" value="<?php echo $seq;?>">
			<input type="hidden" name="cseq" value="">
	 	<?php
			foreach ( $clist_val as $item ) {
		?>
			<tr>
			 	<td bgcolor="f8f8f9">
					<table width="100%" border="0" cellspacing="0" cellpadding="5" style="border: thin solid #DFDFDF">
				 		<tr height="30px">
					 		<td width="100px" class="tbl-mid" style="border-right: thin solid #DFDFDF;">
								<?php echo $item['user_name'];?>
							</td>
					 		<td width="100px" class="tbl-mid" style="border-right: thin solid #DFDFDF;">
								<?php echo substr($item['insert_date'], 0, 10);?>
							</td>
					 		<td align="right">
								<?php if($id == $item['user_id'] or $tech_lv == 3) {?>
									<img src="<?php echo $misc;?>img/btn_del.svg" width="18" height="17" style="cursor:pointer" border="0" onClick="javascript:chkForm3('<?php echo $item['seq']?>');return false;"/>
								<?php }?>
							</td>
				 		</tr>
			 		</table>
		 		</td>
			</tr>
			<tr>
				<td style="padding-left:40px;height:30px;border: thin solid #DFDFDF;border-top:none;">
					<?php echo nl2br(str_replace(" ", "&nbsp;", htmlspecialchars($item['contents'])))?>
				</td>
			</tr>
		<?php
			}
		?>
			<tr>
				<td>
					<table width="100%" border="0" cellspacing="0" cellpadding="5" style='border: thin solid #DFDFDF;'>
						<tr height="30px" class="row-color1">
							<td width="100px" class="tbl-mid" style="border-right: thin solid #DFDFDF;">
								<?php echo $name;?>
							</td>
							<td width="100px" class="tbl-mid" style="border-right: thin solid #DFDFDF;">
								<?php echo date("Y-m-d");?>
							</td>
							<td align="right"></td>
						</tr>
						<tr>
							<td class="answer2" colspan="3" align="center">
								<textarea name="comment" id="comment" rows="5" class="input_answer1" style="width:100%;"></textarea>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</form>
		</table>
		<div style="width:95%;">
			<input type="button" class="btn-common btn-style1" value="답변등록" onClick="javascript:chkForm2();return false;" style="float:right;margin-bottom:50px;width:90px;">
		</div>
	</div>
</div>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
</body>
</html>

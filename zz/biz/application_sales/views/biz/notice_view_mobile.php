<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<style media="screen">
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
.contents_div {
	overflow-x: scroll;
	white-space: nowrap;
}
</style>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<script language="javascript">
function chkForm( type ) {
	if(type == 1) {
		if (confirm("정말 삭제하시겠습니까?") == true){
			var mform = document.cform;
			mform.action="<?php echo site_url();?>/biz/board/notice_delete_action";
			mform.submit();
			return false;
		}
	} else {
		if($('#is_mobile').val() == 'N') {
			alert('모바일에서 작성된 글만 수정 가능합니다.');
			return false;
		} else {
			var mform = document.cform;
			mform.action="<?php echo site_url();?>/biz/board/notice_view";
			mform.submit();
			return false;
		}
	}
}
//$(document).ready(function() {
//   $('li > ul').show();
//});
</script>
<body>
<meta name="viewport" content="width=device-width,height=device-width, initial-scale=1.0">
<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/mobile_side.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/mobile_header.php";
	?>
<form name="cform" method="get">
<input type="hidden" name="seq" value="<?php echo $seq;?>">
<input type="hidden" name="category" value="<?php echo $category;?>">
<input type="hidden" id="is_mobile" value="<?php echo $view_val['is_mobile'];?>">
<input type="hidden" name="mode" value="modify">
<div style="max-width:90%;margin: 0 auto; padding-bottom: 60px;margin-top:30px;">
	<div width="100%">
		<table class="basic_table">
			<col width="30%">
			<col width="70%">
			<tr>
				<td bgcolor="#F4F4F4" style="font-weight:bold;">카테고리</td>
				<td>
					<?php
						if($view_val['category_code'] == '001'){
							echo '운영공지';
						}else if($view_val['category_code'] == '002'){
							echo '개발공지';
						}else if($view_val['category_code'] == '003'){
							echo '버전관리';
						}
					?>
				</td>
			</tr>
			<tr>
				<td bgcolor="#F4F4F4" style="font-weight:bold;">날짜</td>
				<td><?php echo $view_val['update_date'];?></td>
			</tr>
			<tr>
				<td bgcolor="#F4F4F4" style="font-weight:bold;">제목</td>
				<td><?php echo stripslashes($view_val['subject']);?></td>
			</tr>
			<tr>
				<td bgcolor="#F4F4F4" style="font-weight:bold;">등록자</td>
				<td><?php echo $view_val['user_name'];?></td>
			</tr>
		</table>
		<div class="contents_div">
			<?php echo $view_val['contents']; ?>
		</div>
		<table class="basic_table">
			<col width="30%">
			<col width="70%">
			<tr>
				<td bgcolor="#F4F4F4" style="font-weight:bold;">첨부파일</td>
				<td>
					<?php
						 if($view_val['file_realname'] != ""){
								$file = explode('*/*',$view_val['file_realname']);
								$file_url = explode('*/*',$view_val['file_changename']);
								for($i=0; $i<count($file); $i++){
									 echo $file[$i];
									 echo "<a href='{$misc}upload/sales/notice/{$file_url[$i]}' download='{$file[$i]}'> <img src='{$misc}img/download.svg' style='width:15px;vertical-align:middle;cursor:pointer;margin:5px 0px 5px 10px;'></a><br>";
								}
						 }
					?>
				</td>
			</tr>
		</table>
		<div class="btn_div" style="margin-top:20px;text-align:right;">
			<?php if($category == '001' && $view_val['user_id'] == $this->id) { ?>
				<input type="button" class="btn-common btn-color1" value="삭제" onClick="javascript:chkForm(1);return false;"style="margin-right:10px;">
				<input type="button" class="btn-common btn-color1" value="수정" onClick="javascript:chkForm(0);return false;"style="margin-right:10px;">
			<?php } ?>
			<input type="button" class="btn-common btn-color1" value="목록" onClick="javascript:history.go(-1);">
		</div>
	</div>
</div>
</form>
<div style="position:fixed;bottom:100px;right:5px;">
		<img src="<?php echo $misc; ?>img/mobile/btn_top.svg" onclick="$('html').scrollTop(0);">
</div>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
</body>
</html>

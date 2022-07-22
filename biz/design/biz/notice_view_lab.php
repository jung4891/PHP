<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<link rel="stylesheet" href="/misc/css/dashboard.css">
<link rel="stylesheet" href="/misc/css/new_dash.css">
<style>
.contents_tbl th{
		border-color:#c0c0c0;
		text-align:center;
		border-style:solid;
		border-width:1px;
		font-size: 16px;
		font-weight:bold;
		height:40px;
		background-color: #efefef;

}

.contents_tbl td{
		border-color:#c0c0c0;
		text-align:center;
		border-style:solid;
		border-width:1px;
		font-size: 14px;
		height:40px;
}
</style>
<body>
<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
<div class="contents_container" align="center">
  <!-- 타이틀 -->
  <div class="contents_item" style="margin-top:30px;">
    <h1 style="float:left">개발공지사항</h1>
  </div>


	<form name="cform" method="get">
		<input type="hidden" name="seq" value="<?php echo $seq;?>">
		<input type="hidden" name="category" value="<?php echo $category;?>">
		<input type="hidden" name="mode" value="modify">
	</form>
  <!-- 엑셀모드 -->
  <div class="contents_item" style="display:flex;justify-content: space-between;align-items: flex-end;">
    <table class="contents_tbl" width="65%" cellspacing="0" cellpadding="0">
      <colgroup>
        <col width="20%">
        <col width="30%">
        <col width="20%">
        <col width="30%">
      </colgroup>
    <thead>
      <tr>
        <th>등록자</th>
        <td><?php echo $view_val['user_name'];?></td>
        <th>등록일</th>
        <td><?php echo $view_val['update_date'];?></td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th>제목</th>
        <td colspan="3">
<?php echo stripslashes($view_val['subject']);?>
        </td>
      </tr>
    </tbody>
    </table>

    <table class="contents_tbl" width="30%" cellspacing="0" cellpadding="0">
    <thead>
      <tr>
        <th></th>
        <th>신규개발</th>
        <th>기능개선</th>
        <th>버그수정</th>
      </tr>
    </thead>
    <tbody>
			<?php
if(!empty($type_count)){
			 ?>
      <tr>
        <th>완료</th>
        <td><?php echo($type_count->new_y) ?></td>
        <td><?php echo($type_count->imp_y) ?></td>
        <td><?php echo($type_count->bug_y) ?></td>
      </tr>
      <tr>
        <th>미완료</th>
        <td><?php echo($type_count->new_n) ?></td>
        <td><?php echo($type_count->imp_n) ?></td>
        <td><?php echo($type_count->bug_n) ?></td>
      </tr>
		<?php } ?>
    </tbody>
    </table>
  </div>

  <div class="contents_item" width="100%">
  <table class="contents_tbl" width="100%" cellspacing="0" cellpadding="0">
    <colgroup>
      <col width="6%">
      <col width="6%">
      <col width="6%">
      <col width="6%">
      <col width="14%">
      <col width="23%">
      <col width="23%">
      <col width="6%">
      <col width="10%">
    </colgroup>
  <thead>
    <tr>
      <th>구분</th>
      <th>페이지</th>
      <th>접수일자</th>
      <th>요청자</th>
      <th>개발사항</th>
      <th>요청사항</th>
      <th>개선방안</th>
      <th>완료일자</th>
      <th>진행결과</th>
    </tr>
  </thead>
  <tbody>
    <?php
		if(!empty($lab_val)){
		foreach ($lab_val as $lab) {

			switch ($lab['dev_type']) {
				case 'new':
					$dev_type = "신규개발";
					break;

				case 'imp':
					$dev_type = "기능개선";
					break;

				case 'bug':
					$dev_type = "버그수정";
					break;
			}

			switch ($lab['complete_yn']) {
				case 'Y':
					$complete_yn = "완료";
					break;

				case 'N':
					$complete_yn = "미완료";
					break;
			}
			?>

      <tr>
        <td><?php echo $dev_type ?></td>
        <td><?php echo $lab['page'] ?></td>
        <td><?php echo $lab['receive_date'] ?></td>
        <td><?php echo $lab['receiver'] ?></td>
        <td style="text-align:left;padding:5px;"><?php echo nl2br($lab['develope']) ?></td>
        <td style="text-align:left;padding:5px;"><?php echo nl2br($lab['request']) ?></td>
        <td style="text-align:left;padding:5px;"><?php echo nl2br($lab['dev_plan']) ?></td>
        <td><?php echo $lab['complete_date'] ?></td>
        <td><?php echo $complete_yn ?></td>
      </tr>
  <?php }
}
	 ?>
  </tbody>
  </table>
  </div>

  <div class="contents_item" id="editor_div">
		<table class="contents_tbl" width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<th>기타</th>
		<tr>
		<tr>
			<td valign="top" colspan="6" style="padding:20px;text-align:left;"><?php echo $view_val['contents'];?></td>
		</tr>
		<tr>
			<th width="15%" align="center" height=40>첨부파일</th>
			<td colspan=3 class="basic_td" align="left">
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
  </div>

<div class="contents_item" style="margin-bottom:5vh;">
	<img src="<?php echo $misc;?>img/dashboard/btn/btn_list.png" border="0" style="cursor:pointer" onClick="<?php if (isset($_GET['dash'])){echo "go_list('dash','".$category."');";}else{echo "go_list('notice','".$category."');";} ?>"/>

<?php
		if( $group == '기술연구소'){
?>
			<img src="<?php echo $misc;?>img/dashboard/btn/btn_adjust.png" style="cursor:pointer" border="0" onClick="javascript:chkForm(0);return false;"/>
			<img src="<?php echo $misc;?>img/dashboard/btn/btn_delete.png" style="cursor:pointer" border="0" onClick="javascript:chkForm(1);return false;"/>
<?php
}
 ?>

</div>

</div>

<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
</body>
<script type="text/javascript">
function side_resize(){
	$("#sidebar_left").height($("#main_contents").height());
	$(".sidebar_sub_on").height($("#main_contents").height());

}

function go_list(page,category){
	if (page=="dash") {
		window.location = "<?php echo site_url(); ?>/biz/board/notice_list?category=002";
	} else {
		history.go(-1);
	}
}

function chkForm( type ) {
	if(type == 1) {
		if (confirm("정말 삭제하시겠습니까?") == true){
			var mform = document.cform;
			mform.action="<?php echo site_url();?>/biz/board/notice_lab_delete_action";
			mform.submit();
			return false;
		}
	} else {
		var mform = document.cform;
		mform.action="<?php echo site_url();?>/biz/board/lab_notice_view";
		mform.submit();
		return false;
	}
}
</script>
</html>

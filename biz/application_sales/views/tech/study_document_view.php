<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<style media="screen">
  .input-common, .textarea-common {
    box-sizing: border-box;
    width:100%;
  }
  .tbl-cell {
    padding-right: 10px;
  }
</style>
<script type="text/javascript">
function chkForm( type ) {
  if($('#approval_yn').val() == 'Y') {
    alert('승인이 완료된 문서는 수정, 삭제가 불가능합니다.');
    return false;
  }

  if(type == 1) {
    if (confirm("정말 삭제하시겠습니까?") == true){
      var mform = document.cform;
      mform.action="<?php echo site_url();?>/tech/board/study_document_delete_action";
      mform.submit();
      return false;
    }
  } else {
    var mform = document.cform;
    mform.action="<?php echo site_url();?>/tech/board/study_document_modify";
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
      <form name="cform" method="get">
        <input type="hidden" name="seq" value="<?php echo $seq;?>">
        <input type="hidden" id="approval_yn" value="<?php echo $view_val['approval_yn']; ?>">
      </form>
			<tr height="5%">
				<td>
          <span class="dash_title">스터디 자료</span>
          <div style="border:2px solid #d7d7d7; width:140px;padding:20px;background-color:#F4F4F4;margin-bottom:10px;float:right;" align="center">
            <div style="font-size:20px;font-weight:bold;">결재승인</div>
            <div style="margin-top:20px;">
              <?php if($this->id == "kkj" || $this->pGroupName =="기술연구소"){?>
                <input type="radio" name="approval_yn" value="Y" onchange="approval(this);" <?php if($view_val['approval_yn'] == "Y"){echo "checked";} ?> >승인
                <input type="radio" name="approval_yn" value="N" onchange="approval(this);"  <?php if($view_val['approval_yn'] == "N"){echo "checked";} ?>>미승인
              <?php } else {
                if($view_val['approval_yn'] == 'Y') {
                  echo "승인 완료";
                } else {
                  echo "미승인";
                }
              } ?>
            </div>
          </div>
				</td>
			</tr>
			<tr>
				<td height="40"></td>
			</tr>
      <tr>
        <td align="right">
  <?php if($view_val['write_id'] == $this->id) { ?>
          <input type="button" class="btn-common btn-color4" value="삭제" onClick="javascript:chkForm(1);return false;" style="margin-right:10px">
          <input type="button" class="btn-common btn-color4" value="수정" onClick="javascript:chkForm(0);return false;" style="margin-right:10px">
  <?php } ?>
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
              <td class="tbl-title">년도</td>
              <td class="tbl-cell" align="center">
                <?php echo $view_val['year'].'년'; ?>
              </td>
              <td class="tbl-title">주차</td>
              <td class="tbl-cell" align="center">
                <?php echo $view_val['week'].'주차'; ?>
              </td>
            </tr>
      			<tr>
              <td class="tbl-title">등록자</td>
              <td class="tbl-mid"><?php echo $view_val['user_name'];?></td>
        			<td class="tbl-title">날짜</td>
        			<td class="tbl-mid"><?php echo date("Y-m-d", strtotime($view_val['write_date']));?></td>
            </tr>
            <tr>
              <td class="tbl-title">제목</td>
              <td class="tbl-cell" colspan="3">
                <?php echo stripslashes($view_val['subject']); ?>
              </td>
            </tr>
            <tr>
              <td colspan="4" style="padding: 10px;0">
								<?php echo nl2br($view_val['content']); ?>
							</td>
            </tr>
            <tr>
              <td class="tbl-title">첨부파일</td>
              <td colspan="3" class="tbl-cell">
                <?php
                if($view_val['file_realname'] != '') {
                  $file = explode('*/*', $view_val['file_realname']);
                  $file_url = explode('*/*', $view_val['file_changename']);
                  for($i = 0; $i < count($file); $i++) {
                    echo $file[$i];
                    echo "<a href='{$misc}upload/tech/study_document/{$file_url[$i]}' download='{$file[$i]}'> <img src='{$misc}img/download.svg' style='width:15px;vertical-align:middle;cursor:pointer;margin:5px 0px 5px 10px;'></a><br>";
                  }
                }
                ?>
              </td>
            </tr>
          </table>
				</td>
			</tr>
		</table>
	</div>
</div>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
</body>
<script type="text/javascript">
function approval(obj){
  var val = $(obj).val();
  var text = "";
  if(val == "Y"){
    text = "승인";
  }else{
    text = "미승인";
  }

  if(confirm("결재를 "+text+ " 하시겠습니까?")){
    $.ajax({
    type: "POST",
    cache: false,
    url: "<?php echo site_url();?>/tech/board/doc_approval",
    dataType: "json",
    async: false,
    data: {
      seq : "<?php echo $_GET['seq']; ?>",
      val : val,
      target : 'tech_study_document'
    },
    success: function (data) {
      if(data){
        alert("저장완료");
        location.reload();
      }else{
        alert("저장 실패");
      }
    }
  });

  }else{
    return false;
  }
}
</script>
</html>

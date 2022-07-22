<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<!-- <link rel="stylesheet" href="/misc/css/dashboard.css"> -->
<link rel="stylesheet" href="/misc/css_mango/view_page_common_mango.css">
<style media="screen">
	.c_tbl td {
		padding-left: 0px;
	}
</style>
<script language="javascript">
function chkForm( type ) {
	if(type == 1) {
		if (confirm("정말 삭제하시겠습니까?") == true){
			var mform = document.cform;
			mform.action="<?php echo site_url();?>/health_certificate/doc_delete_action";
			mform.submit();
			return false;
		}
	} else {
		var mform = document.cform;
		mform.action="<?php echo site_url();?>/health_certificate/doc_modify";
		mform.submit();
		return false;
	}
}
//$(document).ready(function() {
//   $('li > ul').show();
//});
</script>
<body>
<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/mango_header.php";
?>
<div align="center">
<div class="dash1-1">
<table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
<form name="cform" method="get">
<input type="hidden" name="seq" value="<?php echo $seq;?>">
<input type="hidden" name="mode" value="modify">
<tr height="5%">
  <td class="dash_title">
		건강검진 관리대장
	</td>
</tr>
<tr>
	<td height="40"></td>
</tr>
<tr>
	<td align="right">
		<button class="btn-common btn-updownload" style="float:left;display:inline;width:115px;margin-right:10px;" type="button" onclick="excelDownload('c_tbl');">엑셀 다운로드
			<img src="/misc/img/download_btn.svg"  style="float:left; width:12px; padding:5px;">
		</button>
	<?php
			if( $this->admin == 'Y' ) {
	?>
			<input type="button" class="btn-common btn-color1 btn-size1" value="삭제" onClick="javascript:chkForm(1);return false;"style="margin-right:5px;">
			<!-- <input type="button" class="btn-common btn-color4 btn-size1" value="수정" onClick="javascript:chkForm(0);return false;"style="margin-right:5px;"> -->
	<?php
			}
	?>
	<input type="button" class="btn-common btn-style1 btn-size1" value="목록" onClick="history.go(-1);">
	</td>
</tr>
  <tr>
    <td align="center" valign="top">

    <table width="100%" height="100%" cellspacing="0" cellpadding="0" >
        <tr>

            <td width="100%" align="center" valign="top">


            <table width="100%" border="0" style="margin-top:20px;">
									<table class="list_tbl" width="100%" border="0" cellspacing="0" cellpadding="0" style="table-layout:fixed; word-break:break-all;border: thin solid #DFDFDF;margin-bottom:20px;">
										<colgroup>
											<col width="15%">
											<col width="35%">
											<col width="15%">
											<col width="35%">
										</colgroup>

									<!-- <tr style="display:none;"> -->
									<tr>
										<td height="40" align="center" class="row-color1" style="font-weight:bold;">제목</td>
										<td align="left" style="padding-left:10px;" colspan="3" id="subject"><?php echo '건강검진(보건증) 관리대장_'.$view_val['year'].'년 '.$view_val['month'].'월';?></td>
                  </tr>
                  <tr>
										<td align="center" class="row-color1" style="font-weight:bold;">등록자</td>
										<td align="center"><?php echo $view_val['user_name'];?></td>
										<td height="40" align="center" class="row-color1" style="font-weight:bold;">작성일</td>
										<td align="center"><?php echo date('Y-m-d', strtotime($view_val['update_date']));?></td>
                  </tr>
                </table>
								<table id="c_tbl" class="list_tbl c_tbl" width="100%" border="0" cellspacing="0" cellpadding="0" style="table-layout:fixed; word-break:break-all; border: thin solid #DFDFDF; margin-bottom: 50px;">

									<tr>
										<td class="tbl-title">성명</td>
										<td class="tbl-title">건강검진일</td>
										<td class="tbl-title">검진결과<br>(적/부)</td>
										<td class="tbl-title">만료일자</td>
									</tr>
					<?php foreach($contents as $c) { ?>
									<tr>
										<td class="tbl-cell" align="center"><?php echo $c['user_name']; ?></td>
										<td class="tbl-cell" align="center"><?php echo $c['sdate']; ?></td>
										<td class="tbl-cell" align="center">적합</td>
										<td class="tbl-cell" align="center"><?php echo $c['edate']; ?></td>
									</tr>
					<?php } ?>
								</table>
            </table>
          </td>

        </tr>
     </table>

    </td>
  </tr>
</form>
</table>
</div>
</div>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/mango_bottom.php"; ?>
</body>
<script type="text/javascript">
	function excelDownload(id) {
		var tab_text = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
		tab_text = tab_text + '<head><meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">';
		tab_text = tab_text + '<xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>'
		tab_text = tab_text + '<x:Name>Test Sheet</x:Name>';
		tab_text = tab_text + '<x:WorksheetOptions><x:Panes></x:Panes></x:WorksheetOptions></x:ExcelWorksheet>';
		tab_text = tab_text + '</x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body>';
		tab_text = tab_text + "<table border='1px'>";
		var exportTable = $('#' + id).clone();
		exportTable.find('input').each(function(index, elem) {
			$(elem).remove();
		});
		tab_text = tab_text + exportTable.html();
		tab_text = tab_text + '</table></body></html>';
		var data_type = 'data:application/vnd.ms-excel';
		var ua = window.navigator.userAgent;
		var msie = ua.indexOf("MSIE ");
		var fileName = $.trim($('#subject').text()) + '.xls';

		if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
			if (window.navigator.msSaveBlob) {
				var blob = new Blob([tab_text], {
					type: "application/csv;charset=utf-8;"
				});
				navigator.msSaveBlob(blob, fileName);
			}
		} else {
			var blob2 = new Blob([tab_text], {
				type: "application/csv;charset=utf-8;"
			});
			var filename = fileName;
			var elem = window.document.createElement('a');
			elem.href = window.URL.createObjectURL(blob2);
			elem.download = filename;
			document.body.appendChild(elem);
			elem.click();
			document.body.removeChild(elem);
		}
	}
</script>
</html>

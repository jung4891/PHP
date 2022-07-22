<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<style media="screen">
	.note-popover .note-popover-content, .note-toolbar, .note-btn {
		background-color: #F4F4F4 !important;
		border-color: #F4F4F4 !important;
	}
	.note-editor.note-frame {
		border: none !important;
	}
  .input-common {
    width: 100%;
    box-sizing: border-box;
  }
  .tbl-cell {
    padding-right: 10px;
  }
  .tbl-title {
    /* text-align: left; */
    /* padding-left: 30px; */
  }
</style>
<script language="javascript">
$(document).ready(function() {
   $('li > ul').show();
});
</script>
<link rel="stylesheet" href="/misc/daumeditor-7.4.9/css/editor.css" type="text/css" charset="utf-8"/>
<script src="/misc/daumeditor-7.4.9/js/editor_loader.js" type="text/javascript" charset="utf-8"></script>
<body>
<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
<div align="center">
	<div class="dash1-1">
		<table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
			<tr height="5%">
				<td class="dash_title">
					공문
				</td>
			</tr>
			<tr>
				<td height="40"></td>
			</tr>
  		<tr>
    		<td width="100%" align="center" valign="top">
          <form name="tx_editor_form" id="tx_editor_form" method="post" enctype="multipart/form-data">
						<input type="hidden" name="seq" id="seq" value="<?php echo $view_val['seq']; ?>">
						<table class="list_tbl" width="100%" border="0" cellspacing="0" cellpadding="0" style="table-layout:fixed; word-break:break-all;border: thin solid #DFDFDF;margin-bottom:50px;margin-top:20px;">
							<colgroup>
                <col width="30%">
                <col width="70%">
							</colgroup>
						<?php if($view_val['header_text'] != '') { ?>
							<tr>
								<td class="tbl-title">머리글</td>
								<td class="tbl-cell"><?php echo $view_val['header_text']; ?></td>
							</tr>
						<?php } ?>
              <tr>
                <td colspan="2" style="height:80px;text-align:center;vertical-align:middle;">
                  <div style="text-align:center;height:40px;width:70%;font-size:20px;font-weight:bold;margin:0 auto;display:table;">
										<span style="display:table-cell;vertical-align:middle;"><?php echo $view_val['doc_name']; ?></span>
									</div>
                </td>
              </tr>
        			<tr>
          			<td class="tbl-title">문서번호</td>
          			<td class="tbl-cell"><?php if($view_val['doc_num']==''){echo '미발급';}else{echo $view_val['doc_num'].substr_replace($view_val['doc_num2'], '-', 4, 0);} ?></td>
              </tr>
              <tr>
                <td class="tbl-title">일<span style="margin-right:25px;"></span>자</td>
                <td class="tbl-cell"><?php echo date('Y년 m월 d일', strtotime($view_val['doc_date'])); ?></td>
              </tr>
              <tr>
                <td class="tbl-title">수<span style="margin-right:25px;"></span>신</td>
                <td class="tbl-cell"><?php echo $view_val['to']; ?></td>
              </tr>
              <tr>
                <td class="tbl-title">참<span style="margin-right:25px;"></span>조</td>
                <td class="tbl-cell"><?php echo $view_val['cc']; ?></td>
              </tr>
              <tr>
                <td class="tbl-title">발<span style="margin-right:25px;"></span>신</td>
                <td class="tbl-cell"><?php echo $view_val['from']; ?></td>
              </tr>
              <tr>
                <td class="tbl-title">제<span style="margin-right:25px;"></span>목</td>
                <td class="tbl-cell"><?php echo $view_val['subject']; ?></td>
              </tr>
              <tr>
								<td colspan="2" style="padding:20px;">
									<div style="width:21cm;margin:0 auto">
											<?php echo $view_val['content']; ?>
									</div>
								</td>
              </tr>
						<?php if($view_val['footer_text'] != '') { ?>
							<tr>
								<td class="tbl-title">바닥글</td>
								<td class="tbl-cell"><?php echo nl2br($view_val['footer_text']); ?></td>
							</tr>
						<?php } ?>
            </table>
          </form>
				</td>
			</tr>
			<tr>
				<td style="padding-bottom:20px;">
				<?php if($view_val['approval_doc_status'] != '002') { ?>
          <input type="button" class="btn-common btn-color2" value="pdf 미리보기" onClick="preview_pdf(<?php echo $view_val['seq']; ?>);" style="width:auto;">
				<?php } else { ?>
					<input type="button" class="btn-common btn-color2" value="프린트" onClick="preview_pdf(<?php echo $view_val['seq']; ?>);" style="">
				<?php } ?>
				<?php if($view_val['approval_doc_status'] != '001' && $view_val['approval_doc_status'] != '002') { ?>
          <input type="button" class="btn-common btn-color2" value="삭제" onClick="javascript:chkForm(1);return false;" style="float:right;">
					<input type="button" class="btn-common btn-color1" value="수정" onClick="modify(<?php echo $view_val['seq']; ?>)" style="float:right;margin-right:10px;">
				<?php } else {  ?>
					<input type="button" class="btn-common btn-color1" value="복사" onClick="copy(<?php echo $view_val['seq']; ?>)" style="float:right;">
				<?php } ?>
					<input type="button" class="btn-common btn-color1" value="목록" onClick="javascript:history.go(-1)" style="float:right;margin-right:10px;">
				</td>
			</tr>
		</table>
	</div>
</div>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
</body>
<script type="text/javascript">
  function preview_pdf(seq) {
    tx_editor_form.target = '_black';
    tx_editor_form.action = '<?php echo site_url() ?>/biz/official_doc/official_doc_print?seq='+seq;
    tx_editor_form.submit();
  }

	function chkForm(type) {
		if(type == 1) {
			if(confirm('정말 삭제하시겠습니까?') == true) {
				var mform = document.tx_editor_form;

				mform.target = '_self';
				mform.action = "<?php echo site_url(); ?>/biz/official_doc/official_doc_delete_action";
				mform.submit();
				return false;
			}
		}
	}

	function modify(seq) {
		location.href = "<?php echo site_url(); ?>/biz/official_doc/official_doc_modify?seq=" + seq;
	}

	function copy(seq) {
		location.href = "<?php echo site_url(); ?>/biz/official_doc/official_doc_modify?mode=copy&seq=" + seq;
	}
</script>
</html>

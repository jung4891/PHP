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
	#tx_fontfamily, #tx_fontsize {
		display: none !important;
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
					공문작성
				</td>
			</tr>
			<tr>
				<td height="40"></td>
			</tr>
			<form name="tx_editor_form" id="tx_editor_form" method="post" enctype="multipart/form-data">
			<tr>
				<td style="font-weight:bold;font-size:14px;">
					공문종류선택&nbsp;
					<select name="doc_form_seq" class="select-common select-style1" style="margin-right:10px;" onchange="change_doc_form(this);">
							<option value="" selected disabled hidden>공문종류선택</option>
				<?php foreach($doc_form_list as $dfl) { ?>
							<option value="<?php echo $dfl['seq']; ?>" <?php if(isset($_GET['doc_type_seq'])&&$_GET['doc_type_seq']==$dfl['seq']){echo 'selected';$doc_type=$dfl['doc_name'];} ?>><?php echo $dfl['doc_name']; ?></option>
				<?php } ?>
					</select>
				</td>
			</tr>
  		<tr>
    		<td width="100%" align="center" valign="top">
						<table class="list_tbl" width="100%" border="0" cellspacing="0" cellpadding="0" style="table-layout:fixed; word-break:break-all;border: thin solid #DFDFDF;margin-bottom:50px;margin-top:20px;">
							<input type="hidden" name="seq" value="">
							<colgroup>
                <col width="30%">
                <col width="70%">
							</colgroup>
							<tr>
								<td class="tbl-title">머리글<br>
									사용<input type="radio" name="header_yn" onchange="change_yn(this, 'header');" value="Y" checked>
									미사용<input type="radio" name="header_yn" onchange="change_yn(this, 'header');" value="N">
								</td>
								<td class="tbl-cell">
									<input type="hidden" name="doc_type" id="doc_type" value="<?php if(isset($doc_type)){echo $doc_type;} ?>">
									<input type="text" name="header_text" id="header_text" class="input-common" style="width:90%;" value='<?php if(!empty($personal_text) && $personal_text['header']!=''){echo $personal_text['header'];}else{echo 'Your Next Partner ! "DURIANIT"';} ?>'>
									<input type="button" class="btn-common btn-style1" id="header_btn" style="width:auto;float:right;" value="기본값 저장" onclick="save_text('header');">
								</td>
							</tr>
              <tr>
                <td colspan="2" style="height:80px;text-align:center;">
                  <input type="text" name="doc_name" id="doc_name" class="input-common" style="text-align:center;height:40px;width:70%;font-size:20px;font-weight:bold;" placeholder="타이틀을 입력해 주세요." value="<?php if(isset($doc_form)){echo $doc_form[0]['title'];} ?>">
                </td>
              </tr>
        			<tr>
          			<td class="tbl-title">문서번호</td>
          			<td class="tbl-cell">자동 기입</td>
              </tr>
              <tr>
                <td class="tbl-title">일<span style="margin-right:25px;"></span>자</td>
                <td class="tbl-cell"><input type="date" name="doc_date" id="doc_date" class="input-common" style="width:auto;"/></td>
              </tr>
              <tr>
                <td class="tbl-title">수<span style="margin-right:25px;"></span>신</td>
                <td class="tbl-cell"><input type="text" name="to" id="to" class="input-common"/></td>
              </tr>
              <tr>
                <td class="tbl-title">참<span style="margin-right:25px;"></span>조</td>
                <td class="tbl-cell"><input type="text" name="cc" id="cc" class="input-common"/></td>
              </tr>
              <tr>
                <td class="tbl-title">발<span style="margin-right:25px;"></span>신</td>
                <td class="tbl-cell"><input type="text" name="from" id="from" class="input-common"/></td>
              </tr>
              <tr>
                <td class="tbl-title">제<span style="margin-right:25px;"></span>목</td>
                <td class="tbl-cell"><input type="text" name="subject" id="subject" class="input-common"/></td>
              </tr>
              <tr>
                <td colspan="2">
                  <div style="width:21cm;margin:0 auto;">
                    <textarea name="content" id="content" style="display:none;"><?php if(isset($doc_form)){echo $doc_form[0]['content'];} ?></textarea>
                    <input type="hidden" name="contents" id="contents" value="">
                    <?php include $this->input->server('DOCUMENT_ROOT')."/misc/daumeditor-7.4.9/editor.php"; ?>
                  </div>
								</td>
              </tr>
							<tr>
								<td class="tbl-title">바닥글<br>
									사용<input type="radio" name="footer_yn" onchange="change_yn(this, 'footer');" value="Y" checked>
									미사용<input type="radio" name="footer_yn" onchange="change_yn(this, 'footer');" value="N">
								</td>
								<td class="tbl-cell">
									<textarea name="footer_text" id="footer_text" class="textarea-common" style="width:90%" rows="2" cols="80"><?php if(!empty($personal_text) && $personal_text['footer']!=''){echo $personal_text['footer'];}else {echo "경기도 성남시 분당구 판교로255 9-22 판교우림w-city 603호 (13486) TEL: 82-2-542-4987, FAX: 82-2-6455-3987 , URL: http://www.durianit.co.kr\r담당 :  (직통번호 : ), 시행 : ";} ?></textarea>
									<input type="button" class="btn-common btn-style1" id="footer_btn" style="width:auto;float:right;margin-top:5px;" value="기본값 저장" onclick="save_text('footer');">
								</td>
							</tr>
            </table>
          </form>
				</td>
			</tr>
			<tr>
				<td style="padding-bottom:20px;">
          <input type="button" class="btn-common btn-color2" value="pdf 미리보기" onClick="preview_pdf();" style="width:auto;">
          <input type="button" class="btn-common btn-color2" value="등록" onClick="javascript:chkForm();return false;" style="float:right;">
					<input type="button" class="btn-common btn-color4" value="취소" onClick="cancel();" style="float:right;margin-right:10px;">
				</td>
			</tr>
		</table>
	</div>
</div>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
</body>
<script type="text/javascript">
  function preview_pdf() {
    // console.log(Editor.getContent());
    $("#content").val(Editor.getContent());
    // window.open('', 'popOpen');
    tx_editor_form.target = '_black';
    tx_editor_form.action = '<?php echo site_url() ?>/biz/official_doc/official_doc_print';
    tx_editor_form.submit();
  }

  function chkForm() {
    var mform = document.tx_editor_form;

    // if (mform.doc_name.value == '') {
    //   alert('공문 타이틀을 입력해 주세요.');
    //   mform.doc_name.focus();
    //   return false;
    // }

    if (mform.to.value == '') {
      alert('수신을 입력해 주세요.');
      mform.to.focus();
      return false;
    }
		//
    // if (mform.cc.value == '') {
    //   alert('참조를 입력해 주세요.');
    //   mform.cc.focus();
    //   return false;
    // }

    if (mform.from.value == '') {
      alert('발신을 입력해 주세요.');
      mform.from.focus();
      return false;
    }

    if (mform.subject.value == '') {
      alert('제목을 입력해 주세요.');
      mform.subject.focus();
      return false;
    }

    var validator = new Trex.Validator();
    var content = Editor.getContent();
    if(!validator.exists(content)) {
      alert('내용을 입력하세요');
      return false;
    }

    $("#content").val(Editor.getContent());

    mform.target = '_self';
    mform.action = "<?php echo site_url(); ?>/biz/official_doc/official_doc_input_action";
    mform.submit();
  }

	function change_yn(el, mode) {
		if($(el).val() == "Y") {
			$('#'+mode+'_text').show();
			$('#'+mode+'_btn').show();
		} else {
			$('#'+mode+'_text').hide();
			$('#'+mode+'_btn').hide();
		}
	}

	function save_text(type) {
		if(confirm('기본값으로 저장하시겠습니까?')) {

			if(type == 'header') {
				header_text = $("#header_text").val();

				$.ajax({
					type: "POST",
					cache: false,
					url: "<?php echo site_url(); ?>/biz/official_doc/save_headerfooter",
					dataType: "json",
					async: false,
					data: {
						type: 'header',
						header_text: header_text
					},
					success: function(result) {
						if(result) {
							alert('저장되었습니다.');
						} else {
							alert('저장에 실패하였습니다.');
						}
					}
				})

			} else if (type == 'footer') {
				footer_text = $("#footer_text").val();

				$.ajax({
					type: "POST",
					cache: false,
					url: "<?php echo site_url(); ?>/biz/official_doc/save_headerfooter",
					dataType: "json",
					async: false,
					data: {
						type: 'footer',
						footer_text: footer_text
					},
					success: function(result) {
						if(result) {
							alert('저장되었습니다.');
						} else {
							alert('저장에 실패하였습니다.');
						}
					}
				})

			}

		}

	}

	function change_doc_form(el) {
		var mform = document.tx_editor_form;

		var seq = $(el).val();

		mform.target = '_self';
    mform.action = "<?php echo site_url(); ?>/biz/official_doc/official_doc_input?doc_type_seq="+seq;
    mform.submit();
	}

	function cancel() {
		location.href = "<?php echo site_url(); ?>/biz/official_doc/official_doc_list";
	}
</script>
</html>

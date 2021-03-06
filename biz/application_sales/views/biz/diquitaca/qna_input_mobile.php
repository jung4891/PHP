<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<link rel="stylesheet" href="/misc/daumeditor-7.4.9/css/editor.css" type="text/css" charset="utf-8"/>
<script src="/misc/daumeditor-7.4.9/js/editor_loader.js" type="text/javascript" charset="utf-8"></script>
<style media="screen">
body {
	color: #1C1C1C;
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
.contents_div {
	overflow-x: scroll;
	white-space: nowrap;
}
.dayBtn, .timeBtn {
	width: 43%;
	height: 30px;
	background-color: white;
}
.dayBtn {
	background:url(<?php echo $misc; ?>img/mobile/footer_schedule.svg) no-repeat 98% 50% #fff;
	background-size: 20px;
}
.timeBtn {
	background:url(<?php echo $misc; ?>img/mobile/icon_time.svg) no-repeat 98% 50% #fff;
	background-size: 20px;
}
.basic_table {border: 1px solid #DEDEDE;}
.list_tbl {border-top: 1px solid #DEDEDE;border-bottom: none;}
.border-l {border-left: 1px solid #DEDEDE;}
.border-r {border-right: 1px solid #DEDEDE;}
.input-common {width:100%;box-sizing: border-box;}
.bardivs { width: 100%; position: relative; }
.progresstext { position: absolute; top: 0; left: 0; width: 98%; padding-top: 5px; text-align: right; font-weight: bold;}
.ui-widget-header{ background-color: #0575E6;}
.ui-corner-all{ background-color: #F8F9FB; border-color: #DEDEDE; border-radius: 3px;}
/* .num {padding-left:4px;padding-right:4px;width: 30px;height: 25px;margin-left: 3px;text-align: center;font-size: 14px;color: #ccc;vertical-align: middle;} */
.item{position: relative;min-height: 25px;border: 1px solid #ebecef;border-radius: 2px;}
.FlexableTextArea {display: inline-block;min-height: 25px;width: calc(100% - 30px);vertical-align: middle;}
.textarea_input{width: 100%;min-height: 25px;border: 0;font-size: 14px;line-height: 19px;letter-spacing: 0;height:25px;font-family: "Noto Sans KR", sans-serif;}
.textarea_input {display: block;width: 100%;min-height: 25px;border: 1px solid #ebecef;box-sizing: border-box;overflow: hidden;resize: none;word-break: break-all;font-size: 15px;letter-spacing: -.23px;line-height: 17px;border: none;}
.list_tbl td {border-bottom: none;color:#626262}
.vote_content_tr td {border-bottom: thin solid #DEDEDE;}
.vote_content_tr td {border-top: thin solid #DEDEDE;}
.sub_title {font-size:12px;padding-top:10px;width:100%;}
.input_td {font-size:14px;height:35px;padding-left:5px;border-bottom:thin solid #F4F4F4;width:100%;}
div.editor_div div.note-toolbar {
	display: none;
}
#tx_toolbar_basic {
	display:none;
}
#tx_canvas_text {height: 200px !important;}
</style>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<style media="screen">
	.input-common {border:none;width:100%;box-sizing: border-box;}
</style>
<body>
<meta name="viewport" content="width=device-width,height=device-width, initial-scale=1.0">
<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/mobile_side.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/mobile_header.php";
	?>
<form name="tx_editor_form" id="tx_editor_form" action="<?php echo site_url();?>/biz/board/notice_input_action" method="post" enctype="multipart/form-data" onSubmit="javascript:chkForm();return false;">
	<input type="hidden" name="vote_yn" value="">
	<div class="d_1" style="max-width:90%;margin: 0 auto;margin-top:30px;">
		<table class="tbl_1" border="0" cellspacing="0" cellpadding="0" style="width:100%;table-layout:fixed">
			<tr>
				<td class="sub_title">?????????</td>
			</tr>
			<tr>
				<td class="input_td"><?php echo $this->name; ?></td>
			</tr>
			<tr>
				<td class="sub_title">?????????</td>
			</tr>
			<tr>
				<td class="input_td"><?php echo date('Y-m-d'); ?></td>
			</tr>
			<tr>
				<td class="sub_title">??????</td>
			</tr>
			<tr>
				<td class="input_td">
					<input type="text" name="title" class="input-common" value="" placeholder="????????? ???????????????.">
				</td>
			</tr>
			<tr>
				<td class="sub_title">???????????????</td>
			</tr>
			<tbody id="fileTableTbody">
				<tr>
					<td id="dropZone" class="input_td">
						<input type="text" class="input-common" placeholder="???????????? ????????? ???????????????." style="width:auto;" readonly>
						<label class="file_label" for="file_up" style="width:20px;float:right;margin-right:5px;">
							<img src="/misc/img/mobile/btn_upload.svg" width="25">
						</label>
						<input type="file" id="file_up" class="file-input" style="display:none;">
					</td>
				</tr>
			</tbody>
			<tr>
				<td class="sub_title">??????????????????</td>
			</tr>
			<tr>
				<td class="input_td">
					<select class="select-common select-style1" name="category">
						<option value="">???????????? ??????</option>
		<?php foreach($category as $c) { ?>
						<option value="<?php echo $c['seq']; ?>"><?php echo $c['category_name']; ?></option>
		<?php } ?>
					</select>
				</td>
			</tr>
			<tr class="vote_tr">
				<td class="sub_title">?????????</td>
			</tr>
			<tr class="vote_tr">
				<td class="input_td">
					<input class="input-common dayBtn" type="date" name="deadline_day" id="startDay" value="" autocomplete="off" style="width:45%;vertical-align:middle;margin-right:1%;float:left">
					<input class="input-common timeBtn" type="time" name="deadline_time" id="startTime" value="" autocomplete="off" style="width:45%;vertical-align:middle;float:right;">
				</td>
			</tr>
			<tr>
				<td class="sub_title" style="padding-bottom:10px;">??????</td>
			</tr>
			<tr>
				<td class="input_td" style="padding:0;">
					<textarea name="content" id="content" style="display:none;"></textarea>
					<input type="hidden" name="contents" id="contents" value="">
					<?php include $this->input->server('DOCUMENT_ROOT')."/misc/daumeditor-7.4.9/editor.php"; ?>
				</td>
			</tr>
		</table>
		<div style="margin-top:30px;">
			<input type="button" class="btn-common btn-color1" value="??????" onclick="cancel();" style="width:45%;float:left;border-radius:3px;height:40px;">
			<input type="button" class="btn-common btn-color2 vote_y" value="??????" onclick="next_div('d_1')" style="width:45%;float:right;border-radius:3px;height:40px;">
			<input type="button" class="btn-common btn-color2 vote_n" value="??????" onClick="javascript:chkForm();return false;" style="width:45%;float:right;border-radius:3px;height:40px;">
		</div>
	</div>

	<div class="d_2" style="max-width:90%;margin: 0 auto;margin-top:30px;display:none;">
		<table class="tbl_1" border="0" cellspacing="0" cellpadding="0" style="width:100%;table-layout:fixed">
			<tr>
				<td class="sub_title">?????? ??????</td>
			</tr>
			<tr>
				<td class="input_td">
					<input class="input-common" type="text" name="vote_title" value="" placeholder="?????? ????????? ??????????????????.">
				</td>
			</tr>
			<tr>
				<td class="sub_title">?????? ?????? ??????</td>
			</tr>
			<tr>
				<td class="input_td">
					<select class="select-common" name="result_check" style="width:100%;box-sizing:border-box;border:none;">
						<option value="1">?????? ?????? ??? ??????</option>
						<option value="2">?????? ?????? ??? ??????</option>
						<option value="3">?????? ??????</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="input_td">
					?????? ?????? ??????
					<input type="checkbox" name="multi_choice" value="Y" style="margin-left:20px;margin-right:60px;">
					????????? ??????
					<input type="checkbox" name="anonymous" value="Y" style="margin-left:20px;">
				</td>
			</tr>
			<tr>
				<td>
					<table class="list_tbl" width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:30px;border:none;">
						<colgroup>
							<col width="10%">
							<col width="70%">
							<col width="20%">
						</colgroup>
						<tr>
							<td colspan="3" class="sub_title" style="font-weight:bold;color:#1C1C1C;border-bottom:none;">?????? ?????? ??????</td>
						</tr>
						<tr class="vote_content_tr">
							<td class="border-r border-l" align="center" style="background-color:#F4F4F4">
								<span class="num">1</span>
							</td>
							<td class="border-r" style="padding-left:10px;padding-right:10px;">
								<input type="text" class="input-common vote_input" value="" placeholder="??????????????? ???????????????.">
							</td>
							<td align="center" class="border-r">
								<img src="/misc/img/btn_plus_white.svg" style="width:22px;margin-right:2px;" onclick="addRow(this, 'plus')">
								<img src="/misc/img/btn_minus_white.svg" style="width:22px;" onclick="addRow(this, 'minus')">
							</td>
						</tr>
						<tr class="vote_content_tr">
							<td class="border-r border-l" align="center" style="background-color:#F4F4F4">
								<span class="num">1</span>
							</td>
							<td class="border-r" style="padding-left:10px;padding-right:10px;">
								<input type="text" class="input-common vote_input" value="" placeholder="??????????????? ???????????????.">
							</td>
							<td align="center" class="border-r">
								<img src="/misc/img/btn_plus_white.svg" style="width:22px;margin-right:2px;" onclick="addRow(this, 'plus')">
								<img src="/misc/img/btn_minus_white.svg" style="width:22px;" onclick="addRow(this, 'minus')">
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<div style="margin-top:30px;">
			<input type="button" class="btn-common btn-color1" value="??????" onclick="next_div('d_2');" style="width:45%;float:left;border-radius:3px;height:40px;">
			<input type="button" class="btn-common btn-color2" value="??????" onClick="javascript:chkForm();return false;" style="width:45%;float:right;border-radius:3px;height:40px;">
		</div>
	</div>

</form>
<div style="position:fixed;bottom:100px;right:5px;">
		<!-- <img src="<?php echo $misc; ?>img/mobile/btn_top.svg" onclick="$('html').scrollTop(0);"> -->
</div>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
</body>
<script type="text/javascript">
	function cancel() {
		if(confirm('????????? ?????????????????????????')) {
			history.go(-1);
		}
	}

	function next_div(div) {
		if(div == 'd_1') {
			var title = $.trim($('input[name=title]').val());
			var vote_yn = $('input[name=vote_yn]:checked').val();
			var deadline_day = $('input[name=deadline_day]').val();
			var deadline_time = $('input[name=deadline_time]').val();
			var deadline = new Date(deadline_day + 'T' + deadline_time);
			var now = new Date();
			if(title == '') {
				alert('????????? ???????????????.');
				return false;
			} else if(vote_yn == 'Y' && (deadline_day == '' || deadline_time == '')) {
				alert('???????????? ??????????????????.');
				return false;
			} else if (deadline < now) {
				alert('?????? ?????? ????????? ?????? ?????? ???????????????.');
				return false;
			} else {
				$('.' + div).hide();
				$('.d_2').show();
			}
		} else if (div == 'd_2') {
			$('.d_2').hide();
			$('.d_1').show();
		}
	}

	var request_url = "<?php echo site_url(); ?>/biz/diquitaca/qna_input_action";
	var response_url = "<?php echo site_url(); ?>/biz/diquitaca/qna_list";

	$('select[name=category]').on('change', function() {
		var val = $('select[name=category] option:checked').text();

		if($.trim(val) == '??????') {
			$('.vote_tr').show();
			$('.vote_n').hide();
			$('.vote_y').show();
			$(this).closest('td').attr('colspan', '1');
			$('input[name=vote_yn]').val('Y');
		} else {
			$('.vote_tr').hide();
			$('.vote_n').show();
			$('.vote_y').hide();
			$(this).closest('td').attr('colspan', '3');
			$('input[name=vote_yn]').val('N');
		}
	})

	$(function() {
		$('select[name=category]').change();
		$('.progressbar').progressbar({value: 0});
		// $('#progresstext').html('2???');
		numbering();
		fileDropDown();
	})

	function numbering() {
		var num = 1;
		$('.num').each(function() {
			$(this).text(num);
			num ++;
		})
	}

	function addRow(el, mode) {
		var tr = $(el).closest('tr');
		if(mode == 'minus') {
			if($('.vote_content_tr').length < 3) {
				alert('?????? 2??? ????????? ???????????????.');
				return false;
			} else {
				tr.remove();
			}
		} else if (mode == 'plus') {
			var add_tr = '<tr class="vote_content_tr"><td class="border-r border-l" align="center" style="background-color:#F4F4F4"><span class="num">1</span></td><td class="border-r" style="padding-left:10px;padding-right:10px;"><input type="text" class="input-common vote_input" value="" placeholder="??????????????? ???????????????."></td><td align="center" class="border-r"><img src="/misc/img/btn_plus_white.svg" style="width:22px;margin-right:2px;" onclick="addRow(this, '+"'plus'"+')"><img src="/misc/img/btn_minus_white.svg" style="width:22px;" onclick="addRow(this, '+"'minus'"+')"></td></tr>';

			tr.after(add_tr);
			$('.progressbar').progressbar({value: 0});
		}

		numbering();
	}

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
		html += "    <td class='left' style='border:none;height:20px;'>";
		html +=         fileName + " / " + fileSize + "MB "  + "<a href='#' onclick='deleteFile(" + fIndex + "); return false;' class='btn small bg_02'><img src='/misc/img/btn_del2.jpg' style='vertical-align:middle;'></a>";
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

	//????????? ????????? ?????? ??????
	function dbDeleteFile(fIndex){
	$("#dbfileTr_" + fIndex).remove();
		// file_realname.splice(fIndex, 1);
		file_realname[fIndex] ='';
		file_changename[fIndex] ='';
	}

	var chkForm = function() {
		var rv = true;
		var mform = document.tx_editor_form;

		if(mform.title.value == '') {
			mform.title.focus();
			alert('????????? ????????? ?????????.');
			return rv = false;
		}

		if(mform.category.value == '') {
			mform.category.focus();
			alert('??????????????? ????????? ?????????.');
			return rv = false;
		}

		if($('select[name=category] option:checked').text() == '??????') {
			if(mform.deadline_day.value == '') {
				mform.deadline_day.focus();
				alert('?????? ?????? ?????? ??????????????????.');
				return rv = false;
			}
			if(mform.deadline_time.value == '') {
				mform.deadline_time.focus();
				alert('?????? ?????? ????????? ??????????????????.');
				return rv = false;
			}

			var deadline = new Date(mform.deadline_day.value + ' ' + mform.deadline_time.value);
			var now = new Date();

			if(deadline < now) {
				mform.deadline_time.focus();
				alert('?????? ?????? ????????? ?????? ?????? ???????????????.');
				return rv = false;
			}

			if(mform.vote_title.value == '') {
				mform.vote_title.focus();
				alert('?????? ????????? ??????????????????.');
				return rv = false;
			}
			$('.vote_input').each(function() {
				if($.trim($(this).val()) == '') {
					$(this).focus();
					alert('?????? ????????? ??????????????????.');
					return rv = false;
				}
			})
		}

		if(rv) {
			$('#contents').val(Editor.getContent());

			var formData = new FormData(document.getElementById('tx_editor_form'));

			var uploadFileList = Object.keys(fileList);

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

			$('.vote_input').each(function() {
				formData.append('vote_content[]', $.trim($(this).val()));
			})

			$.ajax({
				url: "<?php echo site_url(); ?>/biz/diquitaca/qna_input_action",
				data: formData,
				type: 'POST',
				enctype: 'multipart/form-data',
				processData: false,
				contentType: false,
				dadtaType: 'json',
				cache: false,
				success: function(result) {
					if(result) {
						alert('?????????????????????.');
						location.href = "<?php echo site_url(); ?>/biz/diquitaca/qna_list";
					} else {
						alert('????????? ?????????????????????. ??????????????? ???????????????.');
					}
				}
			})
		}
	}
</script>
</html>

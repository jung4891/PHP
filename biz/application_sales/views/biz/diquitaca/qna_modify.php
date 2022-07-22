<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<link rel="stylesheet" href="/misc/daumeditor-7.4.9/css/editor.css" type="text/css" charset="utf-8"/>
<script src="/misc/daumeditor-7.4.9/js/editor_loader.js" type="text/javascript" charset="utf-8"></script>
<script language="javascript">
</script>
<style media="screen">
.basic_table {border: 1px solid #DEDEDE;}
.list_tbl {border-top: 1px solid #DEDEDE;border-bottom: none;}
.border-l {border-left: 1px solid #DEDEDE;}
.border-r {border-right: 1px solid #DEDEDE;}
.input-common {width:100%;box-sizing: border-box;}
.bardivs { width: 100%; position: relative; }
.progresstext { position: absolute; top: 0; left: 0; width: 98%; padding-top: 5px; text-align: right; font-weight: bold;}
.ui-widget-header{ background-color: #0575E6;}
.ui-corner-all{ background-color: #F8F9FB; border-color: #DEDEDE; border-radius: 3px;}
.num {padding-left:4px;padding-right:4px;width: 30px;height: 25px;margin-left: 3px;text-align: center;font-size: 14px;color: #ccc;vertical-align: middle;}
.item{position: relative;min-height: 25px;border: 1px solid #ebecef;border-radius: 2px;}
.FlexableTextArea {display: inline-block;min-height: 25px;width: calc(100% - 30px);vertical-align: middle;}
.textarea_input{width: 100%;min-height: 25px;border: 0;font-size: 14px;line-height: 19px;letter-spacing: 0;height:25px;font-family: "Noto Sans KR", sans-serif;}
.textarea_input {display: block;width: 100%;min-height: 25px;border: 1px solid #ebecef;box-sizing: border-box;overflow: hidden;resize: none;word-break: break-all;font-size: 15px;letter-spacing: -.23px;line-height: 17px;border: none;}
.list_tbl td {border-bottom: none;color:#626262}
.vote_content_tr td {border-bottom: thin solid #DEDEDE;}
</style>
<script type="text/javascript" src="/misc/js/jquery.bpopup-0.1.1.min.js"></script>
<body>
<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
	$my_vote = $my_vote['my_vote_seq'];
	$my_vote_seq_arr = explode(',', $my_vote);
	$my_vote_seq_arr = array_filter($my_vote_seq_arr);
?>
	<div align="center">
		<div class="dash1-1">
			<table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
				<form name="tx_editor_form" id="tx_editor_form" action="<?php echo site_url();?>/biz/board/notice_input_action" method="post" enctype="multipart/form-data" onSubmit="javascript:chkForm();return false;">
					<input type="hidden" name="seq" value="<?php echo $seq; ?>">
					<input type="hidden" id="type" name="type" value="0" />
					<input type="hidden" name="vote_yn" value="<?php echo $qna_val['vote_yn']; ?>">
					<tr>
	  				<td class="dash_title">
							디키타카
							<img style="cursor:pointer;vertical-align:middle;margin-left:5px;" src="/misc/img/dashboard/btn/btn_info.svg" width="25" onclick="open_inf(this);"/>
						</td>
					</tr>
					<tr>
						<td align="right">
							<input style="margin-top:20px;margin-right:10px;" type="button" class="btn-common btn-color1" value="취소" onClick="javascript:history.go(-1)">
							<input style="margin-top:20px;" type="button" class="btn-common btn-color2" value="수정" onClick="javascript:chkForm();return false;">
						</td>
					</tr>
  				<tr>
    				<td align="center" valign="top">

    					<table width="100%" height="100%" cellspacing="0" cellpadding="0" >
        				<tr>
            			<td width="100%" align="center" valign="top">
            				<table width="100%" border="0" style="margin-top:20px;">
              				<tr>
                				<td>
													<table class="list_tbl" width="100%" border="0" cellspacing="0" cellpadding="0">

														<colgroup>
															<col width="8%">
															<col width="25%">
															<col width="8%">
															<col width="25%">
															<col width="8%">
															<col width="25%">
														</colgroup>

														<tr>
															<td height="50" align="left" style="padding-left:50px;">제목</td>
															<td style="padding-left:10px;">
																<input type="text" name="title" class="input-common" value="<?php echo htmlspecialchars($qna_val['title']); ?>" placeholder="제목을 입력하세요.">
															</td>
															<td height="50" align="left" style="padding-left:50px;">등록자</td>
															<td style="padding-left:10px;"><?php echo $qna_val['user_name']; ?></td>
															<td height="50" align="left" style="padding-left:50px;">등록일</td>
															<td style="padding-left:10px;"><?php echo date("Y-m-d", strtotime($qna_val['insert_date']));?></td>
                  					</tr>
														<tr>
															<td height="50" align="left" style="padding-left:50px;">카테고리</td>
															<td style="padding-left:10px;">
																<select class="select-common select-style1" name="category">
																	<option value="" selected disabled>카테고리 선택</option>
													<?php foreach($category as $c) { ?>
																	<option value="<?php echo $c['seq']; ?>" <?php if($qna_val['category'] == $c['seq']) {echo "selected";} ?>><?php echo $c['category_name']; ?></option>
													<?php } ?>
																</select>
															</td>
															<td height="50" align="left" style="padding-left:50px;" class="vote_tr">마감일</td>
															<td style="padding-left:10px;" class="vote_tr">
																<input class="input-common dayBtn" type="date" name="deadline_day" id="startDay" value="<?php if($qna_val['vote_yn']=='Y'){echo date('Y-m-d', strtotime($qna_val['vote_deadline']));} ?>" autocomplete="off" style="width:125px;vertical-align:middle;margin-right:1%;">
									              <input class="input-common timeBtn" type="time" name="deadline_time" id="startTime" value="<?php echo date('H:i', strtotime($qna_val['vote_deadline'])); ?>" autocomplete="off" style="width:120px;vertical-align:middle;">
															</td>
															<td height="50" align="left" style="padding-left:50px;">파일업로드</td>
															<td style="padding-left:10px;">
																<?php
																	 $file_html = "";
																	 if($qna_val['file_realname'] != ""){
																			$file = explode('*/*',$qna_val['file_realname']);
																			for($i=0; $i<count($file); $i++){
																				 $file_html .= "<tr id='dbfileTr_{$i}'>";
																				 $file_html .= "<td style='height:20px;' class='left' >";
																				 $file_html .= $file[$i]." <a href='#' onclick='dbDeleteFile({$i}); return false;' class='btn small bg_02'><img src='{$misc}/img/btn_del2.jpg' style='vertical-align:middle;'></a>";
																				 $file_html .= "</td>";
																				 $file_html .= "</tr>";
																			}
																	 }
																?>
																<table width="100%" height="auto" style="border:none;">
																	<tbody id="fileTableTbody">
																		<tr>
																			<td id="dropZone" style="border:thin solid #DFDFDF;border-radius:3px;color:#B0B0B0;padding-left:10px;background-color:#F8F9FB">
																				 이곳에 파일을 드래그 하세요.
																		 </td>
																	 </tr>
																	</tbody>
																	<?php echo $file_html; ?>
																</table>
															</td>
														</tr>
														<tr class="vote_tr">
															<td height="50" align="left" style="padding-left:50px;">투표 제목</td>
															<td style="padding-left:10px;">
																<input class="input-common" type="text" name="vote_title" value="<?php if(isset($vote_val['title'])){echo htmlspecialchars($vote_val['title']);} ?>" placeholder="투표 제목을 입력해주세요.">
															</td>
															<td height="50" align="left" style="padding-left:50px;">투표 현황 보기</td>
															<td style="padding-left:10px;">
																<select class="select-common" name="result_check" style="width:130px;">
																	<option value="1" <?php if(isset($vote_val['result_check'])){if($vote_val['result_check'] == "1") {echo 'selected';}} ?>>투표 참여 후 보기</option>
																	<option value="2" <?php if(isset($vote_val['result_check'])){if($vote_val['result_check'] == "2") {echo 'selected';}} ?>>투표 종료 후 보기</option>
																	<option value="3" <?php if(isset($vote_val['result_check'])){if($vote_val['result_check'] == "3") {echo 'selected';}} ?>>항상 보기</option>
																</select>
															</td>
															<td height="50" colspan="2" align="left" style="padding-left:50px;">
																복수 선택 허용
																<input type="checkbox" name="multi_choice" value="Y" style="margin-left:20px;margin-right:60px;" <?php if(isset($vote_val['multi_choice'])){if($vote_val['multi_choice'] == "Y") {echo 'checked';}} ?>>
																무기명 투표
																<input type="checkbox" name="anonymous" value="Y" style="margin-left:20px;" <?php if(isset($vote_val['multi_choice'])){if($vote_val['anonymous'] == "Y") {echo 'checked';}} ?>>
															</td>
															<td></td>
														</tr>
                            <tr>
                              <td height="50" align="left" style="padding-left:50px;">내용</td>
															<td colspan="5" style="border-bottom:none;padding-top:10px;">
																<textarea name="content" id="content" style="display:none;"><?php echo $qna_val['contents']; ?></textarea>
																<input type="hidden" name="contents" id="contents" value="">
																<?php include $this->input->server('DOCUMENT_ROOT')."/misc/daumeditor-7.4.9/editor.php"; ?>
															</td>
                  					</tr>
                						</table>
													</td>
              					</tr>
            					</table>
            				</td>
        					</tr>
					<?php $voted_cnt = count($vote_list); ?>
									<input type="hidden" id="voted" value="<?php if($voted_cnt > 0){echo 'true';}else{echo 'false';} ?>">
					<?php	if($qna_val['vote_yn'] == 'Y') { ?>
									<tr class="vote_tr vote_input_tr">
										<td>
											<table class="list_tbl" width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:30px;">
												<colgroup>
													<col width="10%">
													<col width="85%">
													<col width="10%">
												</colgroup>
												<tr>
													<td colspan="4" class="dash_title" style="color:#1C1C1C;padding-top:20px;padding-bottom:20px;border-bottom:thin solid #DEDEDE;">
														투표진행내용
													</td>
												</tr>
							<?php if(!empty($vote_content)) {
											foreach($vote_content as $vc) { ?>
												<tr class="vote_content_tr vote_toggle_tr" seq="<?php echo $vc['seq']; ?>">
													<td class="border-r" style="padding-left:20px;padding-right:10px;">
														<span class="num">1</span>
													</td>
													<td class="border-r" style="padding-left:10px;padding-right:10px;">
														<input type="text" class="input-common vote_input" value="<?php echo $vc['content']; ?>" placeholder="진행내용을 입력하세요.">
													</td>
													<td align="center">
										<?php if($voted_cnt == 0){ ?>
														<img src="/misc/img/btn_plus_white.svg" style="width:30px;margin-right:10px;" onclick="addRow(this, 'plus')">
														<img src="/misc/img/btn_minus_white.svg" style="width:30px;" onclick="addRow(this, 'minus')">
										<?php } ?>
													</td>
												</tr>
								<?php }
										} ?>
											</table>
										</td>
									</tr>
					<?php } else { ?>
									<tr class="vote_tr">
										<td>
											<table class="list_tbl" width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:30px;">
												<colgroup>
													<col width="10%">
													<col width="85%">
													<col width="10%">
												</colgroup>
												<tr>
													<td colspan="4" class="dash_title" style="color:#1C1C1C;padding-top:20px;padding-bottom:20px;border-bottom:thin solid #DEDEDE;">
														투표진행내용
													</td>
												</tr>
												<tr class="vote_content_tr">
													<td class="border-r" style="padding-left:20px;padding-right:10px;">
														<span class="num">1</span>
													</td>
													<td class="border-r" style="padding-left:10px;padding-right:10px;">
														<input type="text" class="input-common vote_input" value="" placeholder="진행내용을 입력하세요.">
													</td>
													<td align="center">
														<img src="/misc/img/btn_plus_white.svg" style="width:30px;margin-right:10px;" onclick="addRow(this, 'plus')">
														<img src="/misc/img/btn_minus_white.svg" style="width:30px;" onclick="addRow(this, 'minus')">
													</td>
												</tr>
												<tr class="vote_content_tr">
													<td class="border-r" style="padding-left:20px;padding-right:10px;">
														<span class="num">1</span>
													</td>
													<td class="border-r" style="padding-left:10px;padding-right:10px;">
														<input type="text" class="input-common vote_input" value="" placeholder="진행내용을 입력하세요.">
													</td>
													<td align="center">
														<img src="/misc/img/btn_plus_white.svg" style="width:30px;margin-right:10px;" onclick="addRow(this, 'plus')">
														<img src="/misc/img/btn_minus_white.svg" style="width:30px;" onclick="addRow(this, 'minus')">
													</td>
												</tr>
											</table>
										</td>
									</tr>
					<?php } ?>
     						</table>
    					</td>
  					</tr>
					</form>
				</table>
			</div>
		</div>
		<div id="icon_inf" style="display: none; position: absolute;background-color: white;border: 2px solid #B0B0B0;
		border-radius: 3px; width:410px;">
		  <span style="cursor: pointer;float: right;margin-right: 10px;margin-top: 10px;" onclick="$('#icon_inf').bPopup().close();">×</span>
		  <div style="padding: 10px 20px 15px 20px;">
		    <p class="content">이미 투표한 사람이 있을 경우 투표 관련 내용은 수정 할 수 없습니다.</p>
		  </div>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
</body>
<script type="text/javascript">
	var request_url = "<?php echo site_url(); ?>/biz/diquitaca/qna_input_action";
	var response_url = "<?php echo site_url(); ?>/biz/diquitaca/qna_list";

	var file_realname = "<?php echo $qna_val['file_realname']; ?>".split("*/*");
	var file_changename = "<?php echo $qna_val['file_changename']; ?>".split("*/*");

	$('select[name=category]').on('change', function() {
		var val = $('select[name=category] option:checked').text();

		if($.trim(val) == '투표') {
			$('.vote_tr').show();
			$(this).closest('td').attr('colspan', '1');
			$(this).closest('td').removeClass('border-r');
			$('input[name=vote_yn]').val('Y');
		} else {
			$('.vote_tr').hide();
			$(this).closest('td').attr('colspan', '3');
			$(this).closest('td').addClass('border-r');
			$('input[name=vote_yn]').val('N');
		}
	})

	$(function() {
		$('input[name=vote_yn]').change();
		$('.progressbar').progressbar({value: 0});
		// $('#progresstext').html('2명');
		numbering();
		fileDropDown();
		progressing();
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
				alert('최소 2개 항목이 필요합니다.');
				return false;
			} else {
				tr.remove();
			}
		} else if (mode == 'plus') {
			var add_tr = '<tr class="vote_content_tr"><td class="border-r" style="padding-left:20px;padding-right:10px;"><span class="num">1</span></td><td class="border-r" style="padding-left:10px;padding-right:10px;"><input type="text" class="input-common vote_input" value="" placeholder="진행내용을 입력하세요."></td><td align="center"><img src="/misc/img/btn_plus_white.svg" style="width:30px;margin-right:10px;" onclick="addRow(this, '+"'plus'"+')"><img src="/misc/img/btn_minus_white.svg" style="width:30px;" onclick="addRow(this, '+"'minus'"+')"></td></tr>';

			tr.after(add_tr);
			$('.progressbar').progressbar({value: 0});
		}

		numbering();
	}

	// 파일 리스트 번호
	var fileIndex = 0;
	// 등록할 전체 파일 사이즈
	var totalFileSize = 0;
	// 파일 리스트
	var fileList = new Array();
	// 파일 사이즈 리스트
	var fileSizeList = new Array();
	// 등록 가능한 파일 사이즈 MB
	var uploadSize = 50;
	// 등록 가능한 총 파일 사이즈 MB
	var maxUploadSize = 500;

	// 파일 드롭 다운
	function fileDropDown(){
		var dropZone = $("#dropZone");
		//Drag기능
		dropZone.on('dragenter',function(e){
			e.stopPropagation();
			e.preventDefault();
			// 드롭다운 영역 css
			dropZone.css('background-color','#E3F2FC');
		});
		dropZone.on('dragleave',function(e){
			e.stopPropagation();
			e.preventDefault();
			// 드롭다운 영역 css
			dropZone.css('background-color','#FFFFFF');
		});
		dropZone.on('dragover',function(e){
			e.stopPropagation();
			e.preventDefault();
			// 드롭다운 영역 css
			dropZone.css('background-color','#E3F2FC');
		});
		dropZone.on('drop',function(e){
			e.preventDefault();
			// 드롭다운 영역 css
			dropZone.css('background-color','#FFFFFF');

			var files = e.originalEvent.dataTransfer.files;
			if(files != null){
				if(files.length < 1){
					alert("폴더 업로드 불가");
					return;
				}
				selectFile(files)
			}else{
				alert("ERROR");
			}
		});
	}

	// 파일 선택시
	function selectFile(files){
		// 다중파일 등록
		if(files != null){
			for(var i = 0; i < files.length; i++){
				// 파일 이름
				var fileName = files[i].name;
				var fileNameArr = fileName.split("\.");
				// 확장자
				var ext = fileNameArr[fileNameArr.length - 1];
				// 파일 사이즈(단위 :MB)
				var fileSize = files[i].size / 1024 / 1024;

				if($.inArray(ext, ['exe', 'bat', 'sh', 'java', 'jsp', 'html', 'js', 'css', 'xml']) >= 0){
					// 확장자 체크
				  alert("등록 불가 확장자");
					break;
				}else if(fileSize > uploadSize){
					// 파일 사이즈 체크
					alert("용량 초과\n업로드 가능 용량 : " + uploadSize + " MB");
					break;
				}else{
					// 전체 파일 사이즈
					totalFileSize += fileSize;
					// 파일 배열에 넣기
					fileList[fileIndex] = files[i];
					// 파일 사이즈 배열에 넣기
					fileSizeList[fileIndex] = fileSize;
					// 업로드 파일 목록 생성
					addFileList(fileIndex, fileName, fileSize);
					// 파일 번호 증가
					fileIndex++;
				}
			}
		}else{
			alert("ERROR");
		}
	}

	// 업로드 파일 목록 생성
	function addFileList(fIndex, fileName, fileSize){
		var html = "";
		html += "<tr id='fileTr_" + fIndex + "'>";
		html += "    <td class='left' style='border:none;height:20px;'>";
		html +=         fileName + " / " + fileSize + "MB "  + "<a href='#' onclick='deleteFile(" + fIndex + "); return false;' class='btn small bg_02'><img src='/misc/img/btn_del2.jpg' style='vertical-align:middle;'></a>";
		html += "    </td>";
		html += "</tr>";

		$('#fileTableTbody').append(html);
	}

	// 업로드 파일 삭제
	function deleteFile(fIndex){
		// 전체 파일 사이즈 수정
		totalFileSize -= fileSizeList[fIndex];
		// 파일 배열에서 삭제
		delete fileList[fIndex];
		// 파일 사이즈 배열 삭제
		delete fileSizeList[fIndex];
		// 업로드 파일 테이블 목록에서 삭제
		$("#fileTr_" + fIndex).remove();
	}

	//디비에 등록된 파일 삭제
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
			alert('제목을 입력해 주세요.');
			return rv = false;
		}

		if(mform.category.value == '') {
			mform.category.focus();
			alert('카테고리를 선택해 주세요.');
			return rv = false;
		}

		if($('select[name=category] option:checked').text() == '투표') {
			if(mform.deadline_day.value == '') {
				mform.deadline_day.focus();
				alert('투표 마감 일을 입력해주세요.');
				return rv = false;
			}
			if(mform.deadline_time.value == '') {
				mform.deadline_time.focus();
				alert('투표 마감 시간을 입력해주세요.');
				return rv = false;
			}

			var deadline = new Date(mform.deadline_day.value + ' ' + mform.deadline_time.value);
			var now = new Date();

			if(deadline < now) {
				mform.deadline_time.focus();
				alert('투표 마감 시간이 현재 시간 이전입니다.');
				return rv = false;
			}

			if(mform.vote_title.value == '') {
				mform.vote_title.focus();
				alert('투표 제목을 입력해주세요.');
				return rv = false;
			}
			$('.vote_input').each(function() {
				if($.trim($(this).val()) == '') {
					$(this).focus();
					alert('투표 항목을 입력해주세요.');
					return rv = false;
				}
			})
		}

		if(rv) {
			$('#contents').val(Editor.getContent());

			var formData = new FormData(document.getElementById('tx_editor_form'));

			file_realname = file_realname.filter(Boolean);
	    file_changename = file_changename.filter(Boolean);
	    formData.append('file_realname', file_realname.join('*/*'));
	    formData.append('file_changename', file_changename.join('*/*'));

			var uploadFileList = Object.keys(fileList);

			formData.append('file_length', uploadFileList.length);
			if(uploadFileList.length > 0){
					// 용량을 500MB를 넘을 경우 업로드 불가
				if (totalFileSize > maxUploadSize) {
					// 파일 사이즈 초과 경고창
					alert("총 용량 초과\n총 업로드 가능 용량 : " + maxUploadSize + " MB");
					return;
				}

				// 등록할 파일 리스트를 formData로 데이터 입력
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
						if(result == '"already_voted"') {
							alert('이미 투표한 사람이 있습니다.\n투표 내용을 제외한 내용만 수정되었습니다.');
							location.href = "<?php echo site_url(); ?>/biz/diquitaca/qna_view?seq=<?php echo $seq; ?>";
						} else {
							alert('저장되었습니다.');
							location.href = "<?php echo site_url(); ?>/biz/diquitaca/qna_view?seq=<?php echo $seq; ?>";
						}
					} else {
						alert('저장에 실패하였습니다. 관리자에게 문의주세요.');
					}
				}
			})
		}
	}

	function progressing() {
		var val = $('input[name=vote_yn]:checked').val();
		if(val == 'Y') {
			var my_vote_cnt = '<?php if(isset($my_vote_seq_arr)){echo count($my_vote_seq_arr);}else{echo 0;} ?>';
			var result_check = $('select[name=result_check]').val();
			var deadline = new Date('<?php echo date('Y-m-d H:i', strtotime($qna_val['vote_deadline'])); ?>');
			var now = new Date();

			if(deadline < now) {
				$('.vote_btn').hide();
			}

			if( (result_check == 1 && my_vote_cnt > 0) || (result_check == 2 && deadline < now) || result_check == 3 || deadline < now) {
				var user_cnt = "<?php echo $user_count['cnt']; ?>";

				$.ajax({
					url: "<?php echo site_url(); ?>/biz/diquitaca/vote_progress",
					type: "POST",
					dataType: "json",
					data: {
						seq: '<?php echo $seq; ?>'
					},
					cache: false,
					async: false,
					success: function(data) {
						if(data) {
							for(i = 0; i < data.length; i++) {
								var vote_cnt = data[i].vote_cnt;
								if(vote_cnt == null) {
									vote_cnt = 0;
								}
								var percentage = (vote_cnt/user_cnt) * 100;
								$('#progressbar_'+data[i].seq).progressbar({value: percentage});
								$('#progresstext_'+data[i].seq).html(vote_cnt+"명");
							}
						}
					}
				});
			}
		}
	}

  function open_inf(el) {
    var position = $(el).offset();

    $('#icon_inf').bPopup({
      opacity: 0,
      follow: [false, false],
      position: [position.left+25, position.top+25]
    });
  }

	var voted = $('#voted').val();
	$('.vote_input_tr input, .vote_input_tr select').on('click', function() {
		if(voted == 'true') {
			alert('투표를 진행한 사람이 있을 경우 수정이 불가능 합니다.');
			$(this).blur();
			return false;
		}
	})
</script>
</html>

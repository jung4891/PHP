<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<!-- <link rel="stylesheet" href="/misc/css/dashboard.css"> -->
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<link rel="stylesheet" href="/misc/daumeditor-7.4.9/css/editor.css" type="text/css" charset="utf-8"/>
<script src="/misc/daumeditor-7.4.9/js/editor_loader.js" type="text/javascript" charset="utf-8"></script>
<script language="javascript">

//$(document).ready(function() {
//   $('li > ul').show();
//});
</script>
<style media="screen">
.basic_table {
	border: 1px solid #DEDEDE;
}
.list_tbl {
	border-top: 1px solid #DEDEDE;
	border-bottom: none;
}
.border-l {
	border-left: 1px solid #DEDEDE;
}
.border-r {
	border-right: 1px solid #DEDEDE;
}
</style>
<body>
<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
	<div align="center">
		<div class="dash1-1">
			<table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
	<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.css" rel="stylesheet"> -->
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.js"></script> -->
				<form name="tx_editor_form" id="tx_editor_form" action="<?php echo site_url();?>/biz/dev_request/dev_request_input_action" method="post" enctype="multipart/form-data" onSubmit="chkForm();return false;">
					<input type="hidden" name="seq" value="">
					<input type="hidden" id="type" name="type" value="1" />
					<tr>
	  				<td class="dash_title">
							개발 요청사항
						</td>
					</tr>
					<tr>
						<td align="right">
							<input style="margin-top:20px;margin-right:10px;" type="button" class="btn-common btn-color1" value="취소" onClick="javascript:history.go(-1)">
							<input style="margin-top:20px;" type="button" class="btn-common btn-color2" value="등록" onClick="javascript:chkForm();return false;">
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
															<col width="15%">
															<col width="35%">
															<col width="15%">
															<col width="35%">
														</colgroup>
														<tr>
                              <td height="40" align="center" style="font-weight:bold;" class="row-color1 border-l">카테고리</td>
															<td style="padding-left:10px;">
																<select name="category_code" id="category_code" class="select-common" onchange="change_category(this);" style="width:305px;">
																	<option value="신규개발">신규개발</option>
																	<option value="기능개선">기능개선</option>
																	<option value="문의사항">문의사항</option>
																	<option value="버그수정">버그수정</option>
																</select>
															</td>
					          					<td align="center" class="row-color1" style="font-weight:bold;">날짜</td>
					                    <td align="center" class="border-r"><?php echo date("Y-m-d");?></td>
                  					</tr>
                  					<tr>
					                    <td height="40" align="center" class="row-color1 border-l" style="font-weight:bold;">제목</td>
					                    <td style="padding-left:10px;">
																<input type="text" name="subject" id="subject" class="input-common" style="width:300px;"/>
															</td>
															<td align="center" class="row-color1" style="font-weight:bold;" >등록자</td>
															<td align="center" name="insert_id" id="insert_id" class="border-r"><?php echo $name;?></td>
                  					</tr>
                            <tr>
                              <td height="40" align="center" class="row-color1 border-l" style="font-weight:bold;">URL</td>
                              <td colspan="2" style="padding-left:10px;">
																<input type="text" name="page_url" id="page_url" class="input-common" style="width:700px;"/>
															</td>
															<td></td>
															<td class="border-l"></td>
                            </tr>
														<tr>
                              <td height="40" align="center" class="row-color1 border-l border-r" colspan="4" style="font-weight:bold;">상세요청사항</td>
                            </tr>
														<tr>
															<td colspan="4" style="border-bottom:none">
																<textarea name="content" id="content" style="display:none;"></textarea>
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
									<tr>
										<td colspan="4">
											<div>
												<img src="<?php echo $misc; ?>/img/file_upload.png" style="width:20px;float:left;vertical-align:middle;"><h3 style="float:left;margin:0px;">&nbsp;파일업로드</h3><br>
												<table class="basic_table row-color1" width="100%" height="auto" style="margin-top:20px;" >
													<tbody id="fileTableTbody">
														<tr>
															<td id="dropZone" height="100px">
																 이곳에 파일을 드래그 하세요.
														 </td>
													 </tr>
													</tbody>
												</table>
											</div>
										</td>
									</tr>
     						</table>
    					</td>
  					</tr>
					</form>
				</table>
			</div>
		</div>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
</body>
<script type="text/javascript">
	var loc = $("#category_code option:selected").val();

	var request_url = "<?php echo site_url(); ?>/biz/dev_request/dev_request_input_action";
	var response_url = "<?php echo site_url(); ?>/biz/dev_request/dev_request_list?category="+loc;

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

  $(function (){
  	// 파일 드롭 다운
  	fileDropDown();
  });

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
  	html += "    <td class='left' >";
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

  var chkForm = function () {

  	var mform = document.tx_editor_form;

  	if(mform.subject.value == "") {
  		mform.subject.focus();
   		alert("제목을 입력해 주세요.");
   		return false;
   	}

		// if(mform.contents.value == "") {
  	// 	mform.contents.focus();
   	// 	alert("상세요청사항을 입력해 주세요.");
   	// 	return false;
   	// }

  	$("#contents").val(Editor.getContent());

  	var formData = new FormData(document.getElementById("tx_editor_form"));

    if($("#type").val()==0){
      file_realname = file_realname.filter(Boolean);
      file_changename = file_changename.filter(Boolean);
      formData.append('file_realname', file_realname.join('*/*'));
      formData.append('file_changename', file_changename.join('*/*'));
    }

  	// 등록할 파일 리스트
  	var uploadFileList = Object.keys(fileList);

  	// 파일이 있는지 체크
  	formData.append('file_length', uploadFileList.length);
  	if(uploadFileList.length > 0){
  			// 용량을 500MB를 넘을 경우 업로드 불가
  		if(totalFileSize > maxUploadSize) {
  			// 파일 사이즈 초과 경고창
  			alert("총 용량 초과\n총 업로드 가능 용량 : " + maxUploadSize + " MB");
  			return;
  		}

  		// 등록할 파일 리스트를 formData로 데이터 입력
  		for (var i = 0; i < uploadFileList.length; i++) {
  			formData.append('files' + i, fileList[uploadFileList[i]]);
  		}
  	}

  	var loc = $("#category_code option:selected").val();

  	$.ajax({
  		url: '<?php echo site_url(); ?>/biz/dev_request/dev_request_input_action',
  		data: formData,
  		type: 'POST',
  		enctype: 'multipart/form-data',
  		processData: false,
  		contentType: false,
  		dataType: 'json',
  		cache: false,
  		success: function (result){
				if(result) {
					alert('저장되었습니다.');
					location.href = "<?php echo site_url(); ?>/biz/dev_request/dev_request_list";
				}
  		}
  	});
   	return false;
  }

</script>
<script type="text/javascript">
</script>
</html>

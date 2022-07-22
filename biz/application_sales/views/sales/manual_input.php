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
</style>
<script language="javascript">
$(document).ready(function() {
   $('li > ul').show();
});
</script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.js"></script>
<body>
<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
<div align="center">
	<div class="dash1-1">
		<table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
			<form id="cform" name="cform" action="<?php echo site_url();?>/sales/board/manual_input_action" method="post" enctype="multipart/form-data" onSubmit="javascript:chkForm();return false;">
				<input type="hidden" id="type" name="type" value="1" />
				<tr height="5%">
					<td class="dash_title">
						영업자료
					</td>
				</tr>
				<tr>
					<td height="40"></td>
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
									<select name="category_code" id="category_code" class="select-common">
								<?php
								foreach ($category  as $val) {
									echo '<option value="'.$val['code'].'"';
									echo '>'.$val['code_name'].'</option>';
								}
								?>
								</select>
								</td>
          			<td class="tbl-title">날짜</td>
          			<td class="tbl-mid"><?php echo date("Y-m-d");?></td>
              </tr>
              <tr>
                <td class="tbl-title">제목</td>
                <td class="tbl-cell"><input type="text" name="subject" id="subject" class="input-common"/></td>
                <td class="tbl-title">등록자</td>
                <td class="tbl-mid"><?php echo $name;?></td>
              </tr>
              <tr>
                <td colspan="4">
									<div id="summernote"></div>
									<input type="hidden" name="contents" id="contents" >
								</td>
              </tr>
            </table>
						<div class="">
							<img src="<?php echo $misc; ?>/img/file_upload.png" style="width:20px;float:left;vertical-align:middle;"><h3 style="float:left;margin:0px;">&nbsp;파일업로드</h3><br>
						</div>
						<table width="100%" border="0" cellspacing="0" cellpadding="0" style="table-layout:fixed; word-break:break-all;border: thin solid #DFDFDF;margin-bottom:50px;margin-top:20px;">
							<tr>
								<td>
									<div>
										<table class="basic_table" width="100%" bgcolor="f8f8f9" height="auto" >
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
				<tr>
					<td align="right">
						<input type="button" class="btn-common btn-color1" value="취소" onClick="javascript:history.go(-1)" style="margin-right:10px">
						<input type="button" class="btn-common btn-color2" value="등록" onClick="javascript:chkForm();return false;">
					</td>
				</tr>
			</form>
		</table>
	</div>
</div>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
</body>
<script type="text/javascript">
$('#summernote').summernote({ tabsize: 2, height: 300, disableDragAndDrop: true });

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
	html +=         fileName + " / " + fileSize + "MB "  + "<a href='#' onclick='deleteFile(" + fIndex + "); return false;' class='btn small bg_02'><img src='<?php echo $misc;?>/img/btn_del2.jpg' style='vertical-align:middle;'></a>";
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


var chkForm = function () {
	var mform = document.cform;

	if (mform.subject.value == "") {
		mform.subject.focus();
		alert("제목을 입력해 주세요.");
		return false;
	}

	$("#contents").val($('#summernote').summernote('code'));

	var formData = new FormData(document.getElementById("cform"));

	// 등록할 파일 리스트
	var uploadFileList = Object.keys(fileList);

	// 파일이 있는지 체크
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

	var loc = $("#category_code option:selected").val();

	$.ajax({
		url: "<?php echo site_url(); ?>/sales/board/manual_input_action",
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
				location.href = "<?php echo site_url(); ?>/sales/board/manual_list";
			} else {
				alert("저장에 실패하였습니다. 관리자에게 문의주세요.");
			}
		}
	});
	return false;
}
</script>
</html>

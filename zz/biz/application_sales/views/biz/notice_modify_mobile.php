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
.input-common, .textarea-common, .select-common {
	box-sizing : border-box;
	font-size: 14px !important;
	border-radius: 3px !important;
}

.file_label {
	display: inline-block;
	padding: .5em .75em;
	color: #FFFFFF;
	font-size: inherit;
	line-height: normal;
	vertical-align: middle;
	background-color: #A1A1A1;
	cursor: pointer;
	border: 1px solid #ebebeb;
	border-bottom-color: #e2e2e2;
	border-radius: .25em;
}
div.editor_div div.note-toolbar {
	display: none;
}
#tx_toolbar_basic {
	display:none;
}
</style>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<link rel="stylesheet" href="/misc/daumeditor-7.4.9/css/editor.css" type="text/css" charset="utf-8"/>
<script src="/misc/daumeditor-7.4.9/js/editor_loader.js" type="text/javascript" charset="utf-8"></script>
<script language="javascript">
function filedel(seq, filename) {
	if (confirm("정말 삭제하시겠습니까?") == true){
		location.href = "<?php echo site_url();?>/biz/board/notice_filedel/" + seq + "/" + filename;
		return false;
	}
}

</script>
<body>
<meta name="viewport" content="width=device-width,height=device-width, initial-scale=1.0">
<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/mobile_side.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/mobile_header.php";
	?>
<form name="tx_editor_form" id="tx_editor_form" action="<?php echo site_url();?>/biz/board/notice_input_action" method="post" enctype="multipart/form-data" onSubmit="javascript:chkForm();return false;">
<input type="hidden" name="seq" value="<?php echo $seq;?>">
<input type="hidden" id="type" name="type" value="0" />
<div style="max-width:90%;margin: 0 auto; padding-bottom: 60px;margin-top:30px;">
	<div width="100%">
		<table class="basic_table">
			<col width="30%">
			<col width="70%">
			<tr>
				<td bgcolor="#F4F4F4" style="font-weight:bold;">카테고리</td>
				<td>
					<select name="category_code" id="category_code" class="select-common" onchange="change_category(this);" style="width:100%;">
						<option value="001" <?php if($view_val['category_code'] == '001'){ echo 'selected'; } ?>>운영공지</option>
						<?php
							if($group == '기술연구소'){
								echo '<option value="002"';
								if($view_val['category_code'] == '002'){
									echo 'selected';
								}
								echo '>개발공지</option>';
								echo '<option value="003"';
								if($view_val['category_code'] == '003'){
									echo 'selected';
								}
								echo '>버전관리</option>';
							}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td bgcolor="#F4F4F4" style="font-weight:bold;">날짜</td>
				<td><?php echo $view_val['update_date'];?></td>
			</tr>
			<tr>
				<td bgcolor="#F4F4F4" style="font-weight:bold;">제목</td>
				<td><input type="text" name="subject" id="subject" class="input-common" style="width:100%;" value="<?php echo stripslashes($view_val['subject']);?>"/></td>
			</tr>
			<tr>
				<td bgcolor="#F4F4F4" style="font-weight:bold;">등록자</td>
				<td><?php echo $view_val['user_name'];?></td>
			</tr>
			<tr>
				<td colspan="2" style="padding:0;">
					<textarea name="content" id="content" style="display:none;"><?php echo $view_val['contents']; ?></textarea>
					<input type="hidden" name="contents" id="contents" value="">
					<?php include $this->input->server('DOCUMENT_ROOT')."/misc/daumeditor-7.4.9/editor.php"; ?>
				</td>
			</tr>
			<tbody id="fileTableTbody">
				<tr>
					<td id="dropZone">
						<label class="file_label" for="file_up">파일업로드</label>
						<input type="file" id="file_up" class="file-input" style="display:none;">
					</td>
				</tr>
				<?php
					 $file_html = "";
					 if($view_val['file_realname'] != ""){
							$file = explode('*/*',$view_val['file_realname']);
							for($i=0; $i<count($file); $i++){
								 $file_html .= "<tr id='dbfileTr_{$i}'>";
								 $file_html .= "<td colspan='2' class='left' >";
								 $file_html .= $file[$i]." <a href='#' onclick='dbDeleteFile({$i}); return false;' class='btn small bg_02'><img src='{$misc}/img/btn_del2.jpg' style='vertical-align:middle;'></a>";
								 $file_html .= "</td>";
								 $file_html .= "</tr>";
							}
					 }
					 echo $file_html;
				?>
			</tbody>
		</table>
		<div class="btn_div" style="margin-top:20px;text-align:right;">
			<input type="button" class="btn-common btn-color1" style="float:left;width:49%;border-radius:3px;height:40px;" value="취소" onClick="javascript:history.go(-1);">
			<input type="button" class="btn-common btn-color2" style="float:right;width:49%;border-radius:3px;height:40px;" value="수정" onClick="javascript:chkForm();return false;">
		</div>
	</div>
</div>
</form>
<div style="position:fixed;bottom:100px;right:5px;">
		<img src="<?php echo $misc; ?>img/mobile/btn_top.svg" onclick="$('html').scrollTop(0);">
</div>
<div id="wrap-loading" style="z-index: 10000;display:none;">
	<img src="<?php echo $misc; ?>img/loading_img.gif" alt="Loading..." style="width:50px;border:0; position:absolute; left:50%; top:50%;" />
</div>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
</body>
<script type="text/javascript">
var file_realname = "<?php echo $view_val['file_realname']; ?>".split("*/*");
var file_changename = "<?php echo $view_val['file_changename']; ?>".split("*/*");

var loc = $("#category_code option:selected").val();

var request_url = "<?php echo site_url(); ?>/biz/board/notice_input_action";
var response_url = "<?php echo site_url(); ?>/biz/board/notice_list?category="+loc;

function change_category(el) {
	loc = $(el).val();
	response_url = "<?php echo site_url(); ?>/biz/board/notice_list?category="+loc;
}

</script>
<script type="text/javascript">
// $('#summernote').summernote({ tabsize: 2, height: 300, fontsize: '16px', width: '100%' });
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

$("#file_up").change(function(e){
	var file = this.files;
	selectFile(file);

})
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
				// console.log(e);
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
		html += "    <td colspan='2' class='left' >";
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

//디비에 등록된 파일 삭제
function dbDeleteFile(fIndex){
$("#dbfileTr_" + fIndex).remove();
	// file_realname.splice(fIndex, 1);
	file_realname[fIndex] ='';
	file_changename[fIndex] ='';
}

var chkForm = function () {
	$("#wrap-loading").bPopup({modalClose:false,opacity:0});

	var mform = document.tx_editor_form;

	if (mform.subject.value == "") {
		mform.subject.focus();
 		alert("제목을 입력해 주세요.");
 		return false;
 	}


	$("#contents").val(Editor.getContent());

	var formData = new FormData(document.getElementById("tx_editor_form"));

  if ($("#type").val()==0){
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
		url: request_url,
		data: formData,
		type: 'POST',
		enctype: 'multipart/form-data',
		processData: false,
		contentType: false,
		dataType: 'json',
		cache: false,
		success: function (result){
			if(loc=="004"){
				if(result) {
					$("#cform").submit();
				} else {
					alert("저장에 실패하였습니다. 관리자에게 문의주세요.");
					$("#wrap-loading").bPopup().close();
				}
			}else{

				if(result) {
					alert('저장되었습니다.');
					location.href = response_url;
				} else {
					alert("저장에 실패하였습니다. 관리자에게 문의주세요.");
					$("#wrap-loading").bPopup().close();
				}

			}


		}

	});
 	return false;
}

</script>
</html>

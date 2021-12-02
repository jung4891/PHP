<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<link rel="stylesheet" href="/misc/css/bootstrap-datepicker.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/timepicker@1.13.18/jquery.timepicker.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" /> <!-- 조직도 생성 -->
<link rel="stylesheet" href="/misc/css/tech_schedule/proton/style.min.css" /> <!-- 조직도 생성 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script> <!-- 조직도 생성 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/js/select2.min.js"></script>
<script type="text/javascript" src="/misc/js/bootstrap-datepicker.js"></script>
<script src="https://cdn.jsdelivr.net/npm/timepicker@1.13.18/jquery.timepicker.min.js"></script>
<script type="text/javascript" src="/misc/js/jquery.bpopup-0.1.1.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.0/moment.min.js"></script>


<style>

	.autosize{
		width:95%;
		margin: 10px 10px 10px 0px;
		font-size: 14px;
		font-family:"Noto Sans KR", sans-serif !important;
	}

	.datepicker{
		z-index:11000 !important;
	}

	.thinput {
	  font-family:"Noto Sans KR", sans-serif !important;
	  border: 1px solid #DEDEDE !important;
	  border-radius: 20px !important;
	  opacity: 1 !important;
	  outline: none !important;
		font-size: 14px;
		width:100%;
		height:80%;
	}
	.select2-selection{
		width:97%;
		border-color: #B6B6B6;
	}

	.select2-search__field {
		font-family:"Noto Sans KR", sans-serif !important;
		border: 1px solid #DEDEDE !important;
		outline: none !important;
		width:80px!important;
	}

	.list_tbl th{
		border-bottom: solid #DFDFDF;
		background-color: #F4F4F4;
		font-size: 14px;
		border-width: thin;
	}
	textarea{
		border: 1px solid #B6B6B6;
	  background-color: white;
		font-size: 12px;
	}

</style>
<body>
<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
<div align="center">
<div class="dash1-1">
<table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
	<tr height="5%">
		<td class="dash_title">
			회의록
		</td>
	</tr>
	<tr valign="top">
		<td align="right">
			<button type="button" name="button" class="btn-common btn-color3" onclick="history.go(-1);">취소</button>
			<button type="button" name="button" class="btn-common btn-color3" onclick="doc_submit('save');">임시저장</button>
			<button type="button" name="button" class="btn-common btn-color2" onclick="doc_submit('add');">등록</button>
		</td>
	</tr>
	<tr>
		<td align="center" valign="top">
		<form name="cform" id="cform" method="post" enctype="multipart/form-data">
			<input type="hidden" id="type" name="type" value="1" />
			<input type="hidden" name="register" id="register" value="">
			<table width="100%" cellspacing="0" cellpadding="0" style="margin-top:50px;" class="list_tbl" >
				<colgroup>
					<col width="15%">
					<col width="35%">
					<col width="15%">
					<col width="35%">
				</colgroup>
				<thead>
					<tr>
						<th align="center">
							제&nbsp;&nbsp;&nbsp;목
						</th>
						<td colspan="3" align="center">
							<input type="text" class="input-common" style="width:98%" name="doc_title" id="doc_title" value="">
						</td>
					</tr>
					<tr>
						<th align="center">일&nbsp;&nbsp;&nbsp;시</th>
						<td align="center">
							<input type="text" class="input-common" name="start_day" id="start_day" value="" style="width:30%" maxlength="10" autocomplete="off" placeholder="날 짜"/>
							<input type="text" class="input-common" name="stime" id="stime" style="width:30%" maxlength="5" autocomplete="off" placeholder="시작시간"> ~
							<input type="text" class="input-common" name="etime" id="etime" style="width:30%" maxlength="5" autocomplete="off" placeholder="종료시간">
						</td>
						<th align="center">장&nbsp;&nbsp;&nbsp;소</th>
						<td align="center">
							<select class="select-common" name="place" id="place" style="width:97%;">
								<?php
								foreach ($place as $room) {
									echo "<option value='{$room->room_name}'>{$room->room_name}</option>";
								}
								 ?>
							</select>
						</td>
					</tr>
					<tr>
						<th align="center">부&nbsp;&nbsp;&nbsp;서</th>
						<td align="center">
							<select class="select-common" name="user_group" id="user_group" style="width:97%;">
								<option value="">선택없음</option>
								<option value="사업부장">사업부장</option>
								<!-- <option value="사업부서">사업부서</option>
								<option value="기술연구소">기술연구소</option>
								<option value="영업관리">영업관리</option>
								<option value="경영지원실">경영지원실</option> -->
								<?php
foreach ($user_group as $group) {
	echo "<option value='{$group->groupName}'>{$group->groupName}</option>";
}
								 ?>

							</select>
						</td>
						<th align="center">참여자</th>
						<td align="center">
							<select class="select-common" name="participant[]" id="participant" multiple="multiple" style="width:97%">
								<option value="">선택하세요</option>
								<?php
								foreach ($user as $us) {
									echo "<option value='{$us->user_id}'>{$us->user_name} {$us->user_duty}</option>";
								}
								 ?>

							</select>
						</td>
					</tr>
					<tr>
						<th colspan="4" align="center">
							내&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;용
							<span style="float:right"><img src="<?php echo $misc;?>img/btn_add.jpg" style="cursor:pointer;" onclick="plus_content('first');"/></span>
						</th>
					</tr>
				</thead>
				<tbody id="content_tbl">
				<tr class="content_tr">
				<td>
					<textarea name="subtitle[]" rows="3" class="autosize" value="" style="resize:none;text-align:left;" onkeydown="y_size(this);" onkeyup="y_size(this);"></textarea>
				</td>
				<td colspan="3">
					<textarea name="contents[]" rows="3" class="autosize" style="resize:none;" onkeydown="y_size(this);" onkeyup="y_size(this);"></textarea>
					<span style="float:right; padding-top:10px;">
						<img src="<?php echo $misc;?>img/btn_del0.jpg" style="cursor:pointer;" onclick="del_content(this);"/><br>
						<img src="<?php echo $misc;?>img/btn_add.jpg" style="cursor:pointer;" onclick="plus_content(this);"/>
						<input type="hidden" name="tr_num[]" value="">
					</span>
				</td>
				</tr>
			</tbody>
			</table>
			<div style="margin-top:10px;">
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
		</form>
		</td>
	</tr>
	<tr>
		<td height="60">
	</tr>

	<tr>
		<td height="60">
	</tr>
</table>
</div>
</div>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
<script>
// 날짜 달력만들기
$('#start_day').datepicker({
	format: "yyyy-mm-dd",
	clearBtn : false

})

//시간 시계 만들기
$('#stime').timepicker({
	timeFormat:'H:i',
	'minTime':'08:00',
	'maxTime':'22:00',
	'scrollDefaultNow': true
}).on('changeTime',function() {
        var from_time = $("input[name='stime']").val();
				// var end_min = moment(from_time).add("30", "m");
				// var end_min = moment(end_min).format('HH:mm');
				// console.log(end_min);
        $('#etime').timepicker('option','minTime', from_time);//etime의 mintime을 스타트타임보다 작게 안되게 하고
        if ($('#etime').val() && $('#etime').val() < from_time) {
            $('#etime').timepicker('setTime', from_time);
//etime을 먼저 선택한 경우  etime시간이 stime시간보다 작은경우 etime시간 변경
        }
    });

$('#etime').timepicker({
	timeFormat:'H:i',
	'minTime':'08:00',
	'maxTime':'22:00'
});


$('#participant').select2({
	width:'100%',
	placeholder: '검색어 입력'
});

// 내용 추가 삭제하는거
function plus_content(td){
	// var td=$(td).closest('tr');
	var contents = '';
  contents += '<tr class="content_tr"><td><textarea name="subtitle[]" rows="3" class="autosize" style="resize:none;text-align:left;" onkeydown="y_size(this);" onkeyup="y_size(this);" value=""></textarea></td>';
contents += '<td colspan="3"><textarea name="contents[]" rows="3" class="autosize" style="resize:none;" onkeydown="y_size(this);" onkeyup="y_size(this);"></textarea>';
contents += '<span style="float:right; padding-top:10px;"><img src="<?php echo $misc;?>img/btn_del0.jpg" style="cursor:pointer;" onclick="del_content(this);"/><br><img src="<?php echo $misc;?>img/btn_add.jpg" style="cursor:pointer;" onclick="plus_content(this);"/><input type="hidden" name="tr_num[]" value=""></span>';
contents += '	</td></tr>';
if(td == "first"){

// $('.head_tbl tbody:first-child').append(contents);
var rowcount = $("#content_tbl tr").length;
console.log(rowcount);
if(rowcount == 0){
	$("#content_tbl").append(contents);
}else{
	$("#content_tbl tr:first").before(contents);

}
// $('.head_tbl tbody:first-child').append(contents);

}else{
var td=$(td).closest('tr');
td.after(contents);
}
$("#sidebar_left").height($("#main_contents").height());
$(".sidebar_sub_on").height($("#main_contents").height());
}

function del_content(td){
	$(td).closest('tr').remove();
	$("#sidebar_left").height($("#main_contents").height());
 $(".sidebar_sub_on").height($("#main_contents").height());
}

// $("textarea.autosize").on('keydown keyup', function () {
//   $(this).height(1).height( $(this).prop('scrollHeight')+12 );
// 	$("#sidebar_left").height($("#main_contents").height());
//  $(".sidebar_sub_on").height($("#main_contents").height());
// });

// 텍스트 에이리어 스크롤바 안생기고 늘어나게 하기
function y_size(area){
	$(area).height(1).height( $(area).prop('scrollHeight')+12 );
	$("#sidebar_left").height($("#main_contents").height());
 $(".sidebar_sub_on").height($("#main_contents").height());
}

// 등록 저장할때 서브밋하는거
function doc_submit(mode){
	if(mode == "add"){
		$("#register").val("y");
		if($("#doc_title").val()==""){
			alert("제목을 입력해주세요");
			$("#doc_title").focus();
			return false;
		}

		if($("#start_day").val()==""){
			alert("날짜를 선택해주세요");
			$("#start_day").focus();
			return false;
		}
	}else{
		$("#register").val("n");
	}

	$("#content_tbl tr").each(function(){
		var tr_index = $(this).index();
		$(this).find("input:last").val(tr_index);
	})
// var act = "<?php echo site_url();?>/biz/meeting_minutes/mom_input_action";

var formData = new FormData(document.getElementById("cform"));

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

$.ajax({
	url: "<?php echo site_url();?>/biz/meeting_minutes/mom_input_action",
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
			location.href = "<?php echo site_url(); ?>/biz/meeting_minutes/mom_list?type=y";
		} else {
			alert("저장에 실패하였습니다. 관리자에게 문의주세요.");
		}


	}

});
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

</script>
</body>
</html>

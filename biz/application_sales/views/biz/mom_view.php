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
		font-size: 12px;
		font-family:"Noto Sans KR", sans-serif !important;
	}

	.datepicker{
		z-index:11000 !important;
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

	.list_tbl {
		border: 1px solid #DEDEDE;
		border-bottom:none;
	}

	.list_tbl th{
		height: 40px !important;
		background-color: #F4F4F4;
		font-size: 14px;
		border-bottom: solid #DFDFDF;
		border-width: thin;
	}

	.list_tbl td{
		font-size: 12px;
		height: 40px;
		padding:2px 10px 2px 10px;
	}

	textarea{
		border: 1px solid #B6B6B6;
	  background-color: white;
	}

	#dropZone {
		height:100px !important;
	}

</style>
<body>
<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
<div align="center">
<div class="dash1-1">
<table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1" style="border-spacing:0px 0px 40px 0px;">
	<tr height="5%">
		<td class="dash_title">
			회의록
		</td>
	</tr>
	<?php if((strpos($title_val['participant'], $this->id) !== false) || ($title_val['writer_id'] == $this->id)) { ?>
		<tr valign="top">
	<?php if($mode == 'view'){  ?>
		<td align="right">
			<button type="button" name="button" class="btn-common btn-updownload" onclick="fnExcelReport();" style="width:auto;padding-left: 2px;">엑셀 다운로드
				<img src="/misc/img/download_btn.svg"  style="float:left; width:12px; padding:5px;">
			</button>
			<button type="button" name="button" class="btn-common btn-color3" onclick="history.go(-1);">목록</button>
			<button type="button" name="button" class="btn-common btn-color4" onclick="ViewBoard();">수정</button>
			<button type="button" name="button" class="btn-common btn-color4" onclick="mom_delete();">삭제</button>
		</td>
	<?php }else{ ?>
	  	<td align="right">
				<button type="button" name="button" class="btn-common btn-color4" onclick="history.go(-1);">취소</button>
				<button type="button" name="button" class="btn-common btn-color3" onclick="doc_submit('save');">임시저장</button>
				<button type="button" name="button" class="btn-common btn-color2" onclick="doc_submit('add');">등록</button>
			</td>
	<?php } ?>
		</tr>

	<?php }else{ ?>
		<tr valign="top">
			<td align="right">
<button type="button" name="button" class="btn-common btn-color3" onclick="history.go(-1);">목록</button>
		</td>
	</tr>
	<?php } ?>

	<tr style="padding-bottom:30px;">
		<td align="center" valign="top">
		<form name="cform" id="cform" method="post" enctype="multipart/form-data">
			<input type="hidden" id="type" name="type" value="0" />
			<input type="hidden" name="seq" value="<?php echo $title_val['seq']; ?>">
			<input type="hidden" name="mode" value="<?php echo $mode; ?>">
			<input type="hidden" name="register" id="register" value="">
			<table width="100%" cellspacing="0" cellpadding="0" style="margin-top:50px;" class="list_tbl"  id="excel_tbl">
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
						<td colspan="3" id="mom_title">
              <?php
    if($mode == 'view'){
      echo $title_val['title'];
    }else{  ?>
      <input type="text" class="input-common" style="width:98%" name="doc_title" id="doc_title" value="<?php echo $title_val['title']; ?>">

    <?php } ?>


	</td>
					</tr>
					<tr>
						<th align="center">일&nbsp;&nbsp;&nbsp;시</th>
						<td>
        <?php if($mode == 'view'){
						if($title_val['start_time']=="" || $title_val['end_time'] == ""){
							$tilde = "";
						}else{
							$tilde = " ~ ";
						}
            echo $title_val['day']." ".substr($title_val['start_time'],0,-3).$tilde.substr($title_val['end_time'],0,-3);
          }else{ ?>
							<input type="text" class="input-common" name="start_day" id="start_day" value="<?php echo $title_val['day']; ?>" style="width:30%" maxlength="10" autocomplete="off" placeholder="날 짜"/>
							<input type="text" class="input-common" name="stime" id="stime" style="width:30%" maxlength="5" autocomplete="off" value="<?php echo substr($title_val['start_time'],0,-3); ?>" placeholder="시작시간"> ~
							<input type="text" class="input-common" name="etime" id="etime" style="width:30%" maxlength="5" autocomplete="off" value="<?php echo substr($title_val['end_time'],0,-3); ?>" placeholder="종료시간">
            <?php } ?>
					</td>
						<th align="center">장&nbsp;&nbsp;&nbsp;소</th>
						<td>
              <?php if($mode == 'view'){
                 echo $title_val['place'];
               }else{?>
                 <select class="select-common" style="width:97%;" name="place" id="place">
   								<?php
                  $selected_room = $title_val['place'];

   								foreach ($base['place'] as $room) {
                    $selected = $selected_room == $room->room_name ? " selected" : "";
   									echo "<option value='{$room->room_name}'{$selected}>{$room->room_name}</option>";
   								}
   								 ?>
   							</select>
               <?php } ?>
						</td>
					</tr>
					<tr>
						<th align="center">부&nbsp;&nbsp;&nbsp;서</th>
						<td>
              <?php if($mode == 'view'){
                 echo $title_val['user_group'];
               }else{?>
                 <select class="select-common" name="user_group" id="user_group" style="width:97%;">
   								<option value="">선택없음</option>
									<option value="사업부장" <?php if($title_val['user_group']=='사업부장'){echo 'selected';} ?>>사업부장</option>
                  <?php
                  $selected_group = $title_val['user_group'];

                  foreach ($base['user_group'] as $group) {
                    $selected = $selected_group == $group->groupName ? " selected" : "";
                    echo "<option value='{$group->groupName}'{$selected}>{$group->groupName}</option>";
                  }
                   ?>
                </select>

               <?php } ?>
						</td>
						<th align="center">참여자</th>
						<td>
              <?php if($mode == 'view'){
                 if(isset($participant_name)){echo $participant_name;}
               }else{?>
                 <select class="select-common" name="participant[]" id="participant" multiple="multiple">
   								<option value="">선택하세요</option>
                  <?php
                  $selected_user = $title_val['participant'];
                  $selected_userarr = explode(",",$selected_user);
  								foreach ($base['user'] as $us) {
                    $selected = (in_array($us->user_id, $selected_userarr)) ? " selected" : "";
  									echo "<option value='{$us->user_id}'{$selected}>{$us->user_name} {$us->user_duty}</option>";
  								}
  								 ?>

               <?php } ?>

						</td>
					</tr>
					<tr>
						<th colspan="4" align="center">
							내&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;용
							<?php if($mode == 'modify'){ ?>
											<span style="float:right"><img src="<?php echo $misc;?>img/btn_add.jpg" style="cursor:pointer;padding-right:10px;" onclick="plus_content('first');"/></span>
											<!-- <img src="<?php echo $misc;?>img/btn_add.jpg" style="cursor:pointer;" onclick="plus_content(this);"/> -->
							<?php } ?>
						</th>
					</tr>
					<!-- <tr>
						<td colspan="4">

							<span style="float:right"><img src="<?php echo $misc;?>img/btn_add.jpg" style="cursor:pointer;" onclick="plus_content();"/></span>
						</td>
					</tr> -->
				</thead>
				<tbody id="content_tbl">
<?php if($mode == 'view'){
 foreach ($contents_val as $contents) { ?>
  <tr class="content_tr">
    <td align="left" style="border-right:solid 1px #DFDFDF;">
<?php
// $sub_title = str_replace("\r\n","<br />",$contents->sub_title);
echo nl2br($contents->sub_title);

?>
    </td>
    <td colspan="3">
<?php
// $contents = str_replace("\r\n","<br />",$contents->contents);
echo nl2br($contents->contents);
?>
    </td>
  </tr>
<?php }
}else{
  foreach ($contents_val as $contents) {
// $br_sub_title = str_replace("<br />","\r\n",$contents->sub_title);
// $br_contents = str_replace("<br />","\r\n",$contents->contents);
$br_sub_title = nl2br($contents->sub_title);
$br_contents =	nl2br($contents->contents);
$br_count = substr_count($br_contents, "<br />");
$sb_count = substr_count($br_sub_title, "<br />");
$br_count = $sb_count > $br_count ? $sb_count : $br_count;
    ?>

    <tr class="content_tr">
    <td>
      <textarea name="subtitle[]" rows="<?php echo $br_count + 2 ?>" class="autosize" value="" style="resize:none;text-align:left;" onkeydown="y_size(this);" onkeyup="y_size(this);"><?php echo $contents->sub_title; ?></textarea>
    </td>
    <td colspan="3">
        <textarea name="contents[]" rows="<?php echo $br_count + 2 ?>" class="autosize" style="resize:none;" onkeydown="y_size(this);" onkeyup="y_size(this);"><?php echo $contents->contents; ?></textarea>
      <span style="float:right; padding-top:10px;">
        <img src="<?php echo $misc;?>img/btn_del0.jpg" style="cursor:pointer;" onclick="del_content(this);" class="del_row_btn" value="<?php echo $contents->seq;?>"/><br>
        <img src="<?php echo $misc;?>img/btn_add.jpg" style="cursor:pointer;" onclick="plus_content(this);"/>
				<input type="hidden" name="contents_seq[]" value="<?php echo $contents->seq;?>">
				<input type="hidden" name="tr_num[]" value="">
      </span>
    </td>
    </tr>
<?php }
} ?>
<?php if($mode == 'view'){ ?>
		<tr class="no_excel">
			<td class="tbl-title">첨부파일</td>
			<td colspan="3">
				<?php
					 if($title_val['file_realname'] != ""){
							$file = explode('*/*',$title_val['file_realname']);
							$file_url = explode('*/*',$title_val['file_changename']);
							for($i=0; $i<count($file); $i++){
								 echo $file[$i];
								 echo "<a href='{$misc}upload/biz/mom/{$file_url[$i]}' download='{$file[$i]}'> <img src='{$misc}img/download.svg' style='width:15px;vertical-align:middle;cursor:pointer;margin:5px 0px 5px 10px;'></a><br>";
							}
					 }
				?>
			</td>
		</tr>
<?php } else { ?>
		<tr>
			<td colspan="4">
				<div style="margin-top:30px;">
					 <img src="<?php echo $misc; ?>/img/file_upload.png" style="width:20px;float:left;vertical-align:middle;"><h3 style="float:left;margin:0px;">&nbsp;파일업로드</h3><br>
					 <!-- <form name="uploadForm" id="uploadForm" enctype="multipart/form-data" method="post" > -->
							<?php
								 $file_html = "";
								 if($title_val['file_realname'] != ""){
										$file = explode('*/*',$title_val['file_realname']);
										for($i=0; $i<count($file); $i++){
											 $file_html .= "<tr id='dbfileTr_{$i}'>";
											 $file_html .= "<td class='left' style='height:40px;padding:0'>";
											 $file_html .= $file[$i]." <a href='#' onclick='dbDeleteFile({$i}); return false;' class='btn small bg_02'><img src='{$misc}/img/btn_del2.jpg' style='vertical-align:middle;'></a>";
											 $file_html .= "</td>";
											 $file_html .= "</tr>";
										}
								 }
							?>
							<table class="basic_table" width="100%" class="row-color1" height="auto" style="margin-top:20px;" >
										<tbody id="fileTableTbody">
											 <tr>
													<td id="dropZone" class="row-color1" height="100px">
																이곳에 파일을 드래그 하세요.
													</td>
											 </tr>
										</tbody>
										<?php echo $file_html; ?>
							</table>
					 <!-- </form> -->
					 <!-- <a href="#" onclick="uploadFile(); return false;" class="btn bg_01">파일 업로드</a> -->
				</div>
			</td>
		</tr>
<?php } ?>
			</tbody>
			</table>
      <input type="hidden" id="del_row_seq" name="del_row_seq" value="">
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

var file_realname = "<?php echo $title_val['file_realname']; ?>".split("*/*");
var file_changename = "<?php echo $title_val['file_changename']; ?>".split("*/*");

function ViewBoard (){
	document.cform.action = "<?php echo site_url();?>/biz/meeting_minutes/mom_view";
	// document.hiddenform.seq.value = seq;
	document.cform.mode.value = "modify";
	document.cform.submit();

}

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

	var contents = '';
  contents += '<tr class="content_tr"><td><textarea name="new_subtitle[]" rows="3" class="autosize" style="resize:none;text-align:left;" onkeydown="y_size(this);" onkeyup="y_size(this);" value=""></textarea></td>';
	contents += '<td colspan="3"><textarea name="new_contents[]" rows="3" class="autosize" style="resize:none;" onkeydown="y_size(this);" onkeyup="y_size(this);"></textarea>';
	contents += '<span style="float:right; padding-top:10px;"><img src="<?php echo $misc;?>img/btn_del0.jpg" style="cursor:pointer;" onclick="del_content(this);" value=""/><br><img src="<?php echo $misc;?>img/btn_add.jpg" style="cursor:pointer;" onclick="plus_content(this);"/><input type="hidden" name="new_tr_num[]" value=""></span>';
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

	var del_seq = $('#del_row_seq').val();
  var content_seq = $(td).attr('value');
  if(content_seq != ""){
    $('#del_row_seq').val(del_seq +content_seq+',');
  }
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


function mom_delete(){
	var del_yn = confirm('삭제 하시겠습니까?');
	if(del_yn) {
		var act = "<?php echo site_url();?>/biz/meeting_minutes/mom_del_action";
		$("#cform").attr('action', act);
		$("#cform").submit();
	}

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
	html += "    <td class='left' style='height:40px;padding:0;'>";
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

// 엑셀 파일 저장
function fnExcelReport() {

  // var today = getToday();
  $("#accountlist tr[class=bankTypeHidden]").remove();

  var title = $.trim($('#mom_title').text());

  var tab_text = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
  tab_text = tab_text + '<head><meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">';
  tab_text = tab_text + '<xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>'
  tab_text = tab_text + '<x:Name>Test Sheet</x:Name>';
  tab_text = tab_text + '<x:WorksheetOptions><x:Panes></x:Panes></x:WorksheetOptions></x:ExcelWorksheet>';
  tab_text = tab_text + '</x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body>';
  tab_text = tab_text + "<table border='1px'>";
  var exportTable = $('#excel_tbl').clone();
	exportTable.find('.no_excel').each(function(index, elem) {
    $(elem).remove();
  });

  tab_text = tab_text + exportTable.html();
  tab_text = tab_text + '</table></body></html>';
  var data_type = 'data:application/vnd.ms-excel';
  var ua = window.navigator.userAgent;
  var msie = ua.indexOf("MSIE ");
  var fileName = title + '.xls';
  //Explorer 환경에서 다운로드
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
</body>
</html>

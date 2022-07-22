<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<style media="screen">
  .input-common, .textarea-common {
    box-sizing: border-box;
    width:100%;
  }
  .tbl-cell {
    padding-right: 10px;
  }
</style>
<body>
  <?php
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
<div align="center">
	<div class="dash1-1">
    <form id="cform" name="cform" action="<?php echo site_url();?>/tech/board/dailyWorkLog_input_action" method="post" enctype="multipart/form-data" onSubmit="javascript:chkForm();return false;">
		<table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
				<input type="hidden" id="seq" name="seq" value="<?php echo $seq; ?>" />
				<input type="hidden" id="type" name="type" value="0" />
				<tr height="5%">
					<td class="dash_title">
						일일업무일지
					</td>
				</tr>
				<tr>
					<td height="40"></td>
				</tr>
    		<tr>
      		<td width="100%" align="center" valign="top">
						<table class="list_tbl" width="100%" border="0" cellspacing="0" cellpadding="0" style="table-layout:fixed; word-break:break-all;border: thin solid #DFDFDF;margin-bottom:20px;margin-top:20px;">
							<colgroup>
								<col width="15%">
								<col width="35%">
								<col width="15%">
								<col width="35%">
							</colgroup>
        			<tr>
          			<td class="tbl-title">일자</td>
          			<td class="tbl-cell">
                  <input type="date" style="width:140px;" name="log_date" class="input-common" value="<?php echo $view_val['log_date']; ?>">
                </td>
                <td class="tbl-title">등록자</td>
                <td class="tbl-mid"><?php echo $view_val['user_name'];?></td>
              </tr>
            </table>
            <p style="border:none;font-size:14px;font-weight:bold;text-align:left;">■ 금일 업무</p>
            <table class="list_tbl" width="100%" border="0" cellspacing="0" cellpadding="0" style="table-layout:fixed; word-break:break-all;border: thin solid #DFDFDF;margin-bottom:20px;margin-top:20px;">
              <colgroup>
                <col width="20%">
                <col width="20%">
                <col width="57%">
                <col width="4%">
              </colgroup>
              <tr>
                <td class="tbl-title">주제</td>
                <td class="tbl-title">시간</td>
                <td class="tbl-title">내용</td>
                <td class="tbl-title"></td>
              </tr>
        <?php $i = 0;
              foreach($content_val_t as $ct) { ?>
                <tr class="t_contents">
                  <td class="tbl-cell">
                    <input type="text" class="input-common require" name="t_title[]" value="<?php echo $ct['title']; ?>">
                  </td>
                  <td class="tbl-cell border-l" align="center">
                    <input type="time" class="input-common require" name="t_stime[]" style="width:45%;float:left;" value="<?php echo substr($ct['start_time'], 0, 5); ?>">
                    <span style="width:5%;text-align:center;">~</span>
                    <input type="time" class="input-common require" name="t_etime[]" style="width:45%;float:right;" value="<?php echo substr($ct['end_time'], 0, 5); ?>">
                  </td>
                  <td class="tbl-cell border-l" style="padding-top:5px;padding-bottom:5px;">
                    <textarea class="textarea-common require" name="t_content[]"><?php echo nl2br($ct['content']); ?></textarea>
                  </td>
                  <td class="tbl-cell border-l">
            <?php if($i == 0) { ?>
                    <img src="/misc/img/btn_add.jpg" onclick="content_add(this, 't_');" style="cursor:pointer;" />
            <?php } else { ?>
                    <img src="/misc/img/btn_del0.jpg" style="cursor:pointer;" onclick="content_del(this);"/>
            <?php } ?>
                  </td>
                </tr>
        <?php $i++;
              } ?>
            </table>
            <p style="border:none;font-size:14px;font-weight:bold;text-align:left;">■ 예정 업무</p>
            <table class="list_tbl" width="100%" border="0" cellspacing="0" cellpadding="0" style="table-layout:fixed; word-break:break-all;border: thin solid #DFDFDF;margin-bottom:20px;margin-top:20px;">
              <colgroup>
                <col width="20%">
                <col width="20%">
                <col width="57%">
                <col width="4%">
              </colgroup>
              <tr>
                <td class="tbl-title">주제</td>
                <td class="tbl-title">시간</td>
                <td class="tbl-title">내용</td>
                <td class="tbl-title"></td>
              </tr>
      <?php $i = 0;
            foreach($content_val_n as $cn) { ?>
              <tr class="n_contents">
                <td class="tbl-cell">
                  <input type="text" class="input-common require" name="n_title[]" value="<?php echo $cn['title']; ?>">
                </td>
                <td class="tbl-cell border-l" align="center">
                  <input type="time" class="input-common require" name="n_stime[]" style="width:45%;float:left;" value="<?php echo substr($cn['start_time'], 0, 5); ?>">
                  <span style="width:5%;text-align:center;">~</span>
                  <input type="time" class="input-common require" name="n_etime[]" style="width:45%;float:right;" value="<?php echo substr($cn['end_time'], 0, 5); ?>">
                </td>
                <td class="tbl-cell border-l" style="padding-top:5px;padding-bottom:5px;">
                  <textarea class="textarea-common require" name="n_content[]"><?php echo nl2br($cn['content']); ?></textarea>
                </td>
                <td class="tbl-cell border-l">
          <?php if($i == 0) { ?>
                  <img src="/misc/img/btn_add.jpg" onclick="content_add(this, 'n_');" style="cursor:pointer;" />
          <?php } else { ?>
                  <img src="/misc/img/btn_del0.jpg" style="cursor:pointer;" onclick="content_del(this);"/>
          <?php } ?>
                </td>
              </tr>
      <?php   $i++;
            } ?>
            </table>
            <p style="border:none;font-size:14px;font-weight:bold;text-align:left;">■ 건의 및 기타 사항</p>
            <table class="list_tbl" width="100%" border="0" cellspacing="0" cellpadding="0" style="table-layout:fixed; word-break:break-all;border: thin solid #DFDFDF;margin-bottom:20px;margin-top:20px;">
              <tr>
                <td class="tbl-cell border-l" style="padding-top:5px;padding-bottom:5px;">
                  <textarea name="etc" class="textarea-common"><?php echo nl2br($view_val['etc']); ?></textarea>
                </td>
              </tr>
            </table>
						<div style="display:none;">
							<img src="<?php echo $misc; ?>/img/file_upload.png" style="width:20px;float:left;vertical-align:middle;"><h3 style="float:left;margin:0px;">&nbsp;파일업로드</h3><br>
						</div>
						<table width="100%" border="0" cellspacing="0" cellpadding="0" style="table-layout:fixed; word-break:break-all;border: thin solid #DFDFDF;margin-bottom:50px;margin-top:20px;display:none;">
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
						<input type="button" class="btn-common btn-color2" value="수정" onClick="javascript:chkForm();return false;">
					</td>
				</tr>
		</table>
  </form>
	</div>
</div>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
</body>
<script type="text/javascript">
var file_realname = "<?php echo $view_val['file_realname']; ?>".split("*/*");
var file_changename = "<?php echo $view_val['file_changename']; ?>".split("*/*");

var request_url = "<?php echo site_url(); ?>/tech/board/dailyWorkLog_input_action";
var response_url = "<?php echo site_url(); ?>/tech/board/dailyWorkLog_list";

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

function dbDeleteFile(fIndex){
$("#dbfileTr_" + fIndex).remove();
	// file_realname.splice(fIndex, 1);
	file_realname[fIndex] ='';
	file_changename[fIndex] ='';
}


var chkForm = function () {
  var rv = true;
	var mform = document.cform;

	if (mform.log_date.value == "") {
		mform.log_date.focus();
		alert("보고서 일자를 입력해 주세요.");
		return rv = false;
	}

  $('.require').each(function() {
    val = $(this).val();

    if($.trim(val) == '') {
      alert('비어있는 항목이 있습니다.');
      $(this).focus();
      return rv = false;
    }
  })

  if(rv) {
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
      url: request_url,
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
          location.href = response_url;
        } else {
          alert("저장에 실패하였습니다. 관리자에게 문의주세요.");
        }
      }
    });
    return false;
  }
}

function content_add(el, type) {
  var tr_class = $(el).closest('tr').attr('class');
  var target = $("." + tr_class).last();

  var txt = '<tr class="'+type+'contents"><td class="tbl-cell"><input type="text" class="input-common require" name="'+type+'title[]" value=""></td><td class="tbl-cell border-l" align="center"><input type="time" class="input-common require" name="'+type+'stime[]" style="width:45%;float:left;"><span style="width:5%;text-align:center;">~</span><input type="time" class="input-common require" name="'+type+'etime[]" style="width:45%;float:right;"></td><td class="tbl-cell border-l" style="padding-top:5px;padding-bottom:5px;"><textarea class="textarea-common require" name="'+type+'content[]"></textarea></td><td class="tbl-cell border-l"><img src="/misc/img/btn_del0.jpg" style="cursor:pointer;" onclick="content_del(this);"/></td></tr>';

  target.after(txt);
}

function content_del(el) {
  var tr = $(el).closest("tr");

  tr.remove();
}
</script>
</html>

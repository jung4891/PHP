<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<link rel="stylesheet" href="/misc/css/dashboard.css">
<link rel="stylesheet" href="/misc/css/new_dash.css">
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
<style>
.contents_tbl th{
		border-color:#c0c0c0;
		text-align:center;
		border-style:solid;
		border-width:1px;
		font-size: 14px;
		font-weight:bold;
		height:40px;
		background-color: #efefef;
}

.contents_tbl td{
		border-color:#c0c0c0;
		text-align:center;
		border-style:solid;
		border-width:1px;
		font-size: 14px;
		font-weight:bold;
		height:40px;
}
.contents_tbl td input, textarea, select{
	width: 90%
}
</style>
<body>
<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
	<div class="contents_container" align="center">
    <!-- 타이틀 -->
    <div class="contents_item" style="margin-top:30px;">
      <h1 style="float:left">개발공지사항</h1>
    </div>


    <!-- 엑셀모드 -->
    <div class="contents_item" style="display:flex;justify-content: space-between;align-items: flex-end;">
			<table class="contents_tbl" width="100%" cellspacing="0" cellpadding="0">
				<colgroup>
					<col width="20%">
					<col width="30%">
					<col width="20%">
					<col width="30%">
				</colgroup>
			<thead>
			  <tr>
			    <th>날짜</th>
			    <td><?php echo $view_val['update_date'];?></td>
			    <th>등록자</th>
			    <td><?php echo $view_val['user_name'];?></td>
			  </tr>
			</thead>
			<tbody>
			  <tr>
			    <th>제목</th>
			    <td colspan="3">
						<input type="text" name="subject_view" id="subject_view" value="<?php echo stripslashes($view_val['subject']);?>" style="width:90%;">
			    </td>
			  </tr>
			</tbody>
			</table>
    </div>
<form name="cform" id="cform" action="<?php echo site_url();?>/biz/board/lab_modify_action" method="post" enctype="multipart/form-data">
  <input type="hidden" name="notice_seq" value="<?php echo $seq;?>">
		<div class="contents_item" width="100%">
			<table class="contents_tbl" width="100%" cellspacing="0" cellpadding="0">
				<colgroup>
					<col width="6%">
					<col width="6%">
					<col width="6%">
					<col width="6%">
					<col width="14%">
					<col width="23%">
					<col width="23%">
					<col width="6%">
					<col width="10%">
				</colgroup>
			<thead>
			  <tr>
			    <th>구분</th>
			    <th>페이지</th>
			    <th>접수일자</th>
			    <th>접수자</th>
			    <th>개발사항</th>
			    <th>요청사항</th>
			    <th>개선방안</th>
			    <th>완료일자</th>
			    <th>진행결과
						<span>
							<button type="button" name="button" onclick="plus_content('first');">+</button>
						</span>
			  </tr>
			</thead>
			<tbody id="contents_tbl">
<?php
if(!empty($lab_val)){
foreach ($lab_val as $lab) {


  $br_develope =	nl2br($lab['develope']);
  $br_count1 = substr_count($br_develope, "<br />");
  $br_request =	nl2br($lab['request']);
  $br_count2 = substr_count($br_request, "<br />");
  $br_dev_plan =	nl2br($lab['dev_plan']);
  $br_count3 = substr_count($br_dev_plan, "<br />");
  // $max_row = max($br_count1,$br_count2,$br_count3);
   ?>
			  <tr>
			    <td>

						<select class="" name="dev_type[]" id="dev_type">
							<option value="new" <?php if($lab['dev_type'] == 'new'){ echo 'selected'; } ?>>신규개발</option>
							<option value="imp" <?php if($lab['dev_type'] == 'imp'){ echo 'selected'; } ?>>기능개선</option>
							<option value="bug" <?php if($lab['dev_type'] == 'bug'){ echo 'selected'; } ?>>버그수정</option>
						</select>
			    </td>
			    <td>
						<input type="text" name="page[]" id="page" value="<?php echo $lab['page'] ?>">
			    </td>
			    <td>
		<input type="date" name="r_date[]" id="r_date" value="<?php echo $lab['receive_date'] ?>">
			    </td>
			    <td>
		<input type="text" name="receiver[]" id="receiver" value="<?php echo $lab['receiver'] ?>">
			    </td>
			    <td>
		<textarea name="develope[]" style="resize:none;" rows="<?php echo $br_count1+2; ?>" onkeydown="y_size(this);" onkeyup="y_size(this);"><?php echo $lab['develope'] ?></textarea>
			    </td>
			    <td>
		<textarea name="request[]" style="resize:none;" rows="<?php echo $br_count2+2; ?>" onkeydown="y_size(this);" onkeyup="y_size(this);"><?php echo $lab['request'] ?></textarea>
			    </td>
			    <td>
		<textarea name="plan[]"  style="resize:none;" rows="<?php echo $br_count3+2; ?>" onkeydown="y_size(this);" onkeyup="y_size(this);"><?php echo $lab['dev_plan'] ?></textarea>
			    </td>
			    <td>
		<input type="date" name="c_date[]" value="<?php echo $lab['complete_date'] ?>">
			    </td>
			    <td>
		<select class="" name="complete[]" id="complete" style="width:50%">
			<option value="N" <?php if($lab['complete_yn'] == 'N'){ echo 'selected'; } ?>>미완료</option>
			<option value="Y" <?php if($lab['complete_yn'] == 'Y'){ echo 'selected'; } ?>>완료</option>
		</select>
    <input type="hidden" name="contents_seq[]" value="<?php echo $lab['seq'] ?>">
		<input type="hidden" name="tr_num[]" id="tr_num" value="">
		<button type="button" name="button" onclick="plus_content(this)">+</button>
		<button type="button" name="button" value="<?php echo $lab['seq'] ?>" onclick="del_content(this)">-</button>
			    </td>
			  </tr>
<?php }
}
 ?>
			</tbody>
			</table>
      <input type="text" name="del_row_seq" id="del_row_seq" value="">
		</div>
</form>
    <div align="left" class="contents_item" style="margin-top:unset;">
      <h3>기타</h3>
    </div>
  <form name="tx_editor_form" id="tx_editor_form" action="<?php echo site_url();?>/biz/board/notice_input_action" method="post" enctype="multipart/form-data" onSubmit="javascript:chkForm();return false;">
    <input type="hidden" name="seq" value="<?php echo $seq;?>">
		<input type="hidden" id="type" name="type" value="0" />
		<select name="category_code" id="category_code" style="display:none;">
			<option value="004" selected>개발공지</option>
		</select>
		<input type="hidden" name="subject" id="subject" value="">
    <div class="contents_item" id="editor_div" style="margin-top:unset;">
        <textarea name="content" id="content" style="display:none;"><?php echo $view_val['contents']; ?></textarea>
        <input type="hidden" name="contents" id="contents" value="">
        <?php include $this->input->server('DOCUMENT_ROOT')."/misc/daumeditor-7.4.9/editor.php"; ?>

        <div>
          <img src="<?php echo $misc; ?>/img/file_upload.png" style="width:20px;float:left;vertical-align:middle;"><h3 style="float:left;margin:0px;">&nbsp;파일업로드</h3><br>
          <?php
             $file_html = "";
             if($view_val['file_realname'] != ""){
                $file = explode('*/*',$view_val['file_realname']);
                for($i=0; $i<count($file); $i++){
                   $file_html .= "<tr id='dbfileTr_{$i}'>";
                   $file_html .= "<td class='left' >";
                   $file_html .= $file[$i]." <a href='#' onclick='dbDeleteFile({$i}); return false;' class='btn small bg_02'><img src='{$misc}/img/btn_del2.jpg' style='vertical-align:middle;'></a>";
                   $file_html .= "</td>";
                   $file_html .= "</tr>";
                }
             }
          ?>
          <table class="basic_table" width="100%" bgcolor="f8f8f9" height="auto" border="1px" style="margin-top:20px;" >
            <tbody id="fileTableTbody">
              <tr>
                <td id="dropZone" height="100px">
                   이곳에 파일을 드래그 하세요.
               </td>
             </tr>
            </tbody>
          </table>
          <?php echo $file_html; ?>
        </div>
    </div>
</form>
	<div class="contents_item" style="margin-bottom:5vh;" align="center">
			<!-- <input type="image" src="<?php echo $misc;?>img/dashboard/btn/btn_add.png" width="70" height="35" style="cursor:pointer" onClick="javascript:chkForm();return false;"/>
		 -->
		 			<input type="image" src="<?php echo $misc;?>img/dashboard/btn/btn_adjust.png" width="70" height="35" style="cursor:pointer" onClick="notice_insert();"/>
			<img src="<?php echo $misc;?>img/dashboard/btn/btn_cancel.png" width="70" height="35" style="cursor:pointer" onClick="javascript:history.go(-1)"/>
	</div>

  </div>

<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
</body>
<script type="text/javascript" src="/misc/js/board/board_script_daum.js"></script>
<script type="text/javascript">
function filedel(seq, filename) {
	if (confirm("정말 삭제하시겠습니까?") == true){
		location.href = "<?php echo site_url();?>/biz/board/notice_filedel/" + seq + "/" + filename;
		return false;
	}
}


// 내용 추가 삭제하는거
function plus_content(td){

	var contents = '';
	contents += '<tr><td><select name="new_dev_type[]" id="dev_type"><option value="new">신규개발</option><option value="imp">기능개선</option><option value="bug">버그수정</option></select></td>';
	contents += '<td><input type="text" name="new_page[]" value=""></td>';
	contents += '<td><input type="date" name="new_r_date[]" value=""></td>';
	contents += '<td><input type="text" name="new_receiver[]" value=""></td>';
	contents += '<td><textarea name="new_develope[]" style="resize:none;" onkeydown="y_size(this);" onkeyup="y_size(this);"></textarea></td>';
	contents += '<td><textarea name="new_request[]" style="resize:none;" onkeydown="y_size(this);" onkeyup="y_size(this);"></textarea></td>';
	contents += '<td><textarea name="new_plan[]" style="resize:none;" onkeydown="y_size(this);" onkeyup="y_size(this);"></textarea></td>';
	contents += '<td><input type="date" name="new_c_date[]" value=""></td>';
	contents += '<td><select class="" name="new_complete[]" style="width:50%">';
	contents += '<option value="N">미완료</option><option value="Y">완료</option></select>';
	contents += '<input type="hidden" name="new_tr_num[]" value="">';
	contents += '<button type="button" name="button" onclick="plus_content(this)">+</button><button type="button" name="button" onclick="del_content(this)">-</button>';
	contents += '</td></tr>';

	if(td == "first"){
		var rowcount = $("#contents_tbl tr").length;
		// console.log(rowcount);
		if(rowcount == 0){
			$("#contents_tbl").append(contents);
		}else{
			$("#contents_tbl tr:first").before(contents);
		}
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

function side_resize(){
	$("#sidebar_left").height($("#main_contents").height());
	$(".sidebar_sub_on").height($("#main_contents").height());

}

// 텍스트 에이리어 스크롤바 안생기고 늘어나게 하기
function y_size(area){
	$(area).height(1).height( $(area).prop('scrollHeight')+12 );
	side_resize();
}

var file_realname = "<?php echo $view_val['file_realname']; ?>".split("*/*");
var file_changename = "<?php echo $view_val['file_changename']; ?>".split("*/*");

var loc = $("#category_code option:selected").val();
var request_url = "<?php echo site_url(); ?>/biz/board/notice_input_action";
var response_url = "<?php echo site_url(); ?>/biz/board/notice_list?category="+loc;


function notice_insert(){
	$("#contents_tbl tr").each(function(){
		var tr_index = $(this).index();
		$(this).find("input:last").val(tr_index);
	})

	var subject_val = $("#subject_view").val();
	$("#subject").val(subject_val);

chkForm();
return false;

}


</script>
</html>

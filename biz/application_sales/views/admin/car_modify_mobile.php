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
</style>
<script language="javascript">

function chkForm () {
	var mform = document.cform;

	if (mform.type.value == "") {
		mform.type.focus();
		alert("차종을 입력해 주세요.");
		return false;
	}
	if (mform.number.value == "") {
		mform.number.focus();
		alert("차량 번호를 입력해 주세요.");
		return false;
	}
	if($("input:radio[id='public']").is(":checked")==true){
		mform.user_name.value = "공용";
	}
	if($("input:radio[id='individual']").is(":checked")==true && mform.user_name.value == ""){
		alert("사용자를 지정해 주세요.");
		mform.user_name.click();
		return false;
	}

	mform.submit();
	return false;
}

function chkForm2 () {
	if (confirm("정말 삭제하시겠습니까?") == true){
		var mform = document.cform;
		mform.action="<?php echo site_url();?>/admin/equipment/car_delete_action";
		mform.submit();
		return false;
	}
}
</script>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" /> <!-- 조직도 생성 -->
<link rel="stylesheet" href="/misc/css/tech_schedule/proton/style.min.css" /> <!-- 조직도 생성 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
<style media="screen">
	.input-common {
		width: 100%;
	}
</style>
<body>
<meta name="viewport" content="width=device-width,height=device-width, initial-scale=1.0">
<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/mobile_side.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/mobile_header.php";
	?>
<div style="max-width:90%;margin: 0 auto; padding-bottom: 60px;margin-top:30px;">
	<div width="100%">
		<form name="cform" action="<?php echo site_url();?>/admin/equipment/car_input_action" method="post" onSubmit="javascript:chkForm();return false;">
			<input type="hidden" name="seq" value="<?php echo $seq;?>">
			<table class="basic_table">
				<col width="30%">
				<col width="70%">
				<tr>
					<td bgcolor="#F4F4F4" style="font-weight:bold;">차종</td>
					<td>
						<input name="type" type="text" class="input-common" id="type" value="<?php echo stripslashes($view_val['type']);?>"/>
					</td>
				</tr>
				<tr>
					<td bgcolor="#F4F4F4" style="font-weight:bold;">*차량 번호</td>
					<td>
						<input name="number" type="text" class="input-common" id="number" value="<?php echo $view_val['number'];?>" maxlength="10"/>
					</td>
				</tr>
				<tr>
					<td bgcolor="#F4F4F4" style="font-weight:bold;">*지정</td>
					<td>
						<input type="radio" name="chk_info" value="public" id="public" <?php if($view_val['user_name']=="공용"){echo "checked";} ?>>공용
						<input type="radio" name="chk_info" value="individual" id="individual" <?php if($view_val['user_name']!="공용"){echo "checked";} ?>>개인
					</td>
				</tr>
				<tr id="tr_user" style="<?php if($view_val['user_name']=="공용"){echo "display:none";} ?>">
					<td bgcolor="#F4F4F4" style="font-weight:bold;">*사용자</td>
					<td>
						<input type="text" id="appointed" class="input-common" name="user_name" value="<?php if($view_val['user_name']=="공용"){echo "";}else{echo $view_val['user_name'];}; ?>" onclick="$('#searchAddUserpopup').bPopup();" style="width:100%;" autocomplete="off" readonly>
							<input type="hidden" id="appointed_seq" class="input2" name="user_seq" id="user" value="<?php echo $view_val['user_seq']; ?>" onclick="$('#searchAddUserpopup').bPopup();" style="width:100%;display:none;">
						</td>
					</tr>
				</table>
				<div class="btn_div" style="margin-top:20px;">
					<?php if($admin_lv == 3){?>
						<input type="button" class="btn-common btn-color1" value="삭제" onclick="javascript:chkForm2();return false;" style="float:right;">
						<input type="button" class="btn-common btn-color1" value="수정" onclick="javascript:chkForm();return false;" style="float:right;margin-right:10px;">
					<?php } ?>
					<input type="button" class="btn-common btn-color1" value="목록" onClick="javascript:history.go(-1)" style="float:right;margin-right:10px;">
				</div>
		</form>
	</div>
</div>
<!-- 지정 사용자 모달 -->
<div id="searchAddUserpopup" style="display:none; background-color: white; width: auto; height: auto;">
	<span id="searchAddUserpopupCloseBtn" class="btn" onclick="searchCloseBtn()" style="margin:0% 0% 0% 96%; color:white;">X</span>
	<div id="search-modal-body">
		<div id="search-modal-grouptree" style="width:300px">
			<div id="search-usertree">
				<ul>
					<li>(주)두리안정보기술
						<ul>
						<?php
						foreach ($parentGroup as $pg){
						?>

						<?php
						if ($pg->childGroupNum==1 && $pg->depth==1){
						?>
							<li>
								<?php echo $pg->parentGroupName;
									foreach ($userInfo as $ui){
											if ($pg->groupName==$ui->user_group){
								?>
								<ul>
									<li id="<?php echo $ui->user_name; ?>"><?php echo $ui->user_name." ".$ui->user_duty.'<div style="display:none;">'.$ui->seq.'</div>'; ?></li>
								</ul>
								<?php
											}
									}
								?>
							</li>
							<?php
							} else if ($pg->childGroupNum>1 && $pg->depth==1){
							?>
							<li>
							<?php echo $pg->parentGroupName;
							foreach ($user_group as $ug) {
								if ($pg->parentGroupName==$ug->parentGroupName){
							?>
								<ul>
									<?php
									foreach ($userDepth as $ud){
											if ($ug->groupName == $ud->groupName){
												echo '<li id="'.$ud->user_name.'">'.$ud->user_name." ".$ud->user_duty.'<div style="display:none;">'.$ud->seq.'</div></li>';
											}
									}
									if ($ug->groupName != $pg->groupName){
										echo "<li>".$ug->groupName;
									}
									?>
										<ul>
										<?php
											foreach($userInfo as $ui) {
												if ($ug->groupName==$ui->user_group){
													echo '<li id="'.$ui->user_name.'">'.$ui->user_name." ".$ui->user_duty.'<div style="display:none;">'.$ui->seq.'</div></li>';
												}
											}
										?>
										</ul>
									</li>
								</ul>
							<?php
								}
							}
							?>
							</li>
							<?php
							}
							?>
						<?php
						}
						?>
						</ul>
					</li>
				</ul>
			</div>
		</div>
		<div id="search-btnDiv" style="float:right;">
			<input type="button" class="btn-common btn-color2" value="등록" width="54" height="25" onclick="addUser(this.id)" id="searchChosenBtn">
		</div>
	</div>
</div>
		<!-- 지정 사용자 모달 -->
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
</body>
<script>
$("input[name='chk_info']:radio").change(function () {
	if(this.value == "public"){
		$("#tr_user").hide();
	} else if (this.value == "individual") {
		$("#tr_user").show();
	}
});

// 지정 조직도 트리 생성
var checked_text_select = [];
var checked_seq_select = [];
$(function() {
  $('#search-usertree').jstree({
    "checkbox" : {
      "keep_selected_style" : false
    },
    'plugins': ["wholerow", "checkbox"],
    'core' : {
      'themes' : {
        'name': 'proton',
        'icons' : false
      }
    }
  });
  $("#search-usertree").bind("changed.jstree", function (e, data) {
    var reg = /^[가-힣]*$/;
    checked_text_select.length = 0;
    checked_seq_select.length = 0;
    $.each($("#search-usertree").jstree("get_checked",true),function() {
      if (reg.test(this.id)) {
				var text = this.text.split('<div style="display:none;">');
				text2 = text[0];
				var seq = text[1].replace('</div>','');
        checked_text_select.push(text2);
        checked_seq_select.push(seq);
				// console.log(checked_text_select);
				// console.log(checked_seq_select);
      }
    })
  });
});

function unique(array) {
  var result = [];
  $.each(array, function(index, element) {
    if ($.inArray(element, result) == -1) {
      result.push(element);
    }
  });
  return result;
}

// 사용자 추가
function addUser(){
    var noneOverlapArr = unique(checked_text_select);

    var searchName ='';
    var searchNameArr = [];
    //직급 제거하기
    $.each(noneOverlapArr,function() {
      searchName = $(this)[0];
      searchName = searchName.split(' ')[0];
      searchNameArr.push(searchName)
    })
    var searchAdduser = searchNameArr.join(",");
    $('#appointed').val('');
    $('#appointed').val(searchAdduser);
    $('#appointed_seq').val('');
    $('#appointed_seq').val(checked_seq_select);
    $('#searchAddUserpopup').bPopup().close(); //모달 닫기
}
</script>
</html>

<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">
<script type="text/javascript" src="/misc/js/jquery.bpopup-0.1.1.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" /> <!-- 조직도 생성 -->
<link rel="stylesheet" href="/misc/css/tech_schedule/proton/style.min.css" /> <!-- 조직도 생성 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script> <!-- 조직도 생성 -->
<style>
.left {
	float:left;
	border: thin solid #DFDFDF;
	border-radius: 3px;
	min-width:15%;
	max-width:15%;
	height: 70vh;
}
.right {
	float:right;
	border: thin solid #DFDFDF;
	border-radius: 3px;
	min-width:80%;
	height: 70vh;
}
.btn {
	width:100%;
	height: 50px;
	border-bottom: thin solid #DFDFDF;
}
.tree_container {
	width:100%;
	display: block;
	overflow:auto;
	margin-top:10px;
}
.list_container {
	width:100%;
	display: block;
	overflow:auto;
	height:90%;
}
#tree {
	height: 90%;
	overflow-y: auto;
}
#tree a {
  margin-bottom: 10px;
}
#bold a {
  font-weight: bold;
}
.jstree-anchor {
    font-weight:bold;
}
#j3_4_anchor {
  font-weight: bold;
}

.jstree-proton {
  font-family:"Noto Sans KR", sans-serif !important;
}
.moveZone:hover {
	background-color: #76b6ec;
	color: white;
}

.contextmenu {
  display: none;
  position: absolute;
  width: 150px;
  margin: 0;
  padding: 0;
  background: #FFFFFF;
  border-radius: 5px;
  list-style: none;
  box-shadow:
    0 15px 35px rgba(50,50,90,0.1),
    0 5px 15px rgba(0,0,0,0.07);
  overflow: hidden;
  z-index: 999999;
}

.contextmenu li {
  border-left: 3px solid transparent;
  transition: ease .2s;
}

.contextmenu li a {
  display: block;
  padding: 10px;
  color: #B0BEC5;
  text-decoration: none;
  transition: ease .2s;
}

.contextmenu li:hover {
  background: #CE93D8;
  border-left: 3px solid #9C27B0;
}

.contextmenu li:hover a {
  color: #FFFFFF;
}

</style>
<body>
<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>

<div align="center">
	<div class="dash1-1">
		<table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
			<tbody>
				<tr>
					<td class="dash_title">
						조직도관리
					</td>
				</tr>
				<tr height="70px">
        </tr>
				<tr style="max-height:45%">
					<td colspan="2" valign="top" style="padding:10px 0px;">
						<table class="content_dash_tbl" style="border:none;" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td>
									<div class="left">
										<div class="tree_container">
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr>
													<td class="moveZone" id="all" seq="1" style="padding: 5px;">
														<img class='parentGroup' src='/misc/img/dashboard/dash_plus.svg' height='15px'><input type='checkbox' id='allCheck' onchange='selectGroup(this)'>(주)두리안정보기술 (<?php echo $user_count[0]['cnt']; ?>)
													</td>
												</tr>
																			<?php
																				foreach ($parentGroup as $pg) {
																					if ($pg->childGroupNum==1 && $pg->depth==1) {
																						foreach($parent_group_count as $pgc) {
																							if ($pg->parentGroupName == $pgc['parentGroupName']) {
																								echo "<tr><td class='moveZone hide 1 ".$pg->seq."' style='padding: 5px;cursor: pointer;' id=".$pg->parentGroupName." seq=".$pg->seq." onmousedown='selectMoveGroup(this); return false;'>&nbsp;&emsp;&emsp;&emsp;<input type='checkbox' class='checkbox' onchange='selectGroup(this)'>".$pg->parentGroupName." (".$pgc['cnt'].")</td></tr>";
																							}
																						}
																					} else if ($pg->childGroupNum>1 && $pg->depth==1) {
																						foreach ($parent_group_count as $pgc) {
																							if ($pg->parentGroupName == $pgc['parentGroupName']) {
																								echo "<tr><td class='moveZone hide 1 ".$pg->seq."' style='padding: 5px;cursor: pointer;' id=".$pg->parentGroupName." seq=".$pg->seq." onmousedown='selectMoveGroup(this); return false;'>&emsp;&emsp;<img class='parentGroup' src='/misc/img/dashboard/dash_plus.svg' height='15px'><input type='checkbox' class='checkbox' onchange='selectGroup(this)'>".$pg->parentGroupName." (".$pgc['cnt'].")</td></tr>";
																							}
																						}
																						foreach ($user_group as $ug) {
																							if ($pg->parentGroupName==$ug->parentGroupName) {
																								if ($ug->groupName != $pg->groupName) {
																									foreach($user_group_count as $ugc) {
																										if ($ug->groupName == $ugc['groupName']) {
																											echo "<tr><td class='moveZone hide ".$pg->seq." ".$ug->seq."' style='padding: 5px;cursor: pointer;' id=".$ug->groupName." seq=".$ug->seq." onmousedown='selectMoveGroup(this); return false;'>&emsp;&emsp;&emsp;&emsp;&emsp;<input type='checkbox' class='checkbox' onchange='selectGroup(this)'>".$ug->groupName.' ('.$ugc['cnt'].')</td></tr>';
																										}
																									}
																								}
																							}
																						}
																					}
																				}
																			?>
											</table>
										</div>
									</div>
									<div class="right">
										<div class="btn">
											<span id="chk_dept" style="float:left;font-weight:bold;font-size:17px;margin-left:10px;padding-top:16px;">두리안정보기술<span id="chk_dept_cnt"></span></span>
											<input type="button" class="btn-common btn-style5" value="부서이동" onclick="changeGroupBtn();" style="float:right;margin-top:10px;margin-right:10px;"></input>
											<!-- <input type="button" class="btn-common btn-style4" value="권한관리" style="float:right;margin-top:10px;margin-right:10px;" onclick="changeLevelBtn();"></input> -->
											<input type="button" class="btn-common btn-style4" value="부서별권한관리" style="width:120px;float:right;margin-top:10px;margin-right:10px;" onclick="$('#group_level_change').bPopup();"/>
										</div>
										<div class="list_container">
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<colgroup>
													<col width="4%">
													<col width="9%">
													<col width="9%">
													<col width="10%">
													<col width="14%">
													<col width="4%">
													<col width="9%">
													<col width="9%">
													<col width="10%">
													<col width="14%">
												</colgroup>
												<tbody id="user_list">
												</tbody>
											</table>
										</div>
									</div>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>


<!--하단-->
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
<!--//하단-->

<!-- 부서관리 모달 -->
<div id="group_management" style="display:none; position: absolute; background-color: white; width: auto; height: auto;">
	<table width="400">
		<tr>
			<td class="modal_title" align="center" colspan="2" style="padding:20px 0px 20px 0px">
			부서관리
			</td>
		</tr>
		<div style="margin-top:20px;position: absolute;right:0;"><img src="<?php echo $misc; ?>img/dashboard/btn/icon_x.svg" width="15" style="cursor:pointer;margin-right:10px;" onclick="$('#group_management').bPopup().close();"></div>
		<tr>
			<td>
				<div id="groupTree"></div>
				<ul style="line-height:2em;">
					<li id="all" name="depth0">
						<img src="<?php echo $misc; ?>img/dashboard/btn/icon_plus.svg" id="depth0" width="13" style="cursor:pointer;" onclick="addGroup(this);">
						<span id="all" style="font-weight:bold" >
							(주)두리안정보기술
						</span>
						<ul id="allGroup" class="not_padding">
							<?php
							$test='';
							foreach ( $view_val2 as $parentGroup ) {
								if($parentGroup['childGroupNum']>1){
									$test .= ",".$parentGroup['groupName'];
								}
								if($parentGroup['depth'] == 1){
									?>
									<li id="<?php echo $parentGroup['groupName'];?>" name="depth1">
										<img src="<?php echo $misc; ?>img/dashboard/btn/icon_plus.svg" width="13" style="cursor:pointer;" onclick="addGroup(this);">
										<img src="<?php echo $misc; ?>img/dashboard/btn/icon_minus.svg" width="13" style="cursor:pointer;" onclick="removeGroup(this);">
										<span id="<?php echo $parentGroup['groupName'];?>">
											<input type="text" class="input2" style="width:100px" name="depth1" value="<?php echo $parentGroup['groupName'];?>">
										</span>
										<ul id="<?php echo $parentGroup['groupName']."Group" ;?>" class="not_padding">
										</ul>
									</li>
									<?php
								}
							}
							?>
						</ul>
					</li>
				</ul>
			</ul>
		</td>
	</tr>
	<tr>
		<td align="center">
			<div style="margin-top:50px;">
				<img src="<?php echo $misc; ?>img/dashboard/btn/btn_save.png" onclick="updateGroup();" style="cursor:pointer;text-align:center"/>
				<!-- <input type="button" value="저장" onclick="updateGroup();" /> -->
			</div>
		</td>
	</tr>
</table>
</div>

<!-- 사이트관리 모달 -->
<div id="page_management" style="display:none; position: absolute; background-color: white; width: auto; height: auto;">
	<table width="100%">
		<tr>
			<td class="modal_title" align="center" style="padding:20px 0px 20px 0px">
				사이트관리
			</td>
		</tr>
	</table>
  <table id="pageTable" border="0" cellspacing="0" cellpadding="0">
		<colgroup>
			<col width="195">
			<col width="195">
			<col width="195">
			<col width="300">
		</colgroup>
    <tr>
      <th height="40" bgcolor="f8f8f9">번호</th>
      <th height="40" bgcolor="f8f8f9">홈페이지명</input></th>
      <th height="40" bgcolor="f8f8f9">주소</input></th>
      <th height="40" bgcolor="f8f8f9"></th>
    </tr>

<?php
    $i = 1;
    foreach($pageList as $page){
      echo '<tr><td height="40" style="text-align: -webkit-center;">'.$i.'</td><td style="text-align: -webkit-center;"><input type="hidden" value="'.$page['seq'].'"><input type="text" id="page_name'.$i.'" class="input2" value="'.$page['page_name'].'" style="width:180px"></td><td style="text-align: -webkit-center;"><input type="text" id="page_address'.$i.'" class="input2" value="'.$page['page_address'].'" style="width:180px"></td><td style="text-align: -webkit-center;"><input type="button" class="groun_btn" value="수정" style="float:left;margin-left:10px;width:60px" onclick="updatePage('.$page['seq'].','.$i.');"></input><input type="button" class="groun_btn" value="삭제" style="float:left;margin-left:10px;width:60px" onclick="deletePage('.$page['seq'].');"></input><input type="button" value="사이트권한관리" class="groun_btn" style="float:left;margin-left:10px;" onclick="pageRightsManagement('.$page['seq'].');" /></td</tr>';
      $i++;
    }
?>
		<tr>
			<td colspan=4 align="center">
				<img src="<?php echo $misc; ?>img/dashboard/dash_detail.png" width="20" style="cursor:pointer;margin-top:50px;" onclick="addPage(this)">
			</td>
		</tr>
  </table>
</div>

<!-- 부서별 권한 관리 모달 -->
<div id="group_level_change" style="display:none; position: absolute; background-color: white; width: 500px; height: auto;">
	<div style="width:90%;margin: 0 auto;">
		<table>
			<tr>
				<td class="tbl-sub-title" align="left">
					부서별권한관리
				</td>
			</tr>
		</table>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<colgroup>
				<col width="40%">
				<col width="60%">
			</colgroup>
	    <!-- <tr><td style="text-align:center;">부서</td><td style="text-align:center;">권한</td></tr> -->
	    <tr>
	      <th height="40" bgcolor="f8f8f9">부서</th>
	      <th height="40" bgcolor="f8f8f9">권한</th>
	    </tr>
	    <tr height="20px"></tr>
	    <tr>
	      <td style="padding-left:10px;text-align: -webkit-center;">
	        <select id="glc_group_level" name="group" class="select-common" >
	        </select>
	      </td>
	      <td id="userPart" style="text-align: -webkit-center;">
	        <div>
	          <select name="glc_user_part1" id="glc_user_part1" class="select-common">
	          <?php
						$part = array('비즈', '영업', '기술', '관리');
						for($i=0; $i<count($part); $i++){ ?>
	            <option value="<?php echo $i+1;?>"><?php echo $part[$i]; ?></option>
	          <?php } ?>
	          </select>
	          <select name="glc_user_part2" id="glc_user_part2" class="select-common">
	            <option value=0>권한없음</option>
	            <option value=1>일반</option>
	            <option value=2>팀관리자</option>
	            <option value=3>관리자</option>
	          </select>
	        </div>
	      </td>
	  </tr>
	  <tr height="30px"></tr>
	  <tr>
			<td colspan="2" style="text-align: -webkit-center;">
				<input style="float:right;" type="button" class="btn-common btn-color2" value="권한부여" onclick="groupLevelChange();">
				<input style="float:right;" type="button" class="btn-common btn-color4" value="취소" onclick="$('#group_level_change').bPopup().close();">
			</td>
		</tr>
		<tr height="30px"></tr>
	  </table>
	</div>
</div>


<!-- 권한 관리 모달 -->
<div id="level_change" style="display:none; position: absolute; background-color: white; width: 300px; height: auto;">
	<div style="width:90%;margin: 0 auto;">
		<table>
			<tr>
				<td class="tbl-sub-title" align="center" style="padding:20px 0px 20px 0px">
					권한관리
				</td>
			</tr>
		</table>
		<table width="250" style="font-family:Noto Sans KR;font-size:13px;">
			<colgroup>
				<col width="20%">
				<col width="80%">
			</colgroup>
			<tbody id="checkMember"></tbody>
		</table>
		<div style="float:right;margin-bottom:10px;">
			<input type="button" class="btn-common btn-color4" value="취소" onclick="$('#level_change').bPopup().close();">
		</div>
	</div>
</div>
<!-- 권한 관리 모달 -->
<div id="group_change" style="display:none; position: absolute; background-color: white; width: 200px; height: auto;">
	<div style="width:90%;margin: 0 auto;">
		<table>
			<tr>
				<td class="tbl-sub-title" align="center" style="padding:20px 0px 20px 0px">
					부서이동
				</td>
			</tr>
		</table>
		<table width="100%" style="font-family:Noto Sans KR;font-size:13px;">
			<tbody id="group_change_tbl">
			</tbody>
		</table>
		<div style="float:right;margin-bottom:10px;width:100%;">
			<input type="button" class="btn-common btn-color2" value="저장" onclick="save_group_change();" style="float:left;width:45%">
			<input type="button" class="btn-common btn-color4" value="취소" onclick="$('#group_change').bPopup().close();" style="float:right;width:45%">
		</div>
	</div>
</div>

<!-- 우클릭창 -->
<ul class="contextmenu" seq="" id="">
	<div class="menu" seq="" id="input_li" style="display:none;">
		<input type="hidden" id="tax_num" value="">
		<input type="text" class="input-common" id="name_input" name="" value="" style="width:140px;">
		<input class="btn-common btn-color2" type="button" onclick="modifyGroup(this);" value="저장" style="width:50px;margin:5px 2px 0px 30px;">
		<input class="btn-common btn-color4" type="button" onclick="$('.contextmenu').hide();" value="취소" style="width:50px;margin:5px 0px 0px 0px;">
	</div>
	<li class="modify"><a href="#" seq="1" onclick="$('#input_li').show();$('.modify').hide();$('.remove').hide();$('.add').hide();goSeq(this);">수정</a></li>
	<li class="remove"><a href="#" seq="2" onclick="removeGroup(this);">삭제</a></li>
	<li class="add"><a href="#" seq="3" onclick="$('#input_li').show();$('.modify').hide();$('.remove').hide();$('.add').hide();goSeq(this);">추가</a></li>
</ul>

<div id="move_box" style="display:none;position: absolute; width: 90px; height: 30px; border-radius: 100%;font-size: 12px; text-align:center;">
<span id="movebox_len"></span>
</div>

</body>

<script>
function changeGroupBtn() {
  var checkMember ="";
  $("input[name=checkMember]:checked").each(function(){
    checkMember += ',' + $(this).val();
  });
  if(checkMember == ''){
    alert("수정 할 인원을 체크 하세요")
    return false;
  }
  // checkMember = checkMember.substring(0,checkMember.length-1);
  // window.open('<?php echo site_url();?>/admin/account/group_change?seq='+checkMember,'_blank','top=100px, left=100px, height=500px, width=800px');
	var seq = checkMember;
  $.ajax({
    type: "POST",
    cache: false,
    url: "<?php echo site_url();?>/ajax/groupView",
    dataType: "json",
    async: false,
    data: {
      group: seq
    },
    success: function(data) {
      $.ajax({
        type: "POST",
        cache: false,
        url: "<?php echo site_url();?>/ajax/group",
        dataType: "json",
        async: false,
        data: {
        },
        success: function (result) {
          var text = "";
            for(i=0; i<data.length; i++){
							text += "<tr><td align='center'><select class='select-common' name='"+data[i].seq+"' style='width:100%'>";
							for(j=0; j<result.length; j++){
								if(result[j].groupName == data[i].user_group){
									text += "<option value='"+result[j].groupName+"' selected='selected'>"+result[j].groupName+"</option>"
								}else{
									text += "<option value='"+result[j].groupName+"'>"+result[j].groupName+"</option>"
								}
							}
							text += "</select></tr></td>";
							text += "<tr><td align='left' style='font-weight:bold;color:#0575E6;font-size:14px;'>"+data[i].user_name+"</td></tr>"
							text += "<tr><td align='left' style='color:#3C3C3C'>"+data[i].user_tel+"</td></tr>"
							text += "<tr><td align='left' style='color:#B0B0B0'>"+data[i].user_email+"</td></tr>"
							text += "<tr height='20'></tr>"
            }
          $("#group_change_tbl").html(text);
          $("#group_change").bPopup();
        }
      });
    }
  });
}

function changeGroup(select){
	var changeSeq = select.name;
	var selectGroup = select.value;
	var check = confirm(selectGroup+"으로 부서 이동 하시겠습니까?")

	if(check == true){
		$.ajax({
			type: "POST",
			cache: false,
			url: "<?php echo site_url();?>/ajax/changeGroup",
			dataType: "json",
			async: false,
			data: {
				seq:changeSeq,
				changeGroup:selectGroup
			},
			success: function (data) {
				if(data==true){
					alert("정상적으로 처리 되었습니다.")
				}else{
					alert("정상적으로 처리되지 못했습니다.")
				}
				location.reload();
			}
		});
	}else{
		location.reload();
	}


}

function changeLevelBtn() {
  var checkMember ="";
  $("input[name=checkMember]:checked").each(function(){
    checkMember += ',' + $(this).val() ;
  });

  if(checkMember == ''){
    alert("수정 할 인원을 체크 하세요")
    return false;
  }
  // checkMember = checkMember.substring(0,checkMember.length-1);
  // window.open('<?php echo site_url();?>/admin/account/level_change?seq='+checkMember,'_blank','top=100px, left=100px, height=500px, width=800px');
	var seq = checkMember;
	$.ajax({
		type: "POST",
		cache: false,
		url: "<?php echo site_url();?>/ajax/groupView",
		dataType: "json",
		async: false,
		data: {
			group: seq
		},
		success: function(data) {
				var text = "";
				$("#checkMember").html("");
				for(i=0; i<data.length; i++){
					var num='';
					text += "<tr><td colspan='2' align='left' style='color:#0575E6;font-weight:bold;'>"+data[i].user_name+" "+data[i].user_duty+"</td></tr>";

          <?php
					$part = array('비즈', '영업', '기술', '관리');
					for($i=0; $i<count($part); $i++){ ?>
            text += '<tr><td align="left"><span name="user_part1" id="page<?php echo ($i+1) ;?>" style="margin-right:20px;"><?php echo $part[$i];?></span></td>';
            text += '<td align="left"><select name="'+data[i].seq+'" id="user_part2" class="select-common" style="width:100%">'
            text += '<option value=0'
            // alert(<?php echo $i; ?>)
            if((data[i].user_part).substr(<?php echo $i; ?>,1) == "0"){
              text += " selected";
            }
            text += '>권한없음</option><option value=1'
            if((data[i].user_part).substr(<?php echo $i; ?>,1) == "1"){
              text += " selected";
            }
            text += '>일반</option><option value=2'
            if((data[i].user_part).substr(<?php echo $i; ?>,1) == "2"){
              text += " selected";
            }
            text += '>팀관리자</option><option value=3'
            if((data[i].user_part).substr(<?php echo $i; ?>,1) == "3"){
              text += " selected";
            }
            text += '>관리자</option></select></td></tr>'
          <?php } ?>

						text += '<td align="center" colspan="2"><input type="button" class="btn-common btn-color4" value="수정" onclick="changeUserPart('+data[i].seq+')"></td><tr height=20></tr>';
						// text += "<td><input type='button' value='수정' class='input1' onclick='changeUserPart("+data[i].seq+")'></td><tr height=20></tr>";
						$("#checkMember").html(text);

						$("#level_change").bPopup({
							follow: [false,false]
						});
				}

		}
	});
}

function groupChangeLevelBtn(){
  window.open('<?php echo site_url();?>/admin/account/group_level_change?','_blank','top=100px, left=100px, height=500px, width=800px');
}

function groupManagementBtn(){
  window.open('<?php echo site_url();?>/admin/account/group_management','_blank','top=100px, left=100px, height=500px, width=800px');
}

function pageManagement(){
  window.open('<?php echo site_url();?>/admin/account/page_management','_blank','top=100px, left=100px, height=500px, width=800px');
}
</script>
<!-- 부서관리 스크립트 -->
<script>
var parent = "<?php echo $test; ?>";
parent = parent.substring(1).split(',');
for(i=0; i <parent.length; i++){
  (function(i) {
    var text = "";
    var parentGroup = parent[i];
    $.ajax({
      type: "POST",
      cache: false,
      url: "<?php echo site_url(); ?>/ajax/childGroup",
      dataType: "json",
      async: false,
      data: {
        parentGroup:parentGroup
      },
      success: function (data) {
        for(i=0; i<data.length; i++){
            text += '<li id="'+data[i].groupName+'" name="depth'+data[i].depth+'" ><img src="<?php echo $misc; ?>img/dashboard/btn/icon_plus.svg" width="13" style="cursor:pointer;" onclick="addGroup(this);"><img src="<?php echo $misc; ?>img/dashboard/btn/icon_minus.svg" width="13" style="cursor:pointer;" onclick="removeGroup(this);"><span style="cursor:pointer;" id="'+data[i].groupName+'"><input type="text" class="input2" style="width:100px" name="depth'+data[i].depth+'" value="'+data[i].groupName+'"></span><ul id="'+data[i].groupName+'Group" class="not_padding"></ul></li>';
        }
        $("#"+parentGroup+"Group").html($("#"+parentGroup+"Group").html()+text);
      }
    });
  })(i);
}

function addGroup(plus){
  var depth = ($(plus).parent().attr('name')).replace('depth', '');
  depth = Number(depth)+1;
  var addTarget = $(plus).parent().children('ul')
  var addText = '<li name="depth'+depth+'"><img src="<?php echo $misc; ?>img/dashboard/btn/icon_plus.svg" width="13" style="cursor:pointer;" onclick="addGroup(this);"><img src="<?php echo $misc; ?>img/dashboard/btn/icon_minus.svg" width="13" style="cursor:pointer;" onclick="removeGroup(this);"><span><input type="text" class="input2" style="width:100px" name="depth'+depth+'"></span><ul class="not_padding"></ul></li>'
  addTarget.html(addTarget.html()+addText);
}

function removeGroup(remove){
  var removeTarget = $(remove).parent().remove();
}

function updateGroup(){
  var success_num = 0;
  var groupTotal = 0;
  $.ajax({
      type: "POST",
      cache: false,
      url: "<?php echo site_url(); ?>/ajax/groupAllDelete",
      dataType: "json",
      async: false,
      data: {
      },
      success: function (data) {
        if (data == true) {
          var depthCheck = true;
          var depth = 1;
          while (depthCheck == true) {
            if ($('input[name="depth' + depth + '"]').length) {
              depth++;
            } else {
              depthCheck = false;
            }
          }
          for (i = 1; i < depth; i++) {
            var length = $('input[name="depth' + i + '"]').length;
            groupTotal = groupTotal+length;
            for (j = 0; j < length; j++) {
              var depthNum = i;
              var group = $('input[name="depth' + i + '"]').eq(j).val();
              var groupUl = $('input[name="depth' + i + '"]').eq(j).parent().parent().children('ul');
              var childGroupNum = Number(groupUl.children('li').length) + 1;

              if (i == 1) {
                var parentGroup = $('input[name="depth' + i + '"]').eq(j).val();
              } else {
                var parentGroup = $('input[name="depth' + i + '"]').eq(j).parent().parent().parent().attr('id')
                parentGroup = parentGroup.replace("Group", "")
              }

              $.ajax({
                type: "POST",
                cache: false,
                url: "<?php echo site_url(); ?>/ajax/groupUpdate",
                dataType: "json",
                async: false,
                data: {
                  groupName: group,
                  parentGroupName: parentGroup,
                  childGroupNum: childGroupNum,
                  depth: depthNum
                },
                success: function (data) {
                  if(data == true){
                    success_num++;
                  }else{
                    alert("정상적으로 처리되지 못했습니다.")
                  }
                }
              });
            }
          }

          if(groupTotal == success_num){
            alert("정상적으로 처리되었습니다.")
          }else{
            alert("정상적으로 처리되지 못했습니다.")
          }
        } else {
          alert("정상적으로 처리되지 못했습니다.")

        }
        location.reload();
      }
    });
}
</script>
<!-- 사이트관리 스크립트 -->
<script>
var num = <?php echo $i;?>;
function addPage(btn){
    var txt = '<tr><td height="40" style="text-align: -webkit-center;">'+num+'</td><td style="text-align: -webkit-center;"><input type="hidden" value=""><input id="page_name'+num+'" type="text" class="input2" value="" style="width:180px"></td><td style="text-align: -webkit-center;"><input type="text" id="page_address'+num+'" class="input2" value="" style="width:180px"></td><td style="text-align: -webkit-center;"><input type="button" class="groun_btn" value="등록" style="margin-left:10px;width:60px"  onclick="insertPage('+num+');"></input></td</tr>'
    $("#pageTable").append(txt);
    $(btn).remove();
    num++
}

//등록
function insertPage(n) {
    var pageName = $("#page_name"+n).val();
    var pageAddress = $("#page_address"+n).val();
    $.ajax({
        type: "POST",
        cache: false,
        url: "<?php echo site_url(); ?>/ajax/insertPage",
        dataType: "json",
        async: false,
        data: {
            pageName: pageName,
            pageAddress:pageAddress,
        },
        success: function (data) {
            if(data == true){
                alert("등록되었습니다.")
                location.reload();
            }else{
                alert("정상적으로 등록 되지 못했습니다.")
            }
        }
    });
}


//수정
function updatePage(seq,n){
    var pageName = $("#page_name"+n).val();
    var pageAddress = $("#page_address"+n).val();
    var updateConfirm = confirm("수정하시겠습니까?");
    if(updateConfirm == true){
        $.ajax({
            type: "POST",
            cache: false,
            url: "<?php echo site_url(); ?>/ajax/updatePage",
            dataType: "json",
            async: false,
            data: {
                seq:seq,
                pageName:pageName,
                pageAddress:pageAddress
            },
            success: function (data) {
                if(data){
                    alert("수정되었습니다.")
                    location.reload();
                }else{
                    alert("정상적으로 수정되지 못했습니다.")
                }
            }
        });
    }else{
        return false;
    }
}

//삭제
function deletePage(seq){
    var deleteConfirm = confirm("삭제하시겠습니까?");
    if(deleteConfirm == true){
        $.ajax({
            type: "POST",
            cache: false,
            url: "<?php echo site_url(); ?>/ajax/deletePage",
            dataType: "json",
            async: false,
            data: {
                seq:seq
            },
            success: function (data) {
                if(data == true){
                    alert("삭제되었습니다.")
                    location.reload();
                }else{
                    alert("정상적으로 삭제되지 못했습니다.")
                }
            }
        });
    }else{
        return false;
    }
}

function pageRightsManagement(seq){
    window.open('<?php echo site_url();?>/admin/account/page_rights_management?seq='+seq);
}
</script>
<!-- 부서별권한관리 -->
<script>
$.ajax({
    type: "POST",
    cache: false,
    url: "<?php echo site_url(); ?>/ajax/group",
    dataType: "json",
    async: false,
    data: {
    },
    success: function (data) {
      var txt;
      for(i=0; i<data.length; i++){
        txt += '<option value="'+data[i].groupName+'">'+data[i].groupName+'</option>'
      }
      $("#glc_group_level").append(txt);
    }
});

function groupLevelChange(){
  $.ajax({
    type: "POST",
    cache: false,
    url: "<?php echo site_url(); ?>/ajax/groupChangeUserPart",
    dataType: "json",
    async: false,
    data: {
      groupName:$("#glc_group_level").val(),
      userPart:$("#glc_user_part1").val(),
      userLevel:$("#glc_user_part2").val()
    },
    success: function (data) {
      if(data==true){
        alert("정상적으로 처리 되었습니다.")
				location.reload();
      }else{
        alert("정상적으로 처리되지 못했습니다.")
      }
    }
  });
}

function changeUserPart(seq){
	var changeUserPart = '';

	for( i=0; i<document.getElementsByName(seq).length; i++){
		changeUserPart = changeUserPart+(document.getElementsByName(seq)[i].value);
	}

	var check = confirm("권한을 수정 하시겠습니까?")

	if(check == true){
		$.ajax({
			type: "POST",
			cache: false,
			url: "<?php echo site_url();?>/ajax/changeUserPart",
			dataType: "json",
			async: false,
			data: {
				seq:seq,
				userPart:changeUserPart
			},
			success: function (data) {
				if(data==true){
					alert("정상적으로 처리 되었습니다.")
				}else{
					alert("정상적으로 처리되지 못했습니다.")
				}
				location.reload();
			}
		});
	}else{
		location.reload();
	}
}

// 체크박스 !!
$(function() {

	//체크박스 기본값
	$('#allCheck').prop('checked', true);
	$('.checkbox').prop('checked', true);

	//전체선택 클릭
	$('#allCheck').click(function() {
		var total = $('.checkbox').length; //전체체크박스 개수
		var checked = $('.checkbox:checked').length; //체크된체크박스 개수

		if($('#allCheck').is(':checked')) { //전체선택 선택시
			$('.checkbox').prop('checked', true); //모든체크박스 선택됨
		} else {
			$('.checkbox').prop('checked', false); //모든체크박스 해제됨
		}
	})

	//부서 클릭
	$('.checkbox').click(function() {
		var td = $(this).closest('td');
		var cSeq = td.attr('seq'); //클릭한 부서seq
		var pSeq = td.attr('class').split(' ').splice(2, 1); //클릭한 부서의 부모seq

		var childNum = 0; //하위부서 개수
		var checkedChildNum = 0; //체크된 하위부서 개수

		var check = '';
		var checkParents = '';

		$('.moveZone').each(function() {
			var aSeq = $(this).attr('seq'); //모든 부서seq

			if(aSeq == cSeq) {
				check = $(this).find('input'); //클릭한 부서
			}

			//클릭한 부서의 하위부서 전체선택 or 전체해제
			if($(this).hasClass(cSeq) && cSeq != aSeq) {
				var checkChild = $(this).find('input'); //하위부서
					$(checkChild).prop('checked', false); //모든하위부서 해제

				if($(check).is(':checked')) {
					$(checkChild).prop('checked', true); //모든하위부서 선택
				}

			}

			if(pSeq == aSeq) {
				checkParents = $(this).find('input'); //상위부서
			}

			//클릭한 부서의 상위부서 선택 or 해제
			if($(this).hasClass(pSeq) && pSeq != aSeq) {
				var checkSide = $(this).find('input'); //클릭한 부서와 같은라인부서들
				childNum += 1; //개수카운트

				if($(checkSide).is(':checked')) {
					var chekedCheckSide = $(this).find('input'); //같은라인에 체크된 부서들
					checkedChildNum += 1; //개수카운트
				}
			}

		})

		if(childNum != 0) {
			if(childNum != checkedChildNum) {
				$(checkParents).prop('checked', false); //상위부서 해제

			} else {
				$(checkParents).prop('checked', true); //상위부서 선택

			}
	}

	//전체선택
	var total = $('.checkbox').length;
	var checked = $('.checkbox:checked').length;

	if(total != checked) {
		$('#allCheck').prop('checked', false); //하나라도 해제시
	} else {
		$('#allCheck').prop('checked', true); //모든체크박스 선택시
	}

	})

}) //체크박스 끝!

// 체크된 부서들에 해당하는 직원 보여주기

	$(function() { //기본값(전직원 보여지기)
		checked_group = [1];
		user_list(checked_group);
	})

	//체크된 부서들 seq 담기
	function selectGroup(select) {
    checked_group = [];

 		var length = $(".checkbox:checked").length;
 		var i = 1;

 		if (length == 0) {
 			$('#chk_dept_cnt').text('(0)');
			$("#user_list").html('');
 		}

		$('.moveZone').each(function() {
			var aSeq = $(this).find('input'); //모든 부서seq

			if ($(aSeq).is(':checked')) {
				var td = $(this).closest('td');
				var seq = td.attr('seq');

				checked_group.push(seq);
				if (i == length) {
					user_list(checked_group);
				}
				i ++;
			}

		})

	}

//체크된 부서들 seq 보내기
function user_list(checked_group){
	$.ajax({
		type:"POST",
		cache: false,
		url: "<?php echo site_url(); ?>/admin/account/management_user_list",
		dataType: 'json',
		async: false,
		data : {
			checked_group: checked_group
		},
		success: function(data) {
			if(data) {
				var list_text = '';
				for(i=0; i<data.length; i++) {
					if(i%2 == 0) {
						list_text += '<tr class="border-b"><td align="center" height="50" style="padding-left:10px;"><input name="checkMember" type="checkbox" style="vertical-align:middle;" value="'+data[i].seq+'"></td>';
						list_text += '<td style="font-weight:bold;color:#1C1C1C;cursor:pointer;" onmousedown="selectMove(' + data[i].seq + ', this); return false;">'+data[i].user_name+' '+data[i].user_duty+'</td>';
						list_text += '<td style="font-weight:bold;color:#1C1C1C">'+data[i].user_group+'</td><td style="color:#626262">'+data[i].user_tel+'</td>';
						list_text += '<td class="border-r" style="color:#626262;">'+data[i].user_email+'</td>';
					} else {
						list_text += '<td align="center" style="padding-left:10px;"><input name="checkMember" type="checkbox" style="vertical-align:middle;" value="'+data[i].seq+'"></td>';
						list_text += '<td style="font-weight:bold;color:#1C1C1C;cursor:pointer;" onmousedown="selectMove(' + data[i].seq + ', this); return false;">'+data[i].user_name+' '+data[i].user_duty+'</td>';
						list_text += '<td style="font-weight:bold;color:#1C1C1C">'+data[i].user_group+'</td><td style="color:#626262">'+data[i].user_tel+'</td>';
						list_text += '<td style="color:#626262;">'+data[i].user_email+'</td></tr>';
					}

				}
				$('#chk_dept_cnt').text('('+data.length+')');
				$("#user_list").html(list_text);
			}
		}
	})
}

// 드래그로 직원 부서 이동
function selectMove(seq, el) { //마우스 클릭(다운)
	drag = true;
	drag_seq = seq; //직원
	var target = $(el).text().trim();

	$(document).on("mousemove", function(e){
	 $("#movebox_len").html(target);
	 $("#move_box").show();

	 mboxmove(e);
	})

}

// 드래그로 부서 위치 이동
function selectMoveGroup(select) { //마우스 클릭(다운)
	gDrag = true;
	select = $(select).closest('td');
	select_id = select.attr('id');
	select_seq = select.attr('seq');

	$(document).on("mousemove", function(e){
	 $("#movebox_len").html(select_id);
	 $("#move_box").show();

	 mboxmove(e);
	})

}

$(function() { //폴더 외 다른 곳으로 드래그 X
	$('*').not('.moveZone').mouseup(function() {
		$("#move_box").hide();
		if(drag) {
			drag = false;
			drag_seq = '';
		}
		if(gDrag) {
			gDrag = false;
			select_id = '';
			elect_seq = '';
		}
		$(document).unbind('mousemove');
		$(document).unbind('mouseup');
	})
})

$(function() { //드래그 후 마우스업
	$('.moveZone').mouseup(function() {
		$("#move_box").hide();

		var group_id = $(this).attr('id'); //이동할 부서 id

		if(drag) { //직원 부서 이동
			if(group_id != 'all') { //두리안정보기술로는 이동 X
				var check = confirm(group_id+"(으)로 부서 이동 하시겠습니까?");

				if(check == true) {
					$.ajax({
					 type: "POST",
					 cache: false,
					 url: "<?php echo site_url(); ?>/ajax/changeGroup",
					 dataType: "json",
					 async :false,
					 data: {
							seq : drag_seq,
							changeGroup : group_id
					 },
					 success: function (data) {
							if(data==true) {
								alert('이동되었습니다.');
								location.reload();
							} else {
								alert("이동에 실패하였습니다. 관리자에게 문의주세요.");
							}
						}
					});
				}
			}
		} else if(gDrag) { //부서 위치 이동

			var pSeq = $(this).attr('class').split(' ').splice(2, 1); //클릭한 부서의 부모seq
			if(select_id != group_id && (pSeq == 1 || group_id == 'all')) { //그냥 클릭때 방지 & depth2로는 이동 X
				if(group_id == 'all') {
					group_id = '(주)두리안정보기술';
				}
				var check = confirm(group_id+" 하위로 이동 하시겠습니까?");

				if(check == true) {
					$.ajax({
					 type: "POST",
					 cache: false,
					 url: "<?php echo site_url(); ?>/ajax/moveGroup",
					 dataType: "json",
					 async :false,
					 data: {
							id : select_id,
							seq : select_seq,
							changeGroup : group_id
					 },
					 success: function (data) {
							if(data==true) {
								alert('부서가 이동되었습니다.');
								location.reload();
							} else {
								alert("부서의 이동에 실패하였습니다. 관리자에게 문의주세요.");
							}
						}
					});
				}
			}

		}
		$(document).unbind('mousemove');
		$(document).unbind('mouseup');
	})
	drag = false;
	drag_seq = '';
	gDrag = false;
	select_id = '';
	select_seq = '';
})

// 조직도 여닫기 !!
$('.hide').hide(); //기본상태(숨김)

$('.parentGroup').click(function() {
	var src = jQuery(this).attr('src');
	var td = $(this).closest('td');
	var pSeq = td.attr('seq');

	if (src.indexOf('t') == -1) { //열기
		$(this).attr('src', '/misc/img/btn_minus_white.svg');

		$('.moveZone').each(function() {
			var tSeq = $(this).attr('seq');
			if ($(this).hasClass(pSeq) && pSeq != tSeq) {
				$(this).slideDown(100);
			}
		})

	} else { //접기
		$(this).attr('src', '/misc/img/dashboard/dash_plus.svg');

		$('.moveZone').each(function() {
			var tSeq = $(this).attr('seq');
			if (pSeq == '1') { //전체접을때
				$('.hide').hide(); //열렸던거 싹접기
				$('.parentGroup').attr('src', '/misc/img/dashboard/dash_plus.svg'); //버튼이미지도 싹변경
			} else if($(this).hasClass(pSeq) && pSeq != tSeq) {
				$(this).hide();
			}
		})

	}

})

//부서 우클릭시(부서 수정/삭제/추가)
$(function() {
  //Show contextmenu:
  $('.moveZone').contextmenu(function(e){
		$('#input_li').hide();
    var target = e.target;
		var pSeq = $(target).attr('class').split(' ').splice(2, 1); //클릭한 부서의 부모seq
		var seq = $(target).attr('seq');

		if(seq == 1) { //두리안정보기술 우클릭시 추가만가능
			$('.modify').hide();$('.remove').hide();$('.add').show();
		} else if(pSeq == 1) { //depth1 우클릭시
			$('.modify').show();$('.remove').show();$('.add').show();
		} else { //depth2 우클릭시 추가는불가능
			$('.modify').show();$('.remove').show();$('.add').hide();
		}

    var gSeq = $(target).attr('seq'); //수정or추가할 부서 seq
		var gId = $(target).attr('id');
    $(".contextmenu").attr('seq', gSeq); //우클릭창에 넣어주기
		$(".contextmenu").attr('id', gId);

    //Get window size:
    var winWidth = $(document).width();
    var winHeight = $(document).height();
    //Get pointer position:
    var posX = e.pageX;
    var posY = e.pageY;
    //Get contextmenu size:
    var menuWidth = $(".contextmenu").width();
    var menuHeight = $(".contextmenu").height();
    //Security margin:
    var secMargin = 10;
    //Prevent page overflow:
    if(posX + menuWidth + secMargin >= winWidth
    && posY + menuHeight + secMargin >= winHeight){
      //Case 1: right-bottom overflow:
      posLeft = posX - menuWidth - secMargin + "px";
      posTop = posY - menuHeight - secMargin + "px";
    }
    else if(posX + menuWidth + secMargin >= winWidth){
      //Case 2: right overflow:
      posLeft = posX - menuWidth - secMargin + "px";
      posTop = posY + secMargin + "px";
    }
    else if(posY + menuHeight + secMargin >= winHeight){
      //Case 3: bottom overflow:
      posLeft = posX + secMargin + "px";
      posTop = posY - menuHeight - secMargin + "px";
    }
    else {
      //Case 4: default values:
      posLeft = posX + secMargin + "px";
      posTop = posY + secMargin + "px";
    };
    //Display contextmenu:
    $(".contextmenu").css({
      "left": posLeft,
      "top": posTop
    }).show();
    //Prevent browser default contextmenu.

    return false;
  });
  //Hide contextmenu:
	$(document).click(function(e) {
		var LayerPopup = $(".contextmenu");
		if(LayerPopup.has(e.target).length === 0){
			$(".contextmenu").hide();
		}
	})
	$('.contextmenu').click(function() {
	})
});

//부서 수정 or 추가 눌렀을때
function goSeq(select) {
  seq = $(select).attr('seq');
  $(".menu").attr('seq', seq);
	mId = $(select).closest('ul').attr('id');
	$("#name_input").val(''); //비워주기
	if(seq == 1) { //수정일때만 원래부서명 넣어주기
		$("#name_input").val(mId);
	}
}

//부서 수정 or 추가 저장 눌렀을때
function modifyGroup(select) {
  mode = $(".menu").attr('seq'); //수정인지 추가인지 구분
  mSeq = $(select).closest('ul').attr('seq'); //수정할 부서 seq
  mGroup = $("#name_input").val(); //새 부서명

    $.ajax({
     type: "POST",
     cache: false,
     url: "<?php echo site_url(); ?>/ajax/modifyGroup",
     dataType: "json",
     async :false,
     data: {
        seq : mSeq,
        group_name : mGroup,
        mode : mode
     },
     success: function (data) {
        if(data==true) {
          alert('저장되었습니다.');
          location.reload();
        } else {
          alert("저장에 실패하였습니다. 관리자에게 문의주세요.");
        }
      }
    });

}

//부서 삭제
function removeGroup(select) {
  mSeq = $(select).closest('ul').attr('seq'); //수정할 부서 seq
	mId = $(select).closest('ul').attr('id');
	var check = confirm(mId+"(을)를 삭제하시겠습니까?");

	if(check == true) {
	  $.ajax({
	   type: "POST",
	   cache: false,
	   url: "<?php echo site_url(); ?>/ajax/removeGroup",
	   dataType: "json",
	   async :false,
	   data: {
	      seq : mSeq
	   },
	   success: function (data) {
	      if(data==true) {
	        alert('삭제되었습니다.');
	        location.reload();
	      } else {
	        alert("삭제에 실패하였습니다. 관리자에게 문의주세요.");
	      }
	    }
	  });
	}

}

//움직이는거
function mboxmove(x) {
	var positionLeft = x.clientX;
	var positionTop = x.clientY;
	document.getElementById('move_box').style.left = (positionLeft + 5) + "px";
	document.getElementById('move_box').style.top = (positionTop) + "px";
}

function save_group_change() {
	var len = $('#group_change_tbl select').length;
	var result = 0;
	var check = confirm('선택한 부서로 부서 이동 하시겠습니까?');

	if(check) {
		$('#group_change_tbl select').each(function() {
			var changeSeq = $(this).attr('name');
			var selectGroup = $(this).val();

			$.ajax({
				type: "POST",
				cache: false,
				url: "<?php echo site_url(); ?>/ajax/changeGroup",
				dataType: "json",
				async: false,
				data: {
					seq: changeSeq,
					changeGroup: selectGroup
				},
				success: function(data) {
					if(data) {
						result++;
					}
				}
			})
		})

		if(result == len) {
			alert('정상적으로 처리 되었습니다.');
		} else {
			alert('정상적으로 처리되지 못했습니다.');
		}
		location.reload();
	}
}
</script>
</html>

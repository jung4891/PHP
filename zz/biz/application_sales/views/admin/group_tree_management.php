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
										<div class="btn">
											<input type="button" class="btn-common btn-color2" value="부서관리"  onClick="$('#group_management').bPopup();" style="float:left;margin-top:10px;margin-left:10px;" />
											<input type="button" class="groun_btn" value="사이트관리" onclick="$('#page_management').bPopup();"  style="float:left;display:none;">
										</div>
										<div class="tree_container">
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr>
													<td>
														<div>
															<div id="tree">
																<ul>
																	<li id="all">(주)두리안정보기술 (<?php echo $user_count[0]['cnt']; ?>)
																		<ul>
																			<?php
																			foreach ($parentGroup as $pg){
																				?>
																				<?php
																				if ($pg->childGroupNum==1 && $pg->depth==1){
																					?>
																						<?php foreach($parent_group_count as $pgc) {
																							if ($pg->parentGroupName == $pgc['parentGroupName']) {
																								echo "<li id=".$pg->parentGroupName.">".$pg->parentGroupName." (".$pgc['cnt'].")</li>";
																							}
																						}
																						?>
																					<?php
																				} else if ($pg->childGroupNum>1 && $pg->depth==1){
																					?>
																						<?php
																						foreach($parent_group_count as $pgc) {
																							if ($pg->parentGroupName == $pgc['parentGroupName']) {
																								echo "<li id=".$pg->parentGroupName.">".$pg->parentGroupName." (".$pgc['cnt'].")";
																							}
																						}
																						foreach ($user_group as $ug) {
																							if ($pg->parentGroupName==$ug->parentGroupName){
																								?>
																								<ul>
																									<?php
																									if ($ug->groupName != $pg->groupName){
																										foreach($user_group_count as $ugc){
																											if ($ug->groupName == $ugc['groupName']) {
																												echo "<li id=".$ug->groupName.">".$ug->groupName.' ('.$ugc['cnt'].')';
																												}
																											}
																										}
																										?>
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
													</td>
												</tr>
											</table>
										</div>
									</div>
									<div class="right">
										<div class="btn">
											<span id="chk_dept" style="float:left;font-weight:bold;font-size:17px;margin-left:10px;padding-top:16px;">두리안정보기술</span>
											<input type="button" class="btn-common btn-color1" value="부서이동" onclick="changeGroupBtn();" style="float:right;margin-top:10px;margin-right:10px;"></input>
											<input type="button" class="btn-common btn-color1" value="권한관리" style="float:right;margin-top:10px;margin-right:10px;" onclick="changeLevelBtn();"></input>
											<input type="button" class="btn-common btn-color1" value="부서별권한관리" style="width:120px;float:right;margin-top:10px;margin-right:10px;" onclick="$('#group_level_change').bPopup();"/>
										</div>
										<div class="list_container">
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<colgroup>
													<col width="3%">
													<col width="5%">
													<col width="8%">
													<col width="5%">
													<col width="12%">
													<col width="13%">
													<col width="3%">
													<col width="5%">
													<col width="8%">
													<col width="5%">
													<col width="12%">
													<col width="13%">
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
				<input style="float:right;" type="button" class="btn-common btn-color1" value="취소" onclick="$('#group_level_change').bPopup().close();">
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
			<input type="button" class="btn-common btn-color1" value="취소" onclick="$('#level_change').bPopup().close();">
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
		<div style="float:right;margin-bottom:10px;">
			<input type="button" class="btn-common btn-color1" value="취소" onclick="$('#group_change').bPopup().close();">
		</div>
	</div>
</div>


</body>
<script>
function changeGroupBtn() {
  var checkMember ="";
  $("input[name=checkMember]:checked").each(function(){
    checkMember += ',' + $(this).val() ;
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
							text += "<tr><td align='center'><select class='select-common' name='"+data[i].seq+"' onchange='changeGroup(this)' style='width:100%'>";
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

						text += '<td align="center" colspan="2"><input type="button" class="btn-common btn-color2" value="수정" onclick="changeUserPart('+data[i].seq+')"></td><tr height=20></tr>';
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

document.addEventListener("DOMContentLoaded", function() {
	$('#tree').jstree({
    "checkbox": {
      "keep_selected_style": false
    },
    'plugins': ["wholerow", "checkbox"],
    'core': {
      'themes': {
        'name': 'proton',
        "icons": false
      }
    },
  }).on('ready.jstree', function() {
		$(this).jstree("check_all");
	})

  $("#tree").bind("changed.jstree", function (e, data) {
    checked_group = [];
    var reg = /^[가-힣]*$/;
		var length = $("#tree").jstree("get_checked", true).length;
		var i = 1;

		if (length == 0) {
			$("#user_list").html('');
		}

    $.each($("#tree").jstree("get_checked", true), function () {
      checked_group.push(this.id);
			if (i == length) {
				user_list(checked_group);
			}
			i ++;
    })
  });
})

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
						list_text += '<tr class="border-b"><td height="50" style="padding-left:10px;"><input name="checkMember" type="checkbox" style="vertical-align:middle;" value="'+data[i].seq+'"></td><td><img src="<?php echo $misc; ?>img/dashboard/user.svg" width=40 style="vertical-align:middle"></td>';
						list_text += '<td style="font-weight:bold;color:#1C1C1C">'+data[i].user_name+' '+data[i].user_duty+'</td>';
						list_text += '<td style="font-weight:bold;color:#1C1C1C">'+data[i].user_group+'</td><td style="color:#626262">'+data[i].user_tel+'</td>';
						list_text += '<td class="border-r" style="color:#626262;">'+data[i].user_email+'</td>';
					} else {
						list_text += '<td style="padding-left:10px;"><input name="checkMember" type="checkbox" style="vertical-align:middle;" value="'+data[i].seq+'"></td><td><img src="<?php echo $misc; ?>img/dashboard/user.svg" width=40 style="vertical-align:middle"></td>';
						list_text += '<td style="font-weight:bold;color:#1C1C1C">'+data[i].user_name+' '+data[i].user_duty+'</td>';
						list_text += '<td style="font-weight:bold;color:#1C1C1C">'+data[i].user_group+'</td><td style="color:#626262">'+data[i].user_tel+'</td>';
						list_text += '<td style="color:#626262;">'+data[i].user_email+'</td></tr>';
					}

				}
				$("#user_list").html(list_text);
			}
		}
	})

}

</script>
</html>

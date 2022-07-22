<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<body>
	<?php
	  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	  ?>
	<meta name="viewport" content="width=device-width,height=device-width, initial-scale=1.0">
	<style>
	.menu_div {
		margin-top:10px;
		padding: 10px;
		border-bottom: thin #EFEFEF solid;
		overflow-x: scroll;
		white-space:nowrap;
	}
	.menu_div::-webkit-scrollbar {
		display: none;
	}
	.menu_list {
		cursor:pointer;margin:10px;font-weight:bold;font-size:15px;
	}
	.content_list {
		width:100%;
	 display: inline-block;
	 padding-bottom:20px;
	}
	.approval_list_tbl {
		padding-top: 20px;
		padding-left: 15px;
		padding-right:15px;
		border-spacing: 0 10px;
		table-layout: fixed;
	}
	.approval_list_tbl td {
		overflow:hidden;
		white-space : nowrap;
		text-overflow: ellipsis;
	}
	#paging_tbl {
		margin-top:10px;
		width:100%;
	}
	#paging_tbl a {
		font-size: 18px;
	}
	.input-common, .select-common, .btn-common {
		height: 35px !important;
		border-radius: 3px !important;
	}
	.dayBtn {
		background:url(<?php echo $misc; ?>img/mobile/footer_schedule.svg) no-repeat 98% 50% #fff;
		background-size: 20px;
	}
	</style>
	<script type="text/javascript">
	function moveList(page){
		 location.href="<?php echo site_url();?>/admin/account/"+page;
	}
	</script>
	<link rel="stylesheet" href="/misc/css/view_page_common.css">
	<style media="screen">
		.input-common, .select-common, .textarea-common {
			box-sizing: border-box;
			border-radius: 3px;
			width: 100%;
		}
	</style>
	<?php
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_side.php";
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_header.php";
  ?>

	<div class="menu_div">
		<a class="menu_list" onclick ="moveList('user')" style='color:#B0B0B0'>회원정보</a>
		<a class="menu_list" onclick ="moveList('group_tree_management')" style='color:#0575E6'>조직도관리</a>
		<?php
		if($admin_lv == 3) {
			?>
		<button id="bye_btn" type="button" name="button" class="btn-common btn-color1" style="display:none; width:auto; float:right;height:auto !important;" onclick="change_list('bye')">미권한자 목록</button>
		<button id="hi_btn" type="button" name="button" class="btn-common btn-color1" style="display:none; width:auto; float:right; height:auto !important;" onclick="change_list('hi')">회원 목록</button>
		<?php
			}
		?>
	</div>

	<div class="content_list">
		<table class="approval_list_tbl" width="100%" border="0" cellspacing="0" cellpadding="0">
			<colgroup>
				<col width="60%">
				<col width="40%">
			</colgroup>
			<tbody id="user_list"></tbody>
		</table>
	</div>

	<!-- 검색 모달 시작 -->
  <!-- <div id="search_div" style="height:auto;width:100%;background-color:#ffffff; display:none;border-radius:5px;">
    <div class="modal_contain" style="font-size:16px; color:#1C1C1C;font-weight:bold;">
      <table style="width:100%;padding:5%;" cellspacing="0">
				<colgroup>
					<col width="50%">
					<col width="50%">
				</colgroup>
				<tr>
      		<td align="left" height="40">
						<select class="select-common" name="search2" id="search_select2" style="margin-right:10px;color:black;width:92%;">
							<option value="001" <?php if($search2 == "001"){ echo "selected";}?>>회사명</option>
							<option value="002" <?php if($search2 == "002"){ echo "selected";}?>>아이디</option>
							<option value="003" <?php if($search2 == "003"){ echo "selected";}?>>사업자등록번호</option>
							<option value="004" <?php if($search2 == "004"){ echo "selected";}?>>이름</option>
							<option value="005" <?php if($search2 == "005"){ echo "selected";}?>>이메일</option>
						</select>
					</td>
      	</tr>
				<tr>
					<td colspan="2">
						<input type="text" id="searchkeyword_input" class="input-common" placeholder="검색하세요." value="<?php echo str_replace('"', '&uml;', $search_keyword );?>" style=";width:95%;" />
					</td>
				</tr>
				<tr>
          <td height="20"></td>
        </tr>
				<tr>
					<td>
						<input type="button" class="btn-common btn-color1" style="width:95%" value="취소" onclick="$('#search_div').bPopup().close();">
					</td>
					<td align="right">
						<input type="button" class="btn-common btn-color2" style="width:95%" value="검색" onclick="return GoSearch();">
					</td>
				</tr>
      </table>
    </div>
  </div> -->
	<!-- 검색 모달 끝 -->

	<!-- 부서별 권한 관리 모달 -->
	<div id="group_level_change" style="display:none; position: absolute; background-color: white; width:100%; height: auto;">
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
					<col width="10%">
					<col width="50%">
				</colgroup>
		    <!-- <tr><td style="text-align:center;">부서</td><td style="text-align:center;">권한</td></tr> -->
		    <tr>
		      <th height="40" bgcolor="f8f8f9">부서</th>
		      <th colspan="2" height="40" bgcolor="f8f8f9">권한</th>
		    </tr>
		    <tr height="20px"></tr>
		    <tr>
		      <td style="padding-left:10px;text-align: -webkit-center;">
		        <select id="glc_group_level" name="group" class="select-common" style="width:100px;" >
		        </select>
		      </td>
		      <td colspan="2" id="userPart" style="text-align: -webkit-center;">
		        <div>
		          <select name="glc_user_part1" id="glc_user_part1" class="select-common" style="width:70px;">
		          <?php
							$part = array('비즈', '영업', '기술', '관리');
							for($i=0; $i<count($part); $i++){ ?>
		            <option value="<?php echo $i+1;?>"><?php echo $part[$i]; ?></option>
		          <?php } ?>
		          </select>
		          <select name="glc_user_part2" id="glc_user_part2" class="select-common" style="width:90px;">
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
				<td colspan="2">
					<input style="width:95%;" type="button" class="btn-common btn-color1" value="취소" onclick="$('#group_level_change').bPopup().close();">
				</td>
				<td>
					<input style="width:95%;" type="button" class="btn-common btn-color2" value="권한부여" onclick="groupLevelChange();">
				</td>
			</tr>
			<tr height="30px"></tr>
		  </table>
		</div>
	</div>

	<!-- 권한 관리 모달 -->
	<div id="level_change" style="display:none; position: absolute; background-color: white; width: 100%; height: auto;">
		<div style="width:90%;margin: 0 auto;">
			<table width="100%" style="font-family:Noto Sans KR;font-size:13px;">
				<colgroup>
					<col width="50%">
					<col width="50%">
				</colgroup>
				<tbody id="checkMember"></tbody>
			</table>
		</div>
	</div>
	<!-- 권한 관리 모달 -->
	<div id="group_change" style="display:none; position: absolute; background-color: white; width: 200px; height: auto;">
		<div style="width:90%;margin: 0 auto;">
			<table width="100%" style="font-family:Noto Sans KR;font-size:13px;margin-top:20px;">
				<tbody id="group_change_tbl">
				</tbody>
			</table>
			<div style="margin-bottom:10px;">
				<input type="button" class="btn-common btn-color1" style="width:100%;" value="취소" onclick="$('#group_change').bPopup().close();">
			</div>
		</div>
	</div>


	<div style="width:90%;margin:0 auto;padding-bottom:60px;">
    <?php if($admin_lv == 3) { ?>
			<input type="button" class="btn-common btn-color1" value="부서별권한관리" style="text-align:center;width:auto;margin-right:10px;" onclick="$('#group_level_change').bPopup();"/>
			<input type="button" class="btn-common btn-color1" value="권한관리" style="margin-right:10px;" onclick="changeLevelBtn();"></input>
			<input type="button" class="btn-common btn-color1" value="부서이동" onclick="changeGroupBtn();"></input>
    <?php } ?>
	</div>
	<div style="width:90%;padding-left:10px;padding-bottom:60px;">
		<!-- <span style="color:red;margin-right:5px;">*</span><?php echo $title; ?> 검색 시 우측 하단에 검색 아이콘을 눌러주세요. -->
	</div>
	<?php include $this->input->server('DOCUMENT_ROOT')."/include/mobile_bottom.php"; ?>
	<div style="position:fixed;bottom:50px;right:5px;">
			<img src="<?php echo $misc; ?>img/mobile/btn_top.svg" onclick="$('html').scrollTop(0);">
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
							text += "<tr style='height:50px;'><td align='center' style='font-weight:bold;color:#0575E6;font-size:14px;'>"+data[i].user_name+"</td></tr>"
							text += "<tr><td align='center' style='color:#3C3C3C'>"+data[i].user_tel+"</td></tr>"
							text += "<tr><td align='center' style='color:#B0B0B0'>"+data[i].user_email+"</td></tr>"
							text += "<tr><td align='center'><select style='margin-top:10px;' class='select-common' name='"+data[i].seq+"' onchange='changeGroup(this)' style='width:100%'>";
							for(j=0; j<result.length; j++){
								if(result[j].groupName == data[i].user_group){
									text += "<option value='"+result[j].groupName+"' selected='selected'>"+result[j].groupName+"</option>"
								}else{
									text += "<option value='"+result[j].groupName+"'>"+result[j].groupName+"</option>"
								}
							}
							text += "</select></tr></td>";
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
            text += '<tr>';
            text += '<td align="left" colspan="2"><select name="'+data[i].seq+'" id="user_part2" class="select-common" style="width:100%">'
            text += '<option value=0'
            // alert(<?php echo $i; ?>)
            if((data[i].user_part).substr(<?php echo $i; ?>,1) == "0"){
              text += " selected";
            }
            text += '><?php echo $part[$i];?> 권한없음</option><option value=1'
            if((data[i].user_part).substr(<?php echo $i; ?>,1) == "1"){
              text += " selected";
            }
            text += '><?php echo $part[$i];?> 일반</option><option value=2'
            if((data[i].user_part).substr(<?php echo $i; ?>,1) == "2"){
              text += " selected";
            }
            text += '><?php echo $part[$i];?> 팀관리자</option><option value=3'
            if((data[i].user_part).substr(<?php echo $i; ?>,1) == "3"){
              text += " selected";
            }
            text += '><?php echo $part[$i];?> 관리자</option></select></td></tr>'
          <?php } ?>

						text += '<td><input type="button" class="btn-common btn-color1" value="취소" onclick="$('+"'#level_change'"+').bPopup().close();" style="width:95%"></td><td><input type="button" class="btn-common btn-color2" value="수정" onclick="changeUserPart('+data[i].seq+')" style="width:95%"></td><tr height=20></tr>';
						$("#checkMember").html(text);

						$("#level_change").bPopup();
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

$(function() {
	user_list();
})

function user_list(){
	$.ajax({
		type:"POST",
		cache: false,
		url: "<?php echo site_url(); ?>/admin/account/management_user_list",
		dataType: 'json',
		async: false,
		data : {
			checked_group: ['all']
		},
		success: function(data) {
			if(data) {
				var list_text = '';
				for(i=0; i<data.length; i++) {
					// if(i%2 == 0) {
					// 	list_text += '<tr class="border-b"><td height="50" style="padding-left:10px;"><input name="checkMember" type="checkbox" style="vertical-align:middle;" value="'+data[i].seq+'"></td><td><img src="<?php echo $misc; ?>img/dashboard/user.svg" width=40 style="vertical-align:middle"></td>';
					// 	list_text += '<td style="font-weight:bold;color:#1C1C1C">'+data[i].user_name+' '+data[i].user_duty+'</td>';
					// 	list_text += '<td style="font-weight:bold;color:#1C1C1C">'+data[i].user_group+'</td><td style="color:#626262">'+data[i].user_tel+'</td>';
					// 	list_text += '<td class="border-r" style="color:#626262;">'+data[i].user_email+'</td>';
					// } else {
					// 	list_text += '<td style="padding-left:10px;"><input name="checkMember" type="checkbox" style="vertical-align:middle;" value="'+data[i].seq+'"></td><td><img src="<?php echo $misc; ?>img/dashboard/user.svg" width=40 style="vertical-align:middle"></td>';
					// 	list_text += '<td style="font-weight:bold;color:#1C1C1C">'+data[i].user_name+' '+data[i].user_duty+'</td>';
					// 	list_text += '<td style="font-weight:bold;color:#1C1C1C">'+data[i].user_group+'</td><td style="color:#626262">'+data[i].user_tel+'</td>';
					// 	list_text += '<td style="color:#626262;">'+data[i].user_email+'</td></tr>';
					// }
					list_text += '<tr>';
					list_text += '<td rowspan="2" align="left" style="color:#1C1C1C;font-weight:bold"><input name="checkMember" type="checkbox" style="vertical-align:middle;" value="'+data[i].seq+'"><img src="<?php echo $misc; ?>img/dashboard/user.svg" width=40 style="vertical-align:middle">'+' '+data[i].user_name+' '+data[i].user_duty+' '+data[i].user_group+'</td>';
					list_text += '<td align="right" style="color:#A1A1A1;">'+data[i].user_email+'</td>';
					list_text += '</tr>';
					list_text += '<tr>';
					list_text += '<td align="right" style="color:#1C1C1C">'+data[i].user_tel+'</td>';
					list_text += '</tr>';
					list_text += '<tr><td height="1" colspan="2" bgcolor="#EFEFEF"></td></tr>';
				}
				$("#user_list").html(list_text);

				$('input[type=checkbox][name=checkMember]').click(function(){
					if($(this).prop('checked')) {
						$('input[type="checkbox"][name="checkMember"]').prop('checked', false);
						$(this).prop('checked', true);
					}
				})
			}
		}
	})

}

</script>

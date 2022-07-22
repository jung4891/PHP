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
	<link rel="stylesheet" href="/misc/css/view_page_common.css">
	<style media="screen">
		.input-common, .select-common, .textarea-common {
			box-sizing: border-box;
			border-radius: 3px;
			width: 100%;
		}
	</style>
  <script language="javascript">
    function GoSearch(){
    $('#searchkeyword').val($.trim($('#searchkeyword_input').val()));
  	$('#search2').val($('#search_select2').val());

     var searchkeyword = document.mform.searchkeyword.value;
     var searchkeyword = searchkeyword.trim();

  document.mform.action = "<?php echo site_url();?>/admin/account/user";
  document.mform.cur_page.value = "";
  //	document.mform.search_keyword.value = searchkeyword;
  document.mform.submit();
  }

	function change_list(type){
		if (type == "bye") {

				document.mform.resignation.value = "y";
		}else{
				document.mform.resignation.value = "n";
		}
		document.mform.searchkeyword.value = "";
		document.mform.action = "<?php echo site_url();?>/admin/account/user";
		document.mform.cur_page.value = "";
		document.mform.submit();
	}

	$(document).ready(function(){

		<?php if($resignation=="y"){ ?>
			$("#bye_btn").hide();
			$("#hi_btn").show();
			<?php }else{ ?>
				$("#bye_btn").show();
				$("#hi_btn").hide();
				<?php } ?>

	});

	function moveList(page){
		 location.href="<?php echo site_url();?>/admin/account/"+page;
	}

  </script>
	<?php
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_side.php";
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_header.php";
  ?>
	<form name="mform" action="<?php echo site_url();?>/admin/account/user" method="get" onkeydown="if(event.keyCode==13) return GoSearch();">
	<input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
	<input type="hidden" name="seq" value="">
	<input type="hidden" name="mode" value="">
	<input type="hidden" name="resignation" value="<?php echo $resignation; ?>">
      <input type="hidden" name="searchkeyword" id="searchkeyword" value="<?php echo str_replace('"', '&uml;',$search_keyword); ?>" />
 	   <input type="hidden" name="search2" id="search2" value="<?php echo $search2; ?>" />

	<div class="menu_div">
		<a class="menu_list" onclick ="moveList('user')" style='color:#0575E6'>회원정보</a>
		<a class="menu_list" onclick ="moveList('group_tree_management')" style='color:#B0B0B0'>조직도관리</a>
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
				<col width="50%">
				<col width="50%">
			</colgroup>
			<tbody>
<?php foreach ($list_val as $item) { ?>
				<tr onclick="ViewBoard('<?php echo $item['seq'];?>')">
					<td align="left" style="color:#A1A1A1;"><?php echo $item['company_name']; ?></td>
					<td align="right" style="color:#A1A1A1;"><?php echo $item['user_tel']; ?></td>
				</tr>
				<tr onclick="ViewBoard('<?php echo $item['seq'];?>')">
					<td align="left" style="color:#1C1C1C;font-weight:bold;"><?php echo $item['user_name'].' '.$item['user_duty']; ?></td>
					<td align="right" style="color:#1C1C1C;font-weight:bold;"><?php echo $item['user_group']; ?></td>
				</tr>
				<tr><td height="1" colspan="2" bgcolor="#EFEFEF"></td></tr>
<?php } ?>
<?php if($count == 0) { ?>
				<tr>
					<td colspan="2" align="center" height="40" style="font-weight:bold;">등록된 게시물이 없습니다.</td>
				</tr>
<?php } ?>
			</tbody>
		</table>

		<!-- 페이징 -->
		<table id="paging_tbl" cellspacing="0" cellpadding="0">
		  <!-- 페이징처리 -->
		  <tr>
		     <td align="center">
		     <?php if ($count > 0) {?>
		           <table border="0" cellspacing="0" cellpadding="0">
		                 <tr>
		           <?php
		              if ($cur_page > 10){
		           ?>
		                 <td width="19"><a href="JavaScript:GoFirstPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_first.png" width="20" height="20"/></a></td>
		                 <td width="2"></td>
		                 <td width="19"><a href="JavaScript:GoPrevPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_left.png" width="20" height="20"/></a></td>
		           <?php
		              } else {
		           ?>
		              <td width="19"></td>
		                 <td width="2"></td>
		                 <td width="19"></td>
		           <?php
		              }
		           ?>
		                 <td align="center">
		              <?php
		                 for  ( $i = $start_page; $i <= $end_page ; $i++ ){
		                    if( $i == $end_page ) {
		                       $strSection = "";
		                    } else {
		                       $strSection = "&nbsp;<span class=\"section\">&nbsp&nbsp</span>&nbsp;";
		                    }

		                    if  ( $i == $cur_page ) {
		                       echo "<a href=\"JavaScript:GoPage( '".$i."' )\" class=\"alink\"><font color=\"#33ccff\">".$i."</font></a>".$strSection;
		                    } else {
		                       echo "<a href=\"JavaScript:GoPage( '".$i."' )\" class=\"alink\">".$i."</a>".$strSection;
		                    }
		                 }
		              ?></td>
		                 <?php
		                 if   ( floor( ( $cur_page - 1 ) / 10 ) < floor( ( $total_page - 1 ) / 10 ) ){
		              ?>
		              <td width="19"><a href="JavaScript:GoNextPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_right.png" width="20" height="20"/></a></td>
		                 <td width="2"></td>
		                 <td width="19"><a href="JavaScript:GoLastPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_last.png" width="20" height="20"/></a></td>
		              <?php
		                 } else {
		              ?>
		              <td width="19"></td>
		                 <td width="2"></td>
		                 <td width="19"></td>
		              <?php
		                 }
		              ?>
		                 </tr>
		              </table>
		     <?php }?>
		           </td>
		     </tr>
		  <!-- 페이징처리끝 -->
		</table>
	</div>

	<!-- 검색 모달 시작 -->
  <div id="search_div" style="height:auto;width:100%;background-color:#ffffff; display:none;border-radius:5px;">
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
  </div>
	<!-- 검색 모달 끝 -->
</form>

<!-- 추가 모달 시작 -->
<div id="user_input" style="height:auto;width:100%;background-color:#ffffff; display:none;border-radius:5px;">
	<div class="modal_contain" style="font-size:16px; color:#1C1C1C;font-weight:bold;">
		<form name="cform" action="<?php echo site_url();?>/admin/account/user_input_action" method="get" onSubmit="javascript:chkForm();return false;">
			<input type="hidden" name="user_part" value="">
			<table style="width:100%;padding:5%;" cellspacing="0">
				<colgroup>
					<col width="50%">
					<col width="50%">
				</colgroup>
				<tr>
					<td colspan="2" align="left" height="40">회원구분</td>
				</tr>
				<tr>
					<td colspan="2">
						<?php
						$part = array("비즈", "영업", "기술", "관리");
						for($i=0; $i<count($part); $i++){ ?>
							<input type="hidden" name="user_part1" id="page<?php echo ($i+1) ;?>" value="<?php echo $part[$i];?>" style="display:inline-block;text-align:center">
							<select name="user_part2" id="user_part2" class="select-common" <?php if($i!=0){echo 'style="margin-top:5px;"';} ?>>
								<option value=0>권한없음(<?php echo $part[$i];?>)</option>
								<option value=1>일반(<?php echo $part[$i];?>)</option>
								<option value=2>팀관리자(<?php echo $part[$i];?>)</option>
								<option value=3>관리자(<?php echo $part[$i];?>)</option>
							</select><br>
						<?php } ?>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="left" height="40">승인요청</td>
				</tr>
				<tr>
					<td colspan="2">
						<select name="confirm_flag" id="confirm_flag" class="select-common">
							<option value="Y">승인</option>
							<option value="N">미승인</option>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="left" height="40">아이디</td>
				</tr>
				<tr>
					<td colspan="2">
						<input name="user_id" type="text" class="input-common" id="user_id" onchange="idcheck()" placeholder="3자~12자의 영문,숫자만 사용"/>
						<input type="hidden" id="id_check" value="N">
					</td>
				</tr>
				<tr>
					<td colspan="2" align="left" height="40">비밀번호</td>
				</tr>
				<tr>
					<td colspan="2">
						<input name="user_password" type="password" class="input-common" id="user_password"/>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="left" height="40">회사명</td>
				</tr>
				<tr>
					<td colspan="2">
						<input name="company_name" type="text" class="input-common" id="company_name"/>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="left" height="40">사업자등록번호</td>
				</tr>
				<tr>
					<td colspan="2">
						<input name="company_num" type="text" class="input-common" id="company_num" onclick="checkNum(this);" onKeyUp="checkNum(this);" maxlength="10"/>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="left" height="40">이름</td>
				</tr>
				<tr>
					<td colspan="2">
						<input name="user_name" type="text" class="input-common" id="user_name"/>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="left" height="40">직급</td>
				</tr>
				<tr>
					<td colspan="2">
						<input name="user_duty" type="text" class="input-common" id="user_duty"/>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="left" height="40">부서</td>
				</tr>
				<tr>
					<td colspan="2">
						<select name="user_group" id="user_group" class="select-common">
							<?php foreach($groupList as $group){ ?>
								<option value="<?php echo $group['groupName']; ?>"><?php echo $group['groupName']; ?></option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="left" height="40">이메일</td>
				</tr>
				<tr>
					<td colspan="2">
						<input name="user_email" type="text" class="input-common" id="user_email"/>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="left" height="40">연락처</td>
				</tr>
				<tr>
					<td colspan="2">
						<input name="user_tel" type="text" class="input-common" id="user_tel"/>
					</td>
				</tr>
				<tr>
					<td height="20"></td>
				</tr>
				<tr>
					<td>
						<input type="button" class="btn-common btn-color1" style="width:95%" value="취소" onclick="$('#user_input').bPopup().close();">
					</td>
					<td align="right">
						<input type="button" class="btn-common btn-color2" style="width:95%" value="등록" onclick="javascript:chkForm();return false;">
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>


	<div style="width:90%;margin:0 auto;margin-bottom:10px;">
    <?php if($admin_lv == 3) { ?>
			<input class="btn-common btn-color2" style="width:100%;" type="button" onclick="$('#user_input').bPopup();" value="추가" >
    <?php } ?>
	</div>
	<div style="width:90%;padding-left:10px;padding-bottom:60px;">
		<span style="color:red;margin-right:5px;">*</span><?php echo $title; ?> 검색 시 우측 하단에 검색 아이콘을 눌러주세요.
	</div>
	<?php include $this->input->server('DOCUMENT_ROOT')."/include/mobile_bottom.php"; ?>
  <script language="javascript">
    function GoFirstPage (){
     document.mform.cur_page.value = 1;
     document.mform.submit();
   }

   function GoPrevPage (){
     var	cur_start_page = <?php echo $cur_page;?>;

     document.mform.cur_page.value = Math.floor( ( cur_start_page - 11 ) / 10 ) * 10 + 1;
     document.mform.submit( );
   }

   function GoPage(nPage){
     document.mform.cur_page.value = nPage;
     document.mform.submit();
   }

   function GoNextPage (){
     var	cur_start_page = <?php echo $cur_page;?>;

     document.mform.cur_page.value = Math.floor( ( cur_start_page + 9 ) / 10 ) * 10 + 1;
     document.mform.submit();
   }

   function GoLastPage (){
     var	total_page = <?php echo $total_page;?>;
  //	alert(total_page);

  document.mform.cur_page.value = total_page;
  document.mform.submit();
  }

  function ViewBoard (seq){
  	document.mform.action = "<?php echo site_url();?>/admin/account/user_view";
  	document.mform.seq.value = seq;
  	document.mform.mode.value = "modify";

  	document.mform.submit();
  }

  function open_search() {
  	$('#search_div').bPopup();
  }
  $(window).bind("pageshow", function(event) {
    if (event.originalEvent.persisted) {
        document.location.reload();
    }
  });

	function checkNum(obj) {
		var word = obj.value;
		var str = "1234567890";
		for (i=0;i< word.length;i++){
			if(str.indexOf(word.charAt(i)) < 0){
				alert("숫자 조합만 가능합니다.");
				obj.value="";
				obj.focus();
				return false;
			}
		}
	}

	function idcheck(){
		var uid =  $("#user_id").val();
	//	return;
		$.ajax({
			type: "POST",
			cache:false,
			url: "<?php echo site_url();?>/ajax/idcheck",
			dataType: "json",
			async: false,
			data: {id: uid},
			success: function(data){
				if(data.result == "true"){
					$("#id_check").val("Y");
					alert('중복되는 아이디가 있습니다.');
					$("#user_id").focus();
					// document.getElementById("id_message").innerHTML = "<font color=red><span id='id_message'><span class='error_1'>* 중복되는 아이디가 있습니다</span></span></font>";
				} else {
					$("#id_check").val("N");
					// alert('3자~12자의 영문,숫자만 사용가능합니다.');
					// $("#user_id").focus();
					// document.getElementById("id_message").innerHTML = "<span id='id_message'><span class='error_1'>* 3자~12자의 영문,숫자만 사용</span></span>";
				}
			}
		});
	}

	function chkForm () {
		var mform = document.cform;
	  var userPart = '';

	  //11을 011로 자릿수에 맞춰주는 함수
	  function pad(n, width) {
	    n = n + '';
	    return n.length >= width ? n : new Array(width - n.length + 1).join('0') + n;
	  }

	  for(i=0; i<document.getElementsByName('user_part1').length; i++){
	    userPart = userPart+document.getElementsByName('user_part2')[i].value;
	  }


	  mform.user_part.value = pad(userPart,3);

		if (mform.user_id.value == "") {
			mform.user_id.focus();
			alert("아이디를 입력해 주세요.");
			return false;
		}
		if ($("#id_check").val()=="Y"){
			mform.user_id.focus();
			alert("아이디가 중복되었습니다.");
			return false;
		}
		if (mform.user_password.value == "") {
			mform.user_password.focus();
			alert("패스워드를 입력해 주세요.");
			return false;
		}
		if ( !passwordvalidcheck( mform.user_password.value ) ){		//	패스워드 길이가 6보다 작거나, 숫자만 입력된 경우
			alert( "보안수준이 안전한 비밀번호를 입력해 주세요.\n\n(6자 이상의 영문,숫자,특수문자 조합)" );
			mform.user_password.value = "";
			mform.user_password.focus();
			return;
		}
		if (mform.company_name.value == "") {
			mform.company_name.focus();
			alert("회사명을 입력해 주세요.");
			return false;
		}
		if (mform.company_num.value == "") {
			mform.company_num.focus();
			alert("사업자등록번호를 입력해 주세요.");
			return false;
		}
		if (mform.user_name.value == "") {
			mform.user_name.focus();
			alert("이름을 입력해 주세요.");
			return false;
		}
		if (mform.user_duty.value == "") {
			mform.user_duty.focus();
			alert("직급을 입력해 주세요.");
			return false;
		}
		if (mform.user_email.value == "") {
			mform.user_email.focus();
			alert("이메일을 입력해 주세요.");
			return false;
		}
		var regex=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
		if(regex.test(mform.user_email.value) === false) {
			alert("잘못된 이메일 형식입니다.");
			mform.user_email.focus();
			return false;
		}
		if (mform.user_tel.value == "") {
			mform.user_tel.focus();
			alert("전화번호를 입력해 주세요.");
			return false;
		}

		// if (c == "004") {
		// 	mform.user_level.value = "3";
		// } else {
		// 	mform.user_level.value = "1";
		// }

		mform.submit();
		return false;
	}
  </script>
</body>

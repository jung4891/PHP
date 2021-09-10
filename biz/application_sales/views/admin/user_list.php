<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<script type="text/javascript" src="/misc/js/jquery.bpopup-0.1.1.min.js"></script>
<script language="javascript">
function GoSearch(){
	var searchkeyword = document.mform.searchkeyword.value;
	var searchkeyword = searchkeyword.trim();

	if(searchkeyword == ""){
		alert( "검색어를 입력해 주세요." );
		return false;
	}

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


</script>
<body>
<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
<div align="center">
  <div class="dash1-1">
		<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" style="width:95%">
			<form name="mform" action="<?php echo site_url();?>/admin/account/user" method="get" onkeydown="if(event.keyCode==13) return GoSearch();">
			<input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
			<input type="hidden" name="seq" value="">
			<input type="hidden" name="mode" value="">
			<input type="hidden" name="resignation" value="<?php echo $resignation; ?>">
			<tbody height="100%">
			<!-- 타이틀 부분 시작 -->
				<tr height="5%">
				  <td class="dash_title">
						회원정보
					</td>
					<tr>
						<td height="70"></td>
					</tr>
				</tr>
				<!-- 타이틀 부분 끝 -->
				<!-- 검색 부분 시작 -->
        <tr height="10%">
          <td align="left" valign="bottom">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td>
              <!-- 검색창 -->
									<select name="search2" id="search2" class="select-common" style="margin-right:10px; width:140px;">
									 <option value="001" <?php if($search2 == "001"){ echo "selected";}?>>회사명</option>
									 <option value="002" <?php if($search2 == "002"){ echo "selected";}?>>아이디</option>
									 <option value="003" <?php if($search2 == "003"){ echo "selected";}?>>사업자등록번호</option>
									 <option value="004" <?php if($search2 == "004"){ echo "selected";}?>>이름</option>
									 <option value="005" <?php if($search2 == "005"){ echo "selected";}?>>이메일</option>
					  		 </select>
                  <span>
										<input type="text" style="margin-right:10px; width:240px;" class="input-common" name="searchkeyword" placeholder="검색하세요." value="<?php echo str_replace('"', '&uml;', $search_keyword );?>"/>
									</span>
                  <span>
										<input class="btn-common btn-style1" type="button" onclick="return GoSearch();" value="검색" >
                  </span>
								</td>
								<td align="right">
									<?php
									if($admin_lv == 3) {
										?>
									<button id="bye_btn" type="button" name="button" class="btn-common btn-color1" style="display:none; margin-right:10px; width:100px;" onclick="change_list('bye')">미권한자 목록</button>
									<button id="hi_btn" type="button" name="button" class="btn-common btn-color1" style="display:none; margin-right:10px; width:100px;" onclick="change_list('hi')">회원 목록</button>
											<input class="btn-common btn-color2" type="button" onclick="$('#user_input').bPopup();" value="추가" >
									<?php
										}
									?>
								</td>

							</tr>
		      	</table>
		  		</td>
				</tr>
				<!-- 콘텐트시작 -->
				<tr height="45%">
					<td valign="top" style="padding:15px 0px 15px 0px">
						<table class="content_dash_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td align="center" valign="top">
									<tr>
										<td>
											<table class="month_tbl" width="100%" border="0" cellspacing="0" cellpadding="0">
												<colgroup>
													<col width="15%" />
													<col width="3.5%" />
			                    <col width="7%" />
			                    <col width="7%" />
			                    <col width="7%" />
			                    <col width="7%" />
			                    <col width="7%" />
			                    <col width="3.5%" />
			                    <col width="10.5%" />
			                    <col width="7%" />
			                    <col width="3.5%" />
			                    <col width="15%" />
	                  		</colgroup>
			                  <tr class="t_top row-color1">
													<th></th>
													<!-- <th height="40" align="center">No.</th> -->
													<th height="40" align="center">번호</td>
			                    <!-- <td align="center">구분</td> -->
			                    <th align="center">회사명</th>
			                    <th align="center">부서</th>
			                    <th align="center">아이디</th>
													<th align="center">사업자등록번호</th>
			                    <th align="center">이름</th>
			                    <th align="center">직급/직책</th>
			                    <th align="center">이메일</th>
			                    <th align="center">연락처</th>
			                    <th align="center">승인여부</th>
													<th></th>
			                  </tr>
<?php
	if ($count > 0) {
		$i = $count - $no_page_list * ( $cur_page - 1 );
		$icounter = 0;

		foreach ( $list_val as $item ) {
			if($item['user_part'] == "001") {
				$strPart = "영업";
			} else if($item['user_part'] == "002") {
				$strPart = "기술";
			} else if($item['user_part'] == "003") {
				$strPart = "고객사";
			} else {
				$strPart = "관리자";
			}

			if($item['confirm_flag'] == "Y") {
				$strConfirm = "승인";
			} else if($item['confirm_flag'] == "N") {
				$strConfirm = "미승인";
			}
?>
			                 <tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'" style="cursor:pointer" onclick="ViewBoard('<?php echo $item['seq'];?>')">
												  <td></td>
													<td height="40" align="center"><?php echo $i;?></td>
			                    <!-- <td  align="center"><?php echo $strPart;?></td> -->
			                    <td align="center"><?php echo $item['company_name'];?></td>
			                    <td align="center"><?php echo $item['user_group'];?></td>
			                    <td align="center"><?php echo $item['user_id'];?></td>
			                    <td align="center"><?php echo $item['company_num'];?></td>
			                    <td align="center"><?php echo $item['user_name'];?></td>
			                    <td align="center"><?php echo $item['user_duty'];?></td>
			                    <td align="center"><?php echo $item['user_email'];?></td>
			                    <td align="center"><?php echo $item['user_tel'];?></td>
			                    <td align="center"><?php echo $strConfirm;?></td>
													<td></td>
			                  </tr>
<?php
			$i--;
			$icounter++;
		}
	} else {
?>
												<tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'">
	                    		<td width="100%" height="40" align="center" colspan="13">등록된 게시물이 없습니다.</td>
			                  </tr>
<?php
	}
?>
	                		</table>
										</td>
			            </tr>
	              <!--//리스트-->
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
</script>
								</td>
							</tr>
						</table>
					</td>
				</tr>
<!-- 컨텐트 테이블 끝 -->
			  <tr height="40%">
        	<td align="left" valign="top">
						<table width="100%" cellspacing="0" cellpadding="0">
				    	<tr>
				      	<td width="19%">
				        	<tr height="20%">
				          	<td colspan="10" align="center" valign="top">
<?php
	if ($count > 0) {
?>
											<table width="400" border="0" cellspacing="0" cellpadding="0">
                  		<tr>
<?php
		if ($cur_page > 10){
?>
		                    <td width="19">
													<a href="JavaScript:GoFirstPage()">
														<img src="<?php echo $misc;?>img/dashboard/btn/btn_first.png"  width="20" height="20"/>
													</a>
												</td>
		                    <td width="2"></td>
		                    <td width="19">
													<a href="JavaScript:GoPrevPage()">
														<img src="<?php echo $misc;?>img/dashboard/btn/btn_left.png"  width="20" height="20"/>
													</a>
												</td>
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
				$strSection = "&nbsp;<span class=\"section\">&nbsp;&nbsp;</span>&nbsp;";
			}

			if  ( $i == $cur_page ) {
				echo "<a href=\"JavaScript:GoPage( '".$i."' )\" class=\"alink\"><font color=\"#33ccff\">".$i."</font></a>".$strSection;
			} else {
				echo "<a href=\"JavaScript:GoPage( '".$i."' )\" class=\"alink\">".$i."</a>".$strSection;
			}
		}
?>
												</td>
<?php
		if   ( floor( ( $cur_page - 1 ) / 10 ) < floor( ( $total_page - 1 ) / 10 ) ){
?>
												<td width="19">
													<a href="JavaScript:GoNextPage()">
														<img src="<?php echo $misc;?>img/dashboard/btn/btn_right.png" width="20" height="20"/>
													</a>
												</td>
		                    <td width="2"></td>
		                    <td width="19">
													<a href="JavaScript:GoLastPage()">
														<img src="<?php echo $misc;?>img/dashboard/btn/btn_last.png" width="20" height="20"/>
													</a>
												</td>
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
<?php
	}
?>
										</td>
            			</tr>
              <!--//페이징-->
            		</td>
			        </tr>

			      </table>
		      </td>
		    </tr>
			</form>
		</table>
	</div>
</div>
<!--하단-->
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
<!--//하단-->

<!-- 회원 추가 모달 시작 -->
<div id="user_input" style="display:none; position: absolute; background-color: white; width: 540px; height: 620px; border-radius:5px;">
  <form name="cform" action="<?php echo site_url();?>/admin/account/user_input_action" method="get" onSubmit="javascript:chkForm();return false;">
	<input type="hidden" name="user_part" value="">
		<table style="margin:10px 30px; border-collapse: separate; border-spacing: 0 30px;">
    <!-- <table width="320" height="100%" style="padding:20px 18px;" border="0" cellspacing="0" cellpadding="0"> -->
			<colgroup>
				<col width="15%" />
				<col width="35%" />
				<col width="20%" />
				<col width="30%" />
			</colgroup>
      <tr>
				<td colspan="4" class="modal_title" align="left" style="padding-bottom:10px; font-size:20px; font-weight:bold;">
					회원정보
				</td>
      </tr>
      <tr>
        <td align="left" valign="top" style=" font-weight:bold;">
        <!-- <td align="left" valign="top" style="width:5%; font-weight:bold;"> -->
          회원구분
        </td>
				<td align="left" style="padding-right:20px;">
					<?php
					$part = array("비즈", "영업", "기술", "관리");
					for($i=0; $i<count($part); $i++){ ?>
						<input type="hidden" name="user_part1" id="page<?php echo ($i+1) ;?>" value="<?php echo $part[$i];?>" style="display:inline-block;text-align:center">
						<select name="user_part2" id="user_part2" class="select-common" style="width:155px;">
							<option value=0>권한없음(<?php echo $part[$i];?>)</option>
							<option value=1>일반(<?php echo $part[$i];?>)</option>
							<option value=2>팀관리자(<?php echo $part[$i];?>)</option>
							<option value=3>관리자(<?php echo $part[$i];?>)</option>
						</select><br>
					<?php } ?>
				</td>
        <td align="left" valign="top" style="font-weight:bold;">
          승인요청
        </td>
				<td valign="top">
					<select name="confirm_flag" id="confirm_flag" class="select-common" style="width:155px;">
						<option value="Y">승인</option>
						<option value="N">미승인</option>
					</select>
				</td>
      </tr>
			<tr>
        <td align="left" valign="center" style="font-weight:bold;">
          아이디
        </td>
				<td align="left" style="padding-right:20px;">
					<input style="width:150px" name="user_id" type="text" class="input-common" id="user_id" onchange="idcheck()" placeholder="3자~12자의 영문,숫자만 사용"/>
					<input type="hidden" id="id_check" value="N">
				</td>
        <td align="left" valign="center" style="font-weight:bold;">
          비밀번호
        </td>
				<td>
					<input style="width:150px" name="user_password" type="password" class="input-common" id="user_password"/>
				</td>
      </tr>
			<tr>
        <td align="left" valign="center" style="font-weight:bold;">
          회사명
        </td>
				<td align="left" style="padding-right:20px;">
					<input style="width:150px" name="company_name" type="text" class="input-common" id="company_name"/>
				</td>
        <td align="left" valign="center" style="font-weight:bold;">
          사업자등록번호
        </td>
				<td>
					<input style="width:150px" name="company_num" type="text" class="input-common" id="company_num" onclick="checkNum(this);" onKeyUp="checkNum(this);" maxlength="10"/>
				</td>
      </tr>
			<tr>
        <td align="left" valign="center" style="font-weight:bold;">
          이름
        </td>
				<td align="left" style="padding-right:20px;">
					<input style="width:150px" name="user_name" type="text" class="input-common" id="user_name"/>
				</td>
        <td align="left" valign="center" style="font-weight:bold;">
          직급
        </td>
				<td>
					<input style="width:150px" name="user_duty" type="text" class="input-common" id="user_duty"/>
				</td>
      </tr>
			<tr>
        <td align="left" valign="center" style="font-weight:bold;">
          부서
        </td>
				<td align="left" style="padding-right:20px;">
					<select style="width:155px;" name="user_group" id="user_group" class="select-common">
						<?php foreach($groupList as $group){ ?>
							<option value="<?php echo $group['groupName']; ?>"><?php echo $group['groupName']; ?></option>
						<?php } ?>
					</select>
				</td>
				<td></td>
				<td></td>
      </tr>
			<tr>
        <td align="left" valign="center" style="font-weight:bold;">
          이메일
        </td>
				<td align="left" style="padding-right:20px;">
					<input style="width:150px" name="user_email" type="text" class="input-common" id="user_email"/>
				</td>
        <td align="left" valign="center" style="font-weight:bold;">
          연락처
        </td>
				<td>
					<input style="width:150px" name="user_tel" type="text" class="input-common" id="user_tel"/>
				</td>
      </tr>
			<tr>
				<td colspan="4" align="right">
					<!--지원내용 추가 버튼-->
					<input type="button" class="btn-common btn-color1" style="width:70px; margin-right:10px;" value="취소" onclick="$('#user_input').bPopup().close()">
					<input type="button" class="btn-common btn-color2" style="width:70px;" value="등록" onclick="javascript:chkForm();return false;">
        </td>
      </tr>
    </table>
  </form>
</div>



</body>
<script language="javascript">
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
</html>

<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<!-- <link rel="stylesheet" href="/misc/css/dashboard.css"> -->
<link rel="stylesheet" href="/misc/css_mango/view_page_common_mango.css">
<style media="screen">
.layerpop {
		display: none;
		z-index: 1000;
		border: 2px solid #ccc;
		background: #fff;
		/* cursor: move;  */
		cursor: default;
	 }

.layerpop_area .modal_title {
		padding: 30px 10px 0px 20px;
		/* border: 0px solid #aaaaaa; */
		font-size: 20px;
		font-weight: bold;
		line-height: 24px;
		text-align: left !important;
	 }

.layerpop_area .layerpop_close {
		width: 25px;
		height: 25px;
		display: block;
		position: absolute;
		top: 10px;
		right: 10px;
		background: transparent url('btn_exit_off.png') no-repeat;
	}

.layerpop_area .layerpop_close:hover {
		background: transparent url('btn_exit_on.png') no-repeat;
		cursor: pointer;
	}

.layerpop_area .content {
		width: 96%;
		margin: 2%;
		color: #828282;
	}
  th {
    font-weight: normal;
    border-right:thin solid #DFDFDF;
  }
  th:last-child {
    border-right:none;
  }
	.modal-input {
		box-sizing: border-box;
	  color: #A6A6A6;
	  border-color: #DDDDDD;
	  height: 35px;
	}
</style>
<script language="javascript">

function GoSearch(){
	var searchkeyword = document.mform.searchkeyword.value;
	var searchkeyword = searchkeyword.trim();

	if (searchkeyword.replace(/,/g, "") == "") {
		 alert("검색어가 없습니다.");
		 location.href="<?php echo site_url();?>/user/user_list";
		 return false;
	}

	document.mform.action = "<?php echo site_url();?>/user/user_list";
	document.mform.cur_page.value = "";
	document.mform.submit();
}

</script>
<script type="text/javascript" src="/misc/js/jquery.bpopup-0.1.1.min.js"></script>
<body>
<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/mango_header.php";
?>
<div align="center">
<div class="dash1-1">
<table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
<form name="mform" action="<?php echo site_url();?>/user/user_list" method="get" onKeyDown="if(event.keyCode==13) return GoSearch();">
<input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
<input type="hidden" name="lpp" value="<?php echo $no_page_list; ?>">
<input type="hidden" name="seq" value="">
<input type="hidden" name="mode" value="">
<tbody height="100%">
	<!-- 타이틀 이미지 tr -->
<tr height="5%">
  <td class="dash_title">회원관리</td>
</tr>
<!-- <tr>
  <td height="10"></td>
</tr> -->
<!-- 검색창 -->
<tr>
	<td>
		<table width="100%" cellspacing="0" cellpadding="0" style="margin-top:70px;">
		<tr>
			<td>
			<!-- </td>
			<td> -->
			<select name="search1" id="search1" class="select-common">
			<option value="001" <?php if($search1 == "001"){ echo "selected";}?>>이름</option>
			<option value="002" <?php if($search1 == "002"){ echo "selected";}?>>아이디</option>
			<option value="003" <?php if($search1 == "003"){ echo "selected";}?>>이메일</option>
		</select>
			<!-- </td>
			<td> -->
				<!-- <table width="95%" border="0" cellspacing="0" cellpadding="0"> -->

					<input  type="text" size="25" class="input-common" name="searchkeyword" placeholder="검색하세요." value="<?php echo str_replace('"', '&uml;', $search_keyword );?>"/>
					<!-- <input type="image" style='cursor:hand; margin-bottom:8px;' onClick="return GoSearch();" src="<?php echo $misc;?>img/dashboard/btn/btn_search.png" width="20px" height="20px" align="middle" border="0" /> -->
					<input type="button" class="btn-common btn-search" value="검색" onClick="return GoSearch();">

			<!-- </table> -->
			<?php if($this->admin == 'Y') { ?>
					<input type="button" class="btn-common btn-style1" style="float:right;" onclick="$('#user_input').bPopup();" value="추가">
			<?php } ?>

				<select class="select-common" id="listPerPage" style="float:right;margin-right:10px;" onchange="change_lpp()">
					<option value="5" <?php if($lpp==5){echo 'selected';} ?>>5건 / 페이지</option>
					<option value="10" <?php if($lpp==10){echo 'selected';} ?>>10건 / 페이지</option>
					<option value="15" <?php if($lpp==15){echo 'selected';} ?>>15건 / 페이지</option>
					<option value="20" <?php if($lpp==20){echo 'selected';} ?>>20건 / 페이지</option>
					<option value="30" <?php if($lpp==30){echo 'selected';} ?>>30건 / 페이지</option>
					<option value="50" <?php if($lpp==50){echo 'selected';} ?>>50건 / 페이지</option>
				</select>
		</td>
		</tr>
	</table>
</td>
</tr>
<!-- 검색 끝 -->
<!-- <tr>
  <td height="10"></td>
</tr> -->

<!-- 콘텐트 시작 -->
<tr height="45%">
<td valign="top" style="padding:2px 0px 15px 0px">
<!-- <td valign="top" style="padding:15px 0px 15px 0px"> -->
	<table class="content_dash_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>

            <td align="center" valign="top">

              <tr>
                <td><table class="list_tbl" width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:20px;">
									<colgroup>
	                  <col width="5%">
	                  <col width="15%">
	                  <col width="12.5%">
	                  <col width="12.5%">
	                  <col width="10%">
										<col width="20%">
	                  <col width="15%">
	                  <col width="10%">
	                </colgroup>
                  <tr class="t_top row-color1">
                    <th height="40" align="center">NO</th>
                    <th align="center">아이디</th>
                    <th align="center">보건증 기간</th>
										<th align="center">이름</th>
                    <th align="center">관리자</th>
										<th align="center">이메일</th>
										<th align="center">연락처</th>
										<th align="center">승인여부</th>
									</tr>

			<?php
				if ($count > 0) {
					$i = $count - $no_page_list * ( $cur_page - 1 );
					$icounter = 0;

					foreach ( $list_val as $item ) {

			?>
                  <tr onMouseOver="this.style.backgroundColor='#FAFAFA'" onMouseOut="this.style.backgroundColor='#fff'" onclick="ViewBoard('<?php echo $item['seq'];?>')" style="cursor:pointer;">
                    <td height="40" align="center"><?php echo $i;?></td>
                    <td align="center"><?php echo $item['user_id'];?></td>
                    <td align="center"><?php echo $item['health_certificate_term_e'];?></td>
										<td align="center"><?php echo $item['user_name'];?></td>
                    <td align="center">
											<?php if($item['admin'] == 'Y') {
															echo '관리자';
														} else {
															echo '직원';
														} ?>
										</td>
                    <td align="center"><?php echo $item['user_email']; ?></td>
                    <td align="center"><?php echo $item['user_tel']; ?></td>
                    <td align="center">
							<?php if($item['confirm_flag'] == "Y") {
											echo '승인';
										} else {
											echo '미승인';
										} ?>
										</td>
                  </tr>
			<?php
						$i--;
						$icounter++;
					}
				} else {
			?>
				<tr onMouseOver="this.style.backgroundColor='#FAFAFA'" onMouseOut="this.style.backgroundColor='#fff'">
                    <td width="100%" height="40" align="center" colspan="9">등록된 게시물이 없습니다.</td>
                  </tr>

			<?php
				}
			?>
                </table></td>
              </tr>
<script language="javascript">

function moveList(category){
	 location.href="<?php echo site_url();?>/user/user_list?category="+category;
}


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

	document.mform.action = "<?php echo site_url();?>/user/user_modify";
	document.mform.seq.value = seq;
	document.mform.mode.value = "view";

	document.mform.submit();
}
</script>


            </td>
        </tr>
     </table>

    </td>
	</tr>
		<!-- 컨텐트 끝 -->

		<!-- 페이징시작 -->
		<tr height="40%">
			<td align="left" valign="top">
				<table width="100%" cellspacing="0" cellpadding="0">
				<tr>
					<td width="19%">

						<tr height="20%">
							<td align="center" valign="top">
						<?php if ($count > 0) {?>
						<table width="400" border="0" cellspacing="0" cellpadding="0">
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
						<!-- 페이징 끝 -->

					</td>
				</tr>

<!-- 버튼 tr 시작 -->
			</table>
		</td>
		</tr>
		<!-- 페이징끝 -->
	</tbody>
</form>
</table>
</div>
<!-- 회원 추가 모달 시작 -->
<div id="user_input" style="display:none; position: absolute; background-color: white; width: 560px; height: 530px; border-radius:5px;">
  <form name="cform" action="<?php echo site_url();?>/user/user_input_action" method="post" onSubmit="javascript:chkForm();return false;">
		<p style="padding: 30px 30px; font-size:20px; font-weight:bold; border-bottom:thin solid #DFDFDF;">회원정보</p>
		<table style="padding:20px 30px; border-collapse: separate; width:100%;">
    <!-- <table width="320" height="100%" style="padding:20px 18px;" border="0" cellspacing="0" cellpadding="0"> -->
			<colgroup>
				<col width="50%" />
				<col width="50%" />
			</colgroup>
			<tr>
				<td align="left" style=" font-weight:bold;">회원구분</td>
				<td align="left" style="font-weight:bold;">승인요청</td>
			</tr>
			<tr>
				<td align="left" style="padding-right:20px;padding-bottom:15px;">
					<select class="select-common modal-input" name="admin" style="width:100%;">
						<option value="N">직원</option>
						<option value="Y">관리자</option>
					</select>
				</td>
				<td valign="top" style="padding-bottom:15px;">
					<select class="select-common modal-input" name="confirm_flag" style="width:100%;">
						<option value="N">미승인</option>
						<option value="Y">승인</option>
					</select>
				</td>
			</tr>
			<tr>
				<td align="left" valign="center" style="font-weight:bold;"><span style="color:red;">*</span>아이디</td>
				<td align="left" valign="center" style="font-weight:bold;"><span style="color:red;">*</span>비밀번호</td>
			</tr>
			<tr>
				<td align="left" style="padding-right:20px;padding-bottom:15px;">
					<input style="width:100%" type="text" class="input-common modal-input" name="user_id" id="user_id" value="" onchange="idcheck()" placeholder="3자~12자의 영문,숫자만 사용"/>
				</td>
				<td style="padding-bottom:15px;">
					<input style="width:100%" type="password" class="input-common modal-input" name="user_password" value="">
				</td>
			</tr>
			<tr>
				<td align="left" valign="center" style="font-weight:bold;"><span style="color:red;">*</span>이름</td>
				<td align="left" valign="center" style="font-weight:bold;"><span style="color:red;">*</span>이메일</td>
			</tr>
			<tr>
				<td align="left" style="padding-right:20px;padding-bottom:15px;">
					<input style="width:100%" type="text" class="input-common modal-input" name="user_name" value="">
				</td>
				<td style="padding-bottom:15px;">
					<input style="width:100%" type="text" class="input-common modal-input" name="user_email" value="">
				</td>
			</tr>
			<tr>
				<td align="left" valign="center" style="font-weight:bold;"><span style="color:red;">*</span>전화번호</td>
			</tr>
			<tr>
				<td align="left" style="padding-right:20px;padding-bottom:15px;">
					<input style="width:100%" type="text" class="input-common modal-input" onkeyup="inputPhoneNumber(this);"  name="user_tel" value="">
				</td>
			</tr>
			<tr>
				<td colspan="2" align="right">
					<!--지원내용 추가 버튼-->
					<input type="button" class="btn-common btn-color1" style="width:auto;padding:0 15px; margin-right:10px;" value="취소" onclick="$('#user_input').bPopup().close()">
					<input type="button" class="btn-common btn-color2" style="width:auto;padding:0 15px;" value="등록" onclick="javascript:chkForm();return false;">
        </td>
      </tr>
    </table>
  </form>
</div>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/mango_bottom.php"; ?>
</body>
<script type="text/javascript">
	function change_lpp(){
		var lpp = $("#listPerPage").val();
		document.mform.lpp.value = lpp;
		document.mform.cur_page.value = 1;
		document.mform.submit();
	}

	function idcheck(){
		var uid =  $("#user_id").val();
	//	return;
		$.ajax({
			type: "POST",
			cache:false,
			url: "<?php echo site_url();?>/user/idcheck",
			dataType: "json",
			async: false,
			data: {id: uid},
			success: function(data){
				if(data.result == "true"){
					$("#id_check").val("Y");
					alert('중복되는 아이디가 있습니다.');
					$("#user_id").val('');
					$("#user_id").focus();
				} else {
					$("#id_check").val("N");
				}
			}
		});
	}

	function chkForm () {
		var mform = document.cform;

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
		if (mform.user_name.value == "") {
			mform.user_name.focus();
			alert("이름을 입력해 주세요.");
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

		mform.submit();
		return false;
	}

	// 전화번호 - 자동입력
	function inputPhoneNumber(obj) {

		var number = obj.value.replace(/[^0-9]/g, "");
		var phone = "";

		if(number.length < 4) {
			return number;
	 	} else if(number.length < 7) {
			phone += number.substr(0, 3);
			phone += "-";
			phone += number.substr(3);
	  } else if(number.length < 11) {
			phone += number.substr(0, 3);
			phone += "-";
			phone += number.substr(3, 3);
			phone += "-";
			phone += number.substr(6);
		} else {
			phone += number.substr(0, 3);
			phone += "-";
			phone += number.substr(3, 4);
			phone += "-";
			phone += number.substr(7);
		}
		obj.value = phone;
	}
</script>
</html>

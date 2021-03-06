<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<style>
	p, div, span, a, a:hover, a:visited, a:active, label, input, h1,h2,h3,h4,h5,h6{font-family: "Noto Sans KR";}
</style>


<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" /> <!-- 조직도 생성 -->
<link rel="stylesheet" href="/misc/css/tech_schedule/proton/style.min.css" /> <!-- 조직도 생성 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<script type="text/javascript" src="/misc/js/jquery.bpopup-0.1.1.min.js"></script>
<script language="javascript">
function GoSearch() {
	var searchkeyword = document.mform.searchkeyword.value;
	var searchkeyword = searchkeyword.trim();


	document.mform.action = "<?php echo site_url();?>/admin/equipment/car_list";
	document.mform.cur_page.value = "";
	document.mform.submit();
}
</script>






<body>
<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>

<div align="center">
	<div class="dash1-1">
		<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" style="width:95%">
			<tbody>
				<tr height="5%">
          <td class="dash_title">
						차량관리
          </td>
        </tr>
				<tr>
					<td height="70"></td>
				</tr>
				<!-- <tr height="13%">
        </tr> -->
				<form name="mform" action="<?php echo site_url();?>/admin/equipment/car_list" method="get" onkeydown="if(event.keyCode==13) return GoSearch();">
				<input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
				<tr height="10%">
					<td>
						<select name="search1" id="search1" class="select-common select-style1" onchange="change_search1(this.value);">
							<!-- value 1,2가 모델 15,21번째 줄 조건 (value값을 넘기니깐) 까먹지마!! -->
							<option value="1" <?php if($search1 == '1'){echo 'selected';} ?>>차량 번호</option>
							<option value="2" <?php if($search1 == '2'){echo 'selected';} ?>>상태</option>
						</select>
						<input  type="text" size="25" class="input-common" id="searchkeyword" name="searchkeyword" placeholder="검색하세요." value="<?php echo $searchkeyword; ?>"/>
						<select class="select-common" id="search2" name="search2">
							<option value="N" <?php if($search2 == 'N'){echo 'selected';} ?>>사용</option>
							<option value="Y" <?php if($search2 == 'Y'){echo 'selected';} ?>>매각</option>
							<option value="A" <?php if($search2 == 'A'){echo 'selected';} ?>>양도</option>
						</select>
					<input type="button" class="btn-common btn-style2" value="검색" style="margin-left:10px;" onclick="return GoSearch();">
					</td>

					<td align="right" valign="bottom">
						<?php
							if($admin_lv == "3") {
						?>
						<!-- <input class="btn-common btn-color2" type="button" onclick="$('#car_input').bPopup();" value="등록" > -->
								<input class="btn-common btn-color2" type="button" onclick="open_car_input();" value="등록" >
						<?php
							}
						?>
					</td>
				</tr>
				<tr style="max-height:45%">
					<td colspan="2" valign="top" style="padding:10px 0px;">
						<table class="content_dash_tbl list" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td align="center" valign="top">
									<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">

									<input type="hidden" name="seq" value="">
									<input type="hidden" name="mode" value="">
									        <tr>
									            <!--내용-->
									             <!--리스트-->
									              <tr>
									                <td>
																		<table width="100%" class="month_tbl" border="0" cellspacing="0" cellpadding="0">
										                  <colgroup>
																				<col width="10%" />
														            <col width="7%" />
										                    <col width="12%" />
										                    <col width="13%" />
										                    <col width="12%" />
										                    <col width="12%" />
										                    <col width="6%" />
										                    <col width="6%" />
																				<col width="12%" />
																				<col width="10%" />
										                  </colgroup>
										                  <tr class="t_top row-color1">
																				<th></th>
														    				<th height="40" align="center">번호</th>
										                    <th align="center">차종</th>
										                    <th align="center">차량 번호</th>
										                    <th align="center">지정</th>
										                    <th align="center">구입일</th>
										                    <th align="center" colspan="2">상태</th>
																				<th align="center">양도 및 매각일</th>
																				<th></th>
										                  </tr>
												<?php
													if ($count > 0) {
														$i = $count - $no_page_list * ( $cur_page - 1 );
														$icounter = 0;

														foreach ( $list_val as $item ) {
												?>
										                  <tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'" style="cursor:pointer" onclick="ViewBoard('<?php echo $item['seq'];?>')">
																				<td></td>
										                    <td height="40" align="center"><?php echo $i;?></td>
										                    <td align="center"><?php echo $item['type'];?></td>
										                    <td align="center"><?php echo $item['number'];?></td>
										                    <td align="center">
																					<?php echo $item['user_name']; ?>
																				</td>
																				<!-- 구입일 -->
																				<td align="center"><?php echo substr($item['purchase_date'], 0, 10);?></td>
																				<!-- 사용-->
																				<td align="center"><?php if($item['sell_yn'] == 'N'){echo '사용';} ?></td>
																				<!-- 매각 -->
																				<td align="center"><?php if($item['sell_yn'] == 'Y'){echo '매각';} else if($item['sell_yn'] == 'A'){echo '양도';} ?></td>
																				<!-- 양도 및 매각일 -->
																				<td align="center">	<?php
																				if($item['sell_yn'] == 'Y' || $item['sell_yn'] == 'A') {
																					echo date('Y-m-d', strtotime($item['sell_date']));
																				}
																				?></td>
																				<td></td>
										                  </tr>
									             <?php
															$i--;
															$icounter++;
														}
													} else {
												?>
													<tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'">
										                    <td width="100%" height="40" align="center" colspan="12">등록된 게시물이 없습니다.</td>
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
										document.mform.action = "<?php echo site_url();?>/admin/equipment/car_view";
										document.mform.seq.value = seq;
										document.mform.mode.value = "modify";

										document.mform.submit();
									}
									</script>
									            <!--//내용-->


									        </tr>

									</form>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<!--페이징-->
				<tr>
					<td align="center" width="100%" colspan="2">
<?php if ($count > 0) {?>
	<table width="400" border="0" cellspacing="0" cellpadding="0">
						<tr>
	<?php
		if ($cur_page > 10){
	?>
							<td width="19"><a href="JavaScript:GoFirstPage()"><img src="<?php echo $misc;?>img/btn_prev.jpg" /></a></td>
							<td width="2"></td>
							<td width="19"><a href="JavaScript:GoPrevPage()"><img src="<?php echo $misc;?>img/btn_left.jpg" /></a></td>
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
					$strSection = "&nbsp;<span class=\"section\">|</span>&nbsp;";
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
		<td width="19"><a href="JavaScript:GoNextPage()"><img src="<?php echo $misc;?>img/btn_right.jpg"/></a></td>
							<td width="2"></td>
							<td width="19"><a href="JavaScript:GoLastPage()"><img src="<?php echo $misc;?>img/btn_next.jpg" /></a></td>
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
				<!--//페이징-->
			</tbody>
		</table>
	</div>
</div>

<!--하단-->
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
<!--//하단-->

<!-- 입력 모달 -->
<div id="car_input" style="display:none; position: absolute; background-color: white; width: 300px; height: 340px; border-radius:5px;">
<!-- <div id="car_input" style="display:none; position: absolute; background-color: white; width: auto; height: auto;"> -->
	<form name="cform" action="<?php echo site_url();?>/admin/equipment/car_input_action" method="post" onSubmit="javascript:chkForm();return false;">
		<table style="margin:10px 30px; border-collapse: separate; border-spacing: 0;">
			<colgroup>
				<col width="30%">
				<col width="70%">
			</colgroup>
			<tr>
				<td height="20"></td>
			</tr>
			<tr>
				<td colspan="2" class="modal_title" align="left" style="padding-bottom:10px; font-size:20px; font-weight:bold;">
				차량
				</td>
			</tr>
			<tr>
				<td height="20"></td>
			</tr>
			<tr class="border-b tbl-tr">
				<td align="left" valign="center" style="font-weight:bold; width:10%;">차종</td>
				<td align="left">
				<!-- <td style="width:50%;"> -->
					<input type="text" class="input-common" name="type" id="type" value="" style="width:100%;">
				</td>
			</tr>
			<tr class="border-b tbl-tr">
				<td align="left" valign="center" style="font-weight:bold; width:17%;">차량번호</td>
				<td align="left">
					<input type="text" class="input-common" name="number" id="number" value="" style="width:100%">
				</td>
			</tr>
			<tr class="border-b tbl-tr">
				<td align="left" valign="center" style="font-weight:bold; width:17%;">구입일</td>
				<td align="left">
					<input type="date" name="purchase_date" value="<?php echo date('Y-m-d'); ?>">
				</td>
			</tr>
			<tr class="tbl-tr">
				<td align="left" valign="center" style="font-weight:bold; width:17%;">지정</td>
				<td align="left">
					<input type="radio" name="chk_info" value="public" id="public" checked>공용
					<input type="radio" name="chk_info" value="individual" id="individual">개인
				</td>
			</tr>
			<tr id="appointed_tr" style="display:none;"  class="tbl-tr">
				<td align="left" valign="center" style="font-weight:bold; width:17%;">사용자</td>
				<td align="left">
					<input type="text" id="appointed" class="input2" name="user_name" value="" onclick="$('#searchAddUserpopup').bPopup();" style="width:95%;" autocomplete="off">
					<input type="hidden" id="appointed_seq" class="input2" name="user_seq" id="user" value="" onclick="$('#searchAddUserpopup').bPopup();" style="width:95%;display:none;">
				</td>
			</tr>
			<tr>
				<td height="20"></td>
			</tr>
			<tr>
				<td style="width:17%;"></td>
				<td align="right">
					<input type="button" class="btn-common btn-color1" style="width:70px; margin-right:10px;" value="취소" onclick="$('#car_input').bPopup().close();">
					<input type="button" class="btn-common btn-color2" style="width:70px;" value="등록" onclick="javascript:chkForm();return false;">
				</td>
			</tr>
		</table>
	</form>
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

</body>
<script>
$("input[name='chk_info']:radio").change(function () {
	if(this.value == "public"){
		$("#car_input").css('height','340px');
		$("#appointed_tr").hide();
		$('#appointed_seq').val('');
		// $("#appointed").hide();
	} else if (this.value == "individual") {
		$("#car_input").css('height','380px');
		$("#appointed_tr").show();
		// $("#appointed").show();
	}
});

function open_car_input(){
	$('#car_input').bPopup();
	$("#car_input").css('height','340px');
	$("#appointed_tr").hide();
	$("input:radio[id='public']").prop('checked', true);
	$("#type").val('');
	$("#number").val('');
	$("#appointed").val('');
	$('#appointed_seq').val('');
}

function searchAddUserBtn(){
 // $('#searchAddUserpopup').bPopup({follow:[false,false]});
 $('#searchAddUserpopup').bPopup();
}
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

function chkForm () {
	var mform = document.cform;

	if (mform.type.value == "") {
		mform.type.focus();
		alert("차종을 입력해 주세요.");
		return false;
	}
	if (mform.number.value == "") {
		mform.number.focus();
		alert("차량번호를 입력해 주세요.");
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

$(function() {
	$('#search1').change();
})

function change_search1(val) {
	// car_list 58번째줄 value 값
	// 1일땐 input 검색창이 보여야해
	if (val == 1) {
		// 차량번호
		$('#searchkeyword').show();
		$('#search2').hide();
	// 59번째줄 value 값
	// 2일땐 selectbox라서 selectbox가 보여야해
	} else if (val == 2) {
		// 상태
		$('#searchkeyword').hide();
		$('#search2').show();
	}
}
</script>
</html>

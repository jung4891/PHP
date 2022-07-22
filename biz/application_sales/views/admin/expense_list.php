<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
	header("Cache-Control: no cache");
?>
<link rel="stylesheet" href="/misc/css/view_page_common.css">

<style>
  body {
    font-size:12px;
  }
  .main_contents {
    text-align: left;
  }
  .left-side {
    width:250px;
    float:left;
    border-radius: 3px;
    border: 1px solid #DFDFDF;
  }
  .right-side {
    width:calc(100% - 300px);
    float:left;
    padding-left: 40px;
  }
  .left-side-tbl td {
    padding:10px;
  }
  #details_tr input {
    margin-right:10px;
    margin-bottom:10px;
  }
  .jstree-open > .jstree-anchor, .jstree-closed > .jstree-anchor {
    font-weight:bold;
  }
	.jstree-proton {
		font-family: "Noto Sans KR", sans-serif !important;
	}
  #j1_4_anchor {
      font-weight: bold;
  }
  .contents_item td {
    text-align: center;
  }
	#icon_inf p {
		font-size: 14px;
		line-height: 0.7;
	}

	#icon_inf .title {
		font-weight: bold;
		font-size: 16px;
	}

	#icon_inf .content {
		color: #B0B0B0;
		padding-left: 10px;
		padding-bottom: 10px;
	}
</style>
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" /> <!-- 조직도 생성 -->
<link rel="stylesheet" href="/misc/css/tech_schedule/proton/style.min.css" /> <!-- 조직도 생성 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script> <!-- 조직도 생성 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.9.2/i18n/jquery.ui.datepicker-ko.min.js"></script>
<script type="text/javascript" src="/misc/js/jquery.bpopup-0.1.1.min.js"></script>
<body>
<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
<div class="contents_container" align="center">
  <!-- 타이틀 -->
  <div class="contents_item dash_title" style="margin-top:30px;display:flex;">
    <p align="left">
      지출통계
			<img style="cursor:pointer;vertical-align:middle;" src="/misc/img/dashboard/btn/btn_info.svg" width="25" onclick="open_inf(this);"/>
    </p>
  </div>

  <div class="main_contents" style="margin-top:40px;">
    <div class="left-side">
      <table class="left-side-tbl" cellpadding="0" cellspacing="0" border="0" style="width:100%;">
        <tr>
          <td style="border-bottom:1px solid #DFDFDF;">
            <input type="button" class="btn-common btn-style4" style="height:28px;cursor:default;" value="조직도">
            <img src="/misc/img/btn_up_box.svg" class="btn_up" style="height:28px;vertical-align:middle;float:right;display:none;cursor:pointer;" onclick="side_btn(this, 'tree', 'up');">
            <img src="/misc/img/btn_down_box.svg" class="btn_down" style="height:28px;vertical-align:middle;float:right;cursor:pointer;" onclick="side_btn(this, 'tree', 'down');">
          </td>
        </tr>
        <tr id="tree_tr" style="display:none;">
          <td>
            <div id="tree">
        			<ul>
        				<li style="font-weight:bold">(주)두리안정보기술 (<?php echo $user_count[0]['cnt']; ?>)
        					<ul>
        					<?php
        					foreach ($parentGroup as $pg){
        					?>
        						<?php
        						if ($pg->childGroupNum==1 && $pg->depth==1){
        						?>
        							<li style="font-weight:bold">
        								<?php foreach($parent_group_count as $pgc) {
        									if ($pg->parentGroupName == $pgc['parentGroupName']) {
        										echo $pg->parentGroupName." (".$pgc['cnt'].")";
        									}
        								}
        								foreach ($userInfo as $ui){
        										if ($pg->groupName==$ui->user_group){
        								?>
        								<ul>
        									<li id="<?php echo $ui->user_id; ?>"><?php echo $ui->user_name." ".$ui->user_duty; ?></li>
        								</ul>
        								<?php
        										}
        								}
        								?>
        							</li>
        						<?php
        						} else if ($pg->childGroupNum>1 && $pg->depth==1){
        						?>
        						<li style="font-weight:bold">
        							<?php
        							foreach($parent_group_count as $pgc) {
        								if ($pg->parentGroupName == $pgc['parentGroupName']) {
        									echo $pg->parentGroupName." (".$pgc['cnt'].")";
        								}
        							}
        							foreach ($user_group as $ug) {
        								if ($pg->parentGroupName==$ug->parentGroupName){
        							?>
        							<ul>
        							<?php
        								foreach ($userDepth as $ud){
        									if ($ug->groupName == $ud->groupName){
        										echo '<li id="'.$ud->user_id.'">'.$ud->user_name." ".$ud->user_duty.'</li>';
        									}
        								}
        								if ($ug->groupName != $pg->groupName){
        									foreach($user_group_count as $ugc){
        										if ($ug->groupName == $ugc['groupName']) {
        											echo "<li style='font-weight:bold'>".$ug->groupName.' ('.$ugc['cnt'].')';
        										}
        									}
        								}
        							?>
        									<ul>
        										<?php
        										foreach($userInfo as $ui) {
        											if ($ug->groupName==$ui->user_group){
        												echo '<li id="'.$ui->user_id.'">'.$ui->user_name." ".$ui->user_duty.'</li>';
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
          </td>
        </tr>
        <tr>
          <td style="border-top:1px solid #DFDFDF;">
            <input type="button" class="btn-common btn-style4" style="height:28px;cursor:default;" value="계정과목">
            <img src="/misc/img/btn_up_box.svg" class="btn_up" style="height:28px;vertical-align:middle;float:right;display:none;cursor:pointer;" onclick="side_btn(this, 'details', 'up');">
            <img src="/misc/img/btn_down_box.svg" class="btn_down" style="height:28px;vertical-align:middle;float:right;cursor:pointer;" onclick="side_btn(this, 'details', 'down');">
          </td>
        </tr>
        <tr id="details_tr" style="display:none;">
          <td style="border-top:1px solid #DFDFDF;">
            <input type="checkbox" id="allCheck">전체<br>
            <input type="checkbox" name="details_chk" value="던킨" <?php if(strpos($checked_detail, '던킨')!==false){echo 'checked';} ?>>던킨<br>
            <input type="checkbox" name="details_chk" value="교육훈련비" <?php if(strpos($checked_detail, '교육훈련비')!==false){echo 'checked';} ?>>교육훈련비<br>
            <input type="checkbox" name="details_chk" value="경조사" <?php if(strpos($checked_detail, '경조사')!==false){echo 'checked';} ?>>경조사<br>
            <input type="checkbox" name="details_chk" value="도서인쇄비" <?php if(strpos($checked_detail, '도서인쇄비')!==false){echo 'checked';} ?>>도서인쇄비<br>
            <input type="checkbox" name="details_chk" value="대중교통" <?php if(strpos($checked_detail, '대중교통')!==false){echo 'checked';} ?>>대중교통<br>
            <input type="checkbox" name="details_chk" value="복리후생비" <?php if(strpos($checked_detail, '복리후생비')!==false){echo 'checked';} ?>>복리후생비<br>
            <input type="checkbox" name="details_chk" value="사무실음료" <?php if(strpos($checked_detail, '사무실음료')!==false){echo 'checked';} ?>>사무실음료<br>
            <input type="checkbox" name="details_chk" value="소모품비" <?php if(strpos($checked_detail, '소모품비')!==false){echo 'checked';} ?>>소모품비<br>
            <input type="checkbox" name="details_chk" value="숙박비" <?php if(strpos($checked_detail, '숙박비')!==false){echo 'checked';} ?>>숙박비<br>
            <input type="checkbox" name="details_chk" value="식대" <?php if(strpos($checked_detail, '식대')!==false){echo 'checked';} ?>>식대<br>
            <input type="checkbox" name="details_chk" value="우편요금" <?php if(strpos($checked_detail, '우편요금')!==false){echo 'checked';} ?>>우편요금<br>
            <input type="checkbox" name="details_chk" value="자가운전" <?php if(strpos($checked_detail, '자가운전')!==false){echo 'checked';} ?>>자가운전<br>
            <input type="checkbox" name="details_chk" value="지급수수료" <?php if(strpos($checked_detail, '지급수수료')!==false){echo 'checked';} ?>>지급수수료<br>
            <input type="checkbox" name="details_chk" value="접대비" <?php if(strpos($checked_detail, '접대비')!==false){echo 'checked';} ?>>접대비<br>
            <input type="checkbox" name="details_chk" value="차량유지비" <?php if(strpos($checked_detail, '차량유지비')!==false){echo 'checked';} ?>>차량유지비<br>
            <input type="checkbox" name="details_chk" value="체력단련비" <?php if(strpos($checked_detail, '체력단련비')!==false){echo 'checked';} ?>>체력단련비<br>
            <input type="checkbox" name="details_chk" value="통신비" <?php if(strpos($checked_detail, '통신비')!==false){echo 'checked';} ?>>통신비<br>
            <input type="checkbox" name="details_chk" value="퀵서비스" <?php if(strpos($checked_detail, '퀵서비스')!==false){echo 'checked';} ?>>퀵서비스<br>
            <input type="checkbox" name="details_chk" value="회식대" <?php if(strpos($checked_detail, '회식대')!==false){echo 'checked';} ?>>회식대<br>
          </td>
        </tr>
      </table>
    </div>
    <div class="right-side">

      <form name="mform" action="<?php echo site_url();?>/admin/account/expense_list" method="post" onkeydown="if(event.keyCode==13) return GoSearch();">
        <input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
        <input type="hidden" name="lpp" value="<?php echo $no_page_list; ?>">
        <input type="hidden" name="checked_user" id="checked_user" value="<?php echo $checked_user; ?>">
        <input type="hidden" name="checked_detail" id="checked_detail" value="<?php echo $checked_detail; ?>">
        <input type="hidden" name="user_tr_open" id="user_tr_open" value="<?php echo $user_tr_open; ?>">
        <input type="hidden" name="details_tr_open" id="details_tr_open" value="<?php echo $details_tr_open; ?>">
        <div style="width:50%;float:left;">
          <select class="select-common" name="search">
            <option value="t_date" <?php if($search == 't_date'){echo 'selected';} ?>>사용일</option>
            <option value="write_date" <?php if($search == 'write_date'){echo 'selected';} ?>>기안일</option>
            <option value="completion_date" <?php if($search == 'completion_date'){echo 'selected';} ?>>완료일</option>
          </select>
          <input type="date" class="input-common input-style1" name="s_date" value="<?php echo $s_date; ?>" style="width:120px;">
          &nbsp;~&nbsp;
          <input type="date" class="input-common input-style1" name="e_date" value="<?php echo $e_date; ?>" style="width:120px;">
          <input type="button" class="btn-common btn-style2" value="조회" onclick="chkForm();">
          <input type="button" class="btn-common btn-color5" value="초기화" onclick="on_reset();">
        </div>
        <div style="width:50%;float:right;text-align:right;">
          <select class="select-common" id="listPerPage" style="height:25px;margin-right:10px;" onchange="change_lpp()">
             <option value="5" <?php if($lpp==5){echo 'selected';} ?>>5건 / 페이지</option>
             <option value="10" <?php if($lpp==10){echo 'selected';} ?>>10건 / 페이지</option>
             <option value="15" <?php if($lpp==15){echo 'selected';} ?>>15건 / 페이지</option>
             <option value="20" <?php if($lpp==20){echo 'selected';} ?>>20건 / 페이지</option>
             <option value="30" <?php if($lpp==30){echo 'selected';} ?>>30건 / 페이지</option>
             <option value="50" <?php if($lpp==50){echo 'selected';} ?>>50건 / 페이지</option>
          </select>
          <span>전체</span>
          <span style="color:red;margin-right:10px;"><?php echo $count; ?></span>
          <input type="button" class="btn-common btn-updownload" value="엑셀 다운로드" style="width:auto;padding-left:20px;" onclick="excelDownload();">
					<img src="/misc/img/download_btn.svg" style="width:12px;position:relative;top: 5px;right: 110px;padding: 2px;">
        </div>
	<?php if($count > 0) { ?>
				<div style="width:100%;float:left;text-align:center;font-weight:bold;padding-top:30px;">
					<span style="">총계 : 법인카드(<?php echo number_format($sum_account[0]['corporation_card']); ?>원), 개인카드(<?php echo number_format($sum_account[0]['personal_card']); ?>원), 간이영수증(<?php echo number_format($sum_account[0]['simple_receipt']); ?>원), 총(<?php echo number_format($sum_account[0]['corporation_card'] + $sum_account[0]['personal_card'] + $sum_account[0]['simple_receipt']); ?>원)</span>
				</div>
	<?php } ?>
      </form>

      <div class="contents_item" valign="top" style="margin-top:20px;width:100%;float:left;">
        <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="contents_tbl">
          <colgroup>
            <col width="8%" />
            <col width="8%" />
            <col width="11%" />
            <col width="11%" />
            <col width="16%" />
            <col width="11%" />
            <col width="9%" />
            <col width="9%" />
            <col width="9%" />
            <col width="8%" />
          </colgroup>
          <tr style="background-color:#F4F4F4; font-weight:bold;">
            <td height="10">일자</td>
            <td>세부계정</td>
            <td>업체</td>
            <td>사용지</td>
            <td>내역 및 사용자</td>
            <td>사용처</td>
            <td>금액(법인카드)</td>
            <td>금액(개인카드)</td>
            <td>금액(간이영수증)</td>
            <td>성명</td>
          </tr>
<?php if(!isset($view_val)) { ?>
          <tr>
            <td colspan="10">검색 조건을 설정해 주세요.</td>
          </tr>
<?php } else {
				if($count > 0) {
	        foreach($view_val as $v) { ?>
          <tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'" style="cursor:pointer" onclick="go_approval('<?php echo $v['approval_seq'];?>')">
            <td><?php echo $v['t_date']; ?></td>
            <td><?php echo $v['details']; ?></td>
            <td><?php echo $v['company']; ?></td>
            <td><?php echo $v['use_area']; ?></td>
            <td><?php echo $v['history_user']; ?></td>
            <td><?php echo $v['use_where']; ?></td>
            <td style="text-align:right;padding-right:10px;"><?php if($v['corporation_card'] != 0){echo number_format($v['corporation_card']);} ?></td>
            <td style="text-align:right;padding-right:10px;"><?php if($v['personal_card'] != 0){echo number_format($v['personal_card']);} ?></td>
            <td style="text-align:right;padding-right:10px;"><?php if($v['simple_receipt'] != 0){echo number_format($v['simple_receipt']);} ?></td>
            <td><?php echo $v['user_name']; ?></td>
          </tr>
	  <?php }
				} else { ?>
					<tr>
						<td colspan="10">검색 결과가 없습니다.</td>
					</tr>
				<?php }?>
	<?php  } ?>
        </table>
        <table style="width:100%;margin-top:20px;">
          <tr>
  					<td align="center">
  <?php if ($count > 0) {?>
  	<table width="100%" border="0" cellspacing="0" cellpadding="0">
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
        </table>
      </div>
    </div>
  </div>
	<!-- 엑셀용 테이블 -->
	<table width="100%" id="excel_tbl" class="month_tbl" border="0" cellspacing="0" cellpadding="0" style="display:none;">
		<colgroup>
			<col width="8%" />
			<col width="8%" />
			<col width="11%" />
			<col width="11%" />
			<col width="16%" />
			<col width="11%" />
			<col width="9%" />
			<col width="9%" />
			<col width="9%" />
			<col width="8%" />
		</colgroup>
		<tr style="background-color:#F4F4F4; font-weight:bold;">
			<td align="center" height="10">일자</td>
			<td align="center">세부계정</td>
			<td align="center">업체</td>
			<td align="center">사용지</td>
			<td align="center">내역 및 사용자</td>
			<td align="center">사용처</td>
			<td align="center">금액(법인카드)</td>
			<td align="center">금액(개인카드)</td>
			<td align="center">금액(간이영수증)</td>
			<td align="center">성명</td>
		</tr>
	  <tbody id="excel_tbody"></tbody>
	</table>

</div>

<!-- 아이콘 모달 -->
<div id="icon_inf" style="display: none; position: absolute;background-color: white;border: 2px solid grey;
border-radius: 3px; font-size: medium;">
<!-- <div id="car_input" style="display:none; position: absolute; background-color: white; width: auto; height: auto;"> -->
<span style="cursor: pointer;float: right;margin-right: 10px;margin-top: 10px;" onclick="$('#icon_inf').bPopup().close();">×</span>
    <div style="padding: 20px 20px 15px 20px;">
      <!-- 개인보관함 이동 방법 : 트리에서 이동할 개인보관함을 선택하여 Drag & Drop으로 이동할 수 있습니다. *아직 미완성* -->
      <p class="title">2021년도 11월 지출 내역 (지출내역서, 던킨지출내역서)부터 확인 가능합니다.</p>
    </div>
</div>

<!--하단-->
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
<!--//하단-->
</body>
<script type="text/javascript">
function side_btn(el, t, type) {
  if(type == 'up') {
    $(el).hide();
    $(el).siblings('.btn_down').show();
    $('#' + t + '_tr').hide();
  } else if (type == 'down') {
    $(el).hide();
    $(el).siblings('.btn_up').show();
    $('#' + t + '_tr').show();
  }
}

// 조직도
var checked_text_select = [];
var checked_id = $('#checked_user').val();
$(function () {
  $('#tree').jstree({
    "checkbox": {
      "keep_selected_style": false
    },
    'plugins': ["wholerow", "checkbox"],
    'core': {
      'themes': {
        'name': 'proton',
        'icons': false
      }
    }
  }).on('ready.jstree', function() {
    $(this).jstree('close_all');
    checked_id = checked_id.split(',');
    for(var i = 0; i < checked_id.length; i++) {
      $(this).jstree('select_node', checked_id[i]);
    }
  });
  $("#tree").bind("changed.jstree", function (e, data) {
    var reg = /_/; //부서아이디에 '_'이 포함되므로
    checked_text_select.length = 0;
    $.each($("#tree").jstree("get_checked", true), function () {
      if(!reg.test(this.id)) { //부서아이디 제외하고 user_id만 받기!
        checked_text_select.push(this.id);
        // checked_text_select.push(this.text);
      }
    })
  });
});

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

function change_lpp(){
	var lpp = $("#listPerPage").val();
	document.mform.lpp.value = lpp;
	document.mform.cur_page.value = '';
	document.mform.submit();
}

function on_reset() {
  location.href = "<?php echo site_url(); ?>/admin/account/expense_list";
}

$(function() {
  if($('#user_tr_open').val() == 'Y') {
    $('.btn_down').eq(0).trigger('click');
  }
  if($('#details_tr_open').val() == 'Y') {
    $('.btn_down').eq(1).trigger('click');
  }
})

function chkForm() {
  var checked_details = [];
  $('input[name=details_chk]').each(function() {
    if($(this).is(':checked')) {
      checked_details.push($(this).val());
    }
  });

  if(checked_text_select.length == 0) {
    alert('선택된 사용자가 없습니다.\n사용자를 선택해 주세요.');
    $('.btn_down').eq(0).trigger('click');
    return false;
  }

  if(checked_details.length == 0) {
    alert('선택된 계정과목이 없습니다.\n계정과목을 선택해 주세요.');
    $('.btn_down').eq(1).trigger('click');
    return false;
  }

  if($('#tree_tr').is(':visible')) {
    $('#user_tr_open').val('Y');
  } else {
    $('#user_tr_open').val('N');
  }

  if($('#details_tr').is(':visible')) {
    $('#details_tr_open').val('Y');
  } else {
    $('#details_tr_open').val('N');
  }

  $('#checked_detail').val(checked_details.join());
  $('#checked_user').val(checked_text_select.join());

  document.mform.cur_page.value = "";
  document.mform.submit();
}

function excelDownload() {
  $.ajax({
    type: "POST",
    url: "<?php echo site_url(); ?>/admin/account/expense_list_excel",
    dataType: "json",
    async: false,
    data: {
      checked_user: '<?php echo $checked_user; ?>',
      checked_detail: '<?php echo $checked_detail; ?>',
      search: '<?php echo $search; ?>',
      s_date: '<?php echo $s_date; ?>',
      e_date: '<?php echo $e_date; ?>'
    },
    success: function(data) {
      console.log(data);
      if(data) {
        var contents = '';
        for(var i = 0; i < data.length; i++) {
          contents += '<tr>';
          contents += '<td align="left">'+data[i].t_date+'</td>';
          contents += '<td align="left">'+data[i].details+'</td>';
          contents += '<td align="left">'+data[i].company+'</td>';
          contents += '<td align="left">'+data[i].use_area+'</td>';
          contents += '<td align="left">'+data[i].history_user+'</td>';
					contents += '<td align="left">'+data[i].use_where+'</td>';
          contents += '<td align="right">'+data[i].corporation_card+'</td>';
          contents += '<td align="right">'+data[i].personal_card+'</td>';
          contents += '<td align="right">'+data[i].simple_receipt+'</td>';
					contents += '<td align="left">'+data[i].user_name+'</td>';
          contents += '</tr>';
        }
      }
      $('#excel_tbody').html(contents);

      var tab_text = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
      tab_text = tab_text + '<head><meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">';
      tab_text = tab_text + '<xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>'
      tab_text = tab_text + '<x:Name>Test Sheet</x:Name>';
      tab_text = tab_text + '<x:WorksheetOptions><x:Panes></x:Panes></x:WorksheetOptions></x:ExcelWorksheet>';
      tab_text = tab_text + '</x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body>';
      tab_text = tab_text + "<table border='1px'>";
      var exportTable = $('#excel_tbl').clone();
      exportTable.find('input').each(function (index, elem) {
        $(elem).remove();
      });
      tab_text = tab_text + exportTable.html();
      tab_text = tab_text + '</table></body></html>';
      var data_type = 'data:application/vnd.ms-excel';
      var ua = window.navigator.userAgent;
      var msie = ua.indexOf("MSIE ");
      var fileName = '지출통계.xls';
      //Explorer 환경에서 다운로드
      if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
        if (window.navigator.msSaveBlob) {
          var blob = new Blob([tab_text], {
            type: "application/csv;charset=utf-8;"
          });
          navigator.msSaveBlob(blob, fileName);
        }
      } else {
        var blob2 = new Blob([tab_text], {
          type: "application/csv;charset=utf-8;"
        });
        var filename = fileName;
        var elem = window.document.createElement('a');
        elem.href = window.URL.createObjectURL(blob2);
        elem.download = filename;
        document.body.appendChild(elem);
        elem.click();
        document.body.removeChild(elem);
      }
    }
  })
}

function go_approval(seq) {
	location.href = "<?php echo site_url(); ?>/biz/approval/electronic_approval_doc_view?seq="+seq+"&type=admin&type2=002";
}

//아이콘 클릭
function open_inf(el){
	var position = $(el).offset();

 $('#icon_inf').bPopup({
	 opacity:0,
	 follow:[false,false],
	 modalClose: false,
	 position:[position.left+25, position.top+25]
 });
}

$(function() {
	var total = $('input[name=details_chk]').length;
	var checked = $('input[name=details_chk]:checked').length;

	if(total != checked) {
		$('#allCheck').prop('checked', false);
	} else {
		$('#allCheck').prop('checked', true);
	}

	$('#allCheck').click(function() {
		if($('#allCheck').is(':checked')) {
			$('input[name=details_chk]').prop('checked', true);
		} else {
			$('input[name=details_chk]').prop('checked', false);
		}
	})

	$('input[name=details_chk]').click(function() {
		var total = $('input[name=details_chk]').length;
		var checked = $('input[name=details_chk]:checked').length;

		if(total != checked) {
			$('#allCheck').prop('checked', false);
		} else {
			$('#allCheck').prop('checked', true);
		}
	})
})
</script>
</html>

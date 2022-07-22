<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<style>
	p, div, span, a, a:hover, a:visited, a:active, label, input, h1,h2,h3,h4,h5,h6{font-family: "Noto Sans KR";}
  .list-input {
    box-sizing: border-box;
    width: 100%;
    height: 100%;
    border:none;
  }
  .modify_input {
    background-color: rgb(240, 128, 128);
  }
  .del_row {
    background-color: orange !important;
  }
  .del_row input {
    background-color: orange !important;
  }
  .new_row input {
    border: thin green solid;
  }
  .month_tbl td{
    height:25px !important;
  }
  .tableWrapper {
    height:auto;
    max-height: 700px;
    overflow: auto;
  }
  #site_tbl th {
    position: sticky;
    top: 0px;
    background-color: #F4F4F4;
  }
  /* 세금계산서 우클릭 메모입력 선택 */
    .contextmenu {
    display: none;
    position: absolute;
    min-width: 200px;
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
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<script type="text/javascript" src="/misc/js/xlsx.full.min.js"></script>
<script type="text/javascript" src="/misc/js/jquery.bpopup-0.1.1.min.js"></script>
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
						<?php if($search_company == '망고'){
							$t = '더';
						} else {
							$t = '';
						} ?>
						사이트관리 (<?php echo $search_group.'-'.$t.$search_company; ?>)
          </td>
        </tr>
				<tr>
					<td height="70"></td>
				</tr>
				<tr height="13%">
          <td style="width:100%;">
            <select class="select-common" id="group" style="width:auto;" <?php if($pGroupName == '영업본부') {echo 'disabled';} ?> onchange="groupChange(this);">
              <option value="경영지원실" <?php if($search_group == '경영지원실'){echo 'selected';} ?>>경영지원실</option>
              <option value="영업본부" <?php if($search_group == '영업본부'){echo 'selected';} ?>>영업본부</option>
            </select>
            <select class="select-common" id="company" style="width:auto;">
              <option value="두리안정보기술" <?php if($search_company == '두리안정보기술'){echo 'selected';} ?>>두리안정보기술</option>
              <option value="두리안정보통신기술" <?php if($search_company == '두리안정보통신기술'){echo 'selected';} ?>>두리안정보통신기술</option>
							<?php if($search_group != '영업본부') { ?>
              <option value="망고" <?php if($search_company == '망고'){echo 'selected';} ?>>더망고</option>
							<?php } ?>
            </select>
            <input type="text" class="input-common" onkeypress="if( event.keyCode==13 ){GoSearch();}" id="search_input" placeholder="검색하세요." value="<?php echo str_replace('"', '&uml;', $searchkeyword );?>">
            <input type="button" class="btn-common btn-style2" value="검색" onclick="GoSearch();">
						<div style="width:33%;float:right;">
							<select class="select-common select-style1" id="listPerPage" style="height:25px;float:right;width:auto;" onchange="change_lpp();">
								<option value="5" <?php if($lpp==5){echo 'selected';} ?>>5건 / 페이지</option>
								<option value="10" <?php if($lpp==10){echo 'selected';} ?>>10건 / 페이지</option>
								<option value="15" <?php if($lpp==15){echo 'selected';} ?>>15건 / 페이지</option>
								<option value="20" <?php if($lpp==20){echo 'selected';} ?>>20건 / 페이지</option>
								<option value="30" <?php if($lpp==30){echo 'selected';} ?>>30건 / 페이지</option>
								<option value="50" <?php if($lpp==50){echo 'selected';} ?>>50건 / 페이지</option>
								<option value="100" <?php if($lpp==100){echo 'selected';} ?>>100건 / 페이지</option>
							</select>
						</div>
          </td>
        </tr>
				<tr style="max-height:45%">
					<td colspan="2" valign="top" style="padding:10px 0px;">
						<table class="content_dash_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td align="center" valign="top">
									<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
									<form name="mform" action="<?php echo site_url();?>/admin/management/site_management" method="get" onkeydown="if(event.keyCode==13) return GoSearch();">
  									<input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
                    <input type="hidden" name="lpp" value="<?php echo $no_page_list; ?>">
                    <input type="hidden" id="search_group" name="search_group" value="<?php echo $search_group; ?>">
                    <input type="hidden" id="search_company" name="search_company" value="<?php echo $search_company; ?>">
                    <input type="hidden" id="searchkeyword" name="searchkeyword" value="<?php echo str_replace('"', '&uml;', $searchkeyword );?>">
                	</form>
								        <tr>
								            <!--내용-->
								             <!--리스트-->
								              <tr>
								                <td>
                                  <div class="tableWrapper">
																		<table width="100%" id="site_tbl" class="month_tbl" border="0" cellspacing="0" cellpadding="0">
										                  <colgroup>
																				<col width="2%" />
														            <col width="2%" />
																				<col width="2%" />
										                    <col width="17%" />
										                    <col width="19%" />
										                    <col width="8%" />
														            <col width="8%" />
										                    <col width="12%" />
																				<col width="12%" />
										                    <col width="8%" />
										                    <col width="8%" />
										                    <col width="2%" />
										                  </colgroup>
                                      <thead>
                                        <tr class="t_top row-color1">
                                          <th></th>
                                          <th height="40" align="center">
                                            <input type="checkbox" id="allCheck" onchange="checkAll(this);" />
                                          </th>
																					<th align="center">순번</th>
                                          <th align="center">사이트 명</th>
                                          <th align="center">web주소</th>
                                          <th align="center">아이디</th>
                                          <th align="center">비밀번호</th>
                                          <th align="center">비고1</th>
																					<th align="center">비고2</th>
                                          <th align="center">최종 수정자</th>
                                          <th align="center">최종 수정일</th>
                                          <th></th>
                                        </tr>
                                      </thead>
                                      <tbody id="site_list">
  												<?php
  													if ($count > 0) {
  														$i = 1 + $no_page_list * ( $cur_page - 1 );
  														$icounter = 0;

  														foreach ( $view_val as $item ) {
  												?>
  										                  <tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'" seq="<?php echo $item['seq']; ?>" class="existing_row">
  																				<td></td>
  										                    <td align="center">
                                            <input type="checkbox" class="delRow" name="delRow" id="rowCheck" onchange="delRowCheck(this);"/>
                                          </td>
																					<td align="center">
                                            <?php echo $i?>
																					</td>
  										                    <td align="center">
                                            <input type="text" class="list-input" name="site_name" value="<?php echo $item['site_name'];?>" title="<?php echo $item['site_name'];?>" onchange="inputModify(this, <?php echo $item['seq']; ?>);">
                                          </td>
  										                    <td align="center">
                                            <input type="text" class="list-input" name="site_url" value="<?php echo $item['site_url'];?>" title="<?php echo $item['site_url'];?>" onchange="inputModify(this, <?php echo $item['seq']; ?>);">
                                          </td>
  										                    <td align="center">
                                            <input type="text" class="list-input" name="id" value="<?php echo $item['id'];?>" title="<?php echo $item['id'];?>" onchange="inputModify(this, <?php echo $item['seq']; ?>);">
                                          </td>
  										                    <td align="center">
                                            <input type="text" class="list-input" name="password" value="<?php echo $item['password'];?>" title="<?php echo $item['password'];?>" onchange="inputModify(this, <?php echo $item['seq']; ?>);">
                                          </td>
  										                    <td align="center">
                                            <input type="text" class="list-input" name="note1" value="<?php echo $item['note1'];?>" title="<?php echo $item['note1'];?>" onchange="inputModify(this, <?php echo $item['seq']; ?>);">
                                          </td>
																					<td align="center">
                                            <input type="text" class="list-input" name="note2" value="<?php echo $item['note2'];?>" title="<?php echo $item['note2'];?>" onchange="inputModify(this, <?php echo $item['seq']; ?>);">
                                          </td>
  										                    <td align="center"><?php echo $item['modifier']; ?></td>
  																				<td align="center"><?php echo $item['modify_date'];?></td>
  																				<td></td>
  										                  </tr>
  									             <?php
  															$i++;
  															$icounter++;
  														}
  													} ?>
                                      </tbody>
									                	</table>
                                  </div>
																</td>
								              </tr>
									              <!--//리스트-->
									            <!--//내용-->
									        </tr>

									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<!--페이징-->
				<tr>
					<td align="center">
<?php if ($count > 0) {?>
	<table width="400" border="0" cellspacing="0" cellpadding="0">
						<tr>
	<?php
		if ($cur_page > 10){
	?>
							<td width="19"><a href="JavaScript:GoFirstPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_last_left.svg" /></a></td>
							<td width="2"></td>
							<td width="19"><a href="JavaScript:GoPrevPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_left.svg" /></a></td>
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
		<td width="19"><a href="JavaScript:GoNextPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_right.svg"/></a></td>
							<td width="2"></td>
							<td width="19"><a href="JavaScript:GoLastPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_last_right.svg" /></a></td>
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
  <div style="width:95%;margin-bottom:50px;">
    <a href="/misc/excelFile/사이트관리_등록_양식.xlsx" download="사이트관리_등록_양식.xlsx">
			<button id="hideButton" class="btn-common btn-updownload" style="float: left;display:inline;width:140px;margin-right:10px;" type="button">엑셀 폼 다운로드
				<img src="/misc/img/download_btn.svg"  style="float:left; width:12px; padding:5px;">
			</button>
    </a>
    <input type="button" class="btn-common btn-style5" style="float:left;display:inline;width:90px;margin-right:10px;" onclick="newRow('add');" value="한줄추가" />
    <input type='button' class="btn-common btn-updownload" value='엑셀 다운로드' onclick="excelDownload();" style="float: right;display:inline;width:100px;padding-left:20px;width:auto;margin-left: -5px;"/>
		<img src="/misc/img/download_btn.svg" style="float:right;width:12px;position:relative;top:10px;left: 15px;padding-right:2px;">

    <input type='button' style="float: right;display:inline;width:90px;padding-left:20px;margin-left:-5px;" class="btn-common btn-updownload" onclick="$('#excelFile').click();" value="파일업로드" />
    <input style="display:none;" type="file" id="excelFile" onchange="excelExport(event)" />
		<img src="/misc/img/upload_btn.svg" style="float:right; width:12px; position:relative; top:10px; left:15px; padding: 2px;">

    <button class="btn-common btn-style3" style="float: right;display:inline;width:90px;margin-right:5px;" type="button" onclick="chkData();">저장</button>
    <button class="btn-common btn-color4" style="float: right;display:inline;width:90px;margin-right:10px;" type="button"name="button" onclick="deleteRow();">삭제</button>
  </div>
</div>

<div id="wrap-loading" style="z-index: 10000;display:none;">
  <img src="<?php echo $misc; ?>img/loading_img.gif" alt="Loading..." style="width:50px;border:0; position:absolute; left:50%; top:50%;" />
</div>

<!-- 엑셀용 테이블 -->
<table width="100%" id="excel_tbl" class="month_tbl" border="0" cellspacing="0" cellpadding="0" style="display:none;">
  <colgroup>
    <col width="4%" />
    <col width="18%" />
    <col width="18%" />
    <col width="10%" />
    <col width="10%" />
    <col width="10%" />
		<col width="10%" />
    <col width="10%" />
    <col width="10%" />
  </colgroup>
  <thead>
    <tr class="t_top row-color1" style="background-color:#F4F4F4">
      <th align="center">순번</th>
      <th align="center">사이트 명</th>
      <th align="center">web주소</th>
      <th align="center">아이디</th>
      <th align="center">비밀번호</th>
      <th align="center">비고1</th>
			<th align="center">비고2</th>
      <th align="center">최종 수정자</th>
      <th align="center">최종 수정일</th>
    </tr>
  </thead>
  <tbody id="excel_tbody"></tbody>
</table>

<ul class="contextmenu">
  <li class="memo_menu" id="memo_select_li"><a style="cursor:pointer;">사이트 이동</a></li>
</ul>
<!--하단-->
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
<!--//하단-->
</body>
<script language="javascript">
// 브라우저(IE) 체크
function isIE() {
  return navigator.userAgent.indexOf('MSIE') > -1 || navigator.appVersion.indexOf('Trident/') > -1
}

// IE 헤더 고정
if (isIE()) {
  function tableFixHead(ths) {
    var sT = this.scrollTop;
    [].forEach.call(ths, function(th) {
      th.style.transform = "translateY(" + sT + "px)";
    });
  }

  [].forEach.call(document.querySelectorAll(".tableWrapper"), function(el) {
    var ths = el.querySelectorAll("thead th");
    el.addEventListener("scroll", tableFixHead.bind(el, ths));
  });
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

function change_lpp(){
	var lpp = $("#listPerPage").val();
	document.mform.lpp.value = lpp;
	document.mform.cur_page.value = '';
	document.mform.submit();
}

function GoSearch() {
	$('#search_group').val($('#group').val());
	$('#search_company').val($('#company').val());
	$('#searchkeyword').val($('#search_input').val());

	document.mform.action = "<?php echo site_url();?>/admin/management/site_management";
	document.mform.cur_page.value = "";
	document.mform.submit();
}

// 수정한 행의 seq
var modifySeq = [];

// 수정 시 수정한 행의 seq 배열에 추가
function inputModify(el, seq) {
  if(!$(el).hasClass('modify_input')) {
    $(el).addClass('modify_input');
  }
  if($.inArray(seq, modifySeq) == -1) {
    modifySeq.push(seq);
  }
   console.log(modifySeq);
}

function checkAll(el) {
  delSeq = [];
  if (el.checked==true){
    $(".delRow").each(function(){
      $(this).attr("checked", "checked");
      $(this).closest('tr').addClass('del_row');
      delRowCheck(this);
    })
  } else {
    $(".delRow").each(function(){
      $(this).removeAttr("checked");
      $(this).closest('tr').removeClass('del_row');
      delRowCheck(this);
    })
  }
}

var delSeq = [];

function delRowCheck(el) {
  var allCnt = $(".delRow").length;
  var tr = $(el).closest('tr');
  var seq = tr.attr('seq');

  var checkedCnt = $(".delRow").filter(":checked").length;

  if (allCnt == checkedCnt) {
    $("#allCheck").attr("checked", "checked");
  } else {
    $("#allCheck").removeAttr("checked");
  }

  if(el.checked == true) {
    if(seq != undefined) {
      delSeq.push(seq);
    }
    tr.addClass('del_row');
  } else {
    if(seq != undefined) {
      delSeq.splice($.inArray(seq, delSeq),1);
    }
    tr.removeClass('del_row');
  }
}

function newRow() {
  var row = '';
  row += '<tr class="new_row"><td></td><td align="center"><input type="checkbox" class="delRow" name="delRow" id="rowCheck" onchange="delRowCheck(this);"/></td>';
	row += '<td></td>';
  row += '<td align="center"><input type="text" class="list-input" name="site_name"></td>';
  row += '<td align="center"><input type="text" class="list-input" name="site_url"></td>';
  row += '<td align="center"><input type="text" class="list-input" name="id"></td>';
  row += '<td align="center"><input type="text" class="list-input" name="password"></td>';
  row += '<td align="center"><input type="text" class="list-input" name="note1"></td>';
	row += '<td align="center"><input type="text" class="list-input" name="note2"></td>';
  row += '<td colspan="2"></td><td align="center"><img style="cursor:pointer;" src="/misc/img/dashboard/btn/icon_x.svg" onclick="delNewRow(this);"/></td></tr>';

  $('#site_list').append(row);
}

function delNewRow(el) {
  $(el).closest('tr').remove();
}

function chkData() {
  $('.new_row').each(function() {
    var site_name = $.trim($(this).find('input[name=site_name]').val());
    var site_url = $.trim($(this).find('input[name=site_url]').val());
    var id = $.trim($(this).find('input[name=id]').val());
    var password = $.trim($(this).find('input[name=password]').val());
    var note1 = $.trim($(this).find('input[name=note1]').val());
		var note2 = $.trim($(this).find('input[name=note2]').val());

    if ($.trim(site_name + site_url + id + password + note1 + note2) == '') {
      $(this).remove();
    }
  })

  saveList();
}

// 저장 버튼 클릭 시
function saveList() {
  if(confirm('저장하시겠습니까')) {
    $("#wrap-loading").bPopup({modalClose:false,opacity:0});
    var result = '';

    // 입력
    var nr = $('.new_row').length;
    if (nr > 0) {
      $('.new_row').each(function() {
        var mode = 'insert';
        var group = '<?php echo $search_group; ?>';
        var company = '<?php echo $search_company; ?>';
        var site_name = $(this).find('input[name=site_name]').val();
        var site_url = $(this).find('input[name=site_url]').val();
        var id = $(this).find('input[name=id]').val();
        var password = $(this).find('input[name=password]').val();
        var note1 = $(this).find('input[name=note1]').val();
				var note2 = $(this).find('input[name=note2]').val();

        $.ajax({
          type: "POST",
          url: "<?php echo site_url(); ?>/admin/management/site_management_save_action",
          dataType: "json",
          async: false,
          data: {
            mode: mode,
            group: group,
            company: company,
            site_name: site_name,
            site_url: site_url,
            id: id,
            password: password,
            note1: note1,
						note2: note2
          },
          success: function(data) {
            result = data;
          }
        })
      });
    }

    // 수정
    if (modifySeq.length > 0) {
      for(var i = 0; i < modifySeq.length; i++) {
        var tr = $('tr[seq='+modifySeq[i]+']');
        var mode = 'modify';
        var site_name = tr.find('input[name=site_name]').val();
        var site_url = tr.find('input[name=site_url]').val();
        var id = tr.find('input[name=id]').val();
        var password = tr.find('input[name=password]').val();
        var note1 = tr.find('input[name=note1]').val();
				var note2 = tr.find('input[name=note2]').val();

        $.ajax({
          type: "POST",
          url: "<?php echo site_url(); ?>/admin/management/site_management_save_action",
          dataType: "json",
          async: false,
          data: {
            mode: mode,
            seq: modifySeq[i],
            site_name: site_name,
            site_url: site_url,
            id: id,
            password: password,
            note1: note1,
						note2: note2
          },
          success: function(data) {
            result = data;
          }
        })
      }
    }

    if(result == 'true') {
      alert('저장을 성공하였습니다.');
      location.reload();
    } else {
      alert('저장을 실패하였습니다.');
      location.reload();
    }

  }

}

// 삭제 버튼 클릭 시
function deleteRow() {
  if(delSeq.length == 0) {
    alert('선택한 행이 없습니다.');
    return false;
  }

  if(confirm('선택한 ' + delSeq.length + '행을 삭제하시겠습니까')) {
    var result = '';

    $.ajax({
      type: "POST",
      url: "<?php echo site_url(); ?>/admin/management/site_management_delete_action",
      dataType: "json",
      async: false,
      data: {
        delSeq: delSeq
      },
      success: function(data) {
        console.log(data);
        if(data) {
          alert('삭제되었습니다.');
          location.reload();
        }
      }
    })
  }
}

function groupChange(el) {
  if($(el).val() == '영업본부') {
    $('#company').empty();
		$('#company').append('<option value="두리안정보기술">두리안정보기술</option><option value="두리안정보통신기술">두리안정보통신기술</option>');
  } else if ($(el).val() == '경영지원실') {
		$('#company').empty();
		$('#company').append('<option value="두리안정보기술">두리안정보기술</option><option value="두리안정보통신기술">두리안정보통신기술</option><option value="망고">더망고</option>');
  }
}

function excelExport(event) {
  var input = event.target;
  var reader = new FileReader();
  var rABS = !!reader.readAsBinaryString;
  var len = 0;

  reader.onload = function() {
    var fileData = reader.result;

    if ( (navigator.appName == 'Netscape' && navigator.userAgent.search('Trident') != -1) || (agent.indexOf("msie") != -1) ) {
      var fileData = reader.result;
      if(!rABS) fileData = new Uint8Array(fileData);
      var wb = XLSX.read(fileData, {
        type: rABS ? 'binary' : 'array',
        cellDates: true,
        cellNF: false,
        cellText: false
      });
      } else {
        var fileData = reader.result;
        var wb = XLSX.read(fileData, {
          type: 'binary',
          cellDates: true,
          cellNF: false,
          cellText: false
        });
      }

  // Sun Apr 26 2015 23:59:08 GMT+0900 (대한민국 표준시)
  wb.SheetNames.forEach(function(sheetName) {
    var rowObj = XLSX.utils.sheet_to_json(wb.Sheets[sheetName], {
      raw: false,
      dateNF: 'YYYY-MM-DD'
    });
    len = len + rowObj.length; // 엑셀 임포트한 길이
    var row = '';

    for (var i = 0; i < len; i++) {
      row += '<tr class="new_row"><td></td><td align="center"><input type="checkbox" class="delRow" name="delRow" id="rowCheck" onchange="delRowCheck(this);"/></td>';
			row += '<td></td>'
      row += '<td align="center"><input type="text" class="list-input" name="site_name" value="'+rowObj[i].사이트명+'"></td>';
      row += '<td align="center"><input type="text" class="list-input" name="site_url" value="'+rowObj[i].web주소+'"></td>';
      row += '<td align="center"><input type="text" class="list-input" name="id" value="'+rowObj[i].아이디+'"></td>';
      row += '<td align="center"><input type="text" class="list-input" name="password" value="'+rowObj[i].비밀번호+'"></td>';
      row += '<td align="center"><input type="text" class="list-input" name="note1" value="'+rowObj[i].비고1+'"></td>';
			row += '<td align="center"><input type="text" class="list-input" name="note2" value="'+rowObj[i].비고2+'"></td>';
      row += '<td colspan="2"></td><td align="center"><img style="cursor:pointer;" src="/misc/img/dashboard/btn/icon_x.svg" onclick="delNewRow(this);"/></td></tr>';
    }
      var contents = row.replace(/undefined/g, '');
      $('#site_list').append(contents);
    })
  };

  var agent = navigator.userAgent.toLowerCase();

  if ( (navigator.appName == 'Netscape' && navigator.userAgent.search('Trident') != -1) || (agent.indexOf("msie") != -1) ) {
    reader.readAsArrayBuffer(input.files[0]);
  } else {
    reader.readAsBinaryString(input.files[0]);
  }
}

function excelDownload() {
  $.ajax({
    type: "POST",
    url: "<?php echo site_url(); ?>/admin/management/site_management_excel",
    dataType: "json",
    async: false,
    data: {
      search_group: '<?php echo $search_group ?>',
      search_company: '<?php echo $search_company ?>',
      searchkeyword: '<?php echo $searchkeyword ?>'
    },
    success: function(data) {
      console.log(data);
      if(data) {
        var contents = '';
        for(var i = 0; i < data.length; i++) {
					if(data[i].note1 == null) {
						data[i].note1 = '';
					}
					if(data[i].note2 == null) {
						data[i].note2 = '';
					}
          contents += '<tr>';
          contents += '<td align="center">'+(i+1)+'</td>';
          contents += '<td align="left">'+data[i].site_name+'</td>';
          contents += '<td align="left">'+data[i].site_url+'</td>';
          contents += '<td align="left">'+data[i].id+'</td>';
          contents += '<td align="left">'+data[i].password+'</td>';
          contents += '<td align="left">'+data[i].note1+'</td>';
					contents += '<td align="left">'+data[i].note2+'</td>';
          contents += '<td align="left">'+data[i].modifier+'</td>';
          contents += '<td align="left">'+data[i].modify_date+'</td>';
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
      var fileName = '<?php echo $search_group; ?>_사이트관리.xls';
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

$("input[name=site_url]").contextmenu(function(e){
  $('#memo_select_li').attr('onclick', 'go_site("'+$.trim($(this).val())+'")');
  $("#memo_select_li").show();
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
    posLeft = posX - menuWidth - secMargin;
    posTop = posY - menuHeight - secMargin;
  }
  else if(posX + menuWidth + secMargin >= winWidth){
    //Case 2: right overflow:
    posLeft = posX - menuWidth - secMargin;
    posTop = posY + secMargin;
  }
  else if(posY + menuHeight + secMargin >= winHeight){
    //Case 3: bottom overflow:
    posLeft = posX + secMargin;
    posTop = posY - menuHeight - secMargin;
  }
  else {
    //Case 4: default values:
    posLeft = posX + secMargin;
    posTop = posY + secMargin;
  };
  //Display contextmenu:
  $(".contextmenu").css({
    "left": posLeft - 60 + "px",
    "top": posTop - 70 + "px"
  }).show();
  //Prevent browser default contextmenu.
  return false;
});
// Hide contextmenu:
// $(document).not("ul.contextmenu").click(function(){
//   $(".contextmenu").hide();
// });
$(document).mouseup(function (e){
   var LayerPopup = $(".contextmenu");
   if(LayerPopup.has(e.target).length === 0){
     $(".contextmenu").hide();
   }
 });
Mousetrap.bind('esc', function(e) {
  $(".contextmenu").hide();
});

function go_site(url) {
  if(url.indexOf('http') != -1) {
    window.open(url, '_blank');
  } else {
    window.open('https://' + url, '_blank');
  }

}
</script>
</html>

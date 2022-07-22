<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
  if($searchkeyword != '') {
  	$filter = explode(',', $searchkeyword); // 문자열 분리하여 배열로 저장
  }
  ?>
  <link rel="stylesheet" href="/misc/css/view_page_common.css">
  <style>
  #mask {
  		position: absolute;
  		left: 0;
  		top: 0;
  		z-index: 999;
  		background-color: #000000;
  		display: none;
  	}
  .layerpop {
      display: none;
      z-index: 1000;
      border: 2px solid #ccc;
      background: #fff;
      cursor: move; }

  .layerpop_area .title {
      font-size: 24px;
      font-weight: bold;
  		margin-top:30px;
  		margin-bottom:40px;
  		margin-left:35px;
  		color:#1C1C1C;
  		float:left;
  	}

  .layerpop_area .layerpop_close {
      width: 25px;
      height: 25px;
      display: block;
      position: absolute;
      top: 10px;
      right: 10px;
      background: transparent url('btn_exit_off.png') no-repeat; }

  .layerpop_area .layerpop_close:hover {
      background: transparent url('btn_exit_on.png') no-repeat;
      cursor: pointer; }

  .layerpop_area .content {
      width: 96%;
      margin: 2%;
      color: #828282; }

  .modal_tbl td {
  	border: thin solid #DFDFDF !important;
  }
  .search_title {
  	margin-right:10px;
  	font-weight:bold;
  	font-size: 14px;
  }
  .search_title:not(:first-child) {
  	margin-left:10px;
  }
  .filtercolumn {
  	width:100px;
  }
  .datepicker {
  	z-index: 10000 !important;
  }
  #icon_inf p {
  	font-size: 14px;
  	line-height: 0.7;
  }

  #icon_inf .title {
  	font-weight: bold;
  	font-size: 16px;
  	padding-top:10px;
  }

  #icon_inf .content {
  	color: #B0B0B0;
  	padding-left: 10px;
  }
  </style>
  <link rel="stylesheet" href="/misc/css/bootstrap-datepicker.css"> <!-- 달력 표시 css (datepicker) -->
  <script type="text/javascript" src="/misc/js/bootstrap-datepicker.js"></script> <!--  달력 표시 js (datepicker) -->
<script type="text/javascript">
// datepicker
$(function(){
	$('.datepicker').datepicker();
})
</script>
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">
<body>
<form name="mform" action="<?php echo site_url();?>/biz/approval/tech_doc_attachment" method="get" onKeyDown="if(event.keyCode==13) return GoSearch();">
  <table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
  <input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
  <input type="hidden" id ="seq" name="seq" value="<?php echo $seq; ?>">
  <input type="hidden" id="check" name="check" value="">
  <input type="hidden" id="searchkeyword" name="searchkeyword" value="<?php echo $searchkeyword; ?>">
  <!-- vlaue값이 비어있으면 페이지 이동하면 값이 넘어가지않아서(비어있어서) 검색이 안됨 -->
  <input type="hidden" name="mode" value="">
  <input type="hidden" name="type" id="type" value="<?php echo $type; ?>">
<table width="90%" height="100%" cellspacing="0" cellpadding="0" style="margin-left:30px;">
	<tr>
		<td width="100%" align="center" valign="top">
			<!--내용-->
			<table width="100%" border="0" style="margin-top:50px; margin-bottom: 50px;">
				<!--타이틀-->
				<tr>
					<td class="title3">기술지원보고서</td>
				</tr>
				<!--//타이틀-->
				<tr>
					<td>&nbsp;</td>
				</tr>

        <tr height="10%">
        <td align="left" valign="bottom">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:70px;">
              <tr>

          			<td align="left" valign="bottom">
          				<span class="search_title" style="margin-right:10px;">고객사</span>
          				<input type="text" id="filter1" class="input-common filtercolumn" value="<?php if(isset($filter)){echo $filter[0];} ?>">
          				<span class="search_title" style="margin-right:10px;">작성자</span>
          				<input type="text" id="filter2" class="input-common filtercolumn" value="<?php if(isset($filter)){echo $filter[1];} ?>">
          				<span class="search_title" style="margin-right:10px;">작업명</span>
          				<input type="text" id="filter3" class="input-common filtercolumn" value="<?php if(isset($filter)){echo $filter[2];} ?>">
          				<span class="search_title" style="margin-right:10px;">장비명</span>
          				<input type="text" id="filter6" class="input-common filtercolumn" value="<?php if(isset($filter)){echo $filter[5];} ?>">
          				<span class="search_title" style="margin-right:10px;display:none;">작성일</span>
          				<input type="text" id="filter4" style="display:none;" class="input-common filtercolumn datepicker" value="<?php if(isset($filter)){echo $filter[3];} ?>">
          			</td>
          		</tr>
          		<tr>
          			<td style="padding-top:10px;">
          				<span class="search_title">지원내역</span>
          				<input type="text" id="filter7" class="input-common filtercolumn" value="<?php if(isset($filter)){echo $filter[6];} ?>">
          				<span class="search_title">지원구분</span>
          				<!-- <input type="text" id="filter9" class="input-common filtercolumn" value="<?php if(isset($filter)){echo $filter[8];} ?>"> -->
          				<select name="result" id="filter9" class="select-common select-style1 filtercolumn" style="width:auto;">
          					<option value="">지원구분</option>
          					<option value="정기점검2" <?php if(isset($filter) && $filter[8] == '정기점검2'){echo 'selected="selected"';}?>>정기점검2</option>
          					<option value="교육지원" <?php if(isset($filter) && $filter[8] == '교육지원'){echo 'selected="selected"';}?>>교육지원</option>
          					<option value="교육참석" <?php if(isset($filter) && $filter[8] == '교육참석'){echo 'selected="selected"';}?>>교육참석</option>
          					<option value="장애지원" <?php if(isset($filter) && $filter[8] == '장애지원'){echo 'selected="selected"';}?> >장애지원</option>
          					<option value="설치지원" <?php if(isset($filter) && $filter[8] == '설치지원'){echo 'selected="selected"';}?>>설치지원</option>
          					<option value="기술지원" <?php if(isset($filter) && $filter[8] == '기술지원'){echo 'selected="selected"';}?>>기술지원</option>
          					<option value="납품설치" <?php if(isset($filter) && $filter[8] == '납품설치'){echo 'selected="selected"';}?>>납품설치</option>
          					<option value="미팅" <?php if(isset($filter) && $filter[8] == '미팅'){echo 'selected="selected"';}?>>미팅</option>
          					<option value="데모(BMT)지원" <?php if(isset($filter) && $filter[8] == '데모(BMT)지원'){echo 'selected="selected"';}?>>데모(BMT)지원</option>
          	  		</select>
          				<span class="search_title">제조사</span>
          				<select name="result" id="filter10" class="select-common select-style1 filtercolumn" style="width:auto;">
          					<option value="" >제조사</option>
          					<?php foreach($product_company as $pc) { ?>
          						<option value="<?php echo $pc['product_company'] ?>" <?php if(isset($filter) && $filter[9] == $pc['product_company']) {echo 'selected';} ?>><?php echo $pc['product_company']; ?></option>
          					<?php } ?>
          				</select>
          				<span class="search_title">작성일 (시작)</span>
          				<!-- <input type="text" id="filter11" class="input-common filtercolumn" value="<?php if(isset($filter)){echo $filter[10];} ?>"> -->
          				<input type="text" id="filter11" class="input-common filtercolumn datepicker" value='<?php if(isset($filter)){echo $filter[10];} ?>' autocomplete="off"/>
          					~
          				<span class="search_title">작성일 (종료)</span>
          				<input type="text" id="filter12" class="input-common filtercolumn datepicker" value='<?php if(isset($filter)){echo $filter[11];} ?>' autocomplete="off"/>


          			</td>
          		</tr>
          		<tr>
          			<td style="padding-top:10px;">
          				<span class="search_title" style="margin-right:23px;">결과</span>
          				<select name="result" id="filter5" class="select-common select-style1 filtercolumn" style="width:auto;">
          					<option value="">기술지원 결과</option>
          					<option value="기술지원 완료(100% 진행)" <?php if(isset($filter) && $filter[4] == "기술지원 완료(100% 진행)"){echo 'selected';} ?>>기술지원 완료(100% 진행)</option>
          					<option value="기술지원 미완료(90% 진행)" <?php if(isset($filter) && $filter[4] == "기술지원 미완료(90% 진행)"){echo 'selected';} ?>>기술지원 미완료(90% 진행)</option>
          					<option value="기술지원 미완료(70% 진행)" <?php if(isset($filter) && $filter[4] == "기술지원 미완료(70% 진행)"){echo 'selected';} ?>>기술지원 미완료(70% 진행)</option>
          					<option value="기술지원 미완료(50% 진행)" <?php if(isset($filter) && $filter[4] == "기술지원 미완료(50% 진행)"){echo 'selected';} ?>>기술지원 미완료(50% 진행)</option>
          					<option value="기술지원 미완료(30% 진행)" <?php if(isset($filter) && $filter[4] == "기술지원 미완료(30% 진행)"){echo 'selected';} ?>>기술지원 미완료(30% 진행)</option>
          					<option value="기술지원 미완료(10% 진행)" <?php if(isset($filter) && $filter[4] == "기술지원 미완료(10% 진행)"){echo 'selected';} ?>>기술지원 미완료(10% 진행)</option>
          					<option value="교육완료" <?php if(isset($filter) && $filter[4] == "교육완료"){echo 'selected';} ?>>교육완료</option>
          					<option value="미팅완료" <?php if(isset($filter) && $filter[4] == "미팅완료"){echo 'selected';} ?>>미팅완료</option>
          	  		</select>
          				<span class="search_title">#해시태그</span>
          				<input style="width:350px;" type="text" id="filter8" class="input-common filtercolumn" value="<?php if(isset($filter)) {echo $filter[7];} else if ($hashtag != '') {echo "#".$hashtag;} ?>" placeholder="#홍길동  #두리안정보기술  #2022-01-01">
          				<span class="search_title" style="vertical-align:middle;<?php if($type == 'N'){echo 'display:none;';} ?>">우수 보고서 보기</span>
          				<input type="checkbox" name="excellent_report_yn" class="excellent_report_yn" value="Y" style="vertical-align:middle;<?php if($type == 'N'){echo 'display:none;';} ?>" <?php if($excellent_report_yn == 'Y'){echo "checked";} ?>>

          				<!-- <input type="text" class="input-common" style="width:250px;margin-left:20px;" placeholder="검색하세요" value=""> -->
          				<input type="button" id="search_btn" class="btn-common btn-style2" style="margin-left:10px;" value="검색" onclick="search_data()">
          				<img style="cursor:pointer;vertical-align:middle;" src="/misc/img/dashboard/btn/btn_info.svg" width="25" onclick="open_inf(this);"/>
          			</td>
            </tr>
          </table>
        </td>
        </tr>

				<!--작성-->
        <tr height="45%">
        <td valign="top" style="padding:10px 0px;">
        	<table class="content_dash_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
        		<tr>
        			<td>
        				<table class="list_tbl" style="margin-top:20px;" width="100%" border="0" cellspacing="0" cellpadding="0">
        					<colgroup>
        						<col width="5%">
        						<col width="5%">
        						<col width="15%">
        						<col width="35%">
        						<col width="10%">
        						<col width="10%">
        						<col width="10%">
        						<col width="5%">
        						<col width="5%">
        					</colgroup>

        					<tr class="t_top row-color1">
        						<th></th>
        						<th height="40" align="center">NO</th>
        						<th align="center">고객사</th>
        						<th align="center">작업명</th>
        						<th align="center">작성자</th>
        						<th align="center">작성일</th>
        						<th align="center">결과</th>
        						<th align="center">첨부</th>
        						<th></th>
        					</tr>
        					<?php
        					if ($count > 0) {
        						$i = $count - $no_page_list * ( $cur_page - 1 );
        						$icounter = 0;

        						foreach ( $list_val as $item ) {

        							if($item['file_changename']) {
        								$strFile = "<img src='".$misc."img/add.png' width='20' height='20' />";
        							} else {
        								$strFile = "-";
        							}


        							?>
        							<tr onMouseOver="this.style.backgroundColor='#EAEAEA'" onMouseOut="this.style.backgroundColor='#fff'">
        								<td align="center">
                          <input type='checkbox' name='attachment_check' value='<?php echo $item['seq']; ?>--<?php echo $item['customer'].'_'.$item['subject']; ?>' onchange='check_change(this);'>
                        </td>
        								<td height="40" align="center">
        									<?php echo $i;?></td>
        									<td align="center">
      											<?php echo $item['customer'];?>
        									</td>
        									<td align="center">
        										<?php echo $item['subject'];?>
        									</td>
        									<td align="center">
        										<?php echo $item['writer'];?>
        									</td>
        									<td align="center">
        										<?php echo substr($item['income_time'], 0, 10);?>
        									</td>
        									<td align="center">
        										<?php echo $item['result'];?>
        									</td>
        									<td align="center">
        										<?php echo $strFile;?>
        									</td>
        									<td></td>
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
        							<tr>

        							</tr>
        							<?php
        						}
        						?>
        				</table>
        			</td>
        		</tr>

        	</table>
        </td>
        </tr>
    <!-- 페이징 부분 시작 -->
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
    // $strSection = "&nbsp;<span class=\"section\">|</span>&nbsp;";
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
    <!-- <td width="19"><a href="JavaScript:GoNextPage()"><img src="<?php echo $misc;?>img/dashboard/page_next.png" width="20" height="20"/></a></td> -->
    		<td width="2"></td>
    		<td width="19"><a href="JavaScript:GoNextPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_right.png" width="20" height="20"/></a></td>
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
    </td>
    </tr>
    </table>
    </td>
    </tr>
  </form>
          <!-- 페이징처리끝 -->
	<!--버튼-->
	<tr>
		<td align="right">
         <input type="image" src="<?php echo $misc; ?>img/btn_ok.jpg" width="64" height="31" style="cursor:pointer" onclick="attachment_ok();" />
         <input type="image" src="<?php echo $misc; ?>img/btn_cancel.jpg" width="64" height="31" style="cursor:pointer" onclick="cancel();return false;" />
		</td>
	</tr>
</table>
</body>
<script>
function GoFirstPage (){
  document.mform.cur_page.value = 1;
  document.mform.submit();
}

function GoPrevPage (){
  var cur_start_page = <?php echo $cur_page;?>;

  document.mform.cur_page.value = Math.floor( ( cur_start_page - 11 ) / 10 ) * 10 + 1;
  document.mform.submit( );
}

function GoPage(nPage){
  document.mform.cur_page.value = nPage;
  document.mform.submit();
}

function GoNextPage (){
  var cur_start_page = <?php echo $cur_page;?>;

  document.mform.cur_page.value = Math.floor( ( cur_start_page + 9 ) / 10 ) * 10 + 1;
  document.mform.submit();
}

function GoLastPage (){
  var total_page = <?php echo $total_page;?>;
//  alert(total_page);

  document.mform.cur_page.value = total_page;
  document.mform.submit();
}

//검색버튼 눌렀을때
function search_data() {
  var column_cnt = $('.filtercolumn').length; // 다중검색 몇개 했는지 길이 구했어
  var search = [];
  for(var i = 1; i <= column_cnt; i++) {
    var text = $.trim($('#filter'+i).val()); // 반복문 돌면서 공백제거하고 filter i번째의 value갖고와
    search.push(text); //search배열에 담아
  }
  var search_string = search.join(','); // ,를 기준으로 한 문자열로 합치기
  if(search_string.replace(/,/g, '') == '' && $('input[name=excellent_report_yn]').is(":checked") == false) { //배열을 문자열로 바꾸면서 [, , , , ,] 가 " , , , , ," 로 되면서 ,들을 다시 공백으로 replace(모든,를 ''으로 바꾸는 정규식)해주고 그제서야 조건문에 if (변수 == '') 이렇게 쓸수있옹
    alert('검색어가 없습니다.');
    location.href="<?php echo site_url(); ?>/biz/approval/tech_doc_attachment";
    return false;
  }
  $('#searchkeyword').val(search_string);
  document.mform.cur_page.value = 1; // 항상 1페이지부터 띄우기 위해 1로 고정
  document.mform.submit(); //컨트롤러로 form 전송
}


// enter키로 검색가능
$(document).ready(function(){
  $("#search_tbl").keydown(function(e){
    if(e.keyCode == 13){
      $("#search_btn").click()
    }
  })
})

   function attachment_ok(){
      var chk_val = $('#check').val();
      if(chk_val == '') {
        alert('선택된 보고서가 없습니다.');
        return false;
      } else {
        var attachement_seq = chk_val.split('--')[0];
        var attachement_doc_name = chk_val.split('--')[1];
        var approval_form_seq = window.opener.$('#approval_form_seq').val();
        if($('#attach_tech_doc_'+attachement_seq, opener.document).length == 0) {
          text1 = attachement_seq;
          text2 = "<div id='attach_tech_doc_"+attachement_seq+"'><span name='attach_name'>"+attachement_doc_name+"</span><img src='/misc/img/btn_search.jpg' style='width:18px;vertical-align:middle;cursor:pointer;margin:5px 0px 5px 10px;' onclick='tech_doc_view("+attachement_seq+")'/><img src='<?php echo $misc; ?>/img/btn_del2.jpg' style='vertical-align:middle;cursor:pointer;margin-left:5px;' onclick='attachTechDocRemove("+attachement_seq+")'/></div>";

          if(approval_form_seq == 56) {
            $.ajax({
              type:'POST',
              cache:false,
              url:"<?php echo site_url(); ?>/biz/approval/tech_doc_data",
              dataType:'json',
              async:false,
              data: {
                attach_seq: attachement_seq
              },
              success: function(data) {
                if(data) {
                  var start_time = data.start_time;
                  start_time = start_time.substr(0, 5);
                  if(start_time < '19:00') {
                    alert('작업시작시간이 19:00 이전입니다.\n근무시작시간이 19:00로 입력됩니다.');
                  }
                }
              }
            })
          }
        }

        if(text1 != '') {
          $('#approval_tech_doc_attach', opener.document).val(text1+'::'+attachement_doc_name);
          $('#approval_tech_doc_attach_list', opener.document).html(text2);
          window.opener.$('#approval_tech_doc_attach').trigger('change');
        }

        self.close();
      }
   }

   //취소버튼
   function cancel(){
      if(confirm("이 페이지에서 나가시겠습니까? 작성중인 내용은 저장 되지 않습니다.")){
         window.self.close();
      }else{
         return false;
      }
   }

  //체크 달라질때마다
  function check_change(el){
    $('input[name=attachment_check]').each(function() {
      $(this).prop('checked', false);
    })
    $(el).prop('checked', true);
    $('#check').val($(el).val());
  }
</script>
</html>

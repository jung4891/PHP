<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
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
</style>
<script language="javascript">

window.onload=function(){

change();

}



function change(){
  var search1 = document.getElementById("search1").selectedIndex;
  var searchkeyword2 = document.getElementById("searchkeyword2");

  if(search1==5){

    searchkeyword2.type="text";

  }else{

    searchkeyword2.type="hidden";

  }
}

function GoSearch(){
  var searchkeyword = document.mform.searchkeyword.value;
  var searchkeyword = searchkeyword.trim();

  var searchkeyword2 = document.mform.searchkeyword2.value;
  var searchkeyword2 = searchkeyword2.trim();
  if(searchkeyword == ""){
    alert( "검색어를 입력해 주세요." );
    return false;
  }
//  if(searchkeyword2 == ""){
 //   alert( "검색어를 입력해 주세요." );
   // return false;
 // }

	var type = "<?php echo $_GET['type']?>";
	document.mform.type.value = type;
  document.mform.action = "<?php echo site_url();?>/tech/tech_board/tech_doc_list";
  document.mform.cur_page.value = "";
//  document.mform.search_keyword.value = searchkeyword;
  document.mform.submit();
}

//$(document).ready(function() {
//   $('li > ul').show();
//});

function sendMail(){
  if($("#mail_send").val() != ''){
    var sendMailCheck = confirm("메일을 전송하시겠습니까?")
    if(sendMailCheck == true){
      $("input:checkbox").attr("disabled",true);
      $("input[name=cur_page]").attr("disabled",true);
      $("input[name=seq]").attr("disabled",true);
      $("input[name=search1]").attr("disabled",true);
      $("input[name=searchkeyword]").attr("disabled",true);
      $("input[name=searchkeyword2]").attr("disabled",true);
      $("input[name=mode]").attr("disabled",true);

      document.mform.mail_send.value = btoa(unescape(encodeURIComponent($("#mail_send").val().substring(1))));
      document.mform.action = "<?php echo site_url();?>/tech/tech_board/tech_report2_csv";
      document.mform.submit();
    }else{
      return false;
    }
  }else{
    alert("전송 할 기술지원보고서를 선택해주세요.");
  }

}
</script>

<!-- 체크해놓은 seq 가져오기 -->
<?php
$checkSeq ='';
  if($mail_send != ""){
    $mailInfo = explode('/',$mail_send);
    for($i=0; $i<count($mailInfo); $i++){
        $eachMail= explode('-',$mailInfo[$i]);
        $checkSeq = $checkSeq.','.$eachMail[0];

    }
    $checkSeq = substr($checkSeq,2);
    $checkSeq = explode(',',$checkSeq);
  }
?>


<body>
  <?php
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
<div align="center">
<div class="dash1-1">
	<form name="mform" action="<?php echo site_url();?>/tech/tech_board/tech_doc_list" method="get" onKeyDown="if(event.keyCode==13) return GoSearch();">
<table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
<input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
<input type="hidden" id ="seq" name="seq" value="<?php echo $seq; ?>">
<input type="hidden" name="mode" value="">
<input type="hidden" name="type" id="type" value="">

<!-- 타이틀 이미지 자리요 -->
<tr height="5%">
	<td class="dash_title">
		<div class="main_title">
			<?php if(isset($_GET['type'])){$type = $_GET['type'];}else{$type="request";} ?>
			<a onclick="register_yn('Y')" style='cursor:pointer;margin-right:10px;color:<?php if($type == "Y" || $type == ''){echo "#1C1C1C";}else{echo "#DEDEDE";}?>'>기술지원보고</a>
			<a onclick="register_yn('N')" style='cursor:pointer;margin-right:10px;color:<?php if($type == "N"){echo "#1C1C1C";}else{echo "#DEDEDE";}?>'>임시저장함</a>
		</div>
	</td>
</tr>
<!-- 타이틀 자리 끝이요 -->
<!-- 여기는 검색 자리요 -->
<tr height="10%">
<td align="left" valign="bottom">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:70px;">
		<tr>
			<!-- <td width="6.5%"></td> -->
			<td align="left" valign="bottom">
				<select name="search1" id="search1" class="select-common select-style1" style="margin-right:10px;" onChange="change();">
				<option value="002" <?php if($search1 == "002"){ echo "selected";}?>>고객사</option>
				<option value="003" <?php if($search1 == "003"){ echo "selected";}?>>작성자</option>
				<option value="001" <?php if($search1 == "001"){ echo "selected";}?>>작업명</option>
				<option value="004" <?php if($search1 == "004"){ echo "selected";}?>>작성일</option>
				<option value="005" <?php if($search1 == "005"){ echo "selected";}?>>결과</option>
				<option value="006" <?php if($search1 == "006"){ echo "selected";}?>>장비명</option>
			</select>

			<span>
			<input  type="text" size="25" class="input-common" name="searchkeyword" placeholder="검색하세요." value="<?php echo str_replace('"', '&uml;', $search_keyword );?>" style="margin-right:10px;"/>
							<input  type="hidden" size="25" class="input-common" name="searchkeyword2" id="searchkeyword2" placeholder="버전명을 입력하세요." value="<?php echo str_replace('"', '&uml;', $search_keyword2 );?>" style="margin-right:10px;" />
			</span>
			<!-- </td>
			<td> -->
			<span>
				<input type="image" style='cursor:hand; margin-bottom:8px;' onClick="return GoSearch();" src="<?php echo $misc;?>img/dashboard/btn/btn_search.png" width="20px" height="20px" align="middle" border="0" />
			</span>
			</td>
			<td align='right'>
				<input type="button" class="btn-common btn-color1" value="표지 등록" style="margin-right:10px;" onclick="coverUpload();"/>
				<input type="button" class="btn-common btn-color1" value="로고 등록" style="margin-right:10px;" onclick="logoUpload();"/>
				<?php if($parent_group == "기술본부" && $tech_lv > 0){ ?>
					<a onclick="open_schedule();">
						<input type="button" class="btn-common btn-color2" value="글쓰기">
					</a>
				<?php } ?>
				<?php if($parent_group == "CEO"){ ?>
					<a onclick="open_schedule();">
						<input type="button" class="btn-common btn-color2" value="글쓰기">
					</a>
				<?php } ?>
			</td>
		</tr>
	</table>
</td>
</tr>
<!-- 검색 끝이요 -->
<!-- 본문 자리요 -->
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
								<td></td>
								<td height="40" align="center">
									<!-- <input type="checkbox" name="<?php echo $item['customer'];?>" value="<?php echo '/'.$item['seq'].'-'.$item['customer_manager'].':'.$item['manager_mail'];?>*" <?php if($checkSeq <> ""){if(in_array($item['seq'],$checkSeq)){echo "checked";};}?> > -->
									<?php echo $i;?></td>

									<td align="center">
										<a href="JavaScript:ViewBoard('<?php echo $item['seq'];?>')">
											<?php echo $item['customer'];?>
										</a>
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

<!-- 본문 끝이요 -->
<!-- 페이징 들어갈 자리요 -->
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
<!-- 페이징 끝이오 -->


</table>
</form>
</div>
</div>

<!-- 일정선택 팝업창 시작 -->
<!-- 팝업뜰때 배경 -->
<div id="mask"></div>
<!--schedule detail Popup Start -->
<!-- <form class="" name="" action="index.html" method="post"> -->
<div id="schedule_popup" name="schedule_popup" class="layerpop" style="width: 700px; height: auto;">
<article class="layerpop_area" align="center">
<div class="title">일정 선택</div>
<table width="100%" border="0" callspacing="0" cellspacing="0">
	 <tr>
			 <td align="center">
				 <table class="list_tbl modal_tbl" border="0" cellspacing="0" cellpadding="0" style="width:90%" align="center">
				 <tr class="t_top row-color1">
					 <td width="5%" align="center">NO</td>
					 <td width="65%" align="center">일정</td>
					 <td width="15%" align="center">시작일</td>
					 <td width="15%" align="center">종료일</td>
				 </tr>
			 <?php
       $i = 1;
       foreach($schedule_list as $sl) { ?>
				 <tr style="cursor:pointer;" onMouseOver="this.style.backgroundColor='#EAEAEA'" onMouseOut="this.style.backgroundColor='#fff'" onclick="select_schedule(this);">
           <input type="hidden" id="schedule_seq" value="<?php echo $sl['seq']; ?>">
           <input type="hidden" id="start_day" value="<?php echo $sl['start_day']; ?>">
           <input type="hidden" id="end_day" value="<?php echo $sl['end_day']; ?>">
           <input type="hidden" id="customer_name" value="<?php echo $sl['customer']; ?>">
					 <td width="5%" height="10" align="center" style="color:#3c3c3c;"><?php echo $i; ?></td>
					 <td width="65%" align="left" style="color:#3c3c3c;">&nbsp;<?php echo "[".$sl['participant']."] ".$sl['customer']."/".$sl['work_name']."/".$sl['support_method']; ?></td>
					 <td width="15%" align="center" style="color:#3c3c3c;"><?php echo $sl['start_day'].'<br>'.$sl['start_time']; ?></td>
					 <td width="15%" align="center" style="color:#3c3c3c;"><?php echo $sl['end_day'].'<br>'.$sl['end_time']; ?></td>
				 </tr>
			 <?php
        $i++;
        } ?>
			 </table>
		 </td>
	 </tr>
	 <tr>
		 <td align="right">
			 <input type="button" class="btn-common btn-color1" value="취소" onclick="popupClose('schedule_popup');" style="margin-right:35px;margin-top:20px;margin-bottom:40px;">
		 </td>
	 </tr>
</table>
</article>
</div>
<!-- 일정 선택 팝업창 끝 -->
<!-- 팝업뜰때 배경 -->
<div id="mask2"></div>
<!--schedule detail Popup Start -->
<!-- <form class="" name="" action="index.html" method="post"> -->
<div id="show_day_select_popup" name="show_day_select_popup" class="layerpop" style="width: 700px; height: 470px;">
<article class="layerpop_area">
<div class="title">일정 선택</div>
<a href="javascript:popupClose('show_day_select_popup');" class="layerpop_close" id="layerbox_close"><img src="/misc/img/btn_del2.jpg"/></a>
<table width="100%" border="0" callspacing="0" cellspacing="0">
   <tr>
     <td colspan="10" height="2" bgcolor="#173162"></td>
   </tr>
   <tr>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td>
       <td align="center"><table border="0" cellspacing="0" cellpadding="0" style="">
         <colgroup>
           <col width="3%" />
           <col width="15%" />
           <col width="20%" />
           <col width="15%" />
         </colgroup>
         <tr>
           <td colspan="4" height="2" bgcolor="#797c88"></td>
         </tr>
         <tr style="cursor:default;" bgcolor="f8f8f9" class="t_top">
           <td height="40" align="center"></td>
           <td align="center" class="t_border">일차</td>
           <td align="center" class="t_border">작업일</td>
           <td align="center" class="t_border">보고서 작성</td>
         </tr>
         <tr>
           <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
         </tr>
         <tbody id="select_day_body"></tbody>
         <tr>
           <td colspan="4" height="2" bgcolor="#797c88"></td>
         </tr>
         <tr>
           <td>&nbsp;</td>
         </tr>
       </table>
       <div id="select_day_btn"></div>
     </td>
     </td>
   </tr>
</table>
</article>
</div>
<!--schedule insert Popup End -->
<script>
  $(document).ready(function(){
    $("input:checkbox").on('click', function() {
      if($("#mail_send").val() == ""){
          $("#seq").val("");
        if($("#seq").val() == ""){
          $("#seq").val($(this).attr('name'));
          $("#mail_send").val($("#mail_send").val()+$(this).val());
        }
      }else{
        if(($(this).attr('name')).trim() != ($("#seq").val()).trim()){
          alert("같은 고객사 끼리 선택해주세요");
          return false;
        }else{
          if($(this).attr('checked') != undefined){
            $("#mail_send").val($("#mail_send").val()+$(this).val());
          }else{
            $("#mail_send").val($("#mail_send").val().replace($(this).val(),'')); //체크 풀었을 때 지우는고
          }
        }
      }
    });
  });

  function coverUpload(){
    window.open('/index.php/tech/tech_board/cover_upload');
  }

  function logoUpload(){
    window.open('/index.php/tech/tech_board/logo_upload');
  }

  function getDateRange(startDate, endDate, listDate){
  	var dateMove = new Date(startDate);
  	var strDate = startDate;

  	if (startDate == endDate) {
  		var strDate = dateMove.toISOString().slice(0,10);
  		listDate.push(strDate);
  	} else {
  		while (strDate<endDate){
  			var strDate = dateMove.toISOString().slice(0,10);
  			listDate.push(strDate);
  			dateMove.setDate(dateMove.getDate() + 1);
  		}
  	}
  	return listDate;
  }

  function select_schedule(el){
    var schedule_seq = $(el).find("#schedule_seq").val();
    var sday = $(el).find("#start_day").val();
    var eday = $(el).find("#end_day").val();
		var customer_name = $(el).find("#customer_name").val();

		location.href='<?php echo site_url();?>/tech/tech_board/tech_doc_input?schedule_seq='+schedule_seq;
  }//함수 끝

  function select_day(schedule_seq){
    var income_day = '';
		var end_work_day = '';
  	$("input:checkbox[name=income_day]:checked").each(function(){
  		income_day = $(this).val();
  	})
		if (income_day == ''){
			alert('작성할 보고서의 작업일을 선택하세요.');
		} else {
 //수정 (기지보 일괄작성)
      var income = new Array();
      var income_day_arr = new Array();
      var i=0;
      $("input:checkbox[name=income_day]").each(function(index){
          if($(this).is(":checked")){
              income[i]=index;
              income_day_arr[i] = $(this).val();
              i++;
          }
      });
      if(income.length != 1){
        var temp = income[0];
        for(var k=1; k<income.length; k++){
            if(temp+k != income[k]){
              alert("연속된 일정만 보고서를 한번에 작성 가능합니다.");
              $("input:checkbox[name=income_day]").prop('checked',false);
              return false;
            }
        }
      }
      if (income.length>1){
        var income_day = income_day_arr[0];
        var end_work_day = income_day_arr[income_day_arr.length-1];
      }

			move(schedule_seq, income_day, end_work_day);
		}

  }

	function move(schedule_seq, income_day, end_work_day){

		$.ajax({
      url : "<?php echo site_url(); ?>/biz/schedule/find_seq_in_tech_doc_basic_temporary_save",
      type : "POST",
      dataType : "json",
      data : {
        seq : schedule_seq,
				income_time : income_day
      },
      cache : false,
      async : false,
      success : function(data){
        if(data != null){
          var con = confirm("임시저장된 기술지원보고서가 존재합니다.\n\n저장 내용을 불러오려면 확인 버튼을 눌러주세요.\n\n저장 내용을 삭제하고 새로 작성하려면 취소 버튼을 눌러주세요.");
          if(con){
						location.href = "<?php echo site_url(); ?>/tech/tech_board/tech_doc_view?mode=view&seq="+data+"&type=N";

          }else{
            $.ajax({
              url:"<?php echo site_url(); ?>/biz/schedule/tech_doc_basic_temporary_save_delete",
              type : "POST",
              dataType : "json",
              data : {
                schedule_seq : schedule_seq
              },
              success: function(data){
                if(data == 'true'){
                  alert('임시저장된 보고서가 삭제되었습니다.');
                  // move();
									location.href='<?php echo site_url();?>/tech/tech_board/tech_doc_input?schedule_seq='+schedule_seq+"&income_day="+income_day+"&end_work_day="+end_work_day;
                }
              }
            });
          }
        }else{ //data == null
          // move();
					location.href='<?php echo site_url();?>/tech/tech_board/tech_doc_input?schedule_seq='+schedule_seq+"&income_day="+income_day+"&end_work_day="+end_work_day;
        }
      }
    });
	}


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
		var type = "<?php echo $_GET['type']?>";
		document.mform.type.value = type;
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

	function ViewBoard (seq){
		var type = "<?php echo $_GET['type']?>";
		document.mform.type.value = type;
	  document.mform.action = "<?php echo site_url();?>/tech/tech_board/tech_doc_view";
	  // document.mform.action = "<?php echo site_url();?>/tech/tech_board/tech_doc_view?type="+type;
	  document.mform.seq.value = seq;
	  document.mform.mode.value = "view";
	  document.mform.submit();
	}

	function wrapWindowByMask() {
			 //화면의 높이와 너비를 구한다.
			 var maskHeight = $(document).height();
			 var maskWidth = $(window).width();

			 //마스크의 높이와 너비를 화면 것으로 만들어 전체 화면을 채운다.
			 $('#mask').css({
					 'width' : maskWidth,
					 'height' : maskHeight
			 });

			 //애니메이션 효과
			 $('#mask').fadeTo("slow", 0.5);
	 }

	 function popupOpen(open_popup_id) {
			 $('.layerpop').css("position", "absolute");
			 //영역 가운에데 레이어를 뛰우기 위해 위치 계산
			 $('.layerpop').css("top",(($(window).height() - $('.layerpop').outerHeight()) / 2) + $(window).scrollTop());
			 $('.layerpop').css("left",(($(window).width() - $('.layerpop').outerWidth()) / 2) + $(window).scrollLeft());
			 $('.layerpop').draggable();
			 $('#'+open_popup_id).show();




	 }


	 function popupClose(close_popup_id) {
			 $('#'+close_popup_id).hide();
			 $('#mask').hide();
	 }

	function open_schedule(){
		var open_popup_id = 'schedule_popup';
		popupOpen(open_popup_id); //레이어 팝업창 오픈
		wrapWindowByMask(); //화면 마스크 효과

	}

	function show_day_select() {
			var open_popup_id = 'show_day_select_popup';
			popupOpen(open_popup_id); //레이어 팝업창 오픈
			wrapWindowByMask(); //화면 마스크 효과
	}

	function register_yn(type){
	  location.href="<?php echo site_url();?>/tech/tech_board/tech_doc_list?type="+type;
	}
</script>
<?php
 include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php";
?>
</body>
</html>
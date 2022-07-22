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
    box-sizing: border-box !important;
	}
	.dayBtn {
		background:url(<?php echo $misc; ?>img/mobile/footer_schedule.svg) no-repeat 98% 50% #fff;
		background-size: 20px;
	}
	</style>
	<link rel="stylesheet" href="/misc/css/view_page_common.css">
  <script language="javascript">
  function search(){
    if($("#search_select1").val() == "002"){
      $("#searchPlace2").show();
      $('#searchkeyword_input').attr('placeholder', '월');
    }else{
      $("#searchPlace2").hide();
      $('#searchkeyword_input').attr('placeholder', '검색하세요.');
    }
  }
    function GoSearch(){
    $('#searchkeyword').val($.trim($('#searchkeyword_input').val()));
    $('#searchkeyword2').val($.trim($('#searchkeyword_input2').val()));
  	$('#search1').val($('#search_select1').val());

    var searchkeyword = document.mform.searchkeyword.value;
    var searchkeyword = searchkeyword.trim();
    document.mform.searchkeyword.value = searchkeyword;
    var searchkeyword2 = document.mform.searchkeyword2.value;
    var searchkeyword2 = searchkeyword2.trim();
    document.mform.searchkeyword2.value = searchkeyword2;

    if(searchkeyword == ""){
      alert( "검색어를 입력해 주세요." );
      return false;
    }

  document.mform.action = "<?php echo site_url();?>/biz/weekly_report/weekly_report_list";
  document.mform.cur_page.value = "";
  //	document.mform.search_keyword.value = searchkeyword;
  document.mform.submit();
  }
  </script>
	<?php
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_side.php";
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_header.php";
  ?>
    <form name="mform" action="<?php echo site_url();?>/biz/weekly_report/weekly_report_list" method="get" onKeyDown="if(event.keyCode==13) return GoSearch();">
      <input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
      <input type="hidden" name="seq" value="">
      <input type="hidden" name="mode" value="">
      <input type="hidden" name="searchkeyword" id="searchkeyword" value="<?php echo str_replace('"', '&uml;',$search_keyword); ?>" />
      <input type="hidden" name="searchkeyword2" id="searchkeyword2" value="<?php echo str_replace('"', '&uml;',$search_keyword2); ?>" />
 	    <input type="hidden" name="search1" id="search1" value="<?php echo $search1; ?>" />

	<div class="content_list">
		<table class="approval_list_tbl" width="100%" border="0" cellspacing="0" cellpadding="0">
			<colgroup>
				<col width="85%">
				<col width="15%">
			</colgroup>
			<tbody>
<?php foreach ($list_val as $item) { ?>
				<tr onclick="ViewBoard('<?php echo $item['seq'];?>')">
					<td align="left" style="color:#A1A1A1;"><?php echo $item['group_name']; ?></td>
					<td align="right" style="color:#A1A1A1;"><?php echo $item['writer']; ?></td>
				</tr>
				<tr onclick="ViewBoard('<?php echo $item['seq'];?>')">
					<td align="left" style="color:#1C1C1C;font-weight:bold;">
            <?php
            	$tmp=explode(" ",$item['s_date']);
            	$tmp2=explode("-",$tmp[0]);
              echo $tmp2[0]."년 ".$item['month']."월 ".$item['week']."주차 주간업무보고" ;
            ?>
          </td>
					<td align="right" style="color:#1C1C1C;font-weight:bold;">
            <?php if($item['approval_yn'] == "Y"){echo "승인"; }else{echo "미승인";} ?>
          </td>
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
						<select class="select-common" name="search1" id="search_select1" style="margin-right:10px;color:black;width:92%;" onchange="search();">
              <option value="001" <?php if($search1 == "001"){ echo "selected";}?>>관리팀</option>
              <option value="002" <?php if($search1 == "002"){ echo "selected";}?>>주차</option>
              <option value="003" <?php if($search1 == "003"){ echo "selected";}?>>보고자</option>
						</select>
					</td>
      	</tr>
				<tr id="searchPlace">
					<td colspan="2">
						<input type="text" id="searchkeyword_input" class="input-common" placeholder="검색하세요." value="<?php echo str_replace('"', '&uml;', $search_keyword );?>" style=";width:95%;" />
					</td>
				</tr>
				<tr id="searchPlace2" <?php if($search_keyword2 == ""){echo "style='display:none'";} ?>>
					<td colspan="2">
						<input type="text" id="searchkeyword_input2" class="input-common" placeholder="주차" value="<?php echo str_replace('"', '&uml;', $search_keyword2 );?>" style=";width:95%;" />
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
	<div style="width:90%;margin:0 auto;margin-bottom:10px;">
    <input type="button" class="btn-common btn-color2" value="글쓰기" onClick="$('#weekly_report_input').bPopup();" style="width:100%;">
	</div>
	<div style="width:90%;padding-left:10px;padding-bottom:60px;">
		<span style="color:red;margin-right:5px;">*</span><?php echo $title; ?> 검색 시 우측 하단에 검색 아이콘을 눌러주세요.
	</div>

  <!-- 주간업무 등록 시작 -->
  <div id="weekly_report_input" style="display:none; position: absolute; background-color: white; width: 100%; height: auto;">
    <form name="cform" id="cform" method="post" enctype="multipart/form-data">
      <table width="100%" height="100%" style="padding:20px 18px;" border="0" cellspacing="0" cellpadding="0">
        <colgroup>
          <col width="100%">
        </colgroup>
        <tr>
          <td align="left" style="font-weight:bold;height:40px;">관리팀</td>
        </tr>
        <tr>
          <td>
            <select name="group" id="group" class="select-common" style="width:100%; height:25px;">
              <?php foreach($tech_group as $tg){
                echo "<option value='{$tg['groupName']}'>{$tg['groupName']}</option>";
              }?>
            </select>
          </td>
        </tr>
        <tr>
          <td align="left" style="font-weight:bold;height:40px;">주차</td>
        </tr>
        <tr>
          <td>
            <select name="week" id="week" class="select-common" style="width:100%; height:25px;">
              <?php for($k=1; $k<=5; $k++){
                echo "<option value={$k}>{$k}주차</option>";
              }?>
            </select>
          </td>
        </tr>
        <tr>
          <td align="left" style="font-weight:bold;height:40px;">시작일</td>
        </tr>
        <tr>
          <td>
            <input type="date" id="s_date" name="s_date" value="" class="input-common" style="width:100%; height:25px;">
          </td>
        </tr>
        <tr>
          <td align="left" style="font-weight:bold;height:40px;">종료일</td>
        </tr>
        <tr>
          <td>
            <input type="date" id="e_date" name="e_date" value="" class="input-common" style="width:100%; height:25px;">
          </td>
        </tr>
        <tr>
          <td colspan="4" align="center" style="padding-top:30px;">
            <input type="button" class="btn-common btn-color2" class="dayBtn" value="등록" onClick="report_input_action();" style="float:right;width:47%;">
            <input type="button" class="btn-common btn-color1" class="dayBtn" value="취소" onClick="$('#weekly_report_input').bPopup().close();" style="float:left;width:47%;">
          </td>
        </tr>
      </table>
    </form>
  </div>
  <!-- 폼 끝 -->
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
  	document.mform.action = "<?php echo site_url();?>/biz/weekly_report/weekly_report_view";
  	document.mform.seq.value = seq;
  	document.mform.mode.value = "view";

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

  function report_input_action(){
    var group_name = $('#group').val();
    var s_date = $('#s_date').val();
    var e_date = $('#e_date').val();
    var week = $('#week').val();
    var split_date = e_date.split('-');
    var year = split_date[0];
    var month = split_date[1];
    // console.log(group_name + s_date + week + year + month);
    if(s_date =='' || e_date ==''){
      alert('날짜를 선택해주세요.');
      return false;
    }
    $.ajax({
      url : "<?php echo site_url(); ?>/biz/weekly_report/weekly_report_duplcheck",
      type : "POST",
      dataType : "json",
      data : {
        group_name : group_name,
        year: year,
        month: month,
        week: week
      },
      success : function(data) {
        // console.log(data);
        if(data == 'dupl'){
          alert("중복되는 주간업무보고서가 존재합니다. 다시 입력해 주세요.");
        }else{
          var act = "<?php echo site_url();?>/biz/weekly_report/weekly_report_input_action";
          $("#cform").attr('action', act);
          $("#cform").submit();
        }
      }

  });
  }
  </script>
</body>

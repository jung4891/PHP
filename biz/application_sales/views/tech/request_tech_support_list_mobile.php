<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";

  // 체크해놓은 seq 가져오기
  $checkSeq ='';
  if(isset($_GET['check_seq']) && $_GET['check_seq']!=''){
    $checkSeq = explode(',',$_GET['check_seq']);
  }
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
  <script language="javascript">
  function GoSearch(){
    $('#searchkeyword').val($.trim($('#searchkeyword_input').val()));
    $('#searchkeyword2').val($.trim($('#searchkeyword2_input').val()));
  	$('#search1').val($('#search_select1').val());

    var searchkeyword = document.mform.searchkeyword.value;
    var searchkeyword = searchkeyword.trim();

    var searchkeyword2 = document.mform.searchkeyword2.value;
    var searchkeyword2 = searchkeyword2.trim();

    if(searchkeyword == ""){
      alert( "검색어를 입력해 주세요." );
      return false;
    }

    document.mform.action = "<?php echo site_url();?>/tech/tech_board/request_tech_support_list";
    document.mform.cur_page.value = "";
    document.mform.submit();
  }

  function moveList(page){
     location.href="<?php echo site_url();?>/tech/"+page;
  }

  window.onload=function(){
     change();
  }

  function change() {
    var search1 = $('#search_select1').val();

    if (search1 == '007') {
      $("#searchkeyword_input").prop("type", "date");
      $("#searchkeyword_input").addClass("dayBtn");
    } else {
      $("#searchkeyword_input").prop("type", "text");
      $("#searchkeyword_input").removeClass("dayBtn");
    }

    if(search1 == '006'){
      $("#searchkeyword_input").attr("placeholder", "승인: y , 미승인: n");
    }else{
      $("#searchkeyword_input").attr("placeholder", "검색하세요.");
    }

    if (search1 == '004') { //장비명
      $('.search2_tr').show();
    } else {
      $('.search2_tr').hide();
    }


  }
  </script>
	<?php
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_side.php";
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_header.php";
  ?>
		<form name="mform" action="<?php echo site_url();?>/tech/tech_board/request_tech_support_list" method="get" onKeyDown="if(event.keyCode==13) return GoSearch();">
      <input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
      <input type="hidden" id ="seq" name="seq" value="">
      <input type="hidden" name="mode" value="">
      <input type="hidden" id="check_seq" name="check_seq" value="<?php if(isset($_GET['check_seq'])){ echo $_GET['check_seq']; } ?>"/>
      <input type="hidden" name="searchkeyword" id="searchkeyword" value="<?php echo str_replace('"', '&uml;',$search_keyword); ?>" />
      <input type="hidden" name="searchkeyword2" id="searchkeyword2" value="<?php echo str_replace('"', '&uml;',$search_keyword); ?>" />
 	   <input type="hidden" name="search1" id="search1" value="<?php echo $search1; ?>" />

     <div class="menu_div">
   		<a class="menu_list" onclick ="moveList('maintain/maintain_list')" style='color:#B0B0B0'>유지보수</a>
   		<a class="menu_list" onclick ="moveList('board/network_map_list')" style='color:#B0B0B0'>구성도</a>
   		<a class="menu_list" onclick ="moveList('tech_board/tech_doc_list?type=Y')" style='color:#B0B0B0'>기술지원보고서</a>
   		<a class="menu_list" onclick ="moveList('tech_board/request_tech_support_list')" style='color:#0575E6'>기술지원요청</a>
   		<a class="menu_list" onclick ="moveList('tech_board/tech_issue')" style='color:#B0B0B0'>요청/이슈</a>
   	</div>

	<div class="content_list">
		<table class="approval_list_tbl" width="100%" border="0" cellspacing="0" cellpadding="0">
			<colgroup>
				<col width="85%">
				<col width="15%">
			</colgroup>
			<tbody>
<?php foreach ($list_val as $item) { ?>
				<tr onclick="ViewBoard('<?php echo $item['seq'];?>')">
					<td align="left" style="color:#A1A1A1;"><?php echo $item['workplace_name']; ?></td>
					<td align="right" style="color:#A1A1A1;"><?php echo $item['result']; ?></td>
				</tr>
				<tr>
					<td align="left" style="color:#1C1C1C;font-weight:bold;">
            <?php if($item['final_approval'] == 'N' && $tech_lv == 3){ ?>
              <input type="checkbox" name="check" value="<?php echo $item['seq']; ?>" onchange="checkSeq(this,<?php echo $item['seq'];?>,'<?php echo $item['file_change_name'];?>')" <?php if($checkSeq <> ""){if(in_array($item['seq'],$checkSeq)){echo "checked";};} ?> >
            <?php } ?>
            <span onclick="ViewBoard('<?php echo $item['seq'];?>')"><?php echo $item['produce']; ?></span>
          </td>
					<td align="right" style="color:#1C1C1C;font-weight:bold;">
            <?php if($item['final_approval'] =='N'){echo "미승인";}else{echo "승인";} ?>
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
						<select class="select-common" name="search1" onChange="change();" id="search_select1" style="margin-right:10px;color:black;width:92%;">
              <option value="001" <?php if($search1 == "001"){ echo "selected";}?>>고객사</option>
              <option value="002" <?php if($search1 == "002"){ echo "selected";}?>>협력사</option>
              <option value="003" <?php if($search1 == "003"){ echo "selected";}?>>사업장명</option>
              <option value="004" <?php if($search1 == "004"){ echo "selected";}?>>장비명</option>
              <option value="009" <?php if($search1 == "009"){ echo "selected";}?>>serial</option>
              <option value="005" <?php if($search1 == "005"){ echo "selected";}?>>진행단계</option>
              <option value="006" <?php if($search1 == "006"){ echo "selected";}?>>최종승인</option>
              <option value="007" <?php if($search1 == "007"){ echo "selected";}?>>설치일자</option>
						</select>
					</td>
      	</tr>
				<tr>
					<td colspan="2">
						<input type="text" id="searchkeyword_input" class="input-common" placeholder="검색하세요." value="<?php echo str_replace('"', '&uml;', $search_keyword );?>" style=";width:95%;" />
					</td>
				</tr>
				<tr class="search2_tr" style="display:none;">
					<td colspan="2">
						<input type="text" id="searchkeyword2_input" class="input-common" placeholder="버전명을 입력하세요." value="<?php echo str_replace('"', '&uml;', $search_keyword2 );?>" style=";width:95%;" />
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
    <?php if($tech_lv == 3) { ?>
			<!-- <a href="<?php echo site_url();?>/tech/board/manual_input"> -->
				<!-- <input style="width:100%" type="button" class="btn-common btn-color2" value="글쓰기"> -->
			<!-- </a> -->
    <?php } ?>
	</div>
	<div style="width:90%;padding-left:10px;padding-bottom:60px;">
		<span style="color:red;margin-right:5px;">*</span><?php echo $title; ?> 검색 시 우측 하단에 검색 아이콘을 눌러주세요.
  <?php if($tech_lv == 3) { ?>
    <button class="btn-common btn-color1" type="button" name="button" style="margin-right:5px;margin-top:20px;width:auto;" onclick="personopen();">담당자 설정</button>
    <input type="button" class="btn-common btn-color1" value="최종승인" style="margin-right:5px;margin-top:20px;" onclick="finalApproval();" />
  <?php } ?>
	</div>

  <!-- 검색 모달 시작 -->
  <div id="person_div" style="height:auto;width:100%;background-color:#ffffff; display:none;border-radius:5px;">
    <div class="modal_contain" style="font-size:16px; color:#1C1C1C;font-weight:bold;">
      <table style="width:100%;padding:5%;" cellspacing="0">
				<colgroup>
					<col width="50%">
					<col width="50%">
				</colgroup>
				<tr>
      		<td align="left" height="40">담당자1</td>
          <input type="hidden" name="person_seq" id="person_seq" value="<?php echo $responsibility->seq ?>">
      	</tr>
        <tr>
          <td colspan="2">
            <select class="select-common" name="person1" id="person1">
              <option value="">선택하세요</option>
              <?php
              $select_seq = $responsibility->person1;
              foreach ($durian_engineer as $eng){
                $selected = $select_seq == $eng['seq'] ? " selected" : "";
                echo "<option value='{$eng['seq']}'{$selected}>{$eng['user_name']}</option>";
             }
             ?>
            </select>
          </td>
        </tr>
				<tr>
      		<td align="left" height="40">담당자2</td>
      	</tr>
        <tr>
          <td colspan="2">
            <select class="select-common" name="person2" id="person2">
              <option value="">선택하세요</option>
              <?php
              $select_seq = $responsibility->person2;
              foreach ($durian_engineer as $eng){
                $selected = $select_seq == $eng['seq'] ? " selected" : "";
                echo "<option value='{$eng['seq']}'{$selected}>{$eng['user_name']}</option>";
             }
             ?>
            </select>
          </td>
        </tr>
				<tr>
					<td colspan="2">
          </td>
				</tr>
				<tr>
          <td height="20"></td>
        </tr>
				<tr>
					<td>
            <button type="button" name="button" class="btn-common btn-color1" style="width:95%" onclick="$('#person_div').bPopup().close();">취소</button>
					</td>
					<td align="right">
            <button type="button" name="button" class="btn-common btn-color2" style="width:95%" onclick="change_person();">확인</button>
					</td>
				</tr>
      </table>
    </div>
  </div>
	<?php include $this->input->server('DOCUMENT_ROOT')."/include/mobile_bottom.php"; ?>
  <script language="javascript">
  function GoFirstPage (){
    $("input[name=check]").attr("disabled",true);
    document.mform.cur_page.value = 1;
    document.mform.submit();
  }

  function GoPrevPage (){
    $("input[name=check]").attr("disabled",true);
    var cur_start_page = <?php echo $cur_page;?>;

    document.mform.cur_page.value = Math.floor( ( cur_start_page - 11 ) / 10 ) * 10 + 1;
    document.mform.submit( );
  }

  function GoPage(nPage){
    $("input[name=check]").attr("disabled",true);
    document.mform.cur_page.value = nPage;
    document.mform.submit();
  }

  function GoNextPage (){
    $("input[name=check]").attr("disabled",true);
    var cur_start_page = <?php echo $cur_page;?>;
    document.mform.cur_page.value = Math.floor( ( cur_start_page + 9 ) / 10 ) * 10 + 1;
    document.mform.submit();
  }

  function GoLastPage (){
    $("input[name=check]").attr("disabled",true);
    var total_page = <?php echo $total_page;?>;
    document.mform.cur_page.value = total_page;
    document.mform.submit();
  }

  function ViewBoard(seq){
    $("input[name=cur_page]").attr("disabled",true);
    $("#search1").attr("disabled",true);
    $("input[name=searchkeyword]").attr("disabled",true);
    $("input[name=searchkeyword2]").attr("disabled",true);
    document.mform.action = "<?php echo site_url();?>/tech/tech_board/request_tech_support_view";
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

  function personopen(){
  	$("#person_div").bPopup();
  }

  function change_person(){
    $.ajax({
      type: "POST",
      cache: false,
      url: "<?php echo site_url(); ?>/tech/tech_board/change_function",
      dataType: "json",
      async: false,
      data: {
        seq: $("#person_seq").val(),
        person1:$("#person1").val(),
        person2:$("#person2").val()
      },
      success: function (data) {
        console.log(data);
        if(data == '실패'){
          alert("저장하지 못했습니다. 다시 처리해 주시기 바랍니다.");
        }else{
          alert("저장하였습니다.");
          $("#person_div").bPopup().close();
        }
      }
    });
  }

  function checkSeq(obj,seq,filename){
    if($(obj).is(":checked")==true){
      $(obj).closest('tr').attr('onMouseOver', "");
      $(obj).closest('tr').attr('onMouseOut', "");
      $(obj).closest('tr').css('backgroundColor','#EAEAEA');
      if($("#check_seq").val() == ""){
        $("#check_seq").val($("#check_seq").val()+seq);
        $("#file_change_name").val($("#file_change_name").val()+filename);
      }else{
        $("#check_seq").val($("#check_seq").val()+","+seq);
        $("#file_change_name").val($("#file_change_name").val()+","+filename);
      }
    }else{
      $(obj).closest('tr').attr('onMouseOver', "this.style.backgroundColor='#EAEAEA'");
      $(obj).closest('tr').attr('onMouseOut', "this.style.backgroundColor='#fff'");
      $(obj).closest('tr').css('backgroundColor','#fff');
      if($("#check_seq").val().indexOf(","+seq) != -1) {
        $("#check_seq").val($("#check_seq").val().replace(","+seq,''));
        $("#file_change_name").val($("#file_change_name").val().replace(","+filename,''));
      }else if($("#check_seq").val().indexOf(seq+",") != -1){
        $("#check_seq").val($("#check_seq").val().replace(seq+",",''));
        $("#file_change_name").val($("#file_change_name").val().replace(filename+",",''));
      }else{
        $("#check_seq").val($("#check_seq").val().replace(seq,''));
        $("#file_change_name").val($("#file_change_name").val().replace(filename,''));
      }
    }
  }

  function finalApproval(){
    var result = confirm("최종승인 하시겠습니까?");
    if(result){
      $.ajax({
        type: "POST",
        cache: false,
        url: "<?php echo site_url(); ?>/tech/tech_board/finalApproval",
        dataType: "json",
        async: false,
        data: {
          seq: $("#check_seq").val()
        },
        success: function (data) {
          if(data){
            alert('승인완료');
            location.href = "<?php echo site_url(); ?>/tech/tech_board/request_tech_support_final_approval_mail?seq="+$("#check_seq").val();
          }else{
            alert('승인오류');
          }
        }
      });
    }else{
      location.href = "<?php echo site_url(); ?>/tech/tech_board/request_tech_support_list";
    }
  }
  </script>
</body>

<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<body>
	<?php
	  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	  ?>
	<meta name="viewport" content="width=device-width,height=device-width, initial-scale=1.0">
  	<link rel="stylesheet" href="/misc/css/view_page_common.css">
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
	.content_list_tbl {
		padding-left: 15px;
		padding-right:15px;
		border-spacing: 0 10px;
		table-layout: fixed;
	}
	.content_list_tbl td {
		overflow:hidden;
		white-space : nowrap;
		text-overflow: ellipsis;
	}

	.input-common, .select-common, .btn-common {
		height: 35px !important;
		border-radius: 3px !important;
    box-sizing : border-box !important;
	}
	.dayBtn {
		background:url(<?php echo $misc; ?>img/mobile/footer_schedule.svg) no-repeat 98% 50% #fff;
		background-size: 20px;
	}
  .modal_contain{
    height:100%;
    /* display: flex; */
    justify-content: center;
    align-items: center;
    font-family:"Noto Sans KR", sans-serif;
  }
  .parentGroup {
    font-size: 17px;
  }
  .userGroup {
    font-size: 16px;
    padding-left: 10px;
  }
  .btn-user {
		width:95px;margin-right:10px;margin-bottom:10px;border-radius:3px;
		border-width: thin;text-align:center;
		font-size:14px !important;
	}
  .btn-user {
    font-size: 14px !important;
    width:auto !important;
  }
  .dept2-user {
    padding-left:10px;
  }
  .btn-style3 {
    color:#B0B0B0;
  }
  .basic_table{
		width:100%;
		 border-collapse:collapse;
		 border:1px solid;
		 border-color:#DEDEDE;
		 table-layout: auto !important;
		 border-left:none;
		 border-right:none;
	}

	.basic_table td{
		height:35px;
		 padding:0px 10px 0px 10px;
		 border:1px solid;
		 border-color:#DEDEDE;
	}
	.border_n {
		border:none;
	}
	.border_n td {
		border:none;
	}
	.basic_table tr > td:first-child {
		border-left:none;
	}
	.basic_table tr > td:last-child {
		border-right:none;
	}
  #formLayoutDiv {
    overflow-x: scroll;
    white-space:nowrap;
    padding:5%;
    max-width: 100%;
  }
	</style>
	<?php
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_side.php";
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_header.php";
	  ?>
  <form name="cform" action="<?php echo site_url(); ?>/biz/approval/electronic_approval_delegation_management" method="get" onkeydown="if(event.keyCode==13) return GoSearch();">
     <input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
  </form>
	<div class="menu_div">
		<a class="menu_list" style='color:#0575E6'>위임관리</a>
		<a class="menu_list" onclick ="moveList('electronic_approval_personal_storage')">개인보관함관리</a>
	</div>
  <div class="content_list">
    <table class="content_list_tbl" width="100%" border="0" cellspacing="0" cellpadding="0">
      <colgroup>
        <col width="50%">
        <col width="50%">
      </colgroup>
      <tr>
        <td align="left" colspan="2" class="tbl-sub-title">
          <span style="color:red;vertical-align:middle;">*</span> 위임할 대상부서
        </td>
      </tr>
      <tr>
        <td align="left" colspan="2" style="font-size:15px;">
          <?php echo $group; ?>
          <input type="hidden" id="delegate_group" name="delegate_group" value="<?php echo $group; ?>">
        </td>
      </tr>
      <tr>
        <td align="left" colspan="2" class="tbl-sub-title">
          <span style="color:red;vertical-align:middle;">*</span> 위임기간
        </td>
      </tr>
      <tr>
        <td align="left">
          <input id="start_date" name="start_date" type="date" class="input-common dayBtn" style="width:95%">
        </td>
        <td align="right">
          <input type="date" id="end_date" name="end_date" class="input-common dayBtn" style="width:95%">
        </td>
      </tr>
      <tr>
        <td align="left" colspan="2" class="tbl-sub-title">
          <span style="color:red;vertical-align:middle;">*</span> 수임자
        </td>
      </tr>
      <tr>
        <td align="left" colspan="2" style="font-size:15px;">
          <input type="text" id="mandatary" name="mandatary" class="input-common" onclick="selUserOpen();" onfocus="selUserOpen();" style="width:80%" readonly/>
          <input type="hidden" id="mandatary_seq" name="mandatary_seq" />
          <img src="<?php echo $misc;?>img/mobile/btn_plus_big.svg" style="float:right;width:35px;cursor:pointer;vertical-align:middle;" border="0" onClick="selUserOpen();" width="20"/>
        </td>
      </tr>
      <tr>
        <td align="left" colspan="2" class="tbl-sub-title">
          <span style="color:red;vertical-align:middle;">*</span> 위임사유
        </td>
      </tr>
      <tr>
        <td align="left" colspan="2">
          <input type="text" id="delegation_reason" name="delegation_reason" class="input-common" style="width:100%">
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <input type="button" class="btn-common btn-color2" value="등록" style="cursor:pointer;margin-top:10px;width:100%;height:40px !important;" onclick="delegation_save();">
        </td>
      </tr>
    </table>

    <table class="content_list_tbl" width="100%" border="0" cellspacing="0" cellpadding="0">
      <colgroup>
        <col width="80%">
				<col width="20%">
      </colgroup>
      <tbody>
        <?php
        if(empty($view_val) != true) {
          $idx = $count - $start_row;
          for($i = $start_row; $i < $start_row + $end_row; $i++) {
            if(!empty($view_val[$i])) {
              $val = $view_val[$i];

              echo "<tr align='center'>";
              echo "<td align='left' style='color:#A1A1A1'>{$val['start_date']}~{$val['end_date']}</td>"; ?>
              <td align='right' style='color:#A1A1A1' onclick="detail_view(<?php echo $val['seq']; ?>,'<?php echo $val['mandatary']; ?>','<?php echo $val['start_date'].'~'.$val['end_date']; ?>','<?php echo $val['delegation_reason']; ?>');">
                상세보기>
              </td>
              <?php
              echo "</tr><tr align='center'>";
              echo "<td align='left' style='color:#1C1C1C;font-weight:bold;'>";
              if($val['status'] == "Y"){
                 echo "<input type='checkbox' name='delegation_check' value='{$val['seq']}' />";
              }
              if($val['status'] == 'Y') {
                echo '[설정]';
              } else {
                echo '[설정해제]';
              }
              echo "{$val['delegation_reason']}</td>";
              echo "<td align='right' style='color:#1C1C1C;font-weight:bold;'>{$val['mandatary']}</td>";
              echo "</tr>";
            }
          } ?>
          <tr>
          <td colspan="2"><input type="button" class="btn-common btn-color1" value="설정해제" style="cursor:pointer;margin-bottom:30px;margin-top:10px;width:100%" onclick="unset();"></td>
          </tr>
        <?php
        } else {
          echo "<tr align='center'><td colspan='2'>위임 이력이 존재하지 않습니다.</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>



  <!-- 참석자 모달 시작 (일정 선택) -->
  <div id="select_user_div" style="height:auto;width:100%;background-color:#ffffff; display:none;border-radius:5px;">
    <div class="modal_contain" style="font-size:18px; color:#1C1C1C;font-weight:bold;">
      <table style="width:100%;padding:5%;">
				<tr>
					<td>(주)두리안정보기술</td>
				</tr>
				<tr>
					<td height="10"></td>
				</tr>
<?php foreach($user_parents_group as $upg) { ?>
				<tr>
					<td class="parentGroup"><?php echo $upg['parentGroupName']; ?></td>
				</tr>
<?php if(isset($depth1_user[$upg['parentGroupName']])){ ?>
				<tr>
					<td class='user'>
<?php foreach($depth1_user[$upg['parentGroupName']] as $du) { ?>
						<input type="button" seq="<?php echo $du['seq']; ?>" class="btn-common btn-style3 btn-user" value="<?php echo $du['user_name'].' '.mb_substr($du['user_duty'],0,2); ?>" onclick="select_user(this);">
<?php } ?>
					</td>
				</tr>
<?php } ?>
<?php for ($i=0; $i<count($user_group); $i++) { ?>
<?php if($upg['parentGroupName'] == $user_group[$i]['parentGroupName'] && $user_group[$i]['groupName'] != $user_group[$i]['parentGroupName']){ ?>
				<tr>
					<td class="userGroup"><?php echo $user_group[$i]['groupName']; ?></td>
				</tr>
<?php if(isset($depth2_user[$user_group[$i]['groupName']])){ ?>
				<tr>
					<td class='user dept2-user'>
<?php foreach($depth2_user[$user_group[$i]['groupName']] as $du) { ?>
						<input type="button" seq="<?php echo $du['seq']; ?>" class="btn-common btn-style3 btn-user" value="<?php echo $du['user_name'].' '.mb_substr($du['user_duty'],0,2); ?>" onclick="select_user(this);">
<?php } ?>
					</td>
				</tr>
<?php } ?>
<?php } ?>
<?php } ?>
<?php } ?>
				<tr>
					<td align="center">
						<input type="button" class="btn-common btn-color1" value="취소" onclick="$('#select_user_div').bPopup().close();" style="width:45%;float:left;">
						<input type="button" class="btn-common btn-color2" value="선택" onclick="selUser_submit();" style="width:45%;float:right;">
					</td>
				</tr>
      </table>
    </div>
  </div>
	<!-- 참석자 모달 끝 -->



  <!-- 상세보기 모달 -->
  <div id="detail_div" style="height:auto;width:100%;background-color:#ffffff; display:none;border-radius:5px;">
    <div class="modal_contain" style="font-size:15px; color:#1C1C1C;">
      <table style="width:100%;padding:5%;" border="0" cellspacing="0" cellpadding="0">
        <colgroup>
          <col width="30%">
          <col width="70%">
        </colgroup>
        <tr>
          <td colspan="2" style="padding-bottom:30px;font-size:18px;font-weight:bold;">결재내역 <span id="detail_count" style="color:#0575E6">(11건)</span></td>
        </tr>
        <tr><td colspan="2">수임자:<span id="detail_view_mendatary"></span></td></tr>
        <tr><td colspan="2">위임 기간:<span id="detail_view_date"></span></td></tr>
        <tr><td colspan="2">위임 사유:<span id="detail_view_reason"></span></td></tr>
      </table>
      <div id="formLayoutDiv"></div>
      <div style="padding:5%;">
        <input type="button" class="btn-common btn-color1" value="닫기" onclick="$('#detail_div').bPopup().close();" style="width:100%;">
      </div>
    </div>
  </div>
	<!-- 상세보기 모달 끝 -->

  <div style="position:fixed;bottom:50px;right:5px;">
  	<!-- <a href="#"> -->
  		<img src="<?php echo $misc; ?>img/mobile/btn_top.svg" onclick="goTop();">
  	<!-- </a> -->
  </div>

	<?php include $this->input->server('DOCUMENT_ROOT')."/include/mobile_bottom.php"; ?>

</body>

<script type="text/javascript">
  function goTop() {
    $('html').scrollTop(0);
  }

  function moveList(type) {
    location.href = '<?php echo site_url(); ?>/biz/approval/' + type;
  }

  function selUserOpen() {
    $("#select_user_div").bPopup({
			follow: [false,false],
			position: [0, 0]
    })
  }

  function select_user(el) {
    // 선택 되어있지 않을때
    if($(el).hasClass('btn-style3')) {

      $(el).removeClass('btn-style3');
      $(el).addClass('btn-style2');

    // 선택 되어있을때
    } else if($(el).hasClass('btn-style2')) {

      $(el).removeClass('btn-style2');
      $(el).addClass('btn-style3');

    }
  }

  function selUser_submit() {
    var selUser = '';
    var selSeq = '';

    if ($('#select_user_div .btn-style2').length > 1) {
      alert('수임자는 한명만 선택 가능합니다.');
      return false;
    } else if ($('#select_user_div .btn-style2').length = 1) {
      // alert($('#select_user_div .btn-style2').val());
      $('#mandatary').val($('#select_user_div .btn-style2').val());
      $('#mandatary_seq').val($('#select_user_div .btn-style2').attr('seq'));
      $('#select_user_div').bPopup().close();
    } else {
      alert('수임자가 선택되지 않았습니다.');
      return false;
    }
  }

  function delegation_save(){
    if($("#start_date").val() == ""){
       $("#start_date").focus();
       alert("위임기간을 선택해주세요");
       return false;
    }
    if($("#end_date").val() == ""){
       $("#end_date").focus();
       alert("위임기간을 선택해주세요");
       return false;
    }
    if($("#mandatary").val() == ""){
       $("#mandatary").focus();
       alert("수임자를 선택해주세요");
       return false;
    }
    if($("#delegation_reason").val() == ""){
       $("#delegation_reason").focus();
       alert("위임사유를 입력해주세요");
       return false;
    }

    var result = confirm("위임 하시겠습니까?");
        if (result) {
           $.ajax({
              type: "POST",
              cache: false,
              url: "<?php echo site_url(); ?>/biz/approval/delegation_save",
              dataType: "json",
              async: false,
              data: {
                delegate_group: $("#delegate_group").val(),
                start_date: $("#start_date").val(),
                end_date: $("#end_date").val(),
                mandatary:$("#mandatary").val(),
                mandatary_seq:$("#mandatary_seq").val(),
                delegation_reason:$("#delegation_reason").val()
              },
              success: function (result) {
                if(result){
                   alert("위임 저장 완료");
                   location.reload();
                }else{
                   alert("위임 저장 실패");
                }
              }
           });
       }
  }

  //설정해제
   function unset(){
     var check_seq = '';
     $('input:checkbox[name="delegation_check"]').each(function() {
        if(this.checked == true){
           if(check_seq == "") {
              check_seq += this.value;
           }else{
              check_seq += "," +this.value;
           }
        }
     });

     if(check_seq != ""){
        $.ajax({
           type: "POST",
           cache: false,
           url: "<?php echo site_url(); ?>/biz/approval/delegation_unset",
           dataType: "json",
           async: false,
           data: {
              check_seq: check_seq
           },
           success: function (result) {
           if(result){
              alert("위임 설정해제 완료");
              location.reload();
           }else{
              alert("위임 설정해제 실패");
           }
           }
        });
     }
   }

  //상세보기
  function detail_view(seq,mendatary,date,reason){

     $('#detail_view_mendatary').html(mendatary);
     $('#detail_view_date').html(date);
     $('#detail_view_reason').html(reason);
     $.ajax({
        type: "POST",
        cache: false,
        url: "<?php echo site_url(); ?>/biz/approval/delegation_detail_view",
        dataType: "json",
        async: false,
        data: {
           seq: seq
        },
        success: function (data) {
          if(data) {
            $('#detail_count').html('('+data.length+')건');
            var html = '';
            for (i=0; i<data.length; i++) {
              html += '<table class="basic_table last_border_n" border="0" cellspacing="0" cellpadding="0" style="display: inline;width:100%;border:none;">'
              html += "<tr>";
              html += "<td bgcolor='#F4F4F4' align='center'>순번</td>";
              html += "<td>"+(i+1)+"</td>";
              html += "</tr><tr>";
              html += "<td bgcolor='#F4F4F4' align='center'>서식함</td>";
              html += "<td>";
              <?php foreach($category as $format_category) { ?>
                if (data[i].template_category == "<?php echo $format_category['seq']; ?>") {
                  html += "<?php echo $format_category['category_name']; ?>";
                }
              <?php } ?>
              html += "</td>";
              html += "<tr>";
              html += "<td bgcolor='#F4F4F4' align='center'>문서제목</td>";
              html += "<td>"+data[i].approval_doc_name+"</td>";
              html += "</tr><tr>";
              html += "<tr>";
              html += "<td bgcolor='#F4F4F4' align='center'>기안자</td>";
              html += "<td>"+data[i].writer_id+"</td>";
              html += "</tr><tr>";
              html += "<tr>";
              html += "<td bgcolor='#F4F4F4' align='center'>기안일</td>";
              html += "<td>"+data[i].write_date+"</td>";
              html += "</tr><tr>";
              html += "<tr>";
              html += "<td bgcolor='#F4F4F4' align='center'>문서상태</td>";
              if(data[i].approval_doc_status == "001") {
                html += "<td style='border-right:none;'>진행중";
              } else if(data[i].approval_doc_status == "002") {
                html += "<td style='border-right:none;'>완료";
              } else if(data[i].approval_doc_status == "003") {
                html += "<td style='border-right:none;'>반려";
              } else if(data[i].approval_doc_status == "004") {
                html += "<td style='border-right:none;'>회수";
              } else if(data[i].approval_doc_status == "005") {
                html += "<td style='border-right:none;'>임시저장";
              } else if(data[i].approval_doc_status == "006") {
                html += "<td style='border-right:none;'>회수";
              } else {
                html += "<td style='border-right:none;'>";
              }
              html += "<img src='<?php echo $misc; ?>img/mobile/btn_detail.svg' style='float:right;'  onclick='doc_view("+data[i].seq+");' /></td>";
              html += "<td style='width:10px;border:none;'></td>"
              html += "</tr><tr>";
              html += "</tr>";
              html += "</table>";
            }
          } else {
            html = '';
            $('#detail_count').html('(0)건');
          }
          console.log(data);
          $('#formLayoutDiv').html(html);
          $("#detail_div").bPopup();
        }
     });
  }


  //기안문보기
  function doc_view(seq){
     window.open("<?php echo site_url(); ?>/biz/approval/electronic_approval_doc_view?seq="+seq, "popup_window", "width = 1200, height = 500, top = 100, left = 400, location = no,status=no,status=no,toolbar=no,scrollbars=no");
  }

  function GoFirstPage (){
        document.cform.cur_page.value = 1;
        document.cform.submit();
  }

  function GoPrevPage (){
     var	cur_start_page = <?php echo $cur_page;?>;

     document.cform.cur_page.value = Math.floor( ( cur_start_page - 11 ) / 10 ) * 10 + 1;
     document.cform.submit( );
  }

  function GoPage(nPage){
     document.cform.cur_page.value = nPage;
     document.cform.submit();
  }

  function GoNextPage (){
     var	cur_start_page = <?php echo $cur_page;?>;

     document.cform.cur_page.value = Math.floor( ( cur_start_page + 9 ) / 10 ) * 10 + 1;
     document.cform.submit();
  }

  function GoLastPage (){
     var	total_page = <?php echo $total_page;?>;
     document.cform.cur_page.value = total_page;
     document.cform.submit();
  }
</script>

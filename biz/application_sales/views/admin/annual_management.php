<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
  if($search_keyword != ''){
	$filter = explode(',',str_replace('"', '&uml;',$search_keyword));
  }
?>

<style>
	p, div, span, a, a:hover, a:visited, a:active, label, input, h1,h2,h3,h4,h5,h6{font-family: "Noto Sans KR";}
	.contents td{
		border-bottom: 1px solid #e8e8e8;
		height:40px;
	}
	.sticky-th {
		position:sticky;
		top:0px;
		background-color:#fff;
	}
	.basic_table{
      border-collapse:collapse;
      border:1px solid;
      border-color:#d7d7d7;
   }
   .basic_table td{
	  border:1px solid;
      border-color:#d7d7d7;
	  padding:3px;
	  height:40px;
   }
</style>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">
<link rel="stylesheet" href="/misc/css/yearpicker.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script type="text/javascript" src="/misc/js/yearpicker.js"></script>
<script type="text/javascript" src="/misc/js/calculator.js"></script>
<script type="text/javascript" src="/misc/js/jquery.bpopup-0.1.1.min.js"></script>
<body>
<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
<form name="mform" action="<?php echo site_url();?>/admin/annual_admin/annual_management" method="post" onkeydown="if(event.keyCode==13) return GoSearch();">
<input type="hidden" id="searchkeyword" name="searchkeyword" value="<?php echo str_replace('"', '&uml;', $search_keyword );?>"/>
<div align="center">
	<div class="dash1-1">
		<table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
			<tbody>
        <tr height="5%">
					<td class="dash_title">
						연차관리
					</td>
				</tr>
				<tr id="search_tr">
					<td align="left" valign="top">
						<table width="100%" id="filter_table" style="margin-top:80px;">
              <tr>
                <td align="center" valign="top">
                  <!-- <input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>"> -->
                  <input type="hidden" name="seq" value="">
                  <input type="hidden" name="mode" value="">
                </td>
              </tr>
							<tr>
                <td style="font-weight:bold;vertical-align:middle;">
                  <div>
                    기준연도
                    <input id="filter1" class="filtercolumn yearpicker input-common" style="width:70px;" value='<?php if(isset($filter)){echo $filter[0];} ?>' autocomplete="off" />
                    &nbsp;휴가관리기준
                    <select id="filter2" class="filtercolumn select-common select-style1">
                      <option value="" <?php if(isset($filter)){if($filter[1] == ""){echo "selected";}} ?>>전체</option>
                    <option value="calcDt" <?php if(isset($filter)){if($filter[1] == "calcDt"){echo "selected";}} ?>>연차기준월</option>
                    <option value="entryDt" <?php if(isset($filter)){if($filter[1] == "entryDt"){echo "selected";}} ?>>입사일</option>
                  </select>
                  &nbsp;검색어
                  <select id="filter3" class="filtercolumn select-common select-style1">
                      <option value="user_name" <?php if(isset($filter)){if($filter[2] == "user_name"){echo "selected";}} ?>>성명</option>
                    <option value="user_group" <?php if(isset($filter)){if($filter[2] == "user_group"){echo "selected";}} ?>>부서</option>
                  </select>
                  <input type="text" id="filter4" class="filtercolumn input-common" style="width:100px;" value='<?php if(isset($filter)){echo $filter[3];} ?>'/>

                  &nbsp;연차생성여부
                  <select id="filter5" class="filtercolumn select-common select-style1">
                      <option value="" <?php if(isset($filter)){if($filter[4] == ""){echo "selected";}} ?>>전체</option>
                    <option value="true" <?php if(isset($filter)){if($filter[4] == "true"){echo "selected";}} ?>>생성</option>
                    <option value="false" <?php if(isset($filter)){if($filter[4] == "false"){echo "selected";}} ?>>미생성</option>
                  </select>

                  <button type="button" name="button" class="btn-common btn-style2" onclick="return GoSearch();">검색</button>

                </div>
                </td>
                <td align="right">
                  <input type="checkbox" name="quit_user" value="Y" onchange="return GoSearch();" <?php if($quit_user == 'Y'){echo 'checked';} ?>>
                  <span style="font-weight:bold;">퇴사자 기록 보기</span>
                    <input type="button" id="" class="btn-common btn-color7" value="연차생성" onclick="create_annual();" />
                    <input type="button" id="" class="btn-common btn-color4" value="연차삭제" onclick="annualReset();" />
                    <input type="button" id="" class="btn-common btn-style4" value="조정연차관리" onclick="adjust_annual()" style="width:auto;" />
                </td>
							</tr>

						</table>
					</td>
				</tr>
				<tr style="max-height:45%">
					<td colspan="2" valign="top" style="padding:10px 0px;">
						<table class="content_dash_tbl" align="center" width="100%"  border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td>
									<div class="list_tbl" style="width:100%; height:500px; overflow:auto">
									<table width="100%" class="contents" border="0" cellspacing="0" cellpadding="0">
										<colgroup>
											<col width="5%" />
											<col width="5%" />
											<col width="5%" />
											<col width="5%" />
											<col width="7%" />
											<col width="8%" />
											<col width="5%" />
											<col width="5%" />
											<col width="15%" />
											<col width="5%" />
											<col width="5%" />
											<col width="5%" />
											<col width="5%" />
											<col width="5%" />
											<col width="5%" />
											<col width="5%" />
										</colgroup>
										<thead>
											<tr class="t_top">
												<th class="tbl-title sticky-th " ></th>
												<th class="tbl-title sticky-th" align="center" ><input id="user_annual_all" type="checkbox" /></th>
												<th class="tbl-title sticky-th" height="40" align="center">성명</th>
												<th class="tbl-title sticky-th" align="center">부서</th>
												<th class="tbl-title sticky-th" align="center">연차기준</th>
												<th class="tbl-title sticky-th" align="center">입사일</th>
												<th class="tbl-title sticky-th" align="center">근속년수</th>
												<th class="tbl-title sticky-th" align="center">기준연도</th>
												<th class="tbl-title sticky-th" align="center">연차사용기간</th>
												<th class="tbl-title sticky-th" align="center">1년미만월발생분</th>
												<th class="tbl-title sticky-th" align="center">근속연차</th>
												<th class="tbl-title sticky-th" align="center">조정연차</th>
												<th class="tbl-title sticky-th" align="center">사용연차(승인)</th>
                        <th class="tbl-title sticky-th" align="center">잔여연차</th>
												<th class="tbl-title sticky-th" align="center">사용연차(결재중)</th>
												<th class="tbl-title sticky-th" ></th>
											</tr>
										</thead>
										<tbody>
										<?php
										if (!empty($view_val)) {
											foreach($view_val as $val){?>
											<tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'" >
												<td></td>
												<td align="center"><input type="checkbox" name="user_annual_seq" value="<?php echo $val['seq']; ?>"/></td>
												<td align="center"><?php echo $val['user_name']; ?></td>
												<td align="center"><?php echo $val['user_group']; ?></td>
												<td align="center">
													<?php if ($val['annual_standard'] == "calcDt"){
														echo "연차기준월";
													}else{
														echo "입사일";
													} ?>
												</td>
												<td align="center"><?php echo $val['join_company_date']; ?></td>
												<td align="center"><?php if($val['annual_period']-substr($val['join_company_date'],0,4)-1 < 0){echo 0;}else{
													echo $val['annual_period']-substr($val['join_company_date'],0,4)-1;
												} ?> </td>
												<td align="center"><?php echo $val['annual_period']; ?></td>
												<td align="center"><?php echo $val['annual_period'];?>-01-01 ~ <?php echo $val['annual_period'];?>-12-31</td>
												<td align="center"><?php echo $val['month_annual_cnt'];?></td>
												<td align="center"><?php echo $val['annual_cnt'];?></td>
												<td align="center"><?php echo $val['adjust_annual_cnt'];?></td>
												<td align="center"><?php echo $val['use_annual_cnt'];?></td>
												<td align="center"><?php echo $val['remainder_annual_cnt'];?></td>
												<td align="center"><?php echo $val['approval_cnt'];?></td>
												<td></td>
											</tr>
										<?php
										    }
										} else {
										?>
										<tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'">
											<td width="100%" height="40" align="center" colspan="16">등록된 게시물이 없습니다.</td>
										</tr>
										<?php
										}
									?>
									</tbody>
									</table>
									</div>
								</td>
							</tr>

						</table>

					</td>
				</tr>
			</table>
	</div>
</div>

<!--하단-->
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
<!--//하단-->

<!-- 입력 모달 -->
<div id="attendance_input" style="display:none; position: absolute; background-color: white; width: auto; height: auto;">
	<!-- <form name="cform" action="<?php echo site_url();?>/admin/attendance_admin/attendance_input_action" method="post" onSubmit="javascript:chkForm();return false;"> -->
		<table width="800" style="padding:10px">
			<colgroup>
				<col width="10%" />
				<col width="40%" />
				<col width="10%" />
				<col width="40%" />
			</colgroup>
			<tr>
				<td colspan=4 class="modal_title" align="center" colspan="2" style="padding:30px 0px 20px 0px;text-align:left;font-weight:bold;font-size:20px;">
					조정연차관리
					<input type="hidden" name="delete_adjust_seq" id="delete_adjust_seq" value="">
				</td>
			</tr>
			<tr>
				<td colspan=4 align="left" style="padding:20px 0px;color:red;">
					<div style="text-align:right;margin-bottom:20px;">
            <table style="position:relative; top:30px;">
              <tr>
        				<td align="center" style="color:black;font-weight:bold;padding-right: 10px;">이름</td>
        				<td align="left">
        					<input type="text" class="input2" name="type" id="user_name" value="" style="width:95%;color:#B6B6B6;font-weight:bold;" readonly>
                  			<input type="hidden" name="annual_seq" id="annual_seq" value="">
        				</td>
        				<td align="center" style="color:black;font-weight:bold;padding-left: 20px;padding-right:10px;">기준연도</td>
        				<td align="left">
                  			<input type="text" class="input2" name="annual_period" id="annual_period" value="" style="width:95%;color:#B6B6B6;font-weight:bold;">
        				</td>
        			</tr>
            </table>
            <button type="button" name="button" class="btn-common btn-color4" style="margin-right:10px;" onclick="adjust_annual_del();">행삭제</button>
            <button type="button" name="button" class="btn-common btn-color2" onclick="adjust_annual_add();">행추가</button>
            <!-- <input type="button" class="basicBtn" value="행추가" onclick="adjust_annual_add();" /> -->
						<!-- <input type="button" class="basicBtn" value="행삭제" onclick="adjust_annual_del();"/> -->
					</div>
					<table id="adjust_annual_table" class="basic_table" style="width:100%;color:black;">
						<colgroup>
							<col width="10%" />
							<col width="20%" />
							<col width="30%" />
							<col width="10%" />
							<col width="30%" />
						</colgroup>
						<tr bgcolor="f8f8f9">
							<th height="30" ></th>
							<th>조정연차구분</th>
							<th>조정연차생성일</th>
							<th>조정연차일수</th>
							<th>내용</th>
						</tr>
					</table>
					* 삭감의 경우 조정연차일수에 마이너스(-) 부호를 적어주세요. ex) -1
				</td>
			</tr>
			<tr>
				<td colspan=4 align="center">
					<div style="margin-top:50px;">

						<!-- <img src="<?php echo $misc;?>img/dashboard/btn/btn_save.png" width="64" height="31" style="cursor:pointer" onclick="adjust_annual_save();"/> -->
            <button type="button" name="button" class="btn-common btn-color2" onclick="adjust_annual_save();" style="float:right;">저장</button>
            <button type="button" name="button" class="btn-common btn-color4" onclick="$('#attendance_input').bPopup().close();" style="float:right; margin-right:10px;">취소</button>
						<!-- <img src="<?php echo $misc;?>img/dashboard/btn/btn_cancel.png" width="64" height="31" style="cursor:pointer" onClick="$('#attendance_input').bPopup().close();"/> -->
					</div>
				</td>
			</tr>
		</table>
	<!-- </form> -->
</div>
</form>
</body>
<script type="text/javascript">
$(document).ready(function() {
   $(".yearpicker").yearpicker({
    //   year: 2021,
      startYear: 2019,
      endYear: 2050,
   });
});


  function chkForm () {
  	var mform = document.cform;

  	if (mform.card_num.value == "") {
  		mform.card_num.focus();
  		alert("카드번호를 입력해 주세요.");
  		return false;
  	}
  	if (mform.ws_time.value == "") {
  		mform.ws_time.focus();
  		alert("출근시간을 입력해 주세요.");
  		return false;
  	}
  	if (mform.wc_time.value == "") {
  		mform.wc_time.focus();
  		alert("퇴근시간을 입력해 주세요.");
  		return false;
  	}

  	mform.submit();
  	return false;
  }

  //연차생성
  function create_annual(){
	if($('input:checkbox[name="user_annual_seq"]:checked').length == 0){
		alert("선택된 자료가 없습니다.");
		return false;
	}

	$('input:checkbox[name="user_annual_seq"]').each(function () {
		if (this.checked == true) {
			var annual_seq = this.value;
			$.ajax({
				type: "POST",
				async: false,
				url: "<?php echo site_url(); ?>/admin/annual_admin/annual_management_user",
				dataType: "json",
				data: {
					seq: annual_seq
				},
				success: function (data) {
					if(Number(data.month_annual_cnt) + Number(data.annual_cnt) > 0){
						alert("이미 생성된 연차는 연차생성을 할 수 없습니다.");
						return true;
					}
					var type = data.annual_standard;
					var jd = data.join_company_date;
					var standard_year = data.annual_period;
					var join_company_date = new Date(jd); //입사일
					if(type == "calcDt"){//연차기준일 calcDt
						var selHour = format_date(join_company_date); // 입사일자
						var orgSelMinute=(standard_year-1)+"-12-31";
						var selMinute = (standard_year-1)+"-12-31";  // 생성일

						if(selHour > orgSelMinute){ //입사일이 생성일보다 늦을때 ^_^
							selMinute =(standard_year)+"-12-31";
						}

						var startDate = selHour.replace(/-/g, "");
						var endDate = selMinute.replace(/-/g, "");
						var arrAnnual = calculate.annual(selHour, selMinute);
						if(arrAnnual[0] == 0){ //근속년수 1 미만
							var date1 = new Date(selHour);
							var date2 = new Date(selMinute);
							var elapsedMSec = date2.getTime() - date1.getTime(); // 172800000
							var elapsedDay = (elapsedMSec / 1000 / 60 / 60 / 24) + 1; // 2

							var check_num = Math.floor(15*elapsedDay/365)+0.5;
							var continuous_service = (15*elapsedDay/365);

							if(check_num <= continuous_service){
								continuous_service = Math.round(continuous_service);
							}else{
								continuous_service = check_num
							}


							if(selHour > orgSelMinute){ //입사일이 생성일보다 늦을때 ^_^
								arrAnnual[0]= arrAnnual[1];
								arrAnnual[1]= 0;
							}else{
								arrAnnual[0]= Math.floor((365-(elapsedDay))/30);
								arrAnnual[1]= continuous_service;
							}

						}else{
							var getDate = new Date();
							getDate = util.getFormatDate(getDate);
							var selHour = format_date(join_company_date) // 입사일자
							var selMinute = format_date(new Date(new Date().getFullYear(),join_company_date.getMonth(),join_company_date.getDate()-1)); // 기준일자
							var startDate = selHour.replace(/-/g, "");
							var endDate = selMinute.replace(/-/g, "");
							var arrAnnual = calculate.annual(selHour, selMinute);
							arrAnnual[0] = 0 ;
						}

					}else{// 입사일 entryDt
						var getDate = new Date();
							getDate = util.getFormatDate(getDate);
						var selHour = format_date(join_company_date) // 입사일자
						var selMinute = format_date(new Date(new Date().getFullYear(),join_company_date.getMonth(),join_company_date.getDate()-1)); // 기준일자
						var startDate = selHour.replace(/-/g, "");
						var endDate = selMinute.replace(/-/g, "");
						var arrAnnual = calculate.annual(selHour, selMinute);
						arrAnnual[0] = 0 ;
					}
					$.ajax({
						type: "POST",
						async: false,
						url: "<?php echo site_url(); ?>/admin/annual_admin/user_annual_update",
						dataType: "json",
						data: {
							type:1, //생성
							seq: annual_seq,
							month_annual_cnt : arrAnnual[0],
							annual_cnt :arrAnnual[1]
						},
						success: function (data) {

						}
					})
				}
			})
		}
	});
	alert("연차가 생성되었습니다.");
	location.reload();
  }

//yyyy-mm-dd 변환
function format_date(d){
	d = new Date(d);
	var year = d.getFullYear();
	var month = ("0" + (1 + d.getMonth())).slice(-2);
	var day = ("0" + d.getDate()).slice(-2);
	return year + "-" + month + "-" + day;
}

// 연차삭제
function annualReset() {
	if($('input:checkbox[name="user_annual_seq"]:checked').length == 0){
		alert("선택된 자료가 없습니다.");
		return false;
	}
	if(confirm("연차를 삭제하시겠습니까?")){
	$('input:checkbox[name="user_annual_seq"]').each(function () {
		if (this.checked == true) {
			$.ajax({
				type: "POST",
				async: false,
				url: "<?php echo site_url(); ?>/admin/annual_admin/user_annual_update",
				dataType: "json",
				data: {
					type:2,
					seq: this.value,
					month_annual_cnt : 0,
					annual_cnt :0,
					remainder_annual_cnt : 0
				},
				success: function (data) {

				}
			})
		}
	});
	alert("연차가 삭제되었습니다.");
	location.reload();
	}
}

//전체선택 체크박스 클릭
$(function(){
	$("#user_annual_all").click(function () { //만약 전체 선택 체크박스가 체크된상태일경우
		if ($("#user_annual_all").prop("checked")) { //해당화면에 전체 checkbox들을 체크해준다
			$("input[name=user_annual_seq]").prop("checked", true);
		} else { //해당화면에 모든 checkbox들의 체크를해제시킨다.
			$("input[name=user_annual_seq]").prop("checked", false);
		}
	})
})

//조정연차
function adjust_annual(){
	if($('input:checkbox[name="user_annual_seq"]:checked').length == 0){
		alert("선택된 자료가 없습니다.");
		return false;
	}else if($('input:checkbox[name="user_annual_seq"]:checked').length > 1){
		alert("자료를 하나만 선택하세요.");
		return false;
	}
	$('input:checkbox[name="user_annual_seq"]').each(function () {
		if (this.checked == true) {
			$.ajax({
			type:"POST",
			async:false,
			url:"<?php echo site_url(); ?>/admin/annual_admin/annual_management_user",
			dataType:"json",
			data:{
				seq:this.value
			},
			success: function(data) {
				$("#annual_seq").val(data.seq);
				$("#user_name").val(data.user_name);
				$("#annual_period").val(data.annual_period);
			}
			})
		}
	});
	//조정연차 있으면 가져와야지
	$.ajax({
		type: "POST",
		async: false,
		url: "<?php echo site_url(); ?>/admin/annual_admin/adjust_annual_save",
		dataType: "json",
		data: {
			type: 0 ,//insert
			annual_seq : $("#annual_seq").val(),
		},
		success: function (data) {
			for(var i=0; i<data.length; i++){
				var html = "<tr class='adjust_annual_"+data[i].seq+"'><td align='center'>";
				html += "<input type='checkbox' name='annual_each' value='update_annual_"+data[i].seq+"'></td>";
				html += "<td align='center'>"+data[i].adjust_annual_type+"</td>";
				// <select class='input7 adjust_annual_type'><option value=''>미선택</option><option value='조정'";
				// if(data[i].adjust_annual_type =="조정"){
				// 	html +="selected";
				// }
				// html +=">조정</option><option value='포상'";
				// if(data[i].adjust_annual_type =="포상"){
				// 	html += "selected";
				// }
				// html +=">포상</option><option value='삭감'";
				// if(data[i].adjust_annual_type =="삭감"){
				// 	html +="selected";
				// }
				// html += ">삭감</option></select>

				// html +="<td><input type='date' class='input7 insert_date' value='"+data[i].insert_date+"' /></td>";
				html +="<td>"+data[i].insert_date+"</td>";
				html +="<td align='center'>"+data[i].adjust_annual_cnt+"</td>";
				html +="<td>"+data[i].comment+"</td></tr>";
				// html +="<td><input type='text' class='input7 adjust_annual_cnt' value='"+data[i].adjust_annual_cnt+"'  /></td>";
				// html +="<td><input type='text' class='input7 comment' value='"+data[i].comment+"' /></td></tr>";
				$("#adjust_annual_table").append(html);
			}
		}
	})
	$("#delete_adjust_seq").val("");
	$("#attendance_input").bPopup();
}

//조정연차 추가
function adjust_annual_add(){
	var html = "<tr class='insert_annual'><td align='center'><input type='checkbox' name='annual_each' ></td>";
	html +=" <td><select class='input7 adjust_annual_type' style='color:#B0B0B0;font-weight:bold;'><option value=''>미선택</option><option value='조정'>조정</option><option value='포상'>포상</option><option value='삭감'>삭감</option></select></td>";
	html +="<td><input type='date' class='input7 insert_date' style='color:#B0B0B0;' /></td>";
	html +="<td><input type='text' class='input7 adjust_annual_cnt' style='color:#B0B0B0;' /></td>";
	html +="<td><input type='text' class='input7 comment' style='color:#B0B0B0;' /></td></tr>";
	$("#adjust_annual_table").append(html);

}

//조정연차 삭제
function adjust_annual_del(){
	if($('input:checkbox[name="annual_each"]:checked').length == 0){
		alert("선택된 자료가 없습니다.");
		return false;
	}
	$('input:checkbox[name="annual_each"]').each(function () {
		if (this.checked == true) {
			if($(this).closest("tr").attr("class").indexOf("adjust_annual_") !== false){ //insert 가 아닐때
				var seq = $(this).closest("tr").attr("class").replace("adjust_annual_","");
				$("#delete_adjust_seq").val($("#delete_adjust_seq").val()+","+seq);
			}
			$(this).closest("tr").remove();
		}
	});
}

//조정연차 저장
function adjust_annual_save(){
	var insert_len = $(".insert_annual").length;
	var result = true;
	if($("#delete_adjust_seq").val() != ""){
		var delete_seq = $("#delete_adjust_seq").val().replace(",","");
		delete_seq = delete_seq.split(",");
		for(var i=0; i<delete_seq.length; i++){
			$.ajax({
				type: "POST",
				async: false,
				url: "<?php echo site_url(); ?>/admin/annual_admin/adjust_annual_save",
				dataType: "json",
				data: {
					type: 2, //delete
					seq: delete_seq[i],
					annual_seq : $("#annual_seq").val(),
				},
				success: function (data) {
					result = data;
				}
			})
		}
	}

	for(var i=0; i < insert_len; i++){
		var adjust_annual_type = $(".insert_annual").eq(i).find($(".adjust_annual_type")).val();
		var insert_date = $(".insert_annual").eq(i).find($(".insert_date")).val();
		var adjust_annual_cnt = $(".insert_annual").eq(i).find($(".adjust_annual_cnt")).val();
		var comment = $(".insert_annual").eq(i).find($(".comment")).val();

		$.ajax({
			type: "POST",
			async: false,
			url: "<?php echo site_url(); ?>/admin/annual_admin/adjust_annual_save",
			dataType: "json",
			data: {
				type: 1 ,//insert
				annual_seq : $("#annual_seq").val(),
				adjust_annual_type :adjust_annual_type,
				insert_date:insert_date,
				adjust_annual_cnt:adjust_annual_cnt,
				comment:comment
			},
			success: function (data) {
				result = data;
			}
		})
	}


	if(result){
		alert("저장되었습니다.");
		location.reload();
	}
}

function GoSearch(){
	var searchkeyword = '';
	for (i = 1; i <= $(".filtercolumn").length; i++) {
		if (i == 1) {
			searchkeyword += $("#filter" + i).val().trim();
		} else {
			var filter_val = $("#filter" + i).val().trim();
			searchkeyword += ',' + filter_val;
		}
	}

  $("#searchkeyword").val(searchkeyword)

  if (searchkeyword.replace(/,/g, "") == "") {
    alert("검색어가 없습니다.");
	return false;
  }

  document.mform.action = "<?php echo site_url();?>/admin/annual_admin/annual_management";
  document.mform.submit();
}
</script>
</html>

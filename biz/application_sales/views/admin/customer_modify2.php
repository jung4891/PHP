<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<style>
	p, div, span, a, a:hover, a:visited, a:active, label, input, h1,h2,h3,h4,h5,h6{font-family: "Noto Sans KR";}
</style>
<link rel="stylesheet" href="/misc/css/dashboard.css">
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" /> <!-- 조직도 생성 -->
<link rel="stylesheet" href="/misc/css/tech_schedule/proton/style.min.css" /> <!-- 조직도 생성 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
<script type="text/javascript" src="/misc/js/jquery.bpopup-0.1.1.min.js"></script>
<script>
$(function() {
	$("#person_add").click(function() {
    if($("#insert_array").val() == ''){
      $("#insert_array").val(Number(Number($("#row_max_index").val()) + Number(1)));
    }else{
      $("#insert_array").val($("#insert_array").val() + ',' + Number(Number($("#row_max_index").val()) + Number(1)));
    }
		$("#row_max_index").val(Number(Number($("#row_max_index").val()) + Number(1)));
		var id = "person_insert_field_" + $("#row_max_index").val();
		var id2 = "person_insert_field_2_" + $("#row_max_index").val();
		$('#lastline').before("<tr id=" + id + "><td colspan='9' height='1' bgcolor='#e8e8e8'></td></tr><tr id=" + id2 + "><td height='40' align='center' bgcolor='f8f8f9' style='font-weight:bold;'>담당자</td><td height='40' align='center' class='t_border' ><input name='user_branch' type='text' class='input2' style='width:80px;' id='user_branch' value=''/></td><td height='40' align='center' class='t_border'><input name='user_duty' type='text' class='input2' style='width:80px;' id='user_duty' value=''/></td><td align='center' class='t_border' ><input name='user_name' type='text' class='input2' style='width:80px;' id='user_name' value=''/></td><td align='center' class='t_border'><input name='user_tel' type='text' class='input2' style='width:90px;' id='user_tel' value='' onclick='checkNum(this);' onKeyUp='checkNum(this);'/></td><td align='center' class='t_border' ><input name='user_email' type='text' class='input2' id='user_email' value='' style='width:130px;'/></td><td align='center' class='t_border'><select name='user_work' id='user_work' class='select7' style='width:90px;'><option value='영업' selected>영업</option><option value='기술'>기술</option><option value='관리'>관리</option><option value='개발'>개발</option></select></td><td align='center' class='t_border' ><input type='checkbox' name='manager' id='manager' value=''></td><td align='center' class='t_border' ><select name='bill_flag' id='bill_flag' class='select7' style='width:90px;'><option value='N'>N</option><option value='Y'>Y</option></select></td><td align='center' class='t_border' ><input type='checkbox' name='default_flag1' id='default_flag1' value='Y'/></td><td align='center' class='t_border'><img src='<?php echo $misc;?>img/btn_del0.jpg' style='cursor:pointer;' onclick='javascript:person_list_del(" + $("#row_max_index").val() + ");'/></td></tr>");
	});
});

function person_list_del(idx,seq){
  if(seq != undefined){
    if($("#delete_array").val() == ''){
      $("#delete_array").val(seq);
    }else{
      $("#delete_array").val($("#delete_array").val() + ',' + seq);
    }
  }
	$("#person_insert_field_" + idx).remove();
	$("#person_insert_field_2_" + idx).remove();
}

function checkNum(obj) {
    var phone_num;
    function phone_regexp(phonNum) {
        phone_num = phonNum.replace(/[^0-9]/g, "").replace(/(^02|^0505|^1[0-9]{3}|^0[0-9]{2})([0-9]+)?([0-9]{4})$/,
            "$1-$2-$3").replace("--", "-");
    }
    var word = obj.value;
    phone_regexp(word);
    var str = "1234567890";
    obj.value = phone_num;
}
</script>
<script language="javascript">
function chkForm () {
	var mform = document.cform;

	var objuser_branch = document.getElementsByName("user_branch");
	var objuser_duty = document.getElementsByName("user_duty");
	var objuser_name = document.getElementsByName("user_name");
	var objuser_tel = document.getElementsByName("user_tel");
	var objuser_email = document.getElementsByName("user_email");
	var objuser_work = document.getElementsByName("user_work");
  var objmanager = document.getElementsByName("manager");
	var objbill_flag = document.getElementsByName("bill_flag");
	var objdefault_flag1 = document.getElementsByName("default_flag1");

	// if(objuser_duty.length > 0) {
	// 	for(i=0; i<objuser_duty.length; i++) {
	// 		if($.trim(objuser_duty[i].value) == "") {
	// 			alert(i+1 + '번째 직급을 입력해 주세요.');
	// 			objuser_duty[i].focus();
	// 			return;
	// 		}
	// 		if($.trim(objuser_name[i].value) == "") {
	// 			alert(i+1 + "번째 이름을 입력하십시오.");
	// 			objuser_name[i].focus();
	// 			return;
	// 		}
	// 		if($.trim(objuser_tel[i].value) == "") {
	// 			alert(i+1 + "번째 연락처를 입력하십시오.");
	// 			objuser_tel[i].focus();
	// 			return;
	// 		}
	// 		if($.trim(objuser_email[i].value) == "") {
	// 			alert(i+1 + "번째 이메일을 입력하십시오.");
	// 			objuser_email[i].focus();
	// 			return;
	// 		}
	// 		var regex3=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
	// 		if(regex3.test(objuser_email[i].value) === false) {
	// 			alert("잘못된 이메일 형식입니다.");
	// 			objuser_email[i].focus();
	// 			return false;
	// 		}
	// 		if($.trim(objuser_work[i].value) == "") {
	// 			alert(i+1 + "번째 담당업무를 입력하십시오.");
	// 			objuser_work[i].focus();
	// 			return;
	// 		}
	// 	}
	// }

	var checked_value = "";
	$("#person_array").val('');
	if(objuser_duty.length > 0) {
		for(i=0; i<objuser_duty.length; i++) {
			if(objdefault_flag1[i].checked == true) {
				checked_value = "Y";
			} else {
				checked_value = "N";
			}

      if(objmanager[i].checked == true) {
				objmanager[i].value = "Y";
			} else {
				objmanager[i].value = "N";
			}
		}
	}

  if($("#update_array").val() != ""){
    var update_array = $("#update_array").val().split(',');
    update_array = update_array.filter(function(a, i, self){
      return self.indexOf(a) === i;
    });

    var updateObject = new Object();
    var update_total = [];
    for(i=0; i<update_array.length; i++){
      var num = Number(update_array[i]);
      $("#update_array").val()
      var user_seq = $('#person_insert_field_2_'+num).find('input[name="user_seq"]').val();
      var user_branch = $('#person_insert_field_2_'+num).find('input[name="user_branch"]').val();
      var user_duty = $('#person_insert_field_2_'+num).find('input[name="user_duty"]').val();
      var user_name = $('#person_insert_field_2_'+num).find('input[name="user_name"]').val();
      var user_tel = $('#person_insert_field_2_'+num).find('input[name="user_tel"]').val();
      var user_email = $('#person_insert_field_2_'+num).find('input[name="user_email"]').val();
      var user_work = $('#person_insert_field_2_'+num).find('select[name="user_work"]').val();
      var manager = $('#person_insert_field_2_'+num).find('input[name="manager"]').val();
      var bill_flag = $('#person_insert_field_2_'+num).find('select[name="bill_flag"]').val();
      var default_flag = $('#person_insert_field_2_'+num).find('input[name="default_flag1"]').val();

      update_total[i] = user_seq + ";;;"+ user_branch + ";;;"+ user_duty + ";;;" + user_name + ";;;" + user_tel + ";;;" + user_email + ";;;" + user_work+ ";;;" + manager + ";;;" + bill_flag + ";;;" + default_flag ;
    }
    updateObject.value = update_total;
    update_total = JSON.stringify(updateObject);
    $("#update_array").val(update_total);
  }

  if($("#insert_array").val() != ""){
    var insert_array = $("#insert_array").val().split(',');
    insert_array = insert_array.filter(function(a, i, self){
      return self.indexOf(a) === i;
    });

    var insertObject = new Object();
    var insert_total = [];
    for(i=0; i<insert_array.length; i++){
      var num = Number(insert_array[i]);
      if($('#person_insert_field_2_'+num).length > 0){
        var user_branch = $('#person_insert_field_2_'+num).find('input[name="user_branch"]').val();
        var user_duty = $('#person_insert_field_2_'+num).find('input[name="user_duty"]').val();
        var user_name = $('#person_insert_field_2_'+num).find('input[name="user_name"]').val();
        var user_tel = $('#person_insert_field_2_'+num).find('input[name="user_tel"]').val();
        var user_email = $('#person_insert_field_2_'+num).find('input[name="user_email"]').val();
        var user_work = $('#person_insert_field_2_'+num).find('select[name="user_work"]').val();
        var manager = $('#person_insert_field_2_'+num).find('input[name="manager"]').val();
        var bill_flag = $('#person_insert_field_2_'+num).find('select[name="bill_flag"]').val();
        var default_flag = $('#person_insert_field_2_'+num).find('input[name="default_flag1"]').val();

        insert_total[i] = user_branch + ";;;"+ user_duty + ";;;" + user_name + ";;;" + user_tel + ";;;" + user_email + ";;;" + user_work+ ";;;" + manager + ";;;" + bill_flag + ";;;" + default_flag ;

      }
    }
    insert_total  = insert_total.filter(function(item) {//빈배열 제거
      return item !== null && item !== undefined && item !== '';
    });
    insertObject.value = insert_total;
    insert_total = JSON.stringify(insertObject);
    $("#insert_array").val(insert_total);
  }

  if($("#update_array").val() == "" && $("#insert_array").val() == ""  && $("#delete_array").val() == ""){
		alert("정상적으로 처리되었습니다.");
    location.href = "<?php echo site_url(); ?>/admin/customer/customer_view6/<?php echo $seq; ?>";
    // location.href = "<?php echo site_url(); ?>/admin/customer/customer_view3/<?php echo $seq; ?>";
    return false;
  }

	mform.submit();
	return false;
}
</script>
<body>
<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
<div align="center">
  <div class="dash1-1">
		<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
			<form name="cform" action="<?php echo site_url();?>/admin/customer/customer_input_action2" method="post" onSubmit="javascript:chkForm();return false;">
			<input type="hidden" id="person_array" name="person_array" />
			<input type="hidden" id="update_array" name="update_array" />
			<input type="hidden" id="insert_array" name="insert_array" />
			<input type="hidden" id="delete_array" name="delete_array" />
			<input type="hidden" name="seq" value="<?php echo $seq;?>">
			<input type="hidden" name="mode" value="1">
			<!-- 타이틀 부분 시작 -->
				<tr height="5%">
					<td class="dash_title">
						<img src="<?php echo $misc;?>img/dashboard/title_customer_list.png"/>
					</td>
				</tr>
				<!-- 타이틀 부분 끝 -->
				<tr>
			  	<td align="center" valign="top">
    				<table width="1130" height="100%" cellspacing="0" cellpadding="0" >
        			<tr>

            		<td width="923" align="center" valign="top">

		            <!--내용-->
		            	<table width="1100" border="0" style="margin-top:50px; margin-bottom: 50px;">
			 <!--탭-->
			              <tr>
			              	<td height="40">
			                   <ul style="list-style:none; padding:0; margin:0;">
			                    <li style="float:left;">
														<a href="<?php echo site_url();?>/admin/customer/customer_view?seq=<?php echo $seq;?>&mode=modify">
															<img src="<?php echo $misc;?>img/dashboard/btn/btn_tab-1_off.png" />
														</a>
													</li>
													<li style="float:left;">&nbsp;&nbsp;</li>
			                    <li style="float:left;">
														<a href="<?php echo site_url();?>/admin/customer/customer_view2/<?php echo $seq;?>"
														>
															<img src="<?php echo $misc;?>img/dashboard/btn/btn_tab-2_on.png" />
														</a>
													</li>
													<li style="float:left;">&nbsp;&nbsp;</li>
			                    <!-- <li style="float:left;"><a href="<?php echo site_url();?>/admin/customer/customer_view3/<?php echo $seq;?>"><img src="<?php echo $misc;?>img/sales_tab_3.jpg" /></a></li>
			                    <li style="float:left;"><a href="<?php echo site_url();?>/admin/customer/customer_view4/<?php echo $seq;?>"><img src="<?php echo $misc;?>img/sales_tab_4.jpg" /></a></li>
			                    <li style="float:left;"><a href="<?php echo site_url();?>/admin/customer/customer_view5/<?php echo $seq;?>"><img src="<?php echo $misc;?>img/sales_tab_5.jpg" /></a></li> -->
			                    <li style="float:left;">
														<a href="<?php echo site_url();?>/admin/customer/customer_view6/<?php echo $seq;?>">
															<img src="<?php echo $misc;?>img/dashboard/btn/btn_tab-6_off.png" />
														</a>
													</li>
		                    </ul>
			                </td>
			              </tr>
			              <!--//탭-->
			              <!--작성-->
			              <tr>
			                <td valign="top">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
				                  <colgroup>
				                    <col width="10%" />
				                  	<col width="10%" />
				                    <col width="10%" />
				                    <col width="10%" />
				                    <col width="10%" />
				                    <col width="15%" />
				                    <col width="10%" />
				                    <col width="5%" />
				                    <col width="10%" />
				                    <col width="5%" />
				                    <col width="5%" />
				                  </colgroup>
													<tr>
														<td height="40" colspan="11" align="center" style="font-weight:bold; font-size:16px; padding:10px 0;">담당자</td>
													</tr>
													<tr>
				                    <td colspan="11" height="1" bgcolor="#e8e8e8"></td>
				                  </tr>
				                  <tr>
				                    <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">담당자</td>
				                    <td height="40" align="center" class="t_border" bgcolor="f8f8f9" >지사</td>
				                    <td height="40" align="center" class="t_border" bgcolor="f8f8f9" >직급</td>
				                    <td align="center" class="t_border" bgcolor="f8f8f9" >이름</td>
				                    <td align="center" class="t_border" bgcolor="f8f8f9" >연락처</td>
				                    <td align="center" class="t_border" bgcolor="f8f8f9" >이메일</td>
				                    <td align="center" class="t_border" bgcolor="f8f8f9" >담당업무</td>
				                    <td align="center" class="t_border" bgcolor="f8f8f9" >담당자여부</td>
				                    <td align="center" class="t_border" bgcolor="f8f8f9" >계산서담당여부</td>
				                    <td align="center" class="t_border" bgcolor="f8f8f9" >기본</td>
				                    <td align="center" class="t_border" bgcolor="f8f8f9" >
															<img src="<?php echo $misc;?>img/btn_add.jpg" id="person_add" name="person_add" style="cursor:pointer;"/>
														</td>
				                  </tr>

                  <!--추가항목-->
<?php
		$i = 1;
		foreach ( $view_val as $item ) {
			if($i == 1) {
?>
                  <tr id="person_insert_field_<?php echo $i;?>">
                    <td colspan="11" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr id="person_insert_field_2_<?php echo $i;?>">
                    <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">담당자</td>
                    <td height="40" align="center" class="t_border" >
                      <input type="hidden" name="user_seq" id="user_seq"  value="<?php echo $item['seq'];?>" class="input2" style="width:80px;" />
                      <input name="user_branch" type="text" class="input2" style="width:80px;" id="user_branch" value="<?php echo $item['user_branch'];?>" onchange="update_staff(<?php echo $i;?>)"/>
                    </td>
                    <td height="40" align="center" class="t_border" >
											<input name="user_duty" type="text" class="input2" style="width:80px;" id="user_duty" value="<?php echo $item['user_duty'];?>" onchange="update_staff(<?php echo $i;?>)"/>
										</td>
                    <td align="center" class="t_border" >
											<input name="user_name" type="text" class="input2" style="width:80px;" id="user_name" value="<?php echo $item['user_name'];?>" onchange="update_staff(<?php echo $i;?>)" />
										</td>
                    <td align="center" class="t_border" >
											<input name="user_tel" type="text" class="input2" style="width:90px;" id="user_tel" value="<?php echo $item['user_tel'];?>" onclick="checkNum(this);" onKeyUp="checkNum(this);" onchange="update_staff(<?php echo $i;?>)"/>
										</td>
                    <td align="center" class="t_border" >
											<input name="user_email" type="text" class="input2" style="width:130px;" id="user_email" value="<?php echo $item['user_email'];?>" onchange="update_staff(<?php echo $i;?>)"/></td>
                    <td align="center" class="t_border" >
                      <select name="user_work" id="user_work" class="select7" class="input2" style="width:90px;" onchange="update_staff(<?php echo $i;?>)">
                        <option value="" <?php if($item['user_work']==""){echo "selected";}?>>미선택</option>
                        <option value="영업"<?php if($item['user_work']=="영업"){echo "selected";}?>>영업</option>
                        <option value="기술"<?php if($item['user_work']=="기술"){echo "selected";}?>>기술</option>
                        <option value="관리"<?php if($item['user_work']=="관리"){echo "selected";}?>>관리</option>
                        <option value="개발"<?php if($item['user_work']=="개발"){echo "selected";}?>>개발</option>
                      </select>
                    </td>
                    <td align="center" class="t_border" >
                      <input type="checkbox" name="manager" id="manager" value="<?php echo $item['manager'] ;?>" <?php if($item['manager'] == "Y") { echo "checked"; }?> onchange="update_staff(<?php echo $i;?>)">
                    </td>
                    <td align="center" class="t_border" >
                      <select name="bill_flag" id="bill_flag" class="select7" class="input2" style="width:90px;" onchange="update_staff(<?php echo $i;?>)">
                        <option value="N" <?php if($item['bill_flag'] == "N") { echo "selected"; }?>>N</option>
                        <option value="Y" <?php if($item['bill_flag'] == "Y") { echo "selected"; }?>>Y</option>
                      </select>
                    </td>
                    <td align="center" class="t_border" >
											<input type="checkbox" name="default_flag1" id="default_flag1" value="Y" onchange="update_staff(<?php echo $i;?>)" <?php if($item['default_flag'] == "Y") { echo "checked"; }?>>
										</td>
                    <td align="center" class="t_border" >
											<!-- <img src="<?php echo $misc;?>img/btn_del0.jpg" style="cursor:pointer;"/> -->
										</td>
                  </tr>
<?php
			} else {
?>
				  				<tr id="person_insert_field_<?php echo $i;?>">
                    <td colspan="11" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr id="person_insert_field_2_<?php echo $i;?>">
                    <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">담당자</td>
                    <td height="40" align="center" class="t_border" >
                      <input type="hidden" name="user_seq" id="user_seq" value="<?php echo $item['seq'];?>" />
                      <input name="user_branch" type="text" class="input2" style="width:80px;" id="user_branch" value="<?php echo $item['user_branch'];?>" onchange="update_staff(<?php echo $i;?>)"/></td>
                    <td height="40" align="center" class="t_border" >
											<input name="user_duty" type="text" class="input2" style="width:80px;" id="user_duty" value="<?php echo $item['user_duty'];?>" onchange="update_staff(<?php echo $i;?>)"/>
										</td>
                    <td align="center" class="t_border" >
											<input name="user_name" type="text" class="input2" style="width:80px;" id="user_name" value="<?php echo $item['user_name'];?>" onchange="update_staff(<?php echo $i;?>)"/>
										</td>
                    <td align="center" class="t_border" >
											<input name="user_tel" type="text" class="input2" style="width:90px;" id="user_tel" value="<?php echo $item['user_tel'];?>" onclick="checkNum(this);" onKeyUp="checkNum(this);" onchange="update_staff(<?php echo $i;?>)"/>
										</td>
                    <td align="center" class="t_border" >
											<input name="user_email" type="text" class="input2" style="width:130px;" id="user_email" value="<?php echo $item['user_email'];?>" onchange="update_staff(<?php echo $i;?>)"/>
										</td>
                    <td align="center" class="t_border" >
                      <select name="user_work" id="user_work" class="select7" style="width:90px;" onchange="update_staff(<?php echo $i;?>)">
                        <option value="" <?php if($item['user_work']==""){echo "selected";}?>>미선택</option>
                        <option value="영업"<?php if($item['user_work']=="영업"){echo "selected";}?>>영업</option>
                        <option value="기술"<?php if($item['user_work']=="기술"){echo "selected";}?>>기술</option>
                        <option value="관리"<?php if($item['user_work']=="관리"){echo "selected";}?>>관리</option>
                        <option value="개발"<?php if($item['user_work']=="개발"){echo "selected";}?>>개발</option>
                      </select>
                    </td>
                    <td align="center" class="t_border" >
                      <input type="checkbox" name="manager" id="manager" value="<?php echo $item['manager'] ;?>" onchange="update_staff(<?php echo $i;?>)" <?php if($item['manager'] == "Y") { echo "checked"; }?>>
                    </td>
                    <td align="center" class="t_border" >
											<select name="bill_flag" id="bill_flag" class="select7" style="width:90px;" onchange="update_staff(<?php echo $i;?>)">
	                      <option value="N" <?php if($item['bill_flag'] == "N") { echo "selected"; }?>>N</option>
	                      <option value="Y" <?php if($item['bill_flag'] == "Y") { echo "selected"; }?>>Y</option>
                    	</select>
										</td>
                    <td align="center" class="t_border" >
											<input type="checkbox" name="default_flag1" id="default_flag1" onchange="update_staff(<?php echo $i;?>)" <?php if($item['default_flag'] == "Y") { echo "checked"; }?>/>
										</td>
                    <td align="center" class="t_border" >
											<img src="<?php echo $misc;?>img/btn_del0.jpg" onclick="javascript:person_list_del(<?php echo $i;?>,'<?php echo $item['seq'];?>');" style="cursor:pointer;"/></td>
                  </tr>
<?php
			}
			$max_number = $i;
			$i++;
		}
?>
									<input type="hidden" id="row_max_index" name="row_max_index" value="<?=$max_number?>"/>
                  <!--//추가항목-->

                  <!--추가항목--
                  <tr>
                    <td colspan="9" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                    <td height="40" align="center" class="t_border" ><input name="textfield" type="text" class="input0" id="textfield" value=""/></td>
                    <td align="center" class="t_border" ><input name="textfield" type="text" class="input0" id="textfield" value=""/></td>
                    <td align="center" class="t_border" ><input name="textfield" type="text" class="input5" id="textfield" value=""/></td>
                    <td align="center" class="t_border" ><input name="textfield" type="text" class="input5" id="textfield" value=""/></td>
                    <td align="center" class="t_border" ><input name="textfield" type="text" class="input5" id="textfield" value=""/></td>
                    <td align="center" class="t_border" ><select name="select" id="select" class="input0">
                      <option>N</option>
                      <option>Y</option>
                    </select></td>
                    <td align="center" class="t_border" ><input type="checkbox" name="ckbox" id="ckbox"/></td>
                    <td align="center" class="t_border" ><a href="#" title="추가항목삭제" ><img src="<?php echo $misc;?>img/btn_del0.jpg" /></a></td>
                  </tr>
                  <!--//추가항목-->

                  <!--마지막라인-->
                  <tr id="lastline">
                    <td colspan="11" height="2" bgcolor="#e8e8e8"></td>
                  </tr>
                  <!--//마지막라인-->
                </table>
							</td>
            </tr>
            <!--//작성-->
            <tr>
              <td height="10"></td>
            </tr>
            <!--버튼-->
            <tr>
              <td align="center">
								<input type="image" src="<?php echo $misc;?>img/dashboard/btn/btn_next.png" width="64" height="31" style="cursor:pointer" onclick="javascript:chkForm();return false;"/>
								<img src="<?php echo $misc;?>img/dashboard/btn/btn_list.png" width="64" height="31" style="cursor:pointer" border="0" onclick="javascript:history.go(-1)"/>
							</td>
            </tr>
            <!--//버튼-->
            <tr>
              <td>&nbsp;</td>
            </tr>
          </table>
          <!--//내용-->
          </td>
        </tr>
     </table>
    </td>
  </tr>
</form>
</table>
</div>
</div>
<!--하단-->
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
<!--//하단-->
<script>
  function update_staff(row){
    if($("#update_array").val() == ''){
      $("#update_array").val(row);
    }else{
      $("#update_array").val($("#update_array").val() + ',' + row);
    }
  }
</script>
</body>
</html>

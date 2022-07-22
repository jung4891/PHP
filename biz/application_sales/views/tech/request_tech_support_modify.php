<?php
// 김수성 추가
$cnt = 0;
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
$this->cooperative_id = $this->phpsession->get( 'cooperative_id', 'stc' );
?>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<style>
    td {
        word-break: break-all;
        word-break: break-word;
    }
</style>
<script language="javascript">

  /// 제출전 확인할것들
  function chkForm() {
    var mform = document.cform;

    if($("#sortation").val() == "과금망(구내통신)"){
      $("#internal_ip").val($("#internal_ip1").val() + "|" + $("#internal_ip2").val());
    }

    if ($("#engineer_email").val() != '') {
      $('#result').val("접수완료");
    }

    if ($("#installation_date").val() != '' && $("#installation_date").val() != '0000-00-00') {
      $('#result').val("설치예정")
    }

    if($("#cfile").is(":disabled") || $("#cfile").val()){
      $('#result').val("승인요청");
    }

    if ($("#final_approval").val() == 'Y') {
      $('#result').val("지원완료");
    }

    //협력사가 바뀌었을 때 mail 다시 보내야하니깐 메일 체크 N으로 수정
    if('<?php echo $view_val['cooperative_company'] ;?>' != $("#cooperative_company").val()){
      $("#manager_mail_send").val('N');
    }

    //engineer가 바뀌었을때 mail 다시 보내야하니깐 메일 체크 N으로 수정
    if('<?php echo $view_val['engineer_name']; ?>' != $("#engineer_name").val()){
      $("#engineer_mail_send").val('N');
    }

    //첨부파일 등록할때 설치일자가 비워져있음 안돼
    if($("#cfile").val()){
      if($("#installation_date").val() == "" || $("#installation_date").val() == "0000-00-00"){
        alert("설치일자를 입력하세요");
        $("#installation_date").focus();
        return false;
      }
    }

    if($("#installation_date").val() == "" || $("#installation_date").val() == "0000-00-00"){
      var visit_count = 0;
    } else {
      var visit_count = 1;
    }
    var visit_date = '';
    $('input[name=visit_date_input]').each(function() {
      if ($(this).val()=='') {
        alert('방문 일자를 선택해주세요.');
        $(this).focus();
        return false;
      }
      if ($(this).val()!=''){
        visit_count ++;
        visit_date += $(this).val() + '/*/';
      }
    })

    $('#visit_count').val(visit_count);
    $('#visit_date').val(visit_date);

    var visit_remark = '';
    $('input[name=visit_remark_input]').each(function() {
      if ($(this).val()=='') {
        alert('방문 사유를 입력해주세요.');
        $(this).focus();
        return false;
      }
      if ($(this).val()!='') {
        visit_remark += $(this).val() + '/*/';
      }
    })

    $('#visit_remark').val(visit_remark);

    // alert($('#visit_date').val());
    // alert($('#visit_remark').val());

    mform.submit();
    return false;
  }
</script>
<body>
  <?php
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
  $visit_date = explode('/*/',$view_val['visit_date']);
  $visit_remark = explode('/*/',$view_val['visit_remark']);
  $visit_count = count($visit_date) - 1;
?>
<div align="center">
	<div class="dash1-1">
		<table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
			<tr height="5%">
				<td class="dash_title">
					기술지원요청
				</td>
			</tr>
			<tr>
				<td height="40"></td>
			</tr>
			<tr>
				<td align="right" style="padding-right:15%;">
					<input type="button" class="btn-common btn-color4" value="수정" onClick="javascript:chkForm();return false;">
					<input type="button" class="btn-common btn-color4" value="취소" onClick="javascript:history.go(-1)">
				</td>
			</tr>
      <tr>
				<td height="40"></td>
			</tr>
  		<tr>
    		<td width="100%" align="center" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
              <td>
                <form name="cform" action="<?php echo site_url(); ?>/tech/tech_board/request_tech_support_input_action" method="post" enctype="multipart/form-data" onSubmit="javascript:chkForm();return false;">
                  <input type="hidden" name="seq" value="<?php echo $seq; ?>">
                  <input type="hidden" name="visit_count" id='visit_count'>
                  <input type="hidden" name="visit_date" id='visit_date'>
                  <input type="hidden" name="visit_remark" id='visit_remark'>
                  <table id="input_table" width="70%" border="0" cellspacing="0" cellpadding="0" style="margin-left:12%;">
                    <colgroup>
                      <col width="20%">
                      <col width="30%">
                      <col width="20%">
                      <col width="30%">
                    </colgroup>
                    <tr>
      								<td colspan="4" height="1" bgcolor="#F4F4F4"></td>
      							</tr>
                    <tr name="test_c" id="test_c" class="tbl-tr">
                      <td class="tbl-title">구분
                      </td>
                      <td class="tbl-cell">
                        <?php if($tech_lv > 0){ ?>
                        <select class="select-common" name="sortation" id="sortation">
                            <option value="유통망(협력사)" <?php if($view_val['sortation']=="유통망(협력사)"){echo "selected" ;}?> >유통망(협력사)</option>
                            <option value="과금망(구내통신)" <?php if($view_val['sortation']=="과금망(구내통신)"){echo "selected" ;}?> >과금망(구내통신)</option>
                        </select>
                      <?php }else{ echo "<input class='input-common' name='sortation' id='sortation' value='{$view_val['sortation']}' readonly >";  }?>
                      </td>
                      <td class="tbl-title">지원유형</td>
                      <td class="tbl-cell">
                        <input type="hidden" name="manager_mail_send" id="manager_mail_send" class="input2" value="<?php echo $view_val['manager_mail_send'] ;?>" />
                        <input type="hidden" name="engineer_mail_send" id="engineer_mail_send" class="input2" value="<?php echo $view_val['engineer_mail_send'] ;?>" />
                        <?php if($tech_lv > 0){ ?>
                        <select class="select-common" name="support_type" id="support_type" onchange="supportType();">
                            <option value="신규설치" <?php if($view_val['support_type'] == "신규설치"){echo "selected" ;}?>>신규설치</option>
                            <option value="이전설치" <?php if($view_val['support_type'] == "이전설치"){echo "selected" ;}?>>이전설치</option>
                            <option value="장애지원" <?php if($view_val['support_type'] == "장애지원"){echo "selected" ;}?>>장애지원</option>
                            <option value="기타" <?php if($view_val['support_type'] == "기타"){echo "selected" ;}?>>기타</option>
                        </select>
                      <?php }else{ echo "<input class='input-common' name='support_type' id='support_type' value='{$view_val['support_type']}' readonly >";  }?>
                      </td>
                    </tr>
                    <tr>
      								<td colspan="4" height="1" bgcolor="#F4F4F4"></td>
      							</tr>
                    <tr class="tbl-tr">
                      <td class="tbl-title">고객사</td>
                      <td class="tbl-cell">
                        <input name="customer_company" id="customer_company" class="input-common" value="<?php echo $view_val['customer_company'];?>"<?php if($tech_lv < 1){echo "readonly" ;} ?> >
                      </td>
                      <td class="tbl-title">등록자</td>
                      <td class="tbl-cell">
                        <input class="input-common" type="text" id="writer" name="writer" value="<?php echo $view_val['writer']; ?>"<?php if($tech_lv < 1){echo "readonly" ;} ?>>
                      </td>
                    </tr>
                    <tr>
      								<td colspan="4" height="1" bgcolor="#F4F4F4"></td>
      							</tr>

      							<tr><td height=30></td></tr>

      							<tr>
      								<td class="tbl-sub-title">* 기술 담당자</td>
      							</tr>
                    <tr>
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>
            <?php foreach ($durian_engineer as $de) { ?>
                    <tr class="tbl-tr">
                      <td class="tbl-title" rowspan="3">담당자</td>
                      <td class="tbl-cell" rowspan="3"><?php echo $de['user_name'];?></td>
                      <td class="tbl-title">연락처</td>
                      <td class="tbl-cell"><?php echo $de['user_tel'];?></td>
                    </tr>
                    <tr>
      								<td colspan="2" height="1" bgcolor="#F4F4F4"></td>
      							</tr>
                    <tr class="tbl-tr">
                      <td class="tbl-title">e-mail</td>
                      <td class="tbl-cell"><?php echo $de['user_email'];?></td>
                    </tr>
                    <tr>
      								<td colspan="4" height="1" bgcolor="#F4F4F4"></td>
      							</tr>
            <?php } ?>
                    <tr>
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>

      							<tr><td height=30></td></tr>

      							<tr>
      								<td class="tbl-sub-title">* 협력사 정보</td>
      							</tr>
                    <tr>
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>
                    <tr class="tbl-tr">
                      <td class="tbl-title">협력사</td>
                      <td class="tbl-cell">
                        <input type="hidden" name="cooperative_company" id="cooperative_company" value='<?php echo $view_val['cooperative_company'] ;?>' />
                        <?php if($tech_lv >= 1){ ?>
                        <select class="select-common" name="cooperative_company_seq" id="cooperative_company_seq" onclick="cooperative_change();">
                            <option value="" selected>협력사 선택</option>
                            <?php foreach($cooperative_company as $parter){
                                echo "<option value='{$parter['seq']}'";
                                if($parter['company_name'] == $view_val['cooperative_company']){
                                    echo "selected";
                                }
                                echo">{$parter['company_name']}</option>";
                            }
                            ?>
                        </select>
                        <?php }else{
                          echo $view_val['cooperative_company'] ;
                          foreach($cooperative_company as $parter){
                            if($parter['company_name'] == $view_val['cooperative_company']){
                              echo "<input type='hidden' name='cooperative_company_seq' id='cooperative_company_seq' value='{$parter['seq']}' >";
                            }
                          }
                          }?>
                      </td>
                      <td class="tbl-title">담당자</td>
                      <td class="tbl-cell"><input name="cooperative_manager" id="cooperative_manager" class="input-common" value="<?php echo $view_val['cooperative_manager'];?>" <?php if($tech_lv < 1){echo "readonly" ;} ?>></td>
                    </tr>
                    <tr>
      								<td colspan="4" height="1" bgcolor="#F4F4F4"></td>
      							</tr>
                    <tr class="tbl-tr">
                      <td class="tbl-title">연락처</td>
                      <td class="tbl-cell">
                        <input name="cooperative_tel" id="cooperative_tel" class="input-common" value="<?php echo $view_val['cooperative_tel'];?>" <?php if($tech_lv < 1){echo "readonly" ;} ?>>
                      </td>
                      <td class="tbl-title">e-mail</td>
                      <td class="tbl-cell">
                        <input name="cooperative_email" id="cooperative_email" class="input-common" value="<?php echo $view_val['cooperative_email'];?>" <?php if($tech_lv < 1){echo "readonly" ;} ?>>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>

      							<tr><td height=30></td></tr>

      							<tr>
      								<td class="tbl-sub-title">* 엔지니어 정보</td>
      							</tr>
                    <tr>
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>
                    </tr>
                    <tr class="tbl-tr">
                      <td class="tbl-title">엔지니어</td>
                      <td class="tbl-cell">
                        <input type="hidden" name="engineer_name" id="engineer_name" value="<?php echo $view_val['engineer_name']; ?>">
                        <?php if(!empty($cooperativeid) && ($tech_lv > 0 || strpos($view_val['cooperative_email'],$cooperativeid) !== false)){ ?>
                        <select class="select-common" name="engineer_seq" id ="engineer_seq" onchange="engineer_select();">
                         <?php if($view_val['engineer_name']== ''){ echo '<option value="selected">엔지니어 선택</option>' ; }?>
                        </select>
                        <?php }else{ echo $view_val['engineer_name']; } ?>
                      </td>
                      <td class="tbl-title">지사</td>
                      <td class="tbl-cell">
                        <input type="text" class="input-common" name="engineer_branch" id ="engineer_branch" value="<?php echo $view_val['engineer_branch']; ?>" <?php if(($tech_lv < 1) && !empty($cooperativeid) && (strpos($view_val['cooperative_email'],$cooperativeid) === false)){echo "readonly" ;} ?> />
                      </td>
                    </tr>
                    <tr>
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>
                    <tr class="tbl-tr">
                      <td class="tbl-title">연락처</td>
                      <td class="tbl-cell">
                        <input name="engineer_tel" id="engineer_tel" class="input-common" value="<?php echo $view_val['engineer_tel']; ?>" <?php if(($tech_lv < 1) && !empty($cooperativeid) &&  (strpos($view_val['cooperative_email'],$cooperativeid) === false)){echo "readonly" ;} ?>>
                      </td>
                      <td class="tbl-title">e-mail</td>
                      <td class="tbl-cell">
                        <input name="engineer_email" id="engineer_email" class="input-common" value="<?php echo $view_val['engineer_email'];?>" <?php if(($tech_lv < 1) && !empty($cooperativeid) &&  (strpos($view_val['cooperative_email'],$cooperativeid) === false)){echo "readonly" ;} ?>>
                      </td>
                    </tr>
                    <tr id="err_row1">
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>

      							<tr><td height=30></td></tr>

      							<tr>
      								<td class="tbl-sub-title">* 사업장 정보</td>
      							</tr>
                    <tr>
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>
                    <tr id="err_row2" class="tbl-tr">
                      <td class="tbl-title">사업장명</td>
                      <td class="tbl-cell">
                        <input name="workplace_name" id="workplace_name" class="input-common" value="<?php echo $view_val['workplace_name']; ?>" <?php if($tech_lv < 1){echo "readonly" ;} ?>>
                      </td>
                      <td class="tbl-title">주소</td>
                      <td class="tbl-cell">
                        <input name="workplace_address" id="workplace_address" class="input-common" value="<?php echo $view_val['workplace_address']; ?>" <?php if($tech_lv < 1){echo "readonly" ;} ?>>
                      </td>
                    </tr>
                    <tr id="err_row3">
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>
                    <tr id="err_row4" class="tbl-tr">
                      <td class="tbl-title">담당자</td>
                      <td class="tbl-cell">
                        <input name="workplace_manager" id="workplace_manager" class="input-common" value="<?php echo $view_val['workplace_manager']; ?>" <?php if($tech_lv < 1){echo "readonly" ;} ?>>
                      </td>
                      <td class="tbl-title">연락처</td>
                      <td class="tbl-cell">
                        <input name="workplace_tel" id="workplace_tel" class="input-common" value="<?php echo $view_val['workplace_tel']; ?>" <?php if($tech_lv < 1){echo "readonly" ;} ?>>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>
                    <tr class="tbl-tr">
                      <td class="tbl-title">신규 장비</td>
                      <td class="tbl-cell">
                        <?php if($tech_lv > 0){ ?>
                        <select name="produce" id="produce" class="select-common">
                          <option value="Neobox X1" <?php if($view_val['produce']=='Neobox X1'){echo "selected";} ?>>Neobox X1</option>
                          <option value="Neobox m204w" <?php if($view_val['produce']=='Neobox m204w'){echo "selected";} ?>>Neobox m204w</option>
                          <option value="Neobox M106w" <?php if($view_val['produce']=='Neobox M106w'){echo "selected";} ?>>Neobox M106w</option>
                          <option value="VForceUTM 406" <?php if($view_val['produce']=='VForceUTM 406'){echo "selected";} ?>>VForceUTM 406</option>
                          <option value="Neobox X2" <?php if($view_val['produce']=='Neobox X2'){echo "selected";} ?>>Neobox X2</option>
                        </select>
                        <?php }else{ echo "<input name='produce' id='produce' class='input2' value='{$view_val['produce']}' readonly>" ;} ?>
                      </td>
                      <td class="tbl-title">serial</td>
                      <td class="tbl-cell"><input type="text" name="serial" id="serial" class="input-common" value="<?php echo $view_val['serial']; ?>" <?php if($tech_lv < 1){echo "readonly" ;} ?>></td>
                    </tr>
                    <tr id='manager_input_field'>
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>
                    <tr class="tbl-tr">
                      <td class="tbl-title">버전</td>
                      <td class="tbl-cell"><input type="text" name="version" id="version" class="input-common" value="<?php echo $view_val['version']; ?>" <?php if($tech_lv < 1){echo "readonly" ;} ?>/></td>
                      <td class="tbl-title">host</td>
                      <td class="tbl-cell"><input type="text" name="host" id="host" class="input-common" value="<?php echo $view_val['host']; ?>" <?php if($tech_lv < 1){echo "readonly" ;} ?> /></td>
                    </tr>
                    <tr>
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>
                    <tr class="tbl-tr">
                      <td class="tbl-title">내부 IP</td>
                      <td class="tbl-cell">
                        <?php if(strpos($view_val['internal_ip'],'|') !== false){//포함
                            $internal_ip = explode('|',$view_val['internal_ip']);
                            echo "<input type='hidden' name='internal_ip' id='internal_ip' value='{$view_val['internal_ip']}'><input type='text' name='internal_ip1' id='internal_ip1' class='input-common' value='{$internal_ip[0]}'";
                            if($tech_lv < 1){echo "readonly" ;}
                            echo "><input type='text' name='internal_ip2' id='internal_ip2' class='input-common' value='{$internal_ip[1]}'";
                            if($tech_lv < 1){echo "readonly" ;}
                            echo ">";
                        }else{//미포함
                            echo '<input type="text" name="internal_ip" id="internal_ip" class="input-common" value="'.$view_val['internal_ip'].'"';
                            if($tech_lv < 1){echo "readonly" ;}
                            echo '/>';
                        }
                        ?>
                      </td>
                      <td class="tbl-title">외부 고정 IP</td>
                      <td class="tbl-cell"><input type="text" name=
                      "external_ip" id="external_ip" class="input-common" value="<?php echo $view_val['external_ip']; ?>" <?php if($tech_lv < 1){echo "readonly" ;} ?>></td>
                    </tr>
                    <tr>
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>
                    <tr id='manager_input_field' class="tbl-tr">
                      <td class="tbl-title">설치 요청일
                        <img onClick="document_add();" width="15" src="<?php echo $misc;?>img/btn_add.jpg" id="doc_add" name="doc_add" style="cursor:pointer;" />
                      </td>
                      <td class="tbl-cell">
                        <input type="date" name="installation_request_date" id="installation_request_date" class="input-common" value="<?php echo substr($view_val['installation_request_date'], 0, 10); ?>" <?php if($tech_lv < 1){echo "readonly" ;} ?>/>
                      </td>
                      <td class="tbl-title">접수 일자</td>
                      <td class="tbl-cell">
                        <input type="date" name="reception_date" id="reception_date" class="input-common" value="<?php echo substr($view_val['reception_date'], 0, 10); ?>"<?php if($tech_lv < 1){echo "readonly" ;} ?>/>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>
                    <?php
                    for ($i=0; $i<$visit_count; $i++) {
                    ?>
                    <tr id='manager_input_field'>
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>
                    <tr>
                      <td class="tbl-title">방문일자
                        <img onClick="document_del(this);" width="15" src="<?php echo $misc; ?>img/btn_del0.jpg" id="doc_del" name="doc_del" style="cursor:pointer" />
                      </td>
                      <td class="tbl-cell">
                        <input type="date" name="visit_date_input" class="input-common" value="<?php echo $visit_date[$i]; ?>">
                      </td>
                      <td class="tbl-title">비고</td>
                      <td class="tbl-cell">
                        <input type="text" name="visit_remark_input" class="input-common" value="<?php echo $visit_remark[$i]; ?>">
                      </td>
                    </tr>
                    <?php
                    }
                     ?>
                    <tr id='setup_date'>
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>
                    <tr class="tbl-tr">
                      <td class="tbl-title">설치 일자</td>
                      <td class="tbl-cell">
                        <input type="date" name="installation_date" id="installation_date" class="input-common" value="<?php echo substr($view_val['installation_date'], 0, 10); ?>" <?php if(!empty($cooperativeid) && (strpos($view_val['engineer_email'],$cooperativeid) === false) && ($tech_lv < 1)){echo "readonly";} ?>/>
                      </td>
                      <td class="tbl-title">장비 배송일</td>
                      <td class="tbl-cell">
                        <input type="date" name="delivery_date" id="delivery_date" class="input-common" value="<?php echo substr($view_val['delivery_date'], 0, 10); ?>"<?php if($tech_lv < 1){echo "readonly" ;} ?> />
                      </td>
                    </tr>
                    <tr>
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>

                    <tr class="tbl-tr old" <?php if($view_val['support_type']!="장애지원"){echo 'style="display:none"'; } ?>>
                      <td class="tbl-title">기존 장비/serial</td>
                      <td class="tbl-cell">
                      <?php if(!empty($cooperativeid) && (strpos($view_val['engineer_email'],$cooperativeid) === false) && ($tech_lv < 1)){ ?>
                        <input name='old_produce' id='old_produce' class='input-common' value='<?php echo $view_val['old_produce']; ?>' readonly>
                      <?php }else{ ?>
                        <select name="old_produce" id="old_produce" class="select-common">
                            <option value="" <?php if($view_val['old_produce']==''){echo "selected";} ?>>기존장비선택</option>
                            <option value="Neobox X1" <?php if($view_val['old_produce']=='Neobox X1'){echo "selected";} ?>>Neobox X1</option>
                            <option value="Neobox m204w" <?php if($view_val['old_produce']=='Neobox m204w'){echo "selected";} ?>>Neobox m204w</option>
                            <option value="Neobox M106w" <?php if($view_val['old_produce']=='Neobox M106w'){echo "selected";} ?>>Neobox M106w</option>
                            <option value="VForceUTM 406" <?php if($view_val['old_produce']=='VForceUTM 406'){echo "selected";} ?>>VForceUTM 406</option>
                            <option value="Neobox X2" <?php if($view_val['old_produce']=='Neobox X2'){echo "selected";} ?>>Neobox X2</option>
                        </select>
                      <?php } ?>
                        <input type="text" name="old_serial" id="old_serial" class="input-common" value="<?php echo $view_val['old_serial']; ?>" <?php if(!empty($cooperativeid) && (strpos($view_val['engineer_email'],$cooperativeid) === false) && ($tech_lv < 1)){echo "readonly";} ?>>
                      </td>
                      <td class="tbl-title">장비회수완료</td>
                      <td class="tbl-cell">
                      <?php if(!empty($cooperativeid) && (strpos($view_val['engineer_email'],$cooperativeid) === false) && ($tech_lv < 1)){?>
                        <input type="hidden" id="recovery_status" name="recovery_status" value="<?php echo $view_val['recovery_status']; ?>" />
                        <?php if($view_val['recovery_status'] == "Y"){echo "완료";}else{ echo "미완료"; } ?>
                      <?php }else{ ?>
                        <input type="checkbox" id="recovery_status" name="recovery_status" value="Y" <?php if($view_val['recovery_status'] == "Y"){echo "checked";}?>/>
                      <?php } ?>
                      </td>
                    </tr>
                    <tr class="old" <?php if($view_val['support_type']!="장애지원"){echo 'style="display:none"'; } ?>>
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>

                    <tr id="old_produce_insert" class="tbl-tr">
                      <td class="tbl-title">기타 특이사항</td>
                      <td class="tbl-cell" colspan="3" style="padding:10px 0 10px 10px;">
                        <textarea type="text" name="etc" id="etc" class="textarea-common" style="height:100px;width:100%" <?php if($tech_lv < 1){echo "readonly" ;} ?>><?php echo $view_val['etc']; ?></textarea>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>
                    <tr class="tbl-tr">
                      <td class="tbl-title">진행단계</td>
                      <td class="tbl-cell"><input type="hidden" name="result" id="result" value="<?php echo $view_val['result']; ?>"/>
                      <?php echo $view_val['result']; ?></td>
                      <td class="tbl-title">최종승인</td>
                      <td class="tbl-cell">
                        <?php if($tech_lv > 0){ ?>
                        <select class="select-common" name="final_approval" id="final_approval">
                          <option value="N" <?php if($view_val['final_approval']=='N'){echo "selected";} ?>>미승인</option>
                          <option value="Y" <?php if($view_val['final_approval']=='Y'){echo "selected";} ?>>승인</option>
                        </select>
                        <?php }else{ ?>
                          <input type="hidden" class="input-common" name="final_approval" id="final_approval" value = "<?php echo $view_val['final_approval']; ?>" >
                          <?php if($view_val['final_approval']=='N'){echo "미승인";}else{ echo "승인"; } ?>
                        <?php } ?>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>
                    <tr class="tbl-tr">
                      <td class="tbl-title">첨부파일</td>
                      <td class="tbl-cell">
                        <?php if ($view_val['file_change_name']){ ?>
                            <a href="<?php echo site_url(); ?>/tech/tech_board/request_tech_support_download/<?php echo $seq; ?>/<?php echo $view_val['file_change_name']; ?>"><?php echo $view_val['file_real_name']; ?></a>
                            <a href="javascript:filedel('<?php echo $seq; ?>','<?php echo $view_val['file_change_name']; ?>');"><img src="<?php echo $misc; ?>img/del.png" width="8" height="8" /></a>&nbsp;&nbsp;
                            <input name="cfile" id="cfile" type="file" size="" disabled>
                        <?php } else { ?>
                            <input name="cfile" id="cfile" type="file" size=""><span class="point0 txt_s">(용량제한 100MB)
                        <?php } ?>
                      </td>
                      <td class="tbl-title">tax</td>
                      <td class="tbl-cell"><input type="text" class="input-common" name="tax" id="tax" value="<?php echo $view_val['tax']; ?>"/></td>
                    </tr>
                    <tr>
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>

                  </table>
                </form>
              </td>
            </tr>
					</table>
				</td>
			</tr>
			<tr>
				<td height="50"></td>
			</tr>
      <tr>
				<td align="right" style="padding-right:15%;">
					<input type="button" class="btn-common btn-color4" value="수정" onClick="javascript:chkForm();return false;">
					<input type="button" class="btn-common btn-color4" value="취소" onClick="javascript:history.go(-1)">
				</td>
			</tr>
      <tr>
				<td height="50"></td>
			</tr>

		</table>
	</div>
</div>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
</body>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.min.js"></script>
<script>
    // 엔지니어 selecet box 띄우기
    if($("#cooperative_company_seq").val() != ''){
        var seq = $("#cooperative_company_seq").val();
        $.ajax({
        type: "POST",
        cache: false,
        url: "<?php echo site_url(); ?>/ajax/cooperative_company",
        dataType: "json",
        async: false,
        data: {
            seq: seq
        },
        success: function (data) {
            var text = "<option value=''>엔지니어 선택</option>";
            for (i = 0; i < data.length; i++) {
                if (data[i].user_work == "기술") {
                    text += '<option value="' + data[i].seq + '">' + data[i].user_name +'('+data[i].user_branch+'지사)'+ '</option>';
                }
                $("#engineer_seq").html(text);
            }
        }
    });
    if("<?php echo $view_val['engineer_name']?>" != ""){
      $("#engineer_seq option").filter(function(){return this.text.indexOf("<?php echo $view_val['engineer_name']?>") != -1 ;}).attr('selected', true);
    }

    }
    // 엔지니어 selecet box 띄우기 끝

    function cooperative_change() {
        var seq = $("#cooperative_company_seq").val();
        $.ajax({
            type: "POST",
            cache: false,
            url: "<?php echo site_url(); ?>/ajax/cooperative_company",
            dataType: "json",
            async: false,
            data: {
                seq: seq
            },
            success: function (data) {
                $("#cooperative_manager").val('');
                $("#cooperative_tel").val('');
                $("#cooperative_email").val('');
                var text = "<option value=''>엔지니어 선택</option>";
                for(i=0; i<data.length; i++){
                    if(data[i].manager == "Y"){
                        $("#cooperative_manager").val($("#cooperative_manager").val() + data[i].user_name +',');
                        $("#cooperative_tel").val($("#cooperative_tel").val()+data[i].user_tel+',');
                        $("#cooperative_email").val($("#cooperative_email").val()+data[i].user_email+',');
                    }

                    if(data[i].user_work == "기술"){
                        text += '<option value="'+data[i].seq+'">'+data[i].user_name + '(' + data[i].user_branch + '지사)' + '</option>';
                    }

                    $("#engineer_seq").html(text);

                }
                $("#cooperative_manager").val($("#cooperative_manager").val().slice(0,-1));
                $("#cooperative_tel").val($("#cooperative_tel").val().slice(0,-1));
                $("#cooperative_email").val($("#cooperative_email").val().slice(0,-1));
                $("#cooperative_company").val($("#cooperative_company_seq option:selected").text());
            }
        });
    }

    function engineer_select() {
        var seq = $("#engineer_seq").val();
        if(seq != ''){
            $.ajax({
                type: "POST",
                cache: false,
                url: "<?php echo site_url(); ?>/ajax/cooperative_company_engineer",
                dataType: "json",
                async: false,
                data: {
                    seq: seq
                },
                success: function (data) {
                    $("#engineer_branch").val(data[0].user_branch);
                    $("#engineer_tel").val(data[0].user_tel);
                    $("#engineer_email").val(data[0].user_email);
                    $("#engineer_name").val(data[0].user_name);
                }
            });
        }
    }

    $("#sortation").change(function(){
      if($("#sortation").val() == "과금망(구내통신)"){
        var text = "<input type='hidden' name='internal_ip' id='internal_ip' value=''><input type='text' name='internal_ip1' id='internal_ip1' class='input2' value=''><input type='text' name='internal_ip2' id='internal_ip2' class='input2' value=''>"
        $("#internalIP").html(text);
      }else{
        var text = "<input type='text' class='input2' name='internal_ip' id='internal_ip' value=''>"
        $("#internalIP").html(text);
      }
    });

    function filedel(seq, filename) {
      if (confirm("정말 삭제하시겠습니까?") == true) {
        location.href = "<?php echo site_url(); ?>/tech/tech_board/request_tech_support_del/" + seq + "/" + filename;
        return false;
      }
    }

    function supportType(){
      if($("#support_type").val() == "장애지원"){
        $(".old").show();
      }else{
        $("#old_produce").val('');
        $("#old_serial").val('');
        $("input[name=recovery_status]").prop("checked", false);
        $(".old").hide();
      }
    }

    function document_add() {
      var text = "<tr id='manager_input_field'><td colspan='4' height='1' bgcolor='#F4F4F4'></td></tr>";
      text += "<tr><td class='tbl-title'>방문일자 ";
      text += "<img onClick='document_del(this);' width='15' src='<?php echo $misc;?>img/btn_del0.jpg' id='doc_del' name='doc_del' style='cursor:pointer' /></td>";
      text += "<td class='tbl-cell'><input type='date' name='visit_date_input' class='input-common' value=''></td>";
      text += "<td class='tbl-title'>비고</td>";
      text += "<td class='tbl-cell'><input type='text' name='visit_remark_input' class='input-common'></td></tr>";
      $('#setup_date').before(text);
    }

    function document_del(el) {
      var tr = $(el).closest('tr');
      tr.prev().remove();
      tr.remove();
    }

</script>

<?php
// 김수성 추가
$cnt = 0;
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";

$this->cooperative_id = $this->phpsession->get( 'cooperative_id', 'stc' );
if ($this->cooperative_id != '') {
  if(strpos($view_val['cooperative_email'],$this->cooperative_id) === false && strpos($view_val['engineer_email'],$this->cooperative_id) === false && !$id){
    echo '<script>alert("해당 글을 볼 수 있는 권한이 없습니다.");location.href="'.site_url().'/tech/tech_board/request_tech_support_list"</script>';
  }
}
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

    // if (mform.produce.value == "") {
    //   mform.produce.focus();
    //   alert("장비/시스템을 입력해주세요.");
    //   return false
    // }

    if($("#sortation").val() == "과금망(구내통신)"){
      $("#internal_ip").val($("#internal_ip1").val() + "|" + $("#internal_ip2").val());
    }

    if ($("#engineer_email").val() != '') {
      $('#result').val("접수완료");
    }

    if ($("#installation_date").val() != '' && $("#installation_date").val() != '0000-00-00') {
      $('#result').val("설치예정");
    }

    if($("#cfile").is(":disabled") || $("#cfile").val()){
      $('#result').val("승인요청");
    }

    if ($("#final_approval").val() == 'Y') {
      $('#result').val("지원완료");
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
					<input type="button" class="btn-common btn-color1" value="등록" onClick="javascript:chkForm();return false;">
					<input type="button" class="btn-common btn-color2" value="취소" onClick="javascript:history.go(-1)">
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
                        <input type="hidden" name="engineer_name" id ="engineer_name" value='' />
                        <input type="hidden" name="engineer_branch" id ="engineer_branch" value='' />
                        <input type="hidden" name="engineer_tel" id="engineer_tel" class="input2" value= '' />
                        <input type="hidden" name="engineer_email" id="engineer_email" class="input2" value="" />
                        <input type="hidden" name="manager_mail_send" id="manager_mail_send" class="input2" value="N" />
                        <input type="hidden" name="engineer_mail_send" id="engineer_mail_send" class="input2" value="N" />
                        <select class="select-common" name="sortation" id="sortation">
                            <option value="유통망(협력사)" selected>유통망(협력사)</option>
                            <option value="과금망(구내통신)">과금망(구내통신)</option>
                        </select>
                      </td>
                      <td class="tbl-title">지원유형</td>
                      <td class="tbl-cell">
                        <select class="select-common" name="support_type" id="support_type" onchange="supportType();">
                            <option value="신규설치" selected>신규설치</option>
                            <option value="이전설치">이전설치</option>
                            <option value="장애지원">장애지원</option>
                            <option value="기타">기타</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
      								<td colspan="4" height="1" bgcolor="#F4F4F4"></td>
      							</tr>
                    <tr class="tbl-tr">
                      <td class="tbl-title">고객사</td>
                      <td class="tbl-cell">
                        <input name="customer_company" id="customer_company" class="input-common" value="에스케이브로드밴드">
                      </td>
                      <td class="tbl-title">등록자</td>
                      <td class="tbl-cell">
                        <input type="hidden" id="writer" name="writer" value="<?php echo $name; ?>"><?php echo $name; ?>
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
                      <input type="hidden" name="durian_manager[]" value="<?php echo $de['seq'] ?>">
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
                        <input type="hidden" name="cooperative_company" id="cooperative_company" value='' />
                        <select class="select-common" name="cooperative_company_seq" id="cooperative_company_seq" onclick="cooperative_change();">
                            <option value="">협력사 선택</option>
                            <?php foreach($cooperative_company as $parter){
                                echo "<option value='{$parter['seq']}'>{$parter['company_name']}</option>";
                            }
                            ?>
                        </select>
                      </td>
                      <td class="tbl-title">담당자</td>
                      <td class="tbl-cell"><input name="cooperative_manager" id="cooperative_manager" class="input-common" value=""></td>
                    </tr>
                    <tr>
      								<td colspan="4" height="1" bgcolor="#F4F4F4"></td>
      							</tr>
                    <tr class="tbl-tr">
                      <td class="tbl-title">연락처</td>
                      <td class="tbl-cell">
                        <input name="cooperative_tel" id="cooperative_tel" class="input2" value="">
                      </td>
                      <td class="tbl-title">e-mail</td>
                      <td class="tbl-cell">
                        <input name="cooperative_email" id="cooperative_email" class="input2" value="">
                      </td>
                    </tr>
                    <tr>
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
                        <input name="workplace_name" id="workplace_name" class="input2" value="">
                      </td>
                      <td class="tbl-title">주소</td>
                      <td class="tbl-cell">
                        <input name="workplace_address" id="workplace_address" class="input2" value="">
                      </td>
                    </tr>
                    <tr id="err_row3">
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>
                    <tr id="err_row4" class="tbl-tr">
                      <td class="tbl-title">담당자</td>
                      <td class="tbl-cell">
                        <input name="workplace_manager" id="workplace_manager" class="input2" value="">
                      </td>
                      <td class="tbl-title">연락처</td>
                      <td class="tbl-cell">
                        <input name="workplace_tel" id="workplace_tel" class="input2" value="">
                      </td>
                    </tr>
                    <tr>
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>
                    <tr class="tbl-tr">
                      <td class="tbl-title">신규 장비</td>
                      <td class="tbl-cell">
                        <select name="produce" id="produce" class="input2">
                            <option value="Neobox X1">Neobox X1</option>
                            <option value="Neobox m204w">Neobox m204w</option>
                            <option value="Neobox M106w">Neobox M106w</option>
                            <option value="VForceUTM 406">VForceUTM 406</option>
                            <option value="Neobox X2">Neobox X2</option>
                        </select>
                      </td>
                      <td class="tbl-title">serial</td>
                      <td class="tbl-cell"><input type="text" name="serial" id="serial" class="input-common"></td>
                    </tr>
                    <tr>
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>
                    <tr class="tbl-tr">
                      <td class="tbl-title">버전</td>
                      <td class="tbl-cell"><input type="text" name="version" id="version" class="input-common" /></td>
                      <td class="tbl-title">host</td>
                      <td class="tbl-cell"><input type="text" name="host" id="host" class="input2" /></td>
                    </tr>
                    <tr>
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>
                    <tr class="tbl-tr">
                      <td class="tbl-title">내부 IP</td>
                      <td class="tbl-cell">
                        <input type="text" name="internal_ip" id="internal_ip" class="input-common" />
                      </td>
                      <td class="tbl-title">외부 고정 IP</td>
                      <td class="tbl-cell"><input type="text" name="external_ip" id="external_ip" class="input-common"></td>
                    </tr>
                    <tr>
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>
                    <tr id='manager_input_field' class="tbl-tr">
                      <td class="tbl-title">설치 요청일</td>
                      <td class="tbl-cell"><input type="date" name="installation_request_date" id="installation_request_date" class="input-common" /></td>
                      <td class="tbl-title">접수 일자</td>
                      <td class="tbl-cell"><input type="date" name="reception_date" id="reception_date" class="input-common"></td>
                    </tr>
                    <tr>
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>
                    <tr class="tbl-tr">
                      <td class="tbl-title">설치 일자</td>
                      <td class="tbl-cell"><input type="date" name="installation_date" id="installation_date" class="input-common" /></td>
                      <td class="tbl-title">장비 배송일</td>
                      <td class="tbl-cell"><input type="date" name="delivery_date" id="delivery_date" class="input-common"></td>
                    </tr>
                    <tr>
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>
                    <tr id="old_produce_insert" class="tbl-tr">
                      <td class="tbl-title">기타 특이사항</td>
                      <td class="tbl-cell" colspan="3" style="padding:10px 0 10px 10px;"><textarea type="text" name="etc" id="etc" class="textarea-common" style="height:100px;width:90%"></textarea></td>
                    </tr>
                    <tr>
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>
                    <tr class="tbl-tr">
                      <td class="tbl-title">진행단계</td>
                      <td class="tbl-cell"><input type="hidden" name="result" id="result" value="지원대기" />
                      지원대기</td>
                      <td class="tbl-title">최종승인</td>
                      <td class="tbl-cell">
                        <select class="select-common" name="final_approval" id="final_approval">
                          <option value="N" selected>미승인</option>
                          <option value="Y">승인</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="4" height="1" bgcolor="#F4F4F4"></td>
                    </tr>
                    <tr class="tbl-tr">
                      <td class="tbl-title">첨부파일</td>
                      <td class="tbl-cell">
                        <input type="file" name="cfile" id="cfile" />
                          (용량제한 100MB)</td>
                      </td>
                      <td class="tbl-title">tax</td>
                      <td class="tbl-cell"><input type="text" id="tax" name="tax" class="input-common" /></td>
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
					<input type="button" class="btn-common btn-color1" value="등록" onClick="javascript:chkForm();return false;">
					<input type="button" class="btn-common btn-color2" value="취소" onClick="javascript:history.go(-1)">
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
              console.log(data);
                $("#cooperative_manager").val('');
                $("#cooperative_tel").val('');
                $("#cooperative_email").val('');
                // $("#engineer_name").html('');
                for(i=0; i<data.length; i++){
                    // var text;
                    if(data[i].manager == "Y"){
                        $("#cooperative_manager").val($("#cooperative_manager").val() + data[i].user_name +',');
                        $("#cooperative_tel").val($("#cooperative_tel").val()+data[i].user_tel+',');
                        $("#cooperative_email").val($("#cooperative_email").val()+data[i].user_email+',');
                    }

                    // if(data[i].user_work == "기술"){
                    //     text += '<option value="'+data[i].seq+'">'+data[i].user_name+'</option>';
                    // }

                    // $("#engineer_name").html(text);

                }
                $("#cooperative_manager").val($("#cooperative_manager").val().slice(0,-1));
                $("#cooperative_tel").val($("#cooperative_tel").val().slice(0,-1));
                $("#cooperative_email").val($("#cooperative_email").val().slice(0,-1));
                $("#cooperative_company").val($("#cooperative_company_seq option:selected").text());
            }
        });
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


</script>
</html>

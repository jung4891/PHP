<?php
// 김수성 추가
$cnt = 0;
include $this->input->server('DOCUMENT_ROOT') . "/include/base.php";
include $this->input->server('DOCUMENT_ROOT') . "/include/customer_top.php";
?>
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
  <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <?php
    include $this->input->server('DOCUMENT_ROOT')."/include/tech_header.php";
  ?>
    <tr>
      <td align="center" valign="top">
        <table width="1130" height="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td><img src="<?php echo $misc; ?>img/btn_left.jpg" id="leftBtn" style="cursor:pointer;display:none;float:right;" onclick="changePage('left')"/></td>
            <td width="923" align="center" valign="top">
              <form name="cform" action="<?php echo site_url(); ?>/tech_board/request_tech_support_input_action" method="post" enctype="multipart/form-data" onSubmit="javascript:chkForm();return false;">
                <table width="890" border="0" style="margin-top:20px;">
                  <tr>
                    <td class="title3">기술지원요청 등록</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>
                      <table id="input_table" width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td colspan="5" height="2" bgcolor="#797c88"></td>
                        </tr>
                        <tr>
                        <tr name="test_c" id="test_c">
                          <td colspan="2" size="100" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">구분</td>
                          <td style="padding-left:10px;" class="t_border">
                            <input type="hidden" name="engineer_name" id ="engineer_name" value='' />
                            <input type="hidden" name="engineer_branch" id ="engineer_branch" value='' />
                            <input type="hidden" name="engineer_tel" id="engineer_tel" class="input2" value= '' />
                            <input type="hidden" name="engineer_email" id="engineer_email" class="input2" value="" />
                            <input type="hidden" name="manager_mail_send" id="manager_mail_send" class="input2" value="N" />
                            <input type="hidden" name="engineer_mail_send" id="engineer_mail_send" class="input2" value="N" />
                            <select class="input2" name="sortation" id="sortation">
                                <option value="유통망(협력사)" selected>유통망(협력사)</option>
                                <option value="과금망(구내통신)">과금망(구내통신)</option>
                            </select>
                          </td>
                          <td size="100" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">지원유형</td>
                          <td style="padding-left:10px;" class="t_border">
                            <select class="input2" name="support_type" id="support_type" onchange="supportType();">
                                <option value="신규설치" selected>신규설치</option>
                                <option value="이전설치">이전설치</option>
                                <option value="장애지원">장애지원</option>
                                <option value="기타">기타</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                          <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">고객사</td>
                          <td width="35%" style="padding-left:10px;" class="t_border">
                            <input name="customer_company" id="customer_company" class="input2" value="SK브로드밴드">
                          </td>
                          <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">등록자</td>
                          <td width="35%" align="center" class="t_border"><input type="hidden" id="writer" name="writer" value="<?php echo $name; ?>"><?php echo $name; ?></td>
                        </tr>
                        <tr>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                            <td height=35 align="center" style="font-weight:bold;">* 기술 담당자</td>
                        </tr>
                        <tr>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                          <td colspan="2" rowspan="3" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">담당자</td>
                          <td rowspan="3" width="35%" align="center" style="padding-left:10px;" class="t_border">김갑진</td>
                          <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">연락처</td>
                          <td width="35%" align="center" style="padding-left:10px;" class="t_border">01024354987</td>  
                        </tr>
                        <tr>
                          <td colspan="3" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                          <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">e-mail</td>
                          <td width="35%" align="center" style="padding-left:10px;" class="t_border">kkj@durianit.co.kr</td>  
                        </tr>
                        <tr>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                          <td colspan="2" rowspan="3" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">담당자</td>
                          <td rowspan="3" width="35%" align="center" style="padding-left:10px;" class="t_border">박유석</td>
                          <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">연락처</td>
                          <td width="35%" align="center" style="padding-left:10px;" class="t_border">01029133223</td>
                        </tr>
                        <tr>
                          <td colspan="3" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                          <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">e-mail</td>
                          <td width="35%" align="center" style="padding-left:10px;" class="t_border">yspark@durianit.co.kr</td>  
                        </tr>
                        <tr>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                            <td height=35 align="center" style="font-weight:bold;">* 협력사 정보</td>
                        </tr>
                        <tr>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                          <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">협력사</td>
                          <td width="35%" style="padding-left:10px;" class="t_border">
                            <input type="hidden" name="cooperative_company" id="cooperative_company" value='' />
                            <select class="input2" name="cooperative_company_seq" id="cooperative_company_seq" onclick="cooperative_change();">
                                <option value="">협력사 선택</option>
                                <?php foreach($cooperative_company as $parter){
                                    echo "<option value='{$parter['seq']}'>{$parter['company_name']}</option>";
                                }
                                ?>
                            </select>
                          </td>
                          <td  width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">담당자</td>
                          <td width="35%" style="padding-left:10px;" class="t_border">
                            <input name="cooperative_manager" id="cooperative_manager" class="input2" value="">
                          </td>  
                        </tr>
                        <tr>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                          <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">연락처</td>
                          <td width="35%" style="padding-left:10px;" class="t_border">
                            <input name="cooperative_tel" id="cooperative_tel" class="input2" value="">
                          </td>
                          <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">e-mail</td>
                          <td width="35%" style="padding-left:10px;" class="t_border">
                            <input name="cooperative_email" id="cooperative_email" class="input2" value="">
                          </td>
                        </tr>
                        <tr>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <!-- <tr>
                            <td height=35 align="center" style="font-weight:bold;">* 엔지니어 정보</td>
                        </tr>
                        <tr>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                          <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">엔지니어</td>
                          <td width="35%" style="padding-left:10px;" class="t_border">
                            <select class="input2" name="engineer_name" id ="engineer_name" onclick="engineer_select();"></select>
                          </td>
                          <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">지사</td>
                          <td width="35%" style="padding-left:10px;" class="t_border">
                            <input type="text" class="input2" name="engineer_branch" id ="engineer_branch" />
                          </td>
                        </tr>
                        <tr>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                          <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">연락처</td>
                          <td width="35%" style="padding-left:10px;" class="t_border">
                            <input name="engineer_tel" id="engineer_tel" class="input2" value="">
                          </td>
                          <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">e-mail</td>
                          <td width="35%" style="padding-left:10px;" class="t_border">
                            <input name="engineer_email" id="engineer_email" class="input2" value="">
                        </td>
                        </tr>
                        <tr id="err_row1">
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr> -->
                        <tr>
                            <td height=35 align="center" style="font-weight:bold;">* 사업장 정보</td>
                        </tr>
                        <tr>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr id="err_row2">
                          <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">사업장명</td>
                          <td width="35%" style="padding-left:10px;" class="t_border">
                            <input name="workplace_name" id="workplace_name" class="input2" value="">
                          </td>
                          <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">주소</td>
                          <td width="35%" style="padding-left:10px;" class="t_border">
                            <input name="workplace_address" id="workplace_address" class="input2" value="">
                          </td>
                        </tr>
                        <tr id="err_row3">
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr id="err_row4">
                          <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">담당자</td>
                          <td width="35%" style="padding-left:10px;" class="t_border">
                            <input name="workplace_manager" id="workplace_manager" class="input2" value="">
                          </td>
                          <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">연락처</td>
                          <td width="35%" style="padding-left:10px;" class="t_border">
                            <input name="workplace_tel" id="workplace_tel" class="input2" value="">
                          </td>
                        </tr>

                        <tr>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                          <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">신규 장비</td>
                          <td width="35%" style="padding:10px;" class="t_border">
                            <select name="produce" id="produce" class="input2">
                                <option value="Neobox X1">Neobox X1</option>
                                <option value="Neobox m204w">Neobox m204w</option>
                                <option value="Neobox M106w">Neobox M106w</option>
                                <option value="VForceUTM 406">VForceUTM 406</option>
                                <option value="Neobox X2">Neobox X2</option>
                            </select>
                          </td>
                          <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">serial</td>
                          <td width="35%" style="padding:10px;" class="t_border"><input type="text" name="serial" id="serial" class="input2"></td>
                        </tr>
                        <tr>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                          <td colspan="2" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">버전</td>
                          <td style="padding-left:10px;" class="t_border"><input type="text" name="version" id="version" class="input2" /></td>
                          <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">host</td>
                          <td style="padding-left:10px;" class="t_border"><input type="text" name="host" id="host" class="input2" /></td>
                        </tr>
                        <tr>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                          <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">내부 IP</td>
                          <td width="35%" style="padding:10px;" class="t_border" id="internalIP"><input type="text" name="internal_ip" id="internal_ip" class="input2" /></td>
                          <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">외부 고정 IP</td>
                          <td width="35%" style="padding:10px;" class="t_border"><input type="text" name="external_ip" id="external_ip" class="input2"></td>
                        </tr>
                        <tr id='manager_input_field'>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                          <td colspan="2" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">설치 요청일</td>
                          <td style="padding-left:10px;" class="t_border"><input type="date" name="installation_request_date" id="installation_request_date" class="input2" /></td>
                          <td align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">접수 일자</td>
                          <td style="padding:10px;" class="t_border"><input type="date" name="reception_date" id="reception_date" class="input2"></td>
                        </tr>
                        <tr id='manager_input_field'>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                          <td colspan="2" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">설치 일자</td>
                          <td style="padding-left:10px;" class="t_border"><input type="date" name="installation_date" id="installation_date" class="input2" /></td>
                          <td align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">장비 배송일</td>
                          <td style="padding:10px;" class="t_border"><input type="date" name="delivery_date" id="delivery_date" class="input2"></td>
                        </tr>
                        <tr>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <!-- <tr class="old" style="display:none">
                          <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">기존 장비/serial</td>
                          <td width="35%" style="padding:10px;" class="t_border">
                            <select name="old_produce" id="old_produce" class="input7">
                              <option value="">기존장비선택</option>
                              <option value="Neobox X1">Neobox X1</option>
                              <option value="Neobox m204w">Neobox m204w</option>
                              <option value="Neobox M106w">Neobox M106w</option>
                              <option value="VForceUTM 406">VForceUTM 406</option>
                              <option value="Neobox X2">Neobox X2</option>
                            </select>
                            <input type="text" name="old_serial" id="old_serial" class="input7">
                          </td>
                          <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">장비회수완료</td>
                          <td width="35%" style="padding:10px;" class="t_border">
                            <input type="checkbox" id="recovery_status" name="recovery_status" value="Y" />
                          </td>
                        </tr> -->
                        <!-- <tr class="old" style="display:none">
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr> -->
                        <tr id="old_produce_insert">
                          <td colspan="2" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">기타 특이사항</td>
                          <td colspan="3" style="padding-left:10px;" class="t_border">
                            <textarea type="text" name="etc" id="etc" class="input2" style="height:100px;width:100%"></textarea>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                          <td colspan="2" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">진행단계</td>
                          <td style="padding-left:10px;word-break:break-all;" class="t_border">
                            <input type="hidden" name="result" id="result" value="지원대기" />
                            지원대기
                          </td>
                          <td align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">최종승인</td>
                          <td style="padding-left:10px;" class="t_border">
                            <select class="input2" name="final_approval" id="final_approval">
                                    <option value="N" selected>미승인</option>
                                    <option value="Y">승인</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                          <td colspan="2" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">첨부파일</td>
                          <td style="padding-left:10px;word-break:break-all;" class="t_border">
                          <input type="file" name="cfile" id="cfile" />
                            (용량제한 100MB)</td>
                          <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">tax</td>
                          <td class="t_border" style="padding-left:10px;" colspan="3" class="t_border">
                            <input type="text" id="tax" name="tax" class="input2" />
                            <!-- <select class="input2" name="tax" id="tax">
                                    <option value="N" selected>미발행</option>
                                    <option value="Y">발행</option>
                            </select> -->
                          </td>
                        </tr>
                        <tr>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                          <td colspan="5" height="2" bgcolor="#797c88"></td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="right">
                      <!--지원내용 추가 버튼-->
                      <!--<img src="<?php echo $misc; ?>img/btn_add_column3.jpg" width="64" height="31" style="cursor:pointer" onclick="merge_email();return false;"/>-->
                      <!-- <img src="<?php echo $misc; ?>img/btn_add_column3.jpg" id="addRowBtn" width="64" height="31" style="cursor:pointer" onclick="addRow();return false;" />
                      <img src="<?php echo $misc; ?>img/btn_add_column4.jpg" id="deleteRowBtn" width="64" height="31" style="cursor:pointer" onclick="deleteRow('input_table');return false;" /> -->

                      <input type="image" src="<?php echo $misc; ?>img/btn_ok.jpg" width="64" height="31" style="cursor:pointer" onClick="javascript:chkForm();return false;" />
                      <img src="<?php echo $misc; ?>img/btn_cancel.jpg" width="64" height="31" style="cursor:pointer" onClick="javascript:history.go(-1)" />
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                </table>
            </td>
            <td><img src="<?php echo $misc; ?>img/btn_right.jpg" id="rightBtn" onclick="changePage('right');" style="cursor:pointer;display:none"/></td>
          </tr>
        </table>
      </td>
    </tr>
    </form>

    <!-- 폼 끝 -->

    <tr>
      <td align="center" height="100" bgcolor="#CCCCCC">
        <table width="1130" cellspacing="0" cellpadding="0">
          <tr>
            <td width="197" height="100" align="center" background="<?php echo $misc; ?>img/customer_f_bg.png"><img src="<?php echo $misc; ?>img/f_ci.png" /></td>
            <td><?php include $this->input->server('DOCUMENT_ROOT') . "/include/customer_bottom.php"; ?></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>

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
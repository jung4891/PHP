<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";

	// print_r($forcasting_list);
?>
<style type="text/css">

</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/js/select2.min.js"></script>
<script language="javascript">

var chkForm = function () {
	var mform = document.cform;

	if (mform.forcasting_seq.value == "") {
		mform.forcasting_seq.focus();
		alert("포캐스팅을 선택해 주세요.");
		return false;
	}
	if (mform.project_name.value == "") {
		mform.project_name.focus();
		alert("프로젝트명을 입력해주세요");
		return false;
	}
	if (mform.progress_step.value == 0) {
		mform.progress_step.focus();
		alert("진척단계를 선택해 주세요.");
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
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
<form name="cform" action="<?php echo site_url();?>/sales/maintain/forcasting_duplication" method="post" onSubmit="javascript:chkForm();return false;">
<!-- <input type="hidden" id="main_array" name="main_array" />
<input type="hidden" id="product_array" name="product_array" />
<input type="hidden" id="row_max_index" name="row_max_index" value="0"/>
<input type="hidden" id="row_max_index2" name="row_max_index2" value="0"/> -->
  <tr>
    <td align="center" valign="top">
    <table width="1130" height="100%" cellspacing="0" cellpadding="0" >
        <tr>
            <td width="923" align="center" valign="top">
            <!--내용-->
            <table width="1100" border="0" style="margin-top:50px; margin-bottom: 50px">
              <!--타이틀-->
              <tr>
                <td class="title3">유지보수 생성</td>
              </tr>
              <!--//타이틀-->
              <tr>
                <td>&nbsp;</td>
              </tr>

              <!--작성-->
              <tr>
                <td><table width="100%" border="0" cellspacing="0" cellpadding="0" id="main_list">
                  <colgroup>
                    <col width="10%" />
                    <col width="13%" />
                    <col width="10%" />
                    <col width="12%" />
                    <col width="10%" />
                    <col width="15%" />
                    <col width="10%" />
                    <col width="10%" />
                    <col width="5%" />
                    <col width="5%" />
                  </colgroup>
                  <!--시작라인-->
                  <tr>
                    <td colspan="10" height="2" bgcolor="#797c88"></td>
                  </tr>
                  <!--//시작라인-->
                  <tr>
                    <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">포캐스팅</td>
                    <td align="left" class="t_border" style="padding-left:10px;">
						<!-- <input name="customer_companyname" type="text" class="input5" id="customer_companyname"/> -->
						<select id="forcasting_seq" name="forcasting_seq" class="input2" onchange="maintainDuplicate();" >
							<option value="">미선택</option>
							<?php 
								foreach($forcasting_list as $fl){
									echo "<option value='{$fl['seq']}' value2='{$fl['project_name']}'>{$fl['customer_companyname']}({$fl['project_name']})</option>";
								}
							?>
						</select>
						<input id="forcasting_view" class="basicBtn" type="button" value="포캐스팅 뷰" onclick="forcastingView();" style="margin-left:30px;"/> 
					</td>
                  </tr>
                  <tr>
                    <td colspan="10" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                    <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">프로젝트</td>
                    <td colspan="8" align="left" class="t_border" style="padding-left:10px;"><input name="project_name" type="text" class="input2" id="project_name"/></td>
                  </tr>
                  <tr>
                    <td colspan="10" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                    <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">진척단계</td>
                    <td colspan="8" align="left" class="t_border" style="padding-left:10px;"><select name="progress_step" id="progress_step" class="input5">
					  <option value="0">-진척단계-</option>
                      <option value="001">영업보류(0%)</option>
                      <option value="002">고객문의(5%)</option>
					  <option value="003">영업방문(10%)</option>
                      <option value="004">일반제안(15%)</option>
					  <option value="005">견적제출(20%)</option>
                      <option value="006">맞춤제안(30%)</option>
					  <option value="007">수정견적(35%)</option>
                      <option value="008">RFI(40%)</option>
					  <option value="009">RFP(45%)</option>
                      <option value="010">BMT(50%)</option>
					  <option value="011">DEMO(55%)</option>
					  <option value="012">가격경쟁(60%)</option>
					  <option value="013">Spec in(70%)</option>
					  <option value="014">수의계약(80%)</option>
					  <option value="015">수주완료(85%)</option>
					  <option value="016">매출발생(90%)</option>
					  <option value="017">미수잔금(95%)</option>
					  <option value="018">수금완료(100%)</option>
                    </select></td>
                  </tr>    
                  <!--마지막라인-->
                  <tr>
                    <td colspan="10" height="2" bgcolor="#797c88"></td>
                  </tr>
                  <!--//마지막라인-->
                </table></td>
              </tr>
              <!--//작성-->

              <tr>
                <td height="10"></td>
              </tr>
              <!--버튼-->
              <tr>
                <td align="right"><input type="image" src="<?php echo $misc;?>img/btn_ok.jpg" width="64" height="31" style="cursor:pointer" onclick="javascript:chkForm();return false;"/> <img src="<?php echo $misc;?>img/btn_cancel.jpg" width="64" height="31" style="cursor:pointer" onClick="javascript:history.go(-1)"/></td>
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
<!--하단-->
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
<!--//하단-->
<script>
	$("#forcasting_seq").select2();

	//포캐스팅 보러가기^0^
	function forcastingView(){
		var seq = $("#forcasting_seq").val();
		if(seq == ""){
			alert("포캐스팅을 선택해주세요.");
			$("#forcasting_seq").focus();
		}else{
			window.open("<?php echo site_url(); ?>/sales/forcasting/order_completed_view?seq="+seq,"","width = 1200, height = 500, scrollbars=1,resizable=yes");
		}
	}

	//유지보수 중복 여부
	function maintainDuplicate(){
		$("#project_name").val( $("#forcasting_seq option:selected").attr('value2'));
		var seq = $("#forcasting_seq").val();
		$.ajax({
			type: "POST",
			cache: false,
			url: "<?php echo site_url(); ?>/sales/maintain/maintainDuplicate",
			dataType: "json",
			async: false,
			data: {
				seq: seq
			},
			success: function (data) {
				if(data){
					if(confirm('해당 포캐스팅으로 유지보수가 존재합니다. 선택을 유지하시겠습니까?')){
					}else{
						$("#forcasting_seq").select2().val(val);
						$("#forcasting_seq").trigger('change');
					}
				}
			}
		});

	}
</script>
</body>
</html>

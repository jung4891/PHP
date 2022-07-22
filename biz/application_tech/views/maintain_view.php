<?php
include $this->input->server('DOCUMENT_ROOT') . "/include/base.php";
include $this->input->server('DOCUMENT_ROOT') . "/include/sales_top.php";
$sales_cnt=0;
$purchase_cnt=0;
if(!empty($bill_val)){
	foreach($bill_val as $bill){
		if($bill['type'] == "001"){
			$sales_cnt++;
		}else if($bill['type'] == "002"){
			$purchase_cnt++;
		}
	}
}
?>
<style type="text/css">
	.basic_td{
      border:1px solid;
      border-color:#d7d7d7;
      padding:0px 10px 0px 10px;
   }
   .basic_table{
      border-collapse:collapse;
      border:1px solid;
      border-color:#d7d7d7;
   }
</style>
<script language="javascript">
	function chkDel() {
		if (confirm("등록된 모든 코멘트들도 삭제됩니다. 정말 삭제하시겠습니까?") == true) {
			<?php
			if($complete_status_val){ 
			 	foreach($complete_status_val as $item){ ?>
					filedel('<?php echo $item['seq']; ?>','<?php echo $item['file_change_name']; ?>')
			<?php }} ?>
			var mform = document.cform;
			mform.action = "<?php echo site_url(); ?>/maintain/maintain_delete_action";
			mform.submit();
			return false;
		}
	}

	function chkForm2() {
		var rform = document.rform;
		var objproduct_maintain_begin = document.getElementsByName("maintain_begin");
		var objproduct_maintain_expire = document.getElementsByName("maintain_expire");

		if (rform.comment.value == "") {
			rform.comment.focus();
			alert("답변을 등록해 주세요.");
			return false;
		}

		rform.action = "<?php echo site_url(); ?>/maintain/maintain_comment_action";
		rform.submit();
		return false;
	}

	function chkForm3(seq) {
		if (confirm("정말 삭제하시겠습니까?") == true) {
			var rform = document.rform;
			rform.cseq.value = seq;
			rform.action = "<?php echo site_url(); ?>/maintain/maintain_comment_delete";
			rform.submit();
			return false;
		}
	}
</script>
<body>
	<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
	<?php
		include $this->input->server('DOCUMENT_ROOT')."/include/tech_header.php";
	?>
		<tr>
			<td align="center" valign="top">

				<table width="90%" height="100%" cellspacing="0" cellpadding="0">
					<tr>
						<td width="100%" align="center" valign="top">
							<table width="100%" border="0" style="margin-top:50px; margin-bottom: 50px;">
								<!--타이틀-->
								<tr>
									<td class="title3">유지보수</td>
								</tr>
								<!-- <tr>
									<td>
										<div style="margin-top:30px;float:right;">
											<input type="button" id="maintain_renew" class="basicBtn" value="갱신" onclick="renewal();" />
											<input type="button" id="integration_maintain" class="basicBtn" value="통합유지보수 관리" onclick="integration_maintain()" />
										</div>
									</td>
								</tr> -->
								<!--//타이틀-->
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td>
										<table width="100%" border="0" cellspacing="0" cellpadding="0" id="main_list">
											<form name="cform" action="<?php echo site_url(); ?>/maintain/maintain_input_action" method="post" onSubmit="javascript:chkForm();return false;">
												<input type="hidden" id="update_main_array" name="update_main_array" />
												<input type="hidden" id="delete_main_array" name="delete_main_array" />
												<input type="hidden" id="update_product_array" name="update_product_array" />
												<input type="hidden" id="update_sub_product_array" name="update_sub_product_array" />
												<input type="hidden" id="seq" name="seq" value="<?php echo $seq; ?>">
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
												<tr>
													<td height=15></td> 
												</tr>
												<tr>
                                                    <td style="font-weight:bold;font-size:13px;">
                                                        <!-- <span onclick="modifyPopup(1);" style="cursor:pointer"> -->
														    고객사 정보
														    <!-- <img src="<?php echo $misc; ?>img/pencil_btn.png" width="15" height="15" style="margin-left:5px;"/>		
														</span> -->
                                                    </td>
												</tr>
												<!--시작라인-->
												<tr>
													<td colspan="10" height="2" bgcolor="#797c88"></td>
												</tr>
												<!--//시작라인-->
												<tr>
													<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">고객사</td>
													<td align="left" class="t_border" style="padding-left:10px;"><?php echo $view_val['customer_companyname']; ?></td>
													<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">담당자</td>
													<td align="left" class="t_border" style="padding-left:10px;"><?php echo $view_val['customer_username']; ?></td>
													<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">연락처</td>
													<td align="left" class="t_border" style="padding-left:10px;"><?php echo $view_val['customer_tel']; ?></td>
													<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">이메일</td>
													<td colspan="2" align="left" class="t_border" style="padding-left:10px;"><?php echo $view_val['customer_email']; ?></td>
												</tr>
												<tr>
													<td colspan="10" height="1" bgcolor="#e8e8e8"></td>
												</tr>
												<tr>
													<td height=30></td> 
													<!-- 빈칸 -->
												</tr>
												<tr>
                                                    <td style="font-weight:bold;font-size:13px;">
                                                        <!-- <span onclick="modifyPopup(2);" style="cursor:pointer"> -->
                                                            영업 정보
                                                            <!-- <img src="<?php echo $misc; ?>img/pencil_btn.png" width="15" height="15" style="margin-left:5px;"/>
                                                        </span> -->
                                                    </td>
												</tr>
												<tr>
													<td colspan="10" height="2" bgcolor="#797c88"></td>
												</tr>
												<tr>
													<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">프로젝트</td>
													<td colspan="3" align="left" class="t_border" style="padding-left:10px;"><?php echo $view_val['project_name']; ?></td>
													<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">연계프로젝트</td>
                                                    <td colspan=3 align="center" class="t_border" style="font-weight:bold;">
                                                        <?php if(count($sub_project_cancel)>0){?>
                                                            <select class="input7">
                                                                <?php
                                                                foreach ($sub_project_cancel as $val) {
                                                                    echo '<option value="' . $val['seq'] . '">'. $val['customer_companyname'].'-' . $val['project_name'] . '</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        <?php } ?>
													</td>
												</tr>
												<tr>
													<td colspan="10" height="1" bgcolor="#e8e8e8"></td>
												</tr>
												<tr>
													<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">진척단계</td>
                                                    <td align="left" class="t_border" style="padding-left:10px;">
                                                        <?php if ($view_val['progress_step'] == "001") {echo "영업보류(0%)";} 
                                                        else if ($view_val['progress_step'] == "002") {echo "고객문의(5%)";} 
                                                        else if ($view_val['progress_step'] == "003") {echo "영업방문(10%)";}
                                                        else if ($view_val['progress_step'] == "004") {echo "일반제안(15%)";}
                                                        else if ($view_val['progress_step'] == "005") {echo "견적제출(20%)";}
                                                        else if ($view_val['progress_step'] == "006") {echo "맞춤제안(30%)";} 
                                                        else if ($view_val['progress_step'] == "007") {echo "수정견적(35%)";} 
                                                        else if ($view_val['progress_step'] == "008") {echo "RFI(40%)";} 
                                                        else if ($view_val['progress_step'] == "009") {echo "RFP(45%)";} 
                                                        else if ($view_val['progress_step'] == "010") {echo "BMT(50%)";} 
                                                        else if ($view_val['progress_step'] == "011") {echo "DEMO(55%)";} 
                                                        else if ($view_val['progress_step'] == "012") {echo "가격경쟁(60%)";} 
                                                        else if ($view_val['progress_step'] == "013") {echo "Spen in(70%)";} 
                                                        else if ($view_val['progress_step'] == "014") {echo "수의계약(80%)";} 
                                                        else if ($view_val['progress_step'] == "015") {echo "수주완료(85%)";} 
                                                        else if ($view_val['progress_step'] == "016") {echo "매출발생(90%)";} 
                                                        else if ($view_val['progress_step'] == "017") {echo "미수잔금(95%)";} 
                                                        else if ($view_val['progress_step'] == "018") {echo "수금완료(100%)";} 
                                                        ?>
                                                    </td>
													<!-- <td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">판매종류</td>
													<td align="left" class="t_border" style="padding-left:10px;">
                                                        <?php if ($view_val['type'] == "1") {
                                                            echo "판매";
                                                        }else if ($view_val['type'] == "2") {
                                                            echo "용역";
                                                        }else if ($view_val['type'] == "0") {
                                                            echo "선택없음";
                                                        }else if ($view_val['type'] == "3") {
                                                            echo "유지보수";
                                                        }else if ($view_val['type'] == "4") {
                                                            echo "조달";
                                                        } 
                                                        ?>
                                                    </td> -->
													<?php if($view_val['type'] == "4"){ ?>
													<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">조달 판매금액(VAT포함)</td>
                                                    <td align="left" class="t_border" style="padding-left:10px;">
														<?php echo $view_val['procurement_sales_amount']; ?>
													</td>
													<?php }?>
												<!-- </tr>
												<tr>
													<td colspan="10" height="1" bgcolor="#e8e8e8"></td>
												</tr>
												<tr> -->
													<td height="40" align="center" class="t_border" bgcolor="f8f8f9" style="font-weight:bold;">영업업체</td>
													<td align="left" class="t_border" style="padding-left:10px;"><?php echo $view_val['cooperation_companyname']; ?></td>
													<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">영업담당자</td>
													<td align="left" class="t_border" style="padding-left:10px;"><?php echo $view_val['cooperation_username']; ?></td>
													<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">사업부</td>
													<td align="left" class="t_border" style="padding-left:10px;"><?php echo $view_val['dept'];?>
														<input name="cooperation_tel" type="hidden" class="input5" id="cooperation_tel" value="<?php echo $view_val['cooperation_tel']; ?>" />
													</td>
													<!--                    <td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">이메일</td>-->
													<td colspan="4" align="left" style="padding-left:10px;"><input name="cooperation_email" type="hidden" class="input5" id="cooperation_email" value="<?php echo $view_val['cooperation_email']; ?>" /></td>
												</tr>
												<tr>
													<td colspan="10" height="1" bgcolor="#e8e8e8"></td>
												</tr>
												<tr>
													<td height=30></td> 
													<!-- 빈칸 -->
												</tr>
												<tr>
                                                    <td style="font-weight:bold;font-size:13px;">
                                                        <span onclick="modifyPopup(7);" style="cursor:pointer">
                                                            점검 정보
                                                            <img src="<?php echo $misc; ?>img/pencil_btn.png" width="15" height="15" style="margin-left:5px;"/>
                                                        </span>
                                                    </td>
												</tr>
												<tr>
													<td colspan="10" height="2" bgcolor="#797c88"></td>
												</tr>
												<tr>
													<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">관리팀</td>
													<td align="left" class="t_border" style="padding-left:10px;">
													<?php if ($view_val['manage_team'] == "1") {
														echo "기술 1팀";
													}else if ($view_val['manage_team'] == "2") {
														echo "기술 2팀";
													}else if ($view_val['manage_team'] == "3") {
														echo "기술 3팀";
													}else{
														echo "관리팀 미선택";
													} 
													?>
													</td>
													<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">점검주기</td>
													<td align="left" class="t_border" style="padding-left:10px;">
													<?php if ($view_val['maintain_cycle'] == "1") {
														echo "월점검";
													}else if ($view_val['maintain_cycle'] == "3") {
														echo "분기점검";
													}else if ($view_val['maintain_cycle'] == "6") {
														echo "반기점검";
													}else if ($view_val['maintain_cycle'] == "0") {
														echo "장애시";
													}else if ($view_val['maintain_cycle'] == "7") {
														echo "미점검";
													}else{
														echo "점검주기 미선택";
													}
													?>
													</td>
													<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">점검코멘트</td>
													<td align="left" class="t_border" style="padding-left:10px;">
														<?php if(empty($view_val['maintain_comment'])){echo ""; }else{echo nl2br($view_val['maintain_comment']); }; ?>
													</td>
												</tr>
												<tr>
													<td colspan="10" height="1" bgcolor="#e8e8e8"></td>
												</tr>
												<tr>
													<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">점검일자</td>
													<td align="left" class="t_border" style="padding-left:10px;"><?php echo $view_val['maintain_date'];?></td>
													<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">점검자</td>
													<td align="left" class="t_border" style="padding-left:10px;"><?php echo $view_val['maintain_user']; ?></td>
													<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">점검방법</td>
													<td align="left" class="t_border" style="padding-left:10px;">
													<?php if ($view_val['maintain_type'] == "1") {
														echo "방문점검";
													}else if ($view_val['maintain_type'] == "2") {
														echo "원격점검";
													}else{
														echo "점검방법 미선택";
													}
													?>
													</td>
													<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">점검여부</td>
													<td colspan="4" align="left" class="t_border" style="padding-left:10px;">
													<?php if ($view_val['maintain_result'] == "1") {
														echo "완료";
													}else if ($view_val['maintain_result'] == "0") {
														echo "미완료";
													}else if ($view_val['maintain_result'] == "2") {
														echo "미해당";
													}else if ($view_val['maintain_result'] == "9") {
														echo "예정";
													}else if ($view_val['maintain_result'] == "3"){
														echo "연기";
													}else if ($view_val['maintain_result'] == "4"){
														echo "협력사 점검";
													}else{
														echo "점검여부 미선택";
													}
													?> 
													</td>
												</tr>
												<tr>
													<td colspan="10" height="1" bgcolor="#e8e8e8"></td>
												</tr>
												<tr>
													<td height=30></td> 
													<!-- 빈칸 -->
												</tr>
												<tr>
                                                    <td style="font-weight:bold;font-size:13px;">
                                                        <!-- <span onclick="modifyPopup(3);" style="cursor:pointer"> -->
                                                            매출처 정보
                                                            <!-- <img src="<?php echo $misc; ?>img/pencil_btn.png" width="15" height="15" style="margin-left:5px;"/>
                                                        </span> -->
                                                    </td>
												</tr>
												<tr>
													<td colspan="10" height="2" bgcolor="#797c88"></td>
												</tr>
												<tr>
													<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">매출처</td>
													<td align="left" class="t_border" style="padding-left:10px;"><?php echo $view_val['sales_companyname'];?></td>
													<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">담당자</td>
													<td align="left" class="t_border" style="padding-left:10px;"><?php echo $view_val['sales_username']; ?></td>
													<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">연락처</td>
													<td align="left" class="t_border" style="padding-left:10px;"><?php echo $view_val['sales_tel']; ?></td>
													<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">이메일</td>
													<td align="left" class="t_border" style="padding-left:10px;"><?php echo $view_val['sales_email']; ?></td>
													<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">납부회차</td>
													<td align="center" class="t_border" style="padding-left:10px;"><?php echo $view_val['sales_pay_session']; ?></td>
												</tr>
												<?php
												$i = 0;
												$main_company_amount1 = 0;
												foreach ($view_val2 as $item2) {
													${"main_company_amount".($i+1)} = 0;
													if ($i == 0) {
												?>
														<tr id="main_insert_field_<?php echo $i; ?>">
															<td colspan="10" height="1" bgcolor="#e8e8e8"></td>
														</tr>
														<tr>
															<td height=30></td> 
															<!-- 빈칸 -->
														</tr>
														<tr>
                                                            <td style="font-weight:bold;font-size:13px;">
                                                            <!-- <span onclick="modifyPopup(4);" style="cursor:pointer"> -->
                                                                매입처 정보
																<!-- <img src="<?php echo $misc; ?>img/pencil_btn.png" width="15" height="15" style="margin-left:5px;"/></span>
                                                            </td> -->
														</tr>
														<tr>
															<td colspan="10" height="2" bgcolor="#797c88"></td>
														</tr>
														<tr id="main_insert_field_2_<?php echo $i; ?>">
															<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">매입처</td>
															<td align="left" class="t_border" style="padding-left:10px;"><?php echo $item2['main_companyname']; ?>
																<input name="main_seq" type="hidden" id="main_seq" value="<?php echo $item2['seq']; ?>" />
															</td>
															<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">담당자</td>
															<td align="left" class="t_border" style="padding-left:10px;"><?php echo $item2['main_username']; ?></td>
															<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">연락처</td>
															<td align="left" class="t_border" style="padding-left:10px;"><?php echo $item2['main_tel']; ?></td>
															<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">이메일</td>
															<td align="left" class="t_border" style="padding-left:10px;"><?php echo $item2['main_email']; ?></td>
															<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">납부회차</td>
															<td align="center" class="t_border" style="padding-left:10px;"><?php echo $item2['purchase_pay_session']; ?></td>
														</tr>
													<?php
													} else {
													?>
														<tr id="main_insert_field_<?php echo $i; ?>">
															<td colspan="10" height="1" bgcolor="#e8e8e8"></td>
														</tr>
														<tr id="main_insert_field_2_<?php echo $i; ?>">
															<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">매입처</td>
                                                            <td align="left" class="t_border" style="padding-left:10px;">
                                                                <?php echo $item2['main_companyname']; ?>
																<input name="main_seq" type="hidden" id="main_seq" value="<?php echo $item2['seq']; ?>" />
															</td>
															<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">담당자</td>
															<td align="left" class="t_border" style="padding-left:10px;"><?php echo $item2['main_username']; ?></td>
															<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">연락처</td>
															<td align="left" class="t_border" style="padding-left:10px;"><?php echo $item2['main_tel']; ?></td>
															<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">이메일</td>
															<td align="left" class="t_border" style="padding-left:10px;"><?php echo $item2['main_email']; ?></td>
															<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">납부회차</td>
															<td align="center" class="t_border" style="padding-left:10px;"><?php echo $item2['purchase_pay_session']; ?></td>
														</tr>
												<?php
													}
													$max_number = $i;
													$i++;
												}
												?>
												<input type="hidden" id="row_max_index" name="row_max_index" value="<?= $max_number ?>" />
												<?php
												$mb_cnt = 2;
												$j = 1;
												$i = 0;
												foreach ($view_val3 as $item3) {
													if ($j == 1) {
												?>
														<tr>
															<td colspan="10" height="1" bgcolor="#e8e8e8"></td>
														</tr>
														<tr>
															<td height=30></td> 
															<!-- 빈칸 -->
														</tr>
                                                        <tr>
                                                            <td style="font-weight:bold;font-size:13px;">
                                                            <!-- <span onclick="modifyPopup(5);" style="cursor:pointer"> -->
                                                                제품 정보
																<!-- <img src="<?php echo $misc; ?>img/pencil_btn.png" width="15" height="15" style="margin-left:5px;"/></span>
                                                            </td> -->
														</tr>
														<tr id="product_insert_field_<?php echo $j; ?>">
															<td colspan="10" height="2" bgcolor="#797c88"></td>
														</tr>
														<tr id="product_insert_field_1_<?php echo $j; ?>">
															<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">프로젝트명</td>
															<td align="left" class="t_border" style="padding-left:10px;"><?php if($item3['integration_maintain_project_name'] != ""){echo $item3['integration_maintain_project_name'];}else{echo $item3['project_name']."(".$item3['exception_saledate'].")";} ?></td>
															<td class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">제조사</td>
															<td align="left" class="t_border" style="padding-left:10px;" colspan="1"><?php echo $item3['product_company'];?></td>
															<td height="40"  class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">매입처</td>
															<td align="left" class="t_border" style="padding-left:10px;" colspan="1"><?php echo $item3['product_supplier']; ?></td>
															<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">하드웨어/소프트웨어</td>
															<td align="left" class="t_border" style="padding-left:10px;" colspan="1">
                                                                <?php if($item3['product_type'] == "hardware"){
                                                                                echo "하드웨어"; 
                                                                    }else if($item3['product_type'] == "software"){
                                                                        echo "소프트웨어"; 
                                                                    }else{
                                                                        echo "전체" ;
                                                                    }
                                                                ?>
															</td>
														</tr>
														<tr id="product_insert_field_2_<?php echo $j; ?>">
															<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">제품명</td>
															<td align="left" class="t_border" style="padding-left:10px;" colspan="1">
                                                                <input type="hidden" name ="product_seq" id="product_seq" value="<?php echo $item3['seq']; ?>" />
                                                                <?php echo $item3['product_name'] ;?>
															</td>
															<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">라이선스</td>
															<td align="left" class="t_border" style="padding-left:10px;"><?php echo $item3['product_licence']; ?></td>
															<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">Serial</td>
															<td align="left" class="t_border" style="padding-left:10px;"><?php echo $item3['product_serial']; ?></td>
															<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">제품 상태</td>
                                                            <td align="left" class="t_border" style="padding-left:10px;">
                                                                <?php if ($item3['product_state'] == "001") {
                                                                        echo "입고 전";
                                                                    }else if($item3['product_state'] == "002"){
                                                                        echo "창고";
                                                                    }else if($item3['product_state'] == "003"){
                                                                        echo "고객사 출고";
                                                                    }else if($item3['product_state'] == "004"){
                                                                        echo "장애반납";
                                                                    }
                                                                ?>
															</td>
														</tr>

														<tr id="product_insert_field_3_<?php echo $j; ?>">
															<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">장비유지보수시작일</td>
															<td align="left" class="t_border" style="padding-left:10px;"><?php echo $item3['maintain_begin']; ?></td>
															<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">장비유지보수만료일</td>
															<td align="left" class="t_border" style="padding-left:10px;"><?php echo $item3['maintain_expire']; ?> </td>
															<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">유/무상</td>
															<td align="left" class="t_border" style="padding-left:10px;">
                                                                <?php if ($item3['maintain_yn'] == "Y") {
                                                                    echo "유상";
                                                                }else if($item3['maintain_yn'] == "N"){
                                                                    echo "무상";
                                                                }else{
                                                                    echo "유/무상여부";
                                                                } ?>
															</td>
															<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">유지보수 대상</td>
															<td align="left" class="t_border" style="padding-left:10px;">
                                                                <?php if ($item3['maintain_target'] == "Y") {
                                                                    echo "대상";
                                                                }else if ($item3['maintain_target'] == "N") {
                                                                    echo "비대상";
                                                                }else{
                                                                    echo "유지보수 대상";
                                                                } ?>
                                                            </td>
															<input name="product_version" type="hidden" class="input5" id="product_version" value="<?php echo $item3['product_version']; ?>" />
															<input name="product_check_list" type="hidden" class="input5" id="product_check_list" value="<?php echo $item3['product_check_list']; ?>" />
															<input name="product_host" type="hidden" class="input5" id="product_host" value="<?php echo $item3['product_host']; ?>" />
									                  </td>
									                  <input name="custom_title" type="hidden" class="input5" id="custom_title" value="<?php echo $item3['custom_title']; ?>" />
                                                </td>
						                        <input name="custom_detail" type="hidden" class="input5" id="custom_detail" value="<?php echo $item3['custom_detail']; ?>" />
			                              </td>
		                              </tr>
		<tr id="product_insert_field_4_<?php echo $j; ?>">
			<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">유지보수매출가</td>
			<td align="left" class="t_border" style="padding-left:10px;"><?php if(trim($item3['product_sales']) == ""){echo $item3['product_sales'];}else{echo number_format($item3['product_sales']);} ?></td>
			<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">유지보수매입가</td>
			<td align="left" class="t_border" style="padding-left:10px;"><?php if(trim($item3['product_purchase']) == ""){echo $item3['product_purchase'];}else{echo number_format($item3['product_purchase']);} ?></td>
			<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">유지보수마진</td>
			<td align="left" class="t_border" style="padding-left:10px;"><?php if(trim($item3['product_profit']) == ""){echo $item3['product_profit'];}else{echo number_format($item3['product_profit']);} ?></td>
        </tr>
        <tr id="product_insert_field_<?php echo $j; ?>">
            <td colspan="10" height="1" bgcolor="#e8e8e8"></td>
        </tr>
		<?php
	} else {
        ?>
        <tr id="product_insert_field_<?php echo $j; ?>">
            <td colspan="10" height="5" ></td>
        </tr>
		<tr id="product_insert_field_<?php echo $j; ?>">
			<td colspan="10" height="1" bgcolor="#e8e8e8"></td>
        </tr>
		<tr id="product_insert_field_1_<?php echo $j; ?>">
			<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">프로젝트명</td>
			<td align="left" class="t_border" style="padding-left:10px;"><?php if($item3['integration_maintain_project_name'] != ""){echo $item3['integration_maintain_project_name'];}else{echo $item3['project_name']."(".$item3['exception_saledate'].")";} ?></td>
			<td height="40" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">제조사</td>
			<td align="left" class="t_border" style="padding-left:10px;" colspan="1"><?php echo $item3['product_company']; ?></td>
			<td height="40"  class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">매입처</td>
			<td align="left" class="t_border" style="padding-left:10px;" colspan="1"><?php echo $item3['product_supplier']; ?></td>
			<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">하드웨어/소프트웨어</td>
			<td align="left" class="t_border" style="padding-left:10px;" colspan="1">
                <?php if($item3['product_type'] == "hardware"){
                            echo "하드웨어"; 
                    }else if($item3['product_type'] == "software"){
                        echo "소프트웨어"; 
                    }else{
                        echo "전체" ;
                    }
                ?>
			</td>
		</tr>
		<tr id="product_insert_field_2_<?php echo $j; ?>">
			<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">제품명</td>
			<td align="left" class="t_border" style="padding-left:10px;" colspan="1"><?php echo $item3['product_name'] ;?></td>
			<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">라이선스</td>
			<td align="left" class="t_border" style="padding-left:10px;"><?php echo $item3['product_licence']; ?></td>
			<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">Serial</td>
			<td align="left" class="t_border" style="padding-left:10px;"><?php echo $item3['product_serial']; ?></td>
			<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">제품 상태</td>
			<td align="left" class="t_border" style="padding-left:10px;">
                <?php if ($item3['product_state'] == "001") {
                        echo "입고 전";
                    }else if($item3['product_state'] == "002"){
                        echo "창고";
                    }else if($item3['product_state'] == "003"){
                        echo "고객사 출고";
                    }else if($item3['product_state'] == "004"){
                        echo "장애반납";
                    }
                ?>
            </td>
		</tr>
		<tr id="product_insert_field_3_<?php echo $j; ?>">
			<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">장비유지보수시작일</td>
			<td align="left" class="t_border" style="padding-left:10px;"><?php echo $item3['maintain_begin']; ?></td>
			<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">장비유지보수만료일</td>
			<td align="left" class="t_border" style="padding-left:10px;"><?php echo $item3['maintain_expire']; ?></td>
			<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">유/무상</td>
			<td align="left" class="t_border" style="padding-left:10px;">
                <?php if ($item3['maintain_yn'] == "Y") {
                    echo "유상";
                }else if($item3['maintain_yn'] == "N"){
                    echo "무상";
                }else{
                    echo "유/무상여부";
                } ?>
            </td>
			<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">유지보수 대상</td>
			<td align="left" class="t_border" style="padding-left:10px;">
                <?php if ($item3['maintain_target'] == "Y") {
                    echo "대상";
                }else if ($item3['maintain_target'] == "N") {
                    echo "비대상";
                }else{
                    echo "유지보수 대상";
                } ?>
            </td>
			<input name="product_version" type="hidden" class="input5" id="product_version" value="<?php echo $item3['product_version']; ?>" />
			<input name="product_check_list" type="hidden" class="input5" id="product_check_list" value="<?php echo $item3['product_check_list']; ?>" />
			<input name="product_host" type="hidden" class="input5" id="product_host" value="<?php echo $item3['product_host']; ?>" />
			<input name="custom_title" type="hidden" class="input5" id="custom_title" value="<?php echo $item3['custom_title']; ?>" />
			<input name="custom_detail" type="hidden" class="input5" id="custom_detail" value="<?php echo $item3['custom_detail']; ?>" />
		</tr>

		<tr id="product_insert_field_4_<?php echo $j; ?>">
			<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">유지보수매출가</td>
			<td align="left" class="t_border" style="padding-left:10px;"><?php if(trim($item3['product_sales']) == ""){echo $item3['product_sales'];}else{ echo number_format($item3['product_sales']);} ?></td>
			<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">유지보수매입가</td>
			<td align="left" class="t_border" style="padding-left:10px;"><?php if(trim($item3['product_purchase']) == ""){echo $item3['product_purchase'];}else{echo number_format($item3['product_purchase']);} ?></td>
			<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">유지보수마진</td>
			<td align="left" class="t_border" style="padding-left:10px;"><?php if(trim($item3['product_profit']) == ""){echo $item3['product_profit'];}else{echo number_format($item3['product_profit']);} ?></td>
        </tr>
        <tr id="product_insert_field_<?php echo $j; ?>">
            <td colspan="10" height="1" bgcolor="#e8e8e8"></td>
        </tr>

		<?php
		}
		$mb_cnt++;
		$max_number2 = $j;
		$j++;
		$i++;
		}
		?>

<input type="hidden" id="row_max_index2" name="row_max_index2" value="<?php echo $max_number2 ;?>" />
<tr>
	<td id="productEnd" colspan="10" height="0" bgcolor="#e8e8e8"></td>
</tr>
<tr>
    <td colspan="10" height="20" ></td>
</tr>
<tr>
    <td colspan="10" height="1" bgcolor="#e8e8e8"></td>
</tr>
<tr>
	<td name="test" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">유지보수총매출가</td>
	<td name="test" align="left" class="t_border" style="padding-left:10px;"><?php echo number_format($view_val['forcasting_sales']); ?></td>
	<td name="test" height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">유지보수총매입가</td>
	<td name="test" align="left" class="t_border" style="padding-left:10px;"><?php echo number_format($view_val['forcasting_purchase']); ?></td>
	<td name="test" height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">유지보수총마진</td>
	<td name="test" align="left" class="t_border" style="padding-left:10px;"><?php echo number_format($view_val['forcasting_profit']); ?></td>
	
	<!-- 선영테스트 -->
	<!-- <td name="sub" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;display:none">고객사총매출가</td>
	<td name="sub" align="left" class="t_border" style="padding-left:10px; display:none"><input type="text" class="input5" id="sub_plus_forcasting_sales" value="" onfocus="this.blur()" style="border:none" readonly /> </td>
	<td name="sub" height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold; display:none">고객사총매입가</td>
	<td name="sub" align="left" class="t_border" style="padding-left:10px; display:none"><input type="text" class="input5" id="sub_plus_forcasting_purchase" value="" onfocus="this.blur()" style="border:none" readonly /> </td>
	<td name="sub" height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold; display:none">고객사총마진</td>
	<td name="sub" align="left" class="t_border" style="padding-left:10px; display:none"><input type="text" class="input5" id="sub_plus_forcasting_profit" value="" onfocus="this.blur()" style="border:none" readonly /> </td> -->
	<!-- 선영테스트끝 -->

	<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">분할월수</td>
	<td colspan="3" align="left" class="t_border" style="padding-left:10px;">
        <?php if ($view_val['division_month'] == "12") {
                echo "당월";
            }else if ($view_val['division_month'] == "6") {
                echo "반기별";
            }else if ($view_val['division_month'] == "3") {
                echo "분기별";
            }else if ($view_val['division_month'] == "1" || substr($view_val['division_month'], 0, 1) === "m") {
                echo "월별(".substr($view_val['division_month'],1)."개월)";
            } 
        ?>
	</td>
</tr>

<tr>
	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">고객사유지보수시작일</td>
	<td align="left" class="t_border" style="padding-left:10px;"><?php echo $view_val['exception_saledate2']; ?></td>
	<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">고객사유지보수종료일</td>
	<td align="left" class="t_border" style="padding-left:10px;"><?php echo $view_val['exception_saledate3']; ?></td>
</tr>
<tr>
	<td colspan="10" height="1" bgcolor="#e8e8e8"></td>
</tr>
<tr>
	<td height=30></td>
</tr>
<tr>
    <td style="font-weight:bold;font-size:13px;">
    <!-- <span onclick="modifyPopup(6);" style="cursor:pointer"> -->
        수주 정보   
        <!-- <img src="<?php echo $misc; ?>img/pencil_btn.png" width="15" height="15" style="margin-left:5px;"/></span>
    </td> -->
</tr>
<tr>
	<td colspan="10" height="2" bgcolor="#797c88"></td>
</tr>
<tr>
	<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">수주여부</td>
    <td colspan="3" align="left" class="t_border" style="padding-left:10px;">
        <?php if ($view_val['complete_status'] == "001") {
            echo "수주중";
        }else if ($view_val['complete_status'] == "002") {
            echo "수주완료";
        } ?>
    </td>
</tr>
<!--마지막라인-->
<tr>
	<td colspan="10" height="1" bgcolor="#e8e8e8"></td>
</tr>
<!--//마지막라인-->
<tr>
	<td height=30></td>
</tr>
<tr>
	<td colspan=10>
		<table id="sales_statement_table" width="100%" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
			<colgroup>
				<col width="10%" />
				<col width="10%" />
				<col width="10%" />
				<col width="10%" />
				<col width="10%" />
				<col width="10%" />
				<col width="10%" />
				<col width="10%" />
				<col width="10%" />
			</colgroup>
			<tr>
				<td height=50></td> 
			</tr>
			<tr>
				<td style="font-weight:bold;font-size:13px;">
					<!-- <span onclick="modifyPopup(8);" style="cursor:pointer"> -->
					계산서 발행 정보
					<!-- <img src="<?php echo $misc; ?>img/pencil_btn.png" width="15" height="15" style="margin-left:5px;"/>		
					</span> -->
				</td>
			</tr>
			<!--시작라인-->
			<tr>
				<td colspan="10" height="2" bgcolor="#797c88"></td>
			</tr>
			<!-- <tr>
				<td height="40" align="center" class="basic_td" bgcolor="f8f8f9" style="font-weight:bold;">매출납부회차</td>
				<td colspan="4" align="left" class="basic_td" style="padding-left:10px;">
					<?php echo $view_val['sales_pay_session']; ?>
				</td>
				<td height="40" align="center" class="basic_td" bgcolor="f8f8f9" style="font-weight:bold;">매입납부회차</td>
				<td colspan="4" align="left" class="basic_td" style="padding-left:10px;">
					<?php echo $view_val['purchase_pay_session']; ?>
				</td>
			</tr> -->
			<tr>
				<td colspan="10" class="basic_td" height="40" align="center" bgcolor="f8f8f9"
					style="font-weight:bold;">매출</td>
			</tr>
			<tr>
				<td colspan="2" class="basic_td" height="40" align="center" bgcolor="f8f8f9"
					style="font-weight:bold;">계약금액</td>
				<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">회차
				</td>
				<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">발행금액
				</td>
				<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">국세청 승인번호
				</td>
				<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">해당월
				</td>
				<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">발행일자
				</td>
				<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">발행여부
				</td>
				<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">입금일자
				</td>
				<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">입금여부
				</td>
			</tr>
			<?php if(empty($bill_val) || $sales_cnt == 0){?>
				<tr class="insert_sales_bill">
					<td id="sales_contract_total_amount" rowspan="1" colspan="2" class="basic_td" height="40"
						align="center"><?php echo number_format($view_val['forcasting_sales']); ?></td>
					<td colspan=8 align="left" class="basic_td" height="40"> - 등록된 계산서가 없습니다.</td> 
				</tr>
			<?php 
			}
			if($sales_cnt > 0){
				$row = 1; 
				foreach($bill_val as $bill){
					if($bill['type'] == "001"){//매출
						if($row == 1){
			?>
							<tr id="bill_<?php echo $bill['seq']; ?>" class="update_sales_bill" >
								<td id="sales_contract_total_amount" rowspan="1" colspan="2" class="basic_td" height="40" align="center"><?php echo number_format($view_val['forcasting_sales']); ?></td>
								<td height="40" class="basic_td" align="center"><?php echo $bill['pay_session']; ?> </td>
								<td height="40" class="basic_td" align="right"><?php if($bill['issuance_amount'] == ""){echo $bill['issuance_amount'];}else{echo number_format($bill['issuance_amount']);} ?></td>
								<td height="40" class="basic_td" align="center"><?php echo $bill['tax_approval_number']; ?></td>
								<td height="40" class="basic_td" align="center"><?php echo $bill['issuance_month']; ?></td>
								<td height="40" class="basic_td" align="center"><?php echo $bill['issuance_date']; ?></td>
								<td height="40" class="basic_td" align="center">
									<?php if($bill['issuance_status'] == "Y"){
										echo "완료";
									}else{
										echo "미완료";
									} ?>
								</td>
								<td height="40" class="basic_td" align="center"><?php echo $bill['deposit_date']; ?></td>
								<td height="40" class="basic_td" align="center">
									<?php if($bill['deposit_status'] == "Y"){
										echo "완료";
									}else{
										echo "미완료";
									} ?>
								</td>
							</tr>
			<?php		
						$row++;
						}else{ ?>
							<tr id="bill_<?php echo $bill['seq']; ?>" class="update_sales_bill" >
								<td height="40" class="basic_td" align="center"><?php echo $bill['pay_session']; ?> </td>
								<td height="40" class="basic_td" align="right"><?php if($bill['issuance_amount'] == ""){echo $bill['issuance_amount'];}else{echo number_format($bill['issuance_amount']);} ?></td>
								<td height="40" class="basic_td" align="center"><?php echo $bill['tax_approval_number']; ?></td>
								<td height="40" class="basic_td" align="center"><?php echo $bill['issuance_month']; ?></td>
								<td height="40" class="basic_td" align="center"><?php echo $bill['issuance_date']; ?></td>
								<td height="40" class="basic_td" align="center">
									<?php if($bill['issuance_status'] == "Y"){
										echo "완료";
									}else{
										echo "미완료";
									} ?>
								</td>
								<td height="40" class="basic_td" align="center"><?php echo $bill['deposit_date']; ?></td>
								<td height="40" class="basic_td" align="center">
										<?php if($bill['deposit_status'] == "Y"){
											echo "완료";
										}else{
											echo "미완료";
										} ?>
								</td>
							</tr>
			<?php
						echo "<script>";
						echo "$('#sales_contract_total_amount').attr('rowSpan', {$row});";
						echo "</script>";
						$row++;
						}
					}	
				}
			}
			if(empty($bill_val) || $purchase_cnt == 0){?>
				<tr id="sales_issuance_amount_insert_line">
					<td colspan="10" class="basic_td" height="40" align="center" bgcolor="f8f8f9"
						style="font-weight:bold;">매입</td>
				</tr>
				<tr>
					<td class="basic_td" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">업체
					</td>
					<td class="basic_td" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">계약금액
					</td>
					<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">회차
					</td>
					<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">발행금액
					</td>
					<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">국세청 승인번호
					</td>
					<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">해당월
					</td>
					<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">발행일자
					</td>
					<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">발행여부
					</td>
					<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">입금일자
					</td>
					<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">입금여부
					</td>
				</tr>
				<?php
				$num = 1; 
				foreach ($view_val2 as $item2) {?>
				<tr class="purchase_tax_invoice<?php echo $num; ?> insert_purchase_bill">
					<td height="40" class="purchase_contract_total_amount<?php echo $num; ?> basic_td"
						align="center"><?php echo $item2['main_companyname']; ?></td>
					<td id="purchase_contract_total_amount<?php echo $num; ?>" rowspan="1"
						class="purchase_contract_total_amount<?php echo $num; ?> basic_td" height="40"
						align="center"><?php echo number_format(${"main_company_amount".$num}); ?></td>
					<td height="40" colspan=8 class="basic_td" align="left"> - 등록된 계산서가 없습니다.</td>
				</tr>
				<?php 
				$num++;
				}?>
			<?php  
			}
			if($purchase_cnt > 0){ ?>
			<tr id="sales_issuance_amount_insert_line">
				<td colspan="10" class="basic_td" height="40" align="center" bgcolor="f8f8f9"
					style="font-weight:bold;">매입</td>
			</tr>
			<tr>
				<td class="basic_td" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">업체
				</td>
				<td class="basic_td" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">계약금액
				</td>
				<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">회차
				</td>
				<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">발행금액
				</td>
				<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">국세청 승인번호
				</td>
				<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">해당월
				</td>
				<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">발행일자
				</td>
				<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">발행여부
				</td>
				<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">입금일자
				</td>
				<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">입금여부
				</td>
			</tr>
			<?php 
				$num = 1;
				foreach ($view_val2 as $item2) {
					$row2 = 1; 
					foreach($bill_val as $bill){
						if($bill['type'] == "002"){//매입
						if($item2['main_companyname'] == $bill['company_name']){
						if($row2 == 1){ 
			?>
							<tr id="bill_<?php echo $bill['seq']; ?>" class="purchase_tax_invoice<?php echo $num; ?> update_purchase_bill">
								<td height="40" class="purchase_contract_total_amount<?php echo $num; ?> basic_td"
									align="center"><?php echo $bill['company_name']; ?></td>
								<td id="purchase_contract_total_amount<?php echo $num; ?>" rowspan="1"
									class="purchase_contract_total_amount<?php echo $num; ?> basic_td" height="40"
									align="center"><?php echo number_format(${"main_company_amount".$num}); ?></td>
								<td height="40" class="basic_td" align="center"><?php echo $bill['pay_session']; ?></td>
								<td height="40" class="basic_td" align="right">
								<?php if($bill['issuance_amount'] == ""){echo $bill['issuance_amount'];}else{echo number_format($bill['issuance_amount']);} ?>
								</td>
								<td height="40" class="basic_td" align="center"><?php echo $bill['tax_approval_number']; ?></td>
								<td height="40" class="basic_td" align="center"><?php echo $bill['issuance_month']; ?></td>
								<td height="40" class="basic_td" align="center"><?php echo $bill['issuance_date']; ?></td>
								<td height="40" class="basic_td" align="center">
									<?php if($bill['issuance_status'] == "Y"){
										echo "완료";
									}else{
										echo "미완료";
									} ?>
								</td>
								<td height="40" class="basic_td" align="center"><?php echo $bill['deposit_date'];?></td>
								<td height="40" class="basic_td" align="center">
									<?php if($bill['deposit_status'] == "Y"){
											echo "완료";
									}else{
										echo "미완료";
									} ?>
								</td>
							</tr>
					<?php 	
							}else{
					?>
							<tr id="bill_<?php echo $bill['seq']; ?>" class="purchase_tax_invoice<?php echo $num; ?> update_purchase_bill">
								<td height="40" class="basic_td" align="center"><?php echo $bill['pay_session']; ?></td>
								<td height="40" class="basic_td" align="right"><?php if($bill['issuance_amount'] == ""){echo $bill['issuance_amount'];}else{echo number_format($bill['issuance_amount']);} ?></td>
								<td height="40" class="basic_td" align="center"><?php echo $bill['tax_approval_number']; ?></td>
								<td height="40" class="basic_td" align="center"><?php echo $bill['issuance_month']; ?></td>
								<td height="40" class="basic_td" align="center"><?php echo $bill['issuance_date']; ?></td>
								<td height="40" class="basic_td" align="center">
									<?php if($bill['issuance_status'] == "Y"){
										echo "완료";
									}else{
										echo "미완료";
									} ?>
								</td>
								<td height="40" class="basic_td" align="center"><?php echo $bill['deposit_date']; ?></td>
								<td height="40" class="basic_td" align="center">
									<?php if($bill['deposit_status'] == "Y"){
											echo "완료";
									}else{
										echo "미완료";
									} ?>
								</td>
							</tr>
					<?php
							}
							echo "<script>";
							echo "$('.purchase_contract_total_amount{$num}').attr('rowSpan', {$row2});";
							echo "</script>";
							$row2++;
						}
					} 
				}
				$num++;
			}
		}
			?>
		</table>
	</td>
	</tr>

</form>
	</table>
	</td>
	</tr>
	<tr>
		<td height="50"></td>
	</tr>
	<!-- <tr>
		<td>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td colspan="7"style="font-weight:bold;font-size:13px;">수주 여부 코멘트</td>
				<td colspan="2"><div style='float:right;'>코멘트 추가 <img align="center" src="<?php echo $misc; ?>img/btn_add.jpg" width="18" height="17" style="cursor:pointer;" border="0" onclick="completeStatusCommentAdd();"></div></td>
			</tr>
			<tr>
				<td colspan="9" height="2" bgcolor="#797c88"></td>	
			</tr>
			<tr>
				<td id ="complete_status_comment" colspan="9" align="left"  style="padding:5px 5px 0px 5px;">
					<?php
					if($complete_status_val){
						$n = 1;
						foreach ($complete_status_val as $item) {
						?>
							<table id="completeStatusCommentAdd<?php echo $n; ?>" class="update_complete_status_comment" width="100%" border="0" cellspacing="0" cellpadding="5">
								<tr bgcolor="f8f8f9">
									<td width="8%" class="answer"><?php echo $item['user_name']; ?></td>
									<td width="10%"><?php echo substr($item['insert_date'], 0, 10); ?></td>
									<td width="10%" align="right"><?php if ($id == $item['user_id'] || $lv == 3) { ?><img src="<?php echo $misc; ?>img/btn_del.jpg" width="18" height="17" style="cursor:pointer" border="0" onclick="completeStatusCommentDel('<?php echo $item['seq'] ?>');filedel('<?php echo $item['seq']; ?>','<?php echo $item['file_change_name']; ?>');" /><?php } ?></td>
								</tr>
								<tr>
									<td width="10%">
										<input type="hidden" id="comment_seq" value="<?php echo $item['seq']; ?>">
										<select name="complete_status" id="complete_status" class="input5" disabled>
											<option value="0">-수주여부-</option>
											<option value="001" <?php if ($item['complete_status'] == "001") {
																	echo "selected";
																} ?>>수주중
											</option>
											<option value="002" <?php if ($item['complete_status'] == "002") {
																	echo "selected";
																} ?>>수주완료
											</option>
										</select>
									</td>
									<td width="70%">
										<?php echo $item['contents']; ?>
									</td>
									<td width="20%"><?php if($item['file_change_name']){ ?><a href="<?php echo site_url(); ?>/maintain/complete_status_comment_download/<?php echo urlencode($item['file_real_name']); ?>/<?php echo $item['file_change_name']; ?>"><?php echo $item['file_real_name']; ?></a> <a href="javascript:filedel('<?php echo $item['seq']; ?>','<?php echo $item['file_change_name']; ?>');"><img src="<?php echo $misc; ?>img/del.png" width="8" height="8" /></a><?php } else { ?><span class="point0 txt_s">첨부파일 없음<?php } ?></td>
									
								</tr>
							</table>
						<?php
						$n++;
						}
					}?>
				</td>
			</tr>
	
			</table>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr> -->
	<tr>
		<td>&nbsp;</td>
	</tr>
	<!--댓글-->
	<tr>
		<td align="center">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<form name="rform" method="post">
					<input type="hidden" name="seq" value="<?php echo $seq; ?>">
					<input type="hidden" name="cseq" value="">
					<tr>
						<td style="font-weight:bold;font-size:13px;">댓글</td>
					</tr>
					<tr>
						<td height="2" bgcolor="#797c88"></td>
					</tr>
					<?php
					foreach ($clist_val as $item) {
					?>
						<tr>
							<td bgcolor="f8f8f9">
								<table width="180" border="0" cellspacing="0" cellpadding="5">
									<tr>
										<td width="40%" class="answer"><?php echo $item['user_name']; ?></td>
										<td width="50%"><?php echo substr($item['insert_date'], 0, 10); ?></td>
										<td width="10%" align="right"><?php if ($id == $item['user_id'] || $lv == 3) { ?><img src="<?php echo $misc; ?>img/btn_del.jpg" width="18" height="17" style="cursor:pointer" border="0" onclick="javascript:chkForm3('<?php echo $item['seq'] ?>');return false;" /><?php } ?></td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td height="1" bgcolor="#e8e8e8"></td>
						</tr>
						<tr>
							<td class="answer2"><?php echo nl2br(str_replace(" ", "&nbsp;", htmlspecialchars($item['contents']))) ?></td>
						</tr>
						<tr>
							<td height="1" bgcolor="#e8e8e8"></td>
						</tr>
					<?php
					}
					?>
					<tr>
						<td bgcolor="f8f8f9">
							<table width="170" border="0" cellspacing="0" cellpadding="5">
								<tr>
									<td width="40%" class="answer"><?php echo $name; ?></td>
									<td width="50%"><?php echo date("Y-m-d"); ?></td>
									<td width="10%" align="right">
										<!-- <img src="<?php echo $misc; ?>img/btn_del.jpg" width="18" height="17" /> -->
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td height="1" bgcolor="#e8e8e8"></td>
					</tr>
					<tr>
						<td class="answer2" align="center"><textarea name="comment" id="comment" cols="130" rows="5" class="input_answer1"></textarea></td>
					</tr>
					<tr>
						<td height="2" bgcolor="#797c88"></td>
					</tr>
				</form>
			</table>
		</td>
	</tr>
	<tr>
		<td height="10"></td>
	</tr>
	<!--버튼-->
	<tr>
		<td align="center"><input type="image" src="<?php echo $misc; ?>img/btn_answer2.jpg" width="60" height="20" style="cursor:pointer" onclick="javascript:chkForm2();return false;" /></td>
	</tr>
	<!--//버튼-->
	<!--//댓글-->
	<tr>
		<td>&nbsp;</td>
    </tr>
    <tr>
		<td align="right">
            <img src="<?php echo $misc; ?>img/btn_list.jpg" width="64" height="31" style="cursor:pointer" onClick="javascript:history.go(-1)" />
            <img src="<?php echo $misc; ?>img/btn_delete.jpg" width="64" height="31" style="cursor:pointer" border="0" onclick="javascript:chkDel();return false;" />
        </td>
	</tr>
	</table>
	<!--//내용-->

	</td>

	</tr>
	</table>

	</td>
	</tr>
	<!--하단-->
	<tr>
		<td align="center" height="100" bgcolor="#CCCCCC">
			<table width="1130" cellspacing="0" cellpadding="0">
				<tr>
					<td width="197" height="100" align="center" background="<?php echo $misc; ?>img/customer_f_bg.png"><img src="<?php echo $misc; ?>img/f_ci.png" /></td>
					<td><?php include $this->input->server('DOCUMENT_ROOT') . "/include/sales_bottom.php"; ?></td>
				</tr>
			</table>
		</td>
	</tr>
	<!--//하단-->
	</table>
<script src="//cdnjs.cloudflare.com/ajax/libs/babel-standalone/6.26.0/babel.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/babel-polyfill/7.4.3/polyfill.js"></script>
<script type="text/babel" data-presets="es2015, stage-3">
	var mb_cnt = Number($("#row_max_index2").val());

	//조회 추가 됐을 때 기존의 고객사총매출가를 안보이게하고 새로 추가
	// if ($("input[name=sub_product_sales]").length > 0) {
	// 	var subProductSales = 0;
	// 	var subProductPurchase=0;
	// 	var subProductProfit=0;
	// 	for (var i = 0; i < document.getElementsByName("sub_product_sales").length; i++) {
	// 		subProductSales += parseInt(document.getElementsByName("sub_product_sales")[i].value.replace(/,/g, ""));
	// 		subProductPurchase += parseInt(document.getElementsByName("sub_product_purchase")[i].value.replace(/,/g, ""));
	// 		subProductProfit += parseInt(document.getElementsByName("sub_product_profit")[i].value.replace(/,/g, ""));
			
	// 	}
	// 	$("td[name=test]").css("display", "none");
	// 	$("td[name=sub]").css("display", "");

	// 	$("#sub_plus_forcasting_sales").val((<?php echo $view_val['forcasting_sales']; ?> + subProductSales).toString().replace(/(\d)(?=(?:\d{3})+(?!\d))/g, "$1,"));
	// 	$("#sub_plus_forcasting_purchase").val((<?php echo $view_val['forcasting_purchase']; ?> + subProductPurchase).toString().replace(/(\d)(?=(?:\d{3})+(?!\d))/g, "$1,"));
	// 	$("#sub_plus_forcasting_profit").val((<?php echo $view_val['forcasting_profit']; ?> + subProductProfit).toString().replace(/(\d)(?=(?:\d{3})+(?!\d))/g, "$1,"));
	// }


	if ($("#division_month").val() == "month") {
		$("#monthlyInput").show();
		$("#month").show();
		$("#monthlyInput").val(<?php echo substr($view_val['division_month'], 1) ?>)
		var monthlyInputValue = $("#monthlyInput").val();
		var divisionMonthValue = $("#division_month").val();
		$("#division_month option:eq(3)").val("m" + monthlyInputValue);
	} else {
		$("#monthlyInput").hide();
		$("#month").hide();
		$("#monthlyInput").val('');
	}

	function monthDivision() {
		if ($("#division_month").val() == "month") {
			$("#monthlyInput").show();
			$("#month").show();
		} else {
			$("#monthlyInput").hide();
			$("#month").hide();
			$("#monthlyInput").val('');
		}
	}

	function month() {
		var monthlyInputValue = $("#monthlyInput").val();
		var divisionMonthValue = $("#division_month").val();
		$("#division_month option:eq(3)").val("m" + monthlyInputValue);
	}



   //수주여부 코멘트 추가
	function completeStatusCommentAdd(){
		var num;
		if($("#complete_status_comment>table:last").length == 0){
			num = 1;
		}else{
			num = Number($("#complete_status_comment>table:last").attr('id').replace('completeStatusCommentAdd',''))+1;
		}
		
		var html = '<table id="completeStatusCommentAdd'+num+'" width="100%" border="0" cellspacing="0" cellpadding="5"><tr bgcolor="f8f8f9">';
		html += '<td width="8%" class="answer"><?php echo $name; ?></td>';
		html += '<td colspan="2" width="20%" align="right"><input type="image" src="<?php echo $misc; ?>img/btn_answer2.jpg" width="50" height="18" style="cursor:pointer" onclick="ajaxFileUpload('+num+');" /></td></tr>'
		html += '<tr><td width="10%"><select id="comment_status" class="input5">';
		html += '<option value="0" selected>-수주여부-</option><option value="001">수주중</option><option value="002">수주완료</option></select>';
		html += '<td width="80%"><input type="text" id="comment_contents" value="" style="width:95%;"/></td>';
		html += '<td width="10%"><form id="ajaxFrom" method="post"><input type="file" id="ajaxFile" />(용량제한 100MB)</form></td>'
		html += '</tr></table>'
		$("#complete_status_comment").html($("#complete_status_comment").html()+html)
	}

   //수주여부 코멘트 삭제
	function completeStatusCommentDel(seq){
		if (confirm("코멘트를 삭제하시겠습니까?") == true) {
			$.ajax({
				type: "POST",
				cache: false,
				url: "<?php echo site_url();?>/ajax/maintain_complete_status_comment_delete",
				dataType: "json",
				async: false,
				data: {
					seq: seq
				},
				success: function (data) {
					if(data.result == "true"){
						alert("수주여부 코멘트 삭제 되었습니다.");
					}else{
						alert("수주여부 코멘트 삭제 실패하였습니다.");
					}
					location.reload();
				}
			});
		}
	}

	//수주 여부 코멘트 등록 
	function ajaxFileUpload(num) {
		var status = $("#completeStatusCommentAdd"+num).find("#comment_status option:selected").val();//수주 상태
		var contents = $("#completeStatusCommentAdd"+num).find("#comment_contents").val();//코멘트 내용

		if(jQuery("#ajaxFile")[0].files[0] == undefined){ //첨부파일 없성
			$.ajax({
				type: "POST",
				cache: false,
				url: "<?php echo site_url();?>/ajax/maintain_complete_status_comment_insert",
				dataType: "json",
				async: false,
				data: {
					seq: <?php echo $seq ;?>,
					status: status,
					contents:contents,
					file_real_name:'',
					file_change_name:''
				},
				success: function (data) {
					if(data.result == "true"){
						alert("수주여부 코멘트 등록 되었습니다.");
					}else{
						alert("수주여부 코멘트 등록을 실패하였습니다.");
					}
					location.reload();
				}
			});

		}else{//첨부파일 있썽
			var form = jQuery("#ajaxFrom")[0];
			var formData = new FormData(form);
			formData.append("message", "ajax로 파일 전송하기");
			formData.append("file", jQuery("#ajaxFile")[0].files[0]);

			jQuery.ajax({
				url: "<?php echo site_url();?>/ajax/maintain_complete_status_file_upload",
				type : "POST",
				processData : false,
				contentType : false,
				data : formData,
				success:function(json) {
					var obj = JSON.parse(json);
					if(obj == "false"){
						alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.')
					}else{
						var file_real_name = obj.file_real_name;
						var file_change_name = obj.file_change_name;
					
						$.ajax({
							type: "POST",
							cache: false,
							url: "<?php echo site_url();?>/ajax/maintain_complete_status_comment_insert",
							dataType: "json",
							async: false,
							data: {
								seq: <?php echo $seq ;?>,
								status: status,
								contents:contents,
								file_real_name:file_real_name,
								file_change_name:file_change_name
							},
							success: function (data) {
								if(data.result == "true"){
									alert("수주여부 코멘트 등록 되었습니다.");
								}else{
									alert("수주여부 코멘트 등록을 실패하였습니다.");
								}
								location.reload();
							}
						});
					}
				}
			});

		}
	}

	//수주여부 코멘트 첨부파일 삭제
	function filedel(seq, filename) {
		if(filename != ""){
			if (confirm("첨부파일을 삭제하시겠습니까?") == true) {
				location.href = "<?php echo site_url(); ?>/maintain/maintain_complete_status_filedel/" + seq + "/" + filename;
				return false;
			}
		}
 	}

    //수정 하러가기 팝업
    function modifyPopup(type){
		if(type == "8"){
			if("<?php echo $view_val['sales_pay_session']; ?>" == ""){
				alert("유지보수 매출 납부회차를 먼저 입력해주세요. 매출처 정보로 이동합니다.");
				modifyPopup(3);
				return false;
			}
			<?php foreach ($view_val2 as $item2) {
				if($item2['purchase_pay_session'] == ""){?>
					alert("유지보수 매입 납부회차를 먼저 입력해주세요. 매입처 정보로 이동합니다.");
					modifyPopup(4);
					return false;
				<?php
				}
			}?>
		}
        window.open("<?php echo site_url(); ?>/maintain/maintain_modify?seq=<?php echo $view_val['seq'] ;?>&type="+type,"","width = 1000, height = 500, scrollbars=1");
	}

	// 통합유지보수 리스트
	function integration_maintain(){
		window.open("<?php echo site_url(); ?>/maintain/integration_maintain_list","","width = 1000, height = 500, scrollbars=1");
	}

	//유지보수 갱신 
	function renewal(){
		var integration_maintain = confirm("통합유지보수를 유지하시겠습니까?");
		var project_name = prompt("갱신할 유지보수의 프로젝트명을 입력해주세요.");

		$.ajax({
			type: "POST",
			cache: false,
			url: "<?php echo site_url();?>/maintain/maintain_renewal",
			dataType: "json",
			async: false,
			data: {
				maintain_seq: <?php echo $seq ;?>,
				project_name: project_name,
				integration_maintain:integration_maintain
			},
			success: function (data) {
				if(data){
					alert("유지보수 갱신 되었습니다.");
					location.href = "<?php echo site_url(); ?>/maintain/maintain_view?seq="+data;
				}else{
					alert("유지보수 갱신 실패");
				}
			}
		});

	}
</script>
</body>

</html>
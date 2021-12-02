<?php
include $this->input->server('DOCUMENT_ROOT') . "/include/base.php";
include $this->input->server('DOCUMENT_ROOT') . "/include/sales_top.php";
?>
<style type="text/css">
	#monthlyInput {
		width: 50px;
		margin-left: 10px;
		display: none;
	}

	#month {
		display: none;
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
			location.href = "<?php echo site_url(); ?>/forcasting/forcasting_delete_action?seq=<?php echo $seq; ?>";
		}
	}
</script>
<script language="javascript">
	function chkForm2() {
		var rform = document.rform;

		if (rform.comment.value == "") {
			rform.comment.focus();
			alert("답변을 등록해 주세요.");
			return false;
		}

		rform.action = "<?php echo site_url(); ?>/forcasting/forcasting_comment_action";
		rform.submit();
		return false;
	}

	function chkForm3(seq) {
		if (confirm("정말 삭제하시겠습니까?") == true) {
			var rform = document.rform;
			rform.cseq.value = seq;
			rform.action = "<?php echo site_url(); ?>/forcasting/forcasting_comment_delete";
			rform.submit();
			return false;
		}
	}
</script>

<body>
	<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
	<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
	?>
		<tr>
			<td align="center" valign="top">

				<table width="90%" height="100%" cellspacing="0" cellpadding="0">
					<tr>
						<td width="100%" align="center" valign="top">
							<!--내용-->
							<table width="100%" border="0" style="margin-top:50px; margin-bottom: 50px;">
								<!--타이틀-->
								<tr>
									<td class="title3">포캐스팅</td>
								</tr>
								<!--//타이틀-->
								<tr>
									<td>&nbsp;</td>
								</tr>
								<!--작성-->
								<tr>
									<td>
										<table width="100%" border="0" cellspacing="0" cellpadding="0" id="main_list">
												<input type="hidden" name="seq" value="<?php echo $seq; ?>">
												<colgroup>
													<col width="10%" />
													<col width="15%" />
													<col width="10%" />
													<col width="15%" />
													<col width="10%" />
													<col width="15%" />
													<col width="10%" />
													<col width="10%" />
													<col width="5%" />
												</colgroup>
												<tr>
													<td height=15></td> 
												</tr>
												<tr>
                                                    <td style="font-weight:bold;font-size:13px;">
														<span onclick="modifyPopup(1);" style="cursor:pointer">
														고객사 정보
														<img src="<?php echo $misc; ?>img/pencil_btn.png" width="15" height="15" style="margin-left:5px;"/>		
														</span>
                                                    </td>
												</tr>
												<!--시작라인-->
												<tr>
													<td colspan="9" height="2" bgcolor="#797c88"></td>
												</tr>
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
													<td colspan="9" height="1" bgcolor="#e8e8e8"></td>
												</tr>
												<tr>
													<td height=30></td> 
													<!-- 빈칸 -->
												</tr>
												<tr>
                                                    <td style="font-weight:bold;font-size:13px;">
														<span onclick="modifyPopup(2);" style="cursor:pointer">
														영업 정보
														<img src="<?php echo $misc; ?>img/pencil_btn.png" width="15" height="15" style="margin-left:5px;"/>
														</span>
                                                    </td>
												</tr>
												<tr>
													<td colspan="9" height="2" bgcolor="#797c88"></td>
												</tr>
												<tr>
													<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">프로젝트</td>
													<td colspan="3" align="left" class="t_border" style="padding-left:10px;"><?php echo $view_val['project_name']; ?></td>
													<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">판매종류</td>
                                                    <td align="left" class="t_border" style="padding-left:10px;">
                                                        <?php if ($view_val['type'] == "1") {
                                                            echo "판매";
                                                        }else if ($view_val['type'] == "2") {
                                                            echo "용역";
                                                        }else if($view_val['type'] == "0"){
                                                            echo "선택없음";
                                                        }else if ($view_val['type'] == "3"){
															echo "유지보수";
														}else if ($view_val['type'] == "4"){
															echo "조달";
														} ?>
													</td>
													<?php if($view_val['type'] == "4"){ ?>
													<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">조달 판매금액(VAT포함)</td>
                                                    <td align="left" class="t_border" style="padding-left:10px;">
														<?php echo $view_val['procurement_sales_amount']; ?>
													</td>
													<?php }?>
												</tr>
												<tr>
													<td colspan="9" height="1" bgcolor="#e8e8e8"></td>
												</tr>
												<tr>
													<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">진척단계</td>
                                                    <td colspan="8" align="left" class="t_border" style="padding-left:10px;">
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
												</tr>
												<tr>
													<td colspan="9" height="1" bgcolor="#e8e8e8"></td>
												</tr>
												<tr>
													<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">영업업체</td>
                                                    <td align="left" class="t_border" style="padding-left:10px;">
                                                        <?php echo $view_val['cooperation_companyname']; ?>
													</td>
													<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">영업담당자</td>
													<td align="left" class="t_border" style="padding-left:10px;"><?php echo $view_val['cooperation_username']; ?></td>
													<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">사업부</td>
													<td align="left" class="t_border" style="padding-left:10px;"><?php echo $view_val['dept']; ?></td>
												</tr>
												<tr>
													<td colspan="9" height="1" bgcolor="#e8e8e8"></td>
												</tr>
												<tr>
													<td height=30></td>
												</tr>
												<tr>
                                                    <td style="font-weight:bold;font-size:13px;">
                                                        <span onclick="modifyPopup(3);" style="cursor:pointer">매출처 정보
														<img src="<?php echo $misc; ?>img/pencil_btn.png" width="15" height="15" style="margin-left:5px;"/></span>
                                                    </td>
												</tr>
												<tr>
													<td colspan="9" height="2" bgcolor="#797c88"></td>
												</tr>
												<tr>
													<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">매출처</td>
													<td align="left" class="t_border" style="padding-left:10px;"><?php echo $view_val['sales_companyname'];?></td>
													<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">담당자</td>
													<td align="left" class="t_border" style="padding-left:10px;"><?php echo $view_val['sales_username']; ?></td>
													<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">연락처</td>
													<td align="left" class="t_border" style="padding-left:10px;"><?php echo $view_val['sales_tel']; ?></td>
													<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">이메일</td>
													<td colspan="2" align="left" class="t_border" style="padding-left:10px;"><?php echo $view_val['sales_email']; ?></td>
												</tr>
												<?php
												$i = 0;
												foreach ($view_val2 as $item2) {
													if ($i == 0) {
												?>
														<tr id="main_insert_field_<?php echo $i; ?>">
															<td colspan="9" height="1" bgcolor="#e8e8e8"></td>
														</tr>
														<tr>
															<td height=30></td> 
															<!-- 빈칸 -->
														</tr>
														<tr>
                                                            <td style="font-weight:bold;font-size:13px;">
                                                                <span onclick="modifyPopup(4);" style="cursor:pointer">매입처 정보
																<img src="<?php echo $misc; ?>img/pencil_btn.png" width="15" height="15" style="margin-left:5px;"/></span>
                                                            </td>
														</tr>
														<tr>
															<td colspan="9" height="2" bgcolor="#797c88"></td>
														</tr>
														<tr id="main_insert_field_2_<?php echo $i; ?>">
															<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">매입처</td>
															<td align="left" class="t_border" style="padding-left:10px;"><?php echo $item2['main_companyname']; ?>
																<input name="main_seq" type="hidden" class="input7" id="main_seq" value="<?php echo $item2['seq']; ?>" />
															</td>
															<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">담당자</td>
															<td align="left" class="t_border" style="padding-left:10px;"><?php echo $item2['main_username']; ?></td>
															<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">연락처</td>
															<td align="left" class="t_border" style="padding-left:10px;"><?php echo $item2['main_tel']; ?></td>
															<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">이메일</td>
															<td align="left" class="t_border" style="padding-left:10px;"><?php echo $item2['main_email']; ?></td>
														</tr>
													<?php
													} else {
													?>
														<tr id="main_insert_field_<?php echo $i; ?>">
															<td colspan="9" height="1" bgcolor="#e8e8e8"></td>
														</tr>
														<tr id="main_insert_field_2_<?php echo $i; ?>">
															<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">매입처</td>
                                                            <td align="left" class="t_border" style="padding-left:10px;">
                                                                <?php echo $item2['main_companyname']; ?>
																<input name="main_seq" type="hidden" class="input7" id="main_seq" value="<?php echo $item2['seq']; ?>" />
															</td>
															<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">담당자</td>
															<td align="left" class="t_border" style="padding-left:10px;"><?php echo $item2['main_username']; ?></td>
															<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">연락처</td>
															<td align="left" class="t_border" style="padding-left:10px;"><?php echo $item2['main_tel']; ?></td>
															<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">이메일</td>
															<td align="left" class="t_border" style="padding-left:10px;"><?php echo $item2['main_email']; ?></td>
														</tr>
												<?php
													}
													$max_number = $i;
													$i++;
												}
												?>
												<input type="hidden" id="row_max_index" name="row_max_index" value="<?= $max_number ?>" />
												<?php
												$j = 1;
												$i = 0;
												foreach ($view_val3 as $item3) {
													if ($j == 1) {
												?>
														<tr>
															<td colspan="9" height="1" bgcolor="#e8e8e8"></td>
														</tr>
														<tr id="main_insert">
															<td height=30></td> 
														</tr>
														<tr>
                                                            <td style="font-weight:bold;font-size:13px;">
                                                                <span onclick="modifyPopup(5);" style="cursor:pointer">제품 정보
																<img src="<?php echo $misc; ?>img/pencil_btn.png" width="15" height="15" style="margin-left:5px;"/></span>
                                                            </td>
														</tr>
														<!--시작라인-->
														<tr id="product_insert_field_<?php echo $j; ?>">
															<td colspan="9" height="2" bgcolor="#797c88"></td>
														</tr>
														<tr id="product_insert_field_1_<?php echo $j; ?>" >
															<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">제조사</td>
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
															<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">장비매출가</td>
															<td align="left" class="t_border" style="padding-left:10px;"><?php if(trim($item3['product_sales']) == ""){echo $item3['product_sales'];}else{echo number_format($item3['product_sales']);} ?></td>
															<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">장비매입가</td>
															<td align="left" class="t_border" style="padding-left:10px;"><?php if(trim($item3['product_purchase']) == ""){echo $item3['product_purchase'];}else{echo number_format($item3['product_purchase']);} ?></td>
															<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">장비마진</td>
															<td align="left" class="t_border" style="padding-left:10px;"><?php if(trim($item3['product_profit']) == ""){echo $item3['product_profit'];}else{echo number_format($item3['product_profit']);}?></td>
														</tr>
														<tr id="product_insert_field_<?php echo $j; ?>">
															<td colspan="9" height="1" bgcolor="#e8e8e8"></td>
														</tr>
													<?php
													} else {
													?>
														<tr id="product_insert_field_<?php echo $j; ?>">
															<td colspan="9" height="5" ></td>
														</tr>
														<tr id="product_insert_field_<?php echo $j; ?>">
															<td colspan="9" height="1" bgcolor="#e8e8e8"></td>
														</tr>
														<tr id="product_insert_field_1_<?php echo $j; ?>">
															<td  height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">제조사</td>
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
															<input type="hidden" name ="product_seq" id="product_seq" value="<?php echo $item3['seq']; ?>" />
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
															<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">장비매출가</td>
															<td align="left" class="t_border" style="padding-left:10px;"><?php if(trim($item3['product_sales']) == ""){echo $item3['product_sales'];}else{echo number_format($item3['product_sales']);} ?></td>
															<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">장비매입가</td>
															<td align="left" class="t_border" style="padding-left:10px;"><?php if(trim($item3['product_purchase']) == ""){echo $item3['product_purchase'];}else{echo number_format($item3['product_purchase']);} ?></td>
															<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">장비마진</td>
															<td align="left" class="t_border" style="padding-left:10px;"><?php if(trim($item3['product_profit']) == ""){echo $item3['product_profit'];}else{echo number_format($item3['product_profit']);} ?></td>
														</tr>
														<tr id="product_insert_field_<?php echo $j; ?>">
															<td colspan="9" height="1" bgcolor="#e8e8e8"></td>
														</tr>
												<?php
													}
													$max_number2 = $j;
													$j++;
													$i++;
												}
												?>
												<input type="hidden" id="row_max_index2" name="row_max_index2" value="<?php echo $max_number2; ?>" />
												<tr>
													<td colspan="9" height="20" ></td>
												</tr>
												<tr>
													<td colspan="9" height="1" bgcolor="#e8e8e8"></td>
												</tr>
												<tr id="input_point">
													<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">고객사총매출가</td>
													<td align="left" class="t_border" style="padding-left:10px;"><?php echo number_format($view_val['forcasting_sales']); ?></td>
													<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">고객사총매입가</td>
													<td align="left" class="t_border" style="padding-left:10px;"><?php echo number_format($view_val['forcasting_purchase']); ?></td>
													<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">고객사총마진</td>
													<td align="left" class="t_border" style="padding-left:10px;"><?php echo number_format($view_val['forcasting_profit']); ?></td>
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
									</td>
								</tr>
								<tr>
									<td colspan="9" height="1" bgcolor="#e8e8e8"></td>
								</tr>
								<tr>
									<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">최초 매출일</td>
									<td align="left" class="t_border" style="padding-left:10px;"><?php echo $view_val['first_saledate']; ?></td>
									<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">예상 매출일</td>
									<td align="left" class="t_border" style="padding-left:10px;"><?php echo $view_val['exception_saledate']; ?></td>
									<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">월별마진</td>
                                    <td align="left" class="t_border" style="padding-left:10px;">
                                        <?php if (substr($view_val['division_month'], 0, 1) === "m") {
                                            echo number_format($view_val['forcasting_profit'] / substr($view_val['division_month'], 1));
                                        } else {
                                            echo number_format($view_val['forcasting_profit'] / (12 / $view_val['division_month']));
                                        } ?> 
                                    </td>
									<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">해당월</td>
                                    <td colspan="3" align="left" class="t_border" style="padding-left:10px;">
                                        <select name="montly_f_p" id="montly_f_p" class="input5">
											<?php
											$montly_f_p = explode('-', $view_val['exception_saledate']);

											if (substr($view_val['division_month'], 0, 1) === "m") {
												for ($i = 0; $i < substr($view_val['division_month'], 1); $i++) {
													$montly_tmp = ($montly_f_p[1] + 1 * $i) % 12;

													if ($montly_tmp == 0) {
														$montly_tmp = 12;
													}
													$plusYear = $montly_f_p[0] + (int) (($montly_f_p[1] + $i) / 13);
													echo '<option selected>' . $plusYear . '_' . (sprintf('%02d', $montly_tmp)) . '</option>';
												};
											} else {
												for ($i = 0; $i < 12 / $view_val['division_month']; $i++) {
													$montly_tmp = ($montly_f_p[1] + ($view_val['division_month']) * $i) % 12;
													if ($montly_tmp == 0) {
														$montly_tmp = 12;
													}
											?>
												<option selected><?php echo $montly_f_p[0] + (int) (($montly_f_p[1] + $i) / 13) . "-" . (sprintf('%02d', $montly_tmp)); ?></option>

											<?php }
                                            } ?>
                                        </select>
                                    </td>
								</tr>
								<tr>
									<td colspan="9" height="1" bgcolor="#e8e8e8"></td>
								</tr>
								<tr id="main_insert">
										<td height=30></td> 
								</tr>
								<tr>
                                    <td colspan="9"style="font-weight:bold;font-size:13px;">
										<span onclick="modifyPopup(6);" style="cursor:pointer">수주 정보
										<img src="<?php echo $misc; ?>img/pencil_btn.png" width="15" height="15" style="margin-left:5px;"/></span>
                                    </td>
								</tr>
								<!--시작라인-->
								<tr>
									<td colspan="9" height="2" bgcolor="#797c88"></td>
								</tr>
								<tr>
									<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">수주여부</td>
									<td colspan=8 align="left" class="t_border" style="padding-left:10px;">
                                        <?php if ($view_val['complete_status'] == "001") {
                                            echo "수주중";
                                        }else if ($view_val['complete_status'] == "002") {
                                            echo "수주완료";
                                        } ?>
									</td>
								</tr>
								<tr>
									<td colspan="9" height="1" bgcolor="#e8e8e8"></td>
								</tr>
							</table>
						</td>
					</tr>
					<!--//작성-->

					<tr>
						<td height="10"></td>
					</tr>
					<!--버튼-->
					<!-- <tr>
						<td align="right">
                            <img src="<?php echo $misc; ?>img/btn_list.jpg" width="64" height="31" style="cursor:pointer" onClick="javascript:history.go(-1)" />
                            <img src="<?php echo $misc; ?>img/btn_delete.jpg" width="64" height="31" style="cursor:pointer" border="0" onclick="javascript:chkDel();return false;" />
                        </td>
					</tr> -->
					<!--//버튼-->
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
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
							<!-- 여기서부터가 수주여부 코멘트 -->
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
													<td width="10%" align="right"><?php if ($id == $item['user_id'] || $lv == 3) { ?><img src="<?php echo $misc; ?>img/btn_del.jpg" width="18" height="17" style="cursor:pointer" border="0" onclick="completeStatusCommentDel('<?php echo $item['seq'] ?>'); filedel('<?php echo $item['seq']; ?>','<?php echo $item['file_change_name']; ?>');" /><?php } ?></td>
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
													<td width="20%"><?php if($item['file_change_name']){ ?><a href="<?php echo site_url(); ?>/forcasting/complete_status_comment_download/<?php echo urlencode($item['file_real_name']); ?>/<?php echo $item['file_change_name']; ?>"><?php echo $item['file_real_name']; ?></a><img src="<?php echo $misc; ?>img/del.png" width="8" height="8" onclick="filedel('<?php echo $item['seq']; ?>','<?php echo $item['file_change_name']; ?>')"/><?php } else { ?><span class="point0 txt_s">첨부파일 없음<?php } ?></td>
													
												</tr>
											</table>
										<?php
										$n++;
										}
									}?>
								</td>
							</tr>
							<!-- 수주여부코멘트 끝 -->
							</table>
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
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
				</table>
				<!--//내용-->

			</td>

		</tr>
		<tr>
			<td align="right">
				<img src="<?php echo $misc; ?>img/btn_list.jpg" width="64" height="31" style="cursor:pointer" onClick="javascript:history.go(-1)" />
				<img src="<?php echo $misc; ?>img/btn_delete.jpg" width="64" height="31" style="cursor:pointer" border="0" onclick="javascript:chkDel();return false;" />
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
<script>
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
		html += '<td width="10%"><form id="ajaxFrom" method="post" enctype="multipart/form-data"><input type="file" id="ajaxFile" />(용량제한 100MB)</form></td>'
		html += '</tr></table>'
		$("#complete_status_comment").html($("#complete_status_comment").html()+html)
	}

	function completeStatusCommentDel(seq){
		if (confirm("코멘트를 삭제하시겠습니까?") == true) {
			$.ajax({
				type: "POST",
				cache: false,
				url: "<?php echo site_url();?>/ajax/forcasting_complete_status_comment_delete",
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
				url: "<?php echo site_url();?>/ajax/forcasting_complete_status_comment_insert",
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
				url: "<?php echo site_url();?>/ajax/forcasting_complete_status_file_upload",
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
							url: "<?php echo site_url();?>/ajax/forcasting_complete_status_comment_insert",
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
				location.href = "<?php echo site_url(); ?>/forcasting/forcasting_complete_status_filedel/" + seq + "/" + filename;
				return false;
			}
		}
 	}

	//콤마제거
	function commaCheck(obj){
		if(($(obj).val()).indexOf(',') != -1){
			alert(', 를 입력하실 수 없습니다.');
			$(obj).val($(obj).val().replace(',',''));
		}
	}

    //test
    function modifyPopup(type){
        window.open("<?php echo site_url(); ?>/forcasting/forcasting_modify?seq=<?php echo $view_val['seq'] ;?>&type="+type,"","width = 1200, height = 500, scrollbars=1,resizable=yes");
    }
</script>
</body>
</html>
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
	.border_tbl {
		border: thin solid #DFDFDF;
	}
	.border_none_input{
	 width:90%;
	 border:none;
	 border-right:0px;
	 border-top:0px;
	 border-left:0px;
	 cell-trottom:0px;
	 font-weight:bold;
	 font-size:12px;
	}

	/* 첨부파일 */
	.box-file-input label{
	display:inline-block;
	background:#a9abac;
	color:#fff;
	padding:0px 15px;
	line-height:30px;
	cursor:pointer;
	border-radius: 3px;
 }

 .box-file-input label:after{
	content:"파일 선택";
 }

 .box-file-input .file-input{
	display:none;
 }

 .box-file-input .filename{
	display:inline-block;
	padding-left:10px;
 }

 .btn-file {
	 width:50px;
 }
 .btn-file-left {
	 float:left;
	 border: 1px solid #B6B6B6;
	 background: white;
	 color: #565656;
 }
 .btn-file-right {
	 /* right:0; */
	 float:right;
	 margin-right: 40px;
 }
 .file_span {
	 color: #B6B6B6;
	 max-width: 200px;
 }
</style>
<link rel="stylesheet" href="<?php echo $misc;?>css/view_page_common.css">
<script src="<?php echo $misc;?>js/excel/excel-bootstrap-table-filter-bundle.js"></script>
<link rel="stylesheet" href="<?php echo $misc;?>js/excel/excel-bootstrap-table-filter-style.css" />
<script language="javascript">
	function chkDel() {
		if (confirm("등록된 모든 코멘트들도 삭제됩니다. 정말 삭제하시겠습니까?") == true) {
			<?php
			if($complete_status_val){
			 	foreach($complete_status_val as $item){ ?>
					filedel('<?php echo $item['seq']; ?>','<?php echo $item['file_change_name']; ?>')
			<?php }} ?>
			location.href = "<?php echo site_url(); ?>/sales/forcasting/forcasting_delete_action?seq=<?php echo $seq; ?>";
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

		rform.action = "<?php echo site_url(); ?>/sales/forcasting/forcasting_comment_action";
		rform.submit();
		return false;
	}

	function chkForm3(seq) {
		if (confirm("정말 삭제하시겠습니까?") == true) {
			var rform = document.rform;
			rform.cseq.value = seq;
			rform.action = "<?php echo site_url(); ?>/sales/forcasting/forcasting_comment_delete";
			rform.submit();
			return false;
		}
	}
</script>

<body>
	<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
	?>
	<div align="center">
	<div class="dash1-1">
	<table width="96%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
		<tr>
			<td class="dash_title">수주완료</td>
		</tr>
		<tr>
			<td align="center" valign="top">

				<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td>
							<table style="float:right; width:50%;" class="border_tbl" border="0" cellspacing="0" cellpadding="0">
								<colgroup>
									<col width="18%">
									<col width="32%">
									<col width="18%">
									<col width="32%">
								</colgroup>
								<tr class="tbl-tr">
									<td class="tbl-title border-r">최초 작성자</td>
									<td class="tbl-cell border-r">
										<?php
										if ($writer!=''){
											echo $writer['user_name']."  ".$writer['update_date'];
										}
										?>
									</td>
									<td class="tbl-title border-r">마지막 수정자</td>
									<td class="tbl-cell">
										<?php
										if ($modifier==''){
											$modify_date = $view_val['update_date'];
											if ($view_val['insert_date']>$view_val['update_date']){
												$modify_date = $view_val['insert_date'];
											} else {
												$modify_date = $view_val['update_date'];
											}
											echo $modify_name['user_name']."  ".$modify_date;
										} else {
											echo $modifier['user_name']."  ".$modifier['update_date'];
										}
										?>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td width="100%" align="center" valign="top">
							<!--내용-->
							<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:50px; margin-bottom: 50px;">
								<tr>
									<td>
										<table width="100%" border="0" cellspacing="0" cellpadding="0" id="main_list">
												<input type="hidden" name="seq" value="<?php echo $seq; ?>">
												<colgroup>
													<col width="9%" />
													<col width="16%" />
													<col width="9%" />
													<col width="16%" />
													<col width="9%" />
													<col width="16%" />
													<col width="9%" />
													<col width="16%" />
												</colgroup>
												<tr>
                          <td class="tbl-sub-title" colspan="8">
														<span onclick="modifyPopup(1);" style="cursor:pointer">
														고객사 정보
														<img src="<?php echo $misc; ?>img/pencil_btn.png" width="15" height="15" style="margin-left:5px;"/>
														</span>
														<input type="button" style="float:right;" class="btn-common btn-color2" value="목록" onClick="javascript:history.go(-1)">
														<input type="button" style="float:right;margin-right:10px;" class="btn-common btn-color1" value="삭제" onclick="javascript:chkDel();return false;">
                          </td>
												</tr>
												<!--시작라인-->
												<tr class="tbl-tr cell-tr border-t">
													<td class="tbl-title">고객사</td>
													<td class="tbl-cell"><?php echo $view_val['customer_companyname']; ?></td>
													<td class="tbl-title">담당자</td>
													<td class="tbl-cell"><?php echo $view_val['customer_username']; ?></td>
													<td class="tbl-title">연락처</td>
													<td class="tbl-cell"><?php echo $view_val['customer_tel']; ?></td>
													<td class="tbl-title">이메일</td>
													<td class="tbl-cell"><?php echo $view_val['customer_email']; ?></td>
												</tr>
												<tr>
													<td height=30></td>
													<!-- 빈칸 -->
												</tr>
												<tr>
                          <td class="tbl-sub-title">
														<span onclick="modifyPopup(2);" style="cursor:pointer">
														영업 정보
														<img src="<?php echo $misc; ?>img/pencil_btn.png" width="15" height="15" style="margin-left:5px;"/>
														</span>
                          </td>
												</tr>
												<tr class="tbl-tr cell-tr border-t">
													<td class="tbl-title">프로젝트</td>
													<td class="tbl-cell" colspan="3"><?php echo $view_val['project_name']; ?></td>
													<td class="tbl-title">판매종류</td>
                          <td class="tbl-cell" <?php if($view_val['type']!="4"){echo "colspan='3'";} ?>>
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
													<td class="tbl-title">조달 판매금액(VAT포함)</td>
                          <td class="tbl-cell">
														<?php echo $view_val['procurement_sales_amount']; ?>
													</td>
													<?php }?>
												</tr>
												<tr class="tbl-tr cell-tr">
													<td class="tbl-title">진척단계</td>
                          <td colspan="7" class="tbl-cell">
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
                                                        else if ($view_val['progress_step'] == "013") {echo "Spec in(70%)";}
                                                        else if ($view_val['progress_step'] == "014") {echo "수의계약(80%)";}
                                                        else if ($view_val['progress_step'] == "015") {echo "수주완료(85%)";}
                                                        else if ($view_val['progress_step'] == "016") {echo "매출발생(90%)";}
                                                        else if ($view_val['progress_step'] == "017") {echo "미수잔금(95%)";}
														else if ($view_val['progress_step'] == "018") {echo "수금완료(100%)";}
														else if ($view_val['progress_step'] == "000") {echo "실주";}
													?>
                                                    </td>
												</tr>
												<tr class="tbl-tr cell-tr">
													<td class="tbl-title">영업업체</td>
                          <td class="tbl-cell">
                            <?php echo $view_val['cooperation_companyname']; ?>
													</td>
													<td class="tbl-title">영업담당자</td>
													<td class="tbl-cell"><?php echo $view_val['cooperation_username']; ?></td>
													<td class="tbl-title">사업부</td>
													<td class="tbl-cell" colspan="3"><?php echo $view_val['dept']; ?></td>
												</tr>
												<tr class="tbl-tr cell-tr">
													<td class="tbl-title">정보통신공사업</td>
                          <td class="tbl-cell" <?php if($view_val['type'] ==3){echo "colspan='7'";} ?>>
                      <?php if($view_val['infor_comm_corporation'] == "Y"){
															echo "신청";
														}else{
															echo "미신청";
														} ?>
													</td>
												<?php if($view_val['type'] !=3){ ?>
													<td class="tbl-title">품의서작성여부</td>
													<td class="tbl-cell" <?php if($view_val['type'] !=3){echo "colspan='5'";} ?>>
                      <?php if(empty($approval_doc)){
															echo "미작성";
														}else if($approval_doc['approval_doc_status'] == "001" ){
															echo "진행중";
														}else if($approval_doc['approval_doc_status'] == "002" ){
															echo "완료";
														}else if($approval_doc['approval_doc_status'] == "003" ){
															echo "반려";
														}else if($approval_doc['approval_doc_status'] == "004" ){
															echo "회수";
														}else if($approval_doc['approval_doc_status'] == "005" ){
															echo "임시저장";
														}else if($approval_doc['approval_doc_status'] == "006" ){
															echo "보류";
														}?>
														<?php if(empty($approval_doc) || $approval_doc['approval_doc_status'] != "002"){?>
															<input type="button" id="" style="cursor:pointer;margin-left:20px;width:100px;" value="품의서 작성" onclick="report_write('<?php echo $view_val['type']; ?>');" class="btn-common btn-style1">
														<?php }else if ($approval_doc['approval_doc_status'] == "002"){?>
															<input type="button" id="" style="cursor:pointer;margin-left:20px;width:100px;" value="품의서 보기" onclick="report_view('<?php echo $approval_doc['seq']; ?>');" class="btn-common btn-style1">
														<?php } ?>
													</td>
												<?php } ?>
												</tr>
												<tr>
													<td height=30></td>
												</tr>
												<tr id="input_point" class="tbl-tr cell-tr border-t">
													<td class="tbl-title">고객사총매출가</td>
													<td class="tbl-cell"><?php echo number_format($view_val['forcasting_sales']); ?></td>
													<td class="tbl-title">고객사총매입가</td>
													<td class="tbl-cell"><?php echo number_format($view_val['forcasting_purchase']); ?></td>
													<td class="tbl-title">고객사총마진</td>
													<td class="tbl-cell"><?php echo number_format($view_val['forcasting_profit']); ?></td>
													<td class="tbl-title">분할월수</td>
	                        <td colspan="3" class="tbl-cell">
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
												<tr class="tbl-tr cell-tr">
													<td class="tbl-title">최초 매출일</td>
													<td class="tbl-cell"><?php echo $view_val['first_saledate']; ?></td>
													<td class="tbl-title">예상 매출일</td>
													<td class="tbl-cell"><?php echo $view_val['exception_saledate']; ?></td>
													<td class="tbl-title">월별마진</td>
													<td class="tbl-cell">
														<?php if (substr($view_val['division_month'], 0, 1) === "m") {
															echo number_format($view_val['forcasting_profit'] / substr($view_val['division_month'], 1));
														} else {
															echo number_format($view_val['forcasting_profit'] / (12 / $view_val['division_month']));
														} ?>
													</td>
													<td class="tbl-title">발행월</td>
													<td class="tbl-cell">
														<select name="montly_f_p" id="montly_f_p" class="select-common">
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
												<tr class="tbl-tr cell-tr">
													<td class="tbl-title">무상보증 종료일</td>
													<td class="tbl-cell" colspan="7"><?php echo $view_val['warranty_end_date']; ?></td>
												</tr>
												<tr>
													<td height=30></td>
												</tr>
												<tr>
                          <td class="tbl-sub-title">
														<span onclick="modifyPopup(3);" style="cursor:pointer">
														매출처 정보
														<img src="<?php echo $misc; ?>img/pencil_btn.png" width="15" height="15" style="margin-left:5px;"/></span>
                          </td>
												</tr>
												<tr class="tbl-tr cell-tr border-t">
													<td class="tbl-title">매출처</td>
													<td class="tbl-cell"><?php echo $view_val['sales_companyname'];?></td>
													<td class="tbl-title">담당자</td>
													<td class="tbl-cell"><?php echo $view_val['sales_username']; ?></td>
													<td class="tbl-title">연락처</td>
													<td class="tbl-cell"><?php echo $view_val['sales_tel']; ?></td>
													<td class="tbl-title">이메일</td>
													<td class="tbl-cell"><?php echo $view_val['sales_email']; ?></td>
												</tr>
												<tr>
													<td height=30></td>
													<!-- 빈칸 -->
												</tr>
												<tr>
													<td class="tbl-sub-title">
														<span onclick="modifyPopup(4);" style="cursor:pointer">
														매입처 정보<img src="<?php echo $misc; ?>img/pencil_btn.png" width="15" height="15" style="margin-left:5px;"/>
														</span>
													</td>
												</tr>
												<?php
												$i = 0;
												$main_company_amount1 = 0;
												// ${"main_company_amount1".$i} = 0;
												foreach ($view_val2 as $item2) {
													${"main_company_amount".($i+1)} = 0;
													foreach ($view_val3 as $item3) {
														if($item3['product_supplier'] == $item2['main_companyname']){
															${"main_company_amount".($i+1)} += (int)$item3['product_purchase'];
														}
													}
												?>
													<tr id="main_insert_field_2_<?php echo $i; ?>" class="tbl-tr cell-tr border-t">
														<td class="tbl-title">매입처</td>
														<td class="tbl-cell"><?php echo $item2['main_companyname']; ?>
															<input name="main_seq" type="hidden" class="input7" id="main_seq" value="<?php echo $item2['seq']; ?>" />
														</td>
														<td class="tbl-title">담당자</td>
														<td class="tbl-cell"><?php echo $item2['main_username']; ?></td>
														<td class="tbl-title">연락처</td>
														<td class="tbl-cell"><?php echo $item2['main_tel']; ?></td>
														<td class="tbl-title">이메일</td>
														<td class="tbl-cell"><?php echo $item2['main_email']; ?></td>
													</tr>
												<?php
													$max_number = $i;
													$i++;
												}
												?>
												<input type="hidden" id="row_max_index" name="row_max_index" value="<?php echo $max_number; ?>" />

												<!-- <input type="hidden" id="row_max_index2" name="row_max_index2" value="<?php echo $max_number2; ?>" /> -->
												<tr>
													<td height=30></td>
													<!-- 빈칸 -->
												</tr>
												<tr>
													<td class="tbl-sub-title">
														<span onclick="modifyPopup(5);" style="cursor:pointer">
														제품 정보<img src="<?php echo $misc; ?>img/pencil_btn.png" width="15" height="15" style="margin-left:5px;"/>
														</span>
													</td>
												</tr>
												<tr>
													<td height="60" colspan="9" align="left"><span style='cursor:pointer;' onclick="productView(this);">제품 정보 보기 ▼</span></td>
												</tr>
												<tr id="product_field" style="display:none;">
													<td colspan="9">
														<img src="<?php echo $misc;?>/img/filter_refresh.png" onclick="filter_reset();" width=20 style="float:right;cursor:pointer;margin-bottom:5px;"/>
														<table id="product_table" style="min-width:100%;" border="0" cellspacing="0" cellpadding="0">
															<colgroup>
																<col width="3%" />
																<col width="8%" />
																<col width="10%" />
																<col width="7%" />
																<col width="10%" />
																<col width="10%" />
																<col width="10%" />
																<col width="8%" />
																<col width="9%" />
																<col width="9%" />
																<col width="9%" />
																<col width="7%" />
															</colgroup>
															<thead id="product_table_head">
															<tr bgcolor="F4F4F4" style="font-weight:bold;" class="tbl-tr cell-tr border-t">
																<th height="40" align="center">번호</th>
																<th align="center">제조사</th>
																<th align="center">매입처</th>
																<th align="center">하드웨어/소프트웨어</th>
																<th align="center">제품명</th>
																<th align="center">라이선스 수량</th>
																<th align="center">hardware/software<br>serial number</th>
																<th align="center">제품 상태</th>
																<th align="center">장비매출가</th>
																<th align="center">장비매입가</th>
																<th align="center">장비마진</th>
																<th align="center">비고</th>
															</tr>
															</thead>
															<tbody>
															<?php
															$j = 1;
															foreach ($view_val3 as $item3) {
															?>
																	<!--시작라인-->
																<tr class="tbl-tr cell-tr">
																	<td align="center"><?php echo $j; ?></td>
																	<td align="center"><?php echo $item3['product_company']; ?></td>
																	<td align="center"><?php echo $item3['product_supplier']; ?></td>
																	<td align="center">
																		<?php if($item3['product_type'] == "hardware"){
																					echo "하드웨어";
																			}else if($item3['product_type'] == "software"){
																				echo "소프트웨어";
																			}else if($item3['product_type'] == "software"){
																				echo "어플라이언스";
																			}else{
																				echo "전체" ;
																			}
																		?>
																	</td>
																	<td align="left">
																		<?php echo $item3['product_name'] ;?>
																	</td>
																	<td align="center"><?php echo $item3['product_licence']; ?></td>
																	<td align="center"><?php echo $item3['product_serial']; ?></td>
																	<td align="center" style="padding-left:10px;">
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
																	<td align="right" name="product_sales"><?php if(trim($item3['product_sales']) == ""){echo $item3['product_sales'];}else{echo number_format($item3['product_sales']);} ?></td>
																	<td align="right" name="product_purchase"><?php if(trim($item3['product_purchase']) == ""){echo $item3['product_purchase'];}else{echo number_format($item3['product_purchase']);} ?></td>
																	<td align="right" name="product_profit"><?php if(trim($item3['product_profit']) == ""){echo $item3['product_profit'];}else{echo number_format($item3['product_profit']);}?></td>
																	<td align="left" name="comment"><?php echo $item3['comment']; ?></td>
																</tr>
															<?php
															$max_number2 = $j;
															$j++;
															}
															?>
															</tbody>
														</table>
														<table id="filter_sales" style="min-width:100%;display:none;" border="0" cellspacing="0" cellpadding="0">
																<colgroup>
																	<col width="3%" />
																	<col width="8%" />
																	<col width="10%" />
																	<col width="7%" />
																	<col width="10%" />
																	<col width="10%" />
																	<col width="10%" />
																	<col width="8%" />
																	<col width="9%" />
																	<col width="9%" />
																	<col width="9%" />
																	<col width="7%" />
																</colgroup>
																	<tr height="40" align="center" bgcolor="F4F4F4" style="font-weight:bold;" class="tbl-tr cell-tr">
																		<td colspan=8></td>
																		<td>필터별총매출가</td>
																		<td>필터별총매입가</td>
																		<td>필터별총마진</td>
																		<td></td>
																	</tr>
																	<tr class="tbl-tr cell-tr">
																		<td colspan=8></td>
																		<td align="right" id="filter_forcasting_sales"><?php echo number_format($view_val['forcasting_sales']); ?></td>
																		<td align="right" id="filter_forcasting_purchase"><?php echo number_format($view_val['forcasting_purchase']); ?></td>
																		<td align="right" id="filter_forcasting_profit"><?php echo number_format($view_val['forcasting_profit']); ?></td>
																		<td></td>
																	</tr>
															</table>
															<table class="basic_table" style="min-width:100%;" border="0" cellspacing="0" cellpadding="0">
                                <colgroup>
																	<col width="3%" />
																	<col width="8%" />
																	<col width="10%" />
																	<col width="7%" />
																	<col width="10%" />
																	<col width="10%" />
																	<col width="10%" />
																	<col width="8%" />
																	<col width="9%" />
																	<col width="9%" />
																	<col width="9%" />
																	<col width="7%" />
																</colgroup>
															<tr height="40" align="center" bgcolor="F4F4F4" style="font-weight:bold;" class="tbl-tr cell-tr">
																<td colspan=8></td>
																<td>총매출가</td>
																<td>총매입가</td>
																<td>총마진</td>
																<td></td>
															</tr>
															<tr class="tbl-tr cell-tr">
																<td colspan=8 class="border-f"></td>
																<td align="right"><?php echo number_format($view_val['forcasting_sales']); ?></td>
																<td align="right"><?php echo number_format($view_val['forcasting_purchase']); ?></td>
																<td align="right"><?php echo number_format($view_val['forcasting_profit']); ?></td>
																<td></td>
															</tr>
                            </table>
													</td>
												</tr>

								<tr id="main_insert">
									<td height=30></td>
								</tr>
								<tr>
                  <td class="tbl-sub-title">
										<span onclick="modifyPopup(6);" style="cursor:pointer">
										수주 정보
										<img src="<?php echo $misc; ?>img/pencil_btn.png" width="15" height="15" style="margin-left:5px;"/></span>
                                    </td>
								</tr>
								<!--시작라인-->
								<tr class="tbl-tr cell-tr border-t">
									<td class="tbl-title">수주여부</td>
									<td colspan=8 class="tbl-cell">
                    <?php if ($view_val['complete_status'] == "001") {
                        echo "수주중";
                    }else if ($view_val['complete_status'] == "002") {
                        echo "수주완료";
                    } ?>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<!--//작성-->

					<tr>
						<td height="30"></td>
					</tr>

					<tr>
						<td>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td colspan="7" class="tbl-sub-title">수주 여부 코멘트</td>
								<td colspan="2">
									<div style='float:right;font-size:14px;'>코멘트 추가
										<img align="center" src="<?php echo $misc; ?>img/dashboard/dash_detail.svg" width="18" style="cursor:pointer;" border="0" onclick="completeStatusCommentAdd(this);">
									</div>
								</td>
							</tr>
							<tr>
							<!-- 여기서부터가 수주여부 코멘트 -->
								<td id ="complete_status_comment" colspan="8" align="left">
									<?php
									if($complete_status_val){
										$n = 1;
										foreach ($complete_status_val as $item) {
										?>
											<table id="completeStatusCommentAdd<?php echo $n; ?>" width="100%" border="0" cellspacing="0" cellpadding="0">
												<colgroup>
													<col width="9%"><col width="16%"><col width="9%"><col width="16%">
													<col width="9%"><col width="16%"><col width="9%"><col width="16%">
												</colgroup>
												<tr class="cell-tr border-t row-color1">
													<td class="tbl-title" height="25">
														<?php echo $item['user_name'];?>
													</td>
													<td class="tbl-cell tbl-mid" height="25">
														<?php echo substr($item['insert_date'], 0, 10);?>
													</td>
													<td class="tbl-cell" align="right" colspan="6" height="25">
														<?php if ($id == $item['user_id'] || $sales_lv == 3) { ?>
															<img src="<?php echo $misc;?>img/btn_del.svg" width="18" height="17" style="cursor:pointer" border="0" onclick="completeStatusCommentDel('<?php echo $item['seq'] ?>'); filedel('<?php echo $item['seq']; ?>','<?php echo $item['file_change_name']; ?>');"/>
														<?php }?>
													</td>
												</tr>
												<tr class="cell-tr">
													<td class="tbl-cell" height="40">
														<input type="hidden" id="comment_seq" value="<?php echo $item['seq']; ?>">
														<select style="width:95%" name="complete_status" id="complete_status" class="input-common" disabled>
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
													<td class="tbl-cell" colspan="6">
														<?php echo $item['contents']; ?>
													</td>
													<td class="tbl-cell" width="16%">
														<?php if($item['file_change_name']){ ?>
															<a href="<?php echo site_url(); ?>/sales/forcasting/complete_status_comment_download/<?php echo urlencode($item['file_real_name']); ?>/<?php echo $item['file_change_name']; ?>">
																<?php echo $item['file_real_name']; ?>
															</a>
															<img src="<?php echo $misc; ?>img/del.png" width="8" height="8" onclick="filedel('<?php echo $item['seq']; ?>','<?php echo $item['file_change_name']; ?>')"/>
														<?php } else { ?>
															<span class="point0 txt_s">첨부파일 없음
															<?php } ?>
													</td>
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
						<td height=50></td>
					</tr>
					<tr>
						<td class="tbl-sub-title">
							<span onclick="invoiceIssue(<?php echo $seq; ?>);" style="cursor:pointer">
							계산서 발행 정보
							<img src="<?php echo $misc; ?>img/pencil_btn.png" width="15" height="15" style="margin-left:5px;"/>
							</span>
						</td>
					</tr>
					<tr class="statement_table">
						<td colspan=10>
							<img src="<?php echo $misc;?>/img/filter_refresh.png" onclick="filter_reset('sales_statement_table');" width=20 style="float:right;cursor:pointer;margin:5px 5px;"/>
						</td>
					</tr>
					<tr>
						<td colspan="10" class="basic_td" height="40" align="center" bgcolor="DEDEDE" style="font-weight:bold;font-size:15px;">매출</td>
					</tr>
					<tr>
						<td colspan="10">
							<table id="sales_statement_table" width="100%" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
								<colgroup>
									<col width="8%" />
									<col width="3%" />
									<col width="3%" />
									<col width="7%" />
									<col width="8%" />
									<col width="8%" />
									<col width="8%" />
									<col width="16%" />
									<col width="7%" />
									<col width="10%" />
									<col width="7%" />
									<col width="10%" />
									<col width="5%" />
								</colgroup>
								<thead>
								<tr bgcolor="F4F4F4" height="40">
									<th colspan="2" class="basic_td apply-filter no-sort border-f" filter_column="1" style="font-weight:bold;">계약금액</th>
									<th class="basic_td apply-filter no-sort border-r" filter_column="2" style="font-weight:bold;">회차</th>
									<th class="basic_td apply-filter no-sort border-r" filter_column="3" style="font-weight:bold;">%</th>
									<th class="basic_td apply-filter no-sort border-r" filter_column="4" style="font-weight:bold;">발행금액</th>
									<th class="basic_td apply-filter no-sort border-r" filter_column="5" style="font-weight:bold;">세액</th>
									<th class="basic_td apply-filter no-sort border-r" filter_column="6" style="font-weight:bold;">합계</th>
									<th class="basic_td apply-filter no-sort border-r" filter_column="7" style="font-weight:bold;">국세청 승인번호
									</th>
									<th class="basic_td apply-filter no-sort border-r" filter_column="8" style="font-weight:bold;">발행월
									</th>
									<th class="basic_td apply-filter no-sort border-r" filter_column="9" style="font-weight:bold;">발행일자
									</th>
									<th class="basic_td apply-filter no-sort border-r" filter_column="10" style="font-weight:bold;">발행여부
									</th>
									<th class="basic_td apply-filter no-sort border-r" filter_column="11" style="font-weight:bold;">입금일자
									</th>
									<th class="basic_td apply-filter no-sort border-r" filter_column="12" style="font-weight:bold;">입금여부
									</th>
								</tr>
								<tr>
									<td colspan="13" height="1" bgcolor="#DFDFDF"></td>
								</tr>
								</thead>
								<tbody>
								<?php if(empty($bill_val) || $sales_cnt == 0){?>
									<tr class="insert_sales_bill cell-tr">
										<td id="sales_contract_total_amount" rowspan="1" colspan="2" class="border-f" height="40"
											align="center"><?php echo number_format($view_val['forcasting_sales']); ?></td>
										<td colspan=11 align="left" class="border-r" height="40">등록된 계산서가 없습니다.</td>
									</tr>
								<?php
								}
								if($sales_cnt > 0){
									$row = 1;
									foreach($bill_val as $bill){
										if($bill['type'] == "001"){//매출
											if($row == 1){
								?>
												<tr id="bill_<?php echo $bill['seq']; ?>" class="update_sales_bill tbl-tr cell-tr" <?php if($bill['issuance_status'] == "M"){echo "style='color:red;'";}?>>
													<td id="sales_contract_total_amount" rowspan="1" colspan="2" filter_column="1"  align="center" class="border-f"><?php echo number_format($view_val['forcasting_sales']); ?></td>
													<td height="40" class="border-r" align="center" filter_column="2"><?php echo $bill['pay_session']; ?></td>
													<td height="40" class="border-r" align="center" filter_column="3"><?php echo $bill['percentage']; ?> %</td>
													<td height="40" class="border-r sales_issuance_amount" align="right" filter_column="4" style="padding-right:7px;"><?php echo number_format($bill['issuance_amount']); ?></td>
													<td height="40" class="border-r sales_tax_amount" align="right" filter_column="5" style="padding-right:7px;"><?php echo number_format($bill['tax_amount']); ?></td>
													<td height="40" class="border-r sales_total_amount" align="right" filter_column="6" style="padding-right:7px;"><?php echo number_format($bill['total_amount']); ?></td>
													<td height="40" class="border-r" align="center" filter_column="7"><?php echo $bill['tax_approval_number']; ?></td>
													<td height="40" class="border-r" align="center" filter_column="8"><?php echo $bill['issuance_month']; ?></td>
													<td height="40" class="border-r" align="center" filter_column="9"><?php echo $bill['issuance_date']; ?></td>
													<td height="40" class="border-r" align="center" filter_column="10">
													<?php if($bill['issuance_status'] == "Y"){
														echo "완료";
													}else if ($bill['issuance_status'] == "N"){
														echo "미완료";
													}else if ($bill['issuance_status'] == "C"){
														echo "발행취소";
													}else if ($bill['issuance_status'] == "M"){
														echo "마이너스발행";
													}
													?>
													</td>
													<td height="40" class="border-r" align="center" filter_column="11"><?php echo $bill['deposit_date']; ?></td>
													<td height="40" class="border-r" align="center" filter_column="12">
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
												<tr id="bill_<?php echo $bill['seq']; ?>" class="update_sales_bill tbl-tr cell-tr" <?php if($bill['issuance_status'] == "M"){echo "style='color:red;'";}?> >
													<td height="40" class="border-r" align="center" filter_column="2" ><?php echo $bill['pay_session']; ?></td>
													<td height="40" class="border-r" align="center" filter_column="3" ><?php echo $bill['percentage']; ?> %</td>
													<td height="40" class="border-r sales_issuance_amount" align="right" filter_column="4" style="padding-right:7px;"><?php echo number_format($bill['issuance_amount']); ?></td>
													<td height="40" class="border-r sales_tax_amount" align="right" filter_column="5" style="padding-right:7px;"><?php echo number_format($bill['tax_amount']); ?></td>
													<td height="40" class="border-r sales_total_amount" align="right" filter_column="6" style="padding-right:7px;"><?php echo number_format($bill['total_amount']); ?></td>

													<td height="40" class="border-r" align="center" filter_column="7"><?php echo $bill['tax_approval_number']; ?></td>
													<td height="40" class="border-r" align="center" filter_column="8"><?php echo $bill['issuance_month']; ?></td>
													<td height="40" class="border-r" align="center" filter_column="9"><?php echo $bill['issuance_date']; ?></td>
													<td height="40" class="border-r" align="center" filter_column="10">
													<?php if($bill['issuance_status'] == "Y"){
														echo "완료";
													}else if ($bill['issuance_status'] == "N"){
														echo "미완료";
													}else if ($bill['issuance_status'] == "C"){
														echo "발행취소";
													}else if ($bill['issuance_status'] == "M"){
														echo "마이너스발행";
													}
													?>
													</td>
													<td height="40" class="border-r" align="center" filter_column="11"><?php echo $bill['deposit_date']; ?></td>
													<td height="40" class="border-r" align="center" filter_column="12">
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
								}?>
								<tr height="40" class="cell-tr" align="center" style="font-weight:bold;">
									<td colspan=2>합계</td>
									<td></td>
									<td></td>
									<td><input id="sum_sales_issuance_amount" value="" class="border_none_input" onchange="numberFormat(this);" style="text-align:right;" readonly/></td>
									<td><input id="sum_sales_tax_amount" class="border_none_input" value="" onchange="numberFormat(this);" style="text-align:right;" readonly/></td>
									<td><input id="sum_sales_total_amount" class="border_none_input" value="" onchange="numberFormat(this);" style="text-align:right;" readonly/></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								</tbody>
							</table>
						</td>
					</tr>
					<tr>
						<td colspan=10 height="30"></td>
					</tr>
					<tr>
						<td colspan=10>
							<img src="<?php echo $misc;?>/img/filter_refresh.png" onclick="filter_reset('purchase_statement_table');" width=20 style="float:right;cursor:pointer;margin-bottom:5px;"/>
						</td>
					</tr>
					<tr id="sales_issuance_amount_insert_line">
						<td colspan="10" height="40" align="center" bgcolor="DEDEDE" style="font-weight:bold;font-size:15px;">매입</td>
					</tr>
					<tr>
						<td>
							<table id="purchase_statement_table" width="100%" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
								<colgroup>
									<col width="10%" />
									<col width="10%" />
									<col width="3%" />
									<col width="5%" />
									<col width="7%" />
									<col width="7%" />
									<col width="7%" />
									<col width="16%" />
									<col width="5%" />
									<col width="10%" />
									<col width="5%" />
									<col width="10%" />
									<col width="5%" />
								</colgroup>
								<thead>
									<tr class="cell-tr">
										<th class="basic_td apply-filter no-sort" height="40" align="center" bgcolor="f8f8f9" filter_column="1" style="font-weight:bold;">업체</th>
										<th class="basic_td apply-filter no-sort" height="40" align="center" bgcolor="f8f8f9" filter_column="2" style="font-weight:bold;">계약금액</th>
										<th class="basic_td apply-filter no-sort" height="40" align="center" bgcolor="f8f8f9" filter_column="2" style="font-weight:bold;">회차</th>
										<th height="40" class="basic_td apply-filter no-sort" align="center" bgcolor="f8f8f9" filter_column="3" style="font-weight:bold;">%</th>
										<th height="40" class="basic_td apply-filter no-sort" align="center" bgcolor="f8f8f9" filter_column="4" style="font-weight:bold;">발행금액</th>
										<th height="40" class="basic_td apply-filter no-sort" align="center" bgcolor="f8f8f9" filter_column="5" style="font-weight:bold;">세액</th>
										<th height="40" class="basic_td apply-filter no-sort" align="center" bgcolor="f8f8f9" filter_column="6" style="font-weight:bold;">합계</th>
										<th height="40" class="basic_td apply-filter no-sort" align="center" bgcolor="f8f8f9" filter_column="7" style="font-weight:bold;">국세청 승인번호</th>
										<th height="40" class="basic_td apply-filter no-sort" align="center" bgcolor="f8f8f9" filter_column="8" style="font-weight:bold;">발행월</th>
										<th height="40" class="basic_td apply-filter no-sort" align="center" bgcolor="f8f8f9" filter_column="9" style="font-weight:bold;">발행일자</th>
										<th height="40" class="basic_td apply-filter no-sort" align="center" bgcolor="f8f8f9" filter_column="10" style="font-weight:bold;">발행여부</th>
										<th height="40" class="basic_td apply-filter no-sort" align="center" bgcolor="f8f8f9" filter_column="11" style="font-weight:bold;">입금일자</th>
										<th height="40" class="basic_td apply-filter no-sort" align="center" bgcolor="f8f8f9" filter_column="12" style="font-weight:bold;">입금여부</th>
									</tr>
								</thead>
								<tbody>
									<?php if(empty($bill_val) || $purchase_cnt == 0){?>
									<?php
									$num = 1;
									foreach ($view_val2 as $item2) {?>
									<tr class="purchase_tax_invoice<?php echo $num; ?> insert_purchase_bill cell-tr">
										<td height="40" class="purchase_contract_total_amount<?php echo $num; ?> basic_td"
											align="center"><?php echo $item2['main_companyname']; ?></td>
										<td id="purchase_contract_total_amount<?php echo $num; ?>" rowspan="1"
											class="purchase_contract_total_amount<?php echo $num; ?> basic_td" height="40"
											align="center"><?php echo number_format(${"main_company_amount".$num}); ?></td>
										<td height="40" colspan=11 class="basic_td" align="left">등록된 계산서가 없습니다.</td>
									</tr>
									<?php
									$num++;
									}?>
								<?php
								}
								if($purchase_cnt > 0){ ?>
								<?php
									$num = 1;
									foreach ($view_val2 as $item2) {
										$row2 = 1;
										foreach($bill_val as $bill){
											if($bill['type'] == "002"){//매입
											if($item2['main_companyname'] == $bill['company_name']){
											if($row2 == 1){
								?>
												<tr id="bill_<?php echo $bill['seq']; ?>" class="purchase_tax_invoice<?php echo $num; ?> update_purchase_bill cell-tr tbl-tr" <?php if($bill['issuance_status'] == "M"){echo "style='color:red;'";}?>>
													<td class="purchase_contract_total_amount<?php echo $num; ?>" align="center" filter_column="1"><?php echo $bill['company_name']; ?></td>
													<td id="purchase_contract_total_amount<?php echo $num; ?>" rowspan="1" class="purchase_contract_total_amount<?php echo $num; ?>" height="40" align="center" filter_column="2"><?php echo number_format(${"main_company_amount".$num}); ?></td>
													<td align="center" filter_column="3"><?php echo $bill['pay_session']; ?></td>
													<td align="center" filter_column="3"><?php echo $bill['percentage']; ?> %</td>
													<td class="purchase_issuance_amount<?php echo $num; ?>" align="right" filter_column="4" style="padding-right:7px;">
														<?php echo number_format($bill['issuance_amount']); ?>
													</td>
													<td class="purchase_tax_amount<?php echo $num; ?>" align="right" filter_column="5" style="padding-right:7px;">
														<?php echo number_format($bill['tax_amount']); ?>
													</td>
													<td class="purchase_total_amount<?php echo $num; ?>" align="right" filter_column="6" style="padding-right:7px;">
														<?php echo number_format($bill['total_amount']); ?>
													</td>
													<td align="center" filter_column="7"><?php echo $bill['tax_approval_number']; ?></td>
													<td align="center" filter_column="8"><?php echo $bill['issuance_month']; ?></td>
													<td align="center" filter_column="9"><?php echo $bill['issuance_date']; ?></td>
													<td align="center" filter_column="10">
													<?php if($bill['issuance_status'] == "Y"){
														echo "완료";
													}else if ($bill['issuance_status'] == "N"){
														echo "미완료";
													}else if ($bill['issuance_status'] == "C"){
														echo "발행취소";
													}else if ($bill['issuance_status'] == "M"){
														echo "마이너스발행";
													}
													?>
													</td>
													<td align="center" filter_column="11"><?php echo $bill['deposit_date'];?></td>
													<td align="center" filter_column="12">
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
												<tr id="bill_<?php echo $bill['seq']; ?>" class="purchase_tax_invoice<?php echo $num; ?> update_purchase_bill cell-tr tbl-tr" <?php if($bill['issuance_status'] == "M"){echo "style='color:red;'";}?>>
													<td align="center" filter_column="3"><?php echo $bill['pay_session']; ?></td>
													<td align="center" filter_column="3"><?php echo $bill['percentage']; ?> %</td>
													<td class="purchase_issuance_amount<?php echo $num; ?>" align="right" filter_column="4" style="padding-right:7px;"><?php echo number_format($bill['issuance_amount']); ?></td>
													<td class="purchase_tax_amount<?php echo $num; ?>" align="right" filter_column="5" style="padding-right:7px;"><?php echo number_format($bill['tax_amount']); ?></td>
													<td class="purchase_total_amount<?php echo $num; ?>" align="right" filter_column="6" style="padding-right:7px;"><?php echo number_format($bill['total_amount']); ?></td>

													<td align="center" filter_column="7"><?php echo $bill['tax_approval_number']; ?></td>
													<td align="center" filter_column="8"><?php echo $bill['issuance_month']; ?></td>
													<td align="center" filter_column="9"><?php echo $bill['issuance_date']; ?></td>
													<td align="center" filter_column="10">
													<?php if($bill['issuance_status'] == "Y"){
														echo "완료";
													}else if ($bill['issuance_status'] == "N"){
														echo "미완료";
													}else if ($bill['issuance_status'] == "C"){
														echo "발행취소";
													}else if ($bill['issuance_status'] == "M"){
														echo "마이너스발행";
													}
													?>
													</td>
													<td align="center" filter_column="11"><?php echo $bill['deposit_date']; ?></td>
													<td align="center" filter_column="12">
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
									}?>
									<tr height="40" class="cell-tr tbl-tr" align="center" style="font-weight:bold;">
										<td colspan=4><?php echo $item2['main_companyname']." "; ?>요약</td>
										<td><input id="sum_purchase_issuance_amount<?php echo $num; ?>" name ="sum_purchase_issuance_amount" value="" class="border_none_input" onchange="numberFormat(this);" style="text-align:right;" /></td>
										<td><input id="sum_purchase_tax_amount<?php echo $num; ?>" name ="sum_purchase_tax_amount" class="border_none_input" value="" onchange="numberFormat(this);"style="text-align:right;" /></td>
										<td><input id="sum_purchase_total_amount<?php echo $num; ?>" name ="sum_purchase_total_amount" class="border_none_input" value="" onchange="numberFormat(this);" style="text-align:right;" /></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
									<?php $num++;
								}
							}
								?>
									<tr height="40" class="cell-tr tbl-tr" align="center" style="font-weight:bold;">
										<td colspan="4" style="font-size:13px;">매입 총 합계</td>
										<td ><input id="t_sum_purchase_issuance_amount" name ="t_sum_purchase_issuance_amount" value="" class="border_none_input" onchange="numberFormat(this);" style="text-align:right;" /></td>
										<td ><input id="t_sum_purchase_tax_amount" name ="t_sum_purchase_tax_amount" class="border_none_input" value="" onchange="numberFormat(this);"style="text-align:right;" /></td>
										<td ><input id="t_sum_purchase_total_amount" name ="t_sum_purchase_total_amount" class="border_none_input" value="" onchange="numberFormat(this);" style="text-align:right;" /></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
								</tbody>
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
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<form name="rform" method="post">
									<input type="hidden" name="seq" value="<?php echo $seq; ?>">
									<input type="hidden" name="cseq" value="">
									<tr>
										<td class="tbl-sub-title">댓글</td>
									</tr>
									<?php
									foreach ($clist_val as $item) {
									?>
										<tr>
											<td bgcolor="f8f8f9">
												<table width="100%" border="0" cellspacing="0" cellpadding="5" style="border: thin solid #DFDFDF">
													<tr height="30px">
														<td width="100px" class="tbl-mid" style="border-right: thin solid #DFDFDF;">
															<?php echo $item['user_name'];?>
														</td>
														<td width="100px" class="tbl-mid" style="border-right: thin solid #DFDFDF;">
															<?php echo substr($item['insert_date'], 0, 10);?>
														</td>
														<td align="right">
															<?php if($id == $item['user_id'] or $sales_lv == 3) {?>
																<img src="<?php echo $misc;?>img/btn_del.svg" width="18" height="17" style="cursor:pointer" border="0" onClick="javascript:chkForm3('<?php echo $item['seq'] ?>');return false;"/>
															<?php }?>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td style="padding-left:40px;height:30px;border: thin solid #DFDFDF;border-top:none;">
												<?php echo nl2br(str_replace(" ", "&nbsp;", htmlspecialchars($item['contents'])))?>
											</td>
										</tr>
									<?php
									}
									?>
									<tr>
										<td>
											<table width="100%" border="0" cellspacing="0" cellpadding="5" style='border: thin solid #DFDFDF;'>
												<tr height="30px" class="row-color1">
													<td width="100px" class="tbl-mid" style="border-right: thin solid #DFDFDF;">
														<?php echo $name;?>
													</td>
													<td width="100px" class="tbl-mid" style="border-right: thin solid #DFDFDF;">
														<?php echo date("Y-m-d");?>
													</td>
													<td align="right"></td>
												</tr>
												<tr>
													<td class="answer2" colspan="3" align="center">
														<textarea name="comment" id="comment" rows="5" class="input_answer1" style="width:100%;"></textarea>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</form>
							</table>
							<div style="width:100%;">
								<input type="button" class="btn-common btn-style2" value="답변등록" onClick="javascript:chkForm2();return false;" style="float:right;margin-bottom:50px;width:90px;margin-top:20px;">
							</div>
						</table>
					<!--//댓글-->
				<!--//내용-->

			</td>

		</tr>

	</table>
	</td>
	</tr>
</table>
</div>
</div>
<!--하단-->
<?php include $this->input->server('DOCUMENT_ROOT') . "/include/sales_bottom.php"; ?>
<!--//하단-->
<script>
	get_sum_amount(0); // 매출총합

	for(var i=0; i<$("input[name=sum_purchase_issuance_amount]").length; i++){
		get_sum_amount(1,i+1);
	}


	function completeStatusCommentAdd(el){
		$(el).attr('onclick', '');
		var num;
		if($("#complete_status_comment>table:last").length == 0){
			num = 1;
		}else{
			num = Number($("#complete_status_comment>table:last").attr('id').replace('completeStatusCommentAdd',''))+1;
		}

		var html = '<table id="completeStatusCommentAdd'+num+'" width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:40px;">';
		// html += '<tr bgcolor="f8f8f9">';
		// html += '<td width="8%" class="answer"><?php echo $name; ?></td>';
		// html += '<td colspan="2" width="20%" align="right"><input type="image" src="<?php echo $misc; ?>img/btn_answer2.jpg" width="50" height="18" style="cursor:pointer" onclick="ajaxFileUpload('+num+');" /></td></tr>'
		// html += '<tr><td width="10%"><select id="comment_status" class="input5">';
		// html += '<option value="0" selected>-수주여부-</option><option value="001">수주중</option><option value="002">수주완료</option></select>';
		// html += '<td width="80%"><input type="text" id="comment_contents" value="" style="width:95%;"/></td>';
		// html += '<td width="10%"><form id="ajaxFrom" method="post" enctype="multipart/form-data"><input type="file" id="ajaxFile" />(용량제한 100MB)</form></td>'
		// html += '</tr>';
		html += '<tr class="tbl-tr cell-tr border-t">';
		html += '<td class="tbl-title" width="9%"><?php echo $name; ?></td>';
		html += '<td class="tbl-cell" width="16%"><select id="comment_status" class="select-common" style="width:95%">';
		html += '<option value="0" selected>-수주여부-</option><option value="001">수주중</option><option value="002">수주완료</option></select></td>';
		html += '<td class="tbl-cell" width="50%;"><input type="text" id="comment_contents" class="input-common" value="" style="width:95%;"/></td>';
		html += '<td class="tbl-cell" width="25%;padding-right:10px;" align="right">';
		html += '<div class="box-file-input s_file_input_box"><span style="margin-right:10px;" class="file_span">선택된 파일 없음(용량제한 100MB)</span><label>';
		html += '<form id="ajaxFrom" method="post" enctype="multipart/form-data"><input type="file" class="file-input" id="ajaxFile" onchange="file_change(this);" /></form>';
		html += '</label></div>'
		html += '</td></tr>';
		html += '</table>'
		html += '<div style="margin-top:10px;float:right;"><input type="button" style="width:100px;" class="btn-common btn-style2" value="답변등록" onclick="ajaxFileUpload('+num+');"></div>'
		$("#complete_status_comment").html($("#complete_status_comment").html()+html)
	}

	function completeStatusCommentDel(seq){
		if (confirm("코멘트를 삭제하시겠습니까?") == true) {
			$.ajax({
				type: "POST",
				cache: false,
				url: "<?php echo site_url();?>/sales/forcasting/forcasting_complete_status_comment_delete",
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
				url: "<?php echo site_url();?>/sales/forcasting/forcasting_complete_status_comment_insert",
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
				url: "<?php echo site_url();?>/sales/forcasting/forcasting_complete_status_file_upload",
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
							url: "<?php echo site_url();?>/sales/forcasting/forcasting_complete_status_comment_insert",
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
				location.href = "<?php echo site_url(); ?>/sales/forcasting/forcasting_complete_status_filedel/" + seq + "/" + filename;
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
        window.open("<?php echo site_url(); ?>/sales/forcasting/forcasting_modify?seq=<?php echo $view_val['seq'] ;?>&type="+type,"","height = 500, top = 100, left = 400, location = no,status=no,status=no,toolbar=no,scrollbars=no");
    }

	function check_add(btn,tableNum) {

		var rowspan;
		if(tr.children(":first").attr("rowSpan")==undefined){
		rowspan = 1;
		}else{
		rowspan = Number(tr.children(":first").attr("rowSpan"));
		}
		var rowspanChange =tr.children(":first").attr("rowspan",rowspan+1)
	}

	//계싼서 추가
	function addRow(insertLine,rowspanid,type){
		if(type == 0){
			//나머지 금액구하기
			var total_amount = Number($("#sales_contract_total_amount").text().replace(/\,/g,''));
			var remain_amount = total_amount;
			var row_num = $("input[name=sales_issuance_amount]").length+1;
			for(i=0; i<$("input[name=sales_issuance_amount]").length; i++){
				remain_amount -= Number($("input[name=sales_issuance_amount]").eq(i).val().replace(/\,/g,''));
			}

			if(remain_amount == 0){
				alert("총 발행 금액이 계약 금액과 일치합니다.")
				return false;
			}

			var html = '<tr><td height="40" class="basic_td" align="center"><input type="text" id="sales_percentage'+row_num+'" name="sales_percentage" class="input7" style="width:60%" value="" onchange="calculation_amount('+total_amount+',this,'+row_num+',0)" /> %</td>';
			html += '<td height="40" class="basic_td" align="right"><input type="text" id="sales_issuance_amount'+row_num+'" name="sales_issuance_amount" class="input7" style="text-align:right;" value="'+remain_amount+'" onchange="percentage('+total_amount+',this,'+row_num+',0); numberFormat(this);" /></td>';
			html += '<td height="40" class="basic_td" align="center"><input type="text" id="sales_issuance_month'+row_num+'" name="sales_issuance_month" class="input7" style="text-align:center;" readonly/></td>';
			html += '<td height="40" class="basic_td" align="center"><input type="date" id="sales_issuance_date'+row_num+'" name="sales_issuance_date" class="input7" onchange="issuance_date_change(this,'+row_num+',0);" /></td>';
			html += '<td height="40" class="basic_td" align="center"><input type="hidden" id="sales_issuance_status'+row_num+'" name="sales_issuance_status" class="input7" value="N" /><span id="sales_issuance_YN'+row_num+'">미완료</span></td>';
			html += '<td height="40" class="basic_td" align="center"><input type="date" id="sales_deposit_date'+row_num+'" name="sales_deposit_date" class="input7" onchange="deposit_date_change(this,'+row_num+',0);"/></td>';
			html += '<td height="40" class="basic_td" align="center"><input type="hidden" id="sales_deposit_status'+row_num+'" name="sales_deposit_status" class="input7" value="N" /><span id="sales_deposit_YN'+row_num+'">미완료</span></td>';
			html += '<td height="40" class="basic_td" align="center"><img src="<?php echo $misc; ?>img/btn_del0.jpg" onclick="deleteRow(this,'+"'sales_contract_total_amount'"+',0);"/></td></tr>';


			var rowspan = Number($("#"+rowspanid).attr("rowspan"));
			$("#"+rowspanid).attr("rowSpan",rowspan+1);

			$("#"+insertLine).before(html);
			$("#sales_issuance_amount"+row_num).trigger('change');
		}else{
			//나머지 금액구하기
			var row_num = insertLine.replace('purchase_tax_invoice','');
			var total_amount = Number($("#purchase_contract_total_amount"+row_num).text().replace(/\,/g,''));
			var remain_amount = total_amount;
			var eq = $(".purchase_issuance_amount"+row_num).length;
			for(i=0; i<$(".purchase_issuance_amount"+row_num).length; i++){
				remain_amount -= Number($(".purchase_issuance_amount"+row_num).eq(i).val().replace(/\,/g,''));
			}

			if(remain_amount == 0){
				alert("총 발행 금액이 계약 금액과 일치합니다.")
				return false;
			}

			var html = '<tr class="purchase_tax_invoice'+row_num+'"><td height="40" class="basic_td" align="center"><input type="text" class="purchase_percentage'+row_num+' input7" name="sales_percentage" style="width:60%" value="" onchange="calculation_amount('+total_amount+',this,'+row_num+',1)" /> %</td>';
			html += '<td height="40" class="basic_td" align="right"><input type="text" class="purchase_issuance_amount'+row_num+' input7" name="sales_issuance_amount" style="text-align:right;" value="'+remain_amount+'" onchange="percentage('+total_amount+',this,'+row_num+',1); numberFormat(this);" /></td>';
			html += '<td height="40" class="basic_td" align="center"><input type="text" class="purchase_issuance_month'+row_num+' input7" name="sales_issuance_month" style="text-align:center;" readonly/></td>';
			html += '<td height="40" class="basic_td" align="center"><input type="date" class="purchase_issuance_date'+row_num+' input7" name="sales_issuance_date" onchange="issuance_date_change(this,'+row_num+',1);" /></td>';
			html += '<td height="40" class="basic_td" align="center"><input type="hidden" class="purchase_issuance_status'+row_num+' input7" name="sales_issuance_status" value="N" /><span class="purchase_issuance_YN'+row_num+'">미완료</span></td>';
			html += '<td height="40" class="basic_td" align="center"><input type="date" class="purchase_deposit_date'+row_num+' input7" name="sales_deposit_date" onchange="deposit_date_change(this,'+row_num+',1);"/></td>';
			html += '<td height="40" class="basic_td" align="center"><input type="hidden" class="purchase_deposit_status'+row_num+' input7" name="sales_deposit_status" value="N" /><span class="purchase_deposit_YN'+row_num+'">미완료</span></td>';
			html += '<td height="40" class="basic_td" align="center"><img src="<?php echo $misc; ?>img/btn_del0.jpg" onclick="deleteRow(this,'+"'purchase_contract_total_amount"+row_num+"'"+',1);"/></td></tr>';


			var rowspan = Number($("#"+rowspanid).attr("rowspan"));
			$("."+rowspanid).attr("rowSpan",rowspan+1);

			$("."+insertLine).eq($("."+insertLine).length-1).after(html);
			$(".purchase_issuance_amount"+row_num).eq(eq).trigger('change');
		}
	}
	//delete row
	function deleteRow(obj,rowspanid,type){
		if(type == 0){
			var tr = $(obj).parent().parent();
			tr.remove();
			var rowspan = Number($("#"+rowspanid).attr("rowspan"));
			$("#"+rowspanid).attr("rowSpan",rowspan-1);
		}else{
			var tr = $(obj).parent().parent();
			tr.remove();
			var rowspan = Number($("#"+rowspanid).attr("rowspan"));
			$("."+rowspanid).attr("rowSpan",rowspan-1);
		}
	}

	//금액으로 퍼센트 구하기
	function percentage(total_amount,obj,num,type){
		if(type == 0 ){
			var val = $(obj).val().replace(/\,/g,'');
			$("#sales_percentage"+num).val(val/total_amount*100);
		}else{
			var className = trim($(obj).attr('class').replace('input7',''));
			var eq = $('.'+className).index(obj);
			var val =$(obj).val().replace(/\,/g,'');
			$(".purchase_percentage"+num).eq(eq).val(val/total_amount*100);
		}
	}

	//퍼센트로 금액 구하기
	function calculation_amount(total_amount,obj,num,type){
		if(type == 0){
			var val = total_amount * Number($(obj).val()) /100;
			val = String(val).replace(/(\d)(?=(?:\d{3})+(?!\d))/g, "$1,");
			$("#sales_issuance_amount"+num).val(val);
		}else{
			var className = trim($(obj).attr('class').replace('input7',''));
			var eq = $('.'+className).index(obj);
			var val = total_amount * Number($(obj).val()) /100;
			val = String(val).replace(/(\d)(?=(?:\d{3})+(?!\d))/g, "$1,");
			$(".purchase_issuance_amount"+num).eq(eq).val(val);
		}

	}

	//금액 천단위 마다 ,
	function numberFormat(obj) {
		if(obj.value == ""){
			obj.value = 0;
		}
		var inputNumber = obj.value.replace(/,/g, "");
		var fomatnputNumber = inputNumber.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, "$1,");
		obj.value= fomatnputNumber;
	}

	//발행일자 change
	function issuance_date_change(obj,num,type){
		if(type == 0){
			var val = $(obj).val();
			val = val.substring(0,val.length-3);
			$('#sales_issuance_month'+num).val(val);
			$("#sales_issuance_status"+num).val("Y");
			$("#sales_issuance_YN"+num).text("완료")
		}else{
			var className = trim($(obj).attr('class').replace('input7',''));
			var eq = $('.'+className).index(obj);
			var val = $(obj).val();
			val = val.substring(0,val.length-3);

			$('.purchase_issuance_month'+num).eq(eq).val(val);
			$(".purchase_issuance_status"+num).eq(eq).val("Y");
			$(".purchase_issuance_YN"+num).eq(eq).text("완료")
		}


	}

	//입금일자 change
	function deposit_date_change(obj,num,type){
		if(type == 0){
			$("#sales_deposit_status"+num).val("Y");
			$("#sales_deposit_YN"+num).text("완료");
		}else{
			var className = trim($(obj).attr('class').replace('input7',''));
			var eq = $('.'+className).index(obj);
			$(".purchase_deposit_status"+num).eq(eq).val("Y");
			$(".purchase_deposit_YN"+num).eq(eq).text("완료");
		}

	}

	function invoiceIssue(seq){
		window.open("<?php echo site_url(); ?>/sales/forcasting/order_completed_modify?seq="+seq,"","width = 2000, height = 500, top = 100, left = 400, location = no,status=no,status=no,toolbar=no,scrollbars=no");
	}

	//필터적용햇을때 돈계싼
	function filter_profit_change(){
		var forcasting_sales = 0;
		var forcasting_purchase = 0;
		var forcasting_profit = 0;
		for (i = 0; i <$("td[name=product_sales]").length; i++) {
			if($("td[name=product_sales]").eq(i).parent().css('display') !== 'none' && $("td[name=product_sales]").eq(i).css('display') !== 'none' ){
				forcasting_sales +=  parseInt($("td[name=product_sales]").eq(i).text().replace(/,/g, ""));
				forcasting_purchase += parseInt($("td[name=product_purchase]").eq(i).text().replace(/,/g, ""));
				forcasting_profit += parseInt($("td[name=product_profit]").eq(i).text().replace(/,/g, ""));
			}
			$("#filter_forcasting_sales").text(String(forcasting_sales).replace(/(\d)(?=(?:\d{3})+(?!\d))/g, "$1,"));
			$("#filter_forcasting_purchase").text(String(forcasting_purchase).replace(/(\d)(?=(?:\d{3})+(?!\d))/g, "$1,"));
			$("#filter_forcasting_profit").text(String(forcasting_profit).replace(/(\d)(?=(?:\d{3})+(?!\d))/g, "$1,"));
		}
		$("#filter_sales").show();

	}

	//엑셀필터 적용
    $(function () {
      // Apply the plugin
      $('#product_table').excelTableFilter({
		captions :{a_to_z: '오름차순',
        z_to_a: '내림차순',
        search: 'Search',
        select_all: '전체'}
	  });

	  $('#sales_statement_table').excelTableFilter({
		columnSelector: '.apply-filter',
		captions :{a_to_z: '오름차순',
        z_to_a: '내림차순',
        search: 'Search',
        select_all: '전체'}
	  });

	  $('#purchase_statement_table').excelTableFilter({
		columnSelector: '.apply-filter',
		captions :{a_to_z: '오름차순',
        z_to_a: '내림차순',
        search: 'Search',
        select_all: '전체'}
	  });
    });

	//엑셀필터 초기화
	function filter_reset(){
		$(".오름차순:first").trigger("click");
		$(".select-all:not(:checked)").trigger("click");

		for (i = 0; i <$("td[name=product_sales]").length; i++) {
			$("td[name=product_sales]").eq(i).parent().show();
		}
		$("#filter_sales").hide();
	}

	//제품 폴딩
	function productView(obj){
		if($(obj).html().indexOf("▼") !== -1){
			$(obj).html("제품 정보 닫기 ▲");
		}else{
			$(obj).html("제품 정보 보기 ▼");
		}
		$("#product_field").toggle();
	}

	//품의서 쓰러가기
	function report_write(type){
	    var form_seq = "";
		switch (type) {//2 용역 ,3 유지보수 ,4조달 ,0선택없음
			case "4": //조달
				form_seq = 38;
				break;
			case "1": //상품
				form_seq = 32;
				break;
			case "2":
				form_seq = 39;
				break;
			default:
				return false;
		}
		location.href="<?php echo site_url(); ?>/biz/approval/electronic_approval_doc_input?seq="+form_seq+"&sales_seq=<?php echo $seq;?>";
	}

	function report_view(doc_seq){
		location.href="<?php echo site_url(); ?>/biz/approval/electronic_approval_doc_view?seq="+doc_seq+"&type=completion";
	}

	//총 합!
	function get_sum_amount(type,row){
		var issuance_amount = 0;
		var tax_amount = 0;
		var total_amount =  0;
		if(type == 0){ //매출
			for(var i=0; i<$(".sales_issuance_amount").length; i++){
				if($(".sales_issuance_amount").eq(i).is(":visible")){
					issuance_amount += Number($(".sales_issuance_amount").eq(i).text().replace(/,/g, ""));
					tax_amount += Number($(".sales_tax_amount").eq(i).text().replace(/,/g, ""));
					total_amount += Number($(".sales_total_amount").eq(i).text().replace(/,/g, ""));
				}
			}
			$("#sum_sales_issuance_amount").val(issuance_amount);
			$("#sum_sales_issuance_amount").change();
			$("#sum_sales_tax_amount").val(tax_amount);
			$("#sum_sales_tax_amount").change();
			$("#sum_sales_total_amount").val(total_amount);
			$("#sum_sales_total_amount").change();
		}else{ //매입
			for(var i=0; i<$(".purchase_issuance_amount"+row).length; i++){
				if($(".purchase_issuance_amount"+row).eq(i).is(":visible")){
					issuance_amount += Number($(".purchase_issuance_amount"+row).eq(i).text().replace(/,/g, ""));
					tax_amount += Number($(".purchase_tax_amount"+row).eq(i).text().replace(/,/g, ""));
					total_amount += Number($(".purchase_total_amount"+row).eq(i).text().replace(/,/g, ""));
				}
			}
			$("#sum_purchase_issuance_amount"+row).val(issuance_amount);
			$("#sum_purchase_issuance_amount"+row).change();
			$("#sum_purchase_tax_amount"+row).val(tax_amount);
			$("#sum_purchase_tax_amount"+row).change();
			$("#sum_purchase_total_amount"+row).val(total_amount);
			$("#sum_purchase_total_amount"+row).change();

			var t_issuance_amount = 0;
			var t_tax_amount = 0;
			var t_total_amount =  0;
			for(var i=0; i < $("input[name=sum_purchase_issuance_amount]").length; i++){
				t_issuance_amount += Number($("input[name=sum_purchase_issuance_amount]").eq(i).val().replace(/,/g, ""));
				t_tax_amount += Number($("input[name=sum_purchase_tax_amount]").eq(i).val().replace(/,/g, ""));
				t_total_amount += Number($("input[name=sum_purchase_total_amount]").eq(i).val().replace(/,/g, ""));
			}
			$("#t_sum_purchase_issuance_amount").val(t_issuance_amount);
			$("#t_sum_purchase_issuance_amount").change();
			$("#t_sum_purchase_tax_amount").val(t_tax_amount);
			$("#t_sum_purchase_tax_amount").change();
			$("#t_sum_purchase_total_amount").val(t_total_amount);
			$("#t_sum_purchase_total_amount").change();

		}
	}

	function numberFormat(obj) {
		if (obj.value == "") {
			obj.value = 0;
		}
		var inputNumber = obj.value.replace(/,/g, "");
		var fomatnputNumber = inputNumber.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, "$1,");
		obj.value = fomatnputNumber;
	}

	function file_change(el) {
		var filename = $(el).val().replace(/.*(\/|\\)/, '');
	  if(filename == "") {
	    filename = "파일을 선택해주세요.";
		}
	  $(el).closest("div").find(".file_span").text(filename);
	}

</script>
</body>
</html>

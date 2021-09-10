<?php
include $this->input->server('DOCUMENT_ROOT') . "/include/base.php";
include $this->input->server('DOCUMENT_ROOT') . "/include/sales_top.php";
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
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" /> -->
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
	<table width="94%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
		<tr>
			<td class="dash_title">
			<?php if($view_val['progress_step'] != '000'){
				echo "포캐스팅";
			}else{
				echo "실주";
			}?>
			</td>
		</tr>
		<tr>
			<td align="center" valign="top">
				<!--내용-->
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
									<td class="tbl-title border-r">마지막 작성자</td>
									<td class="tbl-cell border-r">
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
							<table width="100%" border="0" cellspacing="0" cellpadding="0" id="main_list" style="margin-top:50px; margin-bottom: 50px;">
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
										<td colspan="3" class="tbl-cell"><?php echo $view_val['project_name']; ?></td>
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
                    <td class="tbl-cell" <?php if($view_val['progress_step'] != "000"){echo "colspan='7'";}else{echo "colspan='3'";}?>>
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
										<?php if($view_val['progress_step'] == "000"){?>
											<td class="tbl-title">실주사유</td>
											<td class="tbl-cell" colspan="3">
												<?php echo $view_val['mistake_order_reason'];?>
											</td>
										<?php } ?>
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
                    <td class="tbl-cell" colspan="7">
                <?php if($view_val['infor_comm_corporation'] == "Y"){
												echo "신청";
											}else{
												echo "미신청";
											} ?>
										</td>
									</tr>
									<tr>
										<td height=30></td>
									</tr>
									<tr>
                    <td class="tbl-sub-title">
                      <span onclick="modifyPopup(3);" style="cursor:pointer">매출처 정보
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
									<?php
									$i = 0;
									foreach ($view_val2 as $item2) {
										if ($i == 0) {
									?>
											<tr>
												<td height=30></td>
												<!-- 빈칸 -->
											</tr>
											<tr>
                        <td class="tbl-sub-title">
                          <span onclick="modifyPopup(4);" style="cursor:pointer">
													매입처 정보
													<img src="<?php echo $misc; ?>img/pencil_btn.png" width="15" height="15" style="margin-left:5px;"/></span>
                        </td>
											</tr>
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
										} else {
										?>
											<tr id="main_insert_field_2_<?php echo $i; ?>" class="tbl-tr cell-tr">
												<td class="tbl-title">매입처</td>
                        <td class="tbl-cell">
                    <?php echo $item2['main_companyname']; ?>
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
										}
										$max_number = $i;
										$i++;
									}
									?>
									<tr id="main_insert">
										<td height=30></td>
									</tr>
									<tr>
										<td colspan="8" class="tbl-sub-title">
											<span onclick="modifyPopup(5);" style="cursor:pointer">제품 정보
											<img src="<?php echo $misc; ?>img/pencil_btn.png" width="15" height="15" style="margin-left:5px;"/></span>
											<img src="<?php echo $misc;?>/img/filter_refresh.png" onclick="filter_reset();" width=20 style="float:right;cursor:pointer;"/>
										</td>
									</tr>
									<input type="hidden" id="row_max_index" name="row_max_index" value="<?= $max_number ?>" />
									<tr id="product_field" >
										<td colspan="9" style="max-width:100%;">
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
                              <th align="center" >번호</th>
                              <th align="center" >제조사</th>
                              <th align="center" >매입처</th>
                              <th align="center" >하드웨어/소프트웨어</th>
                              <th align="center" >제품명</th>
                              <th align="center" >라이선스 수량</th>
                              <th align="center" >hardware/software<br>serial number</th>
                              <th align="center" >제품 상태</th>
                              <th align="center" >장비매출가</th>
                              <th align="center" >장비매입가</th>
                              <th align="center" >장비마진</th>
															<th align="center" >비고</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php
                          $j = 1;
                          $i = 0;
                          foreach ($view_val3 as $item3) {
                              // if ($j == 1) {
                          ?>
                                  <!--시작라인-->
                            <tr class="tbl-tr cell-tr">
	                            <td align="center" ><?php echo $j; ?></td>
	                            <td align="center" ><?php echo $item3['product_company']; ?></td>
	                            <td align="center" ><?php echo $item3['product_supplier']; ?></td>
	                            <td align="center" >
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
	                            <td align="left" >
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
	                            <td align="left"><?php echo $item3['comment'];?></td>
														</tr>
				                    <?php
				                    $max_number2 = $j;
				                    $j++;
				                    $i++;
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
                            <td >총매출가</td>
                            <td >총매입가</td>
                            <td >총마진</td>
														<td></td>
                          </tr>
                          <tr class="tbl-tr cell-tr">
														<td colspan=8 class="border-f"></td>
                            <td align="right" ><?php echo number_format($view_val['forcasting_sales']); ?></td>
                            <td align="right" ><?php echo number_format($view_val['forcasting_purchase']); ?></td>
                            <td align="right" ><?php echo number_format($view_val['forcasting_profit']); ?></td>
														<td></td>
													</tr>
                        </table>
											</td>
										</tr>
										<input type="hidden" id="row_max_index2" name="row_max_index2" value="<?php echo $max_number2; ?>" />
										<tr>
											<td colspan="9" height="20" ></td>
										</tr>
										<tr id="input_point" class="tbl-tr cell-tr border-t">
											<td class="tbl-title">분할월수</td>
		                  <td class="tbl-cell">
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
										<td class="tbl-title">해당월</td>
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
										<td class="tbl-title">월별마진</td>
										<td class="tbl-cell" colspan="3">
											<?php if (substr($view_val['division_month'], 0, 1) === "m") {
												echo number_format($view_val['forcasting_profit'] / substr($view_val['division_month'], 1));
											} else {
												echo number_format($view_val['forcasting_profit'] / (12 / $view_val['division_month']));
											} ?>
										</td>
									</tr>
									<tr class="tbl-tr cell-tr">
										<td class="tbl-title">최초 매출일</td>
										<td class="tbl-cell"><?php echo $view_val['first_saledate']; ?></td>
										<td class="tbl-title">예상 매출일</td>
										<td class="tbl-cell"><?php echo $view_val['exception_saledate']; ?></td>
										<td class="tbl-title">무상보증 종료일</td>
										<td class="tbl-cell" colspan="3"><?php echo $view_val['warranty_end_date']; ?></td>
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
											<div style='float:right;'>코멘트 추가
												<img align="center" src="<?php echo $misc; ?>img/dashboard/dash_detail.svg" width="18" style="cursor:pointer;" border="0" onclick="completeStatusCommentAdd();">
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
											<table id="completeStatusCommentAdd<?php echo $n; ?>" class="update_complete_status_comment" width="100%" border="0" cellspacing="0" cellpadding="0">
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
													<?php if ($id == $item['user_id'] || $sales_lv == 3) { ?>
														<img src="<?php echo $misc; ?>img/btn_del.jpg" width="18" height="17" style="cursor:pointer" border="0" onclick="javascript:chkForm3('<?php echo $item['seq'] ?>');return false;" />
													<?php } ?>
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td style="padding-left:40px;height:30px;border: thin solid #DFDFDF;border-top:none;">
										<?php echo nl2br(str_replace(" ", "&nbsp;", htmlspecialchars($item['contents']))) ?>
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
						<input type="button" class="btn-common btn-style2" value="답변등록" onclick="javascript:chkForm2();return false;" style="float:right;margin-bottom:50px;width:90px;margin-top:20px;">
					</div>
					<!--//댓글-->
				</table>
				<!--//내용-->

			</td>

		</tr>
</div>
</div>
<!--하단-->
<?php include $this->input->server('DOCUMENT_ROOT') . "/include/sales_bottom.php"; ?>
<!--//하단-->
<script>
	function completeStatusCommentAdd(){
		var num;
		if($("#complete_status_comment>table:last").length == 0){
			num = 1;
		}else{
			num = Number($("#complete_status_comment>table:last").attr('id').replace('completeStatusCommentAdd',''))+1;
		}

		var html = '<table id="completeStatusCommentAdd'+num+'" width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:40px;">';
		//
		// html += '<td width="8%" class="answer"><?php echo $name; ?></td>';
		// html += '<td colspan="2" width="20%" align="right"><input type="image" src="<?php echo $misc; ?>img/btn_answer2.jpg" width="50" height="18" style="cursor:pointer" onclick="ajaxFileUpload('+num+');" /></td></tr>'
		// html += '<tr><td width="10%"><select id="comment_status" class="input5">';
		// html += '<option value="0" selected>-수주여부-</option><option value="001">수주중</option><option value="002">수주완료</option></select>';
		// html += '<td width="80%"><input type="text" id="comment_contents" value="" style="width:95%;"/></td>';
		// html += '<td width="10%"><form id="ajaxFrom" method="post" enctype="multipart/form-data"><input type="file" id="ajaxFile" />(용량제한 100MB)</form></td>';
		// html += '</tr></table>';

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
        window.open("<?php echo site_url(); ?>/sales/forcasting/forcasting_modify?seq=<?php echo $view_val['seq'] ;?>&type="+type,"","height = 500, scrollbars=1,resizable=yes");
    }

	//필터적용햇을때 돈계싼
	function filter_profit_change(){
		console.log("돈!");
		var forcasting_sales = 0;
		var forcasting_purchase = 0;
		var forcasting_profit = 0;

		for (var i = 0; i <$("td[name=product_sales]").length; i++) {
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

<?php
include $this->input->server('DOCUMENT_ROOT') . "/include/base.php";
include $this->input->server('DOCUMENT_ROOT') . "/include/sales_top.php";
$sales_total_issuance_amount = 0;
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
.layerpop {
		display: none;
		z-index: 1000;
		border: 2px solid #ccc;
		background: #fff;
		/* cursor: move;  */
		cursor: default;
	 }

.layerpop_area .modal_title {
		padding: 30px 10px 0px 20px;
		/* border: 0px solid #aaaaaa; */
		font-size: 20px;
		font-weight: bold;
		line-height: 24px;
		text-align: left !important;
	 }

.layerpop_area .layerpop_close {
		width: 25px;
		height: 25px;
		display: block;
		position: absolute;
		top: 10px;
		right: 10px;
		background: transparent url('btn_exit_off.png') no-repeat;
	}

.layerpop_area .layerpop_close:hover {
		background: transparent url('btn_exit_on.png') no-repeat;
		cursor: pointer;
	}

.layerpop_area .content {
		width: 96%;
		margin: 2%;
		color: #828282;
	}

</style>
<link rel="stylesheet" href="<?php echo $misc;?>css/view_page_common.css">
<script src="<?php echo $misc;?>js/excel/excel-bootstrap-table-filter-bundle.js"></script>
<script type="text/javascript" src="/misc/js/jquery.bpopup-0.1.1.min.js"></script>
<link rel="stylesheet" href="<?php echo $misc;?>js/excel/excel-bootstrap-table-filter-style.css" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script language="javascript">
	function chkDel() {
		if (confirm("등록된 모든 코멘트들도 삭제됩니다. 정말 삭제하시겠습니까?") == true) {
			<?php
			if($complete_status_val){
			 	foreach($complete_status_val as $item){ ?>
					filedel('<?php echo $item['seq']; ?>','<?php echo $item['file_change_name']; ?>')
			<?php }} ?>
			var mform = document.cform;
			mform.action = "<?php echo site_url(); ?>/sales/maintain/maintain_delete_action";
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

		rform.action = "<?php echo site_url(); ?>/sales/maintain/maintain_comment_action";
		rform.submit();
		return false;
	}

	function chkForm3(seq) {
		if (confirm("정말 삭제하시겠습니까?") == true) {
			var rform = document.rform;
			rform.cseq.value = seq;
			rform.action = "<?php echo site_url(); ?>/sales/maintain/maintain_comment_delete";
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
	<!-- 타이틀 이미지 -->
	<tr>
		<td class="dash_title">
		<?php if($_GET['type']=='003') { ?>
			유지보수 포캐스팅
		<?php } else { ?>
			유지보수
		<?php } ?>
		</td>
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
										if (isset($modify_name['user_name'])) {
											echo $modify_name['user_name']."  ".$modify_date;
										}
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
							<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:50px; margin-bottom: 50px;">
								<tr>
									<td>
										<table width="100%" border="0" cellspacing="0" cellpadding="0" id="main_list">
											<tr>
												<td class="tbl-sub-title" colspan="10">
													<span onclick="modifyPopup(1);" style="cursor:pointer">
													고객사 정보
													<img src="<?php echo $misc; ?>img/pencil_btn.png" width="15" height="15" style="margin-left:5px;"/>
													</span>
													<input type="button" class="btn-common btn-color2" value="목록" onClick="javascript:history.go(-1)" style="float:right;"/>
								<?php if(empty($approval_doc) || ($approval_doc['approval_doc_status'] != "001" && $approval_doc['approval_doc_status'] != "002")) { ?>
													<input type="button" class="btn-common btn-color1" value="삭제" onclick="javascript:chkDel();return false;" style="float:right;margin-right:10px;"/>
									<?php } ?>
													<input type="button" id="integration_maintain" onclick="integration_maintain();" class="btn-common btn-color1" value="통합유지보수 관리 장비" style="float:right;margin-right:10px;width:150px;"/>
													<input type="button" id="maintain_renew" class="btn-common btn-color1" value="갱신" onclick="renewal();" style="float:right;margin-right:10px;"/>
									<?php if($_GET['type'] != '003' && $forcasting_cnt['cnt'] == 0) { ?>
													<input type="button" id="generate_forcasting" class="btn-common btn-color1" value="포캐스팅 생성" onclick="generate_forcasting('<?php echo $seq; ?>');" style="float:right;margin-right:10px;width:auto;"/>
									<?php } ?>
												</td>
											</tr>
											<form name="cform" action="<?php echo site_url(); ?>/sales/maintain/maintain_input_action" method="post" onSubmit="javascript:chkForm();return false;">
												<input type="hidden" id="update_main_array" name="update_main_array" />
												<input type="hidden" id="delete_main_array" name="delete_main_array" />
												<input type="hidden" id="update_product_array" name="update_product_array" />
												<input type="hidden" id="update_sub_product_array" name="update_sub_product_array" />
												<input type="hidden" id="seq" name="seq" value="<?php echo $seq; ?>">
												<input type="hidden" name="type" value="<?php echo $_GET['type']; ?>">
												<colgroup>
													<col width="9%" />
													<col width="16%" />
													<col width="9%" />
													<col width="16%" />
													<col width="9%" />
													<col width="16%" />
													<col width="9%" />
													<col width="6%" />
													<col width="5%" />
													<col width="5%" />
												</colgroup>
												<tr class="tbl-tr cell-tr border-t">
													<td class="tbl-title">고객사</td>
													<td class="tbl-cell"><?php echo $view_val['customer_companyname']; ?></td>
													<td class="tbl-title">담당자</td>
													<td class="tbl-cell"><?php echo $view_val['customer_username']; ?></td>
													<td class="tbl-title">연락처</td>
													<td class="tbl-cell"><?php echo $view_val['customer_tel']; ?></td>
													<td class="tbl-title">이메일</td>
													<td colspan="3" class="tbl-cell"><?php echo $view_val['customer_email']; ?></td>
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
													<td class="tbl-title">연계프로젝트</td>
                          <td colspan="5" align="center" style="font-weight:bold;">
                            <?php if(count($sub_project_cancel)>0){?>
                                <select class="input-common" style="width:90%;">
                                    <?php
                                    foreach ($sub_project_cancel as $val) {
                                        echo '<option value="' . $val['seq'] . '">'. $val['customer_companyname'].'-' . $val['project_name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            <?php } ?>
													</td>
												</tr>
												<tr class="tbl-tr cell-tr">
													<td class="tbl-title">진척단계</td>
                          <td class="tbl-cell">
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
                              ?>
                          </td>
									<?php if($view_val['type'] == "4"){ ?>
													<td class="tbl-title">조달 판매금액(VAT포함)</td>
                          <td class="tbl-cell">
														<?php echo $view_val['procurement_sales_amount']; ?>
													</td>
													<?php }?>
													<td class="tbl-title">영업업체</td>
													<td class="tbl-cell"><?php echo $view_val['cooperation_companyname']; ?></td>
													<td class="tbl-title">영업담당자</td>
													<td class="tbl-cell"><?php echo $view_val['cooperation_username']; ?></td>
													<td class="tbl-title">사업부</td>
													<td class="tbl-cell" <?php if($view_val['type'] != "4"){echo "colspan='3'";} ?>><?php echo $view_val['dept'];?>
														<input name="cooperation_tel" type="hidden" class="input5" id="cooperation_tel" value="<?php echo $view_val['cooperation_tel']; ?>" />
													</td>
													<!--                    <td class="tbl-title">이메일</td>-->
													<input name="cooperation_email" type="hidden" class="input5" id="cooperation_email" value="<?php echo $view_val['cooperation_email']; ?>" />
												</tr>
												<tr class="tbl-tr cell-tr">
													<td class="tbl-title">정보통신공사업</td>
                          <td class="tbl-cell" <?php if($_GET['type']=='003'){echo 'colspan="9"';} ?>>
                      <?php if($view_val['infor_comm_corporation'] == "Y"){
															echo "신청";
														}else{
															echo "미신청";
														} ?>
													</td>
											<?php if($_GET['type'] != '003'){ ?>
													<td class="tbl-title">품의서작성여부</td>
													<td colspan='7' class="tbl-cell">
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
															<input type="button" class="btn-common btn-style1" style="cursor:pointer;margin-left:20px;width:100px" value="품의서 작성" onclick="report_write('<?php echo $view_val['type']; ?>');">
														<?php }else if ($approval_doc['approval_doc_status'] == "002"){?>
															<input type="button" class="btn-common btn-style1" style="cursor:pointer;margin-left:20px;width:100px" value="품의서 보기" onclick="report_view('<?php echo $approval_doc['seq']; ?>');">
														<?php } ?>
													</td>
											<?php } ?>
												</tr>
												<tr>
													<td height=30></td>
													<!-- 빈칸 -->
												</tr>
												<tr>
	                        <td class="tbl-sub-title">
	                          <span onclick="modifyPopup(7);" style="cursor:pointer">
                            점검 정보
                            <img src="<?php echo $misc; ?>img/pencil_btn.png" width="15" height="15" style="margin-left:5px;"/>
	                          </span>
	                      	</td>
												</tr>
												<tr class="tbl-tr cell-tr border-t">
													<td class="tbl-title">관리팀</td>
													<td class="tbl-cell">
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
													<td class="tbl-title">점검주기</td>
													<td class="tbl-cell">
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
													<td class="tbl-title">점검코멘트</td>
													<td class="tbl-cell" colspan="5">
														<?php if(empty($view_val['maintain_comment'])){echo ""; }else{echo nl2br($view_val['maintain_comment']); }; ?>
													</td>
												</tr>
												<tr class="tbl-tr cell-tr">
													<td class="tbl-title">점검일자</td>
													<td class="tbl-cell"><?php echo $view_val['maintain_date'];?></td>
													<td class="tbl-title">점검자</td>
													<td class="tbl-cell"><?php echo $view_val['maintain_user']; ?></td>
													<td class="tbl-title">점검방법</td>
													<td class="tbl-cell">
													<?php if ($view_val['maintain_type'] == "1") {
														echo "방문점검";
													}else if ($view_val['maintain_type'] == "2") {
														echo "원격점검";
													}else{
														echo "점검방법 미선택";
													}
													?>
													</td>
													<td class="tbl-title">점검여부</td>
													<td colspan="3" class="tbl-cell">
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
													<td height=30></td>
													<!-- 빈칸 -->
												</tr>
												<tr>
                          <td class="tbl-sub-title">
                            <span onclick="modifyPopup(3);" style="cursor:pointer">
                            매출처 정보
                            <img src="<?php echo $misc; ?>img/pencil_btn.png" width="15" height="15" style="margin-left:5px;"/>
                            </span>
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
													<td class="tbl-title">납부회차</td>
													<td align="center" class="tbl-cell"><?php echo $view_val['sales_pay_session']; ?></td>
												</tr>
												<?php
												$i = 0;
												$main_company_amount1 = 0;
												foreach ($view_val2 as $item2) {
													${"main_company_amount".($i+1)} = 0;
													if ($i == 0) {
													foreach ($view_val3 as $item3) {
														if($item3['product_supplier'] == $item2['main_companyname']){
															$main_company_amount1 += (int)$item3['product_purchase'];
														}
													}
												    if($_GET['type'] == "002" && !empty($view_val5)){
														foreach ($view_val5 as $item3) {
															if($item3['product_supplier'] == $item2['main_companyname']){
																$main_company_amount1 += (int)$item3['product_purchase'];
															}
														}
													}
												?>
												<tr>
													<td height=30></td>
												</tr>
												<tr>
                          <td class="tbl-sub-title">
                          <span onclick="modifyPopup(4);" style="cursor:pointer">
                            매입처 정보
														<img src="<?php echo $misc; ?>img/pencil_btn.png" width="15" height="15" style="margin-left:5px;"/></span>
                          </td>
												</tr>
												<tr>
													<td height="60" colspan="9" align="left">
														<input type="checkbox" name="" value="" style="cursor:pointer;" onclick="mCompanyView(this);">매입처 정보 보기
													</td>
												</tr>
												<tr id="main_insert_field_2_<?php echo $i; ?>" class="mCompany tbl-tr cell-tr border-t" style="display:none;">
													<td class="tbl-title">매입처</td>
													<td class="tbl-cell"><?php echo $item2['main_companyname']; ?>
														<input name="main_seq" type="hidden"  value="<?php echo $item2['seq']; ?>" />
													</td>
													<td class="tbl-title">담당자</td>
													<td class="tbl-cell"><?php echo $item2['main_username']; ?></td>
													<td class="tbl-title">연락처</td>
													<td class="tbl-cell"><?php echo $item2['main_tel']; ?></td>
													<td class="tbl-title">이메일</td>
													<td class="tbl-cell"><?php echo $item2['main_email']; ?></td>
													<td class="tbl-title">납부회차</td>
													<td class="tbl-cell tbl-mid"><?php echo $item2['purchase_pay_session']; ?></td>
												</tr>
													<?php
													} else {
														foreach ($view_val3 as $item3) {
															if($item3['product_supplier'] == $item2['main_companyname']){
																${"main_company_amount".($i+1)} += (int)$item3['product_purchase'];
															}
														}
														if($_GET['type'] == "002"){
															foreach ($view_val5 as $item3) {
																if($item3['product_supplier'] == $item2['main_companyname']){
																	${"main_company_amount".($i+1)} += (int)$item3['product_purchase'];
																}
															}
														}
													?>

												<tr id="main_insert_field_2_<?php echo $i; ?>" class="mCompany tbl-tr cell-tr" style="display:none;">
													<td class="tbl-title">매입처</td>
                            <td class="tbl-cell">
                              <?php echo $item2['main_companyname']; ?>
															<input name="main_seq" type="hidden" value="<?php echo $item2['seq']; ?>" />
														</td>
														<td class="tbl-title">담당자</td>
														<td class="tbl-cell"><?php echo $item2['main_username']; ?></td>
														<td class="tbl-title">연락처</td>
														<td class="tbl-cell"><?php echo $item2['main_tel']; ?></td>
														<td class="tbl-title">이메일</td>
														<td class="tbl-cell"><?php echo $item2['main_email']; ?></td>
														<td class="tbl-title">납부회차</td>
														<td class="tbl-cell tbl-mid"><?php echo $item2['purchase_pay_session']; ?></td>
													</tr>
												<?php
													}
													$max_number = $i;
													$i++;
												}
												?>
												<input type="hidden" id="row_max_index" name="row_max_index" value="<?= $max_number ?>" />
												<tr>
													<td height=30></td>
													<!-- 빈칸 -->
												</tr>
												<tr>
													<td class="tbl-sub-title">
													<span onclick="modifyPopup(5);" style="cursor:pointer">
														제품 정보
														<img src="<?php echo $misc; ?>img/pencil_btn.png" width="15" height="15" style="margin-left:5px;"/></span>
													</td>
												</tr>
												<tr>
													<td height="60" colspan="10" align="left">
														<input type="checkbox" name="" value="" style="cursor:pointer;'" onclick="productView(this);">제품 정보 보기
													</td>
												</tr>
												<tr id="product_field" style="display:none;" >
													<td colspan="10" style="max-width:100%;">
														<!-- <input type="button" value="필터초기화" onclick="filter_reset('product_table');" style="float:right;cursor:pointer;margin-bottom:5px;" /> -->
														<img src="<?php echo $misc;?>/img/filter_refresh.png" onclick="filter_reset('product_table');" width=20 style="float:right;cursor:pointer;margin-bottom:5px;"/>
														<table id="product_table" style="min-width:100%;" border="0" cellspacing="0" cellpadding="0">
															<colgroup>
																<col width="3%" />
																<col width="8%" />
																<col width="7%" />
																<col width="7%" />
																<col width="5%" />
																<col width="8%" />
																<col width="5%" />
																<col width="7%" />
																<col width="6%" />
																<col width="6%" />
																<col width="6%" />
																<col width="3%" />
																<col width="3%" />
																<col width="7%" />
																<col width="7%" />
																<col width="7%" />
																<col width="5%" />
															</colgroup>
															<thead id="product_table_head">
															<tr bgcolor="F4F4F4" style="font-weight:bold;" class="tbl-tr cell-tr border-t">
																<th class="apply-filter" align="center" >번호</th>
																<th class="apply-filter" align="center" >프로젝트명</th>
																<th class="apply-filter" align="center" >제조사</th>
																<th class="apply-filter" align="center" >매입처</th>
																<th class="apply-filter" align="center" >구분</th>
																<th class="apply-filter" align="center" >제품명</th>
																<th class="apply-filter" align="center" >라이선스 수량</th>
																<th class="apply-filter" align="center" >hardware/software<br>serial number</th>
																<th class="apply-filter" align="center" >제품 상태</th>
																<th class="apply-filter" align="center" >장비유지보수<br>시작일</th>
																<th class="apply-filter" align="center" >장비유지보수<br>만료일</th>
																<th class="apply-filter" align="center" >유/무상</th>
																<th class="apply-filter" align="center" >유지보수 대상</th>
																<th class="apply-filter" align="center" >유지보수매출가</th>
																<th class="apply-filter" align="center" >유지보수매입가</th>
																<th class="apply-filter" align="center" >유지보수마진</th>
																<th class="apply-filter" align="center" >비고</th>
															</tr>
															</thead>
															<tbody>
											<?php
											$mb_cnt = 2;
											$j = 1;
											$i = 0;
											foreach ($view_val3 as $item3) {?>
													<tr id="product_insert_field<?php echo $j; ?>" class="tbl-tr cell-tr">
														<td align="center"><?php echo $j;?></td>
														<td align="left"><?php echo $item3['project_name']; ?></td>
														<td align="center"><?php echo $item3['product_company'];?></td>
														<td align="left"><?php echo $item3['product_supplier']; ?></td>
														<td align="center">
															<?php
																if(strpos($item3['product_type'],'License') !== false || strpos($item3['product_type'],'license') !== false || strpos($item3['product_type'],'라이선스') !== false){
																	echo "라이선스";
																}else if($item3['product_type'] == "hardware" || strpos($item3['product_type'],'하') !== false || strpos($item3['product_type'],'h') !== false || strpos($item3['product_type'],'H') !== false ){
																	echo "하드웨어";
																}else if($item3['product_type'] == "software" || strpos($item3['product_type'],'소') !== false || strpos($item3['product_type'],'s') !== false || strpos($item3['product_type'],'S') !== false ){
																	echo "소프트웨어";
																}else{
																	echo "전체" ;
																}
															?>
														</td>
														<td align="left">
															<!-- <input type="hidden" name ="product_seq" id="product_seq" value="<?php echo $item3['seq']; ?>" /> -->
															<?php echo $item3['product_name'] ;?>
														</td>
														<td align="center"><?php echo $item3['product_licence']; ?></td>
														<td align="left"><?php echo $item3['product_serial']; ?></td>
														<td align="center">
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
														<td align="center"><?php echo $item3['maintain_begin']; ?></td>
														<td align="center"><?php echo $item3['maintain_expire']; ?> </td>
														<td align="center">
															<?php if ($item3['maintain_yn'] == "Y") {
																echo "유상";
															}else if($item3['maintain_yn'] == "N"){
																echo "무상";
															}else{
																echo "유/무상여부";
															} ?>
														</td>
														<td align="center">
															<?php if ($item3['maintain_target'] == "Y") {
																echo "대상";
															}else if ($item3['maintain_target'] == "N") {
																echo "비대상";
															}else{
																echo "미선택";
															} ?>
														</td>
														<td align="right" name="product_sales"><?php if(trim($item3['product_sales']) == ""){echo $item3['product_sales'];}else{echo number_format((int)$item3['product_sales']);} ?></td>
														<td align="right" name="product_purchase"><?php if(trim($item3['product_purchase']) == ""){echo $item3['product_purchase'];}else{echo number_format((int)$item3['product_purchase']);} ?></td>
														<td align="right" name="product_profit"><?php if(trim($item3['product_profit']) == ""){echo $item3['product_profit'];}else{echo number_format((int)$item3['product_profit']);} ?></td>
														<td align="left"><?php echo $item3['comment']; ?></td>
														</tr>
												<?php
												$mb_cnt++;
												$max_number2 = $j;
												$j++;
												$i++;
												}
												?>
												</tbody>
										<?php if(!empty($view_val5)){ ?>
											</table>
										</td>
								</tr>

								<!-- 통합유지보수제품 스타떠 -->
								<tr id="integration_product_field" style="display:none;" >
									<td colspan="10" style="max-width:100%;padding-top:20px; ">
										<span style="font-weight:bold;font-size:13px;">
											통합 유지보수 제품 정보
										</span>
										<img src="<?php echo $misc;?>/img/filter_refresh.png" onclick="filter_reset('integration_product_table');" width=20 style="float:right;cursor:pointer;margin-bottom:5px;"/>
											<table id="integration_product_table" style="min-width:100%;" border="0" cellspacing="0" cellpadding="0">
												<colgroup>
													<col width="3%" />
													<col width="8%" />
													<col width="7%" />
													<col width="7%" />
													<col width="5%" />
													<col width="8%" />
													<col width="5%" />
													<col width="7%" />
													<col width="6%" />
													<col width="6%" />
													<col width="6%" />
													<col width="3%" />
													<col width="3%" />
													<col width="7%" />
													<col width="7%" />
													<col width="7%" />
													<col width="5%" />
												</colgroup>
												<thead>
													<tr bgcolor="F4F4F4" style="font-weight:bold;" class="tbl-tr cell-tr border-t">
														<th class="apply-filter" align="center" >번호</th>
														<th class="apply-filter" align="center" >프로젝트명</th>
														<th class="apply-filter" align="center" >제조사</th>
														<th class="apply-filter" align="center" >매입처</th>
														<th class="apply-filter" align="center" >구분</th>
														<th class="apply-filter" align="center" >제품명</th>
														<th class="apply-filter" align="center" >라이선스 수량</th>
														<th class="apply-filter" align="center" >hardware/software<br>serial number</th>
														<th class="apply-filter" align="center" >제품 상태</th>
														<th class="apply-filter" align="center" >장비유지보수<br>시작일</th>
														<th class="apply-filter" align="center" >장비유지보수<br>만료일</th>
														<th class="apply-filter" align="center" >유/무상</th>
														<th class="apply-filter" align="center" >유지보수 대상</th>
														<th class="apply-filter" align="center" >유지보수매출가</th>
														<th class="apply-filter" align="center" >유지보수매입가</th>
														<th class="apply-filter" align="center" >유지보수마진</th>
														<th class="apply-filter" align="center" >비고</th>
													</tr>
												</thead>
												<tbody>
										<?php
												$i = 0;
												foreach ($view_val5 as $item3) {?>
													<tr id="product_insert_field<?php echo $j; ?>" class="tbl-tr cell-tr">
														<td align="center"><?php echo $j;?></td>
														<td align="left"><?php echo $item3['project_name']; ?></td>
														<td align="center"><?php echo $item3['product_company'];?></td>
														<td align="left"><?php echo $item3['product_supplier']; ?></td>
														<td align="center">
                            <?php
																if(strpos($item3['product_type'],'License') !== false || strpos($item3['product_type'],'license') !== false || strpos($item3['product_type'],'라이선스') !== false){
																	echo "라이선스";
																}else if($item3['product_type'] == "hardware" || strpos($item3['product_type'],'하') !== false || strpos($item3['product_type'],'h') !== false || strpos($item3['product_type'],'H') !== false ){
																	echo "하드웨어";
	                              }else if($item3['product_type'] == "software" || strpos($item3['product_type'],'소') !== false || strpos($item3['product_type'],'s') !== false || strpos($item3['product_type'],'S') !== false ){
	                                  echo "소프트웨어";
	                              }else{
	                                  echo "전체" ;
	                              }
	                          ?>
														</td>
														<td align="left">
                              <?php echo $item3['product_name'] ;?>
														</td>
														<td align="center"><?php echo $item3['product_licence']; ?></td>
														<td align="left"><?php echo $item3['product_serial']; ?></td>
                            <td align="center">
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
														<td align="center"><?php echo $item3['maintain_begin']; ?></td>
														<td align="center"><?php echo $item3['maintain_expire']; ?> </td>
														<td align="center">
                              <?php if ($item3['maintain_yn'] == "Y") {
                                  echo "유상";
                              }else if($item3['maintain_yn'] == "N"){
                                  echo "무상";
                              }else{
                                  echo "유/무상여부";
                              } ?>
														</td>
														<td align="center">
                              <?php if ($item3['maintain_target'] == "Y") {
                                  echo "대상";
                              }else if ($item3['maintain_target'] == "N") {
                                  echo "비대상";
                              }else{
                                  echo "유지보수 대상";
                              } ?>
                            </td>
														<td align="right" name="product_sales"><?php if(trim($item3['product_sales']) == ""){echo $item3['product_sales'];}else{echo number_format((int)$item3['product_sales']);} ?></td>
														<td align="right" name="product_purchase"><?php if(trim($item3['product_purchase']) == ""){echo $item3['product_purchase'];}else{echo number_format((int)$item3['product_purchase']);} ?></td>
														<td align="right" name="product_profit"><?php if(trim($item3['product_profit']) == ""){echo $item3['product_profit'];}else{echo number_format((int)$item3['product_profit']);} ?></td>
														<td align="left" ><?php echo $item3['comment']; ?></td>
													</tr>
										<?php
										$mb_cnt++;
										$max_number2 = $j;
										$j++;
										$i++;
										}
										?>
										<?php } ?>
												</tbody>
											</table>
											<table id="filter_sales" class="basic_table" style="min-width:100%;display:none;" border="0" cellspacing="0" cellpadding="0">
											<colgroup>
												<col width="3%" />
												<col width="8%" />
												<col width="7%" />
												<col width="7%" />
												<col width="5%" />
												<col width="8%" />
												<col width="5%" />
												<col width="7%" />
												<col width="6%" />
												<col width="6%" />
												<col width="6%" />
												<col width="3%" />
												<col width="3%" />
												<col width="7%" />
												<col width="7%" />
												<col width="7%" />
												<col width="5%" />
											</colgroup>
											<tr align="center" bgcolor="F4F4F4" style="font-weight:bold;" class="tbl-tr cell-tr">
												<td colspan=13></td>
												<td >필터별총매출가</td>
												<td >필터별총매입가</td>
												<td >필터별총마진</td>
												<td align="left"></td>
											</tr>
											<tr class="tbl-tr cell-tr">
												<td colspan=13></td>
												<td align="right" id="filter_forcasting_sales"><?php echo number_format($view_val['forcasting_sales']); ?></td>
												<td align="right" id="filter_forcasting_purchase"><?php echo number_format($view_val['forcasting_purchase']); ?></td>
												<td align="right" id="filter_forcasting_profit"><?php echo number_format($view_val['forcasting_profit']); ?></td>
												<td align="left"></td>
											</tr>
										</table>
										<table class="basic_table" style="min-width:100%;" border="0" cellspacing="0" cellpadding="0">
											<colgroup>
												<col width="3%" />
												<col width="8%" />
												<col width="7%" />
												<col width="7%" />
												<col width="5%" />
												<col width="8%" />
												<col width="5%" />
												<col width="7%" />
												<col width="6%" />
												<col width="6%" />
												<col width="6%" />
												<col width="3%" />
												<col width="3%" />
												<col width="7%" />
												<col width="7%" />
												<col width="7%" />
												<col width="5%" />
											</colgroup>
											<tr align="center" bgcolor="F4F4F4" style="font-weight:bold;" class="tbl-tr cell-tr">
												<td colspan=13></td>
												<td >총매출가</td>
												<td >총매입가</td>
												<td >총마진</td>
												<td align="left"></td>
											</tr>
											<tr class="tbl-tr cell-tr">
												<td colspan=13></td>
												<td align="right" ><?php echo number_format($view_val['forcasting_sales']); ?></td>
												<td align="right" ><?php echo number_format($view_val['forcasting_purchase']); ?></td>
												<td align="right" ><?php echo number_format($view_val['forcasting_profit']); ?></td>
												<td align="left"></td>
											</tr>
										</table>
								</td>
							</tr>
							<input type="hidden" id="row_max_index2" name="row_max_index2" value="<?php echo $max_number2 ;?>" />
							<tr>
								<td id="productEnd" colspan="10" height="0" bgcolor="#e8e8e8"></td>
							</tr>
							<tr>
						    <td colspan="10" height="20" ></td>
							</tr>
							<tr class="tbl-tr cell-tr border-t">
								<td class="tbl-title">고객사유지보수시작일</td>
								<td class="tbl-cell"><?php echo $view_val['exception_saledate2']; ?></td>
								<td class="tbl-title">고객사유지보수종료일</td>
								<td class="tbl-cell" colspan="7"><?php echo $view_val['exception_saledate3']; ?></td>
							</tr>
							<tr>
								<td height=30></td>
							</tr>
							<tr>
						    <td class="tbl-sub-title">
							    <span onclick="modifyPopup(6);" style="cursor:pointer">
					        수주 정보
					        <img src="<?php echo $misc; ?>img/pencil_btn.png" width="15" height="15" style="margin-left:5px;"/>
									</span>
						    </td>
							</tr>
							<tr class="tbl-tr cell-tr border-t">
								<td class="tbl-title">수주여부</td>
						    <td colspan="9" class="tbl-cell">
						        <?php if ($view_val['complete_status'] == "001") {
						            echo "수주중";
						        }else if ($view_val['complete_status'] == "002") {
						            echo "수주완료";
						        } ?>
						    </td>
							</tr>
							<tr>
								<td height=30></td>
							</tr>
							<tr>
								<td class="tbl-sub-title">
									<span onclick="modifyPopup(8);" style="cursor:pointer">
									계산서 발행 정보
									<img src="<?php echo $misc; ?>img/pencil_btn.png" width="15" height="15" style="margin-left:5px;"/>
									</span>
								</td>
							</tr>
							<tr>
								<td height="60" colspan="1" align="left">
									<!-- <span style='cursor:pointer;' onclick="billView(this);">계산서 정보 보기 ▼</span> -->
									<input type="checkbox" name="" value="" style="cursor:pointer;'" onclick="billView(this);">계산서 정보 보기
								</td>
								<td colspan="9">
									<div style="width:100%;display:flex">
										<div style="width:5%;float:left">
											<span style="width:100%;font-weight:bold;margin-left:40px;margin-right:10px;">- 메모 </span>
										</div>
										<div style="width:95%;float:left">
											<input type="text" style="color:#B6B6B6;width:100%;" onclick="insert_memo();" value="<?php if($memo){echo $memo['memo'];} ?>" placeholder="이곳을 클릭하면 메모를 입력/수정 할 수 있습니다." readonly>
										</div>
									</div>
								</td>
							</tr>
							<tr class="statement_table">
								<td colspan=10>
									<img src="<?php echo $misc;?>/img/filter_refresh.png" onclick="filter_reset('sales_statement_table');" width=20 style="float:right;cursor:pointer;margin-bottom:5px;"/>
								</td>
							</tr>
							<tr class="statement_table">
								<td colspan="10" height="40" align="center" bgcolor="DEDEDE" style="font-weight:bold;font-size:15px;">매출</td>
							</tr>
							<tr class="statement_table">
								<td colspan=10>
									<table id="sales_statement_table" width="100%" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
										<colgroup>
											<col width="7%" />
											<col width="3%" />
											<col width="4%" />
											<col width="4%" />
											<col width="8%" />
											<col width="8%" />
											<col width="8%" />
											<col width="8%" />
											<col width="16%" />
											<col width="7%" />
											<col width="10%" />
											<col width="5%" />
											<col width="9%" />
											<col width="3%" />
										</colgroup>
										<!--시작라인-->
										<thead>
											<tr bgcolor="F4F4F4" height="40">
												<th colspan="2" class="apply-filter no-sort border-f" filter_column="1"	style="font-weight:bold;">계약금액(총공급가액)</th>
												<th class="border-r" style="font-weight:bold;">발행주기</th>
												<th class="border-r apply-filter no-sort" filter_column="2" style="font-weight:bold;">회차
												</th>
												<th class="border-r apply-filter no-sort" filter_column="3" style="font-weight:bold;">발행예정일
												</th>
												<th class="border-r apply-filter no-sort" filter_column="4" style="font-weight:bold;">발행금액</th>
												<th class="border-r apply-filter no-sort" filter_column="5" style="font-weight:bold;">세액</th>
												<th class="border-r apply-filter no-sort" filter_column="6" style="font-weight:bold;">합계</th>
												<th class="border-r apply-filter no-sort" filter_column="7" style="font-weight:bold;">국세청 승인번호
												</th>
												<th class="border-r apply-filter no-sort" filter_column="8" style="font-weight:bold;">발행월
												</th>
												<th class="border-r apply-filter no-sort" filter_column="9" style="font-weight:bold;">발행일자
												</th>
												<th class="border-r apply-filter no-sort" filter_column="10" style="font-weight:bold;">발행여부
												</th>
												<th class="border-r apply-filter no-sort" filter_column="11" style="font-weight:bold;">입금일자
												</th>
												<th class="border-r apply-filter no-sort" filter_column="12" style="font-weight:bold;">입금여부
												</th>
											</tr>
										</thead>
										<tbody>
										<?php if(empty($sales_bill_val)){?>
											<tr class="insert_sales_bill cell-tr">
												<td id="sales_contract_total_amount" rowspan="1" colspan="2" class="border-f" height="40"
													align="center"><?php echo number_format($view_val['forcasting_sales']); ?></td>
												<td colspan=12 align="left" class="basic_td" height="40"> - 등록된 계산서가 없습니다.</td>
											</tr>
										<?php
										}else{ ?>
											<tr class="tbl-tr cell-tr" style="font-weight:bold;text-align:center;">
												<td id="sales_contract_total_amount" rowspan="<?php echo count($sales_bill_val)+3; ?>" colspan="2" filter_column="1" class="border-f" align="center"><?php echo number_format($view_val['forcasting_sales']); ?>
												<br>(<span id="sales_total_issuance_amount"></span>)</td>
												<td rowspan="<?php echo count($sales_bill_val)+3; ?>" class="border-r" align="center"><?php echo $view_val['issue_cycle']; ?> </td>
												<td colspan="2">합계(기발행)</td>
												<td><input id="sum_sales_issuance_amount_done" value="" class="border_none_input" onchange="numberFormat(this);" style="text-align:right;" readonly/></td>
												<td><input id="sum_sales_tax_amount_done" value="" class="border_none_input" onchange="numberFormat(this);" style="text-align:right;" readonly/></td>
												<td><input id="sum_sales_total_amount_done" value="" class="border_none_input" onchange="numberFormat(this);" style="text-align:right;" readonly/></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
											</tr>
											<tr class="tbl-tr cell-tr" style="font-weight:bold;text-align:center;">
												<td colspan="2">합계(미발행)</td>
												<td><input id="sum_sales_issuance_amount_yet" value="" class="border_none_input" onchange="numberFormat(this);" style="text-align:right;" readonly/></td>
												<td><input id="sum_sales_tax_amount_yet" value="" class="border_none_input" onchange="numberFormat(this);" style="text-align:right;" readonly/></td>
												<td><input id="sum_sales_total_amount_yet" value="" class="border_none_input" onchange="numberFormat(this);" style="text-align:right;" readonly/></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
											</tr>
										<?php
										// if($sales_cnt > 0){
											$row = 1;

											foreach($sales_bill_val as $bill){
												if($bill['type'] == "001"){//매출
													if($bill['issuance_amount'] != ""){
														$sales_total_issuance_amount += $bill['issuance_amount'];
													}
										?>
											<tr id="bill_<?php echo $bill['seq']; ?>" class="update_sales_bill tbl-tr cell-tr" <?php if($bill['issuance_status'] == "M"){echo "style='color:red;'";}?>  >
												<td class="border-r" align="center" filter_column="2"><?php echo $bill['pay_session']; ?> </td>
												<td class="border-r" align="center" filter_column="3" ><?php echo $bill['issue_schedule_date']; ?></td>
												<td class="border-r sales_issuance_amount <?php echo "sales_issuance_amount".$bill['issuance_status']; ?>" align="right" filter_column="4" style="padding-right:7px;"><?php if($bill['issuance_amount'] == ""){echo $bill['issuance_amount'];}else{echo number_format($bill['issuance_amount']);} ?></td>
												<td class="border-r sales_tax_amount <?php echo "sales_tax_amount".$bill['issuance_status']; ?>" align="right" filter_column="5" style="padding-right:7px;"><?php if($bill['tax_amount'] == ""){echo $bill['tax_amount'];}else{echo number_format($bill['tax_amount']);} ?></td>
												<td class="border-r sales_total_amount <?php echo "sales_total_amount".$bill['issuance_status']; ?>" align="right" filter_column="6" style="padding-right:7px;"><?php if($bill['total_amount'] == ""){echo $bill['total_amount'];}else{echo number_format($bill['total_amount']);} ?></td>

												<td class="border-r" align="center" filter_column="7"><?php echo $bill['tax_approval_number']; ?></td>
												<td class="border-r" align="center" filter_column="8"><?php echo $bill['issuance_month']; ?></td>
												<td class="border-r" align="center" filter_column="9"><?php echo $bill['issuance_date']; ?></td>
												<td class="border-r" align="center" filter_column="10">
													<?php if($bill['issuance_status'] == "Y"){
														echo "완료";
													}else if ($bill['issuance_status'] == "N"){
														echo "미완료";
													}else if ($bill['issuance_status'] == "C"){
														echo "발행취소";
													}else if ($bill['issuance_status'] == "M"){
														echo "마이너스발행";
													}?>
												</td>
												<td class="border-r" align="center" filter_column="11"><?php echo $bill['deposit_date']; ?></td>
												<td class="border-r" align="center" filter_column="12">
														<?php if($bill['deposit_status'] == "Y"){
															echo "완료";
														} else if ($bill['deposit_status'] == "L") {
															echo '부족';
														} else if ($bill['deposit_status'] == "O") {
															echo '과잉';
														} else {
															echo "미완료";
														} ?>
												</td>
											</tr>
										<?php
													$row++;
												}
											}
										}?>
											<tr height="40" class="cell-tr" align="center" style="font-weight:bold;">
												<td colspan="2" style="background-color:#FFFFF2;">합계</td>
												<td style="background-color:#FFFFF2;"><input id="sum_sales_issuance_amount" value="" class="border_none_input" onchange="numberFormat(this);" style="text-align:right;background-color:#FFFFF2;" readonly/></td>
												<td style="background-color:#FFFFF2;"><input id="sum_sales_tax_amount" class="border_none_input" value="" onchange="numberFormat(this);" style="text-align:right;background-color:#FFFFF2;" readonly/></td>
												<td style="background-color:#FFFFF2;"><input id="sum_sales_total_amount" class="border_none_input" value="" onchange="numberFormat(this);" style="text-align:right;background-color:#FFFFF2;" readonly/></td>
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
							<tr class="statement_table">
								<td colspan=10 height="30"></td>
							</tr>
							<tr class="statement_table">
								<td colspan=10>
									<img src="<?php echo $misc;?>/img/filter_refresh.png" onclick="filter_reset('purchase_statement_table');" width=20 style="float:right;cursor:pointer;margin-bottom:5px;"/>
								</td>
							</tr>
							<tr id="sales_issuance_amount_insert_line" class="statement_table">
								<td colspan="10" height="40" align="center" bgcolor="DEDEDE" style="font-weight:bold;font-size:15px;">매입</td>
							</tr>
							<tr class="statement_table">
								<td colspan=10>
									<table id="purchase_statement_table" width="100%" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
										<colgroup>
											<col width="8%" />
											<col width="8%" />
											<col width="4%" />
											<col width="4%" />
											<col width="8%" />
											<col width="7%" />
											<col width="7%" />
											<col width="7%" />
											<col width="16%" />
											<col width="6%" />
											<col width="8%" />
											<col width="5%" />
											<col width="9%" />
											<col width="3%" />
										</colgroup>
										<!--시작라인-->
										<thead>
											<tr class="cell-tr">
												<th class="basic_td apply-filter no-sort" height="40" filter_column="1" align="center" bgcolor="f8f8f9" style="font-weight:bold;">업체
												</th>
												<th class="basic_td apply-filter no-sort" filter_column="2" align="center" bgcolor="f8f8f9" style="font-weight:bold;">계약금액(총공급가액)
												</th>
												<th class="basic_td"  align="center" bgcolor="f8f8f9" style="font-weight:bold;">발행주기</th>
												<th class="basic_td apply-filter no-sort" filter_column="3" align="center" bgcolor="f8f8f9" style="font-weight:bold;">회차
												</th>
												<th class="basic_td apply-filter no-sort" filter_column="4" align="center" bgcolor="f8f8f9" style="font-weight:bold;">발행예정일
												</th>
												<th class="basic_td apply-filter no-sort" filter_column="5" align="center" bgcolor="f8f8f9" style="font-weight:bold;">발행금액</th>
												<th class="basic_td apply-filter no-sort" filter_column="6" align="center" bgcolor="f8f8f9" style="font-weight:bold;">세액</th>
												<th class="basic_td apply-filter no-sort" filter_column="7" align="center" bgcolor="f8f8f9" style="font-weight:bold;">합계</th>

												<th class="basic_td apply-filter no-sort" filter_column="8" align="center" bgcolor="f8f8f9" style="font-weight:bold;">국세청 승인번호
												</th>
												<th class="basic_td apply-filter no-sort" filter_column="9" align="center" bgcolor="f8f8f9" style="font-weight:bold;">발행월
												</th>
												<th class="basic_td apply-filter no-sort" filter_column="10" align="center" bgcolor="f8f8f9" style="font-weight:bold;">발행일자
												</th>
												<th class="basic_td apply-filter no-sort" filter_column="11" align="center" bgcolor="f8f8f9" style="font-weight:bold;">발행여부
												</th>
												<th class="basic_td apply-filter no-sort" filter_column="12" align="center" bgcolor="f8f8f9" style="font-weight:bold;">지급일자
												</th>
												<th class="basic_td apply-filter no-sort" filter_column="13" align="center" bgcolor="f8f8f9" style="font-weight:bold;">입금여부
												</th>
											</tr>
										<thead>
										<tbody>
										<?php if(empty($purchase_bill_val)){?>
										<?php
										$num = 1;
										foreach ($view_val2 as $item2) {
										${"purchase_total_issuance_amount".$num} = 0;?>
											<tr class="purchase_tax_invoice<?php echo $num; ?> insert_purchase_bill cell-tr">
												<td class="purchase_contract_total_amount<?php echo $num; ?> basic_td" align="center"><?php echo $item2['main_companyname']; ?></td>
												<td id="purchase_contract_total_amount<?php echo $num; ?>" rowspan="1" class="purchase_contract_total_amount<?php echo $num; ?> basic_td" align="center"><?php echo number_format(${"main_company_amount".$num}); ?></td>
												<td colspan=12 class="basic_td" align="left" height="40"> - 등록된 계산서가 없습니다.</td>
											</tr>
										<?php
										$num++;
										}?>
									<?php
									}else{
										$num = 1;
										foreach ($view_val2 as $item2) {
											${"purchase_total_issuance_amount".$num} = 0;
											$row2 = 1;
											foreach($purchase_bill_val as $bill){
												if($bill['type'] == "002"){//매입
												if($item2['main_companyname'] == $bill['company_name']){
													if($bill['issuance_amount'] != ""){
														${"purchase_total_issuance_amount".$num}+= $bill['issuance_amount'];
													}
												if($row2 == 1){
									?>
													<tr class="purchase_tax_invoice<?php echo $num; ?> update_purchase_bill cell-tr tbl-tr" style="font-weight:bold;text-align:center;">
														<td class="purchase_contract_total_amount<?php echo $num; ?>" align="center" filter_column="1"><?php echo $bill['company_name']; ?></td>
														<td id="purchase_contract_total_amount<?php echo $num; ?>" rowspan="1"
															class="purchase_contract_total_amount<?php echo $num; ?>" filter_column="2"
															align="center"><?php echo number_format(${"main_company_amount".$num}); ?><br>
															(<span id="purchase_total_issuance_amount<?php echo $num ;?>"></span>)
														</td>
														<td align="center" rowspan=1><?php echo $item2['issue_cycle']; ?></td>
														<td colspan="2">합계(기발행)</td>
														<td><input id="sum_purchase_issuance_amount_done<?php echo $num; ?>" name ="sum_purchase_issuance_amount_done" value="" class="border_none_input" onchange="numberFormat(this);" style="text-align:right;" /></td>
														<td><input id="sum_purchase_tax_amount_done<?php echo $num; ?>" name ="sum_purchase_tax_amount_done" class="border_none_input" value="" onchange="numberFormat(this);"style="text-align:right;" /></td>
														<td><input id="sum_purchase_total_amount_done<?php echo $num; ?>" name ="sum_purchase_total_amount_done" class="border_none_input" value="" onchange="numberFormat(this);" style="text-align:right;" /></td>
														<td></td>
														<td></td>
														<td></td>
														<td></td>
														<td></td>
														<td></td>
													</tr>
													<tr class="cell-tr tbl-tr" style="font-weight:bold;text-align:center;">
														<td colspan="2">합계(미발행)</td>
														<td><input id="sum_purchase_issuance_amount_yet<?php echo $num; ?>" value="" class="border_none_input" onchange="numberFormat(this);" style="text-align:right;" /></td>
														<td><input id="sum_purchase_tax_amount_yet<?php echo $num; ?>" class="border_none_input" value="" onchange="numberFormat(this);"style="text-align:right;" /></td>
														<td><input id="sum_purchase_total_amount_yet<?php echo $num; ?>" class="border_none_input" value="" onchange="numberFormat(this);" style="text-align:right;" /></td>
														<td></td>
														<td></td>
														<td></td>
														<td></td>
														<td></td>
														<td></td>
													</tr>
													<tr id="bill_<?php echo $bill['seq']; ?>" class="purchase_tax_invoice<?php echo $num; ?> update_purchase_bill cell-tr tbl-tr" <?php if($bill['issuance_status'] == "M"){echo "style='color:red;'";}?>>
														<td align="center" filter_column="3" ><?php echo $bill['pay_session']; ?></td>
														<td align="center" filter_column="4" ><?php echo $bill['issue_schedule_date']; ?></td>
														<td class="purchase_issuance_amount<?php echo $num; ?> <?php echo "purchase_issuance_amount$num".$bill['issuance_status']; ?>" align="right" filter_column="5" style="padding-right:7px;"><?php if($bill['issuance_amount'] == ""){echo $bill['issuance_amount'];}else{echo number_format($bill['issuance_amount']);} ?></td>
														<td class="purchase_tax_amount<?php echo $num; ?> <?php echo "purchase_tax_amount$num".$bill['issuance_status']; ?>" align="right" filter_column="6" style="padding-right:7px;"><?php if($bill['tax_amount'] == ""){echo $bill['tax_amount'];}else{echo number_format($bill['tax_amount']);} ?></td>
														<td class="purchase_total_amount<?php echo $num; ?> <?php echo "purchase_total_amount$num".$bill['issuance_status']; ?>" align="right" filter_column="7" style="padding-right:7px;"><?php if($bill['total_amount'] == ""){echo $bill['total_amount'];}else{echo number_format($bill['total_amount']);} ?></td>

														<td align="center" filter_column="8"><?php echo $bill['tax_approval_number']; ?></td>
														<td align="center" filter_column="9"><?php echo $bill['issuance_month']; ?></td>
														<td align="center" filter_column="10"><?php echo $bill['issuance_date']; ?></td>
														<td align="center" filter_column="11">
															<?php if($bill['issuance_status'] == "Y"){
																echo "완료";
															}else if ($bill['issuance_status'] == "N"){
																echo "미완료";
															}else if ($bill['issuance_status'] == "C"){
																echo "발행취소";
															}else if ($bill['issuance_status'] == "M"){
																echo "마이너스발행";
															}?>
														</td>
														<td align="center" filter_column="12"><?php echo $bill['deposit_date']; ?></td>
														<td align="center" filter_column="13">
															<?php if($bill['deposit_status'] == "Y"){
																	echo "완료";
															} else if ($bill['deposit_status'] == "L") {
																echo '부족';
															} else if ($bill['deposit_status'] == "O") {
																echo '과잉';
															} else{
																echo "미완료";
															} ?>
														</td>
													</tr>
											<?php
													}else{
											?>
													<tr id="bill_<?php echo $bill['seq']; ?>" class="purchase_tax_invoice<?php echo $num; ?> update_purchase_bill cell-tr tbl-tr" <?php if($bill['issuance_status'] == "M"){echo "style='color:red;'";}?>>
														<td align="center" filter_column="3" ><?php echo $bill['pay_session']; ?></td>
														<td align="center" filter_column="4" ><?php echo $bill['issue_schedule_date']; ?></td>
														<td class="purchase_issuance_amount<?php echo $num; ?> <?php echo "purchase_issuance_amount$num".$bill['issuance_status']; ?>" align="right" filter_column="5" style="padding-right:7px;"><?php if($bill['issuance_amount'] == ""){echo $bill['issuance_amount'];}else{echo number_format($bill['issuance_amount']);} ?></td>
														<td class="purchase_tax_amount<?php echo $num; ?> <?php echo "purchase_tax_amount$num".$bill['issuance_status']; ?>" align="right" filter_column="6" style="padding-right:7px;"><?php if($bill['tax_amount'] == ""){echo $bill['tax_amount'];}else{echo number_format($bill['tax_amount']);} ?></td>
														<td class="purchase_total_amount<?php echo $num; ?> <?php echo "purchase_total_amount$num".$bill['issuance_status']; ?>" align="right" filter_column="7" style="padding-right:7px;"><?php if($bill['total_amount'] == ""){echo $bill['total_amount'];}else{echo number_format($bill['total_amount']);} ?></td>

														<td align="center" filter_column="8"><?php echo $bill['tax_approval_number']; ?></td>
														<td align="center" filter_column="9"><?php echo $bill['issuance_month']; ?></td>
														<td align="center" filter_column="10"><?php echo $bill['issuance_date']; ?></td>
														<td align="center" filter_column="11">
															<?php if($bill['issuance_status'] == "Y"){
																echo "완료";
															}else if ($bill['issuance_status'] == "N"){
																echo "미완료";
															}else if ($bill['issuance_status'] == "C"){
																echo "발행취소";
															}else if ($bill['issuance_status'] == "M"){
																echo "마이너스발행";
															}?>
														</td>
														<td align="center" filter_column="12"><?php echo $bill['deposit_date']; ?></td>
														<td align="center" filter_column="13">
															<?php if($bill['deposit_status'] == "Y"){
																	echo "완료";
															} else if ($bill['deposit_status'] == "L") {
																echo '부족';
															} else if ($bill['deposit_status'] == "O") {
																echo '과잉';
															} else{
																echo "미완료";
															} ?>
														</td>
													</tr>
											<?php
													}
													$rowspan = $row2 + 3;
													echo "<script>";
													echo "$('.purchase_contract_total_amount{$num}').attr('rowSpan', {$rowspan});";
													echo "$('.purchase_contract_total_amount{$num}').next().attr('rowSpan', {$rowspan});";
													echo "</script>";
													$row2++;
												}
											}
										}
													if($row2 == 1){?>
													<tr class="purchase_tax_invoice<?php echo $num; ?> insert_purchase_bill cell-tr">
														<td class="purchase_contract_total_amount<?php echo $num; ?> basic_td" align="center" rowspan="2"><?php echo $item2['main_companyname']; ?></td>
														<td id="purchase_contract_total_amount<?php echo $num; ?>" rowspan="2" class="purchase_contract_total_amount<?php echo $num; ?> basic_td" align="center"><?php echo number_format(${"main_company_amount".$num}); ?></td>
														<td rowspan="2"></td>
														<td height="40" colspan=11 class="basic_td" align="left" style="padding-left:10px;"> - 등록된 계산서가 없습니다.
															<input type="hidden" name="sum_purchase_issuance_amount_done" value="" onchange="numberFormat(this);"/>
															<input type="hidden" name="sum_purchase_tax_amount_done" value="" onchange="numberFormat(this);"/>
															<input type="hidden" name="sum_purchase_total_amount_done" value="" onchange="numberFormat(this);"/>
															<input type="hidden" name="sum_purchase_issuance_amount_yet" value="" onchange="numberFormat(this);"/>
															<input type="hidden" name="sum_purchase_tax_amount_yet" value="" onchange="numberFormat(this);"/>
															<input type="hidden" name="sum_purchase_total_amount_yet" value="" onchange="numberFormat(this);"/>
														</td>
													</tr>
													<?php } ?>
													<tr class="cell-tr tbl-tr" align="center" style="font-weight:bold;">
														<td colspan="2" style="background-color:#FFFFF2;"><?php echo $item2['main_companyname']." "; ?>요약</td>
														<td style="background-color:#FFFFF2;"><input id="sum_purchase_issuance_amount<?php echo $num; ?>" name ="sum_purchase_issuance_amount" value="" class="border_none_input" onchange="numberFormat(this);" style="text-align:right;background-color:#FFFFF2;" /></td>
														<td style="background-color:#FFFFF2;"><input id="sum_purchase_tax_amount<?php echo $num; ?>" name ="sum_purchase_tax_amount" class="border_none_input" value="" onchange="numberFormat(this);"style="text-align:right;background-color:#FFFFF2;" /></td>
														<td style="background-color:#FFFFF2;"><input id="sum_purchase_total_amount<?php echo $num; ?>" name ="sum_purchase_total_amount" class="border_none_input" value="" onchange="numberFormat(this);" style="text-align:right;background-color:#FFFFF2;" /></td>
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
									<tr class="tbl-tr cell-tr" align="center" style="font-weight:bold;">
										<td colspan=3>매입 총 합계</td>
										<td></td>
										<td></td>
										<td><input id="t_sum_purchase_issuance_amount" name ="t_sum_purchase_issuance_amount" value="" class="border_none_input" onchange="numberFormat(this);" style="text-align:right;" /></td>
										<td><input id="t_sum_purchase_tax_amount" name ="t_sum_purchase_tax_amount" class="border_none_input" value="" onchange="numberFormat(this);"style="text-align:right;" /></td>
										<td><input id="t_sum_purchase_total_amount" name ="t_sum_purchase_total_amount" class="border_none_input" value="" onchange="numberFormat(this);" style="text-align:right;" /></td>
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
						</form>
					</table>
				</td>
			</tr>
			<tr>
				<td height="50"></td>
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
							<td id ="complete_status_comment" colspan="9" align="left">
								<?php
								if($complete_status_val){
									$n = 1;
									foreach ($complete_status_val as $item) {
									?>
								<table id="completeStatusCommentAdd<?php echo $n; ?>" class="update_complete_status_comment" width="100%" border="0" cellspacing="0" cellpadding="5">
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
												<img src="<?php echo $misc;?>img/btn_del.svg" width="18" height="17" style="cursor:pointer" border="0" onclick="completeStatusCommentDel('<?php echo $item['seq'] ?>');filedel('<?php echo $item['seq']; ?>','<?php echo $item['file_change_name']; ?>');"/>
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
												<a href="<?php echo site_url(); ?>/sales/maintain/complete_status_comment_download/<?php echo urlencode($item['file_real_name']); ?>/<?php echo $item['file_change_name']; ?>">
													<?php echo $item['file_real_name']; ?>
												</a>
												<a href="javascript:filedel('<?php echo $item['seq']; ?>','<?php echo $item['file_change_name']; ?>');">
													<img src="<?php echo $misc; ?>img/del.png" width="8" height="8" />
												</a>
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
										<?php echo $item['user_name']; ?>
									</td>
									<td width="100px" class="tbl-mid" style="border-right: thin solid #DFDFDF;">
										<?php echo substr($item['insert_date'], 0, 10); ?>
									</td>
									<td align="right">
										<?php if ($id == $item['user_id'] || $sales_lv >= 1) { ?>
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
										<?php echo $name; ?>
									</td>
									<td width="100px" class="tbl-mid" style="border-right: thin solid #DFDFDF;">
										<?php echo date("Y-m-d"); ?>
									</td>
									<td align="right"></td>
								</tr>
								<tr>
									<td class="answer2" colspan="3" align="center">
										<textarea name="comment" id="comment" rows="5" class="textarea-common" style="width:100%;"></textarea>
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
	<!--버튼-->
	<!--//버튼-->
	<!--//댓글-->
		</table>
	<!--//내용-->
		</td>
		</tr>
		</table>
	</td>
	</tr>
</table>
</div>
</div>
<div id="dialog-message-1" title="선택하세요." style='display:none'>
  통합유지보수를 유지하시겠습니까?
</div>
<div id="dialog-message-2" title="선택하세요." style='display:none'>
유지보수를 갱신하시겠습니까?
</div>
<div id="memo_popup" name="duple_sch_popup" class="layerpop" style="display:none; width:700px; height:auto;padding:20px;">
  <article class="layerpop_area" align="center">
  <div align="left" class="tbl-sub-title">메모</div>
  <table border="0" cellspacing="0" cellpadding="0" style="width:100%" align="center">
		<tr>
			<td>
				<input type="text" id="memo" name="input-common" style="width:100%;" value="<?php if($memo){echo $memo['memo'];} ?>">
				<input type="hidden" id="memo_seq" value="<?php if($memo){echo $memo['seq'];} ?>">
			</td>
		</tr>
  </table>
  <div align="right" style="margin-top:20px;">
    <button type="button" class="btn-common btn-color1" onclick="$('#memo_popup').bPopup().close();" >닫기</button>
    <button type="button" class="btn-common btn-color2" onclick="save_memo();" >저장</button>
  </div>
  </article>
</div>
<!--하단-->
<?php include $this->input->server('DOCUMENT_ROOT') . "/include/sales_bottom.php"; ?>
<!--//하단-->
<script src="//cdnjs.cloudflare.com/ajax/libs/babel-standalone/6.26.0/babel.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/babel-polyfill/7.4.3/polyfill.js"></script>
<script type="text/babel" data-presets="es2015, stage-3">

	get_sum_amount(0); // 매출총합

	for(var i=0; i<$("input[name=sum_purchase_issuance_amount]").length; i++){
		get_sum_amount(1,i+1);
	}


	var mb_cnt = Number($("#row_max_index2").val());
	$("#sales_total_issuance_amount").text("<?php echo number_format($sales_total_issuance_amount); ?>");
	<?php
	for($i=1; $i<$num; $i++){?>
		$("#purchase_total_issuance_amount<?php echo $i;?>").text("<?php echo number_format(${"purchase_total_issuance_amount".$i}) ;?>");

	<?php } ?>

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

		// var html = '<table id="completeStatusCommentAdd'+num+'" width="100%" border="0" cellspacing="0" cellpadding="5"><tr bgcolor="f8f8f9">';
		// html += '<td width="8%" class="answer"><?php echo $name; ?></td>';
		// html += '<td colspan="2" width="20%" align="right"><input type="image" src="<?php echo $misc; ?>img/btn_answer2.jpg" width="50" height="18" style="cursor:pointer" onclick="ajaxFileUpload('+num+');" /></td></tr>'
		// html += '<tr><td width="10%"><select id="comment_status" class="input5">';
		// html += '<option value="0" selected>-수주여부-</option><option value="001">수주중</option><option value="002">수주완료</option></select>';
		// html += '<td width="80%"><input type="text" id="comment_contents" value="" style="width:95%;"/></td>';
		// html += '<td width="10%"><form id="ajaxFrom" method="post"><input type="file" id="ajaxFile" />(용량제한 100MB)</form></td>'
		// html += '</tr></table>'

		var html = '<table id="completeStatusCommentAdd'+num+'" width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:40px;">';
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

   //수주여부 코멘트 삭제
	function completeStatusCommentDel(seq){
		if (confirm("코멘트를 삭제하시겠습니까?") == true) {
			$.ajax({
				type: "POST",
				cache: false,
				url: "<?php echo site_url();?>/sales/maintain/maintain_complete_status_comment_delete",
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
				url: "<?php echo site_url();?>/sales/maintain/maintain_complete_status_comment_insert",
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
				url: "<?php echo site_url();?>/sales/maintain/maintain_complete_status_file_upload",
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
							url: "<?php echo site_url();?>/sales/maintain/maintain_complete_status_comment_insert",
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
				location.href = "<?php echo site_url(); ?>/sales/maintain/maintain_complete_status_filedel/" + seq + "/" + filename;
				return false;
			}
		}
 	}

    //수정 하러가기 팝업
    function modifyPopup(type){
        window.open("<?php echo site_url(); ?>/sales/maintain/maintain_modify?seq=<?php echo $view_val['seq'] ;?>&type="+type,"","width = 1200, height = 500, scrollbars=1,resizable=yes");
	}

	// 통합유지보수 리스트
	function integration_maintain(){
		window.open("<?php echo site_url(); ?>/sales/maintain/integration_maintain_list","","width = 1000, height = 500, scrollbars=1,resizable=yes");
	}

	//유지보수 갱신
	function renewal(){
		var integration_maintain ="";
		$('#dialog-message-1').dialog({
			modal: true,
			buttons: {
				"예": function() {
					$(this).dialog('close');
					integration_maintain="true";
					var project_name = prompt("갱신할 유지보수의 프로젝트명을 입력해주세요.");
					$('#dialog-message-2').dialog({
						modal: true,
						buttons: {
							"예": function() {
								$(this).dialog('close');
								$.ajax({
									type: "POST",
									cache: false,
									url: "<?php echo site_url();?>/sales/maintain/maintain_renewal",
									dataType: "json",
									async: false,
									data: {
										maintain_seq: <?php echo $seq ;?>,
										project_name: project_name,
										integration_maintain:integration_maintain
									},
									success: function (data) {
										if(data){
											alert("유지보수 갱신 되었습니다.갱신된 유지보수로 이동합니다.");
											location.href = "<?php echo site_url(); ?>/sales/maintain/maintain_view?seq="+data+"&type=<?php echo $_GET['type']; ?>";
										}else{
											alert("유지보수 갱신 실패");
										}
									}
								});
							},
							"아니오": function() { $(this).dialog('close'); }
						}
					});
				},
				"아니오": function() {
					$(this).dialog('close');
					integration_maintain="false";
					var project_name = prompt("갱신할 유지보수의 프로젝트명을 입력해주세요.");
					$('#dialog-message-2').dialog({
						modal: true,
						buttons: {
							"예": function() {
								$(this).dialog('close');
								$.ajax({
									type: "POST",
									cache: false,
									url: "<?php echo site_url();?>/sales/maintain/maintain_renewal",
									dataType: "json",
									async: false,
									data: {
										maintain_seq: <?php echo $seq ;?>,
										project_name: project_name,
										integration_maintain:integration_maintain
									},
									success: function (data) {
										if(data){
											alert("유지보수 갱신 되었습니다.갱신된 유지보수로 이동합니다.");
											location.href = "<?php echo site_url(); ?>/sales/maintain/maintain_view?seq="+data+"&type=<?php echo $_GET['type']; ?>";
										}else{
											alert("유지보수 갱신 실패");
										}
									}
								});
							},
							"아니오": function() { $(this).dialog('close'); }
						}
					});
				 },
			}
		});

	}

	//제품 폴딩
	function productView(obj){
		if($(obj).html().indexOf("▼") !== -1){
			$(obj).html("제품 정보 닫기 ▲");
		}else{
			$(obj).html("제품 정보 보기 ▼");
		}
		$("#product_field").toggle();
		$("#integration_product_field").toggle();
		// $("#integration_product_title").toggle();
	}

	//계산서 폴딩
	function billView(obj){
		if($(obj).html().indexOf("▼") !== -1){
			$(obj).html("계산서 정보 닫기 ▲");
		}else{
			$(obj).html("계산서 정보 보기 ▼");
		}
		$(".statement_table").toggle();
	}

	function mCompanyView(obj){
		if($(obj).html().indexOf("▼") !== -1){
			$(obj).html("매입처 정보 닫기 ▲");
		}else{
			$(obj).html("매입처 정보 보기 ▼");
		}
		$(".mCompany").toggle();
	}

	//필터적용햇을때 돈계싼
	function filter_profit_change(){
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

	  $('#integration_product_table').excelTableFilter({
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

	$(".statement_table").hide();

	//필터 다시 돌려
	function filter_reload(target,e){
		if(e != undefined){
			if($(e.target).attr('class').indexOf('drop') === -1){
				$('#'+target).find($(".dropdown-filter-dropdown")).remove();
				$('#'+target).excelTableFilter({
					columnSelector: '.apply-filter',
					captions :{a_to_z: '오름차순',
					z_to_a: '내림차순',
					search: 'Search',
					select_all: '전체'}
				});
			}
		}else{
			$('#'+target).find($(".dropdown-filter-dropdown")).remove();
			$('#'+target).excelTableFilter({
				columnSelector: '.apply-filter',
				captions :{a_to_z: '오름차순',
				z_to_a: '내림차순',
				search: 'Search',
				select_all: '전체'}
			});
		}
	}

	//엑셀필터 초기화
	function filter_reset(target){
		$("#"+target).find($(".오름차순:first")).trigger("click");
		$("#"+target).find("tr").show();
		$("#"+target).find("td").show();
		$("#"+target).find($(".filter_n")).val('all');
		if(target.indexOf("product") !== -1){
			for (var i = 0; i <$("td[name=product_sales]").length; i++) {
				$("td[name=product_sales]").eq(i).show();
				$("td[name=product_sales]").eq(i).parent().show();
			}
			$("#filter_sales").hide();
		}
		filter_reload(target);
		$("#"+target).find($(".select-all:not(:checked)")).trigger("click");
		if(target=="sales_statement_table"){
			get_sum_amount(0);
		}else if (target=="purchase_statement_table"){
			for(var i=0; i<$("input[name=sum_purchase_issuance_amount]").length; i++){
				get_sum_amount(1,i+1);
			}
		}
	}


	//품의서 쓰러가기
	function report_write(){
		location.href="<?php echo site_url(); ?>/biz/approval/electronic_approval_doc_input?seq=31&maintain_seq=<?php echo $seq;?>";
	}

	//품의서 보러가깅
	function report_view(doc_seq){
		location.href="<?php echo site_url(); ?>/biz/approval/electronic_approval_doc_view?seq="+doc_seq+"&type=completion";
	}

	//총 합!
	function get_sum_amount(type,row){
		var issuance_amount = 0;
		var tax_amount = 0;
		var total_amount =  0;
		var issuance_amount_done = 0;
		var tax_amount_done = 0;
		var total_amount_done = 0;
	if(type == 0){ //매출
		for(var i=0; i<$(".sales_issuance_amount").length; i++){
			if($(".sales_issuance_amount").eq(i).is(":visible")){
				issuance_amount += Number($(".sales_issuance_amount").eq(i).text().replace(/,/g, ""));
				tax_amount += Number($(".sales_tax_amount").eq(i).text().replace(/,/g, ""));
				total_amount += Number($(".sales_total_amount").eq(i).text().replace(/,/g, ""));
				issuance_amount_done += Number($('.sales_issuance_amountY').eq(i).text().replace(/,/g, ""));
				tax_amount_done += Number($('.sales_tax_amountY').eq(i).text().replace(/,/g, ""));
				total_amount_done += Number($('.sales_total_amountY').eq(i).text().replace(/,/g, ""));
			}
		}
		$("#sum_sales_issuance_amount").val(issuance_amount);
		$("#sum_sales_tax_amount").val(tax_amount);
		$("#sum_sales_total_amount").val(total_amount);
		$("#sum_sales_issuance_amount_done").val(issuance_amount_done);
		$("#sum_sales_tax_amount_done").val(tax_amount_done);
		$("#sum_sales_total_amount_done").val(total_amount_done);
		$("#sum_sales_issuance_amount_yet").val(issuance_amount-issuance_amount_done);
		$("#sum_sales_tax_amount_yet").val(tax_amount-tax_amount_done);
		$("#sum_sales_total_amount_yet").val(total_amount-total_amount_done);
		$("input[id^='sum_sales']").change();
	}else{ //매입
		for(var i=0; i<$(".purchase_issuance_amount"+row).length; i++){
			if($(".purchase_issuance_amount"+row).eq(i).is(":visible")){
				issuance_amount += Number($(".purchase_issuance_amount"+row).eq(i).text().replace(/,/g, ""));
				tax_amount += Number($(".purchase_tax_amount"+row).eq(i).text().replace(/,/g, ""));
				total_amount += Number($(".purchase_total_amount"+row).eq(i).text().replace(/,/g, ""));
				issuance_amount_done += Number($(".purchase_issuance_amount"+row+'Y').eq(i).text().replace(/,/g, ""));
				tax_amount_done += Number($(".purchase_tax_amount"+row+'Y').eq(i).text().replace(/,/g, ""));
				total_amount_done += Number($(".purchase_total_amount"+row+'Y').eq(i).text().replace(/,/g, ""));
			}
		}
		$("#sum_purchase_issuance_amount"+row).val(issuance_amount);
		$("#sum_purchase_tax_amount"+row).val(tax_amount);
		$("#sum_purchase_total_amount"+row).val(total_amount);

		$("#sum_purchase_issuance_amount_done"+row).val(issuance_amount_done);
		$("#sum_purchase_tax_amount_done"+row).val(tax_amount_done);
		$("#sum_purchase_total_amount_done"+row).val(total_amount_done);

		$("#sum_purchase_issuance_amount_yet"+row).val(issuance_amount - issuance_amount_done);
		$("#sum_purchase_tax_amount_yet"+row).val(tax_amount - tax_amount_done);
		$("#sum_purchase_total_amount_yet"+row).val(total_amount - total_amount_done);
		$("input[id^='sum_purchase']").change();

		var t_issuance_amount = 0;
		var t_tax_amount = 0;
		var t_total_amount =  0;
		var t_issuance_amount_done = 0;
		var t_tax_amount_done = 0;
		var t_total_amount_done = 0;
		for(var i=0; i < $("input[name=sum_purchase_issuance_amount]").length; i++){
			t_issuance_amount += Number($("input[name=sum_purchase_issuance_amount]").eq(i).val().replace(/,/g, ""));
			t_tax_amount += Number($("input[name=sum_purchase_tax_amount]").eq(i).val().replace(/,/g, ""));
			t_total_amount += Number($("input[name=sum_purchase_total_amount]").eq(i).val().replace(/,/g, ""));
			t_issuance_amount_done += Number($("input[name=sum_purchase_issuance_amount_done]").eq(i).val().replace(/,/g, ""));
			t_tax_amount_done += Number($("input[name=sum_purchase_tax_amount_done]").eq(i).val().replace(/,/g, ""));
			t_total_amount_done += Number($("input[name=sum_purchase_total_amount_done]").eq(i).val().replace(/,/g, ""));
		}
		$("#t_sum_purchase_issuance_amount").val(t_issuance_amount);
		$("#t_sum_purchase_tax_amount").val(t_tax_amount);
		$("#t_sum_purchase_total_amount").val(t_total_amount);
		$("#t_sum_purchase_issuance_amount_done").val(t_issuance_amount_done);
		$("#t_sum_purchase_tax_amount_done").val(t_tax_amount_done);
		$("#t_sum_purchase_total_amount_done").val(t_total_amount_done);
		$("#t_sum_purchase_issuance_amount_yet").val(t_issuance_amount - t_issuance_amount_done);
		$("#t_sum_purchase_tax_amount_yet").val(t_tax_amount - t_tax_amount_done);
		$("#t_sum_purchase_total_amount_yet").val(t_total_amount - t_total_amount_done);
		$("input[id^='t_sum_purchase_']").change();

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

function insert_memo() {
	$('#memo_popup').bPopup();
}

function save_memo() {
	$.ajax({
		type: "POST",
		url: "<?php echo site_url(); ?>/sales/maintain/save_memo",
		cashe: false,
		dataType: "json",
		async: false,
		data: {
			seq: $('#memo_seq').val(),
			maintain_seq: $('#seq').val(),
			memo: $("#memo").val()
		},
		success: function(data) {
			if(data) {
				alert('메모가 저장되었습니다.');
				location.reload();
			}
		}
	})
}

function generate_forcasting(seq) {
	if(confirm('유지보수 포캐스팅을 생성하시겠습니까?')) {
		$.ajax({
			type: "POST",
			url: "<?php echo site_url(); ?>/sales/maintain/generate_maintain_forcasting",
			cashe: false,
			dataType: "json",
			async: false,
			data: {
				seq: seq
			},
			success: function(data) {
				if(data) {
					alert('유지보수 포캐스팅이 생성되었습니다.');
					location.reload();
				}
			}
		})
	}
}
</script>
</body>

</html>

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
<link rel="stylesheet" href="/misc/css/view_page_common.css">
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
			mform.action = "<?php echo site_url(); ?>/tech/maintain/maintain_delete_action";
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

		rform.action = "<?php echo site_url(); ?>/tech/maintain/maintain_comment_action";
		rform.submit();
		return false;
	}

	function chkForm3(seq) {
		if (confirm("정말 삭제하시겠습니까?") == true) {
			var rform = document.rform;
			rform.cseq.value = seq;
			rform.action = "<?php echo site_url(); ?>/tech/maintain/maintain_comment_delete";
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
		<table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
			<tr height="5%">
				<td class="dash_title">
					유지보수
				</td>
			</tr>
			<tr>
				<td height="40"></td>
			</tr>
			<tr>
				<td align="right">
					<input type="button" class="btn-common btn-color2" value="목록" onClick="javascript:history.go(-1);">
				</td>
			</tr>
  		<tr>
    		<td width="100%" align="center" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" id="main_list">
						<form name="cform" action="<?php echo site_url(); ?>/tech/maintain/maintain_input_action" method="post" onSubmit="javascript:chkForm();return false;">
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
								<td class="tbl-sub-title">고객사 정보</td>
							</tr>
							<tr>
								<td colspan="10" height="1" bgcolor="#F4F4F4"></td>
							</tr>
							<tr class="tbl-tr">
								<td class="tbl-title">고객사</td>
								<td class="tbl-cell"><?php echo $view_val['customer_companyname']; ?></td>
								<td class="tbl-title">담당자</td>
								<td class="tbl-cell"><?php echo $view_val['customer_username']; ?></td>
								<td class="tbl-title">연락처</td>
								<td class="tbl-cell"><?php echo $view_val['customer_tel']; ?></td>
								<td class="tbl-title">이메일</td>
								<td colspan="2" class="tbl-cell"><?php echo $view_val['customer_email']; ?></td>
							</tr>
							<tr>
								<td colspan="10" height="1" bgcolor="#F4F4F4"></td>
							</tr>

							<tr><td height=30></td></tr>

							<tr>
								<td class="tbl-sub-title">영업 정보</td>
							</tr>
							<tr>
								<td colspan="10" height="1" bgcolor="#F4F4F4"></td>
							</tr>
							<tr class="tbl-tr">
								<td class="tbl-title">프로젝트</td>
								<td colspan="3" class="tbl-cell"><?php echo $view_val['project_name']; ?></td>
								<td class="tbl-title">연계프로젝트</td>
								<td colspan="3" class="tbl-cell">
						<?php if(count($sub_project_cancel)>0){?>
									<select class="select-common" style="width:100%;">
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
								<td colspan="10" height="1" bgcolor="#F4F4F4"></td>
							</tr>
							<tr class="tbl-tr">
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
									else if ($view_val['progress_step'] == "013") {echo "Spen in(70%)";}
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
								<td class="tbl-cell">
									<?php echo $view_val['dept'];?>
									<input name="cooperation_tel" type="hidden" class="input5" id="cooperation_tel" value="<?php echo $view_val['cooperation_tel']; ?>" />
								</td>
								<td class="tbl-cell"><input name="cooperation_email" type="hidden" class="input5" id="cooperation_email" value="<?php echo $view_val['cooperation_email']; ?>" /></td>
							</tr>
							<tr>
								<td colspan="10" height="1" bgcolor="#F4F4F4"></td>
							</tr>

							<tr><td height=30></td></tr>

							<tr>
								<td class="tbl-sub-title">
									<span onclick="modifyPopup(7);" style="cursor:pointer">
											점검 정보
											<img src="<?php echo $misc; ?>img/pencil_btn.png" width="15" height="15" style="margin-left:5px;"/>
									</span>
								</td>
							</tr>
							<tr>
								<td colspan="10" height="1" bgcolor="#F4F4F4"></td>
							</tr>
							<tr class="tbl-tr">
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
								<td class="tbl-cell">
									<?php if(empty($view_val['maintain_comment'])){echo ""; }else{echo nl2br($view_val['maintain_comment']); }; ?>
								</td>
							</tr>
							<tr>
								<td colspan="10" height="1" bgcolor="#F4F4F4"></td>
							</tr>
							<tr class="tbl-tr">
								<td class="tbl-title">점검일자</td>
								<td class="tbl-cell"><?php echo $view_val['maintain_date']; ?></td>
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
								<td colspan="4" class="tbl-cell">
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
								<td colspan="10" height="1" bgcolor="#F4F4F4"></td>
							</tr>

							<tr><td height=30></td></tr>
							<tr>
								<td class="tbl-sub-title">매출처 정보</td>
							</tr>
							<tr>
								<td colspan="10" height="1" bgcolor="#F4F4F4"></td>
							</tr>
							<tr class="tbl-tr">
								<td class="tbl-title">매출처</td>
								<td class="tbl-cell"><?php echo $view_val['sales_companyname']; ?></td>
								<td class="tbl-title">담당자</td>
								<td class="tbl-cell"><?php echo $view_val['sales_username']; ?></td>
								<td class="tbl-title">연락처</td>
								<td class="tbl-cell"><?php echo $view_val['sales_tel']; ?></td>
								<td class="tbl-title">이메일</td>
								<td class="tbl-cell"><?php echo $view_val['sales_email']; ?></td>
								<td class="tbl-title">납부회차</td>
								<td class="tbl-cell"><?php echo $view_val['sales_pay_session']; ?></td>
							</tr>
							<tr>
								<td colspan="10" height="1" bgcolor="#F4F4F4"></td>
							</tr>
							<?php
							$i = 0;
							$main_company_amount1 = 0;
							foreach ($view_val2 as $item2) {
								${"main_company_amount".($i+1)} = 0;
								if ($i == 0) {
							 ?>
							<tr id="main_insert_field_<?php echo $i; ?>">
								<td colspan="10" height="1" bgcolor="#F4F4F4"></td>
							</tr>

							<tr><td height=30></td></tr>
							<tr>
								<td class="tbl-sub-title">매입처 정보</td>
							</tr>
							<tr>
								<td colspan="10" height="1" bgcolor="#F4F4F4"></td>
							</tr>
							<tr id="main_insert_field_2_<?php echo $i; ?>" class="tbl-tr">
								<td class="tbl-title">매입처</td>
								<td class="tbl-cell"><?php echo $item2['main_companyname']; ?>
									<input name="main_seq" type="hidden" id="main_seq" value="<?php echo $item2['seq']; ?>" />
								</td>
								<td class="tbl-title">담당자</td>
								<td class="tbl-cell"><?php echo $item2['main_username']; ?></td>
								<td class="tbl-title">연락처</td>
								<td class="tbl-cell"><?php echo $item2['main_tel']; ?></td>
								<td class="tbl-title">이메일</td>
								<td class="tbl-cell"><?php echo $item2['main_email']; ?></td>
								<td class="tbl-title">납부회차</td>
								<td class="tbl-cell"><?php echo $item2['purchase_pay_session']; ?></td>
							</tr>
							<?php
							} else {
							?>
							<tr id="main_insert_field_<?php echo $i; ?>">
								<td colspan="10" height="1" bgcolor="#F4F4F4"></td>
							</tr>
							<tr id="main_insert_field_2_<?php echo $i; ?>" class="tbl-tr">
								<td class="tbl-title">매입처</td>
								<td class="tbl-cell"><?php echo $item2['main_companyname']; ?>
									<input name="main_seq" type="hidden" id="main_seq" value="<?php echo $item2['seq']; ?>" />
								</td>
								<td class="tbl-title">담당자</td>
								<td class="tbl-cell"><?php echo $item2['main_username']; ?></td>
								<td class="tbl-title">연락처</td>
								<td class="tbl-cell"><?php echo $item2['main_tel']; ?></td>
								<td class="tbl-title">이메일</td>
								<td class="tbl-cell"><?php echo $item2['main_email']; ?></td>
								<td class="tbl-title">납부회차</td>
								<td class="tbl-cell"><?php echo $item2['purchase_pay_session']; ?></td>
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
								<td colspan="10" height="1" bgcolor="#F4F4F4"></td>
							</tr>

							<tr><td height=30></td></tr>
							<tr>
								<td class="tbl-sub-title">제품 정보</td>
							</tr>
							<tr id="product_insert_field_<?php echo $j; ?>">
								<td colspan="10" height="1" bgcolor="#F4F4F4"></td>
							</tr>

							<tr id="product_insert_field_1_<?php echo $j; ?>" class="tbl-tr">
								<td class="tbl-title">프로젝트명</td>
								<td class="tbl-cell">
									<?php
									if($item3['integration_maintain_project_name'] != ""){
										echo $item3['integration_maintain_project_name'];
									}else{
										echo $item3['project_name']."(".$item3['exception_saledate'].")";
									}
									?>
								</td>
								<td class="tbl-title">제조사</td>
								<td class="tbl-cell"><?php echo $item3['product_company'];?></td>
								<td class="tbl-title">매입처</td>
								<td class="tbl-cell"><?php echo $item3['product_supplier']; ?></td>
								<td class="tbl-title">하드웨어/소프트웨어</td>
								<td class="tbl-cell">
									<?php
									if($item3['product_type'] == "hardware"){
										echo "하드웨어";
									}else if($item3['product_type'] == "software"){
										echo "소프트웨어";
									}else{
										echo "전체" ;
									}
									?>
								</td>
							</tr>

							<tr id="product_insert_field_2_<?php echo $j; ?>" class="tbl-tr">
								<td class="tbl-title">제품명</td>
								<td class="tbl-cell">
									<input type="hidden" name ="product_seq" id="product_seq" value="<?php echo $item3['seq']; ?>" />
									<?php echo $item3['product_name'] ;?>
								</td>
								<td class="tbl-title">라이선스</td>
								<td class="tbl-cell"><?php echo $item3['product_licence'];?></td>
								<td class="tbl-title">Serial</td>
								<td class="tbl-cell"><?php echo $item3['product_serial']; ?></td>
								<td class="tbl-title">제품 상태</td>
								<td class="tbl-cell">
									<?php
									if ($item3['product_state'] == "001") {
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

							<tr id="product_insert_field_3_<?php echo $j; ?>" class="tbl-tr">
								<td class="tbl-title">장비유지보수시작일</td>
								<td class="tbl-cell"><?php echo $item3['maintain_begin']; ?></td>
								<td class="tbl-title">장비유지보수만료일</td>
								<td class="tbl-cell"><?php echo $item3['maintain_expire'];?></td>
								<td class="tbl-title">유/무상</td>
								<td class="tbl-cell">
									<?php
									if ($item3['maintain_yn'] == "Y") {
										echo "유상";
									}else if($item3['maintain_yn'] == "N"){
										echo "무상";
									}else{
										echo "유/무상여부";
									}
									?>
								</td>
								<td class="tbl-title">유지보수 대상</td>
								<td class="tbl-cell">
									<?php
									if ($item3['maintain_target'] == "Y") {
										echo "대상";
									}else if ($item3['maintain_target'] == "N") {
										echo "비대상";
									}else{
										echo "유지보수 대상";
									}
									?>
									<input name="product_version" type="hidden" class="input5" id="product_version" value="<?php echo $item3['product_version']; ?>" />
									<input name="product_check_list" type="hidden" class="input5" id="product_check_list" value="<?php echo $item3['product_check_list']; ?>" />
									<input name="product_host" type="hidden" class="input5" id="product_host" value="<?php echo $item3['product_host']; ?>" />
									<input name="custom_title" type="hidden" class="input5" id="custom_title" value="<?php echo $item3['custom_title']; ?>" />
									<input name="custom_detail" type="hidden" class="input5" id="custom_detail" value="<?php echo $item3['custom_detail']; ?>" />
								</td>
							</tr>

							<tr id="product_insert_field_4_<?php echo $j; ?>" class="tbl-tr">
								<td class="tbl-title">유지보수매출가</td>
								<td class="tbl-cell">
									<?php
									if(trim($item3['product_sales']) == ""){
										echo $item3['product_sales'];
									}else{
										echo number_format($item3['product_sales']);
									}
									?>
								</td>
								<td class="tbl-title">유지보수매입가</td>
								<td class="tbl-cell">
									<?php
									if(trim($item3['product_purchase']) == ""){
										echo $item3['product_purchase'];
									}else{
										echo number_format($item3['product_purchase']);
									}
									?>
								</td>
								<td class="tbl-title">유지보수마진</td>
								<td class="tbl-cell">
									<?php
									if(trim($item3['product_profit']) == ""){
										echo $item3['product_profit'];
									}else{
										echo number_format($item3['product_profit']);
									}
									?>
								</td>
							</tr>
							<tr id="product_insert_field_<?php echo $j; ?>">
								<td colspan="10" height="1" bgcolor="#F4F4F4"></td>
							</tr>
							<?php
						} else {
							 ?>

							<tr id="product_insert_field_<?php echo $j; ?>">
 			            <td colspan="10" height="5" ></td>
 			        </tr>
							<tr id="product_insert_field_<?php echo $j; ?>">
								<td colspan="10" height="1" bgcolor="#F4F4F4"></td>
							</tr>
							<tr id="product_insert_field_1_<?php echo $j; ?>" class="tbl-tr">
								<td class="tbl-title">프로젝트명</td>
								<td class="tbl-cell"><?php if($item3['integration_maintain_project_name'] != ""){echo $item3['integration_maintain_project_name'];}else{echo $item3['project_name']."(".$item3['exception_saledate'].")";} ?></td>
								<td class="tbl-title">제조사</td>
								<td class="tbl-cell"><?php echo $item3['product_company']; ?></td>
								<td class="tbl-title">매입처</td>
								<td class="tbl-cell"><?php echo $item3['product_supplier']; ?></td>
								<td class="tbl-title">하드웨어/소프트웨어</td>
								<td class="tbl-cell">
									<?php
									if($item3['product_type'] == "hardware"){
                    echo "하드웨어";
                  }else if($item3['product_type'] == "software"){
                    echo "소프트웨어";
                  }else{
                    echo "전체" ;
                  }
	                ?>
								</td>
							</tr>
							<tr id="product_insert_field_2_<?php echo $j; ?>" class="tbl-tr">
								<td class="tbl-title">제품명</td>
								<td class="tbl-cell"><?php echo $item3['product_name'] ;?></td>
								<td class="tbl-title">라이선스</td>
								<td class="tbl-cell"><?php echo $item3['product_licence']; ?></td>
								<td class="tbl-title">Serial</td>
								<td class="tbl-cell"><?php echo $item3['product_serial']; ?></td>
								<td class="tbl-title">제품 상태</td>
								<td class="tbl-cell">
									<?php
									if ($item3['product_state'] == "001") {
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
							<tr id="product_insert_field_3_<?php echo $j; ?>" class="tbl-tr">
								<td class="tbl-title">장비유지보수시작일</td>
								<td class="tbl-cell"><?php echo $item3['maintain_begin']; ?></td>
								<td class="tbl-title">장비유지보수만료일</td>
								<td class="tbl-cell"><?php echo $item3['maintain_expire']; ?></td>
								<td class="tbl-title">유/무상</td>
								<td class="tbl-cell">
									<?php
									if ($item3['maintain_yn'] == "Y") {
                    echo "유상";
	                }else if($item3['maintain_yn'] == "N"){
                    echo "무상";
	                }else{
                    echo "유/무상여부";
	                }
									?>
								</td>
								<td class="tbl-title">유지보수 대상</td>
								<td class="tbl-cell">
									<?php
									if ($item3['maintain_target'] == "Y") {
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

							<tr id="product_insert_field_4_<?php echo $j; ?>" class="tbl-tr">
								<td class="tbl-title">유지보수매출가</td>
								<td class="tbl-cell"><?php if(trim($item3['product_sales']) == ""){echo $item3['product_sales'];}else{ echo number_format($item3['product_sales']);} ?></td>
								<td class="tbl-title">유지보수매입가</td>
								<td class="tbl-cell"><?php if(trim($item3['product_purchase']) == ""){echo $item3['product_purchase'];}else{echo number_format($item3['product_purchase']);} ?></td>
								<td class="tbl-title">유지보수마진</td>
								<td class="tbl-cell"><?php if(trim($item3['product_profit']) == ""){echo $item3['product_profit'];}else{echo number_format($item3['product_profit']);} ?></td>
							</tr>
							<tr id="product_insert_field_<?php echo $j; ?>">
			          <td colspan="10" height="1" bgcolor="#F4F4F4"></td>
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
								<td id="productEnd" colspan="10" height="0" bgcolor="#F4F4F4"></td>
							</tr>
							<tr>
							    <td colspan="10" height="20"></td>
							</tr>
							<tr>
			          <td colspan="10" height="1" bgcolor="#F4F4F4"></td>
			        </tr>
							<tr class="tbl-tr">
								<td class="tbl-title">유지보수총매출가</td>
								<td class="tbl-cell"><?php echo number_format($view_val['forcasting_sales']); ?></td>
								<td class="tbl-title">유지보수총매입가</td>
								<td class="tbl-cell"><?php echo number_format($view_val['forcasting_purchase']); ?></td>
								<td class="tbl-title">유지보수총마진</td>
								<td class="tbl-cell"><?php echo number_format($view_val['forcasting_profit']); ?></td>
								<td class="tbl-title">분할월수</td>
								<td class="tbl-cell">
									<?php
									if ($view_val['division_month'] == "12") {
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

							<tr class="tbl-tr">
								<td class="tbl-title">고객사유지보수시작일</td>
								<td class="tbl-cell"><?php echo $view_val['exception_saledate2']; ?></td>
								<td class="tbl-title">고객사유지보수종료일</td>
								<td class="tbl-cell"><?php echo $view_val['exception_saledate3']; ?></td>
							</tr>
							<tr>
			          <td colspan="10" height="1" bgcolor="#F4F4F4"></td>
			        </tr>

							<tr><td height=30></td></tr>
							<tr>
								<td class="tbl-sub-title">수주 정보</td>
							</tr>
							<tr>
			          <td colspan="10" height="1" bgcolor="#F4F4F4"></td>
			        </tr>
							<tr class="tbl-tr">
								<td class="tbl-title">수주여부</td>
								<td colspan="3" class="tbl-cell">
									<?php
									if ($view_val['complete_status'] == "001") {
				            echo "수주중";
					        }else if ($view_val['complete_status'] == "002") {
				            echo "수주완료";
					        } ?>
							</td>
							</tr>
							<tr>
			          <td colspan="10" height="1" bgcolor="#F4F4F4"></td>
			        </tr>
							<tr>
								<td height=30></td>
							</tr>
							<tr>
								<td colspan="10">
									<table id="sales_statement_table" class="bill_tbl" width="100%" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
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
											<td height=30></td>
										</tr>
										<tr>
											<td class="tbl-sub-title no-border">계산서 발행 정보</td>
										</tr>
										<tr>
						          <td colspan="10" height="1" bgcolor="#F4F4F4"></td>
						        </tr>
										<tr class="tbl-tr">
											<td colspan="10" class="tbl-title basic_td" style="margin-bottom:thin solid #F4F4F4;background-color:#DEDEDE;">매출</td>
										</tr>
										<tr class="tbl-tr">
											<td colspan="2" class="tbl-title basic_td">계약금액</td>
											<td class="tbl-title basic_td">회차</td>
											<td class="tbl-title basic_td">발행금액</td>
											<td class="tbl-title basic_td">국세청 승인번호</td>
											<td class="tbl-title basic_td">해당월</td>
											<td class="tbl-title basic_td">발행일자</td>
											<td class="tbl-title basic_td">발행여부</td>
											<td class="tbl-title basic_td">입금일자</td>
											<td class="tbl-title basic_td">입금여부</td>
										</tr>
						<?php if(empty($bill_val) || $sales_cnt == 0){?>
										<tr class="insert_sales_bill tbl-tr">
											<td id="sales_contract_total_amount" rowspan="1" colspan="2" class="basic_td" align="center">
												<?php echo number_format($view_val['forcasting_sales']); ?>
											</td>
											<td colspan=8 class="basic_td" height="40"> - 등록된 계산서가 없습니다.</td>
										</tr>
									<?php
									}
									if($sales_cnt > 0){
										$row = 1;
										foreach($bill_val as $bill){
											if($bill['type'] == "001"){//매출
												if($row == 1){
									?>
										<tr id="bill_<?php echo $bill['seq']; ?>" class="update_sales_bill tbl-tr" >
											<td id="sales_contract_total_amount" rowspan="1" colspan="2" class="basic_td" align="center"><?php echo number_format($view_val['forcasting_sales']); ?></td>
											<td class="basic_td" align="center"><?php echo $bill['pay_session']; ?> </td>
											<td class="basic_td" align="right"><?php if($bill['issuance_amount'] == ""){echo $bill['issuance_amount'];}else{echo number_format($bill['issuance_amount']);} ?></td>
											<td class="basic_td" align="center"><?php echo $bill['tax_approval_number']; ?></td>
											<td class="basic_td" align="center"><?php echo $bill['issuance_month']; ?></td>
											<td class="basic_td" align="center"><?php echo $bill['issuance_date']; ?></td>
											<td class="basic_td" align="center">
												<?php if($bill['issuance_status'] == "Y"){
													echo "완료";
												}else{
													echo "미완료";
												} ?>
											</td>
											<td class="basic_td" align="center"><?php echo $bill['deposit_date']; ?></td>
											<td class="basic_td" align="center">
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
										<tr id="bill_<?php echo $bill['seq']; ?>" class="update_sales_bill tbl-tr" >
											<td class="basic_td" align="center"><?php echo $bill['pay_session']; ?> </td>
											<td class="basic_td" align="right"><?php if($bill['issuance_amount'] == ""){echo $bill['issuance_amount'];}else{echo number_format($bill['issuance_amount']);} ?></td>
											<td class="basic_td" align="center"><?php echo $bill['tax_approval_number']; ?></td>
											<td class="basic_td" align="center"><?php echo $bill['issuance_month']; ?></td>
											<td class="basic_td" align="center"><?php echo $bill['issuance_date']; ?></td>
											<td class="basic_td" align="center">
												<?php if($bill['issuance_status'] == "Y"){
													echo "완료";
												}else{
													echo "미완료";
												} ?>
											</td>
											<td class="basic_td" align="center"><?php echo $bill['deposit_date']; ?></td>
											<td class="basic_td" align="center">
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
										<tr id="sales_issuance_amount_insert_line" class="tbl-tr">
											<td colspan="10" class="basic_td tbl-title" style="background-color:#DEDEDE;">매입</td>
										</tr>
										<tr>
											<td class="basic_td tbl-title">업체</td>
											<td class="basic_td tbl-title">계약금액</td>
											<td class="basic_td tbl-title">회차</td>
											<td class="basic_td tbl-title">발행금액</td>
											<td class="basic_td tbl-title">국세청 승인번호</td>
											<td class="basic_td tbl-title">해당월</td>
											<td class="basic_td tbl-title">발행일자</td>
											<td class="basic_td tbl-title">발행여부</td>
											<td class="basic_td tbl-title">입금일자</td>
											<td class="basic_td tbl-title">입금여부</td>
										</tr>
							<?php
							$num = 1;
							foreach ($view_val2 as $item2) {?>
										<tr class="purchase_tax_invoice<?php echo $num; ?> insert_purchase_bill tbl-tr">
											<td class="purchase_contract_total_amount<?php echo $num; ?> basic_td"
												align="center"><?php echo $item2['main_companyname']; ?></td>
											<td id="purchase_contract_total_amount<?php echo $num; ?>" rowspan="1"
												class="purchase_contract_total_amount<?php echo $num; ?> basic_td" align="center"><?php echo number_format(${"main_company_amount".$num}); ?></td>
											<td colspan=8 class="basic_td"> - 등록된 계산서가 없습니다.</td>
										</tr>
							<?php
							$num++;
							}?>
						<?php
						}
						if($purchase_cnt > 0){ ?>
										<tr id="sales_issuance_amount_insert_line" class="tbl-tr">
											<td colspan="10" class="basic_td tbl-title" style="background-color:#DEDEDE;">매입</td>
										</tr>
										<tr class="tbl-tr">
											<td class="basic_td tbl-title">업체</td>
											<td class="basic_td tbl-title">계약금액</td>
											<td class="basic_td tbl-title">회차</td>
											<td class="basic_td tbl-title">발행금액</td>
											<td class="basic_td tbl-title">국세청 승인번호</td>
											<td class="basic_td tbl-title">해당월</td>
											<td class="basic_td tbl-title">발행일자</td>
											<td class="basic_td tbl-title">발행여부</td>
											<td class="basic_td tbl-title">입금일자</td>
											<td class="basic_td tbl-title">입금여부</td>
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
					 					<tr id="bill_<?php echo $bill['seq']; ?>" class="purchase_tax_invoice<?php echo $num; ?> update_purchase_bill tbl-tr">
											<td class="purchase_contract_total_amount<?php echo $num; ?> basic_td"
												align="center"><?php echo $bill['company_name']; ?></td>
											<td id="purchase_contract_total_amount<?php echo $num; ?>" rowspan="1"
												class="purchase_contract_total_amount<?php echo $num; ?> basic_td"
												align="center"><?php echo number_format(${"main_company_amount".$num}); ?></td>
											<td class="basic_td" align="center"><?php echo $bill['pay_session']; ?></td>
											<td class="basic_td" align="right">
											<?php if($bill['issuance_amount'] == ""){echo $bill['issuance_amount'];}else{echo number_format($bill['issuance_amount']);} ?>
											</td>
											<td class="basic_td" align="center"><?php echo $bill['tax_approval_number']; ?></td>
											<td class="basic_td" align="center"><?php echo $bill['issuance_month']; ?></td>
											<td class="basic_td" align="center"><?php echo $bill['issuance_date']; ?></td>
											<td class="basic_td" align="center">
												<?php if($bill['issuance_status'] == "Y"){
													echo "완료";
												}else{
													echo "미완료";
												} ?>
											</td>
											<td class="basic_td" align="center"><?php echo $bill['deposit_date'];?></td>
											<td class="basic_td" align="center">
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
										<tr id="bill_<?php echo $bill['seq']; ?>" class="purchase_tax_invoice<?php echo $num; ?> update_purchase_bill tbl-tr">
											<td class="basic_td" align="center"><?php echo $bill['pay_session']; ?></td>
											<td class="basic_td" align="right"><?php if($bill['issuance_amount'] == ""){echo $bill['issuance_amount'];}else{echo number_format($bill['issuance_amount']);} ?></td>
											<td class="basic_td" align="center"><?php echo $bill['tax_approval_number']; ?></td>
											<td class="basic_td" align="center"><?php echo $bill['issuance_month']; ?></td>
											<td class="basic_td" align="center"><?php echo $bill['issuance_date']; ?></td>
											<td class="basic_td" align="center">
												<?php if($bill['issuance_status'] == "Y"){
													echo "완료";
												}else{
													echo "미완료";
												} ?>
											</td>
											<td class="basic_td" align="center"><?php echo $bill['deposit_date']; ?></td>
											<td class="basic_td" align="center">
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

<!-- 댓글 -->
		<table width="95%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:20px;">
			<form name="rform" method="post">
			<input type="hidden" name="seq" value="<?php echo $seq;?>">
			<input type="hidden" name="cseq" value="">
			<tr>
				<td class="tbl-sub-title">댓글</td>
			</tr>
		<?php
			foreach ( $clist_val as $item ) {
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
								<?php if($id == $item['user_id'] or $tech_lv == 3) {?>
									<img src="<?php echo $misc;?>img/btn_del.svg" width="18" height="17" style="cursor:pointer" border="0" onClick="javascript:chkForm3('<?php echo $item['seq']?>');return false;"/>
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
		<div style="width:95%;">
			<input type="button" class="btn-common btn-style1" value="답변등록" onClick="javascript:chkForm2();return false;" style="float:right;margin-bottom:50px;width:90px;">
		</div>

		</table>
	</div>
</div>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
</body>
<script src="//cdnjs.cloudflare.com/ajax/libs/babel-standalone/6.26.0/babel.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/babel-polyfill/7.4.3/polyfill.js"></script>
<script type="text/babel" data-presets="es2015, stage-3">
	var mb_cnt = Number($("#row_max_index2").val());

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
				url: "<?php echo site_url();?>/tech/maintain/maintain_complete_status_comment_delete",
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
				url: "<?php echo site_url();?>/tech/maintain/maintain_complete_status_comment_insert",
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
				url: "<?php echo site_url();?>/tech/maintain/maintain_complete_status_file_upload",
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
							url: "<?php echo site_url();?>/tech/maintain/maintain_complete_status_comment_insert",
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
				location.href = "<?php echo site_url(); ?>tech/maintain/maintain/maintain_complete_status_filedel/" + seq + "/" + filename;
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
        window.open("<?php echo site_url(); ?>/tech/maintain/maintain_modify?seq=<?php echo $view_val['seq'] ;?>&type="+type,"","width = 1000, height = 500, scrollbars=1");
	}

	// 통합유지보수 리스트
	function integration_maintain(){
		window.open("<?php echo site_url(); ?>/tech/maintain/integration_maintain_list","","width = 1000, height = 500, scrollbars=1");
	}

	//유지보수 갱신
	function renewal(){
		var integration_maintain = confirm("통합유지보수를 유지하시겠습니까?");
		var project_name = prompt("갱신할 유지보수의 프로젝트명을 입력해주세요.");

		$.ajax({
			type: "POST",
			cache: false,
			url: "<?php echo site_url();?>/tech/maintain/maintain_renewal",
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
					location.href = "<?php echo site_url(); ?>/tech/maintain/maintain_view?seq="+data;
				}else{
					alert("유지보수 갱신 실패");
				}
			}
		});

	}
</script>
</html>

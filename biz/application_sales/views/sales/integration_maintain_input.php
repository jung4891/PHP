<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
if(isset($_GET['seq'])){
	$seq = $_GET['seq'];
}
?>
<style>
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
<body>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/js/select2.min.js"></script>
    <table width="100%" height="100%" cellspacing="0" cellpadding="0" style="padding:30px 30px 30px 30px" >
        <tr>
            <td width="100%" align="center" valign="top">
            <table width="100%" border="0" style="margin-top:50px; margin-bottom: 50px;">
              <!--타이틀-->
              <tr>
				<?php if(isset($seq)){
					echo '<td class="title3">통합 유지보수 수정</td>';
				}else{
					echo '<td class="title3">통합 유지보수 등록</td>';
				}?>
              </tr>
              <!--타이틀-->
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td id="tablePlus">
					<table class="basic_table" width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td colspan="16" height="2" bgcolor="#797c88"></td>
						</tr>
						<tr class="t_top">
							<td height=40 align="center" bgcolor="f8f8f9" class="basic_td">프로젝트명</td>
							<td class="basic_td"><input type="text" class="input7" id="project_name" name="project_name" value="<?php if(isset($seq)){echo $view_val['project_name'];}?>" /></td>
						</tr>
					</table>
           		 </td>
       		  </tr>
			  <tr>
			  	<td height="40"></td>
			  </tr>
				<tr>
					<td height="40" style="font-weight:bold;font-size:13px;">제품 정보
						<div style="float:right;">
							<a href='<?php echo $misc;?>upload/sales/product_registration_form.xlsx' download='product_registration_form.xlsx'>
							<!-- <a href='D:\/product_registration_form.xlsx' download='product_registration_form.xlsx'> -->
								<input type="button" class="basicBtn" value="제품등록 엑셀 폼">
							</a>
							<input type="button" class="basicBtn" value="제품등록 엑셀 업로드" onclick="$('#product_registration_file').click();">
							<input id="product_registration_file" type="file" onchange="readExcel();" style="display:none;"/>
						
						</div>
						<input type="hidden" id="row_max_index2" name="row_max_index2" value="<?php if(isset($seq)){echo (count($view_val2)-1);} ?>" />
						<input type="hidden" id="update_product_array" name="update_product_array" />
						<input type="hidden" id="insert_product_array" name="insert_product_array" />
						<input type="hidden" id="delete_product_array" name="delete_product_array" />
					</td>
				</tr>
				<tr>
					<td colspan=2 height="40" align="left" style="padding:0px 0px 30px 30px;">
					<span style="font-weight:bold;">* 일괄적용</span> <br>
						<table>
							<tr>
								<td>제조사</td>
								<td>
									<!-- <select id="check_product_company" class="input2" onchange="productSearch('check');">
										<option value="" >제조사</option>
										<?php foreach($product_company as $pc){
											echo "<option value='{$pc['product_company']}'>{$pc['product_company']}</option>";
										}?>
									</select> -->
									<input id="check_product_company" class="input2" onchange="productSearch('check');" />
								</td>
								<td><input type="button" class="input5" value="선택적용" onclick="collectiveApplication('product_company',0);" style="margin-right:30px;" /></td>
								<td>제품명</td>
								<td>
									<!-- <select id="check_product_name" class="input2" onclick="productSearch('check');">
										<option value="" selected>제조사를 선택해주세요</option>
									</select> -->
									<input id="check_product_name" class="input2" onclick="productSearch('check');" />
								</td>
								<td><input type="button" class="input5" value="선택적용" onclick="collectiveApplication('product_name',0);" style="margin-right:30px;" /></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td><input type="checkbox" id="allCheck" />전체 </td>
					<td colspan = 8></td>
				</tr>
				<tr>
					<td>
						<table style="width:100%;border-collapse:collapse">
							<?php if(!isset($seq)){ ?>
							<tr class="product_insert_field_0">
								<td colspan="9" height="1" bgcolor="#e8e8e8"></td>
							</tr>
							<tr>
								<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;"><input type="checkbox" name="product_row" value="0" />제조사</td>
								<td align="left" class="t_border" style="padding-left:10px;">
									<!-- <select name="product_company" id="product_company0" class="input2" onchange="productSearch(0);product_type_default();" >
										<option value="">제조사</option>
										<?php foreach($product_company as $pc){
											echo "<option value='{$pc['product_company']}'>{$pc['product_company']}</option>";
										}?>
									</select> -->
									<input name="product_company" id="product_company0" class="input2" />
								</td>
								<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">하드웨어/소프트웨어</td>
								<td align="left" class="t_border" style="padding-left:10px;" colspan="1">
									<!-- <select name="product_type" id="product_type0" class="input2" onchange="productSearch(0);">
										<option value="">전체</option>
										<option value="hardware">하드웨어</option>
										<option value="software">소프트웨어</option>
									</select> -->
									<input name="product_type" id="product_type0" class="input5" />
								</td>
								<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">품목(용도)</td>
								<td align="left" class="t_border" style="padding-left:10px;" colspan="1">
									<input name="product_item" id="product_item0" class="input5" />
								</td>
							</tr>
							<tr class="product_insert_field_0">
								<td  height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">제품명</td>
								<td align="left" class="t_border" style="padding-left:10px;" colspan="1">
									<!-- <select name ="product_name" id="product_name0" class="input2" onclick="productSearch(0);">
										<option value="" >제품선택</option>
									</select> -->
									<input name ="product_name" id="product_name0" class="input2" />
								</td>
								<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">라이선스</td>
								<td align="left" class="t_border" style="padding-left:10px;"><input name="product_licence" type="text" class="input5" id="product_licence0" onkeyup ="commaCheck(this);" /> </td>
								<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">Serial</td>
								<td align="left" class="t_border" style="padding-left:10px;"><input name="product_serial" type="text" class="input5" id="product_serial0" onkeyup ="commaCheck(this);" /> </td>
								<td align="center" colspan="1"><img src="<?php echo $misc; ?>img/btn_add.jpg" id="product_add" name="product_add" style="cursor:pointer;" onclick="productAdd();" /></td>
							</tr>
							<tr>
								<td colspan="9" height="1" bgcolor="#e8e8e8"></td>
							</tr>
							<?php }else{ 
								$idx = 0;
								foreach($view_val2 as $item){?>
									<tr class="product_insert_field_<?php echo $idx; ?>">
										<td colspan="9" height="1" bgcolor="#e8e8e8">
											<input type="hidden" name="product_seq" value="<?php echo $item['seq']; ?>">
										</td>
									</tr>
									<tr class="product_insert_field_<?php echo $idx; ?>">
										<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;"><input type="checkbox" name="product_row" value="<?php echo $idx;?>" />제조사</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<!-- <select name="product_company" id="product_company<?php echo $idx;?>" class="input2" onchange="productSearch(<?php echo $idx;?>);product_type_default();" >
												<option value="">제조사</option>
												<?php foreach($product_company as $pc){
													echo "<option value='{$pc['product_company']}'";
													if($pc['product_company'] == $item['product_company']){
														echo "selected";
													}
													echo ">{$pc['product_company']}</option>";
												}?>
											</select> -->
											<input name="product_company" id="product_company<?php echo $idx;?>" class="input2" value="<?php echo $item['product_company']; ?>" >
										</td>
										<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">하드웨어/소프트웨어</td>
										<td align="left" class="t_border" style="padding-left:10px;" colspan="1">
											<!-- <select name="product_type" id="product_type<?php echo $idx;?>" class="input2" onchange="productSearch(<?php echo $idx;?>);">
												<option value="" <?php if($item['product_type'] == "" ){echo "selected";}?>>전체</option>
												<option value="hardware" <?php if($item['product_type'] == "hardware" ){echo "selected";}?>>하드웨어</option>
												<option value="software" <?php if($item['product_type'] == "software" ){echo "selected";}?>>소프트웨어</option>
											</select> -->
											<input name="product_type" id="product_type<?php echo $idx;?>" class="input5" value="<?php echo $item['product_type']; ?>" />
										</td>
										<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">품목(용도)</td>
										<td align="left" class="t_border" style="padding-left:10px;" colspan="1">
											<input name="product_item" id="product_item<?php echo $idx;?>" class="input5" value="<?php echo $item['product_item']; ?>" />
										</td>
									</tr>
									<tr class="product_insert_field_<?php echo $idx; ?>">
										<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">제품명</td>
										<td align="left" class="t_border" style="padding-left:10px;" colspan="1">
											<!-- <select name ="product_name" id="product_name<?php echo $idx;?>" class="input2" onclick="productSearch(<?php echo $idx;?>);">
												<option value="<?php echo $item['product_code'] ;?>" selected> <?php echo $item['product_name'] ;?></option>
											</select> -->
											<input name ="product_name" id="product_name<?php echo $idx;?>" value="<?php echo $item['product_name'] ;?>" class="input2" />
										</td>
										<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">라이선스</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<input name="product_licence" type="text" class="input5" id="product_licence<?php echo $idx;?>" value="<?php echo $item['product_licence']; ?>" onkeyup ="commaCheck(this);" /> 
										</td>
										<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">Serial</td>
										<td align="left" class="t_border" style="padding-left:10px;"><input name="product_serial" type="text" class="input5" id="product_serial<?php echo $idx;?>" value="<?php echo $item['product_serial']; ?>" onkeyup ="commaCheck(this);" /> </td>
										<td align="center">
											<?php if($idx == 0){ ?>
												<img src="<?php echo $misc; ?>img/btn_add.jpg" id="product_add" name="product_add" style="cursor:pointer;" onclick="productAdd();" />
											<?php }else{ ?>
												<img src="<?php echo $misc; ?>img/btn_del0.jpg" style="cursor:pointer;" onclick='product_list_del(<?php echo $idx.",".$item['seq']; ?>);' />
											<?php } ?>	
										</td>
									</tr>
									<script>
										// $("#product_company<?php echo $idx;?>").select2();
									</script>
								<?php $idx++; }} ?>
								<tr>
									<td colspan="9" height="1" bgcolor="#e8e8e8"></td>
								</tr>
								<tr id="insert_product_line">
									<td></td>
								</tr>
						</table>
					</td>
				</tr>
				</table>
			 <tr>
				<td align="right">
					<span style="margin-top:30px;">
						<img src="<?php echo $misc;?>img/btn_cancel.jpg" width="64" height="31" style="cursor:pointer;" onclick="location.href='<?php echo site_url();?>/sales/maintain/integration_maintain_list'"/>
						<img src="<?php echo $misc;?>img/btn_ok.jpg" width="64" height="31" style="cursor:pointer;" onclick="chkForm(<?php if(isset($seq)){echo 1;}else{echo 0;}?>);"/>
					</span>
				</td>
			 </tr>
     </table>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.15.5/xlsx.full.min.js"></script>
<script>
	//select box 검색 기능
	// check_product_company
	// $("#check_product_company").select2();
	// $("#product_company0").select2();

    function productAdd(){
		$("#row_max_index2").val(Number(Number($("#row_max_index2").val()) + Number(1)));
		var id = "product_insert_field_" + $("#row_max_index2").val();
		var html = "";
		html += '<tr class=' + id + '><td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;"><input type="checkbox" name="product_row" value="'+$("#row_max_index2").val()+'"/>제조사</td><td align="left" class="t_border" style="padding-left:10px;" colspan="1">';
		html += '<input name="product_company" id="product_company'+$("#row_max_index2").val()+'" class="input2" /></td>';

		html += '<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">하드웨어/소프트웨어</td><td align="left" class="t_border" style="padding-left:10px;">';
		// html += '<select name="product_type" id="product_type'+$("#row_max_index2").val()+'" class="input2" onchange="productSearch('+$("#row_max_index2").val()+');"><option value="">전체</option><option value="hardware">하드웨어</option><option value="software">소프트웨어</option></select></td></tr>'
		html += '<input name="product_type" id="product_type'+$("#row_max_index2").val()+'" class="input2" /></td>'
		html += '<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">항목(용도)</td><td align="left" class="t_border" style="padding-left:10px;">';
		html += '<input name="product_item" id="product_item'+$("#row_max_index2").val()+'" class="input2" /></td></tr>'

		
		html += '<tr class='+id+'><td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">제품명</td><td align="left" class="t_border" style="padding-left:10px;" colspan="1">'
		// html += '<select name ="product_name" id="product_name'+$("#row_max_index2").val()+'" class="input2" onclick="productSearch('+$("#row_max_index2").val()+');"><option value="" >제품선택</option></select></td>';
		html += '<input name ="product_name" id="product_name'+$("#row_max_index2").val()+'" class="input2" /></td>';
		html += "<td height='40' align='center' bgcolor='f8f8f9' class='t_border' style='font-weight:bold;'>라이선스</td><td align='left' class='t_border' style='padding-left:10px;'><input name='product_licence' type='text' class='input5' id='product_licence"+$("#row_max_index2").val()+"' onkeyup ='commaCheck(this);' /> </td><td height='40' align='center' bgcolor='f8f8f9' class='t_border' style='font-weight:bold;'>Serial</td><td align='left' class='t_border' style='padding-left:10px;'><input name='product_serial' type='text' class='input5' id='product_serial"+$("#row_max_index2").val()+"' onkeyup ='commaCheck(this);' /></td>";
		html += "<td align='center'  colspan='1' ><img src='<?php echo $misc; ?>img/btn_del0.jpg' style='cursor:pointer;' onclick='javascript:product_list_del(" + $("#row_max_index2").val() + ");'/></td></tr>";
		html += "<tr class=" + id + "><td colspan='9' height='1' bgcolor='#e8e8e8'></td></tr>"
		$('#insert_product_line').before(html);
		// $("#product_company"+$("#row_max_index2").val()).select2();
	}

	function selectSalesCompany() {
		$("#sales_companyname").val($("#select_sales_company option:selected").text());
		var seq = $("#select_sales_company option:selected").val();
		$.ajax({
			type: "POST",
			cache: false,
			url: "<?php echo site_url();?>/ajax/sales_customer_staff",
			dataType: "json",
			async: false,
			data: {
				seq: seq
			},
			success: function (data) {
				var html = "<option value='' selected>담당자 선택</option>";
				for (i = 0; i < data.length; i++) {
					html += "<option value=" + data[i].seq + ">" + data[i].user_name + "</option>"
				}
				$("#select_sales_user").html(html);

				$("#select_sales_user").change(function () {
					$("#sales_username").val($("#select_sales_user option:selected").text());
					for (i = 0; i < data.length; i++) {
						if ($("#select_sales_user").val() == data[i].seq) {
							$("#sales_tel").val(data[i].user_tel);
							$("#sales_tel").click();
							$("#sales_email").val(data[i].user_email);
						}
					}
				})
			}
		});
	}

	function productSearch(idx) {
		if(idx == "check"){
			var productCompany = $("#"+idx+"_product_company").val();
			var productType = $("#"+idx+"_product_type").val();
			$.ajax({
				type: "POST",
				cache: false,
				url: "<?php echo site_url();?>/ajax/product_search",
				dataType: "json",
				async: false,
				data: {
					productCompany: productCompany,
					productType: productType
				},
				success: function (data) {
					var html = "<option value=''>제품선택</option>";
					for (i = 0; i < data.length; i++) {
						html += "<option value ='" + data[i].seq + "'>" + data[i].product_name + "</option>";
					}
					$("#"+idx+"_product_name").html(html);
					// $("#"+idx+"_product_name").select2();
				}
			});

		}else{
			if(idx == undefined){
				idx='';
			}
			var productCompany = $("#product_company"+idx).val();
			var productType = $("#product_type"+idx).val();

			$.ajax({
				type: "POST",
				cache: false,
				url: "<?php echo site_url();?>/ajax/product_search",
				dataType: "json",
				async: false,
				data: {
					productCompany: productCompany,
					productType:productType
				},
				success: function (data) {
					var html = "<option value=''>제품선택</option>";
					for(i=0; i<data.length; i++){
						html += "<option value ='"+ data[i].seq +"'>" + data[i].product_name + "</option>";
					}
					$("#product_name"+idx).html(html);
					// $("#product_name"+idx).select2();
				}
			});
		}
	}

	//일괄적용
	function collectiveApplication(column,tagName){
		if($('input:checkbox[name="product_row"]:checked').length > 0){
			if(confirm("일괄수정 하시겠습니까?")){
				// if(column == "product_name"){
				// 	$('input:checkbox[name="product_row"]').each(function () {
				// 		if (this.checked == true) {
				// 			// var idx ='';
				// 			// if(this.value != 0){
				// 				idx = this.value;
				// 			// }
				// 			if($("#product_company"+idx).val() != $("#check_product_company").val()){
				// 				alert("제조사 먼저 선택적용 해주세요.");
				// 				return false;
				// 			}
				// 		} 
				// 	});
				// }
				$('input:checkbox[name="product_row"]').each(function () {
					if (this.checked == true) {
						var val = $("#check_"+column).val();
						if(tagName == 0){//input
							$("#"+column+this.value).val(val);
							$("#"+column+this.value).trigger('change');
						}else if(tagName == 1){//select
							$("#"+column+this.value).val(val).prop("selected",true);
						}else{//select2
							$("#"+column+this.value).val(val).prop("selected",true);
							// $("#"+column+this.value).select2().val(val);
							$("#"+column+this.value).trigger('change');
						}
					}
				});
			}
		}else{
			alert("선택된 제품이 없습니다.")
			return false;
		}
	}

	//전체선택 체크박스 클릭 
	$(function () {
		$("#allCheck").click(function () { //만약 전체 선택 체크박스가 체크된상태일경우 
			if ($("#allCheck").prop("checked")) { //해당화면에 전체 checkbox들을 체크해준다 
				$("input[name=product_row]").prop("checked", true); // 전체선택 체크박스가 해제된 경우 
			} else { //해당화면에 모든 checkbox들의 체크를해제시킨다. 
				$("input[name=product_row]").prop("checked", false);
			}
		})
	})

	//제조사 바뀌면 하드웨어 소프트웨어 전체로 수정
	function product_type_default(idx){
		if(idx == undefined){
			idx = '';
		}else{
			idx = idx;
		}
		$("#product_type"+idx).val("");
	}

	function product_list_del(idx,product_seq) {
		if(product_seq){
			$("#delete_product_array").val($("#delete_product_array").val()+","+product_seq)
		}
		$(".product_insert_field_" + idx).remove();
		// $("#product_insert_field_0_" + idx).remove();
		// $("#product_insert_field_1_" + idx).remove();
		// $("#product_insert_field_2_" + idx).remove();
		// $("#product_insert_field_3_" + idx).remove();
		// $("#product_insert_field_4_" + idx).remove();
		// t_forcasting_profit_change();
		// $("#row_max_index2").val(Number(Number($("#row_max_index2").val()) - Number(1)));
	}

	//콤마제거
	function commaCheck(obj){
		if(($(obj).val()).indexOf(',') != -1){
			alert(', 를 입력하실 수 없습니다.');
			$(obj).val($(obj).val().replace(',',''));
		}
	}


	function chkForm(type){
		var objproduct_seq = document.getElementsByName("product_seq");
		var objproduct_name = document.getElementsByName("product_name");
		var objproduct_company = document.getElementsByName("product_company");
		var objproduct_type = document.getElementsByName("product_type");
		var objproduct_serial = document.getElementsByName("product_serial");
		var objproduct_licence = document.getElementsByName("product_licence");
		var objproduct_item = document.getElementsByName("product_item");
		$("#update_product_array").val('');
		if (objproduct_seq.length > 0) {
			for (var i = 0; i < objproduct_seq.length; i++) {
				$("#update_product_array").val($("#update_product_array").val() + "||" + objproduct_name[i].value + "~" + objproduct_company[i].value + "~" + objproduct_type[i].value + "~" + objproduct_licence[i].value + "~" + objproduct_serial[i].value + "~" + objproduct_item[i].value + "~" + objproduct_seq[i].value);
			}
		}

		$("#insert_product_array").val('');
		if (objproduct_name.length > objproduct_seq.length) {
			for (i = objproduct_seq.length; i < objproduct_name.length; i++) {
				$("#insert_product_array").val($("#insert_product_array").val() + "||"  + objproduct_name[i].value + "~" + objproduct_company[i].value + "~" + objproduct_type[i].value + "~" + objproduct_licence[i].value + "~" + objproduct_serial[i].value + "~" + objproduct_item[i].value);
			}
		}
		
		$.ajax({
			type: "POST",
			cache: false,
			url: "<?php echo site_url(); ?>/sales/maintain/integration_maintain_input_action",
			dataType: "json",
			async: false,
			data: {
				seq:<?php if(isset($seq)){echo $seq;}else{echo "null";} ?>,
				type : type,
				project_name: $("#project_name").val(),
				insert_product_array: $("#insert_product_array").val(),
				update_product_array: $("#update_product_array").val(),
				delete_product_array: $("#delete_product_array").val()
			},
			success: function(data) {
				if(data){
					alert("ok");
					location.href="<?php echo site_url();?>/sales/maintain/integration_maintain_list";
				}else{
					alert("실패");
				}
			}
		})
	}

	//엑셀읽어와
	function readExcel() {
		let input = event.target;
		let reader = new FileReader();
		reader.onload = function () {
			let data = reader.result;
			let workBook = XLSX.read(data, { type: 'binary' });
			workBook.SheetNames.forEach(function (sheetName) {
				let rows = XLSX.utils.sheet_to_json(workBook.Sheets[sheetName]);
				console.log(rows);
				for(var i=0; i<rows.length; i++){
					if($("#product_company0").val() == "" && $("#product_name0").val() == "" && $("input[name='product_name']").length == 1 ){
						var row_max = 0;
						$("#product_company"+row_max).val(rows[i].product_company);
						$("#product_name"+row_max).val(rows[i].product_name);
						$("#product_type"+row_max).val(rows[i].product_type);
						$("#product_serial"+row_max).val(rows[i].product_serial);
						$("#product_item"+row_max).val(rows[i].product_item);
					}else{
						var row_max = Number(Number($("#row_max_index2").val()) + Number(1));
						productAdd();
						$("#product_company"+row_max).val(rows[i].product_company);
						$("#product_name"+row_max).val(rows[i].product_name);
						$("#product_type"+row_max).val(rows[i].product_type);
						$("#product_serial"+row_max).val(rows[i].product_serial);
						$("#product_item"+row_max).val(rows[i].product_item);
					}
				};
			})
		};
		reader.readAsBinaryString(input.files[0]);
	}
</script>
</body>
</html>

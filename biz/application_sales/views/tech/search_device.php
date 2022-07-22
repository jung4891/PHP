<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/customer_top.php";
?>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<style media="screen">
	.list_tbl td:not(.tbl-title) {
		height:20px;
	}
	.input-common {
		box-sizing: border-box;
	}
	.modify_row {
		background-color: rgb(236, 235, 165);
	}
</style>
<body>
	<form name="tb1">
		<input type="hidden" name="mode" value="<?php echo $_GET['mode']; ?>">
		<input type="hidden" name="name" value="<?php echo $_GET['name']; ?>">
		<div style="padding-left:10px;padding-right:10px;">
			<table width="100%" border="0" style="margin-top:20px;">
				<tr>
					<td class="title3">장비검색</td>
				</tr>
			</table>
			<table width="100%" class="list_tbl" border="0" cellspacing="0" cellpadding="0" style="margin-top:20px;">
				<colgroup>
					<col width="3%">
					<col width="12%">
					<col width="11%">
					<col width="11%">
					<col width="11%">
					<col width="12%">
					<col width="12%">
					<col width="12%">
					<col width="4%">
					<!-- <col width="4%"> -->
				</colgroup>
				<tr class="tbl-tr cell-tr border-t">
					<td class="tbl-title"><input type="checkbox" id="checkAll" name="checkAll" onChange="allCheck();"></td>
					<td class="tbl-title">장비/시스템명</td>
					<td class="tbl-title">host</td>
					<td class="tbl-title">하드웨어</td>
					<td class="tbl-title">제조사</td>
					<td class="tbl-title"><span style="color:red;">*</span>버전정보</td>
					<td class="tbl-title"><span style="color:red;">*</span>Serial</td>
					<td class="tbl-title"><span style="color:red;">*</span>라이선스</td>
					<td class="tbl-title"><span style="color:red;">*</span>이중화여부</td>
				</tr>
<?php foreach($input as $entry) { ?>
				<tr class="tbl-tr cell-tr">
					<td align="center">
						<input type="checkbox" name="check">
					</td>
					<td align="center">
						<input type="hidden" name="product_seq" value="<?php echo $entry['product_seq']; ?>">
						<input type="hidden" name="product_name" value="<?php echo $entry['product_name']; ?>">
						<?php echo $entry['product_name']; ?>
					</td>
					<td align="center">
						<input type="hidden" name="product_host" value="<?php echo $entry['product_host']; ?>">
						<?php echo $entry['product_host']; ?>
					</td>
					<td align="center">
						<input type="hidden" name="product_item" value="<?php echo $entry['product_item']; ?>">
						<?php echo $entry['product_item']; ?>
					</td>
					<td align="center">
						<input type="hidden" name="product_company" value="<?php echo $entry['product_company']; ?>">
						<?php echo $entry['product_company']; ?>
					</td>
					<td align="center">
						<input type="text" name="product_version" class="input-common require" value="<?php echo $entry['product_version']; ?>">
					</td>
					<td align="center">
						<input type="text" name="product_serial" class="input-common require" value="<?php echo $entry['product_serial']; ?>">
					</td>
					<td align="center">
		<?php if(strpos(strtolower($entry['product_name']), 'fortigate') !== false || strpos(strtolower($entry['product_name']), 'fg-') !== false) { ?>
						<input type="hidden" name="product_licence" value="<?php echo $entry['fortigate_licence']?>">
						<input type="text" name="fortigate_licence" class="fortigate_licence input-common require" value="<?php echo $entry['fortigate_licence']?>">
		<?php } else { ?>
						<input type="hidden" name="product_licence" value="<?php echo $entry['product_licence']; ?>">
						<?php echo $entry['product_licence']; ?>
		<?php } ?>
					</td>
					<td align="center">
						<input type="hidden" name="duplicate_yn" value="<?php echo $entry['duplicate_yn']; ?>">
						<input type="checkbox" class="duplicate_yn" <?php if($entry['duplicate_yn'] == 'Y'){echo 'checked';} ?> onclick="change_duplicate_yn(this);">
					</td>
				</tr>
<?php } ?>
				<tr>
					<td colspan="9" style="border:none;padding-top:20px;">
						<input type="button" class="btn-common btn-color2" style="width:60px;margin-right:10px;" value="저장" onclick="save_product_info();">
						<input type="button" name="check" class="btn-common btn-style2" value="선택" onclick="submitCharge();">
					</td>
				</tr>
			</table>
		</div>
	</form>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/js/select2.min.js"></script>
	<script>
	$(".product_company").select2();

	$('.input-common, .duplicate_yn').change(function() {
		var tr = $(this).closest('tr');
		tr.addClass('modify_row');
	})

	function change_duplicate_yn(el) {
		var duplicate_val = $(el).prev();
		if($(el).is(':checked')) {
			$(duplicate_val).val('Y');
		} else {
			$(duplicate_val).val('N');
		}
	}

		function save_product_info(el, product_seq) {
			var mode = $('input[name=mode]').val();
			var modify_row = $('.modify_row');
			if(modify_row.length == 0) {
				alert('수정된 행이 없습니다.');
				return false;
			} else {
				var result = 0;

				modify_row.each(function() {
					var tr = $(this);

					var product_seq       = tr.find('input[name=product_seq]').val();
					var product_version   = tr.find('input[name=product_version]').val();
					var product_serial    = tr.find('input[name=product_serial]').val();
					var fortigate_licence = tr.find('input[name=fortigate_licence]').val();
					var duplicate_yn    = tr.find('input[name=duplicate_yn]').val();
					if( duplicate_yn == '' ) {
						duplicate_yn = 'N';
					}

					$.ajax({
						type: "POST",
						cache: false,
						url: "<?php echo site_url(); ?>/tech/tech_board/save_product_info",
						dataType: "json",
						async: false,
						data: {
							mode: mode,
							product_seq: product_seq,
							product_version: product_version,
							product_serial: product_serial,
							fortigate_licence: fortigate_licence,
							duplicate_yn: duplicate_yn
						},
						success: function(data) {
							if(data) {
								result++;
							}
						}
					})
				})

				if(result == modify_row.length) {
					alert('저장되었습니다.');
					location.reload();
				}
			}
		}

		function allCheck() {
		  if (document.tb1.checkAll.checked) {
		    for (i = 0; i < document.getElementsByName('check').length - 1; i++) {
		      if (!document.getElementsByName('check')[i].checked) {
		        document.getElementsByName('check')[i].checked = true;
		      }
		    }
		  } else {
		    for (i = 0; i < document.getElementsByName('check').length - 1; i++) {
		      if (document.getElementsByName('check')[i].checked) {
		        document.getElementsByName('check')[i].checked = false;
		      }
		    }
		  }
		}

		$('.require').change(function() {
			if($(this).val() != '') {
				$(this).css('background-color', '#fff');
			}
		})

		function submitCharge() {

			var submit = true;
			var require = true;

			if($('.modify_row').length > 0) {
				if(!confirm('수정된 내역이 있습니다.\n저장하지 않고 제품을 선택하시겠습니까?')) {
					return submit = false;
				}
			}

			$('.require').each(function() {
				if($(this).val() == '') {
					$(this).css('background-color', 'rgba(222, 41, 74, 0.6)');
					require = false;
				}
			})

			if(!require) {
				if(confirm('필수 입력값이 입력되지 않았습니다.\n입력없이 제품 선택을 하시겠습니까?')) {
					select_product();
				} else {
					return false;
				}
			}

			if(submit && require) {
				select_product();
			}


			// select_product();
		}

		function select_product() {
			len = document.getElementsByName('check').length;
			total_dev_id = "";
			id_check = "_";
			total_dev_name = "";
			total_dev_hardware = "";
			total_dev_serial = "";
			total_dev_version = "";
			total_dev_license = "";
			total_dev_host = "";
			total_dev_seq = "";
			total_dev_manufacturer = "";
			total_dev_duplication_yn = "";
			name_check = ", ";

			var fortigate_licence = true;

			$('.fortigate_licence').each(function() {
				if($.trim($(this).val()) == '') {
					fortigate_licence = false;
				}
			})

			if(fortigate_licence || confirm('포티게이트 장비 중 라이선스가 입력 되지 않은 장비가 있습니다.\n라이선스 입력 없이 보고서 작성을 진행 하시겠습니까?')) {

				<?php if(!isset($_GET['type']) || $_GET['type'] != "add"){ ?>
					$(opener.document).find("#sortable").empty();
					var num = 1;
					for (i = 0; i < len - 1; i++) {
						if (document.getElementsByName('check')[i].checked) {
							total_dev_name += document.getElementsByName('product_name')[i].value + name_check;
							total_dev_hardware += document.getElementsByName('product_item')[i].value + name_check;
							total_dev_serial += document.getElementsByName('product_serial')[i].value + name_check;
							total_dev_version += document.getElementsByName('product_version')[i].value + name_check;
							total_dev_license += document.getElementsByName('product_licence')[i].value + name_check;
							total_dev_seq += document.getElementsByName('product_seq')[i].value + name_check;
							total_dev_manufacturer += document.getElementsByName('product_company')[i].value + name_check;
							total_dev_duplication_yn += document.getElementsByName('duplicate_yn')[i].value + name_check;
							total_dev_host += document.getElementsByName('product_host')[i].value + name_check;

							var sortable = '<li id="li'+ num +'"><span style="cursor:pointer;" id="produce' + num + '" class="click_produce" onclick = "clickProduce(' + num + ',' + document.getElementsByName('product_seq')[i].value + ')">';
							sortable += '<span class="produce_seq" style="display:none;">'+document.getElementsByName('product_seq')[i].value+'</span>';

							sortable += '<span class="produce">' + document.getElementsByName('product_name')[i].value + '</span>';
							sortable += '<span style="font-weight:bold;"> / </span><span class="manufacturer">' + document.getElementsByName('product_company')[i].value + '</span>';
							sortable += '<span style="font-weight:bold;"> / </span><span class="host">' + document.getElementsByName('product_host')[i].value + '</span>';
							sortable += '<span style="font-weight:bold;"> / </span><span class="version">'+ document.getElementsByName('product_version')[i].value + '</span>';
							sortable += '<span style="font-weight:bold;"> / </span><span class="hardware">' + document.getElementsByName('product_item')[i].value + '</span>';
							sortable += '<span style="font-weight:bold;"> / </span><span class="license">'+ document.getElementsByName('product_licence')[i].value + '</span>';
							sortable += '<span style="font-weight:bold;"> / </span><span class="serial">'+document.getElementsByName('product_serial')[i].value+'</span>';
							sortable += '<span style="font-weight:bold;"> / </span><span class="duplication_yn">'+document.getElementsByName('duplicate_yn')[i].value+'</span>';

							sortable += '</span>&nbsp;&nbsp;<input type="button" value="×" style="color:red;cursor:pointer;border:none;background-color:#FFEDED;" onclick="produceRemove('+num+')" /></li>';

							$(opener.document).find("#sortable").append(sortable);
							num++;
						}
					}
					alert("제품이 " + ((total_dev_name.split(',').length) - 1) + "개 선택 되었습니다.")

					opener.document.cform.productSeq.value = total_dev_seq.substr(0, (total_dev_seq.length - 2));
					opener.document.cform.produce.value = total_dev_name.substr(0, (total_dev_name.length - 2));
					opener.document.cform.hardware.value = total_dev_hardware.substr(0, (total_dev_hardware.length - 2));
					opener.document.cform.serial.value = total_dev_serial.substr(0, (total_dev_serial.length - 2));
					opener.document.cform.version.value = total_dev_version.substr(0, (total_dev_version.length - 2));
					opener.document.cform.license.value = total_dev_license.substr(0, (total_dev_license.length - 2));
					opener.document.cform.host.value = total_dev_host.substr(0, (total_dev_host.length - 2));
					opener.document.cform.manufacturer.value = total_dev_manufacturer.substr(0, (total_dev_manufacturer.length - 2));
					opener.document.cform.duplication_yn.value = total_dev_duplication_yn.substr(0, (total_dev_duplication_yn.length - 2));
					opener.document.cform.currentProduce.value = document.getElementsByName('product_seq')[0].value;
					opener.tableRemove();

					opener.createTable(((total_dev_name.split(',').length) - 1));

					var productSeq = total_dev_seq.substr(0, (total_dev_seq.length - 2)).split(',');
					for (i = 0; i < (total_dev_name.split(',').length) - 1; i++) {
						opener.template(productSeq[i], (i + 1));
					}
					opener.textareaSize();
					opener.serialInput();
					self.close();

				<?php }else{ ?>
					var num = 1;
					var max_table = 0;

					if(opener.document.cform.produce.value != ''){
						for(i=0; i<$(".work_text_table",opener.document).length; i++){
							if( max_table < Number($(".work_text_table",opener.document).eq(i).attr('id').replace("work_text_table",""))){
								max_table = Number($(".work_text_table",opener.document).eq(i).attr('id').replace("work_text_table",""));
							}
						}
					}

					var next_table = max_table+1;
					for (i = 0; i < len - 1; i++) {
						if (document.getElementsByName('check')[i].checked) {
							total_dev_name += document.getElementsByName('product_name')[i].value + name_check;
							total_dev_hardware += document.getElementsByName('product_item')[i].value + name_check;
							total_dev_serial += document.getElementsByName('product_serial')[i].value + name_check;
							total_dev_version += document.getElementsByName('product_version')[i].value + name_check;
							total_dev_license += document.getElementsByName('product_licence')[i].value + name_check;
							total_dev_seq += document.getElementsByName('product_seq')[i].value + name_check;
							total_dev_manufacturer += document.getElementsByName('product_company')[i].value + name_check;
							total_dev_duplication_yn += document.getElementsByName('duplicate_yn')[i].value + name_check;
							total_dev_host += document.getElementsByName('product_host')[i].value + name_check;

							var sortable = '<li id="li'+ next_table +'"><span style="cursor:pointer;" id="produce' + next_table + '" class="click_produce" onclick = "clickProduce(' + next_table + ',' + document.getElementsByName('product_seq')[i].value + ')">';
							sortable += '<span class="produce_seq" style="display:none;">'+document.getElementsByName('product_seq')[i].value+'</span>';

							sortable += '<span class="produce">' + document.getElementsByName('product_name')[i].value + '</span>';
							sortable += '<span style="font-weight:bold;"> / </span><span class="manufacturer">' + document.getElementsByName('product_company')[i].value + '</span>';
							sortable += '<span style="font-weight:bold;"> / </span><span class="host">' + document.getElementsByName('product_host')[i].value + '</span>';
							sortable += '<span style="font-weight:bold;"> / </span><span class="version">'+ document.getElementsByName('product_version')[i].value + '</span>';
							sortable += '<span style="font-weight:bold;"> / </span><span class="hardware">' + document.getElementsByName('product_item')[i].value + '</span>';
							sortable += '<span style="font-weight:bold;"> / </span><span class="license">'+ document.getElementsByName('product_licence')[i].value + '</span>';
							sortable += '<span style="font-weight:bold;"> / </span><span class="serial">'+document.getElementsByName('product_serial')[i].value+'</span>';
							sortable += '<span style="font-weight:bold;"> / </span><span class="duplication_yn">'+document.getElementsByName('duplicate_yn')[i].value+'</span>';

							sortable += '</span>&nbsp;&nbsp;<input type="button" value="×" style="color:red;cursor:pointer;border:none;background-color:#FFEDED;" onclick="produceRemove('+next_table+')" /></li>';

							$(opener.document).find("#sortable").append(sortable);
							next_table++;
						}
					}

					alert("제품이 " + ((total_dev_name.split(',').length) - 1) + "개 추가 선택 되었습니다.")

					opener.document.cform.productSeq.value += name_check + total_dev_seq.substr(0, (total_dev_seq.length - 2));
					opener.document.cform.produce.value += name_check + total_dev_name.substr(0, (total_dev_name.length - 2));
					opener.document.cform.hardware.value += name_check + total_dev_hardware.substr(0, (total_dev_hardware.length - 2));
					opener.document.cform.serial.value += name_check + total_dev_serial.substr(0, (total_dev_serial.length - 2));
					opener.document.cform.version.value += name_check + total_dev_version.substr(0, (total_dev_version.length - 2));
					opener.document.cform.license.value += name_check + total_dev_license.substr(0, (total_dev_license.length - 2));
					opener.document.cform.host.value += name_check + total_dev_host.substr(0, (total_dev_host.length - 2));
					opener.document.cform.manufacturer.value += name_check + total_dev_manufacturer.substr(0, (total_dev_manufacturer.length - 2));
					opener.document.cform.duplication_yn.value += name_check + total_dev_duplication_yn.substr(0, (total_dev_duplication_yn.length - 2));


					opener.createTable(((total_dev_name.split(',').length) - 1),max_table);

					var productSeq = total_dev_seq.substr(0, (total_dev_seq.length - 2)).split(',');
					for (i = 0; i < (total_dev_name.split(',').length) - 1; i++) {
						opener.template(productSeq[i],(max_table+1)+i);
					}
					opener.textareaSize();
					opener.serialInput();
					self.close();

				<?php } ?>

			} else {
				window.history.back();
			}
		}
	</script>
</body>
